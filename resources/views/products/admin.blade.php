<h1>ADMIN PAGE</h1>

<h1>completed orders</h1>

@foreach($orders as $order)
    <h3><a href = "{{route('selectable', $order->id)}}">Order ID: {{$order->id}}</a></h3>
    <h3>Name: {{$order->firstname}} {{$order->lastname}}</h3>
    <h3>Email: {{$order->email}}</h3>
    <hr />
@endforeach