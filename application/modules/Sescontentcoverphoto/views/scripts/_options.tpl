<?php ?>

<?php if($this->resource_type == 'user'): ?>
  <?php echo $this->content()->renderWidget("user.profile-options",array("optionsG"=>true)); ?>
<?php elseif($this->resource_type == 'blog'): ?>
  <?php echo $this->content()->renderWidget("blog.gutter-menu",array("optionsG"=>true)); ?>
<?php elseif($this->resource_type == 'event'): ?>
  <?php echo $this->content()->renderWidget("event.profile-options",array("optionsG"=>true)); ?>
<?php elseif($this->resource_type == 'group'): ?>
  <?php echo $this->content()->renderWidget("group.profile-options",array("optionsG"=>true)); ?>
<?php endif; ?>