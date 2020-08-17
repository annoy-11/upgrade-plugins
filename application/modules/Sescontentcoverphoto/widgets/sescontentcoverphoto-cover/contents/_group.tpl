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
    $category = @$subject->getCategory(); ?>
    <div class="sescontentcoverphoto_cover_field sesbasic_clearfix"> 
      <i class="fa fa-folder"></i>
      <span>
        <?php echo $this->translate("Category: "); ?><?php echo $this->htmlLink(array('route' => 'group_general', 'action' => 'browse', 'category_id' => $subject->category_id), $this->translate($category->title)) ?>
      </span>
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
    <?php if(in_array('membercount',$this->option)){ ?>
      <div title="<?php echo $this->translate(array('%s member', '%s members', $subject->member_count), $this->locale()->toNumber($subject->member_count))?>">
        <span class="sescontentcoverphoto_cover_stat_count"><?php echo $subject->member_count ?></span>
        <span class="sescontentcoverphoto_cover_stat_txt"> <?php echo str_replace(',','',preg_replace('/[0-9]+/','',$this->translate(array('%s Member', '%s Members', $subject->member_count), $this->locale()->toNumber($subject->member_count)))); ?></span>
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
    $category = @$subject->getCategory();
    ?>
      <p class="sescontentcoverphoto_cover_field"> 
        <i class="fa fa-folder"></i>
        <span>
          <?php echo $this->translate("Category: "); ?><?php echo $this->htmlLink(array('route' => 'group_general', 'action' => 'browse', 'category_id' => $subject->category_id), $this->translate($category->title)) ?>
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
      <?php if(in_array('membercount',$this->option)){ ?>
        <li>
          <span><i class="fa fa-user"></i></span>
          <?php echo $subject->member_count ?><?php echo str_replace(',','',preg_replace('/[0-9]+/','',$this->translate(array('%s Member', '%s Members', $subject->member_count), $this->locale()->toNumber($subject->member_count)))); ?></span>
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
        $category = @$subject->getCategory();
    ?>
    <p class="sescontentcoverphoto_cover_field"> 
      <i class="fa fa-folder"></i>
      <span>
        <?php echo $this->translate("Category: "); ?><?php echo $this->htmlLink(array('route' => 'event_general', 'action' => 'browse', 'category_id' => $subject->category_id), $this->translate($category->title)) ?>
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
    <?php if(in_array('membercount',$this->option)){ ?>
      <div title="<?php echo $this->translate(array('%s member', '%s members', $subject->member_count), $this->locale()->toNumber($subject->member_count))?>">
        <span class="sescontentcoverphoto_cover_stat_count"><?php echo $subject->member_count ?></span>
        <span class="sescontentcoverphoto_cover_stat_txt"> <?php echo str_replace(',','',preg_replace('/[0-9]+/','',$this->translate(array('%s Member', '%s Members', $subject->member_count), $this->locale()->toNumber($subject->member_count)))); ?></span>
      </div>
    <?php } ?>
  </div>
  
<?php endif; ?>