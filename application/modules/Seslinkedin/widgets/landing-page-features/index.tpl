<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslinkedin
 * @package    Seslinkedin
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-05-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/themes/seslinkedin/landing_page.css'); ?>
  <div class="lp_features_section">
     <div class="lp_container lp_features_inner">
         <div class="lp_features_head">
            <?php if(!empty($this->heading) && $this->heading != ''): ?>
                <h2><?php echo $this->translate($this->heading); ?></h2>
            <?php endif; ?>
         </div>
         <div class="lp_features_cont">
            <ul>
               <li><div class="working-process">
								<span class="process-img">
									<img src="<?php echo $this->fe1img; ?>" />
									<span class="process-num"><?php echo $this->translate('01'); ?></span>
								</span>
                <?php if(!empty($this->fe1heading) && $this->fe1heading != ''): ?>
                    <h4><?php echo $this->translate($this->fe1heading); ?></h4>
                <?php endif; ?>
                <?php if(!empty($this->fe1description) && $this->fe1description != ''): ?>
                    <p><?php echo $this->translate($this->fe1description); ?></p>
								<?php endif; ?>
							</div></li>
               <li><div class="working-process">
								<span class="process-img">
									<img src="<?php echo $this->fe2img; ?>" />
									<span class="process-num"><?php echo $this->translate('02'); ?></span>
								</span>
                <?php if(!empty($this->fe2heading) && $this->fe2heading != ''): ?>
                    <h4><?php echo $this->translate($this->fe2heading); ?></h4>
                <?php endif; ?>
								<?php if(!empty($this->fe2description) && $this->fe2description != ''): ?>
                    <p><?php echo $this->translate($this->fe2description); ?></p>
								<?php endif; ?>
							</div></li>
               <li><div class="working-process">
								<span class="process-img">
									<img src="<?php echo $this->fe3img; ?>" />
									<span class="process-num"><?php echo $this->translate('03'); ?></span>
								</span>
								 <?php if(!empty($this->fe3heading) && $this->fe3heading != ''): ?>
                    <h4><?php echo $this->translate($this->fe3heading); ?></h4>
                <?php endif; ?>
								<?php if(!empty($this->fe3description) && $this->fe3description != ''): ?>
                    <p><?php echo $this->translate($this->fe3description); ?></p>
								<?php endif; ?>
							</div></li>
            </ul>
         </div>
     </div>
  </div>
