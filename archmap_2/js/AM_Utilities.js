	var entityName = {10:'Model', 20:'HistoricalEvent', 25:'HistoricalObject', 30:'Place', 40:'Building', 50:'Person', 60:'Publication', 70:'Collection', 80:'LexiconEntry', 90:'SocialEntity', 100:'Map', 110:'Image', 140:'NoteCard', 150:'Essay'};
	var entityId = {'Model':10, 'HistoricalEvent':20, 'HistoricalObject':25, 'Place':30, 'Building':40, 'Person':50, 'Publication':60, 'Collection':70, 'LexiconEntry':80, 'SocialEntity':90, 'Map':100, 'Image':110, 'NoteCard':140, 'Essay':150};
	var pubtypes = {'BookSection':5, 'Book':6, 'ConferenceProceedings':10, 'Webpage': 12, 'Article':17, 'JournalArticle':17, 'NewspaperArticle':23, 'Patent':25, 'PersonalCommunication':26, 'Report':27, 'EditedBook':28, 'Periodical':1000};
	var mimeSuffixes = {1:'gif', 2:'jpg', 3:'png'};

	function generateTempId() {
		return 'tmp_' + Math.floor(Math.random()*1000000000);
	}


	function logit(msg) {
	      console.log("%s: ", msg);
	      
	 };

	function isNumeric(input)
	{
		logit("isNumeric: " + input + " --> " + ((input - 0) == input) + " && "+ input.length+">0 = " + (input.length > 0) );
	    return (input - 0) == input;
	}

	 
	function $_GET( name ){
	  name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
	  var regexS = "[\\?&]"+name+"=([^&#]*)";
	  var regex = new RegExp( regexS );
	  var results = regex.exec( window.location.href );
	  if( results == null )
	    return "";
	  else
	    return results[1];
	}		    
