// JavaScript Document


function moveScroller() {
    var move = function() {
        var st = jQuery(window).scrollTop();
        var ot = jQuery("#scroller-anchor").offset().top;
        var s = jQuery("#scroller");
        if(st > ot) {
            s.css({
                position: "fixed",
                top: "0px"
            });
        } else {
            if(st <= ot) {
                s.css({
                    position: "relative",
                    top: ""
                });
            }
        }
    };
    jQuery(window).scroll(move);
    move();
}

