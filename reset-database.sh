#!/usr/bin/env bash

SQL="
DROP DATABASE IF EXISTS \`operator\`;
CREATE DATABASE IF NOT EXISTS \`operator\` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
GRANT ALL PRIVILEGES ON \`operator\`.* TO \`homestead\`@\`localhost\`;
FLUSH PRIVILEGES;
"
echo "Resetting database.."
echo $SQL >> temp.sql
mysql -u root -p"secret" -h localhost --port=33060 < temp.sql
rm temp.sql