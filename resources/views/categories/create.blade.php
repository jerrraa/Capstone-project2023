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
Create Category
@endsection

@section('pagename')
Laravel Project
@endsection

@section('scripts')
{!! Html::script('/bower_components/parsleyjs/dist/parsley.min.js') !!}
@endsection

@section('css')
{!! Html::style('/css/parsley.css') !!}
@endsection

@section('content')
	
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<h1>Add New Category</h1>
			<hr/>

			{!! Form::open(['route' => 'categories.store', 'data-parsley-validate' => '', 
			                'files' => true]) !!}
			    
				{{ Form::label('name', 'Name:') }}
			    {{ Form::text('name', null, ['class'=>'form-control', 'style'=>'', 
			                                  'data-parsley-required'=>'', 
											  'data-parsley-maxlength'=>'100']) }}

			    {{ Form::submit('Create Category', ['class'=>'btn btn-success btn-lg btn-block', 'style'=>'margin-top:20px']) }}

			{!! Form::close() !!}

		</div>
	</div>

@endsection