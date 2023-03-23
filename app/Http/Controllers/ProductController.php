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

    public function details($id) {
        $item = Item::find($id);
        $categories = Category::find($id);
        //in order to get the category name w/ item details, we'll pass both of them over.
        return view('products.details')->with('item', $item)->with('categories', $categories);
    }

    public function create()
    {
        $categories = Category::all()->sortBy('name');
        return view('products.create')->with('categories',$categories);
    }



}
