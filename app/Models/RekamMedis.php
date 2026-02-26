<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class RekamMedis extends Model
{
    protected $table = 'rekam_medis';
    protected $primaryKey = 'idrekam_medis';

    // Sesuaikan dengan skema 'rshp_insert_role_user.sql'
    protected $fillable = [
        'idreservasi_dokter',
        'created_at',
        'anamnesa',
        'temuan_klinis',
        'diagnosa',
        'dokter_pemeriksa' // ini adalah idrole_user
    ];

    // Kita set 'updated_at' ke false, tapi 'created_at' ada
    const UPDATED_AT = null;
    
    // Cast 'created_at' sebagai Carbon instance
    protected $casts = [
        'created_at' => 'datetime',
    ];

    /**
     * Relasi ke TemuDokter (Pendaftaran)
     */
    public function temuDokter()
    {
        return $this->belongsTo(TemuDokter::class, 'idreservasi_dokter', 'idreservasi_dokter');
    }

    /**
     * Relasi ke Dokter (RoleUser)
     */
    public function dokter()
    {
        // 'dokter_pemeriksa' adalah FK ke 'idrole_user'
        return $this->belongsTo(RoleUser::class, 'dokter_pemeriksa', 'idrole_user');
    }
    
    /**
     * Relasi ke DetailRekamMedis
     */
    public function detailRekamMedis()
    {
        return $this->hasMany(DetailRekamMedis::class, 'idrekam_medis', 'idrekam_medis');
    }
}