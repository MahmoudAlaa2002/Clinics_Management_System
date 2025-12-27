<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable{

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'image',
        'address',
        'date_of_birth',
        'role',
        'gender',
        'last_seen',
    ];

    protected $casts = [
        'last_seen' => 'datetime',
    ];


    protected static function booted(){
        static::deleting(function ($user) {
            $user->roles()->detach();     // هذا السطر يحذف الإدخالات من جدول model_has_roles
        });
    }

    public function employee(){
        return $this->hasOne(Employee::class);
    }

    public function patient(){
        return $this->hasOne(Patient::class);
    }


    // علاقات خاصة بالمحادثات
    public function conversations() {
        return $this->belongsToMany(Conversation::class, 'conversation_user')->withTimestamps();
    }

    public function sentMessages() {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function getIsOnlineAttribute() {
        return $this->last_seen && $this->last_seen->gt(now()->subMinutes(2));
    }


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
    protected function casts(): array{
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
