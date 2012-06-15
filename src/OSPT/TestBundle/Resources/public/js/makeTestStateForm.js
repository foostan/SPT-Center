
function setRichTextform(){
	$("textarea").cleditor({
		width:	"100%", 
		height:	100,
	});

	jQuery(function(){$("textarea").cleditor();});
}

if(typeof jQuery != "undefined"){

	// Get the div that holds the collection 
	var optionCH = $('div#test_state_test_StaOptions');
	
	// setup an "add" link
	var $addOptionLink = $('<a href="#" class="add_option_link btn btn-mini btn-primary">Add option</a>');
	var $newOptionLinkDiv = $('<div></div>').append($addOptionLink);
	
	$(document).ready(function() {
		setRichTextform();
	
	    // add a delete link to all of the existing form div elements
	    optionCH.find('div.option').each(function() {
	        addFormDeleteOptionLink($(this));
	    });
	
	    // add the "add" anchor and div to  div
	    optionCH.append($newOptionLinkDiv);
	
	    $addOptionLink.on('click', function(e) {
	        // prevent the link from creating a "#" on the URL
	        e.preventDefault();
	
	        // add a new form (see next code block)
	        addOptionForm();
	
			setRichTextform();
		
	    });
	
	});
}

function addOptionForm() {
    // Get the data-prototype we explained earlier
    var prototype = optionCH.attr('data-prototype');
    // Replace '$$name$$' in the prototype's HTML to
    // instead be a number based on the current collection's length.
   	var newForm = prototype.replace(/\$\$test_staOption\$\$/g, optionCH.children().length-1);

    // Display the form in the page in an li, before the "Add" link div 
    var $newFormDiv = $('<div class="option well"></div>').append(newForm);
    $newOptionLinkDiv.before($newFormDiv);

	// add a delete link to the new form
    addFormDeleteOptionLink($newFormDiv);

	setRichTextform();
}

function addFormDeleteOptionLink($formDiv) {
	var $removeFormA = $('<a href="#" class="btn btn-mini btn-danger">Delete option</a>');
	$formDiv.append($removeFormA);

	$removeFormA.on('click', function(e) {
		 // prevent the link from creating a "#" on the URL
		e.preventDefault();

		// remove the div for form
		$formDiv.remove();
	});
}
