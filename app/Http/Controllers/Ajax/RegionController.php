<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegionController extends Controller
{

// произведет выборку Родителей, если они есть
    public function get(Request $request): array
    {
    	$parent = $request->get('parent') ?: null;

    	return Region::where('parent_id', $parent)
    		->orderBy('name')
    		->select('id', 'name')
    		->get()
    		->toArray();
    }
}
