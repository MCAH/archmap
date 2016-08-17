	
		var  imageLayer, curveLayer, scaleMeterGroup, imageGroup, scaleMeterText, yoda, meterStick;

		var imageScale = 1;



		$( document ).ready(function() {

			window.onresize = function(event) {
				stage.setWidth(window.innerWidth);
			}
			
			$('.scrollable').mouseenter(function(){
               $("body").css("overflow","hidden");
               document.addEventListener("mousewheel", zoom, false);
            });
            $('.scrollable').mouseleave(function(){
            	$("body").css("overflow","auto");
            	document.removeEventListener("mousewheel", zoom);
            });
            $('.scrollable').bind('scroll', function() {
            	
            	// scrollTop is  the number of pixels that are hidden from view above the scrollable area.
            	if( $(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight   ||  $(this).scrollTop() == 0) {
                    setTimeout(function(){
                    	$("body").css("overflow","auto");    
                    }, 1000);
                } else {
                	//$("body").css("overflow","hidden");
                }                         
			});
			
			 document.addEventListener("mousewheel", zoom, false);
		
		});



	function calculateDistance(x1, y1, x2, y2) {
	    var distance = Math.sqrt((x2 - x1) * (x2 - x1) + (y2 - y1) * (y2 - y1));
	  
	    //distance = Math.round(distance * 100 / 1) / 100;
	    distance = Math.round(distance);
	    return distance;
	}	
	function getCenter(x1, y1, x2, y2) {
	    var distance = Math.sqrt((x2 - x1) * (x2 - x1) + (y2 - y1) * (y2 - y1));
	  
		var cx = (x2-x1)/2;
		var cy = (y2-y1)/2;
		
	    cx = Math.round(cx * 100 / 1) / 100;
	    cy = Math.round(cy * 100 / 1) / 100;
	    
	    return {x:(x1+cx), y:(y1+cy)};
	}	
	
	
	
	
	function buildAnchor(x, y) {
	
		var anchorGroup = new Kinetic.Group({
			x: x,
			y: y,
			draggable: true
			
		});
		
        var anchor = new Kinetic.Circle({
          radius: 20,
          stroke: '#666',
          strokeWidth: 2,
          fill: 'red',
          opacity: 0.3
          
          
        });
        

        // add hover styling
        anchor.on('mouseover', function() {
          document.body.style.cursor = 'pointer';
          this.setStrokeWidth(4);
          imageLayer.draw();
        });
        anchor.on('mouseout', function() {
          document.body.style.cursor = 'default';
          this.setStrokeWidth(2);
          imageLayer.draw();
          
        });

        anchor.on('dragend', function() {
          //drawCurves();
         // updateDottedLines();
        });
        
        
        anchorGroup.add(anchor);

		var gap = 5;
		var len = 35;
		
		var line1 = new Kinetic.Line({
			points: [0, gap, 0, len],
			stroke: "gold"
			
		});
		var line2 = new Kinetic.Line({
			points: [0, -gap, 0, -len],
			stroke: "gold"
			
		});
		var line3 = new Kinetic.Line({
			points: [gap, 0, len, 0],
			stroke: "gold"
			
		});
		var line4 = new Kinetic.Line({
			points: [-gap, 0, -len, 0],
			stroke: "gold"
			
		});
        anchorGroup.add(line1);
        anchorGroup.add(line2);
        anchorGroup.add(line3);
        anchorGroup.add(line4);

		
		
		scaleMeterGroup.add(anchorGroup);
       
        return anchorGroup;
        
      
      }	
      
      
      
    function drawCurvesAndText() {
    
        var context = curveLayer.getContext();

        context.clear();
       
       var p1 = {x: meterStick.start.attrs.x, y: meterStick.start.attrs.y};
       var p2 = {x: meterStick.end.attrs.x,   y: meterStick.end.attrs.y};
       
       var cen = getCenter(p1.x, p1.y,  p2.x, p2.y);
 

       	p1.x = p1.x + scaleMeterGroup.getX();
       	p1.y = p1.y + scaleMeterGroup.getY();
       	p2.x = p2.x + scaleMeterGroup.getX();
       	p2.y = p2.y + scaleMeterGroup.getY();
 
 
       	
       	p1.x = p1.x*imageScale + imageLayer.getX();
       	p1.y = p1.y*imageScale + imageLayer.getY();
       	p2.x = p2.x*imageScale + imageLayer.getX();
       	p2.y = p2.y*imageScale + imageLayer.getY();
        
        var dist = calculateDistance(p1.x, p1.y,  p2.x, p2.y);
      
		context.beginPath();
        context.moveTo(p1.x, p1.y);
        context.lineTo(p2.x, p2.y);
 
        context.setAttr('strokeStyle', 'red');
        context.setAttr('lineWidth', 1);
        context.stroke();
        
          
        
        
        
       scaleMeterText.setX(cen.x - 25);
       scaleMeterText.setY(cen.y - 25);
       var distInPixels = Math.round(dist/imageScale);
       var distInMeters = Math.round((distInPixels * 20/255)*100) / 100;
       scaleMeterText.setText( distInMeters + " m ("+   Math.round( (distInMeters * (1/.2959))*100)/100 + " rm-ft)");
       
	}
	
	
	function globalToLayerCoords(layer, pt) {
       	var p = {x:0, y:0};
       	
       	p.x = pt.x*layer.getScale() + layer.getX();
       	p.y = pt.y*layer.getScale() + layer.getY();
		
	   	return p;
	}
	
	
	function zoom(e) {
		var zoomAmount = e.wheelDeltaY*0.001;
	  
		
		var prevScale = imageScale;
		
        imageScale += zoomAmount;
        if (imageScale < .1) {
        	imageScale = .1;
		}
		imageLayer.setScale(imageScale*1);
		
		var scaleFactor = imageScale/prevScale;

		var x = e.clientX;
		var y = e.clientY;
		
		var mousePos = stage.getMousePosition();
		// now how does this stage point transpose into the imageLayer?
			
		var ix = imageLayer.getX();
		var iy = imageLayer.getY();
		
		var distx = mousePos.x - ix;
		var disty = mousePos.y - iy;
		
		// get local dist
		var localdistx = distx / prevScale;
		var localdisty = disty / prevScale;
		
		
		var globaldistx = localdistx*imageScale;
		var globaldisty = localdisty*imageScale;
		
		var newx = globaldistx - distx;
		var newy = globaldisty - disty;
		
		var xx = ix -    newx;
		var yy = iy -    newy;
		
		imageLayer.setX(xx);
		imageLayer.setY(yy);
		

/*

		var evt = e.originalEvent;
		var mx = e.offsetX;
        var my = e.offsetY;
		var origin = imageLayer.getPosition();
		origin.x = mx - (mx - origin.x) * zoom;
        origin.y = my - (my - origin.y) * zoom;
		
		imageLayer.setPosition(origin.x, origin.y);
*/		
		imageLayer.batchDraw();    

	
	}
	
			
      function writeScaleMeterMessage(message) {
        scaleMeterText.setText(message);
        //imageLayer.draw();
      }
      
     
      
      
      
      // INIT
      
      // SET STAGE
      var stage = new Kinetic.Stage({
        container: 'container',
        width: window.innerWidth,
        height:  500
       
      });
      
      // LAYERS
      curveLayer = new Kinetic.Layer();
	  imageLayer = new Kinetic.Layer({ draggable: true});
	  
	   
	  scaleMeterGroup = new Kinetic.Group({
        x: 220,
        y: 200,
        rotationDeg: 0
      });
      
      imageGroup = new Kinetic.Group();
      
   

	  scaleMeterText = new Kinetic.Text({
        x: 90,
        y: 10,
        fontFamily: 'Calibri',
        fontSize: 18,
        text: '',
        fill: '5a55'
      });
	  scaleMeterGroup.add(scaleMeterText);
	  

      imageLayer.add(imageGroup);
      imageLayer.add(scaleMeterGroup);
	 
        
      
      var imageObj = new Image();
      imageObj.onload = function() {
         yoda = new Kinetic.Image({
	          x: -1000,
	          y: -500,
	          image: imageObj,
	          filter: Kinetic.Filters.Brighten,
	          filterBrightness: 0

			  });

        // add the shape to the layer
        imageGroup.add(yoda);
        
        
        
		imageLayer.setPosition(window.innerWidth/2, 250);
        imageScale = .5;
        imageLayer.setScale(.5);
        
         imageLayer.batchDraw();
       
       
       
       
        var slider = document.getElementById('slider'); 
        slider.onchange = function() {
        
        	
        
			yoda.setFilterBrightness(Math.round(slider.value));
          
            imageLayer.batchDraw();    
        };
        var scaleSlider = document.getElementById('scaleSlider'); 
        scaleSlider.onchange = function() {
           	imageScale = scaleSlider.value;
        
			imageLayer.setScale(imageScale*1);
			
			imageLayer.batchDraw();    
        };

      };
      //imageObj.src = '/archmap/media/buildings/001000/1063/images/100/1063_00058_w.jpg';
	  imageObj.src = '/archmap/media/buildings/001000/1063/images/2000/1063_00748_w.jpg'; // 2000x 1023



	
	  imageLayer.on('beforeDraw', function() {
          drawCurvesAndText();
         
      });
      

	  meterStick = {
          start: 	buildAnchor(0, 0),
          end: 		buildAnchor(180, 0)
        };
      
      
     

     stage.add(imageLayer);
     stage.add(curveLayer);
	
