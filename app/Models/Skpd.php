<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Skpd extends Model {
    protected $table='skpd';
    protected $fillable=['skpd'];
    public function unitKerja(){ return $this->hasMany(UnitKerja::class); }
    public function pegawai(){ return $this->hasMany(Pegawai::class); }
}
