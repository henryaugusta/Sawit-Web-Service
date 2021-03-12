<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Models\Armada;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArmadaController extends Controller
{
    public function adminManage(){
        return view('admin.armada.manage');
    }
    public function adminCreate(){
        return view('admin.armada.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'merk' => 'required',
            'nopol' => 'required|unique:armadas',
            'no_mesin' => 'required|unique:armadas',
            'max_capacity' => 'required',
            'max_weight' => 'required',
            'description' => 'required',
        ];

        $customMessages = [
            'required' => 'Mohon Isi Kolom :attribute terlebih dahulu'
        ];

        $this->validate($request, $rules, $customMessages);

        $armada = new Armada();
        $armada->merk_mobil =  $request->merk;
        $armada->nopol = $request->nopol;
        $armada->no_mesin = $request->no_mesin;
        $armada->max_cap = $request->max_capacity;
        $armada->max_weight = $request->max_weight;

        $armada->save();

        $image = $request->file('upload_file');
        $counter=1;
        $returnVal = false;
        if ($armada) {
            $returnVal=true;
            foreach ($image as $files) {
                $destinationPath = 'photo/armada/'.$request->nopol;
                $file_name = Carbon::now()->timestamp . "_" . $files->getClientOriginalName().$files->getClientOriginalExtension();
                $files->move($destinationPath, $file_name);
                $dataFile[] = $destinationPath.$file_name;
    
                DB::table('armada_photo')->insert([
                    'armada_id' => $armada->id,
                    'path' => "$file_name",
                ]);
            }
        }

    
        if ($returnVal) {
            if (Helper::isAPI()) {
                return response()->json([
                    'http_response' => 200,
                    'status' => 1,
                    'message_id' => 'Berhasil Menyimpan Armada',
                    'message' => 'News Feed Success',
                ]);
            } else {
                return back()->with(['success' => "Berhasil Menyimpan Armada"]);
            }

        } else {
            if (str_contains(url()->current(), 'api/')) {
                return response()->json([
                    'http_response' => 400,
                    'status' => 0,
                    'message_id' => 'Gagal Menyimpan Armada',
                    'message' => 'News Feed Posting Failed',
                ]);
            } else {
                return  back()->with(['error' => "Gagal Menyimpan Armada"]);
            }
        }

    }
}
