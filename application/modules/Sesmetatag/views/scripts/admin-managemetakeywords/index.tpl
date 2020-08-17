<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmetatag
 * @package    Sesmetatag
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2017-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>

<?php include APPLICATION_PATH .  '/application/modules/Sesmetatag/views/scripts/dismiss_message.tpl';?>

<h3 style="margin-bottom:6px;">Meta Tags Settings for Widgetized Pages</h3>
<p>Here, you can enter the meta title, meta description and meta image for Facebook Open Graph & Twitter Cards for all the widgetized pages on your website.<br />The View pages of all the content and member profile page will have own meta tags, so these tags will be appended to their tags automatically according to SE standards.</p>
<br class="clear" />
<?php //echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesmetatag', 'controller' => 'managemetakeywords', 'action' => 'add'), $this->translate("Add New Page"), array('class'=>'buttonlink sesbasic_icon_add'));
?>
<!--<br /><br />-->

<div class='admin_search sesbasic_search_form'>
  <?php echo $this->formFilter->render($this) ?>
</div>
<br />
<div class='admin_results'>
  <div>
    <?php $count = $this->paginator->getTotalItemCount() ?>
    <?php echo $this->translate(array("%s entry found.", "%s entries found.", $count),
        $this->locale()->toNumber($count)) ?>
  </div>

</div><br />
<?php if(count($this->paginator)): ?>
<form id='multidelete_form'>
  <table class='admin_table' style="width:100%;">
    <thead>
      <tr>
        <th align="left">
          <?php echo $this->translate("Page ID"); ?>
        </th>
        <th align="left">
          <?php echo $this->translate("Page Name"); ?>
        </th>
        <th align="left">
          <?php echo $this->translate("Meta Title"); ?>
        </th>
        <th align="left">
          <?php echo $this->translate("Meta Description"); ?>
        </th>
        <th align="left">
          <?php echo $this->translate("Meta Image"); ?>
        </th>
        <th class="left">
          <?php echo $this->translate("Status"); ?>
        </th>
        <th align="left">
          <?php echo $this->translate("Options"); ?>
        </th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($this->paginator as $item): ?>
        <?php 
          $title = Engine_Api::_()->sesbasic()->getwidgetizePageName(array('page_id' => $item->page_id)); 
        ?>
        <tr>
          <td><?php if( !empty($item->page_id) ){ echo $item->page_id; } ?></td>
          <td><?php if( !empty($item->page_id) ){ echo $title; }else { echo '-'; } ?></td>
          <td><?php if( !empty($item->meta_title) ){ echo $item->meta_title; }else { echo '-'; } ?></td>
          <td><?php if( !empty($item->meta_description) ){ echo $item->meta_description; }else { echo '-'; } ?></td>
          
          <td>
            <?php if($item->file_id): ?>
              <img height="100px;" width="100px;" alt="" src="<?php echo Engine_Api::_()->storage()->get($item->file_id, '')->getPhotoUrl(); ?>" />
            <?php else: ?>
              <?php echo "---"; ?>
            <?php endif; ?>
          </td>
          
          <td>
            <?php echo ( $item->enabled ? $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesmetatag', 'controller' => 'managemetakeywords', 'action' => 'enabled', 'managemetatag_id' => $item->managemetatag_id ), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title' => $this->translate('Disable'))), array())  : $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesmetatag', 'controller' => 'managemetakeywords', 'action' => 'enabled', 'managemetatag_id' => $item->managemetatag_id ), $this->htmlImage('application/modules/Sesbasic/externals/images/icons/error.png', '', array('title' => $this->translate('Enable')))) ) ?>
          </td >
          <td><a href="<?php echo $this->url(array('action' => 'delete', 'managemetatag_id' => $item->managemetatag_id)) ?>" class="smoothbox"><?php echo $this->translate("Delete") ?></a> | 
            <a href="<?php echo $this->url(array('action' => 'edit', 'managemetatag_id' => $item->managemetatag_id)) ?>"><?php echo $this->translate("Edit") ?>
            </a>
          </td>
        </tr>
      <?php  endforeach; ?>
    </tbody>
  </table>
</form>
<br />
<div>
  <?php echo $this->paginationControl($this->paginator); ?>
</div>
<?php else: ?>
<div class="tip">
  <span>
    <?php echo $this->translate("No pages integrated yet.") ?>
  </span>
</div>
<?php endif; ?>