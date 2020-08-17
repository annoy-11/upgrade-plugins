<?php

?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Seslink/externals/styles/styles.css'); ?>
<div class="seslinks_item_view sesbasic_bxs">
	<header class="sesbasic_clearfix">	
    <div class="_photo">
    	<?php echo $this->htmlLink($this->owner->getHref(), $this->itemPhoto($this->owner, 'thumb.icon', $this->owner->getTitle())) ?>
    </div>
    <div class="_info">
      <p class="name"><?php echo $this->htmlLink($this->owner->getHref(), $this->owner->getTitle()) ?></p>
      <p class="sesbasic_text_light _date">
      	<span><?php echo $this->translate("Posted")?><?php echo $this->timestamp($this->link->creation_date) ?></span>
        <span>|</span>
        <span>
          <i class="fa fa fa-thumbs-up"></i>
          <span> <?php echo $this->translate(array('%s like', '%s likes', $this->link->like_count), $this->locale()->toNumber($this->link->like_count)) ?></span>
        </span>
        <span>
          <i class="fa fa fa-comment"></i>
          <span><?php echo $this->translate(array('%s comment', '%s comments', $this->link->comment_count), $this->locale()->toNumber($this->link->comment_count)) ?></span>
        </span>
        <span>
          <i class="fa fa fa-eye"></i>
          <span><?php echo $this->translate(array('%s view', '%s views', $this->link->view_count), $this->locale()->toNumber($this->link->view_count)) ?></span>
        </span>
        <?php if(0) { ?>
          <span>|</span>
          <span>
          	<i class="fa fa-folder-open"></i>
            <span>
              <?php $category = Engine_Api::_()->getItem('seslink_category', $this->link->category_id); ?>
              <a href="<?php echo $this->url(array('action' => 'index'), 'seslink_general').'?category_id='.$this->link->category_id; ?>"><?php echo $category->category_name; ?></a>
              <?php if($this->link->subcat_id) { ?>
                &nbsp;&raquo;
                <?php $subcategory = Engine_Api::_()->getItem('seslink_category', $this->link->subcat_id); ?>
                <a href="<?php echo $this->url(array('action' => 'index'), 'seslink_general').'?category_id='.$this->link->category_id.'&subcat_id='.$this->link->subcat_id; ?>"><?php echo $subcategory->category_name; ?></a>
              <?php } ?>
              <?php if($this->link->subsubcat_id) { ?>
                &nbsp;&raquo;
                <?php $subsubcategory = Engine_Api::_()->getItem('seslink_category', $this->link->subsubcat_id); ?>
                <a href="<?php echo $this->url(array('action' => 'index'), 'seslink_general').'?category_id='.$this->link->category_id.'&subcat_id='.$this->link->subcat_id.'&subsubcat_id='.$this->link->subsubcat_id; ?>"><?php echo $subsubcategory->category_name; ?></a>
              <?php } ?>
            </span>
          </span>
        <?php } ?>
      </p>  
    </div>
  </header>
  <section class="_cont">
    <h2 class="_title">
      <?php echo $this->link->getTitle() ?>
    </h2>
    <div class="_body sesbasic_html_block">
      <?php echo $this->link->body ?>
    </div>
  </section>
  <div class="_footer sesbasic_clearfix">
    <?php if (count($this->linkTags )):?>
      <div class="_tags">
        <?php foreach ($this->linkTags as $tag): ?>
          <a href='javascript:void(0);' onclick='javascript:tagAction(<?php echo $tag->getTag()->tag_id; ?>);'>#<?php echo $tag->getTag()->text?></a>&nbsp;
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
    <div class="_options">
      <?php if($this->viewer_id):?>
        <a href="<?php echo $this->url(array("module" => "activity","controller" => "index","action" => "share", "type" => $this->link->getType(), "id" => $this->link->getIdentity(), "format" => "smoothbox"), 'default', true);?>" class="smoothbox sesbasic_icon_share"><?php echo $this->translate('Share');?></a>
    <?php endif;?>
    <?php if($this->viewer_id && $this->viewer_id != $this->link->owner_id):?>
      <a href="<?php echo $this->url(array("module" => "core","controller" => "report","action" => "create", 'subject' => $this->link->getGuid()),'default', true);?>" class="smoothbox sesbasic_icon_report"><?php echo $this->translate('Report');?></a>
    <?php endif;?>
      <?php if( $this->mine || $this->canEdit ): ?>
        <?php echo $this->htmlLink(array('route' => 'seslink_specific', 'action' => 'edit', 'link_id' => $this->link->link_id), $this->translate('Edit Link'), array(
          'class' => 'buttonlink sesbasic_icon_edit'
        )) ?>
        <?php echo $this->htmlLink(array('route' => 'seslink_specific', 'action' => 'delete', 'link_id' => $this->link->link_id, 'format' => 'smoothbox'), $this->translate('Delete Link'), array(
          'class' => 'buttonlink smoothbox sesbasic_icon_delete'
        )) ?>
      <?php endif;?>
    </div>
  </div>
</div>
<script type="text/javascript">
	function tagAction(tag_id){
		window.location.href = '<?php echo $this->url(array("action"=>"index"),"seslink_general",true); ?>'+'?tag_id='+tag_id;
	}
  $$('.core_main_seslink').getParent().addClass('active');
</script>