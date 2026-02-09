<?php

namespace Tests\Unit\Validation;

use PHPUnit\Framework\TestCase;
use App\Validation\CarValidator;

class CarValidatorTest extends TestCase
{
    public function testValidateValidData(): void
    {
        $data = [
            'brand' => 'Toyota',
            'model' => 'Camry',
            'price' => 2500000,
            'year' => 2023,
            'color' => 'Black'
        ];

        $errors = CarValidator::validate($data);
        $this->assertEmpty($errors);
    }

    public function testValidateEmptyBrand(): void
    {
        $data = [
            'brand' => '',
            'model' => 'Camry',
            'price' => 2500000,
            'year' => 2023
        ];

        $errors = CarValidator::validate($data);
        $this->assertArrayHasKey('brand', $errors);
    }

    public function testValidateInvalidPrice(): void
    {
        $data = [
            'brand' => 'Toyota',
            'model' => 'Camry',
            'price' => -1000,
            'year' => 2023
        ];

        $errors = CarValidator::validate($data);
        $this->assertArrayHasKey('price', $errors);
    }

    public function testValidateInvalidYear(): void
    {
        $data = [
            'brand' => 'Toyota',
            'model' => 'Camry',
            'price' => 2500000,
            'year' => 1800
        ];

        $errors = CarValidator::validate($data);
        $this->assertArrayHasKey('year', $errors);
    }

    public function testSanitizeData(): void
    {
        $data = [
            'brand' => '  Toyota  ',
            'model' => '  Camry  ',
            'price' => '2500000.50',
            'year' => '2023',
            'color' => '  Black  '
        ];

        $sanitized = CarValidator::sanitize($data);
        
        $this->assertEquals('Toyota', $sanitized['brand']);
        $this->assertEquals('Camry', $sanitized['model']);
        $this->assertEquals(2500000.50, $sanitized['price']);
        $this->assertEquals(2023, $sanitized['year']);
        $this->assertEquals('Black', $sanitized['color']);
    }
}
