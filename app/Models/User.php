<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Add the role attribute
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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

    public function kiosk(): BelongsTo
    {
        return $this->belongsTo(Kiosk::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'worker_id');
    }

    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class);
    }

    public function getWorkHoursToday(): float
    {
        // Implement work hours calculation
        return 8.0; // Placeholder
    }

    public function getCompletedOrdersToday(): int
    {
        return $this->orders()
            ->where('status', 'completed')
            ->whereDate('completed_at', today())
            ->count();
    }

    public function calculatePerformance(): float
    {
        // Implement performance calculation
        return 85.0; // Placeholder
    }

    public function getPendingTasksCount(): int
    {
        return $this->tasks()
            ->where('status', 'pending')
            ->count();
    }

    public function startShift(): void
    {
        $this->update(['is_active' => true]);
        $this->activities()->create([
            'type' => 'shift_start',
            'description' => 'Memulai shift'
        ]);
    }

    public function endShift(): void
    {
        $this->update(['is_active' => false]);
        $this->activities()->create([
            'type' => 'shift_end',
            'description' => 'Mengakhiri shift'
        ]);
    }
}
