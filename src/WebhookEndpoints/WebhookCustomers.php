<?php namespace StripeFacility\WebhookEndpoints;


use CodeIgniter\HTTP\Exceptions\HTTPException;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\Response;
use Stripe\Event;

interface Webhook
{
    public function setWebhookKey(string $key);
    public function getWebhookKey();
    public function verifyStripeSignature(IncomingRequest $request, string $webhookKey);
}


class WebhookCustomers implements Webhook
{
    private $webhookSecret;

    /**
     * setWebhookSecret function
     * 
     * Set the webhook endpoint secret
     * 
     * !IMPORTANT :: You should pass your custom WebhookSecret
     * 
     * @param string $key 
     * @return WebhookCustomers 
     */
    public function setWebhookKey(string $key): WebhookCustomers
    {
        $this->webhookSecret = $key;
        return $this;
    }

    /**
     * getWebhookKey
     * 
     * Get the webhook key to pass it on the 
     * verifyStripeSignature function $webhookKey param
     * 
     * @return mixed 
     */
    public function getWebhookKey()
    {
        return $this->webhookSecret;
    }

    
    /**
     * verifyStripeSignature function
     * 
     * This function verify the Authenticity
     * of your stripe webhook payload.
     * 
     * @param IncomingRequest $request
     * @param Response $response
     * @param string $webhookKey 
     * @return Event|RedirectResponse 
     * @throws ReflectionException 
     * @throws HTTPException 
     */
    public function verifyStripeSignature(IncomingRequest $request, string $webhookKey)
    {
        
        $sig_header = $request->getServer('HTTP_STRIPE_SIGNATURE');
        $event = null;

        try 
        {
            if ($sig_header)
            {
                $payload = $request->getBody();
                

                if ($this->webhookSecret !== null)
                {
                    $event = \Stripe\Webhook::constructEvent(
                        $payload,
                        $sig_header,
                        $webhookKey
                    );
                }
                else
                {
                    throw new \ErrorException('The webhook secret for the Customer endpoints is empty', 500, 3);
                }
            }
            else
            {
                throw new \ErrorException('The Stripe server signature is not present', 500, 3);
            }

        } catch (\ErrorException $e) {
            return $e;
            exit();
        } catch(\UnexpectedValueException $e) {
            return $e;
            exit();
        } catch(\Stripe\Exception\SignatureVerificationException $e) {
            return $e;
            exit();
        }
        
        return $event;
    }

}