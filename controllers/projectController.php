<?php 

require_once(__DIR__ . "/../conf/conf.php");

require_once(__DIR__ . "/../models/projectModel.php");
require_once(__DIR__ . "/../models/pictureModel.php");
require_once(__DIR__ . "/../models/skillModel.php");

class ProjectController {

    public function create(string $name, string $description, string $date_start, string $date_end, string $link_site, string $link_git, array $cover, array $skills) {

        // Vérifications des informations
        if(strlen($name) > 255) {
            return [
                "success" => false,
                "message" => "Le nom doit contenir 255 caractères maximum"
            ];
        }

        if(strlen($link_site) > 50) {
            return [
                "success" => false,
                "message" => "Le lien du site doit contenir 50 caractères maximum"
            ];
        }

        if(strlen($link_git) > 50) {
            return [
                "success" => false,
                "message" => "Le lien du git doit contenir 50 caractères maximum"
            ];
        }

        if(!in_array($cover["type"], ["image/png", "image/jpeg", "image/webp"])) {
            return [
                "success" => false,
                "message" => "Formats d'image acceptés : PNG, JPEG, WebP"
            ];
        }

        // Les informations sont correctes : stockons l'image de couverture en lui attribuant un nouveau nom unique
        $cover_name = time() . $cover["name"];
        move_uploaded_file($cover["tmp_name"], __DIR__ . "/../assets/img/projects/" . $cover_name);

        // Insérons le nouveau projet dans la base de données
        global $pdo;

        $sql = "INSERT INTO project 
        (name, description, date_start, date_end, link_site, link_git, cover)
        VALUES 
        (:name, :description, :date_start, :date_end, :link_site, :link_git, :cover)";

        $statement = $pdo->prepare($sql);

        $statement->bindParam(":name", $name);
        $statement->bindParam(":description", $description);
        $statement->bindParam(":date_start", $date_start);

        // Si $date_end est vide, donnons-lui la valeur null
        $date_end = ($date_end == '' ? null : $date_end);
        $statement->bindParam(":date_end", $date_end);
        
        $link_site = ($link_site == '' ? null : $link_site);
        $statement->bindParam(":link_site", $link_site);
        
        $link_git = ($link_git == '' ? null : $link_git);
        $statement->bindParam(":link_git", $link_git);

        $statement->bindParam(":cover", $cover_name);

        $statement->execute();

        // Récupérons l'ID du projet que nous venons d'insérer
        $id_project = $pdo->lastInsertId();

        // Insertion des compétences liées à ce projet
        if(count($skills) > 0) {
            foreach($skills as $skill) {
                $sql = "INSERT INTO skill_project
                (id_project, id_skill)
                VALUES
                (:id_project, :id_skill)";

                $statement = $pdo->prepare($sql);

                $statement->bindParam(":id_project", $id_project);
                $statement->bindParam(":id_skill", $skill);

                $statement->execute();
            }
        }

        return [
            "success" => true,
            "message" => "Le projet " . $name . " a été créé"
        ];
    }

    public function readAll(): array {
        global $pdo;

        $sql = "SELECT * FROM project";

        $statement = $pdo->prepare($sql);
        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_CLASS, "ProjectModel");

        foreach($result as $project) {
            $this->loadSkillsFromProject($project);
        }

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

        // Requête de récupération des compétences (skills)
        $this->loadSkillsFromProject($result);

        return $result;
    }

    public function loadSkillsFromProject(ProjectModel $project) {
        global $pdo;

        $sql = "SELECT 
            skill.id_skill, skill.name, skill.level, skill.picture
            FROM skill
            INNER JOIN skill_project ON skill_project.id_skill = skill.id_skill
            INNER JOIN project ON project.id_project = skill_project.id_project
            WHERE project.id_project = :id
        ";

        $statement = $pdo->prepare($sql);
        $statement->bindParam(":id", $project->id_project, PDO::PARAM_INT);
        $statement->execute();

        $project->skills = $statement->fetchAll(PDO::FETCH_CLASS, "SkillModel");
    }
}

?>