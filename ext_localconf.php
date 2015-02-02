<?php

if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

/** @var \TYPO3\CMS\Extbase\SignalSlot\Dispatcher $signalSlotDispatcher */
$signalSlotDispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\SignalSlot\\Dispatcher');
$signalSlotDispatcher->connect('In2code\\Powermail\\Controller\\FormController', 'createActionAfterSubmitView', 'FRUIT\\Html5videoplayerPowermail\\Slots\\Form', 'createActionAfterSubmitView');
$signalSlotDispatcher->connect('HVP\\Html5videoplayer\\Controller\\VideoplayerController', 'HVP\\Html5videoplayer\\Controller\\VideoplayerController::detailAction', 'FRUIT\\Html5videoplayerPowermail\\Slots\\Videoplayer', 'detailAction');
