<?php

require_once __DIR__.'/vendor/autoload.php';

use SLLH\StyleCIBridge\ConfigBridge;

$header = <<<EOF
This file is part of the Nexylan packages.

(c) Nexylan SAS <contact@nexylan.com>

For the full copyright and license information, please view the LICENSE
file that was distributed with this source code.
EOF;

$config = ConfigBridge::create();

return $config
    ->setUsingCache(true)
    ->setRules(array_merge($config->getRules(), array(
        'header_comment' => array('header' => $header)
    )))
;
