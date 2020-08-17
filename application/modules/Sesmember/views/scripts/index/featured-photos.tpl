<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmember
 * @package    Sesmember
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: featured-photos.tpl 2016-05-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesmember/externals/styles/styles.css'); 
$sesalbumenabled = Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesalbum');
?> 
<div class="sesbasic_sidebar_block sesmember_featured_photos_block sesbasic_bxs sesbasic_clearfix">
  <?php if(count($this->photos) == 1):?>
    <?php $classnumber = 1;?>
  <?php elseif(count($this->photos) == 2):?>
    <?php $classnumber = 2;?>
  <?php elseif(count($this->photos) == 3):?>
    <?php $classnumber = 3;?>
  <?php elseif(count($this->photos) == 4):?>
    <?php $classnumber = 4;?>
  <?php elseif(count($this->photos) == 5):?>
    <?php $classnumber = 5;?>
  <?php endif;?>
  <div class="sesmember_featured_photos_block_photos sm_f_photo<?php echo $classnumber?>">
    <?php foreach($this->photos as $photo):
    	$photo = Engine_Api::_()->getItem('photo',$photo->photo_id);
      if(!$photo)
      	continue;
    ?>
      <div class="sesmember_featured_photos_block_item">
	  <?php if(!$sesalbumenabled){ ?>
				<a href="<?php echo $photo->getHref().'?featured=1'; ?>"><img src="<?php echo $photo->getPhotoUrl('thumb.normalmain');?>" alt=""></a>
      <?php }else{ ?>
      	<?php $imageURL = Engine_Api::_()->sesalbum()->getImageViewerHref($photo,array('status'=>'member-featured','limit'=>$limit)); ?>
      	<a class="ses-image-viewer" onclick="getRequestedAlbumPhotoForImageViewer('<?php echo $photo->getPhotoUrl(); ?>','<?php echo $imageURL	; ?>')" href="<?php echo Engine_Api::_()->sesalbum()->getHrefPhoto($photo->getIdentity(),$photo->album_id); ?>"><img src="<?php echo $photo->getPhotoUrl('thumb.normalmain');?>"></a>
      <?php } ?>
      </div>
    <?php  $limit++;endforeach;?>
  </div>
  <?php if(count($this->photos) < 1):?>
    <div class="sesmember_featured_photos_block_overlay"></div>
    <div class="sesmember_featured_photos_block_link">
      <a href="<?php echo $this->url(array('action'=>'featured-block'), 'sesmember_general'); ?>" class="sessmoothbox fa fa-picture-o"><?php echo $this->translate('Add Featured Photos'); ?></a>
    </div>
  <?php else:?>
    <a href="<?php echo $this->url(array('action'=>'featured-block', 'featured' => 1), 'sesmember_general'); ?>" class="sessmoothbox fa fa-pencil sesbasic_button sesmember_featured_photos_edit" title="<?php echo $this->translate('Edit Photos'); ?>"></a>
  <?php endif;?>
</div>