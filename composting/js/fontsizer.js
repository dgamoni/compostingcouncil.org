/*
FontSizer v2.1mod
Javascript to dynamically change font sizes on a web page.
Coded by Phil Nash of www.unintentionallyblank.co.uk
Cookies script courtesy of http://www.quirksmode.org/js/cookies.html
Measuring the current font size courtesy of http://www.alistapart.com/articles/fontresizing

-- Modified 20080206
* Removed JS link creation
* Replaced addDOMLoadEvent with jQuery call
* Call init with jQuery selector of parent to size
-- Marcus Campbell, Tugboat Media
*/

var fS={
    ele:  null,
    iFS:  null,
    cFS:  null,
    init: function (ele) {
        fS.ele = ele;
        if (UBCookie.read("fS")) {
            var sizes = UBCookie.read("fS").split(",");
            fS.iFS = sizes[0] * 1;
            fS.cFS = sizes[1] * 1;
            fS.setBodySize();
        } else {
            var el = document.createElement('span');
            el.innerHTML = "&nbsp;";
            el.setAttribute("style", "position:absolute;left:-9999px;line-height:1em;");
            document.body.insertBefore(el, document.body.firstChild);
            fS.iFS = el.offsetHeight / 16;
            fS.cFS = fS.iFS;
            UBCookie.create("fS", fS.iFS + "," + fS.cFS, 30);
        }
    },
    incFS: function () {
        fS.cFS = fS.cFS * 1.25;
        fS.setBodySize();
        return false;
    },
    decFS: function () {
        fS.cFS = fS.cFS * 0.8;
        fS.setBodySize();
        return false;
    },
    rFS: function () {
        fS.cFS = fS.iFS;
        fS.setBodySize();
        return false;
    },
    setBodySize: function() {
        jQuery(fS.ele).css("font-size", fS.cFS + "em");
        UBCookie.create("fS", fS.iFS + "," + fS.cFS, 30);
    }
}

var UBCookie={
    create: function (name,value,days) {
        if (days) {
            var date = new Date();
            date.setTime(date.getTime()+(days*24*60*60*1000));
            var expires = "; expires="+date.toGMTString();
        } else { var expires = ""; }
        document.cookie = name+"="+value+expires+"; path=/";
    },
    read: function (name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for(var i=0;i < ca.length;i++) {
            var c = ca[i];
            while (c.charAt(0)==' ') c = c.substring(1,c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
        }
        return null;
    },
    erase: function(name) { createCookie(name,"",-1); }
}

jQuery(function() { fS.init("#main"); });