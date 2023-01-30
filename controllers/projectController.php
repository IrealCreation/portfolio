<?php 

require_once("./conf/conf.php");

require_once("./models/projectModel.php");
require_once("./models/pictureModel.php");

class ProjectController {

    public function readAll(): array {
        global $pdo;

        $sql = "SELECT * FROM project";

        $statement = $pdo->prepare($sql);
        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_CLASS, "ProjectModel");

        return $result;
    }

    public function readOne($id): ProjectModel {
        global $pdo;

        // Requête de récupération du projet
        $sql = "SELECT * FROM project WHERE id_project = :id";

        $statement = $pdo->prepare($sql);
        $statement->bindParam(":id", $id);
        $statement->execute();

        $statement->setFetchMode(PDO::FETCH_CLASS, "ProjectModel");
        $result = $statement->fetch();

        // Requête de récupération des images
        $sql = "SELECT * FROM picture WHERE id_project = :id";

        $statement = $pdo->prepare($sql);
        $statement->bindParam(":id", $id);
        $statement->execute();

        $result->pictures = $statement->fetchAll(PDO::FETCH_CLASS, "PictureModel");

        return $result;
    }
}

?>