<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="{{ env('APP_URL') }}/css/products.css" rel="stylesheet">
        <!-- Styles -->
    </head>
    <body style="padding: 5%">
        
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
                <button type="button" name="item-1-button" id="item-1-button">Buy Now</button>
              </div>
            </div>
            @endforeach
        </div>    
    </body>
</html>
