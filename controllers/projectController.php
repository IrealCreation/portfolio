<?php 

require_once("./conf/conf.php");

require_once("./models/projectModel.php");

class ProjectController {

    public function readAll(): array {
        global $pdo;

        $sql = "SELECT * FROM project";

        $statement = $pdo->prepare($sql);
        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_CLASS, "ProjectModel");

        return $result;
    }
}

?>