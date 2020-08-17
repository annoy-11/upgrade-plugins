<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagevideo
 * @package    Sespagevideo
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: last-element-data.tpl 2018-07-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<div class="ses_ml_more_popup_container sesbasic_clearfix">
  	<div class="ses_ml_more_popup_lb">
    	<div class="ses_ml_more_popup_bh">
      	<i class="fa fa-file-image-o"></i>
        <?php $type = $this->type == 'pagevideo' ? 'Recent' : 'Popular'; ?>
      	<span><?php echo $this->translate($type." ".ucfirst(str_replace('sespagevideo_','',$this->type)).'s'); ?></span>
      </div>
      <div class="ses_ml_more_popup_bc sesbasic_clearfix">
      <?php 
      	 $albumItems = Engine_Api::_()->getItemTable('pagevideo')->getVideo(array('limit_data'=>6,'popularCol'=>'creation_date'),false); 
     	
       	foreach($albumItems as $albumItem){ ?>
          <?php $imageURL = Engine_Api::_()->sespagevideo()->getCustomLightboxHref($albumItem,array('type'=>$this->type,'item_id'=>$this->item_id)); ?>
      	<div class="ses_ml_more_popup_a_list sesbasic_clearfix">
        	<a class="ses-image-viewer" href="<?php echo $albumItem->getHref(); ?>" onclick="getRequestedVideoForImageViewer('<?php echo $albumItem->getPhotoUrl(); ?>','<?php echo $imageURL	; ?>','change')" >
        		<span class="ses_ml_more_popup_a_list_img" style="background-image:url(<?php echo $albumItem->getPhotoUrl('thumb.normalmain'); ?>);"></span>
            <span class="ses_ml_more_popup_a_list_title">
            	  <?php echo $this->string()->truncate($albumItem->getTitle(), 30) ; ?>
              <span class="ses_ml_more_popup_a_list_owner"><?php echo $this->translate('by').' '.$albumItem->getOwner()->getTitle(); ?></span>
             </span>
          </a>
        </div>
         <?php } ?>
      </div>
    </div>
    <div class="ses_ml_more_popup_rb">
    	<div class="ses_ml_more_popup_bh">
      	<i class="fa fa-picture-o"></i>
        <span><?php echo $this->translate("Popular Videos"); ?></span>
      </div>
      <div class="ses_ml_more_popup_bc sesbasic_clearfix">
      <?php  $videoItems = Engine_Api::_()->getDbTable('videos', 'sespagevideo')->getVideo(array('limit_data'=>9,'popularCol'=>'view_count'),false); 
        $count = 1;
        foreach($videoItems as $videoItem){ 
      ?>
      <?php $imageURL = $videoItem->getHref(); ?>
        <a onclick="getRequestedVideoForImageViewer('<?php echo $videoItem->getPhotoUrl(); ?>','<?php echo $imageURL	; ?>','change')" href="<?php echo $imageURL	; ?>" class="ses_ml_more_popup_photo_list ses-image-viewer "><span style="background-image:url(<?php echo $videoItem->getPhotoUrl('thumb.normalmain'); ?>);"></span></a>
    <?php 
      $count++;
    } ?>
      </div>
    </div>
  </div>
