<?php
// URI:       design/admin/templates/navigator/alphabetical.tpl
// Filename:  design/admin/templates/navigator/alphabetical.tpl
// Timestamp: 1383940876 (Fri Nov 8 21:01:16 CET 2013)
$oldSetArray_c12448851a3818d40a983aa36adf15b6 = isset( $setArray ) ? $setArray : array();
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

if ( !isset( $vars[$currentNamespace]['page_uri_suffix'] ) )
{
    $vars[$currentNamespace]['page_uri_suffix'] = false;
    $setArray[$currentNamespace]['page_uri_suffix'] = true;
}

if ( !isset( $vars[$currentNamespace]['show_google_navigator'] ) )
{
    $vars[$currentNamespace]['show_google_navigator'] = false;
    $setArray[$currentNamespace]['show_google_navigator'] = true;
}

// if begins
unset( $if_cond );
unset( $if_cond );
$if_cond = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'show_google_navigator', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['show_google_navigator'] : null;
if (! isset( $if_cond ) ) $if_cond = NULL;
while ( is_object( $if_cond ) and method_exists( $if_cond, 'templateValue' ) )
    $if_cond = $if_cond->templateValue();

if ( $if_cond )
{
$text .= '    ';
$oldRestoreIncludeArray_d66f1abc5acc9735cd26b4c376357132 = isset( $restoreIncludeArray ) ? $restoreIncludeArray : array();
$restoreIncludeArray = array();

if ( isset( $namespace ) and isset( $vars[$namespace]['page_uri'] ) )
    $restoreIncludeArray[] = array( $namespace, 'page_uri', $vars[$namespace]['page_uri'] );
elseif ( !isset( $vars[( isset( $namespace ) ? $namespace : '' )]['page_uri'] ) ) 
    $restoreIncludeArray[] = array( ( isset( $namespace ) ? $namespace : '' ), 'page_uri', 'unset' );

unset( $var );
unset( $var );
$var = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'page_uri', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['page_uri'] : null;
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
$namespace = $currentNamespace;
if ( $namespace == '' )
    $namespace = "navigator";
else
    $namespace .= ':navigator';
$vars[$namespace]['page_uri'] = $var;
unset( $var );
if ( isset( $namespace ) and isset( $vars[$namespace]['page_uri_suffix'] ) )
    $restoreIncludeArray[] = array( $namespace, 'page_uri_suffix', $vars[$namespace]['page_uri_suffix'] );
elseif ( !isset( $vars[( isset( $namespace ) ? $namespace : '' )]['page_uri_suffix'] ) ) 
    $restoreIncludeArray[] = array( ( isset( $namespace ) ? $namespace : '' ), 'page_uri_suffix', 'unset' );

unset( $var );
unset( $var );
$var = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'page_uri_suffix', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['page_uri_suffix'] : null;
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
$namespace = $currentNamespace;
if ( $namespace == '' )
    $namespace = "navigator";
else
    $namespace .= ':navigator';
$vars[$namespace]['page_uri_suffix'] = $var;
unset( $var );
if ( isset( $namespace ) and isset( $vars[$namespace]['item_count'] ) )
    $restoreIncludeArray[] = array( $namespace, 'item_count', $vars[$namespace]['item_count'] );
elseif ( !isset( $vars[( isset( $namespace ) ? $namespace : '' )]['item_count'] ) ) 
    $restoreIncludeArray[] = array( ( isset( $namespace ) ? $namespace : '' ), 'item_count', 'unset' );

unset( $var );
unset( $var );
$var = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'item_count', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['item_count'] : null;
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
$namespace = $currentNamespace;
if ( $namespace == '' )
    $namespace = "navigator";
else
    $namespace .= ':navigator';
$vars[$namespace]['item_count'] = $var;
unset( $var );
if ( isset( $namespace ) and isset( $vars[$namespace]['view_parameters'] ) )
    $restoreIncludeArray[] = array( $namespace, 'view_parameters', $vars[$namespace]['view_parameters'] );
elseif ( !isset( $vars[( isset( $namespace ) ? $namespace : '' )]['view_parameters'] ) ) 
    $restoreIncludeArray[] = array( ( isset( $namespace ) ? $namespace : '' ), 'view_parameters', 'unset' );

unset( $var );
unset( $var );
$var = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'view_parameters', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['view_parameters'] : null;
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
$namespace = $currentNamespace;
if ( $namespace == '' )
    $namespace = "navigator";
else
    $namespace .= ':navigator';
$vars[$namespace]['view_parameters'] = $var;
unset( $var );
if ( isset( $namespace ) and isset( $vars[$namespace]['item_limit'] ) )
    $restoreIncludeArray[] = array( $namespace, 'item_limit', $vars[$namespace]['item_limit'] );
elseif ( !isset( $vars[( isset( $namespace ) ? $namespace : '' )]['item_limit'] ) ) 
    $restoreIncludeArray[] = array( ( isset( $namespace ) ? $namespace : '' ), 'item_limit', 'unset' );

unset( $var );
unset( $var );
$var = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'item_limit', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['item_limit'] : null;
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
$namespace = $currentNamespace;
if ( $namespace == '' )
    $namespace = "navigator";
else
    $namespace .= ':navigator';
$vars[$namespace]['item_limit'] = $var;
unset( $var );
if ( !isset( $dKeys ) )
{
    $resH = $tpl->resourceHandler( "design" );
    $dKeys = $resH->keys();
}

$resourceFound = false;
if ( file_exists( 'var/ezdemo_site/cache/template/compiled/google-d559618c170d3c37b2d2e0485be3ec20.php' ) )
{
$resourceFound = true;
$namespaceStack[] = array( $rootNamespace, $currentNamespace );
$currentNamespace = $rootNamespace = !$currentNamespace ? 'navigator' : ( $currentNamespace . ':' . 'navigator' );
$tpl->createLocalVariablesList();
$tpl->appendTemplateFetch( 'design/admin/templates/navigator/google.tpl' );
include( '' . 'var/ezdemo_site/cache/template/compiled/google-d559618c170d3c37b2d2e0485be3ec20.php' );
$tpl->unsetLocalVariables();
$tpl->destroyLocalVariablesList();
list( $rootNamespace, $currentNamespace ) = array_pop( $namespaceStack );
}
else
{
    $resourceFound = true;
$resourceFound = true;
$namespaceStack[] = array( $rootNamespace, $currentNamespace );
$currentNamespace = $rootNamespace = !$currentNamespace ? 'navigator' : ( $currentNamespace . ':' . 'navigator' );
$textElements = array();
$extraParameters = array();
$tpl->processURI( 'design/admin/templates/navigator/google.tpl', true, $extraParameters, $textElements, $rootNamespace, $currentNamespace );
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
$restoreIncludeArray = $oldRestoreIncludeArray_d66f1abc5acc9735cd26b4c376357132;

}
unset( $if_cond );
// if ends

// if begins
unset( $if_cond );
unset( $if_cond1 );
unset( $if_cond2 );
if (! isset( $if_cond2 ) ) $if_cond2 = NULL;
while ( is_object( $if_cond2 ) and method_exists( $if_cond2, 'templateValue' ) )
    $if_cond2 = $if_cond2->templateValue();
$if_cond2Data = array( 'value' => $if_cond2 );
$tpl->processOperator( 'count',
                       array (
  0 => 
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
            1 => 'AlphabeticalFilterSettings',
            2 => false,
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            0 => 1,
            1 => 'ContentFilterList',
            2 => false,
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            0 => 1,
            1 => 'content.ini',
            2 => false,
          ),
        ),
      ),
      2 => false,
    ),
  ),
),
                       $rootNamespace, $currentNamespace, $if_cond2Data, false, false );
$if_cond2 = $if_cond2Data['value'];
unset( $if_cond2Data );
if (! isset( $if_cond2 ) ) $if_cond2 = NULL;
while ( is_object( $if_cond2 ) and method_exists( $if_cond2, 'templateValue' ) )
    $if_cond2 = $if_cond2->templateValue();
$if_cond1 = ( ( $if_cond2 ) > ( 0 ) );
unset( $if_cond2 );
if (! isset( $if_cond1 ) ) $if_cond1 = NULL;
while ( is_object( $if_cond1 ) and method_exists( $if_cond1, 'templateValue' ) )
    $if_cond1 = $if_cond1->templateValue();
if ( !$if_cond1 )
    $if_cond = false;
else
    $if_cond = $if_cond1;
unset( $if_cond1 );
if (! isset( $if_cond ) ) $if_cond = NULL;
while ( is_object( $if_cond ) and method_exists( $if_cond, 'templateValue' ) )
    $if_cond = $if_cond->templateValue();

if ( $if_cond )
{
$text .= '
   ';
if ( !isset( $vars[$currentNamespace]['children_count_by_letter'] ) )
{
    $vars[$currentNamespace]['children_count_by_letter'] = false;
    $setArray[$currentNamespace]['children_count_by_letter'] = true;
}

if ( !isset( $vars[$currentNamespace]['objectname_filter'] ) )
{
    $vars[$currentNamespace]['objectname_filter'] = false;
    $setArray[$currentNamespace]['objectname_filter'] = true;
}

unset( $var );
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
$varData = array( 'value' => $var );
$tpl->processOperator( 'alphabet',
                       array (
),
                       $rootNamespace, $currentNamespace, $varData, false, false );
$var = $varData['value'];
unset( $varData );
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
if ( !isset( $vars[$currentNamespace]['alphabet'] ) )
{
    $vars[$currentNamespace]['alphabet'] = $var;
    unset( $var );
    $setArray[$currentNamespace]['alphabet'] = true;
}

if ( !isset( $vars[$currentNamespace]['node_id'] ) )
{
    $vars[$currentNamespace]['node_id'] = false;
    $setArray[$currentNamespace]['node_id'] = true;
}

if ( !isset( $vars[$currentNamespace]['page_uri_suffix'] ) )
{
    $vars[$currentNamespace]['page_uri_suffix'] = false;
    $setArray[$currentNamespace]['page_uri_suffix'] = true;
}

unset( $var );
unset( $var1 );
unset( $var2 );
unset( $var3 );
unset( $var3 );
$var3 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'item_count', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['item_count'] : null;
if (! isset( $var3 ) ) $var3 = NULL;
while ( is_object( $var3 ) and method_exists( $var3, 'templateValue' ) )
    $var3 = $var3->templateValue();
while ( is_object( $var3 ) and method_exists( $var3, 'templateValue' ) )
    $var3 = $var3->templateValue();
unset( $var4 );
unset( $var4 );
$var4 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'item_limit', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['item_limit'] : null;
if (! isset( $var4 ) ) $var4 = NULL;
while ( is_object( $var4 ) and method_exists( $var4, 'templateValue' ) )
    $var4 = $var4->templateValue();
while ( is_object( $var4 ) and method_exists( $var4, 'templateValue' ) )
    $var4 = $var4->templateValue();
@$var2 = $var3 / $var4;
unset( $var3, $var4 );
if (! isset( $var2 ) ) $var2 = NULL;
while ( is_object( $var2 ) and method_exists( $var2, 'templateValue' ) )
    $var2 = $var2->templateValue();
$var1 = ceil( $var2 );
unset( $var2 );
if (! isset( $var1 ) ) $var1 = NULL;
while ( is_object( $var1 ) and method_exists( $var1, 'templateValue' ) )
    $var1 = $var1->templateValue();
$var = (int)$var1;
unset( $var1 );
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
if ( !isset( $vars[$currentNamespace]['page_count'] ) )
{
    $vars[$currentNamespace]['page_count'] = $var;
    unset( $var );
    $setArray[$currentNamespace]['page_count'] = true;
}

$text .= '
   
   ';
// if begins
unset( $if_cond );
unset( $if_cond1 );
unset( $if_cond2 );
unset( $if_cond2 );
$if_cond2 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'node_id', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['node_id'] : null;
if (! isset( $if_cond2 ) ) $if_cond2 = NULL;
while ( is_object( $if_cond2 ) and method_exists( $if_cond2, 'templateValue' ) )
    $if_cond2 = $if_cond2->templateValue();
$if_cond1 = ( ( $if_cond2 ) != ( false ) );
unset( $if_cond2 );
if (! isset( $if_cond1 ) ) $if_cond1 = NULL;
while ( is_object( $if_cond1 ) and method_exists( $if_cond1, 'templateValue' ) )
    $if_cond1 = $if_cond1->templateValue();
if ( !$if_cond1 )
    $if_cond = false;
else if ( !true )
    $if_cond = false;
else
    $if_cond = true;
unset( $if_cond1 );
if (! isset( $if_cond ) ) $if_cond = NULL;
while ( is_object( $if_cond ) and method_exists( $if_cond, 'templateValue' ) )
    $if_cond = $if_cond->templateValue();

if ( $if_cond )
{
$text .= '      ';
// def $alphabet_tmp
unset( $var );
unset( $var1 );
unset( $var1 );
$var1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'alphabet', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['alphabet'] : null;
if (! isset( $var1 ) ) $var1 = NULL;
while ( is_object( $var1 ) and method_exists( $var1, 'templateValue' ) )
    $var1 = $var1->templateValue();
while ( is_object( $var1 ) and method_exists( $var1, 'templateValue' ) )
    $var1 = $var1->templateValue();
$var = array_merge( $var1, array( "others" ) );
unset( $var1 );
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
if ( $tpl->hasVariable( 'alphabet_tmp', $rootNamespace ) )
{
    $tpl->warning( 'def', "Variable 'alphabet_tmp' is already defined.", array (
  0 => 
  array (
    0 => 25,
    1 => 6,
    2 => 1059,
  ),
  1 => 
  array (
    0 => 26,
    1 => 34,
    2 => 1149,
  ),
  2 => 'design/admin/templates/navigator/alphabetical.tpl',
) );
    $tpl->setVariable( 'alphabet_tmp', $var, $rootNamespace );
}
else
{
    $tpl->setLocalVariable( 'alphabet_tmp', $var, $rootNamespace );
}

// def $hash_by_letter
if ( $tpl->hasVariable( 'hash_by_letter', $rootNamespace ) )
{
    $tpl->warning( 'def', "Variable 'hash_by_letter' is already defined.", array (
  0 => 
  array (
    0 => 25,
    1 => 6,
    2 => 1059,
  ),
  1 => 
  array (
    0 => 26,
    1 => 34,
    2 => 1149,
  ),
  2 => 'design/admin/templates/navigator/alphabetical.tpl',
) );
    $tpl->setVariable( 'hash_by_letter', false, $rootNamespace );
}
else
{
    $tpl->setLocalVariable( 'hash_by_letter', false, $rootNamespace );
}

$text .= '      ';
// foreach begins
$skipDelimiter = true;
if ( !isset( $fe_variable_stack_cc7a006f362346f674a27d9ed08c0044_25 ) ) $fe_variable_stack_cc7a006f362346f674a27d9ed08c0044_25 = array();
$fe_variable_stack_cc7a006f362346f674a27d9ed08c0044_25[] = compact( 'fe_array_cc7a006f362346f674a27d9ed08c0044_25', 'fe_array_keys_cc7a006f362346f674a27d9ed08c0044_25', 'fe_n_items_cc7a006f362346f674a27d9ed08c0044_25', 'fe_n_items_processed_cc7a006f362346f674a27d9ed08c0044_25', 'fe_i_cc7a006f362346f674a27d9ed08c0044_25', 'fe_key_cc7a006f362346f674a27d9ed08c0044_25', 'fe_val_cc7a006f362346f674a27d9ed08c0044_25', 'fe_offset_cc7a006f362346f674a27d9ed08c0044_25', 'fe_max_cc7a006f362346f674a27d9ed08c0044_25', 'fe_reverse_cc7a006f362346f674a27d9ed08c0044_25', 'fe_first_val_cc7a006f362346f674a27d9ed08c0044_25', 'fe_last_val_cc7a006f362346f674a27d9ed08c0044_25' );
unset( $fe_array_cc7a006f362346f674a27d9ed08c0044_25 );
unset( $fe_array_cc7a006f362346f674a27d9ed08c0044_25 );
$fe_array_cc7a006f362346f674a27d9ed08c0044_25 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'alphabet_tmp', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['alphabet_tmp'] : null;
if (! isset( $fe_array_cc7a006f362346f674a27d9ed08c0044_25 ) ) $fe_array_cc7a006f362346f674a27d9ed08c0044_25 = NULL;
while ( is_object( $fe_array_cc7a006f362346f674a27d9ed08c0044_25 ) and method_exists( $fe_array_cc7a006f362346f674a27d9ed08c0044_25, 'templateValue' ) )
    $fe_array_cc7a006f362346f674a27d9ed08c0044_25 = $fe_array_cc7a006f362346f674a27d9ed08c0044_25->templateValue();

$fe_array_keys_cc7a006f362346f674a27d9ed08c0044_25 = is_array( $fe_array_cc7a006f362346f674a27d9ed08c0044_25 ) ? array_keys( $fe_array_cc7a006f362346f674a27d9ed08c0044_25 ) : array();
$fe_n_items_cc7a006f362346f674a27d9ed08c0044_25 = count( $fe_array_keys_cc7a006f362346f674a27d9ed08c0044_25 );
$fe_n_items_processed_cc7a006f362346f674a27d9ed08c0044_25 = 0;
$fe_offset_cc7a006f362346f674a27d9ed08c0044_25 = 0;
$fe_max_cc7a006f362346f674a27d9ed08c0044_25 = $fe_n_items_cc7a006f362346f674a27d9ed08c0044_25 - $fe_offset_cc7a006f362346f674a27d9ed08c0044_25;
$fe_reverse_cc7a006f362346f674a27d9ed08c0044_25 = false;
if ( $fe_offset_cc7a006f362346f674a27d9ed08c0044_25 < 0 || $fe_offset_cc7a006f362346f674a27d9ed08c0044_25 >= $fe_n_items_cc7a006f362346f674a27d9ed08c0044_25 )
{
    $fe_offset_cc7a006f362346f674a27d9ed08c0044_25 = ( $fe_offset_cc7a006f362346f674a27d9ed08c0044_25 < 0 ) ? 0 : $fe_n_items_cc7a006f362346f674a27d9ed08c0044_25;
    if ( $fe_n_items_cc7a006f362346f674a27d9ed08c0044_25 || $fe_offset_cc7a006f362346f674a27d9ed08c0044_25 < 0 )
 {
        eZDebug::writeWarning("Invalid 'offset' parameter specified: '$fe_offset_cc7a006f362346f674a27d9ed08c0044_25'. Array count: $fe_n_items_cc7a006f362346f674a27d9ed08c0044_25");   
}
}
if ( $fe_max_cc7a006f362346f674a27d9ed08c0044_25 < 0 || $fe_offset_cc7a006f362346f674a27d9ed08c0044_25 + $fe_max_cc7a006f362346f674a27d9ed08c0044_25 > $fe_n_items_cc7a006f362346f674a27d9ed08c0044_25 )
{
    if ( $fe_max_cc7a006f362346f674a27d9ed08c0044_25 < 0 )
 eZDebug::writeWarning("Invalid 'max' parameter specified: $fe_max_cc7a006f362346f674a27d9ed08c0044_25");
    $fe_max_cc7a006f362346f674a27d9ed08c0044_25 = $fe_n_items_cc7a006f362346f674a27d9ed08c0044_25 - $fe_offset_cc7a006f362346f674a27d9ed08c0044_25;
}
if ( $fe_reverse_cc7a006f362346f674a27d9ed08c0044_25 )
{
    $fe_first_val_cc7a006f362346f674a27d9ed08c0044_25 = $fe_n_items_cc7a006f362346f674a27d9ed08c0044_25 - 1 - $fe_offset_cc7a006f362346f674a27d9ed08c0044_25;
    $fe_last_val_cc7a006f362346f674a27d9ed08c0044_25  = 0;
}
else
{
    $fe_first_val_cc7a006f362346f674a27d9ed08c0044_25 = $fe_offset_cc7a006f362346f674a27d9ed08c0044_25;
    $fe_last_val_cc7a006f362346f674a27d9ed08c0044_25  = $fe_n_items_cc7a006f362346f674a27d9ed08c0044_25 - 1;
}
// foreach
for ( $fe_i_cc7a006f362346f674a27d9ed08c0044_25 = $fe_first_val_cc7a006f362346f674a27d9ed08c0044_25; $fe_n_items_processed_cc7a006f362346f674a27d9ed08c0044_25 < $fe_max_cc7a006f362346f674a27d9ed08c0044_25 && ( $fe_reverse_cc7a006f362346f674a27d9ed08c0044_25 ? $fe_i_cc7a006f362346f674a27d9ed08c0044_25 >= $fe_last_val_cc7a006f362346f674a27d9ed08c0044_25 : $fe_i_cc7a006f362346f674a27d9ed08c0044_25 <= $fe_last_val_cc7a006f362346f674a27d9ed08c0044_25 ); $fe_reverse_cc7a006f362346f674a27d9ed08c0044_25 ? $fe_i_cc7a006f362346f674a27d9ed08c0044_25-- : $fe_i_cc7a006f362346f674a27d9ed08c0044_25++ )
{
$fe_key_cc7a006f362346f674a27d9ed08c0044_25 = $fe_array_keys_cc7a006f362346f674a27d9ed08c0044_25[$fe_i_cc7a006f362346f674a27d9ed08c0044_25];
$fe_val_cc7a006f362346f674a27d9ed08c0044_25 = $fe_array_cc7a006f362346f674a27d9ed08c0044_25[$fe_key_cc7a006f362346f674a27d9ed08c0044_25];
$vars[$rootNamespace]['letter'] = $fe_val_cc7a006f362346f674a27d9ed08c0044_25;
$text .= '           ';
unset( $var );
unset( $var1 );
unset( $var1 );
$var1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'letter', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['letter'] : null;
if (! isset( $var1 ) ) $var1 = NULL;
while ( is_object( $var1 ) and method_exists( $var1, 'templateValue' ) )
    $var1 = $var1->templateValue();
while ( is_object( $var1 ) and method_exists( $var1, 'templateValue' ) )
    $var1 = $var1->templateValue();
unset( $var2 );
unset( $var3 );
unset( $var3 );
$var3 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'node_id', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['node_id'] : null;
if (! isset( $var3 ) ) $var3 = NULL;
while ( is_object( $var3 ) and method_exists( $var3, 'templateValue' ) )
    $var3 = $var3->templateValue();
while ( is_object( $var3 ) and method_exists( $var3, 'templateValue' ) )
    $var3 = $var3->templateValue();
unset( $var4 );
unset( $var4 );
$var4 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'letter', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['letter'] : null;
if (! isset( $var4 ) ) $var4 = NULL;
while ( is_object( $var4 ) and method_exists( $var4, 'templateValue' ) )
    $var4 = $var4->templateValue();
while ( is_object( $var4 ) and method_exists( $var4, 'templateValue' ) )
    $var4 = $var4->templateValue();
$var2 = call_user_func_array( array( new eZContentFunctionCollection(), 'fetchObjectTreeCount' ),
  array(     'parent_node_id' => $var3,
    'only_translated' => false,
    'language' => false,
    'class_filter_type' => false,
    'class_filter_array' => false,
    'attribute_filter' => false,
    'depth' => 1,
    'depth_operator' => "le",
    'ignore_visibility' => false,
    'limitation' => null,
    'main_node_only' => false,
    'extended_attribute_filter' => false,
    'objectname_filter' => $var4 ) );
$var2 = isset( $var2['result'] ) ? $var2['result'] : null;
unset( $var3, $var4 );
if (! isset( $var2 ) ) $var2 = NULL;
while ( is_object( $var2 ) and method_exists( $var2, 'templateValue' ) )
    $var2 = $var2->templateValue();
$var = array( $var1 => $var2 );unset( $var1, $var2 );
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
if ( array_key_exists( $currentNamespace, $vars ) && array_key_exists( 'hash_by_letter', $vars[$currentNamespace] ) )
{
    $vars[$currentNamespace]['hash_by_letter'] = $var;
    unset( $var );
}
$text .= '           ';
// if begins
unset( $if_cond );
unset( $if_cond1 );
if (! isset( $if_cond1 ) ) $if_cond1 = NULL;
while ( is_object( $if_cond1 ) and method_exists( $if_cond1, 'templateValue' ) )
    $if_cond1 = $if_cond1->templateValue();
$if_cond1Data = array( 'value' => $if_cond1 );
$tpl->processOperator( 'count',
                       array (
  0 => 
  array (
    0 => 
    array (
      0 => 4,
      1 => 
      array (
        0 => '',
        1 => 2,
        2 => 'children_count_by_letter',
      ),
      2 => false,
    ),
  ),
),
                       $rootNamespace, $currentNamespace, $if_cond1Data, false, false );
$if_cond1 = $if_cond1Data['value'];
unset( $if_cond1Data );
if (! isset( $if_cond1 ) ) $if_cond1 = NULL;
while ( is_object( $if_cond1 ) and method_exists( $if_cond1, 'templateValue' ) )
    $if_cond1 = $if_cond1->templateValue();
$if_cond = ( ( $if_cond1 ) == ( 0 ) );
unset( $if_cond1 );
if (! isset( $if_cond ) ) $if_cond = NULL;
while ( is_object( $if_cond ) and method_exists( $if_cond, 'templateValue' ) )
    $if_cond = $if_cond->templateValue();

if ( $if_cond )
{
$text .= '              ';
unset( $var );
unset( $var );
$var = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'hash_by_letter', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['hash_by_letter'] : null;
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
if ( array_key_exists( $currentNamespace, $vars ) && array_key_exists( 'children_count_by_letter', $vars[$currentNamespace] ) )
{
    $vars[$currentNamespace]['children_count_by_letter'] = $var;
    unset( $var );
}
$text .= '           ';
}
else
{
$text .= '              ';
unset( $var );
unset( $var1 );
unset( $var1 );
$var1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'hash_by_letter', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['hash_by_letter'] : null;
if (! isset( $var1 ) ) $var1 = NULL;
while ( is_object( $var1 ) and method_exists( $var1, 'templateValue' ) )
    $var1 = $var1->templateValue();
while ( is_object( $var1 ) and method_exists( $var1, 'templateValue' ) )
    $var1 = $var1->templateValue();
unset( $var2 );
unset( $var2 );
$var2 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'children_count_by_letter', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['children_count_by_letter'] : null;
if (! isset( $var2 ) ) $var2 = NULL;
while ( is_object( $var2 ) and method_exists( $var2, 'templateValue' ) )
    $var2 = $var2->templateValue();
while ( is_object( $var2 ) and method_exists( $var2, 'templateValue' ) )
    $var2 = $var2->templateValue();
$var = array_merge( $var1, $var2 );
unset( $var1, $var2 );
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
if ( array_key_exists( $currentNamespace, $vars ) && array_key_exists( 'children_count_by_letter', $vars[$currentNamespace] ) )
{
    $vars[$currentNamespace]['children_count_by_letter'] = $var;
    unset( $var );
}
$text .= '           ';
}
unset( $if_cond );
// if ends

$text .= '      ';
$fe_n_items_processed_cc7a006f362346f674a27d9ed08c0044_25++;
} // foreach
$skipDelimiter = false;
if ( count( $fe_variable_stack_cc7a006f362346f674a27d9ed08c0044_25 ) ) extract( array_pop( $fe_variable_stack_cc7a006f362346f674a27d9ed08c0044_25 ) );

else
{

unset( $fe_array_cc7a006f362346f674a27d9ed08c0044_25 );

unset( $fe_array_keys_cc7a006f362346f674a27d9ed08c0044_25 );

unset( $fe_n_items_cc7a006f362346f674a27d9ed08c0044_25 );

unset( $fe_n_items_processed_cc7a006f362346f674a27d9ed08c0044_25 );

unset( $fe_i_cc7a006f362346f674a27d9ed08c0044_25 );

unset( $fe_key_cc7a006f362346f674a27d9ed08c0044_25 );

unset( $fe_val_cc7a006f362346f674a27d9ed08c0044_25 );

unset( $fe_offset_cc7a006f362346f674a27d9ed08c0044_25 );

unset( $fe_max_cc7a006f362346f674a27d9ed08c0044_25 );

unset( $fe_reverse_cc7a006f362346f674a27d9ed08c0044_25 );

unset( $fe_first_val_cc7a006f362346f674a27d9ed08c0044_25 );

unset( $fe_last_val_cc7a006f362346f674a27d9ed08c0044_25 );

unset( $fe_variable_stack_cc7a006f362346f674a27d9ed08c0044_25 );

}

// foreach ends
$text .= '      ';
// undef $alphabet_tmp
$tpl->unsetLocalVariable( 'alphabet_tmp', $rootNamespace );

// undef $hash_by_letter
$tpl->unsetLocalVariable( 'hash_by_letter', $rootNamespace );

$text .= '   ';
}
unset( $if_cond );
// if ends

$text .= '
   
   ';
// if begins
unset( $if_cond );
unset( $if_cond1 );
unset( $if_cond1 );
$if_cond1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'view_parameters', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['view_parameters'] : null;
$if_cond2 = compiledFetchAttribute( $if_cond1, 'namefilter' );
unset( $if_cond1 );
$if_cond1 = $if_cond2;
if (! isset( $if_cond1 ) ) $if_cond1 = NULL;
while ( is_object( $if_cond1 ) and method_exists( $if_cond1, 'templateValue' ) )
    $if_cond1 = $if_cond1->templateValue();
$if_cond = isset( $if_cond1 );unset( $if_cond1 );
if (! isset( $if_cond ) ) $if_cond = NULL;
while ( is_object( $if_cond ) and method_exists( $if_cond, 'templateValue' ) )
    $if_cond = $if_cond->templateValue();

if ( $if_cond )
{
$text .= '      ';
unset( $var );
unset( $var );
$var = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'view_parameters', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['view_parameters'] : null;
$var1 = compiledFetchAttribute( $var, 'namefilter' );
unset( $var );
$var = $var1;
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
if ( array_key_exists( $currentNamespace, $vars ) && array_key_exists( 'objectname_filter', $vars[$currentNamespace] ) )
{
    $vars[$currentNamespace]['objectname_filter'] = $var;
    unset( $var );
}
$text .= '   ';
}
unset( $if_cond );
// if ends

$text .= '
   ';
// if begins
unset( $if_cond );
unset( $if_cond1 );
unset( $if_cond2 );
unset( $if_cond2 );
$if_cond2 = ( array_key_exists( $currentNamespace, $vars ) and array_key_exists( 'objectname_filter', $vars[$currentNamespace] ) ) ? $vars[$currentNamespace]['objectname_filter'] : null;
if (! isset( $if_cond2 ) ) $if_cond2 = NULL;
while ( is_object( $if_cond2 ) and method_exists( $if_cond2, 'templateValue' ) )
    $if_cond2 = $if_cond2->templateValue();
$if_cond1 = ( ( $if_cond2 ) == ( false ) );
unset( $if_cond2 );
if (! isset( $if_cond1 ) ) $if_cond1 = NULL;
while ( is_object( $if_cond1 ) and method_exists( $if_cond1, 'templateValue' ) )
    $if_cond1 = $if_cond1->templateValue();
unset( $if_cond2 );
unset( $if_cond3 );
unset( $if_cond3 );
$if_cond3 = ( array_key_exists( $currentNamespace, $vars ) and array_key_exists( 'page_count', $vars[$currentNamespace] ) ) ? $vars[$currentNamespace]['page_count'] : null;
if (! isset( $if_cond3 ) ) $if_cond3 = NULL;
while ( is_object( $if_cond3 ) and method_exists( $if_cond3, 'templateValue' ) )
    $if_cond3 = $if_cond3->templateValue();
$if_cond2 = ( ( $if_cond3 ) == ( 0 ) );
unset( $if_cond3 );
if (! isset( $if_cond2 ) ) $if_cond2 = NULL;
while ( is_object( $if_cond2 ) and method_exists( $if_cond2, 'templateValue' ) )
    $if_cond2 = $if_cond2->templateValue();
if ( !$if_cond1 )
    $if_cond = false;
else if ( !$if_cond2 )
    $if_cond = false;
else
    $if_cond = $if_cond2;
unset( $if_cond1, $if_cond2 );
if (! isset( $if_cond ) ) $if_cond = NULL;
while ( is_object( $if_cond ) and method_exists( $if_cond, 'templateValue' ) )
    $if_cond = $if_cond->templateValue();

if ( $if_cond )
{
$text .= '   
   ';
}
else
{
$text .= '       <div class="break"></div>
       <div class="pagenavigator alphabetical">
       <p>
       ';
$vars[$currentNamespace]['c'] = 0;
$text .= '       <span class="pages">
            ';
// if begins
unset( $if_cond );
unset( $if_cond1 );
unset( $if_cond1 );
$if_cond1 = ( array_key_exists( $currentNamespace, $vars ) and array_key_exists( 'objectname_filter', $vars[$currentNamespace] ) ) ? $vars[$currentNamespace]['objectname_filter'] : null;
if (! isset( $if_cond1 ) ) $if_cond1 = NULL;
while ( is_object( $if_cond1 ) and method_exists( $if_cond1, 'templateValue' ) )
    $if_cond1 = $if_cond1->templateValue();
$if_cond = ( ( $if_cond1 ) == ( false ) );
unset( $if_cond1 );
if (! isset( $if_cond ) ) $if_cond = NULL;
while ( is_object( $if_cond ) and method_exists( $if_cond, 'templateValue' ) )
    $if_cond = $if_cond->templateValue();

if ( $if_cond )
{
$text .= '<span class="current">*</span>';
}
else
{
$text .= '<span class="other"><a href=';
unset( $var );
unset( $var1 );
unset( $var2 );
unset( $var2 );
$var2 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'page_uri', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['page_uri'] : null;
if (! isset( $var2 ) ) $var2 = NULL;
while ( is_object( $var2 ) and method_exists( $var2, 'templateValue' ) )
    $var2 = $var2->templateValue();
while ( is_object( $var2 ) and method_exists( $var2, 'templateValue' ) )
    $var2 = $var2->templateValue();
unset( $var3 );
unset( $var3 );
$var3 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'page_uri_suffix', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['page_uri_suffix'] : null;
if (! isset( $var3 ) ) $var3 = NULL;
while ( is_object( $var3 ) and method_exists( $var3, 'templateValue' ) )
    $var3 = $var3->templateValue();
while ( is_object( $var3 ) and method_exists( $var3, 'templateValue' ) )
    $var3 = $var3->templateValue();
$var1 = ( $var2 . $var3 );
unset( $var2, $var3 );
if (! isset( $var1 ) ) $var1 = NULL;
while ( is_object( $var1 ) and method_exists( $var1, 'templateValue' ) )
    $var1 = $var1->templateValue();

eZURI::transformURI( $var1, false, eZURI::getTransformURIMode() );
$var1 = '"' . $var1 . '"';
$var = $var1;
unset( $var1 );
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
$text .= $var;
unset( $var );

$text .= '>*</a></span>';
}
unset( $if_cond );
// if ends

$text .= '
        ';
// if begins
unset( $if_cond );
unset( $if_cond1 );
unset( $if_cond1 );
$if_cond1 = ( array_key_exists( $currentNamespace, $vars ) and array_key_exists( 'objectname_filter', $vars[$currentNamespace] ) ) ? $vars[$currentNamespace]['objectname_filter'] : null;
if (! isset( $if_cond1 ) ) $if_cond1 = NULL;
while ( is_object( $if_cond1 ) and method_exists( $if_cond1, 'templateValue' ) )
    $if_cond1 = $if_cond1->templateValue();
$if_cond = ( ( $if_cond1 ) == ( 'others' ) );
unset( $if_cond1 );
if (! isset( $if_cond ) ) $if_cond = NULL;
while ( is_object( $if_cond ) and method_exists( $if_cond, 'templateValue' ) )
    $if_cond = $if_cond->templateValue();

if ( $if_cond )
{
$text .= '        <span class="current">others</span>
        ';
}
else
{
$text .= '        <span class="other">
         ';
// if begins
unset( $if_cond );
unset( $if_cond1 );
unset( $if_cond2 );
unset( $if_cond3 );
unset( $if_cond3 );
$if_cond3 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'children_count_by_letter', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['children_count_by_letter'] : null;
if (! isset( $if_cond3 ) ) $if_cond3 = NULL;
while ( is_object( $if_cond3 ) and method_exists( $if_cond3, 'templateValue' ) )
    $if_cond3 = $if_cond3->templateValue();
$if_cond2 = ( ( $if_cond3 ) != ( false ) );
unset( $if_cond3 );
if (! isset( $if_cond2 ) ) $if_cond2 = NULL;
while ( is_object( $if_cond2 ) and method_exists( $if_cond2, 'templateValue' ) )
    $if_cond2 = $if_cond2->templateValue();
unset( $if_cond3 );
unset( $if_cond4 );
unset( $if_cond4 );
$if_cond4 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'children_count_by_letter', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['children_count_by_letter'] : null;
$if_cond5 = compiledFetchAttribute( $if_cond4, 'others' );
unset( $if_cond4 );
$if_cond4 = $if_cond5;
if (! isset( $if_cond4 ) ) $if_cond4 = NULL;
while ( is_object( $if_cond4 ) and method_exists( $if_cond4, 'templateValue' ) )
    $if_cond4 = $if_cond4->templateValue();
$if_cond3 = ( ( $if_cond4 ) > ( 0 ) );
unset( $if_cond4 );
if (! isset( $if_cond3 ) ) $if_cond3 = NULL;
while ( is_object( $if_cond3 ) and method_exists( $if_cond3, 'templateValue' ) )
    $if_cond3 = $if_cond3->templateValue();
if ( !$if_cond2 )
    $if_cond1 = false;
else if ( !$if_cond3 )
    $if_cond1 = false;
else
    $if_cond1 = $if_cond3;
unset( $if_cond2, $if_cond3 );
if (! isset( $if_cond1 ) ) $if_cond1 = NULL;
while ( is_object( $if_cond1 ) and method_exists( $if_cond1, 'templateValue' ) )
    $if_cond1 = $if_cond1->templateValue();
unset( $if_cond2 );
unset( $if_cond3 );
unset( $if_cond3 );
$if_cond3 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'children_count_by_letter', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['children_count_by_letter'] : null;
if (! isset( $if_cond3 ) ) $if_cond3 = NULL;
while ( is_object( $if_cond3 ) and method_exists( $if_cond3, 'templateValue' ) )
    $if_cond3 = $if_cond3->templateValue();
$if_cond2 = ( ( $if_cond3 ) == ( false ) );
unset( $if_cond3 );
if (! isset( $if_cond2 ) ) $if_cond2 = NULL;
while ( is_object( $if_cond2 ) and method_exists( $if_cond2, 'templateValue' ) )
    $if_cond2 = $if_cond2->templateValue();
if ( $if_cond1 )
    $if_cond = $if_cond1;
else if ( $if_cond2 )
    $if_cond = $if_cond2;
else
    $if_cond = false;
unset( $if_cond1, $if_cond2 );
if (! isset( $if_cond ) ) $if_cond = NULL;
while ( is_object( $if_cond ) and method_exists( $if_cond, 'templateValue' ) )
    $if_cond = $if_cond->templateValue();

if ( $if_cond )
{
$text .= '             <a href=';
unset( $var );
unset( $var1 );
unset( $var2 );
unset( $var2 );
$var2 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'page_uri', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['page_uri'] : null;
if (! isset( $var2 ) ) $var2 = NULL;
while ( is_object( $var2 ) and method_exists( $var2, 'templateValue' ) )
    $var2 = $var2->templateValue();
while ( is_object( $var2 ) and method_exists( $var2, 'templateValue' ) )
    $var2 = $var2->templateValue();
unset( $var5 );
unset( $var5 );
$var5 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'page_uri_suffix', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['page_uri_suffix'] : null;
if (! isset( $var5 ) ) $var5 = NULL;
while ( is_object( $var5 ) and method_exists( $var5, 'templateValue' ) )
    $var5 = $var5->templateValue();
while ( is_object( $var5 ) and method_exists( $var5, 'templateValue' ) )
    $var5 = $var5->templateValue();
$var1 = ( $var2 . '/(namefilter)/' . 'others' . $var5 );
unset( $var2, $var5 );
if (! isset( $var1 ) ) $var1 = NULL;
while ( is_object( $var1 ) and method_exists( $var1, 'templateValue' ) )
    $var1 = $var1->templateValue();

eZURI::transformURI( $var1, false, eZURI::getTransformURIMode() );
$var1 = '"' . $var1 . '"';
$var = $var1;
unset( $var1 );
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
$text .= $var;
unset( $var );

$text .= '>
                 ';
}
else
{
$text .= '             <span class="disabled">
         ';
}
unset( $if_cond );
// if ends

$text .= '         others
         ';
// if begins
unset( $if_cond );
unset( $if_cond1 );
unset( $if_cond2 );
unset( $if_cond3 );
unset( $if_cond3 );
$if_cond3 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'children_count_by_letter', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['children_count_by_letter'] : null;
if (! isset( $if_cond3 ) ) $if_cond3 = NULL;
while ( is_object( $if_cond3 ) and method_exists( $if_cond3, 'templateValue' ) )
    $if_cond3 = $if_cond3->templateValue();
$if_cond2 = ( ( $if_cond3 ) != ( false ) );
unset( $if_cond3 );
if (! isset( $if_cond2 ) ) $if_cond2 = NULL;
while ( is_object( $if_cond2 ) and method_exists( $if_cond2, 'templateValue' ) )
    $if_cond2 = $if_cond2->templateValue();
unset( $if_cond3 );
unset( $if_cond4 );
unset( $if_cond4 );
$if_cond4 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'children_count_by_letter', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['children_count_by_letter'] : null;
$if_cond5 = compiledFetchAttribute( $if_cond4, 'others' );
unset( $if_cond4 );
$if_cond4 = $if_cond5;
if (! isset( $if_cond4 ) ) $if_cond4 = NULL;
while ( is_object( $if_cond4 ) and method_exists( $if_cond4, 'templateValue' ) )
    $if_cond4 = $if_cond4->templateValue();
$if_cond3 = ( ( $if_cond4 ) > ( 0 ) );
unset( $if_cond4 );
if (! isset( $if_cond3 ) ) $if_cond3 = NULL;
while ( is_object( $if_cond3 ) and method_exists( $if_cond3, 'templateValue' ) )
    $if_cond3 = $if_cond3->templateValue();
if ( !$if_cond2 )
    $if_cond1 = false;
else if ( !$if_cond3 )
    $if_cond1 = false;
else
    $if_cond1 = $if_cond3;
unset( $if_cond2, $if_cond3 );
if (! isset( $if_cond1 ) ) $if_cond1 = NULL;
while ( is_object( $if_cond1 ) and method_exists( $if_cond1, 'templateValue' ) )
    $if_cond1 = $if_cond1->templateValue();
unset( $if_cond2 );
unset( $if_cond3 );
unset( $if_cond3 );
$if_cond3 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'children_count_by_letter', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['children_count_by_letter'] : null;
if (! isset( $if_cond3 ) ) $if_cond3 = NULL;
while ( is_object( $if_cond3 ) and method_exists( $if_cond3, 'templateValue' ) )
    $if_cond3 = $if_cond3->templateValue();
$if_cond2 = ( ( $if_cond3 ) == ( false ) );
unset( $if_cond3 );
if (! isset( $if_cond2 ) ) $if_cond2 = NULL;
while ( is_object( $if_cond2 ) and method_exists( $if_cond2, 'templateValue' ) )
    $if_cond2 = $if_cond2->templateValue();
if ( $if_cond1 )
    $if_cond = $if_cond1;
else if ( $if_cond2 )
    $if_cond = $if_cond2;
else
    $if_cond = false;
unset( $if_cond1, $if_cond2 );
if (! isset( $if_cond ) ) $if_cond = NULL;
while ( is_object( $if_cond ) and method_exists( $if_cond, 'templateValue' ) )
    $if_cond = $if_cond->templateValue();

if ( $if_cond )
{
$text .= '             </a>
                 ';
}
else
{
$text .= '                     </span>
                 ';
}
unset( $if_cond );
// if ends

$text .= '                 </span>
        ';
}
unset( $if_cond );
// if ends

$text .= '            
            ';
// foreach begins
$skipDelimiter = true;
if ( !isset( $fe_variable_stack_cc7a006f362346f674a27d9ed08c0044_26 ) ) $fe_variable_stack_cc7a006f362346f674a27d9ed08c0044_26 = array();
$fe_variable_stack_cc7a006f362346f674a27d9ed08c0044_26[] = compact( 'fe_array_cc7a006f362346f674a27d9ed08c0044_26', 'fe_array_keys_cc7a006f362346f674a27d9ed08c0044_26', 'fe_n_items_cc7a006f362346f674a27d9ed08c0044_26', 'fe_n_items_processed_cc7a006f362346f674a27d9ed08c0044_26', 'fe_i_cc7a006f362346f674a27d9ed08c0044_26', 'fe_key_cc7a006f362346f674a27d9ed08c0044_26', 'fe_val_cc7a006f362346f674a27d9ed08c0044_26', 'fe_offset_cc7a006f362346f674a27d9ed08c0044_26', 'fe_max_cc7a006f362346f674a27d9ed08c0044_26', 'fe_reverse_cc7a006f362346f674a27d9ed08c0044_26', 'fe_first_val_cc7a006f362346f674a27d9ed08c0044_26', 'fe_last_val_cc7a006f362346f674a27d9ed08c0044_26' );
unset( $fe_array_cc7a006f362346f674a27d9ed08c0044_26 );
unset( $fe_array_cc7a006f362346f674a27d9ed08c0044_26 );
$fe_array_cc7a006f362346f674a27d9ed08c0044_26 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'alphabet', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['alphabet'] : null;
if (! isset( $fe_array_cc7a006f362346f674a27d9ed08c0044_26 ) ) $fe_array_cc7a006f362346f674a27d9ed08c0044_26 = NULL;
while ( is_object( $fe_array_cc7a006f362346f674a27d9ed08c0044_26 ) and method_exists( $fe_array_cc7a006f362346f674a27d9ed08c0044_26, 'templateValue' ) )
    $fe_array_cc7a006f362346f674a27d9ed08c0044_26 = $fe_array_cc7a006f362346f674a27d9ed08c0044_26->templateValue();

$fe_array_keys_cc7a006f362346f674a27d9ed08c0044_26 = is_array( $fe_array_cc7a006f362346f674a27d9ed08c0044_26 ) ? array_keys( $fe_array_cc7a006f362346f674a27d9ed08c0044_26 ) : array();
$fe_n_items_cc7a006f362346f674a27d9ed08c0044_26 = count( $fe_array_keys_cc7a006f362346f674a27d9ed08c0044_26 );
$fe_n_items_processed_cc7a006f362346f674a27d9ed08c0044_26 = 0;
$fe_offset_cc7a006f362346f674a27d9ed08c0044_26 = 0;
$fe_max_cc7a006f362346f674a27d9ed08c0044_26 = $fe_n_items_cc7a006f362346f674a27d9ed08c0044_26 - $fe_offset_cc7a006f362346f674a27d9ed08c0044_26;
$fe_reverse_cc7a006f362346f674a27d9ed08c0044_26 = false;
if ( $fe_offset_cc7a006f362346f674a27d9ed08c0044_26 < 0 || $fe_offset_cc7a006f362346f674a27d9ed08c0044_26 >= $fe_n_items_cc7a006f362346f674a27d9ed08c0044_26 )
{
    $fe_offset_cc7a006f362346f674a27d9ed08c0044_26 = ( $fe_offset_cc7a006f362346f674a27d9ed08c0044_26 < 0 ) ? 0 : $fe_n_items_cc7a006f362346f674a27d9ed08c0044_26;
    if ( $fe_n_items_cc7a006f362346f674a27d9ed08c0044_26 || $fe_offset_cc7a006f362346f674a27d9ed08c0044_26 < 0 )
 {
        eZDebug::writeWarning("Invalid 'offset' parameter specified: '$fe_offset_cc7a006f362346f674a27d9ed08c0044_26'. Array count: $fe_n_items_cc7a006f362346f674a27d9ed08c0044_26");   
}
}
if ( $fe_max_cc7a006f362346f674a27d9ed08c0044_26 < 0 || $fe_offset_cc7a006f362346f674a27d9ed08c0044_26 + $fe_max_cc7a006f362346f674a27d9ed08c0044_26 > $fe_n_items_cc7a006f362346f674a27d9ed08c0044_26 )
{
    if ( $fe_max_cc7a006f362346f674a27d9ed08c0044_26 < 0 )
 eZDebug::writeWarning("Invalid 'max' parameter specified: $fe_max_cc7a006f362346f674a27d9ed08c0044_26");
    $fe_max_cc7a006f362346f674a27d9ed08c0044_26 = $fe_n_items_cc7a006f362346f674a27d9ed08c0044_26 - $fe_offset_cc7a006f362346f674a27d9ed08c0044_26;
}
if ( $fe_reverse_cc7a006f362346f674a27d9ed08c0044_26 )
{
    $fe_first_val_cc7a006f362346f674a27d9ed08c0044_26 = $fe_n_items_cc7a006f362346f674a27d9ed08c0044_26 - 1 - $fe_offset_cc7a006f362346f674a27d9ed08c0044_26;
    $fe_last_val_cc7a006f362346f674a27d9ed08c0044_26  = 0;
}
else
{
    $fe_first_val_cc7a006f362346f674a27d9ed08c0044_26 = $fe_offset_cc7a006f362346f674a27d9ed08c0044_26;
    $fe_last_val_cc7a006f362346f674a27d9ed08c0044_26  = $fe_n_items_cc7a006f362346f674a27d9ed08c0044_26 - 1;
}
// foreach
for ( $fe_i_cc7a006f362346f674a27d9ed08c0044_26 = $fe_first_val_cc7a006f362346f674a27d9ed08c0044_26; $fe_n_items_processed_cc7a006f362346f674a27d9ed08c0044_26 < $fe_max_cc7a006f362346f674a27d9ed08c0044_26 && ( $fe_reverse_cc7a006f362346f674a27d9ed08c0044_26 ? $fe_i_cc7a006f362346f674a27d9ed08c0044_26 >= $fe_last_val_cc7a006f362346f674a27d9ed08c0044_26 : $fe_i_cc7a006f362346f674a27d9ed08c0044_26 <= $fe_last_val_cc7a006f362346f674a27d9ed08c0044_26 ); $fe_reverse_cc7a006f362346f674a27d9ed08c0044_26 ? $fe_i_cc7a006f362346f674a27d9ed08c0044_26-- : $fe_i_cc7a006f362346f674a27d9ed08c0044_26++ )
{
$fe_key_cc7a006f362346f674a27d9ed08c0044_26 = $fe_array_keys_cc7a006f362346f674a27d9ed08c0044_26[$fe_i_cc7a006f362346f674a27d9ed08c0044_26];
$fe_val_cc7a006f362346f674a27d9ed08c0044_26 = $fe_array_cc7a006f362346f674a27d9ed08c0044_26[$fe_key_cc7a006f362346f674a27d9ed08c0044_26];
$vars[$rootNamespace]['letter'] = $fe_val_cc7a006f362346f674a27d9ed08c0044_26;
$text .= '                 ';
// if begins
unset( $if_cond );
unset( $if_cond1 );
unset( $if_cond1 );
$if_cond1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'letter', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['letter'] : null;
if (! isset( $if_cond1 ) ) $if_cond1 = NULL;
while ( is_object( $if_cond1 ) and method_exists( $if_cond1, 'templateValue' ) )
    $if_cond1 = $if_cond1->templateValue();
unset( $if_cond2 );
unset( $if_cond2 );
$if_cond2 = ( array_key_exists( $currentNamespace, $vars ) and array_key_exists( 'objectname_filter', $vars[$currentNamespace] ) ) ? $vars[$currentNamespace]['objectname_filter'] : null;
if (! isset( $if_cond2 ) ) $if_cond2 = NULL;
while ( is_object( $if_cond2 ) and method_exists( $if_cond2, 'templateValue' ) )
    $if_cond2 = $if_cond2->templateValue();
$if_cond = ( ( $if_cond1 ) == ( $if_cond2 ) );
unset( $if_cond1, $if_cond2 );
if (! isset( $if_cond ) ) $if_cond = NULL;
while ( is_object( $if_cond ) and method_exists( $if_cond, 'templateValue' ) )
    $if_cond = $if_cond->templateValue();

if ( $if_cond )
{
$text .= '                      <span class="current">';
unset( $var );
unset( $var );
$var = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'letter', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['letter'] : null;
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
$text .= ( is_object( $var ) ? compiledFetchText( $tpl, $rootNamespace, $currentNamespace, false, $var ) : $var );
unset( $var );

$text .= '</span>
                 ';
}
else
{
$text .= '                      <span class="other">
                      ';
// if begins
unset( $if_cond );
unset( $if_cond1 );
unset( $if_cond2 );
unset( $if_cond3 );
unset( $if_cond3 );
$if_cond3 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'children_count_by_letter', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['children_count_by_letter'] : null;
if (! isset( $if_cond3 ) ) $if_cond3 = NULL;
while ( is_object( $if_cond3 ) and method_exists( $if_cond3, 'templateValue' ) )
    $if_cond3 = $if_cond3->templateValue();
$if_cond2 = ( ( $if_cond3 ) != ( false ) );
unset( $if_cond3 );
if (! isset( $if_cond2 ) ) $if_cond2 = NULL;
while ( is_object( $if_cond2 ) and method_exists( $if_cond2, 'templateValue' ) )
    $if_cond2 = $if_cond2->templateValue();
unset( $if_cond3 );
unset( $if_cond4 );
unset( $if_cond5 );
unset( $if_cond5 );
$if_cond5 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'children_count_by_letter', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['children_count_by_letter'] : null;
unset( $if_cond7 );
unset( $if_cond7 );
$if_cond7 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'letter', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['letter'] : null;
if (! isset( $if_cond7 ) ) $if_cond7 = NULL;
while ( is_object( $if_cond7 ) and method_exists( $if_cond7, 'templateValue' ) )
    $if_cond7 = $if_cond7->templateValue();
$if_cond6 = compiledFetchAttribute( $if_cond5, $if_cond7 );
unset( $if_cond5 );
$if_cond5 = $if_cond6;
if (! isset( $if_cond5 ) ) $if_cond5 = NULL;
while ( is_object( $if_cond5 ) and method_exists( $if_cond5, 'templateValue' ) )
    $if_cond5 = $if_cond5->templateValue();
$if_cond4 = isset( $if_cond5 );unset( $if_cond5 );
if (! isset( $if_cond4 ) ) $if_cond4 = NULL;
while ( is_object( $if_cond4 ) and method_exists( $if_cond4, 'templateValue' ) )
    $if_cond4 = $if_cond4->templateValue();
unset( $if_cond5 );
unset( $if_cond6 );
unset( $if_cond6 );
$if_cond6 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'children_count_by_letter', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['children_count_by_letter'] : null;
unset( $if_cond8 );
unset( $if_cond8 );
$if_cond8 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'letter', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['letter'] : null;
if (! isset( $if_cond8 ) ) $if_cond8 = NULL;
while ( is_object( $if_cond8 ) and method_exists( $if_cond8, 'templateValue' ) )
    $if_cond8 = $if_cond8->templateValue();
$if_cond7 = compiledFetchAttribute( $if_cond6, $if_cond8 );
unset( $if_cond6 );
$if_cond6 = $if_cond7;
if (! isset( $if_cond6 ) ) $if_cond6 = NULL;
while ( is_object( $if_cond6 ) and method_exists( $if_cond6, 'templateValue' ) )
    $if_cond6 = $if_cond6->templateValue();
$if_cond5 = ( ( $if_cond6 ) > ( 0 ) );
unset( $if_cond6 );
if (! isset( $if_cond5 ) ) $if_cond5 = NULL;
while ( is_object( $if_cond5 ) and method_exists( $if_cond5, 'templateValue' ) )
    $if_cond5 = $if_cond5->templateValue();
if ( !$if_cond4 )
    $if_cond3 = false;
else if ( !$if_cond5 )
    $if_cond3 = false;
else
    $if_cond3 = $if_cond5;
unset( $if_cond4, $if_cond5 );
if (! isset( $if_cond3 ) ) $if_cond3 = NULL;
while ( is_object( $if_cond3 ) and method_exists( $if_cond3, 'templateValue' ) )
    $if_cond3 = $if_cond3->templateValue();
if ( !$if_cond2 )
    $if_cond1 = false;
else if ( !$if_cond3 )
    $if_cond1 = false;
else
    $if_cond1 = $if_cond3;
unset( $if_cond2, $if_cond3 );
if (! isset( $if_cond1 ) ) $if_cond1 = NULL;
while ( is_object( $if_cond1 ) and method_exists( $if_cond1, 'templateValue' ) )
    $if_cond1 = $if_cond1->templateValue();
unset( $if_cond2 );
unset( $if_cond3 );
unset( $if_cond3 );
$if_cond3 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'children_count_by_letter', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['children_count_by_letter'] : null;
if (! isset( $if_cond3 ) ) $if_cond3 = NULL;
while ( is_object( $if_cond3 ) and method_exists( $if_cond3, 'templateValue' ) )
    $if_cond3 = $if_cond3->templateValue();
$if_cond2 = ( ( $if_cond3 ) == ( false ) );
unset( $if_cond3 );
if (! isset( $if_cond2 ) ) $if_cond2 = NULL;
while ( is_object( $if_cond2 ) and method_exists( $if_cond2, 'templateValue' ) )
    $if_cond2 = $if_cond2->templateValue();
if ( $if_cond1 )
    $if_cond = $if_cond1;
else if ( $if_cond2 )
    $if_cond = $if_cond2;
else
    $if_cond = false;
unset( $if_cond1, $if_cond2 );
if (! isset( $if_cond ) ) $if_cond = NULL;
while ( is_object( $if_cond ) and method_exists( $if_cond, 'templateValue' ) )
    $if_cond = $if_cond->templateValue();

if ( $if_cond )
{
$text .= '<a href=';
unset( $var );
unset( $var1 );
unset( $var2 );
unset( $var2 );
$var2 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'page_uri', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['page_uri'] : null;
if (! isset( $var2 ) ) $var2 = NULL;
while ( is_object( $var2 ) and method_exists( $var2, 'templateValue' ) )
    $var2 = $var2->templateValue();
while ( is_object( $var2 ) and method_exists( $var2, 'templateValue' ) )
    $var2 = $var2->templateValue();
unset( $var4 );
unset( $var4 );
$var4 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'letter', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['letter'] : null;
if (! isset( $var4 ) ) $var4 = NULL;
while ( is_object( $var4 ) and method_exists( $var4, 'templateValue' ) )
    $var4 = $var4->templateValue();
while ( is_object( $var4 ) and method_exists( $var4, 'templateValue' ) )
    $var4 = $var4->templateValue();
unset( $var5 );
unset( $var5 );
$var5 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'page_uri_suffix', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['page_uri_suffix'] : null;
if (! isset( $var5 ) ) $var5 = NULL;
while ( is_object( $var5 ) and method_exists( $var5, 'templateValue' ) )
    $var5 = $var5->templateValue();
while ( is_object( $var5 ) and method_exists( $var5, 'templateValue' ) )
    $var5 = $var5->templateValue();
$var1 = ( $var2 . '/(namefilter)/' . $var4 . $var5 );
unset( $var2, $var4, $var5 );
if (! isset( $var1 ) ) $var1 = NULL;
while ( is_object( $var1 ) and method_exists( $var1, 'templateValue' ) )
    $var1 = $var1->templateValue();

eZURI::transformURI( $var1, false, eZURI::getTransformURIMode() );
$var1 = '"' . $var1 . '"';
$var = $var1;
unset( $var1 );
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
$text .= $var;
unset( $var );

$text .= '>
              ';
}
else
{
$text .= '                 <span class="disabled">
              ';
}
unset( $if_cond );
// if ends

$text .= '              ';
unset( $var );
unset( $var );
$var = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'letter', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['letter'] : null;
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
$text .= ( is_object( $var ) ? compiledFetchText( $tpl, $rootNamespace, $currentNamespace, false, $var ) : $var );
unset( $var );

// if begins
unset( $if_cond );
unset( $if_cond1 );
unset( $if_cond2 );
unset( $if_cond3 );
unset( $if_cond3 );
$if_cond3 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'children_count_by_letter', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['children_count_by_letter'] : null;
if (! isset( $if_cond3 ) ) $if_cond3 = NULL;
while ( is_object( $if_cond3 ) and method_exists( $if_cond3, 'templateValue' ) )
    $if_cond3 = $if_cond3->templateValue();
$if_cond2 = ( ( $if_cond3 ) != ( false ) );
unset( $if_cond3 );
if (! isset( $if_cond2 ) ) $if_cond2 = NULL;
while ( is_object( $if_cond2 ) and method_exists( $if_cond2, 'templateValue' ) )
    $if_cond2 = $if_cond2->templateValue();
unset( $if_cond3 );
unset( $if_cond4 );
unset( $if_cond5 );
unset( $if_cond5 );
$if_cond5 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'children_count_by_letter', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['children_count_by_letter'] : null;
unset( $if_cond7 );
unset( $if_cond7 );
$if_cond7 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'letter', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['letter'] : null;
if (! isset( $if_cond7 ) ) $if_cond7 = NULL;
while ( is_object( $if_cond7 ) and method_exists( $if_cond7, 'templateValue' ) )
    $if_cond7 = $if_cond7->templateValue();
$if_cond6 = compiledFetchAttribute( $if_cond5, $if_cond7 );
unset( $if_cond5 );
$if_cond5 = $if_cond6;
if (! isset( $if_cond5 ) ) $if_cond5 = NULL;
while ( is_object( $if_cond5 ) and method_exists( $if_cond5, 'templateValue' ) )
    $if_cond5 = $if_cond5->templateValue();
$if_cond4 = isset( $if_cond5 );unset( $if_cond5 );
if (! isset( $if_cond4 ) ) $if_cond4 = NULL;
while ( is_object( $if_cond4 ) and method_exists( $if_cond4, 'templateValue' ) )
    $if_cond4 = $if_cond4->templateValue();
unset( $if_cond5 );
unset( $if_cond6 );
unset( $if_cond6 );
$if_cond6 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'children_count_by_letter', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['children_count_by_letter'] : null;
unset( $if_cond8 );
unset( $if_cond8 );
$if_cond8 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'letter', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['letter'] : null;
if (! isset( $if_cond8 ) ) $if_cond8 = NULL;
while ( is_object( $if_cond8 ) and method_exists( $if_cond8, 'templateValue' ) )
    $if_cond8 = $if_cond8->templateValue();
$if_cond7 = compiledFetchAttribute( $if_cond6, $if_cond8 );
unset( $if_cond6 );
$if_cond6 = $if_cond7;
if (! isset( $if_cond6 ) ) $if_cond6 = NULL;
while ( is_object( $if_cond6 ) and method_exists( $if_cond6, 'templateValue' ) )
    $if_cond6 = $if_cond6->templateValue();
$if_cond5 = ( ( $if_cond6 ) > ( 0 ) );
unset( $if_cond6 );
if (! isset( $if_cond5 ) ) $if_cond5 = NULL;
while ( is_object( $if_cond5 ) and method_exists( $if_cond5, 'templateValue' ) )
    $if_cond5 = $if_cond5->templateValue();
if ( !$if_cond4 )
    $if_cond3 = false;
else if ( !$if_cond5 )
    $if_cond3 = false;
else
    $if_cond3 = $if_cond5;
unset( $if_cond4, $if_cond5 );
if (! isset( $if_cond3 ) ) $if_cond3 = NULL;
while ( is_object( $if_cond3 ) and method_exists( $if_cond3, 'templateValue' ) )
    $if_cond3 = $if_cond3->templateValue();
if ( !$if_cond2 )
    $if_cond1 = false;
else if ( !$if_cond3 )
    $if_cond1 = false;
else
    $if_cond1 = $if_cond3;
unset( $if_cond2, $if_cond3 );
if (! isset( $if_cond1 ) ) $if_cond1 = NULL;
while ( is_object( $if_cond1 ) and method_exists( $if_cond1, 'templateValue' ) )
    $if_cond1 = $if_cond1->templateValue();
unset( $if_cond2 );
unset( $if_cond3 );
unset( $if_cond3 );
$if_cond3 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'children_count_by_letter', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['children_count_by_letter'] : null;
if (! isset( $if_cond3 ) ) $if_cond3 = NULL;
while ( is_object( $if_cond3 ) and method_exists( $if_cond3, 'templateValue' ) )
    $if_cond3 = $if_cond3->templateValue();
$if_cond2 = ( ( $if_cond3 ) == ( false ) );
unset( $if_cond3 );
if (! isset( $if_cond2 ) ) $if_cond2 = NULL;
while ( is_object( $if_cond2 ) and method_exists( $if_cond2, 'templateValue' ) )
    $if_cond2 = $if_cond2->templateValue();
if ( $if_cond1 )
    $if_cond = $if_cond1;
else if ( $if_cond2 )
    $if_cond = $if_cond2;
else
    $if_cond = false;
unset( $if_cond1, $if_cond2 );
if (! isset( $if_cond ) ) $if_cond = NULL;
while ( is_object( $if_cond ) and method_exists( $if_cond, 'templateValue' ) )
    $if_cond = $if_cond->templateValue();

if ( $if_cond )
{
$text .= '                 </a>
              ';
}
else
{
$text .= '                 </span>
              ';
}
unset( $if_cond );
// if ends

$text .= '              </span>
                 ';
}
unset( $if_cond );
// if ends

$text .= '             ';
unset( $var );
unset( $var1 );
unset( $var1 );
$var1 = ( array_key_exists( $currentNamespace, $vars ) and array_key_exists( 'c', $vars[$currentNamespace] ) ) ? $vars[$currentNamespace]['c'] : null;
if (! isset( $var1 ) ) $var1 = NULL;
while ( is_object( $var1 ) and method_exists( $var1, 'templateValue' ) )
    $var1 = $var1->templateValue();
while ( is_object( $var1 ) and method_exists( $var1, 'templateValue' ) )
    $var1 = $var1->templateValue();
$var = $var1 + 1;
unset( $var1 );
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
if ( array_key_exists( $currentNamespace, $vars ) && array_key_exists( 'c', $vars[$currentNamespace] ) )
{
    $vars[$currentNamespace]['c'] = $var;
    unset( $var );
}
$text .= '             ';
// if begins
unset( $if_cond );
unset( $if_cond1 );
unset( $if_cond1 );
$if_cond1 = ( array_key_exists( $currentNamespace, $vars ) and array_key_exists( 'c', $vars[$currentNamespace] ) ) ? $vars[$currentNamespace]['c'] : null;
if (! isset( $if_cond1 ) ) $if_cond1 = NULL;
while ( is_object( $if_cond1 ) and method_exists( $if_cond1, 'templateValue' ) )
    $if_cond1 = $if_cond1->templateValue();
$if_cond = ( ( $if_cond1 ) > ( 25 ) );
unset( $if_cond1 );
if (! isset( $if_cond ) ) $if_cond = NULL;
while ( is_object( $if_cond ) and method_exists( $if_cond, 'templateValue' ) )
    $if_cond = $if_cond->templateValue();

if ( $if_cond )
{
$text .= '                ';
if ( array_key_exists( $currentNamespace, $vars ) && array_key_exists( 'c', $vars[$currentNamespace] ) )
{
    $vars[$currentNamespace]['c'] = 0;
}
$text .= '                <br />
                 ';
}
unset( $if_cond );
// if ends

$text .= '            ';
$fe_n_items_processed_cc7a006f362346f674a27d9ed08c0044_26++;
} // foreach
$skipDelimiter = false;
if ( count( $fe_variable_stack_cc7a006f362346f674a27d9ed08c0044_26 ) ) extract( array_pop( $fe_variable_stack_cc7a006f362346f674a27d9ed08c0044_26 ) );

else
{

unset( $fe_array_cc7a006f362346f674a27d9ed08c0044_26 );

unset( $fe_array_keys_cc7a006f362346f674a27d9ed08c0044_26 );

unset( $fe_n_items_cc7a006f362346f674a27d9ed08c0044_26 );

unset( $fe_n_items_processed_cc7a006f362346f674a27d9ed08c0044_26 );

unset( $fe_i_cc7a006f362346f674a27d9ed08c0044_26 );

unset( $fe_key_cc7a006f362346f674a27d9ed08c0044_26 );

unset( $fe_val_cc7a006f362346f674a27d9ed08c0044_26 );

unset( $fe_offset_cc7a006f362346f674a27d9ed08c0044_26 );

unset( $fe_max_cc7a006f362346f674a27d9ed08c0044_26 );

unset( $fe_reverse_cc7a006f362346f674a27d9ed08c0044_26 );

unset( $fe_first_val_cc7a006f362346f674a27d9ed08c0044_26 );

unset( $fe_last_val_cc7a006f362346f674a27d9ed08c0044_26 );

unset( $fe_variable_stack_cc7a006f362346f674a27d9ed08c0044_26 );

}

// foreach ends
$text .= '       </span>
       ';
unset( $vars[$currentNamespace]['c'] );
$text .= '       </p>
       <div class="break"></div>
       </div>
   ';
}
unset( $if_cond );
// if ends

$text .= '   ';
if ( isset( $setArray[$currentNamespace]['children_count_by_letter'] ) )
{
unset( $vars[$currentNamespace]['children_count_by_letter'] );
}

if ( isset( $setArray[$currentNamespace]['objectname_filter'] ) )
{
unset( $vars[$currentNamespace]['objectname_filter'] );
}

if ( isset( $setArray[$currentNamespace]['alphabet'] ) )
{
unset( $vars[$currentNamespace]['alphabet'] );
}

if ( isset( $setArray[$currentNamespace]['node_id'] ) )
{
unset( $vars[$currentNamespace]['node_id'] );
}

if ( isset( $setArray[$currentNamespace]['page_uri_suffix'] ) )
{
unset( $vars[$currentNamespace]['page_uri_suffix'] );
}

if ( isset( $setArray[$currentNamespace]['page_count'] ) )
{
unset( $vars[$currentNamespace]['page_count'] );
}

}
unset( $if_cond );
// if ends

if ( isset( $setArray[$currentNamespace]['page_uri_suffix'] ) )
{
unset( $vars[$currentNamespace]['page_uri_suffix'] );
}

if ( isset( $setArray[$currentNamespace]['show_google_navigator'] ) )
{
unset( $vars[$currentNamespace]['show_google_navigator'] );
}


$setArray = $oldSetArray_c12448851a3818d40a983aa36adf15b6;
$tpl->Level--;
?>
