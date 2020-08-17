<html>
<head>
  <?php $title = Engine_Api::_()->getApi('settings', 'core')->getSetting('core_general_site_title', $this->translate('_SITE_TITLE')); ?>
  <?php if($title): ?>
  <title><?php echo $this->translate("%s - Profile Locked", $title); ?></title>
  <?php else: ?>
  <title><?php echo $this->translate("Profile Locked"); ?></title>
  <?php endif; ?>

  <link href="<?php echo $this->baseUrl(); ?>/application/modules/Sesprofilelock/externals/styles/style_lock_screen.css" rel="stylesheet" />
</head>
<body>  
 <?php  $count = count($this->paginator); ?>
  <div class="page_background" id="page_background">    

     <img id="sesprofilelock_slides" alt="" src="" />
     
  </div>

  <div class="page_overlay"></div>
  <div class="lock_box_container">
    <?php if(isset($this->sesproflelock_popupinfovalue) && in_array('site_title', $this->sesproflelock_popupinfovalue)): ?>
    <div class="site_logo">
    <?php 
    
    if($this->logo):
    
$photoUrl = $this->baseUrl() . '/' . $this->logo;
$logo = "<img src='$photoUrl' height='' alt='' align='left' />";
   echo $logo;
    else: 
    echo $title;
    endif;
    ?>
    </div>
  <?php endif; ?>
    <div class="user_information_container">
      
      <div class="user_photo">
        <?php if ($this->viewer->photo_id): ?>
          <?php echo $this->itemPhoto($this->viewer, 'thumb.profile', $this->viewer->getTitle()) ?>
        <?php else: ?>
          <img src="<?php echo $this->layout()->staticBaseUrl ?>/application/modules/User/externals/images/nophoto_user_thumb_profile.png" alt="" />
        <?php endif; ?>
      </div>
      <div class="user_info">
        <?php if(isset($this->sesproflelock_popupinfovalue) && in_array('member_title', $this->sesproflelock_popupinfovalue)): ?>
        <h2><?php echo $this->viewer->getTitle() ?></h2>
        <?php endif; ?>
        
        <?php if(isset($this->sesproflelock_popupinfovalue) && in_array('email', $this->sesproflelock_popupinfovalue) && $this->viewer->email): ?>
          <div class="user_email"><?php echo $this->viewer->email; ?></div>
        <?php endif; ?>
        <?php if(isset($this->sesproflelock_popupinfovalue) && in_array('locked_text', $this->sesproflelock_popupinfovalue)): ?>
        <div class="user_loked"><?php echo $this->translate("Locked"); ?></div>
        <?php endif; ?>
        <div class="user_login_form">
          <?php echo $this->form->render($this); ?>
        </div>
        <?php $viewer_id = $this->viewer->getIdentity(); ?>
        <?php if(isset($this->sesproflelock_popupinfovalue) && in_array('signout_link', $this->sesproflelock_popupinfovalue) && $viewer_id): ?>
				<div class="relogin_link">
					<a href="<?php echo $this->url(array('module' => 'user', 'controller' => 'auth', 'action' => 'signout-delete'), 'user_logout'); ?>"><?php echo $this->translate("Not %s, logout?", $this->viewer->getTitle()); ?></a>
				</div>
        <?php endif; ?>
      </div>
    </div>
    


<script type="text/javascript">
    var timeToDisplay = 7000;
    var opacityChangeDelay = 30;
    var opacityChangeAmount = 0.1;

    <?php $slides_array = array(); 
      if($count > 0): 
      
    foreach ($this->paginator as $item) :  ?>
    <?php $slides_array[] = $this->storage->get($item->file_id, '')->getPhotoUrl(); ?>
    <?php endforeach; ?>
<?php else: ?>
<?php $slides_array = array("http://" . $_SERVER['SERVER_NAME'] . $this->baseUrl() . '/application/modules/Sesprofilelock/externals/images/backgrounds/bg1.jpg', "http://" . $_SERVER['SERVER_NAME'] . $this->baseUrl() . '/application/modules/Sesprofilelock/externals/images/backgrounds/bg2.jpg', "http://" . $_SERVER['SERVER_NAME'] . $this->baseUrl() . '/application/modules/Sesprofilelock/externals/images/backgrounds/bg3.jpg');
 ?>
          <?php endif; ?>
  
var slideshow = document.getElementById("sesprofilelock_slides");
var urls=<?php echo json_encode($slides_array); ?>;
    var index = 0;
    var transition = function() {
        var url = urls[index];
        document.getElementById("sesprofilelock_slides").setAttribute('src', url);
        index = index + 1;
        if (index > urls.length - 1) {
            index = 0;
        }
    };
    var fadeIn = function(opacity) {
        opacity = opacity + opacityChangeAmount;
        document.getElementById("sesprofilelock_slides").style.opacity = opacity;
        if (opacity >= 1) {
            setTimeout(function() {
             changeImage(opacity);
              }, timeToDisplay);
              return;
        }
        setTimeout(function() {
            fadeIn(opacity);
        }, opacityChangeDelay);
    };
var changeImage = function(opacity) {
        setTimeout(function() {
            fadeOut(opacity);
          }, opacityChangeDelay);

};
    var fadeOut = function(opacity) {
        opacity = opacity - opacityChangeAmount;
       document.getElementById("sesprofilelock_slides").style.opacity = opacity;
        if (opacity <= 0) {
            transition();
             fadeIn(0);
           return;
        }
        setTimeout(function() {
            fadeOut(opacity);
        }, opacityChangeDelay);
    };
    transition();
    fadeIn(0);
    </script>
</body>
</html>
<?php die; ?>
