<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'provider',
        'address1',
        'address2',
        'city',
        'state',
        'zip',
        'phone',
        'hours',
        'lat',
        'lng',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'lat' => 'decimal:8',
        'lng' => 'decimal:8',
    ];

    /**
     * Get clean formatted hours broken down by line for UI badges and cards
     */
    public function getFormattedHoursLinesAttribute(): array
    {
        $raw = $this->hours;
        if (empty($raw)) {
            return ['Mon–Fri: 8:00 AM – 5:00 PM'];
        }

        // Quest pipe format: e.g. "M-F 6:30 AM-3:00 PM|Sa 8:00 AM-11:30 AM"
        if (str_contains($raw, '|')) {
            $segments = explode('|', $raw);
            $result = [];
            foreach ($segments as $s) {
                $s = trim($s);
                $s = preg_replace('/^Sa\b/i', 'Sat:', $s);
                $s = preg_replace('/^M-F\b/i', 'Mon–Fri:', $s);
                $s = preg_replace('/^M-Th\b/i', 'Mon–Thu:', $s);
                $s = preg_replace('/^F\b/i', 'Fri:', $s);
                $s = preg_replace('/^Su\b/i', 'Sun:', $s);
                $s = preg_replace('/(\d(?:AM|PM))-(\d)/i', '$1 – $2', $s);
                $result[] = $s;
            }
            return $result;
        }

        // LabCorp semicolon format: e.g. "Sunday: Closed; Monday: 06:00 am - 02:00 pm; ..."
        if (str_contains($raw, ';')) {
            $parts = array_filter(array_map('trim', explode(';', $raw)));
            $schedule = [];
            foreach ($parts as $p) {
                if (str_contains($p, ':')) {
                    [$d, $h] = explode(':', $p, 2);
                    $d = ucfirst(strtolower(trim($d)));
                    $hClean = trim($h);
                    if (stripos($hClean, 'Lunch') !== false) {
                        $hClean = preg_replace('/\s*Lunch:.*$/i', '', $hClean);
                    }
                    $hClean = preg_replace('/\b0([1-9]:)/', '$1', $hClean);
                    $hClean = preg_replace_callback('/\b(am|pm)\b/i', fn($m) => strtoupper($m[1]), $hClean);
                    $hClean = str_replace('-', '–', $hClean);
                    $schedule[$d] = trim($hClean);
                }
            }

            $weekdays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
            $weekdayHours = [];
            foreach ($weekdays as $w) {
                if (isset($schedule[$w])) {
                    $weekdayHours[$w] = $schedule[$w];
                }
            }

            $unique = array_unique($weekdayHours);
            $result = [];
            if (count($unique) === 1) {
                $result[] = 'Mon–Fri: ' . reset($unique);
            } elseif (count($unique) === 2 && isset($weekdayHours['Friday'])) {
                $monThu = array_slice($weekdayHours, 0, 4);
                if (count(array_unique($monThu)) === 1) {
                    $result[] = 'Mon–Thu: ' . reset($monThu);
                    $result[] = 'Fri: ' . $weekdayHours['Friday'];
                } else {
                    $result[] = 'Mon–Fri: ' . reset($unique);
                }
            } else {
                $result[] = 'Mon–Fri: ' . (reset($unique) ?: '8:00 AM – 5:00 PM');
            }

            $sat = $schedule['Saturday'] ?? null;
            if ($sat && stripos($sat, 'closed') === false) {
                $result[] = 'Sat: ' . $sat;
            }
            return $result;
        }

        $clean = trim($raw);
        $clean = preg_replace('/\b0([1-9]:)/', '$1', $clean);
        $clean = preg_replace_callback('/\b(am|pm)\b/i', fn($m) => strtoupper($m[1]), $clean);
        $clean = str_replace('-', '–', $clean);
        return [$clean];
    }

    /**
     * Get single-line hours summary string
     */
    public function getFormattedHoursAttribute(): string
    {
        return implode(' • ', $this->formatted_hours_lines);
    }
}
