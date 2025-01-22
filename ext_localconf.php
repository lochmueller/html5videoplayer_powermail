<?php

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

# todo migrate in HTML5 Videoplayer
$signalSlotDispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class);
$signalSlotDispatcher->connect(
    \HVP\Html5videoplayer\Controller\VideoplayerController::class,
    \HVP\Html5videoplayer\Controller\VideoplayerController::class . '::detailAction',
    \HVP\Html5videoplayerPowermail\Slots\Videoplayer::class,
    'detailAction'
);
