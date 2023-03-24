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
        //we pass a item id and category id, that's used to display the item details.
        $item = Item::find($item_id);
        $category = Category::where('id', $category_id)->first();
        //if processed correctly it'll show a page w/ the item name, id...
        return view('products.details')->with('item', $item)->with('categories', $category);
    }
    
    public function select($id)
    {
        //we'll transfer both categories and items to the view.
        $categories = Category::all()->sortBy('name');
        $items = Item::where('category_id', $id)->get();
        //this will gather the items from the category that was selected.
        return view('products.select', compact('categories', 'items'));
    }
    

    public function create()
    {
        $categories = Category::all()->sortBy('name');
        return view('products.create')->with('categories',$categories);
    }



}
