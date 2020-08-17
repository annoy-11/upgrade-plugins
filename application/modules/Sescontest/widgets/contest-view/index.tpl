<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescontest
 * @package    Sescontest
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2017-12-01 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $contest = $this->contest;?>
<?php $isContestEdit = Engine_Api::_()->sescontest()->contestPrivacy($contest, 'edit');?>
<?php if (Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sescontestpackage') && Engine_Api::_()->getApi('settings', 'core')->getSetting('sescontestpackage.enable.package', 0)):?>
  <?php $params = Engine_Api::_()->getItem('sescontestpackage_package', $this->contest->package_id)->params;?>
  <?php $params = json_decode($params, true);?>
  <?php $canUploadCover = $params['upload_cover'];?>
<?php else:?>
  <?php $canUploadCover = Engine_Api::_()->authorization()->isAllowed('contest', $this->viewer(), 'upload_cover');?>
<?php endif;?>
<?php if($isContestEdit):?>
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/webcam.js'); ?>
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/imagesloaded.pkgd.js');?>
   <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery-ui.min.js'); ?>
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.drag-n-crop.js');?>
<?php endif;?>
  <?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sescontest/externals/styles/styles.css'); ?>
<?php $isContestDelete = Engine_Api::_()->sescontest()->contestPrivacy($contest, 'delete');?>
<?php $contest = $this->contest;?>
<?php $owner = $contest->getOwner();?>
<?php $participate = Engine_Api::_()->getDbTable('participants', 'sescontest')->hasParticipate($this->viewer()->getIdentity(), $contest->contest_id);?>
<?php if(is_numeric($this->params['cover_height'])):?>
  <?php $height = $this->params['cover_height'].'px';?>
<?php else:?>
  <?php $height = $this->params['cover_height'];?>
<?php endif;?>
<?php if($this->params['layout_type'] == 2):?>
  <div class="sescontest_view_container sesbasic_clearfix sesbasic_bxs">
    <div class="sescontest_view_top sesbasic_clearfix">
      <div class="sescontest_view_owner_photo">
        <?php if($this->params['photo_type'] == 'ownerPhoto'):?>
          <?php if($owner->photo_id):?>
             <a href="<?php echo $owner->getHref();?>"><img src="<?php echo Engine_Api::_()->storage()->get($owner->photo_id)->getPhotoUrl('thumb.icon'); ?>" alt=""></a>
           <?php else:?>
             <a href="<?php echo $owner->getHref();?>"><img src="application/modules/User/externals/images/nophoto_user_thumb_icon.png" alt=""></a>
           <?php endif;?>
         <?php elseif($this->params['photo_type'] == 'contestPhoto'):?>
          <?php if($this->contest->photo_id):?>
            <a href="<?php echo $this->contest->getHref();?>"><img src="<?php echo Engine_Api::_()->storage()->get($this->contest->photo_id)->getPhotoUrl('thumb.icon'); ?>" alt=""></a>
          <?php else:?>
            <a href="<?php echo $this->contest->getHref();?>"><img src="application/modules/user/externals/images/nophoto_user_thumb_icon.png" alt=""></a>
          <?php endif;?>
         <?php endif;?>
      </div>
      <div class="sescontest_view_top_cont">
          <?php if(isset($this->titleActive)):?><h1><?php echo $contest->title;?><?php if(isset($this->verifiedLabelActive) && $this->contest->verified):?><i class="sescontest_label_verified fa fa-check-circle" title='<?php echo $this->translate("Verified");?>'></i><?php endif;?></h1><?php endif;?>
          <p class="sesbasic_clearfix sesbasic_text_light">
            <?php if(isset($this->byActive)):?>
              <span><?php echo $this->translate('by ');?><?php echo $this->htmlLink($owner->getHref(), $owner->getTitle()) ?></span>
            <?php endif;?>
            <span class="sescontest_view_stats"><?php if(isset($this->byActive)):?>&nbsp;|&nbsp;<?php endif;?> 
              <?php include APPLICATION_PATH .  '/application/modules/Sescontest/views/scripts/_dataStatics.tpl';?>
              <?php if(isset($this->entryCountActive)):?>
                <span title="<?php echo $this->translate(array('%s Entry', '%s Entries', $contest->join_count), $this->locale()->toNumber($contest->join_count)) ?>">
                  <i class="fa fa-sign-in"></i>
                  <span><?php echo $contest->join_count;?></span>
                </span>
              <?php endif;?>
            </span>
          </p>
      </div>
      <div class="sescontest_view_type">
        <?php include APPLICATION_PATH .  '/application/modules/Sescontest/views/scripts/_mediaType.tpl';?> 
      </div>  
    </div>
    <div class="sescontest_view_main_photo">
      <div class="sescontest_cover_inner sescontest_default_cover" style="height:<?php echo $height ?>;">
        <img id="sescontest_cover_id" src="<?php echo $contest->getCoverPhotoUrl() ?>" style="top:<?php echo $contest->cover_position ? $contest->cover_position : '0px'; ?>;" />
      </div>
      <div id="sescontest_cover_photo_loading" class="sesbasic_loading_cont_overlay"></div>
      <div class="sescontest_cover_content">
      <div class="sescontest_view_labels">
        <?php if(isset($this->featuredLabelActive) && $contest->featured):?>
          <span class="sescontest_label_featured" title="<?php echo $this->translate("Featured");?>"><i class="fa fa-star"></i></span>
        <?php endif;?>
        <?php if(isset($this->sponsoredLabelActive) && $contest->sponsored):?>
          <span class="sescontest_label_sponsored" title="<?php echo $this->translate("Sponsored");?>"><i class="fa fa-star"></i></span>
        <?php endif;?>
        <?php if(isset($this->hotLabelActive) && $contest->hot):?>
          <span class="sescontest_label_hot" title="<?php echo $this->translate("Hot");?>"><i class="fa fa-star"></i></span>
        <?php endif;?>
      </div>
            <?php if($isContestEdit && $canUploadCover):?>
        <div class="sescontest_cover_change_btn" id="sescontest_change_cover_op">
          <a href="javascript:;" id="cover_change_btn">
            <i class="fa fa-camera" id="cover_change_btn_i"></i>
            <span id="change_cover_txt"><?php echo $this->translate("Upload Cover Photo"); ?></span>
          </a>
          <div class="sescontest_cover_change_options sesbasic_option_box"> 
            <i class="sesusercoverphoto_change_cover_options_main_arrow"></i>
             <input type="file" id="uploadFilesescontest" name="art_cover" onchange="uploadCoverArt(this);"  style="display:none" />
             <a id="uploadWebCamPhoto" href="javascript:;"><i class="fa fa-camera"></i><?php echo $this->translate("Take Photo"); ?></a>
             <a id="coverChangesescontest" data-src="<?php echo $contest->cover; ?>" href="javascript:;"><i class="fa fa-plus"></i>
             <?php echo (isset($contest->cover) && $contest->cover != 0 && $contest->cover != '') ? $this->translate('Change Cover Photo') : $this->translate('Add Cover Photo'); ?></a>
              <a id="coverRemovesescontest" style="display:<?php echo (isset($contest->cover) && $contest->cover != 0 && $contest->cover != '') ? 'block' : 'none' ; ?>;" data-src="<?php echo $contest->cover; ?>" href="javascript:;"><i class="fa fa-trash"></i><?php echo $this->translate('Remove Cover Photo'); ?></a>
              <a style="display:<?php echo (isset($contest->cover) && $contest->cover != 0 && $contest->cover != '') ? 'block' : 'none' ; ?>;" href="javascript:;" id="sescontest_cover_photo_reposition"><i class="fa fa-arrows-alt"></i><?php echo $this->translate("Reposition"); ?></a>  
          </div>
        </div>
      <?php endif;?>
      <?php if(isset($this->statusLabelActive)):?>
        <div class="sescontest_view_status">
          <?php if(strtotime(date('Y-m-d H:i:s')) > strtotime($contest->endtime)):?>
            <span class="_ended"><?php echo $this->translate('Ended');?></span>
          <?php elseif(strtotime(date('Y-m-d H:i:s')) < strtotime($contest->starttime)):?>
            <span class="_comingsoon"><?php echo $this->translate('Coming Soon');?></span>
          <?php elseif(strtotime(date('Y-m-d H:i:s')) >= strtotime($contest->starttime)):?>
            <span class="_active"><?php echo $this->translate('Active');?></span>
          <?php endif;?>
        </div>
      <?php endif;?>
      </div>
      <?php if($isContestEdit && $canUploadCover):?>
        <div class="sescontest_cover_reposition_btn" style="display:none;">
          <a class="sesbasic_button" href="javascript:;" id="savereposition"><?php echo $this->translate("Save"); ?></a>
        	<a class="sesbasic_button" href="javascript:;" id="cancelreposition"><?php echo $this->translate("Cancel"); ?></a>
        </div>
      <?php endif;?>
    </div>
    <div class="sescontest_view_btns sesbasic_clearfix">
      <div class="floatL">
        <div class="sescontest_view_social_btns">
          <?php include APPLICATION_PATH .  '/application/modules/Sescontest/views/scripts/_dataSharing.tpl';?>               
        </div>
      </div>
      <div class="floatR sescontest_view_btns_right">
        <?php if(isset($this->joinButtonActive) && isset($participate['can_join']) && isset($participate['show_button']) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sescontestjoinfees.allow.entryfees', 1)): ?>
        <span><a href="<?php echo $this->url(array('action' => 'create', 'contest_id' => $contest->contest_id),'sescontest_join_contest','true');?>" class="contest_join_btn"><i class="fa fa-sign-in"></i>
          <?php if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sescontestjoinfees') && $contest->entry_fees > 0){ ?>
            <span><?php echo $this->translate('Join Contest').'<br>'.Engine_Api::_()->sescontestjoinfees()->getCurrencyPrice($contest->entry_fees);;?></span></a>
          <?php }else{ ?>
            <span><?php echo $this->translate('Join Contest');?></span></a>
          <?php } ?>
        </span>
        <?php endif;?>
        <?php if(isset($this->optionMenuActive)):?>
          <span><a href="javascript:void(0);" class="sesbasic_button sescontest_view_option_btn" id="sescontest_view_option_btn"><i class="fa fa-cog"></i></a></span>
        <?php endif;?>
      </div>
    </div>
    <?php if(isset($this->descriptionActive)):?>
      <div class="sescontest_view_des">
        <p><?php echo $this->string()->truncate($contest->description, $this->params['description_truncation']) ?></p>
      </div>
    <?php endif;?>
    <div class="sescontest_view_meta sesbasic_clearfix">
      <?php if(isset($this->mediaTypeActive)):?>
        <div>
          <span><?php echo $this->translate('Media Type:');?>&nbsp;</span>
          <span><?php if($contest->contest_type == 1):?><a href="<?php echo $this->url(array('action' => 'text'),'sescontest_media',true);?>"><?php echo $this->translate('Writing Contest');?></a><?php elseif($contest->contest_type == 2):?><a href="<?php echo $this->url(array('action' => 'photo'),'sescontest_media',true);?>"><?php echo $this->translate('Photo Contest');?></a><?php elseif($contest->contest_type == 3):?><a href="<?php echo $this->url(array('action' => 'video'),'sescontest_media',true);?>"><?php echo $this->translate('Video Contest');?></a><?php else:?><a href="<?php echo $this->url(array('action' => 'audio'),'sescontest_media',true);?>"><?php echo $this->translate('Audio Contest');?></a><?php endif;?></span>
        </div>
      <?php endif;?>
      <?php if(isset($this->categoryActive) && $this->category):?>
        <div>
          <span><?php echo $this->translate('Category:');?>&nbsp;</span>
          <span><a href="<?php echo $this->category->getHref();?>"><?php echo $this->category->category_name;?></a></span>
        </div>
      <?php endif;?>
      <?php if(isset($this->tagActive)):?>
        <div>
          <span><?php echo $this->translate('Tags:');?>&nbsp;</span>
          <?php if (count($this->contestTags )):?>
            <span>
              <?php foreach ($this->contestTags as $tag):?>
                <?php if(empty($tag->getTag()->text)):?><?php continue;?><?php endif;?>
                <a href='javascript:;' onclick='javascript:tagAction(<?php echo $tag->getTag()->tag_id; ?>,"<?php echo $tag->getTag()->text; ?>");'>#<?php echo $tag->getTag()->text?></a>&nbsp;
              <?php endforeach; ?>
            </span>
          <?php endif; ?>
        </div>
      <?php endif;?>
    </div>
    <div class="sescontest_view_time sesbasic_clearfix">
      <div>
        <span>
          <?php $dateinfoParams['starttime'] = true; ?>
          <?php $dateinfoParams['endtime'] = true; ?>
          <?php $dateinfoParams['timezone']  =  true; ?>
          <?php echo $this->contestStartEndDates($contest, $dateinfoParams);?>
        </span>
      </div>
      <div>
        <span>
          <?php $dateinfoParams = array();?>
          <?php $dateinfoParams['joinstarttime'] = true; ?>
          <?php $dateinfoParams['joinendtime'] = true; ?>
          <?php $dateinfoParams['timezone']  =  true; ?>
          <?php echo $this->contestStartEndDates($contest, $dateinfoParams);?>
        </span>
      </div>
      <div>
        <span>
          <?php $dateinfoParams = array();?>
          <?php $dateinfoParams['votingstarttime'] = true; ?>
          <?php $dateinfoParams['votingendtime'] = true; ?>
          <?php $dateinfoParams['timezone']  =  true; ?>
          <?php echo $this->contestStartEndDates($contest, $dateinfoParams);?>
        </span>
      </div>
    </div>
  </div>
  <?php if(isset($this->optionMenuActive)):?>
    <div id="sescontest_cover_options_wrap">
      <div class="sescontest_view_options sescontest_options_dropdown" id="sescontest_view_options">
          <span class="sescontest_options_dropdown_arrow"></span>
          <div class="sescontest_options_dropdown_links">
          <ul>
            <?php if($isContestEdit):?>
              <li><a href="<?php echo $this->url(array('action' => 'edit', 'contest_id' => $contest->custom_url), 'sescontest_dashboard', 'true');?>" class="buttonlink sesbasic_icon_edit"><?php echo $this->translate('Edit Contest');?></a></li>
                <?php endif;?>
              <?php if($isContestDelete):?>
                <li><a href="<?php echo $this->url(array('contest_id' => $contest->contest_id,'action'=>'delete'), 'sescontest_general', true); ?>" class="buttonlink sesbasic_icon_delete smoothbox"><?php echo$this->translate('Delete Contest');?></a></li>
              <?php endif;?>

            <?php if($this->viewer_id):?>
              <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sescontest.allow.share', 1)):?>
                <li><a href="<?php echo $this->url(array("module" => "activity","controller" => "index","action" => "share", "type" => $contest->getType(), "id" => $contest->getIdentity(), "format" => "smoothbox"), 'default', true);?>" class="buttonlink sesbasic_icon_share smoothbox"><?php echo $this->translate('Share Contest');?></a></li>
              <?php endif;?>
              <?php if(($this->viewer_id != $contest->user_id) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sescontest.allow.report', 1)):?>
                <li><a href="<?php echo $this->url(array("module" => "core","controller" => "report","action" => "create", 'subject' => $contest->getGuid()),'default', true);?>" class="buttonlink sesbasic_icon_report smoothbox"><?php echo $this->translate('Report Contest');?></a></li>
              <?php endif;?>
            <?php endif;?>
          </ul>
        </div>
      </div>
    </div>
  <?php endif;?>
  <script type="text/javascript">
    function doResizeForButton(){
        if(!sesJqueryObject(".sescontest_view_option_btn").length) 
          return;
        var topPositionOfParentSpan =  sesJqueryObject(".sescontest_view_option_btn").offset().top + 34;
        topPositionOfParentSpan = topPositionOfParentSpan+'px';
        var leftPositionOfParentSpan =  sesJqueryObject(".sescontest_view_option_btn").offset().left - 96;
        leftPositionOfParentSpan = leftPositionOfParentSpan+'px';
        sesJqueryObject('.sescontest_view_options').css('top',topPositionOfParentSpan);
        sesJqueryObject('.sescontest_view_options').css('left',leftPositionOfParentSpan);
    }
    window.addEventListener("scroll", function(event) {
      doResizeForButton();
    });
    window.addEvent('load',function(){
      doResizeForButton();
    });
    sesJqueryObject(document).ready(function(){
      sesJqueryObject("<div>"+sesJqueryObject("#sescontest_cover_options_wrap").html()+'</div>').appendTo('body');
      sesJqueryObject('#sescontest_cover_options_wrap').remove();
      doResizeForButton();
    });
    sesJqueryObject(window).resize(function(){
      doResizeForButton();
    });
    if($('sescontest_view_option_btn')) {
      $('sescontest_view_option_btn').addEvent('click', function(event){
          event.stop();
          if(sesJqueryObject('#sescontest_view_options').hasClass('show-options'))
              sesJqueryObject('#sescontest_view_options').removeClass('show-options');
          else
              sesJqueryObject('#sescontest_view_options').addClass('show-options');
          return false;
      });
    }
    var tagAction = window.tagAction = function(tag,name){
      var url = "<?php echo $this->url(array('module' => 'sescontest'), 'sescontest_general', true) ?>?tag_id="+tag+'&tag_name='+name;
      window.location.href = url;
    }
  </script>
<?php else:?>
  <?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sescontest/externals/styles/style_cover.css'); ?>
  <?php // Cover Layout code ?>
  <div class="sescontest_cover_container sesbasic_clearfix sesbasic_bxs <?php if($this->params['show_full_width'] == 'yes'){ ?>sescontest_cover_container_full <?php } ?>" style="<?php if($this->params['show_full_width'] == 'yes'):?>margin-top:-<?php echo is_numeric($this->params['margin_top']) ? $this->params['margin_top'].'px' : $this->params['margin_top']?>;<?php endif;?>">
    <div class="sescontest_cover" style="height:<?php echo $height ?>;">
      <div class="sescontest_cover_inner sesbasic_clearfix">
        <div class="sescontest_default_cover" style="height:<?php echo $height ?>;">
          <img id="sescontest_cover_id" src="<?php echo $contest->getCoverPhotoUrl() ?>" style="top:<?php echo $contest->cover_position ? $contest->cover_position : '0px'; ?>;" />
        </div>
        <div class="sescontest_cover_content">		
           <div class="sescontest_cover_owner_info sesbasic_clearfix">
           	<span class="_media"><?php include APPLICATION_PATH .  '/application/modules/Sescontest/views/scripts/_mediaType.tpl';?></span>
            <div class="_photo">
              <?php if($this->params['photo_type'] == 'ownerPhoto'):?>
               <?php if($owner->photo_id):?>
                 <a href="<?php echo $owner->getHref();?>"><img src="<?php echo Engine_Api::_()->storage()->get($owner->photo_id)->getPhotoUrl('thumb.icon'); ?>" alt=""></a>
               <?php else:?>
                 <a href="<?php echo $owner->getHref();?>"><img src="application/modules/User/externals/images/nophoto_user_thumb_icon.png" alt=""></a>
               <?php endif;?>
             <?php elseif($this->params['photo_type'] == 'contestPhoto'):?>
              <?php if($this->contest->photo_id):?>
                <a href="<?php echo $this->contest->getHref();?>"><img src="<?php echo Engine_Api::_()->storage()->get($this->contest->photo_id)->getPhotoUrl('thumb.icon'); ?>" alt=""></a>
              <?php else:?>
                <a href="<?php echo $this->contest->getHref();?>"><img src="application/modules/user/externals/images/nophoto_user_thumb_icon.png" alt=""></a>
              <?php endif;?>
             <?php endif;?>
            </div>
            <div class="_cont">
              <p class="sesbasic_clearfix">
                <?php if(isset($this->byActive)):?>
                  <span><?php echo $this->translate('by ');?><?php echo $this->htmlLink($owner->getHref(), $owner->getTitle()) ?></span>
                <?php endif;?>
              </p>
            </div>
          </div>
          <div class="sescontest_cover_mid_cont">
           <h1><?php echo $contest->title;?><?php if(isset($this->verifiedLabelActive) && $this->contest->verified):?><i class="sescontest_label_verified fa fa-check-circle" title='<?php echo $this->translate("Verified");?>'></i><?php endif;?></h1>
            <?php  if(isset($this->joinButtonActive)):?>
              <div class="sescontest_cover_btns">
                <?php if(isset($participate['can_join']) && isset($participate['show_button'])):?>
                  <span>
                    <a href="<?php echo $this->url(array('action' => 'create', 'contest_id' => $contest->contest_id),'sescontest_join_contest','true');?>"><i class="fa fa-sign-in"></i>
                    <?php if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sescontestjoinfees') && $contest->entry_fees > 0 && Engine_Api::_()->getApi('settings', 'core')->getSetting('sescontestjoinfees.allow.entryfees', 1)){ ?>
                      <span><?php echo $this->translate('Join Contest').'<span> '. $this->translate("in") .' '.Engine_Api::_()->sescontestjoinfees()->getCurrencyPrice($contest->entry_fees);?></span></span></a>
                    <?php }else{ ?>
                      <span><?php echo $this->translate('Join Contest');?></span></a>
                    <?php } ?>
                  </a>
                 </span>
                <?php endif;?>
                  <?php if(!$this->viewer()->getIdentity()):?><?php $levelId = 5;?><?php else:?><?php $levelId = $this->viewer()->level_id;?><?php endif;?>
              <?php $voteType = Engine_Api::_()->authorization()->getPermission($levelId, 'participant', 'allow_entry_vote');?>
               <?php if ($contest->contest_type == 2 && $voteType != 0 && (($voteType == 1) || $voteType == 2)):?>  
              	  <?php if(strtotime($contest->votingstarttime) <= time() && strtotime($contest->votingendtime) > time() && strtotime($contest->endtime) > time()):?>
                  <?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sescontest/externals/styles/style_voting_popup.css');                  $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.flex-images.js');
                  ?> 
                  <?php $canVote = 1;?>
                  <?php if ($levelId != 5 && Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sescontestjurymember') && $contest->audience_type == 0):?>
                    <?php $isViewerJury = Engine_Api::_()->getDbTable('members', 'sescontestjurymember')->isJuryMember(array('user_id' => $this->viewer()->getIdentity(), 'contest_id' => $contest->contest_id));?>
                    <?php if(!$isViewerJury):?>
                      <?php $canVote = 0;?>
                    <?php endif;?>
                  <?php endif;?>
                  <?php if($canVote):?>
                    <span><a href="javascript:;" data-addclass="sescontest_voting_popup_container" class="sessmoothbox" data-url="sescontest/index/votes/contest_id/<?php echo $contest->getIdentity(); ?>"><i class="fa fa-hand-o-up"></i><?php echo $this->translate("VOTE"); ?></a></span>
                  <?php endif;?>
                 <?php endif; ?>
               <?php endif; ?>   
              </div>
            <?php endif;?>
            <?php if($this->params['tab_type'] == 'center' || $this->params['tab_placement'] == 'out'):?>
              <div class="sescontest_cover_social_btns_in">
                <?php include APPLICATION_PATH .  '/application/modules/Sescontest/views/scripts/_dataSharing.tpl';?>
                <?php if(isset($this->optionMenuActive)):?>
                  <a href="javascript:void(0);" class="sesbasic_icon_btn" id="sescontest_cover_option_btn"><i class="fa fa-cog"></i></a>
                <?php endif;?>
              </div>
            <?php endif;?>
          </div>
          <div class="sescontest_cover_labels sesbasic_animation">
            <?php if(isset($this->featuredLabelActive) && $contest->featured):?>
              <span class="sescontest_label_featured" title="<?php echo $this->translate("Featured");?>"><i class="fa fa-star"></i></span>
            <?php endif;?>
            <?php if(isset($this->sponsoredLabelActive) && $contest->sponsored):?>
              <span class="sescontest_label_sponsored" title="<?php echo $this->translate("Sponsored");?>"><i class="fa fa-star"></i></span>
            <?php endif;?>
            <?php if(isset($this->hotLabelActive) && $contest->hot):?>
              <span class="sescontest_label_hot" title="<?php echo $this->translate("Hot");?>"><i class="fa fa-star"></i></span>
            <?php endif;?>
          </div>
          <?php if($this->params['tab_placement'] == 'in'):?>
            <?php if($this->params['tab_type'] == 'full'):?>
              <div class="sescontest_cover_footer sesbasic_clearfix">
                <div class="sescontest_cover_footer_inner sesbasic_clearfix">
                  <div class="sescontest_cover_social_btns">
                    <?php include APPLICATION_PATH .  '/application/modules/Sescontest/views/scripts/_dataSharing.tpl';?>
                    <?php if(isset($this->optionMenuActive)):?>
                      <a href="javascript:void(0);" class="sesbasic_icon_btn" id="sescontest_cover_option_btn"><i class="fa fa-cog"></i></a>
                    <?php endif;?>
                  </div>
                  <div class="sescontest_cover_tabs"></div>
                </div>  
              </div>
            <?php endif;?>
            <?php if($this->params['tab_type'] == 'center'):?>
              <div class="sescontest_cover_footer_section sesbasic_clearfix">
                <div class="sescontest_cover_footer_section_inner sesbasic_clearfix">
                  <div class="sescontest_cover_tabs"></div>
                </div>
              </div>
            <?php endif;?> 
          <?php endif;?>
          <span class="sescontest_cover_fade"></span>
          <?php if($isContestEdit && $canUploadCover):?>
            <div class="sescontest_cover_change_btn" id="sescontest_change_cover_op">
              <a href="javascript:;" id="cover_change_btn">
                <i class="fa fa-camera" id="cover_change_btn_i"></i>
                <span id="change_cover_txt"><?php echo $this->translate("Upload Cover Photo"); ?></span>
              </a>
              <div class="sescontest_cover_change_options sesbasic_option_box"> 
                <i class="sesusercoverphoto_change_cover_options_main_arrow"></i>
                 <input type="file" id="uploadFilesescontest" name="art_cover" onchange="uploadCoverArt(this);"  style="display:none" />
                 <a id="uploadWebCamPhoto" href="javascript:;"><i class="fa fa-camera"></i><?php echo $this->translate("Take Photo"); ?></a>
                 <a id="coverChangesescontest" data-src="<?php echo $contest->cover; ?>" href="javascript:;"><i class="fa fa-plus"></i>
                 <?php echo (isset($contest->cover) && $contest->cover != 0 && $contest->cover != '') ? $this->translate('Change Cover Photo') : $this->translate('Add Cover Photo'); ?></a>
                  <a id="coverRemovesescontest" style="display:<?php echo (isset($contest->cover) && $contest->cover != 0 && $contest->cover != '') ? 'block' : 'none' ; ?>;" data-src="<?php echo $contest->cover; ?>" href="javascript:;"><i class="fa fa-trash"></i><?php echo $this->translate('Remove Cover Photo'); ?></a>
                  <a style="display:<?php echo (isset($contest->cover) && $contest->cover != 0 && $contest->cover != '') ? 'block' : 'none' ; ?>;" href="javascript:;" id="sescontest_cover_photo_reposition"><i class="fa fa-arrows-alt"></i><?php echo $this->translate("Reposition"); ?></a>        
              </div>
            </div>
           <?php endif;?>
        </div>
        <div id="sescontest_cover_photo_loading" class="sesbasic_loading_cont_overlay"></div>
        <?php if($isContestEdit && $canUploadCover):?>
          <div class="sescontest_cover_reposition_btn" style="display:none;">
            <a class="sesbasic_button" href="javascript:;" id="savereposition"><?php echo $this->translate("Save"); ?></a>
            <a class="sesbasic_button" href="javascript:;" id="cancelreposition"><?php echo $this->translate("Cancel"); ?></a>
          </div>
        <?php endif;?>
      </div> 
    </div>
  </div>
  <?php if(isset($this->optionMenuActive)):?>
  <div id="sescontest_cover_options_wrap">
    <div class="sescontest_cover_options sescontest_options_dropdown" id="sescontest_cover_options">
      <span class="sescontest_options_dropdown_arrow"></span>
      <div class="sescontest_options_dropdown_links">
        <ul>
          <?php if($isContestEdit):?>
            <li><a href="<?php echo $this->url(array('action' => 'edit', 'contest_id' => $contest->custom_url), 'sescontest_dashboard', 'true');?>" class="buttonlink sesbasic_icon_edit"><?php echo $this->translate('Edit Contest');?></a></li>
            <?php if($isContestDelete):?>
              <li><a href="<?php echo $this->url(array('contest_id' => $contest->contest_id,'action'=>'delete'), 'sescontest_general', true); ?>" class="buttonlink sesbasic_icon_delete smoothbox"><?php echo$this->translate('Delete Contest');?></a></li>
            <?php endif;?>
          <?php endif;?>
          <?php if($this->viewer_id):?>
            <li><a href="<?php echo $this->url(array("module" => "activity","controller" => "index","action" => "share", "type" => $contest->getType(), "id" => $contest->getIdentity(), "format" => "smoothbox"), 'default', true);?>" class="buttonlink sesbasic_icon_share smoothbox"><?php echo $this->translate('Share Contest ');?></a></li>
          <?php endif;?>
          <?php if(($this->viewer_id && $this->viewer_id != $contest->user_id) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sescontest.allow.report', 1)):?>
            <li><a href="<?php echo $this->url(array("module" => "core","controller" => "report","action" => "create", 'subject' => $contest->getGuid()),'default', true);?>" class="buttonlink sesbasic_icon_report smoothbox"><?php echo $this->translate('Report Contest');?></a></li>
          <?php endif;?>
        </ul>
      </div>
    </div>
  </div>
  <?php endif;?>
<script type="text/javascript">
  <?php if(isset($this->optionMenuActive)):?>
    function doResizeForButton(){
        if(!sesJqueryObject("#sescontest_cover_option_btn").length) 
          return;
        var topPositionOfParentSpan =  sesJqueryObject("#sescontest_cover_option_btn").offset().top + 44;
        topPositionOfParentSpan = topPositionOfParentSpan+'px';
        var leftPositionOfParentSpan =  sesJqueryObject("#sescontest_cover_option_btn").offset().left - 90;
        leftPositionOfParentSpan = leftPositionOfParentSpan+'px';
        sesJqueryObject('.sescontest_cover_options').css('top',topPositionOfParentSpan);
        sesJqueryObject('.sescontest_cover_options').css('left',leftPositionOfParentSpan);
    }
    window.addEventListener("scroll", function(event) {
      doResizeForButton();
    });
    window.addEvent('load',function(){
      doResizeForButton();
    });
    sesJqueryObject(document).ready(function(){
      sesJqueryObject("<div>"+sesJqueryObject("#sescontest_cover_options_wrap").html()+'</div>').appendTo('body');
      sesJqueryObject('#sescontest_cover_options_wrap').remove();
      doResizeForButton();
    });
    sesJqueryObject(window).resize(function(){
      doResizeForButton();
    });

    $('sescontest_cover_option_btn').addEvent('click', function(contest){
        contest.stop();
        if(sesJqueryObject('#sescontest_cover_options').hasClass('show-options'))
            sesJqueryObject('#sescontest_cover_options').removeClass('show-options');
        else
            sesJqueryObject('#sescontest_cover_options').addClass('show-options');
        return false;
    });
  <?php endif;?>
  <?php if($this->params['tab_placement'] == 'in'):?>
    if (matchMedia('only screen and (min-width: 767px)').matches) {
        sesJqueryObject(document).ready(function(){
        if(sesJqueryObject('.layout_core_container_tabs').length>0){
          var tabs = sesJqueryObject('.layout_core_container_tabs').find('.tabs_alt').get(0).outerHTML;
          sesJqueryObject('.layout_core_container_tabs').find('.tabs_alt').remove();
          sesJqueryObject('.sescontest_cover_tabs').html(tabs);
        }
      });
      sesJqueryObject(document).on('click','ul#main_tabs li > a',function(){
          if(sesJqueryObject(this).parent().hasClass('more_tab'))
              return;
          var index = sesJqueryObject(this).parent().index() + 1;
          var divLength = sesJqueryObject('.layout_core_container_tabs > div');
          for(i=0;i<divLength.length;i++){
              sesJqueryObject(divLength[i]).hide();
          }
          sesJqueryObject('.layout_core_container_tabs').children().eq(index).show();
      });
      sesJqueryObject(document).on('click','.tab_pulldown_contents ul li',function(){
       var totalLi = sesJqueryObject('ul#main_tabs > li').length;
       var index = sesJqueryObject(this).index();
       var divLength = sesJqueryObject('.layout_core_container_tabs > div');
          for(i=0;i<divLength.length;i++){
              sesJqueryObject(divLength[i]).hide();
          }
       sesJqueryObject('.layout_core_container_tabs').children().eq(index+totalLi).show();
      });
    }
  <?php endif;?>
</script>
<?php endif;?>

<script type="text/javascript">
  sesJqueryObject(document).click(function(event){
  if(event.target.id != 'sescontest_dropdown_btn' && event.target.id != 'a_btn' && event.target.id != 'i_btn'){
    sesJqueryObject('#sescontest_dropdown_btn').find('.sescontest_option_box1').css('display','none');
    sesJqueryObject('#a_btn').removeClass('active');
  }
  if(event.target.id == 'change_cover_txt' || event.target.id == 'cover_change_btn_i' || event.target.id == 'cover_change_btn'){
      if(sesJqueryObject('#sescontest_change_cover_op').hasClass('active'))
          sesJqueryObject('#sescontest_change_cover_op').removeClass('active')
      else
          sesJqueryObject('#sescontest_change_cover_op').addClass('active');

      sesJqueryObject('#sescontest_cover_option_main_id').removeClass('active');

  }else if(event.target.id == 'change_main_txt' || event.target.id == 'change_main_btn' || event.target.id == 'change_main_i'){
    if(sesJqueryObject('#sescontest_cover_option_main_id').hasClass('active'))
      sesJqueryObject('#sescontest_cover_option_main_id').removeClass('active')
    else
      sesJqueryObject('#sescontest_cover_option_main_id').addClass('active');
      sesJqueryObject('#sescontest_change_cover_op').removeClass('active');
  }else{
    sesJqueryObject('#sescontest_change_cover_op').removeClass('active');
    sesJqueryObject('#sescontest_cover_option_main_id').removeClass('active')
  }
  if(event.target.id == 'a_btn'){
    if(sesJqueryObject('#a_btn').hasClass('active')){
      sesJqueryObject('#a_btn').removeClass('active');
      sesJqueryObject('.sescontest_option_box1').css('display','none');
    }
    else{
      sesJqueryObject('#a_btn').addClass('active');
      sesJqueryObject('.sescontest_option_box1').css('display','block');
    }
  }else if(event.target.id == 'i_btn'){
    if(sesJqueryObject('#a_btn').hasClass('active')){
      sesJqueryObject('#a_btn').removeClass('active');
      sesJqueryObject('.sescontest_option_box1').css('display','none');
    }
    else{
      sesJqueryObject('#a_btn').addClass('active');
      sesJqueryObject('.sescontest_option_box1').css('display','block');
    }
  }	
});
  sesJqueryObject(document).on('click','#coverChangesescontest',function(){
    document.getElementById('uploadFilesescontest').click();	
  });
  function uploadCoverArt(input){
    var url = input.value;
    var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
    if (input.files && input.files[0] && (ext == "png" || ext == "jpeg" || ext == "jpg" || ext == 'PNG' || ext == 'JPEG' || ext == 'JPG')){
      uploadFileToServer(input.files[0]);
    }
  }
  function uploadFileToServer(files){
    sesJqueryObject('.sescontest_cover_inner').append('<div id="sescontest_cover_loading" class="sesbasic_loading_cont_overlay" style="display:block;"></div>');
    var formData = new FormData();
    formData.append('Filedata', files);
    uploadURL = 'sescontest/profile/upload-cover/id/<?php echo $contest->contest_id ?>';
    var jqXHR=sesJqueryObject.ajax({
    url: uploadURL,
    type: "POST",
    contentType:false,
    processData: false,
        cache: false,
        data: formData,
        success: function(response){
          response = sesJqueryObject.parseJSON(response);
          sesJqueryObject('#uploadFilesescontest').val('');
          sesJqueryObject('#sescontest_cover_loading').remove();
          sesJqueryObject('#sescontest_cover_id').attr('src', response.file);
          sesJqueryObject('#coverChangesescontest').html('<i class="fa fa-plus"></i>'+en4.core.language.translate('Change Cover Photo'));
          sesJqueryObject('#sescontest_cover_photo_reposition').css('display','block');
          sesJqueryObject('#coverRemovesescontest').css('display','block');
        }
    }); 
  }
  sesJqueryObject('#coverRemovesescontest').click(function(){
    sesJqueryObject(this).css('display','none');
    sesJqueryObject('.sescontest_cover_inner').append('<div id="sescontest_cover_loading" class="sesbasic_loading_cont_overlay" style="display:block;"></div>');
    uploadURL = en4.core.baseUrl+'sescontest/profile/remove-cover/id/<?php echo $contest->contest_id ?>';
    var jqXHR=sesJqueryObject.ajax({
          url: uploadURL,
          type: "POST",
          contentType:false,
          processData: false,
          cache: false,
      success: function(response){
          sesJqueryObject('#coverChangesescontest').html('<i class="fa fa-plus"></i>'+en4.core.language.translate('Add Cover Photo'));
          response = sesJqueryObject.parseJSON(response);
          sesJqueryObject('#sescontest_cover_id').attr('src', response.file);
          sesJqueryObject('#sescontest_cover_photo_reposition').css('display','none');
          sesJqueryObject('#sescontest_cover_loading').remove();
          //silence
       }
      }); 
    });
    sesJqueryObject('<div class="sescontest_photo_update_popup sesbasic_bxs" id="sescontest_popup_cam_upload" style="display:none"><div class="sescontest_photo_update_popup_overlay"></div><div class="sescontest_photo_update_popup_container sescontest_photo_update_webcam_container"><div class="sescontest_photo_update_popup_header"><?php echo $this->translate("Click to Take Cover Photo") ?><da class="fa fa-close" href="javascript:;" onclick="hideProfilePhotoUpload()" title="<?php echo $this->translate("Close") ?>"></a></div><div class="sescontest_photo_update_popup_webcam_options"><div id="sescontest_camera" style="background-color:#ccc;"></div><div class="centerT sescontest_photo_update_popup_btns">   <button onclick="take_snapshot()" style="margin-right:3px;" ><?php echo $this->translate("Take Cover Photo") ?></button><button onclick="hideProfilePhotoUpload()" ><?php echo $this->translate("Cancel") ?></button></div></div></div></div><div class="sescontest_photo_update_popup sesbasic_bxs" id="sescontest_popup_existing_upload" style="display:none"><div class="sescontest_photo_update_popup_overlay"></div><div class="sescontest_photo_update_popup_container" id="sescontest_popup_container_existing"><div class="sescontest_photo_update_popup_header"><?php echo $this->translate("Select a cover photo") ?><a class="fa fa-close" href="javascript:;" onclick="hideProfilePhotoUpload()" title="<?php echo $this->translate("Close") ?>"></a></div><div class="sescontest_photo_update_popup_content"><div id="sescontest_existing_data"></div><div id="sescontest_profile_existing_img" style="display:none;text-align:center;"><img src="application/modules/Sesbasic/externals/images/loading.gif" alt="<?php echo $this->translate("Loading"); ?>" style="margin-top:10px;"  /></div></div></div></div>').appendTo('body');
  sesJqueryObject(document).on('click','#uploadWebCamPhoto',function(){
    sesJqueryObject('#sescontest_popup_cam_upload').show();
    <!-- Configure a few settings and attach camera -->
    Webcam.set({
        width: 320,
        height: <?php echo str_replace('px','',$height); ?>,
        image_format:'jpeg',
        jpeg_quality: 90
    });
    Webcam.attach('#sescontest_camera');
  });
  function hideProfilePhotoUpload(){
    if(typeof Webcam != 'undefined')
     Webcam.reset();
    canPaginatePageNumber = 1;
    sesJqueryObject('#sescontest_popup_cam_upload').hide();
    sesJqueryObject('#sescontest_popup_existing_upload').hide();
    if(typeof Webcam != 'undefined'){
        sesJqueryObject('.slimScrollDiv').remove();
        sesJqueryObject('.sescontest_photo_update_popup_content').html('<div id="sescontest_existing_data"></div><div id="sescontest_profile_existing_img" style="display:none;text-align:center;"><img src="application/modules/Sesbasic/externals/images/loading.gif" alt="Loading" style="margin-top:10px;"  /></div>');
    }
  }
  <!-- Code to handle taking the snapshot and displaying it locally -->
  function take_snapshot() {
    // take snapshot and get image data
    Webcam.snap(function(data_uri) {
      Webcam.reset();
      sesJqueryObject('#sescontest_popup_cam_upload').hide();
      // upload results
      sesJqueryObject('.sescontest_cover_inner').append('<div id="sescontest_cover_loading" class="sesbasic_loading_cont_overlay"></div>');
       Webcam.upload( data_uri, en4.core.baseUrl+'sescontest/profile/upload-cover/id/<?php echo $contest->contest_id ?>' , function(code, text) {
              response = sesJqueryObject.parseJSON(text);
              sesJqueryObject('#sescontest_cover_loading').remove();
              sesJqueryObject('#sescontest_cover_id').attr('src', response.file);
              sesJqueryObject('#coverChangesescontest').html('<i class="fa fa-plus"></i>'+en4.core.language.translate('Change Cover Photo'));
              sesJqueryObject('#sescontest_cover_photo_reposition').css('display','block');
              sesJqueryObject('#coverRemovesescontest').css('display','block');
          } );
    });
  }
  <?php if($this->params['show_full_width'] == 'yes'){ ?>
    sesJqueryObject(document).ready(function(){
      var htmlElement = document.getElementsByTagName("body")[0];
      htmlElement.addClass('sescontest_cover_full');
    });
  <?php } ?>
  <?php if($isContestEdit && $canUploadCover):?>
  var previousPositionOfCover = sesJqueryObject('#sescontest_cover_id').css('top');
  <!-- Reposition Photo -->
  sesJqueryObject('#sescontest_cover_photo_reposition').click(function(){
          sesJqueryObject('.sescontest_cover_reposition_btn').show();
          sesJqueryObject('.sescontest_cover_fade').hide();
          sesJqueryObject('#sescontest_change_cover_op').hide();
          sesJqueryObject('.sescontest_cover_content').hide();
          sesJqueryUIMin('#sescontest_cover_id').dragncrop({instruction: true,instructionText:'<?php echo $this->translate("Drag to Reposition") ?>'});
  });
  sesJqueryObject('#cancelreposition').click(function(){
      sesJqueryObject('.sescontest_cover_reposition_btn').hide();
      sesJqueryObject('#sescontest_cover_id').css('top',previousPositionOfCover);
      sesJqueryObject('.sescontest_cover_fade').show();
      sesJqueryObject('#sescontest_change_cover_op').show();
      sesJqueryObject('.sescontest_cover_content').show();
      sesJqueryUIMin("#sescontest_cover_id").dragncrop('destroy');
  });
  sesJqueryObject('#savereposition').click(function(){
      var sendposition = sesJqueryObject('#sescontest_cover_id').css('top');
      sesJqueryObject('#sescontest_cover_photo_loading').show();
      var uploadURL = en4.core.baseUrl+'sescontest/profile/reposition-cover/id/<?php echo $contest->contest_id ?>';
      var formData = new FormData();
      formData.append('position', sendposition);
      var jqXHR=sesJqueryObject.ajax({
              url: uploadURL,
              type: "POST",
              contentType:false,
              processData: false,
              data: formData,
              cache: false,
              success: function(response){
                  response = sesJqueryObject.parseJSON(response);
                  if(response.status == 1){
                      previousPositionOfCover = sendposition;
                      sesJqueryObject('.sescontest_cover_reposition_btn').hide();
                      sesJqueryUIMin("#sescontest_cover_id").dragncrop('destroy');
                      sesJqueryObject('.sescontest_cover_fade').show();
                      sesJqueryObject('#sescontest_change_cover_op').show();
                      sesJqueryObject('.sescontest_cover_content').show();
                  }else{
                      alert('<?php echo $this->translate("Something went wrong, please try again later.") ?>');	
                  }
                      sesJqueryObject('#sescontest_cover_photo_loading').hide();
                  //silence
               }
              });


  });
<?php endif;?>
sesJqueryObject(document).ready(function(e){
  sesJqueryObject('#main_tabs').children().eq(0).find('a').trigger('click');
});
 </script>
