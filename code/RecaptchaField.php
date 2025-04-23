<?php

namespace Heyday\FormHelper;

use Heyday\FormHelper\Exception\EnvironmentVariableNotSetException;
use SilverStripe\Core\Environment;
use SilverStripe\Forms\FormField;

/**
 * Class RecaptchaField
 *
 * @package silverstripe-form-helper
 * @license MIT License https://github.com/heyday/silverstripe-formhelper/LICENSE
 */
class RecaptchaField extends FormField
{
    /**
     * RecaptchaField constructor
     *
     * @param string $name
     * @param null $title
     * @param string $value
     * @param null $form
     */
    public function __construct($name, $title = null, $value = '', $form = null)
    {
        if ($form) {
            $this->setForm($form);
        }

        $this->setTemplate('RecaptchaField');

        parent::__construct($name, $title, $value);
    }


    /**
     * Get the secret key
     *
     * @throws EnvironmentVariableNotSetException
     * @return array|scalar
     */
    public function getSiteKey()
    {
        $key = Environment::getEnv('RECAPTCHA_SITE_KEY');

        if (!$key) {
            throw new EnvironmentVariableNotSetException('RECAPTCHA_SITE_KEY');
        }

        if (isset($key) && !empty($key)) {
            return $key;
        }
    }

    /**
     * Get the secret key
     *
     * @throws EnvironmentVariableNotSetException
     * @return array|scalar
     */
    public function getSecretKey()
    {
        $key = Environment::getEnv('RECAPTCHA_SECRET');

        if (!$key) {
            throw new EnvironmentVariableNotSetException('RECAPTCHA_SECRET');
        }

        if (isset($key) && !empty($key)) {
            return $key;
        }
    }

    /**
     * Validate the recaptcha
     *
     * @param $validator
     * @return bool
     */
    public function validate($validator)
    {
        if (!isset($_REQUEST['g-recaptcha-response']) || empty($_REQUEST['g-recaptcha-response'])) {
            $validator->validationError($this->name, 'Please complete the recaptcha', 'required');
            return false;
        }
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = array(
            'secret' => $this->getSecretKey(),
            'response' => $_REQUEST['g-recaptcha-response']
        );

        $options = array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data),
            ),
        );
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        $result = json_decode($result);

        if ($result->success) {
            return true;
        } else {
            $validator->validationError($this->name, 'The recaptcha could not be validated', 'required');
            return false;
        }

    }
}