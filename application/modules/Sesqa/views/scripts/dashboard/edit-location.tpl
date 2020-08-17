<?php

/**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Sesqa
 * @copyright  Copyright 2014-2020 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: edit-location.tpl 2016-07-23 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

?>
<?php //echo $this->partial('dashboard/left-bar.tpl', 'sesblog', array('blog' => $this->blog));	?>
<?php if(!$this->is_ajax) {
  echo $this->partial('dashboard/left-bar.tpl', 'sesqa', array('question' => $this->question));	
?>
<div class="sesbasic_dashboard_content sesbm sesbasic_clearfix">
<?php }  ?>
	
  <div class="sesqa_edit_location_form sesbasic_dashboard_form sesbm sesbasic_clearfix sesbasic_bxs"><?php echo $this->form->render($this) ?></div>
  
<?php if(!$this->is_ajax) { ?>
	</div>
  </div>
<?php } ?>


<script type="application/javascript">

	<?php 
$optionsenableglotion = unserialize(Engine_Api::_()->getApi('settings', 'core')->getSetting('optionsenableglotion','a:6:{i:0;s:7:"country";i:1;s:5:"state";i:2;s:4:"city";i:3;s:3:"zip";i:4;s:3:"lat";i:5;s:3:"lng";}'));

if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesqa_enable_location', 1)){ ?>
  sesJqueryObject(document).ready(function(){
    <?php if(!in_array('lat', $optionsenableglotion)) { ?>
      sesJqueryObject('#lat-wrapper').css('display' , 'none');
    <?php } ?>
    <?php if(!in_array('lng', $optionsenableglotion)) { ?>
      sesJqueryObject('#lng-wrapper').css('display' , 'none');
    <?php } ?>
    <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1)) { ?>
      sesJqueryObject('#lat-wrapper').css('display' , 'none');
      sesJqueryObject('#lng-wrapper').css('display' , 'none');
    <?php } ?>
    sesJqueryObject('#mapcanvas-element').attr('id','map-canvas');
    sesJqueryObject('#map-canvas').css('height','200px');
    sesJqueryObject('#map-canvas').css('width','500px');
    sesJqueryObject('#mapcanvas-wrapper').css('display' , 'none');
    sesJqueryObject('#ses_location-label').attr('id','ses_location_data_list');
    sesJqueryObject('#ses_location_data_list').html("<?php echo isset($_POST['location']) ? $_POST['location'] : '' ; ?>");
    sesJqueryObject('#ses_location-wrapper').css('display','none');
    <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1)) { ?>
    initializeSesQaMap();
    <?php } ?>
  });
  <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1)) { ?>
  sesJqueryObject( window ).load(function() {
    editMarkerOnMapSesqaEdit();
  });
  <?php } ?>
<?php } ?>

</script>
