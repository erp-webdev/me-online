<!-- BODY -->
<div id="mainsplashtext" class="mainsplashtext lefttalign">
	<div class="topsplashtext lefttalign robotobold cattext whitetext"><?php echo WELCOME; ?></div>
	<div class="leftsplashtext lefttalign"><?php include(TEMP."/menu.php"); ?></div>
	<div class="rightsplashtext lefttalign">
		<div id="mainwfh" class="mainbody lefttalign whitetext">
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
			<?php if(!$wfh_user[0]["end_date"]){ ?>
			<div class="mleave_msg" style="padding: 10px; text-align: center; color: rgb(156, 0, 6); background: rgb(255, 199, 206);
			border: 2px solid rgb(156, 0, 6); height: auto; display: block;">
                You have no access to WFH Application. Please submit a WFH clearance and provide necessary attachment for approval.
            </div>
			<?php } ?>
			
			<form id="frmapplywd" name="frmapplywd" action="?ignore-page-cache=true" method="post" enctype="multipart/form-data">
				<div id="tabs">
					<ul>
						<li><a href="#ldetails">Details</a></li>
						<li><a href="#lapprover">Approvers</a></li>
					</ul>

					<div id="ldetails"  ng-app="WFHApp" ng-controller="WFHController">
						<table class="tdataform" border="0" cellspacing="0" width="100%">
                            <tr>
								<td width="25%"><b>Type</b></td>
								<td width="75%">
                                    <select name="wfh_type" id="wfh_type" class="txtbox width95per">
                                        <option value="sickness"  selected>Sickness / Illness</option>
                                        <!-- <option value="regular">Regular Work</option> -->
                                    </select>
                                </td>
							</tr>
							<tr>
								<td width="25%"><b>Covered Period: </b></td>
								<td width="75%">
                                    <input id="wfh_from_" type="text" name="wfh_from" attribute1="<?php echo $limit_from; ?>" value="" class="txtbox datepickwh_" readonly ng-model="wfh_from"/> - <input id="wfh_to_" attribute1="<?php echo $limit_from; ?>" type="text" name="wfh_to" value="" class="txtbox datepickwh_" readonly ng-model="wfh_to"/>
                                </td>
							</tr>
                            <tr>
								<td width="25%"><b>Reason: </b></td>
								<td width="75%">
                                    <textarea name="reason" id="reason" cols="30" rows="10" class="txtarea width95per"></textarea>
                                </td>
							</tr>
						</table>
						<br><br>
					</div>
					<div id="lapprover">
						<?php if ($wh_app) : ?>
						<?php foreach($wh_app as $key => $value) : ?>
							<?php if ($key < 7) : ?>
							<b>Level <?php echo $key; ?>:</b> <?php echo trim($value[0]) ? $value[0] : '-- NOT SET --'; ?> <input type="hidden" name="approver<?php echo $key; ?>" value="<?php echo $value[1]; ?>" /><input type="hidden" name="dbapprover<?php echo $key; ?>" value="<?php echo $value[2]; ?>" /><br>
							<?php endif; ?>
						<?php endforeach; ?>
						<?php else : ?>
							No approvers has been set
						<?php endif; ?>
					</div>
				</div>
				<div class="righttalign">
					<?php
						$microsec = microtime();
						$micsec = explode(' ', $microsec);
						$finsec = str_replace('.', '', $micsec[1].$micsec[0]);
					?>
					<input id="ndays" type="hidden" name="ndays" value="<?php echo $dayn; ?>" />
					<input type="hidden" name="empid" value="<?php echo $profile_idnum; ?>" />
					<input type="hidden" name="reqnbr" value="<?php echo "WC-".$finsec; ?>" />
					<input type="hidden" name="user" value="<?php echo $profile_idnum; ?>" />
					<input id="btnwfhapply" type="submit" name="btnwfhapply" value="Submit" class="btn margintop10" />
					<a href="<?php echo WEB; ?>/pending"><input type="button" onClick="localStorage.removeItem('wfh-entries');" name="btncancel" value="Cancel" class="redbtn margintop10" /></a>
				</div>

			</form>
		</div>
	</div>
</div>

<script>

	$(document).ready(function () {

		$(".datepickwh_").datepicker({
	        dateFormat: 'yy-mm-dd',
	        minDate: "<?php echo $limit_from; ?>",
	        maxDate: "<?php echo $limit_to; ?>",
	        changeMonth: true,
	        changeYear: true
	    });

	});

</script>