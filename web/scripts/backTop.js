
$('body').append('<a href="#top" class="top_link" title="Revenir en haut de page"><img src="img/haut.jpg" style="width: 100%; height: 100%;" /></a>');
			$('.top_link').css({
				'position':'fixed',
				'right':'30px',
				'bottom'	:'50px',
				'display':'none',
				'height':'10%',
				'color':'#20202A',
				'width':'5%',


				'border':'solid 2px #E74C3C',
				'opacity':'0.9',
				'z-index':'2000'
			});
			$(window).scroll(function(){
				posScroll = $(document).scrollTop();
				if(posScroll >=550) 
				$('.top_link').fadeIn(600);
				else
				$('.top_link').fadeOut(600);
			});
		