<?php

namespace Tests\Unit\Security;

use PHPUnit\Framework\TestCase;
use App\Security\CsrfToken;

class CsrfTokenTest extends TestCase
{
    protected function setUp(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
        $_SESSION = [];
    }

    public function testGenerateToken(): void
    {
        $token = CsrfToken::generate();
        $this->assertNotEmpty($token);
        $this->assertEquals(64, strlen($token));
    }

    public function testGetToken(): void
    {
        $generatedToken = CsrfToken::generate();
        $retrievedToken = CsrfToken::get();
        
        $this->assertEquals($generatedToken, $retrievedToken);
    }

    public function testValidateToken(): void
    {
        $token = CsrfToken::generate();
        $this->assertTrue(CsrfToken::validate($token));
    }

    public function testValidateInvalidToken(): void
    {
        CsrfToken::generate();
        $this->assertFalse(CsrfToken::validate('invalid_token'));
    }

    public function testValidateWithoutToken(): void
    {
        $this->assertFalse(CsrfToken::validate('some_token'));
    }

    public function testClearToken(): void
    {
        CsrfToken::generate();
        $this->assertNotNull(CsrfToken::get());
        
        CsrfToken::clear();
        $this->assertNull(CsrfToken::get());
    }
}
