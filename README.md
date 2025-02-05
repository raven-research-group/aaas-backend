# Laravel Authentication as a Service (AAAS) Backend

## Table of Contents
1. [Introduction](#introduction)
2. [Features](#features)
3. [Prerequisites](#prerequisites)
4. [Installation](#installation)
   - [Clone the Repository](#1-clone-the-repository)
   - [Install Dependencies](#2-install-dependencies)
   - [Set Up Environment Variables](#3-set-up-environment-variables)
   - [Generate Application Key](#4-generate-application-key)
   - [Run Migrations](#5-run-migrations)
   - [Run Seeders](#6-run-seeders-creates-admin-and-organization-setup)
   - [Serve the Application](#7-serve-the-application)
5. [API Authentication](#api-authentication)
6. [Additional Commands](#additional-commands)

## Introduction
This is a Laravel-based Authentication as a Service (AAAS) backend that provides secure user authentication and organization management. The system enables seamless user onboarding with an organization structure and an administrative role.

## Features
- User authentication with passport token
- Organization and Admin management
- API authentication with Laravel Passport
- Secure and scalable architecture

## Prerequisites
Ensure you have the following installed before setting up the project:
- PHP 8.1 or higher
- Composer
- MySQL database
- Laravel 10+

## Installation
Follow these steps to set up the project after cloning the repository:

### 1. Clone the Repository
```sh
git clone git@github.com:Cran-Stack/aaas-backend.git
cd aaas-backend
```

### 2. Install Dependencies
```sh
composer install
```

### 3. Set Up Environment Variables
Copy the example environment file and configure the database settings:
```sh
cp .env.example .env
```
Edit the `.env` file to match your database configuration:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=aaasBackend
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

### 4. Generate Application Key
```sh
php artisan key:generate
```

### 5. Run Migrations
```sh
php artisan migrate
```

### 6. Run Seeders (Creates Admin and Organization Setup)
```sh
php artisan db:seed
```

### 7. Serve the Application
```sh
php artisan serve --port 8053
```
The application should now be running on `http://127.0.0.1:8053`.

## API Authentication
This project uses Laravel Passport for API authentication. To set up Passport, run:
```sh
php artisan passport:install
php artisan passport:keys
```
This command generates access and refresh tokens required for authentication.

## Additional Commands
To clear the application cache:
```sh
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```
---
**Maintainer:** Your Name (cranstack@gmail.com)

