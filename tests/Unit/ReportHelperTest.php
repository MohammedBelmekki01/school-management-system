<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Helpers\ReportHelper;

/**
 * Unit tests for the ReportHelper class.
 *
 * @author Mohammed Belmekki
 */
class ReportHelperTest extends TestCase
{
    /**
     * Test attendance percentage calculation.
     *
     * @return void
     */
    public function testCalculateAttendancePercentage()
    {
        $this->assertEquals(80.0, ReportHelper::calculateAttendancePercentage(20, 25));
        $this->assertEquals(100.0, ReportHelper::calculateAttendancePercentage(30, 30));
        $this->assertEquals(0.0, ReportHelper::calculateAttendancePercentage(0, 30));
        $this->assertEquals(0.0, ReportHelper::calculateAttendancePercentage(0, 0));
    }

    /**
     * Test attendance status labels.
     *
     * @return void
     */
    public function testGetAttendanceStatus()
    {
        $excellent = ReportHelper::getAttendanceStatus(95);
        $this->assertEquals('Excellent', $excellent['label']);
        $this->assertEquals('text-success', $excellent['class']);

        $good = ReportHelper::getAttendanceStatus(80);
        $this->assertEquals('Good', $good['label']);

        $average = ReportHelper::getAttendanceStatus(65);
        $this->assertEquals('Average', $average['label']);

        $poor = ReportHelper::getAttendanceStatus(40);
        $this->assertEquals('Poor', $poor['label']);
        $this->assertEquals('text-danger', $poor['class']);
    }

    /**
     * Test marks display formatting.
     *
     * @return void
     */
    public function testFormatMarksDisplay()
    {
        $display = ReportHelper::formatMarksDisplay(85, 100, 'A+');
        $this->assertEquals('85/100 (85%) - Grade: A+', $display);

        $display = ReportHelper::formatMarksDisplay(0, 0, 'F');
        $this->assertEquals('0/0 (0%) - Grade: F', $display);
    }

    /**
     * Test CSV sanitization prevents injection.
     *
     * @return void
     */
    public function testSanitizeForCsv()
    {
        $this->assertEquals("'=cmd", ReportHelper::sanitizeForCsv('=cmd'));
        $this->assertEquals("'+alert()", ReportHelper::sanitizeForCsv('+alert()'));
        $this->assertEquals("'-1+1", ReportHelper::sanitizeForCsv('-1+1'));
        $this->assertEquals("'@import", ReportHelper::sanitizeForCsv('@import'));
        $this->assertEquals('Normal text', ReportHelper::sanitizeForCsv('Normal text'));
    }

    /**
     * Test space replacement in strings.
     *
     * @return void
     */
    public function testReplaceSpaceCharInString()
    {
        $this->assertEquals('Hello_World', ReportHelper::replaceSpaceCharInString('Hello World', ' ', '_'));
        $this->assertEquals('NoChange', ReportHelper::replaceSpaceCharInString('NoChange', ' ', '_'));
    }

    /**
     * Test student attendance summary table row generation.
     *
     * @return void
     */
    public function testGenerateStudentMonthlyAttendanceSumTableRows()
    {
        $present = ['2024-03-01' => 25, '2024-03-02' => 24];
        $absent = ['2024-03-01' => 5, '2024-03-02' => 6];

        $html = ReportHelper::generateStudentMonthlyAttendanceSumTableRows($present, $absent);

        $this->assertStringContainsString('T.P', $html);
        $this->assertStringContainsString('T.A', $html);
        $this->assertStringContainsString('25', $html);
        $this->assertStringContainsString('5', $html);
        $this->assertStringContainsString('<tr>', $html);
    }

    /**
     * Test employee attendance summary table row generation.
     *
     * @return void
     */
    public function testGenerateEmployeeMonthlyAttendanceSumTableRows()
    {
        $present = ['2024-03-01' => 10, '2024-03-02' => 9];
        $absent = ['2024-03-01' => 2, '2024-03-02' => 3];

        $html = ReportHelper::generateEmployeeMonthlyAttendanceSumTableRows($present, $absent);

        $this->assertStringContainsString('T.P', $html);
        $this->assertStringContainsString('T.A', $html);
        $this->assertStringContainsString('10', $html);
        $this->assertStringContainsString('2', $html);
    }
}
