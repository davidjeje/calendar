<?php

//namespace App/Modele;

class Error
{
    private $_error;

    public function setError($message)
    {
        if (is_string($message))
        {
            $this->_error = $message;
        }
    }

    public function error()
    {
        return $this->_error;
    }
}
