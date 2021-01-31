<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Price;
use Illuminate\Support\Facades\URL;
use App\Helper\Helper;

class PriceController extends Controller
{
    public function manage()
    {
    }

    public function getAll(Request $request)
    {
        $data = Price::all();
        $latestPriceObject = Price::latest()->first();
        $latestPrice = 0;
        $latestMargin = 0;
        $latestSimulation = 0;
        if ($latestPriceObject != null) {
            $latestPrice = $latestPriceObject->price;
            $latestMargin = $latestPriceObject->margin;
            $latestSimulation = (1176- ($latestMargin * 1176)) * $latestPrice;
        }

        if (str_contains(url()->current(), 'api/')) {
            $check = Helper::checkApiKey($request->api_key);
            if ($check != null) {
                return $check;
            }
            return response()->json([
                    'http_response' => 200,
                    'status' => 1,
                    'message_id' => 'Berhasil Mengambil Data Harga',
                    'message' => 'Price Data retrieved successfully',
                    'data_count' => count($data),
                    'price' => $data,
                ]
            );
        } else {
            if (str_contains(url()->current(), 'admin/')) {
                return view('admin.price.manage')->
                with(compact('data', 'latestPrice', 'latestMargin', 'latestSimulation'));
            }
        }
    }

    public function store(Request $request)
    {
        $rules = [
            'price' => 'required|numeric',
            'margin' => 'required|numeric',
        ];

        $customMessages = [
            'required' => 'Mohon Isi Kolom :attribute terlebih dahulu'
        ];

        $this->validate($request, $rules, $customMessages);

        $store = Price::create([
            'price' => $request->price,
            'margin' => $request->margin / 100,
        ]);

        if ($store) {
            if (str_contains(url()->current(), 'api/')) {
                return response()->json([
                    'http_response' => 200,
                    'status' => 1,
                    'message_id' => 'Harga Sawit Berhasil Diperbaharui',
                    'message' => 'Price Updated Successfully',
                ]);
            } else {
                return redirect("$request->redirectTo")->with(['success' => "Harga Sawit Berhasil Diperbaharui"]);
            }
        } else {
            if (str_contains(url()->current(), 'api/')) {
                return response()->json([
                    'http_response' => 400,
                    'status' => 0,
                    'message_id' => 'Harga Sawit Berhasil Diperbaharui',
                    'message' => 'Price Updated Failed',
                ]);
            } else {
                return redirect("$request->redirectTo")->with(['error' => "Harga Sawit Gagal Diperbaharui"]);
            }
        }
    }


    public function destroy(Request $request)
    {
        $price = Price::findOrFail($request->id);
        $delete = $price->delete();
        if ($delete) {
            if (str_contains(url()->current(), 'api/')) {
                return response()->json([
                    'http_response' => 200,
                    'status' => 1,
                    'message_id' => 'Harga Sawit Berhasil Dihapus',
                    'message' => 'Price Deleted',
                ]);
            } else {
                return redirect("$request->redirectTo")->with(['success' => "Harga Sawit Berhasil Dihapus"]);
            }
        } else {
            if (str_contains(url()->current(), 'api/')) {
                return response()->json([
                    'http_response' => 400,
                    'status' => 0,
                    'message_id' => 'Harga Sawit Gagal Dihapus',
                    'message' => 'Price Deleted',
                ]);
            } else {
                return redirect("$request->redirectTo")->with(['error' => "Harga Sawit Gagal Dihapus"]);
            }
        }

    }


}
