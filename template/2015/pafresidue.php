                            <td style="text-align:center;">
                                <?php if($row['status'] == 'Active' && date('Y-m-d', strtotime($row['appdt'])) <= $datenow){ ?>
                                <i class="fa fa-cog fa-spin"></i> On Going
                                <?php } elseif($row['status'] == 'Inactive' || date('Y-m-d', strtotime($row['appdt'])) >= $datenow ) { ?>
                                <i class="fa fa-warning"></i> Inactive
                                <?php } ?>
                            </td>
                            <?php if($row['status'] == 'Active' && date('Y-m-d', strtotime($row['appdt'])) <= $datenow){ ?>
                                <?php if($row['cid'] == 'MEGA01'){ ?>
                                <td><a href="<?php echo WEB; ?>/paf?groupid=<?php echo $row['gid']; ?>" class="smlbtn" style="float:right;margin-right:10px;background-color:#3EC2FB;">View</a></td>
                                <?php } else { ?>
                                <td><a href="<?php echo WEB; ?>/pafglobal?groupid=<?php echo $row['gid']; ?>" class="smlbtn" style="float:right;margin-right:10px;background-color:#3EC2FB;">View</a></td>
                                <?php } ?> 
                            <?php } elseif($row['status'] == 'Inactive') { ?>
                                <td style="text-align:center;">Administrator <br /> Set it as inactive</td>
                            <?php } elseif(date('Y-m-d', strtotime($row['appdt'])) >= $datenow){ ?> 
                                <td>Appraisal Period <br />is not yet started</td>
                            <?php } ?>  