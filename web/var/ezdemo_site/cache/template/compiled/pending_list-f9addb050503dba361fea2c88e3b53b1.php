<?php
// URI:       design:dashboard/pending_list.tpl
// Filename:  design/standard/templates/dashboard/pending_list.tpl
// Timestamp: 1383940884 (Fri Nov 8 21:01:24 CET 2013)
$oldSetArray_84701436375a47598034d43f039478b4 = isset( $setArray ) ? $setArray : array();
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

$text .= '<h2>Le mie cose da fare</h2>
';
// if begins
unset( $if_cond );
$if_cond = call_user_func_array( array( new eZContentFunctionCollection(), 'fetchPendingCount' ),
  array(  ) );
$if_cond = isset( $if_cond['result'] ) ? $if_cond['result'] : null;
if (! isset( $if_cond ) ) $if_cond = NULL;
while ( is_object( $if_cond ) and method_exists( $if_cond, 'templateValue' ) )
    $if_cond = $if_cond->templateValue();

if ( $if_cond )
{
$text .= '
<table class="list" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <th>Nome</th>
        <th>Tipo</th>
        <th>Modificato il</th>
    </tr>
    ';
// foreach begins
$skipDelimiter = true;
// creating sequence variables for \{foreach} loop
$foreach_sequence_array_76b03f83fee18c6a663f9e494350bb39_2 = array (
  0 => 'bglight',
  1 => 'bgdark',
);
$foreach_sequence_var_76b03f83fee18c6a663f9e494350bb39_2 = current( $foreach_sequence_array_76b03f83fee18c6a663f9e494350bb39_2 );

if ( !isset( $fe_variable_stack_76b03f83fee18c6a663f9e494350bb39_2 ) ) $fe_variable_stack_76b03f83fee18c6a663f9e494350bb39_2 = array();
$fe_variable_stack_76b03f83fee18c6a663f9e494350bb39_2[] = compact( 'fe_array_76b03f83fee18c6a663f9e494350bb39_2', 'fe_array_keys_76b03f83fee18c6a663f9e494350bb39_2', 'fe_n_items_76b03f83fee18c6a663f9e494350bb39_2', 'fe_n_items_processed_76b03f83fee18c6a663f9e494350bb39_2', 'fe_i_76b03f83fee18c6a663f9e494350bb39_2', 'fe_key_76b03f83fee18c6a663f9e494350bb39_2', 'fe_val_76b03f83fee18c6a663f9e494350bb39_2', 'fe_offset_76b03f83fee18c6a663f9e494350bb39_2', 'fe_max_76b03f83fee18c6a663f9e494350bb39_2', 'fe_reverse_76b03f83fee18c6a663f9e494350bb39_2', 'fe_first_val_76b03f83fee18c6a663f9e494350bb39_2', 'fe_last_val_76b03f83fee18c6a663f9e494350bb39_2' );
unset( $fe_array_76b03f83fee18c6a663f9e494350bb39_2 );
unset( $fe_array_76b03f83fee18c6a663f9e494350bb39_21 );
unset( $fe_array_76b03f83fee18c6a663f9e494350bb39_21 );
$fe_array_76b03f83fee18c6a663f9e494350bb39_21 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'block', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['block'] : null;
$fe_array_76b03f83fee18c6a663f9e494350bb39_22 = compiledFetchAttribute( $fe_array_76b03f83fee18c6a663f9e494350bb39_21, 'number_of_items' );
unset( $fe_array_76b03f83fee18c6a663f9e494350bb39_21 );
$fe_array_76b03f83fee18c6a663f9e494350bb39_21 = $fe_array_76b03f83fee18c6a663f9e494350bb39_22;
if (! isset( $fe_array_76b03f83fee18c6a663f9e494350bb39_21 ) ) $fe_array_76b03f83fee18c6a663f9e494350bb39_21 = NULL;
while ( is_object( $fe_array_76b03f83fee18c6a663f9e494350bb39_21 ) and method_exists( $fe_array_76b03f83fee18c6a663f9e494350bb39_21, 'templateValue' ) )
    $fe_array_76b03f83fee18c6a663f9e494350bb39_21 = $fe_array_76b03f83fee18c6a663f9e494350bb39_21->templateValue();
while ( is_object( $fe_array_76b03f83fee18c6a663f9e494350bb39_21 ) and method_exists( $fe_array_76b03f83fee18c6a663f9e494350bb39_21, 'templateValue' ) )
    $fe_array_76b03f83fee18c6a663f9e494350bb39_21 = $fe_array_76b03f83fee18c6a663f9e494350bb39_21->templateValue();
$fe_array_76b03f83fee18c6a663f9e494350bb39_2 = call_user_func_array( array( new eZContentFunctionCollection(), 'fetchPendingList' ),
  array(     'offset' => false,
    'limit' => $fe_array_76b03f83fee18c6a663f9e494350bb39_21 ) );
$fe_array_76b03f83fee18c6a663f9e494350bb39_2 = isset( $fe_array_76b03f83fee18c6a663f9e494350bb39_2['result'] ) ? $fe_array_76b03f83fee18c6a663f9e494350bb39_2['result'] : null;
unset( $fe_array_76b03f83fee18c6a663f9e494350bb39_21 );
if (! isset( $fe_array_76b03f83fee18c6a663f9e494350bb39_2 ) ) $fe_array_76b03f83fee18c6a663f9e494350bb39_2 = NULL;
while ( is_object( $fe_array_76b03f83fee18c6a663f9e494350bb39_2 ) and method_exists( $fe_array_76b03f83fee18c6a663f9e494350bb39_2, 'templateValue' ) )
    $fe_array_76b03f83fee18c6a663f9e494350bb39_2 = $fe_array_76b03f83fee18c6a663f9e494350bb39_2->templateValue();

$fe_array_keys_76b03f83fee18c6a663f9e494350bb39_2 = is_array( $fe_array_76b03f83fee18c6a663f9e494350bb39_2 ) ? array_keys( $fe_array_76b03f83fee18c6a663f9e494350bb39_2 ) : array();
$fe_n_items_76b03f83fee18c6a663f9e494350bb39_2 = count( $fe_array_keys_76b03f83fee18c6a663f9e494350bb39_2 );
$fe_n_items_processed_76b03f83fee18c6a663f9e494350bb39_2 = 0;
$fe_offset_76b03f83fee18c6a663f9e494350bb39_2 = 0;
$fe_max_76b03f83fee18c6a663f9e494350bb39_2 = $fe_n_items_76b03f83fee18c6a663f9e494350bb39_2 - $fe_offset_76b03f83fee18c6a663f9e494350bb39_2;
$fe_reverse_76b03f83fee18c6a663f9e494350bb39_2 = false;
if ( $fe_offset_76b03f83fee18c6a663f9e494350bb39_2 < 0 || $fe_offset_76b03f83fee18c6a663f9e494350bb39_2 >= $fe_n_items_76b03f83fee18c6a663f9e494350bb39_2 )
{
    $fe_offset_76b03f83fee18c6a663f9e494350bb39_2 = ( $fe_offset_76b03f83fee18c6a663f9e494350bb39_2 < 0 ) ? 0 : $fe_n_items_76b03f83fee18c6a663f9e494350bb39_2;
    if ( $fe_n_items_76b03f83fee18c6a663f9e494350bb39_2 || $fe_offset_76b03f83fee18c6a663f9e494350bb39_2 < 0 )
 {
        eZDebug::writeWarning("Invalid 'offset' parameter specified: '$fe_offset_76b03f83fee18c6a663f9e494350bb39_2'. Array count: $fe_n_items_76b03f83fee18c6a663f9e494350bb39_2");   
}
}
if ( $fe_max_76b03f83fee18c6a663f9e494350bb39_2 < 0 || $fe_offset_76b03f83fee18c6a663f9e494350bb39_2 + $fe_max_76b03f83fee18c6a663f9e494350bb39_2 > $fe_n_items_76b03f83fee18c6a663f9e494350bb39_2 )
{
    if ( $fe_max_76b03f83fee18c6a663f9e494350bb39_2 < 0 )
 eZDebug::writeWarning("Invalid 'max' parameter specified: $fe_max_76b03f83fee18c6a663f9e494350bb39_2");
    $fe_max_76b03f83fee18c6a663f9e494350bb39_2 = $fe_n_items_76b03f83fee18c6a663f9e494350bb39_2 - $fe_offset_76b03f83fee18c6a663f9e494350bb39_2;
}
if ( $fe_reverse_76b03f83fee18c6a663f9e494350bb39_2 )
{
    $fe_first_val_76b03f83fee18c6a663f9e494350bb39_2 = $fe_n_items_76b03f83fee18c6a663f9e494350bb39_2 - 1 - $fe_offset_76b03f83fee18c6a663f9e494350bb39_2;
    $fe_last_val_76b03f83fee18c6a663f9e494350bb39_2  = 0;
}
else
{
    $fe_first_val_76b03f83fee18c6a663f9e494350bb39_2 = $fe_offset_76b03f83fee18c6a663f9e494350bb39_2;
    $fe_last_val_76b03f83fee18c6a663f9e494350bb39_2  = $fe_n_items_76b03f83fee18c6a663f9e494350bb39_2 - 1;
}
// foreach
for ( $fe_i_76b03f83fee18c6a663f9e494350bb39_2 = $fe_first_val_76b03f83fee18c6a663f9e494350bb39_2; $fe_n_items_processed_76b03f83fee18c6a663f9e494350bb39_2 < $fe_max_76b03f83fee18c6a663f9e494350bb39_2 && ( $fe_reverse_76b03f83fee18c6a663f9e494350bb39_2 ? $fe_i_76b03f83fee18c6a663f9e494350bb39_2 >= $fe_last_val_76b03f83fee18c6a663f9e494350bb39_2 : $fe_i_76b03f83fee18c6a663f9e494350bb39_2 <= $fe_last_val_76b03f83fee18c6a663f9e494350bb39_2 ); $fe_reverse_76b03f83fee18c6a663f9e494350bb39_2 ? $fe_i_76b03f83fee18c6a663f9e494350bb39_2-- : $fe_i_76b03f83fee18c6a663f9e494350bb39_2++ )
{
$fe_key_76b03f83fee18c6a663f9e494350bb39_2 = $fe_array_keys_76b03f83fee18c6a663f9e494350bb39_2[$fe_i_76b03f83fee18c6a663f9e494350bb39_2];
$fe_val_76b03f83fee18c6a663f9e494350bb39_2 = $fe_array_76b03f83fee18c6a663f9e494350bb39_2[$fe_key_76b03f83fee18c6a663f9e494350bb39_2];
$vars[$rootNamespace]['pending_item'] = $fe_val_76b03f83fee18c6a663f9e494350bb39_2;
// setting current sequence value
$vars[$rootNamespace]['style'] = $foreach_sequence_var_76b03f83fee18c6a663f9e494350bb39_2;
$text .= '        <tr class="';
unset( $var );
unset( $var );
$var = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'style', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['style'] : null;
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
$text .= ( is_object( $var ) ? compiledFetchText( $tpl, $rootNamespace, $currentNamespace, false, $var ) : $var );
unset( $var );

$text .= '">
            <td>
                <a href="';
unset( $var );
unset( $var1 );
unset( $var3 );
unset( $var3 );
$var3 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'pending_item', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['pending_item'] : null;
$var4 = compiledFetchAttribute( $var3, 'contentobject' );
unset( $var3 );
$var3 = $var4;
$var4 = compiledFetchAttribute( $var3, 'id' );
unset( $var3 );
$var3 = $var4;
if (! isset( $var3 ) ) $var3 = NULL;
while ( is_object( $var3 ) and method_exists( $var3, 'templateValue' ) )
    $var3 = $var3->templateValue();
while ( is_object( $var3 ) and method_exists( $var3, 'templateValue' ) )
    $var3 = $var3->templateValue();
unset( $var5 );
unset( $var5 );
$var5 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'pending_item', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['pending_item'] : null;
$var6 = compiledFetchAttribute( $var5, 'version' );
unset( $var5 );
$var5 = $var6;
if (! isset( $var5 ) ) $var5 = NULL;
while ( is_object( $var5 ) and method_exists( $var5, 'templateValue' ) )
    $var5 = $var5->templateValue();
while ( is_object( $var5 ) and method_exists( $var5, 'templateValue' ) )
    $var5 = $var5->templateValue();
$var1 = ( '/content/versionview/' . $var3 . '/' . $var5 . '/' );
unset( $var3, $var5 );
if (! isset( $var1 ) ) $var1 = NULL;
while ( is_object( $var1 ) and method_exists( $var1, 'templateValue' ) )
    $var1 = $var1->templateValue();

eZURI::transformURI( $var1, false, eZURI::getTransformURIMode() );
$var = $var1;
unset( $var1 );
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
$text .= $var;
unset( $var );

$text .= '">
                    ';
unset( $var );
unset( $var1 );
unset( $var1 );
$var1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'pending_item', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['pending_item'] : null;
$var2 = compiledFetchAttribute( $var1, 'version_name' );
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

$text .= '
                </a>
            </td>
            <td>
                ';
unset( $var );
unset( $var1 );
unset( $var1 );
$var1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'pending_item', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['pending_item'] : null;
$var2 = compiledFetchAttribute( $var1, 'contentobject' );
unset( $var1 );
$var1 = $var2;
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

$text .= '
            </td>
            <td>
                ';
unset( $var );
// l10nTransformation begin
$locale = eZLocale::instance();
// l10nTransformation: static
unset( $var1 );
unset( $var1 );
$var1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'pending_item', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['pending_item'] : null;
$var2 = compiledFetchAttribute( $var1, 'modified' );
unset( $var1 );
$var1 = $var2;
if (! isset( $var1 ) ) $var1 = NULL;
while ( is_object( $var1 ) and method_exists( $var1, 'templateValue' ) )
    $var1 = $var1->templateValue();
while ( is_object( $var1 ) and method_exists( $var1, 'templateValue' ) )
    $var1 = $var1->templateValue();
unset( $var2 );
if (! isset( $var2 ) ) $var2 = NULL;
while ( is_object( $var2 ) and method_exists( $var2, 'templateValue' ) )
    $var2 = $var2->templateValue();
while ( is_object( $var2 ) and method_exists( $var2, 'templateValue' ) )
    $var2 = $var2->templateValue();
unset( $var3 );
if (! isset( $var3 ) ) $var3 = NULL;
while ( is_object( $var3 ) and method_exists( $var3, 'templateValue' ) )
    $var3 = $var3->templateValue();
while ( is_object( $var3 ) and method_exists( $var3, 'templateValue' ) )
    $var3 = $var3->templateValue();

$var = $locale->formatShortDateTime( $var1 );
unset( $var1, $var2, $var3 );
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
$text .= $var;
unset( $var );

$text .= '
            </td>
        </tr>
    ';
// sequence iteration
if ( ( $foreach_sequence_var_76b03f83fee18c6a663f9e494350bb39_2 = next( $foreach_sequence_array_76b03f83fee18c6a663f9e494350bb39_2 ) ) === false )
{
   reset( $foreach_sequence_array_76b03f83fee18c6a663f9e494350bb39_2 );
   $foreach_sequence_var_76b03f83fee18c6a663f9e494350bb39_2 = current( $foreach_sequence_array_76b03f83fee18c6a663f9e494350bb39_2 );
}

$fe_n_items_processed_76b03f83fee18c6a663f9e494350bb39_2++;
} // foreach
unset( $foreach_sequence_array_76b03f83fee18c6a663f9e494350bb39_2 );

unset( $foreach_sequence_var_76b03f83fee18c6a663f9e494350bb39_2 );

unset( $vars[$rootNamespace]['style'] );
$skipDelimiter = false;
if ( count( $fe_variable_stack_76b03f83fee18c6a663f9e494350bb39_2 ) ) extract( array_pop( $fe_variable_stack_76b03f83fee18c6a663f9e494350bb39_2 ) );

else
{

unset( $fe_array_76b03f83fee18c6a663f9e494350bb39_2 );

unset( $fe_array_keys_76b03f83fee18c6a663f9e494350bb39_2 );

unset( $fe_n_items_76b03f83fee18c6a663f9e494350bb39_2 );

unset( $fe_n_items_processed_76b03f83fee18c6a663f9e494350bb39_2 );

unset( $fe_i_76b03f83fee18c6a663f9e494350bb39_2 );

unset( $fe_key_76b03f83fee18c6a663f9e494350bb39_2 );

unset( $fe_val_76b03f83fee18c6a663f9e494350bb39_2 );

unset( $fe_offset_76b03f83fee18c6a663f9e494350bb39_2 );

unset( $fe_max_76b03f83fee18c6a663f9e494350bb39_2 );

unset( $fe_reverse_76b03f83fee18c6a663f9e494350bb39_2 );

unset( $fe_first_val_76b03f83fee18c6a663f9e494350bb39_2 );

unset( $fe_last_val_76b03f83fee18c6a663f9e494350bb39_2 );

unset( $fe_variable_stack_76b03f83fee18c6a663f9e494350bb39_2 );

}

// foreach ends
$text .= '</table>
';
}
else
{
$text .= '
<p>Al momento non hai alcuna cosa da fare disponibile.</p>
';
}
unset( $if_cond );
// if ends


$setArray = $oldSetArray_84701436375a47598034d43f039478b4;
$tpl->Level--;
?>
