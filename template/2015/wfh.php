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

									<div id="ldetails"  ng-app="WFHApp" ng-controller="WFHController">
										<table class="tdataform" border="0" cellspacing="0">
											<tr>
												<td width="15%"><b>DTR Date: </b></td>
												<td width="85%"><input id="wfh_from_" type="text" name="wfh_from" value="<?php echo $wfh_fdate; ?>" class="txtbox datepickwh" readonly ng-model="wfh_from"/> - <input id="wfh_to_" type="text" name="wfh_to" value="<?php echo $wfh_todate; ?>" class="txtbox datepickwh" readonly ng-model="wfh_to"/></td>
											</tr>
											<tr>
												<td width="100%" colspan="3">
													<div id="wfh" class="wfh">

														<table width="100%" class="tdata vsmalltext" border="0" cellspacing="0">
															<tr>
																<th width="15px">#</th>
																<th width="15px">Exclude</th>
																<th width="100px">Date</th>
																<th width="60px">Total Worked Hours</th>
																<th width="">Activities</th>
															</tr>
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
															<tr ng-repeat="wfh_day in wfh_days" id="tr{{ $index+1 }}">
																<td class="centertalign">{{ $index+1 }}</td>
																<td class="centertalign">
																	<input type="hidden" name="wfh_disable[{{ $index+1 }}]" id="wfh_disable{{ $index+1 }}" value=0><input id="mdtr_absent{{ $index+1 }}" type="checkbox" name="mdtr_absent[{{ $index+1 }}]" attribute="{{ $index+1 }}" class="mdtr_absent">
																</td>
																<td class="centertalign">
																	{{ $wfh_day | date: "E MM/dd/yy"}}
																	<input id="wfh_dayin{{ $index+1 }}" type="hidden" name="wfh_dayin[{{ $index+1 }}]" value="{{ $wfh_day | date: 'y-MM-dd'}}" class="wfh_dayin{{ $index+1 }}" />
																</td>
																<td class="centertalign">
																	<input style="width: 100%" id="wfh_totalworkedhours{{ $index+1 }}" type="number" name="wfh_totalworkedhours[{{ $index+1 }}]" attribute="{{ $index+1 }}" class="wfh_totalworkedhours">
																</td>
																<td class="centertalign" >
																	<textarea rows="1" style="display:none" name="wfh_activity[{{ $index+1 }}]" id="wfh_activity{{ $index+1 }}" class="txtbox"></textarea>
																	<table>
																		<tr ng-repeat="activity in wfh_activity{{ $index+1 }}">
																			<td style="border-bottom: 0px; margin: 0; padding: 0" >
																				<input id="asd{{ $index }}" type="text" class="txtbox width80" ng-model="wfh_activity{{ $index+1 }}[$index].time">
																			</td>
																			<td style="border-bottom: 0px; margin: 0; padding: 0" width="150px">
																				<textarea class="txtarea" name="" id="" cols="30" rows="1" ng-model="wfh_activity{{ $index+1 }}[$index].act" ng-click="check()"></textarea>
																			</td>
																			<td style="border-bottom: 0px; margin: 0; padding: 0; text-align:left" width="120px">
																				<button style="" type="button" class="smlbtn" ng-show="$index+1 == wfh_activity{{ $index+1 }}.length" ng-click="addItem('wfh_activity{{ $index+1 }}')">Add</button>
																				<button style="" type="button" class="redbtn " ng-show="wfh_activity{{ $index+1 }}.length > 1" ng-click="delItem('wfh_activity{{ $index+1 }}', $index)">Del</button>
																			</td>
																		</tr>
																	</table>
																</td>
															</tr>
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
			// Dates
			$scope.wfh_from = Date.now();
			$scope.wfh_to = Date.now();
			$scope.wfh_days = [];
			$scope.$watchGroup(['wfh_from', 'wfh_to'], function(newVal, oldVal){
				$scope.wfh_days = [];
				var current_date =$scope.wfh_from;
				while(current_date <= $scope.wfh_to){

					$scope.wfh_days.push(current_date);
					current_date.addDays(1);

				}
			})

			// Activities and Items
			$scope.item = {time : '', act: ''};
			
			<?php $key = 1; $wfh_from = $wfh_from_original; while($wfh_from <= $wfh_today) { ?>

			$scope.wfh_activity<?php echo $key; ?> = [];
			$scope.wfh_activity<?php echo $key; ?>.push(angular.copy($scope.item));

			$scope.$watch('wfh_activity<?php echo $key; ?>', function(newValue, oldValue, scope){
				$('#wfh_activity<?php echo $key; ?>').text( JSON.stringify(newValue) );
				console.log(JSON.stringify(newValue));
			}, true);

			<?php $key++;  $wfh_from = strtotime("+1 day", $wfh_from); } ?>

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
