<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QR_Code;
use App\Models\User;

class HomeController extends Controller
{
    public function index() {
        $totalCount_qrcodes = QR_Code::all();
        $totalCount_users = User::all();
        return view('admin.dashboard', compact('totalCount_qrcodes', 'totalCount_users'));
    }
    public function edit() {
        
        return view('admin.profile.edit');
    }
}
