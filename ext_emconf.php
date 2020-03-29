<?php

$EM_CONF[$_EXTKEY] = array(
    'title'        => 'HTML5 Video Player vs. Powermail',
    'description'  => 'Connect both extenion to fetch user input (one powermail form) before the user can access the detail view.',
    'category'     => 'plugin',
    'version'      => '0.1.1',
    'state'        => 'beta',
    'author'       => 'Tim Lochmueller',
    'author_email' => 'tim@fruit-lab.de',
    'constraints'  => array(
        'depends' => array(
            'typo3'            => '6.2.0-8.7.99',
            'html5videoplayer' => '6.3.1-0.0.0',
            'powermail'        => '2.1.0-0.0.0',
        ),
    ),
);
