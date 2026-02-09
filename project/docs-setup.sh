#!/bin/bash

# Скрипт для генерации документации

set -e

echo "Проверка Docker..."
if command -v docker > /dev/null && docker info > /dev/null 2>&1; then
    echo "Используем Docker..."
    docker pull phpdoc/phpdoc:3 2>/dev/null || true
    
    if docker run --rm -v "$(pwd):/data" phpdoc/phpdoc:3 -d src -t docs/html 2>/dev/null; then
        echo "✅ Документация сгенерирована через Docker в docs/html/index.html"
        exit 0
    else
        echo "⚠️  Проблема с Docker credentials. Используем альтернативный метод..."
    fi
else
    echo "⚠️  Docker недоступен. Используем альтернативный метод..."
fi

echo "Генерация документации через PHP скрипт..."
php generate-docs.php

echo "✅ Документация сгенерирована в docs/html/index.html"
