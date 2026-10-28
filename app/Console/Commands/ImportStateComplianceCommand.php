<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\State;

class ImportStateComplianceCommand extends Command
{
    protected $signature = 'app:import-state-compliance';
    protected $description = 'Import state compliance laws and legal FAQs from accrediteddrugte_s2 into cdtc.states and export JSON for zero-dependency deployment';

    public function handle(): int
    {
        $this->info('Starting state compliance laws and FAQs migration...');

        // Fetch compliance laws
        $laws = DB::select("SELECT * FROM accrediteddrugte_s2.state_compliance_laws");
        $lawsMap = [];
        foreach ($laws as $l) {
            $lawsMap[strtoupper(trim($l->state_abbr))] = $l;
        }

        // Fetch state FAQs
        $faqs = DB::select("SELECT * FROM accrediteddrugte_s2.state_faqs ORDER BY state_code, display_order ASC");
        $faqsMap = [];
        foreach ($faqs as $f) {
            $abbr = strtoupper(trim($f->state_code));
            if (!isset($faqsMap[$abbr])) {
                $faqsMap[$abbr] = [];
            }
            $faqsMap[$abbr][] = [
                'question' => trim($f->question),
                'answer' => str_replace(
                    ['Accredited Drug Testing', 'accrediteddrugtesting.com', 'ADT'],
                    ['Certified Drug Test Center', 'certifieddrugtestcenter.com', 'CDTC'],
                    trim($f->answer)
                ),
            ];
        }

        $states = State::all();
        $exportData = [];
        $updatedCount = 0;

        foreach ($states as $state) {
            $abbr = strtoupper(trim($state->abbr));
            $law = $lawsMap[$abbr] ?? null;
            $stateFaqs = $faqsMap[$abbr] ?? [];

            $statuteCode = $law ? $law->statute_code : null;
            $medMarijuana = $law ? $law->medical_marijuana_status : 'Subject to State Law';
            $recMarijuana = $law ? $law->recreational_marijuana_status : 'Subject to State Law';
            $employerRights = $law ? str_replace(['Accredited Drug Testing', 'ADT'], ['Certified Drug Test Center', 'CDTC'], $law->employer_rights_summary) : null;
            $workerComp = $law ? str_replace(['Accredited Drug Testing', 'ADT'], ['Certified Drug Test Center', 'CDTC'], $law->worker_comp_rules) : null;

            $state->update([
                'statute_code' => $statuteCode,
                'medical_marijuana_status' => $medMarijuana,
                'recreational_marijuana_status' => $recMarijuana,
                'employer_rights_summary' => $employerRights,
                'worker_comp_rules' => $workerComp,
                'faqs_json' => !empty($stateFaqs) ? $stateFaqs : null,
            ]);

            $updatedCount++;

            $exportData[] = [
                'abbr' => $abbr,
                'name' => $state->name,
                'slug' => $state->slug,
                'statute_code' => $statuteCode,
                'medical_marijuana_status' => $medMarijuana,
                'recreational_marijuana_status' => $recMarijuana,
                'employer_rights_summary' => $employerRights,
                'worker_comp_rules' => $workerComp,
                'faqs_json' => $stateFaqs,
            ];
        }

        $this->info("Successfully updated compliance laws and FAQs for {$updatedCount} states.");

        // Export JSON snapshot for zero-dependency live deployments
        $dataPath = database_path('seeders/data');
        if (!is_dir($dataPath)) {
            mkdir($dataPath, 0755, true);
        }

        file_put_contents($dataPath . '/states_compliance.json', json_encode($exportData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        $this->info("Exported JSON snapshot to database/seeders/data/states_compliance.json (" . count($exportData) . " states)");

        return Command::SUCCESS;
    }
}
