<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescontest
 * @package    Sescontest
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: votes.tpl  2017-12-01 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
$randonNumber = "voting_popup"
?>
<?php if(!$this->is_ajax){ ?>
<input type="hidden" id="submitdatavalue" name="submitdatavalue" value="">
<div class="sescontest_voting_popup sesbasic_bxs">
	<div class=""></div>
  <header>
  	<p class="_title"><strong><?php echo $this->translate('VOTE');?></strong><?php echo $this->translate(' for your favorite photos');?></p>
    <p class="_btns">
      <?php if($this->paginator->getTotalItemCount() > 0):?>
    	<button onClick="submitVotingData();return false;"><?php echo $this->translate("Submit Vote");?></button>
      <?php endif;?>
      <a href="javascript:void(0)" onclick="sessmoothboxclose();" class="_cls">X</a>
    </p>
  </header>
  <section class="sescontest_voting_popup_cont" id="sescontest_voting_container_elem">
 <?php } ?>
   <?php if($this->paginator->getTotalItemCount() > 0){
   foreach ($this->paginator as $item){ ?>
   
   <?php
    $imageURL = $item->getPhotoUrl('');
    if(strpos($imageURL,'http://') === FALSE && strpos($imageURL,'https://') === FALSE)
      {
      if(strpos($imageURL,',') === false)   
        $imageGetSizeURL = $_SERVER['DOCUMENT_ROOT']. DIRECTORY_SEPARATOR . $imageURL;    
      else            
        $imageGrtSizeURL = $_SERVER['DOCUMENT_ROOT']. DIRECTORY_SEPARATOR . substr($imageURL, 0, strpos($imageURL, "?"));
      }
    else
      $imageGetSizeURL = $imageURL;
    $imageHeightWidthData = getimagesize($imageGetSizeURL);           
    $width = isset($imageHeightWidthData[0]) ? $imageHeightWidthData[0] : '300';
    $height = isset($imageHeightWidthData[1]) ? $imageHeightWidthData[1] : '200'; 
   ?>
   <?php $contest = Engine_Api::_()->getItem('contest', $item->contest_id);?>
   <?php $contest_id = $contest->contest_id; ?>
  	<div class="_thumb sesbasic_list_photo_grid" data-w="<?php echo $width ?>" data-h="<?php echo $height; ?>"  rel="<?php echo $item->getIdentity(); ?>">
    	<a href="javascript:;" class="selectvoting"><img src="<?php echo $item->getPhotoUrl(); ?>" /></a>
      <?php if(!$this->viewer()->getIdentity()):?><?php $levelId = 5;?><?php else:?><?php $levelId = $this->viewer()->level_id;?><?php endif;?>
    <?php $voteType = Engine_Api::_()->authorization()->getPermission($levelId, 'participant', 'allow_entry_vote');?>
    <?php if ($voteType != 0 && (($voteType == 1 && $item->owner_id != $this->viewer()->getIdentity()) || $voteType == 2)){ ?>
        <?php if(strtotime($contest->votingstarttime) <= time() && strtotime($contest->votingendtime) > time() && strtotime($contest->endtime) > time()){ ?>
          <?php $hasVoted = Engine_Api::_()->getDbTable('votes', 'sescontest')->hasVoted($this->viewer()->getIdentity(), $contest_id, $item->participant_id); ?>
          <?php if($hasVoted):?>
            <?php //already voted test ?>
            <a class="_votebtn fa fa-hand-o-up" href="javascript:;" style="display:block;"><span class="_votmgg"><?php echo $this->translate('Already voted'); ?></span> </a>
          <?php endif; ?>
          <?php }else{ ?>
          <a class="_votebtn fa fa-hand-o-up" href="javascript:;" style="display:block;"><span class="_votmgg"><?php echo $this->translate('Voting ended'); ?></span> </a>
          <?php } ?>
        <?php } ?>
     
      <a class="_votebtn fa fa-hand-o-up deselectvoting" href="javascript:;" style="display:none;"></a>    
    </div>
  <?php } ?>
  <?php }else{ ?>
    <div class="sesbasic_tip clearfix">
      <img src="application/modules/Sescontest/externals/images/contest-icon.png" alt="">
      <span>
        <?php echo $this->translate("No one has participated in this contest yet!")?></span>
    </div>
  <?php } ?>   
<?php if(!$this->is_ajax){ ?>
  </section>
  <div class="sescontest_voting_popup_loading_wrapper" style="display:none;">
    <div class="sescontest_voting_popup_loading">
    <div class="dot"></div>
    <div class="dot"></div>
    <div class="dot"></div>
  </div>
</div>
  <div class="sescontest_voting_thanks_popup sesbasic_bxs" style="display:none;">
  <div class="_bigicon"><i class="fa fa-hand-o-up sesbasic_text_light"></i></div>
  <div class="_cont">
  	<span class="_title"><?php echo $this->translate("Thanks for voting");?></span>
    <span class="_des"><?php echo $this->translate("your voice was heard");?></span>
    <span class="_btns">
    	<button onClick="sessmoothboxclose();return false;"><?php echo $this->translate("Done");?></button>
    </span>
  </div>
</div>
</div>
<div class="sesbasic_load_btn" id="view_more_<?php echo $randonNumber;?>" onclick="viewMore_<?php echo $randonNumber; ?>();" >
    <a href="javascript:void(0);" class="sesbasic_animation sesbasic_link_btn" id="feed_viewmore_link_<?php echo $randonNumber; ?>"><i class="fa fa-repeat"></i><span><?php echo $this->translate('View More');?></span></a>
  </div>  
  <div class="sesbasic_load_btn sesbasic_view_more_loading_<?php echo $randonNumber;?>" id="loading_image_<?php echo $randonNumber; ?>" style="display: none;"><span class="sesbasic_link_btn"><i class="fa fa-spinner fa-spin"></i></span></div>
  
<script type="application/javascript">
en4.core.runonce.add(function(){
 sesJqueryObject("#sescontest_voting_container_elem").sesbasicFlexImage({rowHeight: 400,truncate:false});
});
function submitVotingData(){
    var valuesData = sesJqueryObject('#submitdatavalue').val();
    var values = sesJqueryObject.trim(valuesData);
    if(!values || values == ""){
      alert("Please select atleast one photo to vote.");
      return false;
    }
    sesJqueryObject('.sescontest_voting_popup_loading_wrapper').show();
     requestViewMore_<?php echo $randonNumber; ?> = new Request.HTML({
        method: 'post',
        'url': en4.core.baseUrl + "sescontest/vote/voteall",
        'data': {
            format: 'html',
            values: valuesData,    
            is_ajax : 1,
        },
        onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {            
            if(responseHTML == 1){
              sesJqueryObject('.sescontest_voting_popup_loading_wrapper').hide();
              sesJqueryObject('.sescontest_voting_thanks_popup').show();  
              
              var str_array = valuesData.split(' ');
              for(var i = 0; i < str_array.length; i++) {
                var objElem = sesJqueryObject('#sescontest_vote_button_'+str_array[i]); 
                sesJqueryObject(objElem).html('<i class="fa fa-hand-o-up"></i><span >'+en4.core.language.translate("Voted")+'</span>');
                sesJqueryObject(objElem).addClass('disable'); 
              }
              
              
            }else{
              sesJqueryObject('.sescontest_voting_popup_loading_wrapper').hide();
              alert('Something went wrong, please try again later.');  
            }
        },
        onError:function(){
          alert('Something went wrong, please try again later.');  
        }
    });
    requestViewMore_<?php echo $randonNumber; ?>.send();    
}
</script>
<?php } ?>
<script type="application/javascript">
en4.core.runonce.add(function(){
  viewMoreHide_<?php echo $randonNumber; ?>();	
});
function viewMoreHide_<?php echo $randonNumber; ?>() {
    if ($('view_more_<?php echo $randonNumber; ?>'))
    $('view_more_<?php echo $randonNumber; ?>').style.display = "<?php echo ($this->paginator->count() == 0 ? 'none' : ($this->paginator->count() == $this->paginator->getCurrentPageNumber() ? 'none' : '' )) ?>";
}
var page<?php echo $randonNumber; ?> = '<?php echo $this->page + 1; ?>';
function viewMore_<?php echo $randonNumber; ?> (){
    sesJqueryObject('#view_more_<?php echo $randonNumber; ?>').hide();
    sesJqueryObject('#loading_image_<?php echo $randonNumber; ?>').show(); 
    requestViewMore_<?php echo $randonNumber; ?> = new Request.HTML({
        method: 'post',
        'url': en4.core.baseUrl + "sescontest/index/votes/contest_id/<?php echo $this->contest_id; ?>",
        'data': {
            format: 'html',
            page: page<?php echo $randonNumber; ?>,    
            is_ajax : 1,
        },
        onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {            
            document.getElementById('sescontest_voting_container_elem').innerHTML = document.getElementById('sescontest_voting_container_elem').innerHTML + responseHTML;
            viewMoreHide_<?php echo $randonNumber; ?>();	
            sesJqueryObject("#sescontest_voting_container_elem").sesbasicFlexImage({rowHeight: 400,truncate:false});
        }
    });
    requestViewMore_<?php echo $randonNumber; ?>.send();
    return false;
}
</script>