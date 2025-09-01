<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserManagementController extends Controller
{
    public function __construct()
    {
        // Only admin can access these routes
        // , 'role:admin'
        // $this->middleware(['auth:sanctum', 'role:admin']);
    }

    /**
     * List all users (optional, for admin dashboard).
     */
    public function index()
    {
        // dd('murd');
        // return response()->json(['message' => 'API works!']);
        $users = User::with('roles')->get();
        // $users = User::with('roles')
        //     ->whereHas('roles', function ($q) {
        //         $q->whereIn('name', ['operator', 'backoffice']);
        //     })
        //     ->get();
        // $users = User::role(['operator', 'backoffice'])->with('roles')->get();
        return response()->json($users);
    }

    /**
     * Store a new Operator or Backoffice user.
     */
    public function store(Request $request)
    {
        // return response()->json(['message' => 'API works!']);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|in:operator,backoffice',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Assign role
        $user->assignRole($validated['role']);

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user->load('roles'),
        ], 201);
    }
}
