<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesteam
 * @package    Sesteam
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2015-02-20 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>

<script type="text/javascript">
  function loadMore() {
  
    if ($('view_more'))
      $('view_more').style.display = "<?php echo ( $this->paginator->count() == $this->paginator->getCurrentPageNumber() || $this->count == 0 ? 'none' : '' ) ?>";

    if(document.getElementById('view_more'))
      document.getElementById('view_more').style.display = 'none';
    
    if(document.getElementById('loading_image'))
     document.getElementById('loading_image').style.display = '';

    en4.core.request.send(new Request.HTML({
      method: 'post',              
      'url': en4.core.baseUrl + 'widget/index/mod/sesteam/name/team-page',
      'data': {
        format: 'html',
        page: "<?php echo sprintf('%d', $this->paginator->getCurrentPageNumber() + 1) ?>",
        viewmore: 1,
        params: '<?php echo json_encode($this->params); ?>',
        
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        document.getElementById('browse-team-widget').innerHTML = document.getElementById('browse-team-widget').innerHTML + responseHTML;
        
        if(document.getElementById('view_more'))
          document.getElementById('view_more').destroy();
        
        if(document.getElementById('loading_image'))
         document.getElementById('loading_image').destroy();
               if(document.getElementById('loadmore_list'))
         document.getElementById('loadmore_list').destroy();
      }
    }));
    return false;
  }
</script>


<?php if(count($this->paginator) > 0): ?>
  <?php if($this->template_settings == 1): ?>
    <?php include APPLICATION_PATH .  '/application/modules/Sesteam/views/scripts/index/_teamtemplate1.tpl'; ?> 
  <?php elseif($this->template_settings == 2): ?>
    <?php include APPLICATION_PATH .  '/application/modules/Sesteam/views/scripts/index/_teamtemplate2.tpl'; ?>
  <?php elseif($this->template_settings == 3): ?>
    <?php include APPLICATION_PATH .  '/application/modules/Sesteam/views/scripts/index/_teamtemplate3.tpl'; ?>
  <?php elseif($this->template_settings == 4): ?>
    <?php include APPLICATION_PATH .  '/application/modules/Sesteam/views/scripts/index/_teamtemplate4.tpl'; ?>
  <?php elseif($this->template_settings == 5): ?>
    <?php include APPLICATION_PATH .  '/application/modules/Sesteam/views/scripts/index/_teamtemplate5.tpl'; ?>
  <?php elseif($this->template_settings == 6): ?>
    <?php include APPLICATION_PATH .  '/application/modules/Sesteam/views/scripts/index/_teamtemplate6.tpl'; ?>
<?php endif; ?>
<?php else: ?>
  <div class="tip">
    <span>
      <?php echo $this->translate("Sorry, no results matching your search criteria were found.") ?>
    </span>
  </div>
<?php endif; ?>

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
            loadMore();
        }
      }
      window.addEvent('scroll', function() {
        ScrollLoader(); 
      });
    });    
  </script>
<?php endif; ?>
