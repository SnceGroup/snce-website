<?php
//
// Definition of ezjscEncodingTemplateFunctions
//
// Created on: <17-Sep-2007 12:42:08 ar>
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

/**
 * Custom has access to call that also lets you check that user has access to provided limitation(s)
 *
 * has_access_to_limitation( string $module, string $function, hash $limitations ):
 * Currently only returns true/false, but will in the future also return array of limitations that
 * did not match (as in limitations you did not ask to check by your provided parameters)
 */

class ezjscAccessTemplateFunctions
{
    function ezjscAccessTemplateFunctions()
    {
    }

    function operatorList()
    {
        return array( 'has_access_to_limitation' );
    }

    function namedParameterPerOperator()
    {
        return true;
    }

    function namedParameterList()
    {
        return array( 'has_access_to_limitation' => array( 'module' => array( 'type' => 'string',
                                                'required' => true,
                                                'default' => '' ),
                                              'function' => array( 'type' => 'string',
                                                'required' => true,
                                                'default' => '' ),
                                              'limitations' => array( 'type' => 'array',
                                                'required' => true,
                                                'default' => array() ),
                                              'debug' => array( 'type' => 'bool',
                                                'required' => false,
                                                'default' => false )),
        );

    }

    function modify( $tpl, $operatorName, $operatorParameters, $rootNamespace, $currentNamespace, &$operatorValue, $namedParameters )
    {
        switch ( $operatorName )
        {
            case 'has_access_to_limitation':
            {
              $operatorValue = self::hasAccessToLimitation( $namedParameters['module'], $namedParameters['function'], $namedParameters['limitations'], $namedParameters['debug'] );
            } break;
        }
    }

    /**
     * Check access to a specific module/function with limitation values.
     * See eZ Publish documentation on more info on module, function and
     * limitation values. Example: a user can have content/read permissions
     * but it can be limited to a specific limitation like a section, a node
     * or node tree. Limitation: returns false if one of provided values
     * don't match but ignores limitations not specified in $limitations.
     *
     * @param string $module
     * @param string $function
     * @param array|null $limitations A hash of limitation keys and values
     * @return bool
     */
    public static function hasAccessToLimitation( $module, $function, $limitations = null, $debug = false )
    {
        // Like fetch(user,has_access_to), but with support for limitations
        $user = eZUser::currentUser();
        if ( !$user instanceof eZUser )
        {
            eZDebug::writeDebug( 'No user instance', __METHOD__ );
            return false;
        }

        $result = $user->hasAccessTo( $module, $function );
        if ( $result['accessWord'] !== 'limited')
        {
            return $result['accessWord'] === 'yes';
        }

        // Merge limitations before we check access
        $mergedLimitations = array();
        $missingLimitations = array();
        foreach ( $result['policies'] as $userLimitationArray  )
        {
            foreach ( $userLimitationArray as $userLimitationKey => $userLimitationValues  )
            {
                if ( isset( $limitations[$userLimitationKey] ) )
                {
                    if ( isset( $mergedLimitations[$userLimitationKey] ) )
                        $mergedLimitations[$userLimitationKey] = array_merge( $mergedLimitations[$userLimitationKey], $userLimitationValues );
                    else
                        $mergedLimitations[$userLimitationKey] = $userLimitationValues;
                }
                else
                {
                    $missingLimitations[] = $userLimitationKey;
                }
            }
        }

        // User has access unless provided limitations don't match
        foreach ( $mergedLimitations as $userLimitationKey => $userLimitationValues  )
        {
            // Handle subtree matching specifically as we need to match path string
            if ( $userLimitationKey === 'User_Subtree' || $userLimitationKey === 'Subtree' )
            {
                $pathMatch = false;
                foreach ( $userLimitationValues as $subtreeString )
                {
                    if ( strstr( $limitations[$userLimitationKey], $subtreeString ) )
                    {
                        $pathMatch = true;
                        break;
                    }
                }
                if ( !$pathMatch )
                {
                    if ( $debug ) eZDebug::writeDebug( "Unmatched[$module/$function]: " . $userLimitationKey . ' '. $limitations[$userLimitationKey] . ' != ' . $subtreeString, __METHOD__ );
                    return false;
                }
            }
            else
            {
                if ( is_array( $limitations[$userLimitationKey] ) )
                {
                    // All provided limitations must exist in $userLimitationValues
                    foreach( $limitations[$userLimitationKey] as $limitationValue )
                    {
                        if ( !in_array( $limitationValue, $userLimitationValues ) )
                        {
                            if ( $debug ) eZDebug::writeDebug( "Unmatched[$module/$function]: " . $userLimitationKey . ' ' . $limitationValue . ' != [' . implode( ', ', $userLimitationValues ) . ']', __METHOD__ );
                            return false;
                        }
                    }
                }
                else if ( !in_array( $limitations[$userLimitationKey], $userLimitationValues ) )
                {
                    if ( $debug ) eZDebug::writeDebug( "Unmatched[$module/$function]: " . $userLimitationKey . ' ' . $limitations[$userLimitationKey] . ' != [' . implode( ', ', $userLimitationValues ) . ']', __METHOD__ );
                    return false;
                }
            }
        }
        if ( !empty( $missingLimitations ) && $debug )
        {
            eZDebug::writeNotice( "Matched, but missing limitations[$module/$function]: " . implode( ', ', $missingLimitations ), __METHOD__ );
        }
        return true;
    }
}

?>
