<?php include(TEMP."/header.php"); ?>
<div id="floatdiv" class="floatdiv invisible">                    
                        
<!-- ADD EMPLOYEE - BEGIN --> 
<div id="aedit" class="fedit2" style="display: none;">
    <div class="closebutton2 cursorpoint"><i class="fa fa-times-circle fa-3x redtext"></i></div>
    
    <!-- SEARCH APPROVERS - BEGIN --> 
    <div id="asearch" class="fsearch invisible">
        <div class="closebutton3 cursorpoint"><i class="fa fa-times-circle fa-3x redtext"></i></div>
        <i class="fa fa-search"></i> Search employee <input id="apsrsearch" type="text" name="apsrsearch" placeholder="and press ENTER..." class="txtbox" /> <button id="btnapsrdel" name="btnapsrdel" class="btnapsrdel redbtn invisible">Delete this Approver</button>
        <div id="apsr_data" class="apsr_data">

        </div>
        <div id="apsr_button" class="apsr_button centertalign">
            <input id="apsrtbid" type="hidden" name="apsrtbid" />
            <input id="apsrtbdb" type="hidden" name="apsrtbdb" />
        </div>
    </div>
    <!-- SEARCH APPROVERS - END -->  
    
    <div id="appr_title" class="appr_title robotobold cattext dbluetext"></div>
    <div id="appr_data">
    
    </div>
    <div id="appr_button" class="appr_button centertalign">
        <input id="appempid" type="hidden" name="appempid" />
        <input id="appcount" type="hidden" name="appcount" />
        <input id="appdbname" type="hidden" name="appdbname" />
        <button id="btnapprovers" class="btn btnapprovers invisible">Update</button>
    </div>
</div>
<!-- EDIT APPROVERS - END -->    
</div>
<div id="mainsplashtext" class="mainsplashtext lefttalign">  
    <div class="topsplashtext lefttalign robotobold cattext whitetext"><?php echo WELCOME; ?></div>
    <div class="leftsplashtext lefttalign"><?php include(TEMP."/menu.php"); ?></div>
    <div class="rightsplashtext lefttalign">
        <div id="mainapprovers" class="mainbody lefttalign whitetext">  
            <b class="mediumtext lorangetext">ACCESS MANAGEMENT</b><br><br>                                
            
            <!-- <table class="width100per">
                <tr>
                    <td><span class="fa fa-search"></span> Search: 
                        <input type="text" id="searchacman" name="searchacman" value="<?php echo $_SESSION['searchacman'] ? $_SESSION['searchacman'] : ''; ?>" placeholder="by <?php echo $profile_nadd; ?> ID, lastname or firstname" class="smltxtbox width250" />&nbsp;
                        <input type="button" id="btnacman" name="btnacman" value="Search" class="smlbtn" />
                        <input type="button" id="btnacmanall" name="btnacmanall" value="View All" class="smlbtn<?php if (!$_SESSION['searchacman']) : ?> invisible<?php endif; ?>" />                                            
                    </td>
                    <td class="righttalign">
                    </td>
                </tr>
            </table> -->
            <style>
                /* Styles for rotateTableCellContent plugin*/
                table div.rotated {
                    -webkit-transform: rotate(178deg);
                    -moz-transform: rotate(178deg);
                    writing-mode:tb-rl;
                    white-space: nowrap;
                }

                thead th {
                    vertical-align: top;
                }

                table .vertical {
                    white-space: nowrap;
                }
            </style>
            
            <div id="empdata">
                <table border="0" cellspacing="0" class="yourtableclass tdata width100per">
                    <?php if ($acman_data) : ?>
                    <tr>
                        <th>EmpID</th>
                        <th>Name</th>
                        <th class="vertical">DTR</th>
                        <th class="vertical">PAYSLIP</th>
                        <th class="vertical">REQUESTS</th>
                        <th class="vertical">APPROVERS</th>
                        <th class="vertical">ACTIVITIES</th>
                        <th class="vertical">MEMO</th>
                        <th class="vertical">ADS</th>
                        <th class="vertical">BIRTHDAY</th>
                        <th class="vertical">FORMS</th>
                        <th class="vertical">WFH</th>
                        <th class="vertical">ACCESS</th>
                    </tr>
                    <!-- <tr class="cursorpoint trdata centertalign whitetext" attribute="<?php echo md5($value['EmpID']); ?>">
                        <td><input type="text" class="smltxtbox" name="EmpID">
                            <input type="hidden" name="EmpIDDB"></td>
                        <td><span id="empname"></span></td>
                        <td style="text-align: left"><input type="checkbox" class="actoggle" name="dtr" value="dtr" id="dtr" <?php if($value['dtr']) echo'checked'; ?>></td>
                        <td style="text-align: left"><input type="checkbox" class="actoggle" name="payslip" value="payslip" id="payslip" <?php if($value['payslip']) echo'checked'; ?>></td>
                        <td style="text-align: left"><input type="checkbox" class="actoggle" name="requests" value="requests" id="requests" <?php if($value['requests']) echo'checked'; ?>></td>
                        <td style="text-align: left"><input type="checkbox" class="actoggle" name="approvers" value="approvers" id="approvers" <?php if($value['approvers']) echo'checked'; ?>></td>
                        <td style="text-align: left"><input type="checkbox" class="actoggle" name="activities" value="activities" id="activities" <?php if($value['activities']) echo'checked'; ?>></td>
                        <td style="text-align: left"><input type="checkbox" class="actoggle" name="memo" value="memo" id="memo" <?php if($value['memo']) echo'checked'; ?>></td>
                        <td style="text-align: left"><input type="checkbox" class="actoggle" name="ads" value="ads" id="ads" <?php if($value['ads']) echo'checked'; ?>></td>
                        <td style="text-align: left"><input type="checkbox" class="actoggle" name="bday" value="bday" id="bday" <?php if($value['bday']) echo'checked'; ?>></td>
                        <td style="text-align: left"><input type="checkbox" class="actoggle" name="wfh" value="wfh" id="wfh" <?php if($value['wfh']) echo'checked'; ?>></td>
                        <td style="text-align: left"><input type="checkbox" class="actoggle" name="forms" value="forms" id="forms" <?php if($value['forms']) echo'checked'; ?>></td>
                        <td style="text-align: left"><input type="checkbox" class="actoggle" name="access" value="access" id="access" <?php if($value['access']) echo'checked'; ?>></td>
                    </tr> -->
                    <?php foreach ($acman_data as $key => $value) : ?>                                    
                    <tr class="cursorpoint trdata centertalign whitetext" attribute="<?php echo md5($value['EmpID']); ?>">
                        <td><?php echo $value['EmpID']; ?></td>
                        <td><?php echo $value['Fullname']; ?></td>
                        <td style="text-align: left"><input type="checkbox" class="actoggle" name="dtr" value="dtr" id="dtr" <?php if($value['dtr']) echo'checked'; ?>></td>
                        <td style="text-align: left"><input type="checkbox" class="actoggle" name="payslip" value="payslip" id="payslip" <?php if($value['payslip']) echo'checked'; ?>></td>
                        <td style="text-align: left"><input type="checkbox" class="actoggle" name="requests" value="requests" id="requests" <?php if($value['requests']) echo'checked'; ?>></td>
                        <td style="text-align: left"><input type="checkbox" class="actoggle" name="approvers" value="approvers" id="approvers" <?php if($value['approvers']) echo'checked'; ?>></td>
                        <td style="text-align: left"><input type="checkbox" class="actoggle" name="activities" value="activities" id="activities" <?php if($value['activities']) echo'checked'; ?>></td>
                        <td style="text-align: left"><input type="checkbox" class="actoggle" name="memo" value="memo" id="memo" <?php if($value['memo']) echo'checked'; ?>></td>
                        <td style="text-align: left"><input type="checkbox" class="actoggle" name="ads" value="ads" id="ads" <?php if($value['ads']) echo'checked'; ?>></td>
                        <td style="text-align: left"><input type="checkbox" class="actoggle" name="bday" value="bday" id="bday" <?php if($value['bday']) echo'checked'; ?>></td>
                        <td style="text-align: left"><input type="checkbox" class="actoggle" name="wfh" value="wfh" id="wfh" <?php if($value['wfh']) echo'checked'; ?>></td>
                        <td style="text-align: left"><input type="checkbox" class="actoggle" name="forms" value="forms" id="forms" <?php if($value['forms']) echo'checked'; ?>></td>
                        <td style="text-align: left"><input type="checkbox" class="actoggle" name="access" value="access" id="access" <?php if($value['access']) echo'checked'; ?>></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if ($pages) : ?>
                    <tr>
                        <td colspan="7" class="centertalign"><?php echo $pages; ?></td>
                    </tr>
                    <?php endif; ?>
                    <?php else : ?>
                    <tr>
                        <td class="bold centertalign noborder"><br><br>You have no employees listed</td>
                    </tr>
                    <?php endif; ?>
                </table>
                <input type="hidden" id="emppage" name="emppage" value="<?php echo $page; ?>" />   
            </div>
        </div>
    </div>
</div>
<script>
    (function ($) {
        $.fn.rotateTableCellContent = function (options) {

        var cssClass = ((options) ? options.className : false) || "vertical";

        var cellsToRotate = $('.' + cssClass, this);

        var betterCells = [];
        cellsToRotate.each(function () {
        var cell = $(this)
        , newText = cell.text()
        , height = cell.height()
        , width = cell.width()
        , newDiv = $('<div>', { height: width, width: height })
        , newInnerDiv = $('<div>', { text: newText, 'class': 'rotated' });

        // newInnerDiv.css('-webkit-transform-origin', (50) + 'px ' + (50) + 'px');
        // newInnerDiv.css('-moz-transform-origin', (50) + 'px ' + (50) + 'px');
        newDiv.append(newInnerDiv);

        betterCells.push(newDiv);
        });

        cellsToRotate.each(function (i) {
        $(this).html(betterCells[i]);
        });
        };
        })(jQuery);
     $(document).ready(function(){
        $('.yourtableclass').rotateTableCellContent();
    });
</script>
<script type="text/javascript">
    $(function() {	

        $(".actoggle").on("click", function() {	

            toggleval = $(this).val();
            empid = $(this).attr('attribute2');
            dbname = $(this).attr('attribute3');

            pstoggleobj = $(this);

            $.ajax(
            {
                url: "<?php echo WEB; ?>/lib/requests/dtrman_request.php?sec=pstoggle",
                data: "toggleval=" + toggleval + "&empid=" + empid + "&dbname=" + dbname,
                type: "POST",
                complete: function(){
                    $("#loading").hide();
                },
                success: function(data) {
                    if (toggleval == 1) {
                        pstoggleobj.attr('attribute', 0);
                        pstoggleobj.removeClass('fa-times');
                        pstoggleobj.removeClass('redtext');
                        pstoggleobj.addClass('fa-check');
                        pstoggleobj.addClass('greentext');
                    }
                    else {
                        pstoggleobj.attr('attribute', 1);
                        pstoggleobj.removeClass('fa-check');
                        pstoggleobj.removeClass('greentext');
                        pstoggleobj.addClass('fa-times');
                        pstoggleobj.addClass('redtext');
                    }

                }
            })
        });

    });
</script>
<?php include(TEMP."/footer.php"); ?>