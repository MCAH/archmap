		$(document).ready(function() {
			$("html").bind("selectionChanged", loadProfile);			
		});

		function loadProfile() {
			if (dataStore.lastSelected) {
				$("div#profile_holder").load("/archmap/appdev/main.php?componentName=Profile/Profile&id="+dataStore.lastSelected);
			}
		}