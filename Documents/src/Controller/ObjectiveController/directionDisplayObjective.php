<?php    
function directionDisplayObjective()    
{     
	function chargerMaClasse($classe) 
	{
    	include(dirname(__FILE__).'/../../Modele/' . $classe . '.php');
	}
	spl_autoload_register('chargerMaClasse');

	$bdd = new PDO('mysql:host=localhost;dbname=calendar;charset=utf8', 'root', '');

	$ObjectiveManager = new ObjectiveManager($bdd);
    
    $allObjectives = $ObjectiveManager->allObjectives();
   
	include(dirname(__FILE__).'/../../../view/objectivePage.php');	
}  