<?php 

// Commencer par l'appel du controller
require("./controllers/projectController.php");

// Instanciation de notre controller
$controller = new ProjectController;

// Appel de la méthode permettant de récupérer tous les projets
$projects = $controller->readAll();

// Définition de la constante du titre de la page, que nous utilisons dans le head
define("PAGE_TITLE", "Projets");

?>
<?php include("./assets/inc/head.php"); ?>

<?php include("./assets/inc/header.php"); ?>

<main class="container-fluid mt-4 mb-4">
    <h1>Liste des projets</h1>
    <div class="row">
        <?php foreach($projects as $project) { ?>
            <div class="col-sm-6 col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">
                            <a href="/projetDetail.php?id=<?= $project->id_project; ?>">
                                <?= $project->name ?>
                            </a>
                        </h5>
                    </div>
                    <img src="/assets/img/projects/<?= $project->cover ?>" alt="Couverture de <?= $project->name ?>">
                    <div class="card-body">
                        <p>
                            <?= $project->description ?>
                        </p>
                        <div class="flex">
                            <?php if(isset($project->link_site)) { ?>
                                <a href="<?= $project->link_site ?>" class="btn btn-primary">Voir le site</a>
                            <?php } ?>
                            <?php if(isset($project->link_git)) { ?>
                                <a href="<?= $project->link_git ?>" class="btn btn-primary">Voir Git</a>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="card-footer">
                        Date : 
                        <?= $project->displayDateStart() ?>
                        <?php if(isset($projet->date_end)) { ?>
                            <?= $project->displayDateEnd() ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
        <?php } ?>
        
    </div>
</main>

<?php include("./assets/inc/footer.php"); ?>