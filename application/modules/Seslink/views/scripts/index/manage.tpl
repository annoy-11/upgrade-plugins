<?php
?>
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

<script type="text/javascript">
  var pageAction =function(page){
    $('page').value = page;
    $('filter_form').submit();
  }
</script>
  <?php if( $this->paginator->getTotalItemCount() > 0 ): ?>
    <ul class="prelative seslinks_listing sesbasic_pinboard_<?php echo $randonNumber ; ?>" style="min-height:50px;" id="tabbed-widget_<?php echo $randonNumber; ?>" >
      <?php foreach( $this->paginator as $item ): ?>
        <li class="seslinks_list_item new_image_pinboard_<?php echo $randonNumber; ?>" >
        	<section>
          	<header class="sesbasic_clearfix">
            	<div class="_owner_thumb">
              	<?php echo $this->htmlLink($item->getOwner()->getHref(), $this->itemPhoto($item->getOwner(), 'thumb.icon', $item->getOwner()->getTitle()), array('class' => '')) ?>
              </div>
              <div class="_owner_info">
                  <div class="_owner_name"><?php echo $this->htmlLink($item->getOwner()->getHref(), $item->getOwner()->getTitle()) ?></div>
                  <div class="sesbasic_text_light _date">
                    <?php echo $this->translate('Posted');?>
                    <?php echo $this->timestamp(strtotime($item->creation_date)) ?>
                  </div>
              </div>
              	<div class="_options">
               		<span class="_options_toggle fa fa-ellipsis-v sesbasic_text_light"></span>
                	<div class="_options_pulldown">
                    <?php echo $this->htmlLink(array(
                      'action' => 'edit',
                      'link_id' => $item->getIdentity(),
                      'route' => 'seslink_specific',
                      'reset' => true,
                    ), $this->translate('Edit'), array(
                      'class' => 'icon_link_edit',
                    )) ?>
                    <?php
                    echo $this->htmlLink(array('route' => 'default', 'module' => 'seslink', 'controller' => 'index', 'action' => 'delete', 'link_id' => $item->getIdentity(), 'format' => 'smoothbox'), $this->translate('Delete'), array(
                      'class' => 'smoothbox icon_link_delete'
                    ));
                    ?>
                	</div>
            		</div>
            </header>
            <div class='_content'>
              <?php if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('seslink.show', 0)) { ?>
                <div class='_title'>
                  <?php echo $this->htmlLink($item->getHref(), $item->getTitle()) ?>
                </div>
              <?php } else { ?>
                <div class="_title seslink_link_popup">
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
              <div class="_stats sesbasic_text_light">
                <span title="<?php echo $this->translate(array('%s Like', '%s Likes', $item->like_count), $this->locale()->toNumber($item->like_count)) ?>">
                  <i class="fa fa-thumbs-up"></i>
                  <span><?php echo $this->locale()->toNumber($item->like_count) ?></span>
                </span>
                <span title="<?php echo $this->translate(array('%s Comment', '%s Comments', $item->comment_count), $this->locale()->toNumber($item->comment_count)) ?>">
                  <i class="fa fa-comment"></i>
                  <span><?php echo $this->locale()->toNumber($item->comment_count) ?></span>
                </span>
                <span title="<?php echo $this->translate(array('%s View', '%s Views', $item->view_count), $this->locale()->toNumber($item->view_count)) ?>">
                  <i class="fa fa-eye"></i>
                  <span><?php echo $this->locale()->toNumber($item->view_count) ?></span>
                </span>
                <?php if(0) { ?>
                  <span>- 
                    <?php $category = Engine_Api::_()->getItem('seslink_category', $item->category_id); ?>
                    <a href="<?php echo $this->url(array('action' => 'index'), 'seslink_general').'?category_id='.$item->category_id; ?>"><?php echo $category->category_name; ?></a>
                  </span>
                <?php } ?>
                <span>- 
                  <?php if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('seslink.show', 0)) { ?>
                    <a href="<?php echo $item->getHref(); ?>"><?php echo $this->translate('Permalink'); ?></a>
                  <?php } else { ?>
                    <a data-url='seslink/index/link-popup/link_id/<?php echo $item->getIdentity(); ?>' class="sessmoothbox" href="javascript:;"><?php echo $this->translate('Permalink'); ?></a>
                  <?php } ?>
                </span>
              </div>
            </div>
          </section>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php elseif($this->search): ?>
    <div class="tip">
      <span>
        <?php echo $this->translate('You do not have any link entries that match your search criteria.');?>
      </span>
    </div>
  <?php else: ?>
    <div class="tip">
      <span>
        <?php echo $this->translate('You do not have any link entries.');?>
        <?php if( $this->canCreate ): ?>
          <?php echo $this->translate('Get started by %1$swriting%2$s a new entry.', '<a class="smoothbox" href="'.$this->url(array('action' => 'create'), 'seslink_general').'">', '</a>'); ?>
        <?php endif; ?>
      </span>
    </div>
  <?php endif; ?>

  <?php echo $this->paginationControl($this->paginator, null, null, array(
    'pageAsQuery' => true,
    'query' => $this->formValues,
    //'params' => $this->formValues,
  )); ?>

<script type="application/javascript">
 	
	function tagAction(tag_id){
		window.location.href = '<?php echo $this->url(array("action"=>"manage"),"seslink_general",true); ?>'+'?tag_id='+tag_id;
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
          itemWidth: <?php echo isset($this->allParams['width']) ? str_replace(array('px','%'),array(''),$this->allParams['width']) : '250'; ?>, // Optional min width of a grid item
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
	
	sesJqueryObject(document).on('click','._options_toggle',function(){
		if(sesJqueryObject(this).hasClass('open')){
			sesJqueryObject(this).removeClass('open');
		}else{
			sesJqueryObject(this).addClass('open');
		}
			return false;
	});
	
  $$('.core_main_link').getParent().addClass('active');
</script>
