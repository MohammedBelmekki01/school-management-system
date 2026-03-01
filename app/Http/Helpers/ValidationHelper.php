<?php

namespace App\Http\Helpers;

use Illuminate\Support\Facades\Validator;

/**
 * ValidationHelper
 *
 * Centralized validation rules and utilities for common
 * input patterns used across the school management system.
 *
 * @author Mohammed Belmekki
 */
class ValidationHelper
{
    /**
     * Algerian phone number pattern (mobile)
     * Supports: 05, 06, 07 prefixes with 8 digits
     */
    const PHONE_REGEX = '/^(0)(5|6|7)[0-9]{8}$/';

    /**
     * Simple name pattern (letters, spaces, hyphens, apostrophes)
     */
    const NAME_REGEX = '/^[\pL\s\-\'\.]+$/u';

    /**
     * Validate a phone number format
     *
     * @param string $phone
     * @return bool
     */
    public static function isValidPhone($phone)
    {
        if (empty($phone)) {
            return false;
        }

        return (bool) preg_match(self::PHONE_REGEX, $phone);
    }

    /**
     * Validate a person's name
     *
     * @param string $name
     * @return bool
     */
    public static function isValidName($name)
    {
        if (empty($name) || strlen($name) < 2 || strlen($name) > 100) {
            return false;
        }

        return (bool) preg_match(self::NAME_REGEX, $name);
    }

    /**
     * Validate email format
     *
     * @param string $email
     * @return bool
     */
    public static function isValidEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Sanitize a string input by trimming and removing extra whitespace
     *
     * @param string $input
     * @return string
     */
    public static function sanitizeString($input)
    {
        if (!is_string($input)) {
            return '';
        }

        $input = trim($input);
        $input = preg_replace('/\s+/', ' ', $input);
        $input = strip_tags($input);

        return $input;
    }

    /**
     * Get standard validation rules for student registration
     *
     * @return array
     */
    public static function getStudentValidationRules()
    {
        return [
            'name'             => 'required|string|min:2|max:100',
            'dob'              => 'required|date',
            'gender'           => 'required|integer|in:1,2',
            'religion'         => 'nullable|integer|in:1,2,3,4,5',
            'blood_group'      => 'nullable|integer|in:1,2,3,4,5,6,7,8',
            'nationality'      => 'nullable|string|max:50',
            'email'            => 'nullable|email|max:100',
            'phone_no'         => 'nullable|string|max:20',
            'father_name'      => 'nullable|string|max:100',
            'father_phone_no'  => 'nullable|string|max:20',
            'mother_name'      => 'nullable|string|max:100',
            'mother_phone_no'  => 'nullable|string|max:20',
            'present_address'  => 'nullable|string|max:500',
            'permanent_address' => 'nullable|string|max:500',
        ];
    }

    /**
     * Get standard validation rules for employee creation
     *
     * @return array
     */
    public static function getEmployeeValidationRules()
    {
        return [
            'name'          => 'required|string|min:2|max:100',
            'designation'   => 'required|integer',
            'dob'           => 'required|date',
            'gender'        => 'required|integer|in:1,2',
            'religion'      => 'nullable|integer|in:1,2,3,4,5',
            'email'         => 'nullable|email|max:100',
            'phone_no'      => 'required|string|max:20',
            'address'       => 'nullable|string|max:500',
            'qualification' => 'nullable|string|max:200',
            'joining_date'  => 'required|string',
        ];
    }

    /**
     * Get standard validation rules for exam marks entry
     *
     * @return array
     */
    public static function getMarksValidationRules()
    {
        return [
            'exam_id'       => 'required|integer|exists:exams,id',
            'class_id'      => 'required|integer|exists:i_classes,id',
            'section_id'    => 'required|integer|exists:sections,id',
            'subject_id'    => 'required|integer|exists:subjects,id',
            'marks'         => 'required|array',
            'marks.*'       => 'required|numeric|min:0|max:100',
        ];
    }

    /**
     * Validate that a date string is in the expected d/m/Y format
     *
     * @param string $date
     * @return bool
     */
    public static function isValidDateFormat($date, $format = 'd/m/Y')
    {
        $parsed = \DateTime::createFromFormat($format, $date);
        return $parsed && $parsed->format($format) === $date;
    }

    /**
     * Validate password strength
     * Must contain at least 8 characters, one uppercase, one lowercase, one digit
     *
     * @param string $password
     * @return array ['valid' => bool, 'errors' => array]
     */
    public static function validatePasswordStrength($password)
    {
        $errors = [];

        if (strlen($password) < 8) {
            $errors[] = 'Password must be at least 8 characters long.';
        }

        if (!preg_match('/[A-Z]/', $password)) {
            $errors[] = 'Password must contain at least one uppercase letter.';
        }

        if (!preg_match('/[a-z]/', $password)) {
            $errors[] = 'Password must contain at least one lowercase letter.';
        }

        if (!preg_match('/[0-9]/', $password)) {
            $errors[] = 'Password must contain at least one digit.';
        }

        return [
            'valid'  => empty($errors),
            'errors' => $errors,
        ];
    }
}
