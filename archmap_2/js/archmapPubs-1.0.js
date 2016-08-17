

$( document ).ready(function() {

	// initialize json dropzone from zotero (CSL-JSON)
	
	
	widget = $('.biblio-import-widget');
	$(".addItemFromZoteroButton").click(function() {
		$(this).hide();
		setupBiblioImportWidget(widget);
	});
	
	
});

function setupBiblioImportWidget(widget) {
	
	
	form = $('<form class="biblio-upload-form" style="position: relative;margin-bottom: 50;"  action="/api" method="post" ></form>');
	
	form.append('<div>Import Records from Zotero</div>');	
	form.append('<div class="directions">Paste or drag-and-drop CSL JSON here... (RIS coming soon!)</div>');
		
	form.append('<input type="hidden" name="request" value="checkBiblioJSONRecords" />')
	
	textarea = $('<textarea id="zotero-json" name="json-textarea" style="position: relative; width:100%; height:50;"></textarea>').val("Paste or drag-and-drop CSL JSON here... (RIS coming soon!)");
	
	textarea.bind('input propertychange', function() {
		processJSON($(this));
	});
	resetTextArea(textarea);

	form.append(textarea);
	form.append('<button>Done</button>').click(function(e) {
		e.preventDefault();
		$(this).hide();
		form.remove();
		$(".addItemFromZoteroButton").show();
		$(this).remove();
	});
						
	widget.append(form);
	
	widget.append('<div class="biblio-upload-results"style="clear: both;"></div>');
		
}


function resetTextArea(el) 
{
	el.val("");
}

function processJSON(textareaEl) {
	
	var form 			= textareaEl.parent();
	var widget 			= textareaEl.parent().parent();
	var resultsEl 		= widget.find(".biblio-upload-results"); 
	
	var data = {};
	data['request'] 		= 'checkBiblioJSONRecords';
	//data['session_id']		= thisUser.session_id;
	
	var text = textareaEl.val();
	
	
	// determine if json or RIS or neither
	var isJSON = false;
	try {
		$.parseJSON( text );
		//must be valid JSON
		isJSON = true;
	} catch(e) {
	    //must not be valid JSON  
	      
	}
	
	
	
	if(! isJSON){
		resetTextArea(textareaEl);
		alert('Please use CSL JSON exported records. In Zotero, from Preferences, choose export "Default Export Format"');
		return;
	} 
	
	data['json'] = text;
	
	console.log('....server api call: checkBiblioJSONRecords');
	
	$.post('/api', data, function(json_data) {
		//console.log("json_data=" + json_data); return;
		
		form.hide();
		
		//var pubs = $.parseJSON(json_data);
		var pubs = json_data;
		
		resultsEl.empty();
		resultsEl.append('<div style="margin-bottom: 30;">Please review the records before hitting the Submit button.</div>');
		
		var min_score = 20;
		var counter = 0;
		$.each( pubs, function( key, pub ) {
				
				console.log("key:" + key + ", " + pub.title);
				// check if in db already
				var container = $('<div  class="pub-import-item" data-pub_item="'+counter+'" style="padding-left:20; margin-bottom: 40;"></div>');
				
				var checked = " checked ";
								
				// record from imported json (e.g., zotero
				if (pub.suggested && pub.suggested[0] && pub.suggested[0]['score'] > min_score) 
				{
					checked = " ";
					
				}
				
				var date;
				if (pub.issued && pub.issued['date-parts']) 
				{
					date = pub.issued['date-parts'][0];
				}
				var origRecRow = $('<div><input data-import_row_id="'+counter+'" data-pub_id="import"  type="radio" '+checked+' name="pubItem_'+counter+'"/></div>');
				switch(pub.type)
				{
					case "book":
					case "thesis":
					
						origRecRow.append(pub.author[0].given+' '+pub.author[0].family+', <i>'+pub.title+'</i>, '+date +', '+pub.publisher+', '+pub["publisher-place"]);
						break;
						
					case "chapter":
						origRecRow.append(pub.author[0].given+' '+pub.author[0].family+', "'+pub.title+'" in <i>'+pub['container-title']+'</i>, '+pub.publisher+', '+pub["publisher-place"] + ', (' +date+'): p. '+pub["page"]);
						break;
					case "article-journal":
						origRecRow.append(pub.author[0].given+' '+pub.author[0].family+', "'+pub.title+'" in <i>'+pub['container-title']+'</i>, '+pub["volume"] + ', (' +date+'): p. '+pub["page"]);
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
				
			
				
				resultsEl.append(container);
				
				counter++;
		});
		
		// add submit
		var submit = $("<button>Submit</button>");
		
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
			 
			 	
			 var entityEl = $(this).closest(".entity-profile");
			 	
			 			 
			 var submit_data = {};
			
			 submit_data['request'] 		= 'submitJSONBibRecords';
			 submit_data['session_id']		= thisUser.session_id;
			 if (entityEl) 
			 {
			 	submit_data["from_entity"] 	= entityEl.attr("data-entity");
			 	submit_data["from_id"] 		= entityEl.attr("data-id");
			 	
			 	
			 } 
			 else 
			 {
			 	submit_data["from_entity"] 	= "null";
			 	submit_data["from_id"] 		= "null";
			 }
			 console.log("from_entity: "+submit_data["from_entity"]+", from_id="+submit_data["from_id"]);
			 
			 submit_data["json_records"] 	= json_str;

			
			 console.log(json_str);
			 console.log("Yup - now submit!");
			 
			 $.post('/api', submit_data, function(json_data) 
				 {
				 	console.log('Server Response!');
				 	console.log(json_data);
				 	
					 resultsEl.empty();
	
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
					 resultsEl.append(container);
	
				 }, "json");
			
		});
		
		
		resultsEl.append(submit);
		
		
		
	}, 'json');
	
	
	
}


