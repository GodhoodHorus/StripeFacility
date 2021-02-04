<?php namespace StripeFacility\ApiCommunication;


use Stripe\StripeClient;
use ErrorException;
use Stripe\Collection;
use Stripe\Exception\ApiErrorException;
use Stripe\product;

interface Api
{
    public function setApiSecretKey(string $key);
    public function getApiSecretKey();
}

class ApiProducts implements Api
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
     * @return ApiProducts 
     */
    public function setApiSecretKey(string $key): ApiProducts
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
     * createProduct function
     * 
     * Creates a new product object.
     * 
     * @param array $data The data for creating the product (customer_id, price_id, etc...)
     * @param bool $return If you want to have the function to return something
     * @return product|void
     * @throws ApiErrorException 
     */
    public function createProduct(array $data, bool $return = false)
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

                // Create the product and return it if $return is True
                if ($return === true)
                {
                    $stripe->products->create($data);
                }
                else
                {
                    return $stripe->products->create($data);
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
     * getProduct function
     * 
     * Retrieves the details of an existing product. 
     * Supply the unique product ID from either a product creation request or the product list, 
     * and Stripe will return the corresponding product information.
     * 
     * @param string $prodId The product ID we want
     * @param array $data The optionals data
     * @return product|void 
     */
    public function getProduct(string $prodId, array $data = [])
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

                // Retrieve the product          
                return $stripe->products->retrieve($prodId, $data);
                
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
     * updateProduct function
     * 
     * Updates the specific product by setting the values of the parameters passed.
     *  Any parameters not provided will be left unchanged.
     * 
     * @param string $prodId The product ID normally save in your database
     * @param array $data The data you want to update
     * @param bool $return If you want to have the API return
     * @return product|void 
     */
    public function updateProduct(string $prodId, array $data, bool $return = false)
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

                // Update the product and return it if $return is True
                if ($return === true)
                {
                    $stripe->products->update($prodId, $data);
                }
                else
                {
                    return $stripe->products->update($prodId, $data);
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
     * deleteProduct function
     * 
     * Delete a product. 
     * Deleting a product is only possible if it has no prices associated with it.
     * 
     * @param string $prodId The product ID
     * @param array $data The optionals params
     * @param bool $return The optional return of the API call
     * @return product|void 
     */
    public function deleteProduct(string $prodId, array $data = [], bool $return = false)
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

                // Delete the product and return it if $return is True
                if ($return === true)
                {
                    $stripe->products->delete($prodId, $data);
                }
                else
                {
                    return $stripe->products->delete($prodId, $data);
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
     * getAllProducts function
     * 
     * Returns a list of your products.
     * The products are returned sorted by creation date, 
     * with the most recently created products appearing first.
     * 
     * @param int $limit The limitation of the products number we want to return
     * @return Collection|void 
     */
    public function getAllProducts(int $limit = 2)
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

                // Delete the product and return it if $return is True
                return $stripe->products->all(['limit' => $limit]);
                
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