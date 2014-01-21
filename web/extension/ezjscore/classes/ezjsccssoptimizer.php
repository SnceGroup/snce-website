<?php
//
// Definition of ezjscCssOptimizer class
//
// Created on: <26-Sep-2011 00:00:00 dj>
//
// ## BEGIN COPYRIGHT, LICENSE AND WARRANTY NOTICE ##
// SOFTWARE NAME: eZ JSCore extension for eZ Publish
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

class ezjscCssOptimizer
{
    /**
     * 'compress' css code by removing whitespace
     *
     * @param string $css Concated Css string
     * @param int $packLevel Level of packing, values: 2-3
     * @return string
     */
    public static function optimize( $css, $packLevel = 2 )
    {
        // Normalize line feeds
        $css = str_replace( array( "\r\n", "\r" ), "\n", $css );

        // Remove multiline comments
        $css = preg_replace( '!(?:\n|\s|^)/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css );
        $css = preg_replace( '!(?:;)/\*[^*]*\*+([^/][^*]*\*+)*/!', ';', $css );

        // Remove whitespace from start and end of line + multiple linefeeds
        $css = preg_replace( array( '/\n\s+/', '/\s+\n/', '/\n+/' ), "\n", $css );

        if ( $packLevel > 2 )
        {
            // Remove space around ':' and ','
            $css = preg_replace( array( '/:\s+/', '/\s+:/' ), ':', $css );
            $css = preg_replace( array( '/,\s+/', '/\s+,/' ), ',', $css );

            // Remove unnecessary line breaks...
            $css = str_replace( array( ";\n", '; ' ), ';', $css );
            $css = str_replace( array( "}\n", "\n}", ';}' ), '}', $css );
            $css = str_replace( array( "{\n", "\n{", '{;' ), '{', $css );
            // ... and spaces as well
            $css = str_replace(array('\s{\s', '\s{', '{\s' ), '{', $css );
            $css = str_replace(array('\s}\s', '\s}', '}\s' ), '}', $css );

            // Optimize css
            $css = str_replace( array( ' 0em', ' 0px', ' 0pt', ' 0pc' ), ' 0', $css );
            $css = str_replace( array( ':0em', ':0px', ':0pt', ':0pc' ), ':0', $css );
            $css = str_replace( ' 0 0 0 0;', ' 0;', $css );
            $css = str_replace( ':0 0 0 0;', ':0;', $css );

            // Optimize hex colors from #bbbbbb to #bbb
            $css = preg_replace( "/color:#([0-9a-fA-F])\\1([0-9a-fA-F])\\2([0-9a-fA-F])\\3/", "color:#\\1\\2\\3", $css );
        }
        return $css;
    }
}
?>
