<?php 
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: centerradar.tpl 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */ 
 ?>
<style type="text/css">
.pace {
  -webkit-pointer-events: none;
  pointer-events: none;
  -webkit-user-select: none;
  -moz-user-select: none;
  user-select: none;
  z-index: 2000;
  position: fixed;
  height: 90px;
  width: 90px;
  margin: auto;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
}
.pace.pace-inactive .pace-activity {
  display: none;
}
.pace .pace-activity {
  position: fixed;
  z-index: 2000;
  display: block;
  position: absolute;
  left: -30px;
  top: -30px;
  height: 90px;
  width: 90px;
  display: block;
  border-width: 30px;
  border-style: double;
  border-color:#<?php echo $this->color; ?> transparent transparent;
  border-radius: 50%;
  -webkit-animation: spin 1s linear infinite;
  -moz-animation: spin 1s linear infinite;
  -o-animation: spin 1s linear infinite;
  animation: spin 1s linear infinite;
}
.pace .pace-activity:before {
  content: ' ';
  position: absolute;
  top: 10px;
  left: 10px;
  height: 50px;
  width: 50px;
  display: block;
  border-width: 10px;
  border-style: solid;
  border-color: #<?php echo $this->color; ?> transparent transparent;
  border-radius: 50%;
}
@-webkit-keyframes spin {
  100% { -webkit-transform: rotate(359deg); }
}
@-moz-keyframes spin {
  100% { -moz-transform: rotate(359deg); }
}
@-o-keyframes spin {
  100% { -moz-transform: rotate(359deg); }
}
@keyframes spin {
  100% {  transform: rotate(359deg); }
}
</style>