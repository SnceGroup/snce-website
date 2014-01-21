<?php
// URI:       design:content/dashboard.tpl
// Filename:  design/admin/templates/content/dashboard.tpl
// Timestamp: 1383940876 (Fri Nov 8 21:01:16 CET 2013)
$oldSetArray_20ce99b165b5f64f2deb945fa758ceaa = isset( $setArray ) ? $setArray : array();
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

<div class="context-block content-dashboard">
    
<div class="box-header">
    ';
$oldRestoreIncludeArray_c7050f8208a5f4f43cffa1b330c40f9e = isset( $restoreIncludeArray ) ? $restoreIncludeArray : array();
$restoreIncludeArray = array();

if ( !isset( $dKeys ) )
{
    $resH = $tpl->resourceHandler( "design" );
    $dKeys = $resH->keys();
}

$resourceFound = false;
if ( file_exists( 'var/ezdemo_site/cache/template/compiled/maintenance-308eb1e321fb550ed3e977c0e74add35.php' ) )
{
$resourceFound = true;
$namespaceStack[] = array( $rootNamespace, $currentNamespace );
$rootNamespace = $currentNamespace;
$tpl->createLocalVariablesList();
$tpl->appendTemplateFetch( 'extension/ez_network/design/admin2/templates/dashboard/maintenance.tpl' );
include( '' . 'var/ezdemo_site/cache/template/compiled/maintenance-308eb1e321fb550ed3e977c0e74add35.php' );
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
$tpl->processURI( 'extension/ez_network/design/admin2/templates/dashboard/maintenance.tpl', true, $extraParameters, $textElements, $rootNamespace, $currentNamespace );
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
$restoreIncludeArray = $oldRestoreIncludeArray_c7050f8208a5f4f43cffa1b330c40f9e;

$text .= '</div>


<div class="box-bc"><div class="box-ml"><div class="box-mr"><div class="box-bl"><div class="box-br"><div class="box-content">

<div class="block">';
// def $right_blocks
if ( $tpl->hasVariable( 'right_blocks', $rootNamespace ) )
{
    $tpl->warning( 'def', "Variable 'right_blocks' is already defined.", array (
  0 => 
  array (
    0 => 13,
    1 => 0,
    2 => 386,
  ),
  1 => 
  array (
    0 => 13,
    1 => 27,
    2 => 413,
  ),
  2 => 'design/admin/templates/content/dashboard.tpl',
) );
    $tpl->setVariable( 'right_blocks', array (
), $rootNamespace );
}
else
{
    $tpl->setLocalVariable( 'right_blocks', array (
), $rootNamespace );
}

$text .= '
<div class="left">';
// foreach begins
$skipDelimiter = true;
// creating sequence variables for \{foreach} loop
$foreach_sequence_array_6b35ca682f1f6af7815a0888f9895ba7_1 = array (
  0 => 'left',
  1 => 'right',
);
$foreach_sequence_var_6b35ca682f1f6af7815a0888f9895ba7_1 = current( $foreach_sequence_array_6b35ca682f1f6af7815a0888f9895ba7_1 );

if ( !isset( $fe_variable_stack_6b35ca682f1f6af7815a0888f9895ba7_1 ) ) $fe_variable_stack_6b35ca682f1f6af7815a0888f9895ba7_1 = array();
$fe_variable_stack_6b35ca682f1f6af7815a0888f9895ba7_1[] = compact( 'fe_array_6b35ca682f1f6af7815a0888f9895ba7_1', 'fe_array_keys_6b35ca682f1f6af7815a0888f9895ba7_1', 'fe_n_items_6b35ca682f1f6af7815a0888f9895ba7_1', 'fe_n_items_processed_6b35ca682f1f6af7815a0888f9895ba7_1', 'fe_i_6b35ca682f1f6af7815a0888f9895ba7_1', 'fe_key_6b35ca682f1f6af7815a0888f9895ba7_1', 'fe_val_6b35ca682f1f6af7815a0888f9895ba7_1', 'fe_offset_6b35ca682f1f6af7815a0888f9895ba7_1', 'fe_max_6b35ca682f1f6af7815a0888f9895ba7_1', 'fe_reverse_6b35ca682f1f6af7815a0888f9895ba7_1', 'fe_first_val_6b35ca682f1f6af7815a0888f9895ba7_1', 'fe_last_val_6b35ca682f1f6af7815a0888f9895ba7_1' );
unset( $fe_array_6b35ca682f1f6af7815a0888f9895ba7_1 );
unset( $fe_array_6b35ca682f1f6af7815a0888f9895ba7_1 );
$fe_array_6b35ca682f1f6af7815a0888f9895ba7_1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'blocks', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['blocks'] : null;
if (! isset( $fe_array_6b35ca682f1f6af7815a0888f9895ba7_1 ) ) $fe_array_6b35ca682f1f6af7815a0888f9895ba7_1 = NULL;
while ( is_object( $fe_array_6b35ca682f1f6af7815a0888f9895ba7_1 ) and method_exists( $fe_array_6b35ca682f1f6af7815a0888f9895ba7_1, 'templateValue' ) )
    $fe_array_6b35ca682f1f6af7815a0888f9895ba7_1 = $fe_array_6b35ca682f1f6af7815a0888f9895ba7_1->templateValue();

$fe_array_keys_6b35ca682f1f6af7815a0888f9895ba7_1 = is_array( $fe_array_6b35ca682f1f6af7815a0888f9895ba7_1 ) ? array_keys( $fe_array_6b35ca682f1f6af7815a0888f9895ba7_1 ) : array();
$fe_n_items_6b35ca682f1f6af7815a0888f9895ba7_1 = count( $fe_array_keys_6b35ca682f1f6af7815a0888f9895ba7_1 );
$fe_n_items_processed_6b35ca682f1f6af7815a0888f9895ba7_1 = 0;
$fe_offset_6b35ca682f1f6af7815a0888f9895ba7_1 = 0;
$fe_max_6b35ca682f1f6af7815a0888f9895ba7_1 = $fe_n_items_6b35ca682f1f6af7815a0888f9895ba7_1 - $fe_offset_6b35ca682f1f6af7815a0888f9895ba7_1;
$fe_reverse_6b35ca682f1f6af7815a0888f9895ba7_1 = false;
if ( $fe_offset_6b35ca682f1f6af7815a0888f9895ba7_1 < 0 || $fe_offset_6b35ca682f1f6af7815a0888f9895ba7_1 >= $fe_n_items_6b35ca682f1f6af7815a0888f9895ba7_1 )
{
    $fe_offset_6b35ca682f1f6af7815a0888f9895ba7_1 = ( $fe_offset_6b35ca682f1f6af7815a0888f9895ba7_1 < 0 ) ? 0 : $fe_n_items_6b35ca682f1f6af7815a0888f9895ba7_1;
    if ( $fe_n_items_6b35ca682f1f6af7815a0888f9895ba7_1 || $fe_offset_6b35ca682f1f6af7815a0888f9895ba7_1 < 0 )
 {
        eZDebug::writeWarning("Invalid 'offset' parameter specified: '$fe_offset_6b35ca682f1f6af7815a0888f9895ba7_1'. Array count: $fe_n_items_6b35ca682f1f6af7815a0888f9895ba7_1");   
}
}
if ( $fe_max_6b35ca682f1f6af7815a0888f9895ba7_1 < 0 || $fe_offset_6b35ca682f1f6af7815a0888f9895ba7_1 + $fe_max_6b35ca682f1f6af7815a0888f9895ba7_1 > $fe_n_items_6b35ca682f1f6af7815a0888f9895ba7_1 )
{
    if ( $fe_max_6b35ca682f1f6af7815a0888f9895ba7_1 < 0 )
 eZDebug::writeWarning("Invalid 'max' parameter specified: $fe_max_6b35ca682f1f6af7815a0888f9895ba7_1");
    $fe_max_6b35ca682f1f6af7815a0888f9895ba7_1 = $fe_n_items_6b35ca682f1f6af7815a0888f9895ba7_1 - $fe_offset_6b35ca682f1f6af7815a0888f9895ba7_1;
}
if ( $fe_reverse_6b35ca682f1f6af7815a0888f9895ba7_1 )
{
    $fe_first_val_6b35ca682f1f6af7815a0888f9895ba7_1 = $fe_n_items_6b35ca682f1f6af7815a0888f9895ba7_1 - 1 - $fe_offset_6b35ca682f1f6af7815a0888f9895ba7_1;
    $fe_last_val_6b35ca682f1f6af7815a0888f9895ba7_1  = 0;
}
else
{
    $fe_first_val_6b35ca682f1f6af7815a0888f9895ba7_1 = $fe_offset_6b35ca682f1f6af7815a0888f9895ba7_1;
    $fe_last_val_6b35ca682f1f6af7815a0888f9895ba7_1  = $fe_n_items_6b35ca682f1f6af7815a0888f9895ba7_1 - 1;
}
// foreach
for ( $fe_i_6b35ca682f1f6af7815a0888f9895ba7_1 = $fe_first_val_6b35ca682f1f6af7815a0888f9895ba7_1; $fe_n_items_processed_6b35ca682f1f6af7815a0888f9895ba7_1 < $fe_max_6b35ca682f1f6af7815a0888f9895ba7_1 && ( $fe_reverse_6b35ca682f1f6af7815a0888f9895ba7_1 ? $fe_i_6b35ca682f1f6af7815a0888f9895ba7_1 >= $fe_last_val_6b35ca682f1f6af7815a0888f9895ba7_1 : $fe_i_6b35ca682f1f6af7815a0888f9895ba7_1 <= $fe_last_val_6b35ca682f1f6af7815a0888f9895ba7_1 ); $fe_reverse_6b35ca682f1f6af7815a0888f9895ba7_1 ? $fe_i_6b35ca682f1f6af7815a0888f9895ba7_1-- : $fe_i_6b35ca682f1f6af7815a0888f9895ba7_1++ )
{
$fe_key_6b35ca682f1f6af7815a0888f9895ba7_1 = $fe_array_keys_6b35ca682f1f6af7815a0888f9895ba7_1[$fe_i_6b35ca682f1f6af7815a0888f9895ba7_1];
$fe_val_6b35ca682f1f6af7815a0888f9895ba7_1 = $fe_array_6b35ca682f1f6af7815a0888f9895ba7_1[$fe_key_6b35ca682f1f6af7815a0888f9895ba7_1];
$vars[$rootNamespace]['block'] = $fe_val_6b35ca682f1f6af7815a0888f9895ba7_1;
// setting current sequence value
$vars[$rootNamespace]['position'] = $foreach_sequence_var_6b35ca682f1f6af7815a0888f9895ba7_1;
$text .= '  
  ';
// if begins
unset( $if_cond );
unset( $if_cond1 );
unset( $if_cond1 );
$if_cond1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'position', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['position'] : null;
if (! isset( $if_cond1 ) ) $if_cond1 = NULL;
while ( is_object( $if_cond1 ) and method_exists( $if_cond1, 'templateValue' ) )
    $if_cond1 = $if_cond1->templateValue();
$if_cond = ( ( $if_cond1 ) == ( 'left' ) );
unset( $if_cond1 );
if (! isset( $if_cond ) ) $if_cond = NULL;
while ( is_object( $if_cond ) and method_exists( $if_cond, 'templateValue' ) )
    $if_cond = $if_cond->templateValue();

if ( $if_cond )
{
$text .= '  <div class="dashboard-item">
    ';
// if begins
unset( $if_cond );
unset( $if_cond );
$if_cond = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'block', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['block'] : null;
$if_cond1 = compiledFetchAttribute( $if_cond, 'template' );
unset( $if_cond );
$if_cond = $if_cond1;
if (! isset( $if_cond ) ) $if_cond = NULL;
while ( is_object( $if_cond ) and method_exists( $if_cond, 'templateValue' ) )
    $if_cond = $if_cond->templateValue();

if ( $if_cond )
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
            1 => 'design:',
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
              2 => 'block',
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
                1 => 'template',
                2 => false,
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
                       array (
  0 => 
  array (
    0 => 21,
    1 => 8,
    2 => 606,
  ),
  1 => 
  array (
    0 => 21,
    1 => 56,
    2 => 654,
  ),
  2 => 'design/admin/templates/content/dashboard.tpl',
),
                       $rootNamespace, $currentNamespace );
$text .= implode( '', $textElements );

$text .= '    ';
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
            1 => 'design:dashboard/',
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
              2 => 'block',
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
                1 => 'identifier',
                2 => false,
              ),
            ),
            2 => false,
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            0 => 1,
            1 => '.tpl',
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
    0 => 23,
    1 => 8,
    2 => 676,
  ),
  1 => 
  array (
    0 => 23,
    1 => 76,
    2 => 744,
  ),
  2 => 'design/admin/templates/content/dashboard.tpl',
),
                       $rootNamespace, $currentNamespace );
$text .= implode( '', $textElements );

$text .= '    ';
}
unset( $if_cond );
// if ends

$text .= '  </div>
  ';
}
else
{
$text .= '	';
if ( !isset( $textStack ) )
    $textStack = array();
$textStack[] = $text;
$text = '';
$text .= '	<div class="dashboard-item">
	    ';
// if begins
unset( $if_cond );
unset( $if_cond );
$if_cond = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'block', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['block'] : null;
$if_cond1 = compiledFetchAttribute( $if_cond, 'template' );
unset( $if_cond );
$if_cond = $if_cond1;
if (! isset( $if_cond ) ) $if_cond = NULL;
while ( is_object( $if_cond ) and method_exists( $if_cond, 'templateValue' ) )
    $if_cond = $if_cond->templateValue();

if ( $if_cond )
{
$text .= '	        ';
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
            1 => 'design:',
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
              2 => 'block',
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
                1 => 'template',
                2 => false,
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
                       array (
  0 => 
  array (
    0 => 30,
    1 => 9,
    2 => 879,
  ),
  1 => 
  array (
    0 => 30,
    1 => 57,
    2 => 927,
  ),
  2 => 'design/admin/templates/content/dashboard.tpl',
),
                       $rootNamespace, $currentNamespace );
$text .= implode( '', $textElements );

$text .= '	    ';
}
else
{
$text .= '	        ';
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
            1 => 'design:dashboard/',
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
              2 => 'block',
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
                1 => 'identifier',
                2 => false,
              ),
            ),
            2 => false,
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            0 => 1,
            1 => '.tpl',
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
    0 => 32,
    1 => 9,
    2 => 951,
  ),
  1 => 
  array (
    0 => 32,
    1 => 77,
    2 => 1019,
  ),
  2 => 'design/admin/templates/content/dashboard.tpl',
),
                       $rootNamespace, $currentNamespace );
$text .= implode( '', $textElements );

$text .= '	    ';
}
unset( $if_cond );
// if ends

$text .= '	</div>
	';
$blockText = $text;
unset( $blockData );
unset( $blockData );
$blockData = ( array_key_exists( $currentNamespace, $vars ) and array_key_exists( 'right_blocks', $vars[$currentNamespace] ) ) ? $vars[$currentNamespace]['right_blocks'] : null;
if (! isset( $blockData ) ) $blockData = NULL;
while ( is_object( $blockData ) and method_exists( $blockData, 'templateValue' ) )
    $blockData = $blockData->templateValue();

if ( is_null ( $blockData ) ) $blockData = array();
if ( is_array ( $blockData ) ) $blockData[] = $blockText;
else eZDebug::writeError( "Variable 'right_blocks' is already in use." );
$vars[$currentNamespace]['right_blocks'] = $blockData;
unset( $blockData );

unset( $blockText );

$text = array_pop( $textStack );
$text .= '  ';
}
unset( $if_cond );
// if ends

// sequence iteration
if ( ( $foreach_sequence_var_6b35ca682f1f6af7815a0888f9895ba7_1 = next( $foreach_sequence_array_6b35ca682f1f6af7815a0888f9895ba7_1 ) ) === false )
{
   reset( $foreach_sequence_array_6b35ca682f1f6af7815a0888f9895ba7_1 );
   $foreach_sequence_var_6b35ca682f1f6af7815a0888f9895ba7_1 = current( $foreach_sequence_array_6b35ca682f1f6af7815a0888f9895ba7_1 );
}

$fe_n_items_processed_6b35ca682f1f6af7815a0888f9895ba7_1++;
} // foreach
unset( $foreach_sequence_array_6b35ca682f1f6af7815a0888f9895ba7_1 );

unset( $foreach_sequence_var_6b35ca682f1f6af7815a0888f9895ba7_1 );

unset( $vars[$rootNamespace]['position'] );
$skipDelimiter = false;
if ( count( $fe_variable_stack_6b35ca682f1f6af7815a0888f9895ba7_1 ) ) extract( array_pop( $fe_variable_stack_6b35ca682f1f6af7815a0888f9895ba7_1 ) );

else
{

unset( $fe_array_6b35ca682f1f6af7815a0888f9895ba7_1 );

unset( $fe_array_keys_6b35ca682f1f6af7815a0888f9895ba7_1 );

unset( $fe_n_items_6b35ca682f1f6af7815a0888f9895ba7_1 );

unset( $fe_n_items_processed_6b35ca682f1f6af7815a0888f9895ba7_1 );

unset( $fe_i_6b35ca682f1f6af7815a0888f9895ba7_1 );

unset( $fe_key_6b35ca682f1f6af7815a0888f9895ba7_1 );

unset( $fe_val_6b35ca682f1f6af7815a0888f9895ba7_1 );

unset( $fe_offset_6b35ca682f1f6af7815a0888f9895ba7_1 );

unset( $fe_max_6b35ca682f1f6af7815a0888f9895ba7_1 );

unset( $fe_reverse_6b35ca682f1f6af7815a0888f9895ba7_1 );

unset( $fe_first_val_6b35ca682f1f6af7815a0888f9895ba7_1 );

unset( $fe_last_val_6b35ca682f1f6af7815a0888f9895ba7_1 );

unset( $fe_variable_stack_6b35ca682f1f6af7815a0888f9895ba7_1 );

}

// foreach ends
$text .= '</div>
<div class="right">
    ';
unset( $var );
unset( $var1 );
unset( $var1 );
$var1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'right_blocks', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['right_blocks'] : null;
if (! isset( $var1 ) ) $var1 = NULL;
while ( is_object( $var1 ) and method_exists( $var1, 'templateValue' ) )
    $var1 = $var1->templateValue();
while ( is_object( $var1 ) and method_exists( $var1, 'templateValue' ) )
    $var1 = $var1->templateValue();
$var = implode( "", $var1 );unset( $var1 );
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
$text .= $var;
unset( $var );

$text .= '
</div>
<div class="float-break"></div>
</div>


</div></div></div></div></div></div>

</div>';

$setArray = $oldSetArray_20ce99b165b5f64f2deb945fa758ceaa;
$tpl->Level--;
?>
