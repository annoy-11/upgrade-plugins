<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesinterest
 * @package    Sesinterest
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-03-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $height = $this->params['height_grid'];?>
<?php $width = $this->params['width_grid'];?>
<?php $viewTypeClass = "sespagenote_list_type";?>
<?php //foreach( $this->paginator as $result ) {  ?>
  <?php $item = $this->paginator; //Engine_Api::_()->getItem('pageoffer', $result); ?>
  <?php include APPLICATION_PATH .  '/application/modules/Sespagenote/views/scripts/note/_gridView.tpl';?>
<?php //} ?>
