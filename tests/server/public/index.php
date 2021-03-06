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

function json($data)
{
    return response()->json($data);
}

function json_stub($stub, $additional = [])
{
    $stub = stub($stub) + [
        'requestData' => app('request')->all(),
        'headers' => app('request')->header(),
    ] + $additional;

    return json($stub);
}

function is_bar_user($request)
{
    $headers = $request->header();

    if (isset($headers['php-auth-user'])) {
        return $headers['php-auth-user'][0] == 'bar';
    }

    return false;
}

$app->get('422', function () {
    return response()->json([
        'errors' => [
            'due_date' => [
                'should not be in the past',
            ],
        ],
    ], 422);
});

$app->get('401', function () {
    return response()->json([
        'errors' => 'Unauthorized',
    ], 401);
});

$app->get('/get', function () {
    return build_response(app('request'));
});

$app->get('auth', function () {
    return build_response(app('request'));
});

$app->post('payment_token', function () {
    return json_stub('token_create_response.json');
});

$app->post('charge', function () {
    return json_stub('charge.json');
});

$app->get('transfers/{id}', function ($id) {
    return json_stub($id . '_transfer_response.json');
});

$app->get('transfers', function () {
    if (is_bar_user(app('request'))) {
        return json_stub('all_transfers_response_other_account.json');
    }

    return json_stub('all_transfers_response.json');
});

$app->post('transfers', function () {
    return json_stub('transfer_response.json');
});

$app->post('marketplace/create_account', function () {
    return json_stub('marketplace_create_account.json');
});

$app->get('accounts/{id}', function ($id) {
    return json_stub('marketplace_123_account.json', [
        'params' => [
            'id' => $id,
        ],
    ]);
});

$app->post('accounts/{id}/request_verification', function ($id) {
    return json_stub('marketplace_verify_account.json', [
        'params' => [
            'id' => $id,
        ],
    ]);
});

$app->post('accounts/{id}/request_withdraw', function ($id) {
    return json_stub('marketplace_account_request_withdraw.json', [
        'params' => [
            'id' => $id,
        ],
    ]);
});

$app->get('invoices/{id}', function ($id) {
    return json_stub('find_invoice_response.json', [
        'params' => [
            'id' => $id,
        ],
    ]);
});

$app->post('invoices', function () {
    return json_stub('create_invoice_response.json');
});

$app->post('invoices/{id}/refund', function ($id) {
    return json_stub('refund_invoice_response.json', [
        'params' => [
            'id' => $id,
        ],
    ]);
});

$app->run();
