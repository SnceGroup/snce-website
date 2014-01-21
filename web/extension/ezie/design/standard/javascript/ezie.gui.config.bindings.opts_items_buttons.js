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

ezie.gui.config.bindings.opts_items_buttons = [
{
    'selector':     '#optsRotation button',
    'click':        ezie.gui.config.bind.tool_rotation_submit
},
{
    'selector':     '#selectAngle .preset',
    'click':        ezie.gui.config.bind.tool_rotation_preset_value
},
{
    'selector':     '#optsZoom #zoomIn',
    'click':        ezie.gui.config.tool_zoom_in
},
{
    'selector':  '#optsZoom #zoomOut',
    'click':        ezie.gui.config.tool_zoom_out
},
{
    'selector':     '#optsZoom #fitOnScreen',
    'click':        ezie.gui.config.tool_zoom_fit_on_screen
},
{
    'selector':     '#optsZoom #actualPixels',
    'click':        ezie.gui.config.tool_zoom_actual_pixels
},
{
    'selector':    '#optsWatermarks .ezie-watermark-image',
    'click':           ezie.gui.config.bind.tool_place_watermark
},
{
    'selector':     '#optsWatermarks button.submit',
    'click':           ezie.gui.config.bind.tool_watermark_submit
},
{
    'selector':     '#optsWatermarksPositions button',
    'click':        ezie.gui.config.bind.tool_watermark_set_pos
},
{
    'selector':     '#optsContrast button.submit',
    'click':        ezie.gui.config.bind.filter_contrast_submit
},
{
    'selector':     '#optsBrightness button.submit',
    'click':        ezie.gui.config.bind.filter_brightness_submit
},
{
    'selector':     '#optsSelect li',
    'click':        ezie.gui.config.bind.tool_select_method
},
{
    'selector':     '#optsCrop button.submit',
    'click':        ezie.gui.config.bind.tool_crop_perform
}
];
