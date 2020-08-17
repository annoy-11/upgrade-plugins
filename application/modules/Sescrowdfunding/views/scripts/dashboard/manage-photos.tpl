<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manage-photos.tpl  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php if(!$this->is_ajax){ ?>
  <?php echo $this->partial('dashboard/left-bar.tpl', 'sescrowdfunding', array('crowdfunding' => $this->crowdfunding)); ?>
  <div class="sescrowdfunding_dashboard_content sesbm sesbasic_clearfix">
<?php } ?>
<div class="sescf_dashboard_manage_photos sesbasic_bxs sesbasic_clearfix">
	<div class="sescrowdfunding_dashboard_content_header">
  	<h3><?php echo $this->translate("Manage Campaign Photos"); ?></h3>
  </div>
  <div class="sescf_dashboard_manage_btn">
		<?php echo $this->htmlLink(array('route' => 'sescrowdfunding_album_specific', 'action' => 'upload', 'album_id' => $this->album->album_id, 'crowdfunding_id' => $this->crowdfunding->crowdfunding_id), $this->translate('Add More Photos'), array('class' => 'sesbasic_button cescf_photo_icon cescf_ic_btn')); ?>
  </div>
	<?php if( $this->paginator->count() > 0 ): ?>
		<?php echo $this->paginationControl($this->paginator); ?>
	<?php endif; ?>
	<form action="<?php echo $this->escape($this->form->getAction()) ?>" method="<?php echo $this->escape($this->form->getMethod()) ?>">
		<?php echo $this->form->album_id; ?>
		<ul class='sescf_dashboard_manage_photos_list sesbasic_clearfix'>
			<?php foreach( $this->paginator as $photo ): ?>
				<li>
        	<div class="sesbasic_clearfix">
            <div class="sescf_dashboard_manage_photos_list_photo">
              <?php echo $this->itemPhoto($photo, 'thumb.main');  ?>
            </div>
            <div class="sescf_dashboard_manage_photos_list_info">
              <?php
                $key = $photo->getGuid();
                echo $this->form->getSubForm($key)->render($this);
              ?>
              <!--<div class="sescf_editphotos_cover">
                <input type="radio" name="cover" value="<?php //echo $photo->getIdentity() ?>" <?php //if( $this->album->photo_id == $photo->getIdentity() ): ?> checked="checked"<?php //endif; ?> />
                <label><?php //echo $this->translate('Album Cover');?></label>
              </div>-->
            </div>
          </div>
				</li>
			<?php endforeach; ?>
		</ul>
		<?php echo $this->form->submit->render(); ?>
	</form>
	<?php if( $this->paginator->count() > 0 ): ?>
		<br />
		<?php echo $this->paginationControl($this->paginator); ?>
	<?php endif; ?>
</div>
<?php if(!$this->is_ajax){ ?>
  		</div>
  	</div>
  </div>
<?php } ?>