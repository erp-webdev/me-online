<?php include(TEMP."/header.php"); ?>

<!-- BODY -->

				<div id="mainsplashtext" class="mainsplashtext lefttalign">
					<div class="topsplashtext lefttalign robotobold cattext whitetext"><?php echo WELCOME; ?></div>
					<div class="leftsplashtext lefttalign"><?php include(TEMP."/menu.php"); ?></div>
					<div class="rightsplashtext lefttalign">
						<div id="mainwfh" class="mainbody lefttalign whitetext">
							<b class="mediumtext lorangetext">Work From Home</b><br><br>
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
										<li><a href="#lapprover">Approvers</a></li>
									</ul>

									<div id="ldetails">
										<table class="tdataform" border="0" cellspacing="0">
											<tr>
												<td width="15%"><b>DTR Date: </b></td>
												<td width="85%"><input id="wfh_from" type="text" name="wfh_from" value="<?php echo $wfh_fdate; ?>" class="txtbox datepickwh" readonly /> - <input id="wfh_to" type="text" name="wfh_to" value="<?php echo $wfh_todate; ?>" class="txtbox datepickwh" readonly /></td>
											</tr>
											<tr>
												<td width="100%" colspan="3">
													<div id="wfh" class="wfh">

														<table width="100%" class="tdata vsmalltext" border="0" cellspacing="0">
															<tr>
																<th width="30px">#</th>
																<th width="30px">Exclude</th>
																<th width="100px">Date</th>
																<th width="60px">Total Worked Hours</th>
																<th width="">Activities</th>
															</tr>

															<?php

																$key = 1;

																$shiftsched = $mainsql->get_schedshift($profile_idnum);
																$shiftlist = $mainsql->get_shift();

																while($wfh_from <= $wfh_today) {

																	$udate = date("U", $wfh_from);
																	$dates = date("Y-m-d", $wfh_from);
																	$days = date("D m/d/y", $wfh_from);
																	$numdays = intval(date("N", $wfh_from));
																	$dtr_data = $mainsql->get_dtr_bydate($profile_idnum, date("m/d/Y", $udate));

																	$shiftsched2 = $mainsql->get_schedshiftdtr($profile_idnum, $dates);
																	$sft = $mainsql->get_shift($shiftsched2[0]['ShiftID']);

																	$dtimein = trim($dtr_data[0]['TimeIN']);
																	$dtimeout = trim($dtr_data[0]['TimeOut']);

																	$timein = date('h:ia', strtotime($sft[0]['TimeIN']));
																	$timeout = date('h:ia', strtotime($sft[0]['TimeOUT']));

																	$datein = strtotime($dates.' '.$timein);
																	$dateout = strtotime($dates.' '.$timeout);

																	$totaltime = $dateout - $datein;

																	?>

<script>
$(function() {

	$("#mdtr_absent<?php echo $key; ?>").change(function() {

		arrayid = $(this).attr('attribute');

		if($("#wfh_disable" + arrayid).val() == 0){
			$("#wfh_disable" + arrayid).val(1);
		}else{
			$("#wfh_disable" + arrayid).val(0);
		}



		if($("#wfh_totalworkedhours" + arrayid).prop("disabled")){
			$("#wfh_totalworkedhours" + arrayid).prop("disabled", false);
		}else{
			$("#wfh_totalworkedhours" + arrayid).prop("disabled", true);
		}

		if($("#wfh_activity" + arrayid).prop("disabled")){
			$("#wfh_activity" + arrayid).prop("disabled", false);
		}else{
			$("#wfh_activity" + arrayid).prop("disabled", true);
		}

	});

});



</script>



																	<tr id="tr<?php echo $key; ?>">
																		<td class="centertalign"><?php echo $key; ?></td>
																		<td class="centertalign"><input type="hidden" name="wfh_disable[<?php echo $key; ?>]" id="wfh_disable<?php echo $key; ?>" value=0><input id="mdtr_absent<?php echo $key; ?>" type="checkbox" name="mdtr_absent[<?php echo $key; ?>]" attribute="<?php echo $key; ?>" class="mdtr_absent"></td>
																		<td class="centertalign">
																			<?php echo $days; ?>
																			<input id="wfh_dayin<?php echo $key; ?>" type="hidden" name="wfh_dayin[<?php echo $key; ?>]" value="<?php echo $dates; ?>" class="wfh_dayin<?php echo $key; ?>" />
																		</td>
																		<td class="centertalign"><input style="width: 100%" id="wfh_totalworkedhours<?php echo $key; ?>" type="number" name="wfh_totalworkedhours[<?php echo $key; ?>]" attribute="<?php echo $key; ?>" class="wfh_totalworkedhours"></td>
																		<td class="centertalign" >
																			<textarea rows="1" style="" name="wfh_activity[<?php echo $key; ?>]" id="wfh_activity<?php echo $key ?>" class="txtbox"></textarea>
																			<table ng-app="WFHApp" ng-controller="WFHController">
																				<tr ng-repeat="activity in wfh_activity<?php echo $key ?>">
																					<td style="border-bottom: 0px; margin: 0; padding: 0" width="30px">
																						<input type="text" class="txtbox width80 " ng-model="wfh_activity<?php echo $key ?>[$index].time">
																					</td>
																					<td style="border-bottom: 0px; margin: 0; padding: 0" width="150px"><textarea class="txtarea" name="" id="" cols="30" rows="1" ng-model="wfh_activity<?php echo $key ?>[$index].act" ng-click="check()"></textarea></td>
																					<td style="border-bottom: 0px; margin: 0; padding: 0" width="30px"><button style="" type="button" class="smlbtn" ng-show="$index+1 == wfh_activity<?php echo $key ?>.length" ng-click="addItem('wfh_activity<?php echo $key ?>')">Add</button><button style="" type="button" class="redbtn smlbtn" ng-show="$index == 0" ng-click="delItem('wfh_activity<?php echo $key ?>', $index)">Del</button></td>
																				</tr>
																				
																			</table>
																		</td>
																	</tr>

																	<?php
																	$key++;

																	$wfh_from = strtotime("+1 day", $wfh_from);
																}

															?>
														</table>
													</div>
												</td>
											</tr>
											<tr>
												<td colspan="2">
													<i>* If there's something wrong with date or time represent within this application, please check your DTR first</i>
												</td>
											</tr>
										</table>
										<br><br>
									</div>
									<div id="lapprover">
										<?php if ($wh_app) : ?>
										<?php foreach($wh_app as $key => $value) : ?>
											<?php if ($key < 6) : ?>
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
									<input type="hidden" name="reqnbr" value="<?php echo "MD-".$finsec; ?>" />
									<input type="hidden" name="user" value="<?php echo $profile_idnum; ?>" />
									<input id="btnwfhapply" type="submit" name="btnwfhapply" value="Submit" class="btn margintop10" />
									<a href="<?php echo WEB; ?>/pending"><input type="button" name="btncancel" value="Cancel" class="redbtn margintop10" /></a>
								</div>

							</form>

						</div>
					</div>
				</div>
	
<script>

$(document).ready(function () {
	var wfh_app = angular.module('WFHApp', []);
	wfh_app.controller('WFHController', function WFHController($scope){
		
		$scope.item = {time : '', act: ''};

		$scope.wfh_activity1 = [];
		$scope.wfh_activity1.push(angular.copy($scope.item));

		$scope.$watch('wfh_activity1', function(newValue, oldValue, scope){
			$('#wfh_activity1').text( JSON.stringify(newValue) );
			console.log(JSON.stringify(newValue));
		}, true);

		// Add new activity item
		$scope.addItem = function(act){
			$scope[act].push(angular.copy($scope.item));
		}

		// Remove item
		$scope.delItem = function(act, index){
			$scope[act].splice(index, 1);
		}

	});
});

</script>
<?php include(TEMP."/footer.php"); ?>
