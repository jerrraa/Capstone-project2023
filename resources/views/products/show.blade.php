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
Shopping Cart
@endsection

@section('pagename')
Laravel Project
@endsection

@section('content')
	
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<h1>Shopping Cart</h1>
      <hr />
		</div>
	</div>
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<table class="table">
				<thead>
					<th>#</th>
					<th>Item ID</th>
					<th>Price</th>
          <th>Quantity</th>

					<th></th>
				</thead>
				<tbody>
					@foreach ($products as $product)
    <tr>
        <th>{{ $product->id }}</th>
        <td>{{ $product->item_id }}</td>
        <td>${{ $product->price }}</td>
        <td>
            {!! Form::open(['route' => ['products.update', $product->id], 'method' => 'PUT']) !!}
                {{ Form::number('quantity', $product->quantity, ['class' => '', 'min' => 0]) }}
                {{ Form::submit('Update', ['class' => 'btn btn-warning']) }}
            {!! Form::close() !!}
        </td>
        <td>
            {!! Form::open(['route' => ['products.destroy', $product->id], 'method' => 'DELETE']) !!}
            {{ Form::submit('Remove', ['class' => 'btn btn-danger', 'style' => '', 'onclick' => 'return confirm("Are you sure you want to delete this item?")']) }}
            {!! Form::close() !!}
        </td>
    </tr>
    @endforeach

				</tbody>              
			</table>
		</div> <!-- end of .col-md-8 -->
      <div class="col-md-6 cd col-md-offset-2">
         <hr />
         <!-- i've used this resource to grab my subtotal.
          https://laravel.com/docs/5.6/collections#method-sum 
          as $products is a 'collection' of objects, i used the sum method to return price * quantity
          of everything in the database.
         -->
              <h3><strong>Total: </strong> ${{ $products->sum(function ($product) {
                return $product->price * $product->quantity; 
                }) }}
              </h3>
         <hr />
          <div class="row">
              <div class="col-md-8">
              {!! Form::open(['route' => ['check_order', $product->id], 'method' => 'POST']) !!}
                  {{ Form::label ('firstname', 'First Name:') }}
                  {{ Form::input('text', 'firstname', $product->firstname, ['class' => 'form-control']) }}
                  {{ Form::label ('lastname', 'Last Name:') }}
                  {{ Form::input('text', 'lastname', $product->lastname, ['class' => 'form-control']) }}
                  {{ Form::label ('email', 'Email:') }}
                  {{ Form::input('email', 'email', $product->email, ['class' => 'form-control']) }}
                  {{ Form::label ('phone', 'Phone:') }}
                  {{ Form::input('text', 'phone', $product->phone, ['class' => 'form-control']) }}

                  {{ Form::hidden('session_id', $_SESSION['session_id']) }}
                  {{ Form::hidden('ip_address', $_SESSION['ip_address']) }}
                  
              <hr/>
                  {{ Form::submit('Submit Order', ['class' => 'btn btn-primary btn-lg']) }}
              {!! Form::close() !!}

              </div>
          </div> 
	     </div> <!-- end of .col-md-6 -->
       <style>
        hr {
          height: 1px;
          background-color: black;
        }

      </style>

@endsection