<?php

//namespace App/Modele;

class Task 
{
    private $_id,
           $_name,
           $_description,
           $_date,
           $_hour;

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

    public function name()
    {
        return $this->_name;
    }

    public function description()
    {
        return $this->_description;
    }

    public function date()
    {
        return $this->_date;   
    }

    public function hour()
    {
        return $this->_hour;   
    }

    public function setId($id)
    {
        $id = (int) $id;
    
        if ($id > 0)
        {
            $this->_id = $id;
        }
    }

    public function setName($name)
    {
        if (is_string($name))
        {
            $this->_name = $name; 
        }
    }

    public function setDescription($description)
    {
        if (is_string($description))
        {
            $this->_description = $description;
        }
    }

    public function setDate($date)
    {
        if (is_string($date))
        {
            $this->_date = $date;
        }
    }

    public function setHour($hour)
    {
        if (is_string($hour))
        {
            $this->_hour = $hour;
        }
    }
}
