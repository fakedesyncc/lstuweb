# Подготовка проекта к Git

## Важно перед первым коммитом

### 1. Проверка .env файлов

Убедитесь, что все `.env` файлы (кроме `.env.example`) игнорируются:

```bash
# Проверка что .env файлы игнорируются
git status --ignored | grep .env
```

**НЕ КОММИТЬТЕ:**
- `project/.env` - содержит пароли БД
- `project/.env.test` - содержит тестовые пароли
- Любые другие `.env` файлы

**МОЖНО КОММИТИТЬ:**
- `project/.env.example` - шаблон без паролей

### 2. Проверка credentials

Убедитесь, что нет файлов с credentials:
- `**/*credentials*`
- `**/*secret*`
- `**/*.key`
- `**/*.pem`
- `~/.docker/config.json`

### 3. Очистка временных файлов

Перед коммитом выполните:

```bash
# Остановка Docker контейнеров
cd labs1
docker-compose down

# Очистка временных файлов
cd ..
make clean
```

### 4. Инициализация Git (если еще не сделано)

```bash
git init
git add .
git commit -m "Initial commit"
```

### 5. Проверка перед коммитом

```bash
# Проверить что будет добавлено
git status

# Проверить что .env файлы игнорируются
git status --ignored | grep env

# Проверить размер коммита
git diff --cached --stat
```

## Структура проекта

Проект состоит из:
- `project/` - основной проект (готовое приложение)
- `labs1/` - Lab 1 (Docker, Apache)
- `labs2/` - Lab 2 (Формы)
- `labs3/` - Lab 3 (База данных)
- `labs4/` - Lab 4 (MVC)
- `labs5/` - Lab 5 (Авторизация)
- `labs6/` - Lab 6 (Отчеты)
- `labs7/` - Lab 7 (API)

## Что НЕ коммитится (.gitignore)

- `.env` файлы (кроме `.env.example`)
- `vendor/` (Composer зависимости)
- `composer.lock` (генерируется автоматически)
- Логи (`*.log`, `logs/`)
- Кэш (`cache/`, `*.cache`)
- Документация (`docs/`)
- Временные файлы (`.DS_Store`, `*.tmp`, `*.bak`)
- Docker volumes (`mysql_data/`)

## После клонирования репозитория

```bash
# 1. Установить зависимости
cd project
composer install

# 2. Создать .env файл из примера
cp .env.example .env
# Отредактировать .env с вашими настройками

# 3. Запустить Docker
cd ../labs1
docker-compose up -d
./setup-database.sh

# 4. Запустить seed данных (опционально)
cd ../project
php scripts/seed-cars.php
```
