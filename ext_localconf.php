<?php

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

/** @var \TYPO3\CMS\Extbase\SignalSlot\Dispatcher $signalSlotDispatcher */
$signalSlotDispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class);
$signalSlotDispatcher->connect(
    \In2code\Powermail\Controller\FormController::class,
    'createActionAfterSubmitView',
    \FRUIT\Html5videoplayerPowermail\Slots\Form::class,
    'createActionAfterSubmitView'
);
$signalSlotDispatcher->connect(
    \HVP\Html5videoplayer\Controller\VideoplayerController::class,
    \HVP\Html5videoplayer\Controller\VideoplayerController::class . '::detailAction',
    \FRUIT\Html5videoplayerPowermail\Slots\Videoplayer::class,
    'detailAction'
);
