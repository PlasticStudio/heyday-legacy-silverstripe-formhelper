<?php

namespace Heyday\FormHelper;

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\View\Requirements;

/**
 * Class AddressField
 *
 * @package silverstripe-form-helper
 * @license MIT License https://github.com/heyday/silverstripe-formhelper/LICENSE
 **/
class AddressField extends TextField
{
    /**
     * @var array
     */
    public static $address_fields = array();

    /**
     * @var array
     */
    public static $autocomplete_values = array();

    /**
     * AddressField constructor
     *
     * @param string $name
     * @param array $options
     */
    public function __construct($name, $options = array())
    {
        parent::__construct($name);

        $this->setTemplate('AddressField');

        $jsRoot = 'heyday/silverstripe-formhelper:js/';

        $jsFile = $jsRoot . 'google-autocomplete.js';
        if (isset($options['NZOnly'])) {
            $jsFile = $jsRoot . 'google-autocomplete-nz.js';
        }

        Requirements::javascript($jsFile);
    }

    /**
     * @return FieldList
     */
    public function Fields()
    {
        $addressFields = $this->getAddressFields();
        $listOfFields = [];

        foreach ($addressFields as $key => $value) {
            array_push($listOfFields, ${$value} = new TextField($key, $key));
        }

        $fields = new FieldList(
            $listOfFields
        );

        // Setting attribute to fields to respect Google response

        if (isset($autocomplete)) {
            $autocomplete->setAttribute('placeholder', 'Street Address')->setAttribute('id', 'autocomplete')->setAttribute('onFocus', 'geolocate()');
        }

        if (isset($suburb)) {
            $suburb->setAttribute('id', 'sublocality_level_1');
        }

        if (isset($city)) {
            $city->setAttribute('id', 'locality');
        }

        if (isset($state)) {
            $state->setAttribute('id', 'administrative_area_level_1');
        }

        if (isset($postalCode)) {
            $postalCode->setAttribute('id', 'postal_code');
        }

        if (isset($streetNumber)) {
            $streetNumber->setAttribute('id', 'street_number');
        }

        if (isset($street)) {
            $street->setAttribute('id', 'route');
        }

        if (isset($streetAndNumber)) {
            $streetAndNumber->setAttribute('id', 'street_and_number');
        }

        return $fields;
    }

    /**
     * @param array $fields
     * @return array
     */
    public function setAutocompleteValues($fields = array())
    {
        return self::$autocomplete_values = $fields;
    }

    /**
     * @return string
     */
    public function getAutocompleteValues()
    {
        return implode(',', self::$autocomplete_values);
    }

    /**
     * @param array $fields
     */
    public function setAddressFields($fields = array())
    {
        self::$address_fields = $fields;
    }

    /**
     * @return array
     */
    public function getAddressFields()
    {
        return self::$address_fields;
    }
}
