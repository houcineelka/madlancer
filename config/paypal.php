<?php
/**
 * PayPal Setting & API Credentials
 * Created by Raza Mehdi <srmk@outlook.com>.
 */

return [
    'mode'    => env('PAYPAL_MODE', 'sandbox'), // Can only be 'sandbox' Or 'live'. If empty or invalid, 'live' will be used.
    'sandbox' => [
        'client_id'         => 'ARBS-RuYhqBHHfqfjTH1eBVJigAyv5tVElLaUe35LPyI6C76V5LfsHzG7rLIFY8uizZM_YgoipE9VIcg',
        'client_secret'     => 'EEFarubQ1ESmIVkIpn-3Wf-j-m7dbnBPMsLrSC7dk8s4N767DbrYDHHpCW_7zoi8BKDr90kUFB9P_pfi',
        'app_id'            => '',
    ],
    'live' => [
        'client_id'         => '',
        'client_secret'     => '',
        'app_id'            => '',
    ],

    'payment_action' => 'Order', // Can only be 'Sale', 'Authorization' or 'Order'
    'currency'       => 'USD',
    'notify_url'     => '', // Change this accordingly for your application.
    'locale'         => 'en_US', // force gateway language  i.e. it_IT, es_ES, en_US ... (for express checkout only)
    'validate_ssl'   => false, // Validate SSL when creating api client.
];
