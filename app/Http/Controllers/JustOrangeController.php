<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Product;
use App\Models\MetaSetting;
use Illuminate\Http\Request;

class JustOrangeController extends Controller
{
    public function index(): \Inertia\Response
    {
        $data['products'] = Product::where('active',true)->orderBy('id','desc')->get();
        return Inertia::render('justorange-default',$data);
    }
    
}
