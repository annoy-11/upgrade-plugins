<?php

?>
<?php if(count($this->paginator) <= 0): ?>
<div class="tip">
      <span>
        <?php echo $this->translate('Nobody has created an '.$this->itemType.' yet.');?>
        <?php if ($this->canCreate):?>
          <?php echo $this->translate('Be the first to %1$screate%2$s one!', '<a href="'.$this->url(array('action' => 'create','module'=>'sesgroupalbum'), "sesgroupalbum_general",true).'">', '</a>'); ?>
        <?php endif; ?>
      </span>
    </div>
<?php endif; ?>