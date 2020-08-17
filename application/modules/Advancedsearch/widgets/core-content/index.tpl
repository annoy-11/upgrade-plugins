<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Advancedsearch
 * @package    Advancedsearch
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-12-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php $randonNumber = 'sesadvancedsearch_cnt';//!empty($this->randonNumber) ? $this->randonNumber : time().md5(time()); ?>
<?php if(empty($this->loading_data)){ ?>
<?php if( $this->paginator->getTotalItemCount() > 0 ): ?>
<div id="search_result_counts">
<?php echo $this->translate(array('<b>%s result found</b>', '<b>%s results found</b>', $this->paginator->getTotalItemCount()),
$this->locale()->toNumber($this->paginator->getTotalItemCount())); ?>
</div>
<?php endif; ?>
<?php }else{ ?>
<?php if( $this->paginator->getTotalItemCount() > 0 ): ?>
<div id="result-search-data" style="display: none;">
<?php echo $this->translate(array('<b>%s result found</b>', '<b>%s results found</b>', $this->paginator->getTotalItemCount()),
$this->locale()->toNumber($this->paginator->getTotalItemCount())); ?>
</div>
<?php endif; ?>
<?php } ?>
    <?php if(empty($this->loading_data)){ ?>
        <div class="advancedsearch_result_main sesbasic_bxs sebasic_clearfix" style="position: relative;">
    <?php } ?>
<?php foreach( $this->paginator as $item ):?>
<div class="advancedsearch_result">
   <div class="advancedsearch_item_top">
    <?php if(in_array('photo',$this->searchParams)){ ?>
    <div class="advancedsearch_photo">
        <?php echo $this->htmlLink($item->getHref(), $this->itemPhoto($item, 'thumb.main')) ?>
    </div>
    <?php } ?>
    <div class="advancedsearch_overlay">
      <div class="advancedsearch_stats">
        <?php if(in_array('view',$this->searchParams) && isset($item->view_count)){ ?>
        <?php echo $this->translate(array('<i class="fa fa-eye"></i> %s', '<i class="fa fa-eye"></i> %s', $item->view_count), $this->locale()->toNumber($item->view_count)) ?>
        <?php } ?>
        <?php if(in_array('likes',$this->searchParams) && isset($item->like_count)){ ?>
        <?php echo $this->translate(array('<i class="fa fa-thumbs-o-up"></i> %s', '<i class="fa fa-thumbs-o-up"></i> %s', $item->like_count), $this->locale()->toNumber($item->like_count)) ?>
        <?php } ?>
        <?php if(in_array('comment',$this->searchParams) && isset($item->comment_count)){ ?>
        <?php echo $this->translate(array('<i class="fa fa-comment-o"></i> %s', '<i class="fa fa-comment-o"></i> %s', $item->comment_count), $this->locale()->toNumber($item->comment_count)) ?>
        <?php } ?>
    </div>
    <?php if(in_array('postedBy',$this->searchParams)){ ?>
    <div class="advancedsearch_owner">
        by <?php echo $this->htmlLink($item->getOwner()->getHref(), $item->getOwner()->getTitle(), array('class' => 'search_title')); ?>
    </div>
    <?php } ?>
   </div>
   </div>
    <div class="advancedsearch_info">
        <?php if( '' != $this->query ): ?>
        <?php echo $this->htmlLink($item->getHref(), $this->highlightText($item->getTitle(), $this->query), array('class' => 'search_title')) ?>
        <?php else: ?>
        <?php echo $this->htmlLink($item->getHref(), $item->getTitle(), array('class' => 'search_title')) ?>
        <?php endif; ?>
    </div>
</div>
<?php endforeach; ?>
          <?php  if($this->loadmore == "pagging"){ ?>
                <?php echo $this->paginationControl($this->paginator, null, array("_pagging.tpl", "advancedsearch"),array('identityWidget'=>$randonNumber)); ?>
            <?php } ?>
<?php if( $this->paginator->getTotalItemCount() <= 0 ): ?>
<div class="tip">
    <span>
      <?php echo $this->translate('There are no results that match your search. Please try again.') ?>
    </span>
</div>
<?php endif; ?>
<?php if(empty($this->loading_data)){ ?>
    </div>
<?php } ?>
<?php if($this->loadmore != 'pagging' && empty($this->loading_data)){  ?>
         <div class="sesbasic_load_btn" id="view_more_<?php echo $randonNumber;?>" onclick="viewMore_<?php echo $randonNumber; ?>();" >
			<a href="javascript:void(0);" class="sesbasic_animation sesbasic_link_btn" id="feed_viewmore_link_<?php echo $randonNumber; ?>"><i class="fa fa-repeat"></i><span><?php echo $this->translate('View More');?></span></a></div>
         <div class="sesbasic_load_btn" id="loading_image_<?php echo $randonNumber; ?>" style="display: none;">
             <span class="sesbasic_link_btn"><i class="fa fa-spinner fa-spin"></i></span>
         </div>
<?php } ?>
<script type="application/javascript">
    <?php if(empty($this->loading_data)){ ?>
        if(typeof isIncludedSearchSubmit == "undefined") {
                var isIncludedSearchSubmit = false;
                sesJqueryObject(document).on('submit','#filter_form_advsearch',function(e){
                    e.preventDefault();
                    if(typeof paggingNumber<?php echo $randonNumber; ?> == "function"){
                        paggingNumber<?php echo $randonNumber; ?>(1);
                    }else{
                        viewMore_<?php echo $randonNumber; ?> ();
                        page<?php echo $randonNumber; ?> = 1;
                        sesJqueryObject(".advancedsearch_result_main").html('');

                    }
                });
        }
    <?php } ?>
    <?php if($this->loadmore == "pagging"){ ?>
        function paggingNumber<?php echo $randonNumber; ?>(pageNum){
            sesJqueryObject ('.overlay_<?php echo $randonNumber ?>').css('display','block');
            var searchText;
            var cat;
            if(sesJqueryObject('#filter_form_advsearch').length){
                searchText = sesJqueryObject('#filter_form_advsearch').find('#search').val();
                if(!searchText){
                    sesJqueryObject('#advancedsearch_title').val('');
                }else{
                    sesJqueryObject('#advancedsearch_title').val(searchText);
                }
                cat = sesJqueryObject('#filter_form_advsearch').find('#category_id').val();
            }
            updateHashValue('query',sesJqueryObject('#advancedsearch_title').val());
            new Request.HTML({
                method: 'post',
                'url': en4.core.baseUrl + "widget/index/mod/advancedsearch/name/core-content/index/",
                'data': {
                    format: 'html',
                    search:searchText,
                    query : sesJqueryObject('#advancedsearch_title').val(),
                    category_id:cat,
                    resource_type:"<?php echo $this->type; ?>",
                    limit:<?php echo $this->limit; ?>,
                    pagging : "<?php echo $this->loadmore; ?>",
                    page: pageNum,
                    randonNumber:"<?php echo $randonNumber; ?>",
                    loading_data:true,
                    show_criteria : <?php echo json_encode($this->searchParams); ?>,
        },
            onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
                sesJqueryObject(".advancedsearch_result_main").html(responseHTML);
            }
        }).send();
        };
    <?php }else{ ?>
        var page<?php echo $randonNumber; ?> = '<?php echo $this->page + 1; ?>';

        function viewMoreHide_<?php echo $randonNumber; ?>() {
            if ($('view_more_<?php echo $randonNumber; ?>'))
                $('view_more_<?php echo $randonNumber; ?>').style.display = "<?php echo ($this->paginator->count() == 0 ? 'none' : ($this->paginator->count() == $this->paginator->getCurrentPageNumber() ? 'none' : '' )) ?>";
            if ($('loading_image_<?php echo $randonNumber; ?>'))
                $('loading_image_<?php echo $randonNumber; ?>').style.display = "none";
        }
        en4.core.runonce.add(function() {
            viewMoreHide_<?php echo $randonNumber; ?>();
        });
        function viewMore_<?php echo $randonNumber; ?> (){
            document.getElementById('view_more_<?php echo $randonNumber; ?>').style.display = 'none';
            document.getElementById('loading_image_<?php echo $randonNumber; ?>').style.display = '';
            var searchText;
            var cat;
            if(sesJqueryObject('#filter_form_advsearch').length){
                searchText = sesJqueryObject('#filter_form_advsearch').find('#search').val();
                if(!searchText){
                    sesJqueryObject('#advancedsearch_title').val('');
                }else{
                    sesJqueryObject('#advancedsearch_title').val(searchText);
                }
                cat = sesJqueryObject('#filter_form_advsearch').find('#category_id').val();
            }
            updateHashValue('query',sesJqueryObject('#advancedsearch_title').val());
            new Request.HTML({
                method: 'post',
                'url': en4.core.baseUrl + "widget/index/mod/advancedsearch/name/core-content/index/",
                'data': {
                    format: 'html',
                    search:searchText,
                    query : sesJqueryObject('#advancedsearch_title').val(),
                    category_id:cat,
                    resource_type:"<?php echo $this->type; ?>",
                    limit:<?php echo $this->limit; ?>,
                    pagging : "<?php echo $this->loadmore; ?>",
                    page: page<?php echo $randonNumber; ?>,
                    randonNumber:"<?php echo $randonNumber; ?>",
                    loading_data:true,
                    show_criteria : <?php echo json_encode($this->searchParams); ?>,
        },
            onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
                //sesJqueryObject('#view_more_<?php echo $randonNumber; ?>').remove();
                //sesJqueryObject('#loading_image_<?php echo $randonNumber; ?>').remove();
                sesJqueryObject(".advancedsearch_result_main").append(responseHTML);
                var html = sesJqueryObject('#result-search-data').html();
                console.log(html);
                if(!sesJqueryObject('#search_result_counts').length)
                    sesJqueryObject('.layout_advancedsearch_core_content').prepend('<div id="search_result_counts"></div>');
                if(html && html != ""){
                    sesJqueryObject('#search_result_counts').html(html);
                }else{
                    sesJqueryObject('#search_result_counts').html('')
                }
                sesJqueryObject('#result-search-data').remove();
                viewMoreHide_<?php echo $randonNumber; ?>();
            }
        }).send();
        };
    <?php } ?>
</script>
<?php if($this->loadmore == 'loadmore'){ ?>
<script type="text/javascript">
    window.addEvent('load', function() {
        sesJqueryObject(window).scroll( function() {
            var heightOfContentDiv_<?php echo $randonNumber; ?> = sesJqueryObject('.advancedsearch_result_main').offset().top;
            var fromtop_<?php echo $randonNumber; ?> = sesJqueryObject(this).scrollTop();
            if(fromtop_<?php echo $randonNumber; ?> > heightOfContentDiv_<?php echo $randonNumber; ?> - 100 && sesJqueryObject('#view_more_<?php echo $randonNumber; ?>').css('display') == 'block' ){
                document.getElementById('feed_viewmore_link_<?php echo $randonNumber; ?>').click();
            }
        });
    });
</script>
<?php } ?>


