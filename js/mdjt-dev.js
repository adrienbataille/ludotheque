$(function(){



	//tagging catégorie
    $('#categorie').tagit({

	    singleField: true,
	    allowSpaces: true,
	    autoFocusFirst: true,
	    requireAutocomplete: true,
	    
	    tagSource: function(search, showChoices) {
	        var that = this;
	        var filter = search.term.toLowerCase();
	        $.ajax({
	          url: "tagcategorie.php",
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
    
    //tagging illustrateur
    
    $('#illustrateur').tagit({

	    singleField: true,
	    allowSpaces: true,
	    autoFocusFirst: true,
	    requireAutocomplete: true,
	    
	    tagSource: function(search, showChoices) {
	        var that = this;
	        var filter = search.term.toLowerCase();
	        $.ajax({
	          url: "tagillustrateur.php",
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
    
    //tagging distributeur
    
    $('#distributeur').tagit({

	    singleField: true,
	    allowSpaces: true,
	    autoFocusFirst: true,
	    requireAutocomplete: true,
	    
	    tagSource: function(search, showChoices) {
	        var that = this;
	        var filter = search.term.toLowerCase();
	        $.ajax({
	          url: "tagdistributeur.php",
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
		  