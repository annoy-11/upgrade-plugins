<?php

?>
<?php include APPLICATION_PATH .  '/application/modules/Seseventmusic/views/scripts/dismiss_message.tpl';?>
<h3><?php echo $this->translate("Manage Widgetize Pages") ?></h3>
<p>
	<?php echo $this->translate('This page lists all of the Widgetize Page in this plugin. From here you can easily go to particular page in "Layout Editor" by clicking on "Get Widgetize Page" and also you can view directly user side page by click on "View Page" link.'); ?>
</p>
<br />
<table class='admin_table'>
  <thead>
    <tr>
      <th><?php echo $this->translate("Page Name") ?></th>
      <th><?php echo $this->translate("Options") ?></th>
      <th><?php echo $this->translate("Demo Links") ?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($this->pagesArray as $item):
    $corePages = Engine_Api::_()->sesbasic()->getwidgetizePage(array('name' => $item));
    $page = explode("_",$corePages->name);
    $executed = false;
    ?>
    <tr>
      <td><?php echo $corePages->displayname ?></td>
      <td>
        <?php $url = $this->url(array('module' => 'core', 'controller' => 'content', 'action' => 'index'), 'admin_default').'?page='.$corePages->page_id;?>
        <a href="<?php echo $url;?>"  target="_blank"><?php echo "Get Widgetize Page";?></a>
      </td>
      <td>
      </td>
    </tr>
    <?php $results = ''; ?>
    <?php endforeach; ?>
  </tbody>
</table>