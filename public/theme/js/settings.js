$(document).ready(function(){
    //Redirect Link
    $('.prminf').click(function(e){
        //e.preventDefault();
        if($(this).attr('href')=='#'){
            $('#info_msgcontent').html("Access Forbidden! Sorry, You don't have permission to access this form or report requested by you. It is either read-protected or not readable by the system administrator. Please contact your system administrator for more details about this problem. Sorry for the inconvenience.");
            $('#message-box-info').toggleClass("open");
            return false;
        }
    });

    //Redirect Link with ID
    $('.rdrctwid').click(function(e){
        var lurl=$(this).attr('name');
        var rfid=$(this).attr('id');
        if(lurl=='#'){
            document.getElementById('info_msgcontent').innerHTML="Access Forbidden! Sorry, You don't have permission to access this form or report requested by you. It is either read-protected or not readable by the system administrator. Please contact your system administrator for more details about this problem. Sorry for the inconvenience.";
            $('#message-box-info').toggleClass("open");
            return false;
        }else{
            $(".loader").fadeIn("fast");
            $.redirect(lurl,{"rfid":rfid},"POST","_self");
        }
    });

    //Redirect Link with ID to popup window
    $('.rdrctwdnw').click(function(e){
        var lurl=$(this).attr('name');
        var token=$(this).attr('id');
        if(token=='#'){
            document.getElementById('info_msgcontent').innerHTML="Access Forbidden! Sorry, You don't have permission to access this form or report requested by you. It is either read-protected or not readable by the system administrator. Please contact your system administrator for more details about this problem. Sorry for the inconvenience.";
            $('#message-box-info').toggleClass("open");
            return false;
        }else{
            var panel=$(this).parents(".panel");
            panel_refresh(panel);
            setTimeout(function(){panel_refresh(panel);},3000);
            var w = openWindowWithGet(lurl,{"token":token});
        }
    });

    //Redirect Link with ID to popup window
    $('.rdrctwdnwpost').click(function(e){
        var lurl=$(this).attr('name');
        var csrf =$(this).attr('data-csrf');
        var rfid=$(this).attr('id');
        if(lurl=='#'){
            document.getElementById('info_msgcontent').innerHTML="Access Forbidden! Sorry, You don't have permission to access this form or report requested by you. It is either read-protected or not readable by the system administrator. Please contact your system administrator for more details about this problem. Sorry for the inconvenience.";
            $('#message-box-info').toggleClass("open");
            return false;
        }else{
            var panel=$(this).parents(".panel");
            panel_refresh(panel);
            setTimeout(function(){panel_refresh(panel);},3000);
            var w = openWindowWithPost(lurl,{"rfid":rfid,"_token":csrf});
        }
    });

		//Page Loading Process
		$(window).load(function(){
			$(".loader").fadeOut("slow");
			$("body").css("cursor","default");
		});

		//Press enter key focus next element
		$('input,textarea,select').not($(":button")).keypress(function(evt){
			if(evt.keyCode==13){
				iname=$(this).val();
				if(iname!=='Submit'){
					var fields=$(this).parents('form:eq(0),body').find('input:visible:not([disabled],[readonly]),textarea,select:visible:not([disabled],[readonly])');
					var index=fields.index(this);
					if(index>-1 && (index+1)<fields.length){
						fields.eq(index+1).focus();
					}
					return false;
				}
			}
		});

    /* Default settings */
    var theme_settings = {
        st_head_fixed: 1,
        st_sb_fixed: 1,
        st_sb_scroll: 1,
        st_sb_right: 0,
        st_sb_custom: 0,
        st_sb_toggled: 0,
        st_layout_boxed: 0
    };
    /* End Default settings */

    set_settings(theme_settings,false);

    $(".theme-settings input").on("ifClicked",function(){

        var input   = $(this);

        if(input.attr("name") != 'st_layout_boxed'){

            if(!input.prop("checked")){
                theme_settings[input.attr("name")] = input.val();
            }else{
                theme_settings[input.attr("name")] = 0;
            }

        }else{
            theme_settings[input.attr("name")] = input.val();
        }

        /* Rules */
        if(input.attr("name") === 'st_sb_fixed'){
            if(theme_settings.st_sb_fixed == 1){
                theme_settings.st_sb_scroll = 1;
            }else{
                theme_settings.st_sb_scroll = 0;
            }
        }

        if(input.attr("name") === 'st_sb_scroll'){
            if(theme_settings.st_sb_scroll == 1 && theme_settings.st_layout_boxed == 0){
                theme_settings.st_sb_fixed = 1;
            }else if(theme_settings.st_sb_scroll == 1 && theme_settings.st_layout_boxed == 1){
                theme_settings.st_sb_fixed = -1;
            }else if(theme_settings.st_sb_scroll == 0 && theme_settings.st_layout_boxed == 1){
                theme_settings.st_sb_fixed = -1;
            }else{
                theme_settings.st_sb_fixed = 0;
            }
        }

        if(input.attr("name") === 'st_layout_boxed'){
            if(theme_settings.st_layout_boxed == 1){
                theme_settings.st_head_fixed    = -1;
                theme_settings.st_sb_fixed      = -1;
                theme_settings.st_sb_scroll     = 1;

                $("#ts-wallpapers").show();
            }else{
                theme_settings.st_head_fixed    = 0;
                theme_settings.st_sb_fixed      = 1;
                theme_settings.st_sb_scroll     = 1;

                $("#ts-wallpapers").hide();
            }
        }
        /* End Rules */

        set_settings(theme_settings,input.attr("name"));
    });

    /* Change Theme */
    $(".ts-themes a[data-theme]").click(function(){
        $(".ts-themes a[data-theme]").removeClass("active");
        $(this).addClass("active");
        $("#theme").attr("href",$(this).data("theme"));
        return false;
    });
    /* END Change Theme */

    /* Change Wallpaper */
    $(".ts-themes a[data-wall]").click(function(){
        $(".ts-themes a[data-wall]").removeClass("active");
        $(this).addClass("active");
        $(".page-container-boxed").removeClass("wall_1 wall_2 wall_3 wall_4 wall_5 wall_6 wall_7 wall_8 wall_9 wall_10").addClass($(this).data("wall"));
        return false;
    });
    /* END Change Wallpaper */

    /* Open/Hide Settings */
    $(".ts-button").on("click",function(){
        $(".theme-settings").toggleClass("active");
    });
    /* End open/hide settings */
});
function set_settings(theme_settings,option){

    /* Start Header Fixed */
    if(theme_settings.st_head_fixed == 1)
        $(".page-container").addClass("page-navigation-top-fixed");
    else
        $(".page-container").removeClass("page-navigation-top-fixed");
    /* END Header Fixed */

    /* Start Sidebar Fixed */
    if(theme_settings.st_sb_fixed == 1){
        $(".page-sidebar").addClass("page-sidebar-fixed");
    }else
        $(".page-sidebar").removeClass("page-sidebar-fixed");
    /* END Sidebar Fixed */

    /* Start Sidebar Fixed */
    if(theme_settings.st_sb_scroll == 1){
        $(".page-sidebar").addClass("scroll").mCustomScrollbar("update");
    }else
        $(".page-sidebar").removeClass("scroll").css("height","").mCustomScrollbar("disable",true);

    /* END Sidebar Fixed */

    /* Start Right Sidebar */
    if(theme_settings.st_sb_right == 1)
        $(".page-container").addClass("page-mode-rtl");
    else
        $(".page-container").removeClass("page-mode-rtl");
    /* END Right Sidebar */

    /* Start Custom Sidebar */
    if(theme_settings.st_sb_custom == 1)
        $(".page-sidebar .x-navigation").addClass("x-navigation-custom");
    else
        $(".page-sidebar .x-navigation").removeClass("x-navigation-custom");
    /* END Custom Sidebar */

    /* Start Custom Sidebar */
    if(option && option === 'st_sb_toggled'){
        if(theme_settings.st_sb_toggled == 1){
            $(".page-container").addClass("page-navigation-toggled");
            $(".x-navigation-minimize").trigger("click");
        }else{
            $(".page-container").removeClass("page-navigation-toggled");
            $(".x-navigation-minimize").trigger("click");
        }
    }
    /* END Custom Sidebar */

    /* Start Layout Boxed */
    if(theme_settings.st_layout_boxed == 1)
        $("body").addClass("page-container-boxed");
    else
        $("body").removeClass("page-container-boxed");
    /* END Layout Boxed */

    /* Set states for options */
    if(option === false || option === 'st_layout_boxed' || option === 'st_sb_fixed' || option === 'st_sb_scroll'){
        for(option in theme_settings){
            set_settings_checkbox(option,theme_settings[option]);
        }
    }
    /* End states for options */

    /* Call resize window */
    //$(window).resize();
    /* End call resize window */
}
function set_settings_checkbox(name,value){

    if(name == 'st_layout_boxed'){

        $(".theme-settings").find("input[name="+name+"]").prop("checked",false).parent("div").removeClass("checked");

        var input = $(".theme-settings").find("input[name="+name+"][value="+value+"]");

        input.prop("checked",true);
        input.parent("div").addClass("checked");

    }else{

        var input = $(".theme-settings").find("input[name="+name+"]");

        input.prop("disabled",false);
        input.parent("div").removeClass("disabled").parent(".check").removeClass("disabled");

        if(value === 1){
            input.prop("checked",true);
            input.parent("div").addClass("checked");
        }
        if(value === 0){
            input.prop("checked",false);
            input.parent("div").removeClass("checked");
        }
        if(value === -1){
            input.prop("checked",false);
            input.parent("div").removeClass("checked");
            input.prop("disabled",true);
            input.parent("div").addClass("disabled").parent(".check").addClass("disabled");
        }

    }
}
function openWindowWithPost(url,data){
	var form = document.createElement("form");
	form.target = "wndw";
	form.method = "POST";
	form.action = url;
	form.style.display = "none";
	for (var key in data){
		var input = document.createElement("input");
		input.type = "hidden";
		input.name = key;
		input.value = data[key];
		form.appendChild(input);
	}
	document.body.appendChild(form);
	wndw = window.open("","wndw","status=0,title=1,location=no,width=1000,height=900,scrollbars=1");
	if(wndw){form.submit();}
	document.body.removeChild(form);
}
function openWindowWithGet(url,data){
	var form = document.createElement("form");
	form.target = "wndw";
	form.method = "GET";
	form.action = url;
	form.style.display = "none";
	for (var key in data){
		var input = document.createElement("input");
		input.type = "hidden";
		input.name = key;
		input.value = data[key];
		form.appendChild(input);
	}
	document.body.appendChild(form);
	wndw = window.open("","wndw","status=0,title=1,location=no,width=1000,height=900,scrollbars=1");
	if(wndw){form.submit();}
	document.body.removeChild(form);
}
//Search ID or Acc Numenr
$('#sarhidoac').keypress(function(e){
    if(e.keyCode=='13'){
        var srsc = $(this).val();
        var srch = $(this).attr('srch');
        $.ajax({
            type        : "POST",
            url         : srch,
            data        : {"srsc":srsc},
            headers     : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            beforeSend  : function(){$("body").css("cursor","wait");},
            success     : function(msg){
                            $("body").css("cursor","default");
                            if(msg=='0'){
                                document.getElementById('wrng_msgcontent').innerHTML="Data Error!<br>Error searching value, Please enter ID number or Account number correctly and continue again.";
                                $('#message-box-warning').toggleClass("open");
                            }else{
                                $(".loader").fadeIn("fast");
                                $.redirect("clnt_srch_view",{"token":msg },"GET","_self");
                            }
                        },
            error       : function(){ $("body").css("cursor","default"); console.log("Error");  }
        });
        return false;
    }
});
