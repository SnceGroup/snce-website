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

ezie.gui.config.bind.filter_brightness = function() {
    $.log('starting brightness filter');

    ezie.gui.eziegui.getInstance().opts().showOpts("#optsBrightness");
}

ezie.gui.config.bind.filter_brightness_slide = function(val) {
    $('#optsBrightness input[name="optsBrightnessValue"]:first').val(val);
}

ezie.gui.config.bind.filter_brightness_submit = function() {
    var val = $('#optsBrightness input[name="optsBrightnessValue"]:first').val();

    $.log('sending brightness action');

    ezie.ezconnect.connect.instance().action({
        'action':   'filter_brightness',
        'data':     {
            'value':    val
        }
    });
}