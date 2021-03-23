<?php 
//require '/../Modele/Objective.php';
include(dirname(__FILE__).'/../Modele/Objective.php');
 
class ObjectiveManager
{
    private $_SqlRequest;
    private $_Objects;
    private $_bdd ;
   
    public function __construct($bdd)
    {
        $this->setDb($bdd);
    }
  
    public function allObjectives()    
    { 
        $this->_Objects = []; 
        $objectives = [];
        $this->_SqlRequest = $this->_bdd->query('SELECT * FROM objective');
      
        while ($objectives = $this->_SqlRequest->fetch(PDO::FETCH_ASSOC)) 
        {
            $this->_Objects[] = new Objective($objectives);
        }
        return $this->_Objects;           
    }

    public function lastIdObjectives()    
    { 
        $this->_Objects = []; 
        $objectives = [];
        $this->_SqlRequest = $this->_bdd->query('SELECT max(id) as id FROM objective');
      
        while ($objectives = $this->_SqlRequest->fetch(PDO::FETCH_ASSOC)) 
        {
            $this->_Objects[] = new Objective($objectives);
        }
        return $this->_Objects;           
    }
    
    public function create(Objective $objective)
    {
        $this->_SqlRequest = $this->_bdd->prepare('INSERT INTO objective (id, name, family, description) VALUES (NULL, :name, :family, :description)');

        $this->_SqlRequest->bindValue(':name', $objective->name(), PDO::PARAM_STR);
        $this->_SqlRequest->bindValue(':family', $objective->family(), PDO::PARAM_STR);
        $this->_SqlRequest->bindValue(':description', $objective->description(), PDO::PARAM_STR);
    
        $executeIsOk = $this->_SqlRequest->execute();

        if(!$executeIsOk)
        {
            return false;
        } 
        else
        {
            $id = $this->_bdd->lastInsertId();
            return true;
        }   
    }

    public function oneObjective($id)
    {
        $this->_SqlRequest = $this->_bdd->prepare('SELECT *  FROM objective WHERE id = :id ');
      
        $this->_SqlRequest->bindValue(':id', $id, PDO::PARAM_INT);
        
        $executeIsOk = $this->_SqlRequest->execute();

        if($executeIsOk == true)
        { 
            return new Objective($this->_SqlRequest->fetch());
        }
        else
        {
            return false;
        }       
    }

    public function update(Objective $objective, $id)
    {
        $this->_SqlRequest = $this->_bdd->prepare('UPDATE objective SET name = :name, family = :family, description = :description WHERE id = :id LIMIT 1');

        $this->_SqlRequest->bindValue(':name', $objective->name(), PDO::PARAM_STR);
        $this->_SqlRequest->bindValue(':family', $objective->family(), PDO::PARAM_STR);
        $this->_SqlRequest->bindValue(':description', $objective->description(), PDO::PARAM_STR);
        $this->_SqlRequest->bindValue(':id', $id, PDO::PARAM_INT);
    
        return $this->_SqlRequest->execute();
    }

    public function delete($id)
    {
        $this->_SqlRequest = $this->_bdd->prepare('DELETE FROM objective WHERE id = :id');

        $this->_SqlRequest->bindValue(':id', $id, PDO::PARAM_INT);
    
        $executeIsOk = $this->_SqlRequest->execute();

        if($executeIsOk)
        {
            return true;
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