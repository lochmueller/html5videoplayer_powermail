<?php
/**
 * Handling the detail page access
 *
 * @package    Html5videoplayerPowermail\Service
 * @author     Tim Lochmüller
 */

namespace HVP\Html5videoplayerPowermail\Service;

use HVP\Html5videoplayerPowermail\Utility\GlobalUtility;
use HVP\Html5videoplayer\Domain\Model\Video;
use In2code\Powermail\Domain\Model\Form;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\HttpUtility;
use TYPO3\CMS\Core\Utility\MathUtility;
use TYPO3\CMS\Frontend\Page\PageRepository;

/**
 * Handling the detail page access
 *
 * @author     Tim Lochmüller
 */
class AccessService extends AbstractService
{

    /**
     * Session service
     *
     * @var \HVP\Html5videoplayerPowermail\Service\SessionService
     * @inject
     */
    protected $sessionService;

    /**
     * Uri Builder
     *
     * @var \TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder
     * @inject
     */
    protected $uriBuilder;

    /**
     * Flexform service
     *
     * @var \TYPO3\CMS\Extbase\Service\FlexFormService
     * @inject
     */
    protected $flexFormService;

    /**
     * The session name
     *
     * @var string
     */
    protected $sessionName = 'submittedForms';

    /**
     * @param Video $video
     */
    public function checkVideoAccess(Video $video = null)
    {
        if ($video === null) {
            return;
        }

        $formProtection = $this->getFormProtection($video);
        if ($formProtection <= 0) {
            return;
        }

        // disable the cache
        GlobalUtility::getTypoScriptFrontendController()
            ->set_no_cache('Do not cache video detail page, because every request is check via html5videoplayer_powermail');

        if ($this->isAccessableByCurrentUser($formProtection)) {
            return;
        }

        $formPage = $this->findFormPage($formProtection);
        if ($formPage) {
            $this->sessionService->set('videoReturnUrl', GeneralUtility::getIndpEnv('TYPO3_REQUEST_URL'));

            $uri = $this->uriBuilder->setTargetPageUid($formPage)
                ->build();
            HttpUtility::redirect($uri, HttpUtility::HTTP_STATUS_403);
        }
    }

    /**
     * @param Form $form
     */
    public function triggerFormSubmit(Form $form)
    {
        if ($this->sessionService->has('videoReturnUrl') && $this->isProtectionForm($form)) {
            $forms = $this->sessionService->has($this->sessionName) ? $this->sessionService->get($this->sessionName) : [];
            $forms[] = $form->getUid();
            $this->sessionService->set($this->sessionName, $forms);
            HttpUtility::redirect($this->sessionService->get('videoReturnUrl'));
        }
    }

    /**
     * Find the given page UID of the form Protection ID
     *
     * @param int $formProtectionId
     *
     * @return int
     */
    protected function findFormPage($formProtectionId)
    {
        $pluings = $this->findPowermailPlugins();
        foreach ($pluings as $plugin) {
            $configuration = $this->flexFormService->convertFlexFormContentToArray($plugin['pi_flexform']);
            if (isset($configuration['settings']['flexform']['main']['form'])) {
                $formId = $configuration['settings']['flexform']['main']['form'];
                if (MathUtility::canBeInterpretedAsInteger($formId) && (int)$formId == $formProtectionId) {
                    return $plugin['pid'];
                }
            }
        }
        return 0;
    }

    /**
     * Find all includes Powermail plugins
     *
     * @return array
     */
    protected function findPowermailPlugins()
    {
        $database = GlobalUtility::getDatabaseConnection();
        $pageRepository = new PageRepository();
        return $database->exec_SELECTgetRows('uid,pid,pi_flexform', 'tt_content', 'CType="list" AND list_type="powermail_pi1"' . $pageRepository->enableFields('tt_content'));
    }

    /**
     * @param $formProtectionId
     *
     * @return bool
     */
    protected function isAccessableByCurrentUser($formProtectionId)
    {
        $forms = $this->sessionService->has($this->sessionName) ? $this->sessionService->get($this->sessionName) : [];
        return in_array((int)$formProtectionId, $forms);
    }

    /**
     * @param Form $form
     *
     * @return bool
     */
    protected function isProtectionForm(Form $form)
    {
        return (bool)GlobalUtility::getDatabaseConnection()
            ->exec_SELECTcountRows('*', 'tx_html5videoplayer_domain_model_video', 'powermail_protection=' . $form->getUid());
    }

    /**
     * Get the Form protection value
     *
     * @param Video $video
     *
     * @return int
     */
    protected function getFormProtection(Video $video)
    {
        $record = BackendUtility::getRecord('tx_html5videoplayer_domain_model_video', $video->getUid());
        return (int)$record['powermail_protection'];
    }
}
