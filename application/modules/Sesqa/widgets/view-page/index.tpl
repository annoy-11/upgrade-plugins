<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesqa
 * @package    Sesqa
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-10-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php if(empty($this->is_answer_ajax)){ ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'externals/tinymce/tinymce.min.js'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesqa/externals/styles/styles.css'); ?>

<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesqa/externals/scripts/prism.js'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesqa/externals/styles/prism.css'); ?>

<div class="sesqa_viewpage sesbasic_bxs">
	<div class="sesqa_view_header sesbasic_clearfix">
  	<div class="_right">
      <ul class="sesqa_labels">
        <?php if(in_array('newLabel',$this->show_criteria)){ 
        if(empty($enableNewSetting)){
          $newSetting = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesqa_new_label', 5);
          $enableNewSetting = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesqa_enable_newLabel', 1);
        }
        	if($newSetting && $enableNewSetting && strtotime(date("Y-m-d H:i:s")) <= strtotime($this->question->creation_date." + ".$newSetting." Days")){
        ?>
        	<li><span title="<?php echo $this->translate('New Question'); ?>" class="sesqa_new_label"><i class="fa fa-star"></i></span></li>
        <?php 
        	}
        } ?>
        <?php if(in_array('hotLabel',$this->show_criteria) && $this->question->hot){ ?>
        	<li><span title="<?php echo $this->translate('Hot Question'); ?>" class="sesqa_featured_label"><i class="fa fa-star"></i></span></li>
        <?php } ?>
        <?php if(in_array('sponsoredLabel',$this->show_criteria) && $this->question->sponsored){ ?>
        	<li><span title="<?php echo $this->translate('Sponsored Question'); ?>" class="sesqa_hot_label"><i class="fa fa-star"></i></span></li>
        <?php } ?>
        <?php if(in_array('verifiedLabel',$this->show_criteria) && $this->question->verified){ ?>
        	<li><span title="<?php echo $this->translate('Verified Question'); ?>" class="sesqa_verified_label"><i class="fa fa-star"></i></span></li>
        <?php } ?>
        <?php if(in_array('featuredLabel',$this->show_criteria) && $this->question->featured){ ?>
       	 <li><span title="<?php echo $this->translate('Featured Question'); ?>" class="sesqa_sponsored_label"><i class="fa fa-star"></i></span></li>
        <?php } ?>
      </ul>
    	<?php if($this->can_edit || $this->can_delete){ ?>
        <div class="sesqa_viewpage_options">
        	<a href="javascript:;" class="sesbasic_pulldown_toggle"><i class="fa fa-ellipsis-h sesbasic_text_light"></i></a>
        	<div class="sesbasic_pulldown_options">
            <ul class="_isicon">
              <?php if($this->can_edit){ ?>
                <li><a href="<?php echo $this->url(array('action' => 'edit','question_id' => $this->question->getIdentity()),'sesqa_general'); ?>"><i class="fa-pencil"></i><?php echo $this->translate("SESEdit"); ?></a></li>
								<?php if($this->question->open_close == 1): ?>
								<li><a href="<?php echo $this->url(array('action' => 'close','question_id' => $this->question->getIdentity()),'sesqa_general'); ?>" class="smoothbox"><i class="fa-lock"></i><?php echo $this->translate("Open"); ?></a></li>								
								<?php else: ?>
								<li><a href="<?php echo $this->url(array('action' => 'close','question_id' => $this->question->getIdentity()),'sesqa_general'); ?>" class="smoothbox"><i class="fa-lock"></i><?php echo $this->translate("Close"); ?></a></li>
								<?php endif; ?>
              <?php } ?>
              <?php if($this->can_delete){ ?>
                <li><a href="<?php echo $this->url(array('action' => 'delete','question_id' => $this->question->getIdentity()),'sesqa_general'); ?>" class="smoothbox"><i class="fa-trash"></i><?php echo $this->translate("SESDelete"); ?></a></li>
              <?php } ?>
            </ul>
       		</div>
       	</div>
      <?php } ?>
		</div>
    <div class="_title">
      <h2>
        <?php if(in_array('title',$this->show_criteria)){ ?>
          <?php echo $this->question->getTitle(); ?>
        <?php } ?>
        <?php if(in_array('openClose',$this->show_criteria)){ ?>
          <span class="sesqa_tag"><?php echo $this->question->open_close ? $this->translate('SESClose') : $this->translate("SESOpen"); ?></span>
        <?php } ?>
      </h2>
    </div>          
  </div>
	<div class="sesqa_viewpage_main sesbasic_clearfix">
    <?php if(in_array('voteBtn',$this->show_criteria)){ ?>
    	<div class="_votebtns">
    		<?php include('application/modules/Sesqa/views/scripts/_updownvote.tpl'); ?>
    	</div>
		<?php } ?>    
    <div class="sesqa_viewpage_main_container">
      <?php  include('application/modules/Sesqa/views/scripts/_pollActivity.tpl'); ?>

    	<div class="sesqa_viewpage_footer">
      	<div class="_left">
          <div class="_tags">
            <?php if(in_array('tags',$this->show_criteria)){ ?>
            <?php foreach($this->tags as $tagMap){ 
                  $tag = $tagMap->getTag();
                    if (!isset($tag->text))
                      continue;
                  ?>
            	<a class="sesqa_tag" href="<?php echo $this->url(array('action'=>'browse'),'sesqa_general',true).'?tag_id='.$tag->getIdentity(); ?>"><?php echo $tag->text; ?></a>
            <?php } ?>
            <?php } ?>
          </div>
          <div class="_stats sesbasic_text_light">
            <?php if(in_array('like',$this->show_criteria)){ ?>
            	<span title="<?php echo $this->translate(array('%s like', '%s likes', $this->question->like_count), $this->locale()->toNumber($this->question->like_count)); ?>"> <i class="fa fa-thumbs-up"></i><?php echo $this->question->like_count ?> </span>
            <?php } ?>
            <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesqa.allow.favourite', 1) && in_array('favourite',$this->show_criteria)){ ?>
            	<span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $this->question->favourite_count), $this->locale()->toNumber($this->question->favourite_count)); ?>"> <i class="fa fa-heart"></i><?php echo $this->question->favourite_count ?> </span>
            <?php } ?>
            <?php if(in_array('follow',$this->show_criteria)){ ?>
            	<span title="<?php echo $this->translate(array('%s follow', '%s followers', $this->question->follow_count), $this->locale()->toNumber($this->question->follow_count)); ?>"> <i class="fa fa-check"></i><?php echo $this->question->follow_count ?> </span>
            <?php }?>
            <?php if(in_array('view',$this->show_criteria)){ ?>
            	<span title="<?php echo $this->translate(array('%s view', '%s views', $this->question->view_count), $this->locale()->toNumber($this->question->view_count)); ?>"> <i class="fa fa-eye"></i><?php echo $this->question->view_count ?> </span>
            <?php } ?>
            <?php if(in_array('vote',$this->show_criteria)){ ?>
            	<span title="<?php echo $this->translate(array('%s vote', '%s votes', Engine_Api::_()->sesqa()->voteCount($this->question)), $this->locale()->toNumber(Engine_Api::_()->sesqa()->voteCount($this->question))); ?>"> <i class="fa fa-hand-o-up"></i><?php echo Engine_Api::_()->sesqa()->voteCount($this->question) ?> </span>
            <?php } ?>
            <?php if(in_array('comment',$this->show_criteria)){ ?>
            	<span title="<?php echo $this->translate(array('%s comment', '%s comments', $this->question->comment_count), $this->locale()->toNumber($this->question->comment_count)); ?>"> <i class="fa fa-comments"></i><?php echo $this->question->comment_count ?> </span>
            <?php } ?>
          </div>
          <div class="_social sesqa_social_btns">
            <?php if($this->viewer()->getIdentity()){ ?>
              <?php if(in_array('likeBtn',$this->show_criteria)){ ?>
                <?php $LikeStatus = Engine_Api::_()->sesqa()->getLikeStatusQuestion($this->question->getIdentity(),$this->question->getType()); ?>
                <div><a href="javascript:;" data-url="<?php echo $this->question->getIdentity() ; ?>"  class="sesbasic_icon_btn sesqa_like_question <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>" title='<?php echo $this->translate("Like")?>'><i class="fa fa-thumbs-up"></i></a></div>
              <?php } ?>
              <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesqa.allow.favourite', 1) && in_array('favBtn',$this->show_criteria)){ ?>
                <?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'sesqa')->isFavourite(array('resource_type'=>$this->question->getType(),'resource_id'=>$this->question->getIdentity())); ?>
                <div><a href="javascript:;"   data-url="<?php echo $this->question->getIdentity() ; ?>" class="sesbasic_icon_btn sesqa_favourite_question <?php echo ($favStatus)  ? 'button_active' : '' ?>" title='<?php echo $this->translate("Favourite")?>'><i class="fa fa-heart"></i></a></div>
              <?php } ?>
              <?php if(in_array('followBtn',$this->show_criteria)){ ?>
                <?php
                  $FollowUser = Engine_Api::_()->sesqa()->getFollowStatus($this->question->getIdentity());
                  $followClass = (!$FollowUser) ? 'fa-check' : 'fa-times' ;
                  $followText = ($FollowUser) ?  $this->translate('SESUnfollow') : $this->translate('SESFollow') ;
                 ?>
                <div><a href="javacript:;"  data-url="<?php echo $this->question->getIdentity(); ?>" class="sesbasic_icon_btn sesqa_follow_question sesqa_follow_question_<?php echo $this->question->getIdentity(); ?>  <?php echo $FollowUser ? 'button_active' : ''; ?>" title='<?php echo $this->translate(!$FollowUser ? "Follow" : "Unfollow")?>'><i class="fa <?php echo $followClass; ?>"></i></a></div>
              <?php } ?>
            <?php } ?>
           <?php if(in_array('report',$this->show_criteria) &&  Engine_Api::_()->getApi('settings', 'core')->getSetting('qanda_allow_reporting', '1')){ ?>
              <div><a href="<?php echo $this->url(array('module'=>'core', 'controller'=>'report', 'action'=>'create', 'route'=>'default', 'subject'=> $this->question->getGuid(), 'format' => 'smoothbox'),'default',true) ?>"  class="sesbasic_icon_btn smoothbox" title='<?php echo $this->translate("Report")?>'><i class="fa fa-flag"></i></a></div>
            <?php } ?>
            <?php if(in_array('share',$this->show_criteria) &&  Engine_Api::_()->getApi('settings', 'core')->getSetting('qanda_allow_sharing', 1)){ ?>
            	<div class="_socialmore sesqa_social_share_wrap">
              	<a href="javascript:void(0);" class="sesbasic_icon_btn sesqa_share_button_toggle" title='<?php echo $this->translate("Share")?>'><i class="fa fa-share-alt"></i></a>
                <div class="sesqa_social_share_options sesbasic_bg">
                  <?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $this->question->getHref()); ?>
                  <?php echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $this->question, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
            		</div>
              </div>
            <?php } ?>
          </div>
        </div>
        <div class="_right">
          <div class="sesqa_view_question_info">
            <?php if(in_array('owner',$this->show_criteria)){ ?>
              <div><a href="<?php echo $this->question->getOwner()->getHref(); ?>" class="sesbasic_linkinherit" title='<?php echo $this->translate("Created By"); ?>'><i class="fa fa-user sesbasic_text_light"></i><span><?php echo $this->question->getOwner()->getTitle(); ?></span></a></div>
            <?php } ?>
            <?php if(in_array('category',$this->show_criteria) && $this->question->category_id){ 
              $category_id = $this->question->category_id;
              $category = Engine_Api::_()->getItem('sesqa_category',$this->question->category_id);
              if($category){
            ?>
            	<div><a href="<?php echo $category->getHref(); ?>" class="sesbasic_linkinherit" title='<?php echo $this->translate("Category"); ?>'><i class="fa fa-folder-open-o sesbasic_text_light"></i><span><?php echo $category->category_name; ?></span></a></div>
            <?php 
          		}
          	} ?>
            <?php if(in_array('date',$this->show_criteria)){ ?>
            	<div><a href="javascript:;" class="sesbasic_linkinherit" title='<?php echo $this->translate("Created On"); ?>'><i class="fa fa-calendar sesbasic_text_light"></i><span><?php echo date('d M Y',strtotime($this->question->creation_date)); ?></span></a></div>
            <?php } ?>
            <?php if(in_array('location',$this->show_criteria) && $this->question->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesqa.enable.location', 1)){ ?>
            	<div><?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1)) { ?><a href="<?php echo $this->url(array('resource_id' => $this->question->getIdentity(),'resource_type'=>'sesqa_question','action'=>'get-direction'), 'sesbasic_get_direction', true); ?>" class="opensmoothboxurl" title='<?php echo $this->translate("SESLocation"); ?>'><i class="fa fa-map-marker sesbasic_text_light"></i><span><?php echo $this->question->location; ?></span></a><?php } else { ?><i class="fa fa-map-marker sesbasic_text_light"></i><span><?php echo $this->question->location; ?></span><?php } ?> </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>	
  </div>
  
  <!-- answers -->
  <div class="sesqa_view_ans_container">
<?php } ?>
    <?php //if($this->paginator->getTotalItemCount()){ ?>
    <?php if(empty($this->is_answer_ajax)){ ?>
      <div class="_head"><?php echo $this->translate('SESAnswers'); ?>(<?php echo $this->paginator->getTotalItemCount(); ?>)</div>
      <div class="sesqa_view_ans_listing">
    <?php } ?>
      <?php foreach($this->paginator as $answer){ ?>
      <?php if(in_array('markBest',$this->answer_show_criteria)){ 
         $markasBest = true;
      } ?>
      <div class="sesqa_view_ans_item"> 
        <?php if(in_array('vote',$this->answer_show_criteria)){  ?>
          <div class="_votebtns"><?php include('application/modules/Sesqa/views/scripts/_updownvote.tpl'); ?></div>
        <?php } ?>
        <div class="sesqa_view_ans_item_content">       
          <?php if($this->viewer()->getIdentity()  && $this->viewer()->getIdentity() == $answer->owner_id){ ?>
            <div class="sesqa_toggle_option">
              <a href="javascript:;" class="sesbasic_pulldown_toggle"><i class="fa fa-ellipsis-h sesbasic_text_light"></i></a>
              <div class="sesbasic_pulldown_options">
                <ul class="_isicon">
                  <li><a href="javascript:;" class="editanswersesqa" data-id="<?php echo $answer->getIdentity(); ?>"><i class="fa fa-pencil"></i><?php echo $this->translate('SESEdit'); ?></a></li>
                  <li><a href="javascript:;" class="deleteanswersesqa" data-id="<?php echo $answer->getIdentity(); ?>"><i class="fa fa-trash"></i><?php echo $this->translate('SESDelete'); ?></a></li>
                </ul>
              </div>
            </div>
          <?php } ?>
          <div class="question_description">
            <div class="sesquestion_description sesbasic_html_block"><?php echo $answer->getDescription(); ?></div>
            <div class="sesqa_view_ans_owner_info">
              <?php if(in_array('owner',$this->show_criteria)){ ?>
                <a href="<?php echo $answer->getOwner()->getHref(); ?>" class="sesbasic_linkinherit" title='<?php echo $this->translate("By"); ?>'><?php echo $this->itemPhoto($answer->getOwner(), 'thumb.icon') ?><span><?php echo $answer->getOwner()->getTitle(); ?></span></a>
              <?php } ?>
              <?php if(in_array('date',$this->show_criteria)){ ?>
                <a href="javascript:;" class="sesbasic_linkinherit" title='<?php echo $this->translate("Created On"); ?>'><i class="fa fa-calendar sesbasic_text_light"></i><span><?php echo date('d M Y',strtotime($answer->creation_date)); ?></span></a>
              <?php } ?>
            </div>
            <div class="edit_cnt" style="display:block;"></div>
            <ul class="cancel_cnt edit_btns sesbasic_clearfix" style="display:none;">
              <li><a href="javascript:;" class="saveanswersesqa" data-id="<?php echo $answer->getIdentity(); ?>"><i class="fa fa-save"></i><?php echo $this->translate('SESSave'); ?></a></li>
              <li><a href="javascript:;" class="cancelanswersesqa" data-id="<?php echo $answer->getIdentity(); ?>"><i class="fa fa-remove"></i><?php echo $this->translate('SESCancel'); ?></a></li>
            </ul>
            <?php if(in_array('comment',$this->answer_show_criteria)){ ?>
              <?php if( $answer->authorization()->isAllowed($viewer, 'comment') && Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesadvancedcomment')){ ?>
                <div class="sesqa_cnt_comment">
                  <?php $hasComment = Engine_Api::_()->sesqa()->hasAnswerComment($answer->getIdentity()); ?>
                  <a href="javascript:;" class="sesqa_comment_a" <?php if($hasComment){ ?> style="display:none;" <?php } ?>><strong><?php echo $this->translate('Add a comment'); ?></strong></a>
                  <div class="sesqa_cmt" style="display:<?php if(!$hasComment){ ?>none<?php } ?>;"> <?php echo $this->action("list", "comment", "sesadvancedcomment", array("type" => $answer->getType(), "id" => $answer->getIdentity())); ?> </div>
                </div>
              <?php } ?>
            <?php } ?>
          </div>
        </div>  
      </div>
      <?php } ?>
      <?php if(empty($this->is_answer_ajax) || $this->is_paging_content){ ?>
        <?php echo $this->paginationControl($this->paginator, null, array("_pagging.tpl", "sesqa"),array('identityWidget'=>'8723jh')); ?> 
      <?php } ?>
      <?php if(empty($this->is_answer_ajax)){ ?>
    </div>
    <?php } ?>
    <!-- answers -->
    <?php //} ?>
<?php if(empty($this->is_answer_ajax)){ ?>
    <?php if($this->canVote){ ?>
    <!-- your answer -->
    <div class="sesqa_youranswer sesqa_view_ansbox">
      <div style="display:none" class="sesaddand">
        <div class="_textbox">
          <textarea  style="height:300px; width:100%" class="sesqa_answer_post" id="sesqa_answer_post"></textarea>
        </div>
        <div class="_btn"><input type="button" class="post-btn sesand_submit sesqa_button" value="<?php echo $this->translate('SESSubmit'); ?>" /></div>
      </div>
      <input type="button" class="post-btn addanswerbtn sesqa_button" value="<?php echo $this->translate('Add Answer'); ?>">
      <div class="sesbasic_loading_cont_overlay sesqa_answer_post_overlay" style="display:none"></div>
    </div>
    <?php } ?>
  </div>
</div>
<script type="application/javascript">
sesJqueryObject(document).on('click','.sesand_submit',function(){ 
if(tinymceEnableAnswer == 1){
  var content = tinyMCE.get('sesqa_answer_post').getContent();
}else{
  var content =   sesJqueryObject('#sesqa_answer_post').val();  
}
  if(!content)
   return;  
   sesJqueryObject('.sesqa_answer_post_overlay').show();
   (new Request.HTML({
      method: 'post',
      'url':en4.core.baseUrl + 'sesqa/index/create-answer',
      'data': {
        format: 'html',
        data:content,
        tinymce:'<?php echo $this->tinymce; ?>',
        answer_show_criteria: '<?php echo json_encode($this->answer_show_criteria); ?>',
        question_id:<?php echo $this->question->getIdentity() ?>,
      },
      onSuccess: function (responseTree, responseElements, responseHTML, responseJavaScript) {
        var response = (responseHTML);
        if (response == 0)
          alert(en4.core.language.translate('Something went wrong,please try again later'));
        else {
          if(tinymceEnableAnswer == 1){
            content = tinyMCE.get('sesqa_answer_post').setContent('');
          }else{
              sesJqueryObject('#sesqa_answer_post').val('')
          }
          sesJqueryObject('.sesqa_view_ans_listing').prepend(responseHTML);
        }
        var height = 0;
        if(sesJqueryObject('.layout_page_header').css('position') == "fixed"){
          height =  sesJqueryObject('.layout_page_header').height(); 
        }
        var elem = sesJqueryObject('.sesqa_view_ans_container');
        sesJqueryObject('html, body').animate({
          scrollTop: elem.offset().top - height
         }, 2000);
         sesJqueryObject('.sesqa_answer_post_overlay').hide();
        return true;
      
      }
    })).send();
})
sesJqueryObject(document).on('click','.addanswerbtn',function(){
    sesJqueryObject(this).parent().find('.sesaddand').show();
    sesJqueryObject(this).parent().find('.addanswerbtn').hide();
})
var tinymceEnableAnswer = '<?php echo $this->tinymce; ?>';
var sesqa_language = '<?php echo $this->language; ?>';
var sesqa_direction = '<?php echo $this->direction; ?>';
var sesqa_upload_url = "<?php echo $this->url(array('module' => 'sesbasic', 'controller' => 'index', 'action' => 'upload-image'), 'default', true); ?>";
if(tinymceEnableAnswer == 1){
tinymce.init({
  mode: "specific_textareas",
  plugins: "table,fullscreen,media,preview,paste,code,image,textcolor,jbimages,link,codesample",
  theme: "modern",
  menubar: false,
  statusbar: false,
  toolbar1:  "undo,redo,removeformat,pastetext,|,code,media,image,jbimages,link,fullscreen,preview,codesample",
  toolbar2: "fontselect,fontsizeselect,bold,italic,underline,strikethrough,forecolor,backcolor,|,alignleft,aligncenter,alignright,alignjustify,|,bullist,numlist,|,outdent,indent,blockquote",
  toolbar3: "",
  element_format: "html",
  height: "225px",
  content_css: "bbcode.css",
  entity_encoding: "raw",
  add_unload_trigger: "0",
  remove_linebreaks: false,
  convert_urls: false,
  language: sesqa_language,
  directionality: sesqa_direction,
  upload_url: sesqa_upload_url,
  editor_selector: "sesqa_answer_post"
});
 } 
function paggingNumber8723jh(page_number){
    sesJqueryObject('#ses_pagging_128738hsdkfj').find('.sesbasic_loading_cont_overlay').show();
    (new Request.HTML({
      method: 'post',
      'url':en4.core.baseUrl + "widget/index/mod/sesqa/name/view-page",
      'data': {
        format: 'html',
        pageAnswer:page_number,
        tinymce:'<?php echo $this->tinymce; ?>',
        limit_data:<?php echo $this->limit_data; ?>,
        answer_show_criteria: '<?php echo json_encode($this->answer_show_criteria); ?>',
        question_id:<?php echo $this->question->getIdentity() ?>,
      },
      onSuccess: function (responseTree, responseElements, responseHTML, responseJavaScript) {
        sesJqueryObject('#ses_pagging_128738hsdkfj').find('.sesbasic_loading_cont_overlay').hide();
        var response = (responseHTML);
        if (response == 0)
          alert(en4.core.language.translate('Something went wrong,please try again later'));
        else {
          sesJqueryObject('.sesqa_view_ans_listing').html(responseHTML);
        }
        return true;
      }
    })).send();
}
</script>
<?php } ?>
