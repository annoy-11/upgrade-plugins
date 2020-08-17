<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesinterest
 * @package    Sesinterest
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-03-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sespagenote/externals/styles/style.css'); ?> 
<ul class='sesbasic_clearfix sesbasic_bxs sesbasic_sidebar_block sespagenote_sidebar_info_block'>
  <?php if(in_array('by',$this->criteria)){ ?>
    <li class="sesbasic_clearfix sespagenote_list_stats sespagenote_list_created_by"> <i title='<?php echo $this->translate("Created by"); ?>' class="fa fa-user"></i> <span><a href="<?php echo $this->subject->getOwner()->getHref(); ?>"><?php echo $this->translate('by ');?><?php echo $this->subject->getOwner()->getTitle(); ?></a></span> </li>
  <?php } ?>
  <?php if(in_array('creationDate',$this->criteria)){ ?>
  <li class="sesbasic_clearfix sespagenote_list_stats sespagenote_list_created_on"> <i title='<?php echo $this->translate("Created on"); ?>' class="fa fa-clock-o"></i> <span><?php echo $this->translate('%1$s', $this->timestamp($this->subject->creation_date)); ?></span> </li>
  <?php } ?>
  <?php if(in_array('tag',$this->criteria) && count($this->pageTags)){ ?>
  <li class="sesbasic_clearfix sespagenote_list_stats sespagenote_list_tag"> <i title='<?php echo $this->translate("Tags"); ?>' class="fa fa-tag"></i> <span>
    <?php 
            	$counter = 1;
            	 foreach($this->pageTags as $tag):
                if($tag->getTag()->text != ''){ ?>
    <a href='javascript:void(0);' onclick='javascript:tagAAANotection(<?php echo $tag->getTag()->tag_id; ?>,"<?php echo $tag->getTag()->text; ?>");'>#<?php echo $tag->getTag()->text ?></a>
    <?php if(count($this->pageTags) != $counter){ 
                  	echo "";	
                   } ?>
    <?php	 } 
          		$counter++;
              endforeach;  ?>
    </span> </li>
  <?php } ?>
  <?php if(in_array('pagename',$this->criteria)) { ?>
    <?php $page = Engine_Api::_()->getItem('sespage_page',$this->subject->parent_id); ?>
    <?php if($page) { ?>
      <li class="sesbasic_clearfix sespagenote_list_stats sespagenote_list_category"> <i title="<?php echo $this->translate("Page"); ?>" class="fa fa-tags"></i> <span><a href="<?php echo $page->getHref(); ?>"><?php echo $page->getTitle(); ?></a></span> </li>
    <?php } ?>          
  <?php } ?>
  
  <?php if(count(array_intersect($this->criteria,array('likecount','commentcount','favouritecount','viewcount'))) > 0):?>
  <li class="sesbasic_clearfix sesbasic_text_light"> <i title="<?php echo $this->translate('Statistics'); ?>" class="fa fa-bar-chart"></i> <span>
    <?php if(in_array('commentcount',$this->criteria)){ ?>
    <span title="<?php echo $this->translate(array('%s comment', '%s comments', $this->subject->comment_count), $this->locale()->toNumber($this->subject->comment_count)); ?>"><?php echo $this->translate(array('%s comment', '%s comments', $this->subject->comment_count), $this->locale()->toNumber($this->subject->comment_count)); ?></span>,
    <?php } ?>
    <?php if(in_array('likecount',$this->criteria)){ ?>
    <span title="<?php echo $this->translate(array('%s like', '%s likes', $this->subject->like_count), $this->locale()->toNumber($this->subject->like_count)); ?>"><?php echo $this->translate(array('%s like', '%s likes', $this->subject->like_count), $this->locale()->toNumber($this->subject->like_count)); ?></span>,
    <?php } ?>
    <?php if(in_array('viewcount',$this->criteria)){ ?>
    <span title="<?php echo $this->translate(array('%s view', '%s views', $this->subject->view_count), $this->locale()->toNumber($this->subject->view_count)); ?>"><?php echo $this->translate(array('%s view', '%s views', $this->subject->view_count), $this->locale()->toNumber($this->subject->view_count)); ?></span>,
    <?php } ?>
    <?php if(in_array('favouritecount',$this->criteria)){ ?>
    <span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $this->subject->favourite_count), $this->locale()->toNumber($this->subject->favourite_count)); ?>"><?php echo $this->translate(array('%s favourite', '%s favourites', $this->subject->favourite_count), $this->locale()->toNumber($this->subject->favourite_count)); ?></span>,
    <?php } ?>
    </span> </li>
  <?php endif;?>
</ul>
<script type="application/javascript">
var tabId_pI = <?php echo $this->identity; ?>;
window.addEvent('domready', function() {
	tabContainerHrefSesbasic(tabId_pI);	
});
var tagAAANotection = window.tagAAANotection = function(tag,value){
	var url = "<?php echo $this->url(array('module' => 'sespagenote','action'=>'browse'), 'sespagenote_general', true) ?>?tag_id="+tag+'&tag_name='+value;
 window.location.href = url;
}
</script>
