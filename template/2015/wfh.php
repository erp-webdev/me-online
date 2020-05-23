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
										<table class="tdataform" border="0" cellspacing="0" width="100%">
											<tr>
												<td width="15%"><b>DTR Date: </b></td>
												<td width="85%"><input id="wfh_from_" type="text" name="wfh_from" value="<?php echo date('Y-m-d', strtotime("-1 days")); ?>" class="txtbox datepickwh" readonly ng-model="wfh_from"/> - <input id="wfh_to_" type="text" name="wfh_to" value="<?php echo date('Y-m-d', strtotime("-1 days")); ?>" class="txtbox datepickwh" readonly ng-model="wfh_to"/></td>
											</tr>
											<tr>
												<td width="100%" colspan="3">
													<div id="wfh" class="wfh">

														<table width="100%" class="tdata vsmalltext" border="0" cellspacing="0">
															<tr>
																<th width="15px"><span class="fa fa-trash-o"></span></th>
																<th width="80px">Date</th>
																<th width="40px">Credit</th>
																<th width="135px">Time</th>
																<th >Activities</th>
															</tr>
															<tr ng-repeat="wfh_day in wfh_days" id="tr{{ $index+1 }}">
																<td class="centertalign">
																	<input type="hidden" name="wfh_disable[{{ $index+1 }}]" id="wfh_disable{{ $index+1 	}}" value="0"><input id="mdtr_absent{{ $index+1 }}" type="checkbox" name="mdtr_absent[{{ $index+1 }}]" attribute="{{ $index+1 }}" class="mdtr_absent" ng-click="excludeFunction($index+1)" title="Excluded">
																</td>
																<td class="centertalign">
																	<span ng-bind="wfh_day.DTR | date: 'EEE MM/dd/yy'"></span> <br>
																</td>
																<td class="centertalign">
																	<strong><span ng-bind="wfh_day.CREDIT"></span></strong> hr
																	<input value="{{ wfh_day.CREDIT }}" id="wfh_totalworkedhours{{ $index+1 }}" type="hidden" name="wfh_totalworkedhours[{{ $index+1 }}]" attribute="{{ $index+1 }}" class="wfh_totalworkedhours txtbox">
																	<input id="wfh_dayin{{ $index+1 }}" type="hidden" name="wfh_dayin[{{ $index+1 }}]" value="{{ wfh_day.DTR | date: 'y-MM-dd'}}" class="wfh_dayin{{ $index+1 }}" />
																</td>
																<td class="centertalign" >
																	<table>
																		<tr ng-repeat="activity in wfh_day.ACTIVITIES">
																			<td style="border-bottom: 0px; margin: 0; padding: 0" >
																				<!-- PATTERN ([0-1]{1}[0-9]{1}|20|21|22|23):[0-5]{1}[0-9]{1}-([0-1]{1}[0-9]{1}|20|21|22|23):[0-5]{1}[0-9]{1} -->
																				<input type="text" id="start_time" ng-click="timePick($event)" attribute1="{{wfh_day.DTR}}" readonly title="Start Time: eg. 8:00" timepicker class="txtbox width55 wfh_time{{ $parent.$index+1 }} timepick_angular" ng-model="wfh_days[$parent.$index].ACTIVITIES[$index].start_time" data-dtr_index="{{ $parent.$index }}" required >
																				<input type="text" id="end_time" ng-click="timePick($event)" attribute1="{{wfh_day.DTR}}" readonly title="End Time: eg. 9:00" timepicker class="txtbox width55 wfh_time{{ $parent.$index+1 }} timepick_angular" data-dtr_index="{{ $parent.$index }}" ng-model="wfh_days[$parent.$index].ACTIVITIES[$index].end_time" required>
																				<br>
																				<label ng-show="$index == wfh_days[$parent.$index].ACTIVITIES.length - 1" title="When checked, credit hours will be deducted with 1 hour break time">
																					<input id="include_break{{ $index+1 }}" value="0" attribute1="{{ wfh_day.DTR }}" ng-click="includeFunction($event)" type="checkbox" name="include_break[{{ $index+1 }}]" attribute="{{ $index+1 }}" class="mdtr_absent"  > less 1 HR Break
																				</label>
																			</td>
																		</tr>
																	</table>
																</td>
																<td >
																	<textarea rows="1" style="display: none;" name="wfh_activity[{{ $index+1 }}]" id="wfh_activity{{ $index+1 }}"  class="txtbox"></textarea>
																	<table >
																		<tr ng-repeat="activity in wfh_day.ACTIVITIES">
																			<td style="border-bottom: 0px; margin: 0; padding: 0">
																				<textarea class="txtarea wfh_act{{ $parent.$index+1 }}" name="" id="" width="100%" rows="1" cols="43" ng-model="wfh_days[$parent.$index].ACTIVITIES[$index].act" required></textarea>
																			</td>
																			<td style="border-bottom: 0px; margin: 0; padding: 0; text-align:left">
																				<button style="" type="button" class="redbtn " ng-show="wfh_days[$parent.$index].ACTIVITIES.length > 1" ng-click="delItem($parent.$index, $index)"><i class="fa fa-trash-o"></i></button>
																				<button style="" type="button" class="smlbtn" ng-show="$index+1 == wfh_days[$parent.$index].ACTIVITIES.length" ng-click="addItem($parent.$index, $index)"><i class="fa fa-plus"></i></button>
																			</td>
																		</tr>
																	</table>
																	<span >&nbsp;</span>
																</td>
															</tr>
														</table>

													</div>
												</td>
											</tr>
											<tr>
												<td colspan="2">
													<i>* Maximum 7 days per application is allowed.</i>
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
		// wfh_app.directive('timepicker', function(){
		// 	return {
		// 		restrict: 'A',
		// 		link: function(scope, element, attrs){
		//
		// 			$('.timepick_angular').timepicker({
		// 					timeFormat: "hh:mmtt",
		// 	        stepHour: 1,
		// 	        stepMinute: 30,
		// 	        hourMin: 6,
		// 			    hourMax: 22
		// 			});
		// 		}
		// 	}
		// });
		wfh_app.controller('WFHController', function WFHController($scope){

			$scope.timePick = function($event){

				var date = angular.element($event.currentTarget).attr("attribute1");

				// $.ajax(
				// {
				// 	url: "<?php //echo WEB; ?>/lib/requests/app_request.php?sec=getshiftdtr",
				// 	data: "date=" + date,
				// 	type: "POST",
				// 	complete: function(){
				// 		$("#loading").hide();
				// 	},
				// 	success: function(data) {
				//
				// 		console.log(data);
				// 		data = JSON.parse(data);
				//
				// 		if(!(data == null)){
				// 			if(!(data.STARTTIME == null)){
				//
				// 				var start = parseInt(data.STARTTIME);
				// 				var end = parseInt(data.ENDTIME);
				//
				// 				angular.element($event.currentTarget).timepicker({
				// 						timeFormat: "hh:mmtt",
				// 						stepHour: 1,
				// 						stepMinute: 30,
				// 						hourMin: start,
				// 						hourMax: end
				// 				});
				//
				// 				angular.element($event.currentTarget).timepicker("show");
				// 			}
				// 		}
				//
				// 	}
				// });
				$scope.selectedTimePicker = ''; // start or end
				var getTimeOption = function(event){
					var opt = {
						timeFormat: "hh:mm tt",
						stepHour: 1,
						stepMinute: 15,
						hourMin: 0,
						hourMax: 23,
						defaultValue: null,
						minTime: null,
						maxTime: null,
					}

					activities = event.$parent.wfh_day.ACTIVITIES;
					if(event.$index == 0){
						if($($event.currentTarget).attr('id') == 'start_time'){
							if(event.activity.start_time == '')
								opt.defaultValue = '08:00 am';
							// opt.minTime = '';
						}else{
							if(event.activity.end_time == '')
								opt.minTime = event.activity.start_time;
						}

					}else{
						if($($event.currentTarget).attr('id') == 'start_time'){
							if(event.activity.start_time == '')
								opt.maxTime = event.$parent.wfh_day.ACTIVITIES[event.$index - 1].end_time;
						}else{
							if(event.activity.end_time == '')
								opt.minTime = event.activity.start_time;
						}
					}

					return opt;

				}

				angular.element($event.currentTarget).timepicker(getTimeOption(this));

				angular.element($event.currentTarget).timepicker("show");


			}

			$scope.excludeFunction = function(key){

				if($("#wfh_disable" + key).val() == 0){
					$("#wfh_disable" + key).val(1);
				}else{
					$("#wfh_disable" + key).val(0);
				}

				if($("#wfh_totalworkedhours" + key).prop("disabled")){
					$("#wfh_totalworkedhours" + key).prop("disabled", false);
				}else{
					$("#wfh_totalworkedhours" + key).prop("disabled", true);
				}

				if($("#wfh_activity" + key).prop("disabled")){
					$("#wfh_activity" + key).prop("disabled", false);
				}else{
					$("#wfh_activity" + key).prop("disabled", true);
				}

				$(".wfh_act" + key).each(function() {
					if($(this).prop("disabled")){
						$(this).prop("disabled", false);
					}else{
						$(this).prop("disabled", true);
					}
				});

				$(".wfh_time" + key).each(function() {
					if($(this).prop("disabled")){
						$(this).prop("disabled", false);
					}else{
						$(this).prop("disabled", true);
					}
				});

			}

			// $('.timepick_angular').timepicker({
			// 		timeFormat: "hh:mmtt",
			// 		stepHour: 1,
			// 		stepMinute: 30,
			// 		hourMin: 6,
			// 		hourMax: 22
			// });

			$scope.wfh_activity = [];
			$scope.item = {start_time : null, end_time : null, act: ''};
			$scope.wfh_from = new Date().toISOString().split("T")[0];
			$scope.wfh_from = new Date(angular.copy($scope.wfh_from));
			$scope.wfh_from.setDate($scope.wfh_from.getDate()-1);
			$scope.wfh_from = new Date(angular.copy($scope.wfh_from)).toISOString().split("T")[0];

			$scope.wfh_to = new Date().toISOString().split("T")[0];
			$scope.wfh_to = new Date(angular.copy($scope.wfh_to));
			$scope.wfh_to.setDate($scope.wfh_to.getDate()-1);
			$scope.wfh_to = new Date(angular.copy($scope.wfh_to)).toISOString().split("T")[0];

			$scope.date_original = $scope.wfh_to;

			$scope.wfh_days = [];



			function compare(a, b) {
				// Use toUpperCase() to ignore character casing
				const DTRa = a.DTR.toUpperCase();
				const DTRb = b.DTR.toUpperCase();

				let comparison = 0;
				if (DTRa > DTRb) {
					comparison = 1;
				} else if (DTRa < DTRb) {
					comparison = -1;
				}
				return comparison;
			}

			// function to validate from and to dates
			$scope.$watchGroup(['wfh_from', 'wfh_to'], function(newVal, oldVal){

				if(newVal[0] == oldVal[0] && newVal[1] != oldVal[1]){
					// if wfh_to has been changed
					if(new Date(newVal[1]) < new Date($scope.wfh_from)){
						// if wfh_to is less than wfh_from
						$scope.wfh_from = newVal[1];
					}

				}else if(newVal[0] != oldVal[0] && newVal[1] == oldVal[1]){
					// if wfh_from has been changed
					$scope.wfh_to = new Date(angular.copy($scope.wfh_from));
					$scope.wfh_to.setDate($scope.wfh_to.getDate()+6);
					$scope.wfh_to = new Date(angular.copy($scope.wfh_to)).toISOString().split("T")[0];

					if($scope.date_original < $scope.wfh_to){
						$scope.wfh_to = $scope.date_original;
					}


					if(new Date(newVal[0]) > new Date($scope.wfh_to)){
						$scope.wfh_to = newVal[0];
					}


				}

				$("#wfh_from_").change(function() {

					mfrom = $("#wfh_from_").val();
					mto = $("#wfh_to_").val();

					if (mfrom && mto) {

						$.ajax(
						{
							url: "<?php echo WEB; ?>/lib/requests/app_request.php?sec=gettrueto3",
							data: "from=" + mfrom,
							type: "POST",
							complete: function(){
								$("#loading").hide();
							},
							success: function(data) {

								if($scope.date_original < data){
									data = $scope.date_original;
								}

								$('#wfh_to_').datetimepicker('destroy');
								$('#wfh_to_').datepicker({
									dateFormat: 'yy-mm-dd',
									minDate: mfrom,
									maxDate: data
								});
			          $('#wfh_to_').val(data);
								$('#wfh_to_').attr("value", data);
							}
						})

					}
				});

				$scope.current_date = new Date(angular.copy($scope.wfh_from));
				// delete Dates not included
				if($scope.wfh_days.length > 0){
					if(new Date($scope.wfh_from ) > new Date($scope.wfh_days[0].DTR) ){
						var dtrdate = $scope.current_date.toISOString().split("T")[0];
						var index = -1;
						for(var j = 0; j < $scope.wfh_days.length; j++)				{
							if($scope.wfh_days[j].DTR == dtrdate){
								index = j;
							}
						}
						$scope.wfh_days.splice(0, index);
					}

					if(new Date($scope.wfh_to ) < new Date($scope.wfh_days[$scope.wfh_days.length-1].DTR) ){
						var dtrdate = new Date(angular.copy($scope.wfh_to)).toISOString().split("T")[0];
						var index = -1;
						for(var j = 0; j < $scope.wfh_days.length; j++)				{
							if($scope.wfh_days[j].DTR == dtrdate){
								index = j;
							}
						}
						$scope.wfh_days.splice(index + 1, $scope.wfh_days.length - index + 1 );
					}

				}

				while($scope.current_date <= new Date(angular.copy($scope.wfh_to))){

					var dtrdate = $scope.current_date.toISOString().split("T")[0];
					var index = -1;
					for(var j = 0; j < $scope.wfh_days.length; j++)				{
						if($scope.wfh_days[j].DTR == dtrdate){
							index = j;
						}
					}

					if(index == -1){
						var dtr = {
							"DTR" : dtrdate,
							"ACTIVITIES" : [
								angular.copy($scope.item)
							],
							"CREDIT":0,
							"BREAKTIME":0
						}

						$scope.wfh_days.push( dtr );
					}

					$scope.current_date.setDate($scope.current_date.getDate()+1);
				}

				var sort = (angular.copy($scope.wfh_days)).sort(compare);
				$scope.wfh_days = sort;

			});

			$scope.includeFunction = function($event){

				var breaktime = angular.element($event.currentTarget).val();
				var date = angular.element($event.currentTarget).attr("attribute1");

				if(breaktime == 0){
					breaktime = 1;
				}else{
					breaktime = 0;
				}

				angular.element($event.currentTarget).val(breaktime);

				var days_data = JSON.stringify($scope.wfh_days);
				days_data = JSON.parse(days_data);

				angular.forEach(days_data, function(value, key){
					if(value.DTR == date){
						value.BREAKTIME = breaktime;
					}
				});
				$scope.wfh_days = days_data;

				console.log($scope.wfh_days);
			}


			$scope.$watch('wfh_days', function(newVal, oldVal, $scope){
				// has an duplicate computation of hours
				// ex: 8am - 12am = 4hrs
				//     9am - 10am = 1hr 
				//     4hrs + 1hr = 5 hrs where it should be 4hrs bec 9am - 10 am is included within 8am - 12am

				// to compute total credit hours
				var days_data = JSON.stringify($scope.wfh_days);
				days_data = JSON.parse(days_data);

				angular.forEach(days_data, function(value, key){

					var daytime_total = 0;
					angular.forEach(value.ACTIVITIES, function (value, key){
						if(value.start_time == null)
							value.start_time = '';

						var start = value.start_time.substr(0,5);
						var start_type = value.start_time.substr(6,2);
						var time1 =  new Date("01/01/2007 " + start + " " + start_type).getHours() ;

						if(value.end_time == null)
							value.end_time = '';

						var end = value.end_time.substr(0,5);
						var end_type = value.end_time.substr(6,2);
						var time2 =new Date("01/01/2007 " + end + " " + end_type).getHours();

						var time_diff = time2 - time1;
						if(time_diff < 0){
							time_diff = 0;
						}
						daytime_total = (daytime_total + time_diff);

					});
					
					var credit_total = daytime_total - value.BREAKTIME;
					if(credit_total < 0){
						credit_total = 0;
					}
					value.CREDIT = credit_total;

				});

				$scope.wfh_days = days_data;
				
				// for(var i = 0; i < $scope.wfh_days.length; i++){
				// 	$('#wfh_activity'+eval(i+1)).text(JSON.stringify($scope.wfh_days[i].activity));
				// }


				/* computation of credited hours */
				
			}, true);

			// Add new activity item
			$scope.addItem = function(index, act){
				$scope.wfh_days[index].ACTIVITIES.push( 
					{start_time : $scope.wfh_days[index].ACTIVITIES[act].end_time, end_time : null, act: ''}
				);

			}

			// Remove item
			$scope.delItem = function(index, act){
				$scope.wfh_days[index].ACTIVITIES.splice(act, 1);
			}

		});
	});

</script>
<?php include(TEMP."/footer.php"); ?>
