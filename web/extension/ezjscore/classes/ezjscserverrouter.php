<?php
//
// Definition of ezjscServerRouter class
//
// Created on: <1-Jul-2008 12:42:08 ar>
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

/*
  Perfoms calls to custom functions or templates depending on arguments and ini settings
*/


class ezjscServerRouter
{
    protected $className = null;
    protected $functionName = null;
    protected $functionArguments = array();
    protected $isTemplateFunction = false;

    protected function ezjscServerRouter( $className, $functionName = 'call', array $functionArguments = array(), $isTemplateFunction = false )
    {
        $this->className = $className;
        $this->functionName = $functionName;
        $this->functionArguments = $functionArguments;
        $this->isTemplateFunction = $isTemplateFunction;
    }

    /**
     * Gets instance of ezjscServerRouter, IF arguments validates and user has access
     *
     * @param array $arguments
     * @param bool $requireIniGroupe Make sure this is true if $arguments comes from user input
     * @param bool $checkFunctionExistence
     * @return ezjscServerRouter|null
     */
    public static function getInstance( $arguments, $requireIniGroupe = true, $checkFunctionExistence = false )
    {
        if ( !is_array( $arguments ) || !isset( $arguments[1] ) )
        {
            // return null if arguments are invalid
            return null;
        }

        $className = $callClassName = array_shift( $arguments );
        $functionName = array_shift( $arguments );
        $isTemplateFunction = false;
        $permissionFunctions = false;
        $permissionPrFunction = false;
        $ezjscoreIni = eZINI::instance( 'ezjscore.ini' );

        if ( $ezjscoreIni->hasGroup( 'ezjscServer_' . $callClassName ) )
        {
           // load file if defined, else use autoload
           if ( $ezjscoreIni->hasVariable( 'ezjscServer_' . $callClassName, 'File' ) )
                include_once( $ezjscoreIni->variable( 'ezjscServer_' . $callClassName, 'File' ) );

           if ( $ezjscoreIni->hasVariable( 'ezjscServer_' . $callClassName, 'TemplateFunction' ) )
                $isTemplateFunction = $ezjscoreIni->variable( 'ezjscServer_' . $callClassName, 'TemplateFunction' ) === 'true';

           // check permissions
           if ( $ezjscoreIni->hasVariable( 'ezjscServer_' . $callClassName, 'Functions' ) )
                $permissionFunctions = $ezjscoreIni->variable( 'ezjscServer_' . $callClassName, 'Functions' );

           // check permissions
           if ( $ezjscoreIni->hasVariable( 'ezjscServer_' . $callClassName, 'PermissionPrFunction' ) )
                $permissionPrFunction = $ezjscoreIni->variable( 'ezjscServer_' . $callClassName, 'PermissionPrFunction' ) === 'enabled';

           // get class name if defined, else use first argument as class name
           if ( $ezjscoreIni->hasVariable( 'ezjscServer_' . $callClassName, 'Class' ) )
                $className = $ezjscoreIni->variable( 'ezjscServer_' . $callClassName, 'Class' );
        }
        else if ( $requireIniGroupe )
        {
            // return null if ini is not defined as a safety measure
            // to avoid letting user call all eZ Publish classes
            return null;
        }

        if ( $checkFunctionExistence && !self::staticHasFunction( $className, $functionName, $isTemplateFunction  ) )
        {
            return null;
        }

        if ( $permissionFunctions !== false )
        {
            if ( !self::hasAccess( $permissionFunctions, ( $permissionPrFunction ? $functionName : null ) ) )
            {
                return null;
            }
        }

        return new ezjscServerRouter( $className, $functionName, $arguments, $isTemplateFunction );
    }

    /**
     * Gets the name of the current class+function
     *
     * @return string
     */
    public function getName()
    {
        return $this->className . '::' . $this->functionName;
    }

    /**
     * Gets the cache time ( modified time ) for use when chaching the response.
     *
     * @param array $environmentArguments Optionall hash of environment variables
     * @return int
     */
    public function getCacheTime( $environmentArguments = array()  )
    {
        if ( $this->isTemplateFunction )
        {
            return 0;
        }
        else if ( method_exists( $this->className, 'getCacheTime' ) )
        {
            return call_user_func( array( $this->className, 'getCacheTime' ), $this->functionName );
        }
        else
        {
            return 0;
        }
    }

    /**
     * Checks if current user has access based on $requiredFunctions
     *
     * @param array $requiredFunctions
     * @param null|string $functionName
     * @return bool
     */
    public static function hasAccess( $requiredFunctions, $functionName = null )
    {
        // Build limitation array
        $functionName = $functionName !== null ? '_' . $functionName : '';
        $ezjscoreIni = eZINI::instance( 'ezjscore.ini' );
        $ezjscoreFunctionList = $ezjscoreIni->variable( 'ezjscServer', 'FunctionList' );
        $limitationList = array();
        foreach( $requiredFunctions as $requiredFunction )
        {
            $permissionName = $requiredFunction . $functionName;
            if ( !in_array( $permissionName, $ezjscoreFunctionList ) )
            {
                eZDebug::writeWarning( "'$permissionName' is not defined in ezjscore.ini[ezjscServer]FunctionList", __METHOD__ );
                return false;
            }
            $limitationList[] = $permissionName;
        }
        return ezjscAccessTemplateFunctions::hasAccessToLimitation( 'ezjscore', 'call', array( 'FunctionList' => $limitationList ) );
    }

    /**
     * Checks if function actually exits on the requested ezjscServerFunctions
     *
     * @return bool
     */
    public function hasFunction()
    {
        return self::staticHasFunction( $this->className, $this->functionName, $this->isTemplateFunction  );
    }

    /**
     * Checks if function actually exits on the requested ezjscServerFunctions
     *
     * @return bool
     */
    public static function staticHasFunction( $className, $functionName, $isTemplateFunction = false )
    {
        if ( $isTemplateFunction )
        {
            return true;//@todo: find a way to look for templates
        }
        else
        {
            return is_callable( array( $className, $functionName ) );
        }
    }

    /**
     * Call the defined function on requested ezjscServerFunctions class
     *
     * @param array $environmentArguments
     * @return mixed
     */
    public function call( &$environmentArguments = array(), $isPackeStage = false  )
    {
        if ( $this->isTemplateFunction )
        {
            $tpl = eZTemplate::factory();
            $tpl->setVariable( 'arguments', $this->functionArguments );
            $tpl->setVariable( 'environment', $environmentArguments );
            return $tpl->fetch( 'design:' . $this->className . '/' . $this->functionName . '.tpl' );
        }
        else
        {
            return call_user_func_array( array( $this->className, $this->functionName ), array( $this->functionArguments, &$environmentArguments, $isPackeStage ) );
        }
    }

}

?>
