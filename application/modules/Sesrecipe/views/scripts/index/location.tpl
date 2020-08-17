<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesrecipe
 * @package    Sesrecipe
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: location.tpl 2018-05-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<div class="sesrecipe_edit_location_popup">
  <?php echo $this->form->render($this) ?>
</div>
<script type="text/javascript">
  $('lat-wrapper').style.display = 'none';
  $('lng-wrapper').style.display = 'none';
  sesJqueryObject('#mapcanvas-label').attr('id','map-canvas-list');
  sesJqueryObject('#map-canvas-list').css('height','200px');
  sesJqueryObject('#ses_location-label').attr('id','ses_location_data_list');
  sesJqueryObject('#ses_location_data_list').html('<?php echo $this->recipe->location; ?>');
  sesJqueryObject('#ses_location-wrapper').css('display','none');
  <?php if($this->type == 'recipe_location'){ ?>
    sesJqueryObject('#location-wrapper').hide();
    sesJqueryObject('#execute').hide();
    sesJqueryObject('#or_content').hide();
    sesJqueryObject('#location-form').find('div').find('div').find('h3').hide();
    sesJqueryObject('#cancel').replaceWith('<button name="cancel" id="cancel" type="button" href="javascript:void(0);" onclick="parent.Smoothbox.close();">'+en4.core.language.translate('Close')+'</button>');
  <?php } ?>
  initializeSesRecipeMapList();
  sesJqueryObject( window ).load(function() {
    editSetMarkerOnMapListRecipe();
  });
</script>