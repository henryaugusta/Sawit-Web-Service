<?php

namespace App\Http\Controllers;

use App\Models\Price;
use App\Models\SellRequest;
use App\Models\SellRequestPhoto;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RequestSellController extends Controller
{
    /**
     * Show the sell request dashboard
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function manage()
    {
        $sellRequest = SellRequest::orderBy('id')->get();
        return view('admin.sellRequest.manage')
            ->with(compact('sellRequest'));
    }

    public function create()
    {
        $userCount = User::count();
        $data = Price::all();
        $latestPriceObject = Price::latest()->first();
        $latestPrice = 0;
        $latestMargin = 0;

        if ($latestPriceObject != null) {
            $latestPrice = $latestPriceObject->price;
            $latestMargin = $latestPriceObject->margin;
            $latestSimulation = (1176 - ($latestMargin * 1176)) * $latestPrice;
        }

        $user = User::orderBy('role')->get();
        return view('admin.sellRequest.create')
            ->with(compact('user'
                , 'userCount', 'latestPrice', 'latestMargin', 'data'));
    }

    /**
     * store the request sell
     *
     */
    public function store(Request $request)
    {

        $rules = [
            'upload_file' => 'required',
            'upload_file.*' => 'mimes:jpeg,png,jpg,gif,svg,png|max:12048',
            'user' => 'required',
            'additional_contact' => 'required',
            'longitude' => 'required',
            'est_weight' => 'required|numeric',
            'latitude' => 'required',
            'full_address' => 'required',
        ];
        $customMessages = [
            'required' => 'Mohon Isi Kolom :attribute terlebih dahulu'
        ];
        $this->validate($request, $rules, $customMessages);

        $latestPriceObject = Price::latest()->first();
        $latestPrice = 0;
        $latestMargin = 0;

        if ($latestPriceObject != null) {
            $latestPrice = $latestPriceObject->price;
            $latestMargin = $latestPriceObject->margin;
        }

        $image = $request->file('upload_file');

        $dataFile = array();
        foreach ($image as $files) {
            $destinationPath = 'photo/request_sell/';
            $file_name = $request->user . "_" . $files->getClientOriginalName() . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $file_name);
            $dataFile[] = $destinationPath.$file_name;
        }
        $create = SellRequest::create([
            'user_id' => $request->user,
            'staff_id' => null,
            'driver_id' => null,
            'updated_by' => null,
            'est_weight' => $request->est_weight,
            'est_price' => $latestPrice,
            'est_margin' => $latestMargin,
            'address' => $request->full_address,
            'lat' => $request->latitude,
            'long' => $request->longitude,
            'contact' => $request->additional_contact,
            'status' => "0",
            'file_name' => json_encode($dataFile),
        ]);

        if ($create) {
            if (str_contains(url()->current(), 'api/')) {
                return response()->json([
                    'http_response' => 200,
                    'status' => 1,
                    'message_id' => 'Request Jual Berhasil',
                    'message' => 'Sell Request Success',
                ]);
            } else {
                return redirect("$request->redirectTo")->with(['success' => "Request Jual Berhasil"]);
            }

        } else {

            if (str_contains(url()->current(), 'api/')) {
                return response()->json([
                    'http_response' => 400,
                    'status' => 0,
                    'message_id' => 'Request Jual Gagal',
                    'message' => 'Sell Request has Failed',
                ]);
            } else {
                return redirect("$request->redirectTo")->with(['error' => "Request Jual Berhasil"]);
            }


        }
    }
}
