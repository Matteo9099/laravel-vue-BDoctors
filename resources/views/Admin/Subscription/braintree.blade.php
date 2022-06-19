<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Bronze Subscription</title>
</head>
<body class="h-full grid place-items-center">
{{--form pagamento bronze--}}
<div class="w-50 mx-auto">
    <form method="POST" id="payment-form" action="{{route('admin.subscription.checkout', $type->price)}}">
        @csrf
        <h1 class="text-center text-2xl text-gray-800">Il tuo abbonamento <span class="uppercase block">{{$type->name}}</span></h1>
        <section class="mt-6 mb-3">
            <label for="amount" class="flex justify-center space-x-2">
                <span class="input-label text-gray-800 text-lg">Prezzo:</span>
                <span class="text-lg text-gray-800">{{$type->price}} &euro; </span>
            </label>

            <div class="bt-drop-in-wrapper">
                <div id="bt-dropin"></div>
            </div>
        </section>

        <input id="nonce" name="payment_method_nonce" type="hidden" />
        <div class="flex justify-center">
            <button class="disabled:opacity-75 button border-2 px-1 py-2 rounded-lg hover:bg-black hover:text-white hover:border-white" type="submit"><span>Paga Ora</span></button>
        </div>

    </form>
</div>
{{--    script braintree--}}
<script src="https://js.braintreegateway.com/web/dropin/1.33.1/js/dropin.min.js"></script>
<script>
    var form = document.querySelector('#payment-form');
    var client_token = "{{$token}}";

    braintree.dropin.create({
        authorization: client_token,
        selector: '#bt-dropin',
        paypal: {
            flow: 'vault'
        }
    }, function (createErr, instance) {
        if (createErr) {
            console.log('Create Error', createErr);
            return;
        }
        form.addEventListener('submit', function (event) {
            event.preventDefault();
            let button = document.querySelector('button');
            button.disabled=true;
            instance.requestPaymentMethod(function (err, payload) {
                if (err) {
                    console.log('Request Payment Method Error', err);
                    return;
                }

                // Add the nonce to the form and submit
                document.querySelector('#nonce').value = payload.nonce;
                form.submit();
            });
        });
    });
</script>
</body>
</html>
