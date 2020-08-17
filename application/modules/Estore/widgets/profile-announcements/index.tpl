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
<div class="estore_profile_announcements sesbasic_bxs">
  <ul>
  <?php foreach($this->paginator as $announcement):?>
    <li class="_item">
      <div class="_title"><h3><?php echo $announcement->title;?></h3></div>
      <div class="_date"><i class="sesbasic_text_light fa fa-calendar"></i>&nbsp;<span><?php echo date('jS M', strtotime($announcement->creation_date));?> at&nbsp;<?php echo date('h:i a', strtotime($announcement->creation_date));?></span></div>
      <div class="sesbasic_html_block _body">
        <p><?php echo $announcement->body;?></p>
      </div>
    </li>
  <?php endforeach;?>
  </ul>
</div>
