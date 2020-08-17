<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>
<div class="sesbasic_alphabetic_search">
  <?php $alphbet_array = array('all' => "#", "a" => "A", "b" => "B", "c" => "C", "d" => "D", "e" => "E", "f" => "F", "g" => "G", "h" => "H", "i" => "I", "j" => "J", "k" => "K", "l" => "L", "m" => "M", "n" => "N", "o" => "O", "p" => "P", "q" => "Q", "r" => "R", "s" => "S", "t" => "T", "u" => "U", "v" => "V", "w" => "W", "x" => "X", "y" => "Y", "z" => "Z"); ?>
  <?php foreach($alphbet_array as $key => $alphbet): ?>
    <a href="<?php echo $this->url(array('action' => 'browse'), 'estore_general', true) . '?alphabet=' . urlencode($key)?>" <?php if(isset($_GET['alphabet']) && $_GET['alphabet'] == $key):?>class="sesbasic_alphabetic_search_current"<?php endif;?>><?php echo $this->translate($alphbet);?></a>  <?php endforeach; ?>
</div>
