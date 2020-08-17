<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesdocument/externals/scripts/core.js');?>
<?php if (!empty($this->viewer_id)): ?>
  <?php      
  $likeUser = Engine_Api::_()->sesbasic()->getLikeStatus($this->subject->sesdocument_id, 'sesdocument');
  $likeClass = (!$likeUser) ? 'fa-thumbs-up' : 'fa-thumbs-down' ;
  $likeText = ($likeUser) ?  $this->translate('Unlike') : $this->translate('Like') ;
   $LikeStatus = Engine_Api::_()->sesbasic()->getLikeStatus($this->subject->sesdocument_id,$this->subject->getType());
         
  ?>
  <div class="sesdocument_button">
    <a href="javascript:;" data-url="<?php echo $this->subject->sesdocument_id ; ?>" class="sesbasic_animation sesbasic_link_btn sesdocument_like_sesdocument_document_view  sesdocument_like_sesdocument_document_<?php echo $this->subject->sesdocument_id ?> sesdocument_like_sesdocument_document_view"><i class="fa <?php echo $likeClass;?>"></i><span>Like</span></a>
  </div>
<?php endif; ?>
