<?php
namespace App\Http\Controllers;
use App\Models\Jabatan;
use Illuminate\Http\Request;

class JabatanController extends Controller {
    public function index(){ return Jabatan::all(); }
    public function store(Request $r){
        $data=$r->validate(['jabatan'=>'required|string|max:255']);
        return response()->json(Jabatan::create($data),201);
    }
    public function show(Jabatan $jabatan){ return $jabatan; }
    public function update(Request $r, Jabatan $jabatan){
        $data=$r->validate(['jabatan'=>'required|string|max:255']);
        $jabatan->update($data); return $jabatan;
    }
    public function destroy(Jabatan $jabatan){
        $jabatan->delete(); return response()->json(null,204);
    }
}
