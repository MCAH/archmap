<?php

// BASED ON THE REDIRECT_URL, FIGURE OUT LANDING PAGE!
require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap_2/Setup.php');
require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap_2/Database.php');

$db = Utilities::getSharedDBConnection();	



?>
	<script type="text/javascript" src="/archmap_2/js/jquery-1.10.2.min.js"></script> 
	<script type="text/javascript" src="/archmap_2/js/jquery-ui-1.10.2.min.js"></script>
<link rel="stylesheet" type="text/css" href="/archmap_2/css/archmap3.css"/>

<script>

$( document ).ready(function() {
	
	$("#zotero-json").bind('input propertychange', function() {
		processJSON();
	});
});


$(document).on("mousedown", "#process-json", function() {
	//alert("process");

	processJSON();
	
});

function processJSON() {
	
	var data = {};
	data['request'] 		= 'checkBiblioJSONRecords';
	//data['session_id']		= thisUser.session_id;
	data['json']			= $("#zotero-json").val();
	
	console.log('checkBiblioJSONRecords::');
	
	$.post('/api', data, function(json_data) 
	{
		// json returned
		
		$("#theform").remove();
		
		//console.log(json_data); return;
		
		var pubs = $.parseJSON(json_data);
		
		$("#results").empty();
		$("#results").append('<div style="margin-bottom: 30;">Please review the records before hitting the Submit button.</div>');
		
		var min_score = 20;
		var counter = 0;
		$.each( pubs, function( key, pub ) {
				
				// check if in db already
				var container = $('<div  class="pub-import-item" data-pub_item="'+counter+'" style="padding-left:20; margin-bottom: 40;"></div>');
				
				var checked = " checked ";
								
				// record from imported json (e.g., zotero
				if (pub.suggested && pub.suggested[0] && pub.suggested[0]['score'] > min_score) 
				{
					checked = " ";
					
				}
				
				var origRecRow = $('<div><input data-import_row_id="'+counter+'" data-pub_id="import"  type="radio" '+checked+' name="pubItem_'+counter+'"/></div>');
				switch(pub.type)
				{
					case "book":
					case "thesis":
						origRecRow.append(pub.author[0].given+' '+pub.author[0].family+', <i>'+pub.title+'</i>, '+pub.issued['date-parts'][0] +', '+pub.publisher+', '+pub["publisher-place"]);
						break;
						
					case "chapter":
						origRecRow.append(pub.author[0].given+' '+pub.author[0].family+', "'+pub.title+'" in <i>'+pub['container-title']+'</i>, '+pub.publisher+', '+pub["publisher-place"] + ', (' +pub.issued['date-parts'][0]+'): p. '+pub["page"]);
						break;
					case "article-journal":
						origRecRow.append(pub.author[0].given+' '+pub.author[0].family+', "'+pub.title+'" in <i>'+pub['container-title']+'</i>, '+pub["volume"] + ', (' +pub.issued['date-parts'][0]+'): p. '+pub["page"]);
						break;
				}
				container.append(origRecRow);
				
				// suggestions from our database
				checked = "  ";
				if (pub.suggested && pub.suggested[0]) {
					
					container.append('<hr><i style="font-size:12;color: red; padding-left: 20;">Is this actually of the items already in the Archmap database following?</i><br>');
					
					$.each( pub.suggested, function( key1, sug ) {
						if (sug.score > min_score) {
							checked = " checked ";
						}
						//container.append('<div style="padding-left:20;margin-bottom:10"><div class="id-label">AM.PUBID '+sug.am_pubid+'</div> <div><input  data-import_row_id="'+counter+'" data-pub_id="'+sug.am_pubid+'" type="radio" name="pubItem_'+counter+'" '+checked+' /></div>  <div class="id-label">score '+sug.score+'</div></div>');
						
						var origRecRow = $('<div style="padding-left:20;margin-bottom:10"><div class="id-label">AM.PUBID '+sug.am_pubid+'</div><input data-import_row_id="'+counter+'" data-pub_id="'+sug.am_pubid+'"  type="radio" '+checked+' name="pubItem_'+counter+'"  '+checked+'  /></div>');
						switch(pub.type)
						{
						
							case "book":
							case "thesis":
								origRecRow.append(sug.contributors+', <i>'+sug.name+'</i>, '+sug.date +', '+sug.publisher+', '+sug.location);
								break;
								
							case "chapter":
								origRecRow.append(sug.contributors+', "'+sug.name+'" in <i>'+sug['container_title']+'</i>,  '+sug.publisher+', '+sug["publisher"] + ', (' +sug.date+'): p. '+sug["pages"]);
									break;
							case "article-journal":
								origRecRow.append(sug.contributors+', "'+sug.name+'" in <i>'+sug['container_title']+'</i>, '+sug["volume"] + ', (' +sug.date+'): p. '+sug["pages"]);
								break;
						}
						container.append(origRecRow);
						
						
						
						
						
						
						checked = "";

					});
				} else {
					container.append('<div style="padding-left:20;margin-bottom:10"><div class="id-label">[ NEW ]</div>');
				}
				
			
				
				$("#results").append(container);
				
				counter++;
		});
		
		// add submit
		var submit = $("<button>Submite</button>");
		
		submit.click(function(e) {
			 e.preventDefault();
			 
			 console.log("Sending");
			 
			 var inputs = $( "input:checked" );
			 
			 // build data to send to server
			 var import_pubs = new Array();
			 var pub_counter = 0;
			 $.each(inputs, function() {
				 console.log("input: " + $(this).data("import_row_id") + " :: " + $(this).data("pub_id") );
				 
				 var pub = {};
				 
				 pub["id"] = $(this).data("pub_id");
				 
				 if ($(this).data("pub_id") == "import") {
					 console.log('importing "' + pubs[$(this).data("import_row_id")].title + '" ');
					 pub["pub_data"] = pubs[$(this).data("import_row_id")];
				 } 
				 import_pubs[pub_counter++] = pub;
			 });
			 var json_str = JSON.stringify(import_pubs);			 
			 //console.log(json_str);
			 
			 			 
			 var submit_data = {};
			
			 submit_data['request'] 		= 'submitJSONBibRecords';
			// submit_data['session_id']		= thisUser.session_id;
			 submit_data["from_entity"] 	= "null";
			 submit_data["from_id"] 		= "null";
			 submit_data["json_records"] 	= json_str;
			
			 console.log(json_str);
			  console.log("Yup");
			 $.post('/api', submit_data, function(json_data) 
				 {
				 	
				 	console.log(json_data);
				 	
					 $("#results").empty();
	
					 var container = $('<div style="padding-left:20; margin-bottom: 40;"></div>');

					 $.each( pubs, function( key, pub )  
						 {
						 	var authors = "";
						 	var authcount = 0;
						 	$.each( pub.author, function(key, auth)
						 	{
						 		//console.log("auth = " + auth);
							 	if (auth.family) {
							 		if (authcount++ > 0) authors += ", ";
							 		authors += auth.given+' '+auth.family;
								 	
							 	}
						 	});
						 	
							var origRecRow = $('<div style="margin-bottom: 10;"></div>');
							switch(pub.type)
							{
								case "book":
								case "thesis":
									origRecRow.append(pub.author[0].given+' '+pub.author[0].family+', <i>'+pub.title+'</i>, '+pub.issued['date-parts'][0] +', '+pub.publisher+', '+pub["publisher-place"]);
									break;
									
								case "chapter":
									origRecRow.append(pub.author[0].given+' '+pub.author[0].family+', "'+pub.title+'" in <i>'+pub['container-title']+'</i>, '+pub.publisher+', '+pub["publisher-place"] + ', (' +pub.issued['date-parts'][0]+'): p. '+pub["page"]);
									break;
								case "article-journal":
									origRecRow.append(pub.author[0].given+' '+pub.author[0].family+', "'+pub.title+'" in <i>'+pub['container-title']+'</i>, '+pub["volume"] + ', (' +pub.issued['date-parts'][0]+'): p. '+pub["page"]);
									break;
							}
							container.append(origRecRow);
							
						 	
						 });
					 $("#results").append(container);
	
				 });
			
		});
		$("#results").append(submit);
		
		
		
	});
	
	
	
}




</script>



<br>
<div style="margin:30;">

<h2>Bibliographic Import</h2>

<form id="theform" action="/api" method="post" >
<div>Paste or Drag and Drop CSL JSON here:</div>

<input type="hidden" name="request" value="checkBiblioJSONRecords" />
<textarea id="zotero-json" name="json-textarea" style="width:500; height:500;"></textarea>
<!--
<input type="submit" value="send" />
-->
</form>


<div id="results"></div>

</div>