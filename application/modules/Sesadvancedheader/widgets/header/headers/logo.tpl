<?php ?>
<?php if($this->headerlogo): ?>
  <div class="header_logo">
    <?php $headerlogo = $this->baseUrl() . '/' . $this->headerlogo; ?>
    <a href="<?php echo $this->baseUrl(); ?>"><img style="height:<?php echo $this->sesadvancedheader_header_logoheight; ?>px;margin-top:<?php echo $this->sesadvancedheader_header_logomargintop ?>px;" alt="<?php echo $this->siteTitle; ?>" src="<?php echo $headerlogo ?>"></a>
  </div>
<?php else: ?>
  <div class="header_logo">
    <a href="<?php echo $this->baseUrl(); ?>"><?php echo $this->siteTitle; ?></a>
  </div>
<?php endif; ?>