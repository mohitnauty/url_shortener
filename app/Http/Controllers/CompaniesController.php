<?php

namespace App\Http\Controllers;

use App\Models\Companies;
use App\Models\Roles;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CompaniesController extends Controller
{
    public function create()
    {
        return view('companies.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255'
        ]);

        Companies::create([
            'name'  => $request->name
        ]);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Company created successfully');
    }
    public function invite(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('companies.invite');
        }

        $request->validate([
            'name'  => 'required|string',
            'email' => 'required|email',
        ]);

        //check email is exits or not
        $userExists = User::where('email', $request->email)->first();
        if ($userExists) {
            return redirect()
                ->route('companies.invite')
                ->with('error', 'Email already exists');
        }
        DB::transaction(function () use ($request) {
            $company = Companies::create([
                'name' => $request->name,
            ]);

            $user = User::create([
                'name'       => $request->name,
                'email'      => $request->email,
                'password'   => Hash::make('123456'),
                'company_id' => $company->id,
            ]);

            $role = Roles::firstOrCreate([
                'name' => 'Admin',
            ]);

            $user->roles()->attach($role->id);
        });


        return redirect()
            ->route('dashboard')
            ->with('success', 'Invitation sent successfully');
    }

    public function admin(Request $request)
    {
        if ($request->isMethod('get')) {
            $roles = Roles::where('name', '!=', 'SuperAdmin')
                        ->orderBy('name')
                        ->get();            
            return view('companies.admin', compact('roles'));
        }

        $request->validate([
            'name'  => 'required|string',
            'email' => 'required|email|unique:users,email',
            'role'  => 'required|exists:roles,id',
        ]);

        $userExists = User::where('email', $request->email)->first();
        if ($userExists) {
            return redirect()
                ->route('companies.invite')
                ->with('error', 'Email already exists');
        }

        DB::transaction(function () use ($request) {
        
            $user = User::create([
                'name'       => $request->name,
                'email'      => $request->email,
                'password'   => Hash::make('123456'),
                'company_id' => auth()->user()->company_id,
            ]);

            $role = Roles::firstOrCreate([
                'id' => $request->role,
            ]);

            $user->roles()->attach($role->id);
        });


        return redirect()
            ->route('dashboard')
            ->with('success', 'Invitation sent successfully');
    }
}
