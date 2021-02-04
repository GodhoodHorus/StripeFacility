# StripeFacility
A CodeIgniter 4 Stripe implementation to make your life easy

So when i have make this libray i was trying to keep in my mind to make your programmation with the Stripe API easy.

You can clone this library inside the ThirdParty folder, or clone it by using composer

```
need to register to the composer package
```

## Configure the .env

You will need to add a couple of line inside your .env file

```
#--------------------------------------------------------------------
# STRIPE FACILITY
#--------------------------------------------------------------------

# KEY

PUBLIC_TEST_KEY = Your test public key
PRIVATE_TEST_KEY = Your test private key
PUBLIC_KEY = Your production public key
PRIVATE_KEY = Your production private key

# Special Webhook Secret when using the CLI
# You should use the stripe cli for your dev period

STRIPE_WEBHOOK_SECRET_CLI = Your cli key

# Endpoints Secret
# You can comment unnused webhook
# More endpoints will come soon

WEBHOOK_SECRET_INVOICE = your webhook key
WEBHOOK_SECRET_CUSTOMER = your webhook key

```

### Todo

- [ ] Add all webhooks endpoints
- [ ] Add all api communications
- [ ] Documentations

