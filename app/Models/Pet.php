<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Pet extends Model
{
protected $table = 'pet';
    protected $primaryKey = 'idpet';
    protected $fillable = [
        'nama', 
        'tanggal_lahir', 
        'warna_tanda', 
        'jenis_kelamin',
        'idpemilik',
        'idras_hewan'
    ];
    
    // Tabel ini tidak memiliki timestamps
    public $timestamps = false;

    /**
     * Relasi ke Pemilik (belongsTo)
     */
    public function pemilik()
    {
        return $this->belongsTo(Pemilik::class, 'idpemilik', 'idpemilik');
    }

    /**
     * Relasi ke RasHewan (belongsTo)
     */
    public function rasHewan()
    {
        return $this->belongsTo(RasHewan::class, 'idras_hewan', 'idras_hewan');
    }
    
    /**
     * Relasi ke TemuDokter (hasMany)
     */
    public function temuDokter()
    {
        return $this->hasMany(TemuDokter::class, 'idpet', 'idpet');
    }

    // =================================================================
    // == ACCESSOR UNTUK DATA VIRTUAL (USIA & JENIS KELAMIN TEKS) ==
    // =================================================================

    /**
     * Accessor untuk menghitung USIA.
     * Ini memungkinkan kita memanggil $pet->usia di view
     */
    public function getUsiaAttribute()
    {
        if (!$this->tanggal_lahir) {
            return 'N/A';
        }
        // Hitung selisih tanggal lahir dengan tanggal sekarang
        // PERBAIKAN: Tambahkan '\' di depan Carbon untuk memanggil dari namespace global
        $umur = \Carbon\Carbon::parse($this->tanggal_lahir)->diff(\Carbon\Carbon::now());
        return $umur->format('%y thn, %m bln, %d hr'); // Format: 0 thn, 5 bln, 10 hr
    }

    /**
     * Accessor untuk mengubah 'J'/'B' menjadi teks.
     * Ini memungkinkan kita memanggil $pet->jenis_kelamin_text di view
     * (Asumsi 'J' = Jantan, 'B' = Betina. Sesuaikan jika berbeda)
     */
    public function getJenisKelaminTextAttribute()
    {
        if ($this->jenis_kelamin == 'J') {
            return 'Jantan';
        } elseif ($this->jenis_kelamin == 'B') {
            return 'Betina';
        } else {
            return 'N/A'; // Fallback
        }
    }
}
