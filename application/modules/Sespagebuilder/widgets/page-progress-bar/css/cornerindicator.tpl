<?php 
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: cornerindicator.tpl 2015-07-31 00:00:00 SocialEngineSolutions $
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
}
.pace .pace-activity {
  display: block;
  position: fixed;
  z-index: 2000;
  top: 0;
  right: 0;
  width: 300px;
  height: 300px;
  background:#<?php echo $this->color; ?>;
  -webkit-transition: -webkit-transform 0.3s;
  transition: transform 0.3s;
  -webkit-transform: translateX(100%) translateY(-100%) rotate(45deg);
  transform: translateX(100%) translateY(-100%) rotate(45deg);
  pointer-events: none;
}
.pace.pace-active .pace-activity {
  -webkit-transform: translateX(50%) translateY(-50%) rotate(45deg);
  transform: translateX(50%) translateY(-50%) rotate(45deg);
}
.pace .pace-activity::before,
.pace .pace-activity::after {
	-moz-box-sizing: border-box;
	box-sizing: border-box;
	position: absolute;
	bottom: 30px;
	left: 50%;
	display: block;
	border: 5px solid #fff;
	border-radius: 50%;
	content: '';
}
.pace .pace-activity::before {
	margin-left: -40px;
	width: 80px;
	height: 80px;
	border-right-color: rgba(0, 0, 0, .2);
	border-left-color: rgba(0, 0, 0, .2);
	-webkit-animation: pace-theme-corner-indicator-spin 3s linear infinite;
	animation: pace-theme-corner-indicator-spin 3s linear infinite;
}
.pace .pace-activity::after {
	bottom: 50px;
	margin-left: -20px;
	width: 40px;
	height: 40px;
	border-top-color: rgba(0, 0, 0, .2);
	border-bottom-color: rgba(0, 0, 0, .2);
	-webkit-animation: pace-theme-corner-indicator-spin 1s linear infinite;
	animation: pace-theme-corner-indicator-spin 1s linear infinite;
}
@-webkit-keyframes pace-theme-corner-indicator-spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(359deg); }
}
@keyframes pace-theme-corner-indicator-spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(359deg); }
}
</style>