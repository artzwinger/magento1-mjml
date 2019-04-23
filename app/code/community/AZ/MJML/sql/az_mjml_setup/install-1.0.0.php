<?php

$installer = $this;
$installer->startSetup();

$magePath = Mage::getRoot();
$rootPath = realpath($magePath . '/..');
$cmd = 'npm install mjml';
$descriptors = [
    ['pipe', 'r'],
    ['pipe', 'w'],
    ['pipe', 'a']
];
$process = proc_open($cmd, $descriptors, $pipes, $rootPath);
stream_set_blocking($pipes[2], 0);

try {
    if (($error = stream_get_contents($pipes[2])) !== false) {
        throw new Exception('Can not install module AZ MJML: ' . $error);
    }
    stream_set_blocking($pipes[2], 1);

    $read = [
        $pipes[1], $pipes[2]
    ];
    $write = NULL;
    $except = NULL;

    do {
        if (false === ($rv = stream_select($read, $write, $except, 1, 0))) {
            throw new Exception('Can not install module AZ MJML: error in stream_select');
        } else if ($rv > 0) {
            foreach ($read as $readPipe) {
                if ($readPipe == $pipes[2]) {
                    Mage::throwException('Can not install module AZ MJML: can not install mjml npm package');
                    break;
                }
            }
            continue;
        }
        break;
    } while (true);
} catch (Exception $e) {
    Mage::logException($e);
}

proc_close($process);

$installer->endSetup();