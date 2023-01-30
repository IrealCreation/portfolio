<?php 

// Commencer par l'appel du controller
require("./controllers/projectController.php");

// Instanciation de notre controller
$controller = new ProjectController;

$project = $controller->readOne($_GET["id"]);

// Définition de la constante du titre de la page, que nous utilisons dans le head
define("PAGE_TITLE", "Accueil");

?>
<?php include("./assets/inc/head.php"); ?>

<?php include("./assets/inc/header.php"); ?>

<main>
    <?php var_dump($project); ?>

    <div id="carouselExample" class="carousel slide">
        <div class="carousel-inner">
            <?php foreach($project->pictures as $key => $picture) { ?>

            <div class="carousel-item <?= ($key == 0 ? 'active' : '') ?>">
                <img src="/assets/img/projects/<?= $picture->path ?>" class="d-block w-100" alt="<?= $picture->alt ?>">
                <div class="carousel-caption d-none d-md-block">
                    <p><?= $picture->caption ?></p>
                </div>
            </div>

            <?php } ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
        </div>
</main>

<?php include("./assets/inc/footer.php"); ?>