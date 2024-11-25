<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ChartJSController extends Controller
{
    /**
     * Display a chart with user data.
     *
     * @return View
     */
    public function index(): View
    {
        // Retrieve user data grouped by month for the current year
        $userData = User::select(DB::raw("COUNT(*) as count"), DB::raw("MONTHNAME(created_at) as month_name"))
                        ->whereYear('created_at', date('Y'))
                        ->groupBy(DB::raw("MONTHNAME(created_at)"), DB::raw("MONTH(created_at)"))
                        ->orderBy(DB::raw("MONTH(created_at)"))
                        ->get()
                        ->pluck('count', 'month_name');

        // Log the retrieved user data
        Log::info('Users data:', ['users' => $userData]);

        // Define all month names
        $allMonths = collect([
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ]);

        // Merge the user data with all months to ensure all months are represented
        $userData = $allMonths->mapWithKeys(function ($month) use ($userData) {
            return [$month => $userData->get($month, 0)];
        });

        // Extract labels and data for the chart
        $labels = $userData->keys();
        $data = $userData->values();

        // Retrieve the total number of users
        $totalUsers = User::count();

        // Log the labels, data, and total users
        Log::info('Labels:', ['labels' => $labels]);
        Log::info('Data:', ['data' => $data]);
        Log::info('Total Users:', ['totalUsers' => $totalUsers]);

        // Return the view with the chart data
        return view('chart', compact('labels', 'data', 'totalUsers'));
    }
}
