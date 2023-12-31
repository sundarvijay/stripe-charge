<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Stripe Charge</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="{{ env('APP_URL') }}/css/cart.css" rel="stylesheet">
        <!-- Styles -->


    </head>
    <body>

        <div class="pagination">
            <p> <a href="{{env('APP_URL')}}">Home </a> > {{$product->name}} </p>
        </div>
        <!-- product section -->
        <section class="product-container">
            <!-- left side -->
            <div class="img-card">
                <img src="{{env('APP_URL')}}/img/image-{{ $_GET['key'] }}.jpg" alt="" id="featured-image">
            </div>
            <!-- Right side -->
            <div class="product-info">
                <h3>{{$product->name}}</h3>
                <h5>Price: ${{$product->price}}</h5>
                <p>{{$product->description}}</p>

                <div class="quantity">
                    QTY: <input type="number" value="1" min="1" id="qty">
                </div>
                
                <div>
                    <h2>Payment</h2>
                    <form action="/payment/process-payment/{{$product->price}}" method="POST" id="subscribe-form" class="form-group">
                        <input type="hidden" name="product" value=" {{$product->name}}">
                        <div class="row">
                            <div class="col-md-6">
                                <input id="card-holder-name" name="card-holder-name" placeholder="Name" type="text" value="" class="form-control">
                                @csrf
                            </div>
                        </div> <br>
                        <div class="row">
                            <div class="col-md-10">
                                <!-- Stripe Elements Placeholder -->
                                <div id="card-element" class="form-control"></div>
                            </div>
                        </div> <br>
                        <div class="row">
                            <div class="col-md-6">
                                <button id="card-button" type="button">
                                     Process Payment
                                 </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <!-- script tags -->
        <script src="{{ env('APP_URL') }}/js/cart.js"></script>

        <script src="https://js.stripe.com/v3/"></script>
 
        <script>
            const stripe = Stripe('{{env('STRIPE_KEY')}}');

            const elements = stripe.elements();
            
            var style = {
                base: {
                    color: '#32325d',
                    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                    fontSmoothing: 'antialiased',
                    fontSize: '16px',
                    '::placeholder': {
                        color: '#aab7c4'
                    }
                },
                invalid: {
                    color: '#fa755a',
                    iconColor: '#fa755a'
                }
            };
            
            const cardElement = elements.create('card', {hidePostalCode: true, style: style});

            cardElement.mount('#card-element');
            
            const cardHolderName = document.getElementById('card-holder-name');
            const cardButton = document.getElementById('card-button');

            cardButton.addEventListener('click', async (e) => {
                const { paymentMethod, error } = await stripe.createPaymentMethod(
                    'card', cardElement, {
                        billing_details: { name: cardHolderName.value }
                    }
                );

                if (error) {
                    // Display "error.message" to the user...
                } else {
                     paymentMethodHandler(paymentMethod.id);
                }
            });
            
            function paymentMethodHandler(payment_method) {
                var form = document.getElementById('subscribe-form');
                var hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'payment_method');
                hiddenInput.setAttribute('value', payment_method);
                form.appendChild(hiddenInput);
                
                var productName = document.createElement('input');
                productName.setAttribute('type', 'hidden');
                productName.setAttribute('name', 'qty');
                productName.setAttribute('value', document.getElementById("qty").value);
                form.appendChild(productName);
                
                form.submit();
            }
        </script>
    </body>
</html>
