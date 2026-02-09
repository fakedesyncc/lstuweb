# Changelog

## [2026-02-09] - Реализация улучшений

### Добавлено
- ✅ Repository Pattern для работы с БД (`CarRepository`, `UserRepository`)
- ✅ Service Layer для бизнес-логики (`CarService`, `UserService`)
- ✅ Dependency Injection контейнер (`Container`)
- ✅ Middleware система (`AuthMiddleware`, `RateLimitMiddleware`)
- ✅ Event System (`EventDispatcher`)
- ✅ PSR-3 совместимый Logger
- ✅ REST API (`ApiController`) с поддержкой CRUD операций
- ✅ Пагинация для списков данных
- ✅ Поиск и фильтрация автомобилей
- ✅ Индексы в базе данных для оптимизации запросов
- ✅ Health checks для Docker контейнеров
- ✅ Integration тесты (`CarRepositoryTest`)
- ✅ Лабораторная работа 7: REST API и улучшения

### Исправлено
- ✅ Исправлены ошибки в Makefile (команды теперь выполняются из правильных директорий)
- ✅ Создан `composer.json` с необходимыми зависимостями
- ✅ Улучшен autoloader для поддержки Composer
- ✅ Обновлены модели для использования Repository pattern
- ✅ Добавлена пагинация в labs4

### Изменено
- ✅ Обновлен `README.md` с отметками о выполненных улучшениях
- ✅ Обновлен `docker-compose.yml` с health checks
- ✅ Обновлена структура проекта для поддержки новых компонентов

**Автор**: fakedesyncc
