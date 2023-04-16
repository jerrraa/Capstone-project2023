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
Edit Item
@endsection

@section('pagename')
Laravel Project
@endsection

@section('scripts')
{!! Html::script('/bower_components/parsleyjs/dist/parsley.min.js') !!}
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script>
    $(document).ready(function() {
        $('#description').summernote();
    });
</script>
@endsection

@section('css')
{!! Html::style('/css/parsley.css') !!}
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@endsection

@section('content')

	<div class="row">
		{!! Form::model($item, ['route' => ['items.update', $item->id], 'method'=>'PUT', 'data-parsley-validate' => '', 'files' => true]) !!}
		<div class="col-md-6 col-md-offset-2">

			<h1>Edit Post</h1>
			<hr/>

			{{ Form::label('title', 'Name:') }}
			    {{ Form::text('title', null, ['class'=>'form-control', 'style'=>'', 
			                                  'data-parsley-required'=>'', 
											  'data-parsley-maxlength'=>'255']) }}

				{{ Form::label('category_id', 'Category:', ['style'=>'margin-top:20px']) }}
				<select name='category_id' class='form-control' data-parsley-required="true">
					<option value="">Select Category</option>
					@foreach ($categories as $category)
						<option value='{{ $category->id }}' {{ ($category->id == $item->category_id) ? " selected " : "" }}>{{ $category->name }}</option>
					@endforeach
				</select>

			    {{ Form::label('description', 'Description:', ['style'=>'margin-top:20px']) }}
			    {{ Form::textarea('description', null, ['class'=>'form-control', 
				                                 'data-parsley-required'=>'']) }}

				{{ Form::label('price', 'Price:', ['style'=>'margin-top:20px']) }}
			    {{ Form::text('price', null, ['class'=>'form-control', 'style'=>'', 
			                                  'data-parsley-required'=>'']) }}

				{{ Form::label('quantity', 'Quantity:', ['style'=>'margin-top:20px']) }}
			    {{ Form::text('quantity', null, ['class'=>'form-control', 'style'=>'', 
											  'data-parsley-required'=>'']) }}
											  
				{{ Form::label('sku', 'SKU:', ['style'=>'margin-top:20px']) }}
			    {{ Form::text('sku', null, ['class'=>'form-control', 'style'=>'', 
											  'data-parsley-required'=>'']) }}

				@if ($item->picture != "")
				    <p style='margin-top:20px'>Current Image:<br><img src="{{ Storage::url('images/items/'.$item->picture) }}" style='height:100px;' ></p>
			    @endif

				{{ Form::label('picture', 'Picture:', ['style'=>'margin-top:20px']) }}
			    {{ Form::file('picture', null, ['class'=>'form-control', 
				                                       'style'=>'',
													   'data-parsley-required'=>'']) }}
		
		</div>
		<div class="col-md-4">
			<div class="well" style="margin-top: 20px">
				<dl class="dl-horizontal">
					<dt>Created At:</dt>
					<dd>{{ date('M j, Y h:ia', strtotime($item->created_at)) }}</dd>
				</dl>
				<dl class="dl-horizontal">
					<dt>Last Updated:</dt>
					<dd>{{ date('M j, Y h:ia', strtotime($item->updated_at)) }}</dd>
				</dl>
				<hr />
				<div class="row">
					<div class="col-sm-6">
						{!! Html::linkRoute('items.index', 'Cancel', [$item->id], ['class'=>'btn btn-danger btn-block']) !!}
					</div>
					<div class="col-sm-6">
					    {{ Form::submit('Save Changes', ['class'=>'btn btn-success btn-block', 'style'=>'margin-top:0px']) }}
					</div>
				</div>
			</div>		
		</div>
		{!! Form::close() !!}
	</div>


@endsection