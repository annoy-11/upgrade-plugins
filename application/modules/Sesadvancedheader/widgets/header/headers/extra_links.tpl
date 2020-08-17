<?php ?>
<div class="header_social_icons">
  <?php foreach( $this->social_navigation as $link ): ?>
      <?php 
        $linkIcon = $link->get('icon') ? $link->get('icon') : 'fa-star';
      if($linkIcon == "fa-phone"){ ?>
        <p><i class="fa fa-phone"></i> <span><?php echo $this->translate($link->getlabel()) ?></span></p>
      <?php }else{ ?>
      <a href='<?php echo $link->getHref() ?>' class="<?php echo $link->getClass() ? ' ' . $link->getClass() : ''  ?>"
        <?php if( $link->get('target') ): ?> target='<?php echo $link->get('target') ?>' <?php endif; ?> >
        <i class="fa <?php echo $linkIcon; ?>"></i>
        <span><?php echo $this->translate($link->getlabel()) ?></span>
      </a>
      <?php } ?>
  <?php endforeach; ?>
</div>