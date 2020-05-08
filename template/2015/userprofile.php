	<?php include(TEMP."/header.php"); ?>

    <!-- BODY -->
                    
                    <div id="mainsplashtext" class="mainsplashtext lefttalign">  
                        <div class="topsplashtext lefttalign robotobold cattext whitetext"><?php echo WELCOME; ?></div>
                        <div class="leftsplashtext lefttalign"><?php include(TEMP."/menu.php"); ?></div>
                        <div class="rightsplashtext lefttalign">
                
                            <?php foreach ($emp_data as $emp_data) : ?>
                            
                            <div id="memodiv9" class="div9 whitetext"> 
                                <div id="idpic" class="idpic">
                                    <div id="picturediv">
                                    <?php if ($pix_data[0]['SeqID']) : ?>
                                        <img src="<?php echo WEB; ?>/image?type=1&id=<?php echo $emp_data['EmpID']; ?>" width="200" height="200" />
                                    <?php else : ?>
                                        <?php if ($emp_data['Gender'] == 'F') : ?>
                                        <img src="<?php echo IMG_WEB; ?>/davatar_female.png" width="200" height="200" />
                                        <?php else : ?>  
                                        <img src="<?php echo IMG_WEB; ?>/davatar_male.png" width="200" height="200" />
                                        <?php endif; ?>                                        
                                    <?php endif; ?>
                                    </div>                        
                                </div>

                                <div class="profile_info">
                                    <b class="mediumtext lorangetext"><?php echo strtoupper($emp_data['LName']).', '.strtoupper($emp_data['FName']).' '.strtoupper($emp_data['MName']); ?></b><br><br>                        
                                    <div class="lorangetext roboto cattext2">Personal Information</div>
                                    <div>
                                        <p>
                                            <b><?php echo ucfirst($profile_nadd); ?> No.:</b> <?php echo $emp_data['EmpID']; ?><br/>
                                            <b>Position:</b> <?php echo $emp_data['PositionDesc']; ?><br/>
                                            <b>Nickname:</b> <?php echo $emp_data['NickName']; ?><br/>
                                            <b>Address:</b> <?php echo $emp_data['UnitStreet']; ?>, <?php echo $emp_data['Barangay'] ? $emp_data['Barangay'].', ' : ''; ?><?php echo $emp_data['TownCity']; ?> <?php echo $emp_data['Zip']; ?><br/>
                                            <b>Contact No.:</b> <?php echo $emp_data['HomeNumber']; ?><br/>
                                            <b>Email Address:</b> <?php echo $emp_data['EmailAdd']; ?><br/>
                                            <b>Birthdate:</b> <?php echo date("F j, Y", strtotime($emp_data['BirthDate'])); ?><br/>
                                            <b>Birthplace:</b> <?php echo $emp_data['BirthPlace']; ?><br/>
                                            <b>Gender:</b> <?php echo $emp_data['Gender'][0] == "F" ? "FEMALE" : "MALE"; ?><br/>
                                            <b>Civil Status:</b> <?php if ($emp_data['Status'][0] == 'S') : echo "SINGLE"; elseif ($emp_data['Status'][0] == 'M') : echo "MARRIED"; else : echo "WIDOWED"; endif; ?><br/>
                                            <b>SSS No.:</b> <?php echo $emp_data['SSSNbr']; ?><br/>
                                            <b>TIN No.:</b> <?php echo $emp_data['TINNbr']; ?><br/>
                                            <b>PhilHealth No.:</b> <?php echo $emp_data['PhilHealthNbr']; ?><br/>
                                            <b>Pag-IBIG No.:</b> <?php echo $emp_data['PagibigNbr']; ?><br/><br/>
                                        </p>
                                    </div>
                                    <?php if ($family_data) : ?>
                                    <div class="lorangetext roboto cattext2">Family Background</div>
                                    <div>                            
                                        <p>                                

                                            <table class="tdataform">
                                                <tr>
                                                    <th width="20%" align="center">&nbsp;</th>
                                                    <th width="30%" align="center">Name</th>
                                                    <th width="25%" align="center">Birthday</th>
                                                    <th width="25%" align="center">Profession</th>
                                                </tr>
                                                <?php foreach($family_data as $key => $value) : ?>
                                                <tr>
                                                    <td><b><?php echo $value['Relation']; ?></b></td>
                                                    <td><?php echo $value['Name']; ?></td>
                                                    <td align="center"><?php echo $value['BirthDate'] ? date("F j, Y", strtotime($value['BirthDate'])) : 'N/A'; ?></td>
                                                    <td align="center"><?php echo $value['Occupation'] ? $value['Occupation'] : 'N/A'; ?></td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </table><br/>                                  
                                        </p>
                                    </div> 
                                    <?php endif; ?>

                                    <?php if ($education_data || $training_data || $skill_data) : ?>
                                    <div class="lorangetext roboto cattext2">Education and Skills</div>
                                    <div>                            
                                        <p>
                                            <?php if ($education_data) : ?>
                                            <table class="tdataform">
                                                <tr>
                                                    <th width="20%" align="center">Level</th>
                                                    <th width="40%" align="center">Schools Name</th>
                                                    <th width="20%" align="center">Year</th>
                                                    <th width="20%" align="center">Course & Award Recieved</th>
                                                </tr>
                                                
                                                <?php foreach ($education_data as $value) : ?>
                                                <tr>
                                                    <td><?php echo $value['EducAttainment']; ?></td>
                                                    <td><?php echo $value['School']; ?></td>
                                                    <td class="valign-bottom centertalign"><?php echo $value['YearGraduated']; ?></td>
                                                    <td class="valign-bottom centertalign"><?php echo $value['Course'] ? $value['Course'] : "N/A"; ?></td>
                                                </tr>
                                                <?php endforeach; ?>
                                                
                                            </table><br/>
                                            <?php endif; ?>
                                        
                                            <?php if ($skill_data) : ?>                        
                                            <b>Other Skills: </b>
                                            <?php foreach ($skill_array as $key => $value) : ?>
                                                <?php echo $key != 0 ? ",&nbsp;" : ""; ?><?php echo $value['Competency']; ?>
                                            <?php endforeach; ?><br/><br/>
                                            <?php endif; ?>

                                        </p>
                                    </div>
                                    <?php endif; ?>

                                    <?php if ($prevwork_data) : ?>
                                    <div class="lorangetext roboto cattext2">Previous Work</div>
                                    <div>                            
                                        <p>
                                            <table class="tdataform">
                                                <tr>
                                                    <th width="35%" align="center">COMPANY NAME</th>
                                                    <th width="25%" align="center">POSITION HELD</th>
                                                    <th width="20%" align="center">REASON FOR LEAVING</th>
                                                    <th width="20%" align="center">DATES EMPLOYED</th>
                                                </tr>                                    
                                                <?php foreach ($prevwork_data as $key => $value) : ?>
                                                    <tr>
                                                        <td>
                                                            <b><?php echo $value['PrevCompany']; ?></b>
                                                        </td>
                                                        <td class="valign-center">
                                                            <?php echo $value['PrevPosition']; ?>
                                                        </td>
                                                        <td class="valign-center">
                                                            <?php echo stripslashes($value['Reason']) ? stripslashes($value['Reason']) : "N/A"; ?>
                                                        </td>
                                                        <td class="valign-center">
                                                            <b>From:</b><br/><?php echo date("F j, Y", strtotime($value['DateStarted'])); ?><br>
                                                            <b>To:</b><br/><?php echo date("F j, Y", strtotime($value['DateResigned'])); ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>                                    
                                            </table><br/>
                                        </p>
                                    </div>
                                    <?php endif; ?>

                                    <?php if ($emp_data['ContactPerson']) : ?>
                                    <div class="lorangetext roboto cattext2">Person to Notify in Case of Emergency</div>
                                    <div>                            
                                        <p>
                                            <b>Name:</b> <?php echo $emp_data['ContactPerson']; ?><br/>
                                            <b>Address:</b> <?php echo $emp_data['ContactAddress']; ?><br/>
                                            <b>Tel. No.:</b> <?php echo $emp_data['ContactTelNbr'] ? $emp_data['ContactTelNbr'] : 'N/A'; ?><br/>
                                            <b>Mobile No.:</b> <?php echo $emp_data['ContactMobileNbr'] ? $emp_data['ContactMobileNbr'] : 'N/A'; ?>
                                        </p>
                                    </div>
                                    <?php endif; ?>

                                    <div align="center">
                                        <br><input id="btnempapprove" type="button" name="btnempapprove" class="btn" value="Approve" attribute="<?php echo $emp_data['EmpID']; ?>">&nbsp;<input id="btnempreject" type="button" name="btnempreject" class="redbtn" value="Reject" attribute="<?php echo $emp_data['EmpID']; ?>">
                                    </div>


                                </div>

                            </div>

                            <?php endforeach; ?>
                        </div>
                    </div>

    <?php include(TEMP."/footer.php"); ?>