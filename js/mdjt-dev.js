	    $(function(){
            //var sampleTags = ['c++', 'java', 'php', 'coldfusion', 'javascript', 'asp', 'ruby', 'python', 'c', 'scala', 'groovy', 'haskell', 'perl', 'erlang', 'apl', 'cobol', 'go', 'lua'];


            //-------------------------------
            // Single field
            //-------------------------------
		    $('#categorie').tagit({
			    //availableTags: sampleTags,
			    // This will make Tag-it submit a single form value, as a comma-delimited field.
			    singleField: true,
			    allowSpaces: true,
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
		    
			    /*
			    tagSource : function(search, showChoices) {
                    var filter = search.term.toLowerCase();
                    var choices = $.grep(this.availableTags, function(element) {
                        // Only match autocomplete options that begin with the search term.
                        // (Case insensitive.)
                        return (element.toLowerCase().indexOf(filter) === 0);
                    });
                    alert("test");
                    showChoices(this._subtractArray(choices, this.assignedTags()));
                }*/
			    
		    });

            // singleFieldTags2 is an INPUT element, rather than a UL as in the other 
            // examples, so it automatically defaults to singleField.
		    $('#singleFieldTags2').tagit({
			    availableTags: sampleTags
		    });


            //-------------------------------
            // Preloading data in markup
            //-------------------------------
            $('#myULTags').tagit({
			    availableTags: sampleTags, // this param is of course optional. it's for autocomplete.
			    // configure the name of the input field (will be submitted with form), default: item[tags]
			    itemName: 'item',
			    fieldName: 'tags'
		    });

            //-------------------------------
            // Tag events
            //-------------------------------
            var eventTags = $('#eventTags');
            eventTags.tagit({
                availableTags: sampleTags,
                onTagRemoved: function(evt, tag) {
                    console.log(evt);
                    alert('This tag is being removed: ' + eventTags.tagit('tagLabel', tag));
                },
                onTagClicked: function(evt, tag) {
                    console.log(tag);
                    alert('This tag was clicked: ' + eventTags.tagit('tagLabel', tag));
                }
            }).tagit('option', 'onTagAdded', function(evt, tag) {
                // Add this callbackafter we initialize the widget,
                // so that onTagAdded doesn't get called on page load.
                alert('This tag is being added: ' + eventTags.tagit('tagLabel', tag));
            });

            //-------------------------------
            // Tag-it methods
            //-------------------------------
            $('#methodTags').tagit({
			    availableTags: sampleTags
		    });

            //-------------------------------
            // Allow spaces without quotes.
            //-------------------------------
            $('#allowSpacesTags').tagit({
                availableTags: sampleTags,
                allowSpaces: true
            });

            //-------------------------------
            // Remove confirmation
            //-------------------------------
            $('#removeConfirmationTags').tagit({
                availableTags: sampleTags,
                removeConfirmation: true
            });
            
	    });