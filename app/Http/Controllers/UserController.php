<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\RepairOrder;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $user = User::join('branches' , 'users.branch_id','=','branches.id')->get();
        $dataBybranch = [];
        $branches = Branch::get();
        $me = Auth::user();
        if ($me->role == 'ADMIN') {
            foreach ($branches as $branch) {
                $user = User::where('users.branch_id', '=', $branch->id)->where('users.role', '!=', 'ADMIN')->orderBy('role', 'ASC')->orderBy('name', 'ASC')->get();
                $dataBybranch['data'][] = [
                    'branch_id' => $branch->id,
                    'branch_name' => $branch->name,
                    'users' => $user,
                ];
            }
        } else {

            $user = User::where('users.branch_id', '=', $me->branch_id)->where('users.role', '!=', 'ADMIN')->orderBy('role', 'ASC')->orderBy('name', 'ASC')->get();
            $branch_name = Branch::where('id', '=', $me->branch_id)->get(['name'])->first();
            $dataBybranch['users'] = $user;
            $dataBybranch['branch_name'] = $branch_name;
        }
        return view('userlist', compact('dataBybranch'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $me = Auth::user();
        $branch = Branch::where( 'id' , $me->branch_id)->first();
        return view('user.profile', compact('me' , 'branch'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $user = User::find($id);
        RepairOrder::where('user_id', $id)->delete();
        $user->delete();
        // return $user;
        $dataBybranch = [];
        $branches = Branch::get();
        $me = Auth::user();
        if ($me->role == 'ADMIN') {
            foreach ($branches as $branch) {
                $user = User::where('users.branch_id', '=', $branch->id)->where('users.role', '!=', 'ADMIN')->orderBy('role', 'ASC')->orderBy('name', 'ASC')->get();
                $dataBybranch['data'][] = [
                    'branch_id' => $branch->id,
                    'branch_name' => $branch->name,
                    'users' => $user,
                ];
            }
        } else {

            $user = User::where('users.branch_id', '=', $me->branch_id)->where('users.role', '!=', 'ADMIN')->orderBy('role', 'ASC')->orderBy('name', 'ASC')->get();
            $branch_name = Branch::where('id', '=', $me->branch_id)->get(['name'])->first();
            $dataBybranch['users'] = $user;
            $dataBybranch['branch_name'] = $branch_name;
        }
        return view('userlist', compact('dataBybranch'));
    }

    public function rePassword(Request $request)
    {
        $validator = $request->validate([
            'password_old' => 'required|string',
            'password_new' => 'required|string|confirmed|min:4'
        ]);
        // return $request;

        $user = Auth::user();
        if (!$token = Auth::attempt(['email' => $user->email, 'password' => $request->password_old])) {
            return Redirect::back()->withErrors(['msg' => 'Incorrect Old password']);
        }

        $user->password = bcrypt($request->password_new);
        $user->save();
        return redirect()->intended(RouteServiceProvider::HOME);
    }
}
