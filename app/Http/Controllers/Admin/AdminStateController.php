<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\State;
use Illuminate\Http\Request;

class AdminStateController extends Controller
{
    /**
     * List all states with search, center counts, and quick management links
     */
    public function index(Request $request)
    {
        $query = State::withCount(['cities']);

        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('abbr', 'LIKE', "%{$search}%")
                  ->orWhere('slug', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->input('status') === 'active');
        }

        $states = $query->orderBy('name')->paginate(25)->withQueryString();

        // Calculate location counts per state abbreviation
        $stateAbbrs = $states->pluck('abbr')->filter()->all();
        $locationCounts = Location::whereIn('state', $stateAbbrs)
            ->where('is_active', true)
            ->selectRaw('state, count(*) as count')
            ->groupBy('state')
            ->pluck('count', 'state')
            ->all();

        return view('admin.states.index', compact('states', 'locationCounts'));
    }

    /**
     * Show edit form for a state's landing page content, compliance, and SEO
     */
    public function edit(State $state)
    {
        $state->loadCount('cities');
        $locationCount = Location::where('state', $state->abbr)->where('is_active', true)->count();

        // Load raw FAQs if present, or parsed array
        $rawFaqs = $state->getRawOriginal('faqs_json');
        if (!empty($rawFaqs)) {
            $faqs = is_string($rawFaqs) ? json_decode($rawFaqs, true) : $rawFaqs;
        } else {
            $faqs = $state->faqs_json ?? [];
        }

        return view('admin.states.edit', compact('state', 'locationCount', 'faqs'));
    }

    /**
     * Update state content, workplace laws, and SEO metadata
     */
    public function update(Request $request, State $state)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'abbr' => 'required|string|size:2',
            'is_active' => 'nullable|boolean',

            // SEO Metadata
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:1000',

            // Overview Content
            'content' => 'nullable|string',

            // Workplace Compliance & Legal
            'statute_code' => 'nullable|string|max:150',
            'medical_marijuana_status' => 'nullable|string|max:150',
            'recreational_marijuana_status' => 'nullable|string|max:150',
            'employer_rights_summary' => 'nullable|string',
            'worker_comp_rules' => 'nullable|string',

            // FAQs
            'faqs' => 'nullable|array',
            'faqs.*.question' => 'nullable|string|max:500',
            'faqs.*.answer' => 'nullable|string',
        ]);

        $state->name = $validated['name'];
        $state->abbr = strtoupper($validated['abbr']);
        $state->is_active = $request->has('is_active');
        $state->meta_title = $validated['meta_title'] ?? null;
        $state->meta_description = $validated['meta_description'] ?? null;
        $state->content = $validated['content'] ?? null;
        $state->statute_code = $validated['statute_code'] ?? null;
        $state->medical_marijuana_status = $validated['medical_marijuana_status'] ?? null;
        $state->recreational_marijuana_status = $validated['recreational_marijuana_status'] ?? null;
        $state->employer_rights_summary = $validated['employer_rights_summary'] ?? null;
        $state->worker_comp_rules = $validated['worker_comp_rules'] ?? null;

        if ($request->has('faqs')) {
            $cleanedFaqs = [];
            foreach ($request->input('faqs', []) as $faq) {
                if (!empty(trim($faq['question'] ?? '')) && !empty(trim($faq['answer'] ?? ''))) {
                    $cleanedFaqs[] = [
                        'question' => trim($faq['question']),
                        'answer' => trim($faq['answer']),
                    ];
                }
            }
            $state->faqs_json = $cleanedFaqs;
        }

        $state->save();

        return redirect()->route('admin.states.index')->with('success', "State page for '{$state->name}' updated successfully.");
    }
}

