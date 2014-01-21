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

ezie.gui.config.bindings.tools_window = [
    {
        'selector':     '#ezie_select',
        'click':        ezie.gui.config.bind.tool_select,
        'shortcut':     's'
    },
    {
        'selector':     '#ezie_undo',
        'click':        ezie.gui.config.bind.tool_undo,
        'shortcut':     'ctrl+z'
    },
    {
        'selector':     '#ezie_redo',
        'click':        ezie.gui.config.bind.tool_redo,
        'shortcut':     'ctrl+y'
    },
    {
        'selector':     '#ezie_zoom',
        'click':        ezie.gui.config.bind.tool_zoom_show,
        'shortcut':     'z'
    },
    {
        'selector':     '#ezie_img',
        'click':        ezie.gui.config.bind.tool_img,
        'shortcut':     'i'
    },
    {
        'selector':     '#ezie_watermark',
        'click':        ezie.gui.config.bind.tool_watermark,
        'shortcut':     'w'
    },
    {
        'selector':     '#ezie_blackandwhite',
        'click':        ezie.gui.config.bind.filter_black_and_white,
        'shortcut':     'b'
    },
    {
        'selector':     '#ezie_sepia',
        'click':        ezie.gui.config.bind.filter_sepia,
        'shortcut':     'p'
    },
    {
        'selector':     '#ezie_flip_hor',
        'click':        ezie.gui.config.bind.tool_flip_hor,
        'shortcut':     'h'
    },
    {
        'selector':     '#ezie_flip_ver',
        'click':        ezie.gui.config.bind.tool_flip_ver,
        'shortcut':     'e'
    },
    {
        'selector':      '#ezie_rotation',
        'click':         ezie.gui.config.bind.tool_rotation_show,
        'shortcut':      'n'
    },
    {
        'selector':      '#ezie_levels',
        'click':         ezie.gui.config.bind.tool_levels_show,
        'shortcut':      '1'
    },
    {
        'selector':     '#ezie_pixelate',
        'click':        ezie.gui.config.bind.tool_pixelate,
        'shortcut':     null
    },
    {
        'selector':     '#ezie_crop',
        'click':        ezie.gui.config.bind.tool_crop,
        'shortcut':     'ctrl+c'
    },
    {
        'selector':     '#ezie_contrast',
        'click':        ezie.gui.config.bind.filter_contrast,
        'shortcut':     null
    },
    {
        'selector':     '#ezie_brightness',
        'click':        ezie.gui.config.bind.filter_brightness,
        'shortcut':     null
    },
    ];