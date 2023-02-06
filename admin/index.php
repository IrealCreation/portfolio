<?php 

session_start();
define("PAGE_TITLE", "Accueil admin");

require_once("../controllers/accountController.php");

$accountController = new AccountController;

// Permet de vérifier que l'utilisateur soit connecté
$accountController->isLogged();

?>
<?php include("../assets/inc/head.php"); ?>

<?php include("../assets/inc/header.php"); ?>

<main class="container-fluid">
    <h1>Espace administrateur</h1>
    <p>Votre email : <?= $_SESSION["email"] ?></p>
    <div class="d-flex justify-content-around mb-3">
        <a href="/admin/ajoutCompetence.php" class="btn btn-success">Ajouter une compétence</a>
        <a href="/admin/ajoutProjet.php" class="btn btn-success">Ajouter un projet</a>
    </div>
</main>

<?php include("../assets/inc/footer.php"); ?>