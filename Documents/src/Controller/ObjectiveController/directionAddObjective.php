<?php     
function directionAddObjective()    
{    
	function chargerMaClasse($classe) 
	{
    	include(dirname(__FILE__).'/../../Modele/' . $classe . '.php');
	}
	spl_autoload_register('chargerMaClasse');

	$bdd = new PDO('mysql:host=localhost;dbname=calendar;charset=utf8', 'root', '');
	
	include(dirname(__FILE__).'/../../../view/addObjectivePage.php');
	
}  