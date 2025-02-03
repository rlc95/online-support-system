$('.view').on('click',function(){
    //$("#custmrmodl").modal("toggle");
    var cid = $(this).data('id');
    var tid = $(this).data('tkct');
    console.log(cid);
    console.log(tid);

    $("#cusnm").html($(this).data('name'));
    $("#cusem").html($(this).data('email'))
    $("#cusmb").html($(this).data('mobi'));
    $("#cusrf").html($(this).data('ref'));

    $("#cusid").val(cid);
    $("#tikid").val(tid);
   


});


$(function() {
  
    //Start form bvalidation
    $("#tcktfrm").validate({
          onsubmit: false,
          onkeyup: false,
          onkeydown:false,
          onclick: false,
          onkeypress:false,
          onblur:true,
          ignore: [],
          rules: {
  
            reply: {
                  required: true,
              },
              
          },
          
          messages: {
  
            reply: {
                  
                   required: "please enter reply",
                    
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
    
    $('#rplybtn').click(function(e) {
        if ($('#tcktfrm').valid()) {
            console.log("dddddd");
          sendAjax();
          //alert("Register Process was done successfully");
        }
        else {
            
            return false;
        }
    });
    
});



function sendAjax() {
    
    $.ajax({
        type: "POST",
        url: "/reply_store",
        async: false,
        data: { 
            reply: $("#reply").val(),
            cusid: $("#cusid").val(),
            tikid: $("#tikid").val(),
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            
            if (response.status === 'success') {
                $("#Medium-modal").modal("toggle");
                
                // Redirect to the relevant page with the data
                window.location.href = '/UserView';
            }

        },
    });
}