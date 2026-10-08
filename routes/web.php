<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ItemController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Models\Item;

Route::get('/', function () {
    return view('welcome');
});

// Google OAuth Routes
Route::get('/auth/google', function () {
    return Socialite::driver('google')->redirect();
})->name('google.login');

Route::get('/auth/google/callback', function () {
    $googleUser = Socialite::driver('google')->user();
    
    $user = User::updateOrCreate([
        'email' => $googleUser->getEmail(),
    ], [
        'name' => $googleUser->getName(),
        'avatar' => $googleUser->getAvatar(),
        'password' => bcrypt(Illuminate\Support\Str::random(16)),
        'is_admin' => 0,
        'role' => 'user',
    ]);

    Auth::login($user);

    return redirect('/dashboard');
});

// Dashboard Route with Live Database Counts and Weather API Integration for Admin
Route::get('/dashboard', function (Request $request) {
    if (Auth::user()->role === 'admin') {
        $totalLostItems = Item::where('status', 'lost')->count();
        $foundItems = Item::where('status', 'found')->count();
        $claimedItems = Item::where('status', 'claimed')->count();
        $activeUsers = User::count();
        $recentActivities = Item::latest()->take(5)->get();

        // Weather API Integration Logic with 5-second timeout & error handling
        $city = $request->input('city', 'Kidapawan');
        $apiKey = env('WEATHER_API_KEY');
        $weatherData = null;

        try {
            $response = Http::timeout(5)->get("https://api.weatherapi.com/v1/current.json", [
                'key' => $apiKey,
                'q' => $city,
            ]);

            if ($response->successful()) {
                $weatherData = $response->json();
            }
        } catch (\Exception $e) {
            $weatherData = null; // Fallback to null if connection fails or times out
        }

        return view('dashboard', compact(
            'totalLostItems', 
            'foundItems', 
            'claimedItems', 
            'activeUsers', 
            'recentActivities',
            'weatherData',
            'city'
        ));
    }
    
    return view('user-dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Item Reporting & Management Routes
    Route::get('/items', [ItemController::class, 'index'])->name('items.index');
    Route::get('/items/create', [ItemController::class, 'create'])->name('items.create');
    Route::post('/items', [ItemController::class, 'store'])->name('items.store');
    
    Route::get('/items/{id}/edit', [ItemController::class, 'edit'])->name('items.edit');
    Route::put('/items/{id}', [ItemController::class, 'update'])->name('items.update');
    Route::delete('/items/{id}', [ItemController::class, 'destroy'])->name('items.destroy');
    
    Route::post('/items/{id}/report', [ItemController::class, 'report'])->name('items.report');

    // Admin Sidebar Navigation & Maintenance Routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/lost-items', function () {
            return view('admin.lost-items');
        })->name('lost-items');

        Route::get('/found-items', function () {
            return view('admin.found-items');
        })->name('found-items');

        Route::get('/users', function () {
            return view('admin.users');
        })->name('users');

        Route::get('/reports', function () {
            return view('admin.reports');
        })->name('reports');

        Route::get('/maintenance', function () {
            return view('admin.maintenance');
        })->name('maintenance');

        // Database Reset Route (Wipes database records back to zero)
        Route::delete('/system/reset', function () {
            if (auth()->user()->role !== 'admin') {
                abort(403, 'Unauthorized action.');
            }

            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            Item::truncate();
            User::where('role', '!=', 'admin')->delete(); 
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            return redirect()->back()->with('success', 'All system records have been completely deleted from the database.');
        })->name('system.reset');
    });
});

require __DIR__.'/auth.php';