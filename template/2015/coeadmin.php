<?php include(TEMP."/header.php"); ?>
<!-- BODY -->
				<div id="coefloat" class="floatdiv invisible">
					<!-- VIEW NOTIFICATION - BEGIN -->
					<div id="coeview" class="fview" style="display: none;">
						<div class="closebutton cursorpoint"><i class="fa fa-times-circle fa-3x redtext"></i></div>
						<div id="coe_title" class="pend_title robotobold cattext dbluetext" align="center"></div>
						<div id="coedata">
						</div>
					</div>
					<!-- VIEW NOTIFICATION - END -->
				</div>
				<div id="mainsplashtext" class="mainsplashtext lefttalign" style="font-size: 11px;">0
					<div class="topsplashtext lefttalign robotobold cattext whitetext"><?php echo WELCOME; ?></div>
					<div class="leftsplashtext lefttalign"><?php include(TEMP."/menu.php"); ?></div>
					<div class="rightsplashtext lefttalign">
						<div id="mainnotification" class="mainbody lefttalign whitetext">
							<b class="mediumtext lorangetext">COE Requisitions (Administration)</b>

							<br><br>
							<div>
								<div>
									<tr id="adminsort">
										<td></td>
										<td>
											<label>Company: </label>
										</td>
										<td>
											<select id="company_sort" name="company_sort" class="txtbox" style="width:193px;" attribute2="<?php echo $pages ? $pages : ''; ?>">
												<option value="">All Companies</option>
												<?php
													$dbase_array = array(
														'GL' => ['GLOBAL01', 'LGMI01'],
														'MEGAWORLD' => ['MEGA01'],
														'CITYLINK' => ['CITYLINK01'],
														'ECINEMA' => ['ECC02'],
														'ECOC' => ['ECOC01'],
														'EPARKVIEW' => ['ECP02'],
														'EREX' => ['ERA01'],
														'FIRSTCENTRO' => ['FCI01'],
														'GLOBAL_HOTEL' => ['GLOBALHOTEL'],
														'LAFUERZA' => ['LFI01'],
														'LCTM' => ['LUCK01'],
														'MCTI' => ['MCTI'],
														'MLI' => ['MLI01'],
														'NCCAI' => ['NCCAI'],
														'NEWTOWN' => ['NEWTOWN01'],
														'SUNTRUST' => ['SUNT01'],
														'TOWNSQUARE' => ['TOWN01'],
														'SIRUS' => ['SIRUS'],
														'ASIAAPMI' => ['ASIAAPMI'],
														'MALL_ADMIN' => ['Boracay'],
														'AGILE' => ['AGILE']
													);

												foreach ($admin_companies as $key => $admin_company) {
													if(in_array($admin_company['CompanyID'], $dbase_array[$profile_dbname])){?>
														<option value="<?php echo $admin_company['CompanyID']; ?>" <?php if($company_sort == $admin_company['CompanyID']){ echo "selected";} ?>><?php echo $admin_company['CompanyName']; ?></option>
												<?php
													}
												}
												?>
											</select>
										</td>
									</tr>
									<?php if($coe_user_data[0]['level'] != 4){ ?>
											<button id="coenewreq" value="New Request" class="smlbtn" attribute5="2">New Request</button>
									<?php }?>
									<input style="float: right;" type="button" attribute="<?php echo $admin_level; ?>" id="coesearch" name="coesearch" value="Search" class="smlbtn" />
									<input style="float: right;" type="text" id="coeref" name="coeref" class="smltxtbox" placeholder="Reference # or Name" />&nbsp;
								</div>
								</br>

								<div id="tablecoe">
									<table border="0" cellspacing="0" class="tdata width100per">
										<?php
										if ($coe_data) :
											?>
										<tr>
										</tr>
										<tr>
											<th width="5%">#</th>
											<!-- <th width="10%">Date Requested</th> -->
											<th width="20%">FullName</th>
											<th width="10%">Type</th>
											<th width="10%">Employee</th>
											<th width="10%">Company ID</th>
											<th width="10%">Status</th>
											<th width="10%">Date Completed</th>
										</tr>
										<?php foreach ($coe_data as $key => $value) : ?>
										<?php //$appdata = $mainsql->get_notification($value['ReqNbr']); ?>
										<tr class="btncoe cursorpoint trdata centertalign" attribute="<?php echo $value['id']; ?>" attribute5="2">
											<td><?php echo $start + $key + 1; ?></td>
											<!-- <td><?php //echo date('m/d/Y', strtotime($value['created_at'])); ?></td> -->
											<td><?php echo $value['FullName']; ?></td>
											<td><?php echo $value['type']; ?></td>
											<td><?php echo $value['emp_id']; ?></td>
											<td><?php echo $value['company']; ?></td>
											<td><?php echo $value['status']; ?></td>
											<td><?php echo $value['released_at'] ? date('m/d/Y', strtotime($value['released_at'])) : ''; ?></td>
										</tr>
										<?php endforeach; ?>
										<?php if ($pages) : ?>
										<tr>
											<td colspan="10" class="centertalign"><?php echo $pages; ?></td>
										</tr>
										<?php endif; ?>
										<?php else : ?>
										<tr>
											<td class="bold centertalign noborder"><br><br>No COE Requisition found!
											</td>
										</tr>
										<?php endif; ?>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>



<?php include(TEMP."/footer.php"); ?>
