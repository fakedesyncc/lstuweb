# Лабораторная работа 7: REST API и улучшения

## Реализованные улучшения

### Архитектура
- ✅ Repository Pattern для работы с БД
- ✅ Service Layer для бизнес-логики
- ✅ Dependency Injection контейнер
- ✅ Middleware для обработки запросов
- ✅ Event System для расширяемости

### Производительность
- ✅ Пагинация для списков данных
- ✅ Индексы в базе данных для оптимизации запросов
- ✅ Поиск и фильтрация автомобилей

### Безопасность
- ✅ Rate limiting для API endpoints
- ✅ Логирование подозрительной активности

### Функциональность
- ✅ REST API для работы с автомобилями
- ✅ Поиск и фильтрация автомобилей

## API Endpoints

### GET /labs7/api.php/api/cars
Получить список автомобилей с пагинацией и фильтрацией

Параметры:
- `page` - номер страницы (по умолчанию 1)
- `per_page` - элементов на странице (по умолчанию 10)
- `brand` - фильтр по марке
- `model` - фильтр по модели
- `min_price` - минимальная цена
- `max_price` - максимальная цена
- `min_year` - минимальный год
- `max_year` - максимальный год

Пример:
```
GET /labs7/api.php/api/cars?page=1&per_page=10&brand=Toyota&min_price=1000000
```

### GET /labs7/api.php/api/cars/{id}
Получить автомобиль по ID

### POST /labs7/api.php/api/cars
Создать новый автомобиль

Body (JSON):
```json
{
  "brand": "Toyota",
  "model": "Camry",
  "price": 2500000,
  "year": 2023,
  "color": "Black"
}
```

### PUT /labs7/api.php/api/cars/{id}
Обновить автомобиль

### DELETE /labs7/api.php/api/cars/{id}
Удалить автомобиль

## Использование

```bash
# Запустить проект
make start

# Использовать API
curl http://localhost:8080/labs7/api.php/api/cars
```

**Автор**: fakedesyncc
