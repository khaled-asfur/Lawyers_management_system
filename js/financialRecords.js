/* global $, document  */
 

  $(function() {
	$("#input-prec").on('keyup', function() { // everytime keyup event
		var input2 = $(this).val(); // We take the input value
		if ( input2.length >= 2 ) { // Minimum characters = 2 (you can change)
			$('#match2').html('<img src="../design/loader-small.gif" />'); // Loader icon apprears in the <div id="match"></div>
			var dataFields = {'input2': input2}; // We pass input argument in Ajax
			$.ajax({
				type: "POST",
				url: "../php/autocomplete.php", // call the php file ajax/tuto-autocomplete.php
				data: dataFields, // Send dataFields var
				timeout: 3000,
				success: function(dataBack){ // If success
					$('#match2').html(dataBack); // Return data (UL list) and insert it in the <div id="match"></div>
					$('#matchList li').on('click', function() { // When click on an element in the list
						$('#input-prec').val($(this).text()); // Update the field with the new element
						$('#match2').text(''); // Clear the <div id="match"></div>
					});
				},
				error: function() { // if error
					$('#match2').text('No result found !');
				}
			});
		} else {
			$('#match2').text(''); // If less than 2 characters, clear the <div id="match"></div>
		}
	});
});
    

$(document).ready(function(){
  
    $('.view-button').click(function(){
        var doc=document.getElementById('show-details');
        $(doc).css('display','block');
    });
    
    $('#submit-type-of-financial').click(function(){
      var value=$('input[name=groupTypeFinancial]:checked').val() ;
        switch(value){
            case "money":
              var doc1=document.getElementsByClassName("prem-add-details");
                $(doc1).css('display','none');
              var doc1=document.getElementsByClassName("checks-add-details");
                $(doc1).css('display','none');
                break;
            case "checks":
              var doc1=document.getElementsByClassName("prem-add-details");
                $(doc1).css('display','none');
              
                var doc=document.getElementsByClassName("checks-add-details");
                $(doc).css('display','block');
                break;
            case "prem":
                var doc1=document.getElementsByClassName("checks-add-details");
                $(doc1).css('display','none');  
                var doc=document.getElementsByClassName("prem-add-details");
                $(doc).css('display','block');
                break;
        }
    });
    
    $('.add-checks-div').click(function(){
        $(".detail-checks:first").clone().insertAfter(".detail-checks:last");
    });
    $('.add-prem-div').click(function(){
        $(".prem-details:first").clone().insertAfter(".prem-details:last");
    });
    


    $('#btn-addNewFinancial').click(function(){
       var doc=document.getElementsByClassName('addNew-section') ;
        $(doc).css('display','block');
    });
});