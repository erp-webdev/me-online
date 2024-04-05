<div id="sessionfloat" class="floatdiv invisible">
   <div id="sessionfloatview" class="fview" style="display: none;">
         <div class="robotobold cattext dbluetext" style="text-align:center">
            Your session is about to expire
         </div>
         <div>
            <p style="text-align:center; color: black" class="smalltext">Please do not forget to save your progress.</p>
            <p style="text-align:center">
               <button type="button" class="btn closebutton" id='OK'>OK</button>
            </p>
         </div>
   </div>
</div>
</div>

<script>

var targetUnixTimestamp = Math.floor(Date.now() / 1000);
var currentUnixTimestamp = Math.floor(Date.now() / 1000);

function sessionNotice() {
   var timeDifference = targetUnixTimestamp - currentUnixTimestamp;

   if (timeDifference > 3300) {
      $("#sessionfloat").removeClass("invisible");
      $("#sessionfloatview").show({
            effect : 'slide',
            easing : 'easeOutQuart',
            direction : 'up',
            duration : 500
      });
   } else {
      setTimeout(sessionNotice, 1000);
   }

  targetUnixTimestamp = Math.floor(Date.now() / 1000);
}

sessionNotice();
$('#OK').on('click', function(e){
   $.ajax({
      method: 'GET',
      url: '<?php echo WEB ?>',
      success: function(response){
         currentUnixTimestamp = Math.floor(Date.now() / 1000);
         sessionNotice();
      }
   });
});

</script>