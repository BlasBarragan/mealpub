#!/bin/bash

# Configuración
DB_USER="root"
DB_PASS="230988"
DB_NAME="mealmate"
EXPORT_DIR="/var/www/mealmate/db_dumps"
EXPORT_FILE="$EXPORT_DIR/mealmate.sql"

# Crear carpeta si no existe
mkdir -p "$EXPORT_DIR"

# Exportar la base de datos
mysqldump -u$DB_USER -p$DB_PASS $DB_NAME > "$EXPORT_FILE"

# Añadir al commit
cd /var/www/mealmate
git add "$EXPORT_FILE"
