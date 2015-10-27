
    $(document).ready(function() {
    $(".button").click(function(v) {
        var $this = $(this); 
        var parentOffset = $this.offset(),
            cursorX      = v.pageX - parentOffset.left,
            cursorY      = v.pageY - parentOffset.top;

        $this.children(".ripple").remove();
        $this.append("<div class=\"ripple\"></div>");
        $this.children(".ripple").css({"left" : cursorX + "px", "top" : cursorY + "px"});

        $(".ripple").one("webkitAnimationEnd mozAnimationEnd oAnimationEnd\
                          oanimationend animationend", function() {
            $this.children(".ripple").remove();
        });
    });
});

    

