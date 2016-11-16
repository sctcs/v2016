<?php

class Map {
	var $KEY_JS_CHART_BUS_ROUTE = "ABQIAAAA39OJ0CizMzhLlfb1Rn0RzxRKk2qJdEiZbJIT_3pt-hwBU7JyFRQTt13txG64yudZGb7D8WOa8OnEYQ"; 
	var $KEY_JS_CHART = "ABQIAAAA39OJ0CizMzhLlfb1Rn0RzxRpezy7lXCFdYmPKPBsSm3shYEKVxQx3eS4NqMiBPR0Zz4xQrb48H848Q";
	var $KEY_CHINESE_SCHOOL = "ABQIAAAA39OJ0CizMzhLlfb1Rn0RzxSFujQplkgj8COPO9uAfqNfheSh1xQrrZ0wQ8L79O05P_PB_L96ANoOqw";
	var $KEY_ACQCHEM_RIVER = "ABQIAAAA39OJ0CizMzhLlfb1Rn0RzxSgjOxvdr_9Qakomu5SpZ9UKWPlWhS5AK1vMpu_lv0N7HG9c0MM7IHrSQ";
	
	function showMap($key, $address, $width=500, $height=400) {
   		$h =& $this->h;
   		pn("<br/>");
		pn("<script src=\"http://maps.google.com/maps?file=api&amp;v=2&amp;key=".$key."\" type=\"text/javascript\"></script>"); 
		pn("<script type=\"text/javascript\">");
		
		pn("var map;");
		pn("function load() {");
		pn("if (GBrowserIsCompatible()) {");
		pn("map = new GMap2(document.getElementById(\"map\"));");		
		pn("map.addControl(new GSmallMapControl());");
		pn("map.addControl(new GMapTypeControl());");
		pn("showAddress('".$address."');");
		pn("}");
		pn("}");
		pn("function showAddress(address) {");
		pn("var geocoder = new GClientGeocoder();");
		pn("geocoder.getLatLng(");
		pn("address,");
		pn("function(point) {");
		pn("if (!point) {");
		pn("alert(address + \" not found\");");
		pn("} else {");
		pn("map.setCenter(point, 13);");
		pn("var marker = new GMarker(point);");
		pn("map.addOverlay(marker);");
		pn("//marker.openInfoWindowHtml(address);");
		pn("}");
		pn("}");
		pn(");");
		pn("}");
		pn("</script>");
		pn("<div id=\"map\" style=\"width:".$width."px; height:".$height."px\"></div>"); 				
	}
}
