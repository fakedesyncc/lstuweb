# Лабораторная работа 4: MVC-архитектура

## Задание
1. Разделить код на models/, controllers/, views/
2. Сделать роутинг (Router.php)
3. Добавить фильтрацию данных

## Структура проекта

```
labs4/
├── src/
│   ├── Router.php          # Роутинг
│   ├── Controllers/         # Контроллеры
│   │   └── CarController.php
│   ├── Models/             # Модели
│   │   └── CarModel.php
│   └── Views/              # Представления
│       └── View.php
├── views/                  # Шаблоны
│   ├── layout.php
│   └── cars/
│       ├── index.php
│       ├── create.php
│       └── show.php
└── index.php              # Точка входа
```

## Использование

Откройте в браузере: http://localhost:8080/labs4/index.php

## Функционал
- Разделение на Model-View-Controller
- Роутинг через Router.php
- Фильтрация и валидация входных данных
- Список автомобилей
- Добавление нового автомобиля
- Просмотр детальной информации об автомобиле
