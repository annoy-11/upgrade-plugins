<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesshortcut
 * @package    Sesshortcut
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: get-friends.tpl 2018-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>

<script type="text/javascript">
  
  sesJqueryObject(document).on('submit', '#edit_popup', function(e) {
    e.preventDefault();
    sesJqueryObject('#sesshortcut_overlay').show();
    var formData = new FormData(this);
    sesJqueryObject.ajax({
      url: "sesshortcut/index/editpopup/",
      type: "POST",
      contentType:false,
      processData: false,
      cache: false,
      data: formData,
      success: function(response) {
        var result = sesJqueryObject.parseJSON(response);
        if(result.status == 1) {
          sesJqueryObject('#sesshortcut_overlay').hide();
          sesJqueryObject('#sessmoothbox_container').html("<div id='sesshortcutsuccess_message' class='sesshortcut_success_message sesbasic_bxs sesshortcutsuccess_message'><span>You have successfully edited shortcuts.</span></div>");

          sesJqueryObject('#sesshortcutsuccess_message').fadeOut("slow", function(){
            setTimeout(function() {
              window.location.reload();
            }, 1000);
          });
        }
      }
    });
  });

  function smoothboxclose() {
    parent.Smoothbox.close();
  }
</script>
<script type="text/javascript">

  function shortcutButton(id, type) {
    
    if ($(type + '_shortcutunshortcuthidden_' + id))
      var contentId = $(type + '_shortcutunshortcuthidden_' + id).value

    en4.core.request.send(new Request.JSON({
      url: en4.core.baseUrl + 'sesshortcut/index/shortcut',
      data: {
      format: 'json',
        'id': id,
        'type': type,
        'contentId': contentId
      },
      onSuccess: function(responseJSON) {
        if (responseJSON.shortcut_id) {
          if ($(type + '_shortcutunshortcuthidden_' + id))
            $(type + '_shortcutunshortcuthidden_' + id).value = responseJSON.shortcut_id;
          if ($(type + '_shortcut_' + id))
            $(type + '_shortcut_' + id).style.display = 'none';
          if ($(type + '_unshortcut_' + id))
            $(type + '_unshortcut_' + id).style.display = 'block';
          
        } else {
          if ($(type + '_shortcutunshortcuthidden_' + id))
            $(type + '_shortcutunshortcuthidden_' + id).value = 0;
          if ($(type + '_shortcut_' + id))
            $(type + '_shortcut_' + id).style.display = 'block';
          if ($(type + '_unshortcut_' + id))
            $(type + '_unshortcut_' + id).style.display = 'none';
        }
      }
    }));
  }

  function viewMore() {
    document.getElementById('view_more').style.display = 'none';
    document.getElementById('loading_image').style.display = '';
    var id = '<?php echo $this->user_id; ?>';
    (new Request.HTML({
      method: 'post',
      'url': en4.core.baseUrl + '<?php echo $this->urlpage; ?>/' + id ,
      'data': {
        format: 'html',
        page: "<?php echo sprintf('%d', $this->paginator->getCurrentPageNumber() + 1) ?>",
        viewmore: 1
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        document.getElementById('view_more').destroy();
        document.getElementById('loading_image').destroy();
        document.getElementById('sesshortcut_results').innerHTML = document.getElementById('sesshortcut_results').innerHTML + responseHTML;
        document.getElementById('loading_image').style.display = 'none';
      }
    })).send();
    return false;
  }
  
  //static search function
  function sesShortCutsSearch() {

    // Declare variables
    var sesshortcuttitle, sesshortcuttitlefilter, allsocialshare_lists, allsocialshare_lists_li, allsocialshare_lists_p, i;
    sesshortcuttitle = document.getElementById('sesshortcuttitle');
    sesshortcuttitlefilter = sesshortcuttitle.value.toUpperCase();
    allsocialshare_lists = document.getElementById("sesshortcut_results");
    allsocialshare_lists_li = allsocialshare_lists.getElementsByTagName('span');
    // Loop through all list items, and hide those who don't match the search query
    for (i = 0; i < allsocialshare_lists_li.length; i++) {
      allsocialshare_lists_p = sesJqueryObject(allsocialshare_lists_li[i])[0].innerHTML;
      if (allsocialshare_lists_p.toUpperCase().indexOf(sesshortcuttitlefilter) > -1) {
        sesJqueryObject(allsocialshare_lists_li[i]).parent().parent().parent().parent().show();
      } else {
        sesJqueryObject(allsocialshare_lists_li[i]).parent().parent().parent().parent().hide();
      }
    }
  }
</script>
<?php if (empty($this->viewmore)): ?>
  <div class="sesshortcut_popup sesbasic_bxs">
    <div class="_header">
      <h3><?php echo $this->translate("Edit Shortcuts"); ?></h3>
      <p><?php echo $this->translate("Shortcuts are quick links to content on this website. You can search shortcuts you have added and hide or remove them from the list or pin desired ones to the top of the list."); ?></p>
      <div class="_search">
      	<i class="fa fa-search sesbasic_text_light"></i>
      	<input type="text" placeholder="Search your Pages, groups and games" id="sesshortcuttitle" onkeyup="sesShortCutsSearch()" />
      </div>
    </div>
    <div class="sesbasic_loading_cont_overlay" id="sesshortcut_overlay"></div>
    <form action="sesshortcut/index/editpopup" method="post" name="edit_popup" class="edit_popup" id="edit_popup">
    <div class="_cont" id="sesshortcut_results">
<?php endif; ?>

  <?php if (count($this->paginator) > 0) : ?>
    <?php foreach ($this->paginator as $result): ?>
      <?php $resource = Engine_Api::_()->getItem($result['resource_type'], $result['resource_id']); ?>
      <?php if($resource) { ?>
        <div class="item_list sesbasic_clearfix sesshortcut_item_list">
          <div class="_thumb">
            <?php echo $this->htmlLink($resource->getHref(), $this->itemPhoto($resource, 'thumb.icon'), array('title' => $resource->getTitle(), 'target' => '_parent')); ?>
          </div>
          <div class="_options">
            <select name="shortcutvalues_<?php echo $result['shortcut_id']; ?>">
              <option value="1" <?php if(!$result['pintotop']) { ?> selected <?php } ?>><?php echo $this->translate("Sorted Automatically"); ?></option>
              <option value="2" <?php if($result['pintotop']) { ?> selected <?php } ?>><?php echo $this->translate("Pinned to Top"); ?></option>
              <option value="3"><?php echo $this->translate("Remove from Shortcuts"); ?></option>
            </select>
          </div>
          <div class="_info">
            <div class="_title">
              <a href="<?php echo $resource->getHref(); ?>" title="<?php echo $resource->getTitle(); ?>" target="_parent" ><span class="smoothbox_social_name"><?php echo $resource->getTitle(); ?></span></a>
            </div>
          </div>
        </div>
      <?php } ?>
    <?php endforeach; ?> 
  <?php endif; ?>
  
  <?php if (!empty($this->paginator) && $this->paginator->count() > 1): ?>
    <?php if ($this->paginator->getCurrentPageNumber() < $this->paginator->count()): ?>
      <div class="sesbasic_view_more" id="view_more" onclick="viewMore();" >
        <?php echo $this->htmlLink('javascript:void(0);', $this->translate('View More'), array('id' => 'feed_viewmore_link', 'class' => 'buttonlink icon_viewmore')); ?>
      </div>
      <div class="sesbasic_view_more_loading" id="loading_image" style="display:none;">
        <img src='<?php echo $this->layout()->staticBaseUrl ?>application/modules/Sesbasic/externals/images/loading.gif' alt="Loading" />
        <?php echo $this->translate("Loading ...") ?>
      </div>  
    <?php endif; ?>
  <?php endif; ?>  
     
<?php if (empty($this->viewmore)): ?>
  </div>
	<div class="_footer">
  	<button type="submit"><?php echo $this->translate("Save"); ?></button>
    <?php echo $this->translate("or "); ?><a href="javascript:void(0);" onclick="javascript:sessmoothboxclose();"><?php echo $this->translate("Cancel"); ?></a>
  </div>
  </form>
</div>
<?php endif; ?>
