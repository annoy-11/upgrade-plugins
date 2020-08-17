<?php ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesdocument/externals/styles/style.css'); ?>
<div class="sesdocument_gutter_main">
	<div class="_img">
  	<?php echo $this->htmlLink($this->item->getHref(), $this->itemPhoto($this->item, 'thumb.profile')) ?>
	</div>
<?php if($this->title): ?>
  <div class="_name">
    <?php echo $this->translate('%s', $this->item->getTitle()); ?>
  </div>
<?php endif; ?>
</div>
