<?php namespace StripeFacility\ApiCommunication;

use ErrorException;
use Stripe\Collection;
use Stripe\Customer;
use Stripe\Exception\ApiErrorException;
use Stripe\StripeClient;

interface Api
{
    public function setApiSecretKey(string $key);
    public function getApiSecretKey();
}

class ApiCustomers implements Api
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
     * @return ApiCustomers 
     */
    public function setApiSecretKey(string $key): ApiCustomers
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
     * createCustomer function
     * 
     * Create a new customer
     * 
     * @param array $data The data you want to pass to your customer
     * @param bool $return The optional return of the API call
     * @return Customer|void 
     */
    public function createCustomer(array $data, bool $return = false)
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

                // Create the customer and return it if $return is True
                if ($return === true)
                {
                    $stripe->customers->create($data);
                }
                else
                {
                    return $stripe->customers->create($data);
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
     * updateCustomer function
     * 
     * Updates the specified customer by setting the 
     * values of the parameters passed.
     * 
     * Any parameters not provided will be left unchanged. 
     * 
     * @param string $cusId The customer id
     * @param array $data The params to update
     * @param bool $return The optional return of the API call
     * @return Customer|void 
     */
    public function updateCustomer(string $cusId, array $data, bool $return = false)
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

                // Update the customer and return it if $return is True
                if ($return === true)
                {
                    $stripe->customers->update($cusId, $data);
                }
                else
                {
                    return $stripe->customers->update($cusId, $data);
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
     * getCustomer function
     * 
     * Retrieves the details of an existing customer. 
     * 
     * You need only supply the unique customer identifier 
     * that was returned upon customer creation.
     * 
     * @param string $cusId The customer id
     * @param array $data The optionals params
     * @return Customer|void 
     */
    public function getCustomer(string $cusId, array $data = [])
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

                // Retrieve the customer          
                return $stripe->customers->retrieve($cusId, $data);
                
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
     * deleteCustomer function
     * 
     * Permanently deletes a customer. 
     * It cannot be undone. 
     * 
     * Also immediately cancels any active 
     * subscriptions on the customer.
     * 
     * @param string $cusId The customer id
     * @param array $data The optionals params
     * @param bool $return The optional return of the API call
     * @return Customer|void 
     */
    public function deleteCustomer(string $cusId, array $data = [], bool $return = false)
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

                // Delete the customer and return it if $return is True
                if ($return === true)
                {
                    $stripe->customers->delete($cusId, $data);
                }
                else
                {
                    return $stripe->customers->delete($cusId, $data);
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
     * getAllCustomers function
     * 
     * Returns a list of your customers. 
     * 
     * The customers are returned sorted by creation date, 
     * with the most recent customers appearing first.
     * 
     * @param int $limit The limitation of the numbers of customer lines
     * @return Collection|void 
     */
    public function getAllCustomers(int $limit = 2)
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

                // Delete the customer and return it if $return is True
                return $stripe->customers->all(['limit' => $limit]);
                
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