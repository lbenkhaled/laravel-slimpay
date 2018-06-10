# laravel-slimpay
slimpay laravel integration

Required
- Laravel : 5.6
- PHP : 7+
- SlimPay credential--> https://dev.slimpay.com/hapi/login?signup

Edit composer.json file add this:

"require" :{
    ..............
    "slimpay/hapiclient": "1.*"
    }

composer install

composer update

See the my controller SlimPayController for example.

Dont forget to edit .env file an add:

SLIMPAY_CREDITOR=integration

SLIMPAY_SECRET=9#OR#OkgNhP9lig89laQFKD71t0C

Links:

https://dev.slimpay.com/hapi/guide/30-min-integration/easy-step-by-step

Thats it.
