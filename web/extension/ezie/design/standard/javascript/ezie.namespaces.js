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

var ezie = window.ezie || {};

// This is the global namespace of the UI.
ezie.gui = ezie.gui || {};

// Sub-namespace of the UI namespace, contains various configuration
// objects
ezie.gui.config = ezie.gui.config || {};

// Namespace to set the association between an item and the function to be excuted
ezie.gui.config.bindings = ezie.gui.config.bindings || {};

// Namespace used for the definition of the binded functions
ezie.gui.config.bind = ezie.gui.config.bind || {};
// Namespace used for the definition of actions. Similar to gui.config.bind but
// not for actions triggered by a click event
ezie.gui.config.actions = ezie.gui.config.action || {};

// Namespace for the interactions between the ui and ez publish
ezie.ezconnect = ezie.ezconnect || {};
