<?php namespace StripeFacility\ApiCommunication;


use ErrorException;
use Stripe\Collection;
use Stripe\Exception\ApiErrorException;
use Stripe\Invoice;
use Stripe\StripeClient;

interface Api
{
    public function setApiSecretKey(string $key);
    public function getApiSecretKey();
}

class ApiInvoices implements Api
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
     * @return ApiInvoices
     */
    public function setApiSecretKey(string $key): ApiInvoices
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
     * createInvoice function
     * 
     * This endpoint creates a draft invoice for a given customer. 
     * 
     * The draft invoice created pulls in all pending 
     * invoice items on that customer, including prorations. 
     * 
     * The invoice remains a draft until you finalize the invoice, 
     * which allows you to pay or send the invoice to your customers.
     * 
     * @param array $data The params 
     * @param bool $return The optional returning result of the API call
     * @return Invoice|void 
     */
    public function createInvoice(array $data, bool $return = false)
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

                // Create the invoices and return it if $return is True
                if ($return === true)
                {
                    $stripe->invoices->create($data);
                }
                else
                {
                    return $stripe->invoices->create($data);
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
     * updateInvoice function
     * 
     * Draft invoices are fully editable. 
     * 
     * Once an invoice is finalized, monetary values,
     * as well as collection_method, become uneditable.
     * 
     * @param string $invId The invoice id
     * @param array $data The params
     * @param bool $return The optional returning result of the API call
     * @return Invoice|void 
     */
    public function updateInvoice(string $invId, array $data, bool $return = false)
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

                // Update the invoices and return it if $return is True
                if ($return === true)
                {
                    $stripe->invoices->update($invId, $data);
                }
                else
                {
                    return $stripe->invoices->update($invId, $data);
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
     * getInvoice function
     * 
     * Retrieves the invoice with the given ID.
     * 
     * @param string $invId The invoice id
     * @param array $data The optionals params
     * @return Invoice|void 
     */
    public function getInvoice(string $invId, array $data = [])
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

                // Retrieve the invoices          
                return $stripe->invoices->retrieve($invId, $data);
                
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
     * deleteInvoice function
     * 
     * Permanently deletes a one-off invoice draft. 
     * This cannot be undone. 
     * 
     * Attempts to delete invoices that are no longer in a draft state will fail; 
     * once an invoice has been finalized or if an invoice is for a subscription, it must be voided.
     * 
     * @param string $invId The invoice id
     * @param array $data The optionals params
     * @param bool $return The optional returning result of the API call
     * @return Invoice|void 
     */
    public function deleteInvoice(string $invId, array $data = [], bool $return = false)
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

                // Delete the invoices and return it if $return is True
                if ($return === true)
                {
                    $stripe->invoices->delete($invId, $data);
                }
                else
                {
                    return $stripe->invoices->delete($invId, $data);
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
     * getAllInvoices function
     * 
     * You can list all invoices, or list the invoices 
     * for a specific customer. 
     * 
     * The invoices are returned sorted by creation date, 
     * with the most recently created invoices appearing first.
     * 
     * @param int $limit the limitation of numbers of invoices
     * @return Collection|void 
     */
    public function getAllInvoices(int $limit = 2)
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

                // Return all the invoices with a limitation
                return $stripe->invoices->all(['limit' => $limit]);
                
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
     * finalizeInvoice function
     * 
     * Stripe automatically finalizes drafts before sending and attempting payment on invoices. 
     * However, if you’d like to finalize a draft invoice manually, you can do so using this method.
     * 
     * @param string $invId The invoice id
     * @param array $data The optionals params
     * @param bool $return The optional returning result of the API call
     * @return Invoice|void 
     */
    public function finalizeInvoice(string $invId, array $data = [], bool $return = false)
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

                // Finalize a draft invoice manually
                if ($return === true)
                {
                    $stripe->invoices->finalizeInvoice($invId, $data);
                }
                else
                {
                    return $stripe->invoices->finalizeInvoice($invId, $data);
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
     * payInvoice function
     * 
     * Stripe automatically creates and then attempts to collect payment 
     * on invoices for customers on subscriptions according to your subscriptions settings. 
     * 
     * However, if you’d like to attempt payment on an invoice out of the normal 
     * collection schedule or for some other reason, you can do so.
     * 
     * @param string $invId The invoice id
     * @param array $data The optionals params
     * @param bool $return The optional returning result of the API call
     * @return Invoice|void 
     */
    public function payInvoice(string $invId, array $data = [], bool $return = false)
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

                // Send a collecting payment for the invoice id
                if ($return === true)
                {
                    $stripe->invoices->pay($invId, $data);
                }
                else
                {
                    return $stripe->invoices->pay($invId, $data);
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
     * sendInvoice function
     * 
     * Stripe will automatically send invoices to customers 
     * according to your subscriptions settings. 
     * 
     * However, if you’d like to manually send an invoice to your 
     * customer out of the normal schedule, you can do so. 
     * 
     * When sending invoices that have already been paid, 
     * there will be no reference to the payment in the email.
     * 
     * @param string $invId The invoice id
     * @param array $data The optionals params
     * @param bool $return The optional returning result of the API call
     * @return Invoice|void 
     */
    public function sendInvoice(string $invId, array $data = [], bool $return = false)
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

                // Send a invoice to a customer
                if ($return === true)
                {
                    $stripe->invoices->sendInvoice($invId, $data);
                }
                else
                {
                    return $stripe->invoices->sendInvoice($invId, $data);
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
     * voidInvoice function
     * 
     * Mark a finalized invoice as void. 
     * This cannot be undone. 
     * 
     * Voiding an invoice is similar to deletion, 
     * however it only applies to finalized invoices and 
     * maintains a papertrail where the invoice can still be found.
     * 
     * !Important :: This is the as deleting but only for finalized invoices
     * !And maintains a papertrail where the invoice can still be found !
     * 
     * @param string $invId The invoice id
     * @param array $data The optionals params
     * @param bool $return The optional returning result of the API call
     * @return Invoice|void 
     */
    public function voidInvoice(string $invId, array $data = [], bool $return = false)
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

                // Mark a invoice has void this is the same as deleting but for only finalized invoices
                if ($return === true)
                {
                    $stripe->invoices->voidInvoice($invId, $data);
                }
                else
                {
                    return $stripe->invoices->voidInvoice($invId, $data);
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
     * uncollectibleInvoice function
     * 
     * Marking an invoice as uncollectible is useful for keeping 
     * track of bad debts that can be written off for accounting purposes.
     * 
     * @param string $invId The invoice id
     * @param array $data The optionals params
     * @param bool $return The optional returning result of the API call
     * @return Invoice|void 
     */
    public function uncollectibleInvoice(string $invId, array $data = [], bool $return = false)
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

                // Mark a invoice Uncollectible
                if ($return === true)
                {
                    $stripe->invoices->markUncollectible($invId, $data);
                }
                else
                {
                    return $stripe->invoices->markUncollectible($invId, $data);
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
     * getAllLinesInvoice function
     * 
     * When retrieving an invoice, you’ll get a lines property containing 
     * the total count of line items and the first handful of those items. 
     * 
     * There is also a URL where you can retrieve the full 
     * (paginated) list of line items.
     * 
     * @param string $invId The invoice id
     * @param int $limit The numbers of line who will be returning
     * @return Collection|void 
     */
    public function getAllLinesInvoice(string $invId, int $limit = 2)
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

                // Get the total of invoices for a invoice id
                return $stripe->invoices->allLines($invId, ['limit' => $limit]); 
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
     * getUpcomingInvoice function
     * 
     * At any time, you can preview the upcoming invoice for a customer. 
     * This will show you all the charges that are pending, 
     * including subscription renewal charges, invoice item charges, etc. 
     * It will also show you any discounts that are applicable to the invoice.
     * 
     * Note that when you are viewing an upcoming invoice, 
     * you are simply viewing a preview – the invoice has not yet been created. 
     * 
     * As such, the upcoming invoice will not show up in invoice listing calls, 
     * and you cannot use the API to pay or edit the invoice. 
     * 
     * If you want to change the amount that your customer will be billed, 
     * you can add, remove, or update pending invoice items, 
     * or update the customer’s discount.
     * 
     * @param string $cusId The customer id
     * @return Invoice|void 
     */
    public function getUpcomingInvoice(string $cusId)
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

                // Get the upcoming invoice of a customer
                return $stripe->invoices->upcoming([
                    'customer' => $cusId,
                ]); 
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
     * getUpcomingInvoiceLines function
     * 
     * When retrieving an upcoming invoice, 
     * you’ll get a lines property containing the total count of line items 
     * and the first handful of those items. 
     * 
     * There is also a URL where you can retrieve 
     * the full (paginated) list of line items.
     * 
     * @param string $cusId 
     * @param int $limit 
     * @return Invoice|void 
     */
    public function getUpcomingInvoiceLines(string $cusId, int $limit = 2)
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

                // Get the upcoming invoice lines of a customer
                return $stripe->invoices->upcomingLines([
                    'customer' => $cusId,
                    'limit' => $limit,
                ]); 
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