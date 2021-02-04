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
							<b class="mediumtext lorangetext">My COE Requests</b>
							<br><br>
							<div>
								<button id="coenewreq" value="New Request" class="smlbtn" attribute5="1">New Request</button>
								<?php if($coe_users > 0){ ?>
											<a href="<?php echo WEB; ?>/coeadmin" id="coeadmin" class="smlbtn" style="background-color:#3EC2FB;">Administration</a>
								<?php } ?>
								<table border="0" cellspacing="0" class="tdata width100per">
									<?php
									if ($coe_data) :
										?>
									<tr>
									</tr>
									<tr>
										<th width="5%">#</th>
										<th width="10%">Date Requested</th>
										<th width="10%">Reference #</th>
										<th width="10%">Type</th>
										<th width="10%">Category</th>
										<th width="10%">Status</th>
										<th width="10%">Date Completed</th>
									</tr>
									<?php foreach ($coe_data as $key => $value) : ?>
									<?php //$appdata = $mainsql->get_notification($value['ReqNbr']); ?>
									<tr class="btncoe cursorpoint trdata centertalign" attribute="<?php echo $value['id']; ?>" attribute5="1">
										<td><?php echo $start + $key + 1; ?></td>
										<td><?php echo date('m/d/Y', strtotime($value['created_at'])); ?></td>
										<td><?php echo $value['ref_no']; ?></td>
										<td><?php echo $value['type']; ?></td>
										<td><?php echo $value['category']; ?></td>
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

<?php include(TEMP."/footer.php"); ?>
<!-- require_once(DOCUMENT.'/lib/html2pdf/html2pdf.class.php'); -->
