<?php

namespace Mg\Imoispm\Hooks;

use TYPO3\CMS\Core\DataHandling\DataHandler;

class PasswordHashDataHandler
{
    public function processDatamap_preProcessFieldArray(array &$fieldArray, $table, $id, DataHandler $dataHandler)
    {
        if ($table === 'tx_ispm_domain_model_frontenduser' && isset($fieldArray['password'])) {
            if (!empty($fieldArray['password'])) {
                $fieldArray['password'] = password_hash($fieldArray['password'], PASSWORD_DEFAULT);
            }
        }
    }
}
