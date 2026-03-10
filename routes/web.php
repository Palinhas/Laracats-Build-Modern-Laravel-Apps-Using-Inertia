<?php

use App\Http\Controllers\Auth\LoginController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store']);
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout')->middleware('auth');


Route::middleware('auth')->group(function () {

    Route::get('/', function () {
        return  Inertia::render('Home');
    });

    Route::get('/users', function () {
        return  Inertia::render('Users/Index',
            [
                'users' => User::when(request('search'), fn($query, $search) =>
                    $query->where('name', 'like', "%{$search}%")
                          ->orWhere('email', 'like', "%{$search}%")
                )->paginate(10)
                    ->withQueryString() // to keep the search query in the pagination links
                    ->through(fn($user) => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                        'can' => [
                            'updateUser' => Auth::user()->can('update', $user),
                        ],
                ]),
                'filters' => request()->only('search'),
                'can' => [
                    'createUser' => Auth::user()->can('create', User::class),
                ],
            ]);
    });

    Route::get('/users/create', function () {
        return Inertia::render('Users/Create');
    })->middleware('can:create,App\Models\User');

    Route::post('/users', function (Request $request) {
        // Validate the incoming request data

        $attributes = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        User::create($attributes);

        // Redirect to the users index page after successful creation
        return redirect('/users');
    });


    Route::get('/settings', function () {
        return  Inertia::render('Settings');
    });

});
