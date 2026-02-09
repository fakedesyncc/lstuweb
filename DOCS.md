# Документация

## Генерация документации

Документация генерируется автоматически из PHPDoc комментариев.

### Простой способ (рекомендуется)

```bash
cd project
make docs
```

Проект автоматически выберет лучший доступный метод:
1. Docker (если доступен и работает)
2. Альтернативный PHP генератор (встроенный, работает всегда)

### Альтернативные методы

#### Метод 1: Встроенный генератор (работает всегда)

```bash
cd project
php generate-docs.php
```

Этот метод не требует внешних зависимостей и работает с любой версией PHP.

#### Метод 2: Docker (если доступен)

```bash
docker pull phpdoc/phpdoc:3
docker run --rm -v $(pwd):/data phpdoc/phpdoc:3 -d src -t docs/html
```

**Примечание:** Если возникают проблемы с Docker credentials на macOS, см. [DOCKER_FIX.md](project/DOCKER_FIX.md)

#### Метод 3: Через скрипт

```bash
cd project
./docs-setup.sh
```

### Результат

Документация будет доступна в `project/docs/html/index.html`

### Автоматическая генерация

При каждом push в ветку `main` документация автоматически генерируется через GitHub Actions.

## Формат документации

Используйте PHPDoc комментарии:

```php
/**
 * Описание класса
 * 
 * @author fakedesyncc
 */
class MyClass
{
    /**
     * Описание метода
     * 
     * @param string $param Описание параметра
     * @return bool Результат выполнения
     */
    public function myMethod(string $param): bool
    {
        return true;
    }
}
```

**Автор**: fakedesyncc
