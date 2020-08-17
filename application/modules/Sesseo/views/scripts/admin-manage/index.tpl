<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesseo
 * @package    Sesseo
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-03-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php include APPLICATION_PATH .  '/application/modules/Sesseo/views/scripts/dismiss_message.tpl';?>
<?php $filepath = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'public'. DIRECTORY_SEPARATOR .'sesseo'; ?>


<h3 style="margin-bottom:6px;">Index Sitemap</h3>
<p>Here, you can view all content sitemap files.</p>
<br />
<div class="sesseo_sitemap_admin_options">
<?php if(file_exists($filepath .DIRECTORY_SEPARATOR.'sitemap'.'.xml')) { ?>
  <a href="public/sesseo/sitemap.xml" target="_blank">View Sitemap</a>
  <a href="<?php echo $this->url(array('action' => 'downloadxml')) ?>">Download Sitemap XML</a>
  <a href="<?php echo $this->url(array('action' => 'downloadgzip')) ?>">Download Sitemap Gzip File</a>
  <a href="<?php echo $this->url(array('action' => 'generateall')) ?>" class="smoothbox">Regenerate Sitemap</a>
  
  
  <a href="<?php echo $this->url(array('action' => 'submit')) ?>" class="smoothbox">Submit</a>
<?php } else { ?>
  <a href="<?php echo $this->url(array('action' => 'generateall')) ?>" class="smoothbox">Generate Sitemap</a>
<?php } ?>
  </div>
<br/>



<h3 style="margin-bottom:6px;">Content Sitemap</h3>
<p>From here, you can create sitemap for particular content. You can modify settings by click on "Edit" link.</p>
<br class="clear" />
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
          <?php echo $this->translate("Content Title"); ?>
        </th>
        <th align="left">
          <?php echo $this->translate("Frequency"); ?>
        </th>
        <th align="left">
          <?php echo $this->translate("Priority"); ?>
        </th>
        <th class="left">
          <?php echo $this->translate("Status"); ?>
        </th>
        <th class="left">
          <?php echo $this->translate("Sitemap File"); ?>
        </th>
        <th align="left">
          <?php echo $this->translate("Options"); ?>
        </th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($this->paginator as $item): ?>
        <tr>
          <td><?php if( !empty($item->title) ){ echo $item->title; } ?></td>
          <td><?php if( !empty($item->frequency) ){ echo $item->frequency; } ?></td>  
          <td><?php if( !empty($item->priority) ){ echo $item->priority; } ?></td>  
          <td>
            <?php echo ( $item->enabled ? $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesseo', 'controller' => 'manage', 'action' => 'enabled', 'content_id' => $item->content_id ), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title' => $this->translate('Disable'))), array())  : $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesseo', 'controller' => 'manage', 'action' => 'enabled', 'content_id' => $item->content_id ), $this->htmlImage('application/modules/Sesbasic/externals/images/icons/error.png', '', array('title' => $this->translate('Enable')))) ) ?>
          </td >
          <td>
            <?php if(file_exists($filepath .DIRECTORY_SEPARATOR.'sitemap_'.$item->resource_type.'.xml')) { ?>
              <a href="<?php echo 'public'. DIRECTORY_SEPARATOR .'sesseo' .DIRECTORY_SEPARATOR.'sitemap_'.$item->resource_type.'.xml'; ?>" target="_blank">Open File</a>
            <?php } else { ?>
            <?php echo "No File"; ?>
            <?php } ?>
          </td>
          <td>
            <?php if($item->resource_type == 'menu_urls') { ?>
              <a href="<?php echo $this->url(array('action' => 'selectedmenus', 'content_id' => $item->content_id)) ?>" class="smoothbox"><?php echo $this->translate("Select Menus") ?></a> | 
            <?php } ?>
            <a href="<?php echo $this->url(array('action' => 'edit', 'content_id' => $item->content_id)) ?>" class="smoothbox"><?php echo $this->translate("Edit") ?></a>
            |
            <a href="<?php echo $this->url(array('action' => 'generate', 'content_id' => $item->content_id)) ?>" class="smoothbox">
            <?php if(file_exists($filepath .DIRECTORY_SEPARATOR.'sitemap_'.$item->resource_type.'.xml')) { ?>
              <?php echo $this->translate("Regenerate Sitemap") ?>
            <?php } else { ?>
              <?php echo $this->translate("Generate Sitemap") ?>
            <?php } ?>
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
    <?php echo $this->translate("There are no entry yet.") ?>
  </span>
</div>
<?php endif; ?>
