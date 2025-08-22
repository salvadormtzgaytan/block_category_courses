<?php
defined('MOODLE_INTERNAL') || die();

$definitions = [
    'categorydata' => [
        'mode' => cache_store::MODE_APPLICATION,
        'simplekeys' => true,
        'simpledata' => false,
        'ttl' => 300,
        'staticacceleration' => true,
        'staticaccelerationsize' => 100,
    ],
];