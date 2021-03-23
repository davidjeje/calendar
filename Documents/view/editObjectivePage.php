<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un objectif</title>
    <link rel="stylesheet" href="public/CSS/bootstrap.min.css">
    <link rel="stylesheet" href="public/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="public/CSS/templatemo-style.css">
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
                        <a class="nav-link nav-link-3" href="index.php?folder=TaskController&amp;file=directionAddTask">Ajouter une tâche au planning</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-4" href="index.php?folder=ObjectiveController&amp;file=directionDisplayObjective">Objectif</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-3" href="index.php?folder=ObjectiveController&amp;file=directionAddObjective">Ajouter un objectif</a>
                    </li>
                </ul>
            </div>
        </div> 
    </nav>
 
    <div class="container-fluid tm-container-content tm-mt-60">

        <h1>Modifier ou supprimer cet objectif </h1>
        <form action="index.php?folder=ObjectiveController&amp;file=directionUpdateValidateObjective" method="POST" class="form">
            <div class="row">
                <div class="col-6">
                    <label for="name">Titre</label>
                    <input type="hidden" id="idObjective" name="idObjective" value="<?=$oneObjective->id()?>">
                    <input type="text" class="form-control" placeholder="Titre" id="name" name="name" value="<?=$oneObjective->name()?>" required>
                </div>
                <div class="col-6">
                    <label for="family">famille</label>
                    <input type="text" class="form-control" placeholder="famille" id="family" name="family" value="<?=$oneObjective->family()?>" required>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label for="description">Description</label>
                    <textarea class="form-control" placeholder="Description" id="description" name="description" value="<?=$oneObjective->description()?>" required><?=$oneObjective->description()?></textarea>
                </div> 
            </div>
            <br>
            <div class="row">
                <div class="col-auto mr-auto">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                        Modifier cet objectif
                    </button> 
                </div> 
                
                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Modification d'un objectif</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div> 
                            <div class="modal-body">
                                <p>Vous êtes sur le point de modifier cet objectif.</p>
                                <p>Êtes-vous sur de vouloir faire cette action ?</p>
                            </div> 
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                <input type="submit" value="Modifier" class="btn btn-primary" name="Modifier" data-toggle="modal" data-target="#exampleModal">
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
        </form>                 
    </div> 
    <br>
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