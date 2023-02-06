<?php 

require_once("../models/accountModel.php");

require_once("../conf/conf.php");

// Ce controller nous servira à créer de nouveaux comptes, à nous connecter, et à vérifier la connexion quand on navigue dans la partie admin du site
class AccountController {

    public function create(string $email, string $password) {

        // Vérification de l'email
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return [
                "success" => false,
                "message" => "Email incorrect"
            ];
        }

        // Vérification de la longueur du mot de passe
        if(strlen($password) < 8) {
            return [
                "success" => false,
                "message" => "Mot de passe trop court"
            ];
        }

        // Vérification de la force du mot de passe
        if(!preg_match("~^\S*(?=\S*[a-zA-Z])(?=\S*[0-9])(?=\S*[\W])\S*$~", $password)) {
            return [
                "success" => false,
                "message" => "Le mot de passe doit contenir au moins une lettre, un chiffre, et un caractère spécial"
            ];
        }

        // Si nous sommes arrivés jusque là, c'est que notre nouvel account est correct : insérons-le dans la base de données !

        global $pdo;

        $sql = "INSERT INTO account
            (email, password)
            VALUES
            (:email, :password)
        ";

        $statement = $pdo->prepare($sql);

        // Hachage du mot de passe avant son insertion dans la base de données
        $password = password_hash($password, PASSWORD_DEFAULT);

        $statement->bindParam(":email", $email);
        $statement->bindParam(":password", $password);

        $statement->execute();

        // Renvoi d'un tableau associatif permettant de connaître le succès (ou non) de la méthode
        return [
            "success" => true,
            "message" => "Compte utilisateur créé"
        ];
    }
}