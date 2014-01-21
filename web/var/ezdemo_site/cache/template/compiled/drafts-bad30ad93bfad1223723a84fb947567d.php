<?php
// URI:       design:dashboard/drafts.tpl
// Filename:  design/standard/templates/dashboard/drafts.tpl
// Timestamp: 1383940884 (Fri Nov 8 21:01:24 CET 2013)
$oldSetArray_dc847eadb4d4e7d97467404366096220 = isset( $setArray ) ? $setArray : array();
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

$text .= '<h2>Le mie bozze</h2>
';
// if begins
unset( $if_cond );
$if_cond = call_user_func_array( array( new eZContentFunctionCollection(), 'fetchDraftVersionCount' ),
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
        <th>Versione</th>
        <th>Modificato il</th>
        <th class="tight"></th>
    </tr>
    ';
// foreach begins
$skipDelimiter = true;
// creating sequence variables for \{foreach} loop
$foreach_sequence_array_82428289fabf5adc3029aae7cf01c4c5_3 = array (
  0 => 'bglight',
  1 => 'bgdark',
);
$foreach_sequence_var_82428289fabf5adc3029aae7cf01c4c5_3 = current( $foreach_sequence_array_82428289fabf5adc3029aae7cf01c4c5_3 );

if ( !isset( $fe_variable_stack_82428289fabf5adc3029aae7cf01c4c5_3 ) ) $fe_variable_stack_82428289fabf5adc3029aae7cf01c4c5_3 = array();
$fe_variable_stack_82428289fabf5adc3029aae7cf01c4c5_3[] = compact( 'fe_array_82428289fabf5adc3029aae7cf01c4c5_3', 'fe_array_keys_82428289fabf5adc3029aae7cf01c4c5_3', 'fe_n_items_82428289fabf5adc3029aae7cf01c4c5_3', 'fe_n_items_processed_82428289fabf5adc3029aae7cf01c4c5_3', 'fe_i_82428289fabf5adc3029aae7cf01c4c5_3', 'fe_key_82428289fabf5adc3029aae7cf01c4c5_3', 'fe_val_82428289fabf5adc3029aae7cf01c4c5_3', 'fe_offset_82428289fabf5adc3029aae7cf01c4c5_3', 'fe_max_82428289fabf5adc3029aae7cf01c4c5_3', 'fe_reverse_82428289fabf5adc3029aae7cf01c4c5_3', 'fe_first_val_82428289fabf5adc3029aae7cf01c4c5_3', 'fe_last_val_82428289fabf5adc3029aae7cf01c4c5_3' );
unset( $fe_array_82428289fabf5adc3029aae7cf01c4c5_3 );
unset( $fe_array_82428289fabf5adc3029aae7cf01c4c5_31 );
unset( $fe_array_82428289fabf5adc3029aae7cf01c4c5_31 );
$fe_array_82428289fabf5adc3029aae7cf01c4c5_31 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'block', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['block'] : null;
$fe_array_82428289fabf5adc3029aae7cf01c4c5_32 = compiledFetchAttribute( $fe_array_82428289fabf5adc3029aae7cf01c4c5_31, 'number_of_items' );
unset( $fe_array_82428289fabf5adc3029aae7cf01c4c5_31 );
$fe_array_82428289fabf5adc3029aae7cf01c4c5_31 = $fe_array_82428289fabf5adc3029aae7cf01c4c5_32;
if (! isset( $fe_array_82428289fabf5adc3029aae7cf01c4c5_31 ) ) $fe_array_82428289fabf5adc3029aae7cf01c4c5_31 = NULL;
while ( is_object( $fe_array_82428289fabf5adc3029aae7cf01c4c5_31 ) and method_exists( $fe_array_82428289fabf5adc3029aae7cf01c4c5_31, 'templateValue' ) )
    $fe_array_82428289fabf5adc3029aae7cf01c4c5_31 = $fe_array_82428289fabf5adc3029aae7cf01c4c5_31->templateValue();
while ( is_object( $fe_array_82428289fabf5adc3029aae7cf01c4c5_31 ) and method_exists( $fe_array_82428289fabf5adc3029aae7cf01c4c5_31, 'templateValue' ) )
    $fe_array_82428289fabf5adc3029aae7cf01c4c5_31 = $fe_array_82428289fabf5adc3029aae7cf01c4c5_31->templateValue();
$fe_array_82428289fabf5adc3029aae7cf01c4c5_3 = call_user_func_array( array( new eZContentFunctionCollection(), 'fetchDraftVersionList' ),
  array(     'offset' => false,
    'limit' => $fe_array_82428289fabf5adc3029aae7cf01c4c5_31 ) );
$fe_array_82428289fabf5adc3029aae7cf01c4c5_3 = isset( $fe_array_82428289fabf5adc3029aae7cf01c4c5_3['result'] ) ? $fe_array_82428289fabf5adc3029aae7cf01c4c5_3['result'] : null;
unset( $fe_array_82428289fabf5adc3029aae7cf01c4c5_31 );
if (! isset( $fe_array_82428289fabf5adc3029aae7cf01c4c5_3 ) ) $fe_array_82428289fabf5adc3029aae7cf01c4c5_3 = NULL;
while ( is_object( $fe_array_82428289fabf5adc3029aae7cf01c4c5_3 ) and method_exists( $fe_array_82428289fabf5adc3029aae7cf01c4c5_3, 'templateValue' ) )
    $fe_array_82428289fabf5adc3029aae7cf01c4c5_3 = $fe_array_82428289fabf5adc3029aae7cf01c4c5_3->templateValue();

$fe_array_keys_82428289fabf5adc3029aae7cf01c4c5_3 = is_array( $fe_array_82428289fabf5adc3029aae7cf01c4c5_3 ) ? array_keys( $fe_array_82428289fabf5adc3029aae7cf01c4c5_3 ) : array();
$fe_n_items_82428289fabf5adc3029aae7cf01c4c5_3 = count( $fe_array_keys_82428289fabf5adc3029aae7cf01c4c5_3 );
$fe_n_items_processed_82428289fabf5adc3029aae7cf01c4c5_3 = 0;
$fe_offset_82428289fabf5adc3029aae7cf01c4c5_3 = 0;
$fe_max_82428289fabf5adc3029aae7cf01c4c5_3 = $fe_n_items_82428289fabf5adc3029aae7cf01c4c5_3 - $fe_offset_82428289fabf5adc3029aae7cf01c4c5_3;
$fe_reverse_82428289fabf5adc3029aae7cf01c4c5_3 = false;
if ( $fe_offset_82428289fabf5adc3029aae7cf01c4c5_3 < 0 || $fe_offset_82428289fabf5adc3029aae7cf01c4c5_3 >= $fe_n_items_82428289fabf5adc3029aae7cf01c4c5_3 )
{
    $fe_offset_82428289fabf5adc3029aae7cf01c4c5_3 = ( $fe_offset_82428289fabf5adc3029aae7cf01c4c5_3 < 0 ) ? 0 : $fe_n_items_82428289fabf5adc3029aae7cf01c4c5_3;
    if ( $fe_n_items_82428289fabf5adc3029aae7cf01c4c5_3 || $fe_offset_82428289fabf5adc3029aae7cf01c4c5_3 < 0 )
 {
        eZDebug::writeWarning("Invalid 'offset' parameter specified: '$fe_offset_82428289fabf5adc3029aae7cf01c4c5_3'. Array count: $fe_n_items_82428289fabf5adc3029aae7cf01c4c5_3");   
}
}
if ( $fe_max_82428289fabf5adc3029aae7cf01c4c5_3 < 0 || $fe_offset_82428289fabf5adc3029aae7cf01c4c5_3 + $fe_max_82428289fabf5adc3029aae7cf01c4c5_3 > $fe_n_items_82428289fabf5adc3029aae7cf01c4c5_3 )
{
    if ( $fe_max_82428289fabf5adc3029aae7cf01c4c5_3 < 0 )
 eZDebug::writeWarning("Invalid 'max' parameter specified: $fe_max_82428289fabf5adc3029aae7cf01c4c5_3");
    $fe_max_82428289fabf5adc3029aae7cf01c4c5_3 = $fe_n_items_82428289fabf5adc3029aae7cf01c4c5_3 - $fe_offset_82428289fabf5adc3029aae7cf01c4c5_3;
}
if ( $fe_reverse_82428289fabf5adc3029aae7cf01c4c5_3 )
{
    $fe_first_val_82428289fabf5adc3029aae7cf01c4c5_3 = $fe_n_items_82428289fabf5adc3029aae7cf01c4c5_3 - 1 - $fe_offset_82428289fabf5adc3029aae7cf01c4c5_3;
    $fe_last_val_82428289fabf5adc3029aae7cf01c4c5_3  = 0;
}
else
{
    $fe_first_val_82428289fabf5adc3029aae7cf01c4c5_3 = $fe_offset_82428289fabf5adc3029aae7cf01c4c5_3;
    $fe_last_val_82428289fabf5adc3029aae7cf01c4c5_3  = $fe_n_items_82428289fabf5adc3029aae7cf01c4c5_3 - 1;
}
// foreach
for ( $fe_i_82428289fabf5adc3029aae7cf01c4c5_3 = $fe_first_val_82428289fabf5adc3029aae7cf01c4c5_3; $fe_n_items_processed_82428289fabf5adc3029aae7cf01c4c5_3 < $fe_max_82428289fabf5adc3029aae7cf01c4c5_3 && ( $fe_reverse_82428289fabf5adc3029aae7cf01c4c5_3 ? $fe_i_82428289fabf5adc3029aae7cf01c4c5_3 >= $fe_last_val_82428289fabf5adc3029aae7cf01c4c5_3 : $fe_i_82428289fabf5adc3029aae7cf01c4c5_3 <= $fe_last_val_82428289fabf5adc3029aae7cf01c4c5_3 ); $fe_reverse_82428289fabf5adc3029aae7cf01c4c5_3 ? $fe_i_82428289fabf5adc3029aae7cf01c4c5_3-- : $fe_i_82428289fabf5adc3029aae7cf01c4c5_3++ )
{
$fe_key_82428289fabf5adc3029aae7cf01c4c5_3 = $fe_array_keys_82428289fabf5adc3029aae7cf01c4c5_3[$fe_i_82428289fabf5adc3029aae7cf01c4c5_3];
$fe_val_82428289fabf5adc3029aae7cf01c4c5_3 = $fe_array_82428289fabf5adc3029aae7cf01c4c5_3[$fe_key_82428289fabf5adc3029aae7cf01c4c5_3];
$vars[$rootNamespace]['draft'] = $fe_val_82428289fabf5adc3029aae7cf01c4c5_3;
// setting current sequence value
$vars[$rootNamespace]['style'] = $foreach_sequence_var_82428289fabf5adc3029aae7cf01c4c5_3;
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
$var3 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'draft', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['draft'] : null;
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
$var5 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'draft', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['draft'] : null;
$var6 = compiledFetchAttribute( $var5, 'version' );
unset( $var5 );
$var5 = $var6;
if (! isset( $var5 ) ) $var5 = NULL;
while ( is_object( $var5 ) and method_exists( $var5, 'templateValue' ) )
    $var5 = $var5->templateValue();
while ( is_object( $var5 ) and method_exists( $var5, 'templateValue' ) )
    $var5 = $var5->templateValue();
unset( $var7 );
unset( $var7 );
$var7 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'draft', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['draft'] : null;
$var8 = compiledFetchAttribute( $var7, 'initial_language' );
unset( $var7 );
$var7 = $var8;
$var8 = compiledFetchAttribute( $var7, 'locale' );
unset( $var7 );
$var7 = $var8;
if (! isset( $var7 ) ) $var7 = NULL;
while ( is_object( $var7 ) and method_exists( $var7, 'templateValue' ) )
    $var7 = $var7->templateValue();
while ( is_object( $var7 ) and method_exists( $var7, 'templateValue' ) )
    $var7 = $var7->templateValue();
$var1 = ( '/content/versionview/' . $var3 . '/' . $var5 . '/' . $var7 . '/' );
unset( $var3, $var5, $var7 );
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

$text .= '" title="';
unset( $var );
unset( $var1 );
unset( $var1 );
$var1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'draft', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['draft'] : null;
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

$text .= '">
                    ';
unset( $var );
unset( $var1 );
unset( $var1 );
$var1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'draft', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['draft'] : null;
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
                </a>
            </td>
            <td>
                ';
unset( $var );
unset( $var1 );
unset( $var1 );
$var1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'draft', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['draft'] : null;
$var2 = compiledFetchAttribute( $var1, 'contentobject' );
unset( $var1 );
$var1 = $var2;
$var2 = compiledFetchAttribute( $var1, 'class_name' );
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
unset( $var );
$var = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'draft', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['draft'] : null;
$var1 = compiledFetchAttribute( $var, 'version' );
unset( $var );
$var = $var1;
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
$text .= ( is_object( $var ) ? compiledFetchText( $tpl, $rootNamespace, $currentNamespace, false, $var ) : $var );
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
$var1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'draft', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['draft'] : null;
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
            <td>
                <a href="';
unset( $var );
unset( $var1 );
unset( $var3 );
unset( $var3 );
$var3 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'draft', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['draft'] : null;
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
$var5 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'draft', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['draft'] : null;
$var6 = compiledFetchAttribute( $var5, 'version' );
unset( $var5 );
$var5 = $var6;
if (! isset( $var5 ) ) $var5 = NULL;
while ( is_object( $var5 ) and method_exists( $var5, 'templateValue' ) )
    $var5 = $var5->templateValue();
while ( is_object( $var5 ) and method_exists( $var5, 'templateValue' ) )
    $var5 = $var5->templateValue();
$var1 = ( '/content/edit/' . $var3 . '/' . $var5 );
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

$text .= '" title="';
unset( $var );
unset( $var1 );
unset( $var3 );
unset( $var4 );
unset( $var4 );
$var4 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'draft', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['draft'] : null;
$var5 = compiledFetchAttribute( $var4, 'name' );
unset( $var4 );
$var4 = $var5;
if (! isset( $var4 ) ) $var4 = NULL;
while ( is_object( $var4 ) and method_exists( $var4, 'templateValue' ) )
    $var4 = $var4->templateValue();
$var3 = array( '%draft_name' => $var4 );unset( $var4 );
if (! isset( $var3 ) ) $var3 = NULL;
while ( is_object( $var3 ) and method_exists( $var3, 'templateValue' ) )
    $var3 = $var3->templateValue();
$var4 = array();
foreach ( $var3 as $var5 => $var6 )
{
  if ( is_int( $var5 ) )
    $var4['%' . ( ($var5%9) + 1 )] = $var6;
  else
    $var4[$var5] = $var6;
}
$var1 = strtr( 'Modifica <%draft_name>.', $var4 );
unset( $var3, $var4, $var5, $var6 );
if (! isset( $var1 ) ) $var1 = NULL;
while ( is_object( $var1 ) and method_exists( $var1, 'templateValue' ) )
    $var1 = $var1->templateValue();
$var = htmlspecialchars( $var1 );
unset( $var1 );
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
$text .= $var;
unset( $var );

$text .= '">
                    <img src="/extension/ezdemo/design/ezdemo/images/edit.gif" width="16" height="16" border="0" alt="Modifica" />
                </a>
            </td>
        </tr>
    ';
// sequence iteration
if ( ( $foreach_sequence_var_82428289fabf5adc3029aae7cf01c4c5_3 = next( $foreach_sequence_array_82428289fabf5adc3029aae7cf01c4c5_3 ) ) === false )
{
   reset( $foreach_sequence_array_82428289fabf5adc3029aae7cf01c4c5_3 );
   $foreach_sequence_var_82428289fabf5adc3029aae7cf01c4c5_3 = current( $foreach_sequence_array_82428289fabf5adc3029aae7cf01c4c5_3 );
}

$fe_n_items_processed_82428289fabf5adc3029aae7cf01c4c5_3++;
} // foreach
unset( $foreach_sequence_array_82428289fabf5adc3029aae7cf01c4c5_3 );

unset( $foreach_sequence_var_82428289fabf5adc3029aae7cf01c4c5_3 );

unset( $vars[$rootNamespace]['style'] );
$skipDelimiter = false;
if ( count( $fe_variable_stack_82428289fabf5adc3029aae7cf01c4c5_3 ) ) extract( array_pop( $fe_variable_stack_82428289fabf5adc3029aae7cf01c4c5_3 ) );

else
{

unset( $fe_array_82428289fabf5adc3029aae7cf01c4c5_3 );

unset( $fe_array_keys_82428289fabf5adc3029aae7cf01c4c5_3 );

unset( $fe_n_items_82428289fabf5adc3029aae7cf01c4c5_3 );

unset( $fe_n_items_processed_82428289fabf5adc3029aae7cf01c4c5_3 );

unset( $fe_i_82428289fabf5adc3029aae7cf01c4c5_3 );

unset( $fe_key_82428289fabf5adc3029aae7cf01c4c5_3 );

unset( $fe_val_82428289fabf5adc3029aae7cf01c4c5_3 );

unset( $fe_offset_82428289fabf5adc3029aae7cf01c4c5_3 );

unset( $fe_max_82428289fabf5adc3029aae7cf01c4c5_3 );

unset( $fe_reverse_82428289fabf5adc3029aae7cf01c4c5_3 );

unset( $fe_first_val_82428289fabf5adc3029aae7cf01c4c5_3 );

unset( $fe_last_val_82428289fabf5adc3029aae7cf01c4c5_3 );

unset( $fe_variable_stack_82428289fabf5adc3029aae7cf01c4c5_3 );

}

// foreach ends
$text .= '</table>
';
}
else
{
$text .= '
Al momento non hai alcuna bozza disponibile.
';
}
unset( $if_cond );
// if ends


$setArray = $oldSetArray_dc847eadb4d4e7d97467404366096220;
$tpl->Level--;
?>
