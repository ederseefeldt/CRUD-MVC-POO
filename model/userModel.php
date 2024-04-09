<?php

    require_once('../settings/dbConnect.php');

    class userModel extends Connect {
        private $table;

        function __construct() {
            parent::__construct();
            $this -> table = "user";
        }

        function getUsers() {
            $sql = $this->connection->query("SELECT * FROM $this->table");
            $resultQuery = $sql->fetchAll();

            return $resultQuery;
        }

        function addUser($name, $email) {
            $sql = "INSERT INTO $this->table (userName, userEmail) VALUES (:name, :email)";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
        
            if ($stmt->execute()) {
                // Inserção bem-sucedida, retorna os dados inseridos
                return array(
                    'userName' => $name,
                    'userEmail' => $email
                );
            } else {
                // Erro na inserção, retorna null e imprime o erro
                $errorInfo = $stmt->errorInfo();
                echo "Erro na inserção: " . $errorInfo[2];
                return null;
            }
        }

        function editUser($id, $name, $email) {
            $sql = "UPDATE $this->table SET userName=:name, userEmail=:email WHERE userID = :id";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            
            if ($stmt->execute()) {
                // Inserção bem-sucedida, retorna os dados inseridos
                return array(
                    'userName' => $name,
                    'userEmail' => $email
                );
            } else {
                // Erro na inserção, retorna null e imprime o erro
                $errorInfo = $stmt->errorInfo();
                echo "Erro na atualização: " . $errorInfo[2];
                return null;
            }
        }

        function deleteUser($id) {
            $sql = "DELETE FROM $this->table WHERE userID = :id";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':id', $id);
            
            if ($stmt->execute()) {
                // Inserção bem-sucedida, retorna os dados inseridos
                return array(
                    'userID' => $id,
                );
            } else {
                // Erro na inserção, retorna null e imprime o erro
                $errorInfo = $stmt->errorInfo();
                echo "Erro na atualização: " . $errorInfo[2];
                return null;
            }
        }
        
        

        function getUserDetails($userId) {
            $sql = $this->connection->query("SELECT * FROM $this->table WHERE userID = $userId");
            $resultQuery = $sql->fetch();

            return $resultQuery;
        }
    
        
    }

?>