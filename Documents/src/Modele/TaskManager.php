<?php 
include(dirname(__FILE__).'/../Modele/Task.php');
//require '/../Modele/Task.php';
 
class TaskManager
{
    private $_SqlRequest;
    private $_Objects;
    private $_bdd ;
  
    public function __construct($bdd)
    {
        $this->setDb($bdd);
    }
  
    public function allTasks()   
    { 
        $this->_Objects = []; 
        $tasks = [];
        $this->_SqlRequest = $this->_bdd->query('SELECT * FROM task');
      
        while ($tasks = $this->_SqlRequest->fetch(PDO::FETCH_ASSOC)) 
        {
            $this->_Objects[] = new Task($tasks);
        }
        return $this->_Objects;           
    } 

    public function lastIdTask()   
    { 
        $this->_Objects = []; 
        $tasks = [];
        $this->_SqlRequest = $this->_bdd->query('SELECT max(id) as id FROM task');
      
        while ($tasks = $this->_SqlRequest->fetch(PDO::FETCH_ASSOC)) 
        {
            $this->_Objects[] = new Task($tasks);
        }
        return $this->_Objects;           
    } 

    public function oneTask($id)
    {
        $this->_SqlRequest = $this->_bdd->prepare('SELECT *  FROM task WHERE id = :id ');
      
        $this->_SqlRequest->bindValue(':id', $id, PDO::PARAM_INT);
        
        $executeIsOk = $this->_SqlRequest->execute();

        if($executeIsOk == true)
        { 
            return new Task($this->_SqlRequest->fetch());
        }
        else
        {
            return false;
        }       
    }

    public function create(Task $task)
    {
        $this->_SqlRequest = $this->_bdd->prepare('INSERT INTO task (id, name, description, date, hour) VALUES (NULL, :name, :description, :date, :hour )');

        $this->_SqlRequest->bindValue(':name', $task->name(), PDO::PARAM_STR);
        $this->_SqlRequest->bindValue(':description', $task->description(), PDO::PARAM_STR);
        $this->_SqlRequest->bindValue(':date', $task->date(), PDO::PARAM_STR);
        $this->_SqlRequest->bindValue(':hour', $task->hour(), PDO::PARAM_STR);
    
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

    public function update(Task $task, $id)
    {
    
        $this->_SqlRequest = $this->_bdd->prepare('UPDATE task SET name = :name, date = :date, description = :description, hour = :hour WHERE id = :id LIMIT 1');

        $this->_SqlRequest->bindValue(':name', $task->name(), PDO::PARAM_STR);
        $this->_SqlRequest->bindValue(':date', $task->date(), PDO::PARAM_STR);
        $this->_SqlRequest->bindValue(':hour', $task->hour(), PDO::PARAM_STR);
        $this->_SqlRequest->bindValue(':description', $task->description(), PDO::PARAM_STR);
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
        $this->_SqlRequest = $this->_bdd->prepare('DELETE FROM task WHERE id = :id');

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