#!/bin/bash

# Скрипт для настройки базы данных

set -e

echo "Ожидание готовности MySQL..."
timeout=60
counter=0

while ! docker exec autosalon_mysql mysqladmin ping -h localhost --silent 2>/dev/null; do
    sleep 2
    counter=$((counter + 2))
    if [ $counter -ge $timeout ]; then
        echo "❌ MySQL не запустился за $timeout секунд"
        echo "Проверьте логи: docker logs autosalon_mysql"
        exit 1
    fi
    echo -n "."
done

echo ""
echo "✅ MySQL готов!"

echo ""
echo "Создание таблиц для labs3..."
docker exec -i autosalon_mysql mysql -uroot -proot 2>/dev/null < ../labs3/database.sql || \
docker exec -i autosalon_mysql mysql -uroot -proot < ../labs3/database.sql

echo "Создание таблиц для labs5..."
docker exec -i autosalon_mysql mysql -uroot -proot 2>/dev/null < ../labs5/database.sql || \
docker exec -i autosalon_mysql mysql -uroot -proot < ../labs5/database.sql

echo ""
echo "✅ База данных настроена!"
echo ""
echo "Проверка таблиц:"
docker exec autosalon_mysql mysql -uroot -proot -e "USE autosalon; SHOW TABLES;" 2>/dev/null || \
docker exec autosalon_mysql mysql -uroot -proot -e "USE autosalon; SHOW TABLES;"
