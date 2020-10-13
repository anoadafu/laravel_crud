<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{

    public function index(){
        $this->authorize('admin');

        $users = User::withTrashed()->paginate(25);
        return view('users/index')->with(['users' => $users]);
    }

    public function block($id){
        $this->authorize('admin');

        $user = User::find($id);
        
        // Check if user exists before deleting
        if (!isset($user)){
            return redirect('admin/users')->with('error', 'No Such User');
        } elseif($user->id == auth()->user()->id){
            redirect('admin/users')->with('error', 'Can\'t remove yourself');
        }

        // SoftDelete User instance
        $user->delete();

        return redirect('admin/users')->with('status', 'User '. $user->name .' Removed');
    }

    public function restore($id){
        $this->authorize('admin');

        $user = User::onlyTrashed()->find($id);
        // Check if user exists before deleting
        if (!isset($user)){
            return redirect('admin/users')->with('error', 'No Such User');
        } elseif($user->id == auth()->user()->id){
            redirect('admin/users')->with('error', 'Can\'t restore yourself');
        }

        // SoftDelete User instance
        $user->restore();

        return redirect('admin/users')->with('status', 'User '. $user->name .' Restored');
    }
}
