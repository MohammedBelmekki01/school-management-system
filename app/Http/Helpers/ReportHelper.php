<?php

namespace App\Http\Helpers;

/**
 * ReportHelper
 *
 * Helper class for generating HTML report components,
 * formatting report data, and building attendance
 * summary tables.
 *
 * @author Mohammed Belmekki
 */
class ReportHelper
{
    /**
     * Replace space characters in a string.
     *
     * @param  string $string
     * @param  string $search
     * @param  string $replace
     * @return string
     */
    public static function replaceSpaceCharInString($string, $search, $replace)
    {
        return str_replace($search, $replace, $string);
    }

    /**
     * Generate summary table rows for student monthly attendance.
     *
     * @param  array|null $dateWisePresent
     * @param  array|null $dateWiseAbsent
     * @return string HTML table rows
     */
    public static function generateStudentMonthlyAttendanceSumTableRows(?array $dateWisePresent, ?array $dateWiseAbsent)
    {
        $row1 = '<tr><td colspan="4" style="text-align: left;">T.P</td>';
        $row2 = '<tr><td colspan="4" style="text-align: left;">T.A</td>';

        foreach ($dateWisePresent as $date => $total) {
            $row1 .= "<td>{$total}</td>";
            $row2 .= "<td>{$dateWiseAbsent[$date]}</td>";
        }

        $row1 .= '<td rowspan="2" colspan="4"></td>';
        $row1 .= "</tr>";
        $row2 .= "</tr>";
        return $row1 . $row2;
    }

    /**
     * Generate summary table rows for employee monthly attendance.
     *
     * @param  array|null $dateWisePresent
     * @param  array|null $dateWiseAbsent
     * @return string HTML table rows
     */
    public static function generateEmployeeMonthlyAttendanceSumTableRows(?array $dateWisePresent, ?array $dateWiseAbsent)
    {
        $row1 = '<tr><td colspan="2" style="text-align: left;">T.P</td>';
        $row2 = '<tr><td colspan="2" style="text-align: left;">T.A</td>';

        foreach ($dateWisePresent as $date => $total) {
            $row1 .= "<td>{$total}</td>";
            $row2 .= "<td>{$dateWiseAbsent[$date]}</td>";
        }

        $row1 .= '<td rowspan="2" colspan="3"></td>';
        $row1 .= "</tr>";
        $row2 .= "</tr>";
        return $row1 . $row2;
    }

    /**
     * Calculate attendance percentage for a student or employee.
     *
     * @param  int $totalPresent
     * @param  int $totalDays
     * @return float Percentage rounded to 2 decimal places
     */
    public static function calculateAttendancePercentage($totalPresent, $totalDays)
    {
        if ($totalDays <= 0) {
            return 0.0;
        }

        return round(($totalPresent / $totalDays) * 100, 2);
    }

    /**
     * Get the attendance status label with CSS class.
     *
     * @param  float $percentage
     * @return array ['label' => string, 'class' => string]
     */
    public static function getAttendanceStatus($percentage)
    {
        if ($percentage >= 90) {
            return ['label' => 'Excellent', 'class' => 'text-success'];
        } elseif ($percentage >= 75) {
            return ['label' => 'Good', 'class' => 'text-info'];
        } elseif ($percentage >= 60) {
            return ['label' => 'Average', 'class' => 'text-warning'];
        } else {
            return ['label' => 'Poor', 'class' => 'text-danger'];
        }
    }

    /**
     * Format marks for display with grade info.
     *
     * @param  float  $marks
     * @param  float  $totalMarks
     * @param  string $grade
     * @return string
     */
    public static function formatMarksDisplay($marks, $totalMarks, $grade)
    {
        $percentage = $totalMarks > 0 ? round(($marks / $totalMarks) * 100, 1) : 0;
        return "{$marks}/{$totalMarks} ({$percentage}%) - Grade: {$grade}";
    }

    /**
     * Generate a CSV-safe string from report data.
     *
     * @param  string $value
     * @return string
     */
    public static function sanitizeForCsv($value)
    {
        // Prevent CSV injection attacks
        $dangerousChars = ['=', '+', '-', '@', "\t", "\r"];
        if (in_array(substr($value, 0, 1), $dangerousChars)) {
            $value = "'" . $value;
        }

        return $value;
    }
}
