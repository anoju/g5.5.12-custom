
// 새로운 모달창


function Get_AllButton(close_use , DivID){

	if ($('#AllButtonPOP').length) { // 모달창이 존재하면 엔터를 눌러도 더이상 모달창을 열지 않게
		return false;
	}



	$("<div id='AllButtonPOP'><div class='black-overlay'></div><div id='Modal_Cont'><div id='white_content'></div></div></div>").hide().prependTo("body").fadeIn(300);


	$("#white_content").html( $("#"+DivID).html() );

	$("#Modal_Cont").addClass("plus");

	if(close_use == "CLOSE_YES") {

		$(document).on( "click", "#CloseSpanX, #AllButtonPOP .black-overlay", function(e){

			$("#Modal_Cont").fadeOut("10");
			$("#Modal_Cont").removeClass("plus");
			$("#Modal_Cont").addClass("minus");

			$("#AllButtonPOP").fadeOut("1000", function() {
			    $(this).remove();
		    });


		});
	}

	if(close_use == "CLOSE_NO") {

		$(document).on( "click", "#CloseSpanX", function(e){

			$("#Modal_Cont").fadeOut("10");
			$("#Modal_Cont").removeClass("plus");
			$("#Modal_Cont").addClass("minus");

			$("#AllButtonPOP").fadeOut("1000", function() {
			    $(this).remove();
		    });

		});
	}
}


