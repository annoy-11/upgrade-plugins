
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Estore/externals/styles/styles.css'); ?>

<div class="sesbasic_sidebar_block estore_photo_block estore_review_owner_photo sesbasic_clearfix">
  <?php echo $this->htmlLink($this->item->getHref(), $this->itemPhoto($this->item, 'thumb.profile')); ?>
  <?php if($this->title): ?>
    <span class="clear">
      <?php echo $this->htmlLink($this->item->getOwner(), $this->item->getOwner()) ?>
    </span>
  <?php endif; ?>
</div>
