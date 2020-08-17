<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Advancedsearch
 * @package    Advancedsearch
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: add.tpl  2018-12-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Advancedsearch/views/scripts/dismiss_message.tpl';?>
<div class="sesbasic_advancedsearch_result">
    <a href="<?php echo $this->url(array('module'=>'advancedsearch','controller'=>'settings','action'=>'manage'),'admin_default',true); ?>" class="buttonlink sesbasic_icon_back otpsms_icon_create">back to Manage Modules</a>
    <br /><br />
</div>
<div class='clear'>
    <div class='settings sesbasic_admin_form'>
<?php echo $this->form->render($this); ?>
    </div>
</div>
<script>
    function changemodule(modulename) {
        var type = '<?php echo $this->type ?>';
        window.location.href="<?php echo $this->url(array('module'=>'advancedsearch','controller'=>'settings', 'action'=>'add'),'admin_default',true)?>/module_name/"+modulename;
    }

</script>