<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescontentcoverphoto
 * @package    Sescontentcoverphoto
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-06-020 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $getDesignType = Engine_Api::_()->sescontentcoverphoto()->getDesignType($this->id, $this->resource_type); ?>

<?php include APPLICATION_PATH .  '/application/modules/Sescontentcoverphoto/views/scripts/dismiss_message.tpl';?>

<script type="text/javascript">

  var moduleChange = function(resource_type) {
    var url = '<?php echo $this->url(array('resource_type' => null)) ?>';
    window.location.href = 'admin/sescontentcoverphoto/level/index/resource_type/' + resource_type+'/id/'+'<?php echo $this->id; ?>';
  }
  
  var fetchLevelSettings = function(level_id) {
    var url = '<?php echo $this->url(array('id' => null)) ?>';
    window.location.href = url + '/id/' + level_id;
  }
  
  window.addEvent('domready', function() {
    showDesigns('<?php echo $getDesignType; ?>');
  });
  
  function showDesigns(value) {
    var resource_type = '<?php echo $this->resource_type; ?>';
    if(value == 1 || value == 2) {
      if($('urpord_'+resource_type+'-wrapper'))
        $('urpord_'+resource_type+'-wrapper').style.display = 'none';
    } else {
      if($('urpord_'+resource_type+'-wrapper'))
        $('urpord_'+resource_type+'-wrapper').style.display = 'block';
    }
  }
  
</script>
<div class="settings sesbasic_admin_form">
  <div class='settings'>
    <?php echo $this->form->render($this) ?>
  </div>
</div>
