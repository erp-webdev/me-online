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
                        <th class="vertical">ACCESS</th>
                    </tr>
                    <?php foreach ($acman_data as $key => $value) : ?>                                    
                    <tr class="cursorpoint trdata centertalign whitetext" attribute="<?php echo md5($value['EmpID']); ?>">
                        <td><?php echo $value['EmpID']; ?></td>
                        <td><?php echo $value['Fullname']; ?></td>
                        <td style="text-align: left"><input type="checkbox" name="dtr" id="dtr" <?php ($value['Form'] == 'dtr') echo'checked'; ?>></td>
                        <td style="text-align: left"><input type="checkbox" name="payslip" id="payslip" <?php if($value['Form'] == "payslip") echo'checked'; ?>></td>
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
<?php include(TEMP."/footer.php"); ?>