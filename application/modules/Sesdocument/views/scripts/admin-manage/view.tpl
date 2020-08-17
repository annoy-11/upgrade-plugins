
<?php $baseURL = $this->layout()->staticBaseUrl; ?>
<div class="sesbasic_view_stats_popup">
  <h3><?php echo $this->translate("View Details"); ?> </h3>
  <table>
    <tr>
      <?php if($this->item->file_id): ?>
      <?php $img_path = Engine_Api::_()->storage()->get($this->item->file_id, '')->getPhotoUrl();
      $path = $img_path; 
      ?>
      <?php else: ?>
      <?php $path = $this->baseUrl() . '/application/modules/Sesdocument/externals/images/nophoto_event_thumb_icon.png'; ?>
      <?php endif; ?>
      <td colspan="2"><a href="<?php echo $this->item->getHref(); ?>" target="_blank"><img src="<?php echo $path; ?>" style="height:75px; width:75px;"/></a></td>
    </tr>
    <tr>
      <td><?php echo $this->translate('Title') ?>:</td>
      <td><?php if(!is_null($this->item->title) && $this->item->title != '') {?>
        <a href="<?php echo $this->item->getHref(); ?>" target="_blank"><?php echo  $this->item->title ; ?></a>
        <?php
        } else { 
        echo "-";
        } ?>
      </td>
    </tr>
    <tr>
      <td><?php echo $this->translate('Owner') ?>:</td>
      <td><?php echo  $this->item->getOwner(); ?></td>
    </tr>
 
    <tr>
      <td><?php echo $this->translate('Ratings') ?>:</td>
      <td>
        <?php if($this->item->rating): ?>
        <div class="sesbasic_text_light">
          <?php if( $this->item->rating > 0 ): ?>
          <?php for( $x=1; $x<= $this->item->rating; $x++ ): ?>
          <span class="sesbasic_rating_star_small fa fa-star"></span>
          <?php endfor; ?>
          <?php if((round($this->item->rating) - $this->item->rating) > 0): ?>
          <span class="sesbasic_rating_star_small fa fa-star-half-o"></span>
          <?php endif; ?>
          <?php endif; ?>
        </div>
        <?php else: ?>
          <?php for( $x=1; $x<= 5; $x++ ): ?>
            <span class="sesbasic_rating_star_small fa fa-star-o star-disabled"></span>
          <?php endfor; ?>
        <?php endif; ?>
      </td>
    </tr>
    
    

   ?>
    
  
    
    <tr>
      <td><?php echo $this->translate('IP Address') ?>:</td>
      <td><?php echo  $this->item->ip_address ?></td>
    </tr>

    <tr>
      <td><?php echo $this->translate('Approved') ?>:</td>
      <td><?php  if($this->item->is_approved == 1){ ?>
        <img src="<?php echo $baseURL . 'application/modules/Sesbasic/externals/images/icons/check.png'; ?>"/> <?php }else{ ?> 
        <img src="<?php echo $baseURL . 'application/modules/Sesbasic/externals/images/icons/error.png'; ?>" /> <?php } ?>
      </td>
    </tr>
    <tr>
      <td><?php echo $this->translate('Featured') ?>:</td>
      <td><?php  if($this->item->featured == 1 && $this->item->is_approved == 1){ ?>
        <img src="<?php echo $baseURL . 'application/modules/Sesbasic/externals/images/icons/check.png'; ?>"/> <?php }else{ ?> 
        <img src="<?php echo $baseURL . 'application/modules/Sesbasic/externals/images/icons/error.png'; ?>" /> <?php } ?>
      </td>
    </tr>
    <tr>
      <td><?php echo $this->translate('Sponsored') ?>:</td>
      <td><?php  if($this->item->sponsored == 1 && $this->item->is_approved == 1){ ?>
        <img src="<?php echo $baseURL . 'application/modules/Sesbasic/externals/images/icons/check.png'; ?>"/> <?php }else{ ?> 
        <img src="<?php echo $baseURL . 'application/modules/Sesbasic/externals/images/icons/error.png'; ?>" /> <?php } ?>
      </td>
    </tr>
    <tr>
      <td><?php echo $this->translate('Verified') ?>:</td>
      <td><?php  if($this->item->verified == 1 && $this->item->is_approved == 1){ ?>
        <img src="<?php echo $baseURL . 'application/modules/Sesbasic/externals/images/icons/check.png'; ?>"/> <?php }else{ ?> 
        <img src="<?php echo $baseURL . 'application/modules/Sesbasic/externals/images/icons/error.png'; ?>" /> <?php } ?>
      </td>
    </tr>
    
    <?php if(strtotime($this->item->enddate) < strtotime(date('Y-m-d')) && $this->item->offtheday == 1){ 
                    Engine_Api::_()->getDbtable('sesdocuments', 'sesdocument')->update(array(
                        'offtheday' => 0,
                        'starttime' =>'',
                        'endtime' =>'',
                      ), array(
                        "event_id = ?" => $this->item->sesdocument_id,
                      ));
                      $itemofftheday = 0;
               }else
                $itemofftheday = $this->item->offtheday; ?>
    <tr>
      <td><?php echo $this->translate('Of the Day') ?>:</td>
      <td><?php  if($itemofftheday == 1 && $this->item->is_approved == 1){ ?>
        <img src="<?php echo $baseURL . 'application/modules/Sesbasic/externals/images/icons/check.png'; ?>"/> <?php }else{ ?> 
        <img src="<?php echo $baseURL . 'application/modules/Sesbasic/externals/images/icons/error.png'; ?>" /> <?php } ?>
      </td>
    </tr>
    
    
    <tr>
      <td><?php echo $this->translate('Comments') ?>:</td>
      <td><?php echo $this->item->comment_count ?></td>
    </tr>
    <tr>
      <td><?php echo $this->translate('Likes') ?>:</td>
      <td><?php echo $this->item->like_count ?></td>
    </tr>
    <tr>
      <td><?php echo $this->translate('Views') ?>:</td>
      <td><?php echo $this->locale()->toNumber($this->item->view_count) ?></td>
    </tr>
    <tr>
      <td><?php echo $this->translate('Date') ?>:</td>
      <td><?php echo $this->item->creation_date; ;?></td>
    </tr>
  </table>
  <br />
  <button onclick='javascript:parent.Smoothbox.close()'>
    <?php echo $this->translate("Close") ?>
  </button>
</div>