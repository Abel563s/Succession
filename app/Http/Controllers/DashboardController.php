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

        // Redirect admin, DCEO, manager, and user to their specific dashboard
        if ($user->isAdmin() || $user->isDceo() || $user->isManager() || $user->isUser()) {
            return redirect()->route('admin.dashboard');
        }

        return view('dashboard');
    }
}
