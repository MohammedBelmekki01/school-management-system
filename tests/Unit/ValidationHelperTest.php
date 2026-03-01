<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Helpers\ValidationHelper;

/**
 * Unit tests for the ValidationHelper class.
 *
 * Covers phone validation, name validation, email validation,
 * string sanitization, date format validation, and password strength.
 *
 * @author Mohammed Belmekki
 */
class ValidationHelperTest extends TestCase
{
    /**
     * Test valid phone numbers are accepted.
     *
     * @return void
     */
    public function testValidPhoneNumbers()
    {
        $this->assertTrue(ValidationHelper::isValidPhone('0555123456'));
        $this->assertTrue(ValidationHelper::isValidPhone('0661234567'));
        $this->assertTrue(ValidationHelper::isValidPhone('0770123456'));
    }

    /**
     * Test invalid phone numbers are rejected.
     *
     * @return void
     */
    public function testInvalidPhoneNumbers()
    {
        $this->assertFalse(ValidationHelper::isValidPhone(''));
        $this->assertFalse(ValidationHelper::isValidPhone('123'));
        $this->assertFalse(ValidationHelper::isValidPhone('0412345678'));
        $this->assertFalse(ValidationHelper::isValidPhone('abcdefghij'));
        $this->assertFalse(ValidationHelper::isValidPhone(null));
    }

    /**
     * Test valid names are accepted.
     *
     * @return void
     */
    public function testValidNames()
    {
        $this->assertTrue(ValidationHelper::isValidName('Mohammed'));
        $this->assertTrue(ValidationHelper::isValidName('Jean-Pierre'));
        $this->assertTrue(ValidationHelper::isValidName("O'Brien"));
        $this->assertTrue(ValidationHelper::isValidName('Dr. Ahmed'));
    }

    /**
     * Test invalid names are rejected.
     *
     * @return void
     */
    public function testInvalidNames()
    {
        $this->assertFalse(ValidationHelper::isValidName(''));
        $this->assertFalse(ValidationHelper::isValidName('A'));
        $this->assertFalse(ValidationHelper::isValidName('Name123'));
        $this->assertFalse(ValidationHelper::isValidName(null));
    }

    /**
     * Test email validation.
     *
     * @return void
     */
    public function testValidEmails()
    {
        $this->assertTrue(ValidationHelper::isValidEmail('user@example.com'));
        $this->assertTrue(ValidationHelper::isValidEmail('test.user@school.edu'));
        $this->assertFalse(ValidationHelper::isValidEmail('not-an-email'));
        $this->assertFalse(ValidationHelper::isValidEmail(''));
        $this->assertFalse(ValidationHelper::isValidEmail('@domain.com'));
    }

    /**
     * Test string sanitization removes excess whitespace and tags.
     *
     * @return void
     */
    public function testSanitizeString()
    {
        $this->assertEquals('Hello World', ValidationHelper::sanitizeString('  Hello   World  '));
        $this->assertEquals('Clean text', ValidationHelper::sanitizeString('<b>Clean text</b>'));
        $this->assertEquals('No tags', ValidationHelper::sanitizeString('<script>alert("x")</script>No tags'));
        $this->assertEquals('', ValidationHelper::sanitizeString(null));
        $this->assertEquals('', ValidationHelper::sanitizeString(123));
    }

    /**
     * Test date format validation.
     *
     * @return void
     */
    public function testDateFormatValidation()
    {
        $this->assertTrue(ValidationHelper::isValidDateFormat('15/03/2024'));
        $this->assertTrue(ValidationHelper::isValidDateFormat('01/01/2000'));
        $this->assertFalse(ValidationHelper::isValidDateFormat('2024-03-15'));
        $this->assertFalse(ValidationHelper::isValidDateFormat('32/13/2024'));
        $this->assertFalse(ValidationHelper::isValidDateFormat(''));
    }

    /**
     * Test that student validation rules array has expected keys.
     *
     * @return void
     */
    public function testStudentValidationRulesStructure()
    {
        $rules = ValidationHelper::getStudentValidationRules();

        $this->assertIsArray($rules);
        $this->assertArrayHasKey('name', $rules);
        $this->assertArrayHasKey('dob', $rules);
        $this->assertArrayHasKey('gender', $rules);
        $this->assertArrayHasKey('email', $rules);
        $this->assertArrayHasKey('father_name', $rules);
        $this->assertArrayHasKey('mother_name', $rules);
    }

    /**
     * Test that employee validation rules array has expected keys.
     *
     * @return void
     */
    public function testEmployeeValidationRulesStructure()
    {
        $rules = ValidationHelper::getEmployeeValidationRules();

        $this->assertIsArray($rules);
        $this->assertArrayHasKey('name', $rules);
        $this->assertArrayHasKey('designation', $rules);
        $this->assertArrayHasKey('phone_no', $rules);
        $this->assertArrayHasKey('joining_date', $rules);
    }

    /**
     * Test that marks validation rules array has expected keys.
     *
     * @return void
     */
    public function testMarksValidationRulesStructure()
    {
        $rules = ValidationHelper::getMarksValidationRules();

        $this->assertIsArray($rules);
        $this->assertArrayHasKey('exam_id', $rules);
        $this->assertArrayHasKey('class_id', $rules);
        $this->assertArrayHasKey('subject_id', $rules);
        $this->assertArrayHasKey('marks', $rules);
    }

    /**
     * Test strong password passes validation.
     *
     * @return void
     */
    public function testStrongPasswordValidation()
    {
        $result = ValidationHelper::validatePasswordStrength('MyPass1234');

        $this->assertTrue($result['valid']);
        $this->assertEmpty($result['errors']);
    }

    /**
     * Test weak password fails validation with appropriate errors.
     *
     * @return void
     */
    public function testWeakPasswordValidation()
    {
        // Too short
        $result = ValidationHelper::validatePasswordStrength('Ab1');
        $this->assertFalse($result['valid']);
        $this->assertNotEmpty($result['errors']);

        // No uppercase
        $result = ValidationHelper::validatePasswordStrength('lowercase123');
        $this->assertFalse($result['valid']);

        // No digits
        $result = ValidationHelper::validatePasswordStrength('NoDigitsHere');
        $this->assertFalse($result['valid']);

        // No lowercase
        $result = ValidationHelper::validatePasswordStrength('ALLCAPS123');
        $this->assertFalse($result['valid']);
    }
}
