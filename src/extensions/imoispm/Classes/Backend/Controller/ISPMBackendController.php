<?php

declare(strict_types=1);

namespace Mg\Imoispm\Backend\Controller;

use Mg\Imoispm\Domain\Model\ImoChiffre;
use Mg\Imoispm\Domain\Model\ImoObjects;
use Mg\Imoispm\Domain\Model\ImoUnits;
use Mg\Imoispm\Domain\Model\UserData;
use Mg\Imoispm\Domain\Repository\ChiffreLogRepository;
use Mg\Imoispm\Domain\Repository\FrontendUserRepository;
use Mg\Imoispm\Domain\Repository\ImoChiffreRepository;
use Mg\Imoispm\Domain\Repository\ImoObjectsRepository;
use Mg\Imoispm\Domain\Repository\ImoUnitsRepository;
use Mg\Imoispm\Domain\Repository\UserDataRepository;
use Mg\Imoispm\Utility\ChiffreGenerator;

use TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface;
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Backend\Attribute\AsController;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\Extbase\Persistence\Generic\QuerySettingsInterface;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

#[AsController]
class ISPMBackendController extends ActionController
{

    /**
     * imoObjectsRepository
     *
     * @var ImoObjectsRepository
     */
    protected $imoObjectsRepository = null;

    /**
     * imoObjectsRepository
     *
     * @var ImoChiffreRepository
     */
    protected $imoChiffreRepository = null;

    /**
     * imoUnitsRepository
     *
     * @var ImoUnitsRepository
     */
    protected $imoUnitsRepository = null;

    /**
     * ChiffreLogRepository
     *
     * @var ChiffreLogRepository
     */
    protected $chiffreLogRepository = null;

    /**
     * @var ChiffreGenerator
     */
    protected $chiffreGenerator;

    /**
     * @var UserDataRepository
     */
    protected $userDataRepository;

    /**
     * frontendUserRepository
     *
     * @var FrontendUserRepository
     */
    protected $frontendUserRepository;

    /**
     * @var \ModuleTemplateFactory
     */
    protected $moduleTemplate;

    /**
     * @var \PersistenceManagerInterface
     */
    protected $persistenceManager = null;
    
    public function __construct(
        protected readonly ModuleTemplateFactory $moduleTemplateFactory,
        ImoChiffreRepository $imoChiffreRepository,
        ImoUnitsRepository $imoUnitsRepository,
        ImoObjectsRepository $imoObjectsRepository,
        ChiffreLogRepository $chiffreLogRepository,
        UserDataRepository $userDataRepository,
        FrontendUserRepository $frontendUserRepository,
        ChiffreGenerator $chiffreGenerator,
        QuerySettingsInterface $querySettings,
        PersistenceManagerInterface $persistenceManager
    ) {
        $this->imoChiffreRepository = $imoChiffreRepository;
        $this->imoUnitsRepository = $imoUnitsRepository;
        $this->imoObjectsRepository = $imoObjectsRepository;
        $this->chiffreLogRepository = $chiffreLogRepository;
        $this->userDataRepository = $userDataRepository;
        $this->chiffreGenerator = $chiffreGenerator;
        $this->frontendUserRepository = $frontendUserRepository;
        $this->persistenceManager = $persistenceManager;

        $querySettings->setRespectStoragePage(true);
        $querySettings->setStoragePageIds([1]);
        $this->imoChiffreRepository->setDefaultQuerySettings($querySettings);
        $this->imoUnitsRepository->setDefaultQuerySettings($querySettings);
        $this->imoObjectsRepository->setDefaultQuerySettings($querySettings);
        $this->chiffreLogRepository->setDefaultQuerySettings($querySettings);
        $this->userDataRepository->setDefaultQuerySettings($querySettings);
        $this->frontendUserRepository->setDefaultQuerySettings($querySettings);
    }

    protected function initializeModuleTemplate(): void
    {
        if ($this->moduleTemplate === null) {
            $this->moduleTemplate = $this->moduleTemplateFactory->create($this->request);
        }
    }

    //!! User Data

    public function listUserDataAction() {
        $this->initializeModuleTemplate();

        $userDataList = $this->userDataRepository->findAllOrderedByTimestamp();
    
        $detailedUserDataList = [];
    
        foreach ($userDataList as $userData) {
            $unitnr = $userData->getUnitnr();
            $objectnr = $userData->getObjectnr();
    
            $imoUnit = $this->imoUnitsRepository->findByUid($unitnr);
            $imoObject = $this->imoObjectsRepository->findByUid($objectnr);
    
            $detailedUserDataList[] = [
                'userData' => $userData,
                'imoUnit' => $imoUnit,
                'imoObject' => $imoObject,
            ];
        }
    
        $this->moduleTemplate->assign('detailedUserDataList', $detailedUserDataList);
        return $this->moduleTemplate->renderResponse('listUserData');
    }

    public function deleteUserDataAction(UserData $userData, ImoUnits $imoUnit, ImoObjects $imoObject) {
        $this->userDataRepository->remove($userData);
        $this->persistenceManager->persistAll();

        $title = LocalizationUtility::translate('ispm.form.title.ok', 'ispm');
        $message = LocalizationUtility::translate('ispm.form.message.object.deleted', 'ispm');
        $this->addFlashMessage($message, $title, ContextualFeedbackSeverity::ERROR);

        $arguments = ['imoObject' => $imoObject, 'imoUnit' => $imoUnit];
        return $this->redirect('chiffreLog', null, null, $arguments);
    }

    //!! Chiffre Logs

    public function chiffreLogAction(ImoUnits $imoUnit, ImoObjects $imoObject)
    {

        $this->initializeModuleTemplate();

        $chiffre = $this->imoChiffreRepository->findByUnitnr($imoUnit->getUid());
        $imoUnit->chiffre = $chiffre->getChiffre();
        $userInfo = $this->getCurrentAndAllUsersFromChiffre($chiffre);
        $imoUnit->userName =  $userInfo['userOptions'][$userInfo['currentUserId']];

        $chiffreLogs = $this->chiffreLogRepository->findLogsForChiffre($chiffre->getChiffre());

        $sortedChiffreLogs = [];
        foreach ($chiffreLogs as $log) {
            $usercookie = $log->getUsercookie();
            if (!isset($sortedChiffreLogs[$usercookie])) {
                $sortedChiffreLogs[$usercookie] = [];
            }
            $sortedChiffreLogs[$usercookie][] = $log;
        }
        $chiffreLogsCount = count($chiffreLogs);

        $this->moduleTemplate->assign('chiffreLogsCount', $chiffreLogsCount);
        $this->moduleTemplate->assign('chiffreLogs', $sortedChiffreLogs);

        $userData = $this->userDataRepository->findByChiffreOrderedByDate($chiffre->getChiffre());
        $userDataCount = count($userData);
        $this->moduleTemplate->assign('userData', $userData);
        if (!empty($userData)) {
            $this->moduleTemplate->assign('userDataCount', $userDataCount);
        }

        $this->moduleTemplate->assign('imoUnit', $imoUnit);
        $this->moduleTemplate->assign('imoObject', $imoObject);
        return $this->moduleTemplate->renderResponse('chiffreLog');
    }

    //!!! Unit

    /**
     * action deleteUnit
     *
     * @param ImoUnits $imoUnit
     * @param ImoObjects $imoObject
     */
    public function deleteUnitAction(ImoUnits $imoUnit, ImoObjects $imoObject)
    {
        $title = LocalizationUtility::translate('ispm.form.title.error', 'imoispm');
        $message = LocalizationUtility::translate('ispm.form.message.unit.deleted', 'imoispm');
        $this->addFlashMessage($message, $title, ContextualFeedbackSeverity::ERROR);
        $imoChiffre = $this->imoChiffreRepository->findByUnitnrDelete($imoUnit->getUid());
        $this->imoChiffreRepository->remove($imoChiffre);
        $this->imoUnitsRepository->remove($imoUnit);
        $arguments = ['imoObject' => $imoObject];
        return $this->redirect('showObject', null, null, $arguments);
    }

    /**
     * action editunit
     *
     * @param ImoObjects $imoObject
     * @param ImoObjects $imoObject
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("imoObjects")
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function editUnitAction(ImoUnits $imoUnit, ImoObjects $imoObject): \Psr\Http\Message\ResponseInterface
    {
        $this->initializeModuleTemplate();
        $chiffre = $this->imoChiffreRepository->findByUnitnr($imoUnit->getUid());
        $imoUnit->chiffre = $chiffre->getChiffre();

        $this->moduleTemplate->assign('userInfo', $this->getCurrentAndAllUsersFromChiffre($chiffre));
        $this->moduleTemplate->assign('imoUnit', $imoUnit);
        $this->moduleTemplate->assign('imoObject', $imoObject);
        return $this->moduleTemplate->renderResponse('editUnit');
    }
    
    /**
     * action updateUnit
     *
     * @param ImoUnits $imoUnit
     */
    public function updateUnitAction(ImoUnits $imoUnit, int $userid, string $chiffre)
    {
        $title = LocalizationUtility::translate('ispm.form.title.ok', 'imoispm');
        $message = LocalizationUtility::translate('ispm.form.message.unit.updated', 'imoispm');
        $this->addFlashMessage($message, $title, ContextualFeedbackSeverity::OK);
        $this->imoUnitsRepository->update($imoUnit);
        $imoObjectUid = $imoUnit->getImoobjectuid();
        $imoObject = $this->imoObjectsRepository->findByUid($imoObjectUid);
        if($chiffre) {
            $imoChiffre = $this->imoChiffreRepository->findByChiffre($chiffre);
            $imoChiffre->setUserid($userid);
            $this->imoChiffreRepository->update($imoChiffre);
        }
        $arguments = ['imoObject' => $imoObject];
        return $this->redirect('showObject', null, null, $arguments);
    }

    /**
     * action newUnit
     *
     * @param ImoObjects $imoObject
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function newUnitAction(ImoObjects $imoObject): \Psr\Http\Message\ResponseInterface
    {
        $this->initializeModuleTemplate();
        $this->moduleTemplate->assign('imoObject', $imoObject);
        $this->moduleTemplate->assign('userInfo', $this->getCurrentAndAllUsersFromChiffre());
        return $this->moduleTemplate->renderResponse('newUnit');
    }

    /**
     * action createUnit
     *
     * @param ImoUnits $newImoUnit
     * @param int $objectuid
     */
    public function createUnitAction(ImoUnits $newImoUnit, int $objectuid, int $userid)
    {
        $chiffre = $this->chiffreGenerator->generateChiffre();
        $newImoUnit->setImoobjectUid($objectuid);
        $this->imoUnitsRepository->add($newImoUnit);

        // persistenceManager to get the uid
        $this->persistenceManager->persistAll();
        $newImoChiffre = new ImoChiffre();
        $newImoChiffre->setObjectnr($objectuid);
        $newImoChiffre->setUnitnr($newImoUnit->getUid());
        $newImoChiffre->setChiffre($chiffre);
        $newImoChiffre->setUserid($userid);
        $this->imoChiffreRepository->add($newImoChiffre);
        $title = LocalizationUtility::translate('ispm.form.title.ok', 'imoispm');
        $message = LocalizationUtility::translate('ispm.form.message.unit.created', 'imoispm', [$chiffre]);
        $this->addFlashMessage($message, $title, ContextualFeedbackSeverity::OK);
        $arguments = ['imoObject' => $this->imoObjectsRepository->findByUid($objectuid)];
        return $this->redirect('showObject', null, null, $arguments);
    }


    //!! Object
    /**
     * action new
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function newObjectAction(): \Psr\Http\Message\ResponseInterface
    {
        $this->initializeModuleTemplate();
        return $this->moduleTemplate->renderResponse('newObject');
    }

    /**
     * action create
     *
     * @param ImoObjects $newImoObjects
     */
    public function createObjectAction(ImoObjects $newImoObjects)
    {
        $title = LocalizationUtility::translate('ispm.form.title.ok', 'imoispm');
        $message = LocalizationUtility::translate('ispm.form.message.object.created', 'imoispm');
        $this->addFlashMessage($message, $title, ContextualFeedbackSeverity::OK);
        $this->imoObjectsRepository->add($newImoObjects);

        return $this->redirect('listObject');
    }


    /**
     * action editObject
     *
     * @param ImoObjects $imoObject
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("imoObjects")
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function editObjectAction(ImoObjects $imoObject): \Psr\Http\Message\ResponseInterface
    {
        $this->initializeModuleTemplate();
        $this->moduleTemplate->assign('imoObject', $imoObject);
        return $this->moduleTemplate->renderResponse('editObject');
    }

    /**
     * action updateObject
     *
     * @param ImoObjects $imoObjects
     */
    public function updateObjectAction(ImoObjects $imoObject)
    {
        $title = LocalizationUtility::translate('ispm.form.title.ok', 'imoispm');
        $message = LocalizationUtility::translate('ispm.form.message.object.updated', 'imoispm');
        $this->addFlashMessage($message, $title, ContextualFeedbackSeverity::OK);
        $this->imoObjectsRepository->update($imoObject);
        $arguments = ['imoObject' => $imoObject];
        return $this->redirect('showObject', null, null, $arguments);
    }

    /**
     * action deleteObject
     *
     * @param ImoObjects $imoObjects
     */
    public function deleteObjectAction(ImoObjects $imoObject)
    {
        $title = LocalizationUtility::translate('ispm.form.title.ok', 'imoispm');
        $message = LocalizationUtility::translate('ispm.form.message.object.deleted', 'imoispm');
        $this->addFlashMessage($message, $title, ContextualFeedbackSeverity::ERROR);
        $this->imoObjectsRepository->remove($imoObject);
        return $this->redirect('listObject');
    }

    /**
     * action showObject
     *
     * @param ImoObjects $imoObjects
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function showObjectAction(ImoObjects $imoObject): \Psr\Http\Message\ResponseInterface
    {
        $this->initializeModuleTemplate();

        $objectnr = $imoObject->getUid();
        $chiffres = $this->imoChiffreRepository->findByObjectnr($objectnr);
        if ($chiffres) {
            $units = [];
            foreach ($chiffres as $chiffre) {
                $unitUid = $chiffre->getUnitnr();
                if (!empty($unitUid)) {
                    $unit =  $this->imoUnitsRepository->findByUid($unitUid);
                    $unit->chiffre = $chiffre->getChiffre();
                    $userInfo = $this->getCurrentAndAllUsersFromChiffre($chiffre);
                    $unit->userName =  $userInfo['userOptions'][$userInfo['currentUserId']];
                    $units[] = $unit;
                }
            }
            $this->moduleTemplate->assign('imoUnits', $units);
        }

        $this->moduleTemplate->assign('imoObject', $imoObject);
        return $this->moduleTemplate->renderResponse('ShowObject');
    }

     /**
     * Action to show the List und optional sorting wth pagination
     *
     * @param int|null $userid
     * @param string $sort
     * @param string $direction
     * @param int $page
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function listObjectAction(
        int $userid = null,
        string $sort = 'city',
        string $direction = 'ASC',
        int $page = 1
    ): \Psr\Http\Message\ResponseInterface {
        $this->initializeModuleTemplate();

        $limit = 10;
        $page = max(1, $page);
        $offset = ($page - 1) * $limit;
        
        if($userid == 0) {
            $userid = null;
        }

        $allowedSortFields = ['city', 'street', 'streetnumber', 'postalcode'];
        if (!in_array($sort, $allowedSortFields, true)) {
            $sort = 'city';
        }

        $direction = strtoupper($direction);
        if (!in_array($direction, ['ASC', 'DESC'], true)) {
            $direction = 'ASC';
        }

        $orderings = [
            $sort => ($direction === 'DESC') 
                ? \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING 
                : \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
        ];

        $query = $this->imoObjectsRepository->createQuery();
        $query->setOrderings($orderings);

        if ($userid !== null) {
            $userChiffres = $this->imoChiffreRepository->findByUserid($userid);
            $uniqueObjectNrs = [];
            foreach ($userChiffres as $chiffre) {
                $objectNr = $chiffre->getObjectnr();
                if (!in_array($objectNr, $uniqueObjectNrs, true)) {
                    $uniqueObjectNrs[] = $objectNr;
                }
            }

            if (!empty($uniqueObjectNrs)) {
                $query->matching(
                    $query->in('uid', $uniqueObjectNrs)
                );
            } else {
                $query->matching(
                    $query->equals('uid', 0)
                );
            }
        }

        $total = $query->count();
        $imoObjects = $query->setLimit($limit)->setOffset($offset)->execute();
        $totalPages = (int) ceil($total / $limit);
        $currentPage = $page;
        $pages = $this->getVisiblePages($currentPage, $totalPages, 1);

        $sortableFields = ['city', 'street', 'streetnumber', 'postalcode'];
        $newDirections = [];
        foreach ($sortableFields as $field) {
            $newDirections[$field] = ($sort === $field) ? ($direction === 'ASC' ? 'DESC' : 'ASC') : 'ASC';
        }

        $this->moduleTemplate->assignMultiple([
            'imoObjects' => $imoObjects,
            'sortField' => $sort,
            'sortDirection' => $direction,
            'newDirections' => $newDirections,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
            'pages' => $pages,
            'totalResults' => $total
        ]);

        $users = $this->getCurrentAndAllUsersFromChiffre();
        $users['currentUserId'] = $userid;
        
        $this->moduleTemplate->assign('userInfo', $users);

        return $this->moduleTemplate->renderResponse('ListObject');
    }


    protected function getCurrentAndAllUsersFromChiffre($chiffre = null) {
        $currentUserId = 0;
        if ($chiffre) {
            $userid = $chiffre->getUserid();
            $userOptions = [];
            $currentUserId = null;
        
            if ($userid) {
                $frontendUser = $this->frontendUserRepository->findByUid($userid);
                if ($frontendUser) {
                    $userName = $frontendUser->getUsername();
                    $userOptions[$frontendUser->getUid()] = $userName;
                    $currentUserId = $frontendUser->getUid();
                }
            }
        }
        $allUsers = $this->frontendUserRepository->findAllFromPid();
    
        foreach ($allUsers as $userObj) {
            if ($userObj->getUid() === $currentUserId) {
                continue;
            }
            $userOptions[$userObj->getUid()] = $userObj->getUsername();
        }
        
        if(!empty($userOptions)) {
            asort($userOptions);
        }
    
        return [
            'userOptions' => $userOptions,
            'currentUserId' => $currentUserId
        ];
    }

     /**
     * Calc the Visible Pagination Pagesnums
     *
     * @param int $currentPage Current Page
     * @param int $totalPages Total Pages count
     * @param int $range Count for the visible Pages before and after the current page
     * @return array Array with elllipses and the pages that are visible
     */
    protected function getVisiblePages(int $currentPage, int $totalPages, int $range = 1): array
    {
        $visiblePages = [];

        $visiblePages[] = 1;

        $start = max(2, $currentPage - $range);
        $end = min($totalPages - 1, $currentPage + $range);

        if ($start > 2) {
            $visiblePages[] = 'ellipsis_start';
        }

        for ($i = $start; $i <= $end; $i++) {
            $visiblePages[] = $i;
        }

        if ($end < $totalPages - 1) {
            $visiblePages[] = 'ellipsis_end';
        }

        if ($totalPages > 1) {
            $visiblePages[] = $totalPages;
        }

        return $visiblePages;
    }
}
