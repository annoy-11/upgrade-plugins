<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesqa
 * @package    Sesqa
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-10-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php if($this->viewType == 'list1' || $this->viewType == "list2"){ ?>
<div class="sesqa_listview sesbasic_bxs sesbasic_clearfix">
    <?php if($this->viewType == 'list1'){
      include("application/modules/Sesqa/views/scripts/_list1.tpl");
    }else{
      include("application/modules/Sesqa/views/scripts/_list2.tpl");
    }
    ?>
</div>
<?php }else{ ?>
  <div class="sesqa_gridview sesbasic_bxs sesbasic_clearfix">
    <?php 
      if($this->viewType == 'grid1'){
        include("application/modules/Sesqa/views/scripts/_grid1.tpl");
      }else{
        include("application/modules/Sesqa/views/scripts/_grid2.tpl");
      }
    ?>
  </div>
<?php } ?>