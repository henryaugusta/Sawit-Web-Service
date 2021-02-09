<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Http\Resources\RequestSellResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Carbon\Carbon;
use Faker\Provider\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use PHPUnit\Util\Json;
use RazAPI;

class UserController extends Controller
{


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function manage()
    {
        $userCount = User::count();
        $userAdmin = User::where('role', 1)->count();
        $userStaff = User::where('role', 2)->count();
        $userCust = User::where('role', 3)->count();
        $user = User::orderBy('role')->get();
        return view('admin.user.manage')
            ->with(compact('user', 'userAdmin', 'userCust', 'userStaff'
                , 'userCount'));
    }

    public function profile($id)
    {
        $user = User::findOrFail($id);

        if (Helper::isAPI()){
            return response()->json([
                'http_response' => 200,
                'status' => 1,
                'message_id' => 'Registrasi Berhasil, Silakan login untuk melanjutkan',
                'message' => 'Registration Success, Please login to continue',
                'users' => new UserResource(User::findOrFail($id)),
            ]);
        }

        return view('user.profile')
            ->with(compact('user'));
    }

    /**
     * Show the application dashboard.
     *
     * @return
     */
    public function store(Request $request)
    {
        $redirectTo = $request->redirectTo;
        $rules = [
            'nama_pengguna' => 'required',
            'email' => 'required|unique:users',
            'tanggal_lahir' => 'required',
            'contact' => 'required|unique:users|numeric',
            'role' => 'required',
            'password' => 'required', 'string', 'min:8',
        ];
        $customMessages = [
            'required' => 'Mohon Isi Kolom :attribute terlebih dahulu'
        ];
        $this->validate($request, $rules, $customMessages);

        $url_profile = url('/');

        $date_birth = Carbon::parse($request->tanggal_lahir);

        $user = User::create([
            'name' => $request->nama_pengguna,
            'gender' => $request->gender,
            'email' => $request->email,
            'contact' => $request->contact,
            'date_birth' => $date_birth,
            'profile_url' => '',
            'status' => 1,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        if ($user) {
            if (Helper::isAPI()) {
                return response()->json([
                    'http_response' => 200,
                    'status' => 1,
                    'email' => $request->email,
                    'phone' => $request->contact,
                    'message_id' => 'Registrasi Berhasil, Silakan login untuk melanjutkan',
                    'message' => 'Registration Success, Please login to continue',
                ]);
            }
            return redirect("$redirectTo")->with(['success' => 'Berhasil Menambah User']);
        } else {
            if (Helper::isAPI()) {
                return response()->json([
                    'http_response' => 400,
                    'status' => 0,
                    'message_id' => 'Registrasi Gagal',
                    'message' => 'Registration Failed, Please try again later',
                ]);
            }
            return redirect("$redirectTo")->with(['error' => 'Gagal Menambah User']);
        }
    }

    /**
     * change account status of user
     *
     *
     */
    public function changeStatus(Request $request)
    {
        $rules = [
            'id' => 'required',
            'role' => 'required',
            'status' => 'required',
        ];
        $customMessages = [
            'required' => 'Mohon Isi Kolom :attribute terlebih dahulu'
        ];
        $this->validate($request, $rules, $customMessages);

        $user = User::findOrFail($request->id);
        $user->update([
            'role' => $request->role,
            'status' => $request->status,
        ]);

        if ($user) {
            if (Helper::isAPI()) {
                return response()->json([
                    'http_response' => 200,
                    'status' => 1,
                    'message_id' => 'Berhasil Mengubah Status Akun',
                    'message' => 'Account Status Change Success',
                ]);
            }
            return redirect()->back()->with(['success' => 'Berhasil Mengubah Data User']);
        } else {
            if (Helper::isAPI()) {
                return response()->json([
                    'http_response' => 400,
                    'status' => 0,
                    'message_id' => 'Gagal Mengubah Status Akun',
                    'message' => 'Account Status Change Failed',
                ]);
            }
            return redirect()->back()->with(['error' => 'Gagal Mengubah Data User']);
        }

    }

    /**
     * update user data
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Support\Renderable|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function update(Request $request)
    {
        $basePath = "photo/profile/";
        $user = User::findOrFail($request->id);

        $rules = [
            'nama_pengguna' => 'required',
            'email' => 'required|unique:users,id,' . $request->id, //ignore current id
            'tanggal_lahir' => 'required',
            'contact' => 'required|numeric|unique:users,id,' . $request->id, //ignore current id,
        ];

        $customMessages = [
            'required' => 'Mohon Isi Kolom :attribute terlebih dahulu'
        ];
        $this->validate($request, $rules, $customMessages);

        $date_birth = Carbon::parse($request->tanggal_lahir);


        if ($request->file('image') == "") {
            //IF IMAGE NOT REPLACED
            $user->update([
                'name' => $request->nama_pengguna,
                'gender' => $request->gender,
                'email' => $request->email,
                'contact' => $request->contact,
                'date_birth' => $date_birth,
            ]);
        } else {
            if (\File::exists(public_path("$basePath/" . $user->profile_url))) {
                \File::delete(public_path("$basePath/" . $user->profile_url));
            }
            $image = $request->file('image');
            $destinationPath = 'photo/profile/';
            $file_name = Carbon::now()->timestamp . "_" . $image->getClientOriginalName();
            $image->move($destinationPath, $file_name);

            $user->update([
                'name' => $request->nama_pengguna,
                'gender' => $request->gender,
                'email' => $request->email,
                'contact' => $request->contact,
                'date_birth' => $date_birth,
                'profile_url' => $file_name,
            ]);
        }

        if ($user) {
            return redirect()->back()->with(['success' => 'Berhasil Mengupdate Data User']);
        } else {
            return redirect()->back()->with(['error' => 'Gagal Mengupdate User']);;
        }
    }

    /*
     * Change Profile Picture Only ( For API )
     *
     */
    public function changeProfile(Request $request){
        $rules = [
            'image'     => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        $customMessages = [
            'required' => 'Mohon Isi Kolom :attribute terlebih dahulu'
        ];

        $this->validate($request, $rules, $customMessages);
        $basePath = "photo/profile/";
        $user = User::findOrFail($request->id);

        if (File::exists(public_path("$basePath/" . $user->profile_url))) {
            File::delete(public_path("$basePath/" . $user->profile_url));
        }
        $image = $request->file('image');
        $destinationPath = 'photo/profile/';
        $file_name = Carbon::now()->timestamp . "_" . $image->getClientOriginalName();
        $image->move($destinationPath, $file_name);

        $user->update([
            'profile_url' => $file_name,
        ]);
    }

    public function changePassword(Request $request){

        $user = User::findOrFail($request->id);

        $this->validate($request, [
            'old_password'     => 'required',
            'new_password'     => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        ]);

        if(Hash::check($request->old_password, auth()->user()->getAuthPassword())){

            $user->update([
              "password" =>  Hash::make($request->old_password),
          ]);

            if ($user){
                if (Helper::isAPI()){
                    return response()->json([
                        'http_response' => 200,
                        'status' => 1,
                        'message_id' => 'Berhasil Mengupdate Password',
                        'message' => 'Password Change Success',
                    ]);
                }else{
                    return back()->with(["success" =>"Berhasil Mengupdate Password"]);
                }
            }

        }else{
            if (Helper::isAPI()){
                return response()->json([
                    'http_response' => 400,
                    'status' => 0,
                    'message_id' => 'Gagal Mengupdate Password',
                    'message' => 'Password Change Failed',
                ]);
            }else{
                return back()->with(["error" =>"Gagal Mengupdate Password"]);
            }
        }
    }

    /**
     * Show the application dashboard.
     *
     *
     */
    public function delete(Request $request)
    {
        $redirectTo = $request->redirectTo;
        $rules = [
            'nama_pengguna' => 'required',
            'email' => 'required|unique:users',
            'tanggal_lahir' => 'required',
            'contact' => 'required|unique:users|numeric',
            'role' => 'required',
            'password' => 'required', 'string', 'min:8',
        ];
        $customMessages = [
            'required' => 'Mohon Isi Kolom :attribute terlebih dahulu'
        ];

        $this->validate($request, $rules, $customMessages);

        $url_profile = url('/');

        $date_birth = Carbon::parse($request->tanggal_lahir);

        $user = User::create([
            'name' => $request->nama_pengguna,
            'gender' => $request->gender,
            'email' => $request->email,
            'contact' => $request->contact,
            'date_birth' => $date_birth,
            'profile_url' => '',
            'status' => $request->status,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        if ($user) {
            return back()->with(['success' => 'Berhasil Menambah User']);;
        } else {
            return back()->with(['error' => 'Gagal Menambah User']);;
        }
    }
}
