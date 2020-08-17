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
<div class="sespagenote_view_labels">
  <?php if(in_array('featured',$this->option) && $this->subject->featured){ ?>
    <span class="sespagenote_label_featured"><?php echo $this->translate('Featured') ;?></span>
  <?php } ?>
  <?php if(in_array('sponsored',$this->option) && $this->subject->sponsored){ ?>
    <span class="sespagenote_label_sponsored"><?php echo $this->translate('Sponsored') ;?></span>
  <?php } ?>
</div>
