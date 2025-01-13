<?php

namespace Mg\Imoispm\Hooks;

use Mg\Imoispm\ISPM\Hooks\ChiffreGenerator;
use Mg\Imoispm\Domain\Repository\ImoChiffreRepository as RepositoryImoChiffreRepository;
use Mg\Imoispm\Utility\ChiffreGenerator as UtilityChiffreGenerator;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class DataMapHookHandler
{
    /**
     * @var ImoChiffreRepository
     */
    protected $imoChiffreRepository;

    /**
     * @var ChiffreGenerator
     */
    protected $chiffreGenerator;

    /**
     * Constructor to inject dependencies.
     *
     * @param ImoChiffreRepository $imoChiffreRepository
     * @param ChiffreGenerator $chiffreGenerator
     */
    public function __construct(
        RepositoryImoChiffreRepository $imoChiffreRepository = null,
        UtilityChiffreGenerator $chiffreGenerator = null
    ) {
        $this->imoChiffreRepository = $imoChiffreRepository ?? GeneralUtility::makeInstance(RepositoryImoChiffreRepository::class);
        $this->chiffreGenerator = $chiffreGenerator ?? GeneralUtility::makeInstance(UtilityChiffreGenerator::class);
    }
    /**
     * Hook called before a database record is persisted.
     * Automatically fills the 'chiffre' field if it's empty.
     *
     * @param array $fieldArray
     * @param string $table
     * @param mixed $id
     * @param \TYPO3\CMS\Core\DataHandling\DataHandler $dataHandler
     */
    public function processDatamap_preProcessFieldArray(&$fieldArray, $table, $id, $dataHandler)
    {
        $isNew = $dataHandler->isImporting || strpos((string)$id, 'NEW') !== false;

        if ($table === 'tx_ispm_domain_model_imochiffre' && ($isNew || empty($fieldArray['chiffre']))) {
            $fieldArray['chiffre'] = $this->chiffreGenerator->generateChiffre();
        }
    }
}
