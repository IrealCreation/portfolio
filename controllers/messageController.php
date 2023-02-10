<?php 

require_once(__DIR__ . "/../conf/conf.php");

require_once(__DIR__ . "/../models/messageModel.php");



class MessageController {

    public function create(string $firstname, string $lastname, string $company, string $object, string $content, string $email, string $phone) {

        // Vérification des données
        if(strlen($firstname) > 50) {
            return [
                "success" => false,
                "message" => "Le prénom doit contenir 50 caractères maximum"
            ];
        }

        if(strlen($lastname) > 50) {
            return [
                "success" => false,
                "message" => "Le nom de famille doit contenir 50 caractères maximum"
            ];
        }

        if(strlen($company) > 50) {
            return [
                "success" => false,
                "message" => "Le nom de l'entreprise doit contenir 50 caractères maximum"
            ];
        }

        if(strlen($object) > 255) {
            return [
                "success" => false,
                "message" => "Le sujet du message doit contenir 255 caractères maximum"
            ];
        }

        if(strlen($email) > 255) {
            return [
                "success" => false,
                "message" => "L'adresse email doit contenir 255 caractères maximum"
            ];
        }

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return [
                "success" => false,
                "message" => "L'adresse email est incorrecte"
            ];
        }

        if($phone != "" && !preg_match("~^(0[1-7][0-9]{8})$~", $phone)) {
            return [
                "success" => false,
                "message" => "Le numéro de téléphone est incorrect (exemple correct : 0123456789)"
            ];
        }

        // Insertion du message dans la base de données
        global $pdo;

        $sql = "INSERT INTO message (firstname, lastname, company, object, content, email, phone)
        VALUES (:firstname, :lastname, :company, :object, :content, :email, :phone)";

        $statement = $pdo->prepare($sql);

        $statement->bindParam(":firstname", $firstname);
        $statement->bindParam(":lastname", $lastname);

        $company = ($company == "" ? null : $company);
        $statement->bindParam(":company", $company);
        
        $statement->bindParam(":object", $object);
        $statement->bindParam(":content", $content);
        $statement->bindParam(":email", $email);

        $phone = ($phone == "" ? null : $phone);
        $statement->bindParam(":phone", $phone);

        $statement->execute();

        return [
            "success" => true,
            "message" => "Votre message a bien été envoyé, merci de votre intérêt"
        ];
    }

    public function readAll() {

    }
}

?>