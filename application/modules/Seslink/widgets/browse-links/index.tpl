<?php ?>

<?php 
  $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Seslink/externals/styles/styles.css');
  $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/wookmark.min.js');
?>
<?php if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesadvancedcomment')) { ?>
  <?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/mention/jquery.mentionsInput.css'); ?>    
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl .'application/modules/Sesbasic/externals/scripts/mention/underscore-min.js'); ?>
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl .'application/modules/Sesbasic/externals/scripts/mention/jquery.mentionsInput.js'); ?>
<?php } ?>
<?php $randonNumber = 2000; ?>

<?php if( $this->paginator->getTotalItemCount() > 0 ): ?>
	<div class="sesbasic_bxs sesbasic_clearfix">
    <ul class="prelative seslinks_listing sesbasic_pinboard_<?php echo $randonNumber ; ?>" style="min-height:50px;" id="tabbed-widget_<?php echo $randonNumber; ?>" >
      <?php foreach( $this->paginator as $item ): ?>
      
        <li class="seslinks_list_item new_image_pinboard_<?php echo $randonNumber; ?>" >
        	<section>
          	<header class="sesbasic_clearfix">
            	<div class="_owner_thumb">
              	<?php echo $this->htmlLink($item->getOwner()->getHref(), $this->itemPhoto($item->getOwner(), 'thumb.icon', $item->getOwner()->getTitle()), array('class' => '')) ?>
              </div>
              <?php if(in_array('postedby', $this->allParams['stats']) || in_array('posteddate', $this->allParams['stats'])): ?>
                <div class="_owner_info">
                  <?php if(in_array('postedby', $this->allParams['stats'])): ?>
                    <div class="_owner_name"><?php echo $this->htmlLink($item->getOwner()->getHref(), $item->getOwner()->getTitle()) ?></div>
                  <?php endif; ?>
                  <?php if(in_array('posteddate', $this->allParams['stats'])) : ?>
                    <div class="sesbasic_text_light _date">
                      <?php echo $this->translate('Posted');?>
                      <?php echo $this->timestamp(strtotime($item->creation_date)) ?>
                    </div>
                  <?php endif; ?>
                </div>
              <?php endif; ?>
            </header>
            <div class='_content'>
              <?php if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('seslink.show', 0)) { ?>
                <div class='_title'>
                  <?php echo $this->htmlLink($item->getHref(), $item->getTitle()) ?>
                </div>
              <?php } else { ?>
                <div class="_title seslink_text_popup">
                  <?php echo $this->htmlLink('javascript:;', $item->getTitle(), array('data-url'=>'seslink/index/link-popup/link_id/'.$item->getIdentity(),'class'=>'sessmoothbox')) ?>
                </div>
              <?php } ?>
              <div id="seslink_description_content_<?php echo $item->getIdentity(); ?>" class='sesbasic_html_block _des'>
                <?php echo $item->body; //$this->string()->truncate($this->string()->stripTags($item->body), 200) ?>
                <?php if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('seslink.show', 0)) { ?>
                  <a class="seslink_expand" href="<?php echo $item->getHref(); ?>" style="display:none;"><span><?php echo $this->translate('Expand'); ?></span></a>
                <?php } else { ?>
                  <a data-url='seslink/index/link-popup/link_id/<?php echo $item->getIdentity(); ?>' class="sessmoothbox seslink_expand" href="javascript:;" style="display:none;"><span><?php echo $this->translate('Expand'); ?></span></a>
                <?php } ?>
              </div>
              <?php $tags = $item->tags()->getTagMaps(); ?>
              <?php if (count($tags)):?>
                <div class="_tags">
                  <?php foreach ($tags as $tag): ?>
                    <a href='javascript:void(0);' onclick='javascript:tagAction(<?php echo $tag->getTag()->tag_id; ?>);'>#<?php echo $tag->getTag()->text?></a>&nbsp;
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>
              <?php if(in_array('likecount', $this->allParams['stats']) || in_array('commentcount', $this->allParams['stats']) || in_array('viewcount', $this->allParams['stats'])): ?>
                <div class="_stats sesbasic_text_light">
                  <?php if(in_array('likecount', $this->allParams['stats'])) { ?>
                    <span title="<?php echo $this->translate(array('%s Like', '%s Likes', $item->like_count), $this->locale()->toNumber($item->like_count)) ?>">
                      <i class="fa fa-thumbs-up"></i>
                      <span><?php echo $this->locale()->toNumber($item->like_count) ?></span>
                    </span>
                  <?php } ?>
                  <?php if(in_array('commentcount', $this->allParams['stats'])) { ?>
                    <span title="<?php echo $this->translate(array('%s Comment', '%s Comments', $item->comment_count), $this->locale()->toNumber($item->comment_count)) ?>">
                      <i class="fa fa-comment"></i>
                      <span><?php echo $this->locale()->toNumber($item->comment_count) ?></span>
                    </span>
                  <?php } ?>
                  <?php if(in_array('viewcount', $this->allParams['stats'])) { ?>
                    <span title="<?php echo $this->translate(array('%s View', '%s Views', $item->view_count), $this->locale()->toNumber($item->view_count)) ?>">
                      <i class="fa fa-eye"></i>
                      <span><?php echo $this->locale()->toNumber($item->view_count) ?></span>
                    </span>
                  <?php } ?>
                  <?php if(in_array('category', $this->allParams['stats'])) { ?>
                    <span>- 
                      <?php $category = Engine_Api::_()->getItem('seslink_category', $item->category_id); ?>
                      <a href="<?php echo $this->url(array('action' => 'index'), 'seslink_general').'?category_id='.$item->category_id; ?>"><?php echo $category->category_name; ?></a>
                    </span>
                  <?php } ?>
                  <?php if(in_array('permalink', $this->allParams['stats'])) { ?>
                    <span>- 
                      <?php if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('seslink.show', 0)) { ?>
                        <a href="<?php echo $item->getHref(); ?>"><?php echo $this->translate('Permalink'); ?></a>
                      <?php } else { ?>
                        <a data-url='seslink/index/link-popup/link_id/<?php echo $item->getIdentity(); ?>' class="sessmoothbox" href="javascript:;"><?php echo $this->translate('Permalink'); ?></a>
                      <?php } ?>
                    </span>
                  <?php } ?>
                </div>
              <?php endif; ?>
            </div>
          </section>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>

<?php elseif( $this->category || $this->show == 2 || $this->search ): ?>
  <div class="tip">
    <span>
      <?php echo $this->translate('Nobody has written a link entry with that criteria.');?>
      <?php if (TRUE): // @todo check if user is allowed to create a poll ?>
        <?php echo $this->translate('Be the first to %1$swrite%2$s one!', '<a class="smoothbox" href="'.$this->url(array('action' => 'create'), 'seslink_general').'">', '</a>'); ?>
      <?php endif; ?>
    </span>
  </div>

<?php else:?>
  <div class="tip">
    <span>
      <?php echo $this->translate('Nobody has written a link entry yet.'); ?>
      <?php if( $this->canCreate ): ?>
        <?php echo $this->translate('Be the first to %1$swrite%2$s one!', '<a class="smoothbox" href="'.$this->url(array('action' => 'create'), 'seslink_general').'">', '</a>'); ?>
      <?php endif; ?>
    </span>
  </div>
<?php endif; ?>

<?php echo $this->paginationControl($this->paginator, null, null, array('pageAsQuery' => true, 'query' => $this->formValues)); ?>

<script type="application/javascript">
 	
	function tagAction(tag_id){
		window.location.href = '<?php echo $this->url(array("action"=>"index"),"seslink_general",true); ?>'+'?tag_id='+tag_id;
	}
	
  sesJqueryObject(document).on('click', '.seslink_expand', function() {

    sesJqueryObject(this).parent().find('.sesbasic_html_block').css('max-height','none');
    //sesJqueryObject(this).hide();
    sesJqueryObject(this).closest('.seslinks_list_item').addClass('seslink_content_open');
    imageLoadedAll<?php echo $randonNumber ?>(1);
  });

  var wookmark = undefined;
  var wookmark<?php echo $randonNumber ?>;
  function pinboardLayout_<?php echo $randonNumber ?>(force) {
    sesJqueryObject('.new_image_pinboard_<?php echo $randonNumber; ?>').css('display','none');
    imageLoadedAll<?php echo $randonNumber ?>(force);
  }
  
  function imageLoadedAll<?php echo $randonNumber ?>(force) {
  
    sesJqueryObject('#tabbed-widget_<?php echo $randonNumber; ?>').addClass('sesbasic_pinboard_<?php echo $randonNumber; ?>');
    sesJqueryObject('#tabbed-widget_<?php echo $randonNumber; ?>').addClass('sesbasic_pinboard');
    if (typeof wookmark<?php echo $randonNumber ?> == 'undefined' || typeof force != 'undefined') {
      (function() {
        function getWindowWidth() {
          return Math.max(document.documentElement.clientWidth, window.innerWidth || 0)
        }
        wookmark<?php echo $randonNumber ?> = new Wookmark('.sesbasic_pinboard_<?php echo $randonNumber; ?>', {
          itemWidth: <?php echo isset($this->allParams['width']) ? str_replace(array('px','%'),array(''),$this->allParams['width']) : '300'; ?>, // Optional min width of a grid item
          outerOffset: 0, // Optional the distance from grid to parent
          align:'left',
          flexibleWidth: function () {
            // Return a maximum width depending on the viewport
            return getWindowWidth() < 1024 ? '100%' : '40%';
          }
        });
      })();
    } else {
      wookmark<?php echo $randonNumber ?>.initItems();
      wookmark<?php echo $randonNumber ?>.layout(true);
    }
  }
  
  sesJqueryObject(document).ready(function(){
    pinboardLayout_<?php echo $randonNumber ?>();
  });

</script>