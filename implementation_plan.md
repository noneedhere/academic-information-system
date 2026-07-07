# SIAKAD — Full Implementation Plan

This plan implements the complete SIAKAD (Academic Information System) as specified in the [PRD](file:///C:/Users/zidane/.gemini/antigravity/brain/121e7ab1-7731-410a-b911-3def44620dba/implementation_plan.md) from the previous conversation.

## Current State

The project is a **fresh Laravel 13.x scaffold** with:
- Tailwind CSS v4 via `@tailwindcss/vite`
- SQLite database (dev)
- Default User model (no roles, no extra fields)
- No controllers, no views (except `welcome.blade.php`), no middleware, no seeders

Everything needs to be built from scratch.

---

## Proposed Changes

The implementation is organized into **7 phases**, ordered by dependency (foundations first).

---

### Phase 1: Foundation — Database, Models, Enums, Middleware

This phase establishes all database tables, Eloquent models, enums, and the role-checking middleware.

---

#### [MODIFY] [app.php](file:///c:/laragon/www/Siakad/config/app.php)
- Set timezone to `Asia/Jakarta`

#### [NEW] `app/Enums/AttendanceStatus.php`
- Backed string enum: `present`, `sick`, `permission`, `absent`

#### [NEW] `app/Enums/BillStatus.php`
- Backed string enum: `paid`, `unpaid`

#### [NEW] `database/migrations/2026_07_06_000001_create_roles_table.php`
- Creates `roles` table: `id`, `name`, `slug` (unique), `timestamps`

#### [NEW] `database/migrations/2026_07_06_000002_add_fields_to_users_table.php`
- Adds to `users`: `role_id` (FK → roles, default 3), `username` (unique), `phone`, `address`, `profile_photo_path`, `deleted_at` (soft delete)

#### [NEW] `database/migrations/2026_07_06_000003_create_attendances_table.php`
- Creates `attendances`: `id`, `student_id` (FK), `teacher_id` (FK), `date`, `time`, `status` (enum), `notes`, `timestamps`
- Unique composite index on (`student_id`, `date`)

#### [NEW] `database/migrations/2026_07_06_000004_create_bills_table.php`
- Creates `bills`: `id`, `student_id` (FK), `title`, `description`, `amount` (decimal 12,2), `due_date`, `status` (enum, default 'unpaid'), `deleted_at`, `timestamps`

#### [NEW] `app/Models/Role.php`
- Constants: `HEAD_ADMIN`, `TEACHER`, `STUDENT`
- Relationship: `users(): HasMany`

#### [MODIFY] [User.php](file:///c:/laragon/www/Siakad/app/Models/User.php)
- Add `SoftDeletes` trait
- Update `$fillable` to include `role_id`, `username`, `phone`, `address`, `profile_photo_path`
- Add relationships: `role()`, `attendances()`, `recordedAttendances()`, `bills()`
- Add helpers: `hasRole()`, `isAdmin()`, `isTeacher()`, `isStudent()`
- Add `profilePhotoUrl` accessor

#### [NEW] `app/Models/Attendance.php`
- Fillable, casts (`date`, `status` → enum)
- Relationships: `student()`, `teacher()`

#### [NEW] `app/Models/Bill.php`
- SoftDeletes, fillable, casts (`amount`, `due_date`, `status` → enum)
- Relationship: `student()`
- Accessor: `isOverdue`

#### [NEW] `app/Http/Middleware/CheckRole.php`
- Accepts comma-separated role slugs, checks `Auth::user()->role->slug`
- Aborts 403 if not in allowed list

#### [MODIFY] [app.php](file:///c:/laragon/www/Siakad/bootstrap/app.php)
- Register `CheckRole` middleware as alias `role`
- Configure redirect for unauthenticated guests to `/login`

---

### Phase 2: Seeders & Auth

#### [NEW] `database/seeders/RoleSeeder.php`
- Seeds 3 roles: Head Admin, Teacher, Student

#### [NEW] `database/seeders/UserSeeder.php`
- Seeds 3 default accounts: admin@siakad.test, teacher@siakad.test, student@siakad.test

#### [MODIFY] [DatabaseSeeder.php](file:///c:/laragon/www/Siakad/database/seeders/DatabaseSeeder.php)
- Calls `RoleSeeder`, then `UserSeeder`

#### [NEW] `app/Http/Requests/Auth/LoginRequest.php`
- Validates email + password, rate limiting (5 attempts/min)

#### [NEW] `app/Http/Requests/Auth/RegisterRequest.php`
- Validates name, username, email, password + confirmation

#### [NEW] `app/Http/Controllers/Auth/LoginController.php`
- `showLoginForm()`, `login()`, `logout()`

#### [NEW] `app/Http/Controllers/Auth/RegisterController.php`
- `showRegistrationForm()`, `register()` — assigns student role by default

---

### Phase 3: Core Controllers, Form Requests, Services, Policies

#### [NEW] `app/Http/Controllers/DashboardController.php`
- Renders role-specific dashboard partials with data from `DashboardService`

#### [NEW] `app/Http/Controllers/ProfileController.php`
- `show()`, `edit()`, `update()` — handles photo upload

#### [NEW] `app/Http/Controllers/SettingsController.php`
- `edit()`, `updatePassword()` — verifies current password, invalidates other sessions

#### [NEW] `app/Http/Controllers/AttendanceController.php`
- `index()` — teacher's own records with filters
- `create()` — bulk attendance form
- `store()` — saves attendance via service

#### [NEW] `app/Http/Controllers/BillController.php`
- `index()` — student's own bills

#### [NEW] `app/Http/Controllers/Admin/UserController.php`
- Full CRUD for users (Head Admin only)

#### [NEW] `app/Http/Controllers/Admin/AttendanceController.php`
- `index()` — view all attendance with filters (Head Admin only)

#### [NEW] `app/Http/Controllers/Admin/BillController.php`
- Full CRUD + `toggleStatus()` for bills (Head Admin only)

#### [NEW] Form Requests:
- `app/Http/Requests/ProfileUpdateRequest.php`
- `app/Http/Requests/PasswordUpdateRequest.php`
- `app/Http/Requests/StoreAttendanceRequest.php`
- `app/Http/Requests/Admin/StoreUserRequest.php`
- `app/Http/Requests/Admin/UpdateUserRequest.php`
- `app/Http/Requests/Admin/StoreBillRequest.php`
- `app/Http/Requests/Admin/UpdateBillRequest.php`

#### [NEW] Services:
- `app/Services/DashboardService.php` — aggregates dashboard data per role
- `app/Services/AttendanceService.php` — handles attendance creation, duplicate check, percentage calc
- `app/Services/BillService.php` — CRUD, toggle status, overdue detection

#### [NEW] Policies:
- `app/Policies/UserPolicy.php` — Head Admin only; self-delete prevention
- `app/Policies/AttendancePolicy.php` — Teacher (own), Head Admin (all)
- `app/Policies/BillPolicy.php` — Head Admin CRUD, Student view own

---

### Phase 4: Routes

#### [MODIFY] [web.php](file:///c:/laragon/www/Siakad/routes/web.php)
- All routes per PRD §11: guest, auth, profile, settings, attendance, bills, admin groups
- Proper middleware: `auth`, `role:head_admin`, `role:teacher`, `role:student`

---

### Phase 5: Blade Layouts & Components

#### [MODIFY] [app.css](file:///c:/laragon/www/Siakad/resources/css/app.css)
- Add design system tokens (colours, fonts) per PRD §13.1
- Add custom component styles, animations, transitions

#### [MODIFY] [vite.config.js](file:///c:/laragon/www/Siakad/vite.config.js)
- Add Inter font (via Bunny Fonts) alongside Instrument Sans

#### [MODIFY] [app.js](file:///c:/laragon/www/Siakad/resources/js/app.js)
- Add real-time clock, flash message auto-dismiss, mobile sidebar toggle, photo preview, form loading states

#### [NEW] Layouts:
- `resources/views/layouts/app.blade.php` — sidebar + navbar + main content area
- `resources/views/layouts/guest.blade.php` — centred card on gradient background

#### [NEW] Blade Components:
- `resources/views/components/sidebar.blade.php`
- `resources/views/components/navbar.blade.php`
- `resources/views/components/alert.blade.php`
- `resources/views/components/card.blade.php`
- `resources/views/components/modal.blade.php`

---

### Phase 6: Blade Views (All Pages)

#### Auth Views:
- `resources/views/auth/login.blade.php`
- `resources/views/auth/register.blade.php`

#### Dashboard Views:
- `resources/views/dashboard/index.blade.php`
- `resources/views/dashboard/partials/_student.blade.php`
- `resources/views/dashboard/partials/_teacher.blade.php`
- `resources/views/dashboard/partials/_admin.blade.php`

#### Profile & Settings Views:
- `resources/views/profile/show.blade.php`
- `resources/views/profile/edit.blade.php`
- `resources/views/settings/edit.blade.php`

#### Attendance Views:
- `resources/views/attendance/index.blade.php`
- `resources/views/attendance/create.blade.php`

#### Student Bills View:
- `resources/views/bills/index.blade.php`

#### Admin Views:
- `resources/views/admin/users/index.blade.php`
- `resources/views/admin/users/create.blade.php`
- `resources/views/admin/users/edit.blade.php`
- `resources/views/admin/attendance/index.blade.php`
- `resources/views/admin/bills/index.blade.php`
- `resources/views/admin/bills/create.blade.php`
- `resources/views/admin/bills/edit.blade.php`

#### Error Views:
- `resources/views/errors/401.blade.php`
- `resources/views/errors/403.blade.php`
- `resources/views/errors/404.blade.php`
- `resources/views/errors/500.blade.php`

---

### Phase 7: Environment & Configuration

#### [MODIFY] [.env](file:///c:/laragon/www/Siakad/.env)
- Set `APP_NAME=SIAKAD`, `APP_TIMEZONE=Asia/Jakarta`
- Database remains SQLite for development

#### Blade Directive `@role`
- Register in `AppServiceProvider` for conditional rendering in templates

#### Storage Link
- Run `php artisan storage:link` for profile photo serving

---

## UI/UX Design Approach

The UI follows a **modern indigo-themed design** per PRD §13:
- **Sidebar**: Dark indigo (Indigo-900) with icon navigation, user avatar at bottom
- **Guest pages**: Centred card on indigo→purple gradient
- **Cards**: White with `shadow-sm`, `rounded-lg`
- **Status badges**: Colour-coded (green/yellow/blue/red)
- **Responsive**: Sidebar hidden on mobile (hamburger toggle), collapsed on tablet, full on desktop
- **Flash messages**: Auto-dismissing, colour-coded alerts
- **Real-time clock**: JavaScript-driven digital clock on dashboard
- **Micro-animations**: Hover effects, transitions on cards and buttons

---

## Verification Plan

### Automated
```bash
# Run migrations
php artisan migrate:fresh --seed

# Run the development server
composer dev
```

### Manual Verification
1. **Auth flow**: Register → Login → Dashboard redirect → Logout
2. **RBAC**: Login as each role, verify correct dashboard and menu visibility
3. **Attendance**: Teacher records attendance, student sees it on dashboard
4. **Bills**: Admin creates bill, student views it
5. **Profile**: Edit profile, upload photo
6. **Settings**: Change password
7. **Responsive**: Check mobile, tablet, desktop layouts

> [!IMPORTANT]
> This is a **very large implementation** (~50+ new files, ~5000+ lines of code). The full build will require multiple phases of execution. Shall I proceed?

> [!NOTE]
> The PRD specifies MySQL for production, but the current `.env` uses SQLite. I will keep SQLite for development as specified in the PRD assumptions (A-10). The migrations will be compatible with both.
