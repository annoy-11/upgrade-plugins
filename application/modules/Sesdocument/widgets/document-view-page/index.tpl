
<?php $widgetParams = $this->widgetParams; ?>
<script type="text/javascript">
  en4.core.runonce.add(function() {
    var pre_rate = <?php echo $this->document->rating;?>;
    var rated = '<?php echo $this->rated;?>';
    var video_id = <?php echo $this->document->sesdocument_id;?>;
    var total_votes = <?php echo $this->rating_count;?>;
    var viewer = <?php echo $this->viewer_id;?>;
    new_text = '';

    var rating_over = window.rating_over = function(rating) {
      if( rated == 1 ) {
        $('rating_text').innerHTML = "<?php echo $this->translate('you already rated');?>";
        //set_rating();
      } else if( viewer == 0 ) {
        $('rating_text').innerHTML = "<?php echo $this->translate('please login to rate');?>";
      } else {
        $('rating_text').innerHTML = "<?php echo $this->translate('click to rate');?>";
        for(var x=1; x<=5; x++) {
          if(x <= rating) {
            $('rate_'+x).set('class', 'rating_star_big_generic rating_star_big');
          } else {
            $('rate_'+x).set('class', 'rating_star_big_generic rating_star_big_disabled');
          }
        }
      }
    }
    
    var rating_out = window.rating_out = function() {
      if (new_text != ''){
        $('rating_text').innerHTML = new_text;
      }
      else{
        $('rating_text').innerHTML = " <?php echo $this->translate(array('%s rating', '%s ratings', $this->rating_count),$this->locale()->toNumber($this->rating_count)) ?>";        
      }
      if (pre_rate != 0){
        set_rating();
      }
      else {
        for(var x=1; x<=5; x++) {
          $('rate_'+x).set('class', 'rating_star_big_generic rating_star_big_disabled');
        }
      }
    }

    var set_rating = window.set_rating = function() {
      var rating = pre_rate;
      if (new_text != ''){
        $('rating_text').innerHTML = new_text;
      }
      else{
        $('rating_text').innerHTML = "<?php echo $this->translate(array('%s rating', '%s ratings', $this->rating_count),$this->locale()->toNumber($this->rating_count)) ?>";
      }
      for(var x=1; x<=parseInt(rating); x++) {
        $('rate_'+x).set('class', 'rating_star_big_generic rating_star_big');
      }

      for(var x=parseInt(rating)+1; x<=5; x++) {
        $('rate_'+x).set('class', 'rating_star_big_generic rating_star_big_disabled');
      }

      var remainder = Math.round(rating)-rating;
      if (remainder <= 0.5 && remainder !=0){
        var last = parseInt(rating)+1;
        $('rate_'+last).set('class', 'rating_star_big_generic rating_star_big_half');
      }
    }

    var rate = window.rate = function(rating) {
      $('rating_text').innerHTML = "<?php echo $this->translate('Thanks for rating!');?>";
      for(var x=1; x<=5; x++) {
        $('rate_'+x).set('onclick', '');
      }
      (new Request.JSON({
        'format': 'json',
        'url' : '<?php echo $this->url(array('module' => 'sesdocument', 'controller' => 'index', 'action' => 'rate'), 'default', true) ?>',
        'data' : {
          'format' : 'json',
          'rating' : rating,
          'sesdocument_id': video_id
        },
        'onRequest' : function(){
          rated = 1;
          total_votes = total_votes+1;
          pre_rate = (pre_rate+rating)/total_votes;
          set_rating();
        },
        'onSuccess' : function(responseJSON, responseText)
        {
          $('rating_text').innerHTML = responseJSON[0].total+" ratings";
          new_text = responseJSON[0].total+" ratings";
        }
      })).send();

    }

    var tagAction = window.tagAction = function(tag){
      $('tag').value = tag;
      $('filter_form').submit();
    }
    
    set_rating();
  });
</script>
<div class="sesdocument_view_page" >
  <?php $shareType = $this->sharings;?>

   <div class="title">
       <h3><?php echo $this->subject->title;?></h3>
       <?php if($this->ratings == 1 && in_array('ratings', $widgetParams['option'])){  ?>
        <p class="sesbasic_rating_star" onmouseout="rating_out();">    
          <span id="rate_1" class="rating_star_big_generic" <?php if (!$this->rated && $this->viewer_id):?> onclick="rate(1);"<?php endif; ?> onmouseover="rating_over(1);"></span>
          <span id="rate_2" class="rating_star_big_generic" <?php if (!$this->rated && $this->viewer_id):?> onclick="rate(2);"<?php endif; ?> onmouseover="rating_over(2);"></span>
          <span id="rate_3" class="rating_star_big_generic" <?php if (!$this->rated && $this->viewer_id):?> onclick="rate(3);"<?php endif; ?> onmouseover="rating_over(3);"></span>
          <span id="rate_4" class="rating_star_big_generic" <?php if (!$this->rated && $this->viewer_id):?> onclick="rate(4);"<?php endif; ?> onmouseover="rating_over(4);"></span>
          <span id="rate_5" class="rating_star_big_generic" <?php if (!$this->rated && $this->viewer_id):?> onclick="rate(5);"<?php endif; ?> onmouseover="rating_over(5);"></span>
          <span id="rating_text" class="rating_text"><?php echo $this->translate('click to rate');?></span>
        </p>
       <?php }?>
    </div>
    
    <div class="sesdocument_user_stats">
       <?php if(in_array('by', $widgetParams['option'])) { ?>
       <span class="owner sesbasic_text_light"><i class="fa fa-user"></i><?php echo $this->htmlLink($this->subject->getOwner()->getHref(), $this->subject->getOwner()->getTitle(), array('class' => 'thumbs_author')) ;?></span>
       <?php } ?>
       <?php if(in_array('creationdate', $widgetParams['option'])) { ?>
        <span class="date sesbasic_text_light"><i class="fa fa-calendar"></i><?php echo $this->subject->creation_date ;?></span>
        <?php } ?>
        <?php if(in_array('category', $widgetParams['option'])) { ?>
           <?php $showCategory ='';  
                
                    if($this->subject->category_id != '' && intval($this->subject->category_id) && !is_null($this->subject->category_id)){
                       $categoryItem = Engine_Api::_()->getItem('sesdocument_category', $this->subject->category_id);
                    if($categoryItem){
                    $categoryUrl = $categoryItem->getHref();
                    $categoryName = $this->translate($categoryItem->category_name);
                    
                    }
                    }
                
              ?>
       <span class="cat sesbasic_text_light"><i class="fa fa-folder-open"></i><?php echo $categoryName;?></span>
       <?php } ?>
       <?php if(in_array('likecount', $widgetParams['option']) || in_array('viewcount', $widgetParams['option']) || in_array('commentcount', $widgetParams['option'])) { ?>
        <span class="stats">
          <?php if(in_array('viewcount', $widgetParams['option'])) { ?>
            <span class="views  sesbasic_text_light"><i class="fa fa-eye"></i> <?php echo $this->subject->view_count;?> </span>
          <?php } ?>
          <?php if(in_array('viewcount', $widgetParams['option'])) { ?>
            <span class="comment sesbasic_text_light"><i class="fa fa-comment"></i> <?php echo $this->subject->comment_count;?> </span>
          <?php } ?>
          <?php if(in_array('viewcount', $widgetParams['option'])) { ?>
            <span class="like sesbasic_text_light"><i class="fa fa-thumbs-up"></i> <?php echo $this->subject->like_count;?> </span>
          <?php } ?>
        </span>
       <?php } ?>
    </div>
    <div class="desc sesbasic_text_light">     
     <?php echo $this->subject->description;?>
    </div>
    <?php if ($this->subject->file_id_google): ?>
    <div style="margin-top:20px;">
      <?php echo '<iframe src="https://docs.google.com/file/d/' . $this->subject->file_id_google . '/preview" width="100%" height="600"></iframe>'; ?>
    </div>
 <?php 
    $file =  $this->subject->file_id;$type = NULL;
    $document = Engine_Api::_()->getItemTable('storage_file')->getFile($file, $type);
    $type = $document->extension;
    if($type == "png" || $type == "jpeg" || $type == "gif" || $type == "jpg"){
       $url = Engine_Api::_()->storage()->get($file, '')->getPhotoUrl();
    }else{
       $url =  Engine_Api::_()->storage()->get($file, "")->map();
    }
 ?>
 <?php
  $value = Engine_Api::_()->authorization()->isAllowed('sesdocument', $this->viewer, 'downloading');
  if($value == 1){?>
 <br>
 <p >
  <a href="<?php echo $url;?>" download ><button><i class="fa fa-download"></i> <?php echo $this->translate("Download");?></button></a></p><?php }?>
   <div class='sesdocument_edit_options'>
    <?php if( $this->can_edit ): ?>
      <?php echo $this->htmlLink(array(
          'route' => 'default',
          'module' => 'sesdocument',
          'controller' => 'index',
          'action' => 'edit',
        'sesdocument_id' => $this->document->sesdocument_id
      ), $this->translate('Edit'), array(
        'class' => 'edit_doc'
      )) ?>
    <?php endif;?>
      <?php if( $this->can_delete ): ?>
      <?php echo $this->htmlLink(array(
        'route' => 'default',
        'module' => 'sesdocument',
        'controller' => 'index',
        'action' => 'delete',
        'sesdocument_id' => $this->document->sesdocument_id,
        'format' => 'smoothbox'
      ), $this->translate('Delete'), array(
        'class' => 'delete_doc smoothbox'
      )) ?>
    <?php endif;?>
    <?php if($this->viewer_id && $this->viewer_id != $this->document->user_id && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdocument.reporting', 1)):?>
      <a href="<?php echo $this->url(array("module" => "core","controller" => "report","action" => "create", 'subject' => $this->document->getGuid()),'default', true);?>" class="smoothbox report_link"><i class="fa fa-flag"></i><?php echo $this->translate('Report');?></a>
    <?php endif;?>
    <?php else: ?>
    <div class="tip">
      <span>
          <?php echo $this->translate("This document does not exists."); ?>
      </span>
    </div>
    <?php endif; ?>
</div>
