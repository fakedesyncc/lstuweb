<?php

namespace App\Validation;

/**
 * @author fakedesyncc
 */
class UserValidator
{
    public static function validateRegistration(array $data): array
    {
        $errors = [];

        if (empty($data['username'])) {
            $errors['username'] = 'Имя пользователя обязательно для заполнения';
        } elseif (strlen($data['username']) < 3) {
            $errors['username'] = 'Имя пользователя должно содержать минимум 3 символа';
        } elseif (strlen($data['username']) > 100) {
            $errors['username'] = 'Имя пользователя не должно превышать 100 символов';
        } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $data['username'])) {
            $errors['username'] = 'Имя пользователя может содержать только буквы, цифры и подчеркивание';
        }

        if (empty($data['email'])) {
            $errors['email'] = 'Email обязателен для заполнения';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Некорректный формат email';
        } elseif (strlen($data['email']) > 100) {
            $errors['email'] = 'Email не должен превышать 100 символов';
        }

        if (empty($data['password'])) {
            $errors['password'] = 'Пароль обязателен для заполнения';
        } elseif (strlen($data['password']) < 6) {
            $errors['password'] = 'Пароль должен содержать минимум 6 символов';
        } elseif (strlen($data['password']) > 72) {
            $errors['password'] = 'Пароль не должен превышать 72 символа';
        }

        if (empty($data['password_confirm'])) {
            $errors['password_confirm'] = 'Подтверждение пароля обязательно';
        } elseif ($data['password'] !== $data['password_confirm']) {
            $errors['password_confirm'] = 'Пароли не совпадают';
        }

        return $errors;
    }

    public static function validateLogin(array $data): array
    {
        $errors = [];

        if (empty($data['username'])) {
            $errors['username'] = 'Имя пользователя обязательно для заполнения';
        }

        if (empty($data['password'])) {
            $errors['password'] = 'Пароль обязателен для заполнения';
        }

        return $errors;
    }

    public static function sanitize(array $data): array
    {
        return [
            'username' => trim($data['username'] ?? ''),
            'email' => trim(strtolower($data['email'] ?? '')),
            'password' => $data['password'] ?? '',
            'password_confirm' => $data['password_confirm'] ?? ''
        ];
    }
}
