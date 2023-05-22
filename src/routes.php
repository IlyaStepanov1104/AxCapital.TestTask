<?php

use controllers\MainController;

return [
    '~^login/(.*)$~' => [MainController::class, 'login'],
    '~^register/(.*)$~' => [MainController::class, 'register'],
    '~^logout/(.*)$~' => [MainController::class, 'logout'],
    '~^data/(.*)$~' => [MainController::class, 'data'],
    '~^admin-data-add/(.*)$~' => [MainController::class, 'dataAdminAdd'],
    '~^admin-data-delete/(.*)$~' => [MainController::class, 'dataAdminDelete'],
    '~^admin-data-edit/(.*)$~' => [MainController::class, 'dataAdminEdit'],
    '~^admin-data/(.*)$~' => [MainController::class, 'dataAdmin'],
    '~^$~' => [MainController::class, 'index'],
    '~.*~' => [MainController::class, 'error'],
];