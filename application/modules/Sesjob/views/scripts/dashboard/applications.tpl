<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: applications.tpl  2019-03-27 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesjob/externals/styles/styles.css'); ?> 
<?php if(!$this->is_ajax):?>
<?php echo $this->partial('dashboard/left-bar.tpl', 'sesjob', array('job' => $this->job));	?>
<div class="sesbasic_dashboard_content sesjob_manage_role_form sesbm sesbasic_clearfix">
	<div class="sesjob_manage_role_form_top sesbasic_clearfix">
		<?php endif; ?>
<?php if(!$this->is_ajax){ ?>
  </div>
	<div class="sesjob_footer_contant">
		<b><?php echo $this->translate('Manage Applications');?></b>
		<p><?php echo $this->translate('Below, you can manage all applicant applications. You can directly contact then from here.');?></p>
		<div id="manage_admin">
		  <?php if(count($this->paginator) > 0) { ?>
        <?php foreach($this->paginator as $application):?>
          <div class="admin_manage" id="admin_manage_<?php echo $application->application_id;?>">
            <div class="applicant_main">
           <div class="applicant_img">
            <?php if($application->owner_id) { ?>
              <?php $user = Engine_Api::_()->getItem('user', $application->owner_id); ?>
              <?php echo $this->htmlLink($user->getHref(), $this->itemPhoto($user, 'thumb.icon', $user->getTitle())) ?>
             </div>
             <div class="applicant_info">
              <?php echo $this->htmlLink($user->getHref(), $user->getTitle()) ?>
            <?php } else { ?>
            
              <span><?php echo $application->name; ?></span>
            <?php } ?>
            <span><?php echo $this->translate('<i class="fa fa-envelope"></i>'); ?> <?php echo $application->email;  ?></span>
             <span><?php echo $this->translate('<i class="fa fa-phone"></i>'); ?> <?php echo $application->mobile_number;  ?></span>
             <span><?php echo $this->translate('<i class="fa fa-map-marker"></i>'); ?> <?php echo $application->location;  ?></span>
            <div class="sesjob_send_download">
            <a class="smoothbox send_mail" title="<?php echo $this->translate('Send Mail'); ?>" class="" href="<?php echo $this->url(array('module' => 'sesjob', 'controller' => 'dashboard', 'action' => 'sendmail', 'job_id' => $this->job->job_id, 'application_id' => $application->application_id), 'default', true); ?>"><i class="fa fa-envelope"></i> <?php echo $this->translate('Send Mail'); ?></a>
            <a class="download_resume" title="Download Resume" href="<?php echo $this->url(array('module' => 'sesjob', 'controller' => 'index', 'action' => 'download', 'id' => $application->application_id), 'default', true); ?>"><i class="fa fa-download"></i></a>
            </div>
            
            <a title="<?php echo $this->translate('Delete'); ?>" class="remove_application" href="javascript:void(0);" onclick="removeApplication('<?php echo $application->application_id;?>', '<?php echo $this->job->job_id;?>');"><i class="fa fa-close"></i></a>
            </div>
          </div>
          </div>
        <?php endforeach;?>
      <?php } else { ?>
        <div class="tip">
          <span><?php echo $this->translate("There are no applications yet."); ?></span>
        </div>
      <?php } ?>
		</div>
	</div>
</div>
</div>
<?php } ?>
<?php if($this->is_ajax) die; ?>
<script>
  function removeApplication(application_id, job_id) {
		new Request.JSON({
			url : en4.core.baseUrl + 'sesjob/dashboard/delete-application',
			method: 'post',
			data : {
				format : 'json',
				application_id: application_id,
				job_id:job_id,
				is_ajax: 1,
			},
			onSuccess: function(responseJSON) {
				sesJqueryObject('#admin_manage_'+application_id).remove();
			}
		}).send()
  }
</script>
