<?php



/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslandingpage
 * @package    Seslandingpage
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-02-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 ?>

<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Seslandingpage/externals/styles/styles.css'); ?>

<?php $contents = Zend_Json::decode($this->featureblock->contents); ?>
<?php if($this->design_id == 1):?>
  <div class="seslp_intro_wrapper seslp_intro_d1_wrapper seslp_blocks_wrapper sesbasic_bxs seslp_section_spacing">
    <section class="seslp_blocks_container">
      <div class="seslp_intro_container seslp_intro_d1">
        <div class="seslp_intro_left_col wow fadeIn">
          <article>
          	<div class="seslp_intro_left_col_bg" style="background-image:url(<?php echo Engine_Api::_()->seslandingpage()->getFileUrl($this->backgroundimage); ?>);"></div>
            <div class="seslp_intro_left_col_cont">
              <div class="seslp_head_d1 _left">
                <?php if($this->title) { ?>
                  <h2><?php echo $this->title; ?></h2>
                <?php } ?>
                <?php if($this->description) { ?>
                  <p><?php echo $this->description; ?></p>
                <?php } ?>
              </div>
              <?php if($this->buttontitle || $this->buttonurl) { ?>
              <div class="_btn">
                <a href="<?php echo $this->buttonurl; ?>" class="seslp_filled_btn sesbasic_animation"><?php echo $this->buttontitle; ?></a>
              </div>
              <?php } ?>
            </div>
          </article>
        </div>
        <div class="seslp_intro_right_col">
          <ul>
            <?php if(!empty($contents['title1'])) { ?>
              <li class="seslp_intro_right_item wow fadeInUp" data-wow-delay="0.2s">
                <article class="sesbasic_bg">
                  <?php if($contents['icon_type1'] == 1) { ?>
                    <i class="fa <?php echo $contents['fonticon1']; ?>"></i>
                  <?php } elseif($contents['icon_type1'] == 0) { ?>
                    <?php $photo1 = Engine_Api::_()->storage()->get($contents['photo1'], ''); ?>
                    <?php if($photo1) { ?>
                      <i class="_icon"><img src="<?php echo $photo1->getPhotoUrl(); ?>" alt="" /></i>
                    <?php } ?>
                  <?php } ?>
                  <h3><?php echo $contents['title1']; ?></h3>
                  <?php if($contents['description1']) { ?>
                    <p><?php echo $contents['description1']; ?></p>
                  <?php } ?>
                  <span class="count-number">1</span>
                </article>
              </li>
            <?php } ?>
            
            <?php if(!empty($contents['title2'])) { ?>
              <li class="seslp_intro_right_item wow fadeInUp"  data-wow-delay="0.4s">
                <article class="sesbasic_bg">
                  <?php if($contents['icon_type2'] == 1) { ?>
                    <i class="fa <?php echo $contents['fonticon2']; ?>"></i>
                  <?php } else if($contents['icon_type2'] == 0) { ?>
                    <?php $photo2 = Engine_Api::_()->storage()->get($contents['photo2'], ''); ?>
                    <?php if($photo2) { ?>
                      <i class="_icon"><img src="<?php echo $photo2->getPhotoUrl(); ?>" alt="" /></i>
                    <?php } ?>
                  <?php } ?>
                  <h3><?php echo $contents['title2']; ?></h3>
                  <?php if($contents['description2']) { ?>
                    <p><?php echo $contents['description2']; ?></p>
                  <?php } ?>
                  <span class="count-number">2</span>
                </article>
              </li>
            <?php } ?>
            
            <?php if(!empty($contents['title3'])) { ?>
              <li class="seslp_intro_right_item wow fadeInUp" data-wow-delay="0.6s">
                <article class="sesbasic_bg">
                  <?php if($contents['icon_type3'] == 1) { ?>
                    <i class="fa <?php echo $contents['fonticon3']; ?>"></i>
                  <?php } else if($contents['icon_type3'] == 0) { ?>
                    <?php $photo3 = Engine_Api::_()->storage()->get($contents['photo3'], ''); ?>
                    <?php if($photo3) { ?>
                      <i class="_icon"><img src="<?php echo $photo3->getPhotoUrl(); ?>" alt="" /></i>
                    <?php } ?>
                  <?php } ?>
                  <h3><?php echo $contents['title3']; ?></h3>
                  <?php if($contents['description3']) { ?>
                    <p><?php echo $contents['description3']; ?></p>
                  <?php } ?>
                  <span class="count-number">3</span>
                </article>
              </li>
            <?php } ?>
            
            <?php if(!empty($contents['title4'])) { ?>
              <li class="seslp_intro_right_item wow fadeInUp" data-wow-delay="0.8s">
                <article class="sesbasic_bg">
                  <?php if($contents['icon_type4'] == 1) { ?>
                    <i class="fa <?php echo $contents['fonticon4']; ?>"></i>
                  <?php } else if($contents['icon_type4'] == 0) { ?>
                    <?php $photo4 = Engine_Api::_()->storage()->get($contents['photo4'], ''); ?>
                    <?php if($photo4) { ?>
                      <i class="_icon"><img src="<?php echo $photo4->getPhotoUrl(); ?>" alt="" /></i>
                    <?php } ?>
                  <?php } ?>
                  <h3><?php echo $contents['title4']; ?></h3>
                  <?php if($contents['description4']) { ?>
                    <p><?php echo $contents['description4']; ?></p>
                  <?php } ?>
                  <span class="count-number">4</span>
                </article>
              </li>
            <?php } ?>
  
          </ul>
        </div>
      </div>
    </section>
  </div>
<?php else: ?>
  <div class="seslp_intro_wrapper seslp_intro_d2_wrapper seslp_blocks_wrapper sesbasic_bxs seslp_section_spacing">
    <section class="seslp_blocks_container">
      <div class="seslp_intro_d2">
        <div class="seslp_head_d1">
          <?php if($this->title) { ?>
            <h2><?php echo $this->title; ?></h2>
          <?php } ?>
          <?php if($this->description) { ?>
            <p><?php echo $this->description; ?></p>
          <?php } ?>
        </div>
        <div class="seslp_intro_container">
          <div class="seslp_intro_left_col wow fadeIn">
            <article>
  						<img src="<?php echo Engine_Api::_()->seslandingpage()->getFileUrl($this->backgroundimage); ?>">
            </article>
          </div>
          <div class="seslp_intro_right_col">
            <ul>
              <?php if(!empty($contents['title1'])) { ?>
                <li class="seslp_intro_right_item wow fadeIn" data-wow-delay="0.2s">
                  <article>
                    <div class="icon">
                    	<div class="icon_inner">
                        <?php if($contents['icon_type1'] == 1) { ?>
                          <i class="sesbasic_text_hl fa <?php echo $contents['fonticon1']; ?>"></i>
                        <?php } elseif($contents['icon_type1'] == 0) { ?>
                          <?php $photo1 = Engine_Api::_()->storage()->get($contents['photo1'], ''); ?>
                          <?php if($photo1) { ?>
                            <i class="_icon"><img src="<?php echo $photo1->getPhotoUrl(); ?>" alt="" /></i>
                          <?php } ?>
                        <?php } ?>
                      </div>
                    </div>
                    <div class="info">
                      <h3><?php echo $contents['title1']; ?></h3>
                      <?php if($contents['description1']) { ?>
                        <p><?php echo $contents['description1']; ?></p>
                      <?php } ?>
                    </div>
                  </article>
                </li>
              <?php } ?>
              <?php if(!empty($contents['title2'])) { ?>
                <li class="seslp_intro_right_item  wow fadeIn" data-wow-delay="0.4s">
                  <article>
                  	<div class="icon">
                    	<div class="icon_inner">
                        <?php if($contents['icon_type2'] == 1) { ?>
                          <i class="sesbasic_text_hl fa <?php echo $contents['fonticon2']; ?>"></i>
                        <?php } else if($contents['icon_type2'] == 0) { ?>
                          <?php $photo2 = Engine_Api::_()->storage()->get($contents['photo2'], ''); ?>
                          <?php if($photo2) { ?>
                            <i class="_icon"><img src="<?php echo $photo2->getPhotoUrl(); ?>" alt="" /></i>
                          <?php } ?>
                        <?php } ?>
                      </div>
                    </div>
                    <div class="info">  
                      <h3><?php echo $contents['title2']; ?></h3>
                      <?php if($contents['description2']) { ?>
                        <p><?php echo $contents['description2']; ?></p>
                      <?php } ?>
										</div>
                  </article>
                </li>
              <?php } ?>
              <?php if(!empty($contents['title3'])) { ?>
                <li class="seslp_intro_right_item  wow fadeIn" data-wow-delay="0.6s">
                  <article>
                  	<div class="icon">
                    	<div class="icon_inner">
                        <?php if($contents['icon_type3'] == 1) { ?>
                          <i class="sesbasic_text_hl fa <?php echo $contents['fonticon3']; ?>"></i>
                        <?php } else if($contents['icon_type3'] == 0) { ?>
                          <?php $photo3 = Engine_Api::_()->storage()->get($contents['photo3'], ''); ?>
                          <?php if($photo3) { ?>
                            <i class="_icon"><img src="<?php echo $photo3->getPhotoUrl(); ?>" alt="" /></i>
                          <?php } ?>
                        <?php } ?>
                      </div>
                    </div>
                    <div class="info">
                      <h3><?php echo $contents['title3']; ?></h3>
                      <?php if($contents['description3']) { ?>
                        <p><?php echo $contents['description3']; ?></p>
                      <?php } ?>
                    </div>
                  </article>
                </li>
              <?php } ?>
              <?php if(!empty($contents['title4'])) { ?>
                <li class="seslp_intro_right_item wow fadeIn" data-wow-delay="0.8s">
                  <article>
                  	<div class="icon">
                    	<div class="icon_inner">
                        <?php if($contents['icon_type4'] == 1) { ?>
                          <i class="sesbasic_text_hl fa <?php echo $contents['fonticon4']; ?>"></i>
                        <?php } else if($contents['icon_type4'] == 0) { ?>
                          <?php $photo4 = Engine_Api::_()->storage()->get($contents['photo4'], ''); ?>
                          <?php if($photo4) { ?>
                            <i class="_icon"><img src="<?php echo $photo4->getPhotoUrl(); ?>" alt="" /></i>
                          <?php } ?>
                        <?php } ?>
                      </div>
                   	</div>
                    <div class="info">
                      <h3><?php echo $contents['title4']; ?></h3>
                      <?php if($contents['description4']) { ?>
                        <p><?php echo $contents['description4']; ?></p>
                      <?php } ?>
                  	</div>
                  </article>
                </li>
              <?php } ?>
            </ul>
          </div>
      	</div>    
      </div>
    </section>
  </div>
<?php endif; ?>
