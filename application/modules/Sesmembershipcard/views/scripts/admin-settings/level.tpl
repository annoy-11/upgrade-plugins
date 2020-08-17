<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmembershipcard
 * @package    Sesmembershipcard
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: level.tpl  2019-02-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Sesmembershipcard/views/scripts/dismiss_message.tpl';
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jscolor/jscolor.js');
?>

<div class='clear'>
  <div class='settings sesbasic_admin_form'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>


<script type="application/javascript">
  var fetchLevelSettings = function(level_id) {
    window.location.href = en4.core.baseUrl + 'admin/sesmembershipcard/settings/level/id/' + level_id;
  }
     sesJqueryObject(document).on('change','input[type=radio][name=templates_custom]',function(){
    var value = sesJqueryObject(this).val();
    if(value == 1){
          sesJqueryObject('#custom_front-wrapper').hide();
          sesJqueryObject('#background-wrapper').hide();
          sesJqueryObject('#background_image_img-wrapper').hide();
          sesJqueryObject('#background_color-wrapper').hide();
          sesJqueryObject('#background_image_name-wrapper').hide();
          sesJqueryObject('#templates-wrapper').show();
   }else{
          sesJqueryObject('#custom_front-wrapper').show();
          sesJqueryObject('#background-wrapper').show();
          sesJqueryObject('#background_image_img-wrapper').show();
          sesJqueryObject('#background_color-wrapper').show();
          sesJqueryObject('#background_image_name-wrapper').show();
          sesJqueryObject('#templates-wrapper').hide();        
        
          sesJqueryObject(document).on('change','input[type=radio][name=custom_front]',function(){
          var value1 = sesJqueryObject(this).val();
          if(value1 == 1){
                sesJqueryObject('#background-wrapper').show();
                sesJqueryObject('#background_image_img-wrapper').show();
                sesJqueryObject('#background_color-wrapper').show();
                sesJqueryObject('#background_image_name-wrapper').show(); 
                           
                sesJqueryObject(document).on('change','input[type=radio][name=background]',function(){
                var value = sesJqueryObject(this).val();
                if(value == 2){
                      sesJqueryObject('#background_color-wrapper').hide();
                      sesJqueryObject('#background_image_name-wrapper').show();
                      sesJqueryObject('#background_image_img-wrapper').show();
                }else{
                      sesJqueryObject('#background_color-wrapper').show();
                      sesJqueryObject('#background_image_name-wrapper').hide();
                      sesJqueryObject('#background_image_img-wrapper').hide();
                 }
                })
                sesJqueryObject(document).ready(function(e){
                sesJqueryObject('input[type=radio][name=background]:checked').trigger('change');
                });               
          }else{      
                sesJqueryObject('#background-wrapper').hide();
                sesJqueryObject('#background_image_img-wrapper').hide();
                sesJqueryObject('#background_color-wrapper').hide();
                sesJqueryObject('#background_image_name-wrapper').hide();       
          }
        })
         sesJqueryObject(document).ready(function(e){
         sesJqueryObject('input[type=radio][name=custom_front]:checked').trigger('change');    
         });   
    }
  })
   sesJqueryObject(document).ready(function(e){
   sesJqueryObject('input[type=radio][name=templates_custom]:checked').trigger('change');    
   });
   
   sesJqueryObject(document).on('change','input[type=radio][name=site_title_logo]',function(){
   var value = sesJqueryObject(this).val();
   if(value == 1){
         sesJqueryObject('#site_title-wrapper').show();
         sesJqueryObject('#logo_image_img-wrapper').hide();
         sesJqueryObject('#logo_image_name-wrapper').hide();
         sesJqueryObject('#font_color-wrapper').show();
   }else{
         sesJqueryObject('#site_title-wrapper').hide();
         sesJqueryObject('#logo_image_img-wrapper').show();
         sesJqueryObject('#logo_image_name-wrapper').show();
         sesJqueryObject('#font_color-wrapper').hide();              
    }
  })
  sesJqueryObject(document).ready(function(e){
  sesJqueryObject('input[type=radio][name=site_title_logo]:checked').trigger('change');
  });
 
  sesJqueryObject(document).on('change','input[type=radio][name=show_title]',function(){
  var value = sesJqueryObject(this).val();
  if(value == 0){
        sesJqueryObject('#title-wrapper').hide();
        sesJqueryObject('#title_color-wrapper').hide();
        sesJqueryObject('#title_font-wrapper').hide();        
  }else{ 
        sesJqueryObject('#title-wrapper').show();
        sesJqueryObject('#title_color-wrapper').show();
        sesJqueryObject('#title_font-wrapper').show();       
   }
  })   
   sesJqueryObject(document).ready(function(e){
   sesJqueryObject('input[type=radio][name=show_title]:checked').trigger('change');    
  }); 
    
   sesJqueryObject(document).on('change','input[type=radio][name=logo]',function(){
   var value = sesJqueryObject(this).val();
    if(value == 0){
          sesJqueryObject('#logo_image_img-wrapper').hide();
          sesJqueryObject('#logo_image_name-wrapper').hide();
    }else{ 
          sesJqueryObject('#logo_image_img-wrapper').show();
          sesJqueryObject('#logo_image_name-wrapper').show();
     }
  })
   sesJqueryObject(document).ready(function(e){
   sesJqueryObject('input[type=radio][name=logo]:checked').trigger('change');    
  }); 
    
   sesJqueryObject(document).on('change','input[type=radio][name=backside]',function(){
   var value = sesJqueryObject(this).val();
   if(value == 1){
          sesJqueryObject('#back_templates_custom-wrapper').show();
          sesJqueryObject('#back_templates-wrapper').show();
          sesJqueryObject('#back_custom_front-wrapper').show();
          sesJqueryObject('#back_background-wrapper').show();
          sesJqueryObject('#back_background_image_img-wrapper').show();
          sesJqueryObject('#back_background_color-wrapper').show(); 
          sesJqueryObject('#back_title_logo-wrapper').show();
          sesJqueryObject('#back_logo_img-wrapper').show();
          sesJqueryObject('#back_site_title-wrapper').show(); 
          sesJqueryObject('#back_description-wrapper').show();
          sesJqueryObject('#back_background_image_name-wrapper').show();
          sesJqueryObject('#backg_logo_image-wrapper').show();
          sesJqueryObject('#back_font_color-wrapper').show();
         
          sesJqueryObject(document).on('change','input[type=radio][name=back_templates_custom]',function(){
          var value = sesJqueryObject(this).val();
          if(value == 1){
              sesJqueryObject('#back_custom_front-wrapper').hide();
              sesJqueryObject('#back_background-wrapper').hide();
              sesJqueryObject('#back_background_image_img-wrapper').hide();
              sesJqueryObject('#back_background_color-wrapper').hide();
              sesJqueryObject('#back_templates-wrapper').show();
              sesJqueryObject('#backg_logo_image-wrapper').hide();
              sesJqueryObject('#back_background_image_name-wrapper').hide();
          }else{
              sesJqueryObject('#back_custom_front-wrapper').show();
              sesJqueryObject('#back_background-wrapper').show();
              sesJqueryObject('#back_background_image_img-wrapper').show();
              sesJqueryObject('#back_background_color-wrapper').show();
              sesJqueryObject('#back_templates-wrapper').hide();
              sesJqueryObject('#backg_logo_image-wrapper').show();
              sesJqueryObject('#back_background_image_name-wrapper').show();                       
                        
              sesJqueryObject(document).on('change','input[type=radio][name=back_custom_front]',function(){
              var value = sesJqueryObject(this).val();
              if(value == 1){
                    sesJqueryObject('#back_background-wrapper').show();
                    sesJqueryObject('#back_background_image_img-wrapper').show();
                    sesJqueryObject('#back_background_color-wrapper').show();
                    sesJqueryObject('#back_background_image_name-wrapper').show();                      
                        
                    sesJqueryObject(document).on('change','input[type=radio][name=back_background]',function(){
                    var value = sesJqueryObject(this).val();
                    if(value == 1){
                        sesJqueryObject('#back_background_color-wrapper').show();
                        sesJqueryObject('#back_background_image_name-wrapper').hide();
                        sesJqueryObject('#back_background_image_img-wrapper').hide();                                        
                    }else{
                        sesJqueryObject('#back_background_color-wrapper').hide();
                        sesJqueryObject('#back_background_image_name-wrapper').show();
                        sesJqueryObject('#back_background_image_img-wrapper').show();
                     }
                    })
                    sesJqueryObject(document).ready(function(e){
                    sesJqueryObject('input[type=radio][name=back_background]:checked').trigger('change');
                    });                  
              }else{
                    sesJqueryObject('#back_background_color-wrapper').hide();
                    sesJqueryObject('#back_background_image_name-wrapper').hide();
                    sesJqueryObject('#back_background-wrapper').hide();
                    sesJqueryObject('#back_background_image_img-wrapper').hide();
              }
             })
             sesJqueryObject(document).ready(function(e){
             sesJqueryObject('input[type=radio][name=back_custom_front]:checked').trigger('change');
             });        
         }
         })
         sesJqueryObject(document).ready(function(e){
         sesJqueryObject('input[type=radio][name=back_templates_custom]:checked').trigger('change');
         });
         
         sesJqueryObject(document).on('change','input[type=radio][name=back_title_logo]',function(){
         var value = sesJqueryObject(this).val();
         if(value == 1){
            sesJqueryObject('#back_font_color-wrapper').show();
            sesJqueryObject('#back_site_title-wrapper').show();
            sesJqueryObject('#back_logo_img-wrapper').hide();
            sesJqueryObject('#backg_logo_image-wrapper').hide();
         }else{
            sesJqueryObject('#back_site_title-wrapper').hide();
            sesJqueryObject('#back_logo_img-wrapper').show();
            sesJqueryObject('#backg_logo_image-wrapper').show();
            sesJqueryObject('#back_font_color-wrapper').hide();       
         }
        })
        sesJqueryObject(document).ready(function(e){
        sesJqueryObject('input[type=radio][name=back_title_logo]:checked').trigger('change');    
        });   
        }else{ 
           sesJqueryObject('#back_templates_custom-wrapper').hide();
           sesJqueryObject('#back_templates-wrapper').hide();
           sesJqueryObject('#back_custom_front-wrapper').hide();
           sesJqueryObject('#back_background-wrapper').hide();
           sesJqueryObject('#back_background_image_img-wrapper').hide();
           sesJqueryObject('#back_background_color-wrapper').hide(); 
           sesJqueryObject('#back_title_logo-wrapper').hide();
           sesJqueryObject('#back_logo_img-wrapper').hide();
           sesJqueryObject('#back_site_title-wrapper').hide(); 
           sesJqueryObject('#back_description-wrapper').hide();
           sesJqueryObject('#back_background_image_name-wrapper').hide();
           sesJqueryObject('#backg_logo_image-wrapper').hide();
           sesJqueryObject('#back_font_color-wrapper').hide(); 
        }
   })
    sesJqueryObject(document).ready(function(e){
    sesJqueryObject('input[type=radio][name=backside]:checked').trigger('change');    
    });   
  
    sesJqueryObject(document).on('change','#member_level',function(){
    var value = sesJqueryObject(this).val();
    var profile = sesJqueryObject("#profile_type").val();
    window.location.href = "admin/sesmembershipcard/settings/level?level="+value+"&profile="+profile;    
    });  
    
    sesJqueryObject(document).on('change','#profile_type',function(){
    var profile = sesJqueryObject(this).val();
    var value = sesJqueryObject("#member_level").val();
    window.location.href = "admin/sesmembershipcard/settings/level?level="+value+"&profile="+profile;    
    });
    
</script>
