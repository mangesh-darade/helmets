 
    $(document).ready(function () { 	
    	 $("#addTaxRate").submit(function (event) {
	    var _rate	= eval($('#addTaxRate #rate').val());
	    
	    var _total = 0;
		$('#addTaxRate .tax_attr_input ').each(function() {
			if($(this).val()){
			_total += parseFloat($(this).val(), 10) || 0;
			}
		
		    
		});
		
	    if(_rate > 0 && _total > 0 && _rate != _total){	    	 
	    	   alert('Please correct the tax classification');	
	    	   event.preventDefault();
	    	   return false;	
	    	 	
	    } 	

    	 });   	 
    	 
    	 
    	 $("#editTaxRate").submit(function (event) {
	    var _rate	= eval($('#editTaxRate #rate').val());
	    
	    var _total = 0;
		$('#editTaxRate .tax_attr_input ').each(function() {
			if($(this).val()){
			_total += parseFloat($(this).val(), 10) || 0;
			}
		    
		});	
	    if(_rate > 0 && _total > 0 && _rate != _total){	    	 
	    	   alert('Please correct the tax classification');	
	    	   event.preventDefault();
	    	   return false;	    	 	
	    } 	

    	 }); 
    });   
    
        /*---------------------------- Set Group Id  in  hidden  ----------------------------*/ 
        $('.numaric_input').keypress(function (event) {
         	validate(event) ;
        });
        
    function validate(evt) {
	  var theEvent = evt || window.event;
	  var key = theEvent.keyCode || theEvent.which;
	  key = String.fromCharCode( key );
	  var regex = /[0-9]|\./;
	  if( !regex.test(key) ) {
	    theEvent.returnValue = false;
	    if(theEvent.preventDefault) theEvent.preventDefault();
	  }
	}
	   