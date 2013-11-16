window.addEvent('domready', function() {

    $$('.radioClass').each(function(el2){el2.setStyle('opacity','0'); });
    var monimage = $$('.boutonRadio');
    monimage.each(function(el) {
        el.addEvent('click',function(){
            monimage.removeClass('coche');
            el.addClass('coche');
            var moninput = el.getFirst();
            $$('.radioClass').each(function(el2){el2.removeAttribute("checked","checked"); });
                moninput.setAttribute("checked","checked");
            });
        });
    });