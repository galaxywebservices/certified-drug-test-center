<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class State extends Model
{
    use HasFactory;

    protected $fillable = [
        'abbr',
        'name',
        'slug',
        'is_active',
        'content',
        'statute_code',
        'medical_marijuana_status',
        'recreational_marijuana_status',
        'employer_rights_summary',
        'worker_comp_rules',
        'faqs_json',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'faqs_json' => 'array',
    ];

    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }

    /**
     * Dynamically interpolate placeholders (e.g. {{Active_Lab_Count}}, {{City_Name}}, {{State_Abbr}})
     * and ensure consistent brand naming.
     */
    public function getFaqsJsonAttribute($value): array
    {
        if (empty($value)) {
            return [];
        }

        $faqs = is_string($value) ? json_decode($value, true) : $value;
        if (!is_array($faqs)) {
            return [];
        }

        $abbr = strtoupper($this->abbr ?? '');
        $labCount = Location::where('state', $abbr)
            ->where('is_active', true)
            ->count();

        $countFormatted = $labCount > 0 ? number_format($labCount) : 'multiple';
        $stateName = $this->name ?? $abbr;

        return array_map(function ($faq) use ($stateName, $abbr, $countFormatted) {
            if (!is_array($faq)) {
                return $faq;
            }

            $question = $faq['question'] ?? '';
            $answer = $faq['answer'] ?? '';

            $replacements = [
                'Accredited Drug Testing' => 'Certified Drug Test Centers',
                'ADT' => 'CDTC',
                '{{City_Name}}, {{State_Abbr}}' => "{$stateName} ({$abbr})",
                '{{City_Name}}' => $stateName,
                '{{State_Abbr}}' => $abbr,
                '{{State_Name}}' => $stateName,
                '{{Active_Lab_Count}}' => $countFormatted,
            ];

            $question = str_replace(array_keys($replacements), array_values($replacements), $question);
            $answer = str_replace(array_keys($replacements), array_values($replacements), $answer);

            // Clean up phrasing like "in the Arizona area" -> "across Arizona"
            $answer = str_replace("in the {$stateName} area", "across {$stateName}", $answer);

            return [
                'question' => $question,
                'answer' => $answer,
            ];
        }, $faqs);
    }
}
