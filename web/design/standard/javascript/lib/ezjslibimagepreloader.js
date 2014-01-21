//
// Created on: <12-Oct-2004 14:18:58 dl>
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

/*! \file ezjslibimagepreloader.js
*/

/*!
    \brief
*/

function eZImagePreloader()
{
    this.setupEventHandlers( eZImagePreloader.prototype.onImageLoad,
                             eZImagePreloader.prototype.onImageError,
                             eZImagePreloader.prototype.onImageAbort );
}

eZImagePreloader.prototype.preloadImageList = function( imageList )
{
    this.nImagesCount           = imageList.length;
    this.nProcessedImagesCount  = 0;
    this.nLoadedImagesCount     = 0;
    this.bPreloadDone           = false;

    for ( var i in imageList )
    {
        if ( typeof imageList[i] != 'function' )
        {
            this.preload( imageList[i] );
        }
    }
}

eZImagePreloader.prototype.preload = function( imageFilePath )
{
    var image = new Image;

    image.onload  = this.onImageLoadEvent;
    image.onerror = this.onImageErrorEvent;
    image.onabort = this.onImageAbortEvent;

    image.preloader = this;

    image.bLoaded = false;
    image.bError  = false;
    image.bAbort  = false;

    image.src = imageFilePath;

}

eZImagePreloader.prototype.setupEventHandlers = function( onLoad, onError, onAbort )
{
    this.onImageLoadEvent = onLoad;
    this.onImageErrorEvent = onError;
    this.onImageAbortEvent = onAbort;
}

eZImagePreloader.prototype.onImageLoad = function()
{
    this.bLoaded = true;
    this.preloader.nLoadedImagesCount++;
    this.preloader.onComplete();
}

eZImagePreloader.prototype.onImageError = function()
{
    this.bError = true;
    this.preloader.onComplete();
}

eZImagePreloader.prototype.onImageAbort = function()
{
    this.bAbort = true;
    this.preloader.onComplete();
}

eZImagePreloader.prototype.onComplete = function( imageList )
{
    this.nProcessedImagesCount++;
    if ( this.nProcessedImagesCount == this.nImagesCount )
    {
        this.bPreloadDone = true;
    }
}

function ezjslib_preloadImageList( filepathList )
{
    var preloader = new eZImagePreloader();
    preloader.preloadImageList( filepathList );
}


