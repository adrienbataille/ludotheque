$(function(){
    // var sampleTags = ['c++', 'java', 'php', 'coldfusion',
	// 'javascript', 'asp', 'ruby', 'python', 'c', 'scala', 'groovy',
	// 'haskell', 'perl', 'erlang', 'apl', 'cobol', 'go', 'lua'];


    // -------------------------------
    // Single field
    // -------------------------------
    $('#categorie').tagit({
	    // availableTags: sampleTags,
	    // This will make Tag-it submit a single form value, as a
		// comma-delimited field.
	    singleField: true,
	    allowSpaces: true,
	    autoFocusFirst: true,
	    requireAutocomplete: true,
	    
	    tagSource: function(search, showChoices) {
	        var that = this;
	        var filter = search.term.toLowerCase();
	        $.ajax({
	          url: "tagCategorie.php",
	          dataType: "json",
	          type: "POST",
	          data:  { filter: filter } ,
	          success: function(choices) {
	            showChoices(that._subtractArray(choices, that.assignedTags()));
	            availableTags:choices;
	          }
	        });
	      }
    });
});
$(document).ready(function() {
	$("#rechercheAvancee").hide();
	
	$( "#buttonAvance" ).click(function() {
		var options = {};
		$( "#rechercheAvancee" ).toggle( 'blind',options, 500 );
    		return false;
		});
	
	$("#recherche").submit(function() {
		$("form#recherche input:text").each(function(){
			   if($(this).val()==""){
				   $(this).remove();
			   }
			});
		$("form#recherche select").each(function(){
			   if($(this).val()==""){
				   $(this).remove();
			   }
			});
    });
	//$("#resultat tr:nth-child(odd)").addClass("odd");
	
});
