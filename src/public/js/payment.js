const stripe_public_key = "{{ config('stripe.stripe_public_key') }}"
const stripe = Stripe(stripe_public_key);
const elements = stripe.elements();

var cardNumber = elements.create('cardNumber');
cardNumber.mount('#card-number');
cardNumber.on('change', function(event) {
    var displayError = document.getElementById('card-errors');
    if (event.error) {
        displayError.textContent = event.error.message;
    } else {
        displayError.textContent = '';
    }
});

var cardExpiry = elements.create('cardExpiry');
cardExpiry.mount('#card-expiry');
cardExpiry.on('change', function(event) {
    var displayError = document.getElementById('card-errors');
    if (event.error) {
        displayError.textContent = event.error.message;
    } else {
        displayError.textContent = '';
    }
});

var cardCvc = elements.create('cardCvc');
cardCvc.mount('#card-cvc');
cardCvc.on('change', function(event) {
    var displayError = document.getElementById('card-errors');
    if (event.error) {
        displayError.textContent = event.error.message;
    } else {
        displayError.textContent = '';
    }
});

var form = document.getElementById('card-form');
form.addEventListener('submit', function(event) {
    event.preventDefault();
    var errorElement = document.getElementById('card-errors');
    if (event.error) {
        errorElement.textContent = event.error.message;
    } else {
        errorElement.textContent = '';
    }

    stripe.createToken(cardNumber).then(function(result) {
        if (result.error) {
            errorElement.textContent = result.error.message;
        } else {
            stripeTokenHandler(result.token);
        }
    });
});

function stripeTokenHandler(token) {
    var form = document.getElementById('card-form');
    var hiddenInput = document.createElement('input');
    hiddenInput.setAttribute('type', 'hidden');
    hiddenInput.setAttribute('name', 'stripeToken');
    hiddenInput.setAttribute('value', token.id);
    form.appendChild(hiddenInput);
    form.submit();
}