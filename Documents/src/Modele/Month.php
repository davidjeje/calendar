<?php
 
//namespace App/Modele;
 
class Month 
{
    private $_id,
            $_month,
            $_numberYear,
            $_weeks; 
    public  $_months = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
    public  $_days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
    public  $_imgs = ['janvier.jpg', 'fevrier.jpg', 'mars.jpg', 'avril.jpg', 'mai.jpg', 'juin.jpg', 'juillet.jpg', 'août.jpg', 'septembre.jpg', 'octobre.jpg', 'novembre.jpg', 'décembre.jpg']; 

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

    public function month()
    {
        return $this->_month;
    }

    public function numberYear()
    {
        return $this->_numberYear;
    }

    public function months()
    {
        return $this->_months;
    }

    public function setId($id)
    {
        $id = (int) $id;
    
        if ($id > 0)
        {
            $this->_id = $id;
        }
    }

    public function setMonth($month)
    {
        $month = (int) $month;

        if ($month > 0)
        {
            $this->_month = $month;
        }
    }

    public function setNumberYear($numberYear)
    {
        $numberYear = (int) $numberYear;
    
        if ($numberYear > 0)
        {
            $this->_numberYear = $numberYear;
        }
    }

    /**
     * Renvoie le nombre de semaine dans le mois.
     */
    public function weeks()
    {
        $start = new \dateTime("{this->numberYear}-{this->month}-01");
        $cloneStart = clone $start;
        $end = $cloneStart->modify('+ 1 month - 1 day');
        $weeks = intval($end->format('W')) - intval($start->format('W')) + 1;

        if($weeks < 0)
        {
            $weeks = intval($end->format('W'));
        }
        return $weeks;
    }

    /**
     * Renvoie le premier jour du mois.
     * @ Return DateTime
     */
    public function firstDayMonth()
    {
        return new \dateTime("{this->numberYear}-{this->month}-01");
    }


}
