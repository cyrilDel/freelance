     $('.dropdown-toggle').mouseover(function() {
         if( $('.btn-group').hasClass('open') ) $('.btn-group').removeClass('open');
         else $(this).dropdown('toggle');
     });