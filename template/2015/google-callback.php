<?php include(TEMP."/header.php"); ?>

<!-- BODY -->
 <form method="post" action="<?php echo WEB; ?>/google-callback">
	<div id="floatdiv" class="floatdiv">
		<div id="fdbname" class="fview">
				<div id="noti_title" class="noti_title robotobold cattext dbluetext">Choose Company</div>
				<div id="noti_data">
					<br>
					<select id="logdbname" name="logdbname" class="txtbox">
						<?php echo  $_SESSION['dbnamelist']?>
					</select>
					<button id="btnlogdbname" name="btnlogdbname" value="1" class="btn">Submit</button>
					<button id="btnlogdbcancel" name="btnlogdbcancel" value="1" class="redbtn">Cancel</button>
				</div>
		</div>
	</div>
 </form>

<?php include(TEMP."/footer.php"); ?>