<?php 

session_start();
define("PAGE_TITLE", "Connexion");

require_once("../controllers/accountController.php");

$controller = new AccountController;

if(isset($_POST["submit"]) && isset($_POST["email"]) && isset($_POST["password"])) {
    // Le formulaire a été envoyé, essayons de nous connecter
    $error = $controller->login($_POST["email"], $_POST["password"]);
}

// Les deux lignes suivantes permettent d'ajouter un nouvel administrateur
// $result = $controller->create("richard.legrand@novei.fr", "Patate78!");
// var_dump($result);

?>
<?php include("../assets/inc/head.php"); ?>

<?php include("../assets/inc/header.php"); ?>

<main class="container-fluid">
    <h1>Connexion à l'espace administrateur</h1>
    <?php if(isset($error)) { ?>
        <div class="alert alert-danger">
            <?= $error["message"] ?>
        </div>
    <?php } ?>
    <form action="#" method="POST" class="m-4">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Se connecter</button>
    </form>
</main>

<?php include("../assets/inc/footer.php"); ?>