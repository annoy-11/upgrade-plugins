<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: _services.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<ul class="_reviewstype">
  <?php foreach($navigation as $subnavigationMenu): ?>
    <li <?php if ($subnavigationMenu->active): ?><?php echo "class='_active'";?><?php endif; ?> >
      <?php if ($subnavigationMenu->action){ ?>
        <a class= "<?php echo $subnavigationMenu->class ?>" href="<?php echo empty($subnavigationMenu->uri) ? $this->url(array('action' => $subnavigationMenu->action), $subnavigationMenu->route, true) : $subnavigationMenu->uri ?>"><?php echo $this->translate($subnavigationMenu->label); ?></a>
      <?php } else { ?>
        <a class= "<?php echo $subnavigationMenu->class ?>" href='<?php echo empty($subnavigationMenu->uri) ? $this->url(array(), $subnavigationMenu->route, true) : $subnavigationMenu->uri ?>'><?php echo $this->translate($subnavigationMenu->label); ?></a>
      <?php } ?>
    </li>
  <?php $subcountMenu++; endforeach; ?>
</ul>
