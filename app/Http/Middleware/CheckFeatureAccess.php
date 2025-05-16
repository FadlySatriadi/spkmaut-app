<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckFeatureAccess
{
    public function handle(Request $request, Closure $next, $feature)
    {
        $user = Auth::user();

        $allowed = match ($user->role) {
            'admin' => $this->adminAccess($feature),
            'officer' => $this->officerAccess($feature),
            default => false
        };

        if (!$allowed) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }

    protected function adminAccess($feature)
    {
        return in_array($feature, [
            'data-management', // CRUD semua data
            'history-view'    // Lihat history
        ]);
    }

    protected function officerAccess($feature)
    {
        return in_array($feature, [
            'assessment',    // Penilaian
            'data-view'      // Lihat data (read-only)
        ]);
    }
}
