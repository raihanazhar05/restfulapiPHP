<?php
namespace App\Http\Controllers;
use App\Models\UnitKerja;
use Illuminate\Http\Request;

class UnitKerjaController extends Controller {
    public function index(){ return UnitKerja::with('skpd')->get(); }
    public function store(Request $r){
        $data=$r->validate([
            'unit_kerja'=>'required|string|max:255',
            'skpd_id'=>'required|exists:skpd,id',
        ]);
        return response()->json(UnitKerja::create($data),201);
    }
    public function show(UnitKerja $unitKerja){ return $unitKerja->load('skpd'); }
    public function update(Request $r, UnitKerja $unitKerja){
        $data=$r->validate([
            'unit_kerja'=>'required|string|max:255',
            'skpd_id'=>'required|exists:skpd,id',
        ]);
        $unitKerja->update($data); return $unitKerja->load('skpd');
    }
    public function destroy(UnitKerja $unitKerja){
        $unitKerja->delete(); return response()->json(null,204);
    }
}
