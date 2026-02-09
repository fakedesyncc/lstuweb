# Тестирование

## Запуск тестов

```bash
cd project
make test
```

или

```bash
cd project
./vendor/bin/phpunit
```

## Структура тестов

- `tests/Unit/` - Unit тесты
- `tests/Integration/` - Integration тесты

## Написание тестов

Пример unit теста:

```php
<?php

namespace Tests\Unit\Security;

use PHPUnit\Framework\TestCase;
use App\Security\CsrfToken;

class CsrfTokenTest extends TestCase
{
    public function testGenerateToken(): void
    {
        $token = CsrfToken::generate();
        $this->assertNotEmpty($token);
    }
}
```

## CI/CD

Тесты автоматически запускаются при каждом push в репозиторий через GitHub Actions.

**Автор**: fakedesyncc
