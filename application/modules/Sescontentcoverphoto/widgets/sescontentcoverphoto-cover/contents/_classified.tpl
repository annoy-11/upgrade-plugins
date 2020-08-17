<?php

?>
<?php if($this->type == 1): ?>
  <h2 class="sescontentcoverphoto_cover_title">
    <?php echo $subject->getTitle(); ?>
  </h2>
  <?php if(in_array('postedby',$this->option)) : ?>
    <div class="sescontentcoverphoto_cover_field sesbasic_clearfix"> 
      <i class="fa fa-user"></i>
      <span>
        <?php echo $this->translate("Posted By: %s", $subject->getOwner()); ?>
      </span>
    </div>
  <?php endif; ?>
  <?php if(in_array('membersince',$this->option)){ ?>
    <div class="sescontentcoverphoto_cover_field sesbasic_clearfix"> 
      <i class="fa fa-clock-o"></i>
      <span><?php echo  $this->translate('Posted On: %s', $this->timestamp($subject->creation_date)); ?></span>
    </div>
  <?php } ?>
  <?php if(in_array('category',$this->option) && $subject->category_id): 
        $category = Engine_Api::_()->getDbtable('categories', 'classified')->find($subject->category_id)->current();
    ?>
    <div class="sescontentcoverphoto_cover_field sesbasic_clearfix"> 
      <i class="fa fa-folder"></i>
      <span><?php echo $this->translate("Filed in: "); ?><?php echo $this->translate($category->category_name); ?>      </span>
    </div>
  <?php endif; ?>
  
  <!--Member Statics-->          
  <div class="sescontentcoverphoto_cover_stats sesbasic_clearfix clear">
    <?php if(in_array('viewcount',$this->option)){ ?>
      <div title="<?php echo $this->translate(array('%s view', '%s views', $subject->view_count), $this->locale()->toNumber($subject->view_count))?>">
        <span class="sescontentcoverphoto_cover_stat_count"><?php echo $subject->view_count ?></span>
        <span class="sescontentcoverphoto_cover_stat_txt"> <?php echo str_replace(',','',preg_replace('/[0-9]+/','',$this->translate(array('%s View', '%s Views', $subject->view_count), $this->locale()->toNumber($subject->view_count)))); ?></span>
      </div>
    <?php } ?>
    <?php if(in_array('likecount',$this->option)){ ?>
      <?php $likeCount = Engine_Api::_()->getDbtable('likes', 'core')->getLikeCount($subject); ?>
      <div title="<?php echo $this->translate(array('%s like', '%s likes', $likeCount), $this->locale()->toNumber($likeCount))?>">
        <span class="sescontentcoverphoto_cover_stat_count"><?php echo $likeCount ?></span>
        <span class="sescontentcoverphoto_cover_stat_txt"> <?php echo str_replace(',','',preg_replace('/[0-9]+/','',$this->translate(array('%s Like', '%s Likes', $likeCount), $this->locale()->toNumber($likeCount)))); ?></span>
      </div>
    <?php } ?>
    <?php if(in_array('commentcount',$this->option)){ ?>
      <div title="<?php echo $this->translate(array('%s comment', '%s comments', $subject->comment_count), $this->locale()->toNumber($subject->comment_count))?>">
        <span class="sescontentcoverphoto_cover_stat_count"><?php echo $subject->comment_count ?></span>
        <span class="sescontentcoverphoto_cover_stat_txt"> <?php echo str_replace(',','',preg_replace('/[0-9]+/','',$this->translate(array('%s Comment', '%s Comments', $subject->comment_count), $this->locale()->toNumber($subject->comment_count)))); ?></span>
      </div>
    <?php } ?>
  </div>

  <?php //User Cover Photo Work ?>
    <div class="sescontentcoverphoto_cover_buttons">
      <?php include APPLICATION_PATH .  '/application/modules/Sescontentcoverphoto/views/scripts/_iconButton.tpl';?>
    </div>
  <?php //End User Cover Photo Work ?>
  
<?php elseif($this->type == 2): ?>
  <div class="sescontentcoverphoto_cover_content_left">
    <?php if(in_array('postedby',$this->option)) : ?>
      <p class="sescontentcoverphoto_cover_field"> 
        <i class="fa fa-user"></i>
        <span>
          <?php echo $this->translate("Posted By: %s", $subject->getOwner()); ?>
        </span>
      </p>
    <?php endif; ?>
    <?php if(in_array('membersince',$this->option)){ ?>    
      <p class="sescontentcoverphoto_cover_field">
        <i class="fa fa-clock-o"></i>
        <span><?php echo  $this->translate('Posted On: %s', $this->timestamp($subject->creation_date)); ?></span>
      </p>
    <?php } ?>
    <?php if(in_array('category',$this->option) && $subject->category_id): 
    $category = Engine_Api::_()->getDbtable('categories', 'classified')->find($subject->category_id)->current();
    ?>
      <p class="sescontentcoverphoto_cover_field"> 
        <i class="fa fa-folder"></i>
        <span>
          <?php echo $this->translate("Filed in: "); ?>
          <a href='javascript:void(0);' onclick='javascript:categoryAction(<?php echo $category->category_id?>);'><?php echo $this->translate($category->category_name) ?></a>
        </span>
      </p>
    <?php endif; ?>
  </div>
  <div class="sescontentcoverphoto_cover_stats sesbasic_clearfix">
    <ul>
      <?php if(in_array('viewcount',$this->option)){ ?>
        <li>
          <span><i class="fa fa-eye"></i></span>
          <?php echo $subject->view_count ?><?php echo str_replace(',','',preg_replace('/[0-9]+/','',$this->translate(array('%s View', '%s Views', $subject->view_count), $this->locale()->toNumber($subject->view_count)))); ?></span>
        </li>
      <?php } ?>
      <?php if(in_array('likecount',$this->option)){ ?>
        <?php $likeCount = Engine_Api::_()->getDbtable('likes', 'core')->getLikeCount($subject); ?>
        <li>
          <span><i class="fa fa-thumbs-o-up"></i></span>
          <?php echo $likeCount; ?><?php echo str_replace(',','',preg_replace('/[0-9]+/', '', $this->translate(array('%s Like', '%s Likes', $likeCount), $this->locale()->toNumber($likeCount)))); ?>
        </li>     
      <?php } ?>
      <?php if(in_array('commentcount',$this->option)){ ?>
        <li>
          <span><i class="fa fa-thumbs-o-up"></i></span>
          <?php echo $subject->comment_count; ?><?php echo str_replace(',','',preg_replace('/[0-9]+/', '', $this->translate(array('%s Comment', '%s Comments', $subject->comment_count), $this->locale()->toNumber($subject->comment_count)))); ?>
        </li>     
      <?php } ?>      
    </ul>
  </div>
<?php elseif($this->type == 4): ?>
  <div class="sescontentcoverphoto_profile_title">
    <p>
      <?php echo $subject->getTitle(); ?>
    </p>
  </div>
  <?php if(in_array('postedby',$this->option)) : ?>
    <p class="sescontentcoverphoto_cover_field"> 
      <i class="fa fa-user"></i>
      <span>
        <?php echo $this->translate("Posted By: %s", $subject->getOwner()); ?>
      </span>
    </p>
  <?php endif; ?>
  <?php if(in_array('membersince',$this->option)){ ?>     
    <p class="sescontentcoverphoto_cover_field">
      <i class="fa fa-clock-o"></i>
      <span><?php echo  $this->translate('Posted On: %s', $this->timestamp($subject->creation_date)); ?></span>
    </p>
  <?php } ?>
  <?php if(in_array('category',$this->option) && $subject->category_id): 
  $category = Engine_Api::_()->getDbtable('categories', 'classified')->find($subject->category_id)->current();
  ?>
    <p class="sescontentcoverphoto_cover_field"> 
      <i class="fa fa-folder"></i>
      <span>
        <?php echo $this->translate("Filed in: "); ?>
        <a href='javascript:void(0);' onclick='javascript:categoryAction(<?php echo $category->category_id?>);'><?php echo $this->translate($category->category_name) ?></a>
      </span>
    </p>
  <?php endif; ?>
  <div class="sescontentcoverphoto_cover_stats sesbasic_clearfix clear">
    <?php if(in_array('viewcount',$this->option)){ ?>
      <div title="<?php echo $this->translate(array('%s view', '%s views', $subject->view_count), $this->locale()->toNumber($subject->view_count))?>">
        <span class="sescontentcoverphoto_cover_stat_count"><?php echo $subject->view_count ?></span>
        <span class="sescontentcoverphoto_cover_stat_txt"> <?php echo str_replace(',','',preg_replace('/[0-9]+/','',$this->translate(array('%s View', '%s Views', $subject->view_count), $this->locale()->toNumber($subject->view_count)))); ?></span>
      </div>
    <?php } ?>
    <?php if(in_array('likecount',$this->option)){ ?>
      <?php $likeCount = Engine_Api::_()->getDbtable('likes', 'core')->getLikeCount($subject); ?>
      <div title="<?php echo $this->translate(array('%s like', '%s likes', $likeCount), $this->locale()->toNumber($likeCount))?>">
        <span class="sescontentcoverphoto_cover_stat_count"><?php echo $likeCount; ?></span>
        <span class="sescontentcoverphoto_cover_stat_txt"> <?php echo str_replace(',','',preg_replace('/[0-9]+/', '', $this->translate(array('%s Like', '%s Likes', $likeCount), $this->locale()->toNumber($likeCount)))); ?></span>
      </div>      
    <?php } ?>
    <?php if(in_array('commentcount',$this->option)){ ?>
      <div title="<?php echo $this->translate(array('%s comment', '%s comments', $subject->comment_count), $this->locale()->toNumber($subject->comment_count))?>">
        <span class="sescontentcoverphoto_cover_stat_count"><?php echo $subject->comment_count; ?></span>
        <span class="sescontentcoverphoto_cover_stat_txt"> <?php echo str_replace(',','',preg_replace('/[0-9]+/', '', $this->translate(array('%s Comment', '%s Comments', $subject->comment_count), $this->locale()->toNumber($subject->comment_count)))); ?></span>
      </div>      
    <?php } ?>
  </div>
  
<?php endif; ?>