<?php
// URI:       design:zone/2zoneslayout1.tpl
// Filename:  extension/ezdemo/design/ezdemo/templates/zone/2zoneslayout1.tpl
// Timestamp: 1390304571 (Tue Jan 21 12:42:51 CET 2014)
$oldSetArray_967ee88652768b8c241d0ed1f151f4e3 = isset( $setArray ) ? $setArray : array();
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
if ( !isset( $fe_variable_stack_996e8c0e4359ad9f02b84fa1c7aba01a_5 ) ) $fe_variable_stack_996e8c0e4359ad9f02b84fa1c7aba01a_5 = array();
$fe_variable_stack_996e8c0e4359ad9f02b84fa1c7aba01a_5[] = compact( 'fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_5', 'fe_array_keys_996e8c0e4359ad9f02b84fa1c7aba01a_5', 'fe_n_items_996e8c0e4359ad9f02b84fa1c7aba01a_5', 'fe_n_items_processed_996e8c0e4359ad9f02b84fa1c7aba01a_5', 'fe_i_996e8c0e4359ad9f02b84fa1c7aba01a_5', 'fe_key_996e8c0e4359ad9f02b84fa1c7aba01a_5', 'fe_val_996e8c0e4359ad9f02b84fa1c7aba01a_5', 'fe_offset_996e8c0e4359ad9f02b84fa1c7aba01a_5', 'fe_max_996e8c0e4359ad9f02b84fa1c7aba01a_5', 'fe_reverse_996e8c0e4359ad9f02b84fa1c7aba01a_5', 'fe_first_val_996e8c0e4359ad9f02b84fa1c7aba01a_5', 'fe_last_val_996e8c0e4359ad9f02b84fa1c7aba01a_5' );
unset( $fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_5 );
unset( $fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_5 );
$fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_5 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'zones', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['zones'] : null;
$fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_51 = compiledFetchAttribute( $fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_5, 0 );
unset( $fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_5 );
$fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_5 = $fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_51;
$fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_51 = compiledFetchAttribute( $fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_5, 'blocks' );
unset( $fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_5 );
$fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_5 = $fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_51;
if (! isset( $fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_5 ) ) $fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_5 = NULL;
while ( is_object( $fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_5 ) and method_exists( $fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_5, 'templateValue' ) )
    $fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_5 = $fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_5->templateValue();

$fe_array_keys_996e8c0e4359ad9f02b84fa1c7aba01a_5 = is_array( $fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_5 ) ? array_keys( $fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_5 ) : array();
$fe_n_items_996e8c0e4359ad9f02b84fa1c7aba01a_5 = count( $fe_array_keys_996e8c0e4359ad9f02b84fa1c7aba01a_5 );
$fe_n_items_processed_996e8c0e4359ad9f02b84fa1c7aba01a_5 = 0;
$fe_offset_996e8c0e4359ad9f02b84fa1c7aba01a_5 = 0;
$fe_max_996e8c0e4359ad9f02b84fa1c7aba01a_5 = $fe_n_items_996e8c0e4359ad9f02b84fa1c7aba01a_5 - $fe_offset_996e8c0e4359ad9f02b84fa1c7aba01a_5;
$fe_reverse_996e8c0e4359ad9f02b84fa1c7aba01a_5 = false;
if ( $fe_offset_996e8c0e4359ad9f02b84fa1c7aba01a_5 < 0 || $fe_offset_996e8c0e4359ad9f02b84fa1c7aba01a_5 >= $fe_n_items_996e8c0e4359ad9f02b84fa1c7aba01a_5 )
{
    $fe_offset_996e8c0e4359ad9f02b84fa1c7aba01a_5 = ( $fe_offset_996e8c0e4359ad9f02b84fa1c7aba01a_5 < 0 ) ? 0 : $fe_n_items_996e8c0e4359ad9f02b84fa1c7aba01a_5;
    if ( $fe_n_items_996e8c0e4359ad9f02b84fa1c7aba01a_5 || $fe_offset_996e8c0e4359ad9f02b84fa1c7aba01a_5 < 0 )
 {
        eZDebug::writeWarning("Invalid 'offset' parameter specified: '$fe_offset_996e8c0e4359ad9f02b84fa1c7aba01a_5'. Array count: $fe_n_items_996e8c0e4359ad9f02b84fa1c7aba01a_5");   
}
}
if ( $fe_max_996e8c0e4359ad9f02b84fa1c7aba01a_5 < 0 || $fe_offset_996e8c0e4359ad9f02b84fa1c7aba01a_5 + $fe_max_996e8c0e4359ad9f02b84fa1c7aba01a_5 > $fe_n_items_996e8c0e4359ad9f02b84fa1c7aba01a_5 )
{
    if ( $fe_max_996e8c0e4359ad9f02b84fa1c7aba01a_5 < 0 )
 eZDebug::writeWarning("Invalid 'max' parameter specified: $fe_max_996e8c0e4359ad9f02b84fa1c7aba01a_5");
    $fe_max_996e8c0e4359ad9f02b84fa1c7aba01a_5 = $fe_n_items_996e8c0e4359ad9f02b84fa1c7aba01a_5 - $fe_offset_996e8c0e4359ad9f02b84fa1c7aba01a_5;
}
if ( $fe_reverse_996e8c0e4359ad9f02b84fa1c7aba01a_5 )
{
    $fe_first_val_996e8c0e4359ad9f02b84fa1c7aba01a_5 = $fe_n_items_996e8c0e4359ad9f02b84fa1c7aba01a_5 - 1 - $fe_offset_996e8c0e4359ad9f02b84fa1c7aba01a_5;
    $fe_last_val_996e8c0e4359ad9f02b84fa1c7aba01a_5  = 0;
}
else
{
    $fe_first_val_996e8c0e4359ad9f02b84fa1c7aba01a_5 = $fe_offset_996e8c0e4359ad9f02b84fa1c7aba01a_5;
    $fe_last_val_996e8c0e4359ad9f02b84fa1c7aba01a_5  = $fe_n_items_996e8c0e4359ad9f02b84fa1c7aba01a_5 - 1;
}
// foreach
for ( $fe_i_996e8c0e4359ad9f02b84fa1c7aba01a_5 = $fe_first_val_996e8c0e4359ad9f02b84fa1c7aba01a_5; $fe_n_items_processed_996e8c0e4359ad9f02b84fa1c7aba01a_5 < $fe_max_996e8c0e4359ad9f02b84fa1c7aba01a_5 && ( $fe_reverse_996e8c0e4359ad9f02b84fa1c7aba01a_5 ? $fe_i_996e8c0e4359ad9f02b84fa1c7aba01a_5 >= $fe_last_val_996e8c0e4359ad9f02b84fa1c7aba01a_5 : $fe_i_996e8c0e4359ad9f02b84fa1c7aba01a_5 <= $fe_last_val_996e8c0e4359ad9f02b84fa1c7aba01a_5 ); $fe_reverse_996e8c0e4359ad9f02b84fa1c7aba01a_5 ? $fe_i_996e8c0e4359ad9f02b84fa1c7aba01a_5-- : $fe_i_996e8c0e4359ad9f02b84fa1c7aba01a_5++ )
{
$fe_key_996e8c0e4359ad9f02b84fa1c7aba01a_5 = $fe_array_keys_996e8c0e4359ad9f02b84fa1c7aba01a_5[$fe_i_996e8c0e4359ad9f02b84fa1c7aba01a_5];
$fe_val_996e8c0e4359ad9f02b84fa1c7aba01a_5 = $fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_5[$fe_key_996e8c0e4359ad9f02b84fa1c7aba01a_5];
$vars[$rootNamespace]['block'] = $fe_val_996e8c0e4359ad9f02b84fa1c7aba01a_5;
$text .= '                ';
$oldRestoreIncludeArray_e0a9ec3adffe355428a7f5189a27d2f3 = isset( $restoreIncludeArray ) ? $restoreIncludeArray : array();
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
if ( file_exists( 'var/ezdemo_site/cache/template/compiled/zone_block-315ab376ffc5e09683561fa3e9a231e5.php' ) )
{
$resourceFound = true;
$namespaceStack[] = array( $rootNamespace, $currentNamespace );
$rootNamespace = $currentNamespace;
$tpl->createLocalVariablesList();
$tpl->appendTemplateFetch( 'extension/ezflow/design/standard/templates/parts/zone_block.tpl' );
include( '' . 'var/ezdemo_site/cache/template/compiled/zone_block-315ab376ffc5e09683561fa3e9a231e5.php' );
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
$restoreIncludeArray = $oldRestoreIncludeArray_e0a9ec3adffe355428a7f5189a27d2f3;

$text .= '            ';
$fe_n_items_processed_996e8c0e4359ad9f02b84fa1c7aba01a_5++;
} // foreach
$skipDelimiter = false;
if ( count( $fe_variable_stack_996e8c0e4359ad9f02b84fa1c7aba01a_5 ) ) extract( array_pop( $fe_variable_stack_996e8c0e4359ad9f02b84fa1c7aba01a_5 ) );

else
{

unset( $fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_5 );

unset( $fe_array_keys_996e8c0e4359ad9f02b84fa1c7aba01a_5 );

unset( $fe_n_items_996e8c0e4359ad9f02b84fa1c7aba01a_5 );

unset( $fe_n_items_processed_996e8c0e4359ad9f02b84fa1c7aba01a_5 );

unset( $fe_i_996e8c0e4359ad9f02b84fa1c7aba01a_5 );

unset( $fe_key_996e8c0e4359ad9f02b84fa1c7aba01a_5 );

unset( $fe_val_996e8c0e4359ad9f02b84fa1c7aba01a_5 );

unset( $fe_offset_996e8c0e4359ad9f02b84fa1c7aba01a_5 );

unset( $fe_max_996e8c0e4359ad9f02b84fa1c7aba01a_5 );

unset( $fe_reverse_996e8c0e4359ad9f02b84fa1c7aba01a_5 );

unset( $fe_first_val_996e8c0e4359ad9f02b84fa1c7aba01a_5 );

unset( $fe_last_val_996e8c0e4359ad9f02b84fa1c7aba01a_5 );

unset( $fe_variable_stack_996e8c0e4359ad9f02b84fa1c7aba01a_5 );

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
if ( !isset( $fe_variable_stack_996e8c0e4359ad9f02b84fa1c7aba01a_6 ) ) $fe_variable_stack_996e8c0e4359ad9f02b84fa1c7aba01a_6 = array();
$fe_variable_stack_996e8c0e4359ad9f02b84fa1c7aba01a_6[] = compact( 'fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_6', 'fe_array_keys_996e8c0e4359ad9f02b84fa1c7aba01a_6', 'fe_n_items_996e8c0e4359ad9f02b84fa1c7aba01a_6', 'fe_n_items_processed_996e8c0e4359ad9f02b84fa1c7aba01a_6', 'fe_i_996e8c0e4359ad9f02b84fa1c7aba01a_6', 'fe_key_996e8c0e4359ad9f02b84fa1c7aba01a_6', 'fe_val_996e8c0e4359ad9f02b84fa1c7aba01a_6', 'fe_offset_996e8c0e4359ad9f02b84fa1c7aba01a_6', 'fe_max_996e8c0e4359ad9f02b84fa1c7aba01a_6', 'fe_reverse_996e8c0e4359ad9f02b84fa1c7aba01a_6', 'fe_first_val_996e8c0e4359ad9f02b84fa1c7aba01a_6', 'fe_last_val_996e8c0e4359ad9f02b84fa1c7aba01a_6' );
unset( $fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_6 );
unset( $fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_6 );
$fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_6 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'zones', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['zones'] : null;
$fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_61 = compiledFetchAttribute( $fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_6, 1 );
unset( $fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_6 );
$fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_6 = $fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_61;
$fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_61 = compiledFetchAttribute( $fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_6, 'blocks' );
unset( $fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_6 );
$fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_6 = $fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_61;
if (! isset( $fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_6 ) ) $fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_6 = NULL;
while ( is_object( $fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_6 ) and method_exists( $fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_6, 'templateValue' ) )
    $fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_6 = $fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_6->templateValue();

$fe_array_keys_996e8c0e4359ad9f02b84fa1c7aba01a_6 = is_array( $fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_6 ) ? array_keys( $fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_6 ) : array();
$fe_n_items_996e8c0e4359ad9f02b84fa1c7aba01a_6 = count( $fe_array_keys_996e8c0e4359ad9f02b84fa1c7aba01a_6 );
$fe_n_items_processed_996e8c0e4359ad9f02b84fa1c7aba01a_6 = 0;
$fe_offset_996e8c0e4359ad9f02b84fa1c7aba01a_6 = 0;
$fe_max_996e8c0e4359ad9f02b84fa1c7aba01a_6 = $fe_n_items_996e8c0e4359ad9f02b84fa1c7aba01a_6 - $fe_offset_996e8c0e4359ad9f02b84fa1c7aba01a_6;
$fe_reverse_996e8c0e4359ad9f02b84fa1c7aba01a_6 = false;
if ( $fe_offset_996e8c0e4359ad9f02b84fa1c7aba01a_6 < 0 || $fe_offset_996e8c0e4359ad9f02b84fa1c7aba01a_6 >= $fe_n_items_996e8c0e4359ad9f02b84fa1c7aba01a_6 )
{
    $fe_offset_996e8c0e4359ad9f02b84fa1c7aba01a_6 = ( $fe_offset_996e8c0e4359ad9f02b84fa1c7aba01a_6 < 0 ) ? 0 : $fe_n_items_996e8c0e4359ad9f02b84fa1c7aba01a_6;
    if ( $fe_n_items_996e8c0e4359ad9f02b84fa1c7aba01a_6 || $fe_offset_996e8c0e4359ad9f02b84fa1c7aba01a_6 < 0 )
 {
        eZDebug::writeWarning("Invalid 'offset' parameter specified: '$fe_offset_996e8c0e4359ad9f02b84fa1c7aba01a_6'. Array count: $fe_n_items_996e8c0e4359ad9f02b84fa1c7aba01a_6");   
}
}
if ( $fe_max_996e8c0e4359ad9f02b84fa1c7aba01a_6 < 0 || $fe_offset_996e8c0e4359ad9f02b84fa1c7aba01a_6 + $fe_max_996e8c0e4359ad9f02b84fa1c7aba01a_6 > $fe_n_items_996e8c0e4359ad9f02b84fa1c7aba01a_6 )
{
    if ( $fe_max_996e8c0e4359ad9f02b84fa1c7aba01a_6 < 0 )
 eZDebug::writeWarning("Invalid 'max' parameter specified: $fe_max_996e8c0e4359ad9f02b84fa1c7aba01a_6");
    $fe_max_996e8c0e4359ad9f02b84fa1c7aba01a_6 = $fe_n_items_996e8c0e4359ad9f02b84fa1c7aba01a_6 - $fe_offset_996e8c0e4359ad9f02b84fa1c7aba01a_6;
}
if ( $fe_reverse_996e8c0e4359ad9f02b84fa1c7aba01a_6 )
{
    $fe_first_val_996e8c0e4359ad9f02b84fa1c7aba01a_6 = $fe_n_items_996e8c0e4359ad9f02b84fa1c7aba01a_6 - 1 - $fe_offset_996e8c0e4359ad9f02b84fa1c7aba01a_6;
    $fe_last_val_996e8c0e4359ad9f02b84fa1c7aba01a_6  = 0;
}
else
{
    $fe_first_val_996e8c0e4359ad9f02b84fa1c7aba01a_6 = $fe_offset_996e8c0e4359ad9f02b84fa1c7aba01a_6;
    $fe_last_val_996e8c0e4359ad9f02b84fa1c7aba01a_6  = $fe_n_items_996e8c0e4359ad9f02b84fa1c7aba01a_6 - 1;
}
// foreach
for ( $fe_i_996e8c0e4359ad9f02b84fa1c7aba01a_6 = $fe_first_val_996e8c0e4359ad9f02b84fa1c7aba01a_6; $fe_n_items_processed_996e8c0e4359ad9f02b84fa1c7aba01a_6 < $fe_max_996e8c0e4359ad9f02b84fa1c7aba01a_6 && ( $fe_reverse_996e8c0e4359ad9f02b84fa1c7aba01a_6 ? $fe_i_996e8c0e4359ad9f02b84fa1c7aba01a_6 >= $fe_last_val_996e8c0e4359ad9f02b84fa1c7aba01a_6 : $fe_i_996e8c0e4359ad9f02b84fa1c7aba01a_6 <= $fe_last_val_996e8c0e4359ad9f02b84fa1c7aba01a_6 ); $fe_reverse_996e8c0e4359ad9f02b84fa1c7aba01a_6 ? $fe_i_996e8c0e4359ad9f02b84fa1c7aba01a_6-- : $fe_i_996e8c0e4359ad9f02b84fa1c7aba01a_6++ )
{
$fe_key_996e8c0e4359ad9f02b84fa1c7aba01a_6 = $fe_array_keys_996e8c0e4359ad9f02b84fa1c7aba01a_6[$fe_i_996e8c0e4359ad9f02b84fa1c7aba01a_6];
$fe_val_996e8c0e4359ad9f02b84fa1c7aba01a_6 = $fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_6[$fe_key_996e8c0e4359ad9f02b84fa1c7aba01a_6];
$vars[$rootNamespace]['block'] = $fe_val_996e8c0e4359ad9f02b84fa1c7aba01a_6;
$text .= '                    ';
$oldRestoreIncludeArray_31761dd8fea3dc312f9d4ebe8c3ef08d = isset( $restoreIncludeArray ) ? $restoreIncludeArray : array();
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
if ( file_exists( 'var/ezdemo_site/cache/template/compiled/zone_block-315ab376ffc5e09683561fa3e9a231e5.php' ) )
{
$resourceFound = true;
$namespaceStack[] = array( $rootNamespace, $currentNamespace );
$rootNamespace = $currentNamespace;
$tpl->createLocalVariablesList();
$tpl->appendTemplateFetch( 'extension/ezflow/design/standard/templates/parts/zone_block.tpl' );
include( '' . 'var/ezdemo_site/cache/template/compiled/zone_block-315ab376ffc5e09683561fa3e9a231e5.php' );
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
$restoreIncludeArray = $oldRestoreIncludeArray_31761dd8fea3dc312f9d4ebe8c3ef08d;

$text .= '                ';
$fe_n_items_processed_996e8c0e4359ad9f02b84fa1c7aba01a_6++;
} // foreach
$skipDelimiter = false;
if ( count( $fe_variable_stack_996e8c0e4359ad9f02b84fa1c7aba01a_6 ) ) extract( array_pop( $fe_variable_stack_996e8c0e4359ad9f02b84fa1c7aba01a_6 ) );

else
{

unset( $fe_array_996e8c0e4359ad9f02b84fa1c7aba01a_6 );

unset( $fe_array_keys_996e8c0e4359ad9f02b84fa1c7aba01a_6 );

unset( $fe_n_items_996e8c0e4359ad9f02b84fa1c7aba01a_6 );

unset( $fe_n_items_processed_996e8c0e4359ad9f02b84fa1c7aba01a_6 );

unset( $fe_i_996e8c0e4359ad9f02b84fa1c7aba01a_6 );

unset( $fe_key_996e8c0e4359ad9f02b84fa1c7aba01a_6 );

unset( $fe_val_996e8c0e4359ad9f02b84fa1c7aba01a_6 );

unset( $fe_offset_996e8c0e4359ad9f02b84fa1c7aba01a_6 );

unset( $fe_max_996e8c0e4359ad9f02b84fa1c7aba01a_6 );

unset( $fe_reverse_996e8c0e4359ad9f02b84fa1c7aba01a_6 );

unset( $fe_first_val_996e8c0e4359ad9f02b84fa1c7aba01a_6 );

unset( $fe_last_val_996e8c0e4359ad9f02b84fa1c7aba01a_6 );

unset( $fe_variable_stack_996e8c0e4359ad9f02b84fa1c7aba01a_6 );

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

$setArray = $oldSetArray_967ee88652768b8c241d0ed1f151f4e3;
$tpl->Level--;
?>
