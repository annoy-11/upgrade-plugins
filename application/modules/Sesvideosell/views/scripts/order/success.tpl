<?php

?>
<form method="get" action="<?php echo $this->escape($this->url(array('video_id' => $this->resource->getIdentity(), 'user_id' => $this->resource->owner_id, 'slug' => $this->resource->getSlug()), 'sesvideo_view', true)) ?>" class="global_form" enctype="application/x-www-form-urlencoded">
  <div>
    <div>
      <h3>
        <?php echo $this->translate('Payment Complete') ?>
      </h3>
      <p class="form-description">
        <?php echo $this->translate('Thank you! Your payment has completed successfully.') ?>
      </p>
      <div class="form-elements">
        <div id="buttons-wrapper" class="form-wrapper">
          <button type="submit">
            <?php echo $this->translate('Continue') ?>
          </button>
        </div>
      </div>
    </div>
  </div>
</form>