<?php 
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespopupbuilder
 * @package    Sespopupbuilder
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: create.tpl  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
	
	
	<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js'); ?>
	<?php include APPLICATION_PATH .  '/application/modules/Sespopupbuilder/views/scripts/dismiss_message.tpl';?>
	<div>
	<?php echo $this->htmlLink(array('action' => 'index', 'reset' => false), $this->translate("Back to Manage Popups"),array('class' => 'buttonlink sesbasic_icon_back')) ?>
	</div>
	<br/>
	<h3>Choose a Popup Type</h3>
		<p>Choose a suitable type for your popup below.</p>
			<ul class="popupbuilder_create_tabs"> 
				<li>
					<a href="<?php echo $this->url(array('action' => 'create-popup', 'type' => 'image')); ?>" target="_blank">
						<div class="icon"><img src="./application/modules/Sespopupbuilder/externals/images/image.png"/></div>
						<p><?php echo $this->translate('Image'); ?></p>
					</a>
				</li>
				<li>
					<a href="<?php echo $this->url(array('action' => 'create-popup', 'type' => 'html')); ?>" target="_blank">
						<div class="icon"><img src="./application/modules/Sespopupbuilder/externals/images/html.png"/></div>
						<!-- <?php echo  $this->htmlLink(array('route' => 'admin_default', 'module' => 'sespopupbuilder', 'controller' => 'manage', 'action' => 'create-popup', 'type' => 'html'), $this->translate('HTML'), array('target'=>'_blank','style'=>'color:#000;text-decoration:none;')) ?> -->
						<p><?php echo $this->translate('HTML'); ?></p>
					</a>
				</li>
				<li>
					<a href="<?php echo $this->url(array('action' => 'create-popup', 'type' => 'video')); ?>" target="_blank">
						<div class="icon"><img src="./application/modules/Sespopupbuilder/externals/images/video.png"/></div>
						<!-- <?php echo  $this->htmlLink(array('route' => 'admin_default', 'module' => 'sespopupbuilder', 'controller' => 'manage', 'action' => 'create-popup', 'type' => 'video'), $this->translate('Video'), array('target'=>'_blank','style'=>'color:#000;text-decoration:none;')) ?> -->
						<p><?php echo $this->translate('Video'); ?></p>
					</a>
				</li>
				<li>
					<a href="<?php echo $this->url(array('action' => 'create-popup', 'type' => 'iframe')); ?>" target="_blank">
						<div class="icon"><img src="./application/modules/Sespopupbuilder/externals/images/iframe.png"/></div>
						<!-- <?php echo  $this->htmlLink(array('route' => 'admin_default', 'module' => 'sespopupbuilder', 'controller' => 'manage', 'action' => 'create-popup', 'type' => 'iframe'), $this->translate('iframe'), array('target'=>'_blank','style'=>'color:#000;text-decoration:none;')) ?> -->
						<p><?php echo $this->translate('iframe'); ?></p>
					</a>
				</li>
				<li>
					<a href="<?php echo $this->url(array('action' => 'create-popup', 'type' => 'facebook_like')); ?>" target="_blank">
						<div class="icon"><img src="./application/modules/Sespopupbuilder/externals/images/facebook.png"/></div>
						<!-- <?php echo  $this->htmlLink(array('route' => 'admin_default', 'module' => 'sespopupbuilder', 'controller' => 'manage', 'action' => 'create-popup', 'type' => 'facebook-like'), $this->translate('Facebook Page Plugin'), array('target'=>'_blank','style'=>'color:#000;text-decoration:none;')) ?> -->
						<p><?php echo $this->translate('Facebook Page Plugin'); ?></p>
					</a>
				</li>
				<li>
					<a href="<?php echo $this->url(array('action' => 'create-popup', 'type' => 'pdf')); ?>" target="_blank">
						<div class="icon"><img src="./application/modules/Sespopupbuilder/externals/images/pdf.png"/></div>
						<!-- <?php echo  $this->htmlLink(array('route' => 'admin_default', 'module' => 'sespopupbuilder', 'controller' => 'manage', 'action' => 'create-popup', 'type' => 'pdf'), $this->translate('PDF'), array('target'=>'_blank','style'=>'color:#000;text-decoration:none;')) ?> -->
						<p><?php echo $this->translate('PDF'); ?></p>
					</a>
				</li>
				<li>
					<a href="<?php echo $this->url(array('action' => 'create-popup', 'type' => 'age_verification')); ?>" target="_blank">
						<div class="icon"><img src="./application/modules/Sespopupbuilder/externals/images/age.png"/></div>
						<!-- <?php echo  $this->htmlLink(array('route' => 'admin_default', 'module' => 'sespopupbuilder', 'controller' => 'manage', 'action' => 'create-popup', 'type' => 'age_verification'), $this->translate('Age-Verification'), array('target'=>'_blank','style'=>'color:#000;text-decoration:none;')) ?> -->
						<p><?php echo $this->translate('Age Verification'); ?></p>
					</a>
				</li>
				<li>
					<a href="<?php echo $this->url(array('action' => 'create-popup', 'type' => 'notification_bar')); ?>" target="_blank">
						<div class="icon"><img src="./application/modules/Sespopupbuilder/externals/images/notification.png"/></div>
						<!-- <?php echo  $this->htmlLink(array('route' => 'admin_default', 'module' => 'sespopupbuilder', 'controller' => 'manage', 'action' => 'create-popup', 'type' => 'notification_bar'), $this->translate('Notification Bar'), array('target'=>'_blank','style'=>'color:#000;text-decoration:none;')) ?> -->
						<p><?php echo $this->translate('Notification Promo Bar'); ?></p>
					</a>
				</li>
				<li>
					<a href="<?php echo $this->url(array('action' => 'create-popup', 'type' => 'cookie_consent')); ?>" target="_blank">
						<div class="icon"><img src="./application/modules/Sespopupbuilder/externals/images/cookie.png"/></div>
						<!--<?php echo  $this->htmlLink(array('route' => 'admin_default', 'module' => 'sespopupbuilder', 'controller' => 'manage', 'action' => 'create-popup', 'type' => 'cookie_consent'), $this->translate('Cookie Consent'), array('target'=>'_blank','style'=>'color:#000;text-decoration:none;')) ?> -->
						<p><?php echo $this->translate('Cookie Consent'); ?></p>
					</a>
				</li>
				<li>
					<a href="<?php echo $this->url(array('action' => 'create-popup', 'type' => 'christmas')); ?>" target="_blank">
						<div class="icon"><img src="./application/modules/Sespopupbuilder/externals/images/christmas.png"/></div>
						<!-- <?php echo  $this->htmlLink(array('route' => 'admin_default', 'module' => 'sespopupbuilder', 'controller' => 'manage', 'action' => 'create-popup', 'type' => 'christmas'), $this->translate('Christmas & New year'), array('target'=>'_blank','style'=>'color:#000;text-decoration:none;')) ?> -->
						<p><?php echo $this->translate('Christmas & New Year'); ?></p>
					</a>
				</li>
				<li>
					<a href="<?php echo $this->url(array('action' => 'create-popup', 'type' => 'count_down')); ?>" target="_blank">
						<div class="icon"><img src="./application/modules/Sespopupbuilder/externals/images/countdown.png"/></div>
						<!--<?php echo  $this->htmlLink(array('route' => 'admin_default', 'module' => 'sespopupbuilder', 'controller' => 'manage', 'action' => 'create-popup', 'type' => 'count_down'), $this->translate('Count Down'), array('target'=>'_blank','style'=>'color:#000;text-decoration:none;')) ?>-->
						<p><?php echo $this->translate('Count Down'); ?></p>
					</a>
				</li>
      </ul>
