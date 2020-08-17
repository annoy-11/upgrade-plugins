<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Einstaclone
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-12-30 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Einstaclone/externals/styles/styles.css'); ?>

<script type="text/javascript">
  function loadMoreInstaTaggedPhoto() {
    if ($('load_moretagged'))
      $('load_moretagged').style.display = "<?php echo ( $this->paginator->count() == $this->paginator->getCurrentPageNumber() || $this->count == 0 ? 'none' : '' ) ?>";

    if(document.getElementById('load_moretagged'))
      document.getElementById('load_moretagged').style.display = 'none';
    
    if(document.getElementById('underloading_imagetagged'))
     document.getElementById('underloading_imagetagged').style.display = '';

    en4.core.request.send(new Request.HTML({
      method: 'post',
      'url': en4.core.baseUrl + 'widget/index/mod/einstaclone/name/member-tagged-photos',
      'data': {
        format: 'html',
        page: "<?php echo sprintf('%d', $this->paginator->getCurrentPageNumber() + 1) ?>",
        viewmore: 1,
        params: '<?php echo json_encode($this->all_params); ?>',
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        document.getElementById('results_datatagged').innerHTML = document.getElementById('results_datatagged').innerHTML + responseHTML;
        
        if(document.getElementById('load_moretagged'))
          document.getElementById('load_moretagged').destroy();
        
        if(document.getElementById('underloading_imagetagged'))
         document.getElementById('underloading_imagetagged').destroy();
       
        if(document.getElementById('loadmore_listtagged'))
         document.getElementById('loadmore_listtagged').destroy();
      }
    }));
    return false;
  }
</script>

<?php if (empty($this->viewmore)) { ?>
<div class="einstaclone_member_photos">
  <div class="einstaclone_member_photos_inner">
    <ul id= "results_datatagged">
<?php } ?>
  <?php foreach($this->paginator as $item) { ?>
    <?php $photo = Engine_Api::_()->getItem('album_photo', $item->resource_id); ?>
    <li>
      <article>
        <a href="<?php echo $photo->getHref(); ?>">
          <img src="<?php echo $photo->getPhotoUrl(); ?>" />
          <div class="_stats">
            <span><i class="fa fa-thumbs-up"></i><?php echo $photo->like_count; ?></span>
            <span><i class="fa fa-comment"></i><?php echo $photo->comment_count; ?></span>
          </div>
        </a>
      </article>
    </li>
  <?php } ?>
  <?php if (!empty($this->paginator) && $this->paginator->count() > 1): ?>
    <?php if ($this->paginator->getCurrentPageNumber() < $this->paginator->count()): ?>
      <div class="clear" id="loadmore_listtagged"></div>
      <div class="einstaclone_view_more einstaclone_load_btn" id="load_moretagged" onclick="loadMoreInstaTaggedPhoto();" style="display: block;">
        <a href="javascript:void(0);" class="einstaclone_animation einstaclone_link_btn" ><i class="fa fa-repeat"></i><span><?php echo $this->translate('View More');?></span></a>
      </div>
      <div class="einstaclone_load_btn" id="underloading_imagetagged" style="display: none;">
      <span class="einstaclone_link_btn"><i class="fa fa-spinner fa-spin"></i></span>
      </div>
    <?php endif; ?>
  <?php endif; ?>
<?php if (empty($this->viewmore)) { ?>
    </ul>
  </div>
</div>
<?php } ?>

<?php if($this->paginationType == 1): ?>
  <script type="text/javascript">
     //Take refrences from: http://mootools-users.660466.n2.nabble.com/Fixing-an-element-on-page-scroll-td1100601.html
    //Take refrences from: http://davidwalsh.name/mootools-scrollspy-load
    en4.core.runonce.add(function() {
      var paginatorCount = '<?php echo $this->paginator->count(); ?>';
      var paginatorCurrentPageNumber = '<?php echo $this->paginator->getCurrentPageNumber(); ?>';
      function ScrollLoaderTaggedPhoto() { 
        var scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
        if($('loadmore_listtagged')) {
          if (scrollTop > 40)
            loadMoreInstaTaggedPhoto();
        }
      }
      window.addEvent('scroll', function() { 
        ScrollLoaderTaggedPhoto(); 
      });
    });
  </script>
<?php endif; ?>
