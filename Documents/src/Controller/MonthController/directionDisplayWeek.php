<?php     
function directionDisplayWeek()    
{    
	function chargerMaClasse($classe) 
	{
    	include(dirname(__FILE__).'/../../Modele/' . $classe . '.php');
	}
	spl_autoload_register('chargerMaClasse');

	$bdd = new PDO('mysql:host=localhost;dbname=calendar;charset=utf8', 'root', '');

	$MonthManager = new MonthManager($bdd);
	$EventManager = new EventManager($bdd);
	$TaskManager = new TaskManager($bdd);

	$allEvents = $EventManager->allEvents();
	$allTasks = $TaskManager->allTasks();
	
	//Création des entités
	$Month = new Month();
	$time = new Time();

	//Les heures affichées pour chaque semaine
	$hours = $time->_hour;
	
	//Les jours de la semaine en toutes lettres.
	$weekDay = $Month->_days;
	
	//La date du jours créé automatiquement
	$dateNow = date("Y-m-d");

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

	//Clone la valeur de la date du lundi pour éviter de modifier cette valeur
	$cloneMondayWeek = clone $mondayWeek;
	$cloneMondayWeek2 = clone $mondayWeek;
	$cloneMondayWeek3 = clone $mondayWeek;
	$cloneMondayWeek4 = clone $mondayWeek;
	$cloneMondayWeek5 = clone $mondayWeek;
	$cloneMondayWeek6 = clone $mondayWeek;
	$cloneMondayWeek7 = clone $mondayWeek;
	$cloneMondayWeek8 = clone $mondayWeek;
	$cloneMondayWeek9 = clone $mondayWeek;
	$cloneMondayWeek10 = clone $mondayWeek;
	$cloneMondayWeek11 = clone $mondayWeek;
	$cloneMondayWeek12 = clone $mondayWeek;
	$cloneMondayWeek13 = clone $mondayWeek;

	//Modifie la date pour retirer un jours
	$monday = $cloneMondayWeek->modify('- 1 day');

	$tuesday = $cloneMondayWeek9->modify('next tuesday');
	
	$wednesday = $cloneMondayWeek10->modify('next wednesday');
	
	$thursday = $cloneMondayWeek11->modify('next thursday');
	
	$friday = $cloneMondayWeek12->modify('next friday');
	
	$saturday = $cloneMondayWeek13->modify('next saturday');
	
	$sunday = $cloneMondayWeek6->modify('next sunday');
	$daySunday = $cloneMondayWeek6->format('d');
	$intDaySunday = intval($daySunday);

	//Récupère la date du lundi pour la modifier et aller au prochain lundi
	$nextMonday = $cloneMondayWeek2->modify('next monday');

	$previousMonday = $cloneMondayWeek3->modify('last monday');

	//Mois et année en toutes lettres
	$letterMonth = $Month->_months[$cloneStartDate2->format('m') - 1] . ' ' . $cloneStartDate2->format('Y');
	
	include(dirname(__FILE__).'/../../../view/weekPage.php');
}  