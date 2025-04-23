<?php

namespace Heyday\FormHelper\Exception;

class EnvironmentVariableNotSetException extends \Exception
{
    /**
     * The constructor.
     *
     * @param string $environmentVariableName
     */
    public function __construct($environmentVariableName)
    {
        parent::__construct(sprintf(
            'The environment variable %s must be set',
            strtoupper($environmentVariableName)
        ));
    }
}
