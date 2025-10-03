<?php
namespace App\Http\Controllers;
use App\Models\Pegawai;
use Illuminate\Http\Request;

class PegawaiController extends Controller {
    public function index(){ return Pegawai::with(['jabatan','skpd','unitKerja'])->paginate(20); }
    public function store(Request $r){
        $data=$r->validate([
            'nip'=>'required|integer|unique:pegawai,nip',
            'nama_lengkap'=>'required|string|max:255',
            'jenis_kelamin'=>'required|in:L,P',
            'jabatan_id'=>'required|exists:jabatan,id',
            'skpd_id'=>'required|exists:skpd,id',
            'unit_kerja_id'=>'required|exists:unit_kerja,id',
            'nama_golongan'=>'nullable|string|max:255',
            'nama_pangkat'=>'nullable|string|max:255',
            'alamat_lengkap'=>'nullable|string',
        ]);
        return response()->json(Pegawai::create($data)->load(['jabatan','skpd','unitKerja']),201);
    }
    public function show(Pegawai $pegawai){ return $pegawai->load(['jabatan','skpd','unitKerja']); }
    public function update(Request $r, Pegawai $pegawai){
        $data=$r->validate([
            'nip'=>'required|integer|unique:pegawai,nip,'.$pegawai->id,
            'nama_lengkap'=>'required|string|max:255',
            'jenis_kelamin'=>'required|in:L,P',
            'jabatan_id'=>'required|exists:jabatan,id',
            'skpd_id'=>'required|exists:skpd,id',
            'unit_kerja_id'=>'required|exists:unit_kerja,id',
            'nama_golongan'=>'nullable|string|max:255',
            'nama_pangkat'=>'nullable|string|max:255',
            'alamat_lengkap'=>'nullable|string',
        ]);
        $pegawai->update($data); return $pegawai->load(['jabatan','skpd','unitKerja']);
    }
    public function destroy(Pegawai $pegawai){
        $pegawai->delete(); return response()->json(null,204);
    }
}
