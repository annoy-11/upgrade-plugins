<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessocialshare
 * @package    Sessocialshare
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: addmodule.tpl 2017-07-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php include APPLICATION_PATH .  '/application/modules/Sessocialshare/views/scripts/dismiss_message.tpl';?>

<?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sessocialshare', 'controller' => 'integrateothermodule', 'action' => 'index'), $this->translate("Sharing of Site Content in Feeds"), array('class'=>'sesbasic_icon_back buttonlink')) ?>
<br style="clear:both;" /><br />
<div class='clear'>
  <div class='settings sesbasic_admin_form'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<script type="text/javascript">
 function changemodule(modulename) {
   var type = '<?php echo $this->type ?>';
   window.location.href="<?php echo $this->url(array('module'=>'sessocialshare','controller'=>'integrateothermodule', 'action'=>'addmodule'),'admin_default',true)?>/module_name/"+modulename + "/type/" +type;
 }
</script>