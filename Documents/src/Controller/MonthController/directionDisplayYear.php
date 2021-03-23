<?php    
function directionDisplayYear()   
{    
	function chargerMaClasse($classe) 
	{
    	include(dirname(__FILE__).'/../../Modele/' . $classe . '.php');
	}
	spl_autoload_register('chargerMaClasse');

	$bdd = new PDO('mysql:host=localhost;dbname=calendar;charset=utf8', 'root', '');

	$Month = new Month();

	$imgs = $Month->_imgs;
	//Les jours de la semaine en toutes lettres.
	$weekDay = $Month->_days;

	$month = $Month->_months;
	
	function year()
	{
		
		if( !isset($_GET['year']) and empty($_GET['year']))
		{
			$Object = new DateTime();

			$year = $Object->format("Y");
		}
		else
		{
			$year = htmlspecialchars($_GET['year']);
		}

		return $year;
	} 
	
	function previousYear()
	{
		$year = year();
		$previous = $year - 1;
		return $previous;
	}

	function nextYear()
	{
		$year = year();
		$next = $year + 1;
		return $next;
	}
	include(dirname(__FILE__).'/../../../view/yearPage.php');
}  