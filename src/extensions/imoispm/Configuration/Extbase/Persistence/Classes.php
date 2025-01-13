<?php

use Mg\Imoispm\Domain\Model\ChiffreLog;
use Mg\Imoispm\Domain\Model\FrontendUser;
use Mg\Imoispm\Domain\Model\ImoChiffre;
use Mg\Imoispm\Domain\Model\ImoObjects;
use Mg\Imoispm\Domain\Model\ImoUnits;
use Mg\Imoispm\Domain\Model\UserData;

return [
    ImoObjects::class => [
        'tableName' => 'tx_ispm_domain_model_imoobjects',
    ],
    ImoUnits::class => [
        'tableName' => 'tx_ispm_domain_model_imounits',
    ],
    FrontendUser::class => [
        'tableName' => 'tx_ispm_domain_model_frontenduser',
    ],
    ImoChiffre::class => [
        'tableName' => 'tx_ispm_domain_model_imochiffre',
    ],
    UserData::class => [
        'tableName' => 'tx_ispm_domain_model_userdata',
    ],
    ChiffreLog::class => [
        'tableName' => 'tx_ispm_domain_model_chiffrelog',
    ],

];
