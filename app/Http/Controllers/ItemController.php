<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Item;
use Image;
use Storage;
use Session;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::orderBy('title','ASC')->paginate(10);
        return view('items.index')->with('items', $items);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all()->sortBy('name');
        return view('items.create')->with('categories',$categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        //dd(storage_path());;
        //validate the data
        // if fails, defaults to create() passing errors
        $this->validate($request, ['title'=>'required|string|max:255',
                                   'category_id'=>'required|integer|min:0',
                                   'description'=>'required|string',
                                   'price'=>'required|numeric',
                                   'quantity'=>'required|integer',
                                   'sku'=>'required|string|max:100',
                                   'picture' => 'required|image']); 

        //send to DB (use ELOQUENT)
        $item = new Item;
        $item->title = $request->title;
        $item->category_id = $request->category_id;
        $item->description = $request->description;
        $item->price = $request->price;
        $item->quantity = $request->quantity;
        $item->sku = $request->sku;

        //refer to this website i used to implemenet the resize feature.
        //https://www.laravelcode.com/post/laravel-8-image-resize-and-upload-with-intervention-image

        if ($request->hasFile('picture')) {
            $image = $request->file('picture');
        
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location ='images/items/' . $filename;
            //we'll store our image we inserted into the public folder.
            $image = Image::make($image);
            Storage::disk('public')->put($location, (string) $image->encode());
        
            //we'll create a thumbnail image to be stored.
            //with a width/height of 80px.
            $thumbnail = Image::make($image);
            $thumbnail->resize(80, 80, function ($constraint) {
                $constraint->aspectRatio();
            });
            //name our filename with the prefix of tn_.
            $thumbnail_location = 'images/items/tn_' . $filename;
            //then store it with our new name.
            Storage::disk('public')->put($thumbnail_location, (string) $thumbnail->encode());
            
            //after we created our thumbnail, we'll store it.
            $lrg_image = Image::make($image);
            //resize the 400px as before.
            $lrg_image->resize(400, 400, function ($constraint) {
                $constraint->aspectRatio();
            });
            //same as before, except we use lrg_ as our prefix.
            $larimg_location = 'images/items/lrg_' . $filename;
            Storage::disk('public')->put($larimg_location, (string)  $lrg_image->encode());
        
            $item->picture = $filename;
        }
        $item->save();

        Session::flash('success','The item has been added');

        //redirect
        return redirect()->route('items.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Item::find($id);
        $categories = Category::all()->sortBy('name');
        return view('items.edit')->with('item',$item)->with('categories',$categories);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //validate the data
        // if fails, defaults to create() passing errors
        $item = Item::find($id);
        $this->validate($request, ['title'=>'required|string|max:255',
                                   'category_id'=>'required|integer|min:0',
                                   'description'=>'required|string',
                                   'price'=>'required|numeric',
                                   'quantity'=>'required|integer',
                                   'sku'=>'required|string|max:100',
                                   'picture' => 'sometimes|image']);             

        //send to DB (use ELOQUENT)
        $item->title = $request->title;
        $item->category_id = $request->category_id;
        $item->description = $request->description;
        $item->price = $request->price;
        $item->quantity = $request->quantity;
        $item->sku = $request->sku;
        //copied pasted from the store function.
        if ($request->hasFile('picture')) {
            
            $image = $request->file('picture');
            //in order to prevent images from building up if you update it
            //it'll overwrite the original file w/ new images or orginial image.
            $oldfilename = $item->picture;
            Storage::delete('public/images/items/tn_'. $oldfilename); 
            Storage::delete('public/images/items/lrg_'. $oldfilename);   
            Storage::delete('public/images/items/'. $oldfilename);     


            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location ='images/items/' . $filename;
            //we'll store our image we inserted into the public folder.
            $image = Image::make($image);
            Storage::disk('public')->put($location, (string) $image->encode());
        
            if (isset($item->picture)) {
                $oldFilename = $item->picture;
                Storage::delete('public/images/items/'.$oldFilename);                
            }

            //we'll create a thumbnail image to be stored.
            //with a width/height of 80px.
            $thumbnail = Image::make($image);
            $thumbnail->resize(80, 80, function ($constraint) {
                $constraint->aspectRatio();
            });
            //name our filename with the prefix of tn_.
            $thumbnail_location = 'images/items/tn_' . $filename;
            //then store it with our new name.
            Storage::disk('public')->put($thumbnail_location, (string) $thumbnail->encode());
            
            //after we created our thumbnail, we'll store it.
            $lrg_image = Image::make($image);
            //resize the 400px as before.
            $lrg_image->resize(400, 400, function ($constraint) {
                $constraint->aspectRatio();
            });
            //same as before, except we use lrg_ as our prefix.
            $larimg_location = 'images/items/lrg_' . $filename;
            Storage::disk('public')->put($larimg_location, (string)  $lrg_image->encode());
        
            $item->picture = $filename;
        }
        $item->save();

        Session::flash('success','The item has been updated.');

        //redirect
        return redirect()->route('items.index');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Item::find($id);
        if (isset($item->picture)) {
            $oldFilename = $item->picture;
            Storage::delete('public/images/items/'.$oldFilename);  
            //removes the prefixs so it'll remove all pictures in the folder.
            // for lrg_ prefix
            Storage::delete('public/images/items/lrg_'.$oldFilename);
            // for tn_ prefix
            Storage::delete('public/images/items/tn_'. $oldFilename);           
        }
        $item->
        $item->delete();

        Session::flash('success','The item has been deleted');

        return redirect()->route('items.index');

    }
}
