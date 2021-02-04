<?php namespace StripeFacility;

use StripeFacility\ApiCommunication\ApiInvoiceItems;
use StripeFacility\ApiCommunication\ApiInvoices;

class StripeFacility extends \Stripe\Stripe
{
    protected $environnement;
    protected $privateKey;
    protected $publicKey;
    protected $webhookCliKey;

    public function __construct()
    {
        $this->environnement = \getenv('CI_ENVIRONMENT');
    }

    public function setUp()
    {
        if ($this->environnement === 'development')
        {
            $this->privateKey     = \getenv('PRIVATE_TEST_KEY');
            $this->publicKey      = \getenv('PUBLIC_TEST_KEY');
            $this->webhookCliKey = \getenv('STRIPE_WEBHOOK_SECRET_CLI');
        } else {
            $this->privateKey     = \getenv('PRIVATE_KEY');
            $this->publicKey      = \getenv('PUBLIC_KEY');
        }
    }

    public function webhookManager(\CodeIgniter\HTTP\IncomingRequest $request, string $webhookEvenType)
    {
        $evt = null;

        switch ($webhookEvenType) {
            case 'invoice':
                $webhook = new \StripeFacility\Webhook();

                if ($this->environnement === 'development')
                {
                    $webhook->setWebhookKey($this->webhookCliKey);
                    $evt = $webhook->verifyStripeSignature($request);
                }
                else
                {
                    $webhook->setWebhookKey(\getenv('WEBHOOK_SECRET_INVOICE'));
                    $evt = $webhook->verifyStripeSignature($request);
                }
                break;
            case 'customer':
                $webhook = new \StripeFacility\Webhook();

                if ($this->environnement === 'development')
                {
                    $webhook->setWebhookKey($this->webhookCliKey);
                    $evt = $webhook->verifyStripeSignature($request);
                }
                else
                {
                    $webhook->setWebhookKey(\getenv('WEBHOOK_SECRET_CUSTOMER'));
                    $evt = $webhook->verifyStripeSignature($request);
                }
                break;
            default:
                return new \Exception("The webhook you want is not yet implemented but you can implement your own");
                break;
        }

        return $evt;
    }

    /**
     * getApiProduct function
     * 
     * Return a class Instance of the ApiProduct
     * 
     * @return ApiProducts
     */
    public function getApiProducts()
    {
        $api = new \StripeFacility\ApiCommunication\ApiProducts();
        $api->setApiSecretKey($this->privateKey);
        return $api;
    }

    /**
     * getApiSubscription function
     * 
     * Return a class Instance of the ApiSubscription
     * 
     * @return ApiSubscriptions 
     */
    public function getApiSubscriptions()
    {
        $api = new \StripeFacility\ApiCommunication\ApiSubscriptions();
        $api->setApiSecretKey($this->privateKey);
        return $api;
    }
    
    /**
     * getApiCustomers function
     * 
     * Return a class Instance of the ApiCustomers
     * 
     * @return ApiCustomers 
     */
    public function getApiCustomers()
    {
        $api = new \StripeFacility\ApiCommunication\ApiCustomers();
        $api->setApiSecretKey($this->privateKey);
        return $api;
    }

    /**
     * getApiInvoices function 
     * 
     * Return a class Instance of the ApiInvoices
     * 
     * @return ApiInvoices 
     */
    public function getApiInvoices()
    {
        $api = new \StripeFacility\ApiCommunication\ApiInvoices();
        $api->setApiSecretKey($this->privateKey);
        return $api;
    }

    /**
     * getApiInvoiceItems function
     * 
     * Return a class Instance of the ApiInvoiceItems
     * 
     * @return ApiInvoiceItems 
     */
    public function getApiInvoiceItems()
    {
        $api = new \StripeFacility\ApiCommunication\ApiInvoiceItems();
        $api->setApiSecretKey($this->privateKey);
        return $api;
    }

    /**
     * createCheckout function
     * 
     * Create a checkout session by passing a array of options 
     * for the checkout instance
     * 
     * @param array $checkoutInstanceOptions 
     * @return mixed 
     */
    public function createCheckout(array $checkoutInstanceOptions)
    {
        try 
        {
            $checkout_session = \Stripe\Checkout\Session::create($checkoutInstanceOptions);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'error' => [
                    'message' => $e->getMessage(),
                ]
            ])->setStatusCode(400);
        }

        return $checkout_session;
    }
}