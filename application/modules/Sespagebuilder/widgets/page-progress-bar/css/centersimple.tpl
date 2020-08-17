<?php 
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: centersimple.tpl 2015-07-31 00:00:00 SocialEngineSolutions $
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
  margin: auto;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  height: 5px;
  width: 200px;
  background: #fff;
  border: 1px solid #<?php echo $this->color; ?>;
  overflow: hidden;
}
.pace .pace-progress {
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  -ms-box-sizing: border-box;
  -o-box-sizing: border-box;
  box-sizing: border-box;
  -webkit-transform: translate3d(0, 0, 0);
  -moz-transform: translate3d(0, 0, 0);
  -ms-transform: translate3d(0, 0, 0);
  -o-transform: translate3d(0, 0, 0);
  transform: translate3d(0, 0, 0);
  max-width: 200px;
  position: fixed;
  z-index: 2000;
  display: block;
  position: absolute;
  top: 0;
  right: 100%;
  height: 100%;
  width: 100%;
  background: #<?php echo $this->color; ?>;
}
.pace.pace-inactive {
  display: none;
}
</style>