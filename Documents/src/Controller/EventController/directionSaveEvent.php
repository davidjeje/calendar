<?php    
function directionSaveEvent()
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
	
    if (isset($_POST['Ajouter'])) 
    {
        $name = htmlspecialchars($_POST['name']); 
        $date = htmlspecialchars($_POST['date']);
        $start = htmlspecialchars($_POST['start']); 
        $end = htmlspecialchars($_POST['end']);
        $description = htmlspecialchars($_POST['description']);

        if (isset($name) AND !empty($name) /*AND preg_match('#^[a-zA-Z0-9éèàêâùïüë]+$#', $name)*/)
        {
            if (isset($date) AND !empty($date) AND preg_match('#^[0-9]{4}-[0-9]{1,2}-[0-9]{1,2}$#', $date))
            {
                if (isset($start) AND !empty($start) AND preg_match('#^[0-9]{2}:[0-9]{2}$#', $start))
                {
                    if (isset($end) AND !empty($end) AND preg_match('#^[0-9]{2}:[0-9]{2}$#', $end))
                    {
                        if (isset($description) AND !empty($description) AND preg_match('#^[a-zA-Z0-9éèàêâùïüë\s\r\n\t().!,;:\'-]+$#', $description))
                        {
                            $newStart = DateTime::createFromFormat('Y-m-d H:i', $date . ' ' . $start);
                            $newEnd = DateTime::createFromFormat('Y-m-d H:i', $date . ' ' . $end);

                            /*var_dump($newStart->format('Y-m-d H:i'));
                            die();*/
                            if($newStart < $newEnd)
                            {
                                $Event = new Event(); 
                                $Event->setName($name);  
                                $Event->setDescription($description);
                                $Event->setStart($newStart->format('Y-m-d H:i'));  
                                $Event->setEnd($newEnd->format('Y-m-d H:i'));

                                $create = $EventManager->create($Event); 

                                if($create == true)
                                {
                                    $message = "L'ajout de l'évènement à bien fonctionné !!!";
                                    $session->setFlash($message);
                                }
                                else
                                {
                                    $message = "L'ajout de l'évènement à échoué !!!";
                                    $session->setFlash($message);
                                }  
                                
                                include(dirname(__FILE__).'/../../../view/addEventPage.php'); 
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
    else
    {  
        $error = new Error();
        $message = "L'envois des données à échoué !!!";
		$error->setError($message);
		
		$displayMessage = $error->error();
		
        include(dirname(__FILE__).'/../../../view/400Page.php');
    }    
}  