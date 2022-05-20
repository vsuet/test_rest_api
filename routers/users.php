<?php
function route($method, $urlData, $formData)
{
    $db = new PDO("mysql:host=mysql60.hostland.ru;port=3306;dbname=host1323541_vsuet00", "host1323541_vsuet", "dL4JXRjJ");

    switch ($method) {
        case 'GET':
            getUsers($urlData, $db);
            break;
        case 'POST':
            createUser($db, $formData);
            break;
        case 'PUT':
            // обновление пользователя
            break;
        case 'DELETE':
            // удаление пользователя
            break;
        default:
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(array(
                'error' => 'Bad Request'
            ));
            break;
    }
}

function getUsers($urlData, $db)
{
    if (count($urlData) === 1) {
        $userId = $urlData[0];
        getUserById($db, $userId);
    } else {
        getAllUsers($db);
    }
}

function getUserById($db, $id)
{
    $sql = "SELECT tab_users.id AS 'id', name, role FROM tab_users JOIN tab_roles ON tab_users.role_id = tab_roles.id WHERE tab_users.id = " . $id;
    $result = $db->query($sql);
    $row = $result->fetch();

    echo json_encode(array("id" => $row['id'], "name" => $row['name'], "role" => $row['role']));
}

function getAllUsers($db)
{
    $sql = "SELECT tab_users.id AS 'id', name, role FROM tab_users JOIN tab_roles ON tab_users.role_id = tab_roles.id";
    $result = $db->query($sql);

    $res = array();
    while ($row = $result->fetch()) {
        $res[] = array("id" => $row['id'], "name" => $row['name'], "role" => $row['role']);
    }

    echo json_encode($res);
}

function createUser($db, $formData)
{
    $name = $formData["name"];
    $password = $formData["password"];
    $role_id = (int)$formData["role_id"];

    $sql = "INSERT INTO tab_users (name, password, role_id) VALUES ('$name', '$password', $role_id)";
    $result = $db->exec($sql);

    if ($result > 0) {
        echo json_encode(array(
            'success' => 'OK'
        ));
    } else {
        echo json_encode(array(
            'error' => 'Bad'
        ));
    }

    /*var_dump($formData);
    echo $sql;*/
}