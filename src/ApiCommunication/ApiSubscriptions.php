<?php namespace StripeFacility\ApiCommunication;

use App\Entities\ErrorsEntity;
use App\Models\ErrorsModel;
use Stripe\StripeClient;
use ErrorException;
use Stripe\Collection;
use Stripe\Exception\ApiErrorException;
use Stripe\Subscription;

interface Api
{
    public function setApiSecretKey(string $key);
    public function getApiSecretKey();
}

class ApiSubscriptions implements Api
{
    private $apiKey;

    /**
     * setApiSecretKey function
     * 
     * Set the Api Secret Key of your Stripe Account
     * 
     * !IMPORTANT :: You should pass your own API SECRET KEY
     * 
     * @param string $key 
     * @return ApiSubscriptions 
     */
    public function setApiSecretKey(string $key): ApiSubscriptions
    {
        $this->apiKey = $key;
        return $this;
    }

    /**
     * getApiSecretKey function
     * 
     * Get the configurated Api Secret Key
     * 
     * @return mixed 
     */
    public function getApiSecretKey()
    {
        return $this->apiKey;
    }


    /**
     * createSubscription function
     * 
     * Creates a new subscription on an existing customer.
     * Each customer can have up to 500 active or scheduled subscriptions.
     * 
     * @param array $data The data for creating the subscription (customer_id, price_id, etc...)
     * @param bool $return If you want to have the function to return something
     * @return Subscription|void
     * @throws ApiErrorException 
     */
    public function createSubscription(array $data, bool $return = false)
    {
        try 
        {
            // See if the api Key if not null (so not the default one)
            // otherwise throw a ErrorException and save the ErrorException
            // in the table
            if ($this->apiKey !== null)
            {
                // Create a StripeClient Instance by passing your API Key
                $stripe = new StripeClient($this->apiKey);

                // Create the subscription and return it if $return is True
                if ($return === true)
                {
                    $stripe->subscriptions->create($data);
                }
                else
                {
                    return $stripe->subscriptions->create($data);
                }
            }
            else
            {
                throw new ErrorException('The API Key should has been setup', 500, 3);
            }

        } catch (ErrorException $e) {
            return $e;
            exit();
        } catch (ApiErrorException $e) {
            return $e;
            exit();
        }
        
    }

    /**
     * getSubscription function
     * 
     * Retrieves the subscription with the given ID.
     * 
     * @param string $subId The subscription ID we want
     * @param array $data The optionals data
     * @return Subscription|void 
     */
    public function getSubscription(string $subId, array $data = [])
    {
        try 
        {
            // See if the api Key if not null (so not the default one)
            // otherwise throw a ErrorException and save the ErrorException
            // in the table
            if ($this->apiKey !== null)
            {
                // Create a StripeClient Instance by passing your API Key
                $stripe = new StripeClient($this->apiKey);

                // Retrieve the subscription          
                return $stripe->subscriptions->retrieve($subId, $data);
                
            }
            else
            {
                throw new ErrorException('The API Key should has been setup', 500, 3);
            }

        } catch (ErrorException $e) {
            return $e;
            exit();
        } catch (ApiErrorException $e) {
            return $e;
            exit();
        }
    }

    /**
     * updateSubscription function
     * 
     * Updates an existing subscription to match the specified parameters. 
     * 
     * When changing prices or quantities, Stripe will optionally prorate 
     * the price they charge next month to make up for any price changes.
     * 
     * To preview how the proration will be calculated, 
     * use the upcoming invoice endpoint.
     * 
     * @param string $subId The subscription ID normally save in your database
     * @param array $data The data you want to update
     * @param bool $return If you want to have the API return
     * @return Subscription|void 
     */
    public function updateSubscription(string $subId, array $data, bool $return = false)
    {
        try 
        {
            // See if the api Key if not null (so not the default one)
            // otherwise throw a ErrorException and save the ErrorException
            // in the table
            if ($this->apiKey !== null)
            {
                // Create a StripeClient Instance by passing your API Key
                $stripe = new StripeClient($this->apiKey);

                // Update the subscription and return it if $return is True
                if ($return === true)
                {
                    $stripe->subscriptions->update($subId, $data);
                }
                else
                {
                    return $stripe->subscriptions->update($subId, $data);
                }
            }
            else
            {
                throw new ErrorException('The API Key should has been setup', 500, 3);
            }

        } catch (ErrorException $e) {
            return $e;
            exit();
        } catch (ApiErrorException $e) {
            return $e;
            exit();
        }
    }

    /**
     * cancelSubscription function 
     * 
     * Cancels a customer’s subscription immediately.
     * The customer will not be charged again for the subscription.
     * 
     * Note, however, that any pending invoice items that 
     * you’ve created will still be charged for at the end of the period, 
     * unless manually deleted. 
     * 
     * If you’ve set the subscription to cancel at the end of the period, 
     * any pending prorations will also be left in place 
     * and collected at the end of the period. 
     * 
     * But if the subscription is set to cancel immediately, 
     * pending prorations will be removed.
     * 
     * By default, upon subscription cancellation, 
     * Stripe will stop automatic collection of all finalized 
     * invoices for the customer. 
     * 
     * This is intended to prevent unexpected payment attempts 
     * after the customer has canceled a subscription. 
     * 
     * However, you can resume automatic collection of the invoices manually 
     * after subscription cancellation to have us proceed. 
     * 
     * Or, you could check for unpaid invoices before 
     * allowing the customer to cancel the subscription at all.
     * 
     * @param string $subId The subscription Id
     * @param array $data The optionals params
     * @param bool $return The optional return of the API call
     * @return Subscription|void 
     */
    public function cancelSubscription(string $subId, array $data = [], bool $return = false)
    {
        try 
        {
            // See if the api Key if not null (so not the default one)
            // otherwise throw a ErrorException and save the ErrorException
            // in the table
            if ($this->apiKey !== null)
            {
                // Create a StripeClient Instance by passing your API Key
                $stripe = new StripeClient($this->apiKey);

                // Cancel the subscription and return it if $return is True
                if ($return === true)
                {
                    $stripe->subscriptions->cancel($subId, $data);
                }
                else
                {
                    return $stripe->subscriptions->cancel($subId, $data);
                }
            }
            else
            {
                throw new ErrorException('The API Key should has been setup', 500, 3);
            }

        } catch (ErrorException $e) {
            return $e;
            exit();
        } catch (ApiErrorException $e) {
            return $e;
            exit();
        }
    }

    /**
     * getAllSubscriptions function
     * 
     * By default, returns a list of subscriptions that have not been canceled. 
     * In order to list canceled subscriptions, specify $status to canceled.
     * 
     * @param int $limit The limitation of the subscriptions number we want to return
     * @param string $status The status of the subscriptions
     * @return Collection|void 
     */
    public function getAllSubscriptions(int $limit = 2, string $status = '')
    {
        try 
        {
            // See if the api Key if not null (so not the default one)
            // otherwise throw a ErrorException and save the ErrorException
            // in the table
            if ($this->apiKey !== null)
            {
                // Create a StripeClient Instance by passing your API Key
                $stripe = new StripeClient($this->apiKey);

                // Get all the subscription and return it if $return is True
                return $stripe->subscriptions->all(['limit' => $limit, 'status' => $status]);
                
            }
            else
            {
                throw new ErrorException('The API Key should has been setup', 500, 3);
            }

        } catch (ErrorException $e) {
            return $e;
            exit();
        } catch (ApiErrorException $e) {
            return $e;
            exit();
        }
    }
}