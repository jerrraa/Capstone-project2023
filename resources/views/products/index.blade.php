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

<!-- resources/views/products/index.blade.php -->
@section('content')

  <div class="container">
    <div class="row">
      <div class="col-md-2">
        <h2>Categories</h2>
          <b>Select one of the categories below to fliter your products.<b>
        <hr/>
        <ul class="list-group">
          @foreach ($categories->take(10) as $category)
            <li class="list-group-item"><a href="{{ route('products.select', $category->id) }}">{{ $category->name }}</a></li>
          @endforeach
        </ul>
      </div>
      <div class="col-md-9">
        <h2>View Products</h2>
        <hr>
        <table class="table">
          <thead>
            <tr>
              <th>Thumbnail</th>
              <th>Title</th>
              <th>Price</th>
              <th>Purchase</th>
              <th>Add to Cart</th>
            </tr>
          </thead>
          <tbody>
            
            @foreach ($items as $item)
              <tr>
                <td><a href="{{ route('products.details', [$item->id, $item->category->id]) }}">
                <img src="{{ Storage::url('images/items/tn_'.$item->picture) }}" style=''></a></td>
                <td><a href="{{ route('products.details', [$item->id, $item->category->id]) }}">{{ $item->title}}</a></td>
                <td>${{ $item->price }}</td>
           
                <td>
                  <a href="" class="btn btn-primary">Buy Now</a>
                <td>        
              {!! Form::open(['route' => 'products.store', 'data-parsley-validate' => '', 'files' => true]) !!}
                  {{ Form::hidden('item_id', $item->id) }}
                  {{ Form::hidden('session_id', $_SESSION['session_id']) }}
                  {{ Form::hidden('ip_address', $_SESSION['ip_address']) }}
                  {{ Form::hidden('price', $item->price) }}
                  {{ Form::hidden('quantity', 1) }}
                
                  {{ Form::submit('Add to Cart', ['class' => 'btn btn-success']) }}
              {!! Form::close() !!}
                
              

                  

              
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    <style>
      hr {
        height: 1px;
        background-color: black;
      }

    </style>
  </div>
@endsection

