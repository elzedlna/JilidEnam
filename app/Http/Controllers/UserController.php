<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index()
{
    $users = User::all();
    
    return view('users.index', compact('users'));
}


    public function create()
{
    return view('users.create');
}

public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'custname' => 'required',
            'custemail' => 'required|email|unique:users,custemail',
            'custpassword' => 'required|min:8',
            'custphone' => 'required|string|min:10|max:15',  // Corrected line
            'custaddress' => 'required|string|max:255',      // Corrected line
        ]);




        // Insert data into the database using Eloquent
        User::create([
            'custname' => $request->custname,
            'custpassword' => Hash::make($request->custpassword),
            'custemail' => $request->custemail,
            'custphone' => $request->custphone,
            'usertype' => $request->usertype,
            'custaddress' => $request->custaddress,
        ]);

        // Redirect with success message
        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }


    public function show($custid)
{
    $user = User::find($custid);
    return view('users.show', compact('user'));
}



    public function edit($custid)
    {
        $user = User::find($custid);
        return view('users.edit', compact('user'));
    }


    public function update(Request $request, $custid)
{
    // Validate the request
    $request->validate([
        'custname' => 'required',
        'custemail' => 'required|email|unique:users,custemail,' . $custid . ',custid',
        'custpassword' => 'nullable|min:8',
        'custphone' => 'nullable|string|min:10|max:15',
        'custaddress' => 'nullable|string|max:255',
        'usertype' => 'required|string',
    ]);

    // Find the user
    $user = User::findOrFail($custid); // Use findOrFail to automatically handle not found

    // Update the user
    $user->update([
        'custname' => $request->custname,
        'custemail' => $request->custemail,
        'custpassword' => $request->custpassword ? Hash::make($request->custpassword) : $user->custpassword,
        'custphone' => $request->custphone,
        'custaddress' => $request->custaddress,
        'usertype' => $request->usertype,
    ]);

    // Redirect with success message
    return redirect()->route('users.index')->with('success', 'User updated successfully');
}





public function destroy($custid)
{
// Find the student
$user = User::find($custid);

// Check if the student exists
if (!$user) {
    return redirect()->route('users.index')->with('error', 'User not found.');
}
// Delete the student
$user->delete();

// Redirect with success message
return redirect()->route('users.index')->with('success', 'User deleted successfully.');

}

}
