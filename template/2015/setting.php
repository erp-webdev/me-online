	<?php include(TEMP."/header.php"); ?>

    <!-- BODY -->
    
    <div id="subcontainer" class="subcontainer">        
        <div id="lowersub" class="lowersub tbpadding10 dwhitebg">
            <div id="ltitle" class="lowerlist robotobold cattext dbluetext"><?php echo SYSTEMNAME; ?></div>
            <div id="lowerlist" class="lowerlist minheight150">
                <div class="lowerleft">
                    <?php include(TEMP."/menu.php"); ?>
                </div>
                <div class="lowerright">
                    <div id="ltitle" class="robotobold cattext2 dbluetext marginbottom12">iRoom Setting</div>
                    
                    <form name="frmsetting" method="POST" enctype="multipart/form-data">                        
                        <div class="fields">
                            <div class="lfield valigntop">Announcement</div>
                            <div class="rfield valigntop"><textarea name="set_announce" class="txtarea"><?php echo $setting[0]['set_announce'] ? $setting[0]['set_announce'] : $_POST['set_announce']; ?></textarea></div>
                        </div>
                        <div class="fields">
                            <div class="lfield valigntop">Mail Footer</div>
                            <div class="rfield valigntop"><textarea name="set_mailfoot" class="txtarea"><?php echo $setting[0]['set_mailfoot'] ? $setting[0]['set_mailfoot'] : $_POST['set_mailfoot']; ?></textarea></div>
                        </div>
                        <div class="fields">
                            <div class="lfield valigntop">Data per Page</div>
                            <div class="rfield valigntop">
                                <select name="set_numrows" class="text40">                                    
                                    <?php $numrows = $setting[0]['set_numrows'] ? $setting[0]['set_numrows'] : 20; ?>
                                    <?php for($i=1; $i<=20; $i++) { ?>
                                    <option value="<?php echo $i; ?>" <?php echo $numrows == $i ? "selected" : ""; ?>><?php echo $i; ?></option>
                                    <?php } ?>
                                </select></div>
                        </div>
                        <div class="fields centertalign margintop10">                        
                            <input type="submit" name="btneditset" value="Update" class="btn" />
                        </div>
                    </form> 
                    
                </div>
            </div>
        </div>
    </div>

    <?php include(TEMP."/footer.php"); ?>