<?php    
function directionEditEvent()    
{    
	function chargerMaClasse($classe) 
	{
    	include(dirname(__FILE__).'/../../Modele/' . $classe . '.php');
	}
	spl_autoload_register('chargerMaClasse');

	try
    {
		$bdd = new PDO('mysql:host=localhost;dbname=calendar;charset=utf8', 'root', '');

		$EventManager = new EventManager($bdd);
		
		$lastIdEvent = $EventManager->lastIdEvent();
	}
	catch(\Exception $e)
	{
		$e = header('location: view/404Page.php');
	}  

	foreach($lastIdEvent AS $lastIdEvent11)
	{
		$lastIdEvent11 = $lastIdEvent11->id();	
	}

	$idEvent = htmlspecialchars($_GET['idEvent']); 
		
	if(isset($idEvent) AND !empty($idEvent) AND $idEvent >= 1 AND $idEvent <= $lastIdEvent11)
	{
		// 1 : On force la conversion en nombre entier
		$idEvent = (int) $idEvent;

		try
		{
			$oneEvent = $EventManager->oneEvent($idEvent);
			$date = explode(' ', $oneEvent->start())[0];
			$startHour = explode(' ', $oneEvent->start())[1];
			$endHour =  explode(' ', $oneEvent->end())[1];
			/*var_dump($oneEvent->id());
			die();*/
		}
		catch(\Exception $e)
		{
			$e = header('location: view/404Page.php');
		}

		include(dirname(__FILE__).'/../../../view/eventEditPage.php');
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