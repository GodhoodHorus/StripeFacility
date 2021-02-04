<?php namespace StripeFacility\ApiCommunication;


use ErrorException;
use Stripe\Collection;
use Stripe\Exception\ApiErrorException;
use Stripe\InvoiceItem;
use Stripe\StripeClient;

interface Api
{
    public function setApiSecretKey(string $key);
    public function getApiSecretKey();
}

class ApiInvoiceItems implements Api
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
     * @return ApiInvoiceItems 
     */
    public function setApiSecretKey(string $key): ApiInvoiceItems
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
     * createInvoiceItem function
     * 
     * Creates an item to be added to a draft invoice (up to 250 items per invoice). 
     * If no invoice is specified, the item will be on the next invoice 
     * created for the customer specified.
     * 
     * @param array $data The params
     * @param bool $return The optional return of the API call
     * @return InvoiceItem|void 
     */
    public function createInvoiceItem(array $data, bool $return = false)
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

                // Create the invoiceItem and return it if $return is True
                if ($return === true)
                {
                    $stripe->invoiceItems->create($data);
                }
                else
                {
                    return $stripe->invoiceItems->create($data);
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
     * updateInvoiceItem function
     * 
     * Updates the amount or description of an invoice item on an upcoming invoice. 
     * Updating an invoice item is only possible before the invoice it’s attached to is closed.
     * 
     * @param string $invItId The invoice item id
     * @param array $data The params
     * @param bool $return The optional return of the API call
     * @return InvoiceItem|void 
     */
    public function updateInvoiceItem(string $invItId, array $data, bool $return = false)
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

                // Update the invoiceItem and return it if $return is True
                if ($return === true)
                {
                    $stripe->invoiceItems->create($data);
                }
                else
                {
                    return $stripe->invoiceItems->create($data);
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
     * getInvoiceItem function
     * 
     * Retrieves the invoice item with the given ID.
     * 
     * @param string $invItId The invoice item id
     * @param array $data The params
     * @return InvoiceItem|void 
     */
    public function getInvoiceItem(string $invItId, array $data = [])
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

                // Return the invoiceItem
                return $stripe->invoiceItems->retrieve($data);
                
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
     * deleteInvoiceItem function
     * 
     * Deletes an invoice item, removing it from an invoice. 
     * 
     * Deleting invoice items is only possible 
     * when they’re not attached to invoices,
     * or if it’s attached to a draft invoice.
     * 
     * @param string $invItId 
     * @param array $data 
     * @param bool $return 
     * @return InvoiceItem|void 
     */
    public function deleteInvoiceItem(string $invItId, array $data = [], bool $return = false)
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

                // Delete the invoiceItem and return it if $return is True
                if ($return === true)
                {
                    $stripe->invoiceItems->delete($data);
                }
                else
                {
                    return $stripe->invoiceItems->delete($data);
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
     * getAllInvoiceItems function
     * 
     * Returns a list of your invoice items. 
     * Invoice items are returned sorted by creation date, 
     * with the most recently created invoice items appearing first.
     * 
     * @param int $limit The number of invoice items
     * @return Collection|void 
     */
    public function getAllInvoiceItems(int $limit = 2)
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

                // Get all the invoice items
                return $stripe->invoiceItems->all(['limit' => $limit]);
                
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