 <?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: rating.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?> 
  <div class="sesbasic_rating_star">
      <?php for($i = 1; $i <= $classroom->rating; $i++): ?>
        <span id="" class="rating_star"></span>
      <?php endfor; ?>
     <!-- <span id="" class="rating_star"></span>
      <span id="" class="rating_star"></span>
      <span id="" class="rating_star"></span>
      <span id="" class="rating_star"></span>-->
  </div>
