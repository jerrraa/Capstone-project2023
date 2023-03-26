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
Details Page
@endsection

@section('pagename')
Laravel Project
@endsection

@section('css')
{!! Html::style('/css/parsley.css') !!}
@endsection

@section('content')
   <body>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <img src="{{ Storage::url('images/items/lrg_'.$item->picture) }}" style='' >
                <h1>{{ $item->title }}</h1>
                <hr/>
                <h3><strong>Product ID: </strong>{{ $item->id }}</h3>
                <h3><strong>Category: </strong>{{$categories->name}}
                <h3><strong>Description: </strong> {{ $item->description }}</h3>
                <h3><strong>Price: </strong>${{ $item->price }}</h3>
                <h3><strong>Quantity: </strong> {{ $item->quantity }}</h3>
                <h3><strong>SKU: </strong> {{ $item->sku }}</h3>

                <hr/>
                <style>
                  hr {
                    height: 1px;
                    background-color: black;
                  }

                </style>
            </div>
        </div>
    </div>
   </body>




@endsection