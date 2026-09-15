<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

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

    /**
     * Obtiene las iniciales del nombre del usuario.
     *
     * @return string
     */
    public function initials(): string
    {
        $name = $this->name;
        if (empty($name)) {
            return '?';
        }

        $parts = explode(' ', trim($name));
        $initials = '';

        foreach ($parts as $part) {
            if (!empty($part)) {
                $initials .= strtoupper(mb_substr($part, 0, 1));
            }
        }

        return $initials;
    }
    public function tickets()
    {
        return $this->hashMamy(Tickets::class);
    }
}