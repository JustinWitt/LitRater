<?php
$timescalled = $_GET["timescalled"];
$whatever = $timescalled+1;
echo"
<table>
<tr>
<td>Author ". $timescalled ."</td>
</tr>
<tr align=\"center\">
<td>Title</td>
<td>First Name</td>
<td>Middle Name</td>
<td>Last Name</td>
<td>Suffix</td>
</tr>
<tr>
<td>
<select name=\"prefix" . $timescalled . "\" id=\"prefix" . $timescalled . "\">
	<option value=\"\">--</option>
	<option value=\"Mr.\">Mr.</option>
	<option value=\"Ms.\">Ms.</option>
	<option value=\"Mrs.\">Mrs.</option>
	<option value=\"Dr.\">Dr.</option>
	<option value=\"Sir.\">Sir</option>
</select>
</td>
<td><input type=\"text\" name=\"firstname" . $timescalled . "\" id=\"firstname" . $timescalled . "\"/></td>
<td><input type=\"text\" name=\"middlename" . $timescalled . "\" id=\"middlename" . $timescalled . "\"/></td>
<td><input type=\"text\" name=\"lastname" . $timescalled . "\" id=\"lastname" . $timescalled . "\"/></td>
<td>
<select name=\"suffix" . $timescalled . "\" id=\"suffix" . $timescalled . "\">
	<option value=\"\">--</option>
	<option value=\"Sr.\">Sr.</option>
	<option value=\"Jr.\">Jr.</option>
	<option value=\"M.A.\">M.A.</option>
	<option value=\"esq.\">Esq.</option>
	<option value=\"M.D.\">M.D.</option>
	<option value=\"Ph.D\">Ph.D</option>
</select>
</td>
<td id=\"addanother" . $timescalled . "\">
<input type=\"checkbox\" name=\"addanother\" onclick=\"addMore(" . $timescalled . ")\"/>Add Another
</td>
</tr>
</table>
<div id=\"moreauthors" . $whatever . "\">moreauthors" . $whatever . "</div>
";

?>