<?php
/** 
* SocialEngineSolutions * 
* @category   Application_Sesarticle 
* @package    Sesarticle 
* @copyright  Copyright 2015-2016 SocialEngineSolutions 
* @license    http://www.socialenginesolutions.com/license/ 
* @version    $Id: index.tpl 2016-07-23 00:00:00 SocialEngineSolutions $ 
* @author     SocialEngineSolutions 
*/
?>

<?php $baseUrl = $this->layout()->staticBaseUrl; ?><?php $randonNumber = $this->identity; ?>
<?php if($this->showType == 'tagcloud'): ?>
	
	<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js'); ?><?php $this->headScript()->appendFile($baseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.tagcanvas.min.js');?>
	
	<div class="sesbasic_cloud_widget sesbasic_clearfix">  
		<div id="myCanvasContainer_<?php echo $randonNumber ?>" style="width:100%;height:<?php echo $this->height; ?>px">  
		<canvas style="width:100%;height:100%;" id="myCanvas_<?php echo $randonNumber ?>">  <p><?php echo $this->translate('Anything in here will be replaced on browsers 	that support the canvas element');?></p>    
		<ul>
		
			<?php foreach($this->paginator as $value):?> 	
				<?php if($value['category_name'] == '' || empty($value['category_name'])):?>	  	 <?php continue;?>	
				<?php endif;?>	
				<li>
					<a title="<?php echo $value['category_name'] ?>" href="<?php echo $this->url(array('module' =>'sesarticle','controller' => 'index', 'action' => 'browse'),'sesarticle_general',true).'?category_id='.$value['category_id']; ?>">
					<?php if(0 && $value['cat_icon'] != '' && !is_null($value['cat_icon'])){ ?>
						<img src="<?php echo  $this->storage->get($value->cat_icon, '')->getPhotoUrl() ?>" alt="<?php echo $value['category_name'] ?>" width="50" height="40" style=" width:50px; height:40px;" />
					<?php } ?>
					<span><?php echo trim($value['category_name']); ?></span>
					</a>	
				</li>
			<?php endforeach;?>
		</ul>
		</canvas>  
		</div>
	</div>
	
	<script type="text/javascript">  
	window.addEvent('domready', function() {    
		if( ! sesJqueryObject ('#myCanvas_<?php echo $randonNumber ?>').tagcanvas({    textFont: 'Impact,"Arial Black",sans-serif',textColour: "<?php echo $this->color; ?>",textHeight: "<?php echo $this->textHeight; ?>",maxSpeed : 0.03,depth : 0.75,shape : 'sphere',shuffleTags : true,reverse : false,initial :  [0.1,-0.0],minSpeed:.1    
		})) {      
			//	TagCanvas failed to load     
			sesJqueryObject ('#myCanvasContainer_<?php echo $randonNumber ?>').hide();    
		}  
	});
	</script> 
<?php elseif($this->showType = 'simple'):?>  
	<ul class="sesarticle_sidebar_categroies_list">    
		<?php foreach( $this->paginator as $item ): ?>
			<li>
				<?php $subcategory = Engine_Api::_()->getDbtable('categories', 'sesarticle')->getModuleSubcategory(array('column_name' => "*", 'category_id' => $item->category_id, 'countArticles' => true)); ?>
				<?php if(counT($subcategory) > 0): ?>  
					<a id="sesarticle_toggle_<?php echo $item->category_id ?>" class="cattoggel cattoggelright" href="javascript:void(0);" onclick="showCategory('<?php echo $item->getIdentity()  ?>')">
					</a>
				<?php endif; ?>     
				<a class="catlabel' ?>" href="<?php echo $this->url(array('module' =>'sesarticle','controller' => 'index', 'action' => 'browse'),'sesarticle_general',true).'?category_id='.$item->category_id; ?>"> 
					<?php if($item->cat_icon != '' && !is_null($item->cat_icon)):?>
						<img src="<?php echo $this->storage->get($item->cat_icon, '')->getPhotoUrl(); ?>" />
					<?php else:?>
						<img src="application/modules/Sesarticle/externals/images/category/icons/image.png" />
					<?php endif;?>
					<span><?php echo $this->translate($item->category_name); ?>
						<?php echo ' ('.$item->total_articles_categories.')';?>
					</span>
				</a>
				<ul id="subcategory_<?php echo $item->getIdentity() ?>" style="display:none;">   	
					<?php foreach( $subcategory as $subCat ): ?>
						<li>
							<?php $subsubcategory = Engine_Api::_()->getDbtable('categories', 'sesarticle')->getModuleSubsubcategory(array('column_name' => "*", 'category_id' => $subCat->category_id, 'countArticles' => true)); ?>
							<?php if(count($subsubcategory) > 0): ?>   
								<a id="sesarticle_subcat_toggle_<?php echo $subCat->category_id ?>" class="cattoggel cattoggelright" href="javascript:void(0);" onclick="showCategory('<?php echo $subCat->getIdentity()  ?>')"></a>
							<?php endif; ?> 
							<a class="catlabel" href="<?php echo $this->url(array('action' => 'browse'), $route, true).'?category_id='.urlencode($item->category_id) . '&subcat_id='.urlencode($subCat->category_id) ; ?>">
								<?php if($subCat->cat_icon != '' && !is_null($subCat->cat_icon)):?>
									<img src="<?php echo $this->storage->get($subCat->cat_icon, '')->getPhotoUrl(); ?>" />
								<?php else:?>
									<img src="application/modules/Sesarticle/externals/images/category/icons/image.png" />
								<?php endif;?>
								<span>
									<?php echo $this->translate($subCat->category_name); ?>
									<?php echo ' ('.$subCat->total_articles_categories.')';?>
								</span>
							</a>                  
							<ul id="subsubcategory_<?php echo $subCat->getIdentity() ?>" style="display:none;">
								<?php foreach( $subsubcategory as $subSubCat ): ?>                   
									<li>
										<a class="catlabel" href="<?php echo $this->url(array('action' => 'browse'), $route, true).'?category_id='.urlencode($item->category_id) . '&subcat_id='.urlencode($subCat->category_id) .'&subsubcat_id='.urlencode($subSubCat->category_id) ; ?>">
											<?php if($subSubCat->cat_icon != '' && !is_null($subSubCat->cat_icon)):?>	
												<img src="<?php echo $this->storage->get($subSubCat->cat_icon, '')->getPhotoUrl(); ?>" />
											<?php else:?>
												<img src="application/modules/Sesarticle/externals/images/category/icons/image.png" />
											<?php endif;?>
											<span>
												<?php echo $this->translate($subSubCat->category_name); ?>
												<?php echo ' ('.$subSubCat->total_articles_categories.')';?>
											</span>
										</a>
									</li>
								<?php endforeach; ?>                
							</ul>
						</li>          
					<?php endforeach; ?>
				</ul>
			</li>    
		<?php endforeach; ?>  
	</ul>
<script>
function showCategory(id) {  
	if($('subcategory_' + id)) {  
		if ($('subcategory_' + id).style.display == 'block') {
      $('sesarticle_toggle_' + id).removeClass('cattoggel cattoggeldown');
      $('sesarticle_toggle_' + id).addClass('cattoggel cattoggelright'); 
			$('subcategory_' + id).style.display = 'none';   
		} else {  
			$('sesarticle_toggle_' + id).removeClass('cattoggel cattoggelright');
      $('sesarticle_toggle_' + id).addClass('cattoggel cattoggeldown');
      $('subcategory_' + id).style.display = 'block';
		} 
	}    
	if($('subsubcategory_' + id)) {   
		if ($('subsubcategory_' + id).style.display == 'block') { 
			$('sesarticle_subcat_toggle_' + id).removeClass('cattoggel cattoggeldown');
      $('sesarticle_subcat_toggle_' + id).addClass('cattoggel cattoggelright');           
			$('subsubcategory_' + id).style.display = 'none';   
		} else {  
			$('sesarticle_subcat_toggle_' + id).removeClass('cattoggel cattoggelright'); 
			$('sesarticle_subcat_toggle_' + id).addClass('cattoggel cattoggeldown');  
			$('subsubcategory_' + id).style.display = 'block';  
		} 
	}
}
</script>  
<?php endif;?>