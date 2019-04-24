<?php

class Onilab_MJML_Helper_Compiler extends Mage_Core_Helper_Abstract
{
    public function compile($mjmlContent)
    {
        $cmd = $this->getMjmlBinPath() . ' --stdin --stdout ';

        $descriptors = [
            ['pipe', 'r'],
            ['pipe', 'w'],
            ['file', Mage::getBaseDir('log') . '/mjml-compiler-errors.log', 'a']
        ];

        $process = proc_open($cmd, $descriptors, $pipes, $this->getRootPath());

        fwrite($pipes[0], $mjmlContent);
        fclose($pipes[0]);

        $compiledContent = stream_get_contents($pipes[1]);
        fclose($pipes[1]);

        proc_close($process);

        return $compiledContent;
    }

    protected function getRootPath()
    {
        return realpath(Mage::getRoot() . '/..');
    }

    protected function getNodeModulesPath()
    {
        return $this->getRootPath() . '/node_modules';
    }

    protected function getMjmlBinPath()
    {
        return $this->getNodeModulesPath() . '/.bin/mjml';
    }
}