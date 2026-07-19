<p align="center">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300" alt="Laravel Logo">
</p>

# SIAKAD — Academic Information System

A modern, role-based Academic Information System (Sistem Informasi Akademik) built with **Laravel 13**, **Tailwind CSS v4**, and **Vite**. Manages student attendance, billing, and user administration with a clean, responsive dashboard.

## ✨ Features

| Role | Capabilities |
|------|-------------|
| **Head Admin** | Full user CRUD, view all attendance, manage bills (create/edit/delete/toggle status) |
| **Teacher** | Record bulk attendance for students, view own attendance history |
| **Student** | View own attendance records with filters, view own bills |

### Shared Features
- 🔐 Role-based access control (middleware + policies)
- 👤 Profile management with photo upload
- 🔑 Password change via Settings
- 📊 Role-specific dashboard with stats & charts
- 🎨 Premium UI with indigo/violet gradient design system
- 📱 Fully responsive (mobile sidebar, adaptive tables)
- ⚡ Real-time asset compilation with Vite HMR

## 🛠 Tech Stack

- **Backend:** PHP 8.3+, Laravel 13
- **Frontend:** Tailwind CSS v4, Vite 8, Vanilla JS
- **Database:** SQLite (default) / MySQL / PostgreSQL
- **Auth:** Laravel built-in authentication with role middleware

## 🚀 Installation

### Prerequisites
- PHP 8.2+
- Composer
- Node.js 18+
- npm

### Setup

```bash
# 1. Clone the repository
git clone <your-repo-url> siakad
cd siakad

# 2. Install PHP dependencies
composer install

# 3. Configure environment
cp .env.example .env
php artisan key:generate

# 4. Run migrations & seed demo data
php artisan migrate --seed

# 5. Create storage symlink (for profile photos)
php artisan storage:link

# 6. Install frontend dependencies
npm install

# 7. Start the development servers
npm run dev
```

### Using Laragon (Windows)
If you're using Laragon, the app is automatically available at:
```
http://siakad.test
```
Just make sure Laragon's Apache is running and run `npm run dev` for assets.

### Using artisan serve
```bash
php artisan serve
# Then open http://127.0.0.1:8000
```

> **Important:** Always run `npm run dev` in a separate terminal for CSS/JS to load properly.

## 🔑 Demo Credentials

| Role | Email | Password |
|------|-------|----------|
| Admin | `admin@siakad.test` | `password` |
| Teacher | `teacher@siakad.test` | `password` |
| Student | `student@siakad.test` | `password` |

## 📁 Project Structure

```
app/
├── Enums/              # AttendanceStatus, BillStatus
├── Http/
│   ├── Controllers/
│   │   ├── Admin/      # UserController, BillController, AttendanceController
│   │   ├── Auth/       # LoginController, RegisterController
│   │   ├── Student/    # AttendanceController (student view)
│   │   ├── AttendanceController.php   # Teacher attendance
│   │   ├── BillController.php         # Student bills
│   │   ├── DashboardController.php
│   │   ├── ProfileController.php
│   │   └── SettingsController.php
│   ├── Middleware/      # CheckRole
│   └── Requests/        # Form validation (Auth, Admin, Profile)
├── Models/              # User, Role, Attendance, Bill
├── Policies/            # AttendancePolicy, BillPolicy, UserPolicy
└── Services/            # DashboardService, AttendanceService, BillService

resources/views/
├── admin/               # users/, attendance/, bills/ (CRUD views)
├── auth/                # login, register
├── components/          # sidebar, navbar, card, modal, alert, layouts/
├── dashboard/           # index + role partials (_admin, _teacher, _student)
├── errors/              # 403, 404, 500
├── profile/             # show, edit
├── settings/            # edit
├── student/             # attendance/index, bills/index
└── teacher/             # attendance/index, attendance/create
```

## 📜 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
