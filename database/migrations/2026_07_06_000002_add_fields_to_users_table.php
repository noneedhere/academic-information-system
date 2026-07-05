<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('role_id')
                  ->default(3)
                  ->after('id')
                  ->constrained('roles')
                  ->restrictOnDelete()
                  ->cascadeOnUpdate();

            $table->string('username', 100)->unique()->after('name');
            $table->string('phone', 20)->nullable()->after('email');
            $table->text('address')->nullable()->after('phone');
            $table->string('profile_photo_path', 2048)->nullable()->after('address');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropColumn([
                'role_id',
                'username',
                'phone',
                'address',
                'profile_photo_path',
                'deleted_at',
            ]);
        });
    }
};
