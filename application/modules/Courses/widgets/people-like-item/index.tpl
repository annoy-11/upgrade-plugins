<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php if($this->title == ''){ ?>
<h3><?php echo $this->translate('People Like This %s',ucfirst(str_replace('courses_','',$this->subject->getType()))); ?></h3>
<?php } ?>
<ul class="sesbasic_sidebar_block sesbasic_user_grid_list sesbasic_clearfix">
  <?php foreach( $this->paginator as $item ): ?>
    <li>
      <?php $user = Engine_Api::_()->getItem('user',$item->poster_id) ?>
        	 <?php echo $this->htmlLink($user->getHref(), $this->itemPhoto($user, 'thumb.icon'),array('title'=>$user->getTitle())); ?>
    </li>
  <?php endforeach; ?>
    <?php if($this->paginator->getTotalItemCount() > $this->data_show){ ?>
  <li>
    <a href="javascript:;" onclick="getLikeData('<?php echo $this->subject()->getIdentity(); ?>','<?php echo urlencode($this->translate($this->title)); ?>')" class="sesbasic_user_grid_list_more">
     <?php echo '+';echo $this->paginator->getTotalItemCount() - $this->data_show ; ?>
    </a>
  </li>
 <?php } ?>
</ul>
<script type="application/javascript">
function getLikeData(value,title){
	if(value){
		url = en4.core.staticBaseUrl+'courses/index/like-item/item_id/'+value+'/title/'+title+'/item_type/<?php echo $this->subject()->getType(); ?>';
		openURLinSmoothBox(url);	
		return;
	}
}
</script>
