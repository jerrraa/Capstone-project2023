@extends('common')
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
                <h3>ID: {{ $item->id }}</h3>
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