<?php    
function directionDisplayTest()    
{     
	function chargerMaClasse($classe) 
	{
    	include(dirname(__FILE__).'/../../Modele/' . $classe . '.php');
	}
	spl_autoload_register('chargerMaClasse');

	$bdd = new PDO('mysql:host=localhost;dbname=calendar;charset=utf8', 'root', '');

	$MonthManager = new MonthManager($bdd);
	$EventManager = new EventManager($bdd);

	$allEvents = $EventManager->allEvents();

	$Month = new Month();

	//Les jours de la semaine en toutes lettres.
	$weekDay = $Month->_days;

	//La date du jours créé automatiquement
	$dateNow = date("Y-m-d");
	
	//L'heure du jours créé automatiquement
	$hourNow =date(" H:i:s"); 

	//Transforme la date du jours en objet date pour pouvoir modifier cette date
	$dateNowWeek = new \dateTime($dateNow);
	
	// Permet de choisir la date du jours pour afficher la semaine du moment ou de prendre pour référence une autre date dans le but d'implémenter une autre semaine
	$startDate = isset($_GET['monday']) == true ? new \dateTime("{$_GET['year']}-{$_GET['month']}-{$_GET['monday']}") : $dateNowWeek;

	//Clone la date du jours en objet pour éviter de modifier sa valeur
	$cloneStartDate = clone $startDate;
	$cloneStartDate2 = clone $startDate;

	//Permet d'avoir la date du dernier lundi
	$lastMonday = $cloneStartDate->modify('last monday');

	//Si la date du jours est un lundi alors on garde cette date si non on prend la date du dernier lundi de la semaine
	$mondayWeek = $startDate->format('N') == '1' ? $startDate : $lastMonday;
	/*var_dump($mondayWeek);
	die();*/

	//Clone la valeur de la date du lundi pour éviter de modifier cette valeur
	$cloneMondayWeek = clone $mondayWeek;
	$cloneMondayWeek2 = clone $mondayWeek;
	$cloneMondayWeek3 = clone $mondayWeek;

	//Modifie la date pour retirer un jours
	$monday = $cloneMondayWeek->modify('- 1 day');

	//Récupère la date du lundi pour la modifier et aller au prochain lundi
	$nextMonday = $cloneMondayWeek2->modify('next monday');

	$previousMonday = $cloneMondayWeek3->modify('last monday');

	//Mois et année en toutes lettres
	$letterMonth = $Month->_months[$cloneStartDate2->format('m') - 1] . ' ' . $cloneStartDate2->format('Y');
	
	include(dirname(__FILE__).'/../../../view/test.php'); 
	//require '/../../../view/weeksMonth.php';
}  