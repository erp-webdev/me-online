<div id="floatdiv" class="floatdiv ">                                        
    <div id="adview" class="fview" style="">
        <div class="closebutton cursorpoint" style=""><i class="fa fa-times-circle fa-3x redtext"></i></div>
        <div id="clearance" class="floatdata margintop15" style="margin: auto">
            <div id="adview_title" class="robotobold cattext dbluetext" style="text-align:center">Clearance Application</div>
            <p>In line with your separation effective <b><?php echo date('j F Y', strtotime($clearance[0]['SeparationDate'])); ?></b>, you are hereby requested to complete the details for your Clearance Application. Please ensure that details are correct to avoid errors in the process. You will also be notified through your personal email once the clearance process has started.</p>
            <table class="tdataform2 rightmargin margintop10 vsmalltext" width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="150px"><b>EmpID</b></td>
                    <td><?php echo $clearance[0]['EmpID']; ?>
                        <input id="empid" type="hidden" name="empid" value="<?php echo $clearance[0]['EmpID']; ?>" />
                        <input id="empiddb" type="hidden" name="empiddb" value="<?php echo $clearance[0]['DBNAME']; ?>" />
                    </td>
                </tr>
                <tr>
                    <td><b>FullName</b></td>
                    <td><?php echo $profile_full; ?></td>
                </tr>
                <tr>
                    <td><b>Separation Date</b></td>
                    <td><?php echo date('j F Y', strtotime($clearance[0]['SeparationDate'])); ?></td>
                </tr>
                <tr>
                    <td><b>Personal Email*</b></td>
                    <td>
                    <input id="personalemail" type="text" name="personalemail" placeholder="Personal Email..." class="txtbox width95per marginbottom10" required/>
                    </td>
                </tr>
                <tr>
                    <td><b>Contact Number/s*</b></td>
                    <td>
                    <input id="contactno" type="text" name="contactno" placeholder="Contact Number..." class="txtbox width95per marginbottom10" required/>
                    </td>
                </tr>
                <tr>
                    <td><b>Permanent Address*</b></td>
                    <td>
                    <input id="permanentadd" type="text" name="permanentadd" placeholder="Permanent Address..." class="txtbox width95per marginbottom10" required/>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                    <p>Please ensure that you have provided a valid personal email address. You will be notified when your clearance have started.</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><button class="btn btnSaveClearance">Submit</button></td>
                </tr>
            </table>
            
        </div>
    </div>
</div>
<script type="text/javascript">
$(function() {	

    $(".btnSaveClearance").on("click", function() {	
        var r = confirm("This action cannot be UNDONE. Are you sure you want to submit the clearance application?");

        if(!r)
            return;

        $("#loading").show();

        var empid = $('#empid').val();
        var empiddb = $('#empiddb').val();
        var personalemail = $('#personalemail').val();
        var contactno = $('#contactno').val();
        var permanentadd = $('#permanentadd').val();

        pstoggleobj = $(this);

        $.ajax(
        {
            url: "<?php echo WEB; ?>/lib/requests/clearance_request.php?sec=update",
            data: "&empid=" + empid 
                + "&empiddb=" + empiddb
                + "&personalemail=" + personalemail
                + "&contactno=" + contactno
                + "&permanentadd=" + permanentadd,
            type: "POST",
            complete: function(){
                $("#loading").hide();
            },
            success: function(data) {
                window.location.reload();
            }
        })
    });

});
</script>