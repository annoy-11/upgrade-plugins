
<?php include APPLICATION_PATH .  '/application/modules/Sesdocument/views/scripts/dismiss_message.tpl';?>
<h3><?php echo $this->translate("Links to Widgetized Pages") ?></h3>
<p>
	<?php echo $this->translate('This page lists all the Widgetized Pages of this plugin. From here, you can easily go to particular widgetized page in "Layout Editor" by clicking on "Widgetized Page" link. '); ?>
</p>
<br />
<table class='admin_table'>
  <thead>
    <tr>
      <th><?php echo $this->translate("Page Name") ?></th>
      <th><?php echo $this->translate("Options") ?></th>
 
    </tr>
  </thead>
  <tbody>
    <?php foreach ($this->documentsArray as $item):
    $corePages = Engine_Api::_()->sesbasic()->getwidgetizePage(array('name' => $item));
    $page = explode("_",$corePages->name);
    $executed = false;
    ?>
    <tr>
      <td><?php echo $corePages->displayname ?></td>
      <td>
        <?php $url = $this->url(array('module' => 'core', 'controller' => 'content', 'action' => 'index'), 'admin_default').'?page='.$corePages->page_id;?>
        <a href="<?php echo $url;?>"  target="_blank"><?php echo "Widgetized Page";?></a>
        <?php if($corePages->name != 'sespage_join_view' && $corePages->name != 'sespage_profile_index_1' && $corePages->name != 'sespage_profile_index_2' && $corePages->name != 'sespage_profile_index_3' && $corePages->name != 'sespage_profile_index_4' && $corePages->name != 'sespage_category_index'  &&  $corePages->name != 'sespage_album_view' && $corePages->name != 'sespage_photo_view' && $corePages->name != 'sespage_index_claim-requests' && $corePages->name != 'sespage_index_claim'):?>
        
        <?php endif;?>
      </td>
      <td>
      </td>
    </tr>
    <?php $results = ''; ?>
    <?php endforeach; ?>
  </tbody>
</table>

