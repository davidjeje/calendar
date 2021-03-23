<?php 
include(dirname(__FILE__).'/../Modele/Month.php');
//require '/../Modele/Month.php';
 
class MonthManager
{
    private $_SqlRequest;
    private $_Objects;
    private $_bdd ;
  
    public function __construct($bdd)
    {
        $this->setDb($bdd);
    }
  
    public function allMonths()  
    { 
        $this->_Objects = [];
        $months = [];
        $this->_SqlRequest = $this->_bdd->query('SELECT * FROM month');
      
        while ($months = $this->_SqlRequest->fetch(PDO::FETCH_ASSOC)) 
        {
            $this->_Objects[] = new Month($months);
        }
        return $this->_Objects;           
    } 

    public function oneMonth($id, $numberYear)
    {
        $this->_SqlRequest = $this->_bdd->prepare('SELECT *  FROM month WHERE id = :id and numberYear = :numberYear ');
      
        $this->_SqlRequest->bindValue(':id', $id, PDO::PARAM_INT);
        $this->_SqlRequest->bindValue(':numberYear', $numberYear, PDO::PARAM_INT);
        
        $executeIsOk = $this->_SqlRequest->execute();

        if($executeIsOk)
        { 
            return new Month($this->_SqlRequest->fetch());
        }
        else
        {
            return false;
        }       
    }  

    public function setDb(PDO $bdd)
    {
        $this->_bdd = $bdd;
    }   
}