<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html xmlns:v="urn:schemas-microsoft-com:vml" xmlns:iSvg="http://www.w3.org/2000/svg">
<head>
<title>100% Pure JavaScript Chart | JS Chart Inc.</title>

<meta http-equiv="keywords"
	content="chart, bar, line, pie, AJAX,JSON,JavaScript,CSS,DHTML,web,chart,javascript,svg,vml">
<meta http-equiv="description" content="100% Pure JavaScript Chart. 
Over 100 types of bar, line, pie charts are generated within the browser,
configurable by developers, and editable by end users.">
<object id='AdobeSVG' classid='clsid:78156a80-c6a1-4bbf-8e6a-3cd390eeb4e2'></object>
<?php
echo "<?import namespace='iSvg' implementation='#AdobeSVG'?>";
?>
<link rel="stylesheet" type="text/css" href="site.css">

<SCRIPT LANGUAGE="JavaScript" SRC="action.php?t=l&f=JSTile_Pro.js"></SCRIPT>

</head>
<body class="body">

<center>
<table width="800" bgcolor="white" class="mainTable">
	<tr>
		<td>
		<table cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<td class="headerCell"><img src="image/js_logo.png" border="0"/> &nbsp; &nbsp; <a
					href="index.html">
					<img src="image/js_chart.png" border="0"/></a><span
					class="js_pureJSChart"> - 100% Pure JavaScript Chart</span></td>
				<td align="right" valign="bottom">
					<img style="position: relative; top:20px;" src="image/chart_icons.png"/>
				</td>
			</tr>
		</table>
<br/>
		<table cellpadding="0" width="100%">
			<tr height="550" valign="top" >
				<td width="100">
				<br/><br/><br/>
				 <table width="100">
				 
				<tr><td align="center">
					<a href="tile.php" 
					onclick="return com.jschart.get(this, 'mainBody');" class="menuItem">JSTile Home</a>
					<br/><br/>
				</td></tr>				 
				
				 <tr><td align="center">
				<a href="tileDemo.html" o
					onclick="return com.jschart.get(this, 'mainBody');" 
					class="menuItem">Demo</a>
				</td></tr>
				

				 <tr><td align="center">
				 <br/>				 
				<a href="tileGetStarted.html" 
					onclick="return com.jschart.get(this, 'mainBody');" 
					class="menuItem">Get Started</a>
				</td></tr>
				
				 <tr><td align="center">
				 <br/>
				<a href="action.php?t=c" 
				onclick="return com.jschart.get(this, 'mainBody');" 
					class="menuItem">Contact Us</a>
				</td></tr>


				 <tr><td align="center">
				 <br/>
				<a href="tilePrice.html" 
				onclick="return com.jschart.get(this, 'mainBody');" 
					class="menuItem">Price</a>
				</td></tr>				
				
 				<tr><td align="center">
 				<br/>
				<a href="action.php?t=ll" 
					onclick="return com.jschart.get(this, 'mainBody');" 
					class="menuItem">  Login  </a>
				</td></tr>				
								
				</table>

				
				</td>
				<td >
				
				
				<table cellpadding="0" cellspacing="0" width="100%" height="100%">
					<tr><td valign="top" align="center" colspan="3" height="550" class="mainBody" id="mainBody" width="700">
					<?php
						include("tile.php");
					?>
					</td></tr>
				</table>
			
				
				</td>
			</tr>
		</table>
<br/>
		<table cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<td class="footerLinkCell" colspan="3" align="center"
					valign="middle"><a href="index.html" class="footerLink">Home</a><span
					class="js_linkSeparator">|</span><a href="license.html"
					onclick="iGet(this, 8, 'mainBody');return false;" class="footerLink">License</a></td>
			</tr>
			<tr>
				<td colspan="3" align="center" valign="middle"><br>
				<img src="image/logo_20.png" align="absmiddle"/> <span class="footer">Copyright © JS Chart Inc.</span><br>
				<br>
			</tr>
		</table>
		</td>
	</tr>
</table>
</center>
</body>
</html>
