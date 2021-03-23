<?php    
function directionEditTask()     
{  
    function chargerMaClasse($classe) 
	{
    	include(dirname(__FILE__).'/../../Modele/' . $classe . '.php');
	}
	spl_autoload_register('chargerMaClasse');
	try
	{
		$bdd = new PDO('mysql:host=localhost;dbname=calendar;charset=utf8', 'root', '');

    	$TaskManager = new TaskManager($bdd);

		$lastIdTask = $TaskManager->lastIdTask();

		$idTask = htmlspecialchars($_GET['idTask']); 
		
	}
	catch(\Exception $e)
	{
		$e = header('location: view/404Page.php');
	}  

	foreach($lastIdTask AS $lastIdTask11)
	{
		$lastIdTask11 = $lastIdTask11->id();	
	}
	
	if(isset($idTask) AND !empty($idTask) AND $idTask >= 1 AND $idTask <= $lastIdTask11)
	{ 
		$idTask = (int) $idTask;

		try
		{
			$oneTask = $TaskManager->oneTask($idTask);
		}
		catch(\Exception $e)
		{
			$e = header('location: view/404Page.php');
		}   
		include(dirname(__FILE__).'/../../../view/editTaskPage.php'); 
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