<?php

declare(strict_types=1);

namespace App;

class FormValidator
{
    /**
     * Validate a student's name according to the project rules.
     *
     * @param string $name Raw name input from the form.
     * @return string|null Null when valid, otherwise an error message.
     */
    public function validateName(string $name): ?string
    {
        $name = trim($name);

        if (mb_strlen($name) < 2) {
            return 'Name must be at least 2 characters.';
        }

        if (!preg_match('/^[A-Za-z\s\'-]+$/', $name)) {
            return 'Name contains invalid characters. Only letters, spaces, apostrophes, and hyphens are allowed.';
        }

        return null;
    }

    /**
     * Validate an email address using server-side rules.
     *
     * @param string $email Raw email input from the form.
     * @return string|null Null when valid, otherwise an error message.
     */
    public function validateEmail(string $email): ?string
    {
        $email = trim($email);

        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            return 'Invalid email format.';
        }

        return null;
    }

    /**
     * Validate an age value against the project range requirements.
     *
     * @param int $age Student age from the form submission.
     * @return string|null Null when valid, otherwise an error message.
     */
    public function validateAge(int $age): ?string
    {
        if ($age < 18) {
            return 'Age must be at least 18.';
        }

        if ($age > 100) {
            return 'Age must not exceed 100.';
        }

        return null;
    }

    /**
     * Validate all required form fields and return an associative error list.
     *
     * @param array<string, mixed> $input Submitted form data.
     * @return array<string, string> Associative array of validation errors.
     */
    public function validateAll(array $input): array
    {
        $errors = [];

        // Name
        $name = isset($input['name']) ? (string)$input['name'] : '';
        $nameError = $this->validateName($name);
        if ($nameError !== null) {
            $errors['name'] = $nameError;
        }

        // Email
        $email = isset($input['email']) ? (string)$input['email'] : '';
        $emailError = $this->validateEmail($email);
        if ($emailError !== null) {
            $errors['email'] = $emailError;
        }

        // Age
        $age = $input['age'] ?? null;
        if ($age === null || $age === '') {
            $errors['age'] = 'Age is required.';
        } elseif (!is_numeric($age)) {
            $errors['age'] = 'Age must be a number.';
        } else {
            $ageError = $this->validateAge((int)$age);
            if ($ageError !== null) {
                $errors['age'] = $ageError;
            }
        }

        return $errors;
    }
}
