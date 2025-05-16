<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('dynamic_dashboard_url')) {
    /**
     * Generate dashboard URL berdasarkan role user
     * 
     * @return string
     */
    function dynamic_dashboard_url()
    {
        if (!Auth::check()) {
            return url('/login');
        }

        return match(Auth::user()->role) {
            'admin'   => url('/admin/dashboard'),
            'officer' => url('/officer/dashboard'),
            default  => url('/dashboard')
        };
    }
}

if (!function_exists('user_role')) {
    /**
     * Dapatkan role user yang sedang login
     * 
     * @return string|null
     */
    function user_role()
    {
        return Auth::check() ? Auth::user()->role : null;
    }
}

if (!function_exists('is_admin')) {
    /**
     * Cek apakah user adalah admin
     * 
     * @return bool
     */
    function is_admin()
    {
        return Auth::check() && Auth::user()->role === 'admin';
    }
}

if (!function_exists('is_officer')) {
    /**
     * Cek apakah user adalah officer
     * 
     * @return bool
     */
    function is_officer()
    {
        return Auth::check() && Auth::user()->role === 'officer';
    }
}

if (!function_exists('role_prefix')) {
    /**
     * Dapatkan prefix URL berdasarkan role
     * 
     * @return string
     */
    function role_prefix()
    {
        if (!Auth::check()) {
            return '';
        }

        return match(Auth::user()->role) {
            'admin'   => 'admin',
            'officer' => 'officer',
            default  => ''
        };
    }
}

if (!function_exists('asset_role')) {
    /**
     * Load asset dengan folder role
     * Contoh: /admin/css/style.css
     * 
     * @param string $path
     * @return string
     */
    function asset_role($path)
    {
        $prefix = role_prefix();
        return asset($prefix ? "$prefix/$path" : $path);
    }
}