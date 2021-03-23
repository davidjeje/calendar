<?php    
function directionUpdateValidateTask()     
{
    function chargerMaClasse($classe) 
	{
        include(dirname(__FILE__).'/../../Modele/' . $classe . '.php');
	}
    spl_autoload_register('chargerMaClasse');
    $session = new Session();

    try
    {
        $bdd = new PDO('mysql:host=localhost;dbname=calendar;charset=utf8', 'root', '');
        $TaskManager = new TaskManager($bdd);
    }
    catch(\Exception $e)
	{
		$e = header('location: view/404Page.php');
	}  
     
	if (isset($_POST['Modifier'])) 
    {
        $idTask = htmlspecialchars($_POST['idTask']);
        $name = htmlspecialchars($_POST['name']); 
        $date = htmlspecialchars($_POST['date']);
        $hour = htmlspecialchars($_POST['hour']);  
        $description = htmlspecialchars($_POST['description']);

        if (isset($name) AND !empty($name) AND preg_match('#^[a-zA-Z0-9éèàêâùïüë\s]+$#', $name))
        {
            if (isset($date) AND !empty($date) AND preg_match('#^[0-9]{4}-[0-9]{1,2}-[0-9]{1,2}$#', $date))
            {
                if (isset($hour) AND !empty($hour) /*AND preg_match('#^[0-9]{2}:[0-9]{2}$#', $hour)*/)
                {
                    if (isset($description) AND !empty($description) AND preg_match('#^[a-zA-Z0-9éèàêâùïüë\s\r\n\t().!,;:\'-]+$#', $description))
                    {        
                        $Task = new Task(); 
                        $Task->setName($name);  
                        $Task->setDescription($description);
                        $Task->setDate($date);  
                        $Task->setHour($hour);

                        $update = $TaskManager->update($Task, $idTask);
                        
                        if($update == true)
                        {
                            $message = "La modification de la tâche à bien fonctionné !!!";
                            $session->setFlash($message);
                        }
                        else
                        {
                            $message = "La modification de la tâche à échoué !!!";
                            $session->setFlash($message);
                        } 
                        include(dirname(__FILE__).'/../../../view/successUpdateOrDeleteEntityPage.php');      
                    }
                    else
                    {
                        $error = new Error();
                        $message = "Le format description n'est pas correct !!!";
		                $error->setError($message);
		              
		                $displayMessage = $error->error();
		                
                        include(dirname(__FILE__).'/../../../view/400Page.php');
                    }
                }
                else
                {
                    $error = new Error();
                    $message = "Le format heure n'est pas correct !!!";
		            $error->setError($message);
		            
		            $displayMessage = $error->error();
		            
                    include(dirname(__FILE__).'/../../../view/400Page.php');   
                }
            }
            else
            {
                $error = new Error();
                $message = "Le format date n'est pas correct !!!";
		        $error->setError($message);
		        
		        $displayMessage = $error->error();
		        
                include(dirname(__FILE__).'/../../../view/400Page.php');
            }  
        }
        else
        {
            $error = new Error();
            $message = "Le format du pseudo n'est pas correct !!!";
		    $error->setError($message);
		    
		    $displayMessage = $error->error(); 
		    
            include(dirname(__FILE__).'/../../../view/400Page.php');
        }
    } 
    elseif (isset($_POST['Supprimer'])) 
    {
        $lastIdTask = $TaskManager->lastIdTask();

        foreach($lastIdTask AS $lastIdTask11)
	    {
		    $lastIdTask11 = $lastIdTask11->id();	
	    }
    
        $idTask = htmlspecialchars($_POST['idTask']);
        if (isset($idTask) AND !empty($idTask) AND $idTask >= 1 AND $idTask <= $lastIdTask11)
        {
            $delete = $TaskManager->delete($idTask);

            if($delete == true)
            {
                $message = "La suppression de la tâche à bien fonctionné !!!";
                $session->setFlash($message);                       
            }
            else
            {
                $message = "La suppresssion de la tâche à échoué !!!";
                $session->setFlash($message);
            } 
            
            include(dirname(__FILE__).'/../../../view/successUpdateOrDeleteEntityPage.php');  
        }
        else
	    {
		    $error = new Error();
		    $message ='La tâche n\'existe pas. Veuillez sélectionner une tâche existant !!!';
		    
		    $error->setError($message);
		    
		    $displayMessage = $error->error();
		    
            include(dirname(__FILE__).'/../../../view/400Page.php');
	    }
    }
	
}  