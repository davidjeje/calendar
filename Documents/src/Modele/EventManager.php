<?php  
include(dirname(__FILE__).'/../Modele/Event.php');
//require '/../Modele/Event.php';
 
class EventManager
{
    private $_SqlRequest;
    private $_Objects;
    private $_bdd ;
  
    public function __construct($bdd)
    {
        $this->setDb($bdd);
    }
  
    public function allEvents()  
    { 
        $this->_Objects = []; 
        $events = [];
        $this->_SqlRequest = $this->_bdd->query('SELECT * FROM event');
      
        while ($events = $this->_SqlRequest->fetch(PDO::FETCH_ASSOC)) 
        {
            $this->_Objects[] = new Event($events);
        }
        return $this->_Objects;           
    } 

    public function lastIdEvent ()  
    { 
        $this->_Objects = []; 
        $events = []; 
        $this->_SqlRequest = $this->_bdd->query('SELECT max(id) as id FROM event');
        
        while ($events  = $this->_SqlRequest->fetch(PDO::FETCH_ASSOC))
        {
            $this->_Objects[] = new Event($events);
        
            return $this->_Objects; 
        }      
    } 

    public function allFieldStartEvent()  
    { 
        $this->_Objects = [];
        $events = [];
        $this->_SqlRequest = $this->_bdd->query('SELECT start FROM event');
      
        while ($events = $this->_SqlRequest->fetch(PDO::FETCH_ASSOC)) 
        {
            $this->_Objects[] = new Event($events);
        }
        return $this->_Objects;           
    } 

    public function oneEvent($id)
    {
        $this->_SqlRequest = $this->_bdd->prepare('SELECT *  FROM event WHERE id = :id ');
      
        $this->_SqlRequest->bindValue(':id', $id, PDO::PARAM_INT);
        
        $executeIsOk = $this->_SqlRequest->execute();

        if($executeIsOk == true)
        { 
            return new Event($this->_SqlRequest->fetch());
        }
        else
        {
            return false;
        }        
    } 
 
    public function create(Event $event)
    {
        $this->_SqlRequest = $this->_bdd->prepare('INSERT INTO event (id, name, start, end, description) VALUES (NULL, :name, :start, :end, :description )');

        $this->_SqlRequest->bindValue(':name', $event->name(), PDO::PARAM_STR);
        $this->_SqlRequest->bindValue(':start', $event->start(), PDO::PARAM_STR);
        $this->_SqlRequest->bindValue(':end', $event->end(), PDO::PARAM_STR);
        $this->_SqlRequest->bindValue(':description', $event->description(), PDO::PARAM_STR);
    
        $executeIsOk = $this->_SqlRequest->execute();

        if(!$executeIsOk)
        {
            return false;
        } 
        else
        {
            return true;
        }   
    }

    public function update(Event $event, $id)
    {
    
        $this->_SqlRequest = $this->_bdd->prepare('UPDATE event SET name = :name, start = :start, end = :end, description = :description WHERE id = :id LIMIT 1');

        $this->_SqlRequest->bindValue(':name', $event->name(), PDO::PARAM_STR);
        $this->_SqlRequest->bindValue(':start', $event->start(), PDO::PARAM_STR);
        $this->_SqlRequest->bindValue(':end', $event->end(), PDO::PARAM_STR);
        $this->_SqlRequest->bindValue(':description', $event->description(), PDO::PARAM_STR);
        $this->_SqlRequest->bindValue(':id', $id, PDO::PARAM_INT);
    
        return $this->_SqlRequest->execute();

    } 
    
    public function eventByMonth($start, $end)
    {
        
        $this->_SqlRequest = $this->_bdd->prepare('SELECT * FROM event WHERE start >= :start AND end <= :end');
        
        $this->_SqlRequest->bindParam(':start', $start, PDO::PARAM_INT);
        $this->_SqlRequest->bindParam(':end', $end, PDO::PARAM_INT);
        
        $executeIsOk = $this->_SqlRequest->execute();
        
        if($executeIsOk)
        { 
            while ($events = $this->_SqlRequest->fetch(PDO::FETCH_ASSOC)) 
            {
                $this->_Objects[] = new Event($events);
            }
            return $this->_Objects; 
        }
        else
        {
            return false;
        }       
    }

    public function delete($id)
    {
        $this->_SqlRequest = $this->_bdd->prepare('DELETE FROM event WHERE id = :id');

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