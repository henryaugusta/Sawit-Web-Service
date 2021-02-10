<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArmadaController extends Controller
{
    public function adminManage(){
        return view('admin.armada.manage');
    }
    public function adminCreate(){
        return view('admin.armada.create');
    }
}
