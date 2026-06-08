<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('id', 'desc')->get();
        // dd($categories);
        // $category = Category::find(2);
        // dd($category->products);
        return view('categories.list', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store()
    {
        
        // dd(request()->all());
        Category::create(
            [
                'name' => request()->name,
                'dec' => request()->dec,
            ]
        );

        // return view('categories.list'); XXXXXX don't do this 
        return redirect('/categories');
    }

    public function edit($id)
    {
        $category = Category::find($id);
        // dd($category);
        return view('categories.edit', compact('category'));
    }

    public function update($id)
    {
        // dd(request()->all());
        $category = Category::find($id);
        $category->update(
            [
                'name' => request()->name,
                'dec' => request()->dec,
            ]
        );

        return redirect('/categories');
    }

    public function destroy($id)
    {
        // dd($id);
        $category = Category::find($id);
        $category->delete();
        return redirect('/categories');
    }
}
