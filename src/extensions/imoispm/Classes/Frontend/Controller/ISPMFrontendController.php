<?php

declare(strict_types=1);

namespace Mg\Imoispm\Frontend\Controller;

use TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Extbase\Http\ForwardResponse;

use Mg\Imoispm\Domain\Model\ImoChiffre;
use Mg\Imoispm\Domain\Model\UserData;
use Mg\Imoispm\Domain\Repository\ChiffreLogRepository;
use Mg\Imoispm\Domain\Repository\ImoChiffreRepository;
use Mg\Imoispm\Domain\Repository\ImoObjectsRepository;
use Mg\Imoispm\Domain\Repository\ImoUnitsRepository;
use Mg\Imoispm\Domain\Repository\UserDataRepository;
use Mg\Imoispm\PageTitle\ISPMPageTitleProvider;
use Mg\Imoispm\Utility\ChiffreGenerator;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Persistence\Generic\QuerySettingsInterface;

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
        QuerySettingsInterface $querySettings,
    ) {
        $this->imoChiffreRepository = $imoChiffreRepository;
        $this->imoUnitsRepository = $imoUnitsRepository;
        $this->imoObjectsRepository = $imoObjectsRepository;
        $this->chiffreLogRepository = $chiffreLogRepository;
        $this->chiffreGenerator = $chiffreGenerator;
        $this->userDataRepository = $userDataRepository;

        $querySettings->setRespectStoragePage(true);
        $querySettings->setStoragePageIds([1]);
        $this->imoChiffreRepository->setDefaultQuerySettings($querySettings);
        $this->imoUnitsRepository->setDefaultQuerySettings($querySettings);
        $this->imoObjectsRepository->setDefaultQuerySettings($querySettings);
        $this->chiffreLogRepository->setDefaultQuerySettings($querySettings);
        $this->userDataRepository->setDefaultQuerySettings($querySettings);
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
            $message = LocalizationUtility::translate('fe.ispm.form.error.unkown.chiffre', 'imoispm');
            $title = LocalizationUtility::translate('ispm.form.title.error', 'imoispm');

            $this->addFlashMessage($message, $title, ContextualFeedbackSeverity::ERROR);
            return $this->redirect("chiffre");
        }
    }

    public function saveUserDataAction(UserData $userData) {
        $userData->setUsercookie($this->getCookie());
        $userData->setPid(1);
        $this->userDataRepository->add($userData);
        $this->persistenceManager->persistAll();
        $arguments = ["userData" => $userData];
        return $this->redirect('successSaveUserData', null, null, $arguments);
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

    public function showObjectByChiffreAction(array $r): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('r', $r);
        return $this->htmlResponse();
    }

}
