<?php
// URI:       design/admin/templates/relations.tpl
// Filename:  design/admin/templates/relations.tpl
// Timestamp: 1383940876 (Fri Nov 8 21:01:16 CET 2013)
$oldSetArray_5a189767853adb572117405a936f7d98 = isset( $setArray ) ? $setArray : array();
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

// def $page_limit
unset( $var );
unset( $var1 );
unset( $var2 );
$var2 = eZPreferences::value( "admin_list_limit" );
if (! isset( $var2 ) ) $var2 = NULL;
while ( is_object( $var2 ) and method_exists( $var2, 'templateValue' ) )
    $var2 = $var2->templateValue();
$var1 = min( $var2,  3);
unset( $var2 );
if (! isset( $var1 ) ) $var1 = NULL;
while ( is_object( $var1 ) and method_exists( $var1, 'templateValue' ) )
    $var1 = $var1->templateValue();
if ( $var1 < 0 and
     $var1 >= 4 )
{
    $tpl->error( "choose", "Index " . $var1 . " out of range" );
     $var = false;
}
else switch ( $var1 )
{
    case 0: $var = 10; break;
    case 1: $var = 10; break;
    case 2: $var = 25; break;
    case 3: $var = 50; break;
}
unset( $var1 );
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
if ( $tpl->hasVariable( 'page_limit', $rootNamespace ) )
{
    $tpl->warning( 'def', "Variable 'page_limit' is already defined.", array (
  0 => 
  array (
    0 => 2,
    1 => 0,
    2 => 26,
  ),
  1 => 
  array (
    0 => 3,
    1 => 54,
    2 => 168,
  ),
  2 => 'design/admin/templates/relations.tpl',
) );
    $tpl->setVariable( 'page_limit', $var, $rootNamespace );
}
else
{
    $tpl->setLocalVariable( 'page_limit', $var, $rootNamespace );
}

// def $offset
unset( $var );
unset( $var1 );
unset( $var1 );
$var1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( "view_parameters", $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]["view_parameters"] : null;
$var2 = compiledFetchAttribute( $var1, "offset" );
unset( $var1 );
$var1 = $var2;
if (! isset( $var1 ) ) $var1 = NULL;
while ( is_object( $var1 ) and method_exists( $var1, 'templateValue' ) )
    $var1 = $var1->templateValue();
while ( is_object( $var1 ) and method_exists( $var1, 'templateValue' ) )
    $var1 = $var1->templateValue();

if ( isset( $var1 ) )
{
    $var = $var1;
}
else
{
    $var = 0;
}
unset( $var1 );
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
if ( $tpl->hasVariable( 'offset', $rootNamespace ) )
{
    $tpl->warning( 'def', "Variable 'offset' is already defined.", array (
  0 => 
  array (
    0 => 2,
    1 => 0,
    2 => 26,
  ),
  1 => 
  array (
    0 => 3,
    1 => 54,
    2 => 168,
  ),
  2 => 'design/admin/templates/relations.tpl',
) );
    $tpl->setVariable( 'offset', $var, $rootNamespace );
}
else
{
    $tpl->setLocalVariable( 'offset', $var, $rootNamespace );
}

// def $relation_type_names
if ( $tpl->hasVariable( 'relation_type_names', $rootNamespace ) )
{
    $tpl->warning( 'def', "Variable 'relation_type_names' is already defined.", array (
  0 => 
  array (
    0 => 5,
    1 => 0,
    2 => 199,
  ),
  1 => 
  array (
    0 => 8,
    1 => 96,
    2 => 574,
  ),
  2 => 'design/admin/templates/relations.tpl',
) );
    $tpl->setVariable( 'relation_type_names', array (
  'common' => 'Comune',
  'xml_embed' => 'Incluso',
  'xml_link' => 'Collegato',
  'attribute' => 'Attributo',
), $rootNamespace );
}
else
{
    $tpl->setLocalVariable( 'relation_type_names', array (
  'common' => 'Comune',
  'xml_embed' => 'Incluso',
  'xml_link' => 'Collegato',
  'attribute' => 'Attributo',
), $rootNamespace );
}

// def $relation_name_delimiter
if ( $tpl->hasVariable( 'relation_name_delimiter', $rootNamespace ) )
{
    $tpl->warning( 'def', "Variable 'relation_name_delimiter' is already defined.", array (
  0 => 
  array (
    0 => 9,
    1 => 0,
    2 => 577,
  ),
  1 => 
  array (
    0 => 9,
    1 => 35,
    2 => 612,
  ),
  2 => 'design/admin/templates/relations.tpl',
) );
    $tpl->setVariable( 'relation_name_delimiter', ', ', $rootNamespace );
}
else
{
    $tpl->setLocalVariable( 'relation_name_delimiter', ', ', $rootNamespace );
}

$text .= '
<table class="list" cellspacing="0" summary="Elenco degli oggetti correlati per l\'oggetto attuale.">
<tr>
    <th>';
unset( $var );
unset( $var2 );
unset( $var3 );
unset( $var3 );
$var3 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'related_objects_count', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['related_objects_count'] : null;
if (! isset( $var3 ) ) $var3 = NULL;
while ( is_object( $var3 ) and method_exists( $var3, 'templateValue' ) )
    $var3 = $var3->templateValue();
$var2 = array( '%related_objects_count' => $var3 );unset( $var3 );
if (! isset( $var2 ) ) $var2 = NULL;
while ( is_object( $var2 ) and method_exists( $var2, 'templateValue' ) )
    $var2 = $var2->templateValue();
$var3 = array();
foreach ( $var2 as $var4 => $var5 )
{
  if ( is_int( $var4 ) )
    $var3['%' . ( ($var4%9) + 1 )] = $var5;
  else
    $var3[$var4] = $var5;
}
$var = strtr( 'Oggetti correlati (%related_objects_count)', $var3 );
unset( $var2, $var3, $var4, $var5 );
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
$text .= $var;
unset( $var );

$text .= '</th>
    ';
// if begins
unset( $if_cond );
unset( $if_cond );
$if_cond = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'related_objects_count', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['related_objects_count'] : null;
if (! isset( $if_cond ) ) $if_cond = NULL;
while ( is_object( $if_cond ) and method_exists( $if_cond, 'templateValue' ) )
    $if_cond = $if_cond->templateValue();

if ( $if_cond )
{
$text .= '    <th>Classe</th>
    <th>Tipo di relazione</th>
    ';
}
unset( $if_cond );
// if ends

$text .= '</tr>';
// if begins
unset( $if_cond );
unset( $if_cond );
$if_cond = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'related_objects_count', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['related_objects_count'] : null;
if (! isset( $if_cond ) ) $if_cond = NULL;
while ( is_object( $if_cond ) and method_exists( $if_cond, 'templateValue' ) )
    $if_cond = $if_cond->templateValue();

if ( $if_cond )
{
$text .= '    ';
// def $related_objects_grouped
unset( $var );
unset( $var1 );
unset( $var1 );
$var1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'node', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['node'] : null;
$var2 = compiledFetchAttribute( $var1, 'object' );
unset( $var1 );
$var1 = $var2;
$var2 = compiledFetchAttribute( $var1, 'id' );
unset( $var1 );
$var1 = $var2;
if (! isset( $var1 ) ) $var1 = NULL;
while ( is_object( $var1 ) and method_exists( $var1, 'templateValue' ) )
    $var1 = $var1->templateValue();
while ( is_object( $var1 ) and method_exists( $var1, 'templateValue' ) )
    $var1 = $var1->templateValue();
unset( $var2 );
unset( $var2 );
$var2 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'page_limit', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['page_limit'] : null;
if (! isset( $var2 ) ) $var2 = NULL;
while ( is_object( $var2 ) and method_exists( $var2, 'templateValue' ) )
    $var2 = $var2->templateValue();
while ( is_object( $var2 ) and method_exists( $var2, 'templateValue' ) )
    $var2 = $var2->templateValue();
unset( $var3 );
unset( $var3 );
$var3 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'offset', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['offset'] : null;
if (! isset( $var3 ) ) $var3 = NULL;
while ( is_object( $var3 ) and method_exists( $var3, 'templateValue' ) )
    $var3 = $var3->templateValue();
while ( is_object( $var3 ) and method_exists( $var3, 'templateValue' ) )
    $var3 = $var3->templateValue();
$var = call_user_func_array( array( new eZContentFunctionCollection(), 'fetchRelatedObjects' ),
  array(     'object_id' => $var1,
    'attribute_identifier' => "0",
    'all_relations' => true,
    'group_by_attribute' => true,
    'sort_by' => array( array( "class_identifier",
              true ),
       array( "name",
              true ) ),
    'limit' => $var2,
    'offset' => $var3,
    'as_object' => true,
    'load_data_map' => false,
    'ignore_visibility' => null,
    'related_class_identifiers' => null ) );
$var = isset( $var['result'] ) ? $var['result'] : null;
unset( $var1, $var2, $var3 );
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
if ( $tpl->hasVariable( 'related_objects_grouped', $rootNamespace ) )
{
    $tpl->warning( 'def', "Variable 'related_objects_grouped' is already defined.", array (
  0 => 
  array (
    0 => 20,
    1 => 4,
    2 => 1116,
  ),
  1 => 
  array (
    0 => 20,
    1 => 288,
    2 => 1400,
  ),
  2 => 'design/admin/templates/relations.tpl',
) );
    $tpl->setVariable( 'related_objects_grouped', $var, $rootNamespace );
}
else
{
    $tpl->setLocalVariable( 'related_objects_grouped', $var, $rootNamespace );
}

$text .= '    ';
// def $related_objects_id_typed
unset( $var );
unset( $var1 );
unset( $var1 );
$var1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'node', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['node'] : null;
$var2 = compiledFetchAttribute( $var1, 'object' );
unset( $var1 );
$var1 = $var2;
$var2 = compiledFetchAttribute( $var1, 'id' );
unset( $var1 );
$var1 = $var2;
if (! isset( $var1 ) ) $var1 = NULL;
while ( is_object( $var1 ) and method_exists( $var1, 'templateValue' ) )
    $var1 = $var1->templateValue();
while ( is_object( $var1 ) and method_exists( $var1, 'templateValue' ) )
    $var1 = $var1->templateValue();
$var = call_user_func_array( array( new eZContentFunctionCollection(), 'fetchRelatedObjectsID' ),
  array(     'object_id' => $var1,
    'attribute_identifier' => "0",
    'all_relations' => false ) );
$var = isset( $var['result'] ) ? $var['result'] : null;
unset( $var1 );
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
if ( $tpl->hasVariable( 'related_objects_id_typed', $rootNamespace ) )
{
    $tpl->warning( 'def', "Variable 'related_objects_id_typed' is already defined.", array (
  0 => 
  array (
    0 => 21,
    1 => 4,
    2 => 1407,
  ),
  1 => 
  array (
    0 => 21,
    1 => 115,
    2 => 1518,
  ),
  2 => 'design/admin/templates/relations.tpl',
) );
    $tpl->setVariable( 'related_objects_id_typed', $var, $rootNamespace );
}
else
{
    $tpl->setLocalVariable( 'related_objects_id_typed', $var, $rootNamespace );
}

$text .= '
    ';
// def $tr_class
if ( $tpl->hasVariable( 'tr_class', $rootNamespace ) )
{
    $tpl->warning( 'def', "Variable 'tr_class' is already defined.", array (
  0 => 
  array (
    0 => 23,
    1 => 4,
    2 => 1526,
  ),
  1 => 
  array (
    0 => 23,
    1 => 27,
    2 => 1549,
  ),
  2 => 'design/admin/templates/relations.tpl',
) );
    $tpl->setVariable( 'tr_class', 'bglight', $rootNamespace );
}
else
{
    $tpl->setLocalVariable( 'tr_class', 'bglight', $rootNamespace );
}

$text .= '    ';
// def $attr
if ( $tpl->hasVariable( 'attr', $rootNamespace ) )
{
    $tpl->warning( 'def', "Variable 'attr' is already defined.", array (
  0 => 
  array (
    0 => 24,
    1 => 4,
    2 => 1556,
  ),
  1 => 
  array (
    0 => 24,
    1 => 17,
    2 => 1569,
  ),
  2 => 'design/admin/templates/relations.tpl',
) );
    $tpl->setVariable( 'attr', 0, $rootNamespace );
}
else
{
    $tpl->setLocalVariable( 'attr', 0, $rootNamespace );
}

$text .= '    ';
// foreach begins
$skipDelimiter = true;
if ( !isset( $fe_variable_stack_f7d54e3bf684e011bf56b2b03b8f70fb_13 ) ) $fe_variable_stack_f7d54e3bf684e011bf56b2b03b8f70fb_13 = array();
$fe_variable_stack_f7d54e3bf684e011bf56b2b03b8f70fb_13[] = compact( 'fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_13', 'fe_array_keys_f7d54e3bf684e011bf56b2b03b8f70fb_13', 'fe_n_items_f7d54e3bf684e011bf56b2b03b8f70fb_13', 'fe_n_items_processed_f7d54e3bf684e011bf56b2b03b8f70fb_13', 'fe_i_f7d54e3bf684e011bf56b2b03b8f70fb_13', 'fe_key_f7d54e3bf684e011bf56b2b03b8f70fb_13', 'fe_val_f7d54e3bf684e011bf56b2b03b8f70fb_13', 'fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_13', 'fe_max_f7d54e3bf684e011bf56b2b03b8f70fb_13', 'fe_reverse_f7d54e3bf684e011bf56b2b03b8f70fb_13', 'fe_first_val_f7d54e3bf684e011bf56b2b03b8f70fb_13', 'fe_last_val_f7d54e3bf684e011bf56b2b03b8f70fb_13' );
unset( $fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_13 );
unset( $fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_13 );
$fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_13 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'related_objects_grouped', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['related_objects_grouped'] : null;
if (! isset( $fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_13 ) ) $fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_13 = NULL;
while ( is_object( $fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_13 ) and method_exists( $fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_13, 'templateValue' ) )
    $fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_13 = $fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_13->templateValue();

$fe_array_keys_f7d54e3bf684e011bf56b2b03b8f70fb_13 = is_array( $fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_13 ) ? array_keys( $fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_13 ) : array();
$fe_n_items_f7d54e3bf684e011bf56b2b03b8f70fb_13 = count( $fe_array_keys_f7d54e3bf684e011bf56b2b03b8f70fb_13 );
$fe_n_items_processed_f7d54e3bf684e011bf56b2b03b8f70fb_13 = 0;
$fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_13 = 0;
$fe_max_f7d54e3bf684e011bf56b2b03b8f70fb_13 = $fe_n_items_f7d54e3bf684e011bf56b2b03b8f70fb_13 - $fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_13;
$fe_reverse_f7d54e3bf684e011bf56b2b03b8f70fb_13 = false;
if ( $fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_13 < 0 || $fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_13 >= $fe_n_items_f7d54e3bf684e011bf56b2b03b8f70fb_13 )
{
    $fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_13 = ( $fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_13 < 0 ) ? 0 : $fe_n_items_f7d54e3bf684e011bf56b2b03b8f70fb_13;
    if ( $fe_n_items_f7d54e3bf684e011bf56b2b03b8f70fb_13 || $fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_13 < 0 )
 {
        eZDebug::writeWarning("Invalid 'offset' parameter specified: '$fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_13'. Array count: $fe_n_items_f7d54e3bf684e011bf56b2b03b8f70fb_13");   
}
}
if ( $fe_max_f7d54e3bf684e011bf56b2b03b8f70fb_13 < 0 || $fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_13 + $fe_max_f7d54e3bf684e011bf56b2b03b8f70fb_13 > $fe_n_items_f7d54e3bf684e011bf56b2b03b8f70fb_13 )
{
    if ( $fe_max_f7d54e3bf684e011bf56b2b03b8f70fb_13 < 0 )
 eZDebug::writeWarning("Invalid 'max' parameter specified: $fe_max_f7d54e3bf684e011bf56b2b03b8f70fb_13");
    $fe_max_f7d54e3bf684e011bf56b2b03b8f70fb_13 = $fe_n_items_f7d54e3bf684e011bf56b2b03b8f70fb_13 - $fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_13;
}
if ( $fe_reverse_f7d54e3bf684e011bf56b2b03b8f70fb_13 )
{
    $fe_first_val_f7d54e3bf684e011bf56b2b03b8f70fb_13 = $fe_n_items_f7d54e3bf684e011bf56b2b03b8f70fb_13 - 1 - $fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_13;
    $fe_last_val_f7d54e3bf684e011bf56b2b03b8f70fb_13  = 0;
}
else
{
    $fe_first_val_f7d54e3bf684e011bf56b2b03b8f70fb_13 = $fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_13;
    $fe_last_val_f7d54e3bf684e011bf56b2b03b8f70fb_13  = $fe_n_items_f7d54e3bf684e011bf56b2b03b8f70fb_13 - 1;
}
// foreach
for ( $fe_i_f7d54e3bf684e011bf56b2b03b8f70fb_13 = $fe_first_val_f7d54e3bf684e011bf56b2b03b8f70fb_13; $fe_n_items_processed_f7d54e3bf684e011bf56b2b03b8f70fb_13 < $fe_max_f7d54e3bf684e011bf56b2b03b8f70fb_13 && ( $fe_reverse_f7d54e3bf684e011bf56b2b03b8f70fb_13 ? $fe_i_f7d54e3bf684e011bf56b2b03b8f70fb_13 >= $fe_last_val_f7d54e3bf684e011bf56b2b03b8f70fb_13 : $fe_i_f7d54e3bf684e011bf56b2b03b8f70fb_13 <= $fe_last_val_f7d54e3bf684e011bf56b2b03b8f70fb_13 ); $fe_reverse_f7d54e3bf684e011bf56b2b03b8f70fb_13 ? $fe_i_f7d54e3bf684e011bf56b2b03b8f70fb_13-- : $fe_i_f7d54e3bf684e011bf56b2b03b8f70fb_13++ )
{
$fe_key_f7d54e3bf684e011bf56b2b03b8f70fb_13 = $fe_array_keys_f7d54e3bf684e011bf56b2b03b8f70fb_13[$fe_i_f7d54e3bf684e011bf56b2b03b8f70fb_13];
$fe_val_f7d54e3bf684e011bf56b2b03b8f70fb_13 = $fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_13[$fe_key_f7d54e3bf684e011bf56b2b03b8f70fb_13];
$vars[$rootNamespace]['related_objects_array'] = $fe_val_f7d54e3bf684e011bf56b2b03b8f70fb_13;
$vars[$rootNamespace]['attribute_id'] = $fe_key_f7d54e3bf684e011bf56b2b03b8f70fb_13;
$text .= '        ';
// if begins
unset( $if_cond );
unset( $if_cond1 );
unset( $if_cond1 );
$if_cond1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'attribute_id', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['attribute_id'] : null;
if (! isset( $if_cond1 ) ) $if_cond1 = NULL;
while ( is_object( $if_cond1 ) and method_exists( $if_cond1, 'templateValue' ) )
    $if_cond1 = $if_cond1->templateValue();
$if_cond = ( ( $if_cond1 ) != ( 0 ) );
unset( $if_cond1 );
if (! isset( $if_cond ) ) $if_cond = NULL;
while ( is_object( $if_cond ) and method_exists( $if_cond, 'templateValue' ) )
    $if_cond = $if_cond->templateValue();

if ( $if_cond )
{
$text .= '            ';
unset( $var );
unset( $var1 );
unset( $var1 );
$var1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'attribute_id', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['attribute_id'] : null;
if (! isset( $var1 ) ) $var1 = NULL;
while ( is_object( $var1 ) and method_exists( $var1, 'templateValue' ) )
    $var1 = $var1->templateValue();
while ( is_object( $var1 ) and method_exists( $var1, 'templateValue' ) )
    $var1 = $var1->templateValue();
$var = call_user_func_array( array( new eZContentFunctionCollection(), 'fetchClassAttribute' ),
  array(     'attribute_id' => $var1,
    'version_id' => 0 ) );
$var = isset( $var['result'] ) ? $var['result'] : null;
unset( $var1 );
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
if ( array_key_exists( $currentNamespace, $vars ) && array_key_exists( 'attr', $vars[$currentNamespace] ) )
{
    $vars[$currentNamespace]['attr'] = $var;
    unset( $var );
}
$text .= '        ';
}
unset( $if_cond );
// if ends

$text .= '        ';
// foreach begins
$skipDelimiter = true;
if ( !isset( $fe_variable_stack_f7d54e3bf684e011bf56b2b03b8f70fb_12 ) ) $fe_variable_stack_f7d54e3bf684e011bf56b2b03b8f70fb_12 = array();
$fe_variable_stack_f7d54e3bf684e011bf56b2b03b8f70fb_12[] = compact( 'fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_12', 'fe_array_keys_f7d54e3bf684e011bf56b2b03b8f70fb_12', 'fe_n_items_f7d54e3bf684e011bf56b2b03b8f70fb_12', 'fe_n_items_processed_f7d54e3bf684e011bf56b2b03b8f70fb_12', 'fe_i_f7d54e3bf684e011bf56b2b03b8f70fb_12', 'fe_key_f7d54e3bf684e011bf56b2b03b8f70fb_12', 'fe_val_f7d54e3bf684e011bf56b2b03b8f70fb_12', 'fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_12', 'fe_max_f7d54e3bf684e011bf56b2b03b8f70fb_12', 'fe_reverse_f7d54e3bf684e011bf56b2b03b8f70fb_12', 'fe_first_val_f7d54e3bf684e011bf56b2b03b8f70fb_12', 'fe_last_val_f7d54e3bf684e011bf56b2b03b8f70fb_12' );
unset( $fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_12 );
unset( $fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_12 );
$fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_12 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'related_objects_array', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['related_objects_array'] : null;
if (! isset( $fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_12 ) ) $fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_12 = NULL;
while ( is_object( $fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_12 ) and method_exists( $fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_12, 'templateValue' ) )
    $fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_12 = $fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_12->templateValue();

$fe_array_keys_f7d54e3bf684e011bf56b2b03b8f70fb_12 = is_array( $fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_12 ) ? array_keys( $fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_12 ) : array();
$fe_n_items_f7d54e3bf684e011bf56b2b03b8f70fb_12 = count( $fe_array_keys_f7d54e3bf684e011bf56b2b03b8f70fb_12 );
$fe_n_items_processed_f7d54e3bf684e011bf56b2b03b8f70fb_12 = 0;
$fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_12 = 0;
$fe_max_f7d54e3bf684e011bf56b2b03b8f70fb_12 = $fe_n_items_f7d54e3bf684e011bf56b2b03b8f70fb_12 - $fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_12;
$fe_reverse_f7d54e3bf684e011bf56b2b03b8f70fb_12 = false;
if ( $fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_12 < 0 || $fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_12 >= $fe_n_items_f7d54e3bf684e011bf56b2b03b8f70fb_12 )
{
    $fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_12 = ( $fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_12 < 0 ) ? 0 : $fe_n_items_f7d54e3bf684e011bf56b2b03b8f70fb_12;
    if ( $fe_n_items_f7d54e3bf684e011bf56b2b03b8f70fb_12 || $fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_12 < 0 )
 {
        eZDebug::writeWarning("Invalid 'offset' parameter specified: '$fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_12'. Array count: $fe_n_items_f7d54e3bf684e011bf56b2b03b8f70fb_12");   
}
}
if ( $fe_max_f7d54e3bf684e011bf56b2b03b8f70fb_12 < 0 || $fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_12 + $fe_max_f7d54e3bf684e011bf56b2b03b8f70fb_12 > $fe_n_items_f7d54e3bf684e011bf56b2b03b8f70fb_12 )
{
    if ( $fe_max_f7d54e3bf684e011bf56b2b03b8f70fb_12 < 0 )
 eZDebug::writeWarning("Invalid 'max' parameter specified: $fe_max_f7d54e3bf684e011bf56b2b03b8f70fb_12");
    $fe_max_f7d54e3bf684e011bf56b2b03b8f70fb_12 = $fe_n_items_f7d54e3bf684e011bf56b2b03b8f70fb_12 - $fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_12;
}
if ( $fe_reverse_f7d54e3bf684e011bf56b2b03b8f70fb_12 )
{
    $fe_first_val_f7d54e3bf684e011bf56b2b03b8f70fb_12 = $fe_n_items_f7d54e3bf684e011bf56b2b03b8f70fb_12 - 1 - $fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_12;
    $fe_last_val_f7d54e3bf684e011bf56b2b03b8f70fb_12  = 0;
}
else
{
    $fe_first_val_f7d54e3bf684e011bf56b2b03b8f70fb_12 = $fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_12;
    $fe_last_val_f7d54e3bf684e011bf56b2b03b8f70fb_12  = $fe_n_items_f7d54e3bf684e011bf56b2b03b8f70fb_12 - 1;
}
// foreach
for ( $fe_i_f7d54e3bf684e011bf56b2b03b8f70fb_12 = $fe_first_val_f7d54e3bf684e011bf56b2b03b8f70fb_12; $fe_n_items_processed_f7d54e3bf684e011bf56b2b03b8f70fb_12 < $fe_max_f7d54e3bf684e011bf56b2b03b8f70fb_12 && ( $fe_reverse_f7d54e3bf684e011bf56b2b03b8f70fb_12 ? $fe_i_f7d54e3bf684e011bf56b2b03b8f70fb_12 >= $fe_last_val_f7d54e3bf684e011bf56b2b03b8f70fb_12 : $fe_i_f7d54e3bf684e011bf56b2b03b8f70fb_12 <= $fe_last_val_f7d54e3bf684e011bf56b2b03b8f70fb_12 ); $fe_reverse_f7d54e3bf684e011bf56b2b03b8f70fb_12 ? $fe_i_f7d54e3bf684e011bf56b2b03b8f70fb_12-- : $fe_i_f7d54e3bf684e011bf56b2b03b8f70fb_12++ )
{
$fe_key_f7d54e3bf684e011bf56b2b03b8f70fb_12 = $fe_array_keys_f7d54e3bf684e011bf56b2b03b8f70fb_12[$fe_i_f7d54e3bf684e011bf56b2b03b8f70fb_12];
$fe_val_f7d54e3bf684e011bf56b2b03b8f70fb_12 = $fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_12[$fe_key_f7d54e3bf684e011bf56b2b03b8f70fb_12];
$vars[$rootNamespace]['object'] = $fe_val_f7d54e3bf684e011bf56b2b03b8f70fb_12;
$text .= '            <tr class="';
unset( $var );
unset( $var );
$var = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'tr_class', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['tr_class'] : null;
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
$text .= ( is_object( $var ) ? compiledFetchText( $tpl, $rootNamespace, $currentNamespace, false, $var ) : $var );
unset( $var );

$text .= '">
            ';
// if begins
unset( $if_cond );
unset( $if_cond1 );
unset( $if_cond1 );
$if_cond1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'object', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['object'] : null;
$if_cond2 = compiledFetchAttribute( $if_cond1, 'can_read' );
unset( $if_cond1 );
$if_cond1 = $if_cond2;
if (! isset( $if_cond1 ) ) $if_cond1 = NULL;
while ( is_object( $if_cond1 ) and method_exists( $if_cond1, 'templateValue' ) )
    $if_cond1 = $if_cond1->templateValue();
unset( $if_cond2 );
unset( $if_cond2 );
$if_cond2 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'object', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['object'] : null;
$if_cond3 = compiledFetchAttribute( $if_cond2, 'can_view_embed' );
unset( $if_cond2 );
$if_cond2 = $if_cond3;
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
$text .= '                <td>';
unset( $var );
unset( $var );
$var = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'object', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['object'] : null;
$var1 = compiledFetchAttribute( $var, 'content_class' );
unset( $var );
$var = $var1;
$var1 = compiledFetchAttribute( $var, 'identifier' );
unset( $var );
$var = $var1;
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
$varData = array( 'value' => $var );
$tpl->processOperator( 'class_icon',
                       array (
  0 => 
  array (
    0 => 
    array (
      0 => 3,
      1 => 'small',
      2 => false,
    ),
  ),
  1 => 
  array (
    0 => 
    array (
      0 => 4,
      1 => 
      array (
        0 => '',
        1 => 2,
        2 => 'object',
      ),
      2 => false,
    ),
    1 => 
    array (
      0 => 5,
      1 => 
      array (
        0 => 
        array (
          0 => 3,
          1 => 'content_class',
          2 => false,
        ),
      ),
      2 => false,
    ),
    2 => 
    array (
      0 => 5,
      1 => 
      array (
        0 => 
        array (
          0 => 3,
          1 => 'name',
          2 => false,
        ),
      ),
      2 => false,
    ),
    3 => 
    array (
      0 => 6,
      1 => 
      array (
        0 => 'wash',
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

$text .= '&nbsp;';
unset( $var );
unset( $var );
$var = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'object', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['object'] : null;
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
$namespace = $currentNamespace;
if ( $namespace == '' )
    $namespace = "ContentView";
else
    $namespace .= ':ContentView';
$vars[$namespace]['object'] = $var;
unset( $var );
if ( !isset( $dKeys ) )
{
    $resH = $tpl->resourceHandler( 'design' );
    $dKeys = $resH->keys();
}
if ( !isset( $dKeysStack ) )
{
    $dKeysStack = array();
}
$dKeysStack[] = $dKeys;
unset( $dKey );
$namespace = $currentNamespace;
if ( $namespace == '' )
    $namespace = "ContentView";
else
    $namespace .= ':ContentView';
unset( $dKey );
$dKey = ( array_key_exists( $namespace, $vars ) and array_key_exists( 'object', $vars[$namespace] ) ) ? $vars[$namespace]['object'] : null;
$dKey1 = compiledFetchAttribute( $dKey, 'id' );
unset( $dKey );
$dKey = $dKey1;
if (! isset( $dKey ) ) $dKey = NULL;
while ( is_object( $dKey ) and method_exists( $dKey, 'templateValue' ) )
    $dKey = $dKey->templateValue();

$dKeys["object"] = $dKey;
unset( $dKey );

unset( $dKey );
$namespace = $currentNamespace;
if ( $namespace == '' )
    $namespace = "ContentView";
else
    $namespace .= ':ContentView';
unset( $dKey );
$dKey = ( array_key_exists( $namespace, $vars ) and array_key_exists( 'object', $vars[$namespace] ) ) ? $vars[$namespace]['object'] : null;
$dKey1 = compiledFetchAttribute( $dKey, 'match_ingroup_id_list' );
unset( $dKey );
$dKey = $dKey1;
if (! isset( $dKey ) ) $dKey = NULL;
while ( is_object( $dKey ) and method_exists( $dKey, 'templateValue' ) )
    $dKey = $dKey->templateValue();

$dKeys["class_group"] = $dKey;
unset( $dKey );

unset( $dKey );
$namespace = $currentNamespace;
if ( $namespace == '' )
    $namespace = "ContentView";
else
    $namespace .= ':ContentView';
unset( $dKey );
$dKey = ( array_key_exists( $namespace, $vars ) and array_key_exists( 'object', $vars[$namespace] ) ) ? $vars[$namespace]['object'] : null;
$dKey1 = compiledFetchAttribute( $dKey, 'contentclass_id' );
unset( $dKey );
$dKey = $dKey1;
if (! isset( $dKey ) ) $dKey = NULL;
while ( is_object( $dKey ) and method_exists( $dKey, 'templateValue' ) )
    $dKey = $dKey->templateValue();

$dKeys["class"] = $dKey;
unset( $dKey );

unset( $dKey );
$namespace = $currentNamespace;
if ( $namespace == '' )
    $namespace = "ContentView";
else
    $namespace .= ':ContentView';
unset( $dKey );
$dKey = ( array_key_exists( $namespace, $vars ) and array_key_exists( 'object', $vars[$namespace] ) ) ? $vars[$namespace]['object'] : null;
$dKey1 = compiledFetchAttribute( $dKey, 'section_id' );
unset( $dKey );
$dKey = $dKey1;
if (! isset( $dKey ) ) $dKey = NULL;
while ( is_object( $dKey ) and method_exists( $dKey, 'templateValue' ) )
    $dKey = $dKey->templateValue();

$dKeys["section"] = $dKey;
unset( $dKey );

unset( $dKey );
$namespace = $currentNamespace;
if ( $namespace == '' )
    $namespace = "ContentView";
else
    $namespace .= ':ContentView';
unset( $dKey );
$dKey = ( array_key_exists( $namespace, $vars ) and array_key_exists( 'object', $vars[$namespace] ) ) ? $vars[$namespace]['object'] : null;
$dKey1 = compiledFetchAttribute( $dKey, 'class_identifier' );
unset( $dKey );
$dKey = $dKey1;
if (! isset( $dKey ) ) $dKey = NULL;
while ( is_object( $dKey ) and method_exists( $dKey, 'templateValue' ) )
    $dKey = $dKey->templateValue();

$dKeys["class_identifier"] = $dKey;
unset( $dKey );

unset( $dKey );
$namespace = $currentNamespace;
if ( $namespace == '' )
    $namespace = "ContentView";
else
    $namespace .= ':ContentView';
unset( $dKey );
$dKey = ( array_key_exists( $namespace, $vars ) and array_key_exists( 'object', $vars[$namespace] ) ) ? $vars[$namespace]['object'] : null;
$dKey1 = compiledFetchAttribute( $dKey, 'remote_id' );
unset( $dKey );
$dKey = $dKey1;
if (! isset( $dKey ) ) $dKey = NULL;
while ( is_object( $dKey ) and method_exists( $dKey, 'templateValue' ) )
    $dKey = $dKey->templateValue();

$dKeys["remote_id"] = $dKey;
unset( $dKey );

unset( $dKey );
$namespace = $currentNamespace;
if ( $namespace == '' )
    $namespace = "ContentView";
else
    $namespace .= ':ContentView';
unset( $dKey );
$dKey = ( array_key_exists( $namespace, $vars ) and array_key_exists( 'object', $vars[$namespace] ) ) ? $vars[$namespace]['object'] : null;
$dKey1 = compiledFetchAttribute( $dKey, 'state_id_array' );
unset( $dKey );
$dKey = $dKey1;
if (! isset( $dKey ) ) $dKey = NULL;
while ( is_object( $dKey ) and method_exists( $dKey, 'templateValue' ) )
    $dKey = $dKey->templateValue();

$dKeys["state"] = $dKey;
unset( $dKey );

unset( $dKey );
$namespace = $currentNamespace;
if ( $namespace == '' )
    $namespace = "ContentView";
else
    $namespace .= ':ContentView';
unset( $dKey );
$dKey = ( array_key_exists( $namespace, $vars ) and array_key_exists( 'object', $vars[$namespace] ) ) ? $vars[$namespace]['object'] : null;
$dKey1 = compiledFetchAttribute( $dKey, 'state_identifier_array' );
unset( $dKey );
$dKey = $dKey1;
if (! isset( $dKey ) ) $dKey = NULL;
while ( is_object( $dKey ) and method_exists( $dKey, 'templateValue' ) )
    $dKey = $dKey->templateValue();

$dKeys["state_identifier"] = $dKey;
unset( $dKey );

$resourceFound = false;
if ( file_exists( 'var/ezdemo_site/cache/template/compiled/text_linked-3bd896be0f5ad970c3496c0920dba105.php' ) )
{
$resourceFound = true;
$namespaceStack[] = array( $rootNamespace, $currentNamespace );
$currentNamespace = $rootNamespace = !$currentNamespace ? 'ContentView' : ( $currentNamespace . ':' . 'ContentView' );
$tpl->createLocalVariablesList();
$tpl->appendTemplateFetch( 'design/standard/templates/content/view/text_linked.tpl' );
include( '' . 'var/ezdemo_site/cache/template/compiled/text_linked-3bd896be0f5ad970c3496c0920dba105.php' );
$tpl->unsetLocalVariables();
$tpl->destroyLocalVariablesList();
list( $rootNamespace, $currentNamespace ) = array_pop( $namespaceStack );
}
else
{
    $resourceFound = true;
$resourceFound = true;
$namespaceStack[] = array( $rootNamespace, $currentNamespace );
$currentNamespace = $rootNamespace = !$currentNamespace ? 'ContentView' : ( $currentNamespace . ':' . 'ContentView' );
$textElements = array();
$extraParameters = array();
$tpl->processURI( 'design/standard/templates/content/view/text_linked.tpl', true, $extraParameters, $textElements, $rootNamespace, $currentNamespace );
$text .= implode( '', $textElements );
list( $rootNamespace, $currentNamespace ) = array_pop( $namespaceStack );
}

$dKeys = array_pop( $dKeysStack );
$namespace = $currentNamespace;
if ( $namespace == '' )
    $namespace = "ContentView";
else
    $namespace .= ':ContentView';
unset( $vars[$namespace]['object'] );
$text .= '</td>
                <td>';
unset( $var );
unset( $var1 );
unset( $var1 );
$var1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'object', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['object'] : null;
$var2 = compiledFetchAttribute( $var1, 'content_class' );
unset( $var1 );
$var1 = $var2;
$var2 = compiledFetchAttribute( $var1, 'name' );
unset( $var1 );
$var1 = $var2;
if (! isset( $var1 ) ) $var1 = NULL;
while ( is_object( $var1 ) and method_exists( $var1, 'templateValue' ) )
    $var1 = $var1->templateValue();
while ( is_object( $var1 ) and method_exists( $var1, 'templateValue' ) )
    $var1 = $var1->templateValue();
$var = htmlspecialchars( $var1 );
unset( $var1 );
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
$text .= $var;
unset( $var );

$text .= '</td>
            ';
}
else
{
$text .= '                <td colspan="2"><em>You are not allowed to view the related object</em></td>
            ';
}
unset( $if_cond );
// if ends

$text .= '            <td>
                ';
unset( $elseif_cond_f7d54e3bf684e011bf56b2b03b8f70fb_91 );
unset( $elseif_cond_f7d54e3bf684e011bf56b2b03b8f70fb_911 );
unset( $elseif_cond_f7d54e3bf684e011bf56b2b03b8f70fb_911 );
$elseif_cond_f7d54e3bf684e011bf56b2b03b8f70fb_911 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'attribute_id', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['attribute_id'] : null;
if (! isset( $elseif_cond_f7d54e3bf684e011bf56b2b03b8f70fb_911 ) ) $elseif_cond_f7d54e3bf684e011bf56b2b03b8f70fb_911 = NULL;
while ( is_object( $elseif_cond_f7d54e3bf684e011bf56b2b03b8f70fb_911 ) and method_exists( $elseif_cond_f7d54e3bf684e011bf56b2b03b8f70fb_911, 'templateValue' ) )
    $elseif_cond_f7d54e3bf684e011bf56b2b03b8f70fb_911 = $elseif_cond_f7d54e3bf684e011bf56b2b03b8f70fb_911->templateValue();
while ( is_object( $elseif_cond_f7d54e3bf684e011bf56b2b03b8f70fb_911 ) and method_exists( $elseif_cond_f7d54e3bf684e011bf56b2b03b8f70fb_911, 'templateValue' ) )
    $elseif_cond_f7d54e3bf684e011bf56b2b03b8f70fb_911 = $elseif_cond_f7d54e3bf684e011bf56b2b03b8f70fb_911->templateValue();
$elseif_cond_f7d54e3bf684e011bf56b2b03b8f70fb_91 = ( ( $elseif_cond_f7d54e3bf684e011bf56b2b03b8f70fb_911 ) == ( 0 ) );
unset( $elseif_cond_f7d54e3bf684e011bf56b2b03b8f70fb_911 );
if (! isset( $elseif_cond_f7d54e3bf684e011bf56b2b03b8f70fb_91 ) ) $elseif_cond_f7d54e3bf684e011bf56b2b03b8f70fb_91 = NULL;
while ( is_object( $elseif_cond_f7d54e3bf684e011bf56b2b03b8f70fb_91 ) and method_exists( $elseif_cond_f7d54e3bf684e011bf56b2b03b8f70fb_91, 'templateValue' ) )
    $elseif_cond_f7d54e3bf684e011bf56b2b03b8f70fb_91 = $elseif_cond_f7d54e3bf684e011bf56b2b03b8f70fb_91->templateValue();

// if begins
unset( $if_cond );
unset( $if_cond1 );
unset( $if_cond2 );
unset( $if_cond2 );
$if_cond2 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'attribute_id', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['attribute_id'] : null;
if (! isset( $if_cond2 ) ) $if_cond2 = NULL;
while ( is_object( $if_cond2 ) and method_exists( $if_cond2, 'templateValue' ) )
    $if_cond2 = $if_cond2->templateValue();
$if_cond1 = ( ( $if_cond2 ) != ( 0 ) );
unset( $if_cond2 );
if (! isset( $if_cond1 ) ) $if_cond1 = NULL;
while ( is_object( $if_cond1 ) and method_exists( $if_cond1, 'templateValue' ) )
    $if_cond1 = $if_cond1->templateValue();
unset( $if_cond2 );
unset( $if_cond3 );
unset( $if_cond3 );
$if_cond3 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'related_objects_id_typed', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['related_objects_id_typed'] : null;
$if_cond4 = compiledFetchAttribute( $if_cond3, 'attribute' );
unset( $if_cond3 );
$if_cond3 = $if_cond4;
if (! isset( $if_cond3 ) ) $if_cond3 = NULL;
while ( is_object( $if_cond3 ) and method_exists( $if_cond3, 'templateValue' ) )
    $if_cond3 = $if_cond3->templateValue();
unset( $if_cond4 );
unset( $if_cond4 );
$if_cond4 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'object', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['object'] : null;
$if_cond5 = compiledFetchAttribute( $if_cond4, 'id' );
unset( $if_cond4 );
$if_cond4 = $if_cond5;
if (! isset( $if_cond4 ) ) $if_cond4 = NULL;
while ( is_object( $if_cond4 ) and method_exists( $if_cond4, 'templateValue' ) )
    $if_cond4 = $if_cond4->templateValue();
if( is_string( $if_cond3 ) )
{
  $if_cond2 = ( strpos( $if_cond3, $if_cond4 ) !== false );
}
else if ( is_array( $if_cond3 ) )
{
  $if_cond2 = in_array( $if_cond4, $if_cond3 );
}
else
{
$if_cond2 = false;
}unset( $if_cond3, $if_cond4 );
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
$text .= '                    ';
unset( $var );
unset( $var );
$var = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'relation_type_names', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['relation_type_names'] : null;
$var1 = compiledFetchAttribute( $var, 'attribute' );
unset( $var );
$var = $var1;
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
$text .= ( is_object( $var ) ? compiledFetchText( $tpl, $rootNamespace, $currentNamespace, false, $var ) : $var );
unset( $var );

$text .= ' ( ';
unset( $var );
unset( $var );
$var = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'attr', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['attr'] : null;
$var1 = compiledFetchAttribute( $var, 'name' );
unset( $var );
$var = $var1;
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
$text .= ( is_object( $var ) ? compiledFetchText( $tpl, $rootNamespace, $currentNamespace, false, $var ) : $var );
unset( $var );

$text .= ' )
                ';
}
elseif ( $elseif_cond_f7d54e3bf684e011bf56b2b03b8f70fb_91 )
{
$text .= '                    ';
// def $relation_name_array
if ( $tpl->hasVariable( 'relation_name_array', $rootNamespace ) )
{
    $tpl->warning( 'def', "Variable 'relation_name_array' is already defined.", array (
  0 => 
  array (
    0 => 41,
    1 => 20,
    2 => 2642,
  ),
  1 => 
  array (
    0 => 41,
    1 => 54,
    2 => 2676,
  ),
  2 => 'design/admin/templates/relations.tpl',
) );
    $tpl->setVariable( 'relation_name_array', array (
), $rootNamespace );
}
else
{
    $tpl->setLocalVariable( 'relation_name_array', array (
), $rootNamespace );
}

$text .= '                    ';
// foreach begins
$skipDelimiter = true;
if ( !isset( $fe_variable_stack_f7d54e3bf684e011bf56b2b03b8f70fb_11 ) ) $fe_variable_stack_f7d54e3bf684e011bf56b2b03b8f70fb_11 = array();
$fe_variable_stack_f7d54e3bf684e011bf56b2b03b8f70fb_11[] = compact( 'fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_11', 'fe_array_keys_f7d54e3bf684e011bf56b2b03b8f70fb_11', 'fe_n_items_f7d54e3bf684e011bf56b2b03b8f70fb_11', 'fe_n_items_processed_f7d54e3bf684e011bf56b2b03b8f70fb_11', 'fe_i_f7d54e3bf684e011bf56b2b03b8f70fb_11', 'fe_key_f7d54e3bf684e011bf56b2b03b8f70fb_11', 'fe_val_f7d54e3bf684e011bf56b2b03b8f70fb_11', 'fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_11', 'fe_max_f7d54e3bf684e011bf56b2b03b8f70fb_11', 'fe_reverse_f7d54e3bf684e011bf56b2b03b8f70fb_11', 'fe_first_val_f7d54e3bf684e011bf56b2b03b8f70fb_11', 'fe_last_val_f7d54e3bf684e011bf56b2b03b8f70fb_11' );
unset( $fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_11 );
unset( $fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_11 );
$fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_11 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'related_objects_id_typed', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['related_objects_id_typed'] : null;
if (! isset( $fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_11 ) ) $fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_11 = NULL;
while ( is_object( $fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_11 ) and method_exists( $fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_11, 'templateValue' ) )
    $fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_11 = $fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_11->templateValue();

$fe_array_keys_f7d54e3bf684e011bf56b2b03b8f70fb_11 = is_array( $fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_11 ) ? array_keys( $fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_11 ) : array();
$fe_n_items_f7d54e3bf684e011bf56b2b03b8f70fb_11 = count( $fe_array_keys_f7d54e3bf684e011bf56b2b03b8f70fb_11 );
$fe_n_items_processed_f7d54e3bf684e011bf56b2b03b8f70fb_11 = 0;
$fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_11 = 0;
$fe_max_f7d54e3bf684e011bf56b2b03b8f70fb_11 = $fe_n_items_f7d54e3bf684e011bf56b2b03b8f70fb_11 - $fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_11;
$fe_reverse_f7d54e3bf684e011bf56b2b03b8f70fb_11 = false;
if ( $fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_11 < 0 || $fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_11 >= $fe_n_items_f7d54e3bf684e011bf56b2b03b8f70fb_11 )
{
    $fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_11 = ( $fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_11 < 0 ) ? 0 : $fe_n_items_f7d54e3bf684e011bf56b2b03b8f70fb_11;
    if ( $fe_n_items_f7d54e3bf684e011bf56b2b03b8f70fb_11 || $fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_11 < 0 )
 {
        eZDebug::writeWarning("Invalid 'offset' parameter specified: '$fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_11'. Array count: $fe_n_items_f7d54e3bf684e011bf56b2b03b8f70fb_11");   
}
}
if ( $fe_max_f7d54e3bf684e011bf56b2b03b8f70fb_11 < 0 || $fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_11 + $fe_max_f7d54e3bf684e011bf56b2b03b8f70fb_11 > $fe_n_items_f7d54e3bf684e011bf56b2b03b8f70fb_11 )
{
    if ( $fe_max_f7d54e3bf684e011bf56b2b03b8f70fb_11 < 0 )
 eZDebug::writeWarning("Invalid 'max' parameter specified: $fe_max_f7d54e3bf684e011bf56b2b03b8f70fb_11");
    $fe_max_f7d54e3bf684e011bf56b2b03b8f70fb_11 = $fe_n_items_f7d54e3bf684e011bf56b2b03b8f70fb_11 - $fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_11;
}
if ( $fe_reverse_f7d54e3bf684e011bf56b2b03b8f70fb_11 )
{
    $fe_first_val_f7d54e3bf684e011bf56b2b03b8f70fb_11 = $fe_n_items_f7d54e3bf684e011bf56b2b03b8f70fb_11 - 1 - $fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_11;
    $fe_last_val_f7d54e3bf684e011bf56b2b03b8f70fb_11  = 0;
}
else
{
    $fe_first_val_f7d54e3bf684e011bf56b2b03b8f70fb_11 = $fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_11;
    $fe_last_val_f7d54e3bf684e011bf56b2b03b8f70fb_11  = $fe_n_items_f7d54e3bf684e011bf56b2b03b8f70fb_11 - 1;
}
// foreach
for ( $fe_i_f7d54e3bf684e011bf56b2b03b8f70fb_11 = $fe_first_val_f7d54e3bf684e011bf56b2b03b8f70fb_11; $fe_n_items_processed_f7d54e3bf684e011bf56b2b03b8f70fb_11 < $fe_max_f7d54e3bf684e011bf56b2b03b8f70fb_11 && ( $fe_reverse_f7d54e3bf684e011bf56b2b03b8f70fb_11 ? $fe_i_f7d54e3bf684e011bf56b2b03b8f70fb_11 >= $fe_last_val_f7d54e3bf684e011bf56b2b03b8f70fb_11 : $fe_i_f7d54e3bf684e011bf56b2b03b8f70fb_11 <= $fe_last_val_f7d54e3bf684e011bf56b2b03b8f70fb_11 ); $fe_reverse_f7d54e3bf684e011bf56b2b03b8f70fb_11 ? $fe_i_f7d54e3bf684e011bf56b2b03b8f70fb_11-- : $fe_i_f7d54e3bf684e011bf56b2b03b8f70fb_11++ )
{
$fe_key_f7d54e3bf684e011bf56b2b03b8f70fb_11 = $fe_array_keys_f7d54e3bf684e011bf56b2b03b8f70fb_11[$fe_i_f7d54e3bf684e011bf56b2b03b8f70fb_11];
$fe_val_f7d54e3bf684e011bf56b2b03b8f70fb_11 = $fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_11[$fe_key_f7d54e3bf684e011bf56b2b03b8f70fb_11];
$vars[$rootNamespace]['relation_id_array'] = $fe_val_f7d54e3bf684e011bf56b2b03b8f70fb_11;
$vars[$rootNamespace]['relation_type'] = $fe_key_f7d54e3bf684e011bf56b2b03b8f70fb_11;
$text .= '                        ';
// if begins
unset( $if_cond );
unset( $if_cond1 );
unset( $if_cond1 );
$if_cond1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'relation_type', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['relation_type'] : null;
if (! isset( $if_cond1 ) ) $if_cond1 = NULL;
while ( is_object( $if_cond1 ) and method_exists( $if_cond1, 'templateValue' ) )
    $if_cond1 = $if_cond1->templateValue();
$if_cond = ( ( $if_cond1 ) != ( 'attribute' ) );
unset( $if_cond1 );
if (! isset( $if_cond ) ) $if_cond = NULL;
while ( is_object( $if_cond ) and method_exists( $if_cond, 'templateValue' ) )
    $if_cond = $if_cond->templateValue();

if ( $if_cond )
{
$text .= '                            ';
// if begins
unset( $if_cond );
unset( $if_cond1 );
unset( $if_cond1 );
$if_cond1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'relation_id_array', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['relation_id_array'] : null;
if (! isset( $if_cond1 ) ) $if_cond1 = NULL;
while ( is_object( $if_cond1 ) and method_exists( $if_cond1, 'templateValue' ) )
    $if_cond1 = $if_cond1->templateValue();
unset( $if_cond2 );
unset( $if_cond2 );
$if_cond2 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'object', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['object'] : null;
$if_cond3 = compiledFetchAttribute( $if_cond2, 'id' );
unset( $if_cond2 );
$if_cond2 = $if_cond3;
if (! isset( $if_cond2 ) ) $if_cond2 = NULL;
while ( is_object( $if_cond2 ) and method_exists( $if_cond2, 'templateValue' ) )
    $if_cond2 = $if_cond2->templateValue();
if( is_string( $if_cond1 ) )
{
  $if_cond = ( strpos( $if_cond1, $if_cond2 ) !== false );
}
else if ( is_array( $if_cond1 ) )
{
  $if_cond = in_array( $if_cond2, $if_cond1 );
}
else
{
$if_cond = false;
}unset( $if_cond1, $if_cond2 );
if (! isset( $if_cond ) ) $if_cond = NULL;
while ( is_object( $if_cond ) and method_exists( $if_cond, 'templateValue' ) )
    $if_cond = $if_cond->templateValue();

if ( $if_cond )
{
$text .= '                                ';
unset( $var );
unset( $var1 );
unset( $var1 );
$var1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'relation_type_names', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['relation_type_names'] : null;
unset( $var3 );
unset( $var3 );
$var3 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'relation_type', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['relation_type'] : null;
if (! isset( $var3 ) ) $var3 = NULL;
while ( is_object( $var3 ) and method_exists( $var3, 'templateValue' ) )
    $var3 = $var3->templateValue();
$var2 = compiledFetchAttribute( $var1, $var3 );
unset( $var1 );
$var1 = $var2;
if (! isset( $var1 ) ) $var1 = NULL;
while ( is_object( $var1 ) and method_exists( $var1, 'templateValue' ) )
    $var1 = $var1->templateValue();
while ( is_object( $var1 ) and method_exists( $var1, 'templateValue' ) )
    $var1 = $var1->templateValue();
unset( $var2 );
unset( $var2 );
$var2 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'relation_name_array', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['relation_name_array'] : null;
if (! isset( $var2 ) ) $var2 = NULL;
while ( is_object( $var2 ) and method_exists( $var2, 'templateValue' ) )
    $var2 = $var2->templateValue();
while ( is_object( $var2 ) and method_exists( $var2, 'templateValue' ) )
    $var2 = $var2->templateValue();
if ( is_string( $var2 ) )
    $var = $var2 . implode( '', array( $var1 ) );
else if( is_array( $var2 ) )
    $var = array_merge( $var2, array( $var1 ) );
unset( $var1, $var2 );
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
if ( array_key_exists( $currentNamespace, $vars ) && array_key_exists( 'relation_name_array', $vars[$currentNamespace] ) )
{
    $vars[$currentNamespace]['relation_name_array'] = $var;
    unset( $var );
}
$text .= '                            ';
}
unset( $if_cond );
// if ends

$text .= '                        ';
}
unset( $if_cond );
// if ends

$text .= '                    ';
$fe_n_items_processed_f7d54e3bf684e011bf56b2b03b8f70fb_11++;
} // foreach
$skipDelimiter = false;
if ( count( $fe_variable_stack_f7d54e3bf684e011bf56b2b03b8f70fb_11 ) ) extract( array_pop( $fe_variable_stack_f7d54e3bf684e011bf56b2b03b8f70fb_11 ) );

else
{

unset( $fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_11 );

unset( $fe_array_keys_f7d54e3bf684e011bf56b2b03b8f70fb_11 );

unset( $fe_n_items_f7d54e3bf684e011bf56b2b03b8f70fb_11 );

unset( $fe_n_items_processed_f7d54e3bf684e011bf56b2b03b8f70fb_11 );

unset( $fe_i_f7d54e3bf684e011bf56b2b03b8f70fb_11 );

unset( $fe_key_f7d54e3bf684e011bf56b2b03b8f70fb_11 );

unset( $fe_val_f7d54e3bf684e011bf56b2b03b8f70fb_11 );

unset( $fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_11 );

unset( $fe_max_f7d54e3bf684e011bf56b2b03b8f70fb_11 );

unset( $fe_reverse_f7d54e3bf684e011bf56b2b03b8f70fb_11 );

unset( $fe_first_val_f7d54e3bf684e011bf56b2b03b8f70fb_11 );

unset( $fe_last_val_f7d54e3bf684e011bf56b2b03b8f70fb_11 );

unset( $fe_variable_stack_f7d54e3bf684e011bf56b2b03b8f70fb_11 );

}

// foreach ends
$text .= '                    ';
unset( $var );
unset( $var1 );
unset( $var1 );
$var1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'relation_name_delimiter', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['relation_name_delimiter'] : null;
if (! isset( $var1 ) ) $var1 = NULL;
while ( is_object( $var1 ) and method_exists( $var1, 'templateValue' ) )
    $var1 = $var1->templateValue();
while ( is_object( $var1 ) and method_exists( $var1, 'templateValue' ) )
    $var1 = $var1->templateValue();
unset( $var2 );
unset( $var2 );
$var2 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'relation_name_array', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['relation_name_array'] : null;
if (! isset( $var2 ) ) $var2 = NULL;
while ( is_object( $var2 ) and method_exists( $var2, 'templateValue' ) )
    $var2 = $var2->templateValue();
while ( is_object( $var2 ) and method_exists( $var2, 'templateValue' ) )
    $var2 = $var2->templateValue();
$var = implode( $var1, $var2 );unset( $var1, $var2 );
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
$text .= $var;
unset( $var );

$text .= '
                    ';
// undef $relation_name_array
$tpl->unsetLocalVariable( 'relation_name_array', $rootNamespace );

$text .= '                ';
}
unset( $if_cond );
// if ends

unset( $elseif_cond_f7d54e3bf684e011bf56b2b03b8f70fb_91 );

$text .= '            </td>
            </tr>
            ';
// if begins
unset( $if_cond );
unset( $if_cond1 );
unset( $if_cond1 );
$if_cond1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'tr_class', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['tr_class'] : null;
if (! isset( $if_cond1 ) ) $if_cond1 = NULL;
while ( is_object( $if_cond1 ) and method_exists( $if_cond1, 'templateValue' ) )
    $if_cond1 = $if_cond1->templateValue();
$if_cond = ( ( $if_cond1 ) == ( 'bgdark' ) );
unset( $if_cond1 );
if (! isset( $if_cond ) ) $if_cond = NULL;
while ( is_object( $if_cond ) and method_exists( $if_cond, 'templateValue' ) )
    $if_cond = $if_cond->templateValue();

if ( $if_cond )
{
$text .= '                ';
if ( array_key_exists( $currentNamespace, $vars ) && array_key_exists( 'tr_class', $vars[$currentNamespace] ) )
{
    $vars[$currentNamespace]['tr_class'] = 'bglight';
}
$text .= '            ';
}
else
{
$text .= '                ';
if ( array_key_exists( $currentNamespace, $vars ) && array_key_exists( 'tr_class', $vars[$currentNamespace] ) )
{
    $vars[$currentNamespace]['tr_class'] = 'bgdark';
}
$text .= '            ';
}
unset( $if_cond );
// if ends

$text .= '        ';
$fe_n_items_processed_f7d54e3bf684e011bf56b2b03b8f70fb_12++;
} // foreach
$skipDelimiter = false;
if ( count( $fe_variable_stack_f7d54e3bf684e011bf56b2b03b8f70fb_12 ) ) extract( array_pop( $fe_variable_stack_f7d54e3bf684e011bf56b2b03b8f70fb_12 ) );

else
{

unset( $fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_12 );

unset( $fe_array_keys_f7d54e3bf684e011bf56b2b03b8f70fb_12 );

unset( $fe_n_items_f7d54e3bf684e011bf56b2b03b8f70fb_12 );

unset( $fe_n_items_processed_f7d54e3bf684e011bf56b2b03b8f70fb_12 );

unset( $fe_i_f7d54e3bf684e011bf56b2b03b8f70fb_12 );

unset( $fe_key_f7d54e3bf684e011bf56b2b03b8f70fb_12 );

unset( $fe_val_f7d54e3bf684e011bf56b2b03b8f70fb_12 );

unset( $fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_12 );

unset( $fe_max_f7d54e3bf684e011bf56b2b03b8f70fb_12 );

unset( $fe_reverse_f7d54e3bf684e011bf56b2b03b8f70fb_12 );

unset( $fe_first_val_f7d54e3bf684e011bf56b2b03b8f70fb_12 );

unset( $fe_last_val_f7d54e3bf684e011bf56b2b03b8f70fb_12 );

unset( $fe_variable_stack_f7d54e3bf684e011bf56b2b03b8f70fb_12 );

}

// foreach ends
$text .= '    ';
$fe_n_items_processed_f7d54e3bf684e011bf56b2b03b8f70fb_13++;
} // foreach
$skipDelimiter = false;
if ( count( $fe_variable_stack_f7d54e3bf684e011bf56b2b03b8f70fb_13 ) ) extract( array_pop( $fe_variable_stack_f7d54e3bf684e011bf56b2b03b8f70fb_13 ) );

else
{

unset( $fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_13 );

unset( $fe_array_keys_f7d54e3bf684e011bf56b2b03b8f70fb_13 );

unset( $fe_n_items_f7d54e3bf684e011bf56b2b03b8f70fb_13 );

unset( $fe_n_items_processed_f7d54e3bf684e011bf56b2b03b8f70fb_13 );

unset( $fe_i_f7d54e3bf684e011bf56b2b03b8f70fb_13 );

unset( $fe_key_f7d54e3bf684e011bf56b2b03b8f70fb_13 );

unset( $fe_val_f7d54e3bf684e011bf56b2b03b8f70fb_13 );

unset( $fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_13 );

unset( $fe_max_f7d54e3bf684e011bf56b2b03b8f70fb_13 );

unset( $fe_reverse_f7d54e3bf684e011bf56b2b03b8f70fb_13 );

unset( $fe_first_val_f7d54e3bf684e011bf56b2b03b8f70fb_13 );

unset( $fe_last_val_f7d54e3bf684e011bf56b2b03b8f70fb_13 );

unset( $fe_variable_stack_f7d54e3bf684e011bf56b2b03b8f70fb_13 );

}

// foreach ends
$text .= '    ';
// undef $tr_class
$tpl->unsetLocalVariable( 'tr_class', $rootNamespace );

// undef $attr
$tpl->unsetLocalVariable( 'attr', $rootNamespace );

}
else
{
$text .= '    <tr><td>L\'elemento visualizzato non fa uso di nessun altro oggetto.</td></tr>';
}
unset( $if_cond );
// if ends

$text .= '</table>

<br />


<table class="list" cellspacing="0" summary="Elenco inverso degli oggetti correlati per l\'oggetto attuale.">
<tr>
    <th>';
unset( $var );
unset( $var2 );
unset( $var3 );
unset( $var3 );
$var3 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'reverse_related_objects_count', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['reverse_related_objects_count'] : null;
if (! isset( $var3 ) ) $var3 = NULL;
while ( is_object( $var3 ) and method_exists( $var3, 'templateValue' ) )
    $var3 = $var3->templateValue();
$var2 = array( '%related_objects_count' => $var3 );unset( $var3 );
if (! isset( $var2 ) ) $var2 = NULL;
while ( is_object( $var2 ) and method_exists( $var2, 'templateValue' ) )
    $var2 = $var2->templateValue();
$var3 = array();
foreach ( $var2 as $var4 => $var5 )
{
  if ( is_int( $var4 ) )
    $var3['%' . ( ($var4%9) + 1 )] = $var5;
  else
    $var3[$var4] = $var5;
}
$var = strtr( 'Oggetti correlati inversi (%related_objects_count)', $var3 );
unset( $var2, $var3, $var4, $var5 );
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
$text .= $var;
unset( $var );

$text .= '</th>
    ';
// if begins
unset( $if_cond );
unset( $if_cond );
$if_cond = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'reverse_related_objects_count', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['reverse_related_objects_count'] : null;
if (! isset( $if_cond ) ) $if_cond = NULL;
while ( is_object( $if_cond ) and method_exists( $if_cond, 'templateValue' ) )
    $if_cond = $if_cond->templateValue();

if ( $if_cond )
{
$text .= '    <th>Classe</th>
    <th>Tipo di relazione</th>
    ';
}
unset( $if_cond );
// if ends

$text .= '</tr>';
// if begins
unset( $if_cond );
unset( $if_cond );
$if_cond = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'reverse_related_objects_count', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['reverse_related_objects_count'] : null;
if (! isset( $if_cond ) ) $if_cond = NULL;
while ( is_object( $if_cond ) and method_exists( $if_cond, 'templateValue' ) )
    $if_cond = $if_cond->templateValue();

if ( $if_cond )
{
$text .= '    ';
// def $reverse_related_objects_grouped
unset( $var );
unset( $var1 );
unset( $var1 );
$var1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'node', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['node'] : null;
$var2 = compiledFetchAttribute( $var1, 'object' );
unset( $var1 );
$var1 = $var2;
$var2 = compiledFetchAttribute( $var1, 'id' );
unset( $var1 );
$var1 = $var2;
if (! isset( $var1 ) ) $var1 = NULL;
while ( is_object( $var1 ) and method_exists( $var1, 'templateValue' ) )
    $var1 = $var1->templateValue();
while ( is_object( $var1 ) and method_exists( $var1, 'templateValue' ) )
    $var1 = $var1->templateValue();
unset( $var2 );
unset( $var2 );
$var2 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'page_limit', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['page_limit'] : null;
if (! isset( $var2 ) ) $var2 = NULL;
while ( is_object( $var2 ) and method_exists( $var2, 'templateValue' ) )
    $var2 = $var2->templateValue();
while ( is_object( $var2 ) and method_exists( $var2, 'templateValue' ) )
    $var2 = $var2->templateValue();
unset( $var3 );
unset( $var3 );
$var3 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'offset', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['offset'] : null;
if (! isset( $var3 ) ) $var3 = NULL;
while ( is_object( $var3 ) and method_exists( $var3, 'templateValue' ) )
    $var3 = $var3->templateValue();
while ( is_object( $var3 ) and method_exists( $var3, 'templateValue' ) )
    $var3 = $var3->templateValue();
$var = call_user_func_array( array( new eZContentFunctionCollection(), 'fetchReverseRelatedObjects' ),
  array(     'object_id' => $var1,
    'attribute_identifier' => null,
    'all_relations' => true,
    'group_by_attribute' => true,
    'sort_by' => array( array( "class_identifier",
              true ),
       array( "name",
              true ) ),
    'ignore_visibility' => null,
    'limit' => $var2,
    'offset' => $var3,
    'as_object' => true,
    'load_data_map' => false ) );
$var = isset( $var['result'] ) ? $var['result'] : null;
unset( $var1, $var2, $var3 );
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
if ( $tpl->hasVariable( 'reverse_related_objects_grouped', $rootNamespace ) )
{
    $tpl->warning( 'def', "Variable 'reverse_related_objects_grouped' is already defined.", array (
  0 => 
  array (
    0 => 79,
    1 => 4,
    2 => 4279,
  ),
  1 => 
  array (
    0 => 79,
    1 => 304,
    2 => 4579,
  ),
  2 => 'design/admin/templates/relations.tpl',
) );
    $tpl->setVariable( 'reverse_related_objects_grouped', $var, $rootNamespace );
}
else
{
    $tpl->setLocalVariable( 'reverse_related_objects_grouped', $var, $rootNamespace );
}

$text .= '    ';
// def $reverse_related_objects_id_typed
unset( $var );
unset( $var1 );
unset( $var1 );
$var1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'node', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['node'] : null;
$var2 = compiledFetchAttribute( $var1, 'object' );
unset( $var1 );
$var1 = $var2;
$var2 = compiledFetchAttribute( $var1, 'id' );
unset( $var1 );
$var1 = $var2;
if (! isset( $var1 ) ) $var1 = NULL;
while ( is_object( $var1 ) and method_exists( $var1, 'templateValue' ) )
    $var1 = $var1->templateValue();
while ( is_object( $var1 ) and method_exists( $var1, 'templateValue' ) )
    $var1 = $var1->templateValue();
$var = call_user_func_array( array( new eZContentFunctionCollection(), 'fetchReverseRelatedObjectsID' ),
  array(     'object_id' => $var1,
    'attribute_identifier' => "0",
    'all_relations' => false ) );
$var = isset( $var['result'] ) ? $var['result'] : null;
unset( $var1 );
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
if ( $tpl->hasVariable( 'reverse_related_objects_id_typed', $rootNamespace ) )
{
    $tpl->warning( 'def', "Variable 'reverse_related_objects_id_typed' is already defined.", array (
  0 => 
  array (
    0 => 80,
    1 => 4,
    2 => 4586,
  ),
  1 => 
  array (
    0 => 80,
    1 => 131,
    2 => 4713,
  ),
  2 => 'design/admin/templates/relations.tpl',
) );
    $tpl->setVariable( 'reverse_related_objects_id_typed', $var, $rootNamespace );
}
else
{
    $tpl->setLocalVariable( 'reverse_related_objects_id_typed', $var, $rootNamespace );
}

$text .= '
    ';
// def $tr_class
if ( $tpl->hasVariable( 'tr_class', $rootNamespace ) )
{
    $tpl->warning( 'def', "Variable 'tr_class' is already defined.", array (
  0 => 
  array (
    0 => 82,
    1 => 4,
    2 => 4721,
  ),
  1 => 
  array (
    0 => 82,
    1 => 27,
    2 => 4744,
  ),
  2 => 'design/admin/templates/relations.tpl',
) );
    $tpl->setVariable( 'tr_class', 'bglight', $rootNamespace );
}
else
{
    $tpl->setLocalVariable( 'tr_class', 'bglight', $rootNamespace );
}

$text .= '    ';
// def $attr
if ( $tpl->hasVariable( 'attr', $rootNamespace ) )
{
    $tpl->warning( 'def', "Variable 'attr' is already defined.", array (
  0 => 
  array (
    0 => 83,
    1 => 4,
    2 => 4751,
  ),
  1 => 
  array (
    0 => 83,
    1 => 17,
    2 => 4764,
  ),
  2 => 'design/admin/templates/relations.tpl',
) );
    $tpl->setVariable( 'attr', 0, $rootNamespace );
}
else
{
    $tpl->setLocalVariable( 'attr', 0, $rootNamespace );
}

$text .= '    ';
// foreach begins
$skipDelimiter = true;
if ( !isset( $fe_variable_stack_f7d54e3bf684e011bf56b2b03b8f70fb_16 ) ) $fe_variable_stack_f7d54e3bf684e011bf56b2b03b8f70fb_16 = array();
$fe_variable_stack_f7d54e3bf684e011bf56b2b03b8f70fb_16[] = compact( 'fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_16', 'fe_array_keys_f7d54e3bf684e011bf56b2b03b8f70fb_16', 'fe_n_items_f7d54e3bf684e011bf56b2b03b8f70fb_16', 'fe_n_items_processed_f7d54e3bf684e011bf56b2b03b8f70fb_16', 'fe_i_f7d54e3bf684e011bf56b2b03b8f70fb_16', 'fe_key_f7d54e3bf684e011bf56b2b03b8f70fb_16', 'fe_val_f7d54e3bf684e011bf56b2b03b8f70fb_16', 'fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_16', 'fe_max_f7d54e3bf684e011bf56b2b03b8f70fb_16', 'fe_reverse_f7d54e3bf684e011bf56b2b03b8f70fb_16', 'fe_first_val_f7d54e3bf684e011bf56b2b03b8f70fb_16', 'fe_last_val_f7d54e3bf684e011bf56b2b03b8f70fb_16' );
unset( $fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_16 );
unset( $fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_16 );
$fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_16 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'reverse_related_objects_grouped', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['reverse_related_objects_grouped'] : null;
if (! isset( $fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_16 ) ) $fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_16 = NULL;
while ( is_object( $fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_16 ) and method_exists( $fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_16, 'templateValue' ) )
    $fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_16 = $fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_16->templateValue();

$fe_array_keys_f7d54e3bf684e011bf56b2b03b8f70fb_16 = is_array( $fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_16 ) ? array_keys( $fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_16 ) : array();
$fe_n_items_f7d54e3bf684e011bf56b2b03b8f70fb_16 = count( $fe_array_keys_f7d54e3bf684e011bf56b2b03b8f70fb_16 );
$fe_n_items_processed_f7d54e3bf684e011bf56b2b03b8f70fb_16 = 0;
$fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_16 = 0;
$fe_max_f7d54e3bf684e011bf56b2b03b8f70fb_16 = $fe_n_items_f7d54e3bf684e011bf56b2b03b8f70fb_16 - $fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_16;
$fe_reverse_f7d54e3bf684e011bf56b2b03b8f70fb_16 = false;
if ( $fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_16 < 0 || $fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_16 >= $fe_n_items_f7d54e3bf684e011bf56b2b03b8f70fb_16 )
{
    $fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_16 = ( $fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_16 < 0 ) ? 0 : $fe_n_items_f7d54e3bf684e011bf56b2b03b8f70fb_16;
    if ( $fe_n_items_f7d54e3bf684e011bf56b2b03b8f70fb_16 || $fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_16 < 0 )
 {
        eZDebug::writeWarning("Invalid 'offset' parameter specified: '$fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_16'. Array count: $fe_n_items_f7d54e3bf684e011bf56b2b03b8f70fb_16");   
}
}
if ( $fe_max_f7d54e3bf684e011bf56b2b03b8f70fb_16 < 0 || $fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_16 + $fe_max_f7d54e3bf684e011bf56b2b03b8f70fb_16 > $fe_n_items_f7d54e3bf684e011bf56b2b03b8f70fb_16 )
{
    if ( $fe_max_f7d54e3bf684e011bf56b2b03b8f70fb_16 < 0 )
 eZDebug::writeWarning("Invalid 'max' parameter specified: $fe_max_f7d54e3bf684e011bf56b2b03b8f70fb_16");
    $fe_max_f7d54e3bf684e011bf56b2b03b8f70fb_16 = $fe_n_items_f7d54e3bf684e011bf56b2b03b8f70fb_16 - $fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_16;
}
if ( $fe_reverse_f7d54e3bf684e011bf56b2b03b8f70fb_16 )
{
    $fe_first_val_f7d54e3bf684e011bf56b2b03b8f70fb_16 = $fe_n_items_f7d54e3bf684e011bf56b2b03b8f70fb_16 - 1 - $fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_16;
    $fe_last_val_f7d54e3bf684e011bf56b2b03b8f70fb_16  = 0;
}
else
{
    $fe_first_val_f7d54e3bf684e011bf56b2b03b8f70fb_16 = $fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_16;
    $fe_last_val_f7d54e3bf684e011bf56b2b03b8f70fb_16  = $fe_n_items_f7d54e3bf684e011bf56b2b03b8f70fb_16 - 1;
}
// foreach
for ( $fe_i_f7d54e3bf684e011bf56b2b03b8f70fb_16 = $fe_first_val_f7d54e3bf684e011bf56b2b03b8f70fb_16; $fe_n_items_processed_f7d54e3bf684e011bf56b2b03b8f70fb_16 < $fe_max_f7d54e3bf684e011bf56b2b03b8f70fb_16 && ( $fe_reverse_f7d54e3bf684e011bf56b2b03b8f70fb_16 ? $fe_i_f7d54e3bf684e011bf56b2b03b8f70fb_16 >= $fe_last_val_f7d54e3bf684e011bf56b2b03b8f70fb_16 : $fe_i_f7d54e3bf684e011bf56b2b03b8f70fb_16 <= $fe_last_val_f7d54e3bf684e011bf56b2b03b8f70fb_16 ); $fe_reverse_f7d54e3bf684e011bf56b2b03b8f70fb_16 ? $fe_i_f7d54e3bf684e011bf56b2b03b8f70fb_16-- : $fe_i_f7d54e3bf684e011bf56b2b03b8f70fb_16++ )
{
$fe_key_f7d54e3bf684e011bf56b2b03b8f70fb_16 = $fe_array_keys_f7d54e3bf684e011bf56b2b03b8f70fb_16[$fe_i_f7d54e3bf684e011bf56b2b03b8f70fb_16];
$fe_val_f7d54e3bf684e011bf56b2b03b8f70fb_16 = $fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_16[$fe_key_f7d54e3bf684e011bf56b2b03b8f70fb_16];
$vars[$rootNamespace]['related_objects_array'] = $fe_val_f7d54e3bf684e011bf56b2b03b8f70fb_16;
$vars[$rootNamespace]['attribute_id'] = $fe_key_f7d54e3bf684e011bf56b2b03b8f70fb_16;
$text .= '        ';
// if begins
unset( $if_cond );
unset( $if_cond1 );
unset( $if_cond1 );
$if_cond1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'attribute_id', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['attribute_id'] : null;
if (! isset( $if_cond1 ) ) $if_cond1 = NULL;
while ( is_object( $if_cond1 ) and method_exists( $if_cond1, 'templateValue' ) )
    $if_cond1 = $if_cond1->templateValue();
$if_cond = ( ( $if_cond1 ) != ( 0 ) );
unset( $if_cond1 );
if (! isset( $if_cond ) ) $if_cond = NULL;
while ( is_object( $if_cond ) and method_exists( $if_cond, 'templateValue' ) )
    $if_cond = $if_cond->templateValue();

if ( $if_cond )
{
$text .= '            ';
unset( $var );
unset( $var1 );
unset( $var1 );
$var1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'attribute_id', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['attribute_id'] : null;
if (! isset( $var1 ) ) $var1 = NULL;
while ( is_object( $var1 ) and method_exists( $var1, 'templateValue' ) )
    $var1 = $var1->templateValue();
while ( is_object( $var1 ) and method_exists( $var1, 'templateValue' ) )
    $var1 = $var1->templateValue();
$var = call_user_func_array( array( new eZContentFunctionCollection(), 'fetchClassAttribute' ),
  array(     'attribute_id' => $var1,
    'version_id' => 0 ) );
$var = isset( $var['result'] ) ? $var['result'] : null;
unset( $var1 );
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
if ( array_key_exists( $currentNamespace, $vars ) && array_key_exists( 'attr', $vars[$currentNamespace] ) )
{
    $vars[$currentNamespace]['attr'] = $var;
    unset( $var );
}
$text .= '        ';
}
unset( $if_cond );
// if ends

$text .= '        ';
// foreach begins
$skipDelimiter = true;
if ( !isset( $fe_variable_stack_f7d54e3bf684e011bf56b2b03b8f70fb_15 ) ) $fe_variable_stack_f7d54e3bf684e011bf56b2b03b8f70fb_15 = array();
$fe_variable_stack_f7d54e3bf684e011bf56b2b03b8f70fb_15[] = compact( 'fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_15', 'fe_array_keys_f7d54e3bf684e011bf56b2b03b8f70fb_15', 'fe_n_items_f7d54e3bf684e011bf56b2b03b8f70fb_15', 'fe_n_items_processed_f7d54e3bf684e011bf56b2b03b8f70fb_15', 'fe_i_f7d54e3bf684e011bf56b2b03b8f70fb_15', 'fe_key_f7d54e3bf684e011bf56b2b03b8f70fb_15', 'fe_val_f7d54e3bf684e011bf56b2b03b8f70fb_15', 'fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_15', 'fe_max_f7d54e3bf684e011bf56b2b03b8f70fb_15', 'fe_reverse_f7d54e3bf684e011bf56b2b03b8f70fb_15', 'fe_first_val_f7d54e3bf684e011bf56b2b03b8f70fb_15', 'fe_last_val_f7d54e3bf684e011bf56b2b03b8f70fb_15' );
unset( $fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_15 );
unset( $fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_15 );
$fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_15 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'related_objects_array', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['related_objects_array'] : null;
if (! isset( $fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_15 ) ) $fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_15 = NULL;
while ( is_object( $fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_15 ) and method_exists( $fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_15, 'templateValue' ) )
    $fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_15 = $fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_15->templateValue();

$fe_array_keys_f7d54e3bf684e011bf56b2b03b8f70fb_15 = is_array( $fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_15 ) ? array_keys( $fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_15 ) : array();
$fe_n_items_f7d54e3bf684e011bf56b2b03b8f70fb_15 = count( $fe_array_keys_f7d54e3bf684e011bf56b2b03b8f70fb_15 );
$fe_n_items_processed_f7d54e3bf684e011bf56b2b03b8f70fb_15 = 0;
$fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_15 = 0;
$fe_max_f7d54e3bf684e011bf56b2b03b8f70fb_15 = $fe_n_items_f7d54e3bf684e011bf56b2b03b8f70fb_15 - $fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_15;
$fe_reverse_f7d54e3bf684e011bf56b2b03b8f70fb_15 = false;
if ( $fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_15 < 0 || $fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_15 >= $fe_n_items_f7d54e3bf684e011bf56b2b03b8f70fb_15 )
{
    $fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_15 = ( $fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_15 < 0 ) ? 0 : $fe_n_items_f7d54e3bf684e011bf56b2b03b8f70fb_15;
    if ( $fe_n_items_f7d54e3bf684e011bf56b2b03b8f70fb_15 || $fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_15 < 0 )
 {
        eZDebug::writeWarning("Invalid 'offset' parameter specified: '$fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_15'. Array count: $fe_n_items_f7d54e3bf684e011bf56b2b03b8f70fb_15");   
}
}
if ( $fe_max_f7d54e3bf684e011bf56b2b03b8f70fb_15 < 0 || $fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_15 + $fe_max_f7d54e3bf684e011bf56b2b03b8f70fb_15 > $fe_n_items_f7d54e3bf684e011bf56b2b03b8f70fb_15 )
{
    if ( $fe_max_f7d54e3bf684e011bf56b2b03b8f70fb_15 < 0 )
 eZDebug::writeWarning("Invalid 'max' parameter specified: $fe_max_f7d54e3bf684e011bf56b2b03b8f70fb_15");
    $fe_max_f7d54e3bf684e011bf56b2b03b8f70fb_15 = $fe_n_items_f7d54e3bf684e011bf56b2b03b8f70fb_15 - $fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_15;
}
if ( $fe_reverse_f7d54e3bf684e011bf56b2b03b8f70fb_15 )
{
    $fe_first_val_f7d54e3bf684e011bf56b2b03b8f70fb_15 = $fe_n_items_f7d54e3bf684e011bf56b2b03b8f70fb_15 - 1 - $fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_15;
    $fe_last_val_f7d54e3bf684e011bf56b2b03b8f70fb_15  = 0;
}
else
{
    $fe_first_val_f7d54e3bf684e011bf56b2b03b8f70fb_15 = $fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_15;
    $fe_last_val_f7d54e3bf684e011bf56b2b03b8f70fb_15  = $fe_n_items_f7d54e3bf684e011bf56b2b03b8f70fb_15 - 1;
}
// foreach
for ( $fe_i_f7d54e3bf684e011bf56b2b03b8f70fb_15 = $fe_first_val_f7d54e3bf684e011bf56b2b03b8f70fb_15; $fe_n_items_processed_f7d54e3bf684e011bf56b2b03b8f70fb_15 < $fe_max_f7d54e3bf684e011bf56b2b03b8f70fb_15 && ( $fe_reverse_f7d54e3bf684e011bf56b2b03b8f70fb_15 ? $fe_i_f7d54e3bf684e011bf56b2b03b8f70fb_15 >= $fe_last_val_f7d54e3bf684e011bf56b2b03b8f70fb_15 : $fe_i_f7d54e3bf684e011bf56b2b03b8f70fb_15 <= $fe_last_val_f7d54e3bf684e011bf56b2b03b8f70fb_15 ); $fe_reverse_f7d54e3bf684e011bf56b2b03b8f70fb_15 ? $fe_i_f7d54e3bf684e011bf56b2b03b8f70fb_15-- : $fe_i_f7d54e3bf684e011bf56b2b03b8f70fb_15++ )
{
$fe_key_f7d54e3bf684e011bf56b2b03b8f70fb_15 = $fe_array_keys_f7d54e3bf684e011bf56b2b03b8f70fb_15[$fe_i_f7d54e3bf684e011bf56b2b03b8f70fb_15];
$fe_val_f7d54e3bf684e011bf56b2b03b8f70fb_15 = $fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_15[$fe_key_f7d54e3bf684e011bf56b2b03b8f70fb_15];
$vars[$rootNamespace]['object'] = $fe_val_f7d54e3bf684e011bf56b2b03b8f70fb_15;
$text .= '            <tr class="';
unset( $var );
unset( $var );
$var = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'tr_class', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['tr_class'] : null;
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
$text .= ( is_object( $var ) ? compiledFetchText( $tpl, $rootNamespace, $currentNamespace, false, $var ) : $var );
unset( $var );

$text .= '">
            ';
// if begins
unset( $if_cond );
unset( $if_cond1 );
unset( $if_cond1 );
$if_cond1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'object', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['object'] : null;
$if_cond2 = compiledFetchAttribute( $if_cond1, 'can_read' );
unset( $if_cond1 );
$if_cond1 = $if_cond2;
if (! isset( $if_cond1 ) ) $if_cond1 = NULL;
while ( is_object( $if_cond1 ) and method_exists( $if_cond1, 'templateValue' ) )
    $if_cond1 = $if_cond1->templateValue();
unset( $if_cond2 );
unset( $if_cond2 );
$if_cond2 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'object', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['object'] : null;
$if_cond3 = compiledFetchAttribute( $if_cond2, 'can_view_embed' );
unset( $if_cond2 );
$if_cond2 = $if_cond3;
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
$text .= '                <td>';
unset( $var );
unset( $var );
$var = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'object', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['object'] : null;
$var1 = compiledFetchAttribute( $var, 'content_class' );
unset( $var );
$var = $var1;
$var1 = compiledFetchAttribute( $var, 'identifier' );
unset( $var );
$var = $var1;
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
$varData = array( 'value' => $var );
$tpl->processOperator( 'class_icon',
                       array (
  0 => 
  array (
    0 => 
    array (
      0 => 3,
      1 => 'small',
      2 => false,
    ),
  ),
  1 => 
  array (
    0 => 
    array (
      0 => 4,
      1 => 
      array (
        0 => '',
        1 => 2,
        2 => 'object',
      ),
      2 => false,
    ),
    1 => 
    array (
      0 => 5,
      1 => 
      array (
        0 => 
        array (
          0 => 3,
          1 => 'content_class',
          2 => false,
        ),
      ),
      2 => false,
    ),
    2 => 
    array (
      0 => 5,
      1 => 
      array (
        0 => 
        array (
          0 => 3,
          1 => 'name',
          2 => false,
        ),
      ),
      2 => false,
    ),
    3 => 
    array (
      0 => 6,
      1 => 
      array (
        0 => 'wash',
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

$text .= '&nbsp;';
unset( $var );
unset( $var );
$var = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'object', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['object'] : null;
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
$namespace = $currentNamespace;
if ( $namespace == '' )
    $namespace = "ContentView";
else
    $namespace .= ':ContentView';
$vars[$namespace]['object'] = $var;
unset( $var );
if ( !isset( $dKeys ) )
{
    $resH = $tpl->resourceHandler( 'design' );
    $dKeys = $resH->keys();
}
if ( !isset( $dKeysStack ) )
{
    $dKeysStack = array();
}
$dKeysStack[] = $dKeys;
unset( $dKey );
$namespace = $currentNamespace;
if ( $namespace == '' )
    $namespace = "ContentView";
else
    $namespace .= ':ContentView';
unset( $dKey );
$dKey = ( array_key_exists( $namespace, $vars ) and array_key_exists( 'object', $vars[$namespace] ) ) ? $vars[$namespace]['object'] : null;
$dKey1 = compiledFetchAttribute( $dKey, 'id' );
unset( $dKey );
$dKey = $dKey1;
if (! isset( $dKey ) ) $dKey = NULL;
while ( is_object( $dKey ) and method_exists( $dKey, 'templateValue' ) )
    $dKey = $dKey->templateValue();

$dKeys["object"] = $dKey;
unset( $dKey );

unset( $dKey );
$namespace = $currentNamespace;
if ( $namespace == '' )
    $namespace = "ContentView";
else
    $namespace .= ':ContentView';
unset( $dKey );
$dKey = ( array_key_exists( $namespace, $vars ) and array_key_exists( 'object', $vars[$namespace] ) ) ? $vars[$namespace]['object'] : null;
$dKey1 = compiledFetchAttribute( $dKey, 'match_ingroup_id_list' );
unset( $dKey );
$dKey = $dKey1;
if (! isset( $dKey ) ) $dKey = NULL;
while ( is_object( $dKey ) and method_exists( $dKey, 'templateValue' ) )
    $dKey = $dKey->templateValue();

$dKeys["class_group"] = $dKey;
unset( $dKey );

unset( $dKey );
$namespace = $currentNamespace;
if ( $namespace == '' )
    $namespace = "ContentView";
else
    $namespace .= ':ContentView';
unset( $dKey );
$dKey = ( array_key_exists( $namespace, $vars ) and array_key_exists( 'object', $vars[$namespace] ) ) ? $vars[$namespace]['object'] : null;
$dKey1 = compiledFetchAttribute( $dKey, 'contentclass_id' );
unset( $dKey );
$dKey = $dKey1;
if (! isset( $dKey ) ) $dKey = NULL;
while ( is_object( $dKey ) and method_exists( $dKey, 'templateValue' ) )
    $dKey = $dKey->templateValue();

$dKeys["class"] = $dKey;
unset( $dKey );

unset( $dKey );
$namespace = $currentNamespace;
if ( $namespace == '' )
    $namespace = "ContentView";
else
    $namespace .= ':ContentView';
unset( $dKey );
$dKey = ( array_key_exists( $namespace, $vars ) and array_key_exists( 'object', $vars[$namespace] ) ) ? $vars[$namespace]['object'] : null;
$dKey1 = compiledFetchAttribute( $dKey, 'section_id' );
unset( $dKey );
$dKey = $dKey1;
if (! isset( $dKey ) ) $dKey = NULL;
while ( is_object( $dKey ) and method_exists( $dKey, 'templateValue' ) )
    $dKey = $dKey->templateValue();

$dKeys["section"] = $dKey;
unset( $dKey );

unset( $dKey );
$namespace = $currentNamespace;
if ( $namespace == '' )
    $namespace = "ContentView";
else
    $namespace .= ':ContentView';
unset( $dKey );
$dKey = ( array_key_exists( $namespace, $vars ) and array_key_exists( 'object', $vars[$namespace] ) ) ? $vars[$namespace]['object'] : null;
$dKey1 = compiledFetchAttribute( $dKey, 'class_identifier' );
unset( $dKey );
$dKey = $dKey1;
if (! isset( $dKey ) ) $dKey = NULL;
while ( is_object( $dKey ) and method_exists( $dKey, 'templateValue' ) )
    $dKey = $dKey->templateValue();

$dKeys["class_identifier"] = $dKey;
unset( $dKey );

unset( $dKey );
$namespace = $currentNamespace;
if ( $namespace == '' )
    $namespace = "ContentView";
else
    $namespace .= ':ContentView';
unset( $dKey );
$dKey = ( array_key_exists( $namespace, $vars ) and array_key_exists( 'object', $vars[$namespace] ) ) ? $vars[$namespace]['object'] : null;
$dKey1 = compiledFetchAttribute( $dKey, 'remote_id' );
unset( $dKey );
$dKey = $dKey1;
if (! isset( $dKey ) ) $dKey = NULL;
while ( is_object( $dKey ) and method_exists( $dKey, 'templateValue' ) )
    $dKey = $dKey->templateValue();

$dKeys["remote_id"] = $dKey;
unset( $dKey );

unset( $dKey );
$namespace = $currentNamespace;
if ( $namespace == '' )
    $namespace = "ContentView";
else
    $namespace .= ':ContentView';
unset( $dKey );
$dKey = ( array_key_exists( $namespace, $vars ) and array_key_exists( 'object', $vars[$namespace] ) ) ? $vars[$namespace]['object'] : null;
$dKey1 = compiledFetchAttribute( $dKey, 'state_id_array' );
unset( $dKey );
$dKey = $dKey1;
if (! isset( $dKey ) ) $dKey = NULL;
while ( is_object( $dKey ) and method_exists( $dKey, 'templateValue' ) )
    $dKey = $dKey->templateValue();

$dKeys["state"] = $dKey;
unset( $dKey );

unset( $dKey );
$namespace = $currentNamespace;
if ( $namespace == '' )
    $namespace = "ContentView";
else
    $namespace .= ':ContentView';
unset( $dKey );
$dKey = ( array_key_exists( $namespace, $vars ) and array_key_exists( 'object', $vars[$namespace] ) ) ? $vars[$namespace]['object'] : null;
$dKey1 = compiledFetchAttribute( $dKey, 'state_identifier_array' );
unset( $dKey );
$dKey = $dKey1;
if (! isset( $dKey ) ) $dKey = NULL;
while ( is_object( $dKey ) and method_exists( $dKey, 'templateValue' ) )
    $dKey = $dKey->templateValue();

$dKeys["state_identifier"] = $dKey;
unset( $dKey );

$resourceFound = false;
if ( file_exists( 'var/ezdemo_site/cache/template/compiled/text_linked-3bd896be0f5ad970c3496c0920dba105.php' ) )
{
$resourceFound = true;
$namespaceStack[] = array( $rootNamespace, $currentNamespace );
$currentNamespace = $rootNamespace = !$currentNamespace ? 'ContentView' : ( $currentNamespace . ':' . 'ContentView' );
$tpl->createLocalVariablesList();
$tpl->appendTemplateFetch( 'design/standard/templates/content/view/text_linked.tpl' );
include( '' . 'var/ezdemo_site/cache/template/compiled/text_linked-3bd896be0f5ad970c3496c0920dba105.php' );
$tpl->unsetLocalVariables();
$tpl->destroyLocalVariablesList();
list( $rootNamespace, $currentNamespace ) = array_pop( $namespaceStack );
}
else
{
    $resourceFound = true;
$resourceFound = true;
$namespaceStack[] = array( $rootNamespace, $currentNamespace );
$currentNamespace = $rootNamespace = !$currentNamespace ? 'ContentView' : ( $currentNamespace . ':' . 'ContentView' );
$textElements = array();
$extraParameters = array();
$tpl->processURI( 'design/standard/templates/content/view/text_linked.tpl', true, $extraParameters, $textElements, $rootNamespace, $currentNamespace );
$text .= implode( '', $textElements );
list( $rootNamespace, $currentNamespace ) = array_pop( $namespaceStack );
}

$dKeys = array_pop( $dKeysStack );
$namespace = $currentNamespace;
if ( $namespace == '' )
    $namespace = "ContentView";
else
    $namespace .= ':ContentView';
unset( $vars[$namespace]['object'] );
$text .= '</td>
                <td>';
unset( $var );
unset( $var1 );
unset( $var1 );
$var1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'object', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['object'] : null;
$var2 = compiledFetchAttribute( $var1, 'content_class' );
unset( $var1 );
$var1 = $var2;
$var2 = compiledFetchAttribute( $var1, 'name' );
unset( $var1 );
$var1 = $var2;
if (! isset( $var1 ) ) $var1 = NULL;
while ( is_object( $var1 ) and method_exists( $var1, 'templateValue' ) )
    $var1 = $var1->templateValue();
while ( is_object( $var1 ) and method_exists( $var1, 'templateValue' ) )
    $var1 = $var1->templateValue();
$var = htmlspecialchars( $var1 );
unset( $var1 );
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
$text .= $var;
unset( $var );

$text .= '</td>
            ';
}
else
{
$text .= '                <td colspan="2"><em>You are not allowed to view the related object</em></td>
            ';
}
unset( $if_cond );
// if ends

$text .= '            <td>
                ';
unset( $elseif_cond_f7d54e3bf684e011bf56b2b03b8f70fb_100 );
unset( $elseif_cond_f7d54e3bf684e011bf56b2b03b8f70fb_1001 );
unset( $elseif_cond_f7d54e3bf684e011bf56b2b03b8f70fb_1001 );
$elseif_cond_f7d54e3bf684e011bf56b2b03b8f70fb_1001 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'attribute_id', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['attribute_id'] : null;
if (! isset( $elseif_cond_f7d54e3bf684e011bf56b2b03b8f70fb_1001 ) ) $elseif_cond_f7d54e3bf684e011bf56b2b03b8f70fb_1001 = NULL;
while ( is_object( $elseif_cond_f7d54e3bf684e011bf56b2b03b8f70fb_1001 ) and method_exists( $elseif_cond_f7d54e3bf684e011bf56b2b03b8f70fb_1001, 'templateValue' ) )
    $elseif_cond_f7d54e3bf684e011bf56b2b03b8f70fb_1001 = $elseif_cond_f7d54e3bf684e011bf56b2b03b8f70fb_1001->templateValue();
while ( is_object( $elseif_cond_f7d54e3bf684e011bf56b2b03b8f70fb_1001 ) and method_exists( $elseif_cond_f7d54e3bf684e011bf56b2b03b8f70fb_1001, 'templateValue' ) )
    $elseif_cond_f7d54e3bf684e011bf56b2b03b8f70fb_1001 = $elseif_cond_f7d54e3bf684e011bf56b2b03b8f70fb_1001->templateValue();
$elseif_cond_f7d54e3bf684e011bf56b2b03b8f70fb_100 = ( ( $elseif_cond_f7d54e3bf684e011bf56b2b03b8f70fb_1001 ) == ( 0 ) );
unset( $elseif_cond_f7d54e3bf684e011bf56b2b03b8f70fb_1001 );
if (! isset( $elseif_cond_f7d54e3bf684e011bf56b2b03b8f70fb_100 ) ) $elseif_cond_f7d54e3bf684e011bf56b2b03b8f70fb_100 = NULL;
while ( is_object( $elseif_cond_f7d54e3bf684e011bf56b2b03b8f70fb_100 ) and method_exists( $elseif_cond_f7d54e3bf684e011bf56b2b03b8f70fb_100, 'templateValue' ) )
    $elseif_cond_f7d54e3bf684e011bf56b2b03b8f70fb_100 = $elseif_cond_f7d54e3bf684e011bf56b2b03b8f70fb_100->templateValue();

// if begins
unset( $if_cond );
unset( $if_cond1 );
unset( $if_cond2 );
unset( $if_cond2 );
$if_cond2 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'attribute_id', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['attribute_id'] : null;
if (! isset( $if_cond2 ) ) $if_cond2 = NULL;
while ( is_object( $if_cond2 ) and method_exists( $if_cond2, 'templateValue' ) )
    $if_cond2 = $if_cond2->templateValue();
$if_cond1 = ( ( $if_cond2 ) != ( 0 ) );
unset( $if_cond2 );
if (! isset( $if_cond1 ) ) $if_cond1 = NULL;
while ( is_object( $if_cond1 ) and method_exists( $if_cond1, 'templateValue' ) )
    $if_cond1 = $if_cond1->templateValue();
unset( $if_cond2 );
unset( $if_cond3 );
unset( $if_cond3 );
$if_cond3 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'reverse_related_objects_id_typed', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['reverse_related_objects_id_typed'] : null;
$if_cond4 = compiledFetchAttribute( $if_cond3, 'attribute' );
unset( $if_cond3 );
$if_cond3 = $if_cond4;
if (! isset( $if_cond3 ) ) $if_cond3 = NULL;
while ( is_object( $if_cond3 ) and method_exists( $if_cond3, 'templateValue' ) )
    $if_cond3 = $if_cond3->templateValue();
unset( $if_cond4 );
unset( $if_cond4 );
$if_cond4 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'object', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['object'] : null;
$if_cond5 = compiledFetchAttribute( $if_cond4, 'id' );
unset( $if_cond4 );
$if_cond4 = $if_cond5;
if (! isset( $if_cond4 ) ) $if_cond4 = NULL;
while ( is_object( $if_cond4 ) and method_exists( $if_cond4, 'templateValue' ) )
    $if_cond4 = $if_cond4->templateValue();
if( is_string( $if_cond3 ) )
{
  $if_cond2 = ( strpos( $if_cond3, $if_cond4 ) !== false );
}
else if ( is_array( $if_cond3 ) )
{
  $if_cond2 = in_array( $if_cond4, $if_cond3 );
}
else
{
$if_cond2 = false;
}unset( $if_cond3, $if_cond4 );
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
$text .= '                    ';
unset( $var );
unset( $var );
$var = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'relation_type_names', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['relation_type_names'] : null;
$var1 = compiledFetchAttribute( $var, 'attribute' );
unset( $var );
$var = $var1;
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
$text .= ( is_object( $var ) ? compiledFetchText( $tpl, $rootNamespace, $currentNamespace, false, $var ) : $var );
unset( $var );

$text .= ' ( ';
unset( $var );
unset( $var );
$var = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'attr', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['attr'] : null;
$var1 = compiledFetchAttribute( $var, 'name' );
unset( $var );
$var = $var1;
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
$text .= ( is_object( $var ) ? compiledFetchText( $tpl, $rootNamespace, $currentNamespace, false, $var ) : $var );
unset( $var );

$text .= ' )
                ';
}
elseif ( $elseif_cond_f7d54e3bf684e011bf56b2b03b8f70fb_100 )
{
$text .= '                    ';
// def $relation_name_array
if ( $tpl->hasVariable( 'relation_name_array', $rootNamespace ) )
{
    $tpl->warning( 'def', "Variable 'relation_name_array' is already defined.", array (
  0 => 
  array (
    0 => 100,
    1 => 20,
    2 => 5853,
  ),
  1 => 
  array (
    0 => 100,
    1 => 54,
    2 => 5887,
  ),
  2 => 'design/admin/templates/relations.tpl',
) );
    $tpl->setVariable( 'relation_name_array', array (
), $rootNamespace );
}
else
{
    $tpl->setLocalVariable( 'relation_name_array', array (
), $rootNamespace );
}

$text .= '                    ';
// foreach begins
$skipDelimiter = true;
if ( !isset( $fe_variable_stack_f7d54e3bf684e011bf56b2b03b8f70fb_14 ) ) $fe_variable_stack_f7d54e3bf684e011bf56b2b03b8f70fb_14 = array();
$fe_variable_stack_f7d54e3bf684e011bf56b2b03b8f70fb_14[] = compact( 'fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_14', 'fe_array_keys_f7d54e3bf684e011bf56b2b03b8f70fb_14', 'fe_n_items_f7d54e3bf684e011bf56b2b03b8f70fb_14', 'fe_n_items_processed_f7d54e3bf684e011bf56b2b03b8f70fb_14', 'fe_i_f7d54e3bf684e011bf56b2b03b8f70fb_14', 'fe_key_f7d54e3bf684e011bf56b2b03b8f70fb_14', 'fe_val_f7d54e3bf684e011bf56b2b03b8f70fb_14', 'fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_14', 'fe_max_f7d54e3bf684e011bf56b2b03b8f70fb_14', 'fe_reverse_f7d54e3bf684e011bf56b2b03b8f70fb_14', 'fe_first_val_f7d54e3bf684e011bf56b2b03b8f70fb_14', 'fe_last_val_f7d54e3bf684e011bf56b2b03b8f70fb_14' );
unset( $fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_14 );
unset( $fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_14 );
$fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_14 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'reverse_related_objects_id_typed', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['reverse_related_objects_id_typed'] : null;
if (! isset( $fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_14 ) ) $fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_14 = NULL;
while ( is_object( $fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_14 ) and method_exists( $fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_14, 'templateValue' ) )
    $fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_14 = $fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_14->templateValue();

$fe_array_keys_f7d54e3bf684e011bf56b2b03b8f70fb_14 = is_array( $fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_14 ) ? array_keys( $fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_14 ) : array();
$fe_n_items_f7d54e3bf684e011bf56b2b03b8f70fb_14 = count( $fe_array_keys_f7d54e3bf684e011bf56b2b03b8f70fb_14 );
$fe_n_items_processed_f7d54e3bf684e011bf56b2b03b8f70fb_14 = 0;
$fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_14 = 0;
$fe_max_f7d54e3bf684e011bf56b2b03b8f70fb_14 = $fe_n_items_f7d54e3bf684e011bf56b2b03b8f70fb_14 - $fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_14;
$fe_reverse_f7d54e3bf684e011bf56b2b03b8f70fb_14 = false;
if ( $fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_14 < 0 || $fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_14 >= $fe_n_items_f7d54e3bf684e011bf56b2b03b8f70fb_14 )
{
    $fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_14 = ( $fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_14 < 0 ) ? 0 : $fe_n_items_f7d54e3bf684e011bf56b2b03b8f70fb_14;
    if ( $fe_n_items_f7d54e3bf684e011bf56b2b03b8f70fb_14 || $fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_14 < 0 )
 {
        eZDebug::writeWarning("Invalid 'offset' parameter specified: '$fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_14'. Array count: $fe_n_items_f7d54e3bf684e011bf56b2b03b8f70fb_14");   
}
}
if ( $fe_max_f7d54e3bf684e011bf56b2b03b8f70fb_14 < 0 || $fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_14 + $fe_max_f7d54e3bf684e011bf56b2b03b8f70fb_14 > $fe_n_items_f7d54e3bf684e011bf56b2b03b8f70fb_14 )
{
    if ( $fe_max_f7d54e3bf684e011bf56b2b03b8f70fb_14 < 0 )
 eZDebug::writeWarning("Invalid 'max' parameter specified: $fe_max_f7d54e3bf684e011bf56b2b03b8f70fb_14");
    $fe_max_f7d54e3bf684e011bf56b2b03b8f70fb_14 = $fe_n_items_f7d54e3bf684e011bf56b2b03b8f70fb_14 - $fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_14;
}
if ( $fe_reverse_f7d54e3bf684e011bf56b2b03b8f70fb_14 )
{
    $fe_first_val_f7d54e3bf684e011bf56b2b03b8f70fb_14 = $fe_n_items_f7d54e3bf684e011bf56b2b03b8f70fb_14 - 1 - $fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_14;
    $fe_last_val_f7d54e3bf684e011bf56b2b03b8f70fb_14  = 0;
}
else
{
    $fe_first_val_f7d54e3bf684e011bf56b2b03b8f70fb_14 = $fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_14;
    $fe_last_val_f7d54e3bf684e011bf56b2b03b8f70fb_14  = $fe_n_items_f7d54e3bf684e011bf56b2b03b8f70fb_14 - 1;
}
// foreach
for ( $fe_i_f7d54e3bf684e011bf56b2b03b8f70fb_14 = $fe_first_val_f7d54e3bf684e011bf56b2b03b8f70fb_14; $fe_n_items_processed_f7d54e3bf684e011bf56b2b03b8f70fb_14 < $fe_max_f7d54e3bf684e011bf56b2b03b8f70fb_14 && ( $fe_reverse_f7d54e3bf684e011bf56b2b03b8f70fb_14 ? $fe_i_f7d54e3bf684e011bf56b2b03b8f70fb_14 >= $fe_last_val_f7d54e3bf684e011bf56b2b03b8f70fb_14 : $fe_i_f7d54e3bf684e011bf56b2b03b8f70fb_14 <= $fe_last_val_f7d54e3bf684e011bf56b2b03b8f70fb_14 ); $fe_reverse_f7d54e3bf684e011bf56b2b03b8f70fb_14 ? $fe_i_f7d54e3bf684e011bf56b2b03b8f70fb_14-- : $fe_i_f7d54e3bf684e011bf56b2b03b8f70fb_14++ )
{
$fe_key_f7d54e3bf684e011bf56b2b03b8f70fb_14 = $fe_array_keys_f7d54e3bf684e011bf56b2b03b8f70fb_14[$fe_i_f7d54e3bf684e011bf56b2b03b8f70fb_14];
$fe_val_f7d54e3bf684e011bf56b2b03b8f70fb_14 = $fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_14[$fe_key_f7d54e3bf684e011bf56b2b03b8f70fb_14];
$vars[$rootNamespace]['relation_id_array'] = $fe_val_f7d54e3bf684e011bf56b2b03b8f70fb_14;
$vars[$rootNamespace]['relation_type'] = $fe_key_f7d54e3bf684e011bf56b2b03b8f70fb_14;
$text .= '                        ';
// if begins
unset( $if_cond );
unset( $if_cond1 );
unset( $if_cond1 );
$if_cond1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'relation_type', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['relation_type'] : null;
if (! isset( $if_cond1 ) ) $if_cond1 = NULL;
while ( is_object( $if_cond1 ) and method_exists( $if_cond1, 'templateValue' ) )
    $if_cond1 = $if_cond1->templateValue();
$if_cond = ( ( $if_cond1 ) != ( 'attribute' ) );
unset( $if_cond1 );
if (! isset( $if_cond ) ) $if_cond = NULL;
while ( is_object( $if_cond ) and method_exists( $if_cond, 'templateValue' ) )
    $if_cond = $if_cond->templateValue();

if ( $if_cond )
{
$text .= '                            ';
// if begins
unset( $if_cond );
unset( $if_cond1 );
unset( $if_cond1 );
$if_cond1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'relation_id_array', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['relation_id_array'] : null;
if (! isset( $if_cond1 ) ) $if_cond1 = NULL;
while ( is_object( $if_cond1 ) and method_exists( $if_cond1, 'templateValue' ) )
    $if_cond1 = $if_cond1->templateValue();
unset( $if_cond2 );
unset( $if_cond2 );
$if_cond2 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'object', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['object'] : null;
$if_cond3 = compiledFetchAttribute( $if_cond2, 'id' );
unset( $if_cond2 );
$if_cond2 = $if_cond3;
if (! isset( $if_cond2 ) ) $if_cond2 = NULL;
while ( is_object( $if_cond2 ) and method_exists( $if_cond2, 'templateValue' ) )
    $if_cond2 = $if_cond2->templateValue();
if( is_string( $if_cond1 ) )
{
  $if_cond = ( strpos( $if_cond1, $if_cond2 ) !== false );
}
else if ( is_array( $if_cond1 ) )
{
  $if_cond = in_array( $if_cond2, $if_cond1 );
}
else
{
$if_cond = false;
}unset( $if_cond1, $if_cond2 );
if (! isset( $if_cond ) ) $if_cond = NULL;
while ( is_object( $if_cond ) and method_exists( $if_cond, 'templateValue' ) )
    $if_cond = $if_cond->templateValue();

if ( $if_cond )
{
$text .= '                                ';
unset( $var );
unset( $var1 );
unset( $var1 );
$var1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'relation_type_names', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['relation_type_names'] : null;
unset( $var3 );
unset( $var3 );
$var3 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'relation_type', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['relation_type'] : null;
if (! isset( $var3 ) ) $var3 = NULL;
while ( is_object( $var3 ) and method_exists( $var3, 'templateValue' ) )
    $var3 = $var3->templateValue();
$var2 = compiledFetchAttribute( $var1, $var3 );
unset( $var1 );
$var1 = $var2;
if (! isset( $var1 ) ) $var1 = NULL;
while ( is_object( $var1 ) and method_exists( $var1, 'templateValue' ) )
    $var1 = $var1->templateValue();
while ( is_object( $var1 ) and method_exists( $var1, 'templateValue' ) )
    $var1 = $var1->templateValue();
unset( $var2 );
unset( $var2 );
$var2 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'relation_name_array', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['relation_name_array'] : null;
if (! isset( $var2 ) ) $var2 = NULL;
while ( is_object( $var2 ) and method_exists( $var2, 'templateValue' ) )
    $var2 = $var2->templateValue();
while ( is_object( $var2 ) and method_exists( $var2, 'templateValue' ) )
    $var2 = $var2->templateValue();
if ( is_string( $var2 ) )
    $var = $var2 . implode( '', array( $var1 ) );
else if( is_array( $var2 ) )
    $var = array_merge( $var2, array( $var1 ) );
unset( $var1, $var2 );
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
if ( array_key_exists( $currentNamespace, $vars ) && array_key_exists( 'relation_name_array', $vars[$currentNamespace] ) )
{
    $vars[$currentNamespace]['relation_name_array'] = $var;
    unset( $var );
}
$text .= '                            ';
}
unset( $if_cond );
// if ends

$text .= '                        ';
}
unset( $if_cond );
// if ends

$text .= '                    ';
$fe_n_items_processed_f7d54e3bf684e011bf56b2b03b8f70fb_14++;
} // foreach
$skipDelimiter = false;
if ( count( $fe_variable_stack_f7d54e3bf684e011bf56b2b03b8f70fb_14 ) ) extract( array_pop( $fe_variable_stack_f7d54e3bf684e011bf56b2b03b8f70fb_14 ) );

else
{

unset( $fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_14 );

unset( $fe_array_keys_f7d54e3bf684e011bf56b2b03b8f70fb_14 );

unset( $fe_n_items_f7d54e3bf684e011bf56b2b03b8f70fb_14 );

unset( $fe_n_items_processed_f7d54e3bf684e011bf56b2b03b8f70fb_14 );

unset( $fe_i_f7d54e3bf684e011bf56b2b03b8f70fb_14 );

unset( $fe_key_f7d54e3bf684e011bf56b2b03b8f70fb_14 );

unset( $fe_val_f7d54e3bf684e011bf56b2b03b8f70fb_14 );

unset( $fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_14 );

unset( $fe_max_f7d54e3bf684e011bf56b2b03b8f70fb_14 );

unset( $fe_reverse_f7d54e3bf684e011bf56b2b03b8f70fb_14 );

unset( $fe_first_val_f7d54e3bf684e011bf56b2b03b8f70fb_14 );

unset( $fe_last_val_f7d54e3bf684e011bf56b2b03b8f70fb_14 );

unset( $fe_variable_stack_f7d54e3bf684e011bf56b2b03b8f70fb_14 );

}

// foreach ends
$text .= '                    ';
unset( $var );
unset( $var1 );
unset( $var1 );
$var1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'relation_name_delimiter', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['relation_name_delimiter'] : null;
if (! isset( $var1 ) ) $var1 = NULL;
while ( is_object( $var1 ) and method_exists( $var1, 'templateValue' ) )
    $var1 = $var1->templateValue();
while ( is_object( $var1 ) and method_exists( $var1, 'templateValue' ) )
    $var1 = $var1->templateValue();
unset( $var2 );
unset( $var2 );
$var2 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'relation_name_array', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['relation_name_array'] : null;
if (! isset( $var2 ) ) $var2 = NULL;
while ( is_object( $var2 ) and method_exists( $var2, 'templateValue' ) )
    $var2 = $var2->templateValue();
while ( is_object( $var2 ) and method_exists( $var2, 'templateValue' ) )
    $var2 = $var2->templateValue();
$var = implode( $var1, $var2 );unset( $var1, $var2 );
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
$text .= $var;
unset( $var );

$text .= '
                    ';
// undef $relation_name_array
$tpl->unsetLocalVariable( 'relation_name_array', $rootNamespace );

$text .= '                ';
}
unset( $if_cond );
// if ends

unset( $elseif_cond_f7d54e3bf684e011bf56b2b03b8f70fb_100 );

$text .= '            </td>
            </tr>
            ';
// if begins
unset( $if_cond );
unset( $if_cond1 );
unset( $if_cond1 );
$if_cond1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'tr_class', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['tr_class'] : null;
if (! isset( $if_cond1 ) ) $if_cond1 = NULL;
while ( is_object( $if_cond1 ) and method_exists( $if_cond1, 'templateValue' ) )
    $if_cond1 = $if_cond1->templateValue();
$if_cond = ( ( $if_cond1 ) == ( 'bdark' ) );
unset( $if_cond1 );
if (! isset( $if_cond ) ) $if_cond = NULL;
while ( is_object( $if_cond ) and method_exists( $if_cond, 'templateValue' ) )
    $if_cond = $if_cond->templateValue();

if ( $if_cond )
{
$text .= '                ';
if ( array_key_exists( $currentNamespace, $vars ) && array_key_exists( 'tr_class', $vars[$currentNamespace] ) )
{
    $vars[$currentNamespace]['tr_class'] = 'bglight';
}
$text .= '            ';
}
else
{
$text .= '                ';
if ( array_key_exists( $currentNamespace, $vars ) && array_key_exists( 'tr_class', $vars[$currentNamespace] ) )
{
    $vars[$currentNamespace]['tr_class'] = 'bgdark';
}
$text .= '            ';
}
unset( $if_cond );
// if ends

$text .= '        ';
$fe_n_items_processed_f7d54e3bf684e011bf56b2b03b8f70fb_15++;
} // foreach
$skipDelimiter = false;
if ( count( $fe_variable_stack_f7d54e3bf684e011bf56b2b03b8f70fb_15 ) ) extract( array_pop( $fe_variable_stack_f7d54e3bf684e011bf56b2b03b8f70fb_15 ) );

else
{

unset( $fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_15 );

unset( $fe_array_keys_f7d54e3bf684e011bf56b2b03b8f70fb_15 );

unset( $fe_n_items_f7d54e3bf684e011bf56b2b03b8f70fb_15 );

unset( $fe_n_items_processed_f7d54e3bf684e011bf56b2b03b8f70fb_15 );

unset( $fe_i_f7d54e3bf684e011bf56b2b03b8f70fb_15 );

unset( $fe_key_f7d54e3bf684e011bf56b2b03b8f70fb_15 );

unset( $fe_val_f7d54e3bf684e011bf56b2b03b8f70fb_15 );

unset( $fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_15 );

unset( $fe_max_f7d54e3bf684e011bf56b2b03b8f70fb_15 );

unset( $fe_reverse_f7d54e3bf684e011bf56b2b03b8f70fb_15 );

unset( $fe_first_val_f7d54e3bf684e011bf56b2b03b8f70fb_15 );

unset( $fe_last_val_f7d54e3bf684e011bf56b2b03b8f70fb_15 );

unset( $fe_variable_stack_f7d54e3bf684e011bf56b2b03b8f70fb_15 );

}

// foreach ends
$text .= '    ';
$fe_n_items_processed_f7d54e3bf684e011bf56b2b03b8f70fb_16++;
} // foreach
$skipDelimiter = false;
if ( count( $fe_variable_stack_f7d54e3bf684e011bf56b2b03b8f70fb_16 ) ) extract( array_pop( $fe_variable_stack_f7d54e3bf684e011bf56b2b03b8f70fb_16 ) );

else
{

unset( $fe_array_f7d54e3bf684e011bf56b2b03b8f70fb_16 );

unset( $fe_array_keys_f7d54e3bf684e011bf56b2b03b8f70fb_16 );

unset( $fe_n_items_f7d54e3bf684e011bf56b2b03b8f70fb_16 );

unset( $fe_n_items_processed_f7d54e3bf684e011bf56b2b03b8f70fb_16 );

unset( $fe_i_f7d54e3bf684e011bf56b2b03b8f70fb_16 );

unset( $fe_key_f7d54e3bf684e011bf56b2b03b8f70fb_16 );

unset( $fe_val_f7d54e3bf684e011bf56b2b03b8f70fb_16 );

unset( $fe_offset_f7d54e3bf684e011bf56b2b03b8f70fb_16 );

unset( $fe_max_f7d54e3bf684e011bf56b2b03b8f70fb_16 );

unset( $fe_reverse_f7d54e3bf684e011bf56b2b03b8f70fb_16 );

unset( $fe_first_val_f7d54e3bf684e011bf56b2b03b8f70fb_16 );

unset( $fe_last_val_f7d54e3bf684e011bf56b2b03b8f70fb_16 );

unset( $fe_variable_stack_f7d54e3bf684e011bf56b2b03b8f70fb_16 );

}

// foreach ends
$text .= '    ';
// undef $tr_class
$tpl->unsetLocalVariable( 'tr_class', $rootNamespace );

// undef $attr
$tpl->unsetLocalVariable( 'attr', $rootNamespace );

}
else
{
$text .= '    <tr><td>L\'elemento visualizzato non è in uso da nessun altro oggetto.</td></tr>';
}
unset( $if_cond );
// if ends

$text .= '</table>';
$oldRestoreIncludeArray_6a52c3951aa385cc9d63e0c2e9c8568b = isset( $restoreIncludeArray ) ? $restoreIncludeArray : array();
$restoreIncludeArray = array();

if ( isset( $namespace ) and isset( $vars[$namespace]['page_uri'] ) )
    $restoreIncludeArray[] = array( $namespace, 'page_uri', $vars[$namespace]['page_uri'] );
elseif ( !isset( $vars[( isset( $namespace ) ? $namespace : '' )]['page_uri'] ) ) 
    $restoreIncludeArray[] = array( ( isset( $namespace ) ? $namespace : '' ), 'page_uri', 'unset' );

unset( $var );
unset( $var );
$var = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'node', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['node'] : null;
$var1 = compiledFetchAttribute( $var, 'url_alias' );
unset( $var );
$var = $var1;
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
if ( isset( $namespace ) and isset( $vars[$namespace]['item_count'] ) )
    $restoreIncludeArray[] = array( $namespace, 'item_count', $vars[$namespace]['item_count'] );
elseif ( !isset( $vars[( isset( $namespace ) ? $namespace : '' )]['item_count'] ) ) 
    $restoreIncludeArray[] = array( ( isset( $namespace ) ? $namespace : '' ), 'item_count', 'unset' );

unset( $var );
unset( $var1 );
unset( $var1 );
$var1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'related_objects_count', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['related_objects_count'] : null;
if (! isset( $var1 ) ) $var1 = NULL;
while ( is_object( $var1 ) and method_exists( $var1, 'templateValue' ) )
    $var1 = $var1->templateValue();
while ( is_object( $var1 ) and method_exists( $var1, 'templateValue' ) )
    $var1 = $var1->templateValue();
unset( $var2 );
unset( $var2 );
$var2 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'reverse_related_objects_count', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['reverse_related_objects_count'] : null;
if (! isset( $var2 ) ) $var2 = NULL;
while ( is_object( $var2 ) and method_exists( $var2, 'templateValue' ) )
    $var2 = $var2->templateValue();
while ( is_object( $var2 ) and method_exists( $var2, 'templateValue' ) )
    $var2 = $var2->templateValue();
$var = max( $var1,  $var2);
unset( $var1, $var2 );
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
if ( isset( $namespace ) and isset( $vars[$namespace]['node_id'] ) )
    $restoreIncludeArray[] = array( $namespace, 'node_id', $vars[$namespace]['node_id'] );
elseif ( !isset( $vars[( isset( $namespace ) ? $namespace : '' )]['node_id'] ) ) 
    $restoreIncludeArray[] = array( ( isset( $namespace ) ? $namespace : '' ), 'node_id', 'unset' );

unset( $var );
unset( $var );
$var = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'node', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['node'] : null;
$var1 = compiledFetchAttribute( $var, 'node_id' );
unset( $var );
$var = $var1;
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
$namespace = $currentNamespace;
if ( $namespace == '' )
    $namespace = "navigator";
else
    $namespace .= ':navigator';
$vars[$namespace]['node_id'] = $var;
unset( $var );
if ( isset( $namespace ) and isset( $vars[$namespace]['item_limit'] ) )
    $restoreIncludeArray[] = array( $namespace, 'item_limit', $vars[$namespace]['item_limit'] );
elseif ( !isset( $vars[( isset( $namespace ) ? $namespace : '' )]['item_limit'] ) ) 
    $restoreIncludeArray[] = array( ( isset( $namespace ) ? $namespace : '' ), 'item_limit', 'unset' );

unset( $var );
unset( $var );
$var = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'page_limit', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['page_limit'] : null;
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
$restoreIncludeArray = $oldRestoreIncludeArray_6a52c3951aa385cc9d63e0c2e9c8568b;


$setArray = $oldSetArray_5a189767853adb572117405a936f7d98;
$tpl->Level--;
?>
