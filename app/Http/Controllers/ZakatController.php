<?php

namespace App\Http\Controllers;

use App\Exports\DataZakat;
use App\Models\Zakat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class ZakatController extends Controller
{
    public function index() {
        $data = Zakat::all();
        return response()->json([
            "message" => "Success",
            "status" => 200,
            "body" => $data,
        ]);
    }

    public function store(Request $request) {
        $val = Validator::make($request->all(), [
            "nik" => 'required',
            "nama" => 'required',
            "zakat_mal" => 'required',
            "zakat_profesi" => 'required',
            "zakat_fitrah" => 'required',
        ]);

        if ($val->fails()) {
            return response()->json([
                "message" => "Invalid field",
                "status" => 403,
                "body" => $val->errors(),
            ]);
        }

        $zakat = new Zakat();
        $zakat->nik = $request->nik;
        $zakat->nama = $request->nama;
        $zakat->zm = $request->zakat_mal;
        $zakat->za = $request->zakat_profesi;
        $zakat->zf = $request->zakat_fitrah;
        $zakat->total = (int)$request->zakat_mal + (int)$request->zakat_profesi + (int)$request->zakat_fitrah;
        $zakat->save();

        return response()->json([
            "message" => "Success",
            "status" => 200,
            "body" => $zakat,
        ]);
    }

    public function destroy($id) {
        $zakat = Zakat::find($id);
        if ($zakat) {
            $zakat->delete();
            return response()->json([
                "message" => "Success",
                "status" => 200,
                "body" => null,
            ]);
        }
        
        return response()->json([
            "message" => "Data not found",
            "status" => 404,
            "body" => null,
        ]);
    }

    public function download() {
        return Excel::download(new DataZakat(), 'report_zakat.xlsx');redirect()->back();
    }
    
}
