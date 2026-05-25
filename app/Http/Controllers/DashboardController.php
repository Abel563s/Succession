<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show the main dashboard.
     */
    public function index()
    {
        $user = Auth::user();

        // Redirect admins and DCEO to their specific dashboard
        if ($user->isAdmin() || $user->isDceo()) {
            return redirect()->route('admin.dashboard');
        }

        return view('dashboard');
    }
}
