<?php

require_once __DIR__ . '/../../../vendor/autoload.php';

$app = new Laravel\Lumen\Application(
    realpath(__DIR__ . '/../')
);

function build_response($request)
{
    return response()->json([
        'headers' => $request->header(),
        'query' => $request->query(),
        'json' => $request->json()->all(),
        'form_params' => $request->request->all(),
    ], $request->header('Z-Status', 200));
}

function stub($stub)
{
    return json_decode(file_get_contents(
        __DIR__ . '/stubs/' . $stub
    ), true);
}

function is_bar_user($request)
{
    $headers = $request->header();

    if (isset($headers['php-auth-user'])) {
        return $headers['php-auth-user'][0] == 'bar';
    }

    return false;
}

$app->get('/get', function () {
    return build_response(app('request'));
});

$app->get('auth', function () {
    return build_response(app('request'));
});

$app->post('payment_token', function () {
    return response()->json(
        stub('token_create_response.json')
    );
});

$app->post('charge', function () {
    return response()->json(
        stub('charge.json')
    );
});

$app->get('transfers/{id}', function ($id) {
    return response()->json(
        stub($id . '_transfer_response.json')
    );
});

$app->get('transfers', function () {
    if (is_bar_user(app('request'))) {
        return response()->json(
            stub('all_transfers_response_other_account.json')
        );
    }

    return response()->json(
        stub('all_transfers_response.json')
    );
});

$app->post('transfers', function () {
    return response()->json(
        stub('transfer_response.json')
    );
});

$app->run();
