<?php
// URI:       design/admin/templates/windows_extratabs.tpl
// Filename:  design/admin/templates/windows_extratabs.tpl
// Timestamp: 1383940876 (Fri Nov 8 21:01:16 CET 2013)
$oldSetArray_1def5524dd0400e27380a593a02c4faf = isset( $setArray ) ? $setArray : array();
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

// foreach begins
$skipDelimiter = true;
if ( !isset( $fe_variable_stack_e5dee8185e132a8e80d3c17b22347017_18 ) ) $fe_variable_stack_e5dee8185e132a8e80d3c17b22347017_18 = array();
$fe_variable_stack_e5dee8185e132a8e80d3c17b22347017_18[] = compact( 'fe_array_e5dee8185e132a8e80d3c17b22347017_18', 'fe_array_keys_e5dee8185e132a8e80d3c17b22347017_18', 'fe_n_items_e5dee8185e132a8e80d3c17b22347017_18', 'fe_n_items_processed_e5dee8185e132a8e80d3c17b22347017_18', 'fe_i_e5dee8185e132a8e80d3c17b22347017_18', 'fe_key_e5dee8185e132a8e80d3c17b22347017_18', 'fe_val_e5dee8185e132a8e80d3c17b22347017_18', 'fe_offset_e5dee8185e132a8e80d3c17b22347017_18', 'fe_max_e5dee8185e132a8e80d3c17b22347017_18', 'fe_reverse_e5dee8185e132a8e80d3c17b22347017_18', 'fe_first_val_e5dee8185e132a8e80d3c17b22347017_18', 'fe_last_val_e5dee8185e132a8e80d3c17b22347017_18' );
unset( $fe_array_e5dee8185e132a8e80d3c17b22347017_18 );
unset( $fe_array_e5dee8185e132a8e80d3c17b22347017_18 );
$fe_array_e5dee8185e132a8e80d3c17b22347017_18 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'additional_tabs', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['additional_tabs'] : null;
if (! isset( $fe_array_e5dee8185e132a8e80d3c17b22347017_18 ) ) $fe_array_e5dee8185e132a8e80d3c17b22347017_18 = NULL;
while ( is_object( $fe_array_e5dee8185e132a8e80d3c17b22347017_18 ) and method_exists( $fe_array_e5dee8185e132a8e80d3c17b22347017_18, 'templateValue' ) )
    $fe_array_e5dee8185e132a8e80d3c17b22347017_18 = $fe_array_e5dee8185e132a8e80d3c17b22347017_18->templateValue();

$fe_array_keys_e5dee8185e132a8e80d3c17b22347017_18 = is_array( $fe_array_e5dee8185e132a8e80d3c17b22347017_18 ) ? array_keys( $fe_array_e5dee8185e132a8e80d3c17b22347017_18 ) : array();
$fe_n_items_e5dee8185e132a8e80d3c17b22347017_18 = count( $fe_array_keys_e5dee8185e132a8e80d3c17b22347017_18 );
$fe_n_items_processed_e5dee8185e132a8e80d3c17b22347017_18 = 0;
$fe_offset_e5dee8185e132a8e80d3c17b22347017_18 = 0;
$fe_max_e5dee8185e132a8e80d3c17b22347017_18 = $fe_n_items_e5dee8185e132a8e80d3c17b22347017_18 - $fe_offset_e5dee8185e132a8e80d3c17b22347017_18;
$fe_reverse_e5dee8185e132a8e80d3c17b22347017_18 = false;
if ( $fe_offset_e5dee8185e132a8e80d3c17b22347017_18 < 0 || $fe_offset_e5dee8185e132a8e80d3c17b22347017_18 >= $fe_n_items_e5dee8185e132a8e80d3c17b22347017_18 )
{
    $fe_offset_e5dee8185e132a8e80d3c17b22347017_18 = ( $fe_offset_e5dee8185e132a8e80d3c17b22347017_18 < 0 ) ? 0 : $fe_n_items_e5dee8185e132a8e80d3c17b22347017_18;
    if ( $fe_n_items_e5dee8185e132a8e80d3c17b22347017_18 || $fe_offset_e5dee8185e132a8e80d3c17b22347017_18 < 0 )
 {
        eZDebug::writeWarning("Invalid 'offset' parameter specified: '$fe_offset_e5dee8185e132a8e80d3c17b22347017_18'. Array count: $fe_n_items_e5dee8185e132a8e80d3c17b22347017_18");   
}
}
if ( $fe_max_e5dee8185e132a8e80d3c17b22347017_18 < 0 || $fe_offset_e5dee8185e132a8e80d3c17b22347017_18 + $fe_max_e5dee8185e132a8e80d3c17b22347017_18 > $fe_n_items_e5dee8185e132a8e80d3c17b22347017_18 )
{
    if ( $fe_max_e5dee8185e132a8e80d3c17b22347017_18 < 0 )
 eZDebug::writeWarning("Invalid 'max' parameter specified: $fe_max_e5dee8185e132a8e80d3c17b22347017_18");
    $fe_max_e5dee8185e132a8e80d3c17b22347017_18 = $fe_n_items_e5dee8185e132a8e80d3c17b22347017_18 - $fe_offset_e5dee8185e132a8e80d3c17b22347017_18;
}
if ( $fe_reverse_e5dee8185e132a8e80d3c17b22347017_18 )
{
    $fe_first_val_e5dee8185e132a8e80d3c17b22347017_18 = $fe_n_items_e5dee8185e132a8e80d3c17b22347017_18 - 1 - $fe_offset_e5dee8185e132a8e80d3c17b22347017_18;
    $fe_last_val_e5dee8185e132a8e80d3c17b22347017_18  = 0;
}
else
{
    $fe_first_val_e5dee8185e132a8e80d3c17b22347017_18 = $fe_offset_e5dee8185e132a8e80d3c17b22347017_18;
    $fe_last_val_e5dee8185e132a8e80d3c17b22347017_18  = $fe_n_items_e5dee8185e132a8e80d3c17b22347017_18 - 1;
}
// foreach
for ( $fe_i_e5dee8185e132a8e80d3c17b22347017_18 = $fe_first_val_e5dee8185e132a8e80d3c17b22347017_18; $fe_n_items_processed_e5dee8185e132a8e80d3c17b22347017_18 < $fe_max_e5dee8185e132a8e80d3c17b22347017_18 && ( $fe_reverse_e5dee8185e132a8e80d3c17b22347017_18 ? $fe_i_e5dee8185e132a8e80d3c17b22347017_18 >= $fe_last_val_e5dee8185e132a8e80d3c17b22347017_18 : $fe_i_e5dee8185e132a8e80d3c17b22347017_18 <= $fe_last_val_e5dee8185e132a8e80d3c17b22347017_18 ); $fe_reverse_e5dee8185e132a8e80d3c17b22347017_18 ? $fe_i_e5dee8185e132a8e80d3c17b22347017_18-- : $fe_i_e5dee8185e132a8e80d3c17b22347017_18++ )
{
$fe_key_e5dee8185e132a8e80d3c17b22347017_18 = $fe_array_keys_e5dee8185e132a8e80d3c17b22347017_18[$fe_i_e5dee8185e132a8e80d3c17b22347017_18];
$fe_val_e5dee8185e132a8e80d3c17b22347017_18 = $fe_array_e5dee8185e132a8e80d3c17b22347017_18[$fe_key_e5dee8185e132a8e80d3c17b22347017_18];
$vars[$rootNamespace]['tab'] = $fe_val_e5dee8185e132a8e80d3c17b22347017_18;
// def $tab_template
unset( $var );
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
$varData = array( 'value' => $var );
$tpl->processOperator( 'ezini',
                       array (
  0 => 
  array (
    0 => 
    array (
      0 => 6,
      1 => 
      array (
        0 => 'concat',
        1 => 
        array (
          0 => 
          array (
            0 => 1,
            1 => 'AdditionalTab_',
            2 => false,
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            0 => 4,
            1 => 
            array (
              0 => '',
              1 => 2,
              2 => 'tab',
            ),
            2 => false,
          ),
        ),
      ),
      2 => false,
    ),
  ),
  1 => 
  array (
    0 => 
    array (
      0 => 1,
      1 => 'Template',
      2 => false,
    ),
  ),
  2 => 
  array (
    0 => 
    array (
      0 => 1,
      1 => 'admininterface.ini',
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
if ( $tpl->hasVariable( 'tab_template', $rootNamespace ) )
{
    $tpl->warning( 'def', "Variable 'tab_template' is already defined.", array (
  0 => 
  array (
    0 => 3,
    1 => 0,
    2 => 65,
  ),
  1 => 
  array (
    0 => 3,
    1 => 95,
    2 => 160,
  ),
  2 => 'design/admin/templates/windows_extratabs.tpl',
) );
    $tpl->setVariable( 'tab_template', $var, $rootNamespace );
}
else
{
    $tpl->setLocalVariable( 'tab_template', $var, $rootNamespace );
}

$text .= '
<div id="node-tab-';
unset( $var );
unset( $var );
$var = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'tab', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['tab'] : null;
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
$text .= ( is_object( $var ) ? compiledFetchText( $tpl, $rootNamespace, $currentNamespace, false, $var ) : $var );
unset( $var );

$text .= '-content" class="tab-content';
// if begins
unset( $if_cond );
unset( $if_cond1 );
unset( $if_cond1 );
$if_cond1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'node_tab_index', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['node_tab_index'] : null;
if (! isset( $if_cond1 ) ) $if_cond1 = NULL;
while ( is_object( $if_cond1 ) and method_exists( $if_cond1, 'templateValue' ) )
    $if_cond1 = $if_cond1->templateValue();
unset( $if_cond2 );
unset( $if_cond2 );
$if_cond2 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'tab', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['tab'] : null;
if (! isset( $if_cond2 ) ) $if_cond2 = NULL;
while ( is_object( $if_cond2 ) and method_exists( $if_cond2, 'templateValue' ) )
    $if_cond2 = $if_cond2->templateValue();
$if_cond = ( ( $if_cond1 ) != ( $if_cond2 ) );
unset( $if_cond1, $if_cond2 );
if (! isset( $if_cond ) ) $if_cond = NULL;
while ( is_object( $if_cond ) and method_exists( $if_cond, 'templateValue' ) )
    $if_cond = $if_cond->templateValue();

if ( $if_cond )
{
$text .= ' hide';
}
else
{
$text .= ' selected';
}
unset( $if_cond );
// if ends

$text .= '">
    ';
$textElements = array();
$tpl->processFunction( 'include', $textElements,
                       false,
                       array (
  'uri' => 
  array (
    0 => 
    array (
      0 => 6,
      1 => 
      array (
        0 => 'concat',
        1 => 
        array (
          0 => 
          array (
            0 => 1,
            1 => 'design:tabs/',
            2 => false,
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            0 => 4,
            1 => 
            array (
              0 => '',
              1 => 2,
              2 => 'tab_template',
            ),
            2 => false,
          ),
        ),
      ),
      2 => false,
    ),
  ),
),
                       array (
  0 => 
  array (
    0 => 6,
    1 => 4,
    2 => 279,
  ),
  1 => 
  array (
    0 => 6,
    1 => 55,
    2 => 330,
  ),
  2 => 'design/admin/templates/windows_extratabs.tpl',
),
                       $rootNamespace, $currentNamespace );
$text .= implode( '', $textElements );

$text .= '<div class="break"></div>
</div>
';
// undef $tab_template
$tpl->unsetLocalVariable( 'tab_template', $rootNamespace );

$fe_n_items_processed_e5dee8185e132a8e80d3c17b22347017_18++;
} // foreach
$skipDelimiter = false;
if ( count( $fe_variable_stack_e5dee8185e132a8e80d3c17b22347017_18 ) ) extract( array_pop( $fe_variable_stack_e5dee8185e132a8e80d3c17b22347017_18 ) );

else
{

unset( $fe_array_e5dee8185e132a8e80d3c17b22347017_18 );

unset( $fe_array_keys_e5dee8185e132a8e80d3c17b22347017_18 );

unset( $fe_n_items_e5dee8185e132a8e80d3c17b22347017_18 );

unset( $fe_n_items_processed_e5dee8185e132a8e80d3c17b22347017_18 );

unset( $fe_i_e5dee8185e132a8e80d3c17b22347017_18 );

unset( $fe_key_e5dee8185e132a8e80d3c17b22347017_18 );

unset( $fe_val_e5dee8185e132a8e80d3c17b22347017_18 );

unset( $fe_offset_e5dee8185e132a8e80d3c17b22347017_18 );

unset( $fe_max_e5dee8185e132a8e80d3c17b22347017_18 );

unset( $fe_reverse_e5dee8185e132a8e80d3c17b22347017_18 );

unset( $fe_first_val_e5dee8185e132a8e80d3c17b22347017_18 );

unset( $fe_last_val_e5dee8185e132a8e80d3c17b22347017_18 );

unset( $fe_variable_stack_e5dee8185e132a8e80d3c17b22347017_18 );

}

// foreach ends

$setArray = $oldSetArray_1def5524dd0400e27380a593a02c4faf;
$tpl->Level--;
?>
