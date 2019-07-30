<!--LOAD PAGE ON======================================================================================================-->
<SCRIPT LANGUAGE="JavaScript">
// create a new Date object then get the current time
var start = new Date();
var startsec = start.getTime();

// run a loop counting up to 250,000
var num = 0;
for( var i = 0; i < 250000; i++ )
{
  num++;
}

var stop  = new Date();
var stopsec = stop.getTime();

var loadtime = ( stopsec - startsec ) / 1000;

</script>
<!--LOAD PAGE ON======================================================================================================-->  
<!--Googlemap========================================================================================================-->
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?v=3&amp;sensor=false&amp;key=AIzaSyD3VSb2IYSKdPdcDWFffqh0pGy9S47Klzk"></script>
<script language="javascript">
	function ResumeLang(tapmenu,id,lang,label_id){
		document.getElementById("Rlang").value=""+lang; //			
		if(document.getElementById("TapMenu").value==""){tapmenu="history";}else{tapmenu=document.getElementById("TapMenu").value;}
		ResumeTap(tapmenu,'','',lang,label_id);
	
	}
	function SendResume(tapmenu,id,lang,label_id){
				document.getElementById("TapMenu").value=""+tapmenu; //
				if(document.getElementById("Rlang").value==""){lang='th';document.getElementById("Rlang").value='th' }
				ResumeTap(tapmenu,'',id,lang,label_id);
				
	
	}
</script> 
<script type="text/javascript">
window.top.maplacation(13.724713747450026,100.58092574140617);
  google.maps.event.addDomListener(window, "load", function() {
    //
    // initialize map
    //
    var map = new google.maps.Map(document.getElementById("mapdiv"), {
      center: new google.maps.LatLng(13.724713747450026,100.58092574140617),
      zoom: 15,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });
    //
    // initialize marker
    //
    var marker = new google.maps.Marker({
      position: map.getCenter(),
      draggable: true,
      map: map
    });
    //
    // intercept map and marker movements
    //
    /*google.maps.event.addListener(map, "idle", function() {
      marker.setPosition(map.getCenter());
      document.getElementById("mapoutput").innerHTML = "<a href=\"https://maps.google.com/maps?q=" + encodeURIComponent(map.getCenter().toUrlValue()) + "\" target=\"_blank\" style=\"float: right;\">Go to maps.google.com</a>Latitude: " + map.getCenter().lat().toFixed(6) + "<br>Longitude: " + map.getCenter().lng().toFixed(6);
    });*/
    google.maps.event.addListener(marker, "dragend", function(mapEvent) {
      map.panTo(mapEvent.latLng);
	  document.getElementById("mapoutput").innerHTML = "Latitude: " + map.getCenter().lat() + "<br>Longitude: " + map.getCenter().lng();
	  window.top.maplacation(map.getCenter().lat(),map.getCenter().lng());
	  
    });
    //
    // initialize geocoder
    //
    var geocoder = new google.maps.Geocoder();
    google.maps.event.addDomListener(document.getElementById("mapform"), "submit", function(domEvent) {
      if (domEvent.preventDefault){
	  window.top.maplacation(map.getCenter().lat(),map.getCenter().lng());
        domEvent.preventDefault();
      } else {
	   window.top.maplacation(map.getCenter().lat(),map.getCenter().lng());
        domEvent.returnValue = false;
      }
      geocoder.geocode({
        address: document.getElementById("mapinput").value
      }, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
          var result = results[0];
          //  document.getElementById("mapinput").value = result.formatted_address;
          if (result.geometry.viewport) {
            map.fitBounds(result.geometry.viewport);
			marker.setPosition(map.getCenter());
			document.getElementById("mapoutput").innerHTML = "Latitude: " + map.getCenter().lat() + "<br>Longitude: " + map.getCenter().lng();
			window.top.maplacation(map.getCenter().lat(),map.getCenter().lng());
          }
          else {
            map.setCenter(result.geometry.location);
          }
        } else if (status == google.maps.GeocoderStatus.ZERO_RESULTS) {
          alert("Sorry, the geocoder failed to locate the specified address.");
        } else {
          alert("Sorry, the geocoder failed with an internal error.");
        }
      });
    });
  });
  function  maplacation(lat,lng){
  document.getElementById("cad_gmaplat").value=lat;
  document.getElementById("cad_gmaplng").value=lng;
  
  
  	}
</script>
<!--END Googlemap========================================================================================================-->
<!--START LOG JOB========================================================================================================-->
<script language="javascript">
	function send_job_log(field,value,id_prs,lang,id_field_label){	
		
		function Inint_AJAX() {
  												 try { return new ActiveXObject("Msxml2.XMLHTTP"); } catch(e) {} //IE
   												 try { return new ActiveXObject("Microsoft.XMLHTTP"); } catch(e) {} //IE
   												 try { return new XMLHttpRequest(); } catch(e) {} //Native Javascript
   												 alert("XMLHttpRequest not supported")
   												 return null
											}
											var req = Inint_AJAX(); // Object
											
     											req.open('GET', 'job_log_action.php?value='+encodeURIComponent(value)+'&field='+encodeURIComponent(field)+'&lang='+encodeURIComponent(lang)+'&id_prs='+encodeURIComponent(id_prs), true); //
     											req.onreadystatechange = function() { //
          										if (req.readyState==4) {
               										if (req.status==200) { //
                    							var data=req.responseText; //		
               
													if(field=='contact'){document.getElementById(id_field_label).innerHTML=""+data; //
													}else if(field=='interview'){document.getElementById(id_field_label).innerHTML=""+data; //													
													}else if(field=='interview_date'){document.getElementById(id_field_label).innerHTML=""+data; //
													alert('ส่งการนัดการสัมภาษณ์');
													
													}else if(field=='jobregister'){
													 alert('ยื่นใบสมัครแล้วร้อยแล้ว');
													 //document.getElementById(id_field_label).innerHTML=""+data; //	
													window.location=window.location;
													}else if(field=='jobinterest'){
													alert('เพิ่มงานที่สนใจ');
													//document.getElementById(id_field_label).innerHTML=""+data; //
													window.location=window.location;
													}else if(field=='interview_acept'){
														
													 document.getElementById(field).innerHTML=""+data; //
													 
													 
													}else if(field=='interview_disagree'){
													 
													 document.getElementById(field).innerHTML=""+data; //
													 
													}else if(field=='jobinterest_del'){
														//document.getElementById(id_field_label).innerHTML=""+data; //
													 //alert(field+value+id_prs+lang+id_field_label);//
													 window.location=window.location;
													   }else if(field=='jobinterview_del'){
														//document.getElementById(id_field_label).innerHTML=""+data; //
													 //alert(field+value+id_prs+lang+id_field_label);//
													 window.location=window.location;
													   }else if(field=='jobregister_del'){
														  /// alert(field);
													//document.getElementById(id_field_label).innerHTML=""+data; //
													 //alert(field+value+id_prs+lang+id_field_label);//
													 window.location=window.location;
													   }
               										}
          										}
     										};
     										req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // 
     										req.send(null); //
	}
	function send_resume_log(field,value,id_prs,lang,id_field_label){	
		
		function Inint_AJAX() {
  								try { return new ActiveXObject("Msxml2.XMLHTTP"); } catch(e) {} //IE
   								try { return new ActiveXObject("Microsoft.XMLHTTP"); } catch(e) {} //IE
   								try { return new XMLHttpRequest(); } catch(e) {} //Native Javascript
   								alert("XMLHttpRequest not supported")
   								return null
								}
								var req = Inint_AJAX(); // Object
											
     							req.open('GET', 'job_log_action.php?value='+encodeURIComponent(value)+'&field='+encodeURIComponent(field)+'&lang='+encodeURIComponent(lang)+'&id_prs='+encodeURIComponent(id_prs), true); //
     							req.onreadystatechange = function() { //
          						if (req.readyState==4) {
               					if (req.status==200) { //
                    			var data=req.responseText; //		
               if(field=='resumeregister'){
				document.getElementById(id_field_label).innerHTML=""+data; //
				//alert(field+value+id_prs+lang+id_field_label);//
				//window.location=window.location;
				}  if(field=='resumeinterest'){
				document.getElementById(id_field_label).innerHTML=""+data; //
				//alert(field+value+id_prs+lang+id_field_label);//
				//window.location=window.location;
				} if(field=='contact'){
				document.getElementById(id_field_label).innerHTML=""+data; //
				//alert(field+value+id_prs+lang+id_field_label);//
				//window.location=window.location;
				}
									}
          							}
     								};
     	req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // 
     	req.send(null); //
		
	}
	</script>
<!--END LOG JOB========================================================================================================-->
<script language="javascript">

function Inint_AJAX() {
  												 try { return new ActiveXObject("Msxml2.XMLHTTP"); } catch(e) {} //IE
   												 try { return new ActiveXObject("Microsoft.XMLHTTP"); } catch(e) {} //IE
   												 try { return new XMLHttpRequest(); } catch(e) {} //Native Javascript
   												 alert("XMLHttpRequest not supported")
   												 return null
											}
//chk company user ====================================================================											
											function sendget(value) {
     											var req = Inint_AJAX(); //สร้าง Object
     											req.open('GET', 'chk_company_user.php?value='+encodeURIComponent(value), true); //
     											req.onreadystatechange = function() { //
          										if (req.readyState==4) {
               										if (req.status==200) { //
                    							var data=req.responseText; //
                    							document.getElementById("chkuser").innerHTML=""+data; //
               										}
          										}
     										};
     										req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); //
     										req.send(null); //
											};
// end chk company user ======================================================================
//  chk company  from submit ======================================================================
function regisCompanySubmit(lang,typ,action){
	
			var regisobj=document.company;
			var cuser=regisobj.cuser.value;
			var cpass=regisobj.cpass.value;
			var cpass2=regisobj.cpass2.value;
			var cidenum=regisobj.cidenum.value;	
			var cnation=regisobj.cnation.value;
			var cname2=regisobj.cname2.value;
			var chowknow=regisobj.chowknow.value;
			var packet=regisobj.packet.value;
			var cnation=regisobj.cnation.value;
			//var bcg=regisobj.bcg.value;
		//	var hiddbcs=regisobj.hiddbcs.value;
			var chk_error="";							
			if(cuser==""){
			document.getElementById("chkuser").innerHTML=""+"<span style=\"border:1x #FF6600 dotted; margin-left:0px;\"class=\"textbox_error\"><?=$jm_login_name;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">";
			return false; chk_error="1";
			}else if(cuser.length<4){
			document.getElementById("chkuser").innerHTML=""+"<span style=\"border:1x #FF6600 dotted; margin-left:0px;\"class=\"textbox_error\"><?=$jm_login_name;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">";
			return false; chk_error="1";}
			if(cpass==""){
			document.getElementById("password1").innerHTML=""+"<span style=\"border:1x #FF6600 dotted; margin-left:0px;\"class=\"textbox_error\"><?=$jm_login_name;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">";
			return false; chk_error="1";
			}else if(cpass.length<4){
			document.getElementById("password1").innerHTML=""+"<span style=\"border:1x #FF6600 dotted; margin-left:0px;\"class=\"textbox_error\"><?=$jm_least4_pass;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">";
			return false; chk_error="1";}else{document.getElementById("password1").innerHTML="";chk_error="";}
			if(cpass2==""){
			document.getElementById("password2").innerHTML=""+"<span style=\"border:1x #FF6600 dotted; margin-left:0px;\"class=\"textbox_error\"><?=$jm_login_name;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">";
			return false; chk_error="1";
			}else if(cpass2.length<4){
			document.getElementById("password2").innerHTML=""+"<span style=\"border:1x #FF6600 dotted; margin-left:0px;\"class=\"textbox_error\"><?=$jm_least4_pass;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">";
			return false; chk_error="1";}else{document.getElementById("password2").innerHTML="";chk_error="";}
			if(cpass!="" & cpass2!=""){	
					if(cpass != cpass2){
					document.getElementById("password2").innerHTML=""+"<span style=\"border:1x #FF6600 dotted; margin-left:0px;\"class=\"textbox_error\"><?=$jm_synchronization_pass;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">"; return false; chk_error="1";
					}
			
			}
				if(cnation==""){
			document.getElementById("lb_cnation").innerHTML=""+"<span style=\"border:1x #FF6600 dotted; margin-left:0px;\"class=\"textbox_error\"><?=$jm_select_nationality;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">";
			return false; chk_error="1";
			}else{document.getElementById("lb_cnation").innerHTML="";chk_error="";}		
			if(cidenum==""){
			document.getElementById("idenum").innerHTML=""+"<span style=\"border:1x #FF6600 dotted; margin-left:0px;\"class=\"textbox_error\"><?=$jm_card_number;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">";
			return false; chk_error="1";
			}else{
							if(cnation!="" & cnation==1 & cidenum.length==13){
							
									function checkID(id){
										if(id.length != 13) return false; chk_error="1";
										for(i=0, sum=0; i < 12; i++)
										sum += parseFloat(id.charAt(i))*(13-i); if((11-sum%11)%10!=parseFloat(id.charAt(12)))
										return false; return true;}
										 if(!checkID(cidenum))
										document.getElementById("idenum").innerHTML=""+"<span style=\"border:1x #FF6600 dotted; margin-left:0px;\"class=\"textbox_error\"><?=$jm_card_invalid_not;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">"; 
										else 
										document.getElementById("idenum").innerHTML="";
									
							}else if(cnation!="" & cnation==1 & cidenum.length<13){
									
										document.getElementById("idenum").innerHTML=""+"<span style=\"border:1x #FF6600 dotted; margin-left:0px;\"class=\"textbox_error\"><?=$jm_card_invalid_not13;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">";
										return false; chk_error="1";
									}else{document.getElementById("idenum").innerHTML="";chk_error="";}
						if(cnation!="" & cnation!=1 & cidenum.length<8 || cidenum.length >=21){
							
								document.getElementById("idenum").innerHTML=""+"<span style=\"border:1x #FF6600 dotted; margin-left:0px;\"class=\"textbox_error\"><?=$jm_card_invalid_not9;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">";
								return false; chk_error="1";
						}else if(cnation!="" & cnation!=1 & cidenum.length>=8& cidenum.length <=20){
								}
					
					}								
			if(cname2==""){
			document.getElementById("name2").innerHTML=""+"<span style=\"border:1x #FF6600 dotted; margin-left:0px;\"class=\"textbox_error\"><?=$jm_contact;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">";
			return false; chk_error="1";
			}else{ 
						if(cname2.length<4){
						document.getElementById("name2").innerHTML=""+"<span style=\"border:1x #FF6600 dotted; margin-left:0px;\"class=\"textbox_error\"><?=$jm_contact;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">";
						return false; chk_error="1";
						}else{document.getElementById("name2").innerHTML="";chk_error="";}
			}
		/*    if(bcg==""){document.getElementById("lb_bcg").innerHTML=""+"<span style=\"border:1x #FF6600 dotted; margin-left:0px;\"class=\"textbox_error\"><?=$lb_select;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">";
						return false; chk_error="1";}
			else{	document.getElementById("lb_bcg").innerHTML="";
				
					if(hiddbcs==""){
					document.getElementById("lb_hiddbcs").innerHTML=""+"<span style=\"border:1x #FF6600 dotted; margin-left:0px;\"class=\"textbox_error\"><?=$lb_select;?> <?=$lb_business_class;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">";
						return false; chk_error="1";
					}else{document.getElementById("lb_hiddbcs").innerHTML="";}
			}*/
			if(chowknow==""){
			document.getElementById("know").innerHTML=""+"<span style=\"border:1x #FF6600 dotted; margin-left:0px;\"class=\"textbox_error\"><?=$jm_know_us;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">";
			return false; chk_error="1";
			}else if(chowknow.length<8){ document.getElementById("know").innerHTML=""+"<span style=\"border:1x #FF6600 dotted; margin-left:0px;\"class=\"textbox_error\"><?=$jm_specify_more;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">";
			return false; chk_error="1";
			}else{document.getElementById("know").innerHTML="";chk_error="";}
		if(chk_error =="" & action=='action'){	
		//alert(chk_error);
			document.company.target='_parent';
			document.company.action='company_action.php?lang='+lang+'&type='+typ;								
			document.company.submit();
			return true;
			}
}
//  end company  from submit ======================================================================
//bcgtobcs_listbox============================================================================
function bcgtobcj(value,sendto,lang){
						function Inint_AJAX() {
  												 try { return new ActiveXObject("Msxml2.XMLHTTP"); } catch(e) {} //IE
   												 try { return new ActiveXObject("Microsoft.XMLHTTP"); } catch(e) {} //IE
   												 try { return new XMLHttpRequest(); } catch(e) {} //Native Javascript
   												 alert("XMLHttpRequest not supported")
   												 return null
											}
											var req = Inint_AJAX(); //
     											req.open('GET', 'bcgtobcs_listbox.php?value='+encodeURIComponent(value)+'&sendto='+encodeURIComponent(sendto)+'&lang='+encodeURIComponent(lang), true); //
     											req.onreadystatechange = function() { //
          										if (req.readyState==4) {
               										if (req.status==200) { //
                    							var data=req.responseText; //
												
                    							document.getElementById("bcgtobcs_listbox").innerHTML=""+data; //
               										}
          										}
     										};
     										req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); //H
     										req.send(null); //
		};// end countsendprovince
//end bcgtobcs_listbox===========================================================================
function bcssave(data){
	//alert(data);
		document.company.hiddbcs.value = document.company.hiddbcs.value=data ;
	}
//===========================================================================================
</script>
<script language="javascript" >
//chk person user
			
			function sendget2(value) {
			
			function Inint_AJAX() {
  												 try { return new ActiveXObject("Msxml2.XMLHTTP"); } catch(e) {} //IE
   												 try { return new ActiveXObject("Microsoft.XMLHTTP"); } catch(e) {} //IE
   												 try { return new XMLHttpRequest(); } catch(e) {} //Native Javascript
   												 alert("XMLHttpRequest not supported")
   												 return null
											}
     											var req = Inint_AJAX(); // Object
     											req.open('GET', 'chk_person_user.php?value='+encodeURIComponent(value), true); //
     											req.onreadystatechange = function() { //
          										if (req.readyState==4) {
               										if (req.status==200) { //
                    							var data=req.responseText; //
                    							document.getElementById("chkpuser").innerHTML=""+data; //
												
               										}
          										}
     										};
     										req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); //
     										req.send(null); //
											};
											// end chk person user
	//chk person email
			
			function sendget3(value,lang) {
			
			function Inint_AJAX() {
  												 try { return new ActiveXObject("Msxml2.XMLHTTP"); } catch(e) {} //IE
   												 try { return new ActiveXObject("Microsoft.XMLHTTP"); } catch(e) {} //IE
   												 try { return new XMLHttpRequest(); } catch(e) {} //Native Javascript
   												 alert("XMLHttpRequest not supported")
   												 return null
											}
     											var req = Inint_AJAX(); // Object
     											req.open('GET', 'chk_person_email.php?value='+encodeURIComponent(value)+'&lang='+lang, true); //
     											req.onreadystatechange = function() { //
          										if (req.readyState==4) {
               										if (req.status==200) { //
                    							var data=req.responseText; //
												if(data=='false'){document.getElementById("chkpmail").innerHTML="<span style=\"border:0x #FF6600 dotted; margin-left:0px;\"class=\"textbox_side\"><?=$jm_email_is_not2;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">";} 
												if(data=='true'){document.getElementById("chkpmail").innerHTML="";}
												
                    							//document.getElementById("chkpmail").innerHTML=data; //
												
												document.personal.c_mail.value = data;
												
											
               										}
          										}
     										};
     										req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); //
     										req.send(null); //
											};
											// end chk person email
	
	function regispersonalSubmit(retrunmail,lang){
	
			var regisobj=document.personal;
			var puser=regisobj.puser.value;
			var ppass=regisobj.ppass.value;
			var ppass2=regisobj.ppass2.value;
			var pmail=regisobj.pmail.value;	
			var c_mail=regisobj.c_mail.value;
	
			if(puser==""){
			document.getElementById("chkpuser").innerHTML=""+"<span style=\"border:0x #FF6600 dotted; margin-left:0px;\"class=\"textbox_side\"><?=$jm_login_name;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">";
			//alert('<?=$jm_login_name;?>');
			regisobj.puser.focus();
			return false;
			}else if(puser.length<4){
					document.getElementById("chkpuser").innerHTML=""+"<span style=\"border:0x #FF6600 dotted; margin-left:0px;\"class=\"textbox_side\"><?=$jm_least4;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">";
				//	alert('<?=$jm_least4;?>');regisobj.puser.focus();
					return false;}else  { 
					document.getElementById("chkpuser").innerHTML="";
					
					}
			
			if(ppass==""){
			//alert('<?=$jm_enter_pass;?>');
			
			document.getElementById("chkpass").innerHTML=""+"<span style=\"border:0x #FF6600 dotted; margin-left:0px;\"class=\"textbox_side\"><?=$jm_enter_pass;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">";
			
			return false;
			} if(ppass.length<4){
			document.getElementById("chkpass").innerHTML=""+"<span style=\"border:0x #FF6600 dotted; margin-left:0px;\"class=\"textbox_side\"><?=$jm_least4_pass;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">";
			//alert('<?=$jm_least4_pass;?>');
			
			return false;
			}else { 
			document.getElementById("chkpass").innerHTML=""+"";
			
			}
			if(ppass2==""){
			//alert('<?=$jm_enter_pass_confirm;?>');
			
			document.getElementById("chkpass2").innerHTML=""+"<span style=\"border:0x #FF6600 dotted; margin-left:0px;\"class=\"textbox_side\"><?=$jm_enter_pass_confirm;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">";
			return false;
			} if(ppass2.length<4){
			document.getElementById("chkpass2").innerHTML=""+"<span style=\"border:0x #FF6600 dotted; margin-left:0px;\"class=\"textbox_side\"><?=$jm_least4_pass;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">";
			//alert('<?=$jm_least4_pass;?>');
			
			return false;
			}else{ 
			document.getElementById("chkpass2").innerHTML=""+"";
		
			}
			
			if(ppass!="" && ppass2!="" ){
				if(ppass!=ppass2){//alert('<?=$jm_synchronization_pass;?>');
				document.getElementById("chkpass").innerHTML=""+"<span style=\"border:0x #FF6600 dotted; margin-left:0px;\"class=\"textbox_side\"><?=$jm_synchronization_pass;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">";
				document.getElementById("chkpass2").innerHTML=""+"<span style=\"border:0x #FF6600 dotted; margin-left:0px;\"class=\"textbox_side\"><?=$jm_synchronization_pass;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">";
				
				return false;
				}else  { 
				document.getElementById("chkpass").innerHTML=""+"";
				document.getElementById("chkpass2").innerHTML=""+"";
			
							}
				
			}
			
			if(pmail==""){
			/*var l=document.cookie="lang=<?=$_COOKIE['lang'];?>";
												alert(l);*/
			document.getElementById("chkpmail").innerHTML=""+"<span style=\"border:0x #FF6600 dotted; margin-left:0px;\"class=\"textbox_side\"><?=$jm_email;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">";
			document.personal.c_mail.value = '';
			regisobj.pmail.focus();
			return false;
			}else if ((pmail.indexOf('@') == -1) || (pmail.indexOf('.') == -1)) {
						//alert('<?=$jm_email_is_not;?>');
						//regisobj.pmail.focus();
						document.getElementById("chkpmail").innerHTML=""+"<span style=\"border:0x #FF6600 dotted; margin-left:0px;\"class=\"textbox_side\"><?=$jm_email_is_not;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">";
						document.personal.c_mail.value = '';
			regisobj.pmail.focus();
			return false;
					}else{
					//"com|net|org|edu|int|mil|gov|arpa|biz|aero|name|coop|info|pro|museum|co.th|net.th|ac.th|go.th|or.th|in.th|mi.th|me|us|tv|ca|mobi|name|tel|co.uk|org.uk|asia|ws|bz|de|es|cc|la|nu|com.au";
					var dnsname=pmail.split("@");
					var  hostname=dnsname[1].split(".");
					//document.getElementById("chkpmail").innerHTML="'"+hostname.length;
									if(hostname[0].length<=2){
										document.getElementById("chkpmail").innerHTML=""+"<span style=\"border:0x #FF6600 dotted; margin-left:0px;\"class=\"textbox_side\"><?=$jm_email_is_not;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">";document.personal.c_mail.value = '';
										return false;
									}else //{  document.getElementById("chkpmail").innerHTML="";}
									if(hostname[1].length<=1){
									document.getElementById("chkpmail").innerHTML=""+"<span style=\"border:0x #FF6600 dotted; margin-left:0px;\"class=\"textbox_side\"><?=$jm_email_is_not;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">";document.personal.c_mail.value = '';
									regisobj.pmail.focus();
			return false;
									}else{  //document.getElementById("chkpmail").innerHTML="";
									sendget3(pmail,'');
									if(document.personal.c_mail.value=='' || document.personal.c_mail.value=='false'){
										return false;
										}
									}
								
								
								}	
	
	}
	
	//add new admin
	function add_new_admin(value) {
			
			if(document.person.puser.value!=""){
			function Inint_AJAX() 
			     {
    				 try { return new ActiveXObject("Msxml2.XMLHTTP"); } catch(e) {} //IE
   					 try { return new ActiveXObject("Microsoft.XMLHTTP"); } catch(e) {} //IE
   				     try { return new XMLHttpRequest(); } catch(e) {} //Native Javascript
   					 alert("XMLHttpRequest not supported")
   					 return null
				}
     				var req = Inint_AJAX(); // Object
     				req.open('GET', 'chk_admin_user.php?value='+encodeURIComponent(value), true); //
     				req.onreadystatechange = function() { //
          			if (req.readyState==4) {
               		if (req.status==200) { //
                    var data=req.responseText; //
                    document.getElementById("chkpuser").innerHTML=""+data; //
												
               			}
          				}
     			  };
     			  req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); //
     			  req.send(null); // 
				err='none'; }else{err='error'; return false;}
				  if(document.person.newpass.value==""){
			
			document.getElementById("lb_newpass").innerHTML=""+"<span style=\"border:1x #FF6600 dotted; margin-left:0px;\"class=\"textbox_side\"><?=$jm_enter_pass;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">";
			err='error';
			return false;
			} if(document.person.newpass.value.length<4){
			document.getElementById("lb_newpass").innerHTML=""+"<span style=\"border:1x #FF6600 dotted; margin-left:0px;\"class=\"textbox_side\"><?=$jm_least4_pass;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">";
			err='error';
			return false;
			}else { 
			document.getElementById("lb_newpass").innerHTML=""+"";
			err='none';
			}
			
		if(document.person.newpass2.value==""){
			
			
			document.getElementById("lb_newpass2").innerHTML=""+"<span style=\"border:1x #FF6600 dotted; margin-left:0px;\"class=\"textbox_side\"><?=$jm_enter_pass_confirm;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">";
			err='error';
			return false;
			} if(document.person.newpass2.value.length<4){
			document.getElementById("lb_newpass2").innerHTML=""+"<span style=\"border:1x #FF6600 dotted; margin-left:0px;\"class=\"textbox_side\"><?=$jm_least4_pass;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">";
			
			err='error';
			return false;
			}else{ 
			document.getElementById("lb_newpass2").innerHTML=""+"";
			err='none';
			}
		if(document.person.newpass.value!="" && document.person.newpass2.value!="" ){
				if(document.person.newpass.value!=document.person.newpass2.value){
				document.getElementById("lb_newpass").innerHTML=""+"<span style=\"border:1x #FF6600 dotted; margin-left:20px;\"class=\"textbox_side\"><?=$jm_synchronization_pass;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">";
				document.getElementById("lb_newpass2").innerHTML=""+"<span style=\"border:1x #FF6600 dotted; margin-left:0px;\"class=\"textbox_side\"><?=$jm_synchronization_pass;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">";
				err='error';
				return false;
				}else  { 
				document.getElementById("lb_newpass").innerHTML=""+"";
				document.getElementById("lb_newpass2").innerHTML=""+"";
				err='none';
							}
				
			}
	  if(document.person.permis.value==""){
	 document.getElementById("lb_permis").innerHTML=""+"<span style=\"border:1x #FF6600 dotted; margin-left:0px;\"class=\"textbox_side\">ยังไม่เลือกสิทธิ์การจัดการ ข้อมูล</span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">";
	 err='error';
	 return false;}else{document.getElementById("lb_permis").innerHTML=""+"";err='none';}							
  // if(err=="none" && document.person.active.value=='action'  ){alert(err);
    //document.person.bcg_id.value=document.person.bcg_id.value=bcg_id;
	//document.person.bcs_id.value=document.person.bcs_id.value=bcs_id;
	//document.person.hiddenField.value=document.person.hiddenField.value='bsc_del';
	//document.person.action="./admin_action.php";
	//document.person.submit();
	//alert(document.person.active.value);
	 //if(err=="error"  ){alert(err);}
//	 return true;
//	 }
   	
    }
	// end add new admin
											
											
											
	 function renewpassword(act,lang){
	 		var renew=document.person;
			var oldpass=renew.oldpass.value;
			var returnpass=renew.returnpass.value;
			var newpass=renew.newpass.value;
			var newpass2=renew.newpass2.value;
			//var msg_err="";
			if(oldpass!="" ){
				function Inint_AJAX() {
  												 try { return new ActiveXObject("Msxml2.XMLHTTP"); } catch(e) {} //IE
   												 try { return new ActiveXObject("Microsoft.XMLHTTP"); } catch(e) {} //IE
   												 try { return new XMLHttpRequest(); } catch(e) {} //Native Javascript
   												 alert("XMLHttpRequest not supported")
   												 return null
											}
											var req = Inint_AJAX(); //Create Object
     											req.open('GET', 'chk_pass.php?oldpass='+encodeURIComponent(oldpass), true); //
     											req.onreadystatechange = function() { //
          										if (req.readyState==4) {
               										if (req.status==200) { //
                    							var data=req.responseText; //
													
												 if(data==0 ){document.getElementById("lb_oldpass").innerHTML=""+"<span style=\"border:1x #FF6600 dotted; margin-left:0px;\"class=\"textbox_side\"><?=$jm_old_pass;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">"; msg_err=+'<?=$jm_enter_pass;?>';return false;}else
			if(data==1){document.getElementById("lb_oldpass").innerHTML=""; msg_err="";}
               										}
          										}
     										};
											req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // 
     										req.send(null); //
			}else{
			document.getElementById("lb_oldpass").innerHTML=""+"<span style=\"border:1x #FF6600 dotted; margin-left:0px;\"class=\"textbox_side\"><?=$jm_enter_pass;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">";msg_err=+'<?=$jm_enter_pass;?>';
			}
			
			
	 		if(newpass==""){ 
			document.getElementById("lb_newpass").innerHTML=""+"<span style=\"border:1x #FF6600 dotted; margin-left:0px;\"class=\"textbox_side\"><?=$jm_enter_pass_confirm;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">";msg_err=newpass;
			return false;
			} if(newpass.length<4){
			document.getElementById("lb_newpass").innerHTML=""+"<span style=\"border:1x #FF6600 dotted; margin-left:0px;\"class=\"textbox_side\"><?=$jm_least4_pass;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">";msg_err=newpass;
			return false;
			}else{ document.getElementById("lb_newpass").innerHTML="";}
			
				if(newpass2==""){ 
			document.getElementById("lb_newpass2").innerHTML=""+"<span style=\"border:1x #FF6600 dotted; margin-left:0px;\"class=\"textbox_side\"><?=$jm_enter_pass_confirm;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">";msg_err=newpass2;
			return false;
			} if(newpass2.length<4){
			document.getElementById("lb_newpass2").innerHTML=""+"<span style=\"border:1x #FF6600 dotted; margin-left:0px;\"class=\"textbox_side\"><?=$jm_least4_pass;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">";msg_err=newpass2;
			return false;
			}else{ document.getElementById("lb_newpass2").innerHTML="";}
			if(newpass!="" & newpass.length>=4 & newpass2!="" & newpass2.length>=4 & newpass != newpass2){
			document.getElementById("lb_newpass2").innerHTML=""+"<span style=\"border:1x #FF6600 dotted; margin-left:0px;\"class=\"textbox_side\"><?=$jm_synchronization_pass;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">";
			document.getElementById("lb_newpass").innerHTML=""+"<span style=\"border:1x #FF6600 dotted; margin-left:0px;\"class=\"textbox_side\"><?=$jm_synchronization_pass;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">";msg_err=newpass2;
			}
			if(msg_err=="" & act=="1"){

			sendedit('changpass',document.person.newpass.value,'prs_id',lang,'person_wizards_changepass');
		
			
			}else{document.getElementById("lb_submit").innerHTML="";}
			
	 }
	 //
	 	 function renewpassword_company(act,lang){
	 		var renew=document.person;
			var oldpass=renew.oldpass.value;
			var returnpass=renew.returnpass.value;
			var newpass=renew.newpass.value;
			var newpass2=renew.newpass2.value;
			//var msg_err="";
			if(oldpass!="" ){
				function Inint_AJAX() {
  												 try { return new ActiveXObject("Msxml2.XMLHTTP"); } catch(e) {} //IE
   												 try { return new ActiveXObject("Microsoft.XMLHTTP"); } catch(e) {} //IE
   												 try { return new XMLHttpRequest(); } catch(e) {} //Native Javascript
   												 alert("XMLHttpRequest not supported")
   												 return null
											}
											var req = Inint_AJAX(); //Create Object
     											req.open('GET', 'chk_pass2.php?oldpass='+encodeURIComponent(oldpass), true); //
     											req.onreadystatechange = function() { //
          										if (req.readyState==4) {
               										if (req.status==200) { //
                    							var data=req.responseText; //
													
												 if(data==0 ){document.getElementById("lb_oldpass").innerHTML=""+"<span style=\"border:1x #FF6600 dotted; margin-left:0px;\"class=\"textbox_side\"><?=$jm_old_pass;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">"; msg_err=+'<?=$jm_enter_pass;?>';return false;}else
			if(data==1){document.getElementById("lb_oldpass").innerHTML=""; msg_err="";}
               										}
          										}
     										};
											req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // 
     										req.send(null); //
			}else{
			document.getElementById("lb_oldpass").innerHTML=""+"<span style=\"border:1x #FF6600 dotted; margin-left:0px;\"class=\"textbox_side\"><?=$jm_enter_pass;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">";msg_err=+'<?=$jm_enter_pass;?>';
			}
			
			
	 		if(newpass==""){ 
			document.getElementById("lb_newpass").innerHTML=""+"<span style=\"border:1x #FF6600 dotted; margin-left:0px;\"class=\"textbox_side\"><?=$jm_enter_pass_confirm;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">";msg_err=newpass;
			return false;
			} if(newpass.length<4){
			document.getElementById("lb_newpass").innerHTML=""+"<span style=\"border:1x #FF6600 dotted; margin-left:0px;\"class=\"textbox_side\"><?=$jm_least4_pass;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">";msg_err=newpass;
			return false;
			}else{ document.getElementById("lb_newpass").innerHTML="";}
			
				if(newpass2==""){ 
			document.getElementById("lb_newpass2").innerHTML=""+"<span style=\"border:1x #FF6600 dotted; margin-left:0px;\"class=\"textbox_side\"><?=$jm_enter_pass_confirm;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">";msg_err=newpass2;
			return false;
			} if(newpass2.length<4){
			document.getElementById("lb_newpass2").innerHTML=""+"<span style=\"border:1x #FF6600 dotted; margin-left:0px;\"class=\"textbox_side\"><?=$jm_least4_pass;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">";msg_err=newpass2;
			return false;
			}else{ document.getElementById("lb_newpass2").innerHTML="";}
			if(newpass!="" & newpass.length>=4 & newpass2!="" & newpass2.length>=4 & newpass != newpass2){
			document.getElementById("lb_newpass2").innerHTML=""+"<span style=\"border:1x #FF6600 dotted; margin-left:0px;\"class=\"textbox_side\"><?=$jm_synchronization_pass;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">";
			document.getElementById("lb_newpass").innerHTML=""+"<span style=\"border:1x #FF6600 dotted; margin-left:0px;\"class=\"textbox_side\"><?=$jm_synchronization_pass;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">";msg_err=newpass2;
			}
			if(msg_err=="" & act=="1"){
			//alert('');
			sendedit_cpn('changpass',document.person.newpass.value,'prs_id',lang,'company_seting');
			
			
			}else{document.getElementById("lb_submit").innerHTML="";}
			
	 }
	 //
	 function renewpasswordadmin(act,lang){
	 		var renew=document.person;
			var oldpass=renew.oldpass.value;
			var returnpass=renew.returnpass.value;
			var newpass=renew.newpass.value;
			var newpass2=renew.newpass2.value;
			//var msg_err="";
			
			if(oldpass!="" ){
				function Inint_AJAX() {
  												 try { return new ActiveXObject("Msxml2.XMLHTTP"); } catch(e) {} //IE
   												 try { return new ActiveXObject("Microsoft.XMLHTTP"); } catch(e) {} //IE
   												 try { return new XMLHttpRequest(); } catch(e) {} //Native Javascript
   												 alert("XMLHttpRequest not supported")
   												 return null
											}
											var req = Inint_AJAX(); //Create Object
     											req.open('GET', 'admin_convert_pass.php?oldpass='+encodeURIComponent(oldpass), true); //
     											req.onreadystatechange = function() { //
          										if (req.readyState==4) {
               										if (req.status==200) { //
                    							var data=req.responseText; //
												
			
		if(data==0 ){document.getElementById("lb_oldpass").innerHTML=""+"<span style=\"border:1x #FF6600 dotted; margin-left:0px;\"class=\"textbox_side\"><?=$jm_old_pass;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">"; msg_err=+'<?=$jm_enter_pass;?>';return false;}else

if(data==1){document.getElementById("lb_oldpass").innerHTML=""; msg_err="";}
               										}
          										}
     										};
											req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // 
     										req.send(null); //
			}else{
			
			document.getElementById("lb_oldpass").innerHTML=""+"<span style=\"border:1x #FF6600 dotted; margin-left:0px;\"class=\"textbox_side\"><?=$jm_enter_pass;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">";msg_err=+'<?=$jm_enter_pass;?>';
			}
			
			
	 		if(newpass==""){ 
			document.getElementById("lb_newpass").innerHTML=""+"<span style=\"border:1x #FF6600 dotted; margin-left:0px;\"class=\"textbox_side\"><?=$jm_enter_pass_confirm;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">";msg_err=newpass;
			return false;
			} if(newpass.length<4){
			document.getElementById("lb_newpass").innerHTML=""+"<span style=\"border:1x #FF6600 dotted; margin-left:0px;\"class=\"textbox_side\"><?=$jm_least4_pass;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">";msg_err=newpass;
			return false;
			}else{ document.getElementById("lb_newpass").innerHTML="";}
			
				if(newpass2==""){ 
			document.getElementById("lb_newpass2").innerHTML=""+"<span style=\"border:1x #FF6600 dotted; margin-left:0px;\"class=\"textbox_side\"><?=$jm_enter_pass_confirm;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">";msg_err=newpass2;
			return false;
			} if(newpass2.length<4){
			document.getElementById("lb_newpass2").innerHTML=""+"<span style=\"border:1x #FF6600 dotted; margin-left:0px;\"class=\"textbox_side\"><?=$jm_least4_pass;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">";msg_err=newpass2;
			return false;
			}else{ document.getElementById("lb_newpass2").innerHTML="";}
			if(newpass!="" & newpass.length>=4 & newpass2!="" & newpass2.length>=4 & newpass != newpass2){
			document.getElementById("lb_newpass2").innerHTML=""+"<span style=\"border:1x #FF6600 dotted; margin-left:0px;\"class=\"textbox_side\"><?=$jm_synchronization_pass;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">";
			document.getElementById("lb_newpass").innerHTML=""+"<span style=\"border:1x #FF6600 dotted; margin-left:0px;\"class=\"textbox_side\"><?=$jm_synchronization_pass;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">";msg_err=newpass2;
			}
			if(msg_err=="" & act=="1"){

			//sendedit('changpass',document.person.newpass.value,'prs_id',lang,'person_seting');
			
			var acept=confirm('ต้องการเปลี่ยนรหัสผ่าน??')
			if(acept==true){
			
			document.person.newpass.value=document.person.newpass.value;
			document.person.hiddenField.value=document.person.hiddenField.value='changpass';
			document.person.action="./admin_action.php";
			document.person.submit();
			}else{ }
		
			
			}else{document.getElementById("lb_submit").innerHTML="";}
			
	 }
	 //=============
	function verify_email(pmail,label_id,msg){
						function Inint_AJAX() {
  												 try { return new ActiveXObject("Msxml2.XMLHTTP"); } catch(e) {} //IE
   												 try { return new ActiveXObject("Microsoft.XMLHTTP"); } catch(e) {} //IE
   												 try { return new XMLHttpRequest(); } catch(e) {} //Native Javascript
   												 alert("XMLHttpRequest not supported")
   												 return null
											}
											var req = Inint_AJAX(); //สร้าง Object
     											req.open('GET', 'chk_email.php?pmail='+encodeURIComponent(pmail)+'&label_id='+encodeURIComponent(label_id)+'&msg='+encodeURIComponent(msg), true); //
     											req.onreadystatechange = function() { //
          										if (req.readyState==4) {
               										if (req.status==200) { //
                    							var data=req.responseText; //
												
                    							document.getElementById(label_id).innerHTML=""+data; //
               										}
          										}
     										};
											req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // 
     										req.send(null); //
	}
	function verify_email2(pmail,label_id,msg){
						function Inint_AJAX() {
  												 try { return new ActiveXObject("Msxml2.XMLHTTP"); } catch(e) {} //IE
   												 try { return new ActiveXObject("Microsoft.XMLHTTP"); } catch(e) {} //IE
   												 try { return new XMLHttpRequest(); } catch(e) {} //Native Javascript
   												 alert("XMLHttpRequest not supported")
   												 return null
											}
											var req = Inint_AJAX(); //สร้าง Object
     											req.open('GET', 'chk_email2.php?pmail='+encodeURIComponent(pmail)+'&label_id='+encodeURIComponent(label_id)+'&msg='+encodeURIComponent(msg), true); //
     											req.onreadystatechange = function() { //
          										if (req.readyState==4) {
               										if (req.status==200) { //
                    							var data=req.responseText; //
												
                    							document.getElementById(label_id).innerHTML=""+data; //
               										}
          										}
     										};
											req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // 
     										req.send(null); //
	}
</script>

<script language="javascript">
		function countsendprovince(value,sendto,lang){
		//alert(value);alert(sendto);alert(lang);
						function Inint_AJAX() {
  												 try { return new ActiveXObject("Msxml2.XMLHTTP"); } catch(e) {} //IE
   												 try { return new ActiveXObject("Microsoft.XMLHTTP"); } catch(e) {} //IE
   												 try { return new XMLHttpRequest(); } catch(e) {} //Native Javascript
   												 alert("XMLHttpRequest not supported")
   												 return null
											}
											var req = Inint_AJAX(); // Object
											
     											req.open('GET', 'chang_to_listbox.php?value='+encodeURIComponent(value)+'&sendto='+encodeURIComponent(sendto)+'&lang='+encodeURIComponent(lang), true); //
     											req.onreadystatechange = function() { //
          										if (req.readyState==4) {
               										if (req.status==200) { //
                    							var data=req.responseText; //
												
                    							document.getElementById("listprovince").innerHTML=""+data; //
               										}
          										}
     										};
     										req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // 
     										req.send(null); //
						provincesendtodistrict(value,sendto,lang);
		};// end countsendprovince	
		
</script>
<script language="javascript">
		function provincesendtodistrict(value,sendto,lang){
		//alert(value);alert(sendto);alert(lang);
						function Inint_AJAX() {
  												 try { return new ActiveXObject("Msxml2.XMLHTTP"); } catch(e) {} //IE
   												 try { return new ActiveXObject("Microsoft.XMLHTTP"); } catch(e) {} //IE
   												 try { return new XMLHttpRequest(); } catch(e) {} //Native Javascript
   												 alert("XMLHttpRequest not supported")
   												 return null
											}
											var req = Inint_AJAX(); // 
     											req.open('GET', 'chang_to_listbox2.php?value='+encodeURIComponent(value)+'&sendto='+encodeURIComponent(sendto)+'&lang='+encodeURIComponent(lang), true); //
     											req.onreadystatechange = function() { //
          										if (req.readyState==4) {
               										if (req.status==200) { //
                    							var data=req.responseText; //
												
                    							document.getElementById("listdistrict").innerHTML=""+data; //
               										}
          										}
     										};
     										req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // 
     										req.send(null); //
		};// end countsendprovince
</script>
<script language="javascript">
		function savevalue(data){
				  
				document.getElementById("province_name").value = document.getElementById("province_name").value =data ;
				
						
		}
		function savevalue2(data){
		
		document.getElementById("district_name").value  = document.getElementById("district_name").value=data ;
		}	
		function savevalue3(data){
		
		document.getElementById("district_name").value  = document.getElementById("district_name").value=data ;
		}	
</script>
<script  language="javascript">
function  senselectlist(dataset,value,lang){
<?
							$army_th=array("ผ่านเกณฑ์ทหารแล้ว","รอเกณฑ์ทหาร","ได้รับการยกเว้น");
							$army_en=array("Passed","Waiting","Exempted");
							$army_jp=array("免除"," 待っている","渡された");
							if($lang=="lc" or $lang=="th" or $lang==""){$army_lang=$army_th; $lb_select="กรุณาเลือก";}
							if($lang=="en"){$army_lang=$army_en;$lb_select="Please select";}
							if($lang=="jp"){$army_lang=$army_jp;$lb_select="選択してください。";}
							
?>
							var  army_th=Array("ผ่านเกณฑ์ทหารแล้ว","รอเกณฑ์ทหาร","ได้รับการยกเว้น");
							var army_en=Array("Passed","Waiting","Exempted");
							var army_jp=Array("免除"," 待っている","渡された");
							if(lang=='lc' || lang=="th" || lang==""){army_lang=army_th; lb_select="กรุณาเลือก";}
							if(lang=='en'){army_lang=army_en;lb_select="Please select";}
							if(lang=='jp'){army_lang=army_jp;lb_select="選択してください。";}
///alert(lang+value);
if(value>0){var arrmy_name=army_lang[value-1];arrmy_value=value;}else{ arrmy_name=lb_select;arrmy_value=0;}
if(dataset=="m") { 
document.company.militarystatus.options.length = 0;
document.company.militarystatus.options[0]=new Option(arrmy_name,arrmy_value);
document.company.militarystatus.options[1]=new Option(army_lang[0],"1");
document.company.militarystatus.options[2]=new Option(army_lang[1],"2");
document.company.militarystatus.options[3]=new Option(army_lang[2],"3");
}else if(dataset=="f"){
document.company.militarystatus.options.length = 0;
//document.company.militarystatus.options[0]=new Option(lb_select,"0");
document.company.militarystatus.options[0]=new Option(army_lang[2],"3");
}
}
</script>
<script language="javascript">
	function multi_country(data){
		
		document.getElementById("countrty_name").value = document.getElementById("countrty_name").value+data  ;
	
	}
</script>
    <script language="javascript">
	function getcountry(field,savedata){
	if(field=="country"){
	document.company.hid_country.value="";
	document.company.hid_country.value=document.company.hid_country.value+document.company.cad_country.value+'|';
	}
	if(field=="province"){
	//var str=document.company.hid_country.value;
	//text[]=str.split("|");
	//alert(text[0]);alert(text[1]);
	//document.company.hid_country.value=document.company.hid_country.value+'|'+document.company.province_name.value;
	}
	//document.company.hid_country.value=document.company.hid_country.value+'|'+document.company.district_name.value;
		}
	</script> 
     
<script language="javascript">
		function bcgtobcj2(value,sendto,lang){
						function Inint_AJAX() {
  												 try { return new ActiveXObject("Msxml2.XMLHTTP"); } catch(e) {} //IE
   												 try { return new ActiveXObject("Microsoft.XMLHTTP"); } catch(e) {} //IE
   												 try { return new XMLHttpRequest(); } catch(e) {} //Native Javascript
   												 alert("XMLHttpRequest not supported")
   												 return null
											}
											var req = Inint_AJAX(); // Object
     											req.open('GET', 'bcgtobcs_listbox2.php?value='+encodeURIComponent(value)+'&sendto='+encodeURIComponent(sendto)+'&lang='+encodeURIComponent(lang), true); //
     											req.onreadystatechange = function() { //
          										if (req.readyState==4) {
               										if (req.status==200) { //
                    							var data=req.responseText; //
												
                    							document.getElementById("bcgtobcs_listbox2").innerHTML=""+data; //
               										}
          										}
     										};
     										req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // 
     										req.send(null); //
		};// end countsendprovince
</script>
<script language="javascript">
	function bcssave2(data){
	//alert(data);
		document.company.hiddbcs2.value = document.company.hiddbcs2.value=data ;
	}
</script>
<!--Form Edit Person ===================================================================================-->
<script language="javascript">
	function sendedit(field,value,id_prs,lang,id_field_label){	
	//alert(value);
	//alert(field);alert(lang);alert(id_field_label);
		function Inint_AJAX() {
  												 try { return new ActiveXObject("Msxml2.XMLHTTP"); } catch(e) {} //IE
   												 try { return new ActiveXObject("Microsoft.XMLHTTP"); } catch(e) {} //IE
   												 try { return new XMLHttpRequest(); } catch(e) {} //Native Javascript
   												 alert("XMLHttpRequest not supported")
   												 return null
											}
											var req = Inint_AJAX(); // Object
     											req.open('GET', 'person_action.php?value='+encodeURIComponent(value)+'&field='+encodeURIComponent(field)+'&lang='+encodeURIComponent(lang)+'&id_prs='+encodeURIComponent(id_prs), true); //
     											req.onreadystatechange = function() { //
          										if (req.readyState==4) {
               										if (req.status==200) { //
                    							var data=req.responseText; //
													if(id_prs!=''){window.location=id_field_label+'.php?lang='+lang+'&prs_id='+id_prs;}else{
													window.location=id_field_label+'.php?lang='+lang;
													}
                    								document.getElementById(id_field_label).innerHTML=""+data; //
													//window.location=id_field_label+'.php?lang='+lang;
													//ResumeTap(id_field_label,'','',lang,'resume');
               										}
          										}
     										};
     										req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // 
     										req.send(null); //
	}
	
	function sendedit_wizards_save(field,value,id_prs,lang,id_field_label){	
	//alert(value);
	//alert(field);alert(lang);alert(id_field_label);
		function Inint_AJAX() {
  												 try { return new ActiveXObject("Msxml2.XMLHTTP"); } catch(e) {} //IE
   												 try { return new ActiveXObject("Microsoft.XMLHTTP"); } catch(e) {} //IE
   												 try { return new XMLHttpRequest(); } catch(e) {} //Native Javascript
   												 alert("XMLHttpRequest not supported")
   												 return null
											}
											var req = Inint_AJAX(); // Object
     											req.open('GET', 'person_action.php?value='+encodeURIComponent(value)+'&field='+encodeURIComponent(field)+'&lang='+encodeURIComponent(lang)+'&id_prs='+encodeURIComponent(id_prs), true); //
     											req.onreadystatechange = function() { //
          										if (req.readyState==4) {
               										if (req.status==200) { //
                    							var data=req.responseText; //
													/*if(id_prs!=''){window.location=id_field_label+'.php?lang='+lang+'&prs_id='+id_prs;}else{
													window.location=id_field_label+'.php?lang='+lang;
													}*/
                    								//document.getElementById(id_field_label).innerHTML=""+data; //
													//window.location=id_field_label+'.php?lang='+lang;
													//ResumeTap(id_field_label,'','',lang,'resume');*/
               										}
          										}
     										};
     										req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // 
     										req.send(null); //
	}
	
	function sendedit_wizards(field,value,id_prs,lang,id_field_label){	
	
	//alert(field);alert(value);alert(id_prs);alert(lang);alert(id_field_label);
		function Inint_AJAX() {
  												 try { return new ActiveXObject("Msxml2.XMLHTTP"); } catch(e) {} //IE
   												 try { return new ActiveXObject("Microsoft.XMLHTTP"); } catch(e) {} //IE
   												 try { return new XMLHttpRequest(); } catch(e) {} //Native Javascript
   												 alert("XMLHttpRequest not supported")
   												 return null
											}
											var req = Inint_AJAX(); // Object
     											req.open('GET', 'person_action.php?value='+encodeURIComponent(value)+'&field='+encodeURIComponent(field)+'&lang='+encodeURIComponent(lang)+'&id_prs='+encodeURIComponent(id_prs), true); //
     											req.onreadystatechange = function() { //
          										if (req.readyState==4) {
               										if (req.status==200) { //
                    							var data=req.responseText; //
													/*if(id_prs!=''){window.location=id_field_label+'.php?lang='+lang+'&prs_id='+id_prs;}else{
													window.location=id_field_label+'.php?lang='+lang;
													}*/
                    								//document.getElementById(id_field_label).innerHTML=""+data; //
													window.location=id_field_label+'.php?lang='+lang;
													//ResumeTap(id_field_label,'','',lang,'resume');
               										}
          										}
     										};
     										req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // 
     										req.send(null); //
	}
	
	function sendedit_cpn(field,value,id_prs,lang,id_field_label){	
	
		function Inint_AJAX() {
  												 try { return new ActiveXObject("Msxml2.XMLHTTP"); } catch(e) {} //IE
   												 try { return new ActiveXObject("Microsoft.XMLHTTP"); } catch(e) {} //IE
   												 try { return new XMLHttpRequest(); } catch(e) {} //Native Javascript
   												 alert("XMLHttpRequest not supported")
   												 return null
											}
											var req = Inint_AJAX(); // Object
											//alert(field);
     										req.open('POST', 'company_action.php?value='+encodeURIComponent(value)+'&field='+encodeURIComponent(field)+'&lang='+encodeURIComponent(lang)+'&id_prs='+encodeURIComponent(id_prs), true); //
     											req.onreadystatechange = function() { //
												
          										if (req.readyState==4) {
               										if (req.status==200) { //
                    							var data=req.responseText; //
												window.location=window.location;
                    							//document.getElementById(id_field_label).innerHTML=""+data; //
               										}
          										}
												
     										};
     										req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // 
     										req.send(null); //
											
	}
	
	function sendedit_cpn_admin(field,value,id_cpn,lang,id_field_label){
		
	
		function Inint_AJAX() {
  												 try { return new ActiveXObject("Msxml2.XMLHTTP"); } catch(e) {} //IE
   												 try { return new ActiveXObject("Microsoft.XMLHTTP"); } catch(e) {} //IE
   												 try { return new XMLHttpRequest(); } catch(e) {} //Native Javascript
   												 alert("XMLHttpRequest not supported")
   												 return null
											}
											var req = Inint_AJAX(); // Object
											//alert(field);
     										req.open('GET', 'company_action.php?value='+encodeURIComponent(value)+'&field='+encodeURIComponent(field)+'&lang='+encodeURIComponent(lang)+'&id_cpn='+encodeURIComponent(id_cpn), true); //
     											req.onreadystatechange = function() { //
												
          										if (req.readyState==4) {
               										if (req.status==200) { //
                    							var data=req.responseText; //
												window.location=window.location;
                    							//document.getElementById(id_field_label).innerHTML=""+data; //
               										}
          										}
												
     										};
     										req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // 
     										req.send(null); //
											
	}

	
	function sendedit_admin(field,value,id_prs,lang,id_field_label){	
	
		function Inint_AJAX() {
  												 try { return new ActiveXObject("Msxml2.XMLHTTP"); } catch(e) {} //IE
   												 try { return new ActiveXObject("Microsoft.XMLHTTP"); } catch(e) {} //IE
   												 try { return new XMLHttpRequest(); } catch(e) {} //Native Javascript
   												 alert("XMLHttpRequest not supported")
   												 return null
											}
											var req = Inint_AJAX(); // Object
     											req.open('GET', 'person_action.php?value='+encodeURIComponent(value)+'&field='+encodeURIComponent(field)+'&lang='+encodeURIComponent(lang)+'&id_prs='+encodeURIComponent(id_prs), true); //
     											req.onreadystatechange = function() { //
          										if (req.readyState==4) {
               										if (req.status==200) { //
                    							var data=req.responseText; //
													if(id_prs!=''){
													window.location=id_field_label+'.php?lang='+lang+'&prs_id='+id_prs;
													document.getElementById(id_field_label).innerHTML=""+data; //	
													
													}else{
													//window.location=id_field_label+'.php?lang='+lang;
													document.getElementById(id_field_label).innerHTML=""+data;
													}
                    								//document.getElementById(id_field_label).innerHTML=""+data; //
													//window.location=id_field_label+'.php?lang='+lang;
													//ResumeTap(id_field_label,'','',lang,'resume');
               										}
          										}
     										};
     										req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // 
     										req.send(null); //
	}
	
	<!--Form Edit Person  TapAjax===================================================================================-->

	function ResumeTap(filename,value,id_prs,lang,id_field_label){	
		//alert(field);//alert(value);alert(id_prs);alert(lang);
		//alert(filename);alert(id_field_label);
		function Inint_AJAX() {
  												 try { return new ActiveXObject("Msxml2.XMLHTTP"); } catch(e) {} //IE
   												 try { return new ActiveXObject("Microsoft.XMLHTTP"); } catch(e) {} //IE
   												 try { return new XMLHttpRequest(); } catch(e) {} //Native Javascript
   												 alert("XMLHttpRequest not supported")
   												 return null
											}
											var req = Inint_AJAX(); // Object
											//alert(field);
     										req.open('GET',filename+'.php?value='+encodeURIComponent(value)+'&lang='+encodeURIComponent(lang)+'&id_prs='+encodeURIComponent(id_prs), true); //
     											req.onreadystatechange = function() { //
          										if (req.readyState==4) {
               										if (req.status==200) { //
                    							var data=req.responseText; //
												
                    							document.getElementById(id_field_label).innerHTML=""+data; //
               										}
          										}
     										};
     										req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // 
     										req.send(null); //
	}
	//
	function sendeditprovince(field,value,id_prs,lang,id_field_label){	
		
		function Inint_AJAX() {
  												 try { return new ActiveXObject("Msxml2.XMLHTTP"); } catch(e) {} //IE
   												 try { return new ActiveXObject("Microsoft.XMLHTTP"); } catch(e) {} //IE
   												 try { return new XMLHttpRequest(); } catch(e) {} //Native Javascript
   												 alert("XMLHttpRequest not supported")
   												 return null
											}
											var req = Inint_AJAX(); // Object
											//alert(field);
     											req.open('GET', 'person_action.php?value='+encodeURIComponent(value)+'&field='+encodeURIComponent(field)+'&lang='+encodeURIComponent(lang)+'&id_prs='+encodeURIComponent(id_prs), true); //
     											req.onreadystatechange = function() { //
          										if (req.readyState==4) {
               										if (req.status==200) { //
                    							var data=req.responseText; //
												
                    							document.getElementById(id_field_label).innerHTML=""+data; //
               										}
          										}
     										};
     										req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // 
     										req.send(null); //
	}
	function SendEditEdu(field,value,id_prs,lang,id_field_label){	
		
		
		function Inint_AJAX() {
  												 try { return new ActiveXObject("Msxml2.XMLHTTP"); } catch(e) {} //IE
   												 try { return new ActiveXObject("Microsoft.XMLHTTP"); } catch(e) {} //IE
   												 try { return new XMLHttpRequest(); } catch(e) {} //Native Javascript
   												 alert("XMLHttpRequest not supported")
   												 return null
											}
											var req = Inint_AJAX(); // Object
											
     											req.open('GET', 'person_action.php?value='+encodeURIComponent(value)+'&field='+encodeURIComponent(field)+'&lang='+encodeURIComponent(lang)+'&id_prs='+encodeURIComponent(id_prs), true); //
     											req.onreadystatechange = function() { //
          										if (req.readyState==4) {
               										if (req.status==200) { //
                    							var data=req.responseText; //
												window.location=id_field_label+'.php?lang='+lang;
												//ResumeTap('person_education','','',lang,'resume');
                    							document.getElementById(id_field_label).innerHTML=""+data; //
												
               										}
          										}
     										};
     										req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // 
     										req.send(null); //
	}//
	
	
	function SendEditEdu_wizards(field,value,edh_id,lang,id_field_label){	
		
		
		function Inint_AJAX() {
  												 try { return new ActiveXObject("Msxml2.XMLHTTP"); } catch(e) {} //IE
   												 try { return new ActiveXObject("Microsoft.XMLHTTP"); } catch(e) {} //IE
   												 try { return new XMLHttpRequest(); } catch(e) {} //Native Javascript
   												 alert("XMLHttpRequest not supported")
   												 return null
											}
											var req = Inint_AJAX(); // Object
											
     											req.open('GET', 'person_action.php?value='+encodeURIComponent(value)+'&field='+encodeURIComponent(field)+'&lang='+encodeURIComponent(lang)+'&edh_id='+encodeURIComponent(edh_id), true); //
     											req.onreadystatechange = function() { //
          										if (req.readyState==4) {
               										if (req.status==200) { //
                    							var data=req.responseText; //
												window.location=id_field_label+'.php?lang='+lang;
												//ResumeTap('person_education','','',lang,'resume');
                    							document.getElementById(id_field_label).innerHTML=""+data; //
												
               										}
          										}
     										};
     										req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // 
     										req.send(null); //
	}//
	
	function SendEditWork_admin(field,value,id_prs,lang,id_field_label){	
		
		
		function Inint_AJAX() {
  												 try { return new ActiveXObject("Msxml2.XMLHTTP"); } catch(e) {} //IE
   												 try { return new ActiveXObject("Microsoft.XMLHTTP"); } catch(e) {} //IE
   												 try { return new XMLHttpRequest(); } catch(e) {} //Native Javascript
   												 alert("XMLHttpRequest not supported")
   												 return null
											}
											var req = Inint_AJAX(); // Object
											
     											req.open('GET', 'person_action.php?value='+encodeURIComponent(value)+'&field='+encodeURIComponent(field)+'&lang='+encodeURIComponent(lang)+'&id_prs='+encodeURIComponent(id_prs), true); //
     											req.onreadystatechange = function() { //
          										if (req.readyState==4) {
               										if (req.status==200) { //
                    							var data=req.responseText; //
												window.location=id_field_label+'.php?lang='+lang+'&prs_id='+id_prs;
												//ResumeTap('person_education','','',lang,'resume');
                    							document.getElementById(id_field_label).innerHTML=""+data; //
												
               										}
          										}
     										};
     										req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // 
     										req.send(null); //
	}//
	
	function SendEditEdu_admin(field,value,id_prs,lang,id_field_label){	
		
		
		function Inint_AJAX() {
  												 try { return new ActiveXObject("Msxml2.XMLHTTP"); } catch(e) {} //IE
   												 try { return new ActiveXObject("Microsoft.XMLHTTP"); } catch(e) {} //IE
   												 try { return new XMLHttpRequest(); } catch(e) {} //Native Javascript
   												 alert("XMLHttpRequest not supported")
   												 return null
											}
											var req = Inint_AJAX(); // Object
											
     											req.open('GET', 'person_action.php?value='+encodeURIComponent(value)+'&field='+encodeURIComponent(field)+'&lang='+encodeURIComponent(lang)+'&id_prs='+encodeURIComponent(id_prs), true); //
     											req.onreadystatechange = function() { //
          										if (req.readyState==4) {
               										if (req.status==200) { //
                    							var data=req.responseText; //
												//window.location=id_field_label+'.php?lang='+lang+'&prs_id='+id_prs;
												//ResumeTap('person_education','','',lang,'resume');
                    							document.getElementById(id_field_label).innerHTML=""+data; //
												
               										}
          										}
     										};
     										req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // 
     										req.send(null); //
	}//
	
	function SendEditEdu_admin(field,value,id_prs,lang,id_field_label){	
		
		
		function Inint_AJAX() {
  												 try { return new ActiveXObject("Msxml2.XMLHTTP"); } catch(e) {} //IE
   												 try { return new ActiveXObject("Microsoft.XMLHTTP"); } catch(e) {} //IE
   												 try { return new XMLHttpRequest(); } catch(e) {} //Native Javascript
   												 alert("XMLHttpRequest not supported")
   												 return null
											}
											var req = Inint_AJAX(); // Object
											
     											req.open('GET', 'person_action.php?value='+encodeURIComponent(value)+'&field='+encodeURIComponent(field)+'&lang='+encodeURIComponent(lang)+'&id_prs='+encodeURIComponent(id_prs), true); //
     											req.onreadystatechange = function() { //
          										if (req.readyState==4) {
               										if (req.status==200) { //
                    							var data=req.responseText; //
												window.location=id_field_label+'.php?lang='+lang+'&prs_id='+id_prs;
												//ResumeTap('person_education','','',lang,'resume');
                    							document.getElementById(id_field_label).innerHTML=""+data; //
												
               										}
          										}
     										};
     										req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // 
     										req.send(null); //
	}//
	
	function SendEditWorkHis(field,value,id_prs,lang,id_field_label){	
		
		
		function Inint_AJAX() {
  												 try { return new ActiveXObject("Msxml2.XMLHTTP"); } catch(e) {} //IE
   												 try { return new ActiveXObject("Microsoft.XMLHTTP"); } catch(e) {} //IE
   												 try { return new XMLHttpRequest(); } catch(e) {} //Native Javascript
   												 alert("XMLHttpRequest not supported")
   												 return null
											}
											var req = Inint_AJAX(); // Object
											//alert(field);
     										req.open('GET', 'person_action.php?value='+encodeURIComponent(value)+'&field='+encodeURIComponent(field)+'&lang='+encodeURIComponent(lang)+'&id_prs='+encodeURIComponent(id_prs), true); //
     											req.onreadystatechange = function() { //
          										if (req.readyState==4) {
               										if (req.status==200) { //
                    							var data=req.responseText; //
												
												//ResumeTap('person_workhis','','',lang,'resume');
                    							document.getElementById(id_field_label).innerHTML=""+data; //
												window.location=id_field_label+'.php?lang='+lang;
               										}
          										}
     										};
     										req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // 
     										req.send(null); //
	}//
	
	function SendEditWorkHis_admin(field,value,id_prs,lang,id_field_label){	
		
		
		function Inint_AJAX() {
  												 try { return new ActiveXObject("Msxml2.XMLHTTP"); } catch(e) {} //IE
   												 try { return new ActiveXObject("Microsoft.XMLHTTP"); } catch(e) {} //IE
   												 try { return new XMLHttpRequest(); } catch(e) {} //Native Javascript
   												 alert("XMLHttpRequest not supported")
   												 return null
											}
											var req = Inint_AJAX(); // Object
											//alert(field);
     											req.open('GET', 'person_action.php?value='+encodeURIComponent(value)+'&field='+encodeURIComponent(field)+'&lang='+encodeURIComponent(lang)+'&id_prs='+encodeURIComponent(id_prs), true); //
     											req.onreadystatechange = function() { //
          										if (req.readyState==4) {
               										if (req.status==200) { //
                    							var data=req.responseText; //
												
												//ResumeTap('person_workhis','','',lang,'resume');
												window.location=id_field_label+'.php?lang='+lang+'&prs_id='+id_prs;
                    							document.getElementById(id_field_label).innerHTML=""+data; //
												
               										}
          										}
     										};
     										req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // 
     										req.send(null); //
	}//
	
	function SendEditTrainingHis_admin(field,value,id_prs,lang,id_field_label){	
		
		
		function Inint_AJAX() {
  												 try { return new ActiveXObject("Msxml2.XMLHTTP"); } catch(e) {} //IE
   												 try { return new ActiveXObject("Microsoft.XMLHTTP"); } catch(e) {} //IE
   												 try { return new XMLHttpRequest(); } catch(e) {} //Native Javascript
   												 alert("XMLHttpRequest not supported")
   												 return null
											}
											var req = Inint_AJAX(); // Object
											
     											req.open('GET', 'person_action.php?value='+encodeURIComponent(value)+'&field='+encodeURIComponent(field)+'&lang='+encodeURIComponent(lang)+'&id_prs='+encodeURIComponent(id_prs), true); //
     											req.onreadystatechange = function() { //
          										if (req.readyState==4) {
               										if (req.status==200) { //
                    							var data=req.responseText; //
												
												//ResumeTap('person_traininghis','','',lang,'resume');
												window.location=id_field_label+'.php?lang='+lang+'&prs_id='+id_prs;
                    							document.getElementById(id_field_label).innerHTML=""+data; //
												
               										}
          										}
     										};
     										req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // 
     										req.send(null); //
	}//
	
	function SendEditTrainingHis(field,value,id_prs,lang,id_field_label){	
		
		
		function Inint_AJAX() {
  												 try { return new ActiveXObject("Msxml2.XMLHTTP"); } catch(e) {} //IE
   												 try { return new ActiveXObject("Microsoft.XMLHTTP"); } catch(e) {} //IE
   												 try { return new XMLHttpRequest(); } catch(e) {} //Native Javascript
   												 alert("XMLHttpRequest not supported")
   												 return null
											}
											var req = Inint_AJAX(); // Object
											
     											req.open('GET', 'person_action.php?value='+encodeURIComponent(value)+'&field='+encodeURIComponent(field)+'&lang='+encodeURIComponent(lang)+'&id_prs='+encodeURIComponent(id_prs), true); //
     											req.onreadystatechange = function() { //
          										if (req.readyState==4) {
               										if (req.status==200) { //
                    							var data=req.responseText; //
												
												//ResumeTap('person_traininghis','','',lang,'resume');
                    							//document.getElementById(id_field_label).innerHTML=""+data; //
												window.location=id_field_label+'.php?lang='+lang;
               										}
          										}
     										};
     										req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // 
     										req.send(null); //
	}//
	
	
	function SendEditTrainingHis_admin(field,value,id_prs,lang,id_field_label){	
		
		
		function Inint_AJAX() {
  												 try { return new ActiveXObject("Msxml2.XMLHTTP"); } catch(e) {} //IE
   												 try { return new ActiveXObject("Microsoft.XMLHTTP"); } catch(e) {} //IE
   												 try { return new XMLHttpRequest(); } catch(e) {} //Native Javascript
   												 alert("XMLHttpRequest not supported")
   												 return null
											}
											var req = Inint_AJAX(); // Object
											
     											req.open('GET', 'person_action.php?value='+encodeURIComponent(value)+'&field='+encodeURIComponent(field)+'&lang='+encodeURIComponent(lang)+'&id_prs='+encodeURIComponent(id_prs), true); //
     											req.onreadystatechange = function() { //
          										if (req.readyState==4) {
               										if (req.status==200) { //
                    							var data=req.responseText; //
												
												//ResumeTap('person_traininghis','','',lang,'resume');
                    							document.getElementById(id_field_label).innerHTML=""+data; //
												window.location=id_field_label+'.php?lang='+lang+'&prs_id='+id_prs;
               										}
          										}
     										};
     										req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // 
     										req.send(null); //
	}//
	
	function chang_to_area(value,lang,id_field_label){	
		function Inint_AJAX() {
  												 try { return new ActiveXObject("Msxml2.XMLHTTP"); } catch(e) {} //IE
   												 try { return new ActiveXObject("Microsoft.XMLHTTP"); } catch(e) {} //IE
   												 try { return new XMLHttpRequest(); } catch(e) {} //Native Javascript
   												 alert("XMLHttpRequest not supported")
   												 return null
											}
											var req = Inint_AJAX(); // Object
											//alert(id_field_label+''+value);
     										req.open('GET', 'person_to_area.php?value='+encodeURIComponent(value)+'&lang='+encodeURIComponent(lang), true); //
     											req.onreadystatechange = function() { //
          										if (req.readyState==4) {
               										if (req.status==200) { //
                    							var data=req.responseText; //
												
                    							document.getElementById(id_field_label).innerHTML=""+data; //
               										}
          										}
     										};
     										req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // 
     										req.send(null); //
	}
	//
	function chang_to_bkk_area(value,lang,id_field_label){	
		//alert(field);//alert(value);alert(id_prs);alert(lang);
		function Inint_AJAX() {
  												 try { return new ActiveXObject("Msxml2.XMLHTTP"); } catch(e) {} //IE
   												 try { return new ActiveXObject("Microsoft.XMLHTTP"); } catch(e) {} //IE
   												 try { return new XMLHttpRequest(); } catch(e) {} //Native Javascript
   												 alert("XMLHttpRequest not supported")
   												 return null
											}
											var req = Inint_AJAX(); // Object
											//alert(field);
     										req.open('GET', 'person_to_bkk_area.php?value='+encodeURIComponent(value)+'&lang='+encodeURIComponent(lang), true); //
     											req.onreadystatechange = function() { //
          										if (req.readyState==4) {
               										if (req.status==200) { //
                    							var data=req.responseText; //
												
                    							document.getElementById(id_field_label).innerHTML=""+data; //
               										}
          										}
     										};
     										req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // 
     										req.send(null); //
	}
function shw(field1,field2,field3,sta){
						var idfield1 = document.getElementById(field1);
						var idfield2 = document.getElementById(field2);
						var idfield3 = document.getElementById(field3);
					    if(sta=="show"){
						idfield1.style.display='none';
						idfield2.style.display='';
						idfield3.style.display='';
						}
						 if(sta=="hidden"){
						idfield1.style.display='';
						idfield2.style.display='none';
						idfield3.style.display='none';
						}
}
</script> 
  <script language="javascript">
		function GetBirthDate(){
		
		var Year=document.company.Y;
		var Month=document.company.M;
		var Day=document.company.D;
		
				ny=Year.value+'-';
				nm=Month.value+'-';
				nd=Day.value;
				
				if(nm.length<3){nm='0'+nm;}
				if(nd.length<2){nd='0'+nd;}
				if(Month.value==2 & Day.value>28){document.company.hidden_birthdate.value=""; return false;}
				if(Month.value==4 || Month.value==6 || Month.value==9 || Month.value==11& Day.value>30){document.company.hidden_birthdate.value=""; return false;}
				document.company.hidden_birthdate.value="";
			   document.company.hidden_birthdate.value=document.company.hidden_birthdate.value+ny+nm+nd;
		
	    if(Year.value==""){alert('กรุณาเลือกปีที่เกิด');document.company.hidden_birthdate.value=""; return false;}
		else if(Month.value==""){alert('กรุณาเลือกเดือนที่เกิด');document.company.hidden_birthdate.value=""; return false;}
		else if(Day.value==""){alert('กรุณาเลือกวันที่เกิด ');document.company.hidden_birthdate.value=""; return false;}
		
		
		}
	
		</script>
        <script language="javascript">
		function GetWorkHis(lang){
		
		var Year=document.getElementById('Y');
		var Month=document.getElementById('M');
		var Day=document.getElementById('D');
		
				ny=Year.value+'-';
				nm=Month.value+'-';
				nd=Day.value;
				var Month_Label_en =new Array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
				var Month_Label_th =new Array('มกราคม', 'กุมภาพันธ์ ', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม');
				var Month_Label_jp =new Array('1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月');
				 if(lang=='lc' || lang=='th'){var Month_Label=Month_Label_th; }
				 if(lang=='en'){var Month_Label=Month_Label_en; }
				 if(lang=='en'){var Month_Label=Month_Label_jp; }
				if(nm.length<3){nm='0'+nm;}
				if(nd.length<2){nd='0'+nd;}
				
				
				if(Month.value==2 & Day.value>28){
				alert(Month_Label[1]+'มีแค่28วัน');document.getElementById('D2').value=28;return false;}
				if(Month.value==4 & Day.value>30){alert(Month_Label[3]+'มีแค่30วัน');document.getElementById('D').value=30;return false;}
				if( Month.value==6 & Day.value>30){alert(Month_Label[5]+'มีแค่30วัน');document.getElementById('D').value=30;return false;}
				if(  Month.value==9 & Day.value>30){alert(Month_Label[8]+'มีแค่30วัน');document.getElementById('D').value=30;return false;}
				if(   Month.value==11& Day.value>30){alert(Month_Label[10]+'มีแค่30วัน');document.getElementById('D').value=30;return false;}
				
				//alert(ny+nm+nd);
			 document.getElementById('hidden_startdate').value="";
			 document.getElementById('hidden_startdate').value=document.getElementById('hidden_startdate').value+ny+nm+nd;
			   
			//	document.getElementById("chkdate").innerHTML=frm.hidden_birthdate.value;
		
	    if(Year.value==""){alert('กรุณาเลือกปีที่เกิด');document.getElementById('hidden_startdate').value=""; return false;}
		else if(Month.value==""){alert('กรุณาเลือกเดือนที่เกิด');document.getElementById('hidden_startdate').value=""; return false;}
		else if(Day.value==""){alert('กรุณาเลือกวันที่เกิด ');document.getElementById('hidden_startdate').value=""; return false;}
		//else{sendedit('birthdate',document.company.hidden_birthdate.value,'<?=$prs_id;?>',document.getElementById('Rlang').value,'label_birthdate')}
		}
		function GetWorkHis2(lang){
		
		var Year2=document.getElementById('Y2');
		var Month2=document.getElementById('M2');
		var Day2=document.getElementById('D2');
		
				ny=Year2.value+'-';
				nm=Month2.value+'-';
				nd=Day2.value;
				var Month_Label_en =new Array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
				var Month_Label_th =new Array('มกราคม', 'กุมภาพันธ์ ', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม');
				var Month_Label_jp =new Array('1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月');
				 if(lang=='lc' || lang=='th'){var Month_Label=Month_Label_th; }
				 if(lang=='en'){var Month_Label=Month_Label_en; }
				 if(lang=='en'){var Month_Label=Month_Label_jp; }
				if(nm.length<3){nm='0'+nm;}
				if(nd.length<2){nd='0'+nd;}
				
				
				if(Month2.value==2 & Day2.value>28){
				alert(Month_Label[1]+'มีแค่28วัน');document.getElementById('D2').value=28;return false;}
				if(Month2.value==4 & Day2.value>30){alert(Month_Label[3]+'มีแค่30วัน');document.getElementById('D2').value=30;return false;}
				if( Month2.value==6 & Day2.value>30){alert(Month_Label[5]+'มีแค่30วัน');document.getElementById('D2').value=30;return false;}
				if(  Month2.value==9 & Day2.value>30){alert(Month_Label[8]+'มีแค่30วัน');document.getElementById('D2').value=30;return false;}
				if(   Month2.value==11& Day2.value>30){alert(Month_Label[10]+'มีแค่30วัน');document.getElementById('D2').value=30;return false;}
				
				
			 document.getElementById('hidden_enddate').value="";
			 document.getElementById('hidden_enddate').value=document.getElementById('hidden_enddate').value+ny+nm+nd;
			   
			//	document.getElementById("chkdate").innerHTML=frm.hidden_birthdate.value;
		
	    if(Year2.value==""){alert('กรุณาเลือกปีที่เกิด');document.getElementById('hidden_enddate').value=""; return false;}
		else if(Month2.value==""){alert('กรุณาเลือกเดือนที่เกิด');document.getElementById('hidden_enddate').value=""; return false;}
		else if(Day2.value==""){alert('กรุณาเลือกวันที่เกิด ');document.getElementById('hidden_enddate').value=""; return false;}
		//else{sendedit('birthdate',document.company.hidden_birthdate.value,'<?=$prs_id;?>',document.getElementById('Rlang').value,'label_birthdate')}
		
		}
		function GetWorkHisUpdate(lang,label_num){
		
		Year=document.getElementById('Y'+label_num);
		Month=document.getElementById('M'+label_num);
		Day=document.getElementById('D'+label_num);
		
	    startdate=document.getElementById('update_startdate'+label_num);
			
		
				ny=Year.value+'-';
				nm=Month.value+'-';
				nd=Day.value;
				var Month_Label_en =new Array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
				var Month_Label_th =new Array('มกราคม', 'กุมภาพันธ์ ', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม');
				var Month_Label_jp =new Array('1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月');
				 if(lang=='lc' || lang=='th'){var Month_Label=Month_Label_th; }
				 if(lang=='en'){var Month_Label=Month_Label_en; }
				 if(lang=='en'){var Month_Label=Month_Label_jp; }
				
				if(nm.length<3){nm='0'+nm;}
				if(nd.length<2){nd='0'+nd;}
				
		
				if(Month.value==2 & Day.value>28){
				alert(Month_Label[1]+'มีแค่28วัน');Day.value=28;return false;}
				if(Month.value==4 & Day.value>30){alert(Month_Label[3]+'มีแค่30วัน');Day.value=30;return false;}
				if( Month.value==6 & Day.value>30){alert(Month_Label[5]+'มีแค่30วัน');Day.value=30;return false;}
				if(  Month.value==9 & Day.value>30){alert(Month_Label[8]+'มีแค่30วัน');Day.value=30;return false;}
				if(   Month.value==11& Day.value>30){alert(Month_Label[10]+'มีแค่30วัน');Day.value=30;return false;}
				
				document.getElementById('update_startdate'+label_num).value="";
			   document.getElementById('update_startdate'+label_num).value=document.getElementById('update_startdate'+label_num).value+ny+nm+nd;
			
			//	document.getElementById("chkdate").innerHTML=frm.hidden_birthdate.value;
		/*
	    if(Year.value==""){alert('กรุณาเลือกปีที่เกิด'); return false;}
		else if(Month.value==""){alert('กรุณาเลือกเดือนที่เกิด'); return false;}
		else if(Day.value==""){alert('กรุณาเลือกวันที่เกิด '); return false;}*/
		//else{sendedit('birthdate',document.company.hidden_birthdate.value,'<?=$prs_id;?>',document.getElementById('Rlang').value,'label_birthdate')}
		
		}
		function GetWorkHisUpdate2(lang,label_num){
		//alert(lang+'label_num');
		Year=document.getElementById('Y2'+label_num);
		Month=document.getElementById('M2'+label_num);
		Day=document.getElementById('D2'+label_num);
	    enddate=document.getElementById('update_enddate'+label_num);
			
		
				ny=Year.value+'-';
				nm=Month.value+'-';
				nd=Day.value;
				var Month_Label_en =new Array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
				var Month_Label_th =new Array('มกราคม', 'กุมภาพันธ์ ', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม');
				var Month_Label_jp =new Array('1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月');
				 if(lang=='lc' || lang=='th'){var Month_Label=Month_Label_th; }
				 if(lang=='en'){var Month_Label=Month_Label_en; }
				 if(lang=='en'){var Month_Label=Month_Label_jp; }
				
				if(nm.length<3){nm='0'+nm;}
				if(nd.length<2){nd='0'+nd;}
				//alert(Month2.value); alert(Day2.value);
		
				if(Month.value==2 & Day.value>28){
				alert(Month_Label[1]+'มีแค่28วัน');Day.value=28;return false;}
				if(Month.value==4 & Day.value>30){alert(Month_Label[3]+'มีแค่30วัน');Day.value=30;return false;}
				if( Month.value==6 & Day.value>30){alert(Month_Label[5]+'มีแค่30วัน');Day.value=30;return false;}
				if(  Month.value==9 & Day.value>30){alert(Month_Label[8]+'มีแค่30วัน');Day.value=30;return false;}
				if(   Month.value==11& Day.value>30){alert(Month_Label[10]+'มีแค่30วัน');Day.value=30;return false;}
				
				document.getElementById('update_enddate'+label_num).value="";
			   document.getElementById('update_enddate'+label_num).value=document.getElementById('update_enddate'+label_num).value+ny+nm+nd;
			  
			//	document.getElementById("chkdate").innerHTML=frm.hidden_birthdate.value;
		/*
	    if(Year.value==""){alert('กรุณาเลือกปีที่เกิด');document.company.enddate.value=""; return false;}
		else if(Month.value==""){alert('กรุณาเลือกเดือนที่เกิด');document.company.enddate.value=""; return false;}
		else if(Day.value==""){alert('กรุณาเลือกวันที่เกิด ');document.company.enddate.value=""; return false;}
		//else{sendedit('birthdate',document.company.hidden_birthdate.value,'<?=$prs_id;?>',document.getElementById('Rlang').value,'label_birthdate')}
		*/
		}
	function ChkWork(lang){
	
		var frm=document.company;
		var hidden_startdate=document.company.calendar;
		var hidden_enddate=document.company.calendar2;
		var empname=document.company.empname;
		var empname_en=document.company.empname_en;
		var empaddress=document.company.empaddress;
		var empaddress_en=document.company.empaddress_en;
		var position=document.company.position;
		var position_en=document.company.position_en;
		var salary=document.company.salary;
		//var salarycurrency=document.company.salarycurrency;
		var jobdesc=document.company.jobdesc;
		var jobdesc_en=document.company.jobdesc_en;
		var prs_id=document.company.prs_id;
		if(hidden_startdate.value==""){ alert('เริ่มทำงานตั้งแต่');hidden_startdate.focus();return false;}
		 if(hidden_enddate.value==""){ alert('สิ้นสุดการทำงานเมื่อ');hidden_enddate.focus();return false;}
		 if(empname.value==""){ alert('กรอกชื่อบริษัท');empname.focus();return false;}
		 if(empaddress.value==""){ alert('กรอกที่อยู่');empaddress.focus();return false;}
		 if(position.value==""){ alert('ตำแหน่งงาน');position.focus();return false;}
		 if(salary.value==""){ alert('เงินเดือน');salary.focus();return false;}
		//else if(salarycurrency.value==""){ alert('สกุลเงิน');salarycurrency.focus();return false;}
		 if(jobdesc.value==""){ alert('หน้าที่รับผิดชอบ');jobdesc.focus();return false;}
			else{	
			var value=hidden_startdate.value+'|'+hidden_enddate.value+'|'+empname.value+'|'+empname_en.value+'|'+empaddress.value+'|'+empaddress_en.value+'|'+position.value+'|'+position_en.value+'|THB|'+salary.value+'|'+jobdesc.value+'|'+jobdesc_en.value;
			
			SendEditWorkHis('AddRecordWorkhis',value,prs_id.value,lang,'person_workhis');
			}
	
	}
	
	
	function ChkWork_wizards(lang){
	
		var frm=document.company;
		var hidden_startdate=document.company.calendar;
		var hidden_enddate=document.company.calendar2;
		var empname=document.company.empname;
		var empname_en=document.company.empname_en;
		var empaddress=document.company.empaddress;
		var empaddress_en=document.company.empaddress_en;
		var position=document.company.position;
		var position_en=document.company.position_en;
		var salary=document.company.salary;
		//var salarycurrency=document.company.salarycurrency;
		var jobdesc=document.company.jobdesc;
		var jobdesc_en=document.company.jobdesc_en;
		var prs_id=document.company.prs_id;
		if(hidden_startdate.value==""){ alert('เริ่มทำงานตั้งแต่');hidden_startdate.focus();return false;}
		 if(hidden_enddate.value==""){ alert('สิ้นสุดการทำงานเมื่อ');hidden_enddate.focus();return false;}
		 if(empname.value==""){ alert('กรอกชื่อบริษัท');empname.focus();return false;}
		 if(empaddress.value==""){ alert('กรอกที่อยู่');empaddress.focus();return false;}
		 if(position.value==""){ alert('ตำแหน่งงาน');position.focus();return false;}
		 if(salary.value==""){ alert('เงินเดือน');salary.focus();return false;}
		//else if(salarycurrency.value==""){ alert('สกุลเงิน');salarycurrency.focus();return false;}
		 if(jobdesc.value==""){ alert('หน้าที่รับผิดชอบ');jobdesc.focus();return false;}
			else{	
			var value=hidden_startdate.value+'|'+hidden_enddate.value+'|'+empname.value+'|'+empname_en.value+'|'+empaddress.value+'|'+empaddress_en.value+'|'+position.value+'|'+position_en.value+'|THB|'+salary.value+'|'+jobdesc.value+'|'+jobdesc_en.value;
			
			SendEditWorkHis('AddRecordWorkhis',value,prs_id.value,lang,'person_wizards_workhis');
			}
	
	}
	
	
	function ChkWork_admin(lang){
	
		var frm=document.company;
		var hidden_startdate=document.company.calendar;
		var hidden_enddate=document.company.calendar2;
		var empname=document.company.empname;
		var empname_en=document.company.empname_en;
		var empaddress=document.company.empaddress;
		var empaddress_en=document.company.empaddress_en;
		var position=document.company.position;
		var position_en=document.company.position_en;
		var salary=document.company.salary;
		var prs_id=document.company.prs_id;
		//var salarycurrency=document.company.salarycurrency;
		var jobdesc=document.company.jobdesc;
		var jobdesc_en=document.company.jobdesc_en;
		if(hidden_startdate.value==""){ alert('เริ่มทำงานตั้งแต่');hidden_startdate.focus();return false;}
		 if(hidden_enddate.value==""){ alert('สิ้นสุดการทำงานเมื่อ');hidden_enddate.focus();return false;}
		 if(empname.value==""){ alert('กรอกชื่อบริษัท');empname.focus();return false;}
		 if(empaddress.value==""){ alert('กรอกที่อยู่');empaddress.focus();return false;}
		 if(position.value==""){ alert('ตำแหน่งงาน');position.focus();return false;}
		 if(salary.value==""){ alert('เงินเดือน');salary.focus();return false;}
		//else if(salarycurrency.value==""){ alert('สกุลเงิน');salarycurrency.focus();return false;}
		 if(jobdesc.value==""){ alert('หน้าที่รับผิดชอบ');jobdesc.focus();return false;}
			else{	
			var value=hidden_startdate.value+'|'+hidden_enddate.value+'|'+empname.value+'|'+empname_en.value+'|'+empaddress.value+'|'+empaddress_en.value+'|'+position.value+'|'+position_en.value+'|THB|'+salary.value+'|'+jobdesc.value+'|'+jobdesc_en.value;
			
			SendEditWorkHis_admin('AddRecordWorkhis',value,prs_id.value,lang,'admin_person_workhis');
			}
	
	}
	
		</script>
          <script language="javascript">
	  	function ChkTrainning(lang){
		
		var frm=document.company;
		var institute=document.company.institute;
		var institute_en=document.company.institute_en;
		var course=document.company.course;
		var course_en=document.company.course_en;
		var hidden_enddate=document.company.calendar2;
		var hidden_startdate=document.company.calendar;
		var prs_id=document.company.prs_id;
		if(hidden_startdate.value==""){ alert('เริ่มฝึกอบรมเมื่อ');return false;}
		else if(hidden_enddate.value==""){ alert('สิ้นสุดการอบรมเมื่อ');return false;}
		else if(institute.value==""){ alert('กรอกชื่อสถานศึกษา');institute.focus();return false;}
		else if(course.value==""){ alert('กรอกสาขาวิชา');course.focus();return false;}
		else{ 
			var value=hidden_startdate.value+'|'+hidden_enddate.value+'|'+institute.value+'|'+institute_en.value+'|'+course.value+'|'+course_en.value;
			//alert(value);
			SendEditTrainingHis('AddRecordTrainingHis',value,prs_id.value,lang,'person_traininghis');
			}
		}
		
		function ChkTrainning_wizards(lang){
		
		var frm=document.company;
		var institute=document.company.institute;
		var institute_en=document.company.institute_en;
		var course=document.company.course;
		var course_en=document.company.course_en;
		var hidden_enddate=document.company.calendar2;
		var hidden_startdate=document.company.calendar;
		var prs_id=document.company.prs_id;
		if(hidden_startdate.value==""){ alert('เริ่มฝึกอบรมเมื่อ');return false;}
		else if(hidden_enddate.value==""){ alert('สิ้นสุดการอบรมเมื่อ');return false;}
		else if(institute.value==""){ alert('กรอกชื่อสถานศึกษา');institute.focus();return false;}
		else if(course.value==""){ alert('กรอกสาขาวิชา');course.focus();return false;}
		else{ 
			var value=hidden_startdate.value+'|'+hidden_enddate.value+'|'+institute.value+'|'+institute_en.value+'|'+course.value+'|'+course_en.value;
			//alert(value);
			SendEditTrainingHis('AddRecordTrainingHis',value,prs_id.value,lang,'person_wizards_traininghis');
			}
		}
		
		function ChkTrainning_admin(lang){
		
		var frm=document.company;
		var institute=document.company.institute;
		var institute_en=document.company.institute_en;
		var course=document.company.course;
		var course_en=document.company.course_en;
		var hidden_enddate=document.company.calendar2;
		var hidden_startdate=document.company.calendar;
		var prs_id=document.company.prs_id;
		
		if(hidden_startdate.value==""){ alert('เริ่มฝึกอบรมเมื่อ');return false;}
		else if(hidden_enddate.value==""){ alert('สิ้นสุดการอบรมเมื่อ');return false;}
		else if(institute.value==""){ alert('กรอกชื่อสถานศึกษา');institute.focus();return false;}
		else if(course.value==""){ alert('กรอกสาขาวิชา');course.focus();return false;}
		else{ 
			var value=hidden_startdate.value+'|'+hidden_enddate.value+'|'+institute.value+'|'+institute_en.value+'|'+course.value+'|'+course_en.value;
			
			SendEditTrainingHis_admin('AddRecordTrainingHis',value,prs_id.value,lang,'admin_person_traininghis');
			}
		}
		
		function GetTrinningUpdate(numrow,lang){
		
		var Year=document.company.document.getElementById('Y'+numrow);
		var Month=document.company.document.getElementById('M'+numrow);
		var Day=document.company.document.getElementById('D'+numrow);
		
				ny=Year.value+'-';
				nm=Month.value+'-';
				nd=Day.value;
				
				var Month_Label_en =new Array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
				var Month_Label_th =new Array('มกราคม', 'กุมภาพันธ์ ', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม');
				var Month_Label_jp =new Array('1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月');
				 if(lang=='lc' || lang=='th'){var Month_Label=Month_Label_th; }
				 if(lang=='en'){var Month_Label=Month_Label_en; }
				 if(lang=='en'){var Month_Label=Month_Label_jp; }
				if(nm.length<3){nm='0'+nm;}
				if(nd.length<2){nd='0'+nd;}
				
				if(Month.value==2 & Day.value>28){
				alert(Month_Label[1]+'มีแค่28วัน');document.company.document.getElementById('D'+numrow).value=28;return false;}
				if(Month.value==4 & Day.value>30){alert(Month_Label[3]+'มีแค่30วัน');document.getElementById('D'+numrow).value=30;return false;}
				if( Month.value==6 & Day.value>30){alert(Month_Label[5]+'มีแค่30วัน');document.getElementById('D'+numrow).value=30;return false;}
				if(  Month.value==9 & Day.value>30){alert(Month_Label[8]+'มีแค่30วัน');document.getElementById('D'+numrow).value=30;return false;}
				if(   Month.value==11& Day.value>30){alert(Month_Label[10]+'มีแค่30วัน');document.getElementById('D'+numrow).value=30;return false;}
			  document.getElementById('startdate_edit'+numrow).value="";
			  document.getElementById('startdate_edit'+numrow).value=document.getElementById('startdate_edit'+numrow).value+ny+nm+nd;
			   
			//	document.getElementById("chkdate").innerHTML=frm.hidden_birthdate.value;
		/*
	    if(Year.value==""){alert('กรุณาเลือกปีที่เกิด');document.getElementById('hidden_startdate').value=""; return false;}
		else if(Month.value==""){alert('กรุณาเลือกเดือนที่เกิด');document.getElementById('hidden_startdate').value=""; return false;}
		else if(Day.value==""){alert('กรุณาเลือกวันที่เกิด ');document.getElementById('hidden_startdate').value=""; return false;}
		//else{sendedit('birthdate',document.company.hidden_birthdate.value,'<?=$prs_id;?>',document.getElementById('Rlang').value,'label_birthdate')}
		*/
		}
		function GetTrinningUpdate2(numrow,lang){
		
		var Year=document.company.document.getElementById('Y2'+numrow);
		var Month=document.company.document.getElementById('M2'+numrow);
		var Day=document.company.document.getElementById('D2'+numrow);
		
				ny=Year.value+'-';
				nm=Month.value+'-';
				nd=Day.value;
				
				var Month_Label_en =new Array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
				var Month_Label_th =new Array('มกราคม', 'กุมภาพันธ์ ', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม');
				var Month_Label_jp =new Array('1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月');
				 if(lang=='lc' || lang=='th'){var Month_Label=Month_Label_th; }
				 if(lang=='en'){var Month_Label=Month_Label_en; }
				 if(lang=='en'){var Month_Label=Month_Label_jp; }
				if(nm.length<3){nm='0'+nm;}
				if(nd.length<2){nd='0'+nd;}
				
				if(Month.value==2 & Day.value>28){
				alert(Month_Label[1]+'มีแค่28วัน');document.company.document.getElementById('D2'+numrow).value=28;return false;}
				if(Month.value==4 & Day.value>30){alert(Month_Label[3]+'มีแค่30วัน');document.getElementById('D2'+numrow).value=30;return false;}
				if( Month.value==6 & Day.value>30){alert(Month_Label[5]+'มีแค่30วัน');document.getElementById('D2'+numrow).value=30;return false;}
				if(  Month.value==9 & Day.value>30){alert(Month_Label[8]+'มีแค่30วัน');document.getElementById('D2'+numrow).value=30;return false;}
				if(   Month.value==11& Day.value>30){alert(Month_Label[10]+'มีแค่30วัน');document.getElementById('D2'+numrow).value=30;return false;}
			  document.getElementById('enddate_edit'+numrow).value="";
			  document.getElementById('enddate_edit'+numrow).value=document.getElementById('enddate_edit'+numrow).value+ny+nm+nd;
			   
			//	document.getElementById("chkdate").innerHTML=frm.hidden_birthdate.value;
		/*
	    if(Year.value==""){alert('กรุณาเลือกปีที่เกิด');document.getElementById('hidden_startdate').value=""; return false;}
		else if(Month.value==""){alert('กรุณาเลือกเดือนที่เกิด');document.getElementById('hidden_startdate').value=""; return false;}
		else if(Day.value==""){alert('กรุณาเลือกวันที่เกิด ');document.getElementById('hidden_startdate').value=""; return false;}
		//else{sendedit('birthdate',document.company.hidden_birthdate.value,'<?=$prs_id;?>',document.getElementById('Rlang').value,'label_birthdate')}
		*/
		}
       </script>
       <script language="javascript">
	  	function ChkEdu(lang){
		//alert(lang);
		/*var frm=document.company;
		var gpa=document.company.gpa;
		var gradyear=document.company.gradyear;
		var major=document.company.major;
		var institute=document.company.institute;
		var faculty=document.company.faculty;
		var hdd_eduhis=document.company.hdd_eduhis;
		/*if(hdd_eduhis.value==""){ alert('เลือกระดับการศึกษา');hdd_eduhis.focus();return false;}
		else if(faculty.value==""){ alert('กรอกชื่อคณะ');faculty.focus();return false;}
		else if(institute.value==""){ alert('กรอกชื่อสถานศึกษา');institute.focus();return false;}
		else if(major.value==""){ alert('กรอกสาขาวิชา');major.focus();return false;}
		else if(gradyear.value==""){ alert('ปีที่สำเร็จการศึกษา');gradyear.focus();return false;}
		else if(gradyear.value.length<4){ alert('ปีที่สำเร็จการศึกษา');gradyear.focus();return false;}
		else if(gpa.value==""){ alert('เกรดเฉลี่ย');gpa.focus();return false;}
		else if(gpa.value.length<3){ alert('เกรดเฉลี่ย');gpa.focus();return false;}
		else{ 
			var value=hdd_eduhis.value+'|'+faculty.value+'|'+institute.value+'|'+major.value+'|'+gradyear.value+'|'+gpa.value;
			//alert(value);
			SendEditEdu('AddRecord',value,'',lang,'person_education');
			}*/
		}
		function ChkNum(data,inputname){
		 
			var len, digit;
			len = data.length;
			for(var i=0 ; i<len ; i++){
			digit = data.charAt(i)
			if(digit >="0" && digit <="9" ){}else if(digit=="."){ }else{alert('กรอกได้เฉพราะตัวเลข'); document.company.inputname.value=""; return false; } 
			}
		}
		
		function Chk_Character(ch,label_id){
			var len, digit;
			if(ch == ""){ len=0;}else{ len = ch.length; }
			for(var i=0 ; i<len ; i++){
				digit = ch.charAt(i)
				if( (digit >= "a" && digit <= "z") || (digit >="0" && digit <="9") ){ ;	}else{ document.getElementById(label_id).innerHTML=""+"<img src=\"./images/icon_X_01.png\">"; document.getElementById('chk_label').innerHTML="ชื่อนี้มีคนใช้งานแล้ว";alert('กรอกได้แต่ 0-9 , a-z'); return false;	}else{
					document.getElementById('chk_label').innerHTML="ชื่อนี้สามารถใช้ได้";
				}
			}	
			return true;
		}	
	  </script>
        <script language="javascript">
	  	function ChkEdu2(lang){
		var frm=document.company;
		var gpa=document.company.gpa;
		var gradyear=document.company.gradyear;
		var major=document.company.major;
		var major_en=document.company.major_en;
		var institute=document.company.institute;
		var institute_en=document.company.institute_en;
		var faculty=document.company.faculty;
		var faculty_en=document.company.faculty_en;
		var hdd_eduhis=document.company.hdd_eduhis;
		if(hdd_eduhis.value==""){ alert('เลือกระดับการศึกษา');hdd_eduhis.focus();return false;}
		else if(faculty.value==""){ alert('กรอกชื่อคณะ');faculty.focus();return false;}
		else if(institute.value==""){ alert('กรอกชื่อสถานศึกษา');institute.focus();return false;}
		else if(major.value==""){ alert('กรอกสาขาวิชา');major.focus();return false;}
		else if(gradyear.value==""){ alert('ปีที่สำเร็จการศึกษา');gradyear.focus();return false;}
		else if(gradyear.value.length<4){ alert('ปีที่สำเร็จการศึกษา');gradyear.focus();return false;}
		else if(gpa.value==""){ alert('เกรดเฉลี่ย');gpa.focus();return false;}
		else if(gpa.value.length<3){ alert('เกรดเฉลี่ย');gpa.focus();return false;}
		else{ 
			var value=hdd_eduhis.value+'|'+faculty.value+'|'+faculty_en.value+'|'+institute.value+'|'+institute_en.value+'|'+major.value+'|'+major_en.value+'|'+gradyear.value+'|'+gpa.value;
			//alert(value);
			SendEditEdu('AddRecord',value,'',lang,'person_education');
			}
		}
		
		
		function ChkEdu_wizards(lang){
		var frm=document.company;
		var gpa=document.company.gpa;
		var gradyear=document.company.gradyear;
		var major=document.company.major;
		var major_en=document.company.major_en;
		var institute=document.company.institute;
		var institute_en=document.company.institute_en;
		var faculty=document.company.faculty;
		var faculty_en=document.company.faculty_en;
		var hdd_eduhis=document.company.hdd_eduhis;
		if(hdd_eduhis.value==""){ alert('เลือกระดับการศึกษา');hdd_eduhis.focus();return false;}
		if(faculty.value==""){ alert('กรอกชื่อคณะ');faculty.focus();return false;}
		if(institute.value==""){ alert('กรอกชื่อสถานศึกษา');institute.focus();return false;}
		if(major.value==""){ alert('กรอกสาขาวิชา');major.focus();return false;}
		//if(gradyear.value==""){ alert('ปีที่สำเร็จการศึกษา');gradyear.focus();return false;}
		//if(gradyear.value.length<4){ alert('ปีที่สำเร็จการศึกษา');gradyear.focus();return false;}
		//if(gpa.value==""){ alert('เกรดเฉลี่ย');gpa.focus();return false;}
		//if(gpa.value.length<3){ alert('เกรดเฉลี่ย');gpa.focus();return false;}
		else{ 
		var value=hdd_eduhis.value+'|'+faculty.value+'|'+faculty_en.value+'|'+institute.value+'|'+institute_en.value+'|'+major.value+'|'+major_en.value+'|'+gradyear.value+'|'+gpa.value;
		
			SendEditEdu('AddRecord',value,'',lang,'person_wizards_education');
			}
		}
		
		function ChkEdu_admin(lang){
		var frm=document.company;
		var gpa=document.company.gpa;
		var gradyear=document.company.gradyear;
		var major=document.company.major;
		var major_en=document.company.major_en;
		var institute=document.company.institute;
		var institute_en=document.company.institute_en;
		var faculty=document.company.faculty;
		var faculty_en=document.company.faculty_en;
		var hdd_eduhis=document.company.hdd_eduhis;
		var prs_id=document.company.prs_id;
		if(hdd_eduhis.value==""){ alert('เลือกระดับการศึกษา');hdd_eduhis.focus();return false;}
		else if(faculty.value==""){ alert('กรอกชื่อคณะ');faculty.focus();return false;}
		else if(institute.value==""){ alert('กรอกชื่อสถานศึกษา');institute.focus();return false;}
		else if(major.value==""){ alert('กรอกสาขาวิชา');major.focus();return false;}
		//else if(gradyear.value==""){ alert('ปีที่สำเร็จการศึกษา');gradyear.focus();return false;}
		//else if(gradyear.value.length<4){ alert('ปีที่สำเร็จการศึกษา');gradyear.focus();return false;}
		//else if(gpa.value==""){ alert('เกรดเฉลี่ย');gpa.focus();return false;}
		//else if(gpa.value.length<3){ alert('เกรดเฉลี่ย');gpa.focus();return false;}
		else{ 
			var value=hdd_eduhis.value+'|'+faculty.value+'|'+faculty_en.value+'|'+institute.value+'|'+institute_en.value+'|'+major.value+'|'+major_en.value+'|'+gradyear.value+'|'+gpa.value+'|'+prs_id.value;
			//alert(value);
			SendEditEdu_admin('AddRecord',value,prs_id.value,lang,'admin_person_education');
			}
		}
		</script>
      <script language="javascript">
	  function ChkNum2(data,inputname){
		  //document.company.salary_min.value
		  //document.company.salary_max.value
			var len, digit;
			len = data.length;
			for(var i=0 ; i<len ; i++){
			digit = data.charAt(i)
			if(digit >="0" && digit <="9" ){}else if(digit=="."){ }else{alert('กรอกได้เฉพราะตัวเลข'); document.company.inputname.value=""; return false; } 
			}
		}
	  function ChkSalaryFrm(lang){
	  var salary_min=document.company.salary_min.value;
	  var salary_max=document.company.salary_max.value;
	  var worktype=document.company.worktype.value;
	  
	  if(salary_min==""){ }else{  
	 
													var len, digit;
													len = salary_min.length;
													for(var i=0 ; i<len ; i++){
													digit = salary_min.charAt(i)
													if(digit >="0" && digit <="9" ){}else if(digit=="."){ }else{
														alert('<?=$jm_only_number;?>'); document.company.salary_min.value=""; return false; } 
													}
			}//end salary_min
			
			if(salary_max==""){}else{  
	  //alert(salary_min);
													var len, digit;
													len = salary_max.length;
													for(var i=0 ; i<len ; i++){
													digit = salary_max.charAt(i)
													if(digit >="0" && digit <="9" ){}else if(digit=="."){ }else{
													alert('<?=$jm_only_number;?>'); document.company.salary_max.value=""; return false; } 
													}
													
			}//end salary_max
			if(parseFloat(salary_min)>parseFloat(salary_max) ||  parseFloat(salary_max)< parseFloat(salary_min)){
			//alert('Yooooo');
			alert('<?=$jm_salary_is_not_less;?>');
			document.company.salary_max.value="";
			document.company.salary_min.value="";return false;
			}else{
			var value=worktype+'|'+salary_min+'|'+salary_max;
		     
			sendedit('work_type_salary',value,'<?=$user_id;?>',lang,'person_work_type_salary');
			
			//if(salary_min <>""  and  salary_max <>){ alert("dsds"); return false; }
			}
			 
	  }
	  
	   function ChkSalaryFrm_wizards(lang){
	  var salary_min=document.company.salary_min.value;
	  var salary_max=document.company.salary_max.value;
	  var worktype=document.company.worktype.value;
	  
	  if(salary_min==""){ }else{  
	 
													var len, digit;
													len = salary_min.length;
													for(var i=0 ; i<len ; i++){
													digit = salary_min.charAt(i)
													if(digit >="0" && digit <="9" ){}else if(digit=="."){ }else{
														alert('<?=$jm_only_number;?>'); document.company.salary_min.value=""; return false; } 
													}
			}//end salary_min
			
			if(salary_max==""){}else{  
	  //alert(salary_min);
													var len, digit;
													len = salary_max.length;
													for(var i=0 ; i<len ; i++){
													digit = salary_max.charAt(i)
													if(digit >="0" && digit <="9" ){}else if(digit=="."){ }else{
													alert('<?=$jm_only_number;?>'); document.company.salary_max.value=""; return false; } 
													}
													
			}//end salary_max
			if(parseFloat(salary_min)>parseFloat(salary_max) ||  parseFloat(salary_max)< parseFloat(salary_min)){
			//alert('Yooooo');
			alert('<?=$jm_salary_is_not_less;?>');
			document.company.salary_max.value="";
			document.company.salary_min.value="";return false;
			}else{
			var value=worktype+'|'+salary_min+'|'+salary_max;
		     
			sendedit('work_type_salary',value,'<?=$user_id;?>',lang,'person_wizards_work_type_salary');
			
			//if(salary_min <>""  and  salary_max <>){ alert("dsds"); return false; }
			}
			 
	  }
	  
	  function ChkSalaryFrm_admin(lang){
	  var salary_min=document.company.salary_min.value;
	  var salary_max=document.company.salary_max.value;
	  var worktype=document.company.worktype.value;
	  var prs_id=document.company.prs_id.value;
	  
	  if(salary_min==""){ }else{  
	 
													var len, digit;
													len = salary_min.length;
													for(var i=0 ; i<len ; i++){
													digit = salary_min.charAt(i)
													if(digit >="0" && digit <="9" ){}else if(digit=="."){ }else{
														alert('<?=$jm_only_number;?>'); document.company.salary_min.value=""; return false; } 
													}
			}//end salary_min
			
			if(salary_max==""){}else{  
	  //alert(salary_min);
													var len, digit;
													len = salary_max.length;
													for(var i=0 ; i<len ; i++){
													digit = salary_max.charAt(i)
													if(digit >="0" && digit <="9" ){}else if(digit=="."){ }else{
													alert('<?=$jm_only_number;?>'); document.company.salary_max.value=""; return false; } 
													}
													
			}//end salary_max
			if(parseFloat(salary_min)>parseFloat(salary_max) ||  parseFloat(salary_max)< parseFloat(salary_min)){
			//alert('Yooooo');
			alert('<?=$jm_salary_is_not_less;?>');
			//document.company.salary_max.value="";
			document.company.salary_min.value="";
			return false;
			}else{
				
			var value=worktype+'|'+salary_min+'|'+salary_max;
		     
			sendedit_admin('work_type_salary_admin',value,prs_id,lang,'admin_person_work_salary');
			
			//if(salary_min <>""  and  salary_max <>){ alert("dsds"); return false; }
			}
			 
	  }
	  
	  </script>
      <script type='text/javascript'>
				function  checkNumber(data,id_name){
				
													var len, digit;
													len = data.length;
													for(var i=0 ; i<len ; i++){
													digit = data.charAt(i)
													if(digit >="0" && digit <="9" ){}else if(digit=="."){ }else{
													alert('<?=$jm_only_number;?>'); //document.company.id_name.value=""; //document.id_name.focus();  
													} 
													}
			
				}
				function  checkNumber2(data,id_name){
				
													var len, digit;
													len = data.length;
													for(var i=0 ; i<len ; i++){
													digit = data.charAt(i)
													if(digit >="0" && digit <="9" ){}else if(digit=="."){ }else{
													alert('<?=$jm_only_number;?>'); //document.company.id_name.value=""; //document.id_name.focus();  
													} 
													}
			
				}
</script>
          <script language="javascript">
		 	function radio_listen(data,inputname){
				document.getElementById(inputname).value=data;
			}
		function ChkSkill_Lang(langskill,listen,speak,read,writ){

	
		var listen=document.getElementById(listen);
		var speak=document.getElementById(speak);
		var read=document.getElementById(read);
		var writ=document.getElementById(writ);
	   
	     if(langskill==""){ alert('กรุณาชื่อภาษา');document.company.lang_other3.focus();return false;}
		else if(listen.value==""){ alert('กรุณาเลือกทักษะการฟัง');return false;}
		 else if(speak.value==""){ alert('กรุณาเลือกทักษะการพูด');return false;}
		 else if(read.value==""){ alert('กรุณาเลือกทักษะการอ่าน');return false;}
		 else if(writ.value==""){ alert('กรุณาเลือกทักษะการเขียน');return false;}
		else{ 
			var value=langskill+'|'+listen.value+','+speak.value+','+read.value+','+writ.value;
			//alert(value);
			SendEditLangSkill('langskill',value,'<?=$edh_id;?>',document.getElementById('Rlang').value,'langskill');
			}
		}//
		function ChkSkill(label_id,chk1,chk2,chk3){
		var value="";
		if(document.getElementById(chk1).checked==true){ value=value+1+',';}else{ value=value+0+',';}
		 if(document.getElementById(chk2).checked==true){ value=value+1+',';}else{ value=value+0+',';}
		 if(document.getElementById(chk3).checked==true){ value=value+1+',';}else{ value=value+0+',';}
			//alert(value);
		SendEditLangSkill(label_id,value,'<?=$user_id;?>',document.getElementById('Rlang').value,'langskill');
			
			
		}//
		
		function SendEditLangSkill(field,value,id_prs,lang,id_field_label){	
		function Inint_AJAX() {
  												 try { return new ActiveXObject("Msxml2.XMLHTTP"); } catch(e) {} //IE
   												 try { return new ActiveXObject("Microsoft.XMLHTTP"); } catch(e) {} //IE
   												 try { return new XMLHttpRequest(); } catch(e) {} //Native Javascript
   												 alert("XMLHttpRequest not supported")
   												 return null
											}
											var req = Inint_AJAX(); // Object
											//alert(field);
     											req.open('GET', 'person_action.php?value='+encodeURIComponent(value)+'&field='+encodeURIComponent(field)+'&lang='+encodeURIComponent(lang)+'&id_prs='+encodeURIComponent(id_prs), true); //
     											req.onreadystatechange = function() { //
          										if (req.readyState==4) {
               										if (req.status==200) { //
                    							var data=req.responseText; //
												
												//ResumeTap('person_langskill','','',lang,'resume');
                    							document.getElementById(id_field_label).innerHTML=""+data; //
               										}
          										}
     										};
     										req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // 
     										req.send(null); //
	}//
		 </script>

<!--END Form Edit Person ===================================================================================-->
<!--START UPLOAD PICTUR========================================================================================-->
<script language="javascript">
function fncSubmit()
{
//if(confirm('Confirm to submit')==true)
//{
document.getElementById("progress").style.visibility="visible";
document.company.submit();
//return true;
//}
//else
//{
//return false;
//}
}
function showResult(result,filename)
{
document.getElementById("progress").style.visibility="hidden";
	if(result==1){
	//alert(filename)
	window.top.window.resumewizards('1');
	document.getElementById("picfield").value=filename;
	document.getElementById("path_pic").value='tmp';
	document.getElementById("divresult").innerHTML = "<img  src=./images/tmp/"+filename+"  width=\"160\" height=\"90\"><br><img  src=./images/badge_save_outline.png onclick=\"javascript: sendeditpic('pictur',document.getElementById('picfield').value+'|'+document.getElementById('hinden_picfield').value,'<?=$prs_id;?>','##lang##','person_history');\" width=\"40\" height=\"15\" style=\"margin-top:10px; cursor:pointer; display:none;\">";

	}
	if(result==2){
	 alert('ไฟลที่อัพโหลดมีขนาด'+filename+'kbซึ่งเกินที่เรากำหนดคือ 100 kb')
	}
	if(result==3){
	var filename=document.getElementById("picfield").value;
	//alert(filename);
	document.getElementById("divresult").innerHTML = "<img  src=./images/person/"+filename+"  width=\"120\" height=\"150\"> ";
	}
}//

function showResult_person(result,filename)
{
document.getElementById("progress").style.visibility="hidden";
	if(result==1){
	//alert(filename)
	
	document.getElementById("picfield").value=filename;
	document.getElementById("path_pic").value='tmp';
	document.getElementById("divresult").innerHTML = "<img  src=./images/tmp/"+filename+"  width=\"120\" height=\"150\"><br><img  src=./images/badge_save_outline.png onclick=\"javascript: sendeditpic('pictur',document.getElementById('picfield').value+'|'+document.getElementById('hinden_picfield').value,'<?=$prs_id;?>','##lang##','person_history');\" width=\"40\" height=\"15\" style=\"margin-top:10px; cursor:pointer; display:none;\">";

	}
	if(result==2){
	 alert('ไฟลที่อัพโหลดมีขนาด'+filename+'kbซึ่งเกินที่เรากำหนดคือ 100 kb')
	}
	if(result==3){
	var filename=document.getElementById("picfield").value;
	//alert(filename);
	document.getElementById("divresult").innerHTML = "<img  src=./images/person/"+filename+"  width=\"120\" height=\"150\"> ";
	}
}//

function sendfilepicname(filename){
//	alert(filename);
	document.getElementById("picfield2").value=filename;
} 
function showResult2(result,filename)
{
document.getElementById("progress").style.visibility="hidden";
	if(result==1){
	//alert(filename)
	
	document.getElementById("picfield").value=filename;
	document.getElementById("path_pic").value='tmp';
	//document.getElementById("divresult").innerHTML = "<img  src=./images/tmp/"+filename+"  width=\"120\" height=\"150\">  <br>";
	document.getElementById("divresult").innerHTML = "<img  src=./images/tmp/"+filename+"  width=\"160\" height=\"90\"><br><img  src=./images/badge_save_outline.png onclick=\"javascript: sendeditpic('pictur',document.getElementById('picfield').value+'|'+document.getElementById('hinden_picfield').value,'<?=$prs_id;?>','##lang##','person_history');\" width=\"40\" height=\"15\" style=\"margin-top:10px; cursor:pointer; display:none;\">";
	
	}
	if(result==2){
	 alert('ไฟลที่อัพโหลดมีขนาด'+filename+'kbซึ่งเกินที่เรากำหนดคือ 100 kb')
	}
	if(result==3){
	var filename=document.getElementById("picfield").value;
	//alert(filename);
	document.getElementById("divresult").innerHTML = "<img  src=./images/person/"+filename+"  width=\"160\" height=\"90\"> ";
	}
}//
function showResult4(result,filename)
{
document.getElementById("progress").style.visibility="hidden";
	if(result==1){
	//alert(filename)
	
	document.getElementById("picfield").value=filename;
	document.getElementById("divresult").innerHTML = "<img  src=./images/tmp/"+filename+"  width=\"160\" height=\"90\">  <br>";

	}
	if(result==2){
	 alert('ไฟลที่อัพโหลดมีขนาด'+filename+'kbซึ่งเกินที่เรากำหนดคือ 100 kb')
	}
	if(result==3){
	var filename=document.getElementById("picfield").value;
	//alert(filename);
	document.getElementById("divresult").innerHTML = "<img  src=./images/company/"+filename+"  width=\"160\" height=\"90\"> ";
	}
}//.....................................................................................................
function sendeditpic(field,value,id_prs,lang,id_field_label){	
		//alert(field);alert(value);alert(id_prs);alert(lang);
		//alert(value);
		function Inint_AJAX() {
  												 try { return new ActiveXObject("Msxml2.XMLHTTP"); } catch(e) {} //IE
   												 try { return new ActiveXObject("Microsoft.XMLHTTP"); } catch(e) {} //IE
   												 try { return new XMLHttpRequest(); } catch(e) {} //Native Javascript
   												 alert("XMLHttpRequest not supported")
   												 return null
											}
											var req = Inint_AJAX(); // Object
											//alert(field);
     											req.open('GET', 'person_action.php?value='+encodeURIComponent(value)+'&field='+encodeURIComponent(field)+'&lang='+encodeURIComponent(lang)+'&id_prs='+encodeURIComponent(id_prs), true); //
     											req.onreadystatechange = function() { //
          										if (req.readyState==4) {
               										if (req.status==200) { //
                    							var data=req.responseText; //
											
                    							document.getElementById(id_field_label).innerHTML=""+data; //
												
												//ResumeTap('person_history','','',lang,'resume');
               										}
          										}
     										};
     										req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // 
     										req.send(null); //
	}
	function sendeditpic2(field,value,id_prs,lang,id_field_label){	
		//alert(field);alert(value);alert(id_prs);alert(lang);
		//alert(value);
		function Inint_AJAX() {
  												 try { return new ActiveXObject("Msxml2.XMLHTTP"); } catch(e) {} //IE
   												 try { return new ActiveXObject("Microsoft.XMLHTTP"); } catch(e) {} //IE
   												 try { return new XMLHttpRequest(); } catch(e) {} //Native Javascript
   												 alert("XMLHttpRequest not supported")
   												 return null
											}
											var req = Inint_AJAX(); // Object
											//alert(field);
     									req.open('GET', 'company_action.php?value='+encodeURIComponent(value)+'&field='+encodeURIComponent(field)+'&lang='+encodeURIComponent(lang)+'&id_prs='+encodeURIComponent(id_prs), true); //
     											req.onreadystatechange = function() { //
          										if (req.readyState==4) {
               										if (req.status==200) { //
                    							var data=req.responseText; //
											
                    							document.getElementById(id_field_label).innerHTML=""+data; //
												
												//ResumeTap('company_preview','','',lang,'resume');
               										}
          										}
     										};
     										req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // 
     										req.send(null); //
	}
</script>
<script language="javascript">
	function sendlogo(){
	
	document.company.logo.value='logo';
	document.company.target="_parent";
	document.company.action='./company_action.php';
	document.company.submit();
	
	}
</script>
<script  language="javascript">
	function delpic(lang,picname,path){
			//alert(picname);
			if(confirm("ต้องการลบรูปนี้ กด Ok หากไม่ใช่กด Cancel")){
			document.location="unlink.php?picname="+picname+"&path="+path;
		}else{}
	}
	function delpic_cpn(lang,picname,path){
			//alert(picname);
			if(confirm("ต้องการลบรูปนี้ กด Ok หากไม่ใช่กด Cancel")){
			document.location="unlink_company.php?picname="+picname+"&path="+path;
		}else{}
	}
</script>
<!--END UPLOAD PICTUR========================================================================================-->
<script language="javascript">
	function shwform(text_label,form,sta){
		var str_id=form.split("|");
		var str_label=text_label.split("|");
		
		if(sta=='show'){
									for(i=0;i<=str_label.length-1;i++){
										document.getElementById(str_label[i]).style.display='none';
										
									}
		
									for(i=0;i<=str_id.length-1;i++){
													
													document.getElementById(str_id[i]).style.display='';
												}
		}// end show
		if(sta=='hidden'){
									for(i=0;i<=str_label.length-1;i++){
									document.getElementById(str_label[i]).style.display='';
									document.getElementById(str_id[i]).style.display='none';
								}
								for(i=0;i<=str_id.length-1;i++){
												document.getElementById(str_id[i]).style.display='none';
											}
		}// end hidden
		
	}
</script>
<script language="javascript">
	function formhistory(lang){
	var value='';
	var name=document.getElementById('name').value;
	var name_en=document.getElementById('name_en').value;
	var nlt_name=document.getElementById('nlt_name').value;
	var idennumber=document.getElementById('idennumber').value;
	var hidden_birthdate=document.getElementById('calendar').value;
	var hidden_sex=document.getElementById('hidden_sex').value;
	var maritalstatus=document.getElementById('maritalstatus').value;
	var height=document.getElementById('height').value; 
	var weight=document.getElementById('weight').value; 
	var religion=document.getElementById('religion').value; 
	var address=document.getElementById('address').value; 
	var address_en=document.getElementById('address_en').value; 
	var cad_country=document.getElementById('cad_country').value;
	var province_name=document.getElementById('province_name').value;
	var district_name=document.getElementById('district_name').value;
	var portal=document.getElementById('portal').value;
	var tel=document.getElementById('tel').value;
	var mobile=document.getElementById('mobile').value;
	var militarystatus=document.getElementById('militarystatus').value;
	var email=document.getElementById('email').value;
	var picfield=document.getElementById('picfield').value;
	var hinden_picfield=document.getElementById('hinden_picfield').value;
	 value=name+'|'+name_en+'|'+nlt_name+'|'+idennumber+'|'+hidden_birthdate+'|'+hidden_sex+'|'+maritalstatus+'|'+height+'|'+weight+'|'+religion+'|'+address+'|'+address_en+'|'+cad_country+'|'+province_name+'|'+district_name+'|'+portal+'|'+tel+'|'+mobile+'|'+militarystatus+'|'+email+'|'+picfield+'|'+hinden_picfield;
	
	sendedit('formhistory',value,'<?=$prs_id;?>',lang,'person_history');
	
	}
	
	function formhistory_wizards(lang){
	var value='';
	
	var name=document.getElementById('name').value;
	var name_en=document.getElementById('name_en').value;
	var nlt_name=document.getElementById('nlt_name').value;
	var idennumber=document.getElementById('idennumber').value;
	var hidden_birthdate=document.getElementById('calendar').value;
	var hidden_sex=document.getElementById('hidden_sex').value;
	var maritalstatus=document.getElementById('maritalstatus').value;
	var height=document.getElementById('height').value; 
	var weight=document.getElementById('weight').value; 
	var religion=document.getElementById('religion').value; 
	var address=document.getElementById('address').value; 
	var address_en=document.getElementById('address_en').value; 
	var cad_country=document.getElementById('cad_country').value;
	var province_name=document.getElementById('province_name').value;
	var district_name=document.getElementById('district_name').value;
	var portal=document.getElementById('portal').value;
	var tel=document.getElementById('tel').value;
	var mobile=document.getElementById('mobile').value;
	var militarystatus=document.getElementById('militarystatus').value;
	var email=document.getElementById('email').value;
	var picfield=document.getElementById('picfield').value;
	var hinden_picfield=document.getElementById('hinden_picfield').value;
	
	 value=name+'|'+name_en+'|'+nlt_name+'|'+idennumber+'|'+hidden_birthdate+'|'+hidden_sex+'|'+maritalstatus+'|'+height+'|'+weight+'|'+religion+'|'+address+'|'+address_en+'|'+cad_country+'|'+province_name+'|'+district_name+'|'+portal+'|'+tel+'|'+mobile+'|'+militarystatus+'|'+email+'|'+picfield+'|'+hinden_picfield;
	
	sendedit('formhistory',value,'<?=$prs_id;?>',lang,'person_wizards_history');
	
	}
	
	function formhistory_person_by_admin(lang){
	var value='';
	var name=document.getElementById('name').value;
	var name_en=document.getElementById('name_en').value;
	var nlt_name=document.getElementById('nlt_name').value;
	var idennumber=document.getElementById('idennumber').value;
	var hidden_birthdate=document.getElementById('calendar').value;
	var hidden_sex=document.getElementById('hidden_sex').value;
	var maritalstatus=document.getElementById('maritalstatus').value;
	var height=document.getElementById('height').value; 
	var weight=document.getElementById('weight').value; 
	var religion=document.getElementById('religion').value; 
	var address=document.getElementById('address').value; 
	var address_en=document.getElementById('address_en').value; 
	var cad_country=document.getElementById('cad_country').value;
	var province_name=document.getElementById('province_name').value;
	var district_name=document.getElementById('district_name').value;
	var portal=document.getElementById('portal').value;
	var tel=document.getElementById('tel').value;
	var mobile=document.getElementById('mobile').value;
	var militarystatus=document.getElementById('militarystatus').value;
	var email=document.getElementById('email').value;
	var picfield=document.getElementById('picfield').value;
	var hinden_picfield=document.getElementById('hinden_picfield').value;
	var prs_id=document.getElementById('prs_id').value;
	 value=name+'|'+name_en+'|'+nlt_name+'|'+idennumber+'|'+hidden_birthdate+'|'+hidden_sex+'|'+maritalstatus+'|'+height+'|'+weight+'|'+religion+'|'+address+'|'+address_en+'|'+cad_country+'|'+province_name+'|'+district_name+'|'+portal+'|'+tel+'|'+mobile+'|'+militarystatus+'|'+email+'|'+picfield+'|'+hinden_picfield;
	
	sendedit('formhistory',value,prs_id,lang,'admin_person_history');
	
	}
	
	function formcompany(){
	
	var value='';
	var name_lc=document.getElementById('name_lc').value;
	var name_en=document.getElementById('name_en').value;
	var name_nlt=document.getElementById('name_nlt').value;
	var idennumber=document.getElementById('idennumber').value;
	var contactname_lc=document.getElementById('contactname_lc').value;
	var contactname_en=document.getElementById('contactname_en').value;
	var contactemail=document.getElementById('contactemail').value; 
	var website=document.getElementById('website').value; 
	//var taxcontactname=document.getElementById('taxcontactname').value; 
	var taxaddress=document.getElementById('taxaddress').value; 
	var taxtel=document.getElementById('taxtel').value;
	var  taxemail=document.getElementById('taxemail').value;
	var desc=document.getElementById('desc_lc').value;
	var welfare=document.getElementById('welfare').value;
	var howknow=document.getElementById('howknow').value;
	var picfield=document.getElementById('picfield').value;
	var hinden_picfield=document.getElementById('hinden_picfield').value;
	var path_pic=document.getElementById('path_pic').value;
	
	 value=name_lc+'|'+name_en+'|'+name_nlt+'|'+idennumber+'|'+contactname_lc+'|'+contactname_en+'|'+contactemail+'|'+website+'|'+taxaddress+'|'+taxtel+'|'+taxemail+'|'+desc+'|'+welfare+'|'+howknow+'|'+picfield+'|'+hinden_picfield+'|'+path_pic;
	sendedit_cpn('formcompany',value,'','<?=$_COOKIE['lang'];?>','company_preview');
	
	
	}//
	
	function formcompany_admin(){
	
	var value='';
	var name_lc=document.getElementById('name_lc').value;
	var name_en=document.getElementById('name_en').value;
	var name_nlt=document.getElementById('name_nlt').value;
	var idennumber=document.getElementById('idennumber').value;
	var contactname_lc=document.getElementById('contactname_lc').value;
	var contactname_en=document.getElementById('contactname_en').value;
	var contactemail=document.getElementById('contactemail').value; 
	var website=document.getElementById('website').value; 
	//var taxcontactname=document.getElementById('taxcontactname').value; 
	var taxaddress=document.getElementById('taxaddress').value; 
	var taxtel=document.getElementById('taxtel').value;
	var  taxemail=document.getElementById('taxemail').value;
	var desc=document.getElementById('desc').value;
	var welfare=document.getElementById('welfare').value;
	var howknow=document.getElementById('howknow').value;
	var picfield=document.getElementById('picfield').value;
	var hinden_picfield=document.getElementById('hinden_picfield').value;
	var path_pic=document.getElementById('path_pic').value;
	var lang=document.getElementById('lang').value;
	var cpn_id=document.getElementById('cpn_id').value;
	
	 value=name_lc+'|'+name_en+'|'+name_nlt+'|'+idennumber+'|'+contactname_lc+'|'+contactname_en+'|'+contactemail+'|'+website+'|'+taxaddress+'|'+taxtel+'|'+taxemail+'|'+desc+'|'+welfare+'|'+howknow+'|'+picfield+'|'+hinden_picfield+'|'+path_pic;
	sendedit_cpn_admin('formcompany_admin',value,cpn_id,lang,'admin_company_preview');
	
	
	}//
	
	function formbranch(label_field,tap_result,lang){
	var value='';
	             
	var cad_place_name_lc=document.getElementById('cad_place_name_lc').value;
	var cad_place_name_en=document.getElementById('cad_place_name_en').value;
	var cad_address_lc=document.getElementById('cad_address_lc').value;
	var cad_address_en=document.getElementById('cad_address_en').value;
	var  cad_country=document.getElementById('cad_country').value;
	var province_name=document.getElementById('province_name').value;
	var district_name=document.getElementById('district_name').value; 
	var cad_portal=document.getElementById('cad_portal').value; 
	var cad_tel=document.getElementById('cad_tel').value; 
	var cad_fax=document.getElementById('cad_fax').value; 
	//var picfield=document.getElementById('picfield').value;
	//var hinden_picfield=document.getElementById('hinden_picfield').value;
	var  cad_gmaplat=document.getElementById('cad_gmaplat').value;
	var cad_gmaplng=document.getElementById('cad_gmaplng').value;
	var cad_type=document.getElementById('cad_type').value;
	var hidden_id_cad=document.getElementById('hidden_id_cad').value;
	 value=cad_place_name_lc+'|'+cad_place_name_en+'|'+cad_address_lc+'|'+cad_address_en+'|'+cad_country+'|'+province_name+'|'+district_name+'|'+cad_portal+'|'+cad_tel+'|'+cad_fax+'|'+cad_gmaplat+'|'+cad_gmaplng+'|'+cad_type+'|'+hidden_id_cad;
	// alert(value);
	sendedit_cpn(label_field,value,hidden_id_cad,lang,tap_result);
	//alert(value);
	}//

function formbranch_admin(label_field,tap_result,lang){
	var value='';
	             
	var cad_place_name_lc=document.getElementById('cad_place_name_lc').value;
	var cad_place_name_en=document.getElementById('cad_place_name_en').value;
	var cad_address_lc=document.getElementById('cad_address_lc').value;
	var cad_address_en=document.getElementById('cad_address_en').value;
	var  cad_country=document.getElementById('cad_country').value;
	var province_name=document.getElementById('province_name').value;
	var district_name=document.getElementById('district_name').value; 
	var cad_portal=document.getElementById('cad_portal').value; 
	var cad_tel=document.getElementById('cad_tel').value; 
	var cad_fax=document.getElementById('cad_fax').value; 
	//var picfield=document.getElementById('picfield').value;
	//var hinden_picfield=document.getElementById('hinden_picfield').value;
	var  cad_gmaplat=document.getElementById('cad_gmaplat').value;
	var cad_gmaplng=document.getElementById('cad_gmaplng').value;
	var cad_type=document.getElementById('cad_type').value;
	var hidden_id_cad=document.getElementById('hidden_id_cad').value;
	 value=cad_place_name_lc+'|'+cad_place_name_en+'|'+cad_address_lc+'|'+cad_address_en+'|'+cad_country+'|'+province_name+'|'+district_name+'|'+cad_portal+'|'+cad_tel+'|'+cad_fax+'|'+cad_gmaplat+'|'+cad_gmaplng+'|'+cad_type+'|'+hidden_id_cad;
	// alert(value);
	sendedit_cpn_admin(label_field,value,hidden_id_cad,lang,tap_result);
	//alert(value);
	}//

	
	function formbranch_edit(label_field,tap_result,lang){
	var value='';
	             
	var cad_place_name_lc=document.getElementById('cad_place_name_lc').value;
	var cad_place_name_en=document.getElementById('cad_place_name_en').value;
	var cad_address_lc=document.getElementById('cad_address_lc').value;
	var cad_address_en=document.getElementById('cad_address_en').value;
	var cad_country=document.getElementById('cad_country').value;
	var province_name=document.getElementById('province_name').value;
	var district_name=document.getElementById('district_name').value; 
	var cad_portal=document.getElementById('cad_portal').value; 
	var cad_tel=document.getElementById('cad_tel').value; 
	var cad_fax=document.getElementById('cad_fax').value; 
	//var picfield=document.getElementById('picfield').value;
	//var hinden_picfield=document.getElementById('hinden_picfield').value;
	var cad_gmaplat=document.getElementById('cad_gmaplat').value;
	var cad_gmaplng=document.getElementById('cad_gmaplng').value;
	var cad_type=document.getElementById('cad_type').value;
	var hidden_id_cad=document.getElementById('hidden_id_cad').value;
	 value=cad_place_name_lc+'|'+cad_place_name_en+'|'+cad_address_lc+'|'+cad_address_en+'|'+cad_country+'|'+province_name+'|'+district_name+'|'+cad_portal+'|'+cad_tel+'|'+cad_fax+'|'+cad_gmaplat+'|'+cad_gmaplng+'|'+cad_type+'|'+hidden_id_cad;
	 //alert(value);
	sendedit_cpn(label_field,value,hidden_id_cad,lang,tap_result);
	//alert(value);
	}//
	
	function formbranch_edit_admin(label_field,tap_result,lang){
	var value='';
	             
	var cad_place_name_lc=document.getElementById('cad_place_name_lc').value;
	var cad_place_name_en=document.getElementById('cad_place_name_en').value;
	var cad_address_lc=document.getElementById('cad_address_lc').value;
	var cad_address_en=document.getElementById('cad_address_en').value;
	var cad_country=document.getElementById('cad_country').value;
	var province_name=document.getElementById('province_name').value;
	var district_name=document.getElementById('district_name').value; 
	var cad_portal=document.getElementById('cad_portal').value; 
	var cad_tel=document.getElementById('cad_tel').value; 
	var cad_fax=document.getElementById('cad_fax').value; 
	//var picfield=document.getElementById('picfield').value;
	//var hinden_picfield=document.getElementById('hinden_picfield').value;
	var cad_gmaplat=document.getElementById('cad_gmaplat').value;
	var cad_gmaplng=document.getElementById('cad_gmaplng').value;
	var cad_type=document.getElementById('cad_type').value;
	var hidden_id_cad=document.getElementById('hidden_id_cad').value;
	 value=cad_place_name_lc+'|'+cad_place_name_en+'|'+cad_address_lc+'|'+cad_address_en+'|'+cad_country+'|'+province_name+'|'+district_name+'|'+cad_portal+'|'+cad_tel+'|'+cad_fax+'|'+cad_gmaplat+'|'+cad_gmaplng+'|'+cad_type+'|'+hidden_id_cad;
	 //alert(value);
	sendedit_cpn_admin(label_field,value,hidden_id_cad,lang,tap_result);
	//alert(value);
	}//
	
	function formannounce(sendfrm,lang){
	var value='';
	var job_name=document.getElementById('job_name').value;
	var jcs_id=document.getElementById('jcs_id').value;
	var job_desc=document.getElementById('job_desc').value;
	var job_worktype=document.getElementById('job_worktype').value;
	var  cad_id=document.getElementById('cad_id').value;
	var job_quantity=document.getElementById('job_quantity').value;
	var job_salarymin=document.getElementById('job_salarymin').value; 
	var job_salarymax=document.getElementById('job_salarymax').value; 
	//var job_salarycurrency=document.getElementById('job_salarycurrency').value; 
	var job_salarycurrency='';
	var job_extraincome=document.getElementById('job_extraincome').value; 
	var  job_extrawelfare=document.getElementById('job_extrawelfare').value;
    var job_spec=document.getElementById('job_spec').value;
	var job_agemin=document.getElementById('job_agemin').value;
	var job_agemax=document.getElementById('job_agemax').value;
	var job_expmin=document.getElementById('job_expmin').value;
	var job_expmax=document.getElementById('job_expmax').value;
	var job_edumin=document.getElementById('job_edumin').value;
	var job_edumax=document.getElementById('job_edumax').value;
	var job_gender=document.getElementById('job_gender').value;
	var hiddenField=document.getElementById('hiddenField').value;
	
	var msg_err="";
	if(job_name==''){document.getElementById('label_job_name').innerHTML="<span style=\"border:1x #FF6600 dotted; margin-left:0px;\"class=\"textbox_error\"><?=$jm_enter_the_job_title;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">";msg_err="1"; return false;}else{document.getElementById('label_job_name').innerHTML="";msg_err="";}
	if(jcs_id==''){document.getElementById('label_jcs_id').innerHTML="<span style=\"border:1x #FF6600 dotted; margin-left:0px;\"class=\"textbox_error\"><?=$jm_select_jobs;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">";msg_err="1";return false;}else{document.getElementById('label_jcs_id').innerHTML="";msg_err="";}
	if(job_worktype==''){document.getElementById('label_job_worktype').innerHTML="<span style=\"border:1x #FF6600 dotted; margin-left:0px;\"class=\"textbox_error\"><?=$jm_style_operation;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">";msg_err="1";return false;}else{document.getElementById('label_job_worktype').innerHTML="";msg_err="";}
	if(cad_id==''){document.getElementById('label_cad_id').innerHTML="<span style=\"border:1x #FF6600 dotted; margin-left:0px;\"class=\"textbox_error\"><?=$jm_workplace;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">";msg_err="1";return false;}else{document.getElementById('label_cad_id').innerHTML="";msg_err="";}
	
	if(job_gender==''){document.getElementById('label_job_gender').innerHTML="<span style=\"border:1x #FF6600 dotted; margin-left:0px;\"class=\"textbox_error\"><?=$jm_education_gender_to_recruit;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">";msg_err="1";return false;}else{document.getElementById('label_job_gender').innerHTML="";msg_err="";}
	
	if(job_edumin==''){document.getElementById('label_job_edumin').innerHTML="<span style=\"border:1x #FF6600 dotted; margin-left:0px;\"class=\"textbox_error\"><?=$jm_education_minimum;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">";msg_err="1";return false;}else{document.getElementById('label_job_edumin').innerHTML="";msg_err="";}
	if(job_edumax==''){document.getElementById('label_job_edumax').innerHTML="<span style=\"border:1x #FF6600 dotted; margin-left:0px;\"class=\"textbox_error\"><?=$jm_education_maximum;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">";msg_err="1";return false;}else{document.getElementById('label_job_edumax').innerHTML="";msg_err="";}
	
	//alert(sendfrm);
	if(msg_err=="" & sendfrm=="send"){
	value=job_name+'|'+jcs_id+'|'+job_desc+'|'+job_worktype+'|'+cad_id+'|'+job_quantity+'|'+job_salarymin+'|'+job_salarymax+'|'+job_salarycurrency+'|'+job_extraincome+'|'+job_extrawelfare+'|'+job_spec+'|'+job_agemin+'|'+job_agemax+'|'+job_expmin+'|'+job_expmax+'|'+job_edumin+'|'+job_edumax+'|'+job_gender+'|'+hiddenField;
    
	
	sendedit_cpn('formannounce',value,hiddenField,lang,'company_announce');

	}
}

function formannounce_extra(sendfrm,lang){
	var value='';
	var job_name=document.getElementById('job_name').value;
	var jcs_id=document.getElementById('jcs_id').value;
	var job_desc=document.getElementById('job_desc').value;
	var job_worktype=document.getElementById('job_worktype').value;
	var  cad_id=document.getElementById('cad_id').value;
	var job_quantity=document.getElementById('job_quantity').value;
	var job_salarymin=document.getElementById('job_salarymin').value; 
	var job_salarymax=document.getElementById('job_salarymax').value; 
	//var job_salarycurrency=document.getElementById('job_salarycurrency').value; 
	var job_salarycurrency='';
	var job_extraincome=document.getElementById('job_extraincome').value; 
	var  job_extrawelfare=document.getElementById('job_extrawelfare').value;
    var job_spec=document.getElementById('job_spec').value;
	var job_agemin=document.getElementById('job_agemin').value;
	var job_agemax=document.getElementById('job_agemax').value;
	var job_expmin=document.getElementById('job_expmin').value;
	var job_expmax=document.getElementById('job_expmax').value;
	var job_edumin=document.getElementById('job_edumin').value;
	var job_edumax=document.getElementById('job_edumax').value;
	var job_gender=document.getElementById('job_gender').value;
	var hiddenField=document.getElementById('hiddenField').value;
	
	var msg_err="";
	if(job_name==''){document.getElementById('label_job_name').innerHTML="<span style=\"border:1x #FF6600 dotted; margin-left:0px;\"class=\"textbox_error\"><?=$jm_enter_the_job_title;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">";msg_err="1"; return false;}else{document.getElementById('label_job_name').innerHTML="";msg_err="";}
	if(jcs_id==''){document.getElementById('label_jcs_id').innerHTML="<span style=\"border:1x #FF6600 dotted; margin-left:0px;\"class=\"textbox_error\"><?=$jm_select_jobs;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">";msg_err="1";return false;}else{document.getElementById('label_jcs_id').innerHTML="";msg_err="";}
	if(job_worktype==''){document.getElementById('label_job_worktype').innerHTML="<span style=\"border:1x #FF6600 dotted; margin-left:0px;\"class=\"textbox_error\"><?=$jm_style_operation;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">";msg_err="1";return false;}else{document.getElementById('label_job_worktype').innerHTML="";msg_err="";}
	if(cad_id==''){document.getElementById('label_cad_id').innerHTML="<span style=\"border:1x #FF6600 dotted; margin-left:0px;\"class=\"textbox_error\"><?=$jm_workplace;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">";msg_err="1";return false;}else{document.getElementById('label_cad_id').innerHTML="";msg_err="";}
	
	if(job_gender==''){document.getElementById('label_job_gender').innerHTML="<span style=\"border:1x #FF6600 dotted; margin-left:0px;\"class=\"textbox_error\"><?=$jm_education_gender_to_recruit;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">";msg_err="1";return false;}else{document.getElementById('label_job_gender').innerHTML="";msg_err="";}
	
	if(job_edumin==''){document.getElementById('label_job_edumin').innerHTML="<span style=\"border:1x #FF6600 dotted; margin-left:0px;\"class=\"textbox_error\"><?=$jm_education_minimum;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">";msg_err="1";return false;}else{document.getElementById('label_job_edumin').innerHTML="";msg_err="";}
	if(job_edumax==''){document.getElementById('label_job_edumax').innerHTML="<span style=\"border:1x #FF6600 dotted; margin-left:0px;\"class=\"textbox_error\"><?=$jm_education_maximum;?></span><img src=\"./images/icon_X_01.png\" width=\"15\" height=\"15\" style=\"margin-left:5px;\">";msg_err="1";return false;}else{document.getElementById('label_job_edumax').innerHTML="";msg_err="";}
	
	//alert(sendfrm);
	if(msg_err=="" & sendfrm=="send"){
	value=job_name+'|'+jcs_id+'|'+job_desc+'|'+job_worktype+'|'+cad_id+'|'+job_quantity+'|'+job_salarymin+'|'+job_salarymax+'|'+job_salarycurrency+'|'+job_extraincome+'|'+job_extrawelfare+'|'+job_spec+'|'+job_agemin+'|'+job_agemax+'|'+job_expmin+'|'+job_expmax+'|'+job_edumin+'|'+job_edumax+'|'+job_gender+'|'+hiddenField;
    
	
	sendedit_cpn('formannounce_extra',value,hiddenField,lang,'company_announce_extra');

	}
}

function formannounceupdate(label_field,tap_result,lang){
	var value='';
	var job_name=document.getElementById('job_name').value;
	var jcs_id=document.getElementById('jcs_id').value;
	var job_desc=document.getElementById('job_desc').value;
	var job_worktype=document.getElementById('job_worktype').value;
	var  cad_id=document.getElementById('cad_id').value;
	var job_quantity=document.getElementById('job_quantity').value;
	var job_salarymin=document.getElementById('job_salarymin').value; 
	var job_salarymax=document.getElementById('job_salarymax').value; 
	var job_salarycurrency=document.getElementById('job_salarycurrency').value; 
	var job_extraincome=document.getElementById('job_extraincome').value; 
	//var job_extraincome=document.getElementById('job_extraincome').value;
	var  job_extrawelfare=document.getElementById('job_extrawelfare').value;
	var job_spec=document.getElementById('job_spec').value;
	var job_agemin=document.getElementById('job_agemin').value;
	var job_agemax=document.getElementById('job_agemax').value;
	var job_expmin=document.getElementById('job_expmin').value;
	var job_expmax=document.getElementById('job_expmax').value;
	var job_edumin=document.getElementById('job_edumin').value;
	var job_edumax=document.getElementById('job_edumax').value;
	var job_gender=document.getElementById('job_gender').value;
	var hiddenField_id=document.getElementById('hiddenField_id').value;
	
	 value=job_name+'|'+jcs_id+'|'+job_desc+'|'+job_worktype+'|'+cad_id+'|'+job_quantity+'|'+job_salarymin+'|'+job_salarymax+'|'+job_salarycurrency+'|'+job_extraincome+'|'+job_extrawelfare+'|'+job_spec+'|'+job_agemin+'|'+job_agemax+'|'+job_expmin+'|'+job_expmax+'|'+job_edumin+'|'+job_edumax+'|'+job_gender+'|'+hiddenField_id;
	
	sendedit_cpn(label_field,value,lang,tap_result);
	}
</script>
<script language="javascript">
	function EditFrmEdu(numrow,lang){
	
	var level_adu=document.getElementById('level_adu'+numrow).value;
	var edh_faculty=document.getElementById('edh_faculty'+numrow).value;
	var edh_faculty_en=document.getElementById('edh_faculty_en'+numrow).value;
	var edh_institute=document.getElementById('edh_institute'+numrow).value;
	var edh_institute_en=document.getElementById('edh_institute_en'+numrow).value;
	var edh_major=document.getElementById('edh_major'+numrow).value;
	var edh_major_en=document.getElementById('edh_major_en'+numrow).value;
	var yeared=document.getElementById('yeared'+numrow).value;
	var edh_gpa=document.getElementById('edh_gpa'+numrow).value;
	var edh_id=document.getElementById('edh_id'+numrow).value;
	value=level_adu+'|'+edh_faculty+'|'+edh_faculty_en+'|'+edh_institute+'|'+edh_institute_en+'|'+edh_major+'|'+edh_major_en+'|'+yeared+'|'+edh_gpa+'|'+edh_id;
	 //alert(value);
	SendEditEdu('EditEdu',value,'prs_id',lang,'person_education');
	//alert(level_adu+edh_faculty+edh_institute+edh_major+yeared+edh_gpa+edh_id);
	}
	
	function EditFrmEdu_wizards(numrow,lang){
	
	var level_adu=document.getElementById('level_adu'+numrow).value;
	var edh_faculty=document.getElementById('edh_faculty'+numrow).value;
	var edh_faculty_en=document.getElementById('edh_faculty_en'+numrow).value;
	var edh_institute=document.getElementById('edh_institute'+numrow).value;
	var edh_institute_en=document.getElementById('edh_institute_en'+numrow).value;
	var edh_major=document.getElementById('edh_major'+numrow).value;
	var edh_major_en=document.getElementById('edh_major_en'+numrow).value;
	var yeared=document.getElementById('yeared'+numrow).value;
	var edh_gpa=document.getElementById('edh_gpa'+numrow).value;
	var edh_id=document.getElementById('edh_id'+numrow).value;
	value=level_adu+'|'+edh_faculty+'|'+edh_faculty_en+'|'+edh_institute+'|'+edh_institute_en+'|'+edh_major+'|'+edh_major_en+'|'+yeared+'|'+edh_gpa+'|'+edh_id;
	 //alert(value);
	SendEditEdu('EditEdu',value,'prs_id',lang,'person_wizards_education');
	//alert(level_adu+edh_faculty+edh_institute+edh_major+yeared+edh_gpa+edh_id);
	}
	
	function EditFrmEdu_admin(numrow,lang){
	
	var level_adu=document.getElementById('level_adu'+numrow).value;
	var edh_faculty=document.getElementById('edh_faculty'+numrow).value;
	var edh_faculty_en=document.getElementById('edh_faculty_en'+numrow).value;
	var edh_institute=document.getElementById('edh_institute'+numrow).value;
	var edh_institute_en=document.getElementById('edh_institute_en'+numrow).value;
	var edh_major=document.getElementById('edh_major'+numrow).value;
	var edh_major_en=document.getElementById('edh_major_en'+numrow).value;
	var yeared=document.getElementById('yeared'+numrow).value;
	var edh_gpa=document.getElementById('edh_gpa'+numrow).value;
	var edh_id=document.getElementById('edh_id'+numrow).value;
	var prs_id=document.getElementById('prs_id'+numrow).value;
	value=level_adu+'|'+edh_faculty+'|'+edh_faculty_en+'|'+edh_institute+'|'+edh_institute_en+'|'+edh_major+'|'+edh_major_en+'|'+yeared+'|'+edh_gpa+'|'+edh_id;
	 
	SendEditEdu_admin('EditEdu',value,prs_id,lang,'admin_person_education');
	
	}
	
	function EditFrmWork(numrow,lang,calendar_star,calendar_end){
	
	var startdate=document.getElementById('calendar'+calendar_star).value;
	var enddate=document.getElementById('calendar'+calendar_end).value;
	//var startdate=document.getElementById('calendar3').value;
	//var enddate=document.getElementById('calendar4').value;
	var empname=document.getElementById('empname_edit'+numrow).value;
	var empname_en=document.getElementById('empname_edit_en'+numrow).value;
	var empaddress=document.getElementById('empaddress_edit'+numrow).value;
	var empaddress_en=document.getElementById('empaddress_edit_en'+numrow).value;
	var position=document.getElementById('position_edit'+numrow).value;
	var position_en=document.getElementById('position_edit_en'+numrow).value;
	var salary=document.getElementById('salary_edit'+numrow).value;
	var jobdesc=document.getElementById('jobdesc_edit'+numrow).value;
	var jobdesc_en=document.getElementById('jobdesc_edit_en'+numrow).value;
	var wkh_id=document.getElementById('wkh_id'+numrow).value;
	
	value=startdate+'|'+enddate+'|'+empname+'|'+empname_en+'|'+empaddress+'|'+empaddress_en+'|'+position+'|'+position_en+'|'+salary+'|'+jobdesc+'|'+jobdesc_en+'|'+wkh_id;
	
	SendEditEdu('EditWork',value,'prs_id',lang,'person_workhis');
	
	}
	
	function EditFrmWork_wizards(numrow,lang,calendar_star,calendar_end){
	
	var startdate=document.getElementById('calendar'+calendar_star).value;
	var enddate=document.getElementById('calendar'+calendar_end).value;
	//var startdate=document.getElementById('calendar3').value;
	//var enddate=document.getElementById('calendar4').value;
	var empname=document.getElementById('empname_edit'+numrow).value;
	var empname_en=document.getElementById('empname_edit_en'+numrow).value;
	var empaddress=document.getElementById('empaddress_edit'+numrow).value;
	var empaddress_en=document.getElementById('empaddress_edit_en'+numrow).value;
	var position=document.getElementById('position_edit'+numrow).value;
	var position_en=document.getElementById('position_edit_en'+numrow).value;
	var salary=document.getElementById('salary_edit'+numrow).value;
	var jobdesc=document.getElementById('jobdesc_edit'+numrow).value;
	var jobdesc_en=document.getElementById('jobdesc_edit_en'+numrow).value;
	var wkh_id=document.getElementById('wkh_id'+numrow).value;
	
	value=startdate+'|'+enddate+'|'+empname+'|'+empname_en+'|'+empaddress+'|'+empaddress_en+'|'+position+'|'+position_en+'|'+salary+'|'+jobdesc+'|'+jobdesc_en+'|'+wkh_id;
	
	SendEditEdu('EditWork',value,'prs_id',lang,'person_wizards_workhis');
	
	}
	
	function EditFrmWork_admin(numrow,lang,calendar_star,calendar_end){
	
	var startdate=document.getElementById('calendar'+calendar_star).value;
	var enddate=document.getElementById('calendar'+calendar_end).value;
	//var startdate=document.getElementById('calendar3').value;
	//var enddate=document.getElementById('calendar4').value;
	var empname=document.getElementById('empname_edit'+numrow).value;
	var empname_en=document.getElementById('empname_edit_en'+numrow).value;
	var empaddress=document.getElementById('empaddress_edit'+numrow).value;
	var empaddress_en=document.getElementById('empaddress_edit_en'+numrow).value;
	var position=document.getElementById('position_edit'+numrow).value;
	var position_en=document.getElementById('position_edit_en'+numrow).value;
	var salary=document.getElementById('salary_edit'+numrow).value;
	var jobdesc=document.getElementById('jobdesc_edit'+numrow).value;
	var jobdesc_en=document.getElementById('jobdesc_edit_en'+numrow).value;
	var wkh_id=document.getElementById('wkh_id'+numrow).value;
	var prs_id=document.getElementById('prs_id'+numrow).value;
	
	value=startdate+'|'+enddate+'|'+empname+'|'+empname_en+'|'+empaddress+'|'+empaddress_en+'|'+position+'|'+position_en+'|'+salary+'|'+jobdesc+'|'+jobdesc_en+'|'+wkh_id;
	
	SendEditWork_admin('EditWork',value,prs_id,lang,'admin_person_workhis');
	
	}
	
	function EditFrmTrinning(numrow,lang,calendar_star,calendar_end){
	
	var startdate=document.getElementById('calendar'+calendar_star).value;
	var enddate=document.getElementById('calendar'+calendar_end).value;
	var institute=document.getElementById('institute_edit'+numrow).value;
	var institute_edit_en=document.getElementById('institute_edit_en'+numrow).value;
	var course=document.getElementById('course_edit'+numrow).value;
	var course_edit_en=document.getElementById('course_edit_en'+numrow).value;
	var tnh_id=document.getElementById('tnh_id'+numrow).value;
	
	value=startdate+'|'+enddate+'|'+institute+'|'+institute_edit_en+'|'+course+'|'+course_edit_en+'|'+tnh_id;
	 
	SendEditEdu('EditTrining',value,'prs_id',lang,'person_traininghis');
	
	}
	
	function EditFrmTrinning_wizards(numrow,lang,calendar_star,calendar_end){
	
	var startdate=document.getElementById('calendar'+calendar_star).value;
	var enddate=document.getElementById('calendar'+calendar_end).value;
	var institute=document.getElementById('institute_edit'+numrow).value;
	var institute_edit_en=document.getElementById('institute_edit_en'+numrow).value;
	var course=document.getElementById('course_edit'+numrow).value;
	var course_edit_en=document.getElementById('course_edit_en'+numrow).value;
	var tnh_id=document.getElementById('tnh_id'+numrow).value;
	
	value=startdate+'|'+enddate+'|'+institute+'|'+institute_edit_en+'|'+course+'|'+course_edit_en+'|'+tnh_id;
	 
	SendEditEdu('EditTrining',value,'prs_id',lang,'person_wizards_traininghis');
	
	}
	
	function EditFrmTrinning_admin(numrow,lang,calendar_star,calendar_end){
	
	var startdate=document.getElementById('calendar'+calendar_star).value;
	var enddate=document.getElementById('calendar'+calendar_end).value;
	var institute=document.getElementById('institute_edit'+numrow).value;
	var institute_edit_en=document.getElementById('institute_edit_en'+numrow).value;
	var course=document.getElementById('course_edit'+numrow).value;
	var course_edit_en=document.getElementById('course_edit_en'+numrow).value;
	var tnh_id=document.getElementById('tnh_id'+numrow).value;
	var prs_id=document.getElementById('prs_id'+numrow).value;
	
	value=startdate+'|'+enddate+'|'+institute+'|'+institute_edit_en+'|'+course+'|'+course_edit_en+'|'+tnh_id;
	 
	SendEditEdu_admin('EditTrining',value,prs_id,lang,'admin_person_traininghis');
	
	}
</script>
<script language="javascript">
		function ShwRowEdit(numrow){
	var Now=document.company.RowEditNow.value;
	var Old=document.company.RowEditOld.value;
	
			if(Now==''){
			document.getElementById('edu_name'+numrow).style.display='';document.getElementById('lb_edu_name'+numrow).style.display='none';
			document.getElementById('edu_faculty'+numrow).style.display='';document.getElementById('lb_edu_faculty'+numrow).style.display='none';
			document.getElementById('edu_faculty_en'+numrow).style.display='';document.getElementById('lb_edu_faculty_en'+numrow).style.display='none';
			document.getElementById('edu_institute'+numrow).style.display='';document.getElementById('lb_edu_institute'+numrow).style.display='none';
			document.getElementById('edu_institute_en'+numrow).style.display='';document.getElementById('lb_edu_institute_en'+numrow).style.display='none';
			document.getElementById('edu_major'+numrow).style.display='';document.getElementById('lb_edu_major'+numrow).style.display='none';
			document.getElementById('edu_major_en'+numrow).style.display='';document.getElementById('lb_edu_major_en'+numrow).style.display='none';
			document.getElementById('edu_gradyear'+numrow).style.display='';document.getElementById('lb_edu_gradyear'+numrow).style.display='none';
			document.getElementById('edu_gpa'+numrow).style.display='';document.getElementById('lb_edu_gpa'+numrow).style.display='none';
			document.getElementById('btn_save_edit'+numrow).style.display='';
			document.company.RowEditNow.value=numrow;
			document.company.RowEditOld.value=numrow;
			//Old=Now;
			}else{
					if(Now!=numrow){
					document.getElementById('edu_name'+Now).style.display='none';document.getElementById('lb_edu_name'+Now).style.display='';
					document.getElementById('edu_faculty'+Now).style.display='none';document.getElementById('lb_edu_faculty'+Now).style.display='';
					document.getElementById('edu_faculty_en'+Now).style.display='none';document.getElementById('lb_edu_faculty_en'+Now).style.display='';
					document.getElementById('edu_institute'+Now).style.display='none';document.getElementById('lb_edu_institute'+Now).style.display='';
					document.getElementById('edu_institute_en'+Now).style.display='none';document.getElementById('lb_edu_institute_en'+Now).style.display='';
					document.getElementById('edu_major'+Now).style.display='none';document.getElementById('lb_edu_major'+Now).style.display='';
					document.getElementById('edu_major_en'+Now).style.display='none';document.getElementById('lb_edu_major_en'+Now).style.display='';
					document.getElementById('edu_gradyear'+Now).style.display='none';document.getElementById('lb_edu_gradyear'+Now).style.display='';
					document.getElementById('edu_gpa'+Now).style.display='none';document.getElementById('lb_edu_gpa'+Now).style.display='';
					document.getElementById('btn_save_edit'+Now).style.display='none';
					document.company.RowEditOld.value=numrow;
					document.company.RowEditNow.value=numrow;
					}else{
						if(Old==numrow){
								//document.getElementById("person_education").innerHTML=numrow+Now+Old; 
								document.getElementById('edu_name'+numrow).style.display='';document.getElementById('lb_edu_name'+numrow).style.display='none';
								document.getElementById('edu_faculty'+numrow).style.display='';document.getElementById('lb_edu_faculty'+numrow).style.display='none';
								document.getElementById('edu_faculty_en'+numrow).style.display='';document.getElementById('lb_edu_faculty_en'+numrow).style.display='none';
								document.getElementById('edu_institute'+numrow).style.display='';document.getElementById('lb_edu_institute'+numrow).style.display='none';
								document.getElementById('edu_institute_en'+numrow).style.display='';document.getElementById('lb_edu_institute_en'+numrow).style.display='none';
								document.getElementById('edu_major'+numrow).style.display='';document.getElementById('lb_edu_major'+numrow).style.display='none';
								document.getElementById('edu_major_en'+numrow).style.display='';document.getElementById('lb_edu_major_en'+numrow).style.display='none';
								document.getElementById('edu_gradyear'+numrow).style.display='';document.getElementById('lb_edu_gradyear'+numrow).style.display='none';
								document.getElementById('edu_gpa'+numrow).style.display='';document.getElementById('lb_edu_gpa'+numrow).style.display='none';
								document.getElementById('btn_save_edit'+numrow).style.display='';
						}
					
					}
				
			}
	 
	}
</script>
<script language="javascript">
	function ShwRowEditWork(numrow){
		var Now=document.company.RowEditNowWhk.value;
		var Old=document.company.RowEditOldWhk.value;
		if(Now==''){
			//alert('Now = null');
			document.getElementById('startdate'+numrow).style.display='';document.getElementById('lb_startdate'+numrow).style.display='none';
			document.getElementById('enddate'+numrow).style.display='';document.getElementById('lb_enddate'+numrow).style.display='none';
			document.getElementById('empname'+numrow).style.display='';document.getElementById('lb_empname'+numrow).style.display='none';
			document.getElementById('empname_en'+numrow).style.display='';document.getElementById('lb_empname_en'+numrow).style.display='none';
			document.getElementById('empaddress'+numrow).style.display='';document.getElementById('lb_empaddress'+numrow).style.display='none';
			document.getElementById('empaddress_en'+numrow).style.display='';document.getElementById('lb_empaddress_en'+numrow).style.display='none';
			document.getElementById('position'+numrow).style.display='';document.getElementById('lb_position'+numrow).style.display='none';
			document.getElementById('position_en'+numrow).style.display='';document.getElementById('lb_position_en'+numrow).style.display='none';
			document.getElementById('salary'+numrow).style.display='';document.getElementById('lb_salary'+numrow).style.display='none';
			document.getElementById('jobdesc'+numrow).style.display='';document.getElementById('lb_jobdesc'+numrow).style.display='none';
			document.getElementById('jobdesc_en'+numrow).style.display='';document.getElementById('lb_jobdesc_en'+numrow).style.display='none';
			document.getElementById('save_edit'+numrow).style.display='';
			document.company.RowEditNowWhk.value=numrow;
			document.company.RowEditOldWhk.value=numrow;
			//Old=Now;
			}else{
					if(Now!=numrow){
					//alert('Now is not null and Now <> row');
					//document.getElementById('person_workhis').innerHTML="Now is not null and Now <> row"; //
					document.getElementById('startdate'+Now).style.display='none';document.getElementById('lb_startdate'+Now).style.display='';
					document.getElementById('enddate'+Now).style.display='none';document.getElementById('lb_enddate'+Now).style.display='';
					document.getElementById('empname'+Now).style.display='none';document.getElementById('lb_empname'+Now).style.display='';
					document.getElementById('empname_en'+Now).style.display='none';document.getElementById('lb_empname_en'+Now).style.display='';
					document.getElementById('empaddress'+Now).style.display='none';document.getElementById('lb_empaddress'+Now).style.display='';
					document.getElementById('empaddress_en'+Now).style.display='none';document.getElementById('lb_empaddress_en'+Now).style.display='';
					document.getElementById('position'+Now).style.display='none';document.getElementById('lb_position'+Now).style.display='';
					document.getElementById('position_en'+Now).style.display='none';document.getElementById('lb_position_en'+Now).style.display='';
					document.getElementById('salary'+Now).style.display='none';document.getElementById('lb_salary'+Now).style.display='';
					document.getElementById('jobdesc'+Now).style.display='none';document.getElementById('lb_jobdesc'+Now).style.display='';
					document.getElementById('jobdesc_en'+Now).style.display='none';document.getElementById('lb_jobdesc_en'+Now).style.display='';
					document.getElementById('save_edit'+Now).style.display='none';
				
					document.company.RowEditOldWhk.value=numrow;
					document.company.RowEditNowWhk.value=numrow;
					}else{
						if(Old==numrow){
								//document.getElementById("person_education").innerHTML=numrow+Now+Old; 
								document.getElementById('startdate'+numrow).style.display='';document.getElementById('lb_startdate'+numrow).style.display='none';
								document.getElementById('enddate'+numrow).style.display='';document.getElementById('lb_enddate'+numrow).style.display='none';
								document.getElementById('empname'+numrow).style.display='';document.getElementById('lb_empname'+numrow).style.display='none';
								document.getElementById('empname_en'+numrow).style.display='';document.getElementById('lb_empname_en'+numrow).style.display='none';
								document.getElementById('empaddress'+numrow).style.display='';document.getElementById('lb_empaddress'+numrow).style.display='none';
								document.getElementById('empaddress_en'+numrow).style.display='';document.getElementById('lb_empaddress_en'+numrow).style.display='none';
								document.getElementById('position'+numrow).style.display='';document.getElementById('lb_position'+numrow).style.display='none';
								document.getElementById('position_en'+numrow).style.display='';document.getElementById('lb_position_en'+numrow).style.display='none';
								document.getElementById('salary'+numrow).style.display='';document.getElementById('lb_salary'+numrow).style.display='none';
								document.getElementById('jobdesc'+numrow).style.display='';document.getElementById('lb_jobdesc'+numrow).style.display='none';
								document.getElementById('jobdesc_en'+numrow).style.display='';document.getElementById('lb_jobdesc_en'+numrow).style.display='none';
								document.getElementById('save_edit'+numrow).style.display='';
						}
					
					
					}
				
			}
	}
</script>
<script language="javascript">
function ShwRowEditTraining(numrow){
		var Now=document.company.RowEditNowTrn.value;
		var Old=document.company.RowEditOldTrn.value;
		if(Now==''){
			//alert('Now = null');
			document.getElementById('startdate'+numrow).style.display='';document.getElementById('lb_startdate'+numrow).style.display='none';
			document.getElementById('enddate'+numrow).style.display='';document.getElementById('lb_enddate'+numrow).style.display='none';
			document.getElementById('institute'+numrow).style.display='';document.getElementById('lb_institute'+numrow).style.display='none';
			document.getElementById('course'+numrow).style.display='';document.getElementById('lb_course'+numrow).style.display='none';
			document.getElementById('save_edit'+numrow).style.display='';
			document.company.RowEditNowTrn.value=numrow;
			document.company.RowEditOldTrn.value=numrow;
			//Old=Now;
			}else{
					if(Now!=numrow){
					//alert('Now is not null and Now <> row');
					//document.getElementById('person_workhis').innerHTML="Now is not null and Now <> row"; //
					document.getElementById('startdate'+Now).style.display='none';document.getElementById('lb_startdate'+Now).style.display='';
					document.getElementById('enddate'+Now).style.display='none';document.getElementById('lb_enddate'+Now).style.display='';
					document.getElementById('institute'+Now).style.display='none';document.getElementById('lb_institute'+Now).style.display='';
					document.getElementById('course'+Now).style.display='none';document.getElementById('lb_course'+Now).style.display='';
					document.getElementById('save_edit'+Now).style.display='none';
				
					document.company.RowEditOldTrn.value=numrow;
					document.company.RowEditNowTrn.value=numrow;
					}else{
						if(Old==numrow){
								//document.getElementById("person_education").innerHTML=numrow+Now+Old; 
								document.getElementById('startdate'+numrow).style.display='';document.getElementById('lb_startdate'+numrow).style.display='none';
								document.getElementById('enddate'+numrow).style.display='';document.getElementById('lb_enddate'+numrow).style.display='none';
								document.getElementById('institute'+numrow).style.display='';document.getElementById('lb_institute'+numrow).style.display='none';
								document.getElementById('course'+numrow).style.display='';document.getElementById('lb_course'+numrow).style.display='none';
								document.getElementById('save_edit'+numrow).style.display='';
						}
					}
				
			}
	}
</script>
<script language="javascript">

	function open_close_job(field,value,job_id,lang,id_field_label){
	
				function Inint_AJAX() {
  												 try { return new ActiveXObject("Msxml2.XMLHTTP"); } catch(e) {} //IE
   												 try { return new ActiveXObject("Microsoft.XMLHTTP"); } catch(e) {} //IE
   												 try { return new XMLHttpRequest(); } catch(e) {} //Native Javascript
   												 alert("XMLHttpRequest not supported")
   												 return null
											}
											var req = Inint_AJAX(); // Object
											
     											req.open('GET', 'company_action.php?value='+encodeURIComponent(value+'|'+id_field_label)+'&field='+encodeURIComponent(field)+'&lang='+encodeURIComponent(lang)+'&job_id='+encodeURIComponent(job_id), true); //
     											req.onreadystatechange = function() { //
          										if (req.readyState==4) {
               										if (req.status==200) { //
                    							var data=req.responseText; //
											    //window.location=window.location;
	                   							document.getElementById(id_field_label).innerHTML=""+data; //
               										}
          										}
     										};
     										req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // 
     										req.send(null); //
	}
	function open_close_job_admin_extra(field,value,job_id,lang,id_field_label){
	
				function Inint_AJAX() {
  												 try { return new ActiveXObject("Msxml2.XMLHTTP"); } catch(e) {} //IE
   												 try { return new ActiveXObject("Microsoft.XMLHTTP"); } catch(e) {} //IE
   												 try { return new XMLHttpRequest(); } catch(e) {} //Native Javascript
   												 alert("XMLHttpRequest not supported")
   												 return null
											}
											var req = Inint_AJAX(); // Object
											
     											req.open('GET', 'company_action.php?value='+encodeURIComponent(value+'|'+id_field_label)+'&field='+encodeURIComponent(field)+'&lang='+encodeURIComponent(lang)+'&job_id='+encodeURIComponent(job_id), true); //
     											req.onreadystatechange = function() { //
          										if (req.readyState==4) {
               										if (req.status==200) { //
                    							var data=req.responseText; //
											    //window.location=window.location;
	                   							document.getElementById(id_field_label).innerHTML=""+data; //
               										}
          										}
     										};
     										req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // 
     										req.send(null); //
	}
</script>
<script language="javascript">
	function chksearch(data){
		
		if(data=='Local'){
			document.getElementById('Province').style.display='';
			document.getElementById('Country').style.display='none';
			document.getElementById('TypePlace').style.display='none';
			document.getElementById('select_area1').style.display='none';
			
			}
		if(data=='Foreign'){
			
			document.getElementById('Country').style.display='';
			document.getElementById('Province').style.display='none';
			document.getElementById('TypePlace').style.display='none';
			document.getElementById('select_area1').style.display='none';
			
			}
	
	}
	function chksearch_resume(data){
		
		if(data=='Local'){
			document.getElementById('Province').style.display='';
			document.getElementById('Country').style.display='none';
			//document.getElementById('TypePlace').style.display='none';
			document.getElementById('select_area1').style.display='none';
			
			}
		if(data=='Foreign'){
			
			document.getElementById('Country').style.display='';
			document.getElementById('Province').style.display='none';
			//document.getElementById('TypePlace').style.display='none';
			document.getElementById('select_area1').style.display='none';
			
			}
	
	}
</script>
<script language="javascript">
	function display_fromsearch(typefrom,lang){
	
		if(typefrom=='person'){document.getElementById('from_person').style.display='';document.getElementById('from_company').style.display='none';}
		if(typefrom=='company'){document.getElementById('from_person').style.display='none';document.getElementById('from_company').style.display='';}
	
	}
</script>
<script language="javascript">
	function send_resume_accept(field,value,id_prs,lang,id_field_label){	
		function Inint_AJAX() {
  												 try { return new ActiveXObject("Msxml2.XMLHTTP"); } catch(e) {} //IE
   												 try { return new ActiveXObject("Microsoft.XMLHTTP"); } catch(e) {} //IE
   												 try { return new XMLHttpRequest(); } catch(e) {} //Native Javascript
   												 alert("XMLHttpRequest not supported")
   												 return null
											}
											var req = Inint_AJAX(); // Object send_resume_accept('accept_resume','$prs_id','$prs_id','$lang','admin_resume_person');
											
     											req.open('GET', 'admin_action.php?value='+encodeURIComponent(value)+'&field='+encodeURIComponent(field)+'&lang='+encodeURIComponent(lang)+'&id_prs='+encodeURIComponent(id_prs), true); //
     											req.onreadystatechange = function() { //
          										if (req.readyState==4) {
               										if (req.status==200) { //
                    							var data=req.responseText; //
											    window.location=window.location;
	                   							//document.getElementById(id_field_label).innerHTML=""+data; //		
               										}
          										}
     										};
     										req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // 
     										req.send(null); //
	}
</script>
<!-- popup ReturnOperner-->
<script type="text/javascript">
function ReturnOperner (lang,type,value) {
//alert ("Hello from parent!");
window.location=value;
}
function popup(url,name,windowWidth,windowHeight){  

    
    myleft=(screen.width)?(screen.width-windowWidth)/2:100;   
    mytop=(screen.height)?(screen.height-windowHeight)/2:100;     
    properties = "width="+windowWidth+",height="+windowHeight;  
    properties +=",scrollbars=yes, top="+mytop+",left="+myleft;     
    window.open(url,name,properties);  
}  
</script>
<!--END popup ReturnOperner-->

<!-- Admin Start-->
	<script language="javascript">
		function open_close(field,value,lang,id_field_label){
			function Inint_AJAX() {
  												 try { return new ActiveXObject("Msxml2.XMLHTTP"); } catch(e) {} //IE
   												 try { return new ActiveXObject("Microsoft.XMLHTTP"); } catch(e) {} //IE
   												 try { return new XMLHttpRequest(); } catch(e) {} //Native Javascript
   												 alert("XMLHttpRequest not supported")
   												 return null
											}
											var req = Inint_AJAX(); // Object 
											
     											req.open('GET', 'admin_action.php?value='+encodeURIComponent(value)+'&field='+encodeURIComponent(field)+'&lang='+encodeURIComponent(lang)+'&id_field_label='+encodeURIComponent(id_field_label), true); //
     											req.onreadystatechange = function() { //
          										if (req.readyState==4) {
               										if (req.status==200) { //
                    							var data=req.responseText; //
											    window.location=window.location;
	                   							document.getElementById(id_field_label).innerHTML=""+data; //		
               										}
          										}
     										};
     										req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // 
     										req.send(null); //
		}
	
	</script>
    <script language="javascript">
function pac_send(value,sendto,lang){
						function Inint_AJAX() {
  												 try { return new ActiveXObject("Msxml2.XMLHTTP"); } catch(e) {} //IE
   												 try { return new ActiveXObject("Microsoft.XMLHTTP"); } catch(e) {} //IE
   												 try { return new XMLHttpRequest(); } catch(e) {} //Native Javascript
   												 alert("XMLHttpRequest not supported")
   												 return null
											}
											var req = Inint_AJAX(); //
     											req.open('GET', 'admin_action.php?value='+encodeURIComponent(value)+'&sendto='+encodeURIComponent(sendto)+'&lang='+encodeURIComponent(lang), true); //
     											req.onreadystatechange = function() { //
          										if (req.readyState==4) {
               										if (req.status==200) { //
                    							var data=req.responseText; //
												
                    							document.getElementById("pac_send").innerHTML=""+data; //
												
												window.location=window.location;
               										}
          										}
     										};
     										req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); //H
     										req.send(null); //
		};
//end pac_send===========================================================================
			
</script>
<!-- Admin End-->
<script language="javascript">
function resumewizards(dataalert){
	
	
		if(dataalert==1){
		
			var value='';
	var name=document.getElementById('name').value;
	var name_en=document.getElementById('name_en').value;
	var nlt_name=document.getElementById('nlt_name').value;
	var idennumber=document.getElementById('idennumber').value;
	var hidden_birthdate=document.getElementById('calendar').value;
	var hidden_sex=document.getElementById('hidden_sex').value;
	var maritalstatus=document.getElementById('maritalstatus').value;
	var height=document.getElementById('height').value; 
	var weight=document.getElementById('weight').value; 
	var religion=document.getElementById('religion').value; 
	var address=document.getElementById('address').value; 
	var address_en=document.getElementById('address_en').value; 
	var cad_country=document.getElementById('cad_country').value;
	var province_name=document.getElementById('province_name').value;
	var district_name=document.getElementById('district_name').value;
	var portal=document.getElementById('portal').value;
	var tel=document.getElementById('tel').value;
	var mobile=document.getElementById('mobile').value;
	var militarystatus=document.getElementById('militarystatus').value;
	var email=document.getElementById('email').value;
	var picfield=document.getElementById('picfield').value;
	var hinden_picfield=document.getElementById('hinden_picfield').value;
	
	 value=name+'|'+name_en+'|'+nlt_name+'|'+idennumber+'|'+hidden_birthdate+'|'+hidden_sex+'|'+maritalstatus+'|'+height+'|'+weight+'|'+religion+'|'+address+'|'+address_en+'|'+cad_country+'|'+province_name+'|'+district_name+'|'+portal+'|'+tel+'|'+mobile+'|'+militarystatus+'|'+email+'|'+picfield+'|'+hinden_picfield;
	var send_value=value;
	window.top.window.wizards_get(dataalert,'',send_value);
	
		}// ch 1
	if(dataalert==2){
	value=document.company.hdd_bcg.value;
	var send_value=value;
	window.top.window.wizards_get(dataalert,'',send_value);
		}// ch 2
	if(dataalert==3){
	value=document.company.hdd_bcj.value+'|'+'add'+'|'+document.company.position_lc.value+'|'+document.company.position_en.value;
	var send_value=value;
	window.top.window.wizards_get(dataalert,'',send_value);
		}// ch 3
	if(dataalert==4){
		
		var frm=document.company;
		var gpa=document.company.gpa;
		var gradyear=document.company.gradyear;
		var major=document.company.major;
		var major_en=document.company.major_en;
		var institute=document.company.institute;
		var institute_en=document.company.institute_en;
		var faculty=document.company.faculty;
		var faculty_en=document.company.faculty_en;
		var hdd_eduhis=document.company.hdd_eduhis;
	
		var value=hdd_eduhis.value+'|'+faculty.value+'|'+faculty_en.value+'|'+institute.value+'|'+institute_en.value+'|'+major.value+'|'+major_en.value+'|'+gradyear.value+'|'+gpa.value;
		var send_value=value;
	window.top.window.wizards_get(dataalert,'',send_value);		
	
		}// ch 4
	if(dataalert==5){
	var frm=document.company;
		var hidden_startdate=document.company.calendar;
		var hidden_enddate=document.company.calendar2;
		var empname=document.company.empname;
		var empname_en=document.company.empname_en;
		var empaddress=document.company.empaddress;
		var empaddress_en=document.company.empaddress_en;
		var position=document.company.position;
		var position_en=document.company.position_en;
		var salary=document.company.salary;
		//var salarycurrency=document.company.salarycurrency;
		var jobdesc=document.company.jobdesc;
		var jobdesc_en=document.company.jobdesc_en;
		var prs_id=document.company.prs_id;
		var value=hidden_startdate.value+'|'+hidden_enddate.value+'|'+empname.value+'|'+empname_en.value+'|'+empaddress.value+'|'+empaddress_en.value+'|'+position.value+'|'+position_en.value+'|THB|'+salary.value+'|'+jobdesc.value+'|'+jobdesc_en.value;			
	var send_value=value;
	window.top.window.wizards_get(dataalert,'',send_value);
		}// ch 5
	if(dataalert==6){
	var frm=document.company;
		var institute=document.company.institute;
		var institute_en=document.company.institute_en;
		var course=document.company.course;
		var course_en=document.company.course_en;
		var hidden_enddate=document.company.calendar2;
		var hidden_startdate=document.company.calendar;
		var prs_id=document.company.prs_id;
		var value=hidden_startdate.value+'|'+hidden_enddate.value+'|'+institute.value+'|'+institute_en.value+'|'+course.value+'|'+course_en.value;
					
	var send_value=value;
	window.top.window.wizards_get(dataalert,'',send_value);
		}// ch 6
	
	
	//7
	if(dataalert==7){
	var frm=document.company;
		
		var editlisten_th=document.company.editlisten_th.value;
		var editspeak_th=document.company.editspeak_th.value;
		var editread_th=document.company.editread_th.value;
		var editwrit_th=document.company.editwrit_th.value;
		var lang_th=document.company.lang_th.value;
		var lang_th_id=document.company.lang_th_id.value;
		var value_th=editlisten_th+'|'+editspeak_th+'|'+editread_th+'|'+editwrit_th+'|'+lang_th+'|'+lang_th_id;
		//end th
		var editlisten_en=document.company.editlisten_en.value;
		var editspeak_en=document.company.editspeak_en.value;
		var editread_en=document.company.editread_en.value;
		var editwrit_en=document.company.editwrit_en.value;
		var lang_eng=document.company.lang_eng.value;
		var lang_en_id=document.company.lang_en_id.value;
		var value_en=editlisten_en+'|'+editspeak_en+'|'+editread_en+'|'+editwrit_en+'|'+lang_eng+'|'+lang_en_id;
		//end en
	    var opt_listen_oth1_1=document.company.opt_listen_oth1_1.value;
		var editspeak_oth1=document.company.editspeak_oth1.value;
		var editread_oth1=document.company.editread_oth1.value;
		var editwrit_oth1=document.company.editwrit_oth1.value;
		var opt_lang_oth1=document.company.opt_lang_oth1.value;
		var lang_oth1_id=document.company.lang_oth1_id.value;
		var value_oth1=opt_listen_oth1_1+'|'+editspeak_oth1+'|'+editread_oth1+'|'+editwrit_oth1+'|'+opt_lang_oth1+'|'+lang_oth1_id;
		//end oth1
	    var editlisten_oth2=document.company.editlisten_oth2.value;
		var editspeak_oth2=document.company.editspeak_oth2.value;
		var editread_oth2=document.company.editread_oth2.value;
		var editwrit_oth2=document.company.editwrit_oth2.value;
		var opt_lang_oth2=document.company.opt_lang_oth2.value;
		var lang_oth2_id=document.company.lang_oth2_id.value;
		var value_oth2=editlisten_oth2+'|'+editspeak_oth2+'|'+editread_oth2+'|'+editwrit_oth2+'|'+opt_lang_oth2+'|'+lang_oth2_id;
		//oth2
	  
	
	   var typing_thai=document.company.typing_thai.value;
	   var typing_eng=document.company.typing_eng.value;
	   var value_typing=typing_thai+'|'+typing_eng;
	   
	  if(document.getElementById("driving_car").checked==true){var driving_car=document.company.driving_car.value;}else{var driving_car='';}
	  if(document.getElementById("driving_motorcycle").checked==true){var driving_motorcycle=document.company.driving_motorcycle.value;}else{var driving_motorcycle='';}
	  if(document.getElementById("driving_truck").checked==true){var driving_truck=document.company.driving_truck.value;}else{var driving_truck='';}
	  if(document.getElementById("driving_oth").checked==true){var driving_oth=document.company.driving_oth.value;}else{ var driving_oth='';}
	  var value_driving=driving_car+'|'+driving_motorcycle+'|'+driving_truck+'|'+driving_oth;
	  
	  if(document.getElementById("owncar").checked==true){var owncar=document.company.owncar.value;}else{ var owncar='';}
	  if(document.getElementById("own_motorcycle").checked==true){var own_motorcycle=document.company.own_motorcycle.value;}else{ var own_motorcycle='';}
	  if(document.getElementById("own_truck").checked==true){var own_truck=document.company.own_truck.value;}else{ var own_truck='';}
	  if(document.getElementById("own_oth").checked==true){var own_oth=document.company.own_oth.value;}else{ var own_oth='';}
	  var value_own=owncar+'|'+own_motorcycle+'|'+own_truck+'|'+own_oth;
	  
	  if(document.getElementById("licence_car").checked==true){var licence_car=document.company.licence_car.value;}else{ var licence_car='';}
	  if(document.getElementById("licence_motorcycle").checked==true){var licence_motorcycle=document.company.licence_motorcycle.value;}else{ var licence_motorcycle=''; }
	  if(document.getElementById("licence_truck").checked==true){var licence_truck=document.company.licence_truck.value;}else{var licence_truck='';}
	  if(document.getElementById("licence_oth").checked==true){var licence_oth=document.company.licence_oth.value;}else{var licence_oth='';}
	  var value_licence=licence_car+'|'+licence_motorcycle+'|'+licence_truck+'|'+licence_oth;
	  
	  var computer=document.company.computer.value;
	  var oth_skill=document.company.oth_skill.value;
	  var refperson=document.company.refperson.value;
	  var prs_id=document.company.prs_id.value;
	  var value_prs=computer+'|'+oth_skill+'|'+refperson+'|'+prs_id;
		//var prs_id=document.company.prs_id;
		//var value=editlisten_th+'|'+editspeak_th+'|'+editread_th+'|'+editwrit_th+'|'+lang_th+'|'+lang_th_id;
					
	var send_value=value_th+'|'+value_en+'|'+value_oth1+'|'+value_oth2+'|'+value_typing+'|'+value_driving+'|'+value_own+'|'+value_licence+'|'+value_prs;
	window.top.window.wizards_get(dataalert,'',send_value);
		}// ch 7
	//7
	
	if(dataalert==8){

	  var salary_min=document.company.salary_min.value;
	  var salary_max=document.company.salary_max.value;
	  var worktype=document.company.worktype.value;
	  var value=worktype+'|'+salary_min+'|'+salary_max;
	  var send_value=value;
	window.top.window.wizards_get(dataalert,'',send_value);
		}// ch 8
	if(dataalert==9){
			
			if(document.company.workarea.value=='1'){
			var value=document.company.cad_countrty.value+'|'+document.company.workarea.value;
			var send_value=value;
			}
			if(document.company.workarea.value=='2'){
			var send_value=document.company.cad_province.value+'|'+document.company.workarea.value;
			}
			if(document.company.workarea.value=='3'){
			var send_value=document.company.cad_multiprovince.value+'|'+document.company.workarea.value;
			}
			if(document.company.workarea.value=='4'){
			var send_value=document.company.AnyWhere.value+'|'+document.company.workarea.value;
			}
			 
			 
			window.top.window.wizards_get(dataalert,'',send_value);
		}// ch 9
	}
	
	function wizards_get(dataalert,listmenu,send_value){
		//alert(send_value);
	document.getElementById('wizardstapmenu').value=dataalert;
	document.getElementById('wizardslist').value=listmenu;
	document.getElementById('wizardsvalue').value=send_value;
	//var sendvalue=document.getElementById('wizardsvalue').value;
	if(document.getElementById('wizardstapmenu').value==1){
	if(document.getElementById('wizardstapmenu').value!='' && document.getElementById('wizardslist').value!=''){
		if(confirm('ต้องการบันทึกข้อมูล หรือไม่')){alert('บันทึกเรียบร้อย');
		//alert(document.getElementById('wizardsvalue').value);
		document.getElementById('wizardstapmenu').value='';
		document.getElementById('wizardslist').value='';
		sendedit_wizards_save('formhistory',document.getElementById('wizardsvalue').value,'<?=$_SESSION['person_id'];?>','<?=$_GET['lang'];?>','');
		
		document.getElementById('wizardsvalue').value='';
		
			}else{alert('ไม่มีการบันทึก');
		document.getElementById('wizardstapmenu').value='';
		document.getElementById('wizardslist').value='';
		document.getElementById('wizardsvalue').value='';
			}
		}
	 }//ch 1
	 if(document.getElementById('wizardstapmenu').value==2){
	 if(document.getElementById('wizardstapmenu').value!='' && document.getElementById('wizardslist').value!=''){
		if(confirm('ต้องการบันทึกข้อมูล หรือไม่')){alert('บันทึกเรียบร้อย');
		//alert(document.getElementById('wizardsvalue').value);
		document.getElementById('wizardstapmenu').value='';
		document.getElementById('wizardslist').value='';
		sendedit_wizards('businessclass',document.getElementById('wizardsvalue').value+'|'+'add','','<?=$_GET['lang'];?>','');
		
		document.getElementById('wizardsvalue').value='';
		
			}else{alert('ไม่มีการบันทึก');
		document.getElementById('wizardstapmenu').value='';
		document.getElementById('wizardslist').value='';
		document.getElementById('wizardsvalue').value='';
			}
		}
	 }//ch 2
	  if(document.getElementById('wizardstapmenu').value==3){
	  if(document.getElementById('wizardstapmenu').value!='' && document.getElementById('wizardslist').value!=''){
		if(confirm('ต้องการบันทึกข้อมูล หรือไม่')){alert('บันทึกเรียบร้อย');
		//alert(document.getElementById('wizardsvalue').value);
		document.getElementById('wizardstapmenu').value='';
		document.getElementById('wizardslist').value='';
		sendedit_wizards('jobclassgroup',document.getElementById('wizardsvalue').value,'','<?=$_GET['lang'];?>','');
		
		document.getElementById('wizardsvalue').value='';
		
			}else{alert('ไม่มีการบันทึก');
		document.getElementById('wizardstapmenu').value='';
		document.getElementById('wizardslist').value='';
		document.getElementById('wizardsvalue').value='';
			}
		}
	 }//ch 3
	 if(document.getElementById('wizardstapmenu').value==4){
	  if(document.getElementById('wizardstapmenu').value!='' && document.getElementById('wizardslist').value!=''){
		if(confirm('ต้องการบันทึกข้อมูล หรือไม่')){alert('บันทึกเรียบร้อย');
		//alert(document.getElementById('wizardsvalue').value);
		document.getElementById('wizardstapmenu').value='';
		document.getElementById('wizardslist').value='';
		sendedit_wizards('AddRecord',document.getElementById('wizardsvalue').value,'','<?=$_GET['lang'];?>','');
		
		document.getElementById('wizardsvalue').value='';
		
			}else{alert('ไม่มีการบันทึก');
		document.getElementById('wizardstapmenu').value='';
		document.getElementById('wizardslist').value='';
		document.getElementById('wizardsvalue').value='';
			}
		}
	 }//ch 4
	  if(document.getElementById('wizardstapmenu').value==5){
	  if(document.getElementById('wizardstapmenu').value!='' && document.getElementById('wizardslist').value!=''){
		if(confirm('ต้องการบันทึกข้อมูล หรือไม่')){alert('บันทึกเรียบร้อย');
		//alert(document.getElementById('wizardsvalue').value);
		document.getElementById('wizardstapmenu').value='';
		document.getElementById('wizardslist').value='';
		
		SendEditWorkHis('AddRecordWorkhis',document.getElementById('wizardsvalue').value,'<?=$_SESSION['person_id'];?>','<?=$_GET['lang'];?>','');
		
		document.getElementById('wizardsvalue').value='';
		
			}else{alert('ไม่มีการบันทึก');
		document.getElementById('wizardstapmenu').value='';
		document.getElementById('wizardslist').value='';
		document.getElementById('wizardsvalue').value='';
			}
		}
	 }//ch 5
	  if(document.getElementById('wizardstapmenu').value==6){
	  if(document.getElementById('wizardstapmenu').value!='' && document.getElementById('wizardslist').value!=''){
		if(confirm('ต้องการบันทึกข้อมูล หรือไม่')){alert('บันทึกเรียบร้อย');
		//alert(document.getElementById('wizardsvalue').value);
		document.getElementById('wizardstapmenu').value='';
		document.getElementById('wizardslist').value='';
		
		sendedit_wizards('AddRecordTrainingHis',document.getElementById('wizardsvalue').value,'<?=$_SESSION['person_id'];?>','<?=$_GET['lang'];?>','');
		
		document.getElementById('wizardsvalue').value='';
		
			}else{alert('ไม่มีการบันทึก');
		document.getElementById('wizardstapmenu').value='';
		document.getElementById('wizardslist').value='';
		document.getElementById('wizardsvalue').value='';
			}
		}
	 }//ch 6
	 //7
	  if(document.getElementById('wizardstapmenu').value==7){
	  if(document.getElementById('wizardstapmenu').value!='' && document.getElementById('wizardslist').value!=''){
		if(confirm('ต้องการบันทึกข้อมูล หรือไม่')){//alert('บันทึกเรียบร้อย');
		//alert(document.getElementById('wizardsvalue').value);
		document.getElementById('wizardstapmenu').value='';
		document.getElementById('wizardslist').value='';
		
		sendedit_wizards('langskill_wizards',document.getElementById('wizardsvalue').value,'<?=$_SESSION['person_id'];?>','<?=$_GET['lang'];?>','wizards_lang');
		
		document.getElementById('wizardsvalue').value='';
		
			}else{alert('ไม่มีการบันทึก');
		document.getElementById('wizardstapmenu').value='';
		document.getElementById('wizardslist').value='';
		document.getElementById('wizardsvalue').value='';
			}
		}
	 }//ch 7
	 //7
	if(document.getElementById('wizardstapmenu').value==8){
	  if(document.getElementById('wizardstapmenu').value!='' && document.getElementById('wizardslist').value!=''){
		if(confirm('ต้องการบันทึกข้อมูล หรือไม่')){alert('บันทึกเรียบร้อย');
		//alert(document.getElementById('wizardsvalue').value);
		document.getElementById('wizardstapmenu').value='';
		document.getElementById('wizardslist').value='';
		
		sendedit_wizards('work_type_salary',document.getElementById('wizardsvalue').value,'<?=$_SESSION['person_id'];?>','<?=$_GET['lang'];?>','');
		//sendedit('work_type_salary',value,'<?=$user_id;?>',lang,'person_wizards_work_type_salary');
		
		document.getElementById('wizardsvalue').value='';
		
			}else{alert('ไม่มีการบันทึก');
		document.getElementById('wizardstapmenu').value='';
		document.getElementById('wizardslist').value='';
		document.getElementById('wizardsvalue').value='';
			}
		}
	 }//ch 8 
	 if(document.getElementById('wizardstapmenu').value==9){
		 //alert(send_value);
		 var in_value=send_value.split("|");
		 var in_value1 = in_value[0];
		 if(document.getElementById('wizardsvalue2').value != in_value[1]){
			 
			 document.getElementById('wizardsvalue1').value='';
			 document.getElementById('wizardsvalue1').value=document.getElementById('wizardsvalue1').value+in_value[0]+',';
			
			 }else{
				 if(in_value[0]!=''){
			 document.getElementById('wizardsvalue1').value=document.getElementById('wizardsvalue1').value+in_value[0]+','; 
				 }
			}
		 document.getElementById('wizardsvalue2').value = in_value[1];
		 
	  if(document.getElementById('wizardstapmenu').value!='' && document.getElementById('wizardslist').value!=''){
		if(confirm('ต้องการบันทึกข้อมูล หรือไม่')){alert('บันทึกเรียบร้อย');
		//alert(document.getElementById('wizardsvalue').value);
		document.getElementById('wizardstapmenu').value='';
		document.getElementById('wizardslist').value='';
		
	sendedit_wizards('multicountry_wizards',document.getElementById('wizardsvalue1').value+'|'+ document.getElementById('wizardsvalue2').value,'<?=$_SESSION['person_id'];?>','<?=$_GET['lang'];?>','');
		
		document.getElementById('wizardsvalue').value='';
		
			}else{alert('ไม่มีการบันทึก');
		document.getElementById('wizardstapmenu').value='';
		document.getElementById('wizardslist').value='';
		document.getElementById('wizardsvalue').value='';
			}
		}
	 }//ch 9
	 
	//SendEditTrainingHis('AddRecordTrainingHis',value,prs_id.value,lang,'person_wizards_traininghis');
	}
//=============
	function companywizards(dataalert){
		//alert(dataalert)
		if(dataalert=='1'){
		//alert(dataalert)
			var value='';
	var name=document.getElementById('name_lc').value;
	var name_en=document.getElementById('name_en').value;
	/*var name_nlt=document.getElementById('name_nlt').value;
	var contactname_lc=document.getElementById('contactname_lc').value;
	var contactemail=document.getElementById('contactemail').value;
	var contactname_en=document.getElementById('contactname_en').value;
	var website=document.getElementById('website').value;
	var desc=document.getElementById('desc').value; 
	var welfare=document.getElementById('welfare').value; 
	var taxaddress=document.getElementById('taxaddress').value; 
	var picfield=document.getElementById('picfield').value; 
	var hinden_picfield=document.getElementById('hinden_picfield').value; 
	var path_pic=document.getElementById('path_pic').value;*/
	//var logo=document.getElementById('logo').value;
	//var lang=document.getElementById('lang').value;
	//var type=document.getElementById('type').value;
	
	
	 value=name+'|'+name_en;
	 var send_value=value;
	//document.getElementById('Cwizardsvalue').value=send_value;
	//document.FrmCwizards.Cwizardsvalue.value=send_value;
	wizards_get2(dataalert,'',send_value);
	//alert(send_value);
	
		}// ch 1
	}
	//=============
	function wizards_get2(dataalert,listmenu,send_value){
		
		window.document.FrmCwizards.Cwizardsvalue.value='fdfdsdsfdsfdfdsfdsf';
	//document.getElementById('wizardstapmenu').value=dataalert;
	//document.getElementById('wizardslist').value=listmenu;
	//document.getElementById('Cwizardsvalue').value=send_value;
	//var sendvalue=document.getElementById('wizardsvalue').value;
	alert(dataalert);
	/*if(document.getElementById('wizardstapmenu').value==1){
	if(document.getElementById('wizardstapmenu').value!='' && document.getElementById('wizardslist').value!=''){
		if(confirm('ต้องการบันทึกข้อมูล หรือไม่')){alert('บันทึกเรียบร้อย');
		//alert(document.getElementById('wizardsvalue').value);
		document.getElementById('wizardstapmenu').value='';
		document.getElementById('wizardslist').value='';
		//sendedit_wizards_save('formhistory',document.getElementById('wizardsvalue').value,'<?=$_SESSION['company_id'];?>','<?=$_GET['lang'];?>','');
		
		document.getElementById('wizardsvalue').value='';
		
			}else{alert('ไม่มีการบันทึก');
		document.getElementById('wizardstapmenu').value='';
		document.getElementById('wizardslist').value='';
		document.getElementById('wizardsvalue').value='';
			}
		}
	 }//ch */
	}
</script>
<script language="javascript">
function cmenu_left_company(menu){
	 for( i = 1;i <= 8; i++){
		  if(menu == i){
		   document.getElementById('bgtabed'+i).style.display="";  
		   document.getElementById('bgtab'+i).style.display="none"; 
		  }else{
			  
		  document.getElementById('bgtabed'+i).style.display="none";  
		  document.getElementById('bgtab'+i).style.display="";
		  
		  }
		 
		 
	 }//end for
}

</script>
<script  language="javascript">
	function test(datavalue){
	alert(datavalue);
						
	}
</script>
