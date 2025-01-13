<?php

declare(strict_types=1);

namespace Mg\Imoispm\Frontend\Controller;

use TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Utility\GeneralUtility;

use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Extbase\Http\ForwardResponse;

use Mg\Imoispm\Domain\Model\ImoChiffre;
use Mg\Imoispm\Domain\Model\ImoObjects;
use Mg\Imoispm\Domain\Model\ImoUnits;
use Mg\Imoispm\Domain\Model\UserData;
use Mg\Imoispm\Domain\Repository\ChiffreLogRepository;
use Mg\Imoispm\Domain\Repository\ImoChiffreRepository;
use Mg\Imoispm\Domain\Repository\ImoObjectsRepository;
use Mg\Imoispm\Domain\Repository\ImoUnitsRepository;
use Mg\Imoispm\Domain\Repository\UserDataRepository;
use Mg\Imoispm\PageTitle\ISPMPageTitleProvider;
use Mg\Imoispm\Utility\ChiffreGenerator;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * ISPMFrontendController
 */
class ISPMFrontendController extends ActionController
{

    protected $persistenceManager = null;

    protected $imoObjectsRepository = null;

    protected $imoChiffreRepository = null;

    protected $chiffreLogRepository = null;

    protected $imoUnitsRepository = null;
    
    protected $chiffreGenerator;

    protected $userDataRepository = null;

    public function injectPersistenceManager(PersistenceManagerInterface $persistenceManager)
    {
        $this->persistenceManager = $persistenceManager;
    }

    public function __construct(
        ImoChiffreRepository $imoChiffreRepository,
        ImoUnitsRepository $imoUnitsRepository,
        ImoObjectsRepository $imoObjectsRepository,
        ChiffreLogRepository $chiffreLogRepository,
        ChiffreGenerator $chiffreGenerator,
        private readonly ISPMPageTitleProvider $titleProvider,
        UserDataRepository $userDataRepository,
    ) {
        $this->imoChiffreRepository = $imoChiffreRepository;
        $this->imoUnitsRepository = $imoUnitsRepository;
        $this->imoObjectsRepository = $imoObjectsRepository;
        $this->chiffreLogRepository = $chiffreLogRepository;
        $this->chiffreGenerator = $chiffreGenerator;
        $this->userDataRepository = $userDataRepository;
    }

    protected function initializeAction(): void
    {
        parent::initializeAction();

        $this->setCookie(); 
        if ($this->titleProvider->getTitle() == "") {
            $pageTitle = $GLOBALS['TSFE']->page['title'];
            $this->titleProvider->setTitle($pageTitle);
        }
    }

    public function chiffreAction() {
        return $this->htmlResponse();
    }

    public function checkChiffreAction(ImoChiffre $imoChiffre)
    {
        $cookie = $_COOKIE['usercookie'] ?? 'unset';
        $userip = $_SERVER['REMOTE_ADDR'] ?? 'unset';

        $chiffre = $imoChiffre->getChiffre();
        $imoChiffreObj = $this->imoChiffreRepository->findByChiffre($chiffre);
        if (!empty($imoChiffreObj)) {
            $pageTitle = $GLOBALS['TSFE']->page['title'];
            $this->titleProvider->setTitle($chiffre . " | " . $pageTitle);
            $imoObject = $this->imoObjectsRepository->findByUid($imoChiffreObj->getObjectnr());
            $imoUnit = $this->imoUnitsRepository->findByUid($imoChiffreObj->getUnitnr());
            $imoUnit->setChiffre($chiffre);
            $view = [
                "imoObject" => $imoObject,
                "imoUnit" => $imoUnit,
            ];

            $this->chiffreLogRepository->addLog(
                $chiffre,
                $cookie,
                $userip,
                $imoChiffreObj->getObjectnr(),
                $imoChiffreObj->getUnitnr()
            );

            return (new ForwardResponse('showObjectByChiffre'))
               ->withArguments(['r' => $view]);

        } else {
            $message = LocalizationUtility::translate('fe.ispm.form.error.unkown.chiffre', 'ispm');
            $title = LocalizationUtility::translate('ispm.form.title.error', 'ispm');

            $this->addFlashMessage($message, $title, \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
            $this->redirect("chiffre");
        }
    }

    public function saveUserDataAction(UserData $userData) {
        $userData->setUsercookie($this->getCookie());
        $this->userDataRepository->add($userData);
        $this->persistenceManager->persistAll();
        $arguments = ["userData" => $userData];
        $this->redirect('successSaveUserData', null, null, $arguments);
    }

    public function successSaveUserDataAction(UserData $userData) {
        $this->view->assign("userData", $userData);
        return $this->htmlResponse();
    }
    
    protected function setCookie()
    {
        $cookieName = 'usercookie';
        $cookieValue = bin2hex(random_bytes(8));
        $cookieLifetime = time() + 3600 * 24 * 365;

        if (!isset($_COOKIE[$cookieName])) {
            setCookie($cookieName, $cookieValue, $cookieLifetime, '/');
        }
    }

    protected function getCookie()
    {
        $cookieName = 'usercookie';
 
        return $_COOKIE[$cookieName];
    }

    //!! Unused functions

    public function newObjectAction(){
        $path = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('ispm') . 'Resources/Public/JavaScript/Dist/postalcodes.json';
        $jsonData = file_get_contents($path);
        $this->view->assign('postalcodesJson', $jsonData);
        return $this->htmlResponse();
    }


    public function editUnitAction(ImoUnits $imoUnits, ImoObjects $object){
        $this->view->assignMultiple([
            "imoUnits" => $imoUnits,
            "object" => $object,
        ]);
        return $this->htmlResponse();
    }

    public function updateUnitAction(ImoUnits $imoUnits, ImoObjects $object){
        $this->imoUnitsRepository->update($imoUnits);
        $arguments = ["object" => $object];
        return $this->redirect('show', null, null, $arguments);
    }

    public function editObjectAction(ImoObjects $object){
        $path = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('ispm') . 'Resources/Public/JavaScript/Dist/postalcodes.json';
        $jsonData = file_get_contents($path);
        $this->view->assign('postalcodesJson', $jsonData);
        $this->view->assign('object', $object);
    }
    
    public function updateObjectAction(ImoObjects $object){
        $this->imoObjectsRepository->update($object);
        $arguments = ["object" => $object];
        return $this->redirect('show', null, null, $arguments);
    }

    public function deleteUnitAction(ImoUnits $imoUnits, ImoObjects $object){
        $imoChiffre = $this->imoChiffreRepository->findByUnitnrDelete($imoUnits->getUid());
        $this->imoChiffreRepository->remove($imoChiffre);
        $this->imoUnitsRepository->remove($imoUnits);
        $arguments = ["object" => $object];
        return $this->redirect('show', null, null, $arguments);

    }
    public function deleteObjectAction(ImoObjects $object){
        $chiffres = $this->imoChiffreRepository->findByObjectnr($object->getUid());
        foreach ($chiffres as $chiffre) {
            $this->imoChiffreRepository->remove($chiffre);
        }
        $units = $this->imoUnitsRepository->findByImoobjectuid($object->getUid());
        foreach ($units as $unit) {
            $this->imoUnitsRepository->remove($unit);
        }
        $this->imoObjectsRepository->remove($object);
        return $this->redirect('list');
    }

    public function newUnitAction(ImoObjects $newImoObjects){
        if($this->imoObjectsRepository->findByUid($newImoObjects->getUid()) == null){
            $this->imoObjectsRepository->add($newImoObjects);
            $this->persistenceManager->persistAll();
            $object = $this->imoObjectsRepository->findOneByUid($newImoObjects->getUid());
        }else{
           $object = $newImoObjects;
        }
        $this->view->assign("object", $object);
        return $this->htmlResponse();
    }

    public function createUnitAction(ImoUnits $newImoUnit,int $objectUid)
    {
        $context = GeneralUtility::makeInstance(Context::class);
        $userAspect = $context->getAspect('frontend.user');
        $userUid = $userAspect->get('id');

        $newImoUnit->setImoobjectuid($objectUid);
        $this->imoUnitsRepository->add($newImoUnit);
        $this->persistenceManager->persistAll();

        $chiffre = $this->chiffreGenerator->generateChiffre();
        $newImoChiffre = new ImoChiffre();
        $newImoChiffre->setObjectnr($objectUid);
        $newImoChiffre->setUserid($userUid);
        $newImoChiffre->setChiffre($chiffre);
        $newImoChiffre->setUnitnr($newImoUnit->getUid());
        $this->imoChiffreRepository->add($newImoChiffre);

        $arguments = ['object'=>$this->imoObjectsRepository->findByUid($objectUid)];
        $this->redirect("show", null, null, $arguments);
    }

    public function showAction(ImoObjects $object)
    {
        $context = GeneralUtility::makeInstance(Context::class);
        $userAspect = $context->getAspect('frontend.user');
        $userUid = $userAspect->get('id');

        $chiffres = $this->imoChiffreRepository->findByUserid($userUid);

        $imoUnits = [];
        foreach ($chiffres as $chiffre) {
            if ($chiffre->getObjectnr() === $object->getUid()) {
                $unitnr = $chiffre->getUnitnr();
                $unit = $this->imoUnitsRepository->findByUid($unitnr);
                if ($unit !== null) {
                    $unit->chiffre = $chiffre->getChiffre();
                    $imoUnits[] = $unit;
                }
            }
        }

        $this->view->assignMultiple(
            [
                "object" => $object,
                "imoUnits" => $imoUnits,
            ]
        );
    }

    public function listAction()
    {
        $context = GeneralUtility::makeInstance(Context::class);
        $userAspect = $context->getAspect('frontend.user');

        $userUid = $userAspect->get('id');
        $userName = $userAspect->get('username');

        $chiffres = $this->imoChiffreRepository->findByUserid($userUid);

        $uniqueObjects = [];
        foreach ($chiffres as $chiffre) {
            $objectnr = $chiffre->getObjectnr();
            if (!isset($uniqueObjects[$objectnr])) {
                $object = $this->imoObjectsRepository->findByUid($objectnr);
                if ($object !== null) {
                    $uniqueObjects[$objectnr] = $object;
                }
            }
        }
        $objects = array_values($uniqueObjects);

        $this->view->assignMultiple(
            [
                'objects' => $objects,
                'username' => $userName,
                'uid' => $userUid,
            ]
        );
    }

    public function showObjectByChiffreAction(array $r): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('r', $r);
        return $this->htmlResponse();
    }

    public function dispatchAction()
    {
        return (new ForwardResponse('chiffre'));
    }
}
