<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class UnitKerja extends Model {
    protected $table='unit_kerja';
    protected $fillable=['unit_kerja','skpd_id'];
    public function skpd(){ return $this->belongsTo(Skpd::class); }
    public function pegawai(){ return $this->hasMany(Pegawai::class); }
}
