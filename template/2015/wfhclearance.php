<?php include(TEMP."/header.php"); ?>

<!-- BODY -->
<div id="mainsplashtext" class="mainsplashtext lefttalign">
	<div class="topsplashtext lefttalign robotobold cattext whitetext"><?php echo WELCOME; ?></div>
	<div class="leftsplashtext lefttalign"><?php include(TEMP."/menu.php"); ?></div>
	<div class="rightsplashtext lefttalign">
		<div id="mainwfhc" class="mainbody lefttalign whitetext">
			<b class="mediumtext lorangetext">Work From Home Clearance</b> <small><i></i></small><br><br>
			<b>MAIN INFORMATION</b><br><br>
			<div class="column2">
				<b><?php echo ucfirst($profile_nadd); ?> ID: </b><?php echo $profile_idnum; ?><br>
				<b>Name: </b><?php echo $profile_full; ?><br>
				<b>Position: </b><?php echo $profile_pos; ?><br>
				<b>Status: </b>Open<br>
				<b>Department: </b><?php echo $profile_dept; ?><br>
			</div><br>

			<div id="alert"></div>
			
			<form id="frmapplywd" name="frmapplywd" action="?ignore-page-cache=true" method="post" enctype="multipart/form-data">
				<div id="tabs">
					<ul>
						<li><a href="#ldetails">Details</a></li>
                        <li><a href="#lattach">Attachments</a></li>
						<li><a href="#lapprover">Approvers</a></li>
					</ul>

					<div id="ldetails"  >
						<table class="tdataform" border="0" cellspacing="0" width="100%">
                            <tr>
								<td width="25%"><b>Type</b></td>
								<td width="75%">
                                    <select name="wfh_type" id="wfh_type" class="txtbox width95per">
                                        <?php foreach($wfh_clearance->getTypes() as $key=>$type) : ?>
                                        	<option value="<?php echo $key; ?>"><?php echo $type; ?></option>
										<?php endforeach; ?>
                                    </select>
                                </td>
							</tr>
							<tr>
								<td width="25%"><b>Covered Period: </b></td>
								<td width="75%">
                                    <input id="wfhc_from_" type="text" name="wfhc_from" value="" class="txtbox datepickwh_" readonly /> - <input id="wfhc_to_"  type="text" name="wfhc_to" value="" class="txtbox datepickwh_" readonly/>
                                </td>
							</tr>
                            <tr>
								<td width="25%"><b>Reason: </b></td>
								<td width="75%">
                                    <textarea name="reason" id="reason" cols="30" rows="4" class="txtarea width95per"></textarea>
                                </td>
							</tr>
						</table>
						<br><br>
					</div>
					<div id="lapprover">
						<?php if ($wfhc_app) : ?>
						<?php foreach($wfhc_app as $key => $value) : ?>
							<?php if ($key < 7) : ?>
							<b>Level <?php echo $key; ?>:</b> <?php echo trim($value[0]) ? $value[0] : '-- NOT SET --'; ?> <input type="hidden" name="approver<?php echo $key; ?>" value="<?php echo $value[1]; ?>" /><input type="hidden" name="dbapprover<?php echo $key; ?>" value="<?php echo $value[2]; ?>" /><br>
							<?php endif; ?>
						<?php endforeach; ?>
						<?php else : ?>
							No approvers has been set
						<?php endif; ?>
					</div>
                    <div id="lattach">
                        <input id="attachment1" type="file" name="attachment1" class="whitetext" /><br>
                        <input id="attachment2" type="file" name="attachment2" class="whitetext" /><br>
                        <input id="attachment3" type="file" name="attachment3" class="whitetext" /><br>
                        <input id="attachment4" type="file" name="attachment4" class="whitetext" /><br>
                        <input id="attachment5" type="file" name="attachment5" class="whitetext" />
                        <br><br>
                        <i>* it must be PDF or image (JPG or GIF) and not more than 200Kb each</i>
                    </div>
				</div>
				<div class="righttalign">
					<?php
						$ref = substr($profile_idnum, 8);
						$ref .= date('U'); 
					?>
					<input type="hidden" name="empid" value="<?php echo $profile_idnum; ?>" />
					<input type="hidden" name="reqnbr" value="<?php echo "WC".$ref; ?>" />
					<input type="hidden" name="user" value="<?php echo $profile_idnum; ?>" />
					<input id="btnwfhclearanceapply" type="submit" name="btnwfhclearanceapply" value="Submit" class="btn margintop10" />
					<a href="<?php echo WEB; ?>/pending"><input type="button"  name="btncancel" value="Cancel" class="redbtn margintop10" /></a>
				</div>

			</form>
		</div>
	</div>
</div>

<script>

	$(document).ready(function () {

		$(".datepickwh_").datepicker({
	        dateFormat: 'yy-mm-dd',
	        // minDate: "<?php echo $limit_from; ?>",
	        // maxDate: "<?php echo $limit_to; ?>",
	        changeMonth: true,
	        changeYear: true
	    });

	});

</script>

<?php include(TEMP."/footer.php"); ?>
