
$('#addusr').on('click', function () {
    $('#aduser').show();
    $('#main').hide();
    $('#usr').hide();
    $('#surv').hide();
    $('#adcus').hide();
   // $('#datamgrtn').hide();
})

$('#dshbrd').on('click', function () {
    $('#aduser').hide();
    $('#main').show();
    $('#usr').hide();
    $('#surv').hide();
    $('#adcus').hide();
    $('#datamgrtn').hide();
})

$('#usr').on('click', function () {
  $('#aduser').hide();
  $('#main').hide();
  $('#usr').show();
  $('#adcus').hide();
  $('#datamgrtn').hide();
 $('#surv').hide();
})


$('#addcustmr').on('click', function () {
  $('#aduser').hide();
  $('#main').hide();
  $('#usr').hide();
  $('#adcus').show();
  $('#datamgrtn').hide();
 $('#surv').hide();
})

$('#datamigtn').on('click', function () {
  $('#aduser').hide();
  $('#main').hide();
  $('#usr').hide();
  $('#datamgrtn').show();
  $('#surv').hide();
  $('#adcus').hide();
})


$('#survy').on('click', function () {
  $('#aduser').hide();
  $('#main').hide();
  $('#usr').hide();
  $('#adcus').hide();
  $('#datamgrtn').hide();
  $('#surv').show();
})


$(function() {
  
  //Start mfrm form bvalidation
  $("#mfrm").validate({
        onsubmit: false,
        onkeyup: false,
        onkeydown:false,
        onclick: false,
        onkeypress:false,
        onblur:true,
        ignore: [],
        rules: {

          InputName: {
                required: true,
                
                
            },
            
            InputID: {
                required: true,     
               //IDCheck:true,
               //IDCheckexist:true,
              //GenerateDOB:true,
             // ageCount:true
              
            },

            InputEmail: {
                required: true,
               
                
            },

            InputAddrs: {
                required: true,
               
                
            },

            inputContact: {
                required: true,
                //TPNCheck:true
                
                
            },

            InputOcuptn: {
                required: true,
               
                
            },

            Image: {
                required: true,
                //ImageCheck:true
                
            },

        },
        
        messages: {

          InputName: {
                
                 required: "please enter name",
                  
            },

            InputID: {
                required: "please enter ID number",
               
                
            },

            InputAddrs: {
                required: "please enter your address",
                
                
            },

            InputAddrs: {
                required: "please enter your address",
                
                
            },

            inputContact: {
                required: "Please enter contact number",
               
                
            },

            InputOcuptn: {
                required: "please enter your occupation",
                
                
            },

            Image: {
                required: "Please choose your picture",
               
            },

        },
        
        errorPlacement: function(error, element) {
            if(element.hasClass('selectpicker')){
                error.insertAfter(element.parent());
            }
            else {
                error.insertAfter(element);
            }
        },
    
      
    });

});

    

$(function() {

    $('#submitbtn').click(function(e) {
        if ($('#mfrm').valid()) {
            
            document.forms["mfrm"].submit();
            alert("Register Process was done successfully");
        }
        else {
            
            return false;
        }
    });
    
});





//survey form

$(function() {
  
  //Start mfrm form bvalidation
  $("#survyfrm").validate({
        onsubmit: false,
        onkeyup: false,
        onkeydown:false,
        onclick: false,
        onkeypress:false,
        onblur:true,
        ignore: [],
        rules: {

          fname: {
                required: true,
                
                
            },
            
            svyage: {
                required: true,     
               //IDCheck:true,
               //IDCheckexist:true,
              //GenerateDOB:true,
             // ageCount:true
              
            },

            svyemail: {
                required: true,
               
                
            },

            optradio: {
                required: true,
               
                
            },

            favorite: {
                required: true,
                //TPNCheck:true
                
                
            },

            InputOcuptn: {
                required: true,
               
                
            },

            Image: {
                required: true,
                //ImageCheck:true
                
            },

        },
        
        messages: {

          fname: {
                
              required: "please enter name",
                  
            },

            svyemail: {
                required: "please enter your email",
               
                
            },

            svyage: {
                required: "please enter your address",
                
                
            },

            optradio: {
                required: "please enter your gender",
                
                
            },

            favorite: {
                required: "Please select",
               
                
            },

            InputOcuptn: {
                required: "please enter your occupation",
                
                
            },

            Image: {
                required: "Please choose your picture",
               
            },

        },
        

        errorPlacement: function(error, element) {
            if(element.hasClass('selectpicker')){
                error.insertAfter(element.parent());
            }else if(element.hasClass('frmchck')){
              error.insertAfter(element.parent());
            } else if(element.hasClass('custom-select')){
              error.insertAfter(element.parent());
            }
            else {
                error.insertAfter(element);
            }
            
        },
    
      
    });

});


$(function() {

  $('#survysubbtn').click(function(e) {
      
      console.log('music', $('#music').val());
 
      if ($('#survyfrm').valid()) {
          
          document.forms["survyfrm"].submit();
          alert("Register Process was done successfully");
      }
      else {
          
          return false;
      }
  });
  
});


/*
$("#addNewField").on("click", function (e) {




});
*/


$(function() {

  $("#custm").validate({
    onsubmit: false,
    onkeyup: false,
    onkeydown:false,
    onclick: false,
    onkeypress:false,
    onblur:true,
    ignore: [],
    rules: {

      InputName: {
            required: true,
            
            
        },
        
        InputEmail: {
            required: true,     
        },

    },
    
    messages: {

      InputName: {
            
          required: "please enter name",
              
        },

        InputEmail: {
            required: "please enter your email",
           
            
        },

    },
    

    errorPlacement: function(error, element) {
        if(element.hasClass('selectpicker')){
            error.insertAfter(element.parent());
        }else if(element.hasClass('frmchck')){
          error.insertAfter(element.parent());
        } else if(element.hasClass('custom-select')){
          error.insertAfter(element.parent());
        }
        else {
            error.insertAfter(element);
        }
        
    },

  
});


});






















