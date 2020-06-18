<?php include(TEMP."/header.php"); ?>

<!-- BODY -->

				<div id="mainsplashtext" class="mainsplashtext lefttalign">
					<div class="topsplashtext lefttalign robotobold cattext whitetext"><?php echo WELCOME; ?></div>
					<div class="leftsplashtext lefttalign"><?php include(TEMP."/menu.php"); ?></div>
					<div class="rightsplashtext lefttalign">
						<div id="mainwfh" class="mainbody lefttalign whitetext">
							<b class="mediumtext lorangetext">Work From Home</b> <small><i>Beta</i></small><br><br>
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
												<td width="85%"><input id="wfh_from_" type="text" name="wfh_from" attribute1="<?php echo $limit_from; ?>" value="<?php echo date('Y-m-d', strtotime("-1 days")); ?>" class="txtbox datepickwh" readonly ng-model="wfh_from"/> - <input id="wfh_to_" type="text" name="wfh_to" value="<?php echo date('Y-m-d', strtotime("-1 days")); ?>" class="txtbox datepickwh" readonly ng-model="wfh_to"/></td>
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
																<th >Task/s</th>
															</tr>
															<tr ng-repeat="wfh_day in wfh_days" id="tr{{ $index+1 }}">
																<td class="centertalign">
																	<input type="hidden" name="wfh_disable[{{ $index+1 }}]" id="wfh_disable{{ $index+1 	}}" value="0">
																	<input id="mdtr_absent{{ $index+1 }}" type="checkbox" name="mdtr_absent[{{ $index+1 }}]" attribute="{{ $index+1 }}" class="mdtr_absent" ng-click="excludeFunction($index+1)" title="Excluded">
																	<span ng-bind=" isApplied(wfh_day.DTR) ? excludeApplied($index+1) : '' "></span>
																</td>
																<td class="centertalign">
																	<span ng-bind="wfh_day.DTR | date: 'EEE MM/dd/yy'"></span> <br>
																	<span ng-show="isHoliday(wfh_day.DTR)">Holiday</span><br>
																</td>
																<td class="centertalign">
																	<span style="{{ (wfh_day.CREDIT > 8 ||  isWeekends(wfh_day.DTR) || isHoliday(wfh_day.DTR) || isOVerSix(wfh_day.ACTIVITIES)) ? 'color:yellow' : '' }}">
																		<strong><span ng-bind="wfh_day.CREDIT | number:2"></span></strong> hr<span ng-show="wfh_day.CREDIT > 1">s</span>
																		<span ng-show="wfh_day.CREDIT > 8 ||  isWeekends(wfh_day.DTR) || isHoliday(wfh_day.DTR) || isOVerSix(wfh_day.ACTIVITIES)">*</span>
																	</span>

																	<input value="{{ wfh_day.EXCESSHOURS }}" id="wfh_excesshours{{ $index+1 }}" type="hidden" name="wfh_excesshours[{{ $index+1 }}]" attribute="{{ $index+1 }}" class="wfh_excesshours txtbox">

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
																				<label ng-show="$index == wfh_days[$parent.$index].ACTIVITIES.length - 1" title="When checked, credit hours will be deducted with 1 hour break time" >
																					<input id="include_break{{ $parent.$index+1 }}" value="{{ wfh_days[$parent.$index].BREAKTIME }}" attribute1="{{ wfh_day.DTR }}"  type="checkbox" name="include_break[{{ $index+1 }}]" attribute="{{ $index+1 }}" class="mdtr_absent" ng-checked="wfh_days[$parent.$index].BREAKTIME == 1" ng-click="includeFunction($event)" ng-show="false"><span ng-show="false">less 1 HR Break</span>
																					&nbsp;
																				</label>
																			</td>
																		</tr>
																	</table>
																</td>
																<td >
																	<textarea rows="1" style="" name="wfh_activity[{{ $index+1 }}]" id="wfh_activity{{ $index+1 }}" class="txtbox"></textarea>
																	<table >
																		<tr ng-repeat="activity in wfh_day.ACTIVITIES">
																			<td style="border-bottom: 0px; margin: 0; padding: 0">
																				<textarea class="txtarea wfh_act{{ $parent.$index+1 }}" name="" id="" width="100%" rows="1" cols="43" ng-model="wfh_days[$parent.$index].ACTIVITIES[$index].act" required></textarea>
																			</td>
																			<td style="border-bottom: 0px; margin: 0; padding: 0; text-align:left">
																				<button  style="" type="button" class="redbtn wfh_delete{{ $parent.$index+1 }}" ng-show="wfh_days[$parent.$index].ACTIVITIES.length > 1" ng-click="delItem($parent.$index, $index)"><i class="fa fa-trash-o"></i></button>
																				<button  style="" type="button" class="smlbtn wfh_add{{ $parent.$index+1 }}" ng-show="$index+1 == wfh_days[$parent.$index].ACTIVITIES.length" ng-click="addItem($parent.$index, $index)"><i class="fa fa-plus"></i></button>
																			</td>
																		</tr>
																	</table>
																	<span ng-show="isApplied(wfh_day.DTR)" ng-bind="'Existing Application #' + applied_refs[applied.indexOf(wfh_day.DTR)]"></span>
																	<span>&nbsp;</span>
																</td>
															</tr>
														</table>

													</div>
												</td>
											</tr>
											<tr>
												<td colspan="2">
													<i>Maximum 7 days per application. No credit hours between 12:00 - 1:00 pm.</i><br>
													<i>Sample task: Prepared monthly attendance of employees for Perfect Attendance Report</i><br>
													<i><strong>Credit Hours for Approval</strong></i><br>
													<ul style="list-style: none;">
														<li><i><span >* Maximum of 8 working hours per day</span></i></li>
														<li><i><span >* Worked rendered on a Holiday, Saturday or Sunday</span></i></li>
														<li><i><span >* Worked rendered past 6:00 pm</span></i></li>
													</ul>
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
									<input type="hidden" name="reqnbr" value="<?php echo "MD-".$finsec; ?>" />
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

		var wfh_app = angular.module('WFHApp', []);
		wfh_app.controller('WFHController', ['$scope','$http', function($scope, $http){

			$scope.timePick = function($event){
				var date = angular.element($event.currentTarget).attr("attribute1");

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

					if(event.$index == 0){
						if($($event.currentTarget).attr('id') == 'start_time'){
							if(event.activity.start_time == '' || event.activity.start_time == null )
								opt.defaultValue = '08:00 am';
						}else{
							opt.minTime = event.activity.start_time;
						}

					}else{
						if($($event.currentTarget).attr('id') == 'start_time'){
							opt.minTime = event.$parent.wfh_day.ACTIVITIES[event.$index - 1].end_time;
						}else{
							opt.minTime = event.activity.start_time;
						}
					}

					return opt;

				}

				angular.element($event.currentTarget).timepicker('destroy').timepicker(getTimeOption(this));
				angular.element($event.currentTarget).timepicker("show");
			}

			$scope.applied_warn = false;

			$scope.excludeApplied = function(key){


				if($scope.applied_warn == false){

					$scope.applied_warn = true;
					// alert('One or more dates have already been applied and will be excluded from application. Cancel existing applications to enable them.');
				}


				$("#wfh_disable" + key).attr('checked', true);
				$("#wfh_disable" + key).val(1);
				$("#mdtr_absent" + key).attr('checked', true);
				$("#mdtr_absent" + key).val(1);
				$(".wfh_add" + key).hide();
				$(".wfh_delete" + key).hide();
				$("#wfh_totalworkedhours" + key).prop("disabled", true);
				$("#wfh_activity" + key).prop("disabled", true);
				// $("#include_break" + key).prop("disabled", true);

				$(".wfh_act" + key).each(function() {
						$(this).prop("disabled", true);
				});

				$(".wfh_time" + key).each(function() {
						$(this).prop("disabled", true);
				});

			}

			$scope.excludeFunction = function(key){

				if($("#wfh_disable" + key).val() == 0){
					$("#wfh_disable" + key).val(1);
				}else{
					$("#wfh_disable" + key).val(0);
				}
				var disable = $("#wfh_disable" + key).val();


				if(disable == 1){
					$(".wfh_add" + key).hide();
					$(".wfh_delete" + key).hide();
				}else{
					$(".wfh_add" + key).show();
					$(".wfh_delete" + key).show();
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

				// if($("#include_break" + key).prop("disabled")){
				// 	$("#include_break" + key).prop("disabled", false);
				// }else{
				// 	$("#include_break" + key).prop("disabled", true);
				// }

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

			$scope.wfh_activity = [];
			$scope.item = {start_time : null, end_time : null, act: '', excess: 0};
			$scope.wfh_from = new Date().toISOString().split("T")[0];
			$scope.wfh_from = new Date(angular.copy($scope.wfh_from));
			$scope.wfh_from.setDate($scope.wfh_from.getDate()-1);
			$scope.wfh_from = new Date(angular.copy($scope.wfh_from)).toISOString().split("T")[0];

			$scope.wfh_to = new Date().toISOString().split("T")[0];
			$scope.wfh_to = new Date(angular.copy($scope.wfh_to));
			$scope.wfh_to.setDate($scope.wfh_to.getDate()-1);
			$scope.wfh_to = new Date(angular.copy($scope.wfh_to)).toISOString().split("T")[0];

			$scope.date_original = $scope.wfh_to;
			$scope.holidays = [];

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

			$scope.sortTimeRanges = function(ranges){
				var time_ranges = [
					//{start: null, end: null, duration: 0}
				];

				for(var i = 0; i < ranges.length; i++){
					var duration = 0;
					var start = new Date('01/01/1900 ' + ranges[i].start_time);
					var end = new Date('01/01/1900 ' + ranges[i].end_time);

					time_ranges.push({start: start, end: end, duration: duration, defaultApprovedDuration: duration});
				}

				time_ranges.sort((a, b) => a.end.getHours() + (a.end.getMinutes() / 60 ) - b.end.getHours() + (b.end.getMinutes() / 60 ));
				time_ranges.sort((a, b) => a.start.getHours() + (a.start.getMinutes() / 60 ) - b.start.getHours() + (b.start.getMinutes() / 60 ));

				return time_ranges;
			}

			$scope.computeTotalExcessHours = function(ranges){
				var time_ranges = $scope.computeCredits(ranges);
				var total_duration = 0;

				for(var i = 0; i < time_ranges.length; i++){
					total_duration += time_ranges[i].defaultApprovedDuration;
				}

				return total_duration;
			}

			$scope.computeDuration = function(ranges){
				for(var i = 0; i < ranges.length; i++){

				  if(ranges[i].start instanceof Date && !isNaN(ranges[i].start.valueOf())&& ranges[i].end instanceof Date && !isNaN(ranges[i].end.valueOf())){
				    var start = ranges[i].start;
				    var end = ranges[i].end;
					var twelve = new Date('01/01/1900 ' + '12:00 pm');
	          		var one = new Date('01/01/1900 ' + '01:00 pm');

					if(start <= twelve && end >= one){
						console.log('entry contains 12:00-1:00');
						//time start and end contains 12:00 - 1:00
						var duration = (((end.getHours()  - start.getHours()) * 60 + end.getMinutes() - start.getMinutes()) / 60) -1;

					}else if(start >= twelve && end <= one){
						//time start and end within 12:00 - 1:00
						console.log('entry start and end within 12:00-1:00');
						var duration = 0;

					}else if( start < twelve && end > twelve  && end < one){
						console.log('entry end within 12:00-1:00');
						//time end within 12:00 - 1:00 dont add end minutes
						var duration = ((end.getHours()  - start.getHours()) * 60  - start.getMinutes()) / 60;

					}else if(start > twelve && start < one && end > one){
						console.log('entry start within 12:00-1:00');
						//time start within 12:00 - 1:00 dont add start minutes
						var duration = ((end.getHours()  - one.getHours()) * 60 + end.getMinutes()) / 60;

					}else{
						console.log('entry doesnt contain 12:00-1:00');
						//time doesnt contain 12:00 - 1:00
						var duration = ((end.getHours()  - start.getHours()) * 60 + end.getMinutes() - start.getMinutes()) / 60;

					}

					var excessHoursFrom6pm = 0;
					var sixpm = new Date('01/01/1900 ' + '06:00 pm');

					if(start <= sixpm && end > sixpm){
						// 5pm - 7.30pm
						// 6pm - 7:30pm
						// 6pm - 6:45pm
						excessHoursFrom6pm = (((end.getHours() - sixpm.getHours()) * 60 ) + end.getMinutes()) / 60;
					} else if(start > sixpm && end > sixpm ){
						// 6.15pm - 7:00pm
						// 6.15pm - 7:30pm
						excessHoursFrom6pm = (((end.getHours() - start.getHours()) * 60) - start.getMinutes() + end.getMinutes()) / 60;

					}

				    ranges[i].duration = duration;
						ranges[i].defaultApprovedDuration = excessHoursFrom6pm;

				  }

				}
			   return ranges;
			}

			$scope.computeCredits = function (time_ranges){
				time_ranges = $scope.sortTimeRanges(time_ranges);

				var time_ranges_2 = [];
				for(var i = 0; i < time_ranges.length; i++){
					if(time_ranges_2.length == 0){
						time_ranges_2.push(time_ranges[i]);
					}

					for(var j = 0; j < time_ranges_2.length; j++){

						if(time_ranges[i].start >= time_ranges_2[j].start && time_ranges[i].start <= time_ranges_2[j].end){
							if(time_ranges[i].end <= time_ranges_2[j].end){
								continue;
							}else if(time_ranges[i].end > time_ranges_2[j].end){
								time_ranges_2[j].end = time_ranges[i].end;
								break;
							}
						}else{
							if(time_ranges_2[j].start >= time_ranges[i].start && time_ranges_2[j].start <= time_ranges[i].end){
								time_ranges_2[j].start = time_ranges[i].start;
								break;
							}else{
								if(j == time_ranges_2.length - 1){
									time_ranges_2.push(time_ranges[i]);
									break;
								}
							}
						}
					}
				}

				time_ranges_2 = $scope.computeDuration(time_ranges_2);
				return time_ranges_2;
			}

			$scope.computeTotalDuration = function(ranges){
				var time_ranges = $scope.computeCredits(ranges);
				var total_duration = 0;

				for(var i = 0; i < time_ranges.length; i++){
					total_duration += time_ranges[i].duration;
				}

				return total_duration;
			}

			$local_data = JSON.parse(localStorage.getItem('wfh-entries'));
			if($local_data != undefined && $local_data.length > 0){
				if(confirm("You have unsaved WFH entries. Do you want to restore it?")){
					$scope.wfh_from = $local_data[0].DTR;
					$scope.wfh_to = $local_data[$local_data.length - 1].DTR;

					$scope.wfh_days = $local_data;
				}
			}

			$scope.$watchGroup(['wfh_from', 'wfh_to'], function(newVal, oldVal){

				$scope.applied_warn = false;

				if(newVal[0] == oldVal[0] && newVal[1] != oldVal[1]){
					if(new Date(newVal[1]) < new Date($scope.wfh_from)){
						$scope.wfh_from = newVal[1];
					}

				}else if(newVal[0] != oldVal[0] && newVal[1] == oldVal[1]){
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

				// $("#wfh_from_").change(function() {
				//
				// 	mfrom = $("#wfh_from_").val();
				// 	mto = $("#wfh_to_").val();
				//
				// 	if (mfrom && mto) {
				//
				// 		$.ajax(
				// 		{
				// 			url: "<?php //echo WEB; ?>/lib/requests/app_request.php?sec=gettrueto3",
				// 			data: "from=" + mfrom,
				// 			type: "POST",
				// 			complete: function(){
				// 				$("#loading").hide();
				// 			},
				// 			success: function(data) {
				//
				// 				if($scope.date_original < data){
				// 					data = $scope.date_original;
				// 				}
				//
				// 				$('#wfh_to_').datetimepicker('destroy');
				// 				$('#wfh_to_').datepicker({
				// 					dateFormat: 'yy-mm-dd',
				// 					minDate: mfrom,
				// 					maxDate: data
				// 				});
			  //         $('#wfh_to_').val(data);
				// 				$('#wfh_to_').attr("value", data);
				// 			}
				// 		})
				//
				// 	}
				// });

				$scope.current_date = new Date(angular.copy($scope.wfh_from));
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
							"BREAKTIME":0,
							"EXCESSHOURS":0,
						}

						$scope.wfh_days.push( dtr );
					}

					$scope.current_date.setDate($scope.current_date.getDate()+1);
					$scope.applyActivities();
					
				}

				var sort = (angular.copy($scope.wfh_days)).sort(compare);
				$scope.wfh_days = sort;


				$scope.holidays = [];
				for(var k = 0; k < $scope.wfh_days.length; k++)				{
					$http({
						method : "GET",
						url : "<?php echo WEB; ?>/lib/requests/app_request.php?sec=getshiftdtr&date="+ $scope.wfh_days[k].DTR +"",
						data: {date: $scope.wfh_days[k].DTR}
					}).then(function checkHoliday(response) {
						if(response.data.SHIFT == 'HOLIDAY')
							$scope.holidays.push(response.config.data.date);
					}, function error(response) {
						console.log('error retrieving holiday');
					});
				}


				$scope.applied =[];
				$scope.applied_refs = [];
				for(var k = 0; k < $scope.wfh_days.length; k++)				{
					$http({
						method : "GET",
						url : "<?php echo WEB; ?>/lib/requests/app_request.php?sec=getappliedwfh&date="+ $scope.wfh_days[k].DTR +"",
						data: {date: $scope.wfh_days[k].DTR}
					}).then(function checkHoliday(response) {
						if(response.data.DTRDate){
							$scope.applied.push(response.data.DTRDate);
							$scope.applied_refs.push(response.data.Reference);
						}
					}, function error(response) {
						console.log('error retrieving applied dates');
					});
				}


			});

			$scope.includeFunction = function($event){

				var breaktime = angular.element($event.currentTarget).attr("value");
				var date = angular.element($event.currentTarget).attr("attribute1");

				if(breaktime == 0){
					breaktime = 1;
				}else{
					breaktime = 0;
				}

				angular.element($event.currentTarget).attr("value", breaktime);

				var days_data = JSON.stringify($scope.wfh_days);
				days_data = JSON.parse(days_data);

				angular.forEach(days_data, function(value, key){
					if(value.DTR == date){
						value.BREAKTIME = breaktime;
					}
				});

				$scope.wfh_days = days_data;

			}

			$scope.$watch('wfh_days', function(newVal, oldVal, $scope){


				for(var i = 0; i < $scope.wfh_days.length; i++){
					$scope.wfh_days[i].CREDIT = $scope.computeTotalDuration($scope.wfh_days[i].ACTIVITIES) ;
					$scope.wfh_days[i].EXCESSHOURS = $scope.computeTotalExcessHours($scope.wfh_days[i].ACTIVITIES) ;

					for(var j = 0; j < $scope.wfh_days[i].ACTIVITIES.length ; j++){
						$scope.wfh_days[i].ACTIVITIES[j].excess = $scope.wfh_days[i].EXCESSHOURS;
					}
					if($scope.wfh_days[i].CREDIT > $scope.wfh_days[i].BREAKTIME)
						$scope.wfh_days[i].CREDIT -= $scope.wfh_days[i].BREAKTIME;
					else
						$scope.wfh_days[i].CREDIT = 0;

					$('#wfh_activity'+eval(i+1)).text(JSON.stringify($scope.wfh_days[i].ACTIVITIES));
				}

				localStorage.setItem('wfh-entries', JSON.stringify($scope.wfh_days));
			}, true);

			$scope.addItem = function(index, act){

				$scope.wfh_days[index].ACTIVITIES.push(
					{start_time : $scope.wfh_days[index].ACTIVITIES[act].end_time, end_time : null, act: '', excess: 0}
				);

			}

			$scope.delItem = function(index, act){
				$scope.wfh_days[index].ACTIVITIES.splice(act, 1);
			}

			angular.element(document).ready(function () {

				$scope.applyActivities = function(){

					for(var i = 0; i < $scope.wfh_days.length; i++){
						$scope.wfh_days[i].CREDIT = $scope.computeTotalDuration($scope.wfh_days[i].ACTIVITIES) ;
						$scope.wfh_days[i].EXCESSHOURS = $scope.computeTotalExcessHours($scope.wfh_days[i].ACTIVITIES) ;

						for(var j = 0; j < $scope.wfh_days[i].ACTIVITIES.length ; j++){
							$scope.wfh_days[i].ACTIVITIES[j].excess = $scope.wfh_days[i].EXCESSHOURS;
						}
						if($scope.wfh_days[i].CREDIT > $scope.wfh_days[i].BREAKTIME)
							$scope.wfh_days[i].CREDIT -= $scope.wfh_days[i].BREAKTIME;
						else
							$scope.wfh_days[i].CREDIT = 0;

						$('#wfh_activity'+eval(i+1)).text(JSON.stringify($scope.wfh_days[i].ACTIVITIES));
					}

				}
				$scope.applyActivities();


			});

			$scope.isHoliday = function($dtr){
				var isHol = false;
				$scope.holidays.forEach(holiday => {
					if(holiday == $dtr){
						isHol = true;
					}
				});

				return isHol;
			}

			$scope.isApplied = function($dtr){
				var isApl = false;
				if($scope.applied){
					$scope.applied.forEach(date => {
						if(date == $dtr){
							isApl = true;
						}
					});
				}

				return isApl;
			}

			$scope.isWeekends = function($dtr){
				$dtr = new Date($dtr);
				// Saturday or Sunday
				return $dtr.getDay() == 6 || $dtr.getDay() == 0;
			}

			$scope.isOVerSix = function($activities){
				over_six = false;
				six = new Date('01/01/1900 ' + '6:00 pm');

				$activities.forEach(act => {

					endTime = new Date('01/01/1900 ' + act.end_time);

					if(endTime > six){
						over_six = true;
					}

				});

				return over_six;
			}

		}]);
	});

</script>
<?php include(TEMP."/footer.php"); ?>
