<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\ItemsSold;


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

    public function show($id) {
    // it'll transfer all the data in the shopping_cart database.
        $products = Product::all();
        return view('products.show')->with('products', $products);
    }
    
    public function create() {
    }
    public function store(Request $request) {
        // validate the data.
         $this->validate($request, [
             'item_id' => 'required|integer',
             'session_id' => 'required|string',
             'ip_address' => 'required|string',
             'quantity' => 'required|integer'
         ]);
         //we'll transfer item id, session id,, addess session and quantity to the view.
         $pcart = new Product;
         $pcart->item_id = $request->item_id;
         $pcart->session_id = $request->session_id;
         $pcart->ip_address = $request->ip_address;
         $pcart->price = $request->price;
         $pcart->quantity = $request->quantity;
         $pcart->save();
 
         //this will gather the items from the products page into our shop page.
         //it'll direct to SHOW function first and then to SHOP.
         return redirect()->route('products.shop');
 
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

    public function destroy($id) {
        //i assumed there weren't any validation so i didn't add it.
        //deletes all items in the database relating to the id.
        $products = Product::find($id);
        $products->delete();

        return redirect()->route('products.shop');

    }

    public function update(Request $request, $id) {
        //validate only the quanity. as it's only changable in the shop page.
        $this->validate($request, [
            'quantity' => 'required|integer'
        ]);
    //replace the current quantity with the new quantity.
        $products = Product::find($id);
        $products->quantity = $request->quantity;
    //save new quantity. if successful it'll update.
        $products->save();

        return redirect()->route('products.shop');

    }
    public function check_orders(Request $request) {

        //validate the data
        $this->validate($request, [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'phone' => 'required|string|max:10',
            'email' => 'required|string|email|max:255',
        ]);
        //we'll transfer all the data to our order table.

        $order = new Order;
        $order->firstname = $request->firstname;
        $order->lastname = $request->lastname;
        $order->phone = $request->phone;
        $order->email = $request->email;
        $order->session_id = $request->session_id;
        $order->ip_address = $request->ip_address;
        $order->save();

    
        $products = Product::all();
        $orderid = $order->id;
        $total = 0;
        //we'll use a foreach loop to transfer all the data from the shopping cart to the items sold table.
        //by using total we can grab our real total price of each item.
        foreach($products as $product) {
            $sold = new ItemsSold;
            $sold->item_id = $product->item_id;
            $sold->order_id = $orderid;

            $total = $product->price * $product->quantity;

            $sold->item_price = $total;
            $sold->quantity = $product->quantity;
            $sold->save();
         }
        //$total = 0;
         
        //this will delete all the items in the shopping cart.
        Product::truncate();

        $orders = Order::find($orderid);
        $sold = ItemsSold::where('order_id', $orderid)->get();
        return view('products.thankyou')->with('orders', $orders)->with('sold', $sold);
    }

    public function admin() {
        //we'll transfer all the data from the items sold table to the admin page.
        $orders = Order::all();
        return view('products.admin')->with('orders', $orders);
        
    }

    public function selectables($id) {
        //doesn't work as it doesn't want to select thank you.
        $orders = Order::find($id);
        $sold = ItemsSold::where('order_id', $id)->get();
        return view('products.thankyou')->with('orders', $orders)->with('sold', $sold);
    }
    
}
