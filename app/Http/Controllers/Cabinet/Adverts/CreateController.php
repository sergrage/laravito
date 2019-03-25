<?php

namespace App\Http\Controllers\Cabinet\Adverts;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entity\Adverts\Category;
use App\Entity\Region;

class CreateController extends Controller
{
    
    public function __constructor () {
        $this->middleware(['auth', FilledProfile::class]);
    }
    
    //  toTree()  метод трейта nestedSeeds
    public function category () {
        $categories = Category::defaultOrder()->withDepth()->get()->toTree();
        
        return view('cabinet.adverts.create.category', compact('categories'));
    }
    
    public function region (Category $category, Region $region = null) {
        $regions = Region::where('parent_id', $region ? $region->id : null)->orderBy('name')->get();
        
        return view('cabinet.adverts.create.region', compact('category', 'region', 'regions'));
    }   
    
    public function advert (Category $category, Region $region = null) {
        return view('cabinet.adverts.create.advert', compact('category', 'region'));
    }
}
