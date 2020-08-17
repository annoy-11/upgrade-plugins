<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesuserdocverification
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manage.tpl 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $docCount = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesuserdocverification.doccount', 0);  ?>
<?php $uplaodshow = false;
if($docCount == '0') {
  $uplaodshow = true;
} else if($docCount > count($this->documents)) { 
  $uplaodshow = true;
}
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesuserdocverification/externals/styles/styles.css'); ?>
<div class="sesuserdocverification_settings sesbasic_bxs">
	<div class="sesuserdocverification_settings_header">
  	<div class="_title"><?php echo $this->translate("Manage Documents for Verification"); ?></div>
    <div class="_des"><?php echo $this->translate("Here, you can manage your documents submitted for verification."); ?></div>
  </div>
  <?php if($this->user_id == $this->viewer_id && !empty($uplaodshow)) { ?>
  	<div class="sesuserdocverification_upload_btn">
    	<?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sesuserdocverification', 'controller' => 'index', 'action' => 'upload-document', 'format' => 'smoothbox'), $this->translate('Upload New Document'), array('class' => 'smoothbox sesbasic_button sesbasic_icon_add')); ?>
  	</div>
  <?php } ?>
  <?php if($this->paginator->getTotalItemCount() > 0) { ?>
    <div class="sesuserdocverification_manage_documents">
    	<div class="_header">
        <?php if(count($this->documentTypes) > 1) { ?>
      	<div class="_type"><?php echo $this->translate("Document Type"); ?></div>
      	<?php } ?>
        <div class="_status"><?php echo $this->translate("Status"); ?></div>
        <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesuserdocverification.showpreview', 0)) { ?>
        <div class="_preview"><?php echo $this->translate("Preview"); ?></div>
        <?php } ?>
        <div class="_option"><?php echo $this->translate("Options"); ?></div>
      </div>
      <ul>
       <?php $counter = 1; ?>
        <?php foreach($this->paginator as $result) { ?>
          <li>
              <?php if($result->documenttype_id && count($this->documentTypes) > 1) { ?>
                <?php $documentType = Engine_Api::_()->getItem('sesuserdocverification_documenttype', $result->documenttype_id); ?>
                <div class="_type"><i><?php echo $counter; ?></i><?php echo $documentType->getTitle(); ?></div>
              <?php } else { ?>
                <div class="_type"><i><?php echo $counter; ?></i><?php echo '---'; ?></div>
              <?php } ?>
              <div class="_status">
                <?php if($result->verified == '0') { ?>
                  <span class="status_pending"><?php echo $this->translate("Verification Pending")?></span>
                <?php } else if($result->verified == '1') { ?>
                  <span class="status_verified"><?php echo $this->translate("Verified")?></span>
                <?php } else if($result->verified == '2') { ?>
                  <span class="status_rejected"><?php echo $this->translate("Rejected")?></span>
                <?php } ?>
                
              </div>
              <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesuserdocverification.showpreview', 0) &&  $result->file_id) { ?>
              <div class="_preview">
                <?php $storage = Engine_Api::_()->getItem('storage_file', $result->file_id); ?>
                <?php if($storage) { ?>
                <a target="_blank" href="<?php echo $storage->map(); ?>" class="buttonlink sesuserdocverification_icon_view"><?php echo $this->translate("Preview") ?></a>
                <?php } ?>
              </div>
              <?php } ?>
                <?php if($result->user_id == $this->viewer_id) { ?>
                	<div class="_option">
                    <?php if($result->verified == '0' && empty($result->submintoadmin)) { ?>
                      <span><?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sesuserdocverification', 'controller' => 'settings', 'action' => 'delete', 'document_id' => $result->document_id, 'format' => 'smoothbox'), $this->translate('Delete'), array('class' => 'buttonlink smoothbox sesbasic_icon_delete')); ?></span>
                    <?php } else if($result->verified == '2' && !empty($result->submintoadmin)) { ?>
                      <span><?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sesuserdocverification', 'controller' => 'settings', 'action' => 'delete', 'document_id' => $result->document_id, 'format' => 'smoothbox'), $this->translate('Delete'), array('class' => 'buttonlink smoothbox sesbasic_icon_delete')); ?></span>
                    <?php } else { echo "---"; } ?>
                    <?php if(empty($result->submintoadmin)) { ?>
                      <span><?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sesuserdocverification', 'controller' => 'settings', 'action' => 'submit-for-verification', 'document_id' => $result->document_id, 'format' => 'smoothbox'), $this->translate('Submit For Verification'), array('class' => 'buttonlink smoothbox sesuserdocverification_icon_submit')); ?></span>
                    <?php } ?>
                  </div>
                <?php } ?>

          </li>
        <?php $counter++; } ?>
      </ul>
    </div>
  <?php } else { ?>
    <div class="tip">
      <span>
        <?php echo $this->translate("There are no document uploaded by you yet.") ?>
      </span>
    </div>
  <?php } ?>
</div>  
