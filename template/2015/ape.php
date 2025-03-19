
<div width="100%" height="700px">
    <iframe id="filePreview" src='<?php echo $ViewURL; ?>#toolbar=1&zoom=60' width="100%" height="250px" style="border: none; margin-bottom:10px;"></iframe>

    <div style="margin-top: 10px; font-size: 0.7rem;">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 5px;">
            <span style="width: 30%; font-weight: bold;">Employee</span>
            <span style="width: 70%; word-wrap: break-word;">
                <?php echo $profile_full .' (' . $profile_idnum . ')' ?>
            </span>
        </div>
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 5px;">
            <span style="width: 30%; font-weight: bold;">Schedule Date</span>
            <span style="width: 70%; word-wrap: break-word;" id="MedicalDate"><?php echo $MedicalDate; ?></span>
        </div>
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <span style="width: 30%; font-weight: bold;">Remarks</span>
            <span style="width: 70%; word-wrap: break-word; max-height: 150px; overflow-y: auto; padding-right: 5px;" id="MedicalRemarks"> <?php echo $MedicalRemarks; ?></span>
        </div>
    </div>               
</div>
<div style="display: flex; justify-content: center; align-items: center; margin-top: 15px;">
    <button id='downloadAPE' data-url='<?php echo $DownloadURL; ?>' class="bigbtn">Download</button>
</div>

