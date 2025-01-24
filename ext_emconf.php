<?php

$EM_CONF[$_EXTKEY] = array(
    'title'        => 'HTML5 Video Player vs. Powermail',
    'description'  => 'Connect both extensions to fetch user input (one powermail form) before the user can access the detail view.',
    'category'     => 'plugin',
    'version'      => '0.1.1',
    'state'        => 'beta',
    'author'       => 'Tim Lochmueller',
    'author_email' => 'tim@fruit-lab.de',
    'constraints'  => array(
        'depends' => array(
            'typo3'            => '12.4.0-12.4.99',
            'html5videoplayer' => '11.1.0-11.99.99',
            'powermail'        => '12.0.0-12.99.99',
        ),
    ),
);
