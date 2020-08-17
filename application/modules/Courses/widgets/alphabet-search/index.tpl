<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<div class="sesbasic_alphabetic_search">
  <?php $current_url = explode('?', $this->request->getRequestUri());
        $URL =  $current_url[0]; 
  ?>
  <?php $alphbet_array = array('all' => "#", "a" => "A", "b" => "B", "c" => "C", "d" => "D", "e" => "E", "f" => "F", "g" => "G", "h" => "H", "i" => "I", "j" => "J", "k" => "K", "l" => "L", "m" => "M", "n" => "N", "o" => "O", "p" => "P", "q" => "Q", "r" => "R", "s" => "S", "t" => "T", "u" => "U", "v" => "V", "w" => "W", "x" => "X", "y" => "Y", "z" => "Z"); ?>
  <?php foreach($alphbet_array as $key => $alphbet): ?>
    <a href="<?php echo $URL . '?alphabet=' . urlencode($key)?>" <?php if(isset($_GET['alphabet']) && $_GET['alphabet'] == $key):?> class="sesbasic_alphabetic_search_current"<?php endif;?>><?php echo $this->translate($alphbet);?></a>  <?php endforeach; ?>
</div>
