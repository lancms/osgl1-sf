<td width="100" height="100%" align="left" valign="top"> <table class="tbl_links" width="100" cellspacing="0" cellpadding="0">
              <tr>
                <td align=center> </td>
              </tr>
              
              <tr>
                <td bgcolor="#D29F5C"> <b>Menu:</b> </td>
              </tr>

<?php
function partymenu($link, $text) {
echo "<tr><td><a href=$link>$text</a></td>
              </tr>";
}



$q = query("SELECT * FROM partyweb WHERE display_menu = 1");

while($r = fetch($q)) {
partymenu("?viewpage=$r->ID", $r->menuname);

}

echo "<br><br>";
partymenu("?mode=party", "PartyMode");

?>
            </table></td>
          <td height="100%" align="left" valign="top"><table class="tbl_main" width="100%" height="100%" cellpadding="0" cellspacing="0">
              <tr>
