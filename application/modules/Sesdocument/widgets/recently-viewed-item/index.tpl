
<?php if($this->view_type == 'list'): ?>
  <ul class="sesbasic_sidebar_block sesdocument_side_block sesbasic_bxs sesbasic_clearfix">
<?php else: ?>
  <ul class="sesdocument_side_block sesbasic_bxs sesbasic_clearfix">
<?php endif;  ?>
  <?php include APPLICATION_PATH . '/application/modules/Sesdocument/views/scripts/_sidebarWidgetData.tpl'; ?>
</ul>
