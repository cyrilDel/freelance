

function bigger()
{		
	$(".imgProfil img").animate( {
			"width":"100%",
		 	"height":"135%"
	}, 2500);
}
function smaller()
{		
	$(".imgProfil img").animate({
		"width":"70%",
	 	"height":"90%"
	}, 2500);
}
$(".imgProfil img").on("click", function()
{
	if ($(this).data('big') == true)
	{
		$(this).data('big', false);
		smaller();
	}
	else
	{
		$(this).data('big', true);
		bigger();
	}
});


function biggerqr()
{		
	$(".qr").animate({
			"width":"35%",
		 	"height":"35%"
	}, 2500);
}
function smallerqr()
{		
	$(".qr").animate({
		"width":"15%",
	 	"height":"15%"
	}, 2500);
}
$(".qr").on("click", function()
{
	if ($(this).data('big') == true)
	{
		$(this).data('big', false);
		biggerqr();
	}
	else
	{
		$(this).data('big', true);
		smallerqr();
	}
});

