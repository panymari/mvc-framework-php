<?php

require_once '../helpers/helpers.php';
require_once './const.php';

if (isset($_POST['user_id']) || isset($_POST['action'])) {
    ['user_id' => $user_id, 'action' => $action] = $_POST;

    switch ($action) {
        case 'edit':
        case 'delete':
            redirect(301, USER_ROOT_REF. "/$action/$user_id");

            break;
        case 'create':
            redirect(301, USER_ROOT_REF . '/create');

            break;
    }
}
