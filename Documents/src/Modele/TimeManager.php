<?php 
include(dirname(__FILE__).'/../Modele/Time.php');
//require '/../Modele/Time.php';
 
class TimeManager
{
    private $_SqlRequest;
    private $_Objects;
    private $_bdd ;
  
    public function __construct($bdd)
    { 
        $this->setDb($bdd);
    }
  
    public function allTimes()  
    { 
        $this->_Objects = [];
        $times = [];
        $this->_SqlRequest = $this->_bdd->query('SELECT * FROM time');
      
        while ($times = $this->_SqlRequest->fetch(PDO::FETCH_ASSOC)) 
        {
            $this->_Objects[] = new Time($times);
        }
        return $this->_Objects;           
    } 

    public function setDb(PDO $bdd)
    {
        $this->_bdd = $bdd;
    }   
}