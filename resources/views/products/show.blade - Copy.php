<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Stripe Charge</title>

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
                    QTY: <input type="number" value="1" min="1">
                </div>
                
                
                <form action="/payment/process-payment/{{$product->price}}" method="POST" id="subscribe-form">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="subscription-option">
                                    <label for="plan-silver">
                                        <span class="plan-price">${{$product->price}}</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <label for="card-holder-name">Card Holder Name</label>
                    <input id="card-holder-name" type="text" value="">
                    @csrf
                    <div class="form-row">
                        <label for="card-element">Credit or debit card</label>
                        <div id="card-element" class="form-control">   </div>
                        <!-- Used to display form errors. -->
                        <div id="card-errors" role="alert"></div>
                    </div>
                    <div class="form-group text-center">
                        <button type="button"  id="card-button" data-secret="{{ $intent->client_secret }}" class="btn btn-lg btn-success btn-block">SUBMIT</button>
                    </div>
                </form>

            </div>
        </section>

        <!-- script tags -->
        <script src="{{ env('APP_URL') }}/js/cart.js"></script>

        <script src="https://js.stripe.com/v3/"></script>
        <script>
            var stripe = Stripe('pk_test_WXxUiqrkKjNPNUZNIjV5MM2J004t0cmwiK');
            var elements = stripe.elements();
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
            var card = elements.create('card', {hidePostalCode: true, style: style});
            card.mount('#card-element');
            console.log(document.getElementById('card-element'));
            card.addEventListener('change', function (event) {
                var displayError = document.getElementById('card-errors');
                if (event.error) {
                    displayError.textContent = event.error.message;
                } else {
                    displayError.textContent = '';
                }
            });
            const cardHolderName = document.getElementById('card-holder-name');
            const cardButton = document.getElementById('card-button');
            const clientSecret = cardButton.dataset.secret;
            cardButton.addEventListener('click', async (e) => {
                console.log("attempting");
                const {setupIntent, error} = await stripe.confirmCardSetup(
                        clientSecret, {
                            payment_method: {
                                card: card,
                                billing_details: {name: cardHolderName.value}
                            }
                        }
                );
                if (error) {
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = error.message;
                } else {
                    paymentMethodHandler(setupIntent.payment_method);
                }
            });
            function paymentMethodHandler(payment_method) {
                var form = document.getElementById('subscribe-form');
                var hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'payment_method');
                hiddenInput.setAttribute('value', payment_method);
                form.appendChild(hiddenInput);
                form.submit();
            }
        </script>
    </body>
</html>
