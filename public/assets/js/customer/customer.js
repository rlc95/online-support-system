$('#custmrview1,#custmrview2,#custmrview3').on('click',function(){
    $("#custmrmodl").modal("toggle");
});


$('#chcktck1,#chcktck2,#chcktck2').on('click',function(){
    $("#checkstsmdl").modal("toggle");
    $("#warning").hide();
});


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
  
            name: {
                  required: true,
              },
              
  
            email: {
                  required: true,
            },
  
            problm: {
                  required: true,
            },
  
            mobile: {
                  required: true,
              },
  
          },
          
          messages: {
  
            name: {
                  
                   required: "please enter name",
                    
              },
  
            problm: {
                  required: "please enter problem",
            },
  
            mobile: {
                  required: "Please enter mobile number",
                 
                  
              },

            email: {
                required: "Please enter email",
               
                
            },
  
          },
  
          errorPlacement: function(error, element) {
              if(element.hasClass('selectpicker')){
                  error.insertAfter(element.parent());
              } else {
                  error.insertAfter(element);
              }
          },
      
        
      });
  
  });
  
      
  
  $(function() {
    
      $('#submitcus').click(function(e) {
          if ($('#mfrm').valid()) {
            updateAjax();
          }
          else {
              
              return false;
          }
      });
      
  });


  function updateAjax() {
    $("#custmrmodl").modal("toggle");
    $.ajax({
        type: "POST",
        url: "/customer_store",
        async: false,
        data: { 
            name: $("#name").val(),
            email: $("#email").val(),
            mobile: $("#mobile").val(),
            remrk: $("#problm").val(),
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            
            if (response.status === 'success') {
                $("#success-modal").modal("toggle");
                var refNum = response.ref;
                var cusId = response.cuid;

                $('#done').on('click',function(){
                    
                    window.location.href = '/ticket_dashboard?ref=' + refNum + '&cuid=' + cusId;
                });

            }else{
                $("#alert-modal").modal("toggle");
            }

        },
    });
}




$(function() {
  
    //Start form bvalidation
    $("#refrnfrm").validate({
          onsubmit: false,
          onkeyup: false,
          onkeydown:false,
          onclick: false,
          onkeypress:false,
          onblur:true,
          ignore: [],
          rules: {
  
            refrnc: {
                  required: true,
              },
              
          },
          
          messages: {
  
            refrnc: {
                  
                   required: "please enter reference number",
                    
              },
  
          },
  
          errorPlacement: function(error, element) {
              if(element.hasClass('selectpicker')){
                  error.insertAfter(element.parent());
              } else {
                  error.insertAfter(element);
              }
          },
      
        
      });
  
  });


  $(function() {
    
    $('#chckbtn').click(function(e) {
        if ($('#refrnfrm').valid()) {
            console.log("dddddd");
          sendtcktAjax();
          //alert("Register Process was done successfully");
        }
        else {
            
            return false;
        }
    });
    
});



function sendtcktAjax() {
    
    $.ajax({
        type: "POST",
        url: "/customer_sts",
        async: false,
        data: { 
            refrnc: $("#refrnc").val(),
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            
            if (response.status === 'success') {
                $("#checkstsmdl").modal("toggle");
                
                var refNum = response.ref;
                var cusId = response.cuid;

                // Redirect to the relevant page with the data
                 window.location.href = '/ticket_dashboard?ref=' + refNum + '&cuid=' + cusId;
                
            }else{
                $("#warning").show();
            }

        },
    });
}