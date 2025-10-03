<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model {
    protected $table='pegawai';
    protected $fillable=[
        'nip','nama_lengkap','jenis_kelamin',
        'jabatan_id','skpd_id','unit_kerja_id',
        'nama_golongan','nama_pangkat','alamat_lengkap'
    ];
    public function jabatan(){ return $this->belongsTo(Jabatan::class); }
    public function skpd(){ return $this->belongsTo(Skpd::class); }
    public function unitKerja(){ return $this->belongsTo(UnitKerja::class); }
}
