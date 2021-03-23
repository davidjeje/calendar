<?php    
function directionDeleteObjective() 
{  
    function chargerMaClasse($classe) 
	{
        include(dirname(__FILE__).'/../../Modele/' . $classe . '.php');
	}
    spl_autoload_register('chargerMaClasse'); 
    $session = new Session();

    $bdd = new PDO('mysql:host=localhost;dbname=calendar;charset=utf8', 'root', '');

    $ObjectiveManager = new ObjectiveManager($bdd);

    $idObjective = htmlspecialchars($_GET['idObjective']);
    
    if (isset($idObjective) AND !empty($idObjective))
    {
        $delete = $ObjectiveManager->delete($idObjective);

        if($delete == true)
        {
            $message = "La suppression de l'objectif à bien fonctionné !!!";
            $session->setFlash($message);
            
            include(dirname(__FILE__).'/../../../view/objectiveDeletePage.php');                           
        }
    }
}
    