<div class="f_tree">
    <ul class="top_tree">
        <li>
            <?php if($this->treeData){
            $treeData = $this->treeData;
            ?>
            <div class="f_tree_user_box">
                <a href="javascript:;" data-id="<?php echo $treeData['main']['user_id']; ?>" class="addUser" >Add</a>
                <?php if(!empty($treeData['main'])){ ?>
                <div class="f_tree_user">
                    <a href="<?php echo $treeData['main']['href'] ?>">
                        <div class="f_tree_user_thumb">
                            <img src="<?php echo $treeData['main']['image'] ?>" alt="" />
                        </div>
                        <div class="f_tree_user_info">
                            <span><?php echo $treeData['main']['name'] ?></span>
                        </div>
                    </a>
                </div>
                <?php } ?>
                <?php if(!empty($treeData['spouse'])){ ?>
                <div class="f_tree_user">
                    <a href="<?php echo $treeData['spouse']['href'] ?>">
                        <div class="f_tree_user_thumb">
                            <img src="<?php echo $treeData['spouse']['image'] ?>" alt="" />
                        </div>
                        <div class="f_tree_user_info">
                            <span><?php echo $treeData['spouse']['name'] ?></span>
                        </div>
                    </a>
                </div>
                <?php } ?>
                <?php if(!empty($treeData['contents'])){ ?>
                <a class="hideshow_btn hide_show_tree"  href="javascript:;"></a>
                <?php } ?>
            </div>
            <?php if(!empty($treeData['contents'])){ ?>
            <ul>
                <?php echo Engine_Api::_()->efamilytree()->generateFamilyTree($treeData['contents'],'',$this); ?>
            </ul>
            <?php } ?>
            <?php } ?>
        </li>
    </ul>
</div>