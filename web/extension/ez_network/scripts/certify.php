<?php
/**
 * File containing the certify script
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/software/proprietary_license_options/ez_proprietary_use_license_v1_0 PUL
 * @version 5.2.0
 * @package ez_network
 */

/*!
  \class Certify certify.php
  \brief The class Certify does

*/

require 'autoload.php';

$cli = eZCLI::instance();
$script = eZScript::instance( array( 'debug-message' => '',
                                     'use-session' => true,
                                     'use-modules' => true,
                                     'use-extensions' => true ) );

$script->startup();

$options = $script->getOptions( "[include-ezp-design][include-ezp-std-ext][approval-mode:][php-exec:][check-templates][check-php-files]",
                                "[certify_extension:]",
                                array( 'certify_extension'   => 'Specify one or more extension(s) seperated by space.',
                                       'approval-mode'       => "Specify one extension upon which to do an 'approval check'",
                                       'php-exec'            => 'PHP executable',
                                       'check-templates'     => 'Check templates for wash operators and compile errors in global ezp certification mode, default: off',
                                       'check-php-files'     => 'Check php files in extensions just like certify check does (use in combination with --include-ezp-std-ext to check all)',
                                       'include-ezp-design'  => 'Include standard eZ Publish design',
                                       'include-ezp-std-ext' => 'Include standard eZ Publish extension list, if not then approve / certify tests will ignore them' ) );

$specifiedExtension = array();

foreach( $options['arguments'] as $option )
{
    if ( isset( $option ) )
    {
        if ( file_exists( eZDir::path( array( eZExtension::baseDirectory(), $option ) ) ) )
        {
            $specifiedExtension[] = $option;
        }
        else
        {
            help();
            exit(1);
        }
    }
}

$endl = $cli->endlineString();
$webOutput = $cli->isWebOutput();

function help()
{
    $argv = $_SERVER['argv'];
    $cli = eZCLI::instance();
    $cli->output( "Usage: " . $argv[0] . " [OPTION]...\n" .
                  "Executes eZ Publish Network certify script.\n" .
                  "\n" .
                  "General options:\n" .
                  "  -h,--help          display this help and exit \n" .
                  "  -q,--quiet         do not give any output except when errors occur\n" .
                  "  -s,--siteaccess    selected siteaccess for operations, if not specified default siteaccess is used\n" .
                  "  -d,--debug         display debug output at end of execution\n" .
                  "  -c,--colors        display output using ANSI colors\n" .
                  "  --sql              display sql queries\n" .
//                  "  --logfiles         create log files\n" .
//                  "  --no-logfiles      do not create log files (default)\n" .
                  "  --no-colors        do not use ANSI coloring (default)\n" .
                  "Errorcodes returned:\n" .
                  "  0    All test passed. Some could have deemed suboptimal, but not critical.\n" .
                  "  1    At least one critical element failed the test, or the script itself failed.\n");
}

$isQuiet = false;
$changeSiteAccessSetting = function ( &$siteaccess, $optionData ) use ( &$isQuiet )
{
    $cli = eZCLI::instance();
    if ( file_exists( eZSiteAccess::findPathToSiteAccess( $optionData ) ) )
    {
        $siteaccess = $optionData;
        if ( !$isQuiet )
            $cli->notice( "Using siteaccess $siteaccess for certify script" );
    }
    else
    {
        if ( !$isQuiet )
            $cli->notice( "Siteaccess $optionData does not exist, using default siteaccess" );
    }
};

$siteaccess = false;
$debugOutput = false;
$allowedDebugLevels = false;
$useDebugAccumulators = false;
$useDebugTimingpoints = false;
$useIncludeFiles = false;
$useColors = false;
$useLogFiles = false;
$showSQL = false;
$useApprovalMode = false;

$optionsWithData = array( 's' );
$longOptionsWithData = array( 'siteaccess' );

$readOptions = true;

// handle approval mode: only use 1 extension for input, reset and stuff the
// global array of extension names - to deal with later...
if( isset( $options[ "approval-mode" ] ) )
{
    if( file_exists( eZDir::path( array( eZExtension::baseDirectory(), $options[ "approval-mode" ] ) ) ) )
    {
        $specifiedExtension = array( $options[ "approval-mode" ] );
        $useApprovalMode = true;
    }
    else
    {
        help();
        die( "can not find extension" );
        exit(1);
    }
}
for ( $i = 1; $i < count( $argv ); ++$i )
{
    $arg = $argv[$i];
    if ( $readOptions and
         strlen( $arg ) > 0 and
         $arg[0] == '-' )
    {
        if ( strlen( $arg ) > 1 and
             $arg[1] == '-' )
        {
            $flag = substr( $arg, 2 );
            if ( in_array( $flag, $longOptionsWithData ) )
            {
                $optionData = $argv[$i+1];
                ++$i;
            }
            if ( $flag == 'help' )
            {
                help();
                exit(1);
            }
            else if ( $flag == 'siteaccess' )
            {
                $changeSiteAccessSetting( $siteaccess, $optionData );
            }
            else if ( $flag == 'debug' )
            {
                $debugOutput = true;
            }
            else if ( $flag == 'quiet' )
            {
                $isQuiet = true;
            }
            else if ( $flag == 'colors' )
            {
                $useColors = true;
            }
            else if ( $flag == 'no-colors' )
            {
                $useColors = false;
            }
            else if ( $flag == 'no-logfiles' )
            {
                $useLogFiles = false;
            }
            else if ( $flag == 'logfiles' )
            {
                $useLogFiles = true;
            }
            else if ( $flag == 'sql' )
            {
                $showSQL = true;
            }
        }
        else
        {
            $flag = substr( $arg, 1, 1 );
            $optionData = false;
            if ( in_array( $flag, $optionsWithData ) )
            {
                if ( strlen( $arg ) > 2 )
                {
                    $optionData = substr( $arg, 2 );
                }
                else
                {
                    $optionData = $argv[$i+1];
                    ++$i;
                }
            }
            if ( $flag == 'h' )
            {
                help();
                exit(1);
            }
            else if ( $flag == 'q' )
            {
                $isQuiet = true;
            }
            else if ( $flag == 'c' )
            {
                $useColors = true;
            }
            else if ( $flag == 'd' )
            {
                $debugOutput = true;
                if ( strlen( $arg ) > 2 )
                {
                    $levels = explode( ',', substr( $arg, 2 ) );
                    $allowedDebugLevels = array();
                    foreach ( $levels as $level )
                    {
                        if ( $level == 'all' )
                        {
                            $useDebugAccumulators = true;
                            $allowedDebugLevels = false;
                            $useDebugTimingpoints = true;
                            break;
                        }
                        if ( $level == 'accumulator' )
                        {
                            $useDebugAccumulators = true;
                            continue;
                        }
                        if ( $level == 'timing' )
                        {
                            $useDebugTimingpoints = true;
                            continue;
                        }
                        if ( $level == 'include' )
                        {
                            $useIncludeFiles = true;
                        }
                        if ( $level == 'error' )
                            $level = EZ_LEVEL_ERROR;
                        else if ( $level == 'warning' )
                            $level = EZ_LEVEL_WARNING;
                        else if ( $level == 'debug' )
                            $level = EZ_LEVEL_DEBUG;
                        else if ( $level == 'notice' )
                            $level = EZ_LEVEL_NOTICE;
                        else if ( $level == 'timing' )
                            $level = EZ_LEVEL_TIMING;
                        $allowedDebugLevels[] = $level;
                    }
                }
            }
            else if ( $flag == 's' )
            {
                $changeSiteAccessSetting( $siteaccess, $optionData );
            }
        }
    }
}
$script->setUseDebugOutput( $debugOutput );
$script->setAllowedDebugLevels( $allowedDebugLevels );
$script->setUseDebugAccumulators( $useDebugAccumulators );
$script->setUseDebugTimingPoints( $useDebugTimingpoints );
$script->setUseIncludeFiles( $useIncludeFiles );

if ( $webOutput )
$useColors = true;

$cli->setUseStyles( $useColors );
$script->setDebugMessage( "\n\n" . str_repeat( '#', 36 ) . $cli->style( 'emphasize' ) . " DEBUG " . $cli->style( 'emphasize-end' )  . str_repeat( '#', 36 ) . "\n" );

$script->setUseSiteAccess( $siteaccess );

$script->initialize();
if ( !$script->isInitialized() )
{
    $cli->error( 'Error initializing script: ' . $script->initializationError() . '.' );
    $script->shutdown();
    exit(1);
}

if ( !in_array( 'ez_network', eZExtension::activeExtensions( 'default' ) ) )
{
    $cli->error( 'Error initializing script: "ez_network" extension is not enabled, see doc/INSTALL.txt for how to proceed.' );
    $script->shutdown();
    exit(1);
}

$cli->output( 'Certify script start' );

$certify = new eZXNetCertify( $cli, $script, $options );

if ( !$certify->canCreateNetworkLog() )
{
    $script->shutdown();
    exit(1);
}

if ( $options['include-ezp-design'] )
{
    $certify->setIncludeEZPDesign();
}

if ( $options['include-ezp-std-ext'] )
{
    $certify->setIncludeEZPExtensions();
}


// Perform certify checks.
if( $useApprovalMode )
{
    // the extension that we are doing the approval on is the first and only
    // extension in the $specifiedExtension array
    $certify->setExtension( $specifiedExtension[ 0 ] );
    if( !in_array( $specifiedExtension[ 0 ], $certify->extensionList() ) )
    {
        help();

        //echo print_r( $certify->extensionList() );

        $script->shutdown();
        die( "Extension: '$specifiedExtension[0]' is not recognized, is it an ezp extension? (see: --include-ezp-std-ext)\n" );
        exit(1);
    }
    $checkList = array( 'checkTemplateCompilation',
                        'checkTemplateWashing',
                        'checkTemplateAttributeShow',
                        'checkExtensionSize',
                        'checkExtensionFileCount',
                        'checkExtensionType',
                        'checkDataTypeCount',
                        'checkDesignTemplateCount',
                        'checkINIFiles',
                        'checkCustomINISettings',
                        'checkBadExtensionSettings',
                        'checkCronjobExtensionSettings',
                        'checkSiteAccessSetttingsList',
                        'checkExtensionPHPInfo',
                        'checkPHPLint',
                        'checkFunctionList',
                        'checkReferences'
                        );
}
elseif ( !empty( $specifiedExtension ) )
{
    foreach( $specifiedExtension as $extension )
    {
        $certify->setExtension( $extension );
        if ( !in_array( $extension, $certify->extensionList() ) )
        {
            help();

            //echo print_r( $certify->extensionList() );

            $script->shutdown();
            die( "Extension: '$extension' is not recognized, is it an ezp extension? (see: --include-ezp-std-ext)\n" );
            exit(1);
        }
    }

    $checkList = array( 'checkTemplateCompilation',
                        'checkTemplateWashing',
                        'checkTemplateAttributeShow',
                        'checkExtensionSize',
                        'checkExtensionFileCount',
                        'checkExtensionType',
                        'checkDataTypeCount',
                        'checkDesignTemplateCount',
                        'checkINIFiles',
                        'checkCustomINISettings',
                        'checkBadExtensionSettings',
                        'checkCronjobExtensionSettings',
                        'checkSiteAccessSetttingsList',
                        'checkExtensionPHPInfo',
                        'checkPHPFiles',
                        'checkPHPLint',
                        'checkFunctionList',
                        'checkReferences'
                        );
}
else
{
    $checkList = array( 'checkINIWrite',
                        'checkSafeMode',
                        'checkMonitorConnection',
                        'checkPatchCommand',
                        'checkDiffCommand',
                        'checkForSymlinks',
                        'checkExistingFiles',
                        'checkExistingDesigns',
                        'checkExtensionInformation',
                        'checkBadExtensionSettings',
                        'checkDataTypeCount',
                        'checkDBConnection',
                        'checkDBCharset',
                        //'checkMCrypt',
                        'checkCronjobExtensionSettings',
                        'checkMBString',
                        'checkSuhosin',
                        'checkImageHandling',
                        'checkBasicEZStatus',
                        'checkPHPLint',
                        'checkReferences',
                        'checkFunctionList',
                        'checkUniqueExtensionPHPInfoClassNames'
                        );
    if ( isset( $options['check-templates'] ) && $options['check-templates'] )
    {
        $checkList[] = 'checkTemplateAttributeShow';
        $checkList[] = 'checkTemplateCompilation';
        $checkList[] = 'checkTemplateWashing';
    }
    if ( isset( $options['check-php-files'] ) && $options['check-php-files'] )
    {
        $checkList[] = 'checkExtensionPHPInfo';
        $checkList[] = 'checkPHPFiles';
    }
}

if ( !empty( $specifiedExtension ) )
{

    foreach( $specifiedExtension as $extension )
    {

        $certify->appendToLog( "\n\n" . str_repeat( "*", 81 ) . "\n" . str_repeat( "*", 81 ) . "\n*  Testing " . $extension . " Extension\n" . str_repeat( "*", 81 ) . "\n" . str_repeat( "*", 81 ) );

        $certify->setExtension( $extension );
        foreach( $checkList as $check )
        {
            $certify->$check();
        }
    }
}
else
{
    foreach( $checkList as $check )
    {
        $certify->$check();
    }
}

$errorCode = $certify->close();

$script->shutdown();
exit( $errorCode );


/*!
 \class eZXNetCertify

 Support functions for certify script.
*/
class eZXNetCertify
{
    /*!
     Constructor
    */
    function eZXNetCertify( $cli, $script, $options = false )
    {
        $this->TPL = eZTemplate::factory();
        $this->TPL->setCompileTest( true );
        $this->InvalidTemplateCompileList = array();
        $this->CLI = $cli;

        $this->PHPExecutable = empty( $options['php-exec'] ) ? null : $options['php-exec'];

        $this->LogFileList = array();
        $this->CertifyLogFile = 'certify.log';
        $this->fp = @fopen( $this->CertifyLogFile, 'w' );

        if ( !$this->fp )
        {
            $cli->error( 'Could not create log file: ' . $this->CertifyLogFile );
            $cli->output( 'Correct this by making sure this script has access to create and write to: ' . $certifyLogFile );
            $script->shutdown();
            exit();
        }

        $ini = eZINI::instance();
        $siteAccessArray = $ini->variable( 'SiteAccessSettings', 'AvailableSiteAccessList' );
        $siteAccessArray = array_unique( $siteAccessArray );
        $this->setSiteAccessArray( $siteAccessArray );
    }

    /*!
     Will check template, and log result to file
     \param filename
    */
    function checkTemplate( $file )
    {
        $result = $this->TPL->compileTemplateFile( $file );
        if ( ( $this->TPL->hasWarnings() || $this->TPL->hasErrors() ) &&
             !in_array( $file, $this->InvalidTemplateCompileList ) )
        {
            if ( $this->TPL->hasErrors() )
            {
                $this->setBlockHasError();
                $this->appendToBlock( 'Error in template ( compile test ): ' . $file );
                foreach ( $this->arrayUnique( $this->TPL->errorLog() ) as $error )
                {
                    $this->appendToBlock( '  Error description [' . $error['placement']['start']['line'] . ':' . $error['placement']['start']['column'] . '] : ' . $error['text'] );
                }
            }

            if ( $this->TPL->hasWarnings() )
            {
                $this->setBlockHasError();
                $this->appendToBlock( 'Warning in template ( compile test ): ' . $file );
                foreach ( $this->arrayUnique( $this->TPL->warningLog() ) as $error )
                {
                    $this->appendToBlock( '  Warning description [' . $error['placement']['start']['line'] . ':' . $error['placement']['start']['column'] . '] : ' . $error['text'] );
                }
            }

            $this->CLI->output( "   Template file invalid ( compile ): " . $this->CLI->stylize( 'file', $file ) );
            $this->InvalidTemplateCompileList[] = $file;
        }
    }

    /*!
     Change to specified siteaccess
     \param siteaccess name
    */
    function changeAccess( $siteAccess )
    {
        if ( method_exists('eZSiteAccess','change') )// since 4.4
        {
            $GLOBALS['eZCurrentAccess']['name'] = $siteAccess;
            eZSiteAccess::change( array( 'name' => $siteAccess, 'type' => $GLOBALS['eZCurrentAccess']['type'] ) );
        }
        else
        {
            include_once( 'access.php' );
            $GLOBALS['eZCurrentAccess']['name'] = $siteAccess;
            changeAccess( array( 'name' => $siteAccess, 'type' => $GLOBALS['eZCurrentAccess']['type'] ) );

            if ( isset( $GLOBALS['eZCurrentAccess']['type'] ) &&
                 $GLOBALS['eZCurrentAccess']['type'] == EZ_ACCESS_TYPE_URI )
            {
                eZSys::clearAccessPath();
                eZSys::addAccessPath( $siteAccess );
            }

            // Load the siteaccess extensions
            eZExtension::activateExtensions('access');
        }
    }

    /*!
     Generate template file list for current siteaccess

     \param design

     \return template filename list
    */
    function templateList( $design )
    {
        $designAccessINI = eZINI::instance( 'design.ini' );
        $designExtensionList = $designAccessINI->variable( 'ExtensionSettings', 'DesignExtensions' );
        $excludeDesignArray = array( 'standard', 'admin', 'admin2', 'base' );

        $baseDir = 'design/' . $design . '/';
        // If extension set, only include specific extension templates.
        $files = array();
        if ( !$this->extension() )
        {
            if( !( !$this->includeEZPDesign() and in_array( $design, $excludeDesignArray ) ) )
            {
                $files = eZDir::recursiveFind( $baseDir . 'templates', "\.tpl" );
                $files = array_merge( $files, eZDir::recursiveFind( $baseDir . 'override/templates', "\.tpl" ) );
            }
        }

        $extensionBaseDir = eZExtension::baseDirectory() . '/' . $baseDir;
        foreach ( $designExtensionList as $designExtension )
        {
            // If extension set, only include specific extension templates.
            if ( $this->extension() &&
                 $this->extension() != $designExtension )
            {
                continue;
            }

            $files = array_merge( $files, eZDir::recursiveFind( eZDir::path( array( eZExtension::baseDirectory(),
                                                                                    $designExtension,
                                                                                    $baseDir,
                                                                                    'templates' ) ),
                                                                "\.tpl" ) );
            $files = array_merge( $files, eZDir::recursiveFind( eZDir::path( array( eZExtension::baseDirectory(),
                                                                                    $designExtension,
                                                                                    $baseDir,
                                                                                    'override/templates' ) ),
                                                                "\.tpl" ) );
        }

        return array_unique( $files );
    }

    /*!
     Get design list for current siteaccess

     \return design list
    */
    function designList()
    {
        $siteAccessINI = eZINI::instance();
        $standardDesign = $siteAccessINI->variable( "DesignSettings", "StandardDesign" );
        $siteDesign = $siteAccessINI->variable( "DesignSettings", "SiteDesign" );
        $additionalSiteDesignList = $siteAccessINI->variable( "DesignSettings", "AdditionalSiteDesignList" );
        return array_unique( array_merge( array( $standardDesign ), $additionalSiteDesignList, array( $siteDesign ) ) );
    }

    /*!
     Create unique multi dimensional array
    */
    function arrayUnique($array) {
        $new = array(); $new1 = array();

        foreach ( $array as $k => $na )
        {
            $new[$k] = serialize( $na );
        }
        $uniqArray = array_unique($new);
        foreach ( $uniqArray as $k => $ser )
        {
            $new1[$k] = unserialize( $ser );
        }

        return $new1;
    }

    /*!
     Start log block

     \param blockName
    */
    function startBlock( $blockName )
    {
        ++$this->BlockStackCount;
        $this->BlockStack[$this->BlockStackCount] = array( 'name' => $blockName,
                                                           'success' => true,
                                                           'warning' => false,
                                                           'optimal' => true,
                                                           'log' => array() );
    }

    /*!
     End log block

    */
    function commitBlock()
    {
        if ( $this->BlockStack[$this->BlockStackCount]['success'] )
        {
            $fillCharVert = '|';
            $fillCharHor = '-';
            $fillCharCorner = '+';

            if ( $this->BlockStack[$this->BlockStackCount]['warning'] )
            {
                $intro = 'Success with warnings : ' . $this->BlockStack[$this->BlockStackCount]['name'];
            }
            elseif ( $this->BlockStack[$this->BlockStackCount]['optimal'] === false )
            {
                $intro = 'Suboptimal : ' . $this->BlockStack[$this->BlockStackCount]['name'];
            }
            else
            {
                $intro = 'Success : ' . $this->BlockStack[$this->BlockStackCount]['name'];
            }
        }
        else
        {
            $fillCharVert = '*';
            $fillCharHor = '*';
            $fillCharCorner = '*';
            $intro = 'FAILED : ' . $this->BlockStack[$this->BlockStackCount]['name'];
        }

        $indent = ( $this->BlockStackCount - 1 ) * 4;
        $indentString = str_repeat( ' ', $indent );
        $this->appendToLog( "\n" . $indentString . $fillCharCorner . str_repeat( $fillCharHor, 80 - $indent ) );
        $this->appendToLog( $indentString . $fillCharVert . ' ' . $intro );
        foreach( $this->BlockStack[$this->BlockStackCount]['log'] as $line )
        {
            $this->appendToLog( $indentString . $fillCharVert . ' ' . $line );
        }
        $this->appendToLog( $indentString . $fillCharCorner . str_repeat( $fillCharHor, 80 - $indent ) );

        --$this->BlockStackCount;
    }

    /*!
     Append text to block

     \param text
    */
    function appendToBlock( $text )
    {
        $this->BlockStack[$this->BlockStackCount]['log'][] = $text;
    }

    /*!
     Set that block has error
    */
    function setBlockHasError()
    {
        $this->BlockStack[$this->BlockStackCount]['success'] = false;
        $this->ErrorCode = 1;
    }

    /*!
     Set that block has warnings
    */
    function setBlockHasPotentialError()
    {
        $this->BlockStack[$this->BlockStackCount]['warning'] = true;
    }

    /*!
     Set that block is not maximum tuned
    */
    function setBlockIsSubOptimal()
    {
        $this->BlockStack[$this->BlockStackCount]['optimal'] = false;
    }

    /*!
     Prepend text to log
    */
    function prependToLog( $text )
    {
        $this->Log = $text . "\n" . $this->Log;
    }

    /*!
     Append text to log
    */
    function appendToLog( $text )
    {
        $this->Log .= $text . "\n";
    }

    /*!
     Append text to log
    */
    function appendFile( $filename )
    {
        $this->LogFileList[] = $filename;
    }

    /*!
     Close log, and append MD5 checksum
    */
    function close()
    {
        $legend  = "\nLegend:\n";
        $legend .= "Success: No issues found with tested element.\n";
        $legend .= "Success with warnings: No issues found, but certain results should be manually inspected.\n";
        $legend .= "Suboptimal: Not considered a problem, but has room for improvement.\n";
        $legend .= "Failure: This means that the issue should be resolved.\n";
        $this->prependToLog( $legend );

        if ( $this->IncludeSiteData )
        {
            $ini = eZINI::instance();
            $siteName = $ini->variable( 'SiteSettings', 'SiteName' );
            $siteUrl = $ini->variable( 'SiteSettings', 'SiteURL' );
            $siteIdentifier = "'$siteName' $siteUrl  v" .  eZPublishSDK::version();
            $this->prependToLog( 'Certifying site: ' . $siteIdentifier );
        }

        if ( $this->IncludeChecksum )
        {
            $content = $this->Log;
            $content .= 'CERTIFY_STRING';
            $this->appendToLog( md5( $content ) );
        }

        eZFile::create( $this->CertifyLogFile, false, $this->Log );

        $this->CLI->output( 'Certify script complete.' );
        $this->CLI->output( 'Result stored in ' . $this->getLogFileName() );

        return $this->ErrorCode;

/*
    $progressArray = array( '-', '\\', '|', '/' );
    fwrite( $this->fp, base64_encode( $content ) );

    $this->LogFileList = array_unique( $this->LogFileList );

    echo "\n";
    foreach( $this->LogFileList as $idx => $filename )
    {
        echo "\r " . $progressArray[$idx % 4];

        fwrite( $this->fp, base64_encode( '***** ' . $filename . ' *****' . "\n" ) );
        fwrite( $this->fp, base64_encode( base64_encode( file_get_contents( $filename ) . "\n" ) ) );
    }
    echo "\r";

    fclose( $this->fp );

    $output = array();
    exec( 'gzip -f ' . $this->CertifyLogFile, $output );
    rename( $this->CertifyLogFile . '.gz', $this->CertifyLogFile );
*/
    }

    /*!
     Get basic eZ Publish statistics
    */
    function checkBasicEZStatus()
    {
        $this->startBlock( 'eZ Publish statistics' );

        $currentSiteAccess = $GLOBALS['eZCurrentAccess']['name'];
        $currentDB = self::dbInstance();

        $dbList = $this->dbList();
        if ( !$dbList ||
             empty( $dbList ) )
        {
            $this->setBlockHasError();
        }
        // Class and object count list
        foreach( $this->dbList() as $dbEntry )
        {
            $this->changeAccess( $dbEntry['site_access'] );

            $emptyDB = null;
            eZDB::setInstance( $emptyDB );

            $siteAccessDB = self::dbInstance( true );
            if ( !$siteAccessDB )
            {
                $this->appendToBlock( 'DB initialization failed for site access: ' . $dbEntry['site_access'] );
            }
            else
            {
                $totalCount = 0;
                $this->appendToBlock( 'Content statistics (' . $dbEntry['site_access'] . '):' );
                $classList = eZContentClass::fetchList();
                $sortedList = array();
                if( $classList )
                {
                    foreach( $classList as $class )
                    {
                        $sortedList[$class->attribute( 'object_count' )][] = $class->attribute( 'name' );
                    }
                }
                krsort( $sortedList );
                foreach( $sortedList as $count => $nameList )
                {
                    foreach( $nameList as $name )
                    {
                        $this->appendToBlock( 'Class: ' . $name . str_repeat( ' ', 20 - min( strlen( $name ), 20 ) ) . ' - object count: ' . $count );
                        $totalCount += $count;
                    }
                }
                // If count is larger than 250000, raise error.
                if ( $totalCount > 250000 )
                {
                    $this->setBlockHasError();
                }
                $this->appendToBlock( 'Total eZContentObject count: ' . $totalCount );

                // Shop order stats
                $this->appendToBlock( '' );
                $this->appendToBlock( 'Shop statistics (' . $dbEntry['site_access'] . '):' );
                $this->appendToBlock( 'Active order count: ' . eZOrder::activeCount() );

                // Role stats
                $this->appendToBlock( '' );
                $this->appendToBlock( 'Role statistics (' . $dbEntry['site_access'] . '):' );
                $this->appendToBlock( 'Role count: ' . eZRole::roleCount() );
            }
        }

        $this->commitBlock();
    }

    /*!
     Check the default designs for added templates.
     Check the following designs:
     design/admin
     design/admin2
     design/base
     design/standard
    */
    function checkExistingDesigns()
    {
        $this->startBlock( 'Checking for new and modified templates in default designs' );
        $this->CLI->output( 'Checking for new and modified templates in default designs' );

        $aDefaultDesigns = array(
            array( "design", "admin" ),
            array( "design", "admin2" ),
            array( "design", "base" ),
            array( "design", "standard" ) );

        $aFiles = array();
        $md5File = 'share/filelist.md5';
        // use both an array and a bigstring of existing filenames
        //$aShippedFiles = eZFile::splitLines( $md5File );
        $aShippedFiles = file( $md5File, FILE_IGNORE_NEW_LINES );
        $sShippedFiles = ":" . implode( ":", $aShippedFiles ) . ":";

        foreach( $aDefaultDesigns as $aDesignPath )
        {
            $sPath = ezDir::path( $aDesignPath );
            $aFiles = ezDir::recursiveFind( $sPath, "\.tpl" );

            foreach( $aFiles as $sFilename )
            {
                $md5Key = md5_file( $sFilename );
                $sItem = $md5Key . "  " . $sFilename;
                if( !in_array( $sItem, $aShippedFiles ) )
                {
                    if( false === stristr( $sShippedFiles, $sFilename ) )
                    {
                        $this->setBlockIsSubOptimal();
                        $this->appendToBlock( "The template: '" . $sFilename . "' is not part of the default design." );
                    }
                    else
                    {
                        // an MD5 mismatch between the default and current template
                        $this->setBlockHasPotentialError();
                        $this->appendToBlock( "The default template: '" . $sFilename . "' has been modified." );
                    }
                }
                else
                {
                    // the template exists in the default design and is not modified
                }
            }
        }
        $this->commitBlock();
    }

    /*!
     Check existing files
    */
    function checkExistingFiles()
    {
        $this->startBlock( 'eZ Publish PHP MD5 check' );
        $aIgnoreEntries = array( "autoload/ezp_extension.php" );
        $this->CLI->output( 'Checking eZ Publish PHP files' );
        $md5File = 'share/filelist.md5';
        $checkResult = eZMD5::checkMD5Sums( $md5File );
        // filter out entries that we're not interested in
        $checkResult = array_diff( $checkResult, $aIgnoreEntries );

        $ignoreFileList = $this->getFileList( array( "settings/siteaccess/admin" ) );
        $checkResult = array_diff( $checkResult, $ignoreFileList );

        if ( count( $checkResult ) != 0 )
        {
            $this->setBlockHasError();
            $this->appendToBlock( 'Some PHP files has been altered from the eZ Publish ' . eZPublishSDK::version() . ' version.' );
            $this->appendToBlock( 'Please correct these files.' );
            foreach( $checkResult as $file )
            {
                $this->appendToBlock( $file );
            }
        }
        else if ( count( file( $md5File ) ) < 20 )
        {
            $this->setBlockHasError();
            $this->appendToBlock( 'MD5 sum list corrupted. Please make sure: ' . $md5File . ' is correct.' );
            $this->appendToBlock( 'You might not be running a correct distribution ( download from: http://ez.no/download )' );
        }
        else
        {
            $this->appendToBlock( 'MD5 sum check completed successfully.' );
        }

        $this->commitBlock();
    }

    /*Returns list of all files recursively in the given directory .
     It accepts directory name with path from eZ Publish root directory and returns all files in that drectory tree.
     getFileList( array( "settings" ) ) : will return all files in settings directory of eZ Publish.
     getFileList( array( "extension" ) ) : will return all file in extension directory tree structure.
     getFileList( array( "." ) ) : This will return all file in eZ Publish root directory with complete sub tree list.
     getFileList( array( "settings/override", "extension"  ) ) : will returns all files in "settings/override" and "extension" directory.
    */
    function getFileList( $FileAndDirlist = array() )
    {
        $FileList = array();
        foreach( $FileAndDirlist as $FileAndDir )
        {
            $FileList = array_merge( $FileList, eZDir::recursiveFind( $FileAndDir, "." ) );
        }
        return( $FileList );
    }

    /*!
     Check cronjob.ini.append.php,

     [CronjobSettings]
     ExtensionDiretories[]

    */
    function checkCronjobExtensionSettings()
    {
        $this->startBlock( 'Cronjob extension settings' );
        $ini = eZINI::instance();
        $this->appendToBlock( 'Default siteaccess: ' . $ini->variable( 'SiteSettings', 'DefaultAccess' ) );

        $checkedFilenameList = array();
        $fileMatchList = array( 'cronjob\.ini\.append',
                                'cronjob\.ini\.append\.php' );
        foreach( $this->extensionList() as $extension )
        {
            foreach( $fileMatchList as $fileMatch )
            {
                foreach( array_unique( array_merge( eZDir::recursiveFind( 'extension' . $extension . '/', $fileMatch ),
                                                    eZDir::recursiveFind( 'settings/override', $fileMatch ) ) ) as $filename )
                {
                    if ( in_array( $filename, $checkedFilenameList ) )
                    {
                        continue;
                    }
                    $checkedFilenameList[] = $filename;
                    $fileContent = file_get_contents( $filename );
                    foreach( explode( "\n", $fileContent ) as $line )
                    {
                        if ( trim( $line ) == 'ExtensionDirectories[]' )
                        {
                            $this->setBlockHasError();
                            $this->appendToBlock( 'Cronjob ExtensionDiretories cleared in in ' . $filename );
                        }
                    }
                }
            }
        }

        $this->commitBlock();
    }

    /*!
     Check template information
    */
    function checkExtensionInformation()
    {
        $this->startBlock( 'Extension checks' );
        $ini = eZINI::instance();
        $this->appendToBlock( 'Default siteaccess: ' . $ini->variable( 'SiteSettings', 'DefaultAccess' ) );

        $fileMatchList = array( '\.php',
                                '\.ini.*' );
        foreach( $this->extensionList() as $extension )
        {
            foreach( $fileMatchList as $fileMatch )
            {
                foreach( eZDir::recursiveFind( 'extension/' . $extension . '/', $fileMatch ) as $filename )
                {
                    $this->appendFile( $filename );
                }
            }
        }

        $this->commitBlock();
    }

    function canCreateNetworkLog( $logFileName = 'network.log' )
    {
        $logPath = 'var/log';
        $canWrite = ezDir::isWriteable( $logPath );
        if ( $canWrite )
        {
            $logPath = eZDir::path( array( $logPath, 'network' ) );
            if ( !file_exists( $logPath ) )
            {
                ezDir::mkdir( $logPath );
            }

            $canWrite = ezDir::isWriteable( $logPath );
            if ( $canWrite )
            {
                $logPath = eZDir::path( array( $logPath, $logFileName ) );
                if ( file_exists( $logPath ) )
                {
                    $canWrite = eZFile::isWriteable( $logPath );
                }
            }
        }

        if ( !$canWrite )
        {
            $this->CLI->error( 'No access to create/write by path:  ' . $logPath );
            $this->CLI->output( "It is important that you run this script with the same user\n" .
                                "that will run the Apache service. If not possible, then make sure\n" .
                                "that the Apache service has read and write access\n" .
                                "to the whole eZ Publish installation." );
        }

        return $canWrite;
    }

    /**
     * Check for missusage of references.
     */
    public function checkReferences()
    {
        $this->startBlock( 'Check PHP reference usage' );
        $this->CLI->output( 'Check PHP reference usage' );

        // entries are concated to not trigger warnings if this script is checked
        $referenceList = array( '='.'& $contentObjectAttribute->contentClassAttribute(',
                                '='.'& eZTextCodec::instance(',
                                '='.'& eZShopAccountHandler::instance(',
                                '='.'& eZBasket::currentBasket(',
                                '='.'& $attribute->content()',
                                '='.'& eZINI::instance(',
                                '='.'& $contentObjectAttribute->content(',
                                '='.'& eZContentObject::fetch(',
                                '='.'& eZContentClassAttribute::fetchFilteredList(',
                                '='.'& $class->fetchAttributes(',
                                '='.'& $contentObject->dataMap(',
                                '='.'& $object->dataMap(',
                                '='.'& $object->contentClass(',
                                '='.'& $object->version(',
                                '='.'& eZINI::create(',
                                '='.'& templateInit(',
                                '='.'& $Params["Module"]',
                                '='.'& $tpl->fetch(',
                                '='.'& $Params[\'Module\']',
                                '='.'& eZHTTPFile::fetch(',
                                '='.'& imageInit(',
                                '='.'& eZNodeviewfunctions::generateNodeView(',
                                '='.'& eZOrder::active',
                                '='.'& eZObjectRelationListType::parseXML',
                                '='.'& eZHTTPTool::instance(',
                                '='.'& $tpl->elementValue(',
                                '='.'& eZScript::instance(',
                                '='.'& eZCLI::instance(',
                                '='.'& eZDB::instance(',
                                '&'.'$tpl',
                                '&'.'$db',
                                '&'.'$http',
                                '&'.'$object' );

        foreach( $this->extensionList() as $extension )
        {
            $fileList = eZDir::recursiveFind( eZDir::path( array( eZExtension::baseDirectory(),
                                                                  $extension ) ),
                                              '.*\.php' );

            foreach( $fileList as $filename )
            {
                $fileContent = file_get_contents( $filename );
                foreach( $referenceList as $reference )
                {
                    if ( strpos( $fileContent, $reference ) !== false )
                    {
                        $this->setBlockHasPotentialError();
                        $this->appendToBlock( 'Invalid reference usage found: ' . $filename . ': ' . $reference );
                    }
                }
            }
        }

        $this->commitBlock();
    }

    /**
     * Check PHP lint
     */
    function checkPHPLint()
    {
        // If php exec is not set, skip this test
        if ( !$this->PHPExecutable )
        {
            return;
        }
        $this->startBlock( 'Check PHP file syntax' );
        $this->CLI->output( 'Check PHP file syntax' );
        foreach( $this->extensionList() as $extension )
        {
            $fileList = eZDir::recursiveFind( eZDir::path( array( eZExtension::baseDirectory(),
                                                                  $extension ) ),
                                              '.*\.php' );
            foreach( $fileList as $filename )
            {
                $command = $this->PHPExecutable . ' -l ' . $filename;
                $output = array();
                exec( $command, $output );
                $fileOK = false;
                foreach( $output as $line )
                {
                    if ( strpos( $line, 'No syntax errors detected in' ) !== false )
                    {
                        $fileOK = true;
                    }
                }
                if ( !$fileOK )
                {
                    $this->setBlockHasError();
                    $this->appendToBlock( 'Syntax error detected in file: ' . $filename . "\n" . var_export( $output, 1 ) . "\n\n" );
                }
            }
        }
        $this->commitBlock();
    }

   /*!
    *      Check function list
    *           */
    function checkFunctionList()
    {
        $this->startBlock( 'Function list access checking block' );
        $this->CLI->output( 'Checking Function list access checking block' );
        $moduleList = eZDir::recursiveFind( eZDir::path( array( eZExtension::baseDirectory(), $this->extension() ) ), "\module.php" );
        $functiomLists = array();
        $functionNotExists = array();
        $moduleIni = eZINI::instance( 'module.ini' );
        $availableModules = $moduleIni->variable( 'ModuleSettings', 'ModuleList' );
        $pathSeperator = eZSys::fileSeparator();

        foreach ( $moduleList as $modulePath )
        {
            // Skip modules that are not active
            $modulePathArray = explode( $pathSeperator, $modulePath, -1 );
            if ( !in_array( $modulePathArray[ count( $modulePathArray ) -1 ], $availableModules ) )
                continue;

            unset($FunctionList);
            unset( $ViewList );
            include( $modulePath );
            $function_list = array();
            if(isset($FunctionList))
            {
                $function_list = array_keys( $FunctionList );
            }

            foreach( $ViewList as $view_name => $view )
            {
                if(isset( $view['functions'] ))
                {
                    $function_array = array();

                    // Convert to array if not
                    if ( !is_array( $view[ 'functions' ] ) )
                    {
                        $view[ 'functions' ] = array( $view[ 'functions' ] );
                    }

                    foreach( $view['functions'] as $func )
                    {
                        $function_array = array_merge( $function_array, explode( ' ', $func ) );
                    }

                    if( !empty( $function_array )  )
                    {
                        // Remove duplicates
                        $function_array = array_unique( $function_array );

                        foreach( $function_array as $func )
                        {
                            $reservedWords = array( 'or', 'and' );
                            if ( in_array( $func, $reservedWords ) )
                            {
                                continue;
                            }

                            if( !in_array( $func,$function_list ) )
                            {
                                $this->setBlockHasError();
                                $this->appendToBlock( "The view '" . $view_name . "' in '" . $modulePath . "' has a function '" . $func . "' which is not defined in the 'Function' array." );
                            }
                        }
                    }
                }
            }
        }
        $this->commitBlock();
    }


    /*!
     Check mbstring PHP extension
    */
    function checkMBString()
    {
        $this->startBlock( 'Mod MBString check' );
        $result = eZMBStringMapper::hasMBStringExtension();
        if ( !$result  )
        {
            $this->setBlockHasError();
            $this->appendToBlock( 'MBString PHP module not found. But it is recommended because it will improve the performance of eZ Publish.' );
        }
        $this->commitBlock();
    }

    /*!
     Check mCrypt PHP extension
    */
    function checkMCrypt()
    {
        $this->startBlock( 'Mod mCrypt check' );
        if ( !( function_exists( 'mcrypt_encrypt' ) &&
                function_exists( 'mcrypt_decrypt' ) &&
                function_exists( 'mcrypt_get_iv_size' ) ) )
        {
            $this->setBlockIsSubOptimal();
            $this->appendToBlock( 'mCrypt PHP module not found. This module will add a slight performance gain when running eZ Network patching.' );
        }
        $this->commitBlock();
    }

    /*!
     Check Suhosin PHP extension
    */
    function checkSuhosin()
    {
        $this->startBlock( 'Mod Suhosin check' );
        if ( extension_loaded( 'suhosin' ) )
        {
            $this->setBlockIsSubOptimal();
            $this->appendToBlock( 'Suhosin PHP module found. It is not recommended to use this module then running eZ Publish.' );
        }
        $this->commitBlock();
    }

    /*!
     Check DB connection
    */
    function checkDBConnection()
    {
        $this->startBlock( 'Database settings check' );
        foreach( $this->siteAccessArray() as $siteAccess)
        {
            $this->changeAccess( $siteAccess );
            $db = self::dbInstance( true );
            if ( !$db ||
                 !$db->isConnected() )
            {
                // check if the server is "localhost", and if so, retry with 127.0.0.1
                // otherwise, record the problem
                $ini = eZINI::instance();
                if( "localhost" == strtolower( $ini->variable( 'DatabaseSettings', 'Server' ) ) )
                {
                    $db = self::dbInstance( true, array( "server" => "127.0.0.1" ) );
                    if( $db && $db->isConnected() )
                    {
                        // made a connection at 127.0.0.1, so skip to end of loop, and don't emit error message
                        $this->appendToBlock( "DB Connection failed for 'localhost' but worked for '127.0.0.1' for SiteAccess: " . $siteAccess );
                        continue;
                    }
                }
                // emit error message
                $this->InvalidSiteAccessList['db'][$siteAccess] = true;
                $errorMessage = 'Could not initialize database for SiteAccess : ' . $siteAccess;
                $this->setBlockHasError();
                $this->appendToBlock( $errorMessage );
            }
            elseif ( $db->databaseName() == 'mysql' )
            {
                // InnoDB availability checking for MySQL
                $dbTableStatusArray = $db->arrayQuery( "SHOW TABLE STATUS;" );
                foreach ( $dbTableStatusArray as $dbTableStatus )
                {
                    if ( $dbTableStatus['Engine'] != 'InnoDB' )
                    {
                        $errorMessage = 'Not InnoDB database table "' . $dbTableStatus['Name'] . '" detected for SiteAccess : ' . $siteAccess;
                        $this->setBlockHasError();
                        $this->appendToBlock( $errorMessage );
                    }
                }
            }
        }
        $this->commitBlock();
    }

    /*!
     Check DB charset
    */
    function checkDBCharset()
    {
        $this->startBlock( 'Database charset check' );
        foreach( $this->siteAccessArray() as $siteAccess)
        {
            $this->changeAccess( $siteAccess );

            $siteAccessINI = eZINI::instance();

            if ( isset( $this->InvalidSiteAccessList['db'] ) &&
                 isset( $this->InvalidSiteAccessList['db'][$siteAccess] ) )
            {
                continue;
            }

            $db = self::dbInstance( true );

            $dbCharset = $siteAccessINI->variable( 'DatabaseSettings', 'Charset' );
            if ( !$dbCharset )
            {
                $dbCharset = eZTextCodec::internalCharset();
            }
            $actualDBCharset = $dbCharset;
            if ( !$db )
            {
                $this->appendToBlock( 'SiteAccess : ' . $siteAccess . ' - Invalid database.' );
                $this->setBlockHasError();
            }
            else
            {
                if ( !$db->checkCharset( $dbCharset, $actualDBCharset ) )
                {
                    $this->setBlockHasError();
                }
                $this->appendToBlock( 'SiteAccess : ' . $siteAccess . ' - DB charset set to : "' . $dbCharset . '", DB Charset is : "' . $actualDBCharset . '"' );
            }
        }
        $this->commitBlock();
    }

    /*!
     Check template washing
    */
    function checkTemplateWashing()
    {
        $this->startBlock( 'Template wash check' );

        /* Regexp with Lookahead condition ( '{$' or '{:$' )  and Lookbehind condition '}'.
         * That means: Find all words that have '{$' in the beggining and '}' as the end of this word.
         * This words/strings can have all literals/numeric and symbols like '.(|)_' and space
         * The regexp can find words like '{$var}', '{$object.name}', '{$var.contentclass_attribute_name|wash}', '{$var|ezimage}', {:$item}
         * But it doesn't find strings like '{$attribute.data_int|choose( '', 'checked="checked"' )}' or '{"1x1.gif"|ezimage}'
         */

        // Second regExp is used for searching strings like {$:item}
        $varRegexpArray = array( '/(?<={\$)[a-zA-Z0-9.(|)_\s]+(?=})/',
                                 '/(?<={\:\$)[a-zA-Z0-9.(|)_\s]+(?=})/' );

        /* The words/strings like '{$var|ezimage}' should not be washed,
         * for that we are using $washExceptionArray that contains some excepted tpl operators.
         * And if we find one of those operators in matched string we should not continue checking.
         */
        $washExceptionArray = array( 'ezurl',
                                     'ezroot',
                                     'ezimage',
                                     'ezdesign',
                                     'l10n',
                                     'count',
                                     'si',
                                     'flag_icon',
                                     'simpletags',
                                     'wordtoimage',
                                     'autolink' );

        $washOperatorArray = array( '|wash',
                                    '|explode' );

        $checkedFileArray = array();
        foreach( $this->siteAccessArray() as $siteAccess)
        {
            $this->changeAccess( $siteAccess );

            $this->CLI->output( "Processing SiteAccess ( washing ) : " . $this->CLI->stylize( 'emphasize', $siteAccess ) );

            foreach ( $this->designList() as $design )
            {
                $this->CLI->output( " - Design : " . $this->CLI->stylize( 'emphasize', $design ) );

                foreach ( $this->templateList( $design ) as $filename )
                {
                    if ( in_array( $filename, $checkedFileArray ) )
                    {
                        continue;
                    }
                    $checkedFileArray[] = $filename;
                    //$lines = eZFile::splitLines( $filename );
                    $lines = file( $filename, FILE_IGNORE_NEW_LINES );
                    if ( !$lines )
                    {
                        $this->setBlockHasError();
                        $this->appendToBlock( 'Empty file : ' . $filename );
                        continue;
                    }

                    foreach( $lines as $lineCount => $line )
                    {
                        // Go thought regexp array
                        foreach ( $varRegexpArray as $varRegexp )
                        {
                            // Find all variables that should be washed
                            if ( preg_match_all( $varRegexp, $line, $matches ) )
                            {
                                foreach ( $matches[0] as $match )
                                {
                                    $checkWash = true;
                                    // Matched string can contain other operators like 'ezimage' or 'ezurl'
                                    // so we should not check for the 'wash' in this cases
                                    foreach( $washExceptionArray as $washException )
                                    {
                                        if ( strpos( $match, $washException ) !== false )
                                        {
                                            $checkWash = false;
                                            break;
                                        }
                                    }
                                    // We should not continue checking
                                    if ( !$checkWash )
                                    {
                                        continue;
                                    }

                                    $isWashed = false;
                                    // Check if all found vars have been washed
                                    foreach( $washOperatorArray as $washOperator )
                                    {
                                        // Find wash operator in $match variable string
                                        $washPosition = strpos( $match, $washOperator );
                                        if ( $washPosition !== false )
                                        {
                                            $isWashed = true;
                                            break;
                                        }
                                    }

                                    if ( !$isWashed )
                                    {
                                        //it may be missing wash operators but it does not automatically mean that is is flawed
                                        $this->setBlockHasPotentialError();
                                        $this->appendToBlock( 'Missing wash operator in file [' . ( $lineCount + 1 ) . '] : ' . $filename . '; ' . $match );
                                    }
                                } // foreach matches
                            } // if preg_match_all
                        } // foreach $varRegexpArray
                    } // foreach lines from tpl file
                } // foreach tpl list
            } // foreach designs
        } // foreach siteaccesses

        $this->commitBlock();
    }

    /*!
     Check for unique classes in ezinfo.php files in extensions.
    */
    function checkUniqueExtensionPHPInfoClassNames()
    {
        $this->startBlock( 'unique class names in ezinfo.php files' );
        $this->CLI->output( 'Checking unique class names in ezinfo.php files' );

        $eZInfoClassNameList = array();

        // Go through all available extensions and determine not unique class names
        foreach( $this->extensionList() as $extension )
        {
            $infoFileName = eZDir::path( array( eZExtension::baseDirectory(), $extension, 'ezinfo.php' ) );
            if ( !file_exists( $infoFileName ) )
            {
                continue;
            }

            $className = false;
            // This regExp is used for searching strings like "class some_class {"
            $classNameRegexp = '/(?<=class\s)[a-zA-Z0-9_\s]+(?={)/';
            $fileContent = file_get_contents( $infoFileName );
            if ( preg_match( $classNameRegexp, $fileContent, $match ) )
            {
                $className = isset( $match[0] ) ? trim( $match[0] ) : false ;
            }

            if ( !$className )
            {
                continue;
            }

            if ( isset( $eZInfoClassNameList[$className] ) )
            {
                $this->setBlockHasError();
                $this->appendToBlock( 'Extension ' . $extension . ', ezinfo.php contains class name ' . $className .' is already used in ezinfo.php of extension ' . $eZInfoClassNameList[$className] );
            }
            else
            {
                $eZInfoClassNameList[$className] = $extension;
            }
        }

        $this->commitBlock();
    }

    /*!
     Check for ezinfo.php files in extensions.
    */
    function checkExtensionPHPInfo()
    {
        $this->startBlock( 'ezinfo.php in extensions' );
        $this->CLI->output( 'Checking for ezinfo.php in extensions' );

        $useOwnExtensionInfoMethod = true;
        if ( in_array( 'extensioninfo', get_class_methods( 'eZExtension' ) ) )
        {
            $useOwnExtensionInfoMethod = false;
        }

        foreach( $this->extensionList() as $extension )
        {
            if ( $useOwnExtensionInfoMethod )
            {
                $extensionInfo = self::extensionInfo( $extension );
            }
            else
            {
                $extensionInfo = eZExtension::extensionInfo( $extension );
            }

            if ( !$extensionInfo )
            {
                $this->setBlockHasError();
                $this->appendToBlock( 'Extension ' . $extension . ' does not contain a valid ezinfo.php file.' );
            }
            else
            {
                $checkArray = array( 'name',
                                     'version',
                                     'copyright' );
                foreach( $checkArray as $check )
                {
                    if ( !( isset( $extensionInfo[$check] ) ||
                            isset( $extensionInfo[ucfirst( $check )] ) ) )
                    {
                        $this->setBlockHasError();
                        $this->appendToBlock( 'Extension ' . $extension . ', ezinfo.php does not contain a valid ' . $check );
                    }
                    else if ( isset( $extensionInfo[ucfirst( $check )] ) )
                    {
                        $this->appendToBlock( ucfirst( $check ) . ': ' . $extensionInfo[ucfirst( $check )] );
                    }
                    else if ( isset( $extensionInfo[$check] ) )
                    {
                        $this->appendToBlock( ucfirst( $check ) . ': ' . $extensionInfo[$check] );
                    }
                }
                $optionalCheckArray = array( 'info_url' );
                foreach( $optionalCheckArray as $check )
                {
                    if ( isset( $extensionInfo[ucfirst( $check )] ) )
                    {
                        $this->appendToBlock( ucfirst( $check ) . ': ' . $extensionInfo[ucfirst( $check )] );
                    }
                    else if ( isset( $extensionInfo[$check] ) )
                    {
                        $this->appendToBlock( ucfirst( $check ) . ': ' . $extensionInfo[$check] );
                    }
                }
            }
        }

        $this->commitBlock();
    }

    /*!
     Check PHP files

     Check <?php ?> start/end
     Check license header
     Check total php file name count
    */
    function checkPHPFiles()
    {
        $this->startBlock( 'PHP file check' );
        $this->CLI->output( 'Checking PHP files' );
        $globalINIFileList = array();

        foreach( $this->extensionList() as $extension )
        {
            $classificationTools = new eZXNetExtensionClassificationTools( $extension );

            // Get possible PHP file list, and remove files in exclusion list.
            $phpFileList = $classificationTools->phpFileList();
            $phpFileList[] = eZDir::path( array( eZExtension::baseDirectory(), $this->extension(), 'ezinfo.php' ) );

            $this->appendToBlock( 'Extension ' . $extension . ' PHP file count: ' . count( $phpFileList ) );

            foreach( $phpFileList as $phpFile )
            {
                $phpContent = file_exists( $phpFile ) ? file_get_contents( $phpFile ) : false;
                if ( strpos( $phpContent, '<?' ) === false ||
                     !( strpos( $phpContent, '<?' ) < 1000 ) ||
                     strpos( $phpContent, '?>', strlen( $phpContent ) - 10 ) === false )
                {
                    $this->appendToBlock( 'PHP file does not seem to have correct <?php ... ?> start and end, ' . $phpFile );
                    $this->setBlockHasError();
                }
                elseif ( !$classificationTools->havePHPHeaderLicense( $phpFile ) )
                {
                    $this->appendToBlock( 'PHP file does not seem to have correct license header, ' . $phpFile );
                    $this->setBlockHasError();
                }
            }
        }

        $this->commitBlock();
    }


    /*!
     Get list of specific site access settings in extensions.
    */
    function checkSiteAccessSetttingsList()
    {
        $this->startBlock( 'Site access settings in extensions' );
        $this->CLI->output( 'Checking site access settings in extensions' );

        foreach( $this->extensionList() as $extension )
        {
            $siteAccessSettingsFound = false;
            $pathList = glob( eZDir::path( array( eZExtension::baseDirectory(),
                                                  $extension,
                                                  'settings',
                                                  'siteaccess',
                                                  '*' ) ),
                              GLOB_ONLYDIR );
            foreach( $pathList as $path )
            {
                $siteAccessSettingsList = array_merge( eZDir::recursiveFind( $path, '.*\.ini\.append' ),
                                                       eZDir::recursiveFind( $path, '.*\.ini\.append\.php' ) );
                if ( count( $siteAccessSettingsList ) )
                {
                    $siteAccessSettingsFound = true;
                    $fileString = '';
                    foreach( $siteAccessSettingsList as $key => $siteAccessSettings )
                    {
                        $siteAccessSettingsList[$key] = array_pop( explode( eZSys::fileSeparator(), $siteAccessSettings ) );
                    }
                    $this->appendToBlock( 'Extension ' . $extension . ' has site access settings for ' .
                                          array_pop( explode( eZSys::fileSeparator(), $path ) ) . ' ( ' .
                                          implode( ', ', $siteAccessSettingsList ) . ' )' );
                }
            }
            if ( !$siteAccessSettingsFound )
            {
                $this->appendToBlock( 'Extension ' . $extension . ' has no site access specific settings.' );
            }
        }

        $this->commitBlock();
    }

    /*!
     Check INI settings for bad configurations,
     ViewCaching=disabled
     TemplateCompile=disabled
     DebugRedirection=enabled
    */
    function checkBadExtensionSettings()
    {
        $this->startBlock( 'Extension development INI settings' );
        $this->CLI->output( 'Checking extension for development settings' );

        $searchList = array( 'TemplateCompile=disabled',
                             'ViewCaching=disabled',
                             'DebugRedirection=enabled' );

        foreach( $this->extensionList() as $extension )
        {
            $settingsPath = eZDir::path( array( eZExtension::baseDirectory(),
                                                $extension,
                                                'settings' ) );
            $iniFiles = array_merge( eZDir::recursiveFind( $settingsPath, '.*\.ini\.append' ),
                                     eZDir::recursiveFind( $settingsPath, '.*.ini\.append\.php' ) );
            foreach( $iniFiles as $filename )
            {
                foreach( explode( "\n", file_get_contents( $filename ) ) as $line )
                {
                    $line = trim( $line );
                    foreach( $searchList as $term )
                    {
                        if ( strpos( $line, $term ) === 0 )
                        {
                            $this->setBlockHasPotentialError();
                            $this->appendToBlock( 'INI file: ' . $filename . ' contains illegal settings: ' . $term );
                        }
                    }
                }
            }
        }
        $this->commitBlock();
    }

    /*!
     Check INI files

     Check <?php ?> start/end
     Check .ini.append.php filename
     Check total ini file name count
    */
    function checkINIFiles()
    {
        $this->startBlock( 'INI file check' );
        $this->CLI->output( 'Checking INI files' );
        $globalINIFileList = array();

        foreach( $this->extensionList() as $extension )
        {
            $iniFileList = array_merge( eZDir::recursiveFind( eZDir::path( array( eZExtension::baseDirectory(),
                                                                                  $extension,
                                                                                  'settings' ) ),
                                                              '.*\.ini\.append' ),
                                        eZDir::recursiveFind( eZDir::path( array( eZExtension::baseDirectory(),
                                                                                  $extension,
                                                                                  'settings' ) ),
                                                              '.*\.ini\.append\.php' ) );
            $globalINIFileList = array_merge( $globalINIFileList, $iniFileList );

            $this->appendToBlock( 'Extension ' . $extension . ' ini file count: ' . count( $iniFileList ) );

            foreach( $iniFileList as $iniFile )
            {
                if ( eZFile::suffix( $iniFile ) == 'append' )
                {
                    $this->appendToBlock( 'INI file ' . $iniFile . ' does not have a .php ending.' );
                    $this->setBlockHasError();
                }
                $iniContent = file_get_contents( $iniFile );
                if ( strpos( $iniContent, '<?' ) === false ||
                     !( strpos( $iniContent, '<?' ) < 1000 ) ||
                     strpos( $iniContent, '?>', strlen( $iniContent ) - 10 ) === false )
                {
                    $this->appendToBlock( 'INI file does not seem to have correct <?php ... ?> start and end, ' . $iniFile );
                    $this->setBlockHasError();
                }
            }
        }

        $this->commitBlock();
    }

    /*!
     Check custom INI settings

     Check if there are extra settings/blocks
    */
    function checkCustomINISettings()
    {
        $this->startBlock( 'Custom settings check' );
        $this->CLI->output( 'Checking custom INI settings' );

        // This setting files allow the creation of custom settings.
        $settingExceptionArray = array( 'override.ini',
                                        'cronjob.ini',
                                        'image.ini',
                                        'toolbar.ini',
                                        'extendedattributefilter.ini',
                                        'browse.ini',
                                        'layout.ini',
                                        'menu.ini',
                                        'shop.ini',
                                        'dbschema.ini'
                                        );

        foreach( $this->extensionList() as $extension )
        {
            $iniFileList = array_merge( eZDir::recursiveFind( eZDir::path( array( eZExtension::baseDirectory(),
                                                                                  $extension,
                                                                                  'settings' ) ),
                                                              '.*\.ini\.append' ),
                                        eZDir::recursiveFind( eZDir::path( array( eZExtension::baseDirectory(),
                                                                                  $extension,
                                                                                  'settings' ) ),
                                                              '.*\.ini\.append\.php' ),
                                        eZDir::recursiveFind( eZDir::path( array( eZExtension::baseDirectory(),
                                                                                  $extension,
                                                                                  'settings' ) ),
                                                              '.*\.ini' ) );

            $extensionRootDir = eZDir::path( array( eZExtension::baseDirectory(), $extension, 'settings' ) );
            $globalError = false;
            foreach( $iniFileList as $iniFile )
            {
                // Extract the file name with '.append' or '.append.php'
                preg_match( '/[^\/]*$/', $iniFile, $matches );
                if ( !isset( $matches[0] ) )
                    continue;

                // We skip exception files when testing for custom settings
                $checkSetting = true;
                foreach ( $settingExceptionArray as $settingException )
                {
                    if ( strpos( $matches[0], $settingException ) !== false )
                    {
                        $checkSetting = false;
                        break;
                    }
                }

                // If current file is exception file we skip it
                if ( !$checkSetting )
                {
                    continue;
                }

                // Extract the file name without '.append' or '.append.php'
                $iniFileName = array_shift( explode( '.', $matches[0] ) ) . '.ini';

                // If $iniFileName is custom settings file
                if ( !file_exists( eZDir::path( array( 'settings', $iniFileName ) ) ) )
                    continue;

                $useLocalOverrides = false;

                // cache these so that we can restore them after this test -
                // otherwise remaining tests are corrupted
                $key1 = "eZINIGlobalInstance-settings-$iniFileName-$useLocalOverrides";
                $key2 = "eZINIGlobalIsLoaded-settings-$iniFileName-$useLocalOverrides";

                $val1 = isset( $GLOBALS[$key1] ) ? $GLOBALS[$key1] : NULL;
                $val2 = isset( $GLOBALS[$key2] ) ? $GLOBALS[$key2] : NULL;

                // We have to clear globals cache for direct access to default settings without overrides
                unset( $GLOBALS[ $key1 ] );
                unset( $GLOBALS[ $key2 ] );

                $ini        = eZINI::instance( $iniFileName, $extensionRootDir, null, false, $useLocalOverrides, true );
                $defaultINI = eZINI::instance( $iniFileName, 'settings', null, false, $useLocalOverrides, true );

                $namedArray = $ini->getNamedArray();
                $namedDefaultArray = $defaultINI->getNamedArray();
                $blockWasNotFound = false;
                foreach ( $namedArray as $nameOfBlock => $variables )
                {
                    if ( !isset( $namedDefaultArray[$nameOfBlock] ) )
                    {
                        $this->appendToBlock( 'EXTRA configuration block was found: ' . $iniFile . ':[' . $nameOfBlock . ']' );
                        $blockWasNotFound = true;
                        $globalError = true;
                    }
                    if ( !$blockWasNotFound )
                    {
                        foreach ( $variables as $variableName => $value )
                        {
                            if ( !isset( $namedDefaultArray[$nameOfBlock][$variableName] ) )
                            {
                                $this->appendToBlock( 'EXTRA setting was found: ' . $iniFile . ':[' . $nameOfBlock . '].' . $variableName );
                                $globalError = true;
                            }
                        }
                    }
                }

                // restore these
                if ( $val1 !== NULL )
                {
                    $GLOBALS[$key1] = $val1;
                }
                if ( $val2 !== NULL )
                {
                    $GLOBALS[$key2] = $val2;
                }
            }
            if ( $globalError )
            {
                $this->appendToBlock( 'All custom settings has to be stored in custom INI files' );
                $this->setBlockHasError();
            }
        }

        $this->commitBlock();
    }

    /*!
     Check number of design templates.
    */
    function checkDesignTemplateCount()
    {
        $this->startBlock( 'Design template count' );
        $this->CLI->output( 'Checking template count' );

        foreach( $this->extensionList() as $extension )
        {
            $this->appendToBlock( 'Extension ' . $extension . ' contains ' . count( $this->templateFileList( $extension ) ) .
                                  ' design template(s)' );
        }

        if ( !$this->extension() )
        {
            $this->appendToBlock( 'Total template count: ' . count( $this->templateFileList() ) );
        }

        $this->commitBlock();
    }

    /*!
     Check number of datatypes.
    */
    function checkDataTypeCount()
    {
        $this->startBlock( 'Extension data type count' );
        $this->CLI->output( 'Checking datatype count' );

        $contentINI = eZINI::instance( 'content.ini' );
        $extensionList = $contentINI->variable( 'DataTypeSettings', 'ExtensionDirectories' );
        $globalDataTypeList = $this->globalDataTypeList();

        foreach( $this->dataTypeExtensionList() as $extension )
        {
            if ( $this->extension() &&
                 $this->extension() != $extension )
            {
                continue;
            }

            $dataTypeList = glob( eZDir::path( array( eZExtension::baseDirectory(),
                                                      $extension,
                                                      'datatypes',
                                                      '*' ) ),
                                  GLOB_ONLYDIR );
            $newTypeList = array();
            foreach( $dataTypeList as $key => $path )
            {
                $dataType = array_pop( explode( eZSys::fileSeparator(), $path ) );
                if ( in_array( $dataType, $globalDataTypeList ) )
                {
                    $newTypeList[] = $dataType;
                }
            }
            if ( count( $newTypeList ) )
            {
                $this->appendToBlock( 'Extension ' . $extension . ' contains : ' . count( $dataTypeList ) . ' datatype(s). ( ' .
                                      implode( ', ', $newTypeList ) . ' )' );
            }
        }

        if ( !$this->extension() )
        {
            $this->appendToBlock( 'Total data type count ( including eZ Publish ) : ' . count( $globalDataTypeList ) );
        }

        $this->commitBlock();
    }

    /*!
     Check extension type.

     Extension type definition:
     A - Contains settings, translations and document
     B - Contains settings + template design + images
     C - Contains non-template code for reading and processing data for presentation.
     D - Contains non-template code for storing data.
    */
    function checkExtensionType()
    {
        $this->startBlock( 'Classifying extension type' );
        $this->CLI->output( 'Checking extension types' );

        foreach( $this->extensionList() as $extension )
        {
            $fileResultList = array();
            $extensionType = eZXNetExtensionClassificationTools::EXTENSION_TYPE_A;
            $classificationTools = new eZXNetExtensionClassificationTools( $extension );

            // Get possible PHP file list, and remove files in exclusion list.
            $phpFileList = $classificationTools->phpFileList();

            // Type C or D extension.
            if ( $phpFileList )
            {
                $extensionType = eZXNetExtensionClassificationTools::EXTENSION_TYPE_C;
                foreach( $phpFileList as $phpFile )
                {
                    $writeCodeList = $classificationTools->getPHPWriteCodeList( $phpFile );
                    if ( $writeCodeList )
                    {
                        $fileResultList[$phpFile][] = '*Detected write code:';
                        foreach( $writeCodeList as $writeCode )
                        {
                            $fileResultList[$phpFile][] = $writeCode;
                        }
                        if ( $this->extension() )
                        {
                            //write code may appear, but it does not automatically mean that it is flawed
                            $this->setBlockHasPotentialError();
                        }
                        $extensionType = eZXNetExtensionClassificationTools::EXTENSION_TYPE_D;
                    }
                }
            }

            if ( $extensionType == eZXNetExtensionClassificationTools::EXTENSION_TYPE_A )
            {
                $templateFileList = $classificationTools->templateFileList( $extension );
                if ( $templateFileList )
                {
                    $extensionType = eZXNetExtensionClassificationTools::EXTENSION_TYPE_B;
                }
            }

            $this->appendToBlock( '--- Extension is of type: ' . $extensionType . ' ---' );
            if ( count( $fileResultList ) )
            {
                foreach( $fileResultList as $filename => $fileResult )
                {
                    $this->appendToBlock( 'Potential issue detected with file: ' . $filename );
                    foreach( $fileResult as $result )
                    {
                        $this->appendToBlock( $result );
                    }
                }
            }
        }
        $this->commitBlock();
    }

    /*!
     Check extension file count. This function will check a specific function if setExtension is set.
     If not, it'll check all extensions.
    */
    function checkExtensionFileCount()
    {
        $this->startBlock( 'Check extension file count' );
        $this->CLI->output( 'Checking extension file count' );

        foreach( $this->extensionList() as $extension )
        {
            $fileCount = count( eZDir::recursiveFind( eZDir::path( array( eZExtension::baseDirectory(),
                                                                          $extension ) ),
                                                      ".*" ) );
            $this->appendToBlock( 'Extension file count ( ' . $extension . ' ):' .
                                  $fileCount . ' files.' );
        }
        $this->commitBlock();
    }

    /*!
     Check extension size. This function will check a specific function if setExtension is set.
     If not, it'll check all extensions.
    */
    function checkExtensionSize()
    {
        $this->startBlock( 'Check extension size' );
        $this->CLI->output( 'Checking extension sizes' );

        foreach( $this->extensionList() as $extension )
        {
            $extensionSize = 0;
            foreach( eZDir::recursiveFind( eZDir::path( array( eZExtension::baseDirectory(),
                                                               $extension ) ),
                                           ".*" ) as $filename )
            {
                $extensionSize += filesize( $filename );
            }
            $suffix = array( 'B',
                             'KB',
                             'MB',
                             'GB',
                             'TB',
                             'PB' );
            $offset = 0;
            while ( $extensionSize >= 1024 )
            {
                ++$offset;
                $extensionSize = $extensionSize / 1024;
            }
            $this->appendToBlock( 'Extension size ( ' . $extension . ' ):' .
                                  number_format( $extensionSize,
                                                 ( $offset ? 2 : 0)
                                                 ,
                                                 ',',
                                                 '.' ) .
                                  ' ' . $suffix[$offset] );
        }
        $this->commitBlock();
    }

    /*!
     Check for symlinks in extension directory ( may cause updateting and installation to crash )
    */
    function checkForSymlinks()
    {
        $this->startBlock( 'Symlink check' );

        $extensionDir = eZExtension::baseDirectory();
        if ( is_link( $extensionDir ) )
        {
            $this->setBlockHasError();
            $this->appendToBlock( 'Symlink detected: ' . $extensionDir );
        }
        foreach( glob( $extensionDir . '/*' ) as $file )
        {
            if ( is_link( $file ) )
            {
                $this->setBlockHasPotentialError();
                $this->appendToBlock( 'Symlink detected: ' . $file );
            }
        }
        $this->commitBlock();
    }

    /*!
     Check templates for 'attribute(show)'
    */
    function checkTemplateAttributeShow()
    {
        $this->startBlock( 'Template |attribute( check' );

        $searchString = array( '|attribute(' );
        $checkedFileArray = array();

        foreach( $this->siteAccessArray() as $siteAccess)
        {
            $this->changeAccess( $siteAccess );

            $this->CLI->output( "Processing SiteAccess ( attribute show ) : " . $this->CLI->stylize( 'emphasize', $siteAccess ) );

            foreach ( $this->designList() as $design )
            {
                $this->CLI->output( " - Design : " . $this->CLI->stylize( 'emphasize', $design ) );

                foreach ( $this->templateList( $design ) as $filename )
                {
                    if ( in_array( $filename, $checkedFileArray ) )
                    {
                        continue;
                    }
                    $checkedFileArray[] = $filename;

                    foreach( file( $filename, FILE_IGNORE_NEW_LINES ) as $lineCount => $line )
                    {
                        foreach( $searchString as $needle )
                        {
                            $pos = strpos( $line, $needle );
                            if ( $pos !== false &&
                                 ! ( strpos( $line, '{*' ) < $pos &&
                                     strpos( $line, '*}' ) > $pos ) )
                            {
                                $this->setBlockHasPotentialError();
                                $this->appendToBlock( $needle . ' operator in file [' . ( $lineCount + 1 ) . ':' . $pos . '] : ' . $filename );
                                break;
                            }
                        }
                    }
                }
            }
        }

        $this->commitBlock();
    }

    /*!
     Check template compilation
    */
    function checkTemplateCompilation()
    {
        $this->startBlock( 'Template validation' );

        foreach( $this->siteAccessArray() as $siteAccess)
        {
            $this->changeAccess( $siteAccess );

            $this->CLI->output( "Validating SiteAccess : " . $this->CLI->stylize( 'emphasize', $siteAccess ) );

            foreach ( $this->designList() as $design )
            {
                $this->CLI->output( " - Design : " . $this->CLI->stylize( 'emphasize', $design ) );

                foreach ( $this->templateList( $design ) as $idx => $filename )
                {
                    $this->checkTemplate( $filename );
                    echo "\r " . $this->progressArray( $idx );
                }
                echo "\r";
            }
        }

        $this->commitBlock();
    }

    /**
     * Check patch command
     * Note that in the case of FreeBSD and Solaris, where gpatch is required,
     * a special case is required because "gpatch -v" returns, eg, "patch 2.5.4"/"patch 2.6"
     * Note that eZNetUtils::checkAccessToExecutables() contains parallel behaviours.
     */
    function checkPatchCommand()
    {
        $sOSName = $this->getOSName();
        $output = array();

        $this->startBlock( 'System Patch command check' );
        if ( 'Solaris' == $sOSName || "FreeBSD" == $sOSName )
        {
            $command = 'gpatch -v';
            $cmdResult = exec( $command, $output );
            $patchOK = ( preg_match( '/patch [0-9]\.[0-9]/', $output[0], $matches ) == 1 );
            if ( $patchOK === false )
            {
                $this->setBlockHasError();
                $this->appendToBlock( "'gpatch' is required on " . $sOSName ); // log error message
            }
        }
        else
        {
            $command = 'patch -v';
            $cmdResult = exec( $command, $output );
            $patchOK = ( preg_match( '/patch [0-9]\.[0-9]/', $output[0], $matches ) == 1 );
            if ( $patchOK === false )
            {
                $this->setBlockHasError();
                $this->appendToBlock( "'patch' is required on " . $sOSName );
            }
        }
        $this->commitBlock();
    }

    /**
     * Check diff command
     * Matches ouput from 'diff -v', normally:
     * "diff (GNU diffutils) 2.8.1" or "diff (GNU diffutils) 2.9"
     * But returns different format on FreeBSD
     */
    function checkDiffCommand()
    {
        $sOSName = $this->getOSName();
        $output = array();

        $this->startBlock( 'System Diff command check' );
        $command = 'diff -v';
        $cmdResult = exec( $command, $output );

        if ( "FreeBSD" == $sOSName )
        {
            $diffOK = ( preg_match( '/diff - GNU diffutils [a-zA-Z0-9_]* [0-9]\.[0-9]/', $output[0], $matches ) == 1 );

            if ( $diffOK === false )
            {
                unset($matches);
                $diffOK = ( preg_match( '/diff \(GNU diffutils\) [0-9]\.[0-9]/', $output[0], $matches ) == 1 );
            }
        }
        else
        {
            $diffOK = ( preg_match( '/diff \(GNU diffutils\) [0-9]\.[0-9]/', $output[0], $matches ) == 1 );
        }

        if ( $diffOK === false )
        {
            $this->setBlockHasError();
            $this->appendToBlock( "'GNU diff' is required on " . $sOSName );
        }

        $this->commitBlock();
    }


    /*!
     Check image handling
    */
    function checkImageHandling()
    {
        $this->startBlock( 'Image handling' );
        $success = false;
        $imageINI = eZINI::instance( 'image.ini' );

        // Check for gd.
        if ( $imageINI->variable( 'GD', 'IsEnabled' ) == 'true' )
        {
            if ( function_exists( 'gd_info' ) )
            {
                $gdInfo = gd_info();
                $success = true;
                $this->appendToBlock( 'GD detected: ' . $gdInfo['GD Version'] );
            }
            else
            {
                $this->appendToBlock( 'GD not detected.' );
            }
        }
        else
        {
            $this->appendToBlock( 'GD not enabled.' );
        }

        // Check for ImageMagick.
        $imDetected = false;
        if ( $imageINI->variable( 'ImageMagick', 'IsEnabled' ) == 'true' )
        {
            $convertPath = $imageINI->variable( 'ImageMagick', 'ExecutablePath' );
            $executableList = array( $imageINI->variable( 'ImageMagick', 'Executable' ),
                                     $imageINI->variable( 'ImageMagick', 'ExecutableWin32' ) );
            foreach( $executableList as $executable )
            {
                $matches = array();
                $command = eZDir::path( array( $convertPath, $executable ) ) . ' -version';
                $output = array();
                $cmdResult = exec( $command, $output );
                $patchOK = ( preg_match( '/^Version: ImageMagick ([0-9]\.[0-9]\.[0-9])/', $output[0], $matches ) == 1 );
                if ( $patchOK )
                {
                    $success = true;
                    $imDetected = true;
                    $this->appendToBlock( 'ImageMagic detected: ' . $matches[1] );
                    break;
                }
            }
            if ( !$imDetected )
            {
                $this->appendToBlock( 'ImageMagic not detected.' );
            }
        }
        else
        {
            $this->appendToBlock( 'ImageMagic not enabled.' );
        }

        if ( !$success )
        {
            $this->setBlockHasError();
        }
        $this->commitBlock();
    }

    /*!
     Check monitor connection
    */
    function checkMonitorConnection()
    {
        $ini = eZINI::instance( 'sync.ini' );
        $server = $ini->variable( 'NetworkSettings', 'Server' );
        if ( $ini->variable( 'NetworkSettings', 'Port' ) == 80  )
            $portList = array( 80 );
        else
            $portList = array( 'ssl', 443, 80 );

        $this->startBlock( 'eZ.no monitor connection' );
        foreach ( $portList as $port )
        {
            $monitorConnected = self::checkMonitorConnectionTo( $server, $port );
            if ( $monitorConnected )
            {
                break;
            }
        }
        if ( !$monitorConnected )
        {
            $this->appendToBlock( 'Connection to soap server failed.' );
            $this->setBlockHasError();
        }
        $this->commitBlock();
    }

    /*!
     Check SOAP connection to a given server&port
    */
    function checkMonitorConnectionTo( $serverAddress, $port )
    {
        $soapClient = new eZSOAPClient( $serverAddress, '/', $port );
        $request = new eZSOAPRequest( 'certifyTest', 'ez.no', array() );
        $soapResponse = $soapClient->send( $request );
        if ( !$soapResponse or $soapResponse->faultString() != 'Method not found' )
        {
            return false;
        }
        return true;
    }

    /*!
     Check safe mode
    */
    function checkSafeMode()
    {
        $this->startBlock( 'PHP Safe mode' );
        if ( ini_get( 'safe_mode' ) != 0 )
        {
            $this->setBlockHasError();
            $this->appendToBlock( 'PHP seems to be running in safe mode.' );
        }
        $this->commitBlock();
    }

    /*!
     Check ini write
    */
    function checkINIWrite()
    {
        $iniSetOK = ini_set( 'memory_limit', '500M' );
        $this->startBlock( 'System set INI check' );
        if ( $iniSetOK === false )
        {
            $this->setBlockHasError();
        }
        $this->commitBlock();
    }

    /*!
     Get name of logfile
    */
    function getLogFileName()
    {
        return  $this->CertifyLogFile;
    }

    /*!
     Proghress array
    */
    function progressArray( $idx )
    {
        return $this->ProgressArray[ $idx % count( $this->ProgressArray ) ];
    }

    /*!
     Set SiteAccessArray

     \param SiteAccessArray
    */
    function setSiteAccessArray( $siteAccessArray )
    {
        $this->SiteAccessArray = $siteAccessArray;
    }

    /*
     Get SiteAccessArray

     \return SiteAccessArray
    */
    function siteAccessArray()
    {
        return $this->SiteAccessArray;
    }

    /*!
     \private

     Get a list of all databases used by this installation of eZ Publish.
     This function loops through every site access, and reads DB settings.

     \return array of database settings, db name as key. Empty array if none exists.
         The array also caintains name of the site access.
    */
    function dbList()
    {
        $currentSiteAccess = $GLOBALS['eZCurrentAccess']['name'];
        $currentDB = self::dbInstance();

        $dbParameterList = array();
        foreach( $this->siteAccessArray() as $siteAccess )
        {
            $this->changeAccess( $siteAccess );
            $emptyDB = null;
            eZDB::setInstance( $emptyDB );

            $siteAccessDB = self::dbInstance( true );
            if ( !$siteAccessDB ||
                 !$siteAccessDB->isConnected() )
            {
                $this->appendToBlock( 'Could not instantiate DB for site access: ' . $siteAccess );
                $this->setBlockHasError();
            }
            else
            {
                $dbParameterList[$siteAccessDB->DB] = array( 'site_access' => $siteAccess,
                                                             'database' => $siteAccessDB->DB );
                $siteAccessDB->close();
            }
        }

        $this->changeAccess( $currentSiteAccess );
        eZDB::setInstance( $currentDB );

        return $dbParameterList;
    }

    /*!
     \static
     Get the current DB instance.

     \param if set to true, get the new instance

     \return DB instance. If the DB instance fails, or the required DB extension is not loaded, return false.
    */
    function dbInstance( $newInstance = false, $databaseParameters = false )
    {
        $retVal = false;
        $dbModuleNameMap = array( 'ezmysql'      => array( 'mysql' ),
                                  'ezmysqli' => array( 'mysqli' ),
                                  'ezpostgresql' => array( 'pgsql' ),
                                  'ezoracle'     => array( 'oci8', 'oracle' )
                                  );
        $siteINI = eZINI::instance();
        $dbImplementation = trim( $siteINI->variable( 'DatabaseSettings', 'DatabaseImplementation' ) );
        if ( in_array( $dbImplementation, array_keys( $dbModuleNameMap ) ) )
        {
            foreach ( $dbModuleNameMap[$dbImplementation] as $module )
            {
                if ( extension_loaded( $module ) )
                {
                    if ( $newInstance )
                    {
                        $retVal = eZDB::instance( false, $databaseParameters, true );
                    }
                    else
                    {
                        $retVal = eZDB::instance();
                    }
                    break;
                }
                else
                {
                    $this->appendToBlock( 'Extension "' . $module . '" is not loaded.' );
                    $this->setBlockHasError();
                }
            }
        }
        else
        {
            $this->appendToBlock( 'Database implementation "' . $dbImplementation . '" not supported. Choose one of: ' . implode( ', ', array_keys( $dbModuleNameMap ) ) );
            $this->setBlockHasError();
        }

        return $retVal;
    }

    /*!
     Set specified extension. Setting an extension automaticly removes checksum and site name from the certify log.

     \param extension name
    */
    function setExtension( $extension )
    {
        $this->Extension = $extension;
        $this->IncludeChecksum = false;
        $this->IncludeSiteData = false;
    }

    /*!
     Get extension name. This will return false if no extension has been specified. It'll return the name
     of the extension if a specific extension has been specified.

     \return extension name
    */
    function extension()
    {
        return $this->Extension;
    }

    /*!
     Get unique extension list

     \return extension list.
    */
    function extensionList()
    {
        // Which extensions should not be certified if $this->includeEZPExtensions() is false
        $exceptionList = array( 'ezdhtml', 'ezodf', 'ezwebin', 'ezflow', 'ezpaypal', 'ezoe',
                                'ezjscore', 'ezwt', 'ezoracle', 'ezcomments', 'ezfind', 'ezgmaplocation',
                                'ezmbpaex', 'ezmultiupload', 'ezscriptmonitor', 'ezstarrating', 'ezsurvey',
                                'ezsi', 'ezteamroom', 'ezevent', 'ezxmlinstaller', 'ezlightbox', 'ezxmlexport' );

        $extensionList = array();
        foreach( $this->siteAccessArray() as $siteAccess )
        {
            $this->changeAccess( $siteAccess );
            foreach( eZExtension::activeExtensions() as $extension )
            {
                if ( !$this->includeEZPExtensions() and in_array( $extension, $exceptionList ) )
                {
                    continue;
                }

                if ( $this->extension() &&
                     $this->extension() != $extension )
                {
                    continue;
                }

                $extensionList[] = $extension;
            }
        }

        return array_unique( $extensionList );
    }

    /*!
     Get unique datatype extension list

     \return datatype extension list.
    */
    function dataTypeExtensionList()
    {
        $extensionList = array();
        foreach( $this->siteAccessArray() as $siteAccess )
        {
            $this->changeAccess( $siteAccess );
            $contentINI = eZINI::instance( 'content.ini' );
            foreach( $contentINI->variable( 'DataTypeSettings', 'ExtensionDirectories' ) as $extension )
            {
                if ( $this->extension() &&
                     $this->extension() != $extension )
                {
                    continue;
                }
                $extensionList[] = $extension;
            }
        }
        return array_unique( $extensionList );
    }

    /*!
     Get global datatype list

     \return global datatype list
    */
    function globalDataTypeList()
    {
        $dataTypeList = array();
        foreach( $this->siteAccessArray() as $siteAccess )
        {
            $this->changeAccess( $siteAccess );
            $contentINI = eZINI::instance( 'content.ini' );
            $dataTypeList = array_merge( $dataTypeList,
                                         $contentINI->variable( 'DataTypeSettings', 'AvailableDataTypes' ) );
        }

        return array_unique( $dataTypeList );
    }

    /*!
     Get list of template names.

     \param extension ( if extension is defined, return only design templates from extension. If not,
            return all design templates )

     \return list of template names.
    */
    function templateFileList( $extension = false )
    {
        if ( $extension )
        {
            return eZDir::recursiveFind( eZDir::path( array( eZExtension::baseDirectory(),
                                                             $extension ) ),
                                         "\.tpl" );
        }
        else
        {
            return array_merge( eZDir::recursiveFind( eZExtension::baseDirectory(),
                                                      "\.tpl" ),
                                eZDir::recursiveFind( 'design',
                                                      "\.tpl" ) );
        }
    }

    /*!
     ( copied and recopied from eZNetUtils::getOSName )
     Get opearting system name.

     \return operating system. ( Windows, Linux ( default ) or Solaris ( also SunOS ) )
    */
    function getOSName()
    {
        if ( strtolower( substr( PHP_OS, 0, 3 ) ) == 'win' )
        {
            return 'Windows';
        }
        else if ( strtolower( substr( PHP_OS, 0, 5 ) ) == 'sunos' ||
                  strtolower( substr( PHP_OS, 0, 7 ) ) == 'solaris' )
        {
            return 'Solaris';
        }
        else if ( strtolower( PHP_OS ) == 'freebsd' )
        {
            return 'FreeBSD';
        }
        return 'Linux';
    }

    function extensionInfo( $extension )
    {
        $infoFileName = eZDir::path( array( eZExtension::baseDirectory(), $extension, 'ezinfo.php' ) );
        if ( file_exists( $infoFileName ) )
        {
            include_once( $infoFileName );
            $className = $extension . 'Info';
            if ( is_callable( array( $className, 'info' ) ) )
            {
                $result = call_user_func_array( array( $className, 'info' ), array() );
                if ( is_array( $result ) )
                {
                    return $result;
                }
            }
        }

        return null;
    }

    function setIncludeEZPDesign( $flag = true )
    {
        $this->IncludeEZPDesign = $flag;
        return true;
    }

    function includeEZPDesign()
    {
        return $this->IncludeEZPDesign;
    }

    /*!
     Sets include standard eZP extensions flag
    */
    function setIncludeEZPExtensions( $flag = true )
    {
        $this->IncludeEZPStandardExtensions = $flag;
    }

    /*!
     \return should standard eZP extensions be included to certify process
    */
    function includeEZPExtensions()
    {
        return $this->IncludeEZPStandardExtensions;
    }


    /// Private variables
    var $BlockStack = array();
    var $BlockStackCount = 0;
    var $CertyfiLogFile;
    var $tpl;
    var $InvalidTemplateCompileList;
    var $CLI;
    var $fp;
    var $Log;
    var $LogFileList;
    var $ProgressArray = array( '-', '\\', '|', '/' );
    var $SiteAccessArray;
    var $InvalidSiteAccessList = array();
    var $ErrorCode = 0;

    /// Variables for handling specific automated extension approval
    var $Extension = false;
    var $IncludeChecksum = true;
    var $IncludeSiteData = true;
    var $IncludeEZPDesign = false;
    // Do not attempt to certify the extensions distributed with eZ Publish
    var $IncludeEZPStandardExtensions = false;
}

/*!
 Extension classification helper class
*/
class eZXNetExtensionClassificationTools
{
    /*!
     Constructor

     \param extension name
    */
    function eZXNetExtensionClassificationTools( $extension )
    {
        $this->Extension = $extension;
    }

    /*!
     Get list of template names.

     \return list of template names.
    */
    function templateFileList( $extension = false )
    {
        return eZDir::recursiveFind( eZDir::path( array( eZExtension::baseDirectory(),
                                                         $this->extension() ) ),
                                     "\.tpl" );
    }

    /*!
     Get PHP file list, excluding ini files.

     \return list of eZ Publish file names
    */
    function phpFileList()
    {
        $phpFileList = eZDir::recursiveFind( eZDir::path( array( eZExtension::baseDirectory(),
                                                                 $this->extension() ) ),
                                             "\.php" );
        $excludeSuffixList = array( '.ini.append.php',
                                    'ezinfo.php' );
        foreach( $phpFileList as $key => $phpFile )
        {
            foreach( $excludeSuffixList as $excludeSuffix )
            {
                $offset = strlen( $phpFile ) - strlen( $excludeSuffix );
                if ( strpos( $phpFile, $excludeSuffix, $offset ) !== false )
                {
                    unset( $phpFileList[$key] );
                    break;
                }
            }
        }

        return $phpFileList;
    }

    /*!
     Check if a PHP file contains code for writing data to disk, eZ Publish or mysql.

     \param filename

     \return list of detected code, including line/column. Example:
         [12:4]:  fwrite( $fp, 'a' );
         Return false if nothing was detected.
    */
    function getPHPWriteCodeList( $filename )
    {
        $content = file_get_contents( $filename );
        if ( !$content )
        {
            return false;
        }

        $writeCodeList = array( 'PHP' => array( 'fwrite', 'file_put_contents',
                                                'chgrp', 'chown', 'chmod',
                                                'copy', 'delete', 'flock',
                                                'fputcsv', 'fputs', 'ftruncate',
                                                'mkdir', 'unlink', 'symlink' ),
                                'SQL' => array( 'insert into', 'update', 'delete' ),
                                'eZPublish_Dynamic' => array( 'setattribute',
                                                              'store', 'sync', 'storeObject' ),
                                'eZPublish_Static' => array( 'create' ) );
        $resultList = array();
        foreach( explode( "\n", $content ) as $idx => $originalLine )
        {
            $line = strtolower( $originalLine );
            $commentStrPos = strpos( $line, '//' ) === false ? 10000 : strpos( $line, '//' );
            foreach( $writeCodeList['PHP'] as $phpCode )
            {
                $strPos = strpos( $line, $phpCode . '(' );
                if ( $strPos !== false )
                {
                    if ( $strPos < $commentStrPos )
                    {
                        $resultList[] = '[' . ( $idx + 1 ) . ':' . $strPos . ']:' . $originalLine;
                    }
                }
            }
            foreach( $writeCodeList['SQL'] as $sql )
            {
                $strPos = strpos( $line, $sql . ' ' );
                if ( $strPos !== false )
                {
                    if ( $strPos < $commentStrPos )
                    {
                        $resultList[] = '[' . ( $idx + 1 ) . ':' . $strPos . ']:' . $originalLine;
                    }
                }
            }
            foreach( $writeCodeList['eZPublish_Dynamic'] as $eZCode )
            {
                $strPos = strpos( $line, '->' . $eZCode . '(' );
                if ( $strPos !== false )
                {
                    if ( $strPos < $commentStrPos )
                    {
                        $resultList[] = '[' . ( $idx + 1 ) . ':' . $strPos . ']:' . $originalLine;
                    }
                }
            }
            foreach( $writeCodeList['eZPublish_Static'] as $eZCode )
            {
                $strPos = strpos( $line, '::' . $eZCode . '(' );
                if ( $strPos !== false )
                {
                    if ( $strPos < $commentStrPos )
                    {
                        $resultList[] = '[' . ( $idx + 1 ) . ':' . $strPos . ']:' . $originalLine;
                    }
                }
            }
        }

        return count( $resultList ) ? $resultList : false;
    }

    /*!
     Check if a PHP file contains a header of commented lines

     \param filename

     \return list of detected lines
         Return false if nothing was detected.
    */
    function havePHPHeaderLicense( $filename )
    {
        $content = file_get_contents( $filename );
        if ( !$content )
        {
            return false;
        }

        $codeStartPos = strpos( $content, '<?' );
        $codeEndPos = strpos( $content, '?>', strlen( $content ) - 10 );
        if ( $codeStartPos === false ||
             !( $codeStartPos < 1000 ) ||
             $codeEndPos === false )
        {
            return false;
        }

        if ( $codeStartPos === strpos( $content, '<?php' ) )
        {
            $codeStartPos += 3;
        }

        $content = substr( $content, $codeStartPos + 2, $codeEndPos - $codeStartPos - 2 );

        $licenseWordList = array( array( 'license', 'licence' ),
                                  array( 'copyright' ) );
        $insideComment = false;
        foreach( explode( "\n", $content ) as $idx => $originalLine )
        {
            $originalLine = trim( $originalLine );  // hack to allow for Windows-style line-endings
            $line = strtolower( $originalLine );
            do
            {
                $endLine = '';
                if ( $insideComment !== true )
                {
                    $commentStart = strpos( $line, '//' );
                    $multilineCommentStart = strpos( $line, '/*' );
                    if ( $multilineCommentStart !== false &&
                         ( $commentStart === false || $multilineCommentStart < $commentStart ) )
                    {
                        $commentStart = $multilineCommentStart;
                        $insideComment = true;
                    }

                    if ( $line !== '' )
                    {
                        if ( $commentStart === false ) // if header is finished
                        {
                            return false;
                        }

                        $line = substr( $line, $commentStart + 2 );
                    }
                }

                if ( $insideComment === true )
                {
                    $commentEndPos = strpos( $line, '*/' );
                    if ( $commentEndPos !== false )
                    {
                        $endLine = substr( $line, $commentEndPos + 2 );
                        $line = substr( $line, 0, $commentEndPos );
                        if ( $line === false )
                        {
                            $line = '';
                        }
                        $insideComment = false;
                    }
                }

                $leftLicenseWordList = $licenseWordList;
                foreach( $licenseWordList as $wordVersionIndex => $wordVersionList )
                {
                    foreach ( $wordVersionList as $wordVersion )
                    {
                        if ( strpos( $line, $wordVersion ) )
                        {
                            unset( $leftLicenseWordList[$wordVersionIndex] );
                            break;
                        }
                    }
                }

                if ( $leftLicenseWordList === array() ) // all the words are found at least 1 time
                {
                    return true;
                }
                $licenseWordList = $leftLicenseWordList;

                $line = $endLine;
            }
            while ( $endLine !== '' );
        }

        return false;
    }

    /*!
     Get extension name

     \return extension name
    */
    function extension()
    {
        return $this->Extension;
    }

    /// Class variables
    var $Extension = null;

    // Class constants
    const EXTENSION_TYPE_A = 'A';
    const EXTENSION_TYPE_B = 'B';
    const EXTENSION_TYPE_C = 'C';
    const EXTENSION_TYPE_D = 'D';

    protected $PHPExecutable = null;
}
?>
