<?php 
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: bigcounter.tpl 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */ 
 ?>
<style type="text/css">
..pace {
  -webkit-pointer-events: none;
  pointer-events: none;
  -webkit-user-select: none;
  -moz-user-select: none;
  user-select: none;
}
.pace.pace-inactive .pace-progress {
  display: none;
}
.pace .pace-progress {
  position: fixed;
  z-index: 2000;
  top: 0;
  right: 0;
  height: 5rem;
  width: 5rem;
  -webkit-transform: translate3d(0, 0, 0) !important;
  -ms-transform: translate3d(0, 0, 0) !important;
  transform: translate3d(0, 0, 0) !important;
}
.pace .pace-progress:after {
  display: block;
  position: absolute;
  top: 0;
  right: .5rem;
  content: attr(data-progress-text);
  font-family: "Helvetica Neue", sans-serif;
  font-weight: 100;
  font-size: 5rem;
  line-height: 1;
  text-align: right;
  color: #<?php echo $this->color; ?>;
}
</style>