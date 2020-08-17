<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslike
 * @package    Seslike
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AddModules.php  2018-12-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Seslike_Form_Admin_AddModules extends Engine_Form {

  public function init() {

    $this->setTitle('Integrate New Plugin')
            ->setDescription('Here, you can configure the required details for the plugin to be integrated.');
    $integrateothermoduleId = Zend_Controller_Front::getInstance()->getRequest()->getParam('integrateothermodule_id', 0);
    if (!$integrateothermoduleId) {
      $integrateothermoduleItem = array();
      $integrateothermoduleArray = array();
      $integrateothermoduleArray[] = '';
			//get all enabled modules
      $coreTable = Engine_Api::_()->getDbTable('modules', 'core');
      $select = $coreTable->select()
              ->from($coreTable->info('name'), array('name', 'title'))
              ->where('name NOT IN (?)', array('activity', 'advancedsearch', 'album',  'announcement','authorization','blog','chat','classified','core','event', 'exhibition','exhibitionjoinfees','exhibitionjurymember','exhibitionpackage','fields','forum','group','invite', 'messages', 'mobi','music','network','otpsms','payment','poll','sesadvancedactivity','sesadvancedbanner', 'sesadvancedcomment','sesadvancedheader','sesadvsitenotification','sesalbum','sesapi','sesariana','sesarticle', 'sesatoz', 'sesautoaction','sesavatar','sesbasic','sesblog','sesbody','sesbrowserpush','sesbusiness', 'sesbusinesspackage', 'sesbusinessteam','sesbusinessurl','sesbusinessveroth','sesbusinessvideo','seschristmas', 'sescommunityads','sescompany','sescontentcoverphoto','sescontest','sescontestjoinfees','sescontestjurymember','sescontestpackage','sescusdash','sesdbslide','sesdemo','sesdemouser','sesemailverification','sesemoji','seserror', 'sesevent','seseventmusic','seseventpdfticket','seseventreview','seseventticket','seseventvideo','sesexpose','sesfaq','sesfeedbg','sesfeedgif','sesfeelingactivity','sesfooter','sesgdpr','sesgroup','sesgrouppackage','sesgrouppoll','sesgroupteam','sesgroupurl','sesgroupveroth','sesgroupvideo','seshtmlbackground','sesiosapp','seslangtranslator','sesletteravatar','seslike','seslisting','sesmediaimporter','sesmember','sesmembershipswitch','sesmembershorturl', 'sesmemveroth','sesmetatag','sesminify','sesmultiplecurrency','sesmultipleform','sesmusic','sesnewsletter', 'sespage','sespagebuilder','sespagepackage','sespagepoll','sespagereview','sespageteam','sespageurl', 'sespageveroth','sespagevideo','sespoke','sesprayer','sesprofilelock','sespwa','sespymk','sesqa','sesquote','sesrecipe','sesshortcut','sesshoutbox','sessiteiframe','sessociallogin','sessocialshare','sessoundcloudsearch','sesspectromedia','sesteam','sestestimonial','sesthought','sestour','sestutorial','sestweet','sesusercoverphoto','sesusercovervideo','sesvideo','sesvideoimporter','sesweather','seswishe','storage','user','video'))
              ->where('enabled =?', 1)
              ->where('type =?', 'extra');
      $resultsArray = $select->query()->fetchAll();
      if (!empty($resultsArray)) {
        foreach ($resultsArray as $result) {
          $integrateothermoduleArray[$result['name']] = $result['title'];
        }
      }
      if (!empty($integrateothermoduleArray)) {
        $this->addElement('Select', 'module_name', array(
            'label' => 'Choose Plugin',
            'description' => 'Below, you can choose the plugin to be integrated.',
            'allowEmpty' => false,
            'onchange' => 'changemodule(this.value)',
            'multiOptions' => $integrateothermoduleArray,
        ));
      } else {
        $description = "<div class='tip'><span>" . Zend_Registry::get('Zend_Translate')->_("Here are no module to configure with our plugin lightbox.") . "</span></div>";
        $this->addElement('Dummy', 'module', array(
            'description' => $description,
        ));
        $this->module->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));
      }
      $module = Zend_Controller_Front::getInstance()->getRequest()->getParam('module_name', null);
      if (!empty($module)) {
        $this->module_name->setValue($module);
				//get manifest item for given module
        $integrateothermodule = Engine_Api::_()->seslike()->getPluginItem($module);
        if (empty($integrateothermodule))
          $this->addElement('Dummy', 'dummy_title', array(
              'description' => 'No item type define for this plugin.',
          ));
      }
    }
		$param = false;
    if (@$integrateothermoduleId)
      $param = true;
    elseif (@$integrateothermodule)
      $param = true;
    if ($param) {
      if (!$integrateothermoduleId) {
        $this->addElement('Select', 'content_type', array(
            'label' => 'Item Type of Plugin',
            'description' => 'Select the item type of the above chosen plugin which is defined in its manifest.php file. [This item type is the parent to which albums are associated. For example for groups in SocialEngine Groups plugin, simply choose "groups".]',
            'multiOptions' => $integrateothermodule,
        ));
      }

      $this->addElement('Text', "module_title", array(
          'label' => 'Module Title',
          'description' => 'Enter Module Title',
          'allowEmpty' => false,
          'required' => true,
          'value' => '',
      ));


      $this->addElement('Checkbox', 'enabled', array(
          'description' => 'Enable This Plugin?',
          'label' => 'Yes, enable this plugin now.',
          'value' => 1,
      ));
      $this->addElement('Button', 'execute', array(
          'label' => 'Add Plugin',
          'type' => 'submit',
          'ignore' => true,
          'decorators' => array('ViewHelper'),
      ));
      $this->addElement('Cancel', 'cancel', array(
          'label' => 'Cancel',
          'prependText' => ' or ',
          'ignore' => true,
          'link' => true,
          'href' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'index')),
          'decorators' => array('ViewHelper'),
      ));
    }
  }
}
