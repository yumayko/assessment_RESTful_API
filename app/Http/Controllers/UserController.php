<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function __construct()
    {   
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function index()
    {
        $users = User::all();
        return response()->json(['message' => 'Data Berhasil Ditampilkan', $users], 200);
    }

    public function show($id)
    {
        $users = User::find($id);
        return response()->json(['message' => 'Data Berhasil Ditampilkan', $users], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6',
            'age' => 'required|integer|min:1',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'age' => $request->age,
        ]);

        return response()->json(['message' => 'User created successfully', $user], 201);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6',
            'age' => 'required|integer|min:1',
        ]);

        $user->update($request->all());
        return response()->json(['message' => 'User update successfully', $user], 201);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }
}
