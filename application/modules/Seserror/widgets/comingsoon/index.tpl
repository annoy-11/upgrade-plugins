<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seserror
 * @package    Seserror
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2017-05-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php
  $comingsoonDate = date('Y-m-d', strtotime($this->seserror_comingsoondate)); 
  $comingsoonDate = explode('-', $comingsoonDate); 
?>

<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,600,600i,700,700i,800,800i" rel="stylesheet">
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Seserror/externals/styles/comingsoon.css'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Seserror/externals/styles/flipclock.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Seserror/externals/scripts/jquery.syotimer.min.js'); ?>

<?php if($this->default_activate == 1): ?>
  <div class="comming_soong_main_container">
    <div class="comming_soon_one_container sesbasic_bxs" style="background-image:url(application/modules/Seserror/externals/images/comingsoon/template_1.jpg);">
      <div class="middle_section">        
        <?php if($this->text1): ?>
          <div class="main_tittle">
            <h2><?php echo $this->translate($this->text1); ?></h2>
          </div>
        <?php endif; ?>
        <?php if($this->text2): ?>
          <div class="small_tittle">
            <p><?php echo $this->translate($this->text2); ?></p>
          </div>
        <?php endif; ?>
        <?php if($this->text3): ?>
          <div class="discrtiption">
            <p><?php echo $this->translate($this->text3); ?></p>
          </div>
        <?php endif; ?>
        <?php if($this->showcontactbutton): ?>
          <div class="contect_button">
            <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'seserror', 'controller' => 'index', 'action' => 'contact'), $this->translate("Contact Us"), array('class' => 'smoothbox')); ?>
            <!--<a href="help/contact"><?php //echo $this->translate("Contact Us"); ?></a>-->
          </div>
        <?php endif; ?>
      </div>
      <div class="footer_section">
        <div id="simple_timer"></div>
        <?php if($this->showsocialshare && ($this->facebook || $this->googleplus || $this->twitter || $this->youtube || $this->linkedin)): ?>
          <div class="social_icons">
            <ul>
              <?php if($this->facebook): ?>
                <li><a target="_blank" href="<?php echo $this->facebook; ?>"><i class="fa fa-facebook"></i></a></li>
              <?php endif; ?>
              <?php if($this->googleplus): ?>
                <li><a target="_blank"  href="<?php echo $this->googleplus; ?>"><i class="fa fa-twitter"></i></a></li>
              <?php endif; ?>
              <?php if($this->twitter): ?>
                <li><a target="_blank"  href="<?php echo $this->twitter; ?>"><i class="fa fa-linkedin"></i></a></li>
              <?php endif; ?>
              <?php if($this->youtube): ?>
                <li><a target="_blank"  href="<?php echo $this->youtube; ?>"><i class="fa fa-youtube"></i></a></li>
              <?php endif; ?>
              <?php if($this->linkedin): ?>
                <li><a target="_blank"  href="<?php echo $this->linkedin; ?>"><i class="fa fa-google-plus"></i></a></li>
              <?php endif; ?>
            </ul>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>

<?php elseif($this->default_activate == 2): ?>

  <div class="comming_soong_main_container">
    <div class="comming_soon_two_container">
      <div class="container_row">
        <?php if($this->text1): ?>
          <div class="head_section">
            <div class="main_tittle">
              <h2><?php echo $this->translate($this->text1); ?></h2>
            </div>
          </div>
        <?php endif; ?>
        <div class="middle_section">
          <div class="section_left">
            <?php if($this->text2): ?>
              <div class="small_tittle">
                <p><?php echo $this->translate($this->text2); ?></p>
              </div>
            <?php endif; ?>
            <?php if($this->text3): ?>
              <div class="discrtiption">
                <p><?php echo $this->translate($this->text3); ?></p>
              </div>
            <?php endif; ?>
            <?php if($this->showcontactbutton): ?>
            <div class="contect_button">
              <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'seserror', 'controller' => 'index', 'action' => 'contact'), $this->translate("Contact Us"), array('class' => 'smoothbox')); ?>
              <!--<a href="help/contact"><?php //echo $this->translate("Contact Us"); ?></a>-->
            </div>
            <?php endif; ?>
          </div>
          <div class="section_right">
            <div id="simple_timer"></div>
          </div>
        </div>
          <div class="footer_section">
            <?php if($this->showsocialshare && ($this->facebook || $this->googleplus || $this->twitter || $this->youtube || $this->linkedin)): ?>
              <div class="social_icons">
                <ul>
                  <?php if($this->facebook): ?>
                    <li><a target="_blank" href="<?php echo $this->facebook; ?>"><i class="fa fa-facebook"></i></a></li>
                  <?php endif; ?>
                  <?php if($this->googleplus): ?>
                    <li><a target="_blank"  href="<?php echo $this->googleplus; ?>"><i class="fa fa-twitter"></i></a></li>
                  <?php endif; ?>
                  <?php if($this->twitter): ?>
                    <li><a target="_blank"  href="<?php echo $this->twitter; ?>"><i class="fa fa-linkedin"></i></a></li>
                  <?php endif; ?>
                  <?php if($this->youtube): ?>
                    <li><a target="_blank"  href="<?php echo $this->youtube; ?>"><i class="fa fa-youtube"></i></a></li>
                  <?php endif; ?>
                  <?php if($this->linkedin): ?>
                    <li><a target="_blank"  href="<?php echo $this->linkedin; ?>"><i class="fa fa-google-plus"></i></a></li>
                  <?php endif; ?>
                </ul>
              </div>
            <?php endif; ?>
          </div>
      </div>
    </div>
  </div>

<?php elseif($this->default_activate == 3): ?>
  <div class="comming_soong_main_container">
    <div class="comming_soon_three_container sesbasic_bxs" style="background-image:url(application/modules/Seserror/externals/images/comingsoon/template_3.jpg);">
      <div class="container_row">
        <div class="head_section">
          <div id="simple_timer"></div>
        </div>
        <div class="middle_section">
          <?php if($this->text1): ?>
            <div class="main_tittle">
              <h2><?php echo $this->translate($this->text1); ?></h2>
            </div>
          <?php endif; ?>
          <?php if($this->text2): ?>
            <div class="small_tittle">
              <p><?php echo $this->translate($this->text2); ?></p>
            </div>
          <?php endif; ?>
          <?php if($this->text3): ?>
            <div class="discrtiption">
              <p><?php echo $this->translate($this->text3); ?></p>
            </div>
          <?php endif; ?>
        </div>
      </div>
      <?php if($this->showcontactbutton || $this->showsocialshare): ?>
        <div class="footer_section">
          <?php if($this->showcontactbutton): ?>
          <div class="contect_button">
            <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'seserror', 'controller' => 'index', 'action' => 'contact'), $this->translate("Contact Us"), array('class' => 'smoothbox')); ?>
            <!--<a href="help/contact"><?php //echo $this->translate("Contact Us"); ?></a>-->
          </div>
          <?php endif; ?>
          <?php if($this->showsocialshare && ($this->facebook || $this->googleplus || $this->twitter || $this->youtube || $this->linkedin)): ?>
            <div class="social_icons">
              <ul>
                <?php if($this->facebook): ?>
                  <li><a target="_blank" href="<?php echo $this->facebook; ?>"><i class="fa fa-facebook"></i></a></li>
                <?php endif; ?>
                <?php if($this->googleplus): ?>
                  <li><a target="_blank"  href="<?php echo $this->googleplus; ?>"><i class="fa fa-twitter"></i></a></li>
                <?php endif; ?>
                <?php if($this->twitter): ?>
                  <li><a target="_blank"  href="<?php echo $this->twitter; ?>"><i class="fa fa-linkedin"></i></a></li>
                <?php endif; ?>
                <?php if($this->youtube): ?>
                  <li><a target="_blank"  href="<?php echo $this->youtube; ?>"><i class="fa fa-youtube"></i></a></li>
                <?php endif; ?>
                <?php if($this->linkedin): ?>
                  <li><a target="_blank"  href="<?php echo $this->linkedin; ?>"><i class="fa fa-google-plus"></i></a></li>
                <?php endif; ?>
              </ul>
            </div>
          <?php endif; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>

<?php elseif($this->default_activate == 4): ?>
  <div class="comming_soon_main_container">
    <div class="comming_soon_four_container">
      <div class="container_row">
        <?php if($this->text1): ?>
          <div class="main_tittle">
            <h2><?php echo $this->translate($this->text1); ?></h2>
          </div>
        <?php endif; ?>
        <?php if($this->text2): ?>
          <div class="small_tittle">
            <p><?php echo $this->translate($this->text2); ?></p>
          </div>
        <?php endif ;?>
            
        
        <div class="soon_icon">
            <?php if($this->comingsoonphotoID): ?>
          <?php $photo = Engine_Api::_()->storage()->get($this->comingsoonphotoID, '');
            if($photo)
              $photo = $photo->getPhotoUrl(); ?>
          <img src="<?php echo $photo; ?>">
        <?php else: ?>
          <img src="application/modules/Seserror/externals/images/comingsoon/rocket.png" />
        <?php endif; ?>
        </div>
        
        <?php if($this->text3): ?>
          <div class="discrtiption">
            <p><?php echo $this->translate($this->text3); ?></p>
          </div>
        <?php endif; ?>
        <div id="simple_timer" style="text-align:center;"></div>
        <?php if($this->showsocialshare && ($this->facebook || $this->googleplus || $this->twitter || $this->youtube || $this->linkedin)): ?>
          <div class="social_icons">
            <ul>
              <?php if($this->facebook): ?>
                <li><a target="_blank" href="<?php echo $this->facebook; ?>"><i class="fa fa-facebook"></i></a></li>
              <?php endif; ?>
              <?php if($this->googleplus): ?>
                <li><a target="_blank"  href="<?php echo $this->googleplus; ?>"><i class="fa fa-twitter"></i></a></li>
              <?php endif; ?>
              <?php if($this->twitter): ?>
                <li><a target="_blank"  href="<?php echo $this->twitter; ?>"><i class="fa fa-linkedin"></i></a></li>
              <?php endif; ?>
              <?php if($this->youtube): ?>
                <li><a target="_blank"  href="<?php echo $this->youtube; ?>"><i class="fa fa-youtube"></i></a></li>
              <?php endif; ?>
              <?php if($this->linkedin): ?>
                <li><a target="_blank"  href="<?php echo $this->linkedin; ?>"><i class="fa fa-google-plus"></i></a></li>
              <?php endif; ?>
            </ul>
          </div>
        <?php endif; ?>
        <?php if($this->showcontactbutton): ?>
                    <div class="contect_button">
            <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'seserror', 'controller' => 'index', 'action' => 'contact'), $this->translate("Contact Us"), array('class' => 'smoothbox')); ?>
            <!--<a href="help/contact"><?php //echo $this->translate("Contact Us"); ?></a>-->
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>   
  
	<?php elseif($this->default_activate == 5): ?>
  <div class="comming_soong_main_container">
    <div class="comming_soon_five_container sesbasic_bxs">
      <div class="middle_section">
        <?php if($this->text1): ?>
          <div class="main_tittle">
            <h2><?php echo $this->translate($this->text1); ?></h2>
          </div>
        <?php endif; ?>
        <?php if($this->text2): ?>
          <div class="small_tittle">
            <p><?php echo $this->translate($this->text2); ?></p>
          </div>
        <?php endif; ?>
        <?php if($this->text3): ?>
          <div class="discrtiption">
            <p><?php echo $this->translate($this->text3); ?></p>
          </div>
        <?php endif; ?>
        <?php if($this->showcontactbutton): ?>
          <div class="contect_button">
            <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'seserror', 'controller' => 'index', 'action' => 'contact'), $this->translate("Contact Us"), array('class' => 'smoothbox')); ?>
            <!--<a href="help/contact"><?php //echo $this->translate("Contact Us"); ?></a>-->
          </div>
        <?php endif; ?>
                <?php if($this->showsocialshare && ($this->facebook || $this->googleplus || $this->twitter || $this->youtube || $this->linkedin)): ?>
          <div class="social_icons">
            <ul>
              <?php if($this->facebook): ?>
                <li><a target="_blank" href="<?php echo $this->facebook; ?>"><i class="fa fa-facebook"></i></a></li>
              <?php endif; ?>
              <?php if($this->googleplus): ?>
                <li><a target="_blank"  href="<?php echo $this->googleplus; ?>"><i class="fa fa-twitter"></i></a></li>
              <?php endif; ?>
              <?php if($this->twitter): ?>
                <li><a target="_blank"  href="<?php echo $this->twitter; ?>"><i class="fa fa-linkedin"></i></a></li>
              <?php endif; ?>
              <?php if($this->youtube): ?>
                <li><a target="_blank"  href="<?php echo $this->youtube; ?>"><i class="fa fa-youtube"></i></a></li>
              <?php endif; ?>
              <?php if($this->linkedin): ?>
                <li><a target="_blank"  href="<?php echo $this->linkedin; ?>"><i class="fa fa-google-plus"></i></a></li>
              <?php endif; ?>
            </ul>
          </div>
        <?php endif; ?>
      </div>
      <div class="footer_section">
        <div id="simple_timer"></div>

      </div>
    </div>
  </div>
  
  <?php elseif($this->default_activate == 6): ?>
  <div class="comming_soong_main_container">
    <div class="comming_soon_six_container sesbasic_bxs">
      <div class="middle_section">
        <?php if($this->text1): ?>
          <div class="main_tittle">
            <h2><?php echo $this->translate($this->text1); ?></h2>
          </div>
        <?php endif; ?>
        <?php if($this->text2): ?>
          <div class="small_tittle">
            <p><?php echo $this->translate($this->text2); ?></p>
          </div>
        <?php endif; ?>
        <?php if($this->text3): ?>
          <div class="discrtiption">
            <p><?php echo $this->translate($this->text3); ?></p>
          </div>
        <?php endif; ?>
        <?php if($this->showcontactbutton): ?>
          <div class="contect_button">
            <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'seserror', 'controller' => 'index', 'action' => 'contact'), $this->translate("Contact Us"), array('class' => 'smoothbox')); ?>
            <!--<a href="help/contact"><?php //echo $this->translate("Contact Us"); ?></a>-->
          </div>
        <?php endif; ?>
                <?php if($this->showsocialshare && ($this->facebook || $this->googleplus || $this->twitter || $this->youtube || $this->linkedin)): ?>
          <div class="social_icons">
            <ul>
              <?php if($this->facebook): ?>
                <li><a target="_blank" href="<?php echo $this->facebook; ?>"><i class="fa fa-facebook"></i></a></li>
              <?php endif; ?>
              <?php if($this->googleplus): ?>
                <li><a target="_blank"  href="<?php echo $this->googleplus; ?>"><i class="fa fa-twitter"></i></a></li>
              <?php endif; ?>
              <?php if($this->twitter): ?>
                <li><a target="_blank"  href="<?php echo $this->twitter; ?>"><i class="fa fa-linkedin"></i></a></li>
              <?php endif; ?>
              <?php if($this->youtube): ?>
                <li><a target="_blank"  href="<?php echo $this->youtube; ?>"><i class="fa fa-youtube"></i></a></li>
              <?php endif; ?>
              <?php if($this->linkedin): ?>
                <li><a target="_blank"  href="<?php echo $this->linkedin; ?>"><i class="fa fa-google-plus"></i></a></li>
              <?php endif; ?>
            </ul>
          </div>
        <?php endif; ?>
      </div>
      <div class="footer_section" style="background-image:url(application/modules/Seserror/externals/images/comingsoon/template_6.jpg);">
        <div id="simple_timer"></div>

      </div>
    </div>
  </div>

<?php elseif($this->default_activate == 7): ?>
  <div class="comming_soong_main_container">
    <div class="comming_soon_seven_container sesbasic_bxs" style="background-image:url(application/modules/Seserror/externals/images/comingsoon/template_7.jpg);">
      <div class="section_main">
      	<div class="middle_section">
        <div id="simple_timer"></div>
        <?php if($this->text1): ?>
          <div class="main_tittle">
            <h2><?php echo $this->translate($this->text1); ?></h2>
          </div>
        <?php endif; ?>
        <?php if($this->text2): ?>
          <div class="small_tittle">
            <p><?php echo $this->translate($this->text2); ?></p>
          </div>
        <?php endif; ?>
        <?php if($this->text3): ?>
          <div class="discrtiption">
            <p><?php echo $this->translate($this->text3); ?></p>
          </div>
        <?php endif; ?>
        <?php if($this->showcontactbutton): ?>
          <div class="contect_button">
            <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'seserror', 'controller' => 'index', 'action' => 'contact'), $this->translate("Contact Us"), array('class' => 'smoothbox')); ?>
            <!--<a href="help/contact"><?php //echo $this->translate("Contact Us"); ?></a>-->
          </div>
        <?php endif; ?>
      </div>
      	<div class="footer_section">
        
        <?php if($this->showsocialshare && ($this->facebook || $this->googleplus || $this->twitter || $this->youtube || $this->linkedin)): ?>
          <div class="social_icons">
            <ul>
              <?php if($this->facebook): ?>
                <li><a target="_blank" href="<?php echo $this->facebook; ?>"><i class="fa fa-facebook"></i></a></li>
              <?php endif; ?>
              <?php if($this->googleplus): ?>
                <li><a target="_blank"  href="<?php echo $this->googleplus; ?>"><i class="fa fa-twitter"></i></a></li>
              <?php endif; ?>
              <?php if($this->twitter): ?>
                <li><a target="_blank"  href="<?php echo $this->twitter; ?>"><i class="fa fa-linkedin"></i></a></li>
              <?php endif; ?>
              <?php if($this->youtube): ?>
                <li><a target="_blank"  href="<?php echo $this->youtube; ?>"><i class="fa fa-youtube"></i></a></li>
              <?php endif; ?>
              <?php if($this->linkedin): ?>
                <li><a target="_blank"  href="<?php echo $this->linkedin; ?>"><i class="fa fa-google-plus"></i></a></li>
              <?php endif; ?>
            </ul>
          </div>
        <?php endif; ?>
      </div>
      </div>
    </div>
  </div>
  <?php elseif($this->default_activate == 8): ?>
  <div class="comming_soong_main_container">
    <div class="comming_soon_eight_container sesbasic_bxs">
      <div class="section_main">
      	<div class="middle_section">
        
        <?php if($this->text1): ?>
          <div class="main_tittle">
            <h2><?php echo $this->translate($this->text1); ?></h2>
          </div>
        <?php endif; ?>
        <?php if($this->text2): ?>
          <div class="small_tittle">
            <p><?php echo $this->translate($this->text2); ?></p>
          </div>
        <?php endif; ?>
        <div id="simple_timer"></div>
      </div>
      	<div class="footer_section">
                <?php if($this->text3): ?>
          <div class="discrtiption">
            <p><?php echo $this->translate($this->text3); ?></p>
          </div>
        <?php endif; ?>
        <?php if($this->showcontactbutton): ?>
          <div class="contect_button">
            <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'seserror', 'controller' => 'index', 'action' => 'contact'), $this->translate("Contact Us"), array('class' => 'smoothbox')); ?>
            <!--<a href="help/contact"><?php //echo $this->translate("Contact Us"); ?></a>-->
          </div>
        <?php endif; ?>
        <?php if($this->showsocialshare && ($this->facebook || $this->googleplus || $this->twitter || $this->youtube || $this->linkedin)): ?>
          <div class="social_icons">
            <ul>
              <?php if($this->facebook): ?>
                <li><a target="_blank" href="<?php echo $this->facebook; ?>"><i class="fa fa-facebook"></i></a></li>
              <?php endif; ?>
              <?php if($this->googleplus): ?>
                <li><a target="_blank"  href="<?php echo $this->googleplus; ?>"><i class="fa fa-twitter"></i></a></li>
              <?php endif; ?>
              <?php if($this->twitter): ?>
                <li><a target="_blank"  href="<?php echo $this->twitter; ?>"><i class="fa fa-linkedin"></i></a></li>
              <?php endif; ?>
              <?php if($this->youtube): ?>
                <li><a target="_blank"  href="<?php echo $this->youtube; ?>"><i class="fa fa-youtube"></i></a></li>
              <?php endif; ?>
              <?php if($this->linkedin): ?>
                <li><a target="_blank"  href="<?php echo $this->linkedin; ?>"><i class="fa fa-google-plus"></i></a></li>
              <?php endif; ?>
            </ul>
          </div>
        <?php endif; ?>
      </div>
      </div>
    </div>
  </div>
<?php endif; ?>

<script type="text/javascript">
  sesJqueryObject(document).ready(function(){
    sesJqueryObject('#simple_timer').syotimer({
      year: <?php echo $comingsoonDate[0];?>,
      month: <?php echo $comingsoonDate[1]; ?>,
      day: <?php echo $comingsoonDate[2]; ?>,
//           hour: 20,
//           minute: 30
    });            
  });
</script>

