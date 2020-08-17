<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessreview
 * @package    Sesbusinessreview
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: edit.tpl  2018-11-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<div id="sesbusinessreview_review_rate"></div>
<?php  echo $this->partial('_review.tpl','sesbusinessreview',array('review'=>$this->review,'rating_count'=> $this->rating_count,'stats'=>$this->stats, 'form' => $this->form)); ?> 