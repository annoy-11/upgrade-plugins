<?php
 /**
 * SocialEngineSolutions
 *
 * @category Application_Sesdbslide
 * @package Sesdbslide
 * @copyright Copyright 2018-2019 SocialEngineSolutions
 * @license http://www.socialenginesolutions.com/license/
 * @version $Id: index.tpl 2018-07-05 00:00:00 SocialEngineSolutions $
 * @author SocialEngineSolutions
 */
?>

<h2>
    <?php echo $this->translate('Double Banner Slideshow Plugin') ?>
</h2>

<?php if( count($this->navigation) ): ?>
<div class='tabs'>
    <?php
    // Render the menu
    //->setUlClass()
    echo $this->navigation()->menu()->setContainer($this->navigation)->render()
    ?>
</div>
<?php endif; ?>

<script type="text/javascript">
    function multiDelete()
    {
        return confirm("<?php echo $this->translate("Are you sure you want to delete the selected slides ?") ?>");
    }
    function selectAll()
    {
        var i;
        var multidelete_form = $('multidelete_form');
        var inputs = multidelete_form.elements;
        for (i = 1; i < inputs.length; i++) {
            if (!inputs[i].disabled) {
                inputs[i].checked = inputs[0].checked;
            }
        }
    }
</script>
<h3><?php echo $this->translate("Manage Slideshows") ?></h3>
<p class="description">
    <?php echo $this->translate("This page lists all the Banner Slideshows created by you. Here, you can also add and manage any number of slideshows on your website. You can place these banners anywhere on your website including the Landing Page and any other widgetized page of your choice.
    <br>
<br>
You can add and manage any number of Photo Slides in each Banner Slideshow. Each slide is highly configurable and you
    can add title and description to each banner. Use “Create New Slideshow” link below to create new banner.<br>You can configure banner in the “SES - Double Banner Slideshow” widget from the Layout Editor.") ?>
</p>
<br class="clear" />
<div class="sesbasic_search_reasult">
    
    <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesdbslide', 'controller' => 'manage', 'action' => 'create-gallery'), $this->translate("Create New Slideshow"), array('class'=>'smoothbox sesbasic_icon_add buttonlink')) ?>
</div>



<?php if( count($this->paginator) ): ?>
<div class="sesbasic_search_reasult">
    <?php echo $this->translate(array('%s slideshow  found.', '%s slideshows  found', $this->paginator->getTotalItemCount()), $this->locale()->toNumber($this->paginator->getTotalItemCount())) ?>
</div>
<form id="multidelete_form" action="<?php echo $this->url();?>" onSubmit="return multiDelete()" method="POST">
    <table class='admin_table'>
        <thead>
            <tr>
                <th class='admin_table_short'><input onclick="selectAll()" type='checkbox' class='checkbox' /></th>
                <th class='admin_table_short'>Id</th>
                <th><?php echo $this->translate('Title') ?></th>
                <th class="text-center"><?php echo $this->translate('Number of slides') ?></th>
                <th class="text-center"><?php echo $this->translate('Status') ?></th>
                <th><?php echo $this->translate('Options') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($this->paginator as $item): ?>
            <tr>
                <td><input type='checkbox' class='checkbox' name='delete_<?php echo $item->gallery_id;?>' value="<?php echo $item->gallery_id ?>"/></td>
                <td><?php echo $item->gallery_id; ?></td>
                <td><?php echo $item->title ?></td>
                <td class="text-center"><?php echo $item->countSlide(); ?></td>
			   <td style="width:10%;" class="admin_table_centered">
                  <?php echo ( $item->status ? $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesdbslide', 'controller' => 'manage', 'action' => 'enabledgallery', 'gallery_id' => $item->gallery_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title' => $this->translate('Enabled'))), array()) : $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesdbslide', 'controller' => 'manage', 'action' => 'enabledgallery', 'gallery_id' => $item->gallery_id), $this->htmlImage('application/modules/Sesbasic/externals/images/icons/error.png', '', array('title' => $this->translate('Disabled')))) ) ?>
                </td>  
                <td>
                    <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesdbslide', 'controller' => 'manage', 'action' => 'create-gallery','id' => $item->gallery_id), $this->translate("Edit"),array('class' => 'smoothbox')) ?>
                    |
                    <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesdbslide', 'controller' => 'manage', 'action' => 'manage','id' => $item->gallery_id), $this->translate("Manage Slides")) ?>
                    |
                    <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesdbslide', 'controller' => 'manage', 'action' => 'delete-gallery','id' => $item->gallery_id), $this->translate("Delete"),array('class' => 'smoothbox')) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <br />
    <div class='buttons'>
        <button type='submit'><?php echo $this->translate("Delete Selected") ?></button>
    </div>
    <br />
</form>
<?php else: ?>
<div class="tip">
    <span>
        <?php echo $this->translate("There are no slideshow created yet.") ?>
    </span>
</div>
<?php endif; ?>


<style>
.text-center {
   text-align: center;
}
</style>
