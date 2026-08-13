<p align="center">
  <h1 align="center">🎓 Academic Information System</h1>
  <p align="center">
    <strong>SIAKAD</strong> — A modern, role-based academic management platform<br>
    built with Laravel 13 and Tailwind CSS 4
  </p>
  <p align="center">
    <img src="https://img.shields.io/badge/PHP-8.4+-8892BF?style=flat-square&logo=php&logoColor=white" alt="PHP 8.4+">
    <img src="https://img.shields.io/badge/Laravel-13-FF2D20?style=flat-square&logo=laravel&logoColor=white" alt="Laravel 13">
    <img src="https://img.shields.io/badge/Tailwind_CSS-4-38B2AC?style=flat-square&logo=tailwindcss&logoColor=white" alt="Tailwind CSS 4">
    <img src="https://img.shields.io/badge/Vite-8-646CFF?style=flat-square&logo=vite&logoColor=white" alt="Vite 8">
    <img src="https://img.shields.io/badge/SQLite-3-003B57?style=flat-square&logo=sqlite&logoColor=white" alt="SQLite">
  </p>
</p>

---

## 📋 Table of Contents

- [Project Overview](#-project-overview)
- [Key Features](#-key-features)
- [Technology Stack](#-technology-stack)
- [Project Structure](#-project-structure)
- [Prerequisites](#-prerequisites)
- [Installation](#-installation)
- [Usage Guide](#-usage-guide)
- [User Roles & Permissions](#-user-roles--permissions)
- [Environment Variables](#-environment-variables)
- [Database](#-database)
- [Scripts & Commands](#-scripts--commands)
- [Contributing](#-contributing)
- [License](#-license)
- [Contact](#-contact)

---

## 🔍 Project Overview

**SIAKAD** (Sistem Informasi Akademik) is a web-based Academic Information System designed to streamline the management of student attendance tracking, billing/fee management, and user administration within an educational institution.

### Problem Statement

Educational institutions often struggle with manual, fragmented processes for tracking student attendance, managing tuition bills, and coordinating between administrators, teachers, and students. SIAKAD provides a centralized platform that digitizes these workflows.

### Target Users

| Role | Description |
|------|-------------|
| **Head Admin** | Institution administrators who manage all users, bills, and oversee attendance records |
| **Teacher** | Educators who record and manage student attendance on a daily basis |
| **Student** | Learners who view their own attendance history and billing information |

### Architecture

SIAKAD follows a traditional **MVC (Model-View-Controller)** architecture powered by Laravel, with server-side rendered Blade templates. The application uses a **service layer pattern** for business logic encapsulation and **policy-based authorization** for fine-grained access control. The frontend is styled with Tailwind CSS 4 and compiled via Vite 8.

---

## ✨ Key Features

### 🔐 Authentication & Security
- Email/password login with session-based authentication
- Login rate limiting (max 5 attempts per email/IP combination)
- Session regeneration on login, full invalidation on logout
- Password hashing with bcrypt (12 rounds)
- CSRF protection on all forms
- Admin-only account creation (self-registration is disabled by default)

### 📊 Role-Based Dashboards
Each role sees a tailored dashboard upon login:

- **Head Admin** — User count breakdown (admins, teachers, students), today's attendance count, paid/unpaid bill summary
- **Teacher** — Today's submission count, 5 most recent attendance records
- **Student** — Today's attendance status, overall attendance percentage, monthly attendance summary, interactive calendar view for the current month

### 👥 User Management *(Head Admin)*
- Full CRUD for all user accounts (create, list, edit, soft-delete)
- Role assignment (Head Admin, Teacher, Student)
- Search users by name, username, or email
- Filter users by role
- Paginated user listing (15 per page)
- Self-deletion prevention safeguard
- Foreign-key constraint checks before deletion

### 📝 Attendance Management *(Teacher)*
- Bulk attendance recording for multiple students on a single date
- Attendance statuses: `Present`, `Sick`, `Permission`, `Absent`
- Edit previously submitted records (status and notes only)
- Duplicate attendance prevention (unique student + date constraint)
- Filter records by date range, status, or student name
- Paginated record listing (15 per page)

### 📝 Attendance Oversight *(Head Admin)*
- Read-only view of all attendance records across the system
- Advanced filtering by date range, status, student name, or teacher
- Paginated listing (20 per page)

### 📖 My Attendance *(Student)*
- View personal attendance history with summary statistics
- Total records, present count, absent count, and attendance percentage
- Filter by date range and status
- Paginated listing (15 per page)

### 💰 Billing Management *(Head Admin)*
- Full CRUD for student bills (create, list, edit, soft-delete)
- Bill fields: title, description, amount (IDR), due date, status
- Toggle payment status between `Paid` and `Unpaid`
- Filter by status, student, or search by title
- Paginated listing (20 per page)

### 💳 My Bills *(Student)*
- View personal bills with summary statistics
- Total bills count, total unpaid amount, total paid amount
- Filter by status or search by title
- Overdue detection (unpaid bills past due date)
- Currency formatted as IDR (Indonesian Rupiah)

### 👤 Profile Management *(All Roles)*
- View profile details (name, username, email, phone, address, photo)
- Edit profile information including photo upload
- Profile photo stored on public disk with old photo cleanup
- Default avatar generation via UI Avatars when no photo is uploaded

### ⚙️ Settings *(All Roles)*
- Change password with current password verification
- Automatic logout of other active sessions upon password change

### 🎨 UI/UX
- Responsive sidebar navigation with mobile overlay
- Custom Blade component library (cards, alerts, modals, navbar)
- Flash message notifications with auto-dismiss animation
- Form loading states with spinner indicators
- Confirm-before-delete dialogs
- Real-time clock display on the dashboard
- Custom error pages (403, 404, 500)
- Custom scrollbar styling

---

## 🛠 Technology Stack

| Category | Technology | Version | Purpose |
|----------|-----------|---------|---------|
| **Language** | PHP | ^8.4 | Server-side runtime |
| **Framework** | Laravel | ^13.8 | MVC web framework |
| **Database** | SQLite | — | Lightweight relational database (default) |
| **ORM** | Eloquent | — | Object-relational mapping (bundled with Laravel) |
| **Templating** | Blade | — | Server-side view engine (bundled with Laravel) |
| **CSS Framework** | Tailwind CSS | ^4.0 | Utility-first CSS framework |
| **Build Tool** | Vite | ^8.0 | Frontend asset bundling and HMR |
| **Vite Plugin** | laravel-vite-plugin | ^3.1 | Laravel ↔ Vite integration |
| **Fonts** | Bunny Fonts | — | Privacy-friendly font delivery (Inter, Instrument Sans) |
| **Auth** | Laravel built-in | — | Session-based authentication with rate limiting |
| **Authorization** | Policies | — | Model-based policy authorization |
| **Testing** | PHPUnit | ^12.5 | Unit and feature testing |
| **Code Style** | Laravel Pint | ^1.27 | PHP code formatter (PSR-12) |
| **Dev Tools** | Laravel Pail | ^1.2 | Real-time log viewer |
| **Dev Tools** | Laravel Pao | ^1.0 | Development utilities |
| **Mocking** | Mockery | ^1.6 | Test double framework |
| **Fake Data** | FakerPHP | ^1.23 | Test data generation |
| **Process** | Concurrently | ^9.0 | Parallel dev process runner |
| **Package Manager** | Composer | — | PHP dependency management |
| **Package Manager** | npm | — | JavaScript dependency management |

---

## 📁 Project Structure

```
siakad/
├── app/
│   ├── Enums/                  # PHP 8.1+ backed enums
│   │   ├── AttendanceStatus    #   Present, Sick, Permission, Absent
│   │   └── BillStatus          #   Paid, Unpaid
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/          # Head Admin controllers (User, Bill, Attendance)
│   │   │   ├── Auth/           # Login & Register controllers
│   │   │   ├── Student/        # Student-specific controllers
│   │   │   ├── AttendanceController    # Teacher attendance management
│   │   │   ├── BillController          # Student bill viewing
│   │   │   ├── DashboardController     # Role-based dashboard
│   │   │   ├── ProfileController       # Profile view/edit
│   │   │   └── SettingsController      # Password change
│   │   ├── Middleware/
│   │   │   └── CheckRole       # Role-based route middleware
│   │   └── Requests/           # Form request validation classes
│   │       ├── Admin/          #   Admin-specific (StoreUser, UpdateUser, StoreBill, UpdateBill)
│   │       └── Auth/           #   Auth-specific (Login, Register)
│   ├── Models/                 # Eloquent models (User, Role, Attendance, Bill)
│   ├── Policies/               # Authorization policies (User, Attendance, Bill)
│   ├── Providers/              # Service providers (AppServiceProvider with @role directive)
│   └── Services/               # Business logic layer
│       ├── AttendanceService   #   Attendance CRUD + statistics
│       ├── BillService         #   Bill status toggling
│       └── DashboardService    #   Role-specific dashboard data
├── database/
│   ├── factories/              # Model factories (UserFactory)
│   ├── migrations/             # Database schema migrations
│   └── seeders/                # Data seeders (Role, User, Attendance, Bill)
├── resources/
│   ├── css/app.css             # Tailwind CSS entry point with custom design system
│   ├── js/app.js               # Vanilla JS (sidebar, modals, clock, flash messages)
│   └── views/
│       ├── admin/              # Admin views (users/, bills/, attendance/)
│       ├── attendance/         # Teacher attendance views (index, create, edit)
│       ├── auth/               # Login & register forms
│       ├── bills/              # Student bill views
│       ├── components/         # Reusable Blade components (layouts, sidebar, navbar, etc.)
│       ├── dashboard/          # Dashboard with role-specific partials
│       ├── errors/             # Custom error pages (403, 404, 500)
│       ├── profile/            # Profile show & edit
│       ├── settings/           # Password change form
│       └── student/            # Student attendance views
├── routes/
│   └── web.php                 # All application routes (guest, auth, role-based)
├── config/                     # Laravel configuration files
├── public/                     # Public assets and entry point
├── tests/                      # PHPUnit tests (Feature & Unit)
├── composer.json               # PHP dependencies
├── package.json                # JS dependencies
├── vite.config.js              # Vite + Tailwind + Laravel plugin config
└── .env.example                # Environment variable template
```

---

## 📋 Prerequisites

Before installing SIAKAD, ensure you have the following installed:

| Software | Minimum Version | Purpose |
|----------|----------------|---------|
| **PHP** | 8.4+ | Runtime for Laravel 13 |
| **Composer** | 2.x | PHP dependency management |
| **Node.js** | 18+ | JavaScript tooling and Vite |
| **npm** | 9+ | JS package management |
| **Git** | 2.x | Version control |

> **Note:** SQLite is used by default and comes bundled with PHP. No external database server is required unless you configure MySQL/PostgreSQL.

---

## 🚀 Installation

### 1. Clone the Repository

```bash
git clone <repository-url>
cd siakad
```

### 2. Quick Setup (Recommended)

The project includes a Composer `setup` script that automates the full installation:

```bash
composer setup
```

This single command will:
- Install PHP dependencies (`composer install`)
- Copy `.env.example` to `.env` (if not already present)
- Generate the application key
- Run database migrations
- Install JavaScript dependencies
- Build frontend assets

### 3. Manual Setup (Alternative)

If you prefer to run each step individually:

```bash
# Install PHP dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Run database migrations
php artisan migrate

# Seed the database with demo data
php artisan db:seed

# Install JS dependencies
npm install

# Build frontend assets
npm run build
```

### 4. Storage Link

Create a symbolic link for public file access (profile photos):

```bash
php artisan storage:link
```

### 5. Start Development Server

```bash
composer dev
```

This concurrently starts:
- **Laravel dev server** — `php artisan serve`
- **Queue worker** — `php artisan queue:listen`
- **Log viewer** — `php artisan pail`
- **Vite HMR** — `npm run dev`

Alternatively, start services individually:

```bash
# Terminal 1: Laravel server
php artisan serve

# Terminal 2: Vite dev server (for HMR)
npm run dev
```

---

## 📖 Usage Guide

### Default Demo Accounts

After seeding (`php artisan db:seed`), the following accounts are available:

| Role | Email | Password |
|------|-------|----------|
| Head Admin | `admin@siakad.test` | `password` |
| Teacher | `teacher@siakad.test` | `password` |
| Student | `student@siakad.test` | `password` |

> ⚠️ **Important:** Change these passwords immediately in any non-development environment.

### Workflows

#### 🔑 Authentication
1. Navigate to the application URL (defaults to `http://localhost:8000`)
2. Enter your email and password on the login page
3. Upon successful login, you are redirected to your role-specific dashboard

#### 📊 Dashboard *(All Roles)*
1. After login, view your personalized dashboard
2. **Students** see today's attendance, attendance percentage, and a monthly calendar
3. **Teachers** see today's submission count and recent records
4. **Head Admins** see system-wide statistics (user counts, attendance, billing)

#### 📝 Record Attendance *(Teacher)*
1. Navigate to **Attendance → Create** from the sidebar
2. Select the date for the attendance record
3. For each student, choose a status: Present, Sick, Permission, or Absent
4. Optionally add notes for individual students
5. Submit the form — records are stored in a single database transaction
6. View and filter all your submitted records on the Attendance index page

#### 📖 View My Attendance *(Student)*
1. Navigate to **My Attendance** from the sidebar
2. View summary stats at the top (total records, present, absent, percentage)
3. Use date range and status filters to narrow results
4. Paginate through your attendance history

#### 💰 Manage Bills *(Head Admin)*
1. Navigate to **Admin → Bills** from the sidebar
2. Create a new bill: assign a student, set title, amount, due date, and description
3. Toggle bill status between Paid and Unpaid using the toggle action
4. Edit or soft-delete bills as needed
5. Filter by status, student, or search by title

#### 💳 View My Bills *(Student)*
1. Navigate to **Bills** from the sidebar
2. View summary: total bills, unpaid amount, paid amount
3. Filter by status or search by bill title
4. Overdue bills (past due date and still unpaid) are highlighted

#### 👥 Manage Users *(Head Admin)*
1. Navigate to **Admin → Users** from the sidebar
2. Create new users with a specific role (Head Admin, Teacher, or Student)
3. Search by name, username, or email
4. Filter by role
5. Edit user details or reset passwords
6. Soft-delete users (prevented if they have related attendance or bill records)

#### 👤 Edit Profile *(All Roles)*
1. Navigate to **Profile** from the sidebar or navbar
2. Click **Edit Profile**
3. Update name, username, email, phone, address, or profile photo
4. Submit changes

#### 🔒 Change Password *(All Roles)*
1. Navigate to **Settings** from the sidebar
2. Enter your current password and the new password
3. Submit — all other sessions are automatically invalidated

---

## 🔑 User Roles & Permissions

| Feature | Head Admin | Teacher | Student |
|---------|:----------:|:-------:|:-------:|
| View dashboard | ✅ | ✅ | ✅ |
| Manage users (CRUD) | ✅ | ❌ | ❌ |
| Create attendance records | ❌ | ✅ | ❌ |
| Edit own attendance records | ❌ | ✅ | ❌ |
| View all attendance (read-only) | ✅ | ❌ | ❌ |
| View own attendance | ❌ | ✅ | ✅ |
| Manage bills (CRUD) | ✅ | ❌ | ❌ |
| Toggle bill payment status | ✅ | ❌ | ❌ |
| View own bills | ❌ | ❌ | ✅ |
| Edit profile | ✅ | ✅ | ✅ |
| Change password | ✅ | ✅ | ✅ |

---

## 🔧 Environment Variables

The following variables are available in `.env.example`:

| Variable | Description | Default |
|----------|-------------|---------|
| `APP_NAME` | Application display name | `Laravel` |
| `APP_ENV` | Application environment | `local` |
| `APP_KEY` | Encryption key (auto-generated) | *(empty)* |
| `APP_DEBUG` | Enable debug mode | `true` |
| `APP_URL` | Base application URL | `http://localhost` |
| `APP_LOCALE` | Default locale | `en` |
| `APP_FALLBACK_LOCALE` | Fallback locale | `en` |
| `APP_FAKER_LOCALE` | Faker data locale | `en_US` |
| `APP_MAINTENANCE_DRIVER` | Maintenance mode driver | `file` |
| `BCRYPT_ROUNDS` | Password hashing rounds | `12` |
| `LOG_CHANNEL` | Logging channel | `stack` |
| `LOG_STACK` | Log stack driver | `single` |
| `LOG_DEPRECATIONS_CHANNEL` | Deprecation log channel | `null` |
| `LOG_LEVEL` | Minimum log level | `debug` |
| `DB_CONNECTION` | Database driver | `sqlite` |
| `DB_HOST` | Database host *(commented)* | `127.0.0.1` |
| `DB_PORT` | Database port *(commented)* | `3306` |
| `DB_DATABASE` | Database name *(commented)* | `laravel` |
| `DB_USERNAME` | Database username *(commented)* | `root` |
| `DB_PASSWORD` | Database password *(commented)* | *(empty)* |
| `SESSION_DRIVER` | Session storage driver | `database` |
| `SESSION_LIFETIME` | Session duration (minutes) | `120` |
| `SESSION_ENCRYPT` | Encrypt session data | `false` |
| `SESSION_PATH` | Session cookie path | `/` |
| `SESSION_DOMAIN` | Session cookie domain | `null` |
| `BROADCAST_CONNECTION` | Broadcast driver | `log` |
| `FILESYSTEM_DISK` | Default filesystem disk | `local` |
| `QUEUE_CONNECTION` | Queue driver | `database` |
| `CACHE_STORE` | Cache driver | `database` |
| `MAIL_MAILER` | Mail driver | `log` |
| `MAIL_HOST` | SMTP host | `127.0.0.1` |
| `MAIL_PORT` | SMTP port | `2525` |
| `MAIL_FROM_ADDRESS` | Sender email address | `hello@example.com` |
| `MAIL_FROM_NAME` | Sender display name | `${APP_NAME}` |
| `VITE_APP_NAME` | App name exposed to Vite | `${APP_NAME}` |

---

## 🗄 Database

### Technology

SIAKAD uses **SQLite** by default (`database/database.sqlite`). To switch to MySQL or PostgreSQL, update the `DB_*` variables in `.env`.

### Schema Overview

```
┌──────────────┐      ┌──────────────┐
│    roles     │      │    users     │
├──────────────┤      ├──────────────┤
│ id           │◄────┐│ id           │
│ name         │     ││ role_id (FK) │──┘
│ slug (unique)│     ││ name         │
│ timestamps   │     ││ username     │
└──────────────┘     ││ email        │
                     ││ phone        │
                     ││ address      │
                     ││ profile_photo│
                     ││ password     │
                     ││ soft_deletes │
                     ││ timestamps   │
                     │└──────────────┘
                     │        │
        ┌────────────┘        └────────────┐
        │                                  │
┌───────┴──────┐                  ┌────────┴─────┐
│ attendances  │                  │    bills     │
├──────────────┤                  ├──────────────┤
│ id           │                  │ id           │
│ student_id   │                  │ student_id   │
│ teacher_id   │                  │ title        │
│ date         │                  │ description  │
│ time         │                  │ amount       │
│ status (enum)│                  │ due_date     │
│ notes        │                  │ status (enum)│
│ timestamps   │                  │ soft_deletes │
│              │                  │ timestamps   │
│ unique:      │                  └──────────────┘
│ [student,date│
└──────────────┘
```

### Roles (Seeded)

| ID | Name | Slug |
|----|------|------|
| 1 | Head Admin | `head_admin` |
| 2 | Teacher | `teacher` |
| 3 | Student | `student` |

### Migrations

Run all migrations:

```bash
php artisan migrate
```

### Seeders

Seed the database with demo data:

```bash
php artisan db:seed
```

The seeder runs in the following order:
1. **RoleSeeder** — Creates the 3 system roles
2. **UserSeeder** — Creates one demo account per role
3. **AttendanceSeeder** — Generates sample attendance records
4. **BillSeeder** — Generates sample billing records

To reset and re-seed:

```bash
php artisan migrate:fresh --seed
```

---

## 📜 Scripts & Commands

### Composer Scripts

| Script | Command | Description |
|--------|---------|-------------|
| **setup** | `composer setup` | Full automated installation (install deps, copy .env, generate key, migrate, build) |
| **dev** | `composer dev` | Start all development services concurrently (server, queue, logs, Vite) |
| **test** | `composer test` | Clear config cache and run PHPUnit test suite |

### npm Scripts

| Script | Command | Description |
|--------|---------|-------------|
| **dev** | `npm run dev` | Start Vite development server with HMR |
| **build** | `npm run build` | Build production-optimized frontend assets |

### Artisan Commands

| Command | Description |
|---------|-------------|
| `php artisan serve` | Start the Laravel development server |
| `php artisan migrate` | Run database migrations |
| `php artisan migrate:fresh --seed` | Reset database and seed with demo data |
| `php artisan db:seed` | Seed the database |
| `php artisan storage:link` | Create public storage symlink |
| `php artisan queue:listen` | Start the queue worker |
| `php artisan pail` | Open the real-time log viewer |
| `php artisan test` | Run the test suite |
| `php artisan pint` | Run code style fixer (PSR-12) |

---

## 🤝 Contributing

Contributions are welcome! To contribute:

1. **Fork** the repository
2. **Create** a feature branch
   ```bash
   git checkout -b feature/your-feature-name
   ```
3. **Commit** your changes with clear, descriptive messages
   ```bash
   git commit -m "feat: add your feature description"
   ```
4. **Push** to your fork
   ```bash
   git push origin feature/your-feature-name
   ```
5. **Open** a Pull Request against the `main` branch

### Guidelines

- Follow PSR-12 coding standards (run `./vendor/bin/pint` before committing)
- Write tests for new features when applicable
- Keep commits atomic and well-described
- Update documentation if your changes affect user-facing features

---

## 📄 License

This project is licensed under the **MIT License** — see the [composer.json](composer.json) `license` field for reference.

---

## 📬 Contact

| Channel | Link |
|---------|------|
| **LinkedIn** | [Zidane Rosyidi](https://www.linkedin.com/in/zidane-rosyidi-6b438333b/) |
| **Email** | [zidanerosyidi@gmail.com](mailto:zidanerosyidi@gmail.com) |

---

<p align="center">
  Built with ❤️ using Laravel & Tailwind CSS
</p>
