# Инструкция по установке и запуску

## Требования

- Docker Desktop (или Docker + Docker Compose)
- Компьютер с доступом в интернет (для скачивания образов)

## Шаг 1: Запуск Docker окружения

```bash
cd labs1
docker-compose up -d
```

Это запустит:
- PHP 8.1 с Apache на порту 8080
- MySQL 8.0 на порту 3306
- phpMyAdmin на порту 8081

## Шаг 2: Создание базы данных

**Рекомендуется использовать автоматический скрипт:**

```bash
cd labs1
./setup-database.sh
```

Скрипт автоматически дождется готовности MySQL и создаст все необходимые таблицы.

**Или вручную** (после того как MySQL будет готов - обычно 10-20 секунд):

```bash
# Для labs3 (автомобили и клиенты)
docker exec -i autosalon_mysql mysql -uroot -proot < ../labs3/database.sql

# Для labs5 (пользователи)
docker exec -i autosalon_mysql mysql -uroot -proot < ../labs5/database.sql
```

Или подключитесь к MySQL через phpMyAdmin (http://localhost:8081) и выполните SQL вручную.

## Шаг 3: Установка PHP зависимостей (опционально)

Для labs6 (генерация отчетов) потребуются дополнительные библиотеки:

```bash
cd ../project
composer install
```

Если composer не установлен, можно установить библиотеки вручную или использовать готовые файлы.

## Шаг 4: Проверка работы

1. **Лабораторная 1**: http://localhost:8080/labs1/index.php
   - Должна отобразиться страница phpinfo()

2. **Лабораторная 2**: http://localhost:8080/labs2/index.php
   - Форма для добавления автомобиля

3. **Лабораторная 3**: http://localhost:8080/labs3/index.php
   - Работа с базой данных

4. **Лабораторная 4**: http://localhost:8080/labs4/index.php
   - MVC архитектура

5. **Лабораторная 5**: http://localhost:8080/labs5/index.php
   - Авторизация и регистрация

6. **Лабораторная 6**: http://localhost:8080/labs6/index.php
   - Генерация отчетов

## Остановка

```bash
cd labs1
docker-compose down
```

Для полной очистки (включая данные БД):

```bash
docker-compose down -v
```

## Устранение проблем

### Docker credentials ошибка
Если возникает ошибка `error getting credentials`:

```bash
# Быстрое исправление
cd labs1
./fix-docker.sh

# Или вручную
rm ~/.docker/config.json
```

**Решение:** Проблема с сохраненными учетными данными Docker в macOS Keychain. Скрипт `fix-docker.sh` автоматически исправляет это.

### Порт уже занят
Если порты 8080, 8081 или 3306 заняты, измените их в `labs1/docker-compose.yml`

### Ошибка подключения к БД
Убедитесь, что MySQL контейнер запущен:
```bash
docker ps
```

Проверьте логи:
```bash
docker logs autosalon_mysql
```

### PHP не видит классы
Убедитесь, что все require_once пути корректны. Все лабораторные используют общий код из `project/`.
