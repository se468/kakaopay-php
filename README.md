# Kakaopay REST API PHP wrapper
Wrapper for Kakaopay REST API. Kakaopay provides convenient way to do internet transaction in Korea because it doesn't need a separate Payment Gateway (PG). The transaction is done only with the user's Kakaotalk account. 

Official Kakaopay REST API documentation is [here](https://developers.kakao.com/docs/restapi/kakaopay-api).

Example Implementation in Laravel is [here](https://github.com/se468/kakaopay-laravel-example).

## Installation
Via Composer:
```
composer require se468/kakaopay-php
```

## Usage
### Single payment process
#### Payment Ready
Used for requesting the user for the transaction. User will receive a message to confirm the transaction.

API Endpoint:
```
POST /v1/payment/ready HTTP/1.1
```

Usage Example:
```php
$payment = new \se468\Kakaopay\Payment();
\se468\Kakaopay\Kakaopay::setAdminKey(env('KAKAOPAY_ADMIN_KEY'));

$result = $payment->ready([
    'cid' => 'TC0ONETIME',
    'partner_order_id' => 'partner_order_id',
    'partner_user_id' => 'partner_user_id',
    'item_name' => '초코파이',
    'quantity' => '1',
    'total_amount' => '2200',
    'vat_amount' => '200',
    'tax_free_amount' => '0',
    'approval_url' => 'http://package-development.valet/kakaopay/success',
    'cancel_url' => 'http://package-development.valet/kakaopay/fail',
    'fail_url' => 'http://package-development.valet/kakaopay/cancel'
]);
```

Here's the explanation of the process: 

* Result from `payment/ready` will have transation ID, or `tid` (`$result->tid`), which you can safely store in your session. 

* Store the `tid` in session and redirect to `$result->next_redirect_pc_url`. Customer will be prompted to enter their Kakaopay phone number and password. 

* After the customer fills in the form, they will receive a message in their Kakaotalk to approve the transaction. The screen will then redirect to the `approval_url` that you've provided.

* You can then call `payment/approve` using the `tid` stored in the session and it will process the payments. 


#### Payment Approve
With the given `tid` from payment ready, approve the transaction to finalize. 
```
POST /v1/payment/approve HTTP/1.1
```

Example:
```php
$payment = new \se468\Kakaopay\Payment();
\se468\Kakaopay\Kakaopay::setAdminKey(env('KAKAOPAY_ADMIN_KEY'));
$result = $payment->approve([
    'cid' => 'TC0ONETIME',
    'tid' => 'T1234567890123456789', //tid received from result from 'ready'
    'partner_order_id' => 'partner_order_id',
    'partner_user_id' => 'partner_user_id',
    'pg_token' => $input['pg_token']
]);
```

* You can delete the `tid` after you get the result from here, and store the `$result` in your DB, which contains the information about the transaction and show it back to the customer.

### Subscription Process
#### Payment Ready
Example Payment Ready for subscription
```php
$payment = new \se468\Kakaopay\Payment();
\se468\Kakaopay\Kakaopay::setAdminKey(env('KAKAOPAY_ADMIN_KEY'));

$result = $payment->ready([
    'cid' => 'TCSUBSCRIP',
    'partner_order_id' => 'partner_order_id',
    'partner_user_id' => 'partner_user_id',
    'item_name' => '음악정기결제',
    'quantity' => '1',
    'total_amount' => '9900',
    'vat_amount' => '900',
    'tax_free_amount' => '0',
    'approval_url' => 'http://package-development.valet/kakaopay/subscription/success',
    'cancel_url' => 'http://package-development.valet/kakaopay/subscription/fail',
    'fail_url' => 'http://package-development.valet/kakaopay/subscription/cancel'
]);
```

> Note that only thing different here from single payment is the `cid` parameter. 

#### Payment Approve
> Check the documentation for single payment. It is exactly same process.


#### Subscription from second payment
On going subscription fees can be called like the following:

```
POST /v1/payment/subscription HTTP/1.1
```

Example:
```php
$payment = new \se468\Kakaopay\Payment();
\se468\Kakaopay\Kakaopay::setAdminKey(env('KAKAOPAY_ADMIN_KEY'));

$result = $payment->subscription([
    'cid' => 'TCSUBSCRIP', // cid for testing
    'sid' => 'S1234567890987654321',
    'partner_order_id' => 'subscription_order_id_1',
    'partner_user_id' => 'subscription_user_id_1',
    'item_name' => '음악정기결제',
    'quantity' => '1',
    'total_amount' => '9900',
    'vat_amount' => '900',
    'tax_free_amount' => '0',
]);
```

#### Cancelling Payments
```
POST /v1/payment/cancel HTTP/1.1
```

```php
$payment = new \se468\Kakaopay\Payment();
\se468\Kakaopay\Kakaopay::setAdminKey(env('KAKAOPAY_ADMIN_KEY'));

$result = $payment->cancel([
    'cid' => 'TC0ONETIME', // cid for testing
    'tid' => 'T1234567890123456789',
    'cancel_amount' => '2200',
    'cancel_tax_free_amount' => '0',
    'cancel_vat_amount' => '200',
    'cancel_available_amount' => '4000',
]);
```

#### Order checking
```
GET/POST /v1/payment/order HTTP/1.1
```

Example:
```php
$payment = new \se468\Kakaopay\Payment();
\se468\Kakaopay\Kakaopay::setAdminKey(env('KAKAOPAY_ADMIN_KEY'));

$result = $payment->order([
    'cid' => 'TC0ONETIME', // cid for testing
    'tid' => 'T1234567890123456789',
]);
```

#### Checking the Subscription information
```
POST /v1/payment/manage/subscription/status HTTP/1.1
```

Example:
```php
$payment = new \se468\Kakaopay\Payment();
\se468\Kakaopay\Kakaopay::setAdminKey(env('KAKAOPAY_ADMIN_KEY'));

$result = $payment->order([
    'cid' => 'TCSUBSCRIP', // cid for testing
    'tid' => 'S1234567890987654321',
]);
```

#### Deactivating Subscription
```
POST /v1/payment/manage/subscription/inactive HTTP/1.1
```

Example:
```php
$payment = new \se468\Kakaopay\Payment();
\se468\Kakaopay\Kakaopay::setAdminKey(env('KAKAOPAY_ADMIN_KEY'));

$result = $payment->inactive([
    'cid' => 'TCSUBSCRIP', // cid for testing
    'sid' => 'S1234567890987654321',
]);
```