<?php

    define('HOST', 'localhost');
    define('DATABASENAME', 'crud-mvc-php-ajax');
    define('USER', 'root');
    define('PASSWORD', '');

    class Connect {
        protected $connection;

        function __construct()
        {
            $this->connectDatabase();
        }

        function connectDatabase()
        {
            try {
                $this->connection = new PDO('mysql:host='.HOST.';dbname='.DATABASENAME, USER, PASSWORD);
            } 
            catch (PDOException $error) {
                echo "Erro".$error->getMessage();
                die();
            }
        }
    }

?>