	<?php include(TEMP."/header.php"); ?>

    <!-- BODY -->

                    <div id="mainsplashtext" class="mainsplashtext lefttalign">
                        <div class="topsplashtext lefttalign robotobold cattext whitetext"><?php echo WELCOME; ?></div>
                        <div class="leftsplashtext lefttalign"><?php include(TEMP."/menu.php"); ?></div>
                        <div class="rightsplashtext lefttalign">
                            <div id="mainnotification" class="mainbody lefttalign whitetext">
                                <b class="mediumtext lorangetext">QR CODE</b><br><br>

                                <img src="https://chart.googleapis.com/chart?chs=400x400&cht=qr&chl=<?php echo $id; ?>&choe=UTF-8" width="400" height="400" onerror="alert('QR Code failed to load. Please check your internet connection');">
								<!-- place if condition here if activity is xmas party -->
								<?php if($_SESSION["xmas"] == 1){ ?>
								<div>
									<table>
										<tbody align="left">
											<?php
												echo "<tr><td>Table: </td><td>".$table.'</td></tr>';
												echo "<tr><td>Department: </td><td>".$dept_name.'</td></tr>';
											?>
										</tbody>
									</table>
								</div>
								<?php } ?>
								<div class="clearboth">
                                    <button onclick="window.history.back();" class="btn btnred margintop25">Back</button>
                                </div>
                            </div>
                        </div>
                    </div>

    <?php include(TEMP."/footer.php"); ?>
