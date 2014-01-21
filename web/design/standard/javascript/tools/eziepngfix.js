//
// Created on: <18-Nov-2004 10:54:01 bh>
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

/*! \file eziepngfix.js
*/


/*!
  Forces use of DirectX transparency filter for image tags with
  "transparent-png-icon" as class. The result: correct alpha
  blending for normal (32x32) PNG icons in Internet Explorer.
*/
function useDirectXAlphaBlender()
{
    var images = document.getElementsByTagName( "img" );

    for ( var i=0; i<images.length; i++ )
    {
        var image = images[i];
        if ( image.className == "transparent-png-icon" )
        {
            image.runtimeStyle.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" + image.src + "', sizingMethod='scale')";

            if ( image.width == 16 )
            {
                image.src = emptyIcon16;
            }
            else
            {
                image.src = emptyIcon32;
            }

            image.className = "transparent-png-icon-fixed";
        }
    }
}

window.attachEvent( "onload", useDirectXAlphaBlender );
