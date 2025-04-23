silverstripe-formhelper
=======================

This is a copy of the `heyday/silverstripe-formhelper` module which is unable to be found

Heyday's SilverStripe Form Helper

The idea is that primarily this module provides reusable form fields of a slightly more complex nature including validation and to avoid redesigning and rebuilding each time.


For starters, this is going to include the following.

AddressField for auto completing addresses using Google's autocomplete API
--------------------------------------------------------------------------

The following JS is needed:

```
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBvZv3q9ChrfH4Gmwc-rCbNdrimftVbvas&libraries=places&callback=initAutocomplete" async defer></script>
```

You can choose to limit autocomplete to NZ by passing the following option when instantiating the field:

```
new AddressField('Address', ['NZOnly' => true]);
```

You set the Fields as following:
```
        $addressFields = new AddressField('Address', ['NZOnly' => true]);
        $addressFields->setAddressFields([
            'Street Address' => 'autocomplete',
            'Street And Number' => 'streetAndNumber',
            'Street' => 'street',
            'Suburb' => 'suburb',
            'City' => 'city',
            'PostCode' => 'postalCode'
        ]);       
```
where the value of the Array is the field you want from Google autocomplete.
The following fields are available:
* `autocomplete` - Your auto-complete field
* `suburb`
* `city`
* `state`
* `postalCode`
* `streetNumber`
* `street`
* `streetAndNumber` - a concatenation of street number and street

Recaptcha Field
---------------

Using ReCaptcha V2.

You need to set the `RECAPTCHA_SITE_KEY` and `RECAPTCHA_SECRET` environment variables.
To do so you can edit the **.env** file in your SilverStripe project.

```
RECAPTCHA_SITE_KEY=site_key
RECAPTCHA_SECRET=secret
```

and usage:
```
new RecaptchaField('Confirm', 'Confirm you are a human')
```

See [https://www.google.com/recaptcha/admin](https://www.google.com/recaptcha/admin) to retrieve your keys.

