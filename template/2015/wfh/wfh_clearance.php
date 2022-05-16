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

		var wfh_app = angular.module('WFHApp', []);
		wfh_app.controller('WFHController', ['$scope','$http', function($scope, $http){



			

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

				$("#wfh_from_").change(function() {

					mfrom = $("#wfh_from_").val();
					mto = $("#wfh_to_").val();

					if (mfrom && mto) {

						$.ajax(
						{
							url: "<?php //echo WEB; ?>/lib/requests/app_request.php?sec=gettrueto3",
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