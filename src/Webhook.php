<?php namespace StripeFacility;

use CodeIgniter\HTTP\IncomingRequest;
use Stripe\Event;


class Webhook
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
     * @return Webhook
     */
    public function setWebhookKey(string $key): Webhook
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
     * Verify that the webhook is send by Stripe
     * 
     * @param IncomingRequest $request 
     * @return int|string|Event|void 
     */
    public function verifyStripeSignature(IncomingRequest $request)
    {
        $sig_header = $request->getServer('HTTP_STRIPE_SIGNATURE');

        try 
        {
            if ($sig_header)
            {
                $payload = $request->getBody();
                $event = null;

                if (!empty($this->webhookSecret))
                {
                    $event = \Stripe\Webhook::constructEvent(
                        $payload,
                        $sig_header,
                        $this->webhookSecret
                    );

                    return $event;
                }
                else
                {
                    throw new \Exception("The webhook secret is empty");
                }
            }
            else
            {
                throw new \Exception('The Stripe server signature is not present');
            }

        } catch (\Exception $e) {
            return d($e->getMessage(), $e->getFile(), $e->getLine());
            exit();
        } catch(\UnexpectedValueException $e) {
            return d($e->getMessage(), $e->getFile(), $e->getLine());
            exit();
        } catch(\Stripe\Exception\SignatureVerificationException $e) {
            return d($e->getMessage(), $e->getFile(), $e->getLine());
            exit();
        }
    }
}