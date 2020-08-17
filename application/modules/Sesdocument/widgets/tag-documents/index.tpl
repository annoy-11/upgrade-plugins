
<div class="sesdocument_tags sesbasic_clearfix sesbasic_bxs">
  <?php foreach($this->tagCloudData as $valueTags){ 
  if($valueTags['text'] == '' && empty($valueTags['text']))
  continue;
  ?>
  <a href="<?php echo $this->url(array('module' =>'sesdocument','controller' => 'index', 'action' => 'browse'),'sesdocument_general',true).'?tag_id='.$valueTags['tag_id'].'&tag_name='.$valueTags['text'];?>">    <b><?php echo $valueTags['text'] ?></b><sup><?php echo $valueTags['itemCount']; ?></sup></a>
  <?php } ?>
</div>