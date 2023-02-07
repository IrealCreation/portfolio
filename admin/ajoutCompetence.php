<?php 

session_start();

define("PAGE_TITLE", "Ajout d'une compétence");

require_once("../controllers/skillController.php");
require_once("../controllers/accountController.php");

$accountController = new AccountController;

// Permet de vérifier que l'utilisateur soit connecté
$accountController->isLogged();

$skillController = new SkillController;

if(isset($_POST["submit"])) {
    $error = $skillController->create($_POST["name"], $_POST["level"], $_FILES["picture"]);
}


?>
<?php include("../assets/inc/head.php"); ?>

<?php include("../assets/inc/header.php"); ?>

<main class="container-fluid">

    <h1>Ajout d'une compétence</h1>
    <?php
        if(isset($error)) {
            if($error["success"]) { ?>
                <div class="alert alert-success"><?= $error["message"] ?></div>
            <?php }
            else { ?>
                <div class="alert alert-danger"><?= $error["message"] ?></div>
            <?php }
        }
    ?>
    <form action="#" method="POST" enctype="multipart/form-data" class="m-4">
        <label for="name">Nom de la compétence</label>
        <input class="form-control" type="text" name="name" id="name" required>

        <label for="level">Niveau de la compétence</label>
        <input class="form-control" type="number" min="1" max="10" name="level" id="level" required>

        <label for="picture">Image de la compétence</label>
        <input class="form-control" type="file" name="picture" id="picture" accept="image/png, image/jpeg, image/webp" required>

        <button type="submit" name="submit" class="btn btn-success mt-2">Envoyer</button>
    </form>
</main>

<?php include("../assets/inc/footer.php"); ?>