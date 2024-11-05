<?php

namespace App\Http\Controllers;

use App\Models\Catalogue;
use App\Models\Category;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function home()
    {
        $pageName = 'Trang chủ';
        return view('web.home', compact('pageName'));
    }
    public function contact()
    {
        $pageName = 'Liên hệ';
        $settings = Setting::pluck('value', 'key');
        return view('web.contact', compact('pageName', 'settings'));
    }
}
