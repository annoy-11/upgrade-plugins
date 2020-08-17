<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: manage-widgetize.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php include APPLICATION_PATH .  '/application/modules/Courses/views/scripts/dismiss_message.tpl';?>
<h3><?php echo $this->translate("Classrooms Widgetized Pages") ?></h3>
<p>
	<?php echo $this->translate('This page lists all the Widgetized Pages of the Classroom. From here, you can easily go to particular widgetized page in "Layout Editor" by clicking on "Widgetized Page" link.'); ?>
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
    <?php foreach ($this->classroomArray as $item):
    $corePages = Engine_Api::_()->sesbasic()->getwidgetizePage(array('name' => $item));
    $executed = false;
    ?>
    <tr>
      <td><?php echo $corePages->displayname ?></td>
      <td>
        <?php $url = $this->url(array('module' => 'core', 'controller' => 'content', 'action' => 'index'), 'admin_default').'?page='.$corePages->page_id;?>
        <a href="<?php echo $url;?>"  target="_blank"><?php echo "Widgetized Page";?></a>
      </td>
      <td>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

