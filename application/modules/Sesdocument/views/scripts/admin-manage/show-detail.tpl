
<div class="sesbasic_view_stats_popup">
  <div class="sesbasic_view_popup_con">
    <?php $pageItem = Engine_Api::_()->getItem('sesdocument', $this->claimItem->sesdocument_id);?>
    <?php $userItem = Engine_Api::_()->getItem('user', $this->claimItem->user_id);?>
    <div class="sesbasic_popup_img_page">
      <p class="popup_img"><?php echo $this->itemPhoto($pageItem, 'thumb.profile') ?></p>
      <p class="popup_title"><?php echo $pageItem->getTitle();?></p>
    	<p class="owner_title"><b>Page Owner :</b><span class="owner_des"><?php echo $pageItem->getOwner()->getTitle();?></span></p>
			 
    </div>
    <div class="sesbasic_popup_owner_page">
      <p class="owner_title"><b>Reason for Claim:</b></p>
      <p class="owner_des"><?php echo $this->claimItem->description;?></p>
    </div>
  </div>
</div>
