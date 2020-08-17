<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Seseventspeaker
 * @package    Seseventspeaker
 * @copyright  Copyright 2018-2017 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: add-speaker.tpl 2017-03-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>

<?php $this->headScript()->appendFile("https://maps.googleapis.com/maps/api/js?libraries=places&sensor=true"); ?>
<?php include APPLICATION_PATH .  '/application/modules/Sesevent/views/scripts/dismiss_message.tpl';?>


<div class='sesbasic-form sesbasic-categories-form'>
  <div>
    <?php if( count($this->subNavigation) ): ?>
      <div class='sesbasic-admin-sub-tabs'>
        <?php echo $this->navigation()->menu()->setContainer($this->subNavigation)->render();?>
      </div>
    <?php endif; ?>
    <div class='sesbasic-form-cont'>
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'seseventspeaker', 'controller' => 'speaker', 'action' => 'index'), $this->translate("Back to Manage Speakers"), array('class'=>'sesbasic_icon_back buttonlink')) ?>
      <br class="clear" /><br />
      <div class='settings sesbasic_admin_form'>
        <?php echo $this->form->render($this) ?>
      </div>
		</div>
  </div>
</div>


<script type="text/javascript">
  en4.core.runonce.add(function() {
    if (document.getElementById('location')) {
      new google.maps.places.Autocomplete(document.getElementById('location'));
    }
  });
</script>