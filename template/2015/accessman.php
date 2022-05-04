<?php include(TEMP."/header.php"); ?>

<div id="mainsplashtext" class="mainsplashtext lefttalign">  
    <div class="topsplashtext lefttalign robotobold cattext whitetext"><?php echo WELCOME; ?></div>
    <div class="leftsplashtext lefttalign"><?php include(TEMP."/menu.php"); ?></div>
    <div class="rightsplashtext lefttalign">
        <div id="mainapprovers" class="mainbody lefttalign whitetext">  
            <b class="mediumtext lorangetext">ACCESS MANAGEMENT</b><br><br>                                
            
            <table class="width100per">
                <tr>
                    <td><span class="fa fa-search"></span> Search: 
                        <input type="text" id="searchpsman" name="searchpsman" value="<?php echo $_SESSION['searchpsman'] ? $_SESSION['searchpsman'] : ''; ?>" placeholder="by <?php echo $profile_nadd; ?> ID, lastname or firstname" class="smltxtbox width250" />&nbsp;
                        <input type="button" id="btnpsman" name="btnpsman" value="Search" class="smlbtn" />
                        <input type="button" id="btnpsmanall" name="btnpsmanall" value="View All" class="smlbtn<?php if (!$_SESSION['searchpsman']) : ?> invisible<?php endif; ?>" />                                            
                    </td>
                    <td class="righttalign">
                        <!--input type="button" id="btnread" name="btnread" value="Mark as Read" class="smlbtn btnred" />
                        <input type="button" id="btnunread" name="btnunread" value="Mark as Unread" class="smlbtn btnred" /-->                            
                    </td>
                </tr>
            </table>
            <script>
                (function ($) {
                    $.fn.rotateTableCellContent = function (options) {
                    /*
                    Version 1.0
                    7/2011
                    Written by David Votrubec (davidjs.com) and
                    Michal Tehnik (@Mictech) for ST-Software.com
                    */

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

                    newInnerDiv.css('-webkit-transform-origin', (width / 2) + 'px ' + (width / 2) + 'px');
                    newInnerDiv.css('-moz-transform-origin', (width / 2) + 'px ' + (width / 2) + 'px');
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
            <style>
                /* Styles for rotateTableCellContent plugin*/
                table div.rotated {
                    -webkit-transform: rotate(270deg);
                    -moz-transform: rotate(270deg);
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
                    <?php if ($emp_data || true) : ?>
                    <tr>
                        <th width="15%">EmpID</th>
                        <th width="23%">Name</th>
                        <th width="" class="vertical">DTR</th>
                        <th width="" class="vertical">PAYSLIP</th>
                        <th width="" class="vertical">REQUESTS</th>
                        <th width="" class="vertical">APPROVERS</th>
                        <th width="" class="vertical">ACTIVITIES</th>
                        <th width="" class="vertical">MEMO</th>
                        <th width="" class="vertical">ADS</th>
                        <th width="" class="vertical">BIRTHDAY</th>
                    </tr>
                    <?php foreach ($emp_data as $key => $value) : ?>                                    
                    <tr class="btnempdata cursorpoint trdata centertalign whitetext" attribute="<?php echo md5($value['EmpID']); ?>">
                        <td><?php echo $value['EmpID']; ?></td>
                        <td><?php echo $value['LName']; ?></td>
                        <td><?php echo $value['FName']; ?></td>
                        <td><?php echo $value['PositionDesc']; ?></td>
                        <td><?php echo $value['DeptDesc']; ?></td>
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

<?php include(TEMP."/footer.php"); ?>