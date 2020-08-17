<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesdocument/externals/scripts/core.js');?>
<?php if (!empty($this->viewer_id) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdocuments.enable.favourite', 1)): ?>
  <?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'sesdocument')->isFavourite(array('resource_type'=>'sesdocument','resource_id'=>$this->sesdocument->sesdocument_id)); ?>
  <div class="sesdocument_button">
    <a href="javascript:;" data-url="<?php echo $this->sesdocument->sesdocument_id ; ?>" class="sesbasic_animation sesbasic_link_btn  sesdocument_favourite_sesdocument_document_<?php echo $this->sesdocument->sesdocument_id ?> sesbasic_icon_fav_btn sesdocument_favourite_sesdocument_document_view <?php echo ($favStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-heart"></i><span><?php if($favStatus):?><?php echo $this->translate('Un-Favourite');?><?php else:?><?php echo $this->translate('Favourite');?><?php endif;?></span></a>
  </div>
<?php endif; ?>
