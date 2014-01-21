//
// Created on: <14-Jul-2004 14:18:58 dl>
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

/*! \file ezjslibcookiesupport.js
*/

/*!
    \brief
    Functions which works direct with cookie:
        ezjslib_setCookie,
        ezjslib_getCookie,
        ezjslib_setCookieFromArray,
        ezjslib_getCookieToArray.
*/


/*!
    Sets cookie with \a name, \a value and \a expires date.
*/
function ezjslib_setCookie( name, value, expires )
{
    document.cookie = name + '=' + escape(value) + (( !expires ) ? "" : ('; expires=' + expires.toUTCString())) + '; path=/';
}

/*!
    \return a value of cookie with name \a name.
*/
function ezjslib_getCookie( name )
{
    var cookie  = document.cookie;

    var startPos = cookie.indexOf( name );
    if ( startPos != -1 )
    {
        startPos += name.length + 1;

        var endPos = cookie.indexOf( ";", startPos );
        if ( endPos == -1 )
            endPos = cookie.length;

        return unescape( cookie.substring(startPos, endPos) );
    }

    return null;
}

/*!
    Converts array \a valueArray to string using as delimiter \a delimiter.
    Resulting string stores in the cookie with name \a name and expire date
    \a expires.
*/
function ezjslib_setCookieFromArray( name, valuesArray, expires, delimiter )
{
    var strCookie = valuesArray.join( delimiter );
    ezjslib_setCookie( name, strCookie, expires );
}

/*!
    Retrieves string from cookie \a name and converts it to array using
    \a delimiter as delimiter.
*/
function ezjslib_getCookieToArray( name, delimiter )
{
    var valuesArray = new Array( 0 );
    var strCookie = ezjslib_getCookie( name );
    if ( strCookie )
    {
        valuesArray = strCookie.split( delimiter );
    }

    return valuesArray;
}

