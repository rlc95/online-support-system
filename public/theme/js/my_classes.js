//Number Only (intiger) >>mycls_numint
$(document).ready(function(){
	$(".mycls_numint").keydown(function(event) {
		// Allow: backspace, delete, tab, escape and enter
		if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 || 
				 // Allow: Ctrl+A
				(event.keyCode == 65 && event.ctrlKey === true) || 
				 // Allow: home, end, left, right
				(event.keyCode >= 35 && event.keyCode <= 39)) {
						 // let it happen, don't do anything
						 return;
		}else{
				// Ensure that it is a number and stop the keypress
				if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
						event.preventDefault();
				}
		}
	});
});

//Number Only (double) >>mycls_numdub
$(document).ready(function(){
	$(".mycls_numdub").keydown(function(event) {
		// Allow: backspace, delete, tab, escape, decimal and enter
		if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 || event.keyCode == 190 || event.keyCode == 110 ||
				 // Allow: Ctrl+A
				(event.keyCode == 65 && event.ctrlKey === true) || 
				 // Allow: home, end, left, right
				(event.keyCode >= 35 && event.keyCode <= 39)) {
						 // let it happen, don't do anything
						 return;
		}else{
				// Ensure that it is a number and stop the keypress
				if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
						event.preventDefault();
				}
		}
	});
});


// Restricts input for the given textbox to the given inputFilter.
function setInputFilter(textbox, inputFilter) {
  ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach(function(event) {
    textbox.addEventListener(event, function() {
      if (inputFilter(this.value)) {
        this.oldValue = this.value;
        this.oldSelectionStart = this.selectionStart;
        this.oldSelectionEnd = this.selectionEnd;
      } else if (this.hasOwnProperty("oldValue")) {
        this.value = this.oldValue;
        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
      }
    },false);
  });
}


/*
//Integer (positive only):
setInputFilter(document.getElementById("integer"), function(value) {return /^\d*$/.test(value); });

//Integer (positive and <= 500):
setInputFilter(document.getElementById("intLimitTextBox"), function(value) {
  return /^\d*$/.test(value) && (value === "" || parseInt(value) <= 500); });

//Integer (both positive and negative):
setInputFilter(document.getElementById("intTextBox"), function(value) {
  return /^-?\d*$/.test(value); });

//Floating point (use . or , as decimal separator):
setInputFilter(document.getElementById("floatTextBox"), function(value) {
  return /^-?\d*[.,]?\d*$/.test(value); });

//Currency (at most two decimal places):
setInputFilter(document.getElementById("currencyTextBox"), function(value) {
  return /^-?\d*[.,]?\d{0,2}$/.test(value); });

//A-Z only:
setInputFilter(document.getElementById("basicLatinTextBox"), function(value) {
  return /^[a-z]*$/i.test(value); });

//Latin letters only (most European languages):
setInputFilter(document.getElementById("extendedLatinTextBox"), function(value) {
  return /^[a-z\u00c0-\u024f]*$/i.test(value); });

//Hexadecimal:
setInputFilter(document.getElementById("hexTextBox"), function(value) {
	return /^[0-9a-f]*$/i.test(value); });
	*/
	
//Alert number
jQuery.validator.addMethod("alrtno",function(value,element){
	return this.optional(element) || /^[7][0-9]{8}$/.test(value);
},"Invalid SMS Alert Number");

//ID format
jQuery.validator.addMethod("idnfmt",function(value,element){
	idno=$('#idno').val();
	if (idno.length == 10){
			iddate=idno.substring(2, 5);
	}else{
			iddate=idno.substring(4, 7);
	}
return (this.optional(element) || (/^[0-9]{9}[vVxX]$/.test(value) &&  ( (iddate<367) || (iddate>500 && iddate<867) ) || (/^[0-9][vVxX]{12}$/.test(value) && ( (iddate>500 && iddate<867) || (iddate<367) )) ) );
},"Invalid NIC Number Format");