	<?php include(TEMP."/header.php"); ?>

    <!-- BODY -->


                    <div id="mainsplashtext" class="mainsplashtext lefttalign">
                        <div class="topsplashtext lefttalign robotobold cattext whitetext"><?php echo WELCOME; ?></div>
                        <div class="leftsplashtext lefttalign"><?php include(TEMP."/menu.php"); ?></div>
                        <div class="rightsplashtext lefttalign">
                            <div id="mainot" class="mainbody lefttalign whitetext">
                                <b class="mediumtext lorangetext">Other Forms</b><br><br>
                                <b>MAIN INFORMATION</b><br><br>
                                <div class="column2">
                                    <b><?php echo ucfirst($profile_nadd); ?> ID: </b><?php echo $profile_idnum; ?><br>
                                    <b>Name: </b><?php echo $profile_full; ?><br>
                                    <b>Position: </b><?php echo $profile_pos; ?><br>
                                    <b>Status: </b>Open<br>
                                    <b>Department: </b><?php echo $profile_dept; ?><br>
                                </div><br>

                                <div id="alert"></div>
                                <form id="frmother" action="?ignore-page-cache=true" method="post" enctype="multipart/form-data">
                                    <div id="tabs">
                                        <ul>
                                            <li><a href="#ldetails">Details</a></li>
                                            <li><a href="#lattach">Attachments</a></li>
                                            <li><a href="#lapprover">Approvers</a></li>
                                        </ul>

                                        <div id="ldetails" ng-app="OtherApp" ng-controller="OtherController">
                                            <table class="tdataform" border="0" cellspacing="0">
                                                <tr>
                                                    <td width="15%"><b>Form: </b></td>
                                                    <td width="85%" colspan="3">
                                                        <select id="form_type" name="form_type" class="txtbox width300" ng-model="form_type">
																													<?php foreach($forms as $form){ ?>
                                                            <option value="<?php echo $form["name"]; ?>"><?php echo $form["title"]; ?></option>
																													<?php } ?>
                                                        </select>
                                                    </td>
                                                </tr>
																								<tr ng-repeat="item in form_data[0].items" id="tr{{ $index+1 }}">
																									<td>
																										<label>{{ item.title }}</label>
																									</td>
																									<td>

																										<div ng-if="propExist(item.type) == 1"><!-- if item has type  -->
																											<div data-ng-switch on="item.type">

																												<div data-ng-switch-when="radio"><!-- if item is radio type  -->
																													<div ng-repeat="option in item.options">
																														<input type="radio" name="{{ item.name }}" ng-readonly="propReadOnly(item.readonly)" value="{{ option.value }}" class="{{ item.hclass ? item.hclass : '' }}">{{ option.text }}
																													</div>
																												</div>
																												<div data-ng-switch-when="short_text"><!-- if item is short text type  -->
																													<input type="text" name="{{ item.name }}" ng-readonly="propReadOnly(item.readonly)"  class="{{ item.hclass ? item.hclass : '' }}" ng-value=" propExist(item.defaultValue) ? defaultVal(item.defaultValue) : ''">
																												</div>
																											</div>
																										</div>

																										<div ng-if="propExist(item.type) == 0"><!-- if item has no type  -->
																											<div ng-if="textExists(item.hclass, 'datepicker') == 1"><!-- if item has datepicker  -->
																												<input type="text" name="{{ item.name }}" ng-readonly="propReadOnly(item.readonly)" ng-click="showDatePicker($event)" class="{{ item.hclass ? item.hclass : '' }}" ng-value="defaultVal(item.defaultValue)">
																											</div>
																										</div>

																									</td>
																								</tr>

                                            </table>
                                        <?php
                                            /*if ($chkdtrin == '0' || $chkdtrout == '0') :
                                                echo "<script type='text/javascript'>alert('Either or both DTR in or out is NOT SET so you can\'t apply an overtime, pls apply for a manual DTR instead, thank you.');
                                                $(function() { $('#btnotapply').addClass('invisible'); });</script>";
                                            else :
                                                echo "<script type='text/javascript'>$(function() { $('#btnotapply').removeClass('invisible'); });</script>";
                                            endif;*/
                                        ?>
                                        </div>
                                        <div id="lattach">
                                            <input type="file" name="attachment1" class="whitetext" /><br>
                                            <input type="file" name="attachment2" class="whitetext" /><br>
                                            <input type="file" name="attachment3" class="whitetext" /><br>
                                            <input type="file" name="attachment4" class="whitetext" /><br>
                                            <input type="file" name="attachment5" class="whitetext" />
                                            <br><br>
                                            <i>* it must be PDF or image (JPG or GIF) and not more than 200Kb each</i>
                                        </div>
                                        <div id="lapprover">
                                            <?php if ($ot_app) : ?>
                                            <?php foreach($ot_app as $key => $value) : ?>
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
                                        <input id="invalid" type="hidden" name="invalid" value="0" />
                                        <input type="hidden" name="empid" value="<?php echo $profile_idnum; ?>" />
                                        <input type="hidden" name="reqnbr" value="<?php echo "Other-".$finsec; ?>" />
                                        <input type="hidden" name="user" value="<?php echo $profile_idnum; ?>" />
                                        <input id="btnotherapply" type="submit" name="btnotherapply" value="Submit" class="btn margintop10" />
                                        <a href="<?php echo WEB; ?>/pending"><input type="button" name="btncancel" value="Cancel" class="redbtn margintop10" /></a>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>

		<script>

			$(document).ready(function(){


				var wfh_app = angular.module('OtherApp', []);
				wfh_app.controller('OtherController', ['$scope','$http', function($scope, $http){

					$scope.propExist = function(key){
						if(key == '' || key == undefined || key == null){
							return 0;
						}else{
							return 1;
						}
					}

					$scope.propReadOnly = function(value){
						if(value == 'true' || value == true){
							return true;
						}else{
							return false;
						}
					}

					$scope.textExists = function(key, text){
						if(key.search(text) > -1){
							return 1;
						}else{
							return 0;
						}
					}

					$scope.defaultVal = function(key){
						if(key == "date('Y-m-d')"){
							var date = new Date();
							var month = date.getMonth()+1;
							var day = date.getDate();

							return date.getFullYear() + '-' + (month<10 ? '0' : '') + month + '-' + (day<10 ? '0' : '') + day;
						}else{
							return key;
						}
					}

					$scope.showDatePicker = function($event){

						$($event.currentTarget).datepicker({
					        dateFormat: 'yy-mm-dd',
					        minDate: "-5D",
					        maxDate: "1D",
					        changeMonth: true,
					        changeYear: true
					    });

						$($event.currentTarget).datepicker("show");

					}

					$scope.form_type = $('#form_type').val();
					$scope.form_data = [];

					$scope.$watch('form_type', function(newVal, oldVal, $scope){


						$http({
							method : "GET",
							url : "<?php echo WEB; ?>/lib/requests/app_request.php?sec=getotherform&form="+ $scope.form_type +""
						}).then(function checkHoliday(response) {
							console.log(response.data);
							$scope.form_data = response.data;
						}, function error(response) {
							console.log('error retrieving forms');
						});

					});

					$scope.$watch('form_data', function(newVal, oldVal, $scope){

						if($scope.form_data[0]){
							console.log($scope.form_data[0].title);
						}

					});

				}]);

			});

		</script>

    <?php include(TEMP."/footer.php"); ?>
