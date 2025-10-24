<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'role';
    protected $primaryKey = 'idrole';
    protected $fillable = ['nama_role'];

    // Tabel ini tidak memiliki timestamps di DB Anda
    public $timestamps = false;

    /**
     * Relasi many-to-many ke User
     * Melalui tabel pivot 'role_user'
     */
    public function users()
    {
        // Parameter: Model, tabel pivot, foreign key model ini, foreign key model join
        return $this->belongsToMany(User::class, 'role_user', 'idrole', 'iduser')
                    ->withPivot('status'); // Ambil juga kolom 'status' dari tabel pivot
    }
}
