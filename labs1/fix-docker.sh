#!/bin/bash

# Скрипт для исправления проблемы с Docker credentials

echo "Исправление проблемы с Docker credentials..."

if [ -f ~/.docker/config.json ]; then
    echo "Найден файл конфигурации Docker"
    
    # Создаем резервную копию
    cp ~/.docker/config.json ~/.docker/config.json.backup
    echo "Создана резервная копия: ~/.docker/config.json.backup"
    
    # Удаляем credsStore из конфига
    if command -v jq > /dev/null; then
        # Используем jq если доступен
        jq 'del(.credsStore)' ~/.docker/config.json > ~/.docker/config.json.tmp
        mv ~/.docker/config.json.tmp ~/.docker/config.json
        echo "✅ Удален credsStore через jq"
    else
        # Простое удаление через sed (macOS и Linux)
        if [[ "$OSTYPE" == "darwin"* ]]; then
            sed -i '' '/"credsStore"/d' ~/.docker/config.json
        else
            sed -i '/"credsStore"/d' ~/.docker/config.json
        fi
        echo "✅ Удален credsStore через sed"
    fi
else
    echo "Создание нового файла конфигурации..."
    mkdir -p ~/.docker
    echo '{"auths": {}}' > ~/.docker/config.json
fi

echo ""
echo "Попытка удаления credentials из Keychain..."
security delete-internet-password -s index.docker.io 2>/dev/null || true
security delete-internet-password -s registry-1.docker.io 2>/dev/null || true

echo ""
echo "✅ Исправление завершено!"
echo ""
echo "Попробуйте запустить:"
echo "  cd labs1"
echo "  docker-compose up -d"
