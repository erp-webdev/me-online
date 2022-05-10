<?php include(TEMP."/header.php"); ?>

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
                    <?php foreach ($acman_data as $key => $value) : ?>                                    
                    <tr class="cursorpoint trdata centertalign whitetext" attribute="<?php echo md5($value['EmpID']); ?>">
                        <td><?php echo $value['EmpID']; ?></td>
                        <td><?php echo $value['Fullname']; ?></td>
                        <td style="text-align: left"><input type="checkbox" class="actoggle" name="dtr" value="dtr" id="dtr" <?php if($value['Form'] == 'dtr') echo'checked'; ?>></td>
                        <td style="text-align: left"><input type="checkbox" class="actoggle" name="payslip" value="payslip" id="payslip" <?php if($value['Form'] == "payslip") echo'checked'; ?>></td>
                        <td style="text-align: left"><input type="checkbox" class="actoggle" name="requests" value="requests" id="requests" <?php if($value['Form'] == "requests") echo'checked'; ?>></td>
                        <td style="text-align: left"><input type="checkbox" class="actoggle" name="approvers" value="approvers" id="approvers" <?php if($value['Form'] == "approvers") echo'checked'; ?>></td>
                        <td style="text-align: left"><input type="checkbox" class="actoggle" name="activities" value="activities" id="activities" <?php if($value['Form'] == "activities") echo'checked'; ?>></td>
                        <td style="text-align: left"><input type="checkbox" class="actoggle" name="memo" value="memo" id="memo" <?php if($value['Form'] == "memo") echo'checked'; ?>></td>
                        <td style="text-align: left"><input type="checkbox" class="actoggle" name="ads" value="ads" id="ads" <?php if($value['Form'] == "ads") echo'checked'; ?>></td>
                        <td style="text-align: left"><input type="checkbox" class="actoggle" name="bday" value="bday" id="bday" <?php if($value['Form'] == "bday") echo'checked'; ?>></td>
                        <td style="text-align: left"><input type="checkbox" class="actoggle" name="wfh" value="wfh" id="wfh" <?php if($value['Form'] == "wfh") echo'checked'; ?>></td>
                        <td style="text-align: left"><input type="checkbox" class="actoggle" name="forms" value="forms" id="forms" <?php if($value['Form'] == "forms") echo'checked'; ?>></td>
                        <td style="text-align: left"><input type="checkbox" class="actoggle" name="access" value="access" id="access" <?php if($value['Form'] == "access") echo'checked'; ?>></td>
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

        $(".nebtoggle").on("click", function() {	

            toggleval = $(this).attr('attribute');
            empid = $(this).attr('attribute2');
            dbname = $(this).attr('attribute3');

            nebtoggleobj = $(this);

            $.ajax(
            {
                url: "<?php echo WEB; ?>/lib/requests/dtrman_request.php?sec=nebtoggle",
                data: "toggleval=" + toggleval + "&empid=" + empid + "&dbname=" + dbname,
                type: "POST",
                complete: function(){ 
                    $("#loading").hide();
                },
                success: function(data) {
                    if (toggleval == 1) {
                        nebtoggleobj.attr('attribute', 0);
                        nebtoggleobj.removeClass('fa-times');
                        nebtoggleobj.removeClass('redtext');
                        nebtoggleobj.addClass('fa-check');
                        nebtoggleobj.addClass('greentext');
                    }
                    else {
                        nebtoggleobj.attr('attribute', 1);
                        nebtoggleobj.removeClass('fa-check');
                        nebtoggleobj.removeClass('greentext');
                        nebtoggleobj.addClass('fa-times');
                        nebtoggleobj.addClass('redtext');
                    }

                }
            })
        });

        $(".aebtoggle").on("click", function() {	

            toggleval = $(this).attr('attribute');
            empid = $(this).attr('attribute2');
            dbname = $(this).attr('attribute3');

            aebtoggleobj = $(this);

            $.ajax(
            {
                url: "<?php echo WEB; ?>/lib/requests/dtrman_request.php?sec=aebtoggle",
                data: "toggleval=" + toggleval + "&empid=" + empid + "&dbname=" + dbname,
                type: "POST",
                complete: function(){
                    $("#loading").hide();
                },
                success: function(data) {
                    if (toggleval == 1) {
                        aebtoggleobj.attr('attribute', 0);
                        aebtoggleobj.removeClass('fa-times');
                        aebtoggleobj.removeClass('redtext');
                        aebtoggleobj.addClass('fa-check');
                        aebtoggleobj.addClass('greentext');
                    }
                    else {
                        aebtoggleobj.attr('attribute', 1);
                        aebtoggleobj.removeClass('fa-check');
                        aebtoggleobj.removeClass('greentext');
                        aebtoggleobj.addClass('fa-times');
                        aebtoggleobj.addClass('redtext');
                    }

                }
            })
        });
        
    });
</script>
<?php include(TEMP."/footer.php"); ?>