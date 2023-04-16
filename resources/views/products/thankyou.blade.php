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

    if (!isset($_SESSION['session_id'])) {
        return redirect('/products');
    }


?>
@section('pagetitle')
Thank you!
@endsection

@section('pagename')
Laravel Project
@endsection

@section('content')
	
	<div>
        <div>
            <h1>Thank you!</h1>
      <hr />
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <h2>Order Summary</h2>
            <hr />
            @foreach ($sold as $solds)
            <h5><strong> ID: </strong>{{$solds->id}}</h5>
            <h5><strong> Item ID: </strong>{{$solds->item_id}}</h5>
            <h5><strong> Item Price: </strong>{{$solds->item_price}}</h5>
            <h5><strong> Quantity: </strong>{{$solds->quantity}}</h5>
            <hr />
            @endforeach
        </div>
        <div class="col-md-4">
            <h2>Order Details</h2>
            <h4><strong>ID: </strong>{{$orders->id}} </h4>
            <h4><strong> First Name: </strong>{{$orders->firstname}}</h4>
            <h4><strong> Last Name: </strong>{{$orders->lastname}}</h4>
            <h4><strong> Email: </strong>{{$orders->email}}</h4>
            <h4><strong> Number: </strong>{{$orders->phone}}</h4>

            <h3><strong>Total: </strong> ${{ $sold->sum(function ($solds) {
                return $solds->item_price;
            }) }}</h3>
            
            <hr />
   
        </div>
    </div>
    <style>
        hr {
          height: 1px;
          background-color: black;
        }

      </style>
    





@endsection