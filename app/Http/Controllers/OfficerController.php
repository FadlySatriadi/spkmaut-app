<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OfficerController extends Controller
{
    public function dashboard()
    {
        $breadcrumb = (object) [
            'title' => '',
            'list'  => ['DSS Batching Plant', 'Dashboard']
        ];

        $activeMenu = 'dashboard';

        return view('officer.dashboard' , ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu]);
    }
}