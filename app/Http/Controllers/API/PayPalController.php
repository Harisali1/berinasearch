<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

//use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use PayPal\Api\Agreement;
use PayPal\Api\ChargeModel;
use PayPal\Api\Currency;
use PayPal\Api\MerchantPreferences;
use PayPal\Api\Patch;
use PayPal\Api\PatchRequest;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\Plan;
use PayPal\Api\ShippingAddress;
use PayPal\Common\PayPalModel;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;
use PHPUnit\Util\TestDox\ResultPrinter;
use Validator;
use Session;
use Redirect;
use Input;


class PayPalController extends Controller
{
    private $_api_context;

    public function __construct()
    {

        $paypal_configuration = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_configuration['client_id'], $paypal_configuration['secret']));
        $this->_api_context->setConfig($paypal_configuration['settings']);
    }

    public function payWithPaypal()
    {
        return view('paywithpaypal');
    }

    public function postPaymentWithpaypal()
    {
        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                'AUbs-I_T3EH7ycpdLcD1NoXrOw_eMFvavP9pSqCe4RcsfLiINy2BUsqLuf087QPV2ubZPPZnhN2e4w6T',
                'EHcpDw_E6YzFP_jbNSzaGblkeHgx1_I9Oie5UjwjFNPS2lLas9Zcoc-1lPYa19TcVdDNobtOG-4uN6JG'
            )
        );

        $payer = new Payer();
        $payer->setPaymentMethod("paypal");


        $item1 = new Item();
        $item1->setName('Ground Coffee 40 oz')
            ->setCurrency('USD')
            ->setQuantity(1)
            ->setSku("123123") // Similar to `item_number` in Classic API
            ->setPrice(1);
        $item2 = new Item();
        $item2->setName('Granola bars')
            ->setCurrency('USD')
            ->setQuantity(1)
            ->setSku("321321") // Similar to `item_number` in Classic API
            ->setPrice(1);

        $itemList = new ItemList();
        $itemList->setItems(array($item1, $item2));


        $details = new Details();
        $details->setShipping(0.50)
            ->setTax(0.50)
            ->setSubtotal(2);


        $amount = new Amount();
        $amount->setCurrency("USD")
            ->setTotal(3)
            ->setDetails($details);


        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription("Payment description")
            ->setInvoiceNumber(uniqid());

//        $baseUrl = getBaseUrl();
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(url('http://localhost:8000/api/execute-payment'))
            ->setCancelUrl(url('http://localhost:8000/cancel'));


        $payment = new Payment();
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));


        $payment->create($apiContext);

//        dd($payment->getApprovalLink());

        return response()->json(['status' => 200, 'result' => $payment->getApprovalLink()]);


    }

    public function getPaymentStatus(Request $request)
    {
        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                'AUbs-I_T3EH7ycpdLcD1NoXrOw_eMFvavP9pSqCe4RcsfLiINy2BUsqLuf087QPV2ubZPPZnhN2e4w6T',
                'EHcpDw_E6YzFP_jbNSzaGblkeHgx1_I9Oie5UjwjFNPS2lLas9Zcoc-1lPYa19TcVdDNobtOG-4uN6JG'
            )
        );

        $paymentId = request('paymentId');
        $payment = Payment::get($paymentId, $apiContext);

        $execution = new PaymentExecution();
        $execution->setPayerId(request('PayerID'));

        $transaction = new Transaction();
        $amount = new Amount();
        $details = new Details();

        $details->setShipping(2.2)
            ->setTax(1.3)
            ->setSubtotal(17.50);

        $amount->setCurrency('USD');
        $amount->setTotal(21);
        $amount->setDetails($details);
        $transaction->setAmount($amount);

        $execution->addTransaction($transaction);
        $result = $payment->execute($execution, $apiContext);

        return $result;

    }


    public function createPlan()
    {

        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                'AUbs-I_T3EH7ycpdLcD1NoXrOw_eMFvavP9pSqCe4RcsfLiINy2BUsqLuf087QPV2ubZPPZnhN2e4w6T',
                'EHcpDw_E6YzFP_jbNSzaGblkeHgx1_I9Oie5UjwjFNPS2lLas9Zcoc-1lPYa19TcVdDNobtOG-4uN6JG'
            )
        );

        $plan = new Plan();

        $plan->setName('T-Shirt of the Month Club Plan')
            ->setDescription('Template creation.')
            ->setType('fixed');

        $paymentDefinition = new PaymentDefinition();

        $paymentDefinition->setName('Regular Payments')
            ->setType('REGULAR')
            ->setFrequency('Month')
            ->setFrequencyInterval("2")
            ->setCycles("12")
            ->setAmount(new Currency(array('value' => 100, 'currency' => 'USD')));

        $chargeModel = new ChargeModel();
        $chargeModel->setType('SHIPPING')
            ->setAmount(new Currency(array('value' => 10, 'currency' => 'USD')));

        $paymentDefinition->setChargeModels(array($chargeModel));

        $merchantPreferences = new MerchantPreferences();

        $merchantPreferences->setReturnUrl("http://localhost:8000/api/execute-plan/true")
            ->setCancelUrl("http://localhost:8000/api/execute-plan/false")
            ->setAutoBillAmount("yes")
            ->setInitialFailAmountAction("CONTINUE")
            ->setMaxFailAttempts("0")
            ->setSetupFee(new Currency(array('value' => 1, 'currency' => 'USD')));


        $plan->setPaymentDefinitions(array($paymentDefinition));
        $plan->setMerchantPreferences($merchantPreferences);

        $output = $plan->create($apiContext);

        dd($output);
    }

    public function listPlan()
    {
        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                'AUbs-I_T3EH7ycpdLcD1NoXrOw_eMFvavP9pSqCe4RcsfLiINy2BUsqLuf087QPV2ubZPPZnhN2e4w6T',
                'EHcpDw_E6YzFP_jbNSzaGblkeHgx1_I9Oie5UjwjFNPS2lLas9Zcoc-1lPYa19TcVdDNobtOG-4uN6JG'
            )
        );

        $params = array('page_size' => 2);
        $planList = Plan::all($params, $apiContext);
        return $planList;
    }

    public function showPlan($id)
    {
        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                'AUbs-I_T3EH7ycpdLcD1NoXrOw_eMFvavP9pSqCe4RcsfLiINy2BUsqLuf087QPV2ubZPPZnhN2e4w6T',
                'EHcpDw_E6YzFP_jbNSzaGblkeHgx1_I9Oie5UjwjFNPS2lLas9Zcoc-1lPYa19TcVdDNobtOG-4uN6JG'
            )
        );
        $plan = Plan::get($id, $apiContext);
        return $plan;
    }

    public function activePlan($id)
    {
        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                'AUbs-I_T3EH7ycpdLcD1NoXrOw_eMFvavP9pSqCe4RcsfLiINy2BUsqLuf087QPV2ubZPPZnhN2e4w6T',
                'EHcpDw_E6YzFP_jbNSzaGblkeHgx1_I9Oie5UjwjFNPS2lLas9Zcoc-1lPYa19TcVdDNobtOG-4uN6JG'
            )
        );

        $createdPlan = $this->showPlan($id);

        $patch = new Patch();

        $value = new PayPalModel('{
	       "state":"ACTIVE"
	     }');

        $patch->setOp('replace')
            ->setPath('/')
            ->setValue($value);
        $patchRequest = new PatchRequest();
        $patchRequest->addPatch($patch);

        $createdPlan->update($patchRequest, $apiContext);

        $plan = Plan::get($createdPlan->getId(), $apiContext);
        return $plan;
    }

    public function agreementPlan($id)
    {
        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                'AUbs-I_T3EH7ycpdLcD1NoXrOw_eMFvavP9pSqCe4RcsfLiINy2BUsqLuf087QPV2ubZPPZnhN2e4w6T',
                'EHcpDw_E6YzFP_jbNSzaGblkeHgx1_I9Oie5UjwjFNPS2lLas9Zcoc-1lPYa19TcVdDNobtOG-4uN6JG'
            )
        );

        $agreement = new Agreement();
        $agreement->setName('Base Agreement')
            ->setDescription('Basic Agreement')
            ->setStartDate('2019-06-17T9:45:04Z');




        $plan = new Plan();
        $plan->setId($id);
        $agreement->setPlan($plan);

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $agreement->setPayer($payer);

        $shippingAddress = new ShippingAddress();
        $shippingAddress->setLine1('111 First Street')
            ->setCity('Saratoga')
            ->setState('CA')
            ->setPostalCode('95070')
            ->setCountryCode('US');

        $agreement->setShippingAddress($shippingAddress);
//        dd($agreement);

        $approvalLink = $agreement->getApprovalLink();

//        $agreement = $agreement->create($apiContext);
        dd($approvalLink);
        return $agreement->getApprovalLink();
    }
}
