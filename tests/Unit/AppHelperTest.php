<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Helpers\AppHelper;

/**
 * Unit tests for the AppHelper class.
 *
 * Validates constants integrity, helper methods,
 * and utility functions used throughout the application.
 *
 * @author Mohammed Belmekki
 */
class AppHelperTest extends TestCase
{
    /**
     * Test that user role constants are correctly defined.
     *
     * @return void
     */
    public function testUserRoleConstants()
    {
        $this->assertEquals(1, AppHelper::USER_ADMIN);
        $this->assertEquals(2, AppHelper::USER_TEACHER);
        $this->assertEquals(3, AppHelper::USER_STUDENT);
        $this->assertEquals(4, AppHelper::USER_PARENTS);
        $this->assertEquals(5, AppHelper::USER_ACCOUNTANT);
        $this->assertEquals(6, AppHelper::USER_LIBRARIAN);
        $this->assertEquals(7, AppHelper::USER_RECEPTIONIST);
    }

    /**
     * Test active and inactive status constants.
     *
     * @return void
     */
    public function testStatusConstants()
    {
        $this->assertEquals('1', AppHelper::ACTIVE);
        $this->assertEquals('0', AppHelper::INACTIVE);
    }

    /**
     * Test gender constants contain expected values.
     *
     * @return void
     */
    public function testGenderConstants()
    {
        $this->assertCount(2, AppHelper::GENDER);
        $this->assertEquals('Male', AppHelper::GENDER[1]);
        $this->assertEquals('Female', AppHelper::GENDER[2]);
    }

    /**
     * Test blood group constants contain all 8 types.
     *
     * @return void
     */
    public function testBloodGroupConstants()
    {
        $this->assertCount(8, AppHelper::BLOOD_GROUP);
        $this->assertContains('A+', AppHelper::BLOOD_GROUP);
        $this->assertContains('O+', AppHelper::BLOOD_GROUP);
        $this->assertContains('B+', AppHelper::BLOOD_GROUP);
        $this->assertContains('AB+', AppHelper::BLOOD_GROUP);
        $this->assertContains('A-', AppHelper::BLOOD_GROUP);
        $this->assertContains('O-', AppHelper::BLOOD_GROUP);
        $this->assertContains('B-', AppHelper::BLOOD_GROUP);
        $this->assertContains('AB-', AppHelper::BLOOD_GROUP);
    }

    /**
     * Test week days constant is complete (Sunday to Saturday).
     *
     * @return void
     */
    public function testWeekDaysConstant()
    {
        $this->assertCount(7, AppHelper::weekDays);
        $this->assertEquals('Sunday', AppHelper::weekDays[0]);
        $this->assertEquals('Saturday', AppHelper::weekDays[6]);
    }

    /**
     * Test religion constants.
     *
     * @return void
     */
    public function testReligionConstants()
    {
        $this->assertCount(5, AppHelper::RELIGION);
        $this->assertEquals('Islam', AppHelper::RELIGION[1]);
        $this->assertEquals('Other', AppHelper::RELIGION[5]);
    }

    /**
     * Test leave types are properly defined.
     *
     * @return void
     */
    public function testLeaveTypeConstants()
    {
        $this->assertCount(5, AppHelper::LEAVE_TYPES);
        $this->assertStringContainsString('Casual', AppHelper::LEAVE_TYPES[1]);
        $this->assertStringContainsString('Sick', AppHelper::LEAVE_TYPES[2]);
    }

    /**
     * Test attendance types have Present and Absent.
     *
     * @return void
     */
    public function testAttendanceTypeConstants()
    {
        $this->assertCount(2, AppHelper::ATTENDANCE_TYPE);
        $this->assertEquals('Absent', AppHelper::ATTENDANCE_TYPE[0]);
        $this->assertEquals('Present', AppHelper::ATTENDANCE_TYPE[1]);
    }

    /**
     * Test that subject types are defined.
     *
     * @return void
     */
    public function testSubjectTypeConstants()
    {
        $this->assertCount(3, AppHelper::SUBJECT_TYPE);
        $this->assertEquals('Core', AppHelper::SUBJECT_TYPE[1]);
        $this->assertEquals('Electives', AppHelper::SUBJECT_TYPE[2]);
        $this->assertEquals('Selective', AppHelper::SUBJECT_TYPE[3]);
    }

    /**
     * Test grade types are complete (A+ to F).
     *
     * @return void
     */
    public function testGradeTypeConstants()
    {
        $this->assertCount(7, AppHelper::GRADE_TYPES);
        $this->assertEquals('A+', AppHelper::GRADE_TYPES[1]);
        $this->assertEquals('F', AppHelper::GRADE_TYPES[7]);
    }

    /**
     * Test employee designation types contain principal roles.
     *
     * @return void
     */
    public function testEmployeeDesignationConstants()
    {
        $this->assertCount(20, AppHelper::EMPLOYEE_DESIGNATION_TYPES);
        $this->assertEquals('Principal', AppHelper::EMPLOYEE_DESIGNATION_TYPES[1]);
        $this->assertEquals('Other', AppHelper::EMPLOYEE_DESIGNATION_TYPES[20]);
    }

    /**
     * Test marks distribution types.
     *
     * @return void
     */
    public function testMarksDistributionTypes()
    {
        $this->assertCount(7, AppHelper::MARKS_DISTRIBUTION_TYPES);
        $this->assertEquals('Written', AppHelper::MARKS_DISTRIBUTION_TYPES[1]);
        $this->assertEquals('Practical', AppHelper::MARKS_DISTRIBUTION_TYPES[7]);
    }

    /**
     * Test the getShortName acronym generator.
     *
     * @return void
     */
    public function testGetShortName()
    {
        $this->assertEquals('SMS', AppHelper::getShortName('School Management System'));
        $this->assertEquals('AB', AppHelper::getShortName('Ahmed Belmekki'));
        $this->assertEquals('H', AppHelper::getShortName('Hello'));
    }

    /**
     * Test Bengali number translation.
     *
     * @return void
     */
    public function testEn2BnNumber()
    {
        $this->assertEquals('১২৩', AppHelper::en2bnNumber('123'));
        $this->assertEquals('০', AppHelper::en2bnNumber('0'));
        $this->assertEquals('৯৯৯', AppHelper::en2bnNumber('999'));
    }

    /**
     * Test institute category returns valid value.
     *
     * @return void
     */
    public function testGetInstituteCategory()
    {
        $category = AppHelper::getInstituteCategory();
        $this->assertContains($category, ['school', 'college']);
    }

    /**
     * Test employee shift constants.
     *
     * @return void
     */
    public function testEmpShiftConstants()
    {
        $this->assertCount(2, AppHelper::EMP_SHIFTS);
        $this->assertEquals('Day', AppHelper::EMP_SHIFTS[1]);
        $this->assertEquals('Night', AppHelper::EMP_SHIFTS[2]);
    }

    /**
     * Test passing rules constant.
     *
     * @return void
     */
    public function testPassingRulesConstants()
    {
        $this->assertCount(3, AppHelper::PASSING_RULES);
        $this->assertEquals('Over All', AppHelper::PASSING_RULES[1]);
        $this->assertEquals('Individual', AppHelper::PASSING_RULES[2]);
    }

    /**
     * Test language constants.
     *
     * @return void
     */
    public function testLanguageConstants()
    {
        $this->assertCount(2, AppHelper::LANGUEAGES);
        $this->assertArrayHasKey('en', AppHelper::LANGUEAGES);
        $this->assertArrayHasKey('bn', AppHelper::LANGUEAGES);
    }
}
