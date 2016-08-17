<?php
	
	header("Content-type:text/html");

	error_reporting(E_ERROR | E_PARSE);

	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap_2/Setup.php');


	print('<div><b>ArchMap Authors Migration Page</b> </div>');
	
	$db = new Database();
	$buildings = $db->queryAssoc("SELECT id,name FROM building WHERE ((descript is not null AND descript<>\"not visited\") OR plan is not null OR elevation is not null OR history is not null OR chronology IS NOT NULL OR significance IS NOT NULL OR sculpture IS NOT NULL)  ORDER BY name limit 10, 3000");
	
	
	print('<table style="font-size: 10;">');
	
	foreach($buildings as $i=>$building) {
		
		print ("<tr style=\"margin-bottom:25\">");
		print ("<td valign=top><b>".utf8_decode($building["name"])."</b></td>");
		
		$building = new Building($building["id"]);
		print ("<td valign=top><b>".$building->get("author_id")."</b></td>");
		
		
		print("<td valign=top>".utf8_decode($building->get('editdate')) . "</td>");
		
		print("<td valign=top>".utf8_decode($building->get('descript')) . "</td>");
		
		print("<td valign=top>".utf8_decode($building->get('plan')) . "</td>");
		print("<td valign=top>".utf8_decode($building->get('elevation')) . "</td>");
		print("<td valign=top>".utf8_decode($building->get('history')) . "</td>");
		print("<td valign=top>".utf8_decode($building->get('chronology')) . "</td>");
		print("<td valign=top>".utf8_decode($building->get('significance')) . "</td>");
		print("<td valign=top>".utf8_decode($building->get('sculpture')) . "</td>");
	
		 
		print ("</tr>");
		
		/*
		if ( $building->get('descript') != "" ) {
			$p = new Passage();
			
			$p->set("name", 	"Description");
			$p->set("metaphone", 	metaphone("Description"));
			$p->set("descript", $building->get('descript'));
			
			$p->set("author_id", $building->get("author_id"));
			$p->set("createdate", $building->get('editdate'));
			$p->set("editdate", $building->get('editdate'));
			
			$p->saveChanges();
			
			$building->addRelation($p);
		}
		
		
		if ($building->get('plan') != "" ) {
			$p = new Passage();
			$p->set("name", 	"Plan");
			$p->set("metaphone", 	metaphone("Plan"));
			$p->set("descript", $building->get('plan'));
			
			$p->set("author_id", $building->get("author_id"));
			$p->set("createdate", $building->get('editdate'));
			$p->set("editdate", $building->get('editdate'));
			$p->saveChanges();
			$building->addRelation($p);

		}
		
		if ($building->get('elevation') != "" ) {
			$p = new Passage();
			$p->set("name", 	"Elevation");
			$p->set("metaphone", 	metaphone("Elevation"));
			$p->set("descript", $building->get('elevation'));
			
			$p->set("author_id", $building->get("author_id"));
			$p->set("createdate", $building->get('editdate'));
			$p->set("editdate", $building->get('editdate'));
			$p->saveChanges();
			$building->addRelation($p);
		}
		
		if ($building->get('history') != "" ) {
			$p = new Passage();
			$p->set("name", 	"History");
			$p->set("metaphone", 	metaphone("history"));
			$p->set("descript", $building->get('history'));
			
			$p->set("author_id", $building->get("author_id"));
			$p->set("createdate", $building->get('editdate'));
			$p->set("editdate", $building->get('editdate'));
			$p->saveChanges();
			$building->addRelation($p);
		}
		
		
		if ($building->get('chronology') != "" ) {
			$p = new Passage();
			$p->set("name", 	"Chronology");
			$p->set("metaphone", 	metaphone("chronology"));
			$p->set("descript", $building->get('chronology'));
			
			$p->set("author_id", $building->get("author_id"));
			$p->set("createdate", $building->get('editdate'));
			$p->set("editdate", $building->get('editdate'));
			$p->saveChanges();
			$building->addRelation($p);
		}
		
		if ($building->get('significance') != "" ) {
			$p = new Passage();
			$p->set("name", 	"Significance");
			$p->set("metaphone", 	metaphone("significance"));
			$p->set("descript", $building->get('significance'));
			
			$p->set("author_id", $building->get("author_id"));
			$p->set("createdate", $building->get('editdate'));
			$p->set("editdate", $building->get('editdate'));
			$p->saveChanges();
			$building->addRelation($p);
		}
		
		if ($building->get('sculpture') != "" ){
			$p = new Passage();
			$p->set("name", 	"Sculpture");
			$p->set("metaphone", 	metaphone("sculpture"));
			$p->set("descript", $building->get('sculpture'));
			
			$p->set("author_id", $building->get("author_id"));
			$p->set("createdate", $building->get('editdate'));
			$p->set("editdate", $building->get('editdate'));
			$p->saveChanges();
			$building->addRelation($p);
		}
		
	*/
		
		
		
		
		
		
		
		
		
		
		
		
		
	}

	print('<table>');
	
	
?>