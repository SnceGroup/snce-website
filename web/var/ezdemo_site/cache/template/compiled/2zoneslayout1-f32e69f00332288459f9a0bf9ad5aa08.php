<?php
// URI:       design:zone/2zoneslayout1.tpl
// Filename:  extension/ezdemo/design/ezdemo/templates/zone/2zoneslayout1.tpl
// Timestamp: 1390304571 (Tue Jan 21 12:42:51 CET 2014)
$oldSetArray_2e1ea8fca240094eb6f77e3cc2ad9caf = isset( $setArray ) ? $setArray : array();
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

$text .= '<div class="zone-layout-';
unset( $var );
unset( $var1 );
unset( $var1 );
$var1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'zone_layout', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['zone_layout'] : null;
if (! isset( $var1 ) ) $var1 = NULL;
while ( is_object( $var1 ) and method_exists( $var1, 'templateValue' ) )
    $var1 = $var1->templateValue();
while ( is_object( $var1 ) and method_exists( $var1, 'templateValue' ) )
    $var1 = $var1->templateValue();
$var = mb_strtolower( $var1 );
unset( $var1 );
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
$text .= $var;
unset( $var );

$text .= ' row">
    <div class="span8">
        <section class="content-view-block">
            ';
// if begins
unset( $if_cond );
unset( $if_cond1 );
unset( $if_cond2 );
unset( $if_cond2 );
$if_cond2 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'zones', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['zones'] : null;
$if_cond3 = compiledFetchAttribute( $if_cond2, 0 );
unset( $if_cond2 );
$if_cond2 = $if_cond3;
$if_cond3 = compiledFetchAttribute( $if_cond2, 'blocks' );
unset( $if_cond2 );
$if_cond2 = $if_cond3;
if (! isset( $if_cond2 ) ) $if_cond2 = NULL;
while ( is_object( $if_cond2 ) and method_exists( $if_cond2, 'templateValue' ) )
    $if_cond2 = $if_cond2->templateValue();
$if_cond1 = isset( $if_cond2 );unset( $if_cond2 );
if (! isset( $if_cond1 ) ) $if_cond1 = NULL;
while ( is_object( $if_cond1 ) and method_exists( $if_cond1, 'templateValue' ) )
    $if_cond1 = $if_cond1->templateValue();
unset( $if_cond2 );
unset( $if_cond2 );
$if_cond2 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'zones', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['zones'] : null;
$if_cond3 = compiledFetchAttribute( $if_cond2, 0 );
unset( $if_cond2 );
$if_cond2 = $if_cond3;
$if_cond3 = compiledFetchAttribute( $if_cond2, 'blocks' );
unset( $if_cond2 );
$if_cond2 = $if_cond3;
if (! isset( $if_cond2 ) ) $if_cond2 = NULL;
while ( is_object( $if_cond2 ) and method_exists( $if_cond2, 'templateValue' ) )
    $if_cond2 = $if_cond2->templateValue();
$if_cond2Data = array( 'value' => $if_cond2 );
$tpl->processOperator( 'count',
                       array (
),
                       $rootNamespace, $currentNamespace, $if_cond2Data, false, false );
$if_cond2 = $if_cond2Data['value'];
unset( $if_cond2Data );
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
$text .= '            ';
// foreach begins
$skipDelimiter = true;
if ( !isset( $fe_variable_stack_996e8c0e4359ad9f02b84fa1c7aba01a_1 ) ) $fe_variable_stack_996e8c0e4359ad9f02b84fa1c7aba01a_1 = array();
$fe_variable_stack_996e8c0e4359ad9f02b84fa1c7aba01a_1[] = compact( 'fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_1', 'fe_array_keys_996e8c0e4359ad9f02b84fa1c7aba01a_1', 'fe_n_items_996e8c0e4359ad9f02b84fa1c7aba01a_1', 'fe_n_items_processed_996e8c0e4359ad9f02b84fa1c7aba01a_1', 'fe_i_996e8c0e4359ad9f02b84fa1c7aba01a_1', 'fe_key_996e8c0e4359ad9f02b84fa1c7aba01a_1', 'fe_val_996e8c0e4359ad9f02b84fa1c7aba01a_1', 'fe_offset_996e8c0e4359ad9f02b84fa1c7aba01a_1', 'fe_max_996e8c0e4359ad9f02b84fa1c7aba01a_1', 'fe_reverse_996e8c0e4359ad9f02b84fa1c7aba01a_1', 'fe_first_val_996e8c0e4359ad9f02b84fa1c7aba01a_1', 'fe_last_val_996e8c0e4359ad9f02b84fa1c7aba01a_1' );
unset( $fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_1 );
unset( $fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_1 );
$fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'zones', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['zones'] : null;
$fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_11 = compiledFetchAttribute( $fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_1, 0 );
unset( $fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_1 );
$fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_1 = $fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_11;
$fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_11 = compiledFetchAttribute( $fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_1, 'blocks' );
unset( $fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_1 );
$fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_1 = $fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_11;
if (! isset( $fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_1 ) ) $fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_1 = NULL;
while ( is_object( $fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_1 ) and method_exists( $fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_1, 'templateValue' ) )
    $fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_1 = $fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_1->templateValue();

$fe_array_keys_996e8c0e4359ad9f02b84fa1c7aba01a_1 = is_array( $fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_1 ) ? array_keys( $fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_1 ) : array();
$fe_n_items_996e8c0e4359ad9f02b84fa1c7aba01a_1 = count( $fe_array_keys_996e8c0e4359ad9f02b84fa1c7aba01a_1 );
$fe_n_items_processed_996e8c0e4359ad9f02b84fa1c7aba01a_1 = 0;
$fe_offset_996e8c0e4359ad9f02b84fa1c7aba01a_1 = 0;
$fe_max_996e8c0e4359ad9f02b84fa1c7aba01a_1 = $fe_n_items_996e8c0e4359ad9f02b84fa1c7aba01a_1 - $fe_offset_996e8c0e4359ad9f02b84fa1c7aba01a_1;
$fe_reverse_996e8c0e4359ad9f02b84fa1c7aba01a_1 = false;
if ( $fe_offset_996e8c0e4359ad9f02b84fa1c7aba01a_1 < 0 || $fe_offset_996e8c0e4359ad9f02b84fa1c7aba01a_1 >= $fe_n_items_996e8c0e4359ad9f02b84fa1c7aba01a_1 )
{
    $fe_offset_996e8c0e4359ad9f02b84fa1c7aba01a_1 = ( $fe_offset_996e8c0e4359ad9f02b84fa1c7aba01a_1 < 0 ) ? 0 : $fe_n_items_996e8c0e4359ad9f02b84fa1c7aba01a_1;
    if ( $fe_n_items_996e8c0e4359ad9f02b84fa1c7aba01a_1 || $fe_offset_996e8c0e4359ad9f02b84fa1c7aba01a_1 < 0 )
 {
        eZDebug::writeWarning("Invalid 'offset' parameter specified: '$fe_offset_996e8c0e4359ad9f02b84fa1c7aba01a_1'. Array count: $fe_n_items_996e8c0e4359ad9f02b84fa1c7aba01a_1");   
}
}
if ( $fe_max_996e8c0e4359ad9f02b84fa1c7aba01a_1 < 0 || $fe_offset_996e8c0e4359ad9f02b84fa1c7aba01a_1 + $fe_max_996e8c0e4359ad9f02b84fa1c7aba01a_1 > $fe_n_items_996e8c0e4359ad9f02b84fa1c7aba01a_1 )
{
    if ( $fe_max_996e8c0e4359ad9f02b84fa1c7aba01a_1 < 0 )
 eZDebug::writeWarning("Invalid 'max' parameter specified: $fe_max_996e8c0e4359ad9f02b84fa1c7aba01a_1");
    $fe_max_996e8c0e4359ad9f02b84fa1c7aba01a_1 = $fe_n_items_996e8c0e4359ad9f02b84fa1c7aba01a_1 - $fe_offset_996e8c0e4359ad9f02b84fa1c7aba01a_1;
}
if ( $fe_reverse_996e8c0e4359ad9f02b84fa1c7aba01a_1 )
{
    $fe_first_val_996e8c0e4359ad9f02b84fa1c7aba01a_1 = $fe_n_items_996e8c0e4359ad9f02b84fa1c7aba01a_1 - 1 - $fe_offset_996e8c0e4359ad9f02b84fa1c7aba01a_1;
    $fe_last_val_996e8c0e4359ad9f02b84fa1c7aba01a_1  = 0;
}
else
{
    $fe_first_val_996e8c0e4359ad9f02b84fa1c7aba01a_1 = $fe_offset_996e8c0e4359ad9f02b84fa1c7aba01a_1;
    $fe_last_val_996e8c0e4359ad9f02b84fa1c7aba01a_1  = $fe_n_items_996e8c0e4359ad9f02b84fa1c7aba01a_1 - 1;
}
// foreach
for ( $fe_i_996e8c0e4359ad9f02b84fa1c7aba01a_1 = $fe_first_val_996e8c0e4359ad9f02b84fa1c7aba01a_1; $fe_n_items_processed_996e8c0e4359ad9f02b84fa1c7aba01a_1 < $fe_max_996e8c0e4359ad9f02b84fa1c7aba01a_1 && ( $fe_reverse_996e8c0e4359ad9f02b84fa1c7aba01a_1 ? $fe_i_996e8c0e4359ad9f02b84fa1c7aba01a_1 >= $fe_last_val_996e8c0e4359ad9f02b84fa1c7aba01a_1 : $fe_i_996e8c0e4359ad9f02b84fa1c7aba01a_1 <= $fe_last_val_996e8c0e4359ad9f02b84fa1c7aba01a_1 ); $fe_reverse_996e8c0e4359ad9f02b84fa1c7aba01a_1 ? $fe_i_996e8c0e4359ad9f02b84fa1c7aba01a_1-- : $fe_i_996e8c0e4359ad9f02b84fa1c7aba01a_1++ )
{
$fe_key_996e8c0e4359ad9f02b84fa1c7aba01a_1 = $fe_array_keys_996e8c0e4359ad9f02b84fa1c7aba01a_1[$fe_i_996e8c0e4359ad9f02b84fa1c7aba01a_1];
$fe_val_996e8c0e4359ad9f02b84fa1c7aba01a_1 = $fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_1[$fe_key_996e8c0e4359ad9f02b84fa1c7aba01a_1];
$vars[$rootNamespace]['block'] = $fe_val_996e8c0e4359ad9f02b84fa1c7aba01a_1;
$text .= '                ';
$oldRestoreIncludeArray_5b0ffea577b8da50628f37e6818227a0 = isset( $restoreIncludeArray ) ? $restoreIncludeArray : array();
$restoreIncludeArray = array();

if ( isset( $currentNamespace ) and isset( $vars[$currentNamespace]['zone'] ) )
    $restoreIncludeArray[] = array( $currentNamespace, 'zone', $vars[$currentNamespace]['zone'] );
elseif ( !isset( $vars[( isset( $currentNamespace ) ? $currentNamespace : '' )]['zone'] ) ) 
    $restoreIncludeArray[] = array( ( isset( $currentNamespace ) ? $currentNamespace : '' ), 'zone', 'unset' );

unset( $var );
unset( $var );
$var = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'zones', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['zones'] : null;
$var1 = compiledFetchAttribute( $var, 0 );
unset( $var );
$var = $var1;
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
$vars[$currentNamespace]['zone'] = $var;
unset( $var );
if ( !isset( $dKeys ) )
{
    $resH = $tpl->resourceHandler( "design" );
    $dKeys = $resH->keys();
}

$resourceFound = false;
if ( file_exists( 'var/ezdemo_site/cache/template/compiled/zone_block-8686a29e20eab29dde17a2d9079f3fac.php' ) )
{
$resourceFound = true;
$namespaceStack[] = array( $rootNamespace, $currentNamespace );
$rootNamespace = $currentNamespace;
$tpl->createLocalVariablesList();
$tpl->appendTemplateFetch( 'extension/ezflow/design/standard/templates/parts/zone_block.tpl' );
include( '' . 'var/ezdemo_site/cache/template/compiled/zone_block-8686a29e20eab29dde17a2d9079f3fac.php' );
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
$tpl->processURI( 'extension/ezflow/design/standard/templates/parts/zone_block.tpl', true, $extraParameters, $textElements, $rootNamespace, $currentNamespace );
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
$restoreIncludeArray = $oldRestoreIncludeArray_5b0ffea577b8da50628f37e6818227a0;

$text .= '            ';
$fe_n_items_processed_996e8c0e4359ad9f02b84fa1c7aba01a_1++;
} // foreach
$skipDelimiter = false;
if ( count( $fe_variable_stack_996e8c0e4359ad9f02b84fa1c7aba01a_1 ) ) extract( array_pop( $fe_variable_stack_996e8c0e4359ad9f02b84fa1c7aba01a_1 ) );

else
{

unset( $fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_1 );

unset( $fe_array_keys_996e8c0e4359ad9f02b84fa1c7aba01a_1 );

unset( $fe_n_items_996e8c0e4359ad9f02b84fa1c7aba01a_1 );

unset( $fe_n_items_processed_996e8c0e4359ad9f02b84fa1c7aba01a_1 );

unset( $fe_i_996e8c0e4359ad9f02b84fa1c7aba01a_1 );

unset( $fe_key_996e8c0e4359ad9f02b84fa1c7aba01a_1 );

unset( $fe_val_996e8c0e4359ad9f02b84fa1c7aba01a_1 );

unset( $fe_offset_996e8c0e4359ad9f02b84fa1c7aba01a_1 );

unset( $fe_max_996e8c0e4359ad9f02b84fa1c7aba01a_1 );

unset( $fe_reverse_996e8c0e4359ad9f02b84fa1c7aba01a_1 );

unset( $fe_first_val_996e8c0e4359ad9f02b84fa1c7aba01a_1 );

unset( $fe_last_val_996e8c0e4359ad9f02b84fa1c7aba01a_1 );

unset( $fe_variable_stack_996e8c0e4359ad9f02b84fa1c7aba01a_1 );

}

// foreach ends
$text .= '            ';
}
unset( $if_cond );
// if ends

$text .= '        </section>
    </div>
    <div class="span4">
        <aside>
            <section class="content-view-block content-view-aside">
                ';
// if begins
unset( $if_cond );
unset( $if_cond1 );
unset( $if_cond2 );
unset( $if_cond2 );
$if_cond2 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'zones', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['zones'] : null;
$if_cond3 = compiledFetchAttribute( $if_cond2, 1 );
unset( $if_cond2 );
$if_cond2 = $if_cond3;
$if_cond3 = compiledFetchAttribute( $if_cond2, 'blocks' );
unset( $if_cond2 );
$if_cond2 = $if_cond3;
if (! isset( $if_cond2 ) ) $if_cond2 = NULL;
while ( is_object( $if_cond2 ) and method_exists( $if_cond2, 'templateValue' ) )
    $if_cond2 = $if_cond2->templateValue();
$if_cond1 = isset( $if_cond2 );unset( $if_cond2 );
if (! isset( $if_cond1 ) ) $if_cond1 = NULL;
while ( is_object( $if_cond1 ) and method_exists( $if_cond1, 'templateValue' ) )
    $if_cond1 = $if_cond1->templateValue();
unset( $if_cond2 );
unset( $if_cond2 );
$if_cond2 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'zones', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['zones'] : null;
$if_cond3 = compiledFetchAttribute( $if_cond2, 1 );
unset( $if_cond2 );
$if_cond2 = $if_cond3;
$if_cond3 = compiledFetchAttribute( $if_cond2, 'blocks' );
unset( $if_cond2 );
$if_cond2 = $if_cond3;
if (! isset( $if_cond2 ) ) $if_cond2 = NULL;
while ( is_object( $if_cond2 ) and method_exists( $if_cond2, 'templateValue' ) )
    $if_cond2 = $if_cond2->templateValue();
$if_cond2Data = array( 'value' => $if_cond2 );
$tpl->processOperator( 'count',
                       array (
),
                       $rootNamespace, $currentNamespace, $if_cond2Data, false, false );
$if_cond2 = $if_cond2Data['value'];
unset( $if_cond2Data );
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
$text .= '                ';
// foreach begins
$skipDelimiter = true;
if ( !isset( $fe_variable_stack_996e8c0e4359ad9f02b84fa1c7aba01a_2 ) ) $fe_variable_stack_996e8c0e4359ad9f02b84fa1c7aba01a_2 = array();
$fe_variable_stack_996e8c0e4359ad9f02b84fa1c7aba01a_2[] = compact( 'fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_2', 'fe_array_keys_996e8c0e4359ad9f02b84fa1c7aba01a_2', 'fe_n_items_996e8c0e4359ad9f02b84fa1c7aba01a_2', 'fe_n_items_processed_996e8c0e4359ad9f02b84fa1c7aba01a_2', 'fe_i_996e8c0e4359ad9f02b84fa1c7aba01a_2', 'fe_key_996e8c0e4359ad9f02b84fa1c7aba01a_2', 'fe_val_996e8c0e4359ad9f02b84fa1c7aba01a_2', 'fe_offset_996e8c0e4359ad9f02b84fa1c7aba01a_2', 'fe_max_996e8c0e4359ad9f02b84fa1c7aba01a_2', 'fe_reverse_996e8c0e4359ad9f02b84fa1c7aba01a_2', 'fe_first_val_996e8c0e4359ad9f02b84fa1c7aba01a_2', 'fe_last_val_996e8c0e4359ad9f02b84fa1c7aba01a_2' );
unset( $fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_2 );
unset( $fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_2 );
$fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_2 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'zones', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['zones'] : null;
$fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_21 = compiledFetchAttribute( $fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_2, 1 );
unset( $fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_2 );
$fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_2 = $fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_21;
$fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_21 = compiledFetchAttribute( $fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_2, 'blocks' );
unset( $fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_2 );
$fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_2 = $fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_21;
if (! isset( $fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_2 ) ) $fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_2 = NULL;
while ( is_object( $fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_2 ) and method_exists( $fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_2, 'templateValue' ) )
    $fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_2 = $fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_2->templateValue();

$fe_array_keys_996e8c0e4359ad9f02b84fa1c7aba01a_2 = is_array( $fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_2 ) ? array_keys( $fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_2 ) : array();
$fe_n_items_996e8c0e4359ad9f02b84fa1c7aba01a_2 = count( $fe_array_keys_996e8c0e4359ad9f02b84fa1c7aba01a_2 );
$fe_n_items_processed_996e8c0e4359ad9f02b84fa1c7aba01a_2 = 0;
$fe_offset_996e8c0e4359ad9f02b84fa1c7aba01a_2 = 0;
$fe_max_996e8c0e4359ad9f02b84fa1c7aba01a_2 = $fe_n_items_996e8c0e4359ad9f02b84fa1c7aba01a_2 - $fe_offset_996e8c0e4359ad9f02b84fa1c7aba01a_2;
$fe_reverse_996e8c0e4359ad9f02b84fa1c7aba01a_2 = false;
if ( $fe_offset_996e8c0e4359ad9f02b84fa1c7aba01a_2 < 0 || $fe_offset_996e8c0e4359ad9f02b84fa1c7aba01a_2 >= $fe_n_items_996e8c0e4359ad9f02b84fa1c7aba01a_2 )
{
    $fe_offset_996e8c0e4359ad9f02b84fa1c7aba01a_2 = ( $fe_offset_996e8c0e4359ad9f02b84fa1c7aba01a_2 < 0 ) ? 0 : $fe_n_items_996e8c0e4359ad9f02b84fa1c7aba01a_2;
    if ( $fe_n_items_996e8c0e4359ad9f02b84fa1c7aba01a_2 || $fe_offset_996e8c0e4359ad9f02b84fa1c7aba01a_2 < 0 )
 {
        eZDebug::writeWarning("Invalid 'offset' parameter specified: '$fe_offset_996e8c0e4359ad9f02b84fa1c7aba01a_2'. Array count: $fe_n_items_996e8c0e4359ad9f02b84fa1c7aba01a_2");   
}
}
if ( $fe_max_996e8c0e4359ad9f02b84fa1c7aba01a_2 < 0 || $fe_offset_996e8c0e4359ad9f02b84fa1c7aba01a_2 + $fe_max_996e8c0e4359ad9f02b84fa1c7aba01a_2 > $fe_n_items_996e8c0e4359ad9f02b84fa1c7aba01a_2 )
{
    if ( $fe_max_996e8c0e4359ad9f02b84fa1c7aba01a_2 < 0 )
 eZDebug::writeWarning("Invalid 'max' parameter specified: $fe_max_996e8c0e4359ad9f02b84fa1c7aba01a_2");
    $fe_max_996e8c0e4359ad9f02b84fa1c7aba01a_2 = $fe_n_items_996e8c0e4359ad9f02b84fa1c7aba01a_2 - $fe_offset_996e8c0e4359ad9f02b84fa1c7aba01a_2;
}
if ( $fe_reverse_996e8c0e4359ad9f02b84fa1c7aba01a_2 )
{
    $fe_first_val_996e8c0e4359ad9f02b84fa1c7aba01a_2 = $fe_n_items_996e8c0e4359ad9f02b84fa1c7aba01a_2 - 1 - $fe_offset_996e8c0e4359ad9f02b84fa1c7aba01a_2;
    $fe_last_val_996e8c0e4359ad9f02b84fa1c7aba01a_2  = 0;
}
else
{
    $fe_first_val_996e8c0e4359ad9f02b84fa1c7aba01a_2 = $fe_offset_996e8c0e4359ad9f02b84fa1c7aba01a_2;
    $fe_last_val_996e8c0e4359ad9f02b84fa1c7aba01a_2  = $fe_n_items_996e8c0e4359ad9f02b84fa1c7aba01a_2 - 1;
}
// foreach
for ( $fe_i_996e8c0e4359ad9f02b84fa1c7aba01a_2 = $fe_first_val_996e8c0e4359ad9f02b84fa1c7aba01a_2; $fe_n_items_processed_996e8c0e4359ad9f02b84fa1c7aba01a_2 < $fe_max_996e8c0e4359ad9f02b84fa1c7aba01a_2 && ( $fe_reverse_996e8c0e4359ad9f02b84fa1c7aba01a_2 ? $fe_i_996e8c0e4359ad9f02b84fa1c7aba01a_2 >= $fe_last_val_996e8c0e4359ad9f02b84fa1c7aba01a_2 : $fe_i_996e8c0e4359ad9f02b84fa1c7aba01a_2 <= $fe_last_val_996e8c0e4359ad9f02b84fa1c7aba01a_2 ); $fe_reverse_996e8c0e4359ad9f02b84fa1c7aba01a_2 ? $fe_i_996e8c0e4359ad9f02b84fa1c7aba01a_2-- : $fe_i_996e8c0e4359ad9f02b84fa1c7aba01a_2++ )
{
$fe_key_996e8c0e4359ad9f02b84fa1c7aba01a_2 = $fe_array_keys_996e8c0e4359ad9f02b84fa1c7aba01a_2[$fe_i_996e8c0e4359ad9f02b84fa1c7aba01a_2];
$fe_val_996e8c0e4359ad9f02b84fa1c7aba01a_2 = $fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_2[$fe_key_996e8c0e4359ad9f02b84fa1c7aba01a_2];
$vars[$rootNamespace]['block'] = $fe_val_996e8c0e4359ad9f02b84fa1c7aba01a_2;
$text .= '                    ';
$oldRestoreIncludeArray_c320fbbfebe852b4e601eb239b944c40 = isset( $restoreIncludeArray ) ? $restoreIncludeArray : array();
$restoreIncludeArray = array();

if ( isset( $currentNamespace ) and isset( $vars[$currentNamespace]['zone'] ) )
    $restoreIncludeArray[] = array( $currentNamespace, 'zone', $vars[$currentNamespace]['zone'] );
elseif ( !isset( $vars[( isset( $currentNamespace ) ? $currentNamespace : '' )]['zone'] ) ) 
    $restoreIncludeArray[] = array( ( isset( $currentNamespace ) ? $currentNamespace : '' ), 'zone', 'unset' );

unset( $var );
unset( $var );
$var = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'zones', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['zones'] : null;
$var1 = compiledFetchAttribute( $var, 1 );
unset( $var );
$var = $var1;
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
$vars[$currentNamespace]['zone'] = $var;
unset( $var );
if ( !isset( $dKeys ) )
{
    $resH = $tpl->resourceHandler( "design" );
    $dKeys = $resH->keys();
}

$resourceFound = false;
if ( file_exists( 'var/ezdemo_site/cache/template/compiled/zone_block-8686a29e20eab29dde17a2d9079f3fac.php' ) )
{
$resourceFound = true;
$namespaceStack[] = array( $rootNamespace, $currentNamespace );
$rootNamespace = $currentNamespace;
$tpl->createLocalVariablesList();
$tpl->appendTemplateFetch( 'extension/ezflow/design/standard/templates/parts/zone_block.tpl' );
include( '' . 'var/ezdemo_site/cache/template/compiled/zone_block-8686a29e20eab29dde17a2d9079f3fac.php' );
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
$tpl->processURI( 'extension/ezflow/design/standard/templates/parts/zone_block.tpl', true, $extraParameters, $textElements, $rootNamespace, $currentNamespace );
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
$restoreIncludeArray = $oldRestoreIncludeArray_c320fbbfebe852b4e601eb239b944c40;

$text .= '                ';
$fe_n_items_processed_996e8c0e4359ad9f02b84fa1c7aba01a_2++;
} // foreach
$skipDelimiter = false;
if ( count( $fe_variable_stack_996e8c0e4359ad9f02b84fa1c7aba01a_2 ) ) extract( array_pop( $fe_variable_stack_996e8c0e4359ad9f02b84fa1c7aba01a_2 ) );

else
{

unset( $fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_2 );

unset( $fe_array_keys_996e8c0e4359ad9f02b84fa1c7aba01a_2 );

unset( $fe_n_items_996e8c0e4359ad9f02b84fa1c7aba01a_2 );

unset( $fe_n_items_processed_996e8c0e4359ad9f02b84fa1c7aba01a_2 );

unset( $fe_i_996e8c0e4359ad9f02b84fa1c7aba01a_2 );

unset( $fe_key_996e8c0e4359ad9f02b84fa1c7aba01a_2 );

unset( $fe_val_996e8c0e4359ad9f02b84fa1c7aba01a_2 );

unset( $fe_offset_996e8c0e4359ad9f02b84fa1c7aba01a_2 );

unset( $fe_max_996e8c0e4359ad9f02b84fa1c7aba01a_2 );

unset( $fe_reverse_996e8c0e4359ad9f02b84fa1c7aba01a_2 );

unset( $fe_first_val_996e8c0e4359ad9f02b84fa1c7aba01a_2 );

unset( $fe_last_val_996e8c0e4359ad9f02b84fa1c7aba01a_2 );

unset( $fe_variable_stack_996e8c0e4359ad9f02b84fa1c7aba01a_2 );

}

// foreach ends
$text .= '                ';
}
unset( $if_cond );
// if ends

$text .= '            </section>
        </aside>
    </div>
</div>
';

$setArray = $oldSetArray_2e1ea8fca240094eb6f77e3cc2ad9caf;
$tpl->Level--;
?>
