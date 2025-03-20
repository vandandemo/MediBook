<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Receptionist;

class ReceptionistController extends Controller
{

    public function index()
    {
        $receptionists = Receptionist::paginate(10);
        return view('admin.receptionists.index', compact('receptionists'));
    }

    public function create()
    {
        return view('admin.receptionists.create');
    }

public function storeReceptionist(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:receptionists,email',
        'employee_id' => 'required|string|unique:receptionists,employee_id',
        'shift' => 'required|string|max:50',
    ]);

    $validated['password'] = Hash::make('password123'); // Default password

    $receptionist = Receptionist::create($validated);

    return redirect()->route('admin.receptionists.index')
        ->with('success', 'Receptionist created successfully.');
}

}
