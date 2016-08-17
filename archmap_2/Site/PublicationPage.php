<html>

	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		
		<link rel="stylesheet" type="text/css" href="/archmap_2/css/dropzone.css"/>
	
		<!-- JQUERY -->
		<script type="text/javascript" src="/archmap_2/js/jquery-1.5.1.min.js"></script> 
		<script type="text/javascript" src="/archmap_2/js/jquery-ui-1.8.16.custom.min.js"></script>
		
		<!-- DROPZONE fileupload -->
		<script type="text/javascript"  src="/archmap_2/js/dropzone.js">
		</script>
		
		<!-- KINETIC Stage -->
		<script type="text/javascript"  src="/archmap_2/js/kinetic-v4.7.1.min.js">
		</script>
		
		<!-- ARCHMAP -->
		<script type="text/javascript" src="/archmap_2/js/AM_Utilities.js"></script>
		<script type="text/javascript" src="/archmap_2/js/AM_Models.js"></script>
		<script type="text/javascript" src="/archmap_2/js/AM_Drawing.js" defer="defer"></script>
	
		
		<script>
					  
	
			$(function() {
			
				// GET MODEL DATA
				var id = $_GET("id");
				
				if (! id) {
				  id = 3287;
				}
				
				var dataStore = new DataStore();
					dataStore.getModel("Publication", id, callback);
				// GET MODEL DATA: DONE
				
				
				
				
				// SET UP DROP_ZONE 
				
				// Now that the DOM is fully loaded, create the dropzone, and setup the 
				// event listeners
				Dropzone.autoDiscover = false;
				
				
				var myDropzone = new Dropzone($("#dropzoneUpload").get(0), {
					previewTemplate: "<div class=\"dz-preview dz-file-preview\">\n  <div class=\"dz-details\">\n    <div class=\"dz-filename\"><span data-dz-name></span></div>\n    <div class=\"dz-size\" data-dz-size></div>\n    <img data-dz-thumbnail />\n  </div>\n  <div class=\"dz-progress\"><span class=\"dz-upload\" data-dz-uploadprogress></span></div>\n  <div class=\"dz-success-mark\"><span>✔</span></div>\n  <div class=\"dz-error-mark\"><span>✘</span></div>\n  <div class=\"dz-error-message\"><span data-dz-errormessage></span></div>\n</div>",
					clickable: false
				});
				
				myDropzone.on("dragstart", function(file) {
				//alert("drag started ");
				});
				
				myDropzone.on("success", function(file, response) {
				// alert(response);
				});
				
				Dropzone.options.dropzoneUpload = {
				  	tester2: "Yousa"
				  	};
				  	
			});
				
				
				
			// http://covers.openlibrary.org/b/ISBN/59464232-L.jpg
			
			function callback(model) {
				// GET COVER ART
				$("#coverArt").html('<img src="http://covers.openlibrary.org/b/ISBN/'+model.attrs.ISBN_ISSN+'-L.jpg" /><br><span style="font-size:8;">Cover art courtesyof <a href="http://openlibrary.org/isbn/'+model.attrs.ISBN_ISSN+'">Open Library</a>');
				$("#pubTitle").html(model.attrs.name);
				$("#pubContributors").html('<b>'+model.attrs.date+", "+model.attrs.contributors + "</b>,  " + model.attrs.publisher + ",  " + model.attrs.location);
			}
		
	
	
	
			 $(document)[0].addEventListener("drop", function (e) { 
			 	e.preventDefault();
			 	var url = e.dataTransfer.getData("text");
			//    alert(url);    
				
			    if (url) {
			        $('<img/>', {
			            src: url,
			            alt: "resim"
			        }).appendTo('#webImages');            
			    }
			    return false;
			    			
			
			});  
			
		</script>
			
		
		
		<style>
			body {
			margin:0;
			padding:0;
			background: -webkit-linear-gradient(top, rgba(255,255,255,.1) 0%,rgba(255,255,255,1) 60%), url('/archmap_2/upload_center/upload_DropzoneTmpFiles/7933915_orig.jpg')  no-repeat top left fixed;
			background-size: contain;
		
		
			}
			.transp {
				margin-left:0;
				margin-top:0;
				background-color:white;
				 opacity:0.76;
			}
			.AW_dropbox {
				background-color:rgba(0,0,0,.1);
				min-height: 100;
			}
			
		      #slider {
		        position: absolute;
		        top: 30px;
		        left: 20px; 
		      }
		      #scaleSlider {
		        position: absolute;
		        top: 50px;
		        left: 20px; 
		      }
		
		</style>
		
	</head>

	<body style="font-family: Arial, Helvetica, sans-serif; color: #333">
	
		<div class="transp">
	
			<!-- CONTENT HEADER -->
			<table >
				<tr  style="font-size:36;font-weight:bold;">
					<td style="text-align:right;">
							<div id="urlDrop"><span  style="text-align:right; color: #ddd;">Archmap</span></div>
					</td>
					<td>
							<span style="margin-left:10; color: #ddd;">Publication</span>
					</td>
				</tr>
				
				<tr>
					<td id="coverArt" valign="top" style="padding-left:17;padding-right:40;">
						
					</td>
					<td valign="top">
						<div style="margin-left:10;margin-top:50;margin-right:150;">
							<h2><span id="pubTitle"> </span></h2>
							<div>
								<span id="pubContributors"> </span>
							</div>
							
						
						</div>
					</td>
				</tr>
				<tr>
					<td>
					
					</td>
					<td>
						<div style="margin-left:10;color:#777; margin-bottom:10;">
						
						<span style="color: #ff725d;">Images</span> | Quotes & Notes | Arguments | Buildings | Sculpture | Citations | Bibliography
						</div>
						
						
						
					
					</td>
				</tr>
				
			</table>
			
	

	
	
	
			<!-- DROP_ZONE DROP AREA -->
			<div>
				<form action="/archmap_2/upload_center/UploadFromDropzone.php"
			      class="dropzone"
			      id="dropzoneUpload">
				  
				   <input type="HIDDEN" name="tester" value="Wowsa!">
		
			      <div class="dz-default dz-message">
			      	<span>Drop files here to upload</span>
			      </div>
				      
				      
			     </form>
			</div>
	
	
	
	
	
			<!-- kineticjs stage -->
			<div style="width: 100%; height: 100px;background-color: #eee;  border-top: 1px solid gold;border-bottom: 1px solid gold;position: relative;" class="scrollable">
				<div id="container"> </div>
				
				<input id="slider" type="range" min="-255" max="255" step="1" value="0">
				<input id="scaleSlider" type="range" min="1" max="10" step=".1" value="0">

			</div>
			 			
		
	
			<!-- WEB IMAGES DROP AREA -->
			<div id="webImages" class="AW_dropbox"> 
				<div>Drop web images here....</div>
				
				</div>
			</div>
	
		<div>
	

	</body>

</html>