<?php
if (isset($_GET['url'])) {
    $api = new API_configuration();
    $api->token = isset($headers['Authorization']) ? $headers['Authorization'] : (isset($headers['authorization']) ? $headers['authorization'] : "");
    $user = $api->authorization();

    if ($url[0] == 'me') {
        require_once 'src/services/me.php';
        $authorization = $api->authorization("api");

        $me = new Me();

         if ($url[1] == 'login') {
            if (!$authorization) {
                http_response_code(401);
                exit;
            }
            $response = $me->login(
                addslashes($request->email),
                addslashes($request->password)
            );
            if ($response) {
                $api->generate_user_log(
                    $response ['user']['id'],
                    'login'
                );
                http_response_code(200);
                echo json_encode($response);
            } else {
                http_response_code(401);
            }
        } else if ($url[1] == 'logout') {
            $response = $me->logout(
                addslashes($headers['Authorization'])
            );
            if ($response) {
                $api->generate_user_log(
                    $api->user_id,
                    'logout'
                );
                http_response_code(200);
                echo json_encode(['message' => 'Logout successfully']);
            } else {
                http_response_code(401);
            }
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Invalid url']);
        }
    } else if ($user) {
        if ($url[0] == 'users') {
            require_once 'src/services/users.php';
            $users = new Users();
           
            if (!isset($url[1])){ //read
                $users->user_id = $user;
                $response = $users->read(
                    (isset($_GET['position']) ? ['position' => addslashes($_GET['position'])] : [])
                );
                if ($response || $response == []) {
                    $api->generate_user_log(
                        $api->user_id,
                        'users.read'

                    );
                    echo json_encode($response);
                } else {
                    http_response_code(400);
                }
    
            }else if ($url[1] == 'create') {
                $response = $users->create(    
                addslashes($request->name),
                addslashes($request->email),
                addslashes($request->password),
                addslashes($request->position)
    
                );
                if ($response) {
                    $api->generate_user_log(
                        $api->user_id,
                        'users.create',
                        json_encode($response)
                    );
                    http_response_code(201);
                    echo json_encode(['User created']);
                } else {
                    http_response_code(400);
                }
            } else if ($url[1] == 'update') {
                $response = $users->update(
                    addslashes($request->id),
                    addslashes($request->name),
                    addslashes($request->email),
                    addslashes($request->position)
                );
                if ($response) {
                        $api->generate_user_log(
                            $api->user_id,
                            'users.update',
                            json_encode($response)
                        );
                    http_response_code(200);
                    echo json_encode(['User updated']);
                } else {
                    http_response_code(400);
                    echo json_encode(['This id does not exist or invalid URL']);
                }
            } else if ($url[1] == 'delete') {
                $response = $users->delete (
                    addslashes($url[2])
                );
                if ($response) {
                    $api->generate_user_log(
                        $api->user_id,
                        'users.delete',
                        json_encode($response)
                    );
                    http_response_code(204);
                } else {
                    http_response_code(400);
                }
            } else {
                $response = $users->read_by_slug(
                    addslashes($url[1])
                );
                if ($response) {
                    $api->generate_user_log(
                        $api->user_id,
                        'users.read_by_slug'

                    );
                    http_response_code(200);
                    echo json_encode($response);
                } else {
                    http_response_code(400);
                    echo json_encode(['message' => 'Invalid URL or user not found']);
                }
            }
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Invalid url']);
        }
    } else {
        http_response_code(401);
    }

} else {
    echo json_encode([
        'message' => 'server running',
        'version' => VERSION,
    ]);
}