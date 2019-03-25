<?php

namespace App\Http\Controllers\Cabinet;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class ProfileController extends Controller
{
    public function index()
    {
    	$user = Auth::user();

    	return view('cabinet.profile.home', compact('user'));
    }

    public function edit()
    {
    	// тут user берется напрямую из аунтификации
    	// раз он залогинин, то его данные можно дернуть
    	$user = Auth::user();

    	return view('cabinet.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
    	$this->validate($request, [
    		'name' => 'required|string|max:255',
    		'last_name' => 'required|string|max:255',
    	]);

    	$user = Auth::user();

    	$user->update($request->only('name', 'last_name'));

    	return redirect()->route('cabinet.profile.home');
    }
}