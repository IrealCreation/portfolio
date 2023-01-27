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

<main>
    <h1>Liste des projets</h1>
    <?php var_dump($projects); ?>
</main>

<?php include("./assets/inc/footer.php"); ?>