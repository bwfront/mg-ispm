<?php

use Mg\Imoispm\Backend\Controller\ISPMBackendController;;

return [
    'ispm_backend' => [
        'parent' => 'web',
        'position' => ['after' => 'web_info'],
        'access' => 'user,group',
        'workspaces' => 'live',
        'path' => '/module/web/ispm_backend',
        'labels' => 'LLL:EXT:imoispm/Resources/Private/Language/locallang_mod.xlf',
        'extensionName' => 'imoispm',
        'iconIdentifier' => 'tx_imoispm_icon',
        'controllerActions' => [
            ISPMBackendController::class => [
                'listObject', 'showObject', 'newObject', 'createObject', 'editObject', 'deleteObject', 'updateObject', 'newUnit', 'createUnit', 'deleteUnit', 'editUnit', 'updateUnit', 'chiffreLog', 'listUserData'
            ],
        ],
    ],
];
