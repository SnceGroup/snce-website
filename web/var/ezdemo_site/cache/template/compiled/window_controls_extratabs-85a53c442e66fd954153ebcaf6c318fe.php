<?php
// URI:       design/admin/templates/window_controls_extratabs.tpl
// Filename:  design/admin/templates/window_controls_extratabs.tpl
// Timestamp: 1383940876 (Fri Nov 8 21:01:16 CET 2013)
$oldSetArray_43c87adf4f73fffba18e77bc936e9d77 = isset( $setArray ) ? $setArray : array();
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

$text .= '    ';
// def $counter
if ( $tpl->hasVariable( 'counter', $rootNamespace ) )
{
    $tpl->warning( 'def', "Variable 'counter' is already defined.", array (
  0 => 
  array (
    0 => 1,
    1 => 4,
    2 => 5,
  ),
  1 => 
  array (
    0 => 1,
    1 => 20,
    2 => 21,
  ),
  2 => 'design/admin/templates/window_controls_extratabs.tpl',
) );
    $tpl->setVariable( 'counter', 0, $rootNamespace );
}
else
{
    $tpl->setLocalVariable( 'counter', 0, $rootNamespace );
}

$text .= '    ';
// foreach begins
$skipDelimiter = true;
if ( !isset( $fe_variable_stack_7b05c599255039299ea820b6848437fa_3 ) ) $fe_variable_stack_7b05c599255039299ea820b6848437fa_3 = array();
$fe_variable_stack_7b05c599255039299ea820b6848437fa_3[] = compact( 'fe_array_7b05c599255039299ea820b6848437fa_3', 'fe_array_keys_7b05c599255039299ea820b6848437fa_3', 'fe_n_items_7b05c599255039299ea820b6848437fa_3', 'fe_n_items_processed_7b05c599255039299ea820b6848437fa_3', 'fe_i_7b05c599255039299ea820b6848437fa_3', 'fe_key_7b05c599255039299ea820b6848437fa_3', 'fe_val_7b05c599255039299ea820b6848437fa_3', 'fe_offset_7b05c599255039299ea820b6848437fa_3', 'fe_max_7b05c599255039299ea820b6848437fa_3', 'fe_reverse_7b05c599255039299ea820b6848437fa_3', 'fe_first_val_7b05c599255039299ea820b6848437fa_3', 'fe_last_val_7b05c599255039299ea820b6848437fa_3' );
unset( $fe_array_7b05c599255039299ea820b6848437fa_3 );
unset( $fe_array_7b05c599255039299ea820b6848437fa_3 );
$fe_array_7b05c599255039299ea820b6848437fa_3 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'additional_tabs', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['additional_tabs'] : null;
if (! isset( $fe_array_7b05c599255039299ea820b6848437fa_3 ) ) $fe_array_7b05c599255039299ea820b6848437fa_3 = NULL;
while ( is_object( $fe_array_7b05c599255039299ea820b6848437fa_3 ) and method_exists( $fe_array_7b05c599255039299ea820b6848437fa_3, 'templateValue' ) )
    $fe_array_7b05c599255039299ea820b6848437fa_3 = $fe_array_7b05c599255039299ea820b6848437fa_3->templateValue();

$fe_array_keys_7b05c599255039299ea820b6848437fa_3 = is_array( $fe_array_7b05c599255039299ea820b6848437fa_3 ) ? array_keys( $fe_array_7b05c599255039299ea820b6848437fa_3 ) : array();
$fe_n_items_7b05c599255039299ea820b6848437fa_3 = count( $fe_array_keys_7b05c599255039299ea820b6848437fa_3 );
$fe_n_items_processed_7b05c599255039299ea820b6848437fa_3 = 0;
$fe_offset_7b05c599255039299ea820b6848437fa_3 = 0;
$fe_max_7b05c599255039299ea820b6848437fa_3 = $fe_n_items_7b05c599255039299ea820b6848437fa_3 - $fe_offset_7b05c599255039299ea820b6848437fa_3;
$fe_reverse_7b05c599255039299ea820b6848437fa_3 = false;
if ( $fe_offset_7b05c599255039299ea820b6848437fa_3 < 0 || $fe_offset_7b05c599255039299ea820b6848437fa_3 >= $fe_n_items_7b05c599255039299ea820b6848437fa_3 )
{
    $fe_offset_7b05c599255039299ea820b6848437fa_3 = ( $fe_offset_7b05c599255039299ea820b6848437fa_3 < 0 ) ? 0 : $fe_n_items_7b05c599255039299ea820b6848437fa_3;
    if ( $fe_n_items_7b05c599255039299ea820b6848437fa_3 || $fe_offset_7b05c599255039299ea820b6848437fa_3 < 0 )
 {
        eZDebug::writeWarning("Invalid 'offset' parameter specified: '$fe_offset_7b05c599255039299ea820b6848437fa_3'. Array count: $fe_n_items_7b05c599255039299ea820b6848437fa_3");   
}
}
if ( $fe_max_7b05c599255039299ea820b6848437fa_3 < 0 || $fe_offset_7b05c599255039299ea820b6848437fa_3 + $fe_max_7b05c599255039299ea820b6848437fa_3 > $fe_n_items_7b05c599255039299ea820b6848437fa_3 )
{
    if ( $fe_max_7b05c599255039299ea820b6848437fa_3 < 0 )
 eZDebug::writeWarning("Invalid 'max' parameter specified: $fe_max_7b05c599255039299ea820b6848437fa_3");
    $fe_max_7b05c599255039299ea820b6848437fa_3 = $fe_n_items_7b05c599255039299ea820b6848437fa_3 - $fe_offset_7b05c599255039299ea820b6848437fa_3;
}
if ( $fe_reverse_7b05c599255039299ea820b6848437fa_3 )
{
    $fe_first_val_7b05c599255039299ea820b6848437fa_3 = $fe_n_items_7b05c599255039299ea820b6848437fa_3 - 1 - $fe_offset_7b05c599255039299ea820b6848437fa_3;
    $fe_last_val_7b05c599255039299ea820b6848437fa_3  = 0;
}
else
{
    $fe_first_val_7b05c599255039299ea820b6848437fa_3 = $fe_offset_7b05c599255039299ea820b6848437fa_3;
    $fe_last_val_7b05c599255039299ea820b6848437fa_3  = $fe_n_items_7b05c599255039299ea820b6848437fa_3 - 1;
}
// foreach
for ( $fe_i_7b05c599255039299ea820b6848437fa_3 = $fe_first_val_7b05c599255039299ea820b6848437fa_3; $fe_n_items_processed_7b05c599255039299ea820b6848437fa_3 < $fe_max_7b05c599255039299ea820b6848437fa_3 && ( $fe_reverse_7b05c599255039299ea820b6848437fa_3 ? $fe_i_7b05c599255039299ea820b6848437fa_3 >= $fe_last_val_7b05c599255039299ea820b6848437fa_3 : $fe_i_7b05c599255039299ea820b6848437fa_3 <= $fe_last_val_7b05c599255039299ea820b6848437fa_3 ); $fe_reverse_7b05c599255039299ea820b6848437fa_3 ? $fe_i_7b05c599255039299ea820b6848437fa_3-- : $fe_i_7b05c599255039299ea820b6848437fa_3++ )
{
$fe_key_7b05c599255039299ea820b6848437fa_3 = $fe_array_keys_7b05c599255039299ea820b6848437fa_3[$fe_i_7b05c599255039299ea820b6848437fa_3];
$fe_val_7b05c599255039299ea820b6848437fa_3 = $fe_array_7b05c599255039299ea820b6848437fa_3[$fe_key_7b05c599255039299ea820b6848437fa_3];
$vars[$rootNamespace]['tab'] = $fe_val_7b05c599255039299ea820b6848437fa_3;
$text .= '    ';
// def $tab_title
unset( $var );
unset( $var1 );
if (! isset( $var1 ) ) $var1 = NULL;
while ( is_object( $var1 ) and method_exists( $var1, 'templateValue' ) )
    $var1 = $var1->templateValue();
$var1Data = array( 'value' => $var1 );
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
      1 => 'Title',
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
                       $rootNamespace, $currentNamespace, $var1Data, false, false );
$var1 = $var1Data['value'];
unset( $var1Data );
if (! isset( $var1 ) ) $var1 = NULL;
while ( is_object( $var1 ) and method_exists( $var1, 'templateValue' ) )
    $var1 = $var1->templateValue();
$var = htmlspecialchars( $var1 );
unset( $var1 );
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
if ( $tpl->hasVariable( 'tab_title', $rootNamespace ) )
{
    $tpl->warning( 'def', "Variable 'tab_title' is already defined.", array (
  0 => 
  array (
    0 => 3,
    1 => 4,
    2 => 67,
  ),
  1 => 
  array (
    0 => 6,
    1 => 24,
    2 => 416,
  ),
  2 => 'design/admin/templates/window_controls_extratabs.tpl',
) );
    $tpl->setVariable( 'tab_title', $var, $rootNamespace );
}
else
{
    $tpl->setLocalVariable( 'tab_title', $var, $rootNamespace );
}

// def $tab_description
unset( $var );
unset( $var1 );
if (! isset( $var1 ) ) $var1 = NULL;
while ( is_object( $var1 ) and method_exists( $var1, 'templateValue' ) )
    $var1 = $var1->templateValue();
$var1Data = array( 'value' => $var1 );
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
      1 => 'Description',
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
                       $rootNamespace, $currentNamespace, $var1Data, false, false );
$var1 = $var1Data['value'];
unset( $var1Data );
if (! isset( $var1 ) ) $var1 = NULL;
while ( is_object( $var1 ) and method_exists( $var1, 'templateValue' ) )
    $var1 = $var1->templateValue();
$var = htmlspecialchars( $var1 );
unset( $var1 );
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
if ( $tpl->hasVariable( 'tab_description', $rootNamespace ) )
{
    $tpl->warning( 'def', "Variable 'tab_description' is already defined.", array (
  0 => 
  array (
    0 => 3,
    1 => 4,
    2 => 67,
  ),
  1 => 
  array (
    0 => 6,
    1 => 24,
    2 => 416,
  ),
  2 => 'design/admin/templates/window_controls_extratabs.tpl',
) );
    $tpl->setVariable( 'tab_description', $var, $rootNamespace );
}
else
{
    $tpl->setLocalVariable( 'tab_description', $var, $rootNamespace );
}

// def $tab_header_template
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
      1 => 'HeaderTemplate',
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
if ( $tpl->hasVariable( 'tab_header_template', $rootNamespace ) )
{
    $tpl->warning( 'def', "Variable 'tab_header_template' is already defined.", array (
  0 => 
  array (
    0 => 3,
    1 => 4,
    2 => 67,
  ),
  1 => 
  array (
    0 => 6,
    1 => 24,
    2 => 416,
  ),
  2 => 'design/admin/templates/window_controls_extratabs.tpl',
) );
    $tpl->setVariable( 'tab_header_template', $var, $rootNamespace );
}
else
{
    $tpl->setLocalVariable( 'tab_header_template', $var, $rootNamespace );
}

// def $last
if ( $tpl->hasVariable( 'last', $rootNamespace ) )
{
    $tpl->warning( 'def', "Variable 'last' is already defined.", array (
  0 => 
  array (
    0 => 3,
    1 => 4,
    2 => 67,
  ),
  1 => 
  array (
    0 => 6,
    1 => 24,
    2 => 416,
  ),
  2 => 'design/admin/templates/window_controls_extratabs.tpl',
) );
    $tpl->setVariable( 'last', false, $rootNamespace );
}
else
{
    $tpl->setLocalVariable( 'last', false, $rootNamespace );
}

$text .= '    ';
unset( $var );
unset( $var1 );
unset( $var1 );
$var1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'counter', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['counter'] : null;
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
if ( array_key_exists( $currentNamespace, $vars ) && array_key_exists( 'counter', $vars[$currentNamespace] ) )
{
    $vars[$currentNamespace]['counter'] = $var;
    unset( $var );
}
$text .= '
    ';
// if begins
unset( $if_cond );
unset( $if_cond1 );
unset( $if_cond1 );
$if_cond1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'counter', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['counter'] : null;
if (! isset( $if_cond1 ) ) $if_cond1 = NULL;
while ( is_object( $if_cond1 ) and method_exists( $if_cond1, 'templateValue' ) )
    $if_cond1 = $if_cond1->templateValue();
unset( $if_cond2 );
unset( $if_cond2 );
$if_cond2 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'additional_tabs_count', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['additional_tabs_count'] : null;
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
$text .= '        ';
if ( array_key_exists( $currentNamespace, $vars ) && array_key_exists( 'last', $vars[$currentNamespace] ) )
{
    $vars[$currentNamespace]['last'] = true;
}
$text .= '    ';
}
unset( $if_cond );
// if ends

$text .= '
    ';
// if begins
unset( $if_cond );
unset( $if_cond1 );
unset( $if_cond1 );
$if_cond1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'tab_header_template', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['tab_header_template'] : null;
if (! isset( $if_cond1 ) ) $if_cond1 = NULL;
while ( is_object( $if_cond1 ) and method_exists( $if_cond1, 'templateValue' ) )
    $if_cond1 = $if_cond1->templateValue();
$if_cond = ( ( $if_cond1 ) == ( '' ) );
unset( $if_cond1 );
if (! isset( $if_cond ) ) $if_cond = NULL;
while ( is_object( $if_cond ) and method_exists( $if_cond, 'templateValue' ) )
    $if_cond = $if_cond->templateValue();

if ( $if_cond )
{
$text .= '    <li id="node-tab-';
unset( $var );
unset( $var );
$var = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'tab', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['tab'] : null;
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
$text .= ( is_object( $var ) ? compiledFetchText( $tpl, $rootNamespace, $currentNamespace, false, $var ) : $var );
unset( $var );

$text .= '" class="';
// if begins
unset( $if_cond );
unset( $if_cond );
$if_cond = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'last', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['last'] : null;
if (! isset( $if_cond ) ) $if_cond = NULL;
while ( is_object( $if_cond ) and method_exists( $if_cond, 'templateValue' ) )
    $if_cond = $if_cond->templateValue();

if ( $if_cond )
{
$text .= 'last';
}
else
{
$text .= 'middle';
}
unset( $if_cond );
// if ends

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
$if_cond = ( ( $if_cond1 ) == ( $if_cond2 ) );
unset( $if_cond1, $if_cond2 );
if (! isset( $if_cond ) ) $if_cond = NULL;
while ( is_object( $if_cond ) and method_exists( $if_cond, 'templateValue' ) )
    $if_cond = $if_cond->templateValue();

if ( $if_cond )
{
$text .= ' selected';
}
unset( $if_cond );
// if ends

$text .= '">
        ';
// if begins
unset( $if_cond );
unset( $if_cond );
$if_cond = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'tabs_disabled', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['tabs_disabled'] : null;
if (! isset( $if_cond ) ) $if_cond = NULL;
while ( is_object( $if_cond ) and method_exists( $if_cond, 'templateValue' ) )
    $if_cond = $if_cond->templateValue();

if ( $if_cond )
{
$text .= '            <span class="disabled" title="Il tasto è disabilitato, abilitalo con il toggler a sinistra di questi tasti.">';
unset( $var );
unset( $var );
$var = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'tab_title', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['tab_title'] : null;
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
$text .= '            <a href=';
unset( $var );
unset( $var1 );
unset( $var2 );
unset( $var2 );
$var2 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'node_url_alias', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['node_url_alias'] : null;
if (! isset( $var2 ) ) $var2 = NULL;
while ( is_object( $var2 ) and method_exists( $var2, 'templateValue' ) )
    $var2 = $var2->templateValue();
while ( is_object( $var2 ) and method_exists( $var2, 'templateValue' ) )
    $var2 = $var2->templateValue();
unset( $var4 );
unset( $var4 );
$var4 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'tab', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['tab'] : null;
if (! isset( $var4 ) ) $var4 = NULL;
while ( is_object( $var4 ) and method_exists( $var4, 'templateValue' ) )
    $var4 = $var4->templateValue();
while ( is_object( $var4 ) and method_exists( $var4, 'templateValue' ) )
    $var4 = $var4->templateValue();
$var1 = ( $var2 . '/(tab)/' . $var4 );
unset( $var2, $var4 );
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

$text .= ' title="';
unset( $var );
unset( $var );
$var = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'tab_description', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['tab_description'] : null;
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
$text .= ( is_object( $var ) ? compiledFetchText( $tpl, $rootNamespace, $currentNamespace, false, $var ) : $var );
unset( $var );

$text .= '">';
unset( $var );
unset( $var );
$var = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'tab_title', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['tab_title'] : null;
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
$text .= ( is_object( $var ) ? compiledFetchText( $tpl, $rootNamespace, $currentNamespace, false, $var ) : $var );
unset( $var );

$text .= '</a>
        ';
}
unset( $if_cond );
// if ends

$text .= '    </li>
    ';
}
else
{
$text .= '        ';
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
              2 => 'tab_header_template',
            ),
            2 => false,
          ),
        ),
      ),
      2 => false,
    ),
  ),
  'last' => 
  array (
    0 => 
    array (
      0 => 4,
      1 => 
      array (
        0 => '',
        1 => 2,
        2 => 'last',
      ),
      2 => false,
    ),
  ),
),
                       array (
  0 => 
  array (
    0 => 22,
    1 => 8,
    2 => 1069,
  ),
  1 => 
  array (
    0 => 22,
    1 => 77,
    2 => 1138,
  ),
  2 => 'design/admin/templates/window_controls_extratabs.tpl',
),
                       $rootNamespace, $currentNamespace );
$text .= implode( '', $textElements );

$text .= '    ';
}
unset( $if_cond );
// if ends

$text .= '
    ';
// undef $tab_title
$tpl->unsetLocalVariable( 'tab_title', $rootNamespace );

// undef $tab_description
$tpl->unsetLocalVariable( 'tab_description', $rootNamespace );

// undef $tab_header_template
$tpl->unsetLocalVariable( 'tab_header_template', $rootNamespace );

// undef $last
$tpl->unsetLocalVariable( 'last', $rootNamespace );

$text .= '    ';
$fe_n_items_processed_7b05c599255039299ea820b6848437fa_3++;
} // foreach
$skipDelimiter = false;
if ( count( $fe_variable_stack_7b05c599255039299ea820b6848437fa_3 ) ) extract( array_pop( $fe_variable_stack_7b05c599255039299ea820b6848437fa_3 ) );

else
{

unset( $fe_array_7b05c599255039299ea820b6848437fa_3 );

unset( $fe_array_keys_7b05c599255039299ea820b6848437fa_3 );

unset( $fe_n_items_7b05c599255039299ea820b6848437fa_3 );

unset( $fe_n_items_processed_7b05c599255039299ea820b6848437fa_3 );

unset( $fe_i_7b05c599255039299ea820b6848437fa_3 );

unset( $fe_key_7b05c599255039299ea820b6848437fa_3 );

unset( $fe_val_7b05c599255039299ea820b6848437fa_3 );

unset( $fe_offset_7b05c599255039299ea820b6848437fa_3 );

unset( $fe_max_7b05c599255039299ea820b6848437fa_3 );

unset( $fe_reverse_7b05c599255039299ea820b6848437fa_3 );

unset( $fe_first_val_7b05c599255039299ea820b6848437fa_3 );

unset( $fe_last_val_7b05c599255039299ea820b6848437fa_3 );

unset( $fe_variable_stack_7b05c599255039299ea820b6848437fa_3 );

}

// foreach ends
$text .= '    ';
// undef $counter
$tpl->unsetLocalVariable( 'counter', $rootNamespace );


$setArray = $oldSetArray_43c87adf4f73fffba18e77bc936e9d77;
$tpl->Level--;
?>
