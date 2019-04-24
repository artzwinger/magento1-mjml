<?php

class Onilab_MJML_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getCompiler()
    {
        return Mage::helper('onilab_mjml/compiler');
    }
}