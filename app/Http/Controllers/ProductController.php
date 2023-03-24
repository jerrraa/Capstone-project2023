<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $categories = Category::all()->sortBy('name');
        $items = Item::all()->sortBy('title');
        return view('products.index')->with('categories',$categories)->with('items',$items);
    }
   
    public function edit($id) {

    }

    public function details($item_id, $category_id) {
        $item = Item::find($item_id);
        $category = Category::where('id', $category_id)->first();
        return view('products.details')->with('item', $item)->with('categories', $category);
    }
    
    public function select($id)
    {
        $categories = Category::all()->sortBy('name');
        $items = Item::where('category_id', $id)->get();
        return view('products.select', compact('categories', 'items'));
    }
    

    public function create()
    {
        $categories = Category::all()->sortBy('name');
        return view('products.create')->with('categories',$categories);
    }



}
