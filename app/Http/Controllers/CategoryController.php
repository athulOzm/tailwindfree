<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(\App\Models\Category $category){

        return view('category.Index', ['categories' => $category->orderBy('order', 'DESC')->get()]);
    }

    public function store(Request $request){

         
        Category::create([
            'name'  =>  $request->name,
            'parant_id' =>  $request->parant,
            'slug'  =>  Str::slug($request->name),
            'order'  =>   $request->order
        ]);

        return redirect(route('category.index'));
    }

    public function delete(Request $request){

        Category::find($request->id)->delete();
        return redirect(route('category.index'));
    }

    public function getAll(Category $category){

        return response($category->with('posts')->get(), 200);
    }

    public function getPosts($category){

        $category = Category::where('slug', $category)->first();
        return response($category->posts, 200);
    }
}
