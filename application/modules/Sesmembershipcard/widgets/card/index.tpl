<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesmembershipcard/externals/styles/style.css'); 
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');?>
<div class="sesmembership_cards sesbasic_bxs sesbasic_clearfix">
	<div class="sesmembership_cards_container">
    <?php $direction= $this->level->direction;
    if($direction == 1) { ?>
      <div class="sesmembership_cards_col">
        <div class="sesmembership_horizontal_card">
          <?php 
           if($this->level->templates_custom == 1){
           $template = "application/modules/Sesmembershipcard/externals/images/template_".$this->level->templates.".jpg";
           }else{
            if($this->level->custom_front == 1) {          
                $select = $this->level->background;
                if($select == 1){
                $background_color = $this->level->background_color;
                }else{
                $template = $this->level->getPhotoUrl('background_image');
                }
             }else{
                $background_color = "cyan";
             }  
            }
          ?>     
          <div class="sesmembership_horizontal_card_front" style="<?php if(!empty($template)){ ?>background-image: url('<?php  echo $template; ?> ');<?php } if(!empty($background_color)){ ?> background-color:#<?php echo $background_color; } ?>; " >       
            <div class="_header">
              <div class="_logo">
                <?php
                  if($this->level->site_title_logo == 1){
                    $text = $this->level->site_title;
                  }else{
                   $select = $this->level->logo_image;             
                   $logo_image = $this->level->getPhotoUrl('logo_image');
                  }
                ?>     
                <?php if($this->level->site_title_logo == 1){ ?>
                  <p style="color:#<?php echo $this->level->font_color;?>;"><?php echo $text;?></p>
                <?php }?>
                <?php if($this->level->site_title_logo != 1){?>
                  <img src="<?php echo $logo_image ; ?>" alt=""/>
                <?php }?>
              </div>
              <div class="_title">
               <?php $label = $this->level->show_title;
                if($label == 1){
                    $title = $this->level->title;
                    $color = $this->level->title_color;
                    $font = $this->level->title_font;
                }
                ?>
                <span style="font-family:<?php echo str_replace('"','',$font); ?>; color:#<?php echo $color; ?>;"><?php echo $title; ?></span>
              </div>
            </div>
            <div class="_body">
              <div class="_thumb">
                <?php $profilePic = $this->level->profile_photo;
                 if($profilePic == 1){
                    echo $this->itemPhoto($this->subject());
                 } 
                ?>
              </div>
              <div class="_cont">
              <?php  
                $color = $this->level->field_color;
                $font = $this->level->field_font;
                $profiles = json_decode($this->level->profile_fields,true );    
                if(in_array('username',$profiles)){
              ?>
                <p style="font-family:<?php echo str_replace('"','',$font); ?>; color:#<?php echo $color;?>;"><?php echo $this->translate("Username"); ?>: <span style="font-family:<?php echo str_replace('"','',$font); ?>;"><?php echo $this->username;?></span></p>
                <?php } 
                  if(in_array('profile_type_name',$profiles)){
                ?>
                  <p style="font-family:<?php echo str_replace('"','',$font); ?>; color:#<?php echo $color;?>;"><?php echo $this->translate("Profile Type"); ?>: <span style="font-family:<?php echo str_replace('"','',$font); ?>;"><?php echo $this->profileType;?></span></p>
                <?php } ?>
                <?php echo $this->userprofilefields($this->subject(), $this->fieldStructure,$profiles,$this->level);?>
              </div>
            </div>
          </div>
        </div>
      </div>  
      <?php if($this->level->backside == 1){ 
                $back_logo = $this->level->getPhotoUrl('back_logo');
                $description = $this->level->back_description;}
      ?>    
      <?php if($this->level->backside == 1) {?>
        <?php if($this->level->back_templates_custom == 1){
                $image = "application/modules/Sesmembershipcard/externals/images/template_".$this->level->back_templates."_back.jpg";
                }else{
            
                    if($this->level->back_custom_front == 1) {          
                        $select = $this->level->back_background;
                        if($select == 1){
                            $background_color2 = $this->level->back_background_color;
                        }else{
                            $image = $this->level->getPhotoUrl('back_background_image');
                        }
                    }
                }
            ?>
            <div class="sesmembership_cards_col">
              <div class="sesmembership_horizontal_card">      
              <div class="sesmembership_horizontal_card_back" style="<?php if(!empty($image)){ ?>background-image: url('<?php echo $image;?> ');<?php } if(!empty($background_color2)){ ?> background-color:#<?php echo $background_color2; }?>; ">
                  <div class="sesmembership_horizontal_card_back_cont">
                      <?php
                      if($this->level->back_title_logo == 1){
                      $text = $this->level->back_site_title;
                      }else{
                      $select = $this->level->back_logo;             
                      $logo_image = $this->level->getPhotoUrl('back_logo');
                      }
                      ?>        
                  <?php if($this->level->back_title_logo == 1){ ?>
                      <p class="_logo" style="color:#<?php echo $this->level->back_font_color;?>"><?php echo $text;?></p>
                  <?php }?>
                  <?php if($this->level->back_title_logo != 1){?>
                      <p class="_logo"><img src="<?php echo $logo_image ; ?>" alt=""/></p>
                  <?php }?>
                  <p class="_des" style="color:#<?php echo $this->level->back_font_color;?>;font-family:<?php echo str_replace('"','',$this->level->back_title_font); ?>;"><?php echo $description;?> </p>
                  </div>
              </div>
            </div>
          </div>
        <?php } ?>
    <?php } ?>
    <?php if($direction == 2){?>
      <div class="sesmembership_cards_col"> 
        <div class="sesmembership_vertical_card">
          <?php      
          if($this->level->templates_custom == 1){
          $image = "application/modules/Sesmembershipcard/externals/images/template_".$this->level->templates.".jpg";   
          }
          else{ if($this->level->custom_front == 1) {          
                  $select = $this->level->background;
                  if($select == 1){
                  $background_color3 = $this->level->background_color;
                  }else{
                  $image = $this->level->getPhotoUrl('background_image');
                  }
            }}
          ?>         
          <div class="sesmembership_vertical_card_front" style="<?php if(!empty($image)){ ?>background-image: url('<?php  echo $image; ?> ');<?php } if(!empty($background_color3)){ ?> background-color:#<?php echo $background_color3;} ?>; ">
            <div class="_header">
              <div class="_logo">
                <?php
                  if($this->level->site_title_logo == 1){
                  $text = $this->level->site_title;
                  }
                  else{
                  $select = $this->level->logo_image;             
                  $logo_image = $this->level->getPhotoUrl('logo_image');
                  }
                ?>               
                <?php if($this->level->site_title_logo == 1){ ?>
                  <h3 style="font-size:10px;color:#<?php echo $this->level->font_color;?>;"><?php echo $text;?></h3><?php }?>
                <?php if($this->level->site_title_logo != 1){?>
                  <img src="<?php echo $logo_image ; ?>" alt=""/>
                <?php }?>
              </div>
            </div>
            <div class="_body">
              <div class="_thumb">
                <?php $profilePic = $this->level->profile_photo;
                if($profilePic == 1){
                echo $this->itemPhoto($this->subject());
                } 
                ?>
              </div>
              <div class="_cont" style="color:red;">
                <?php 
                  $color = $this->level->field_color;
                  $font = $this->level->field_font;
                  $profiles = json_decode($this->level->profile_fields,true );     
                  if(in_array('username',$profiles)){
                ?>
                  <p style="font-family:<?php echo str_replace('"','',$font); ?>; color:#<?php echo $color;?>;">Username: <span style="font-family:<?php echo str_replace('"','',$font); ?>;"><?php echo $this->username;?></span></p>
                <?php }
                if(in_array('profile_type_name',$profiles)){
                ?>
                  <p style="font-family:<?php echo str_replace('"','',$font); ?>; color:#<?php echo $color;?>;">Profile Type: <span style="font-family:<?php echo str_replace('"','',$font); ?>;"><?php echo $this->profileType;?></span></p>
                <?php } ?>
                <?php echo $this->userprofilefields($this->subject(), $this->fieldStructure,$profiles,$this->level);?>
              </div>
            </div>
            <div class="_footer">
              <?php $label =$this->level->show_title;
                if($label == 1){
                $title = $this->level->title;
                $color = $this->level->title_color;
                $font = $this->level->title_font;
              }?>
              <span style="font-family:<?php echo str_replace('"','',$font); ?>;color:#<?php echo $color; ?>;"><?php echo $title; ?></span>
            </div>
          </div>
        </div>
      </div>
      <?php $back =$this->level->backside;
        if($back == 1 ){
        $back_logo = $this->level->getPhotoUrl('back_logo');
        $description = $this->level->back_description;
        }
      ?>
      <?php if($back == 1){ ?>  
        <?php if($this->level->back_templates_custom == 1){
            $image = "application/modules/Sesmembershipcard/externals/images/template_".$this->level->back_templates."_back.jpg";
            }
          else{
                if($this->level->back_custom_front == 1) {          
                  $select = $this->level->back_background;
                    if($select == 1){
                      $background_color4 = $this->level->back_background_color;
                    }else{
                      $image = $this->level->getPhotoUrl('back_background_image');
                      }
                }
          }
        ?>
        <div class="sesmembership_cards_col">       
          <div class="sesmembership_vertical_card">     
            <div class="sesmembership_vertical_card_back" style="<?php if(!empty($image)){ ?>background-image: url('<?php echo $image;?> ');<?php } if(!empty($background_color4)){ ?> background-color:#<?php echo $background_color4; }?>; " >             
              <div class="_cont" >
                <div class="_logo">
                  <?php
                    if($this->level->back_title_logo == 1){
                      $text = $this->level->back_site_title;
                    }else{ 
                    $select = $this->level->back_logo;             
                    $logo_image = $this->level->getPhotoUrl('back_logo');
                    }
                  ?>     
                  <?php if($this->level->back_title_logo == 1){ ?>
                    <p style="color:#<?php echo $this->level->back_font_color; ?>;"><?php echo $text;?></p>
                  <?php }?>
                  <?php if($this->level->back_title_logo == 0){?>
                    <img src="<?php echo $logo_image ; ?>" alt=""/>
                  <?php }?>
                </div>              
                <p class="_des" style="color:#<?php echo $this->level->back_font_color; ?>;font-family:<?php echo str_replace('"','',$this->level->back_title_font); ?>;"><?php echo $description;?></p>
            	</div>
            </div>
          </div>
        </div>
      <?php }?>
    <?php }?>
  </div>
  <?php 
    if($this->allowed == "true"){ ?>
      <div class="sesmembership_card_print_btn"><a target="_blank" href="sesmembershipcard/index/print/print_id/true/id/<?php echo $this->identity; ?>/subject_id/<?php echo $this->subject()->getIdentity(); ?>"><i class="fa fa-print"></i><span>Print</span></a>
      </div>
    <?php } ?>
</div>
