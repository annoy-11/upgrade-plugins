<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eandroidstories
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: dismiss_message.tpl 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>

<h2><?php echo $this->translate("Stories Feature in Android Mobile Apps") ?></h2>

<?php //$eandroidstories_adminmenu = Zend_Registry::isRegistered('eandroidstories_adminmenu') ? Zend_Registry::get('eandroidstories_adminmenu') : null; ?>

<?php //if(!empty($eandroidstories_adminmenu)) { ?>
  <?php if( count($this->navigation) ):?>
    <div class='sesbasic-admin-navgation'>
      <ul class="navigation">
        <?php foreach( $this->navigation as $link ): ?>
          <li class="<?php echo $link->get('active') ? 'active' : '' ?>">
            <?php if(!empty($link->plateform)) { ?>
              <a href='<?php echo $link->getHref() . "?plateform=".$link->plateform ?>' class="<?php echo $link->getClass() ? ' ' . $link->getClass() : ''  ?>"><?php echo $this->translate($link->getlabel()) ?></a>
            <?php } else { ?>
              <a href='<?php echo $link->getHref() ?>' class="<?php echo $link->getClass() ? ' ' . $link->getClass() : ''  ?>"><?php echo $this->translate($link->getlabel()) ?></a>
            <?php } ?>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>
<?php //} ?>
<?php if(!empty($this->subNavigation) && count($this->subNavigation) ): ?>
  <div class='sesbasic-admin-sub-tabs'>
    <ul class="navigation">
      <?php foreach( $this->subNavigation as $link ): ?>
        <li class="<?php echo $link->get('active') ? 'active' : '' ?>">
          <?php if(!empty($link->plateform)) { ?>
            <a href='<?php echo $link->getHref() . "?plateform=".$link->plateform ?>' class="<?php echo $link->getClass() ? ' ' . $link->getClass() : ''  ?>"><?php echo $this->translate($link->getlabel()) ?></a>
          <?php } else { ?>
            <a href='<?php echo $link->getHref() ?>' class="<?php echo $link->getClass() ? ' ' . $link->getClass() : ''  ?>"><?php echo $this->translate($link->getlabel()) ?></a>
          <?php } ?>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>
