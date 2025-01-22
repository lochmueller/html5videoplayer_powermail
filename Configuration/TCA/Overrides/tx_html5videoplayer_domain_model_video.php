<?php

/**
 * TCA Addon for tx_html5videoplayer_domain_model_video
 */

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

$tempColumns = [
    'powermail_protection' => [
        'exclude' => 1,
        'label' => 'Powermail protection',
        'config' => [
            'type' => 'select',
            'items' => [
                # @todo migrate
                [
                    '** Not protected **',
                    ''
                ]
            ],
            'foreign_table' => 'tx_powermail_domain_model_form',
            'size' => 1
        ]
    ],
];

ExtensionManagementUtility::addTCAcolumns('tx_html5videoplayer_domain_model_video', $tempColumns);
ExtensionManagementUtility::addToAllTCAtypes(
    'tx_html5videoplayer_domain_model_video',
    implode(',', array_keys($tempColumns)),
    '',
    'after:vimeo'
);
