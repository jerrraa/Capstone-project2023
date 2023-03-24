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
Item List
@endsection

@section('pagename')
Laravel Project
@endsection

@section('content')
	
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<h1>Category List</h1>
		</div>
		<div class="col-md-2">
			<a href="{{ route('categories.create') }}" class="btn btn-lg btn-block btn-primary btn-h1-spacing">Add Category</a>
		</div>
		<div class="col-md-12">
			<hr />
		</div>
	</div>

	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<table class="table">
				<thead>
					<th>#</th>
					<th>Name</th>
					<th>Created At</th>
					<th>Last Modified</th>
					<th></th>
				</thead>
				<tbody>
					@foreach ($categories as $category)
						<tr>
							<th>{{ $category->id }}</th>
							<td>{{ $category->name }}</td>
							
							<td style='width:100px;'>{{ date('M j, Y', strtotime($category->created_at)) }}</td>
							<td style='width:100px;'>{{ date('M j, Y', strtotime($category->updated_at)) }}</td>
							<td style='width:150px;'><div style='float:left; margin-right:5px;'><a href="{{ route('categories.edit', $category->id) }}" class="btn btn-success btn-sm">Edit</a></div><div style='float:left;'></div>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div> <!-- end of .col-md-8 -->
	</div>

@endsection