<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('kiosk_id')->nullable()->constrained()->nullOnDelete();
            $table->string('phone')->nullable()->unique();
            $table->text('address')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('avatar')->nullable();
            $table->boolean('is_active')->default(false);
            $table->enum('role', ['admin', 'owner', 'worker'])->default('worker');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['kiosk_id']);
            $table->dropColumn([
                'kiosk_id',
                'phone',
                'address',
                'birth_date',
                'avatar',
                'is_active',
                'role'
            ]);
        });
    }
}; 