
						<div style=" width:<?php echo $this->config->item('page_width')-240;?>px; float:left;">
                        	<strong><?php echo $this->lang->line('txt_Edit_Profile');?></strong>
                        </div>
						
							
							<div style="width:200px; float:left; margin-right:5px;  " align="right"><?php echo $this->lang->line('txt_Photo');?>:</div>
							<div style="width:<?php echo $this->config->item('page_width')-480;?>px; float:left; height:50px;">
								<input type="file" name="photo" id="photo" class="text_gre1" id="photo" size="30" value="" /><br/> (jpg, jpeg, png, gif only)
							</div>
						
                        
						<div style="height:100">	
							<div style="width:200px; float:left;margin-right:5px;  " align="right"><?php echo $this->lang->line('txt_Current_Password');?>:</div>
							<div style="width:<?php echo $this->config->item('page_width')-480;?>px; float:left; height:30px;">
								<input name="currentPassword" type="password" class="text_gre1" id="currentPassword" size="30" />
							</div>
						</div>
                        
                        <div style="width:200px; float:left;margin-right:5px;  " align="right"><?php echo $this->lang->line('txt_New_Password');?>:</div>
                        <div style="width:<?php echo $this->config->item('page_width')-480;?>px; float:left; height:30px;">
                        	<input name="password" type="password" class="text_gre1" id="password" size="30" />
						</div>
                        
                        <div style="width:200px; float:left;margin-right:5px;  " align="right"><?php echo $this->lang->line('txt_Retype_New_Password');?>:</div>
                        <div style="width:<?php echo $this->config->item('page_width')-480;?>px; float:left; height:30px;">
                        	<input name="confirmPassword" type="password" class="text_gre1" id="confirmPassword" size="30" />
						</div>
                        
                        <div style="width:200px; float:left;margin-right:5px;  " align="right"><?php echo $this->lang->line('txt_First_Name');?><span class="text_red">*</span>:</div>
                        <div style="width:<?php echo $this->config->item('page_width')-480;?>px; float:left; height:30px;">
                        	<input name="firstName" class="text_gre1" id="firstName" size="30" value="<?php echo $Profiledetail['firstName'];?>" readonly="readonly" />
                            <input type="hidden" name="userTitle" id="userTitle" value="" />
						</div>
                        
                        <div style="width:200px; float:left;margin-right:5px;  " align="right"><?php echo $this->lang->line('txt_Last_Name');?><span class="text_red">*</span>:</div>
                        <div style="width:<?php echo $this->config->item('page_width')-480;?>px; float:left; height:30px;">
                        	<input name="lastName" class="text_gre1" id="lastName" size="30"  value="<?php echo $Profiledetail['lastName'];?>" readonly="readonly"/>
						</div>
                        
                        <div style="width:200px; float:left; margin-right:5px;  " align="right"><?php echo $this->lang->line('txt_Role');?>:</div>
                        <div style="width:<?php echo $this->config->item('page_width')-480;?>px; float:left; height:30px;">
                        	<input name="role" class="text_gre1" id="role" size="30"  value="<?php echo $Profiledetail['role'];?>"/>
						</div>
                        
                        <div style="width:200px; float:left; margin-right:5px;  " align="right"><?php echo $this->lang->line('txt_Department');?>:</div>
                        <div style="width:<?php echo $this->config->item('page_width')-480;?>px; float:left; height:30px;">
                        	<input name="department" class="text_gre1" id="department" size="30"  value="<?php echo $Profiledetail['department'];?>"/>
						</div>

                        <div style="width:200px; float:left; margin-right:5px;  " align="right"><?php echo $this->lang->line('txt_Address');?>:</div>
                        <div style="width:<?php echo $this->config->item('page_width')-480;?>px; float:left; height:80px;">
                        	<textarea name="address1"  id="address1" style="min-width: 200px; max-width: 200px; width : 200px; min-height: 65px; max-height: 65px; height: 65px;"><?php echo $Profiledetail['address1'];?></textarea>
						</div>

                        <div style="width:200px; float:left; margin-right:5px;  " align="right"><?php echo $this->lang->line('txt_Telephone');?>:</div>
                        <div style="width:<?php echo $this->config->item('page_width')-480;?>px; float:left; height:30px;">
                        	<input name="phone" class="text_gre1" id="phone" size="30" value="<?php echo $Profiledetail['phone'];?>"/>
						</div>

                        <div style="width:200px; float:left; margin-right:5px;  " align="right"><?php echo $this->lang->line('txt_Mobile');?>:</div>
                        <div style="width:<?php echo $this->config->item('page_width')-480;?>px; float:left; height:30px;">
                        	<input name="mobile" class="text_gre1" id="mobile" size="30" value="<?php echo $Profiledetail['mobile'];?>"/>
						</div>

                        <div style="width:200px; float:left; margin-right:5px;  " align="right"><?php echo $this->lang->line('txt_Other_Details');?>:</div>
                        <div style="width:<?php echo $this->config->item('page_width')-480;?>px; float:left; height:80px;">
                        	<textarea name="otherMember" rows="3"  id="otherMember" style="min-width: 200px; max-width: 200px; width : 200px; min-height: 65px; max-height: 65px; height: 65px;"><?php echo $Profiledetail['other'];?></textarea>
						</div>

                  		<div style="width:200px; float:left; margin-right:5px;  " align="right"><?php echo $this->lang->line('txt_Authenticate_with');?>:</div>
                    	<div style="width:<?php echo $this->config->item('page_width')-480;?>px; float:left; height:30px;">
                        	<select name="communityId" id="communityId" disabled="disabled"  style="min-width: 205px; max-width: 205px; width : 205px;" >
                      			<?php
						
								foreach( $communityDetails as $communityData )
								{
								?>
                      				<option value="<?php echo $communityData['communityId'];?>" <?php if( $communityData['communityId'] == $Profiledetail['userCommunityId'] ) { echo 'selected'; }?>><?php echo $communityData['communityName'];?></option>
                      			<?php
								}
								?>
                    			</select>
						</div>
                        
                        <div style="width:200px; float:left; margin-right:5px;  " align="right"><?php echo $this->lang->line('txt_Email');?><span class="text_red">*</span>:</div>
                        <div style="width:<?php echo $this->config->item('page_width')-480;?>px; float:left; height:30px;">
                        	<input name="userName" class="text_gre1" id="userName" size="30" onKeyUp="checkUserName(this,<?php echo $_SESSION['workPlaceId'];?>)" value="<?php echo $Profiledetail['userName'];?>" readonly="readonly"/>&nbsp;<span id="userNameStatusText"></span>
						</div>
							
						
                        <div style="width:200px; float:left; margin-right:5px;  " align="right"><?php echo $this->lang->line('txt_User_Tag_Name');?><span class="text_red">*</span>:</div>
                        <div style="width:<?php echo $this->config->item('page_width')-480;?>px; float:left;height:30px;">
                        	<input name="tagName" type="text" class="text_gre1" id="tagName" size="30" value="<?php echo $Profiledetail['userTagName'];?>" readonly="readonly"/>
						</div>
						

						<div style=" width:<?php echo $this->config->item('page_width')-630;?>px; margin-top:10px; float:left; margin-left:210px ">
                          	<input type="hidden" name="email" class="hidden" id="email" size="30" value=""/>
                            <input type="hidden" name="userCommunity"  id="userCommunity" value="<?php echo $Profiledetail['userCommunityId']; ?>" />
                            <input type="hidden" name="userId" class="hidden" id="userId" size="30" value="<?php echo $Profiledetail['userId'];?>"/>
                            <input type="hidden" name="workSpaceId" class="hidden" id="workSpaceId" size="30" value="<?php echo $workSpaceId;?>"/>
                            <input type="hidden" name="workSpaceType" class="hidden" id="workSpaceType" size="30" value="<?php echo $workSpaceType;?>"/>
                            <input type="hidden" name="userPassword" class="hidden" id="userPassword" size="30" value="<?php echo $Profiledetail['password'];?>"/>
                            <input type="button" name="Submit" value="<?php echo $this->lang->line('txt_Save');?>" class="button01" onClick="validateWorkPlaceMemberEdit('document.frmWorkPlace','<?php echo base_url();?>edit_workplace_member/edit/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/<?php echo $workSpaceId_search_user; ?>/<?php echo $workSpaceType_search_user; ?>','<?php echo base_url();?>edit_workplace_member/uploadImage');"/>
							
							<input type="button" name="Cancel" value="<?php echo $this->lang->line('txt_Cancel');?>" class="button01" onclick="hideBlock('profileDetailsEdit','<?php echo base_url();?>edit_workplace_member/getUserDeatils')" />
							
						</div>
                 