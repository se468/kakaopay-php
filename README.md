# Kakaopay REST API PHP wrapper
Wrapper for Kakaopay REST API. 

## Usage
### Single payment process
#### Payment Ready
```
POST /v1/payment/ready HTTP/1.1
Host: kapi.kakao.com
Authorization: Bearer {access_token}
Content-type: application/x-www-form-urlencoded;charset=utf-8
```

Example:
```
\Kakaopay\Kakaopay::setAccessToken('access_token');
\Kakaopay\Payment::ready([
    'cid' => 'TC0ONETIME', // cid for testing
    'partner_order_id' => 'partner_order_id',
    'partner_user_id' => 'partner_user_id',
    'item_name' => '초코파이',
    'quantity' => '1',
    'total_amount' => '2200',
    'vat_amount' => '200',
    'tax_free_amount' => '0',
    'approval_url' => 'https://developers.kakao.com/success',
    'cancel_url' => 'https://developers.kakao.com/fail',
    'fail_url' => 'https://developers.kakao.com/cancel'
]);
```

#### Payment Approve
```
POST /v1/payment/approve HTTP/1.1
Host: kapi.kakao.com
Authorization: Bearer {access_token}
Content-type: application/x-www-form-urlencoded;charset=utf-8
```

Example:
```
\Kakaopay\Kakaopay::setAccessToken('access_token');
\Kakaopay\Payment::approve([
    'cid' => 'TC0ONETIME', // cid for testing,
    'tid' => 'T1234567890123456789',
    'partner_order_id' => 'partner_order_id',
    'partner_user_id' => 'partner_user_id',
    'pg_token' => 'xxxxxxxxxxxxxxxxxxxx'
]);
```


### Subscription Process
#### Payment Ready
Example Payment Ready
```
\Kakaopay\Kakaopay::setAccessToken('access_token');
\Kakaopay\Payment::ready([
    'cid' => 'TCSUBSCRIP', // cid for testing
    'partner_order_id' => 'subscription_order_id_1',
    'partner_user_id' => 'subscription_user_id_1',
    'item_name' => '음악정기결제',
    'quantity' => '1',
    'total_amount' => '9900',
    'vat_amount' => '900'
    'tax_free_amount' => '0',
    'approval_url' => 'https://developers.kakao.com/success',
    'cancel_url' => 'https://developers.kakao.com/fail',
    'fail_url' => 'https://developers.kakao.com/cancel'
]);
```

#### Payment Approve
Check the documentation for single payment


#### Subscription from second payment
```
POST /v1/payment/subscription HTTP/1.1
Host: kapi.kakao.com
Authorization: Bearer {access_token}
Content-type: application/x-www-form-urlencoded;charset=utf-8
```

Example:
```
\Kakaopay\Kakaopay::setAccessToken('access_token');
\Kakaopay\Payment::subscription([
    'cid' => 'TCSUBSCRIP', // cid for testing
    'sid' => 'S1234567890987654321',
    'partner_order_id' => 'subscription_order_id_1',
    'partner_user_id' => 'subscription_user_id_1',
    'item_name' => '음악정기결제',
    'quantity' => '1',
    'total_amount' => '9900'
    'vat_amount' => '900',
    'tax_free_amount' => '0',
]);
```

#### Cancelling Payments
```
POST /v1/payment/cancel HTTP/1.1
Host: kapi.kakao.com
Authorization: Bearer {access_token}
Content-type: application/x-www-form-urlencoded;charset=utf-8
```

```
\Kakaopay\Kakaopay::setAccessToken('access_token');
\Kakaopay\Payment::cancel([
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
Host: kapi.kakao.com
Authorization: Bearer {access_token}
Content-type: application/x-www-form-urlencoded;charset=utf-8
```

Example:
```
\Kakaopay\Kakaopay::setAccessToken('access_token');
\Kakaopay\Payment::order([
    'cid' => 'TC0ONETIME', // cid for testing
    'tid' => 'T1234567890123456789',
]);
```

#### Subscription information checking
```
POST /v1/payment/manage/subscription/status HTTP/1.1
Host: kapi.kakao.com
Authorization: Bearer {access_token}
Content-type: application/x-www-form-urlencoded;charset=utf-8
```

Example:
```
\Kakaopay\Kakaopay::setAccessToken('access_token');
\Kakaopay\Payment::order([
    'cid' => 'TCSUBSCRIP', // cid for testing
    'tid' => 'S1234567890987654321',
]);
```

#### Deactivating Subscription
```
POST /v1/payment/manage/subscription/inactive HTTP/1.1
Host: kapi.kakao.com
Authorization: Bearer {access_token}
Content-type: application/x-www-form-urlencoded;charset=utf-8
```

Example:
```
curl -v -X POST 'https://kapi.kakao.com/v1/payment/manage/subscription/inactive' \
-H 'Authorization: KakaoAK xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx' \
-d 'cid=TCSUBSCRIP' \
-d 'sid=S1234567890987654321'
```