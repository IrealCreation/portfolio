<?php 

session_start();

define("PAGE_TITLE", "Ajout d'un projet");

require_once("../controllers/accountController.php");
require_once("../controllers/skillController.php");
require_once("../controllers/projectController.php");

$accountController = new AccountController;

// Permet de vérifier que l'utilisateur soit connecté
$accountController->isLogged();

$skillController = new SkillController;
// Récupération de toutes les compétences
$skills = $skillController->readAll();

if(isset($_POST["submit"])) {
    // Envoi des informations du formulaire pour créer un nouveau projet
    $projectController = new ProjectController;
    $result = $projectController->create($_POST["name"], $_POST["description"], $_POST["date_start"], $_POST["date_end"], $_POST["link_site"], $_POST["link_git"], $_FILES["cover"], $_POST["skills"]);
}


?>
<?php include("../assets/inc/head.php"); ?>

<?php include("../assets/inc/header.php"); ?>

<main class="container-fluid">
    <h1>Ajout d'un nouveau projet</h1>
    <?php
        if(isset($result)) {
            if($result["success"]) { ?>
                <div class="alert alert-success"><?= $result["message"] ?></div>
            <?php }
            else { ?>
                <div class="alert alert-danger"><?= $result["message"] ?></div>
            <?php }
        }
    ?>
    <form action="#" method="POST" class="m-4" enctype="multipart/form-data">
        <label for="name">Nom</label>
        <input type="text" name="name" id="name" class="form-control" required>

        <label for="description">Description</label>
        <textarea name="description" id="description" class="form-control" required></textarea>

        <label for="date_start">Date de début</label>
        <input type="date" name="date_start" id="date_start" class="form-control" required>

        <label for="date_end">Date de fin</label>
        <input type="date" name="date_end" id="date_end" class="form-control">

        <label for="cover">Image de couverture</label>
        <input class="form-control" type="file" name="cover" id="cover" accept="image/png, image/jpeg, image/webp" class="form-control" required>

        <label for="link_site">Lien du site</label>
        <input type="url" name="link_site" id="link_site" class="form-control">

        <label for="link_git">Lien Git</label>
        <input type="url" name="link_git" id="link_git" class="form-control">

        <label for="skills">Compétences</label>
        <select name="skills[]" id="skills" class="form-control" multiple>
            <?php foreach($skills as $skill) { ?>
                <option value="<?= $skill->id_skill ?>"><?= $skill->name ?></option>
            <?php } ?>
        </select>

        <button type="submit" name="submit" class="btn btn-success mt-2">Envoyer</button>
    </form>
</main>

<?php include("../assets/inc/footer.php"); ?>