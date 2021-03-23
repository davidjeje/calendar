<?php      
function directionDisplayMonth()    
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
	}
	catch(\Exception $e)
	{
		$e = header('location: view/404Page.php');
	}

	$idMonth = htmlspecialchars($_GET['idMonth']) ; 
	$year = htmlspecialchars($_GET['year']);
	
	if (isset($idMonth) AND !empty($idMonth) AND $idMonth >= 1 AND $idMonth <= 12)
	{
		// 1 : On force la conversion en nombre entier
		$idMonth = (int) $idMonth;

		if(isset($year) AND !empty($year) AND $year >= 1967)
		{
			// 1 : On force la conversion en nombre entier
			$year = (int) $year;

			function previousMonth()
			{ 
				$idMonth = htmlspecialchars($_GET['idMonth']) - 1;
				$year = htmlspecialchars($_GET['year']);
		
				if($idMonth < 1)
				{
					$idMonth = 12;
					$year +=1;
				}

				return $idMonth;
			}
			
			function previousMonth2()
			{
				$idMonth = htmlspecialchars($_GET['idMonth']) - 1; 
				$year = htmlspecialchars($_GET['year']);

				if($idMonth < 1)
				{
					$idMonth = 12;
					$year -=1;
				}

				return $year;
			}

			function nextMonth()
			{
				$idMonth = htmlspecialchars($_GET['idMonth']) + 1; 
				//$year = htmlspecialchars($_GET['year']);

				if($idMonth > 12)
				{
					$idMonth = 1;
					//$year +=1;
				}

				return $idMonth;
			}

			function nextMonth2()
			{
				$idMonth = htmlspecialchars($_GET['idMonth']) + 1; 
				$year = htmlspecialchars($_GET['year']);

				if($idMonth > 12)
				{
					$year +=1;
				}

				return $year;
			}
			
			$Month = new Month();
    		
			//Les jours de la semaine en toutes lettres.
			$weekDay = $Month->_days;

			//Mois et année en toutes lettres
			$letterMonth = $Month->_months[$idMonth - 1] . ' ' . $year;

			$start = new \dateTime("{$year}-{$idMonth}-01");

    		$cloneStart = clone $start;

			$end = $cloneStart->modify('+ 1 month - 1 day');
			
			$clonestart6 = clone $end;
	
			$clonestart6->format("y-m-d 00:00:00");
			$clonestart5 = clone $start;
			$clonestart5->format("y-m-d 00:00:00");

			$allEvents = $EventManager->allEvents();

			$end = $end->format('d');

			function weeksNumber($idMonth, $year) 
			{
				$day = mktime(1, 1, 1, $idMonth, 1, $year);
				//var_dump($day);//retourne 1598922061
				//die();
				$nday = mktime(1, 1, 1, $idMonth, date('t', $day), $year);
				//var_dump($nday);//retourne 1601427661
				//die();
				$week = date('W', $day);
				//var_dump($week);//retourne 36
				//die();
				$nweek = date('W', $nday);
				//var_dump($nweek);//retourne 40
				//die();
				$lweek = date('W', mktime(1, 1, 1, 12, 28, $year));
				//var_dump($lweek);// retourne 53
				//die();
				if ($nweek > $week) $res = $nweek - $week;
				else if ($lweek > $week) $res = $nweek + $lweek - $week;
				else $res = (int)$nweek;
				return $res + 1;
			}
	   
			/*var_dump(weeksNumber($idMonth, $year));
			die();*/

			/*function nombreDeSemaine($mois,$annee)
			{
				$semaines=1;
				$ChiffreJour=date('N',mktime(1,1,1,$mois,1,$annee));//1,2,3,4,5,6,7 le premier jour du mois (1 (pour Lundi) à 7 (pour Dimanche))
				$NbrJrDsLeMois=date('t',mktime(1,1,1,$mois,1,$annee));//nombre de jour dans le mois

				for($jr=1; $jr<=$NbrJrDsLeMois; $jr++)
				{
					if($ChiffreJour==8)
					{
						$ChiffreJour=1;
						$semaines++;
					}
					$ChiffreJour++;
				}
				return $semaines;
			}
			//echo nombreDeSemaine(3,2020);//6, le mois peut être précisé avec ou sans zéro initial, ex: 01 ou 1
	
			var_dump(nombreDeSemaine($idMonth, $year));
			die;*/

	
			$cloneStart2 = clone $start;
			$cloneStart3 = clone $start;
			
			$firstMonday = $cloneStart3->modify('last monday');
			
			$cloneFirstMonday = $cloneStart2->format('N') == '1' ? $cloneStart2 : $firstMonday;

			$cloneFirstMonday = $cloneFirstMonday->modify('- 1 day');

			function withInMonth(\DateTime $date)
			{
				$idMonth = htmlspecialchars($_GET['idMonth']); 
				$year = htmlspecialchars($_GET['year']);
				$start = new \dateTime("{$year}-{$idMonth}-01");

				return $start->format('y-m') === $date->format('y-m');
			}
 
			include(dirname(__FILE__).'/../../../view/homePage.php');
		}
		else
		{
			$error = new Error();
			$message ='L\'année n\'existe pas ou n\'est pas suppérieur ou égale à 1967.';
			
			$error->setError($message);
			
			$displayMessage = $error->error();
			
			include(dirname(__FILE__).'/../../../view/400Page.php');	
		}
	}
	else
	{
		$error = new Error();
		$message ='Le numéro du mois n\'existe pas ou n\'est pas compris entre 1 et 12.';
		
		$error->setError($message);
		
		$displayMessage = $error->error();
			
		include(dirname(__FILE__).'/../../../view/400Page.php');
	}
}  