<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Le mois</title>
    <link rel="stylesheet" href="public/CSS/bootstrap.min.css">
    <link rel="stylesheet" href="public/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="public/CSS/templatemo-style.css">
    <link rel="stylesheet" href="public/CSS/calendar.css">
</head>
<body>
    <!-- Page Loader -->
    <div id="loader-wrapper">
        <div id="loader"></div>

        <div class="loader-section section-left"></div>
        <div class="loader-section section-right"></div>

    </div>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <div class="navbar-brand mb-2 disabled"  >
                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-calendar-check" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                <path fill-rule="evenodd" d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                </svg>
                Calendrier
            </div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link nav-link-1 active" aria-current="page" href="index.php?folder=MonthController&amp;file=directionDisplayYear">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-2" href="index.php?folder=MonthController&amp;file=directionDisplayWeek">Planning</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-3" href="index.php?folder=ObjectiveController&amp;file=directionDisplayObjective">Objectif</a>
                </li>
            </ul>
            </div>
        </div>
    </nav>
 
    <div class="container-fluid tm-container-content tm-mt-60">
        <div class="row mb-4">
            <h2 class="col-6 tm-text-primary"> 
                 <?= $letterMonth ?>
            </h2>
            <div class="col-6 d-flex justify-content-end align-items-center">
                <form action="" class="tm-text-primary">
                    <a href="index.php?folder=MonthController&amp;file=directionDisplayMonth&amp;idMonth=<?=previousMonth()?>&amp;year=<?=previousMonth2()?>" class="btn btn-primary">&lt;</a>
                    <a href="index.php?folder=MonthController&amp;file=directionDisplayMonth&amp;idMonth=<?=nextMonth()?>&amp;year=<?=nextMonth2()?>" class="btn btn-primary">&gt;</a>
                </form>
            </div>
        </div> 
        <div class="row tm-mb-90 tm-gallery">
            <table class ="calendar__table calendar__table--<?= weeksNumber($idMonth, $year) ?>weeks">

                <?php for($i = 0; $i < weeksNumber($idMonth, $year); $i++)
                { ?>
                    <tr>
                        <?php 
                        foreach($weekDay as $k => $letterDay) 
                        {        
                            $date = $cloneFirstMonday->modify("+ 1 day");
                            //$eventForDay = $eventBetweenByDay[$date->format('Y-m-d')] == true ? $eventBetweenByDay[$date->format('Y-m-d')] : [];

                            //$cloneFirstMonday = $cloneStart2->format('N') == '1' ? $cloneStart2 : $firstMonday;
        
                            if(withInMonth($date) === true)
                            {
                            ?>
                                <td>
                                    <?php 
                                    if($i === 0)
                                    {
                                    ?>
                                        <div class ="calendar__weekday">  <?= $letterDay ?>  </div>
                                    <?php
                                    } 
                                    ?>
                                    <br>
                                    <div class ="calendar__day"> <?= $date->format('d'); ?> </div>
                                    <?php
                                    foreach ($allEvents as $allEvent)
                                    {
                                        /*$dateEvent = explode(' ', $allEvent->start())[0];
                                        $hourEvent = explode(' ', $allEvent->start())[1];
                                        $hour = DateTime::createFromFormat(' H:i', $hourEvent);*/
                                        $dateEvent = new \dateTime($allEvent->start());
                                        $time = new \dateTime($allEvent->start());
                       
                                        /*var_dump($date->format('Y-m-d'));
                                        die();*/
                                        if($date->format('Y-m-d') == $dateEvent->format('Y-m-d'))
                                        {      
                                    ?>
                                            <div class ="calendar__event"><?= $time->format('H:i') ?>: <a href="index.php?folder=EventController&amp;file=directionEditEvent&amp;idEvent=<?=$allEvent->id()?>"> <?=$allEvent->name(); ?></a> </div>
                                    <?php
                                        }
                                    }
                                    ?>
                                </td>
                            <?php
                            }   
                            else
                            {
                            ?>                 
                                <td class="calendar__othermonth">
                                    <?php 
                                    if($i === 0)
                                    {
                                    ?>
                                        <div class ="calendar__weekday">  <?= $letterDay ?>  </div>
                                    <?php
                                    } 
                                    ?>
                                    <br>
                                    <div class ="calendar__day"> <?= $date->format('d'); ?> </div>
                                    <?php
                
                                    foreach ($allEvents as $allEvent)
                                    {
                                        $dateEvent = explode(' ', $allEvent->start())[0];
                                        $hourEvent = explode(' ', $allEvent->start())[1];
                                        $hour = DateTime::createFromFormat(' H:i', $hourEvent);

                                        if($date->format('Y-m-d') == $dateEvent)
                                        {      
                                        ?>
                                            <div class ="calendar__event"><?= $hourEvent ?> : <a href="index.php?folder=EventController&amp;file=directionEditEvent&amp;idEvent=<?=$allEvent->id()?>"> <?= $allEvent->name(); ?></a> </div>
                                        <?php
                                        }
                                    }
                                    ?>
                                </td>
                            <?php
                            }
                        }
                        ?>
                    </tr>
                <?php
                }  
                ?>
            </table>
        </div> <!-- row -->
        <div class="row tm-mb-90">
            <div class="col-12 d-flex justify-content-between align-items-center tm-paging-col">
                <a href="index.php?folder=MonthController&amp;file=directionDisplayMonth&amp;idMonth=<?=previousMonth()?>&amp;year=<?=previousMonth2()?>" class="btn btn-primary">&lt;</a>
                <a href="index.php?folder=MonthController&amp;file=directionDisplayMonth&amp;idMonth=<?=nextMonth()?>&amp;year=<?=nextMonth2()?>" class="btn btn-primary">&gt;</a>
            </div>            
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-auto mr-auto">
                </div>
                <div class="col-auto">
                    <a class="calendar__button" href="index.php?folder=EventController&amp;file=directionAddEvent" ><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-calendar-event" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                    <path d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
                    </svg></a>
                </div>
            </div>
        </div>
    </div> <!-- container-fluid, tm-container-content -->

    <!-- footer -->
    <?php include("footer.php"); ?>
    
    <script src="js/plugins.js"></script>
    <script>
        $(window).on("load", function() {
            $('body').addClass('loaded');
        });
    </script>
</body>
</html>