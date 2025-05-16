<?php

// app/Http/Controllers/AdminController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $breadcrumb = (object) [
            'title' => '',
            'list'  => ['DSS Batching Plant', 'Dashboard']
        ];

        $activeMenu = 'dashboard';

        return view('admin.dashboard' , ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu]);
    }
}