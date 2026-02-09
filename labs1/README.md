# Лабораторная работа 1: Введение в Docker и настройка окружения

## Задание
1. Установить Docker и Docker Compose
2. Написать docker-compose.yml с PHP, Apache и MySQL
3. Проверить работу PHP (phpinfo)
4. Написать Dockerfile для PHP-приложения
5. Подключить phpMyAdmin

## Запуск

```bash
cd labs1
docker-compose up -d
```

**Если возникла ошибка с Docker credentials:**
```bash
# Быстрое исправление
./fix-docker.sh

# Или вручную
rm ~/.docker/config.json
```

После запуска:
- PHP приложение доступно по адресу: http://localhost:8080
- phpMyAdmin доступен по адресу: http://localhost:8081
- MySQL доступен на порту: 3306

## Проверка работы

Откройте в браузере: http://localhost:8080/index.php

Должна отобразиться страница с информацией о PHP (phpinfo).

## Остановка

```bash
docker-compose down
```

## Устранение проблем

### Docker credentials ошибка
Если возникают проблемы с Docker credentials:
```bash
./fix-docker.sh
```

### MySQL не готов
Если MySQL еще не готов, подождите и используйте скрипт:
```bash
./setup-database.sh
```

Скрипт автоматически дождется готовности MySQL перед выполнением SQL.
