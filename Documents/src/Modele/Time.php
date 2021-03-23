<?php

//namespace App/Modele;

class Time 
{
    private $_id,
            $_hours;
    public  $_hour = ['07:00', '08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00', '21:00', '22:00', '23:00'];

    /**
     * Month constructor
     * @param int $month Le mois compris entre 1 et 12
     * @param int $year L'année
     * @throws \Exception
     */
 
    public function __construct( $donnees = null) 
    {
        if ($donnees)
        {
            $this->hydrate($donnees);
        }   
    }

    public function hydrate(array $donnees) 
    {
        foreach ($donnees as $key => $value)
        {
            $method = 'set'.ucfirst($key);
      
            if (method_exists($this, $method))
            {
                $this->$method($value);
            }
        }
    }
    
    public function id()
    {
        return $this->_id;
    } 

    public function hours()
    {
        return $this->_hours;
    }

    public function setId($id)
    {
        $id = (int) $id;
    
        if ($id > 0)
        {
            $this->_id = $id;
        }
    }

    public function setHours($hours)
    {
        if (is_string($hours))
        {
            $this->_hours = $hours;
        }
    }
}
