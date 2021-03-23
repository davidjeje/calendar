<?php   
//$bdd = new PDO('mysql:host=localhost;dbname=calendar;charset=utf8', 'root', ''); 
  
//is_file('controleur/'.$_GET['folder']'/'.$_GET['page'].'.php')
if (!empty($_GET['file']) AND !empty($_GET['folder']) AND is_file('src/Controller/'. $_GET['folder'] . '/' .$_GET['file'].'.php') or isset($_GET['id']))
{  
    if ($_GET['folder'] == 'MonthController' AND $_GET['file'] == 'directionDisplayMonth') 
    {
        include('src/Controller/'.$_GET['folder'].'/'.$_GET['file'].'.php');
        directionDisplayMonth();
    }
    elseif ($_GET['folder'] == 'MonthController' AND $_GET['file'] == 'directionDisplayYear')  
    {
        include('src/Controller/'.$_GET['folder'].'/'.$_GET['file'].'.php');
        directionDisplayYear();
    }
    elseif ($_GET['folder'] == 'EventController' AND $_GET['file'] == 'directionEditEvent') 
    {
        include('src/Controller/'.$_GET['folder'].'/'.$_GET['file'].'.php'); 
        directionEditEvent(); 
    }
    elseif ($_GET['folder'] == 'EventController' AND $_GET['file'] == 'directionAddEvent') 
    {
        include('src/Controller/'.$_GET['folder'].'/'.$_GET['file'].'.php');
        directionAddEvent();
    }
    elseif ($_GET['folder'] == 'EventController' AND $_GET['file'] == 'directionSaveEvent') 
    {
        include('src/Controller/'.$_GET['folder'].'/'.$_GET['file'].'.php');
        directionSaveEvent();
    }
    elseif ($_GET['folder'] == 'EventController' AND $_GET['file'] == 'directionUpdateValidateEvent') 
    {
        include('src/Controller/'.$_GET['folder'].'/'.$_GET['file'].'.php');
        directionUpdateValidateEvent();
    }
    elseif ($_GET['folder'] == 'MonthController' AND $_GET['file'] == 'directionDisplayWeek') 
    {
        include('src/Controller/'.$_GET['folder'].'/'.$_GET['file'].'.php');
        directionDisplayWeek();
    }
    elseif ($_GET['folder'] == 'TaskController' AND $_GET['file'] == 'directionAddTask') 
    {
        include('src/Controller/'.$_GET['folder'].'/'.$_GET['file'].'.php');
        directionAddTask();
    }
    elseif ($_GET['folder'] == 'TaskController' AND $_GET['file'] == 'directionSaveTask') 
    {
        include('src/Controller/'.$_GET['folder'].'/'.$_GET['file'].'.php');
        directionSaveTask();
    }
    elseif ($_GET['folder'] == 'TaskController' AND $_GET['file'] == 'directionEditTask') 
    {
        include('src/Controller/'.$_GET['folder'].'/'.$_GET['file'].'.php');
        directionEditTask();
    }
    elseif ($_GET['folder'] == 'TaskController' AND $_GET['file'] == 'directionUpdateValidateTask') 
    {
        include('src/Controller/'.$_GET['folder'].'/'.$_GET['file'].'.php');
        directionUpdateValidateTask();
    }
    elseif ($_GET['folder'] == 'ObjectiveController' AND $_GET['file'] == 'directionDisplayObjective') 
    {
        include('src/Controller/'.$_GET['folder'].'/'.$_GET['file'].'.php');
        directionDisplayObjective();
    }
    elseif ($_GET['folder'] == 'ObjectiveController' AND $_GET['file'] == 'directionAddObjective') 
    {
        include('src/Controller/'.$_GET['folder'].'/'.$_GET['file'].'.php');
        directionAddObjective();
    } 
    elseif ($_GET['folder'] == 'ObjectiveController' AND $_GET['file'] == 'directionSaveObjective') 
    {
        include('src/Controller/'.$_GET['folder'].'/'.$_GET['file'].'.php');
        directionSaveObjective();
    }
    elseif ($_GET['folder'] == 'ObjectiveController' AND $_GET['file'] == 'directionEditObjective') 
    {
        include('src/Controller/'.$_GET['folder'].'/'.$_GET['file'].'.php');
        directionEditObjective();
    }
    elseif ($_GET['folder'] == 'ObjectiveController' AND $_GET['file'] == 'directionUpdateValidateObjective') 
    {
        include('src/Controller/'.$_GET['folder'].'/'.$_GET['file'].'.php');
        directionUpdateValidateObjective();
    }
    elseif ($_GET['folder'] == 'ObjectiveController' AND $_GET['file'] == 'directionDeleteObjective') 
    {
        include('src/Controller/'.$_GET['folder'].'/'.$_GET['file'].'.php');
        directionDeleteObjective();
    } 
}
else
{
    include('src/Controller/MonthController/directionDisplayYear.php');
    directionDisplayYear();
}