//
// Created on: <1-Aug-2002 16:45:00 fh>
//
// ## BEGIN COPYRIGHT, LICENSE AND WARRANTY NOTICE ##
// SOFTWARE NAME: eZ Publish
// SOFTWARE RELEASE: 4.1.x
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
//

/*! \file ezjslibmousetracker.js
*/


/*!
  \brief
  This library contains a mouse tracker. Simply include it and the current mouse
  position will be in MouseX and MouseY.
*/

// Global VARS
var MouseX = 0; // Track mouse position
var MouseY = 0;


/**
 * mouseHandler is called each time the mouse is moved within the document. We use the
 * mouse position to popup the menus where the mouse is located.
 */
function ezjslib_mouseHandler( e )
{
    if ( !e )
    {
        e = window.event;
    }
    if ( e.pageX || e.pageY )
    {
        MouseX = e.pageX;
        MouseY = e.pageY;
    }
    else if ( e.clientX || e.clientY ) // IE needs special treatment
    {
        MouseX = e.clientX + document.documentElement.scrollLeft;
        MouseY = e.clientY + document.documentElement.scrollTop;
    }
}


// Uncomment the following lines if you want to use the mouseHandler function
// for tracing. Note that this can be slow on IE.
//document.onmousemove = ezjslib_mouseHandler;
//if ( document.captureEvents ) document.captureEvents( Event.MOUSEMOVE ); // NN4
