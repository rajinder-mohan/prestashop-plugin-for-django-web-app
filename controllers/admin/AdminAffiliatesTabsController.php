<?php
class AdminAffiliatesTabsController extends ModuleAdminController
{

    public function initContent()
    {
        parent::initContent();
        $tpl_path = _PS_MODULE_DIR_ .'ps_fashioncircle/views/templates/admin/affiliatestabs/MyTab.tpl';
        $data = $this->context->smarty->createTemplate($tpl_path, $this->context->smarty);
    }
}
