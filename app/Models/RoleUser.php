<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    // Sesuaikan dengan nama tabel pivot Anda
    protected $table = 'role_user';
    protected $primaryKey = 'idrole_user';
    
    // Kolom yang bisa diisi
    protected $fillable = ['iduser', 'idrole', 'status'];

    // Tabel pivot di DB Anda tidak memiliki timestamps
    public $timestamps = false;

    /**
     * Relasi ke model Role
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'idrole', 'idrole');
    }

    /**
     * Relasi ke model User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'iduser', 'iduser');
    }
}