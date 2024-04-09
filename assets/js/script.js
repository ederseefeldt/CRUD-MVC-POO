$(document).ready(function() {
    var table;

    getUsers();

    // Função para obter os usuários e preencher a tabela
    function getUsers() {
        if ($.fn.DataTable.isDataTable('#userTable')) {
            table.destroy(); // Destruir a tabela DataTable existente
        }

        table = $('#userTable').DataTable({
            columns: [
                { data: 'userID' },
                { data: 'userName' },
                { data: 'userEmail' },
                {
                    data: null,
                    render: function(data, type, row) {
                        return '<button class="editBtn" id="editBtn" value="' + data.userID + '">Editar</button>' +
                            '<button class="deleteBtn" id="deleteBtn" value="' + data.userID + '">Excluir</button>';
                    }
                }
            ]
        });

        $.ajax({
            type: 'GET',
            url: '../controller/userController.php?action=getConta',
            dataType: 'json',
            success: function(response) {
                // Limpar dados existentes na tabela
                console.log(response)
                table.clear();
                // Adicionar novos dados à tabela
                table.rows.add(response);
                // Redesenhar a tabela com os novos dados
                table.draw();
            },
            error: function(xhr, status, error) {
                console.error('Ocorreu um erro na solicitação AJAX:', xhr.status);
            }
        });

    }

    // Função para adicionar um usuário
    $('#addUserForm').submit(function addUser(event) {
        event.preventDefault(); // Impede o envio do formulário padrão

        var formData = $(this).serialize(); // Obtém os dados do formulário

        $.ajax({
            type: 'POST',
            url: '../controller/userController.php?action=addUser', // Rota para o método addUser no controller
            data: formData,
            dataType: 'json',
            success: function(response) {
                getUsers();
                $('#addUserModal').modal('hide');
                $('#userName').val('');   
                $('#userEmail').val('');
            },
            error: function(xhr, status, error) {
                // Lógica para lidar com erros
                console.error('Erro ao adicionar usuário:', error);
            }
        });
    });

    $('#editUserForm').submit(function editUser(event) {
        event.preventDefault(); // Impede o envio do formulário padrão
    
        var formEditData = $(this).serialize(); // Obtém os dados do formulário
        console.log(formEditData); // Verificar se os dados do formulário estão sendo capturados corretamente
    
        $.ajax({
            type: 'POST',
            url: '../controller/userController.php?action=editUser', // Rota para o método editUser no controller
            data: formEditData,
            dataType: 'json',
            success: function(response) {
                getUsers();
                $('#editUserModal').modal('hide');
            },
            error: function(xhr, status, error) {
                // Lógica para lidar com erros
                console.error('Erro ao editar usuário:', error);
            }
        });
    });

    $(document).on('click', '#deleteBtn', function deleteUser() {
        var userID = $(this).val();
  
        // Fazer requisição AJAX para obter os detalhes do usuário com o ID fornecido
        $.ajax({
            type: 'GET',
            url: '../controller/userController.php?action=deleteUser',
            data: { userId: userID }, // Use userId como chave para o parâmetro
            dataType: 'json',
            success: function(response) {
                console.log(`Usuário excluido ${response.userID}`)
                getUsers()
            },
            error: function(xhr, status, error) {
                console.error('Erro ao obter detalhes do usuário:', error);
            }
        });
    });
    

    $(document).on('click', '#editBtn', function getUserDetails() {
        var userID = $(this).val();
  
        // Fazer requisição AJAX para obter os detalhes do usuário com o ID fornecido
        $.ajax({
            type: 'GET',
            url: '../controller/userController.php?action=getUserDetails',
            data: { userId: userID }, // Use userId como chave para o parâmetro
            dataType: 'json',
            success: function(response) {
                // Preencher o formulário de edição com os detalhes do usuário
                $('#editUserId').val(response.userID);
                $('#editUserName').val(response.userName);
                $('#editUserEmail').val(response.userEmail);
                //console.log(response.userName);
                // Abrir o modal de edição
                $('#editUserModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error('Erro ao obter detalhes do usuário:', error);
            }
        });
    });
    
    
    
});
