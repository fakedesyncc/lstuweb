.PHONY: install start stop clean test phpstan docs

install:
	@echo "Установка зависимостей..."
	@cd project && composer install

start:
	@echo "Запуск Docker окружения..."
	@cd labs1 && docker-compose up -d
	@echo "Ожидание готовности MySQL..."
	@sleep 5
	@cd labs1 && ./setup-database.sh || echo "База данных уже настроена"

stop:
	@echo "Остановка контейнеров..."
	@cd labs1 && docker-compose down

clean:
	@echo "Полная очистка проекта..."
	@cd labs1 && docker-compose down -v 2>/dev/null || true
	@cd project && rm -rf vendor composer.lock .phpunit.cache .phpstan .phpunit.result.cache 2>/dev/null || true
	@cd project && rm -rf docs/html docs/api 2>/dev/null || true
	@find . -name "*.csv" -not -path "./.git/*" -not -path "./project/vendor/*" -delete 2>/dev/null || true
	@find . -name "*.xlsx" -not -path "./.git/*" -not -path "./project/vendor/*" -delete 2>/dev/null || true
	@find . -name "*.pdf" -not -path "./.git/*" -not -path "./project/vendor/*" -delete 2>/dev/null || true
	@find . -name ".phpunit.result.cache" -not -path "./.git/*" -delete 2>/dev/null || true
	@find . -name ".phpunit.cache" -type d -not -path "./.git/*" -exec rm -rf {} + 2>/dev/null || true
	@find . -name "*.backup" -not -path "./.git/*" -delete 2>/dev/null || true
	@echo "✅ Очистка завершена. Проект готов к коммиту в git."
	@echo ""
	@echo "Для коммита выполните:"
	@echo "  git add ."
	@echo "  git commit -m 'Ваше сообщение'"

test:
	@cd project && $(MAKE) test

phpstan:
	@cd project && $(MAKE) phpstan

docs:
	@cd project && $(MAKE) docs

all: test phpstan docs
