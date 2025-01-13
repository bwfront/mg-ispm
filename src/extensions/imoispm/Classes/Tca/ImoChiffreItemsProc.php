<?php
namespace Mg\Imoispm\Tca;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Backend\Utility\BackendUtility;

class ImoChiffreItemsProc
{
    /**
     * itemsProcFunc for objectnr field
     *
     * @param array &$config The TCA configuration array of the field
     */
    public function objectNrItemsProc(array &$config)
    {
        $record = $config['row'];
        $unitUid = $record['unitnr'];

        if ($unitUid) {
            $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
                ->getQueryBuilderForTable('tx_ispm_domain_model_imounits');

            $imounit = $queryBuilder
                ->select('.*') 
                ->from('tx_ispm_domain_model_imounits')
                ->where(
                    $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($unitUid, \PDO::PARAM_INT))
                )
                ->executeQuery()
                ->fetchAssociative();


            if ($imounit && isset($imounit['imoobjectuid'])) {
                $imoObjectUid = (int)$imounit['imoobjectuid'];

                $imoObject = BackendUtility::getRecord('tx_ispm_domain_model_imoobjects', $imoObjectUid, 'street,hidden,deleted');

                if ($imoObject && !$imoObject['hidden'] && !$imoObject['deleted']) {
                    $exists = false;
                    foreach ($config['items'] as $item) {
                        if ($item[1] === $imoObjectUid) {
                            $exists = true;
                            break;
                        }
                    }

                    if (!$exists) {
                        $config['items'][] = [
                            $imoObject['street'],
                            $imoObjectUid
                        ];
                    }

                    if (empty($record['objectnr'])) {
                        $config['default'] = $imoObjectUid;
                    }
                }
            }
        }
    }
}
