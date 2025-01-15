<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'customer')->paginate(10);
        return view('pages.admin.user.index', compact('users'));
    }
}
