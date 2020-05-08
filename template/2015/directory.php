    <?php include(TEMP."/header.php"); ?>


    <!-- BODY -->
                  <head>
                    
                  <meta charset="utf-8">
                  <meta content="ie=edge" http-equiv="x-ua-compatible">
                   
                  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet"> 
                  <link href="template/2015/directory/directory_list/css/main.css" rel="stylesheet">
                  <script src="https://www.google.com/jsapi" type="text/javascript"> </script>
                  </head>

                    <div id="mainsplashtext" class="mainsplashtext lefttalign">  
                        <div class="topsplashtext lefttalign robotobold cattext whitetext">
                          <?php echo WELCOME; ?>  
                        </div>

                        <div class="leftsplashtext lefttalign">
                          <?php include(TEMP."/menu.php"); ?>
                        </div>
                        
                        <div class="rightsplashtext lefttalign">
                            <div id="mainob" class="mainbody lefttalign whitetext">  
                                <b class="mediumtext lorangetext">UPTOWN (Alliance Global Tower) DIRECTORY</b><br><br>
                            <div class="dirheight">                                                          
                             <table class="tdata">
                                
                            <thead>
                            <tr class="tableizer-firstrow"><td colspan="3">TRUNKLINE</td><td>8894-6300/8894-6400</td><td>7905-2800/7905-2900</td><td>&nbsp;</td><td>&nbsp;</td>
                            </tr>
                             <tr class="tableizer-firstrow">
                              <th width="15%">Floor</th>
                              <th width="20%">Department</th>
                              <th width="25%">Name</th>
                              <th width="10%">PLDT</th>
                              <th width="10%">Globe</th>
                              <th width="10%">Local</th>
                              <th width="10%">Local SP</th>
                                    </tr>
                             </thead>
                            </table> 
                            <table class="tdata">
                                    <tbody >
                                      <script src="template/2015/directory/directory_list/js/google-sheets-html.js" type="text/javascript"> </script>
                                      <div id="table"  > </div>
                                    </tbody>
                            </table>
                                </div><br>
                            </div>
                        </div>
                    </div>
                    
    <?php include(TEMP."/footer.php"); ?>


