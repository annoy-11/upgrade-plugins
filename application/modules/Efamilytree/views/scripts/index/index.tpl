<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Efamilytree/externals/styles/styles.css');
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js'); ?>

<script type="application/javascript">
    function resize(){
        var width = sesJqueryObject(".top_tree").children().first().width();
        sesJqueryObject(".f_tree").css("width",width+"px");
    }
    sesJqueryObject(document).ready(function (e) {
        resize();
    })

    var addedMemberRelation;
    var sitememberSelected;
    var addUserId;
    function selectMember() {
        sesJqueryObject('.selecttree').show();
        sesJqueryObject(".familytree_cnt").hide();
    }
    sesJqueryObject(document).on('change','[name="relation"]',function (e) {
        addedMemberRelation = sesJqueryObject(this).val();
        sesJqueryObject('.selectSiteMember').show();
    })
    sesJqueryObject(document).on("click",'.cancelprocess',function (e) {
        sesJqueryObject(".mpop_container").hide();
        sesJqueryObject(".familytree_cnt").show();
        sesJqueryObject('[name="relation"]').removeAttr("checked",'checked');
        sesJqueryObject('[name="sitemember"]').removeAttr("checked",'checked');
        addedMemberRelation = undefined;
        sitememberSelected = undefined;
        addUserId = undefined;
        sesJqueryObject('.member_relation_ul').children().each(function (index) {
            sesJqueryObject(this).show();
        })
    })
    sesJqueryObject(document).on("click",'.addNewMember',function (e) {
        sesJqueryObject(".selectSiteMember").hide();
        sesJqueryObject(".newMember").show();
    })
    sesJqueryObject(document).on('click','.saveSiteMember',function (e) {
        e.preventDefault();
        if(sesJqueryObject('[name="sitemember"]:checked').val()){
            sesJqueryObject(".selectSiteMember").find(".mpop_main").find(".mpop_loading").show();
            sitememberSelected = sesJqueryObject('[name="sitemember"]:checked').val();
            //add user
            sesJqueryObject.post(en4.core.baseUrl+"efamilytree/index/sitemember",{relation_id:addedMemberRelation,sitemember:sitememberSelected,addUserId:addUserId},function (response1) {
                sesJqueryObject(".selectSiteMember").find(".mpop_main").find(".mpop_loading").hide();
                const response = sesJqueryObject.parseJSON(response1);
                if(response.status == 1){
                    sesJqueryObject('.cancelprocess').trigger("click");
                    sesJqueryObject('.familytree_cnt').html(response.content);
                    resize()
                }else{
                    alert("Something went wrong, please try again later.")
                }
            })
        }
    })

    sesJqueryObject(document).on("submit",'.new_member_add',function (e) {
        e.preventDefault();
        //validate submitted form
        var errorPresent = false;
        var validDay = true;
        var validMonth = true;
        var validYear = true;
        var dayObj;
        var monthObj;
        var yearObj;

        sesJqueryObject('.new_member_add input, .new_member_add select, .new_member_add checkbox, .new_member_add textarea, .new_member_add radio').each(
            function(index) {
                var input = sesJqueryObject(this);
                if(!input.val() && input.hasClass('required')){
                    sesJqueryObject(this).css("border",'1px solid red');
                    errorPresent = true;
                }else if(input.val() && input.hasClass('email')){
                    const pattern =  /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                    if(!pattern.test( input.val() )) {
                        //invalid email
                        errorPresent = true;
                        sesJqueryObject(this).css("border",'1px solid red');
                    } else {
                        sesJqueryObject(this).css("border",'');
                    }
                }else if (!input.val() && sesJqueryObject(this).hasClass("day")){
                    validDay = false
                    dayObj = input;
                }else if (!input.val() && sesJqueryObject(this).hasClass("month")){
                    validMonth = false
                    monthObj = input;
                }else if (!input.val() && sesJqueryObject(this).hasClass("year")){
                    validYear = false
                    yearObj = input;
                }else{
                    sesJqueryObject(this).css("border",'');
                }
            }
        );
        var isDobValid = false;

        if((validDay && validMonth && validYear) || (!validDay && !validMonth && !validYear)){
            isDobValid = true;
            sesJqueryObject(yearObj).css("border",'');
            sesJqueryObject(monthObj).css("border",'');
            sesJqueryObject(dayObj).css("border",'');
        }else{
            sesJqueryObject(yearObj).css("border",'1px solid red');
            sesJqueryObject(monthObj).css("border",'1px solid red');
            sesJqueryObject(dayObj).css("border",'1px solid red');
        }
        if(errorPresent || !isDobValid){
            return false;
        }
        var formData = new FormData(this);
        formData.append('relation_id', addedMemberRelation);
        formData.append('addUserId',addUserId);
        sesJqueryObject(".newMember").find(".mpop_main").find(".mpop_loading").show();
        sesJqueryObject.ajax({
            url: en4.core.baseUrl+"efamilytree/index/addnew",
            type: "POST",
            contentType:false,
            processData: false,
            cache: false,
            data: formData,
            success: function(response1) {
                //add user
                sesJqueryObject(".newMember").find(".mpop_main").find(".mpop_loading").hide();
                const response = sesJqueryObject.parseJSON(response1);
                if(response.status == 1){
                    sesJqueryObject('.cancelprocess').trigger("click");
                    sesJqueryObject('.familytree_cnt').html(response.content);
                    resize();
                }else{
                    alert("Something went wrong, please try again later.")
                }
            }
        });
    })
    sesJqueryObject(document).on("keyup",'.search_member',function (e) {
        var value = sesJqueryObject(this).val();
        sesJqueryObject(".mpop_user_list li").each(function(index) {
                $row = sesJqueryObject(this);
                var id = $row.find("label").find("._name").text();
                if (id.indexOf(value) != 0) {
                    $(this).hide();
                }else {
                    $(this).show();
                }
        });
    })

    sesJqueryObject(document).on("click",'.hide_show_tree',function (e) {
        if(sesJqueryObject(this).hasClass("hide")){
            sesJqueryObject(this).removeClass("hide");
            sesJqueryObject(this).closest("li").find("ul").first().show();
        }else{
            sesJqueryObject(this).addClass("hide");
            sesJqueryObject(this).closest("li").find("ul").first().hide();
        }
    })
    sesJqueryObject(document).on('click','.addUser',function (e) {
        e.preventDefault();
        addUserId = sesJqueryObject(this).data("id");
        var isTop = sesJqueryObject(this).closest("ul").hasClass("top_tree");
        var isSpouse = sesJqueryObject(this).parent().find(".f_tree_user").length > 1;
        console.log(isSpouse,isTop)
        sesJqueryObject('.member_relation_ul').children().each(function (index) {
            if(index == 0) {
                if (isTop) {
                    sesJqueryObject(this).show();
                } else {
                    sesJqueryObject(this).hide();
                }
            }else if(index == 1) {
                if (!isSpouse) {
                    sesJqueryObject(this).show();
                } else {
                    sesJqueryObject(this).hide();
                }
            }
        })
        sesJqueryObject('.selecttree').show();
        sesJqueryObject(".familytree_cnt").hide();
    })
</script>

<!--Select Relation Start-->
<div class="mpop_container selecttree" style="display:none">
    <div class="mpop_overlay"></div>
    <div class="mpop_main select-relation">
        <div class="mpop_header">
            Select Relation
        </div>
        <ul class="mpop_menu member_relation_ul">
            <?php foreach($this->relations as $relations){ ?>
            <li class="mpop_menu_radio">
                <label for="relation_<?php echo $relations->getIdentity() ?>">
                    <input type="radio" name="relation" id="relation_<?php echo $relations->getIdentity() ?>" value="<?php echo $relations->getIdentity() ?>" /><span><?php echo $relations->title ?></span>
                </label>
            </li>
            <?php } ?>
        </ul>
        <div class="mpop_footer">
            <button class="btn btn-primary-outline cancelprocess">Cancel</button>
        </div>
        <div class="mpop_loading" style="display:none;">
            <div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
        </div>

    </div>
</div>
<!--Select Relation End-->

<!--Select Family Member Start-->
<div class="mpop_container selectSiteMember" style="display:none">
    <div class="mpop_overlay"></div>
    <div class="mpop_main select-relation">
        <div class="mpop_header">
            Select Members to add
            <div class="new_member" style="float: right">
                <a href="javascript:;" class="addNewMember">Add New Member</a>
            </div>
        </div>
        <div class="mpop_search">
            <div class="mpop_search_field">
                <i class="search_icon"></i>
                <input type="text" name="search" class="search_member" />
            </div>
        </div>
        <div class="mpop_content">
            <ul class="mpop_user_list">
                <?php foreach($this->friends as $friends){ ?>
                    <li class="mpop_user_list_item">
                        <label for="user_<?php echo $friends->getIdentity(); ?>">
                            <div class="_thumb">
                                <?php echo $this->itemPhoto($friends, 'thumb.icon'); ?>
                            </div>
                            <div class="_name"><?php echo $friends->getTitle(); ?></div>
                            <input type="radio" value="<?php echo $friends->getIdentity(); ?>" name="sitemember" id="user_<?php echo $friends->getIdentity(); ?>" />
                            <span></span>
                        </label>
                    </li>
                <?php } ?>
            </ul>
        </div>
        <div class="mpop_footer">
            <button class="btn btn-primary saveSiteMember">Save</button>
            <button class="btn btn-primary-outline cancelprocess">Cancel</button>
        </div>
        <div class="mpop_loading" style="display:none;"><div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>
    </div>
</div>
<!--Select Family Member End-->

<script type="application/javascript">
    sesJqueryObject(document).on("click",'.uploadFile',function (e) {
        sesJqueryObject('.triggerimage').trigger('click');
    });
    function readUploadedFile(input) {
        var url = input.value;
        var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();

        if (input.files && input.files[0] && (ext == "png" || ext == "jpeg" || ext == "jpg" || ext == 'PNG' || ext == 'JPEG' || ext == 'JPG')){
            var reader = new FileReader();
            reader.onload = function (e) {
                jqueryObjectOfSes('.changedFile').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }else{
            jqueryObjectOfSes('.changedFile').attr('src',"application/modules/User/externals/images/nophoto_user_thumb_icon.png");
            jqueryObjectOfSes('.triggerimage').val('');
        }
    }
</script>

<!--Select Family Member Start-->
<div class="mpop_container newMember" style="display: none;">
    <div class="mpop_overlay"></div>
    <div class="mpop_main add-user">
        <div class="mpop_header">
            Add Family Member
        </div>
        <form class="new_member_add" method="post">
        <div class="mpop_content">
            <div class="mpop_add_user">
                    <div class="_top">
                        <div class="_thumb">
                            <img class="changedFile" src="application/modules/User/externals/images/nophoto_user_thumb_icon.png" alt="" />
                            <a href="javascript:;" class="uploadFile">
                                <img src="application/modules/Efamilytree/externals/images/camera-icon.svg" alt="" />
                            </a>
                            <input style="display: none" class="triggerimage" type="file" name="image" onchange="readUploadedFile(this)">
                        </div>
                        <div class="_topfields">
                            <div class="mpop_add_user_field">
                                <input type="text" class="required" placeholder="Name" name="first_title" />
                            </div>
                            <div class="mpop_add_user_field">
                                <input type="text" class="email" placeholder="Email" name="email" />
                            </div>
                        </div>
                    </div>
                    <div class="mpop_add_user_field">
                        <input type="text" class="phone" placeholder="Phone Number" name="phone_number" />
                    </div>
                    <div class="mpop_add_user_field _birthday">
                        <label>Bithday</label>
                        <span>
                            <select name="day" class="day">
                                <option value="">Date</option>
                                <?php
                                    for($i=1;$i<=31;$i++)
                                    {
                                    echo "<option value='$i'>$i</option>";
                                    }

                                ?>
                            </select>
                        </span>
                      <span>
                        <select name="month" class="month">
                            <option value="">Month</option>
                            <?php
                                for($i=1;$i<=12;$i++)
                                {
                                echo "<option value='$i'>$i</option>";
                                }
                            ?>
                        </select>
                      </span>
                      <span>
                        <select name="year" class="year">
                           <option value="">Year</option>
                            <?php
                            for($i=1900;$i<=date(Y);$i++)
                            {
                            echo "<option value='$i'>$i</option>";
                            }
                            ?>
                        </select>
                      </span>
                    </div>
                    <div class="mpop_add_user_field _gender">
                        <label>Gender</label>
                        <select name="gender" class="gender">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
            </div>
        </div>
        <div class="mpop_footer">
            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-primary-outline cancelprocess">Cancel</button>
        </div>
        </form>
        <div class="mpop_loading" style="display:none;"><div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>
    </div>
</div>
<!--Select Family Member End-->

<?php if(false){ ?>
    <button onclick="selectMember();"><?php echo $this->translate("Create Family Tree"); ?></button>
<?php } ?>

<div class="familytree_cnt">
    <?php echo $this->partial('index/mainContent.tpl', 'efamilytree', array("treeData"=>$this->treeData));; ?>
</div>
