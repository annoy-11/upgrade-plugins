<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>

<ul class='sesbasic_clearfix sesbasic_bxs sesbasic_sidebar_block sesgroup_sidebar_info_block'>
  <?php if(SESGROUPSHOWUSERDETAIL == 1 && in_array('owner',$this->criteria)){ ?>
    <li class="sesbasic_clearfix sesgroup_list_stats sesgroup_list_created_by"> <i title='<?php echo $this->translate("Created by"); ?>' class="fa fa-user"></i> <span><a href="<?php echo $this->subject->getOwner()->getHref(); ?>"><?php echo $this->translate('by ');?><?php echo $this->subject->getOwner()->getTitle(); ?></a></span> </li>
  <?php } ?>
  <?php if(in_array('creationDate',$this->criteria)){ ?>
  <li class="sesbasic_clearfix sesgroup_list_stats sesgroup_list_created_on sesbasic_text_light"> <i title='<?php echo $this->translate("Created on"); ?>' class="fa fa-edit"></i> <span><?php echo $this->translate('%1$s', $this->timestamp($this->subject->creation_date)); ?></span> </li>
  <?php } ?>
  <?php if(in_array('tag',$this->criteria) && count($this->groupTags)){ ?>
  <li class="sesbasic_clearfix sesgroup_list_stats sesgroup_list_tag"> <i title='<?php echo $this->translate("Tags"); ?>' class="fa fa-tag"></i> <span>
    <?php 
            	$counter = 1;
            	 foreach($this->groupTags as $tag):
                if($tag->getTag()->text != ''){ ?>
    <a href='javascript:void(0);' onclick='javascript:tagAAAction(<?php echo $tag->getTag()->tag_id; ?>,"<?php echo $tag->getTag()->text; ?>");'>#<?php echo $tag->getTag()->text ?></a>
    <?php if(count($this->groupTags) != $counter){ 
                  	echo ",";	
                   } ?>
    <?php	 } 
          		$counter++;
              endforeach;  ?>
    </span> </li>
  <?php } ?>
  <?php if(in_array('categories',$this->criteria)){ ?>
  <?php $category = Engine_Api::_()->getItem('sesgroup_category',$this->subject->category_id); ?>
  <?php if($category){ ?>
  <li class="sesbasic_clearfix sesgroup_list_stats sesgroup_list_category"> <i title="<?php echo $this->translate("Category"); ?>" class="fa fa-tags"></i> <span><a href="<?php echo $category->getHref(); ?>"><?php echo $category->category_name; ?></a>
    <?php $subcategory = Engine_Api::_()->getItem('sesgroup_category',$this->subject->subcat_id); ?>
    <?php if($subcategory && $this->subject->subcat_id != 0){ ?>
    &nbsp;&raquo;&nbsp;<a href="<?php echo $subcategory->getHref(); ?>"><?php echo $subcategory->category_name; ?></a>
    <?php $subsubcategory = Engine_Api::_()->getItem('sesgroup_category',$this->subject->subsubcat_id); ?>
    <?php if($subsubcategory && $this->subject->subsubcat_id != 0){ ?>
    &nbsp;&raquo;&nbsp;<a href="<?php echo $subsubcategory->getHref(); ?>"><?php echo $subsubcategory->category_name; ?></a>
    <?php } ?>
    <?php } ?>
    </span> </li>
  <?php }          
  } ?>
  <?php if(count(array_intersect($this->criteria,array('like','comment','favourite','view','follow','entryCount'))) > 0):?>
  <li class="sesbasic_clearfix sesbasic_text_light"> <i title="<?php echo $this->translate('Statistics'); ?>" class="fa fa-bar-chart"></i> <span>
    <?php if(in_array('comment',$this->criteria)){ ?>
    <span title="<?php echo $this->translate(array('%s comment', '%s comments', $this->subject->comment_count), $this->locale()->toNumber($this->subject->comment_count)); ?>"><?php echo $this->translate(array('%s comment', '%s comments', $this->subject->comment_count), $this->locale()->toNumber($this->subject->comment_count)); ?></span>,
    <?php } ?>
    <?php if(in_array('like',$this->criteria)){ ?>
    <span title="<?php echo $this->translate(array('%s like', '%s likes', $this->subject->like_count), $this->locale()->toNumber($this->subject->like_count)); ?>"><?php echo $this->translate(array('%s like', '%s likes', $this->subject->like_count), $this->locale()->toNumber($this->subject->like_count)); ?></span>,
    <?php } ?>
    <?php if(in_array('view',$this->criteria)){ ?>
    <span title="<?php echo $this->translate(array('%s view', '%s views', $this->subject->view_count), $this->locale()->toNumber($this->subject->view_count)); ?>"><?php echo $this->translate(array('%s view', '%s views', $this->subject->view_count), $this->locale()->toNumber($this->subject->view_count)); ?></span>,
    <?php } ?>
    <?php if(in_array('favourite',$this->criteria)){ ?>
    <span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $this->subject->favourite_count), $this->locale()->toNumber($this->subject->favourite_count)); ?>"><?php echo $this->translate(array('%s favourite', '%s favourites', $this->subject->favourite_count), $this->locale()->toNumber($this->subject->favourite_count)); ?></span>,
    <?php } ?>
    <?php if(in_array('follow',$this->criteria)){ ?>
    <span title="<?php echo $this->translate(array('%s follower', '%s followers', $this->subject->follow_count), $this->locale()->toNumber($this->subject->follow_count)); ?>"><?php echo $this->translate(array('%s follower', '%s followers', $this->subject->follow_count), $this->locale()->toNumber($this->subject->follow_count)); ?></span>,
    <?php } ?>
    </span> </li>
  <?php endif;?>
</ul>
<script type="application/javascript">
var tabId_pI = <?php echo $this->identity; ?>;
window.addEvent('domready', function() {
	tabContainerHrefSesbasic(tabId_pI);	
});
var tagAAAction = window.tagAAAction = function(tag,value){
	var url = "<?php echo $this->url(array('module' => 'sesgroup','action'=>'browse'), 'sesgroup_general', true) ?>?tag_id="+tag+'&tag_name='+value;
 window.location.href = url;
}
</script>