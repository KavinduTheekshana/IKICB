<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Gallery;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::orderBy('category_name')->orderBy('created_at', 'desc')->get()
            ->groupBy('category_name');

        return view('frontend.gallery', compact('galleries'));
    }
}
