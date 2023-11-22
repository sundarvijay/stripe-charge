<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Stripe Charge</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="{{ env('APP_URL') }}/css/products.css" rel="stylesheet">
        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Styles -->
        <script>
            function submit(id, key){
                window.location.href = '/products/'+id+'?key='+key
            }
        </script>
    </head>
    <body>
        
        <h1 align="center">Product List</h1>
        <div class="listing-section">
            @foreach ($products as $key => $product)
             <div class="product">
              <div class="image-box">
                <div class="images" id="image-{{ $key }}"></div>
              </div>
              <div class="text-box">
                <h2 class="item">{{ $product->name }}</h2>
                <h3 class="price">${{ $product->price }}</h3>
                <p class="description">{{ $product->description }}</p>
                <label for="item-1-quantity">Quantity:</label>
                <input type="text" name="item-1-quantity" id="item-1-quantity" value="1">
                <button type="button" name="item-1-button" onclick="submit({{$product->id}}, {{$key}})" id="item-1-button">Buy Now</button>
              </div>
            </div>
            @endforeach
            <div class="pagination" >
                {{ $products->links() }}
            </div>
        </div>  
    </body>
</html>
