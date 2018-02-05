<?php
/*
* 2007-2015 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2015 PrestaShop SA

*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/
// ini_set('display_startup_errors', 1);
// ini_set('display_errors', 1);
// error_reporting(-1);
if (!defined('_PS_VERSION_')) {
    exit;
}

// use PrestaShop\PrestaShop\Core\Module\WidgetInterface;

// require_once _PS_MODULE_DIR_.'ps_hotspot/classes/HotSpot.php';

class Ps_Fashioncircle extends Module
{
    private $templateFile;
     public $html = '';

    public function __construct()
    {
        $this->name = 'ps_fashioncircle';
        $this->author = 'PrestaShop';
        $this->version = '1.0.5';
        $this->need_instance = 0;
        $this->secure_key = Tools::encrypt($this->name);
        $this->bootstrap = true;
        parent::__construct();

        $this->displayName = $this->l('Fashioncircle Vendor blocks');
        $this->description = $this->l('Integrates Fashioncircle Vendor blocks');

        $this->ps_versions_compliancy = array('min' => '1.6.0.0', 'max' => _PS_VERSION_);

        // $this->templateFile = 'module:ps_fashioncircle/ps_fashioncircle.tpl';

    }

    public function install()
    {
      $parent_tab = new Tab();
      foreach (Language::getLanguages(true) as $lang)
          $parent_tab->name [$lang['id_lang']] = 'Fashion Circle';
      $parent_tab->class_name = 'Tab';
      $parent_tab->id_parent = 0;
      $parent_tab->module = $this->name;
      $parent_tab->add();
      if (!parent::install()
          || !$this->installModuleTab('AdminAffiliatesTabs', array((int)(Configuration::get('PS_LANG_DEFAULT'))=>'Fashion Circle'), $parent_tab->id)
      )
          return false;
      return true;
    }


    public function uninstall()
    {
      if (!parent::uninstall()
                  || !$this->uninstallModuleTab('Ps_Fashioncircle')
                  || !$this->uninstallModuleTab('AffiliatesTabsController'))
                  return false;
              return true;

    }
    private function installModuleTab($tabClass, $tabName, $idTabParent)
    {
        $idTab = Tab::getIdFromClassName($idTabParent);
        $idTab = $idTabParent;
        $pass = true ;
        @copy(_PS_MODULE_DIR_.$this->name.'/logo.gif', _PS_IMG_DIR_.'t/'.$tabClass.'.gif');
        $tab = new Tab();
        $tab->name = $tabName;
        $tab->class_name = $tabClass;
        $tab->module = $this->name;
        $tab->id_parent = $idTab;
        $pass = $tab->save();
        return($pass);
    }

    private function uninstallModuleTab($tabClass)
    {
        $pass = true ;
        @unlink(_PS_IMG_DIR_.'t/'.$tabClass.'.gif');
        $idTab = Tab::getIdFromClassName($tabClass);
        if($idTab != 0)
        {
            $tab = new Tab($idTab);
            $pass = $tab->delete();
        }
        return($pass);
    }
    // public function getContent()
    // {
    //    $id_shop =  $this->context->shop->id;
    //     // die();
    //      $this->html .= $this->headerHTML();
    //     $currentuserprofile = Context::getContext()->employee->id_profile;
    //
    //
    //
    //
    //      return $this->display(__FILE__, ' .tpl');
    //
    //     }else{
    //
    //             $output = '';
    //             $current_lan= $this->context->language->id;
    //             $tem = $_FILES;
    //
    //             if(!empty($tem)){
    //                 foreach ($tem as $key => $value) {
    //
    //
    //                     $hotspot_file = $_FILES[$key];
    //                     if( $hotspot_file['name'] != "" && $hotspot_file['size'] > 0)
    //                     {
    //
    //
    //                         //Formati accettati
    //                         $allowed = array('image/jpeg', 'image/jpg', 'image/png');
    //
    //                         //Controllo che l'immagine sia in un formato accettato
    //                         if( in_array($hotspot_file['type'], $allowed) )
    //                         {
    //
    //                             $path = dirname(__FILE__).DIRECTORY_SEPARATOR.'upload/';
    //
    //                             //Carico il file
    //                             // echo (move_uploaded_file($hotspot_file['tmp_name'], $path.$hotspot_file['name']));
    //                             if( ! move_uploaded_file($hotspot_file['tmp_name'], $path.$hotspot_file['name']) )
    //                             {
    //
    //
    //
    //                                 $output = $this->displayError( $path.$hotspot_file['name'] );
    //                                  return $this->html . $this->displayError($this->l('Image of this name is already exist.') . $this->renderForm());
    //                             }else{
    //
    //
    //
    //                                 $update = $this->processSaveCustomText();
    //
    //
    //                                 if ($update)  {
    //                                     $this->_clearCache($this->templateFile);
    //                                     $this->html .= $this->renderForm();
    //                                     $this->html .= $this->reservation_form();
    //                                     $this->html .= $this->renderList();
    //
    //                                    return $this->html;
    //                                     $_FILES = '';
    //                                     // exit;
    //                                 }else{
    //                                     $this->_clearCache($this->templateFile);
    //                                     // return $this->html . $this->renderForm();
    //                                 }
    //                             }
    //                         }
    //                         else
    //                         {
    //                             $output .= $this->displayError( $this->l('This formate is not allowed') );
    //                             $this->html .= $this->displayError($this->l('This formate is not allowed. Only jpg,jpeg,png are allowed.') . $this->renderForm());
    //                              $this->html .= $this->renderList();
    //                              return  $this->html;
    //
    //                         }
    //                     }
    //
    //                 }
    //
    //                 }else {
    //                     $this->html .= $this->renderForm();
    //                     $this->html .= $this->reservation_form();
    //                     $this->html .= $this->renderList();
    //                     return $this->html;
    //             }
    //         }
    //             $this->html .= $this->renderForm();
    //             return $this->html;
    // }

    // public function processSaveCustomText()
    // {
    //     $info = new FashionCircle();
    //     $images = $_FILES;
    //     $userid = Context::getContext()->employee;
    //     foreach ( $images as $key => $value) {
    //         if($_FILES[$key]['name'] !='' && $_FILES[$key]['size'] > 0 ){
    //             if(isset($_POST['checkBoxShopAsso_configuration'])){
    //                 foreach ($_POST['checkBoxShopAsso_configuration'] as $k => $value){
    //
    //                         $info = new FashionCircle();
    //                         $info->image = $_FILES[$key]['name'];
    //                         $info->id_shop = $k;
    //                         $info->user_id = $userid->id;
    //                         $saved = $info->add();
    //                         $res = Db::getInstance()->execute('INSERT INTO `'._DB_PREFIX_.'hotspot_position` (`id_hotspot`)
    //                         VALUES('.(int)$info->id.')'
    //                     );
    //
    //                     if(isset($_POST['reservation_type'])){
    //                         $result = Db::getInstance()->execute('INSERT INTO `'._DB_PREFIX_.'reservation_setting` (`reservation_type`,`duration`,`user_id`,`id_shop`)
    //                         VALUES("'.$_POST['reservation_type'].'",'.$_POST['reservation_value'].','.$userid->id.','.$k.')'
    //                         );
    //                     }
    //                 }
    //
    //             }else{
    //
    //                 $info = new FashionCircle();
    //                 $info->image = $_FILES[$key]['name'];
    //                 $info->id_shop =  $this->context->shop->id;
    //                 $info->user_id = $userid->id;
    //                 $saved = $info->add();
    //                 $res = Db::getInstance()->execute('INSERT INTO `'._DB_PREFIX_.'fashioncircle_position` (`id_fashioncircle`)
    //                     VALUES('.(int)$info->id.')'
    //                 );
    //                 // print_r($res);
    //                 // echo "--------------------";
    //                 // print_r($_POST);
    //                 // die();
    //                 // if(isset($_POST['reservation_type'])){
    //                 //     $result = Db::getInstance()->execute('INSERT INTO `'._DB_PREFIX_.'reservation_setting` (`reservation_type`,`duration`,`user_id`,`id_shop`)
    //                 //     VALUES("'.$_POST['reservation_type'].'",'.$_POST['reservation_value'].','.$userid->id.','.$this->context->shop->id.')'
    //
    //
    //                 //     );
    //
    //                 // }
    //
    //             }
    //         }
    //     }
    //     // exit();
    //     return $saved;
    // }
    //
    //
    // public function headerHTML()
    // {
    //     if (Tools::getValue('controller') != 'AdminModules' && Tools::getValue('configure') != $this->name)
    //         return;
    //
    //     $this->context->controller->addJqueryUI('ui.sortable');
    //     /* Style & js for fieldset 'slides configuration' */
    //     $html = '<script type="text/javascript">
    //         $(function() {
    //               $("#hours").click(function(){
    //
    //                 $("#reservation_value").attr("placeholder", "Hours");
    //
    //
    //
    //             });
    //
    //               $("#days").click(function(){
    //
    //                 $("#reservation_value").attr("placeholder", "Days");
    //
    //
    //
    //             });
    //
    //             var $mySlides = $("#slides");
    //             $mySlides.sortable({
    //                 opacity: 0.6,
    //                 cursor: "move",
    //                 update: function() {
    //                     var order = $(this).sortable("serialize") + "&action=updateSlidesPosition";
    //                     $.post("'.$this->context->shop->physical_uri.'modules/'.$this->name.'/ajax_'.$this->name.'.php?secure_key=ps_fashioncircle", order);
    //                     }
    //                 });
    //             $mySlides.hover(function() {
    //                 $(this).css("cursor","move");
    //                 },
    //                 function() {
    //                 $(this).css("cursor","auto");
    //             });
    //         });
    //     </script>';
    //
    //
    //
    //     return $html;
    // }
    //
    //
    // public function renderList()
    // {
    //     $slides = $this->getSlides();
    //     $currentuserprofile = Context::getContext()->employee->id_profile;
    //     $this->context->smarty->assign(
    //         array(
    //             'link' => $this->context->link,
    //             'slides' => $slides,
    //             'image_baseurl' => $this->_path.'upload/',
    //             'currentuserprofile'=>$currentuserprofile
    //         )
    //     );
    //
    //     return $this->display(__FILE__, 'list.tpl');
    // }



 //    protected function renderForm()
 //    {
 //        $default_lang = (int)Configuration::get('PS_LANG_DEFAULT');
 //
 //        $fields_form = array(
 //            'tinymce' => true,
 //            'legend' => array(
 //                'title' => $this->l('Fashion Circle block'),
 //            ),
 //            'input' => array(
 //                'id_hotspot' => array(
 //                    'type' => 'hidden',
 //                    'name' => 'id_hotspot'
 //                ),
 //                array(
 //                        'type' => 'file_lang',
 //                        'label' => $this->l('Top banner image'),
 //                        'name' => 'Hotspot_Img',
 //                        'desc' => $this->l('Upload an image for your top banner. The recommended dimensions are 1110 x 214px if you are using the default theme.'),
 //
 //                        'lang' => true,
 //                    ),
 //
 //
 //            ),
 //            'submit' => array(
 //                'title' => $this->l('Save'),
 //            ),
 //            'buttons' => array(
 //                array(
 //                    'href' => AdminController::$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules'),
 //                    'title' => $this->l('Back to list'),
 //                    'icon' => 'process-icon-back'
 //                )
 //            )
 //        );
 //        // echo "<pre>";
 //        // print_r(Shop::isFeatureActive());
 //        // die;
 //        if (Shop::isFeatureActive() && Tools::getValue('ps_fashioncircle') == false) {
 //            $fields_form['input'][] = array(
 //                'type' => 'shop',
 //                'label' => $this->l('Shop association'),
 //                'name' => 'checkBoxShopAsso_theme'
 //            );
 //        }
 //
 //          $this->initReservationForm();
 //
 //
 //        $helper = new HelperForm();
 //        $helper->module = $this;
 //        $helper->name_controller = 'ps_fashioncircle';
 //        $helper->identifier = $this->identifier;
 //        $helper->token = Tools::getAdminTokenLite('AdminModules');
 //        foreach (Language::getLanguages(false) as $lang) {
 //            $helper->languages[] = array(
 //                'id_lang' => $lang['id_lang'],
 //                'iso_code' => $lang['iso_code'],
 //                'name' => $lang['name'],
 //                'is_default' => ($default_lang == $lang['id_lang'] ? 1 : 0)
 //            );
 //        }
 //
 //        $helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;
 //        $helper->default_form_language = $default_lang;
 //        $helper->allow_employee_form_lang = $default_lang;
 //        $helper->toolbar_scroll = true;
 //        $helper->title = $this->displayName;
 //        $helper->submit_action = 'saveps_customtext';
 //
 //        // $helper->fields_value = $this->getFormValues();
 //
 //        return $helper->generateForm(array(array('form' => $fields_form)));
 //    }
 // protected function reservation_form()
 //    {
 //        $default_lang = (int)Configuration::get('PS_LANG_DEFAULT');
 //
 //        $fields_form1 = array(
 //            'tinymce' => true,
 //            'legend' => array(
 //                'title' => $this->l('Reserve block'),
 //            ),
 //            'input' => array(
 //                'id_hotspot1' => array(
 //                    'type' => 'hidden',
 //                    'name' => 'reservation_form'
 //                ),
 //                 array(
 //                        'type' => 'radio',
 //                        'label' => $this->l('Product Reserve Type'),
 //                        'name' => 'reservation_form',
 //                        'desc' => $this->l('Select reserve type in hours or day.'),
 //                        'required'  => true,
 //                        'values' => array(
 //                            array(
 //                                'id' => 'hours',
 //                                'name' => 'hours',
 //                                'value' => 'hours',
 //                                'label' => $this->l('Hours'),
 //
 //                            ),
 //                            array(
 //                                'id' => 'days',
 //                                'name' => 'days',
 //                                'value' => 'days',
 //                                'label' => $this->l('Days'),
 //
 //                            )
 //                        )
 //
 //                    ),
 //
 //                 array(
 //                        'id'=>'reservation_value',
 //                        'type' => 'text',
 //                        'name' => 'reservation_value',
 //                        'value' => 'reservation_value',
 //                        'desc' => $this->l('Fill the value according reserve type '),
 //
 //                    )
 //
 //            ),
 //            'submit' => array(
 //                'title' => $this->l('Save'),
 //            ),
 //            'buttons' => array(
 //                array(
 //                    'href' => AdminController::$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules'),
 //                    'title' => $this->l('Back to list'),
 //                    'icon' => 'process-icon-back'
 //                )
 //            )
 //        );
 //        // echo "<pre>";
 //        // print_r(Shop::isFeatureActive());
 //        // die;
 //        if (Shop::isFeatureActive() && Tools::getValue('id_hotspot1') == false) {
 //            $fields_form1['input'][] = array(
 //                'type' => 'shop',
 //                'label' => $this->l('Shop association'),
 //                'name' => 'checkBoxShopAsso_theme'
 //            );
 //        }
 //
 //          $this->initReservationForm();
 //
 //
 //        $helper = new HelperForm();
 //        $helper->module = $this;
 //        $helper->name_controller = 'ps_hotspot';
 //        $helper->identifier = $this->identifier;
 //        $helper->token = Tools::getAdminTokenLite('AdminModules');
 //        foreach (Language::getLanguages(false) as $lang) {
 //            $helper->languages[] = array(
 //                'id_lang' => $lang['id_lang'],
 //                'iso_code' => $lang['iso_code'],
 //                'name' => $lang['name'],
 //                'is_default' => ($default_lang == $lang['id_lang'] ? 1 : 0)
 //            );
 //        }
 //
 //        $helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;
 //        $helper->default_form_language = $default_lang;
 //        $helper->allow_employee_form_lang = $default_lang;
 //        $helper->toolbar_scroll = true;
 //        $helper->title = $this->displayName;
 //        $helper->value = $this->Name;
 //        // $helper->fields_value[''] = Configuration::get('reservation_form');
 //       // $helper->fields_value['hours'] ='hours';
 //       // $helper->fields_value['days'] ='days';
 //         $vv = $_POST['reservation_value'];
 //         $vv1 = $_POST['reservation_form'];
 //
 //       $helper->fields_value['reservation_value'] =$vv;
 //       $helper->fields_value['reservation_form'] =$vv1;
 //       // echo "<pre>";
 //       // print_r($helper);
 //       // die();
 //      $helper->submit_action = 'saveps_customtext';
 //
 //
 //        // $helper->fields_value = $this->getFormValues();
 //
 //        return $helper->generateForm(array(array('form' => $fields_form1)));
 //    }
 //
 //    public function initReservationForm(){
 //
 //
 //        $default_lang = (int)Configuration::get('PS_LANG_DEFAULT');
 //
 //        $fields_form = array(
 //            'tinymce' => true,
 //            'legend' => array(
 //                'title' => $this->l('Reservation Setting Block'),
 //            ),
 //            'input' => array(
 //                'id_reservation_setting' => array(
 //                    'type' => 'hidden',
 //                    'name' => 'id_reservation_setting'
 //                ),
 //                array(
 //                        'type' => 'radio',
 //                        'label' => $this->l('Reservation Type'),
 //                        'name' => 'reservation_type',
 //                        'desc' => $this->l('Select reserve type in hours or day.'),
 //                        'values' => array(
 //                            array(
 //                                'id' => 'smarty_force_compile_',
 //                                'value' => 'hours',
 //                                'label' => $this->l('Hours'),
 //
 //                            ),
 //                            array(
 //                                'id' => 'smarty_force_compile_'._PS_SMARTY_CHECK_COMPILE_,
 //                                'value' => 'days',
 //                                'label' => $this->l('Days'),
 //
 //                            )
 //                        )
 //
 //                    )
 //
 //            ),
 //            'submit' => array(
 //                'title' => $this->l('Save'),
 //            )
 //
 //        );
 //        // echo "<pre>";
 //        // print_r(Shop::isFeatureActive());
 //        // die;
 //        // if (Shop::isFeatureActive() && Tools::getValue('id') == false) {
 //        //     $fields_form['input'][] = array(
 //        //         'type' => 'shop',
 //        //         'label' => $this->l('Shop association'),
 //        //         'name' => 'checkBoxShopAsso_theme'
 //        //     );
 //        // }
 //
 //    }


    // public function getFormValues()
    // {
    //
    //     $fields_value = array();
    //     $id_hotspot = 1;
    //
    //     foreach (Language::getLanguages(false) as $lang) {
    //         $info = new HotSpot((int)$id_hotspot);
    //
    //         $fields_value['image'][(int)$lang['id_lang']] = $info->text[(int)$lang['id_lang']];
    //     }
    //
    //     $fields_value['ps_fashioncircle'] = $id_hotspot;
    //
    //
    //
    //     return $fields_value;
    // }
    //  public function hookdisplayHeader($params)
    // {
    //
    //
    //    $this->context->controller->addCSS($this->_path.'homeslider.css');
    //     $this->context->controller->addJS($this->_path.'js/homeslider.js');
    //     $this->context->controller->addJqueryPlugin(array('bxslider'));
    // }
    // public function hookDisplayHome()
    // {
    //
    //      $testst = $this->getWidgetVariables();
    //
    //      $this->smarty->assign('homeslider', $testst);
    //
    //    return $this->display(__FILE__, 'ps_fashioncircle.tpl', $this->getCacheId());
    // }
    // public function hookdisplayTop($params)
    //     {
    //         return $this->hookdisplayTopColumn($params);
      //   }
       //
      //   public function hookdisplayTopColumn($params)
      //   {
      //        $testst = $this->getWidgetVariables();
       //
      //    $this->smarty->assign('homeslider', $testst);
       //
      //  return $this->display(__FILE__, 'ps_fashioncircle.tpl', $this->getCacheId());
      //   }


    //
    // public function renderWidget($hookName = null, array $configuration = [])
    // {
    //     if (!$this->isCached($this->templateFile, $this->getCacheId('ps_fashioncircle'))) {
    //         $this->smarty->assign($this->getWidgetVariables($hookName, $configuration));
    //     }
    //
    //     return $this->fetch($this->templateFile, $this->getCacheId('ps_fashioncircle'));
    // }
  //   public function getWidgetVariables($hookName = null, array $configuration = [])
  //   {
   //
  //           $id_shop = $this->context->shop->id;
  //           $id_lang = $this->context->language->id;
  //           $slides = [];
   //
  //           $hotspotImage = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
  //                SELECT hs.`id_hotspot` as id_hotsopt, hsl.`image` FROM '._DB_PREFIX_.'hotspot hs LEFT JOIN '._DB_PREFIX_.'hotspot_lang hsl ON (hs.id_hotspot = hsl.id_hotspot) INNER JOIN '._DB_PREFIX_.'hotspot_position hsp ON (hs.id_hotspot = hsp.id_hotspot)  WHERE hs.`id_shop` ='.(int)$id_shop.' AND hsl.`id_lang`='.(int)$id_lang.' AND hsp.active = 1 ORDER BY hsp.position'
   //
  //           );
   //
   //
  //            foreach ($hotspotImage as $key => $value) {
   //
  //                $slides = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
  //                SELECT hs.`id_hotspot` as id_hotsopt, hsl.`image`, htag.* FROM '._DB_PREFIX_.'hotspot hs LEFT JOIN '._DB_PREFIX_.'hotspot_lang hsl ON (hs.id_hotspot = hsl.id_hotspot) LEFT JOIN '._DB_PREFIX_.'hotspot_tag htag ON (htag.id_hotspot = hsl.id_hotspot)INNER JOIN '._DB_PREFIX_.'hotspot_position hsp ON (hs.id_hotspot = hsp.id_hotspot) WHERE id_shop = '.(int)$id_shop.' AND hsl.`id_lang`='.(int)$id_lang.' AND hsp.active = 1 ORDER BY hsp.position'
  //               );
   //
   //
  //            }
   //
   //
  //           return $homeslider = array(
  //                           'speed' => 5000,
  //                           'pause' =>  'hover',
  //                           'wrap' => 'true' ,
  //                           'slides' => $slides,
  //                           'hotspotimages' => $hotspotImage,
  //                           'image_baseurl' => $this->_path.'upload/'
  //                       );
   //
  //           // return array(
  //           // 'hotspot_slide' => $slides
  //           // );
  //  }

//     public function installFixtures()
//     {
//         $return = true;
//         $tab_texts = array(
//             array(
//                 'text' => '<h3>Custom Text Block</h3>
// <p><strong class="dark">Lorem ipsum dolor sit amet conse ctetu</strong></p>
// <p>Sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit.</p>'
//             ),
//         );
//
//         $shops_ids = Shop::getShops(true, null, true);
//
//         foreach ($tab_texts as $tab) {
//             $info = new FashionCircle();
//             foreach (Language::getLanguages(false) as $lang) {
//                 $info->text[$lang['id_lang']] = $tab['text'];
//             }
//             foreach ($shops_ids as $id_shop) {
//                 $info->id_shop = $id_shop;
//                 $return &= $info->add();
//             }
//         }
//
//         return $return;
//     }
}
