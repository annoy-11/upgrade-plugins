
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesdocument/externals/styles/styles.css'); ?> 
<ul class="sesbasic_quick_links sesbasic_bxs">
  <?php foreach( $this->quickNavigation as $link ): ?>
    <li>
      <?php echo $this->htmlLink($link->getHref(), $this->translate($link->getLabel()), array(
        'class' => 'sesbasic_link_btn sesbasic_icon_add sesdocument_quick_create',
        'target' => $link->get('target'),
      )) ?>
    </li>
  <?php endforeach; ?>
</ul>
