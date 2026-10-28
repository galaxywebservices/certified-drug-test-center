<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\State;
use App\Models\City;
use Illuminate\Http\Request;

class AdminLocationController extends Controller
{
    /**
     * List all 7,382+ certified collection facilities
     */
    public function index(Request $request)
    {
        $query = Location::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('city', 'LIKE', "%{$search}%")
                  ->orWhere('zip', 'LIKE', "%{$search}%")
                  ->orWhere('address1', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('state')) {
            $query->where('state', strtoupper($request->input('state')));
        }

        if ($request->filled('provider')) {
            $query->where('provider', $request->input('provider'));
        }

        $locations = $query->orderBy('state')->orderBy('city')->paginate(25)->withQueryString();
        $states = State::orderBy('name')->get();

        return view('admin.locations.index', compact('locations', 'states'));
    }

    /**
     * Edit individual collection facility
     */
    public function edit(Location $location)
    {
        $states = State::orderBy('name')->get();
        return view('admin.locations.edit', compact('location', 'states'));
    }

    /**
     * Update collection facility
     */
    public function update(Request $request, Location $location)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'provider' => 'required|string|max:50',
            'address1' => 'required|string|max:255',
            'address2' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:10',
            'zip' => 'required|string|max:20',
            'phone' => 'nullable|string|max:50',
            'hours' => 'nullable|string|max:500',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $location->update($validated);

        return redirect()->route('admin.locations.index')->with('success', "Location '{$location->name}' updated successfully.");
    }

    /**
     * List programmatic SEO city landing pages
     */
    public function cities(Request $request)
    {
        $query = City::with('state');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('slug', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('state_id')) {
            $query->where('state_id', $request->input('state_id'));
        }

        $cities = $query->orderBy('name')->paginate(30)->withQueryString();
        $states = State::orderBy('name')->get();

        return view('admin.locations.cities', compact('cities', 'states'));
    }

    /**
     * Edit city content & SEO
     */
    public function editCity(City $city)
    {
        $city->load('state');
        return view('admin.locations.edit-city', compact('city'));
    }

    /**
     * Update city content & SEO
     */
    public function updateCity(Request $request, City $city)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'content' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $city->update($validated);

        return redirect()->route('admin.cities.index')->with('success', "City '{$city->name}, {$city->state->abbr}' updated successfully.");
    }
}
