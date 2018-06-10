<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use \HapiClient\Http;
use \HapiClient\Hal;

class SlimPayController extends Controller
{
    public function sdd()
    {

		// The HAPI Client
		$hapiClient = new Http\HapiClient(
		    'https://api.preprod.slimpay.com',
		    '/',
		    'https://api.slimpay.net/alps/v1',
		    new Http\Auth\Oauth2BasicAuthentication(
		        '/oauth/token',
		        env('SLIMPAY_CREDITOR'),
		        env('SLIMPAY_SECRET')
		    )
		);

		// The Relations Namespace
		$relNs = 'https://api.slimpay.net/alps#';

		// Follow create-orders
		$rel = new Hal\CustomRel($relNs . 'create-orders');
		$follow = new Http\Follow($rel, 'POST', null, new Http\JsonBody(
		[
		    'started' => true,
		    'creditor' => [
		        'reference' => env('SLIMPAY_CREDITOR')
		    ],
		    'subscriber' => [
		        'reference' => 'theSubscriberReference'
		    ],
		    'items' => [
		        [
		            'type' => 'signMandate',
		            'autoGenReference' => true,
		            'mandate' => [
		                'signatory' => [
		                    'billingAddress' => [
		                        'street1' => '27 rue des fleurs',
		                        'street2' => 'Bat 2',
		                        'city' => 'Paris',
		                        'postalCode' => '75008',
		                        'country' => 'FR'
		                    ],
		                    'honorificPrefix' => 'Mr',
		                    'familyName' => 'Doe',
		                    'givenName' => 'John',
		                    'email' => 'change.me@slimpay.com',
		                    'telephone' => '+33612345678'
		                ],
		                'standard' => 'SEPA'
		            ]
		        ]
		    ]
		]
		));

		try {
		    $res = $hapiClient->sendFollow($follow);
		    $url = $res->getLink('https://api.slimpay.net/alps#user-approval')->getHref();
		    header('Location:' . $url);
		    exit;
		} catch (\HapiClient\Exception\HttpException $e) {
		    $log = 'Error - ' . $e->getStatusCode() . ' ' . $e->getReasonPhrase() .
		            ' - ' . $e->getResponseBody();
		    echo $log;
		}
    }


    public function card()
    {
    	// The HAPI Client
		$hapiClient = new Http\HapiClient(
		    'https://api.preprod.slimpay.com',
		    '/',
		    'https://api.slimpay.net/alps/v1',
		    new Http\Auth\Oauth2BasicAuthentication(
		        '/oauth/token',
		        env('SLIMPAY_CREDITOR'),
		        env('SLIMPAY_SECRET')
		    )
		);

		$rel = new Hal\CustomRel('https://api.slimpay.net/alps#create-orders');
		$follow = new Http\Follow($rel, 'POST', null, new Http\JsonBody(
		[
		    'started' => true,
		    'locale' => null,
		    'paymentScheme' => 'CARD',
		    'creditor' => [
		        'reference' => env('SLIMPAY_CREDITOR')
		    ],
		    'subscriber' => [
		        'reference' => 'theSubscriberReference'
		    ],
		    'items' => [
		        [
		            'type' => 'cardAlias'
		        ]
		    ]
		]
		));
		$order = $hapiClient->sendFollow($follow);
		$orderReference = $order->getState()['reference'];

		$url = $order->getLink('https://api.slimpay.net/alps#user-approval')->getHref();
		header('Location: ' . $url);
		exit;
    }
}
