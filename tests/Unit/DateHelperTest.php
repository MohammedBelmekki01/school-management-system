<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Helpers\DateHelper;
use Carbon\Carbon;

/**
 * Unit tests for the DateHelper class.
 *
 * @author Mohammed Belmekki
 */
class DateHelperTest extends TestCase
{
    /**
     * Test age calculation from date of birth.
     *
     * @return void
     */
    public function testCalculateAge()
    {
        // A person born 20 years ago
        $dob = Carbon::now()->subYears(20)->format('Y-m-d');
        $this->assertEquals(20, DateHelper::calculateAge($dob));
    }

    /**
     * Test age calculation with invalid date returns 0.
     *
     * @return void
     */
    public function testCalculateAgeWithInvalidDate()
    {
        $this->assertEquals(0, DateHelper::calculateAge('not-a-date'));
    }

    /**
     * Test date formatting.
     *
     * @return void
     */
    public function testFormatDate()
    {
        $this->assertEquals('15 Mar, 2024', DateHelper::formatDate('2024-03-15'));
        $this->assertEquals('N/A', DateHelper::formatDate(null));
        $this->assertEquals('N/A', DateHelper::formatDate(''));
    }

    /**
     * Test custom date format.
     *
     * @return void
     */
    public function testFormatDateCustomFormat()
    {
        $this->assertEquals('2024-03-15', DateHelper::formatDate('2024-03-15', 'Y-m-d'));
    }

    /**
     * Test academic year string generation.
     *
     * @return void
     */
    public function testGetAcademicYearString()
    {
        $this->assertEquals('2025-2026', DateHelper::getAcademicYearString(2025));
        $this->assertEquals('2024-2025', DateHelper::getAcademicYearString(2024));
    }

    /**
     * Test working days calculation.
     *
     * @return void
     */
    public function testGetWorkingDays()
    {
        // A full week (Mon to Sun) with Fri+Sat weekend = 5 working days
        $start = Carbon::parse('2024-03-11'); // Monday
        $end = Carbon::parse('2024-03-17');   // Sunday

        $days = DateHelper::getWorkingDays($start, $end, [5, 6]); // Fri=5, Sat=6
        $this->assertEquals(5, $days);
    }

    /**
     * Test isToday method.
     *
     * @return void
     */
    public function testIsToday()
    {
        $this->assertTrue(DateHelper::isToday(Carbon::now()));
        $this->assertFalse(DateHelper::isToday(Carbon::yesterday()));
    }

    /**
     * Test months list.
     *
     * @return void
     */
    public function testGetMonthsList()
    {
        $months = DateHelper::getMonthsList();

        $this->assertCount(12, $months);
        $this->assertEquals('January', $months[1]);
        $this->assertEquals('December', $months[12]);
    }

    /**
     * Test month bounds calculation.
     *
     * @return void
     */
    public function testGetMonthBounds()
    {
        $bounds = DateHelper::getMonthBounds(2, 2024); // February 2024 (leap year)

        $this->assertEquals('2024-02-01', $bounds['start']->format('Y-m-d'));
        $this->assertEquals('2024-02-29', $bounds['end']->format('Y-m-d'));
    }

    /**
     * Test timeAgo returns a human-readable string.
     *
     * @return void
     */
    public function testTimeAgo()
    {
        $result = DateHelper::timeAgo(Carbon::now()->subHours(2));
        $this->assertStringContainsString('ago', $result);
    }
}
