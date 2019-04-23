<?php

class AZ_MJML_Model_Rewrite_Mage_Core_Email_Template extends Mage_Core_Model_Email_Template
{
    public function getPreparedTemplateText($html = null)
    {
        if ($this->isMJMLTemplate()) {
            $compiled = $this->getCompiledMJMLTemplateText();
            if ($compiled) {
                return $compiled;
            }
        }

        return parent::getPreparedTemplateText($html);
    }

    public function setTemplateText($templateText)
    {
        $this->setData('template_text', $templateText);
        if ($this->isMJMLTemplate()) {
            $compiled = $this->getCompiledMJMLTemplateText();
            if ($compiled) {
                $this->setData('template_text', $compiled);
            }
        }
    }

    protected function isMJMLTemplate()
    {
        $templateText = $this->getTemplateText();
        return strstr($templateText, '<mjml>');
    }

    protected function getCompiledMJMLTemplateText()
    {
        return $this->getMJMLCompiler()->compile($this->getTemplateText());
    }

    /**
     * @return AZ_MJML_Helper_Compiler
     */
    protected function getMJMLCompiler()
    {
        return Mage::helper('az_mjml/compiler');
    }
}