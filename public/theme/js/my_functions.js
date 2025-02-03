//Chech User Permission
function vlfrm(usid,pmid){
	var temp=0;
	$.ajax({
		type:"POST",
		url:"fun_val_usrfrm.php",
		async: false,
		data:"usid="+usid+"&pmid="+pmid,
		beforeSend: function(){$("body").css("cursor","wait");},
		success: function(msg){temp=msg; $("body").css("cursor","default");}
	});
	return temp;
}

//Data Encrip
function data_encyp(sodt){
	var temp=0;
	$.ajax({
		type:"POST",
		url:"st_encryption.php",
		async: false,
		data:"sosd="+sodt,
		success: function(msg){temp=msg;}
	});
	return temp;
}

//Make AutoID as string
function makeid_stg(lnth){
	var text = "";
	var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
	for(var i=0; i<lnth; i++){text+=possible.charAt(Math.floor(Math.random()*possible.length));}
	return text;
}

//Make AutoID as Intiger
function makeid_int(){
	var text=(Math.floor(Math.random()*(9999-1000+1))+1000);
	return text;
}

//Number Format
function number_format(number,decimals,dec_point,thousands_sep){
  number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function(n, prec) {
      var k = Math.pow(10, prec);
      return '' + (Math.round(n * k) / k)
        .toFixed(prec);
    };
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n))
    .split('.');
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || '')
    .length < prec) {
    s[1] = s[1] || '';
    s[1] += new Array(prec - s[1].length + 1)
      .join('0');
  }
  return s.join(dec);
}