# SIAKAD Implementation Tasks

## Phase 1: Foundation — Database, Models, Enums, Middleware
- [x] Update `config/app.php` timezone → `Asia/Jakarta`
- [x] Create `app/Enums/AttendanceStatus.php`
- [x] Create `app/Enums/BillStatus.php`
- [x] Create migration: `create_roles_table`
- [x] Create migration: `add_fields_to_users_table`
- [x] Create migration: `create_attendances_table`
- [x] Create migration: `create_bills_table`
- [x] Create `app/Models/Role.php`
- [x] Update `app/Models/User.php`
- [x] Create `app/Models/Attendance.php`
- [x] Create `app/Models/Bill.php`
- [x] Create `app/Http/Middleware/CheckRole.php`
- [x] Update `bootstrap/app.php` (middleware alias + guest redirect)

## Phase 2: Seeders & Auth
- [x] Create `database/seeders/RoleSeeder.php`
- [x] Create `database/seeders/UserSeeder.php`
- [x] Update `database/seeders/DatabaseSeeder.php`
- [x] Create `app/Http/Requests/Auth/LoginRequest.php`
- [x] Create `app/Http/Requests/Auth/RegisterRequest.php`
- [x] Create `app/Http/Controllers/Auth/LoginController.php`
- [x] Create `app/Http/Controllers/Auth/RegisterController.php`

## Phase 3: Core Controllers, Form Requests, Services, Policies
- [x] Create `app/Services/DashboardService.php`
- [x] Create `app/Services/AttendanceService.php`
- [x] Create `app/Services/BillService.php`
- [x] Create `app/Http/Controllers/DashboardController.php`
- [x] Create `app/Http/Controllers/ProfileController.php`
- [x] Create `app/Http/Controllers/SettingsController.php`
- [x] Create `app/Http/Controllers/AttendanceController.php`
- [x] Create `app/Http/Controllers/BillController.php`
- [x] Create `app/Http/Controllers/Admin/UserController.php`
- [x] Create `app/Http/Controllers/Admin/AttendanceController.php`
- [x] Create `app/Http/Controllers/Admin/BillController.php`
- [x] Create `app/Http/Requests/ProfileUpdateRequest.php`
- [x] Create `app/Http/Requests/PasswordUpdateRequest.php`
- [x] Create `app/Http/Requests/StoreAttendanceRequest.php`
- [x] Create `app/Http/Requests/Admin/StoreUserRequest.php`
- [x] Create `app/Http/Requests/Admin/UpdateUserRequest.php`
- [x] Create `app/Http/Requests/Admin/StoreBillRequest.php`
- [x] Create `app/Http/Requests/Admin/UpdateBillRequest.php`
- [x] Create `app/Policies/UserPolicy.php`
- [x] Create `app/Policies/AttendancePolicy.php`
- [x] Create `app/Policies/BillPolicy.php`

## Phase 4: Routes
- [x] Update `routes/web.php`

## Phase 5: Blade Layouts & Components
- [ ] Update `resources/css/app.css`
- [ ] Update `resources/js/app.js`
- [ ] Update `vite.config.js`
- [ ] Create `resources/views/layouts/app.blade.php`
- [ ] Create `resources/views/layouts/guest.blade.php`
- [ ] Create `resources/views/components/sidebar.blade.php`
- [ ] Create `resources/views/components/navbar.blade.php`
- [ ] Create `resources/views/components/alert.blade.php`
- [ ] Create `resources/views/components/card.blade.php`
- [ ] Create `resources/views/components/modal.blade.php`
- [x] Register `@role` Blade directive in `AppServiceProvider`

## Phase 6: Blade Views
- [ ] Create `resources/views/auth/login.blade.php`
- [ ] Create `resources/views/auth/register.blade.php`
- [ ] Create `resources/views/dashboard/index.blade.php`
- [ ] Create `resources/views/dashboard/partials/_student.blade.php`
- [ ] Create `resources/views/dashboard/partials/_teacher.blade.php`
- [ ] Create `resources/views/dashboard/partials/_admin.blade.php`
- [ ] Create `resources/views/profile/show.blade.php`
- [ ] Create `resources/views/profile/edit.blade.php`
- [ ] Create `resources/views/settings/edit.blade.php`
- [ ] Create `resources/views/attendance/index.blade.php`
- [ ] Create `resources/views/attendance/create.blade.php`
- [ ] Create `resources/views/bills/index.blade.php`
- [ ] Create `resources/views/admin/users/index.blade.php`
- [ ] Create `resources/views/admin/users/create.blade.php`
- [ ] Create `resources/views/admin/users/edit.blade.php`
- [ ] Create `resources/views/admin/attendance/index.blade.php`
- [ ] Create `resources/views/admin/bills/index.blade.php`
- [ ] Create `resources/views/admin/bills/create.blade.php`
- [ ] Create `resources/views/admin/bills/edit.blade.php`
- [ ] Create `resources/views/errors/401.blade.php`
- [ ] Create `resources/views/errors/403.blade.php`
- [ ] Create `resources/views/errors/404.blade.php`
- [ ] Create `resources/views/errors/500.blade.php`

## Phase 7: Environment & Verification
- [x] Update `.env` (APP_NAME=SIAKAD)
- [x] Upgrade PHP requirement to `^8.4` in `composer.json`
- [ ] Run `php artisan migrate:fresh --seed`
- [ ] Run `php artisan storage:link`
- [ ] Manual smoke test
