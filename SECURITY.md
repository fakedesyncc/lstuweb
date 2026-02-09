# Безопасность

## CSRF защита

Все формы защищены от CSRF атак через токены.

### Использование в формах

```php
<?php
require_once __DIR__ . '/../project/src/Helpers/CsrfHelper.php';
use App\Helpers\CsrfHelper;
?>

<form method="POST">
    <?= CsrfHelper::field() ?>
    <!-- остальные поля формы -->
</form>
```

### Проверка в контроллере

```php
use App\Helpers\CsrfHelper;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!CsrfHelper::validateRequest()) {
        // Обработка ошибки CSRF
        return;
    }
    // Обработка формы
}
```

## Валидация данных

### Валидация автомобилей

```php
use App\Validation\CarValidator;

$data = CarValidator::sanitize($_POST);
$errors = CarValidator::validate($data);

if (empty($errors)) {
    // Данные валидны
} else {
    // Показать ошибки
}
```

### Валидация пользователей

```php
use App\Validation\UserValidator;

$data = UserValidator::sanitize($_POST);
$errors = UserValidator::validateRegistration($data);
// или
$errors = UserValidator::validateLogin($data);
```

## Безопасность паролей

Пароли хешируются с помощью `password_hash()` и проверяются через `password_verify()`.

**Автор**: fakedesyncc
