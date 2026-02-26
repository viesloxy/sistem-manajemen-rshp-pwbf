<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class TemuDokter extends Model
{
    // Dari skema 'rshp_insert_role_user.sql'
    protected $table = 'temu_dokter';
    protected $primaryKey = 'idreservasi_dokter';

    protected $fillable = [
        'no_urut',
        'waktu_daftar',
        'status',
        'idpet',
        'idrole_user' // Ini adalah dokter yang dituju
    ];
    
    // Skema Anda memiliki 'waktu_daftar' tapi tidak ada created/updated at
    public $timestamps = false;
    
    // Cast 'waktu_daftar' sebagai Carbon instance
    protected $casts = [
        'waktu_daftar' => 'datetime',
    ];

    /**
     * Relasi ke Pet
     */
    public function pet()
    {
        return $this->belongsTo(Pet::class, 'idpet', 'idpet');
    }

    /**
     * Relasi ke Dokter (RoleUser)
     */
    public function dokter()
    {
        return $this->belongsTo(RoleUser::class, 'idrole_user', 'idrole_user');
    }

    /**
     * Relasi ke RekamMedis (Satu pendaftaran punya satu rekam medis)
     */
    public function rekamMedis()
    {
        return $this->hasOne(RekamMedis::class, 'idreservasi_dokter', 'idreservasi_dokter');
    }

    /**
     * Accessor untuk mengubah 'status' char menjadi teks
     */
    public function getStatusTextAttribute()
    {
        // Sesuaikan logikanya jika 'status' Anda berbeda
        if ($this->status == '1') {
            return 'Selesai';
        } elseif ($this->status == '0') {
            return 'Menunggu';
        } else {
            return 'Antrian'; // Fallback
        }
    }
}