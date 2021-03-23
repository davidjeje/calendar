<?php    
function directionEditObjective()    
{     
	function chargerMaClasse($classe) 
	{
    	include(dirname(__FILE__).'/../../Modele/' . $classe . '.php');
	}
	spl_autoload_register('chargerMaClasse');

	try
	{
		$bdd = new PDO('mysql:host=localhost;dbname=calendar;charset=utf8', 'root', '');

		$ObjectiveManager = new ObjectiveManager($bdd);

		$idObjective = htmlspecialchars($_GET['idObjective']); 

		$lastIdObjectives = $ObjectiveManager->lastIdObjectives();
	}
	catch(\Exception $e)
	{
		$e = header('location: view/404Page.php');
	}

	foreach($lastIdObjectives AS $lastIdObjectives1)
	{
		$lastIdObjectives1 = $lastIdObjectives1->id();	
	}
	
	if(isset($idObjective) AND !empty($idObjective) AND $idObjective >= 1 AND $idObjective <= $lastIdObjectives1)
	{ 
		$idObjective = (int) $idObjective;

		try
		{
			$oneObjective = $ObjectiveManager->oneObjective($idObjective);
		}
		catch(\Exception $e)
		{
			$e = header('location: view/404Page.php');
		}
	
		include(dirname(__FILE__).'/../../../view/editObjectivePage.php');
	}
	else
	{
		$error = new Error();
		$message ='L\'objectif n\'existe pas. Veuillez sélectionner un objectif existant !!!';
		
		$error->setError($message);
		
		$displayMessage = $error->error();
		
		include(dirname(__FILE__).'/../../../view/400Page.php');
	} 
} 