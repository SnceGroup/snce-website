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

ezie.gui.opts_window = function() {
    var jWindow = null;
    var initialized = false;

    // returns the jQuery Dom element corresponding to
    // the window
    var getJWindow = function() {
        return jWindow;
    };

    var setBindsForSliders = function () {
        $.each(ezie.gui.config.bindings.opts_items_sliders, function() {
            var config = this;
            var item = $(config.selector);

            item.slider({
                min:config.min,
                max:config.max,
                step:config.step,
                slide:function(event, ui) {
                    config.slide(ui.value);
                }
            });
        });
    };

    var setBindsForButtons = function () {
        $.each(ezie.gui.config.bindings.opts_items_buttons, function() {
            var config = this;
            var item = $(config.selector);
            item.click(function() {
                if (!ezie.gui.eziegui.getInstance().isFrozen()) {
                    config.click(this);
                }
                return false;
            });
        });
    };

    var setBinds = function() {
        setBindsForSliders();
        setBindsForButtons();

        $('#optsSelect input[type="text"]').keyup(function(e) {
            ezie.gui.config.bind.tool_select_method( e );
            return true;
        });

    };

    var init = function() {
        setBinds();
        jWindow = $("#sideBar");
        hideOptions();
        initialized = true;
    };

    var switchjWindow = function() {
        if (jWindow.is("#sideBar"))
            jWindow = $("#ezieOptsWindow");
        else
            jWindow = $("#sideBar");
    }

    var freeze = function() {
        $("button").freeze();
    }
    var unfreeze = function() {
        $("button").unfreeze();
    }

    var hide = function () {
        if (initialized)
            jWindow.fadeOut('fast');
    };

    var hideOptions = function() {
        jWindow.find(".opts").hide();
    };

    var showOpts = function(id) {
        jWindow.find(".opts").hide();
        jWindow.find(id).fadeIn();
    };

    var show = function () {
        if (!initialized) {
            init();
        }
        jWindow.fadeIn('fast');
        showOpts("#optsZoom");
    }

    var updateImage = function() {
        var currentImage = ezie.history().current();

        img = $("<img></img>").attr("src", currentImage.thumbnail + "?" + currentImage.mixed)
        .attr("alt", "");

        jWindow.find("#miniature").html(img);
    }

    return {
        jWindow:getJWindow,
        show:show,
        hide:hide,
        showOpts:showOpts,
        switchjWindow:switchjWindow,
        updateImage:updateImage,
        freeze:freeze,
        unfreeze:unfreeze
    };
};
