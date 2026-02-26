<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    protected $table = 'user';
    protected $primaryKey = 'iduser';
    
    // PERBAIKAN 1: Sesuaikan dengan DB Anda (nama)
    protected $fillable = [
        'nama', // Bukan 'name'
        'email',
        'password',
    ];

    // PERBAIKAN 2: Tambahkan ini karena tabel 'user' Anda tidak punya timestamps
    public $timestamps = false;

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

    public function pemilik()
    {
        return $this->hasOne(Pemilik::class, 'iduser', 'iduser');
    }

    public function roles()
    {
        // Parameter: Model, tabel pivot, foreign key model ini, foreign key model join
        return $this->belongsToMany(Role::class, 'role_user', 'iduser', 'idrole')
                    ->withPivot('status'); // Ambil juga kolom 'status' dari tabel pivot
    }

    // PERBAIKAN 3: TAMBAHKAN RELASI INI (Sesuai Modul 10, Hal 6)
    /**
     * Relasi ke model pivot RoleUser (One-to-Many)
     * Ini yang dicari oleh LoginController
     */
    public function roleUser()
    {
        return $this->hasMany(RoleUser::class, 'iduser', 'iduser');
    }
}