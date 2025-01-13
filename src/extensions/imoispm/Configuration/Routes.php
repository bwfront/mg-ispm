<?php

use Mg\Imoispm\Frontend\Controller\ISPMFrontendController;

return [
    'frontend' => [
        'chiffre' => [
            'path' => '/chiffre',
            'target' => ISPMFrontendController::class . '::chiffre',
        ],
    ],
];