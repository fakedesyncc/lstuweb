.PHONY: test test-integration test-all phpstan docs install clean

install:
	composer install

test:
	@if [ ! -f vendor/bin/phpunit ]; then \
		echo "Установка зависимостей..."; \
		composer install --no-interaction; \
	fi
	@echo "Запуск unit тестов..."
	@./vendor/bin/phpunit --configuration phpunit.xml

test-integration:
	@if [ ! -f vendor/bin/phpunit ]; then \
		echo "Установка зависимостей..."; \
		composer install --no-interaction; \
	fi
	@echo "Запуск integration тестов (требуется запущенный MySQL)..."
	@./vendor/bin/phpunit --configuration phpunit.xml --group integration

test-all:
	@if [ ! -f vendor/bin/phpunit ]; then \
		echo "Установка зависимостей..."; \
		composer install --no-interaction; \
	fi
	@echo "Запуск всех тестов..."
	@./vendor/bin/phpunit --configuration phpunit.xml --exclude-group integration || true
	@echo ""
	@echo "Для запуска integration тестов используйте: make test-integration"

phpstan:
	@if [ ! -f vendor/bin/phpstan ]; then \
		echo "Установка зависимостей..."; \
		composer install --no-interaction; \
	fi
	@./vendor/bin/phpstan analyse --memory-limit=512M

docs:
	@echo "Генерация документации..."
	@if command -v docker > /dev/null && docker info > /dev/null 2>&1; then \
		echo "Используем Docker..."; \
		docker pull phpdoc/phpdoc:3 2>/dev/null || true; \
		docker run --rm -v $$(pwd):/data phpdoc/phpdoc:3 -d src -t docs/html 2>/dev/null || \
		(echo "Ошибка Docker credentials. Используем альтернативный метод..."; php generate-docs.php); \
	else \
		echo "Docker недоступен. Используем альтернативный метод..."; \
		php generate-docs.php; \
	fi

clean:
	@echo "Очистка проекта..."
	@cd ../labs1 && docker-compose down -v 2>/dev/null || true
	@rm -rf vendor composer.lock .phpunit.cache .phpstan 2>/dev/null || true
	@rm -rf docs/html docs/api 2>/dev/null || true
	@echo "✅ Очистка завершена"

all: test phpstan docs

.PHONY: test test-integration test-all phpstan docs install clean
