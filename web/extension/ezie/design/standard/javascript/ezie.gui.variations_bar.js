// ## BEGIN COPYRIGHT, LICENSE AND WARRANTY NOTICE ##
// SOFTWARE NAME: eZ Image Editor extension for eZ Publish
// SOFTWARE RELEASE: 5.2.0
// COPYRIGHT NOTICE: Copyright (C) 1999-2013 eZ Systems AS
// SOFTWARE LICENSE: eZ Business Use License Agreement eZ BUL Version 2.1
// NOTICE: >
//   This source file is part of the eZ Publish CMS and is
//   licensed under the terms and conditions of the eZ Business Use
//   License v2.1 (eZ BUL).
// 
//   A copy of the eZ BUL was included with the software. If the
//   license is missing, request a copy of the license via email
//   at license@ez.no or via postal mail at
//  	Attn: Licensing Dept. eZ Systems AS, Klostergata 30, N-3732 Skien, Norway
// 
//   IMPORTANT: THE SOFTWARE IS LICENSED, NOT SOLD. ADDITIONALLY, THE
//   SOFTWARE IS LICENSED "AS IS," WITHOUT ANY WARRANTIES WHATSOEVER.
//   READ THE eZ BUL BEFORE USING, INSTALLING OR MODIFYING THE SOFTWARE.

// ## END COPYRIGHT, LICENSE AND WARRANTY NOTICE ##

ezie.gui.variations_bar = function() {
    var jWindow = null;
    var initialized = false;

    // returns the jQuery Dom element corresponding to
    // the window
    var getJWindow = function() {
        return jWindow;
    };

    var resizeLi = function(h) {
        $("#ezieVariations li").css({
            'height':  h,
            'width': h
        });
    };


    var setBinds = function () {
        $.each(ezie.gui.config.bindings.variations_bar, function() {
            var config = this;
            item = $(config.selector);

            item.click(function () {
                config.click();
                return false;
            });

            // TODO: decide whether to remove this or add a bottom bar
            if (item.attr('title').length > 0) {
                var p = item.closest('div.ezieBox').find('div.bottomBarContent p')
                var oldcontent = p.html()

                item.hover(function (){
                    p.html($(this).attr('title'))
                }, function () {
                    p.html(oldcontent)
                });
            }

        })

    };

    var initMisc = function() {
        var prev = 0;

        $("#ezieVariations").hide();

        $("#ezieVariationsBar").resizable({
            handles:'n',
            maxHeight: 170,
            minHeight: 5,
            resize: function() {
                var h = ($(this).height() - 40);
                if (prev > 10 && h <= 10) {
                    $("#ezieVariations").hide();
                    prev = h;
                } else if (prev <= 10 && h > 10) {
                    $("#ezieVariations").fadeIn("slow");
                    prev = h;
                }
                resizeLi(h);
            }
        });

    }

    var init = function() {
        setBinds();
        initMisc();
        jWindow = $("#ezieVariationsBar");
    };

    var hide = function () {
        jWindow.fadeOut('fast');
    };

    var show = function () {
        if (!initialized) {
            init();

            initialized = true;
        }
        jWindow.fadeIn('fast');
    }

    return {
        jWindow:getJWindow,
        show:show,
        hide:hide
    };
};
