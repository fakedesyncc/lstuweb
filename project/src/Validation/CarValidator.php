<?php

namespace App\Validation;

/**
 * @author fakedesyncc
 */
class CarValidator
{
    public static function validate(array $data): array
    {
        $errors = [];

        if (empty($data['brand'])) {
            $errors['brand'] = 'Марка обязательна для заполнения';
        } elseif (strlen($data['brand']) > 100) {
            $errors['brand'] = 'Марка не должна превышать 100 символов';
        }

        if (empty($data['model'])) {
            $errors['model'] = 'Модель обязательна для заполнения';
        } elseif (strlen($data['model']) > 100) {
            $errors['model'] = 'Модель не должна превышать 100 символов';
        }

        if (!isset($data['price']) || $data['price'] === '') {
            $errors['price'] = 'Цена обязательна для заполнения';
        } else {
            $price = filter_var($data['price'], FILTER_VALIDATE_FLOAT);
            if ($price === false || $price < 0) {
                $errors['price'] = 'Цена должна быть положительным числом';
            }
        }

        if (!isset($data['year']) || $data['year'] === '') {
            $errors['year'] = 'Год обязателен для заполнения';
        } else {
            $year = filter_var($data['year'], FILTER_VALIDATE_INT);
            $currentYear = (int)date('Y');
            if ($year === false || $year < 1900 || $year > $currentYear + 1) {
                $errors['year'] = "Год должен быть в диапазоне от 1900 до " . ($currentYear + 1);
            }
        }

        if (isset($data['color']) && strlen($data['color']) > 50) {
            $errors['color'] = 'Цвет не должен превышать 50 символов';
        }

        return $errors;
    }

    public static function sanitize(array $data): array
    {
        return [
            'brand' => trim($data['brand'] ?? ''),
            'model' => trim($data['model'] ?? ''),
            'price' => filter_var($data['price'] ?? 0, FILTER_VALIDATE_FLOAT),
            'year' => filter_var($data['year'] ?? 0, FILTER_VALIDATE_INT),
            'color' => trim($data['color'] ?? ''),
            'image_url' => trim($data['image_url'] ?? '') ?: null
        ];
    }
}
