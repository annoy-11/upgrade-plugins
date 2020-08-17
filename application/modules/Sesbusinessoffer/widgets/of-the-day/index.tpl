<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessoffer
 * @package    Sesbusinessoffer
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $height = $this->params['height_grid'];?>
<?php $width = $this->params['width_grid'];?>
<?php $viewTypeClass = "sesbusinessoffer_list_type";?>
<?php //foreach( $this->paginator as $result ) {  ?>
  <?php $item = $this->paginator; //Engine_Api::_()->getItem('businessoffer', $result); ?>
  <?php include APPLICATION_PATH .  '/application/modules/Sesbusinessoffer/views/scripts/offer/_gridView.tpl';?>
<?php //} ?>
