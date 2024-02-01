@foreach($products as $product)
    <p>{{ $product->product_name }} - Stok: {{ $product->product_quantity }}, Terjual: {{ $product->total_sold }} items</p>
@endforeach
