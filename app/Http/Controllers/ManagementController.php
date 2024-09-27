<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class ManagementController extends Controller
{
    public function pageCreateBook(){
        $categories = Category::all();
        return view('management.book.create',['categories' => $categories]);
    }
}
