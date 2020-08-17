<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-03-27 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesjob/externals/styles/styles.css'); ?>
<?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $this->sesjob->getHref()); ?>
<?php $isJobAdmin = Engine_Api::_()->sesjob()->isJobAdmin($this->sesjob, 'edit');?>
<?php $canComment =  $this->sesjob->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'comment');?>
<?php $LikeStatus = Engine_Api::_()->sesjob()->getLikeStatus($this->sesjob->job_id,$this->sesjob->getType()); ?> 
<?php $likeClass = (!$LikeStatus) ? 'fa-thumbs-up' : 'fa-thumbs-down' ;?>
<?php $likeText = ($LikeStatus) ?  $this->translate('Unlike') : $this->translate('Like');?>
<?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'sesjob')->isFavourite(array('resource_type'=>'sesjob_job','resource_id'=>$this->sesjob->job_id)); ?>

<?php $enableSharng = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.enable.sharing', 1);?>

	<div class="sesjob_layout_contant sesbasic_clearfix sesbasic_bxs">
    <!--<?php echo $this->htmlLink($this->sesjob->getHref(), $this->itemPhoto($this->sesjob)); ?>-->
	  <?php if(isset($this->titleActive)):?>
			<h2><?php echo $this->sesjob->getTitle() ?></h2>
		<?php endif;?>
    <div class="sesjob_view_comp">
    	 <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.company', 1) && isset($this->companydetailsActive)) { ?>
      <?php if($this->sesjob->company_id) { ?>
        <?php $company = Engine_Api::_()->getItem('sesjob_company', $this->sesjob->company_id); ?>
        <?php if($company) { ?>
         <div class="sesjob_view_emp_info">
            <a href="<?php echo $company->getHref(); ?>"><?php echo $company->company_name; ?></a>
         </div>
        <?php } ?>
      <?php } ?>
		<?php } ?>
     </div>
     <div class="sesjob_view_cat">
       <?php if($this->sesjob->salary) { ?>
       <div class="sesjob_view_emp_info">
       <span><?php echo $this->translate('<i class="fa fa-briefcase sesbasic_text_light" aria-hidden="true"></i>'); ?></span><?php echo $this->sesjob->experience; ?>
      </div>
		<?php } ?>
     <?php if(isset($this->sesjob->location) && $this->sesjob->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.enable.location', 1)){ ?>
			<div class="sesjob_view_emp_loc">
				<span>
					<i class="fa fa-map-marker sesbasic_text_light"></i><a href="<?php echo $this->url(array('resource_id' => $this->sesjob->job_id,'resource_type'=>'sesjob_job','action'=>'get-direction'), 'sesbasic_get_direction', true) ;?>" class="opensmoothboxurl"  title="<?php echo $this->sesjob->location;?>"><?php echo $this->sesjob->location;?></a>
				</span>
			</div>
		<?php } ?>
     </div>
     
    <?php if(empty($this->viewer_id)) { ?>
      <div class="sesjob_view_apply">
        <a class="smoothbox button" href="<?php echo $this->url(array('module' => 'sesjob', 'controller' => 'company', 'action' => 'apply', 'job_id' => $this->job_id), 'default', true); ?>"><?php echo $this->translate("Apply For Job"); ?></a>
      </div>
    <?php } else { ?>
      <?php if($this->viewer_id != $this->sesjob->owner_id) { ?>
        <div class="sesjob_view_apply">
          <?php if(!empty($this->isApplied)) { ?>
            <a href="javascript:void(0);"><?php echo $this->translate("Applied"); ?></a>
          <?php } else { ?>
            <a class="smoothbox button" href="<?php echo $this->url(array('module' => 'sesjob', 'controller' => 'company', 'action' => 'apply', 'job_id' => $this->job_id), 'default', true); ?>"><?php echo $this->translate("Apply For Job"); ?></a>
          <?php } ?>
        </div>
      <?php } ?>
    <?php } ?>
      <?php if(!empty($this->sesjob->expired)) { ?>
        <div class="sesjob_view_expired">
            <?php echo $this->translate("This Job has Expired"); ?>
        </div>
      <?php } ?>
     <div class="sesjob_entrylist_entry_date">
    	<p class="sesbasic_text_light"><?php echo $this->translate('Posted by ');?> <?php echo $this->htmlLink($this->owner->getHref(), $this->owner->getTitle()) ?> on <?php echo $this->timestamp($this->sesjob->creation_date) ?></p>
			<?php if(isset($this->staticsActive)):?>
				<p class="sesjob_view_stats sesbasic_text_light">
					<?php if(isset($this->viewActive)):?>
						<span><?php echo $this->translate(array('%s View', '%s Views', $this->sesjob->view_count), $this->locale()->toNumber($this->sesjob->view_count)) ?></span>
					<?php endif;?>
					<?php if(isset($this->commentActive)):?>
						<span><?php echo $this->translate(array('%s Comment', '%s Comments', $this->sesjob->comment_count), $this->locale()->toNumber($this->sesjob->comment_count)) ?></span>
					<?php endif;?>
					<?php if(isset($this->likeActive)):?>
						<span><?php echo $this->translate(array('%s Like', '%s Likes', $this->sesjob->like_count), $this->locale()->toNumber($this->sesjob->like_count)) ?></span>
					<?php endif;?>
				</p>
			<?php endif;?>
		</div>
		<div class="sesjob_entrylist_entry_body">
     <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.company', 1) && isset($this->companydetailsActive)) { ?>
      <div class="sesjob_entry_head"><?php echo $this->translate("Company Details"); ?></div>
      <?php if($this->sesjob->company_id) { ?>
        <?php $company = Engine_Api::_()->getItem('sesjob_company', $this->sesjob->company_id); ?>
        <?php if($company) { ?>
         <div class="sesjob_view_emp_info">
        <span class="sesbasic_text_light"><?php echo $this->translate("Name:"); ?></span><a href="<?php echo $company->getHref(); ?>"><?php echo $company->company_name; ?></a>
         </div>
        <?php } ?>
      <?php } ?>
      <?php if($company->industry_id) { ?>
        <?php $industry = Engine_Api::_()->getItem('sesjob_industry', $company->industry_id); ?>
        <div class="sesjob_view_emp_info">
        <span class="sesbasic_text_light"><?php echo $this->translate("Industry:"); ?></span>
        <?php echo $industry->industry_name; ?>
        </div>
      <?php } ?>
      <?php if($company->company_websiteurl) { ?>
      <div class="sesjob_view_emp_info">
        <span class="sesbasic_text_light"><?php echo $this->translate("Website:"); ?></span>
        <a href="<?php echo $company->company_websiteurl; ?>"><?php echo $company->company_websiteurl; ?></a>
              </div>
      <?php } ?>
      <?php if($company->company_description) { ?>
       <div class="sesjob_view_emp_info">
        <span class="sesbasic_text_light"><?php echo $this->translate("Description:"); ?></span>
        <?php echo $company->company_description; ?>
        </div>
      <?php } ?>
		<?php } ?>
			<?php if(isset($this->descriptionActive)):?>
        <div class="sesjob_entry_head"><?php echo $this->translate("Job Description"); ?></div>
				<div class="rich_content_body">
          <div class="sesjob_des"> <?php echo $this->sesjob->body;?></div>
           	<?php if(isset($this->customfieldActive) && count($this->customMetaFields)) { ?>
    <div class="profile_fields">
    <h3><?php echo $this->translate("Additional Information"); ?></h3>
    <?php
      //custom field data
      echo $this->sesbasicFieldValueLoop($this->sesjob);
      ?>
    </div>
    <?php } ?>
		
		<?php if($this->sesjob->salary) { ?>
      <div class="sesjob_view_emp_info">
        <span class="sesbasic_text_light"><?php echo $this->translate('Salary: '); ?></span><?php echo $this->sesjob->salary; ?>
      </div>
		<?php } ?>
		<?php if($this->sesjob->otherpay) { ?>
      <div class="sesjob_view_emp_info">
       <span class="sesbasic_text_light"><?php echo $this->translate('Otherpay: '); ?></span><?php echo $this->sesjob->otherpay; ?>
      </div>
		<?php } ?>
		<?php if($this->sesjob->education_id) { ?>
      <?php $educations = explode(',', $this->sesjob->education_id); $educationDetails = ''; ?>
      <?php foreach($educations as  $education) { ?>
        <?php $education = Engine_Api::_()->getItem('sesjob_education', $education); ?>
        <?php $educationDetails .= $education->education_name . ', '; ?>
      <?php } ?>
       <div class="sesjob_view_emp_info">
         <span class="sesbasic_text_light"><?php echo $this->translate('Education: '); ?></span> <?php echo $this->translate($educationDetails); ?>
		  </div>
    <?php } ?>
		<?php if($this->sesjob->manage_others) { ?>
       <div class="sesjob_view_emp_info">
         <span class="sesbasic_text_light"><?php echo $this->translate('Manage Others: '); ?></span><?php echo !empty($this->sesjob->manage_others) ? $this->translate("Yes") : $this->translate('No'); ?>
		   </div>
    <?php } ?>
    <?php if($this->sesjob->employment_id) { ?>
      <?php $employment = Engine_Api::_()->getItem('sesjob_employment', $this->sesjob->employment_id); ?>
      <div class="sesjob_view_emp_info">
      <span class="sesbasic_text_light"><?php echo $this->translate('Employment Type: '); ?></span><?php echo $employment->employment_name; ?>
      </div>
		<?php } ?>
		
		<?php if($this->sesjob->job_contact_name || $this->sesjob->job_contact_email || $this->sesjob->job_contact_phone || $this->sesjob->job_contact_facebook || $this->sesjob->job_contact_website) { ?>
		 <div class="sesjob_view_cont_head">
      <?php echo $this->translate("Contact Information"); ?>
      
    </div>
		<?php if($this->sesjob->job_contact_name) { ?>
      <div class="sesjob_view_emp_info">
      <span class="sesbasic_text_light"><?php echo $this->translate('Name: '); ?></span><?php echo $this->sesjob->job_contact_name; ?>
      </div>
		<?php } ?>
		<?php if($this->sesjob->job_contact_phone) { ?>
     <div class="sesjob_view_emp_info">
      <span class="sesbasic_text_light"><?php echo $this->translate('Phone: '); ?></span><?php echo $this->sesjob->job_contact_phone; ?>
      </div>
		<?php } ?>
		<?php if($this->sesjob->job_contact_facebook) { ?>
      <div class="sesjob_view_emp_info">
      <span class="sesbasic_text_light"><?php echo $this->translate('Facebook: '); ?></span><a href="<?php echo $this->sesjob->job_contact_facebook; ?>"><?php echo $this->sesjob->job_contact_facebook; ?></a>
		  </div>
    <?php } ?>
		<?php if($this->sesjob->job_contact_website) { ?>
      <div class="sesjob_view_emp_info">
       <span class="sesbasic_text_light"><?php echo $this->translate("Website: "); ?></span><a href="<?php echo $this->sesjob->job_contact_website; ?>"><?php echo $this->sesjob->job_contact_website; ?></a>
		  </div>
    <?php } ?>
		<?php } ?>
        </div>
			<?php endif;?>
      	
	   <?php if (count($this->sesjobTags )):?>
       <div class="sesjob_view_skills">
         <p><b><?php echo $this->translate("Key Skills"); ?></b></p>
				<?php foreach ($this->sesjobTags as $tag): ?>
					<a href='javascript:void(0);' onclick='javascript:tagAction(<?php echo $tag->getTag()->tag_id; ?>);'><?php echo $tag->getTag()->text?></a>&nbsp;
				<?php endforeach; ?>
       </div>
			<?php endif; ?>
		</div>
		
    <div class="sesjob_footer_two_job clear">
      <div class="sesjob_shear_job sesbasic_bxs">
        <?php if(isset($this->socialShareActive) && $enableSharng):?>
        
          <?php echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $this->sesjob, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
			  <?php endif;?>
				<?php if($this->viewer_id && $enableSharng && isset($this->shareButtonActive)):?>
						<a href="<?php echo $this->url(array("module" => "activity","controller" => "index","action" => "share", "type" => $this->sesjob->getType(), "id" => $this->sesjob->getIdentity(), "format" => "smoothbox"), 'default', true);?>" class="share_icon sesbasic_icon_btn smoothbox"><i class="fa fa-share "></i></a>
				<?php endif;?>
				<?php if($this->viewer_id):?>
					<?php if(isset($this->likeButtonActive) && $canComment):?>
							<a href="javascript:;" data-url="<?php echo $this->sesjob->job_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_like_btn  sesjob_like_sesjob_job_<?php echo $this->sesjob->job_id ?> sesjob_like_sesjob_job_view <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"><i class="fa <?php echo $likeClass;?>"></i></a>
					<?php endif;?>
					<?php if(isset($this->favouriteButtonActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.enable.favourite', 1)):?>
							<a href="javascript:;" data-url="<?php echo $this->sesjob->job_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_fav_btn  sesjob_favourite_sesjob_job_<?php echo $this->sesjob->job_id ?> sesjob_favourite_sesjob_job_view <?php echo ($favStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-heart"></i></a>
					<?php endif;?>
        <?php endif;?>
			</div>
      <div class="sesjob_deshboard_job">
				<ul>
					<?php if(isset($this->ownerOptionsActive) && $isJobAdmin):?>
						<li><a href="<?php echo $this->url(array('action' => 'edit', 'job_id' => $this->sesjob->custom_url), 'sesjob_dashboard', 'true');?>"><i class="fa fa-edit"></i><?php echo $this->translate('Dashboard');?></a></li>
						<li><a href="<?php echo $this->url(array('action' => 'delete', 'job_id' => $this->sesjob->getIdentity()), 'sesjob_specific', true);?>" class="smoothbox"><i class="fa fa-trash "></i><?php echo $this->translate('Delete This Job');?></a></li>
					<?php endif;?>
					<?php if($this->viewer_id && isset($this->smallShareButtonActive) && $enableSharng):?>
						<li><a href="<?php echo $this->url(array("module" => "activity","controller" => "index","action" => "share", "type" => $this->sesjob->getType(), "id" => $this->sesjob->getIdentity(), "format" => "smoothbox"), 'default', true);?>" class="smoothbox share_icon"><i class="fa fa-share "></i> <?php echo $this->translate('Share');?></a></li>
					<?php endif;?>
					<?php if($this->viewer_id && $this->viewer_id != $this->sesjob->owner_id && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.enable.report', 1)):?>
						<li><a href="<?php echo $this->url(array("module" => "core","controller" => "report","action" => "create", 'subject' => $this->sesjob->getGuid()),'default', true);?>" class="smoothbox report_link"><i class="fa fa-flag"></i><?php echo $this->translate('Report');?></a></li>
					<?php endif;?>
					<?php if(isset($this->postCommentActive) && $canComment):?>
						<li><a href="javascript:void(0);" class="sesjob_comment"><i class="sesjob_comment fa fa-commenting"></i><?php echo $this->translate('Post Comment');?></a></li>
          <?php endif;?>
				</ul>
			</div>
		</div>
	</div>

<script type="text/javascript">

  $$('.core_main_sesjob').getParent().addClass('active');
  sesJqueryObject('.sesjob_comment').click(function() {
    sesJqueryObject('.comments_options').find('a').eq(0).trigger('click');
    sesJqueryObject('#adv_comment_subject_btn_<?php echo $this->sesjob->job_id; ?>').trigger('click');
  });
	
	function tagAction(tag_id){
		window.location.href = '<?php echo $this->url(array("action"=>"browse"),"sesjob_general",true); ?>'+'?tag_id='+tag_id;
	}
	var logincheck = '<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.login.continuereading', 1); ?>';
	
	var viwerId = <?php echo $this->viewer_id ?>;
	function continuereading(){
		
		if(logincheck>0 && !viwerId){
			window.location.href = en4.core.baseUrl +'login';
		}else{
			sesJqueryObject('.rich_content_body').css('height', 'auto');
			sesJqueryObject('.sesjob_morebtn').hide();
		}
	}
</script>
