# laravel-slimpay
SlimPay laravel integration

Required
- Laravel : 5.6
- PHP : 7+
- SlimPay credential--> https://dev.slimpay.com/hapi/login?signup

Edit composer.json file add this:

"require" :{

    ..............
    
    "slimpay/hapiclient": "1.*"
    
    }

do composer install

composer update


See my controller SlimPayController for example.


Dont forget to edit .env file an add your credential:

SLIMPAY_CREDITOR=integration

SLIMPAY_SECRET=9#OR#OkgNhP9lig89laQFKD71t0C


Links:

https://dev.slimpay.com/hapi/guide/30-min-integration/easy-step-by-step

Thats it.
