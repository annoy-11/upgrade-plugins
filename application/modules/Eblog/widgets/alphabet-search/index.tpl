<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Eblog
 * @package    Eblog
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<div class="sesbasic_alphabetic_search">
  <?php $URL =  $this->url(array('action' => 'browse'), 'eblog_general', true); ?>
  <?php foreach($this->alphbet_array as $key => $alphbet): ?>
    <a href="<?php echo $URL . '?alphabet=' . urlencode($key)?>" <?php if(isset($_GET['alphabet']) && $_GET['alphabet'] == $key):?> class="sesbasic_alphabetic_search_current"<?php endif;?>><?php echo $this->translate($alphbet);?></a>  
  <?php endforeach; ?>
</div>
