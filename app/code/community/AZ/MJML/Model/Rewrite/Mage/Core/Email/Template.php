<?php

class AZ_MJML_Model_Rewrite_Mage_Core_Email_Template extends Mage_Core_Model_Email_Template
{
    public function getPreparedTemplateText($html = null)
    {
        if ($this->isMJMLTemplate()) {
            $compiled = $this->getCompiledMJMLTemplateText($html);
            if (!empty($compiled)) {
                $html = $compiled;
            }
        }

        return parent::getPreparedTemplateText($html);
    }

    protected function isMJMLTemplate()
    {
        $templateText = $this->getTemplateText();
        return strstr($templateText, '<mjml>');
    }

    protected function getCompiledMJMLTemplateText($mjml)
    {
        return $this->getMJMLCompiler()->compile($mjml);
    }

    /**
     * @return AZ_MJML_Helper_Compiler
     */
    protected function getMJMLCompiler()
    {
        return Mage::helper('az_mjml/compiler');
    }
}
