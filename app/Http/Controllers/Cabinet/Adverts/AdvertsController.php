<?php

namespace App\Http\Controllers\Cabinet\Adverts;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Middleware\FilledProfile;

class AdvertsController extends Controller
{

	public function __construct()
	{
		$this->middleware(FilledProfile::class); 
		//$this->middleware(FilledProfile::class)->only(['create']); // этот класс middleware только к action create
		//$this->middleware(FilledProfile::class)->except(['delete']); // этот класс middleware ко всем кроме action delete
	}

    public function index()
    {
    	return view('cabinet.adverts.index');
    }
}
