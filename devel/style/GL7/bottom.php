				</p>
                  <p>&nbsp;</p></td>
              </tr>
            </table></td>
<!-- Tabell midt SLUTT -->

            
<!-- Tabell før midt  SLUTT -->


<!--  Tabell Høyre START -->
          <td class=sidetabeller width="10%">
            <!-- Logg inn START -->
            <table border="0" width="100%" cellspacing="0" cellpadding="0">
              <tr>
                <td width="100%">
                  <table border="0" width="100%" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="100%">
                        <table border="0" width="100%" cellspacing="0" cellpadding="0">
                          <tr>
                            <td class=menyfarge width="100%">
                              <table border="0" width="100%" cellpadding="0">
                                <tr>
				<?php if(getcurrentuserid() == 1) {
				?>
                                  <td class=menyfarge width="100%">Logg inn</td>
				<?php }
				else {
					// Skal vi gjøre noe om brukeren er innlogget?
					
					echo "<td class=menyfarge width=100%>Brukerinfo</td>";
				}
				?>
                                </tr>
                              </table>
                            </td>
                          </tr>
                          <tr>
                            <td class=blue-pic width="100%" height="5"></td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr>
                <td width="100%">
				<!-- Dette er login-feltet.... -->
		<?php if(getcurrentuserid() == 1) { ?>
                  <form method=POST action=do.php?action=login>
                    <table border="0" width="100%" cellpadding="0">
                      <tr>
                        <td class=meny-header-tekst>Nick:</td>
                        <td><input type="text" name="username" size="15"></td>
                      </tr>
                      <tr>
                        <td class=meny-header-tekst>Pass:</td>
                        <td><input type="password" name="password" size="15"></td>
                      </tr>
                    </table>
                    <table border="0" width="100%" cellpadding="0">
                      <tr>
                        <td width="100%">
                          <p align="center"><input type="submit" value="Logg inn" name="B1"><input type="reset" value="reset" name="B2"></td>
                      </tr>
                    </table>
                  </form>
		  <?php }
		  else {
			  // Skal vi gjøre noe om brukeren er innlogget?
			$q = query("SELECT * FROM users WHERE ID = ".getcurrentuserid());
			$r = fetch($q);
			
			echo $r->nick." | ".$rank[$r->isCrew]." <br><a href=do.php?action=logout>Logg ut</a>";
		  }
		  ?>
		  <!-- Her slutter loginfeltet.... -->
                </td>
              </tr>
              <tr>
                <td width="100%">
                  <table border="0" width="100%" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="10%"> </td>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr>
                <td width="100%"></td>
              </tr>
              <tr>
                <td width="100%"></td>
              </tr>
            </table>
          </td>
<!-- Logg inn SLUTT -->


        </tr>
<!-- Tabell høyre SLUTT -->

<!-- Tabell bunnen START -->
        <tr valign="top">
          <td class=sidetabeller width="15%" height="1">&nbsp;

          </td>
          <td class=copyright width="7%" height="1">
            <table border="0" width="100%" cellspacing="0" cellpadding="0">
              <tr>
                <td width="100%"></td>
              </tr>
              <tr>
                <td width="100%" valign="top">
                  <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="100%" align="center"><hr color="#999999" SIZE="1"> 
                      </td>
                    </tr>
                    <tr>
                      <td width="100%" align="center">Copyright © 2004-2005 </td>
                    </tr>
                    <tr>
                      <td width="100%" align="center">Globelan - Nøtterøy, Vestfold 
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr>
                <td width="100%" align="center">Design: wasp |:| <a href="http://mats.rove.no">http://mats.rove.no</a></td>
              </tr>
            </table>
          </td>
          <td class=sidetabeller width="10%" height="1">&nbsp;
          </td>
        </tr>
<!-- Tabell bunnen SLUTT -->


      </table>
    </td>
  </tr>
</table>
<!-- Hovedtabell SLUTT -->

</body>
</html>
