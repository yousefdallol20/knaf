<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Project Title
## Project Overview

The project is a full-stack application built with Laravel and Vue.js. It provides a comprehensive solution for managing users, roles, and permissions.

## Tech Stack & Architecture

* Frontend: Vue.js
* Backend: Laravel
* Database: MySQL
* Authentication: JWT

## Key Features

* User management
* Role-based access control
* Permission management

## Project Structure

* app/
* bootstrap/
* config/
* database/
* public/
* resources/
* routes/
* storage/
* tests/
* vendor/

## Installation & Setup

1. Clone the repository
2. Run `composer install`
3. Run `npm install`
4. Run `php artisan migrate`
5. Run `npm run dev`
6. Run `php artisan serve`

## API Endpoints

| Method | Endpoint | Controller | Auth |
| --- | --- | --- | --- |
| GET | /api/users | UserController | Yes |
| POST | /api/users | UserController | Yes |
| GET | /api/roles | RoleController | Yes |
| POST | /api/roles | RoleController | Yes |
| GET | /api/permissions | PermissionController | Yes |
| POST | /api/permissions | PermissionController | Yes |

## Author & License

* Developer: Yousef Dalloul
* License: MIT License
