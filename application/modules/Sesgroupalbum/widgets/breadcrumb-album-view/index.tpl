<?php

?>
<div class="sesbasic_breadcrumb">
  <a href="<?php echo $this->url(array('action' => 'home'), "sesgroupalbum_general"); ?>"><?php echo $this->translate("Album Home"); ?></a>&nbsp;&raquo;
  <a href="<?php echo $this->url(array('action' => 'browse'), "sesgroupalbum_general"); ?>"><?php echo $this->translate("Browse Albums"); ?></a>&nbsp;&raquo;
  <a href="<?php echo $this->group->getHref(); ?>"><?php echo $this->group->getTitle(); ?></a>&nbsp;&raquo;
  <?php echo $this->album->getTitle(); ?>
</div>