<?php 

// Commencer par l'appel du controller
require("./controllers/skillController.php");

// Instanciation de notre controller
$controller = new SkillController;

// TODO: récupérer les compétences
// $skills = $controller->...

// Définition de la constante du titre de la page, que nous utilisons dans le head
define("PAGE_TITLE", "Compétences");

?>
<?php include("./assets/inc/head.php"); ?>

<?php include("./assets/inc/header.php"); ?>

<main>
    <!-- TODO: afficher les compétences grâce à une boucle -->
</main>

<?php include("./assets/inc/footer.php"); ?>