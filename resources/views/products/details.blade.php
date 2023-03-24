@extends('common')
<?php
//this is featured in every public page.

  session_start();
  // we'll generate a session_id if one doesn't exist by creating a unique id.
  if (!isset($_SESSION['session_id'])) {
    $_SESSION['session_id'] = uniqid();
  }
  //check if it's empty and if it is, set the session to the address.
  if (!isset($_SESSION['ip_address'])) {
    $_SESSION['ip_address'] = $_SERVER['REMOTE_ADDR'];
  } else {
    //if it's not empty, check if the address is the same as the one in the session.
    if ($_SESSION['ip_address'] != $_SERVER['REMOTE_ADDR']) {
      //if it's not the same, destroy the session and start a new one.
      session_destroy();
      session_start();
      $_SESSION['session_id'] = uniqid();
      $_SESSION['ip_address'] = $_SERVER['REMOTE_ADDR'];
    }
  }

?>
@section('pagetitle')
Product Page
@endsection

@section('pagename')
Laravel Project
@endsection

@section('css')
{!! Html::style('/css/parsley.css') !!}
@endsection

@section('content')
   <!DOCTYPE html>
   <html lang="en">
   <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
   </head>
   <body>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
            </div>
            <div class="col-md-7">
                <img src="{{ Storage::url('images/items/'.$item->picture) }}" style='width:350px; height:350px;' >
                
                <h1>{{ $item->title }}</h1>
                <h2>--------------------</h2>
                <h3>Product ID: {{ $item->id }}</h3>
                <h3>Category: {{ $categories->name }}</h3>
                <h3>Description: {{ $item->description }}</h3>
                <h3>Price: ${{ $item->price }}</h3>
                <h3>Quantity: {{ $item->quantity }}</h3>
                <h3>SKU: {{ $item->sku }}</h3>
            </div>
        </div>
    </div>
   </body>
   </html>
@endsection