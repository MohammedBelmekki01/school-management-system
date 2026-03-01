<?php

namespace App\Http\Helpers;

use Carbon\Carbon;

/**
 * DateHelper
 *
 * Utility class for date-related operations used across
 * the school management system: academic year calculations,
 * age computation, date formatting, and period checks.
 *
 * @author Mohammed Belmekki
 */
class DateHelper
{
    /**
     * Calculate age from date of birth.
     *
     * @param  string|Carbon $dob
     * @return int
     */
    public static function calculateAge($dob)
    {
        if (is_string($dob)) {
            try {
                $dob = Carbon::parse($dob);
            } catch (\Exception $e) {
                return 0;
            }
        }

        return $dob->age;
    }

    /**
     * Format a date to a human-readable format.
     *
     * @param  string|Carbon $date
     * @param  string        $format
     * @return string
     */
    public static function formatDate($date, $format = 'd M, Y')
    {
        if (empty($date)) {
            return 'N/A';
        }

        if (is_string($date)) {
            try {
                $date = Carbon::parse($date);
            } catch (\Exception $e) {
                return 'Invalid date';
            }
        }

        return $date->format($format);
    }

    /**
     * Get the academic year string (e.g., "2025-2026").
     *
     * @param  int|null $startYear
     * @return string
     */
    public static function getAcademicYearString($startYear = null)
    {
        if (!$startYear) {
            $startYear = Carbon::now()->year;
        }

        return $startYear . '-' . ($startYear + 1);
    }

    /**
     * Check if a given date falls within the current academic year.
     *
     * @param  string|Carbon $date
     * @param  int           $academicStartMonth  Month number (1-12) when academic year starts
     * @return bool
     */
    public static function isInCurrentAcademicYear($date, $academicStartMonth = 1)
    {
        if (is_string($date)) {
            $date = Carbon::parse($date);
        }

        $now = Carbon::now();
        $currentYear = $now->year;

        if ($now->month >= $academicStartMonth) {
            $startDate = Carbon::create($currentYear, $academicStartMonth, 1);
            $endDate = Carbon::create($currentYear + 1, $academicStartMonth, 1)->subDay();
        } else {
            $startDate = Carbon::create($currentYear - 1, $academicStartMonth, 1);
            $endDate = Carbon::create($currentYear, $academicStartMonth, 1)->subDay();
        }

        return $date->between($startDate, $endDate);
    }

    /**
     * Get the number of working days between two dates (excluding weekends).
     *
     * @param  Carbon $startDate
     * @param  Carbon $endDate
     * @param  array  $weekendDays  Array of day numbers (0=Sun, 6=Sat)
     * @return int
     */
    public static function getWorkingDays(Carbon $startDate, Carbon $endDate, array $weekendDays = [5, 6])
    {
        $workingDays = 0;

        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            if (!in_array($date->dayOfWeek, $weekendDays)) {
                $workingDays++;
            }
        }

        return $workingDays;
    }

    /**
     * Get a human-readable time difference (e.g., "2 hours ago", "3 days ago").
     *
     * @param  string|Carbon $date
     * @return string
     */
    public static function timeAgo($date)
    {
        if (is_string($date)) {
            try {
                $date = Carbon::parse($date);
            } catch (\Exception $e) {
                return 'Unknown';
            }
        }

        return $date->diffForHumans();
    }

    /**
     * Check if a given date is today.
     *
     * @param  string|Carbon $date
     * @return bool
     */
    public static function isToday($date)
    {
        if (is_string($date)) {
            $date = Carbon::parse($date);
        }

        return $date->isToday();
    }

    /**
     * Get the list of months as an associative array.
     *
     * @return array
     */
    public static function getMonthsList()
    {
        return [
            1  => 'January',
            2  => 'February',
            3  => 'March',
            4  => 'April',
            5  => 'May',
            6  => 'June',
            7  => 'July',
            8  => 'August',
            9  => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December',
        ];
    }

    /**
     * Get the start and end dates for a given month and year.
     *
     * @param  int $month
     * @param  int $year
     * @return array ['start' => Carbon, 'end' => Carbon]
     */
    public static function getMonthBounds($month, $year)
    {
        $start = Carbon::create($year, $month, 1)->startOfDay();
        $end = $start->copy()->endOfMonth()->endOfDay();

        return [
            'start' => $start,
            'end'   => $end,
        ];
    }
}
