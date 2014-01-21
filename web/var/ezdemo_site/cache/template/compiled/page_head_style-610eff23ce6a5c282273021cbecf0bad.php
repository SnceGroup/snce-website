<?php
// URI:       design/admin/templates/page_head_style.tpl
// Filename:  design/admin/templates/page_head_style.tpl
// Timestamp: 1383940876 (Fri Nov 8 21:01:16 CET 2013)
$oldSetArray_130240229d9b9ab8e20771128040b6af = isset( $setArray ) ? $setArray : array();
$setArray = array();
$tpl->Level++;
if ( $tpl->Level > 40 )
{
$text = $tpl->MaxLevelWarning;$tpl->Level--;
return;
}
$eZTemplateCompilerCodeDate = 1074699607;
if ( !defined( 'EZ_TEMPLATE_COMPILER_COMMON_CODE' ) )
include_once( 'var/ezdemo_site/cache/template/compiled/common.php' );

$text .= '
';
// if begins
unset( $if_cond );
unset( $if_cond1 );
unset( $if_cond1 );
$if_cond1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'load_css_file_list', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['load_css_file_list'] : null;
if (! isset( $if_cond1 ) ) $if_cond1 = NULL;
while ( is_object( $if_cond1 ) and method_exists( $if_cond1, 'templateValue' ) )
    $if_cond1 = $if_cond1->templateValue();
$if_cond = !isset( $if_cond1 );unset( $if_cond1 );
if (! isset( $if_cond ) ) $if_cond = NULL;
while ( is_object( $if_cond ) and method_exists( $if_cond, 'templateValue' ) )
    $if_cond = $if_cond->templateValue();

if ( $if_cond )
{
$text .= '  ';
// def $load_css_file_list
if ( $tpl->hasVariable( 'load_css_file_list', $rootNamespace ) )
{
    $tpl->warning( 'def', "Variable 'load_css_file_list' is already defined.", array (
  0 => 
  array (
    0 => 4,
    1 => 2,
    2 => 104,
  ),
  1 => 
  array (
    0 => 4,
    1 => 34,
    2 => 136,
  ),
  2 => 'design/admin/templates/page_head_style.tpl',
) );
    $tpl->setVariable( 'load_css_file_list', true, $rootNamespace );
}
else
{
    $tpl->setLocalVariable( 'load_css_file_list', true, $rootNamespace );
}

}
unset( $if_cond );
// if ends

// if begins
unset( $if_cond );
unset( $if_cond1 );
unset( $if_cond1 );
$if_cond1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'load_main_css', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['load_main_css'] : null;
if (! isset( $if_cond1 ) ) $if_cond1 = NULL;
while ( is_object( $if_cond1 ) and method_exists( $if_cond1, 'templateValue' ) )
    $if_cond1 = $if_cond1->templateValue();
$if_cond = !isset( $if_cond1 );unset( $if_cond1 );
if (! isset( $if_cond ) ) $if_cond = NULL;
while ( is_object( $if_cond ) and method_exists( $if_cond, 'templateValue' ) )
    $if_cond = $if_cond->templateValue();

if ( $if_cond )
{
$text .= '  ';
// def $load_main_css
if ( $tpl->hasVariable( 'load_main_css', $rootNamespace ) )
{
    $tpl->warning( 'def', "Variable 'load_main_css' is already defined.", array (
  0 => 
  array (
    0 => 8,
    1 => 2,
    2 => 180,
  ),
  1 => 
  array (
    0 => 8,
    1 => 29,
    2 => 207,
  ),
  2 => 'design/admin/templates/page_head_style.tpl',
) );
    $tpl->setVariable( 'load_main_css', true, $rootNamespace );
}
else
{
    $tpl->setLocalVariable( 'load_main_css', true, $rootNamespace );
}

}
unset( $if_cond );
// if ends

// if begins
unset( $if_cond );
unset( $if_cond1 );
unset( $if_cond1 );
$if_cond1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'admin_theme', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['admin_theme'] : null;
if (! isset( $if_cond1 ) ) $if_cond1 = NULL;
while ( is_object( $if_cond1 ) and method_exists( $if_cond1, 'templateValue' ) )
    $if_cond1 = $if_cond1->templateValue();
$if_cond = !isset( $if_cond1 );unset( $if_cond1 );
if (! isset( $if_cond ) ) $if_cond = NULL;
while ( is_object( $if_cond ) and method_exists( $if_cond, 'templateValue' ) )
    $if_cond = $if_cond->templateValue();

if ( $if_cond )
{
$text .= '  ';
// def $admin_theme
if ( $tpl->hasVariable( 'admin_theme', $rootNamespace ) )
{
    $tpl->warning( 'def', "Variable 'admin_theme' is already defined.", array (
  0 => 
  array (
    0 => 12,
    1 => 2,
    2 => 249,
  ),
  1 => 
  array (
    0 => 12,
    1 => 23,
    2 => 270,
  ),
  2 => 'design/admin/templates/page_head_style.tpl',
) );
    $tpl->setVariable( 'admin_theme', '', $rootNamespace );
}
else
{
    $tpl->setLocalVariable( 'admin_theme', '', $rootNamespace );
}

}
unset( $if_cond );
// if ends

// if begins
unset( $if_cond );
unset( $if_cond );
$if_cond = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'admin_theme', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['admin_theme'] : null;
if (! isset( $if_cond ) ) $if_cond = NULL;
while ( is_object( $if_cond ) and method_exists( $if_cond, 'templateValue' ) )
    $if_cond = $if_cond->templateValue();

if ( $if_cond )
{
$text .= '  ';
// def $admin_theme_css
unset( $var );
unset( $var2 );
unset( $var2 );
$var2 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'admin_theme', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['admin_theme'] : null;
if (! isset( $var2 ) ) $var2 = NULL;
while ( is_object( $var2 ) and method_exists( $var2, 'templateValue' ) )
    $var2 = $var2->templateValue();
while ( is_object( $var2 ) and method_exists( $var2, 'templateValue' ) )
    $var2 = $var2->templateValue();
$var = ( 'theme/' . $var2 . '.css' );
unset( $var2 );
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
if ( $tpl->hasVariable( 'admin_theme_css', $rootNamespace ) )
{
    $tpl->warning( 'def', "Variable 'admin_theme_css' is already defined.", array (
  0 => 
  array (
    0 => 16,
    1 => 2,
    2 => 300,
  ),
  1 => 
  array (
    0 => 16,
    1 => 65,
    2 => 363,
  ),
  2 => 'design/admin/templates/page_head_style.tpl',
) );
    $tpl->setVariable( 'admin_theme_css', $var, $rootNamespace );
}
else
{
    $tpl->setLocalVariable( 'admin_theme_css', $var, $rootNamespace );
}

}
else
{
$text .= '  ';
// def $admin_theme_css
if ( $tpl->hasVariable( 'admin_theme_css', $rootNamespace ) )
{
    $tpl->warning( 'def', "Variable 'admin_theme_css' is already defined.", array (
  0 => 
  array (
    0 => 18,
    1 => 2,
    2 => 375,
  ),
  1 => 
  array (
    0 => 18,
    1 => 44,
    2 => 417,
  ),
  2 => 'design/admin/templates/page_head_style.tpl',
) );
    $tpl->setVariable( 'admin_theme_css', 'theme/rounded.css', $rootNamespace );
}
else
{
    $tpl->setLocalVariable( 'admin_theme_css', 'theme/rounded.css', $rootNamespace );
}

}
unset( $if_cond );
// if ends

// if begins
unset( $if_cond );
unset( $if_cond );
$if_cond = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'load_main_css', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['load_main_css'] : null;
if (! isset( $if_cond ) ) $if_cond = NULL;
while ( is_object( $if_cond ) and method_exists( $if_cond, 'templateValue' ) )
    $if_cond = $if_cond->templateValue();

if ( $if_cond )
{
$text .= '  
  ';
// if begins
unset( $if_cond );
unset( $if_cond );
$if_cond = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'load_css_file_list', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['load_css_file_list'] : null;
if (! isset( $if_cond ) ) $if_cond = NULL;
while ( is_object( $if_cond ) and method_exists( $if_cond, 'templateValue' ) )
    $if_cond = $if_cond->templateValue();

if ( $if_cond )
{
$text .= '    ';
unset( $var );
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
$varData = array( 'value' => $var );
$tpl->processOperator( 'ezcss_load',
                       array (
  0 => 
  array (
    0 => 
    array (
      0 => 6,
      1 => 
      array (
        0 => 'array',
        1 => 
        array (
          0 => 
          array (
            0 => 1,
            1 => 'core.css',
            2 => false,
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            0 => 1,
            1 => 'debug.css',
            2 => false,
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            0 => 1,
            1 => 'pagelayout.css',
            2 => false,
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            0 => 1,
            1 => 'content.css',
            2 => false,
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            0 => 4,
            1 => 
            array (
              0 => '',
              1 => 2,
              2 => 'admin_theme_css',
            ),
            2 => false,
          ),
        ),
        6 => 
        array (
          0 => 
          array (
            0 => 1,
            1 => 'theme/yui_datatable.css',
            2 => false,
          ),
        ),
        7 => 
        array (
          0 => 
          array (
            0 => 1,
            1 => 'theme/yui_menu.css',
            2 => false,
          ),
        ),
        8 => 
        array (
          0 => 
          array (
            0 => 1,
            1 => 'theme/yui_container.css',
            2 => false,
          ),
        ),
        9 => 
        array (
          0 => 
          array (
            0 => 1,
            1 => 'theme/modalwindow.css',
            2 => false,
          ),
        ),
        10 => 
        array (
          0 => 
          array (
            0 => 6,
            1 => 
            array (
              0 => 'ezini',
              1 => 
              array (
                0 => 
                array (
                  0 => 1,
                  1 => 'StylesheetSettings',
                  2 => false,
                ),
              ),
              2 => 
              array (
                0 => 
                array (
                  0 => 1,
                  1 => 'BackendCSSFileList',
                  2 => false,
                ),
              ),
              3 => 
              array (
                0 => 
                array (
                  0 => 1,
                  1 => 'design.ini',
                  2 => false,
                ),
              ),
            ),
            2 => false,
          ),
        ),
      ),
      2 => false,
    ),
  ),
),
                       $rootNamespace, $currentNamespace, $varData, false, false );
$var = $varData['value'];
unset( $varData );
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
$text .= ( is_object( $var ) ? compiledFetchText( $tpl, $rootNamespace, $currentNamespace, false, $var ) : $var );
unset( $var );

$text .= '
  ';
}
else
{
$text .= '    ';
unset( $var );
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
$varData = array( 'value' => $var );
$tpl->processOperator( 'ezcss_load',
                       array (
  0 => 
  array (
    0 => 
    array (
      0 => 6,
      1 => 
      array (
        0 => 'array',
        1 => 
        array (
          0 => 
          array (
            0 => 1,
            1 => 'core.css',
            2 => false,
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            0 => 1,
            1 => 'debug.css',
            2 => false,
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            0 => 1,
            1 => 'pagelayout.css',
            2 => false,
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            0 => 1,
            1 => 'content.css',
            2 => false,
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            0 => 4,
            1 => 
            array (
              0 => '',
              1 => 2,
              2 => 'admin_theme_css',
            ),
            2 => false,
          ),
        ),
        6 => 
        array (
          0 => 
          array (
            0 => 1,
            1 => 'theme/yui_datatable.css',
            2 => false,
          ),
        ),
        7 => 
        array (
          0 => 
          array (
            0 => 1,
            1 => 'theme/yui_menu.css',
            2 => false,
          ),
        ),
        8 => 
        array (
          0 => 
          array (
            0 => 1,
            1 => 'theme/yui_container.css',
            2 => false,
          ),
        ),
      ),
      2 => false,
    ),
  ),
),
                       $rootNamespace, $currentNamespace, $varData, false, false );
$var = $varData['value'];
unset( $varData );
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
$text .= ( is_object( $var ) ? compiledFetchText( $tpl, $rootNamespace, $currentNamespace, false, $var ) : $var );
unset( $var );

$text .= '
  ';
}
unset( $if_cond );
// if ends

$text .= '
  ';
$oldRestoreIncludeArray_34f360cf65d38ed07982db5514949f77 = isset( $restoreIncludeArray ) ? $restoreIncludeArray : array();
$restoreIncludeArray = array();

if ( !isset( $dKeys ) )
{
    $resH = $tpl->resourceHandler( "design" );
    $dKeys = $resH->keys();
}

$resourceFound = false;
if ( file_exists( 'var/ezdemo_site/cache/template/compiled/page_head_style_inline-48ea241c1d66cbafd577a7eccf07119c.php' ) )
{
$resourceFound = true;
$namespaceStack[] = array( $rootNamespace, $currentNamespace );
$rootNamespace = $currentNamespace;
$tpl->createLocalVariablesList();
$tpl->appendTemplateFetch( 'design/admin/templates/page_head_style_inline.tpl' );
include( '' . 'var/ezdemo_site/cache/template/compiled/page_head_style_inline-48ea241c1d66cbafd577a7eccf07119c.php' );
$tpl->unsetLocalVariables();
$tpl->destroyLocalVariablesList();
list( $rootNamespace, $currentNamespace ) = array_pop( $namespaceStack );
}
else
{
    $resourceFound = true;
$resourceFound = true;
$namespaceStack[] = array( $rootNamespace, $currentNamespace );
$rootNamespace = $currentNamespace;
$textElements = array();
$extraParameters = array();
$tpl->processURI( 'design/admin/templates/page_head_style_inline.tpl', true, $extraParameters, $textElements, $rootNamespace, $currentNamespace );
$text .= implode( '', $textElements );
list( $rootNamespace, $currentNamespace ) = array_pop( $namespaceStack );
}

foreach ( $restoreIncludeArray as $element )
{
    if ( $element[2] === 'unset' )
    {
        unset( $vars[$element[0]][$element[1]] );
        continue;
    }
    $vars[$element[0]][$element[1]] = $element[2];
}
$restoreIncludeArray = $oldRestoreIncludeArray_34f360cf65d38ed07982db5514949f77;

}
else
{
$text .= '  
  ';
unset( $var );
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
$varData = array( 'value' => $var );
$tpl->processOperator( 'ezcss_load',
                       array (
),
                       $rootNamespace, $currentNamespace, $varData, false, false );
$var = $varData['value'];
unset( $varData );
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
$text .= ( is_object( $var ) ? compiledFetchText( $tpl, $rootNamespace, $currentNamespace, false, $var ) : $var );
unset( $var );

}
unset( $if_cond );
// if ends


$setArray = $oldSetArray_130240229d9b9ab8e20771128040b6af;
$tpl->Level--;
?>
