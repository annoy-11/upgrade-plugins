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
  function loadMoreInsta() {  
    if ($('load_more'))
      $('load_more').style.display = "<?php echo ( $this->paginator->count() == $this->paginator->getCurrentPageNumber() || $this->count == 0 ? 'none' : '' ) ?>";

    if(document.getElementById('load_more'))
      document.getElementById('load_more').style.display = 'none';
    
    if(document.getElementById('underloading_image'))
     document.getElementById('underloading_image').style.display = '';

    en4.core.request.send(new Request.HTML({
      method: 'post',              
      'url': en4.core.baseUrl + 'widget/index/mod/einstaclone/name/explore-posts',
      'data': {
        format: 'html',
        page: "<?php echo sprintf('%d', $this->paginator->getCurrentPageNumber() + 1) ?>",
        viewmore: 1,
        params: '<?php echo json_encode($this->all_params); ?>',
        
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        document.getElementById('results_data').innerHTML = document.getElementById('results_data').innerHTML + responseHTML;
        
        if(document.getElementById('load_more'))
          document.getElementById('load_more').destroy();
        
        if(document.getElementById('underloading_image'))
         document.getElementById('underloading_image').destroy();
       
        if(document.getElementById('loadmore_list'))
         document.getElementById('loadmore_list').destroy();
      }
    }));
    return false;
  }
</script>

<?php if (empty($this->viewmore)) { ?>
<div class="einstaclone_explore_posts">
  <h2 class="einstaclone_text_light"><?php echo $this->translate("Explore"); ?></h2>
  <div class="einstaclone_member_photos_inner">
  <ul id="results_data">
<?php } ?>
    <?php foreach($this->paginator as $item) { ?>
      <li>
        <article>
          <a href="<?php echo $item->getHref(); ?>">
            <img src="<?php echo $item->getPhotoUrl(); ?>" />
            <div class="_stats">
              <span><i class="fa fa-thumbs-up"></i><?php echo $item->like_count; ?></span>
              <span><i class="fa fa-comment"></i><?php echo $item->comment_count; ?></span>
            </div>
          </a>
          </article>
      </li>
    <?php } ?>
    </ul>
    <?php if (!empty($this->paginator) && $this->paginator->count() > 1): ?>
      <?php if ($this->paginator->getCurrentPageNumber() < $this->paginator->count()): ?>
        <div class="clear" id="loadmore_list"></div>
        <div class="einstaclone_view_more einstaclone_load_btn" id="load_more" onclick="loadMoreInsta();" style="display: block;">
          <a href="javascript:void(0);" class="einstaclone_animation einstaclone_link_btn" ><i class="fa fa-sync"></i><span><?php echo $this->translate('View More');?></span></a>
        </div>
        <div class="einstaclone_load_btn" id="underloading_image" style="display: none;">
        <span class="einstaclone_link_btn"><i class="fa fa-spinner fa-spin"></i></span>
        </div>
      <?php endif; ?>
    <?php endif; ?>
<?php if (empty($this->viewmore)) { ?>
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
      function ScrollLoader() { 
        var scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
        if($('loadmore_list')) {
          if (scrollTop > 40)
            loadMoreInsta();
        }
      }
      window.addEvent('scroll', function() { 
        ScrollLoader(); 
      });
    });    
  </script>
<?php endif; ?>
