<?php
//
//
// Created on: <07-Jul-2005 10:14:34 bf>
//
// ## BEGIN COPYRIGHT, LICENSE AND WARRANTY NOTICE ##
// SOFTWARE NAME: eZ Publish
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

/*

Needs the following in PHP Configuration

  --enable-cli
  --enable-pcntl
  --enable-sockets

*/

$host = "127.0.0.1";
$port = 9090;

// Alex 2008/04/11 - Changed executable to 'ooffice'
$ooexecutable = "ooffice";

$maxClients = 3;


set_time_limit( 0 );

$socket = socket_create( AF_INET, SOCK_STREAM, 0) or die( "Could not create socket\n" );

// Alex 2008/04/11 - Uncomment the next line in case there are problems with connecting
// to $host and $port (port busy as an effect of a crash)
//socket_set_option( $socket, SOL_SOCKET, SO_REUSEADDR, 1 );

$result = socket_bind( $socket, $host, $port ) or die( "Could not bind to socket\n" );
$result = socket_listen( $socket, $maxClients ) or die( "Could not set up socket listener\n" );

print( "Started OpenOffice.org daemon\n" );

function convert_to( $sourceFileName, $convertCommand, $destinationFileName )
{
    global $ooexecutable;

    print( "Converting document with $convertCommand\n" );

    switch ( $convertCommand )
    {
        case "convertToPDF":
        case "convertToOOo":
        case "convertToDoc":
        {
            $convertShellCommand = escapeshellcmd( $ooexecutable . " -writer -invisible -headless -nofirststartwizard -norestore" ) . " " .
            escapeshellarg( "macro:///eZconversion.Module1.$convertCommand(\"$sourceFileName\", \"$destinationFileName\")" );

            $result = shell_exec( $convertShellCommand  );

            echo "$result\n";
        }break;

        default:
        {
            echo "Unknown command $convertCommand";
            return "(1)-Unknown command $convertCommand";
        }break;
    }

    if ( !file_exists( $destinationFileName ) )
    {
        return "(3) - Unknown failure converting document \n $result";
    }

    return true;
}


while ( $spawn = socket_accept( $socket ))
{
    print( "got new connection\n" );
    $pid = pcntl_fork();
    if ( $pid != 0)
    {
        // In the main process
        socket_close( $spawn );
    }
    else
    {
        // We are in the forked child process
        socket_write( $spawn, "eZ Publish document conversion daemon\n");

        // Parse input
        $input = socket_read( $spawn, 1024 );

        $inputParts = explode( " ", $input );

        $command = trim( $inputParts[0] );
        $fileName = trim( $inputParts[1] );
        $destName = trim( $inputParts[2] );


        if ( file_exists( $fileName ) )
        {
            $result = convert_to( $fileName, $command, $destName );
            if ( !( $result === true ) )
            {
                echo( "Error: $result" );
                socket_write( $spawn, "Error: $result" );
            }
            else
            {
                echo( "Conversion ok. FilePath: $destName" );
                socket_write( $spawn, "FilePath: $destName" );
            }
        }
        else
        {
            echo( "Error: (2)-File not found" );
            socket_write( $spawn, "Error: (2)-File not found" );
        }

        socket_close( $spawn );
        die('Data Recieved on child ' . posix_getpid(). "\n");
    }
}

socket_close( $socket );

?>
