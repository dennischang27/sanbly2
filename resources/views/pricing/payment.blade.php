<script src="https://js.stripe.com/v3/"></script>

        <script>
            let stripe = Stripe('{{ env('STRIPE_KEY',"") }}');
            @if($stripe_s)
                stripe.redirectToCheckout({
                    sessionId: <?= json_encode($stripe_s) ?>,
                }).then((result) => {

                });
            @endif
        </script>