<?php 

session_start();
define("PAGE_TITLE", "Connexion");

require_once("../controllers/accountController.php");

$controller = new AccountController;

// Les deux lignes suivantes permettent d'ajouter un nouvel administrateur
// $result = $controller->create("richard.legrand@novei.fr", "Patate78!");
// var_dump($result);

?>
<?php include("../assets/inc/head.php"); ?>

<?php include("../assets/inc/header.php"); ?>

<main>
    <!-- TODO: formulaire de connexion -->
</main>

<?php include("../assets/inc/footer.php"); ?>