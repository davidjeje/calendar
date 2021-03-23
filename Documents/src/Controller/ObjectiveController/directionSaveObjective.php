<?php    
function directionSaveObjective()
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

        $ObjectiveManager = new ObjectiveManager($bdd);
    }
    catch(\Exception $e)
	{
		$e = header('location: view/404Page.php');
	}
    
    if (isset($_POST['Ajouter'])) 
    {
        $name = htmlspecialchars($_POST['name']); 
        $family = htmlspecialchars($_POST['family']);
        $description = htmlspecialchars($_POST['description']);
       
        if (isset($name) AND !empty($name) AND preg_match('#^[a-zA-Z0-9éèàêâùïüë\s]+$#', $name))
        {
            if (isset($family) AND !empty($family) AND preg_match('#^[a-zA-Z0-9éèàêâùïüë\s]+$#', $family))
            {
                if (isset($description) AND !empty($description) /*AND preg_match('#^[a-zA-Z0-9éèàêâùïüë\s\r\n\t().!,;:?\'-]+$#', $description)*/)
                {
                    $Objective = new Objective();  
                    $Objective->setName($name);
                    $Objective->setFamily($family);   
                    $Objective->setDescription($description);

                    $create = $ObjectiveManager->create($Objective);
                     
                    if($create == true)
                    {
                        $message = "L'ajout de l'objectif à bien fonctionné !!!";
                        $session->setFlash($message);
                    }
                    else
                    {
                        $message = "L'ajout de l'objectif à échoué !!!";
                        $session->setFlash($message);
                    }  
                    
                    include(dirname(__FILE__).'/../../../view/addObjectivePage.php'); 
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
                $message = "Le format du groupe famille n'est pas correct !!!";
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