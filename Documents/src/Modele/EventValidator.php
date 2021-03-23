<?php

//namespace App/Modele;

class EventValidator extends validator
{
    private $_data;

    /**
     * @param array data
     * @return array bool
     */

    public function validates(array $data)
    {
        parent::validates($data);
        
        $this->validate($data['name'], 'minLength', 30);
        return $this->errors;
    }
    
}
