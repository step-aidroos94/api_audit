#!/bin/bash

echo "🚀 بدء إعداد Laravel في GitHub Codespaces..."

# تحديث الحزم
sudo apt update

# تثبيت MySQL Client وامتداد pdo_mysql
sudo apt install -y php-mysql mysql-client

# التحقق من وجود الامتداد
php -m | grep -i pdo_mysql > /dev/null
if [ $? -eq 0 ]; then
    echo "✅ امتداد pdo_mysql مفعل."
else
    echo "❌ لم يتم تفعيل امتداد pdo_mysql. تحقق من php.ini أو أعد تشغيل PHP."
fi

# تثبيت Composer dependencies
composer install

# إنشاء ملف .env إذا لم يكن موجود
if [ ! -f ".env" ]; then
    cp .env.example .env
    echo "📄 تم إنشاء .env"
fi

# إنشاء مفتاح التطبيق
php artisan key:generate

# تشغيل السيرفر
echo "🌐 تشغيل السيرفر على http://0.0.0.0:8000 ..."
php artisan serve --host=0.0.0.0 --port=8000