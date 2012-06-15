if(typeof jQuery != "undefined"){

// Get the div that holds the collection 
var questionCH = $('div#test_problem_test_proQuestions');

// setup an "add" link
var $addQuestionLink = $('<a href="#" class="add_question_link btn btn-mini btn-primary">Add question</a>');
var $newQuestionLinkDiv = $('<div class="clear"></div>').append($addQuestionLink);

$(document).ready(function() {
    // add a delete link to all of the existing form div elements
    questionCH.find('div.question').each(function() {
        addFormDeleteQuestionLink($(this));

	    // add the "add" anchor and div to  div
		var choiceCH = $(this).find('div:regex(id,^test_problem_test_proQuestions_[0-9]+_test_proQueChoices$)');
		var $addChoiceLink = $('<a href="#" class="add_choice_link btn btn-mini btn-primary">Add choice</a>');
		var $newChoiceLinkDiv = $('<div class="clear"></div>').append($addChoiceLink);
    	
		choiceCH.find('div.choice').each(function() {
			// add a delete link to the new form
		    addFormDeleteChoiceLink($(this));
		});

	    choiceCH.append($newChoiceLinkDiv);

    	$addChoiceLink.on('click', function(e) {
    	    // prevent the link from creating a "#" on the URL
    	    e.preventDefault();
	        // add a new form (see next code block)
	        addChoiceForm();
	    });
    
		function addChoiceForm() {
		    // get the data-prototype we explained earlier
		    var prototype = choiceCH.attr('data-prototype');
		
		    // replace '$$name$$' in the prototype's html to
		    // instead be a number based on the current collection's length.
			var newForm = choiceCH.attr('data-prototype').replace(/\$\$test_proQueChoice\$\$/g, choiceCH.children().length-1).replace(/\$\$test proquechoice\$\$/g, '');
	
		    // display the form in the page in an li, before the "add" link div 
		    var $newFormDiv = $('<div class="choice well"></div>').append(newForm);
		    $newChoiceLinkDiv.before($newFormDiv);
		
			// add a delete link to the new form
		    addFormDeleteChoiceLink($newFormDiv);
		}

    });

    // add the "add" anchor and div to  div
    questionCH.append($newQuestionLinkDiv);

    $addQuestionLink.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // add a new form (see next code block)
        addQuestionForm();
	
    });

});

function addQuestionForm() {
    // Get the data-prototype we explained earlier
    var prototype = questionCH.attr('data-prototype');
    // Replace '$$name$$' in the prototype's HTML to
    // instead be a number based on the current collection's length.
   	var newForm = prototype.replace(/\$\$test_proQuestion\$\$/g, questionCH.children().length-1).replace(/Test proquechoices/g, '<h3>Choices</h3>');

    // Display the form in the page in an li, before the "Add" link div 
    var $newFormDiv = $('<div class="question well"></div>').append(newForm);
    $newQuestionLinkDiv.before($newFormDiv);

	// add a delete link to the new form
    addFormDeleteQuestionLink($newFormDiv);

	// choice
	var choiceCH = $newFormDiv.find('div:regex(id,^test_problem_test_proQuestions_[0-9]+_test_proQueChoices$)');
	var $addChoiceLink = $('<a href="#" class="add_choice_link btn btn-mini btn-primary">Add choice</a>');
	var $newChoiceLinkDiv = $('<div class="clear"></div>').append($addChoiceLink);

    choiceCH.append($newChoiceLinkDiv);
    
	$addChoiceLink.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // add a new form (see next code block)
        addChoiceForm();
	
    });
    
	function addChoiceForm() {
	    // get the data-prototype we explained earlier
	    var prototype = choiceCH.attr('data-prototype');
	
	    // replace '$$name$$' in the prototype's html to
	    // instead be a number based on the current collection's length.
		var newForm = choiceCH.attr('data-prototype').replace(/\$\$test_proQueChoice\$\$/g, choiceCH.children().length-1).replace(/\$\$test proquechoice\$\$/g, '');

	    // display the form in the page in an li, before the "add" link div 
	    var $newFormDiv = $('<div class="choice well"></div>').append(newForm);
	    $newChoiceLinkDiv.before($newFormDiv);
	
		// add a delete link to the new form
	    addFormDeleteChoiceLink($newFormDiv);
	}
}

function addFormDeleteQuestionLink($formDiv) {
	var $removeFormA = $('<a href="#" class="btn btn-mini btn-danger">Delete question</a>');
	$formDiv.append($removeFormA);

	$removeFormA.on('click', function(e) {
		 // prevent the link from creating a "#" on the URL
		e.preventDefault();

		// remove the div for form
		$formDiv.remove();
	});
}

function addFormDeleteChoiceLink($formDiv) {
	var $removeFormA = $('<a href="#" class="btn btn-mini btn-danger">Delete choice</a>');
	$formDiv.append($removeFormA);

	$removeFormA.on('click', function(e) {
		 // prevent the link from creating a "#" on the URL
		e.preventDefault();

		// remove the div for form
		$formDiv.remove();
	});
}

}
