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

ezie.gui.config.bind.tool_rotation_slider_api = null;

ezie.gui.config.bind.tool_rotation_show = function() {
    $.log('starting rotation');
    ezie.gui.eziegui.getInstance().opts().showOpts("#optsRotation");

    if (ezie.gui.config.bind.tool_rotation_slider_api == null) {
        $('#circularSlider').circularslider({
            clockwise: true,
            zeroPos: 'top',
            giveMeTheValuePlease: function(v) {
                ezie.gui.config.bind.tool_rotation_slide(v);
            }
        },
        function(api) {
            ezie.gui.config.bind.tool_rotation_slider_api = api;
            $("#optsRotation input[name='angle']:first").keyup(function(){
                $.log('kikou on tapote');
                if ($(this).val() >= 0 && $(this).val() <= 359)
                    ezie.gui.config.bind.tool_rotation_slider_api.set($(this).val());
                else
                    ezie.gui.config.bind.tool_rotation_slider_api.set(0);

                $(this).val(ezie.gui.config.bind.tool_rotation_slider_api.get());
            });

        });
    }
}

ezie.gui.config.bind.tool_rotation_submit = function() {
    var angle = $("#optsRotation input[name='angle']").val();
    var color = $("#optsRotation input[name='color']").val();


    ezie.ezconnect.connect.instance().action({
        'action': 'tool_rotation',
        'data': {
            'angle':angle,
            'color':color,
            'clockwise': "yes"
        }
    });

    $.log("rotation value send : " + angle);
}

ezie.gui.config.tool_rotation = function(angle) {
    var color = $("#optsRotation input[name='color']").val();

    ezie.ezconnect.connect.instance().action({
        'action': 'tool_rotation',
        'data': {
            'angle':angle,
            'color':color
        }
    });

    $.log("rotation value send : " + angle);
}

ezie.gui.config.bind.tool_rotation_slide = function(value) {
    $("#optsRotation input[name='angle']").val(value);
}

ezie.gui.config.bind.tool_rotation_preview = function() {
    var angle = $("#optsRotation .slider:first").slider("value");
    $("#optsRotation input[name='angle']").val(angle);
    $.log("rotation preview : " + angle);
}

ezie.gui.config.bind.tool_rotation_preset_value = function(a) {
    $.log('setting a presetted value');

    if (ezie.gui.config.bind.tool_rotation_slider_api != null) {
        var v = $(a).html();
        v = v.substr(0, v.length - 1);
        $.log('valeur en cliquant pliz = ' + v);
        ezie.gui.config.bind.tool_rotation_slider_api.set(v);
    }
    return false;
}