<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Str;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $branches = Branch::get(['id','name']);
        // return $branches;
        return view('auth.bo-register', compact('branches'));

        // return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        // return $request;
        $user = Auth::user();
        $assignRole = 'BRANCH-OWNER';
        $branch_user = $request->branch_id;
        if ($user->role == 'BRANCH-OWNER') {
            $assignRole = 'EMPLOYEE';
            $branch_user = $user->branch_id;
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'position' => ['required', 'string', 'max:255'],
            // 'role' => ['required', 'string', 'max:255'],
            // 'branch_id' => ['required', 'numeric' , 'min:0'],
            'password' => ['required', 'confirmed', 'min:4'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'position' => $request->position,
            'role' => $assignRole,
            'branch_id' => $branch_user,
            'remember_token' => $request->_token,
            'password' => Hash::make($request->password),
        ]);

        // event(new Registered($user));

        // Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
