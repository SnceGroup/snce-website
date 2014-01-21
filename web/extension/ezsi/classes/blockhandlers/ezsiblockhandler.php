<?php
//
// Definition of siblocksupdate cronjob
//
// Created on: <28-Apr-2008 10:06:19 jr>
//
// ## BEGIN COPYRIGHT, LICENSE AND WARRANTY NOTICE ##
// SOFTWARE NAME: eZ publish
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
//

abstract class eZSIBlockHandler
{
    public function setTTL( $ttlString )
    {
        $this->TTL = $ttlString;
    }

    public function setKey( $keyString )
    {
        $this->Key = $keyString;
    }

    public function setSrc( $filePath )
    {
        $this->Src = $filePath;
    }

    public function validateKey()
    {
        if( !$this->Key )
        {
            return false;
        }

        return true;
    }

    public function TTLInSeconds()
    {
        $ttlInfos = $this->parseTTL();

        switch( $ttlInfos['ttl_unit'] )
        {
            case 'h' : $ttlInSeconds = $ttlInfos['ttl_value'] * 3600      ; break;
            case 'm' : $ttlInSeconds = $ttlInfos['ttl_value'] * 60        ; break;
            case 's' : $ttlInSeconds = $ttlInfos['ttl_value']             ; break;
            default  : $ttlInSeconds = $ttlInfos['ttl_value'] * 3600 * 24 ; break;
        }

        return $ttlInSeconds;
    }

    public function fileIsExpired( $mtime )
    {
        $TTLValue = $this->TTLInSeconds();
        return ( time() - $mtime ) >= $TTLValue;
    }

    public function parseTTL()
    {
        $ttlUnit  = substr( $this->TTL, -1);
        $ttlValue = (int)$this->TTL;

        return array( 'ttl_unit'  => $ttlUnit,
                      'ttl_value' => $ttlValue );
    }

    public function validateTTL()
    {
        // available time units are :
        // h : hours
        // m : minutes
        // s : seconds
        // d : days
        // units can not be combined

        $possibleUnits = array( 'h', 'm', 's', 'd' );

        $ttlInfos = $this->parseTTL();

        if( !in_array( $ttlInfos['ttl_unit'], $possibleUnits ) )
        {
            return false;
        }

        if( !$ttlInfos['ttl_value'] )
        {
            return false;
        }

        return true;
    }

    abstract public function generateMarkup();

    public $TTL = '';
    public $Key = '';
    public $Src = '';
}
?>
