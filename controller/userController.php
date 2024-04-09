<?php

require_once('../model/userModel.php');

class userController {
    private $model;

    function __construct() {
        $this->model = new UserModel();
    }

    public function getUsers() {
        $users = $this->model->getUsers();
        echo json_encode($users);
    }

    public function addUser() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['userName'];
            $email = $_POST['userEmail'];
            
            // Chama a função addUser no modelo
            $user = $this->model->addUser($name, $email);
    
            // Retorna a resposta como JSON
            echo json_encode($user);
        } else {
            echo json_encode(array('error' => 'Método de requisição inválido'));
        }
    }

    public function editUser() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['editUserID'];
            $name = $_POST['editUserName'];
            $email = $_POST['editUserEmail'];
            
            // Chama a função addUser no modelo
            $user = $this->model->editUser($id, $name, $email);
    
            // Retorna a resposta como JSON
            echo json_encode($user);
        } else {
            echo json_encode(array('error' => 'Método de requisição inválido'));
        }
    }

    function deleteUser() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['userId'])) {
            $userId = $_GET['userId'];
            // Chamar a função do modelo para obter os detalhes do usuário com base no ID
            $userDelete = $this->model->deleteUser($userId);
            echo json_encode($userDelete);
        } else {
            echo json_encode(array('error' => 'Método de requisição inválido ou ID de usuário não fornecido'));
        }
    }

    function getUserDetails() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['userId'])) {
            $userId = $_GET['userId'];
            // Chamar a função do modelo para obter os detalhes do usuário com base no ID
            $userDetails = $this->model->getUserDetails($userId);
            echo json_encode($userDetails);
        } else {
            echo json_encode(array('error' => 'Método de requisição inválido ou ID de usuário não fornecido'));
        }
    }
    

}

// Instanciar o controlador e chamar a função correspondente
$controller = new userController();

if (isset($_GET['action'])) {
    $action = $_GET['action'];
    switch ($action) {
        case 'getUsers':
            $controller->getUsers();
            break;
        case 'addUser':
            $controller->addUser();
            break;
        case 'editUser':
            $controller->editUser();
            break;
        case 'deleteUser':
            $controller->deleteUser();
            break;
        case 'getUserDetails':
            $controller->getUserDetails();
            break;
        // Adicionar casos para outros métodos, se necessário...
        default:
            echo json_encode(array('error' => 'Ação inválida'));
    }
} else {
    echo json_encode(array('error' => 'Nenhuma ação especificada'));
}

?>
