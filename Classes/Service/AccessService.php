<?php

namespace HVP\Html5videoplayerPowermail\Service;

use HVP\Html5videoplayer\Domain\Model\Video;
use In2code\Powermail\Domain\Model\Form;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Service\FlexFormService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\HttpUtility;
use TYPO3\CMS\Core\Utility\MathUtility;
use TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder;

/**
 * Handling the detail page access
 */
class AccessService extends AbstractService
{
    protected SessionService $sessionService;

    protected UriBuilder $uriBuilder;

    protected FlexFormService $flexFormService;

    public function __construct(
        SessionService  $sessionService,
        UriBuilder      $uriBuilder,
        FlexFormService $flexFormService
    )
    {
        $this->sessionService = $sessionService;
        $this->uriBuilder = $uriBuilder;
        $this->flexFormService = $flexFormService;
    }


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
        $message = 'Do not cache video detail page, because every request is check via html5videoplayer_powermail';
        $GLOBALS['TSFE']->set_no_cache($message);

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
        $qb = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');
        return $qb->select('uid,pid,pi_flexform')
            ->from('tt_content')
            ->where(
                $qb->expr()->and(
                    $qb->expr()->eq('CType', 'list'),
                    $qb->expr()->eq('list_type', 'powermail_pi1')
                ))
            ->executeQuery()
            ->fetchAllAssociative();
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
        $qb = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_html5videoplayer_domain_model_video');
        return (bool)$qb->select('*')
            ->from('tx_html5videoplayer_domain_model_video')
            ->where($qb->expr()->eq('powermail_protection', ':uid'))
            ->setParameter('uid', $form->getUid())
            ->executeQuery()
            ->rowCount();
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
