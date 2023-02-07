<?php 

require_once(__DIR__ . "/../conf/conf.php");

require_once(__DIR__ . "/../models/skillModel.php");

class SkillController {
    // TODO: créer les méthodes permettant des récupérer les skills (readAll()...)

    public function create(string $name, int $level, array $picture) {

        // Validation des informations du formulaire

        if(strlen($name) > 255) {
            return [
                "success" => false,
                "message" => "Le nom doit contenir 255 caractères maximum"
            ];
        }

        if($level < 1 || $level > 10) {
            return [
                "success" => false,
                "message" => "Le niveau doit être compris entre 1 et 10"
            ];
        }

        if(!in_array($picture["type"], ["image/png", "image/jpeg", "image/webp"])) {
            return [
                "success" => false,
                "message" => "Formats d'image acceptés : PNG, JPEG, WebP"
            ];
        }

        // Les informations sont correctes : stockons l'image en lui attribuant un nouveau nom unique
        $image_name = time() . $picture["name"];
        move_uploaded_file($picture["tmp_name"], __DIR__ . "/../assets/img/skills/" . $image_name);
        // var_dump($picture);

        // L'image a bien été stockée, exécutons la requête pour ajouter la compétence
        global $pdo;

        $sql = "INSERT INTO skill (name, level, picture)
            VALUES (:name, :level, :picture)
        ";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(":name", $name);
        $statement->bindParam(":level", $level);
        $statement->bindParam(":picture", $image_name);

        $statement->execute();

        return [
            "success" => true,
            "message" => "Compétence ajoutée !"
        ];
    }
}

?>