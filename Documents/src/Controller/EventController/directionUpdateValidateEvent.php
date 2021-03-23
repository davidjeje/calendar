<?php    
function directionUpdateValidateEvent()    
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
        $EventManager = new EventManager($bdd);
    }
    catch(\Exception $e)
	{
		$e = header('location: view/404Page.php');
	}  
	
    if (isset($_POST['Modifier'])) 
    {
        $idEvent = htmlspecialchars($_POST['idEvent']);
        $name = htmlspecialchars($_POST['name']); 
        $date = htmlspecialchars($_POST['date']);
        $start = htmlspecialchars($_POST['start']);  
        $end = htmlspecialchars($_POST['end']);
        $description = htmlspecialchars($_POST['description']);

        if (isset($name) AND !empty($name) AND preg_match('#^[a-zA-Z0-9éèàêâùïüë]+$#', $name))
        {
            if (isset($date) AND !empty($date) AND preg_match('#^[0-9]{4}-[0-9]{1,2}-[0-9]{1,2}$#', $date))
            {
                if (isset($start) AND !empty($start) /*AND preg_match('#^[0-9]{2}:[0-9]{2}$#', $start)*/)
                {
                    if (isset($end) AND !empty($end) /*AND preg_match('#^[0-9]{2}:[0-9]{2}$#', $end)*/)
                    {
                        if (isset($description) AND !empty($description) AND preg_match('#^[a-zA-Z0-9éèàêâùïüë\s\r\n\t().!,;:\'-]+$#', $description))
                        {
                            $newStart = $date . ' ' . $start;
                            $newEnd = $date . ' ' . $end;

                            if($start < $end)
                            {
                                $Event = new Event(); 
                                $Event->setName($name);  
                                $Event->setDescription($description);
                                $Event->setStart($newStart);  
                                $Event->setEnd($newEnd);

                                $update = $EventManager->update($Event, $idEvent);

                                if($update == true)
                                {
                                    $message = "La modification de l'évènement à bien fonctionné !!!";
                                    $session->setFlash($message);
                                }
                                else
                                {
                                    $message = "La modification de l'évènement à échoué !!!";
                                    $session->setFlash($message);
                                }
                                
                                include(dirname(__FILE__).'/../../../view/successUpdateOrDeleteEntityPage.php');
                            }
                            else
                            {
                                $error = new Error();
                                $message = "L'heure de début doit être inférieur à l'heure de fin.";
		                        $error->setError($message);
		                        
		                        $displayMessage = $error->error();
		                        
                                include(dirname(__FILE__).'/../../../view/400Page.php');
                            }
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
        $lastIdEvent = $EventManager->lastIdEvent();

        foreach($lastIdEvent AS $lastIdEvent11)
	    {
		    $lastIdEvent11 = $lastIdEvent11->id();	
	    }
    
        $idEvent = htmlspecialchars($_POST['idEvent']);

        if (isset($idEvent) AND !empty($idEvent) AND $idEvent >= 1 AND $idEvent <= $lastIdEvent11)
        {
            $delete = $EventManager->delete($idEvent);

            if($delete == true )
            {
                $message = "La suppression de l'évènement à bien fonctionné !!!";
                $session->setFlash($message);                      
            }
            else
            {
                $message = "La suppression de l'évènement à échoué !!!";
                $session->setFlash($message);
            }
            
            include(dirname(__FILE__).'/../../../view/successUpdateOrDeleteEntityPage.php');
        } 
        else
	    {
		    $error = new Error();
		    $message ='L\'évènement n\'existe pas. Veuillez sélectionner un évènement existant !!!';
		    
		    $error->setError($message);
		    
		    $displayMessage = $error->error();
		    
            include(dirname(__FILE__).'/../../../view/400Page.php');
	    }        
    }   
}  