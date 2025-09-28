# 📘 Task Management - README

## ⚙️ Setup

Clone the repository:

bash: 
git clone https://github.com/Shahadat-Hossain-Shanto/taskmanager.git

Install dependencies:  composer install

Copy environment file:  cp .env.example .env

Generate app key:  php artisan key:generate

Configure DB in .env

Run migrations:  php artisan migrate

Serve the app:  php artisan serve

🏗️ Architecture

This is a Laravel 12 project following MVC architecture

Models: App\Models\Task for database interaction

Controllers: App\Http\Controllers\TaskController handles task logic

Routes: Defined in routes/api.php and routes/web.php

Views: Blade templates for frontend (Bootstrap 5)

Database: MySQL with tasks table

🚀 Scalability

API supports bulk task insertion

Validation layer ensures data consistency

Rate limiting applied with throttle middleware

Stateless API with token-based Authorization


