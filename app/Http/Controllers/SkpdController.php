<?php
namespace App\Http\Controllers;
use App\Models\Skpd;
use Illuminate\Http\Request;

class SkpdController extends Controller {
    public function index(){ return Skpd::all(); }
    public function store(Request $r){
        $data=$r->validate(['skpd'=>'required|string|max:255']);
        return response()->json(Skpd::create($data),201);
    }
    public function show(Skpd $skpd){ return $skpd; }
    public function update(Request $r, Skpd $skpd){
        $data=$r->validate(['skpd'=>'required|string|max:255']);
        $skpd->update($data); return $skpd;
    }
    public function destroy(Skpd $skpd){
        $skpd->delete(); return response()->json(null,204);
    }
}
