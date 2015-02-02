<?php

/**
 * TCA Addon for tx_html5videoplayer_domain_model_video
 */

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

$tempColumns = array(
	'powermail_protection' => array(
		'exclude' => 1,
		'label'   => 'Powermail protection',
		'config'  => array(
			'type'          => 'select',
			'items'         => array(
				array(
					'** Not protected **',
					''
				)
			),
			'foreign_table' => 'tx_powermail_domain_model_forms',
			'size'          => 1
		)
	),
);

ExtensionManagementUtility::addTCAcolumns('tx_html5videoplayer_domain_model_video', $tempColumns);
ExtensionManagementUtility::addToAllTCAtypes('tx_html5videoplayer_domain_model_video', implode(',', array_keys($tempColumns)), '', 'after:vimeo');