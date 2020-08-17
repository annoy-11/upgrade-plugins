<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroupvideo
 * @package    Sesgroupvideo
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: utility.tpl  2018-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Sesgroup/views/scripts/dismiss_message.tpl';?>
<div class='sesbasic-form sesbasic-categories-form'>
  <div>
    <?php if( count($this->subNavigation) ): ?>
      <div class='sesbasic-admin-sub-tabs'>
        <?php echo $this->navigation()->menu()->setContainer($this->subNavigation)->render();?>
      </div>
    <?php endif; ?>
    <div class='sesbasic-form-cont'>
	    <div class='clear'>
			  <div class='settings sesbasic_admin_form'>
					<p>
					  <?php echo $this->translate("This page contains utilities to help configure and troubleshoot the video plugin.") ?>
					</p>
					<br/>
					<div class="settings">
					  <form onsubmit="return false;">
					    <h3><?php echo $this->translate("Ffmpeg Version") ?></h3>
					    <?php echo $this->translate("This will display the current installed version of ffmpeg.") ?>
					    <br /><br />
					    <textarea style="width: 600px;"><?php echo $this->version;?></textarea>
					  </form>
					</div>
					<div class="settings">
					  <form onsubmit="return false;">
					    <h3><?php echo $this->translate("Supported Video Formats") ?></h3>
					    <?php echo $this->translate('This will run and show the output of "ffmpeg -formats". Please see this page for more info.') ?>
					    <br /><br />
					    <textarea style="width: 600px;"><?php echo $this->format;?></textarea>
					  </form>
					</div>
			</div>
		</div>
  </div>
</div>
<?php /*
<div class="settings">
  <form action="<?php echo $this->escape($this->url(array('action' => 'test-encode'))) ?>" enctype="multipart/form-data">
    <h2><?php echo $this->translate("Test Encode") ?></h2>
    <?php echo $this->translate('This will run a test encode. Please upload the file first using Layout -> File & Media Manager.') ?>
    <br/>
    <?php if( !empty($this->testFiles) ): ?>
      <?php echo $this->formSelect('file', null, $this->testFiles) ?>
    <?php endif; ?>
  </form>
</div>
<br/>
<br/>
 * 
 */ ?>
