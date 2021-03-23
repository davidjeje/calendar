<?php    
function directionSaveTask()
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
	
    if (isset($_POST['Ajouter'])) 
    {
        $name = htmlspecialchars($_POST['name']); 
        $date = htmlspecialchars($_POST['date']);
        $hour = htmlspecialchars($_POST['inlineRadioOptions']);  
        $description = htmlspecialchars($_POST['description']);

        if (isset($name) AND !empty($name) AND preg_match('#^[a-zA-Z0-9éèàêâùïüë\s]+$#', $name))
        {
            if (isset($date) AND !empty($date) AND preg_match('#^[0-9]{4}-[0-9]{1,2}-[0-9]{1,2}$#', $date)) 
            {
                if (isset($hour) AND !empty($hour) AND preg_match('#^[0-9]{2}:[0-9]{2}$#', $hour))
                {
                    if (isset($description) AND !empty($description) AND preg_match('#^[a-zA-Z0-9éèàêâùïüë\s\r\n\t().!,;:\'-]+$#', $description))
                    {
                        //La date du jours créé automatiquement
	                    $dateNow = date("Y-m-d");
	               
	                    //L'heure du jours créé automatiquement
                        $hourNow = date(" H:i");
                        
                        if($date >= $dateNow)
                        {
                            if($hour > $hourNow)
                            {
                                $Task = new Task(); 
                                $Task->setName($name);  
                                $Task->setDescription($description); 
                                $Task->setDate($date);
                                $Task->setHour($hour);

                                $create = $TaskManager->create($Task);
                        
                                if($create == true)
                                {
                                    $message = "L'ajout de la tâche à bien fonctionné !!!";
                                    $session->setFlash($message);
                                }
                                else
                                {
                                    $message = "L'ajout de la tâche à échoué !!!";
                                    $session->setFlash($message);

                                }  
                                
                                include(dirname(__FILE__).'/../../../view/addTaskPage.php');  
                            }
                            else
                            {
                                $error = new Error();
                                $message = "L'heure sélectionnée n'est pas correct !!! Elle doit faire référence aux heures à venir.";
		                        $error->setError($message);
		                        
		                        $displayMessage = $error->error();
		                        
                                include(dirname(__FILE__).'/../../../view/400Page.php');
                            }   
                        }
                        else
                        {
                            $error = new Error();
                            $message = "La date sélectionnée n'est pas correct !!! Elle doit faire référence à ce jour ou aux jours à venir.";
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