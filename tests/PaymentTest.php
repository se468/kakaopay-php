<?php

use se468\Kakaopay\Payment;
use se468\Kakaopay\Kakaopay;
use PHPUnit\Framework\TestCase;

class PaymentTest extends TestCase
{
    public function setUp()
    {
        $dotenv = new Dotenv\Dotenv(realpath(__DIR__ . '/..'));
        $dotenv->load();
    }
    /** @test */
    public function single_charge()
    {
        $payment = new Payment();
        Kakaopay::setAdminKey(getenv('KAKAOPAY_ADMIN_KEY'));
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

        $this->assertNotNull($result->tid);
    }

    public function ready()
    {
        $payment = new Payment();
        Kakaopay::setAdminKey(getenv('KAKAOPAY_ADMIN_KEY'));
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

        $this->assertNotNull($result->tid);
     
        $this->assertNotNull($result->next_redirect_pc_url);
    }
}
