<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role_id',
        'name',
        'username',
        'email',
        'phone',
        'address',
        'profile_photo_path',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // =========================================================================
    // Relationships
    // =========================================================================

    /**
     * Get the role this user belongs to.
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Get the attendance records for this user (as a student).
     */
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class, 'student_id');
    }

    /**
     * Get the attendance records submitted by this user (as a teacher).
     */
    public function recordedAttendances(): HasMany
    {
        return $this->hasMany(Attendance::class, 'teacher_id');
    }

    /**
     * Get the bills for this user (as a student).
     */
    public function bills(): HasMany
    {
        return $this->hasMany(Bill::class, 'student_id');
    }

    // =========================================================================
    // Role Helpers
    // =========================================================================

    /**
     * Check if the user has the given role slug.
     */
    public function hasRole(string $slug): bool
    {
        return $this->role->slug === $slug;
    }

    /**
     * Check if the user is a Head Admin.
     */
    public function isAdmin(): bool
    {
        return $this->hasRole(Role::HEAD_ADMIN);
    }

    /**
     * Check if the user is a Teacher.
     */
    public function isTeacher(): bool
    {
        return $this->hasRole(Role::TEACHER);
    }

    /**
     * Check if the user is a Student.
     */
    public function isStudent(): bool
    {
        return $this->hasRole(Role::STUDENT);
    }

    // =========================================================================
    // Accessors
    // =========================================================================

    /**
     * Get the URL for the user's profile photo.
     * Returns a default avatar URL if no photo is uploaded.
     */
    protected function profilePhotoUrl(): Attribute
    {
        return Attribute::get(function () {
            if ($this->profile_photo_path) {
                return Storage::disk('public')->url($this->profile_photo_path);
            }

            // Generate a default avatar using UI Avatars service (initials-based)
            $name = urlencode($this->name);
            return "https://ui-avatars.com/api/?name={$name}&color=7F9CF5&background=EBF4FF&size=128";
        });
    }
}
