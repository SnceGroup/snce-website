<?php
// URI:       design/admin/templates/page_leftmenu.tpl
// Filename:  design/admin/templates/page_leftmenu.tpl
// Timestamp: 1383940876 (Fri Nov 8 21:01:16 CET 2013)
$oldSetArray_8528f6390d82308517304b3b4130bb3a = isset( $setArray ) ? $setArray : array();
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

$text .= '<div id="leftmenu">
<div id="leftmenu-design">
';
// if begins
unset( $if_cond );
unset( $if_cond1 );
unset( $if_cond1 );
$if_cond1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'module_result', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['module_result'] : null;
$if_cond2 = compiledFetchAttribute( $if_cond1, 'left_menu' );
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
$text .= '    ';
$textElements = array();
$tpl->processFunction( 'include', $textElements,
                       false,
                       array (
  'uri' => 
  array (
    0 => 
    array (
      0 => 4,
      1 => 
      array (
        0 => '',
        1 => 2,
        2 => 'module_result',
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
          1 => 'left_menu',
          2 => false,
        ),
      ),
      2 => false,
    ),
  ),
),
                       array (
  0 => 
  array (
    0 => 5,
    1 => 4,
    2 => 93,
  ),
  1 => 
  array (
    0 => 5,
    1 => 40,
    2 => 129,
  ),
  2 => 'design/admin/templates/page_leftmenu.tpl',
),
                       $rootNamespace, $currentNamespace );
$text .= implode( '', $textElements );

}
else
{
$text .= '    
    ';
// def $navigation_part_name
unset( $var );
unset( $var );
$var = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'navigation_part', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['navigation_part'] : null;
$var1 = compiledFetchAttribute( $var, 'identifier' );
unset( $var );
$var = $var1;
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
if ( $tpl->hasVariable( 'navigation_part_name', $rootNamespace ) )
{
    $tpl->warning( 'def', "Variable 'navigation_part_name' is already defined.", array (
  0 => 
  array (
    0 => 11,
    1 => 4,
    2 => 272,
  ),
  1 => 
  array (
    0 => 11,
    1 => 59,
    2 => 327,
  ),
  2 => 'design/admin/templates/page_leftmenu.tpl',
) );
    $tpl->setVariable( 'navigation_part_name', $var, $rootNamespace );
}
else
{
    $tpl->setLocalVariable( 'navigation_part_name', $var, $rootNamespace );
}

$text .= '    ';
// if begins
unset( $if_cond );
unset( $if_cond1 );
unset( $if_cond1 );
$if_cond1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'navigation_part_name', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['navigation_part_name'] : null;
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
$text .= '        ';
unset( $var );
unset( $var );
$var = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'module_result', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['module_result'] : null;
$var1 = compiledFetchAttribute( $var, 'navigation_part' );
unset( $var );
$var = $var1;
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
if ( array_key_exists( $currentNamespace, $vars ) && array_key_exists( 'navigation_part_name', $vars[$currentNamespace] ) )
{
    $vars[$currentNamespace]['navigation_part_name'] = $var;
    unset( $var );
}
$text .= '    ';
}
unset( $if_cond );
// if ends

$text .= '    
    ';
// def $extract_length
unset( $var );
unset( $var1 );
if (! isset( $var1 ) ) $var1 = NULL;
while ( is_object( $var1 ) and method_exists( $var1, 'templateValue' ) )
    $var1 = $var1->templateValue();
$var1Data = array( 'value' => $var1 );
$tpl->processOperator( 'count_chars',
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
        2 => 'navigation_part_name',
      ),
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
$var = $var1 - 14.000000;
unset( $var1 );
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
if ( $tpl->hasVariable( 'extract_length', $rootNamespace ) )
{
    $tpl->warning( 'def', "Variable 'extract_length' is already defined.", array (
  0 => 
  array (
    0 => 19,
    1 => 4,
    2 => 611,
  ),
  1 => 
  array (
    0 => 20,
    1 => 75,
    2 => 758,
  ),
  2 => 'design/admin/templates/page_leftmenu.tpl',
) );
    $tpl->setVariable( 'extract_length', $var, $rootNamespace );
}
else
{
    $tpl->setLocalVariable( 'extract_length', $var, $rootNamespace );
}

// def $part_name
unset( $var );
unset( $var1 );
unset( $var1 );
$var1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'extract_length', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['extract_length'] : null;
if (! isset( $var1 ) ) $var1 = NULL;
while ( is_object( $var1 ) and method_exists( $var1, 'templateValue' ) )
    $var1 = $var1->templateValue();
while ( is_object( $var1 ) and method_exists( $var1, 'templateValue' ) )
    $var1 = $var1->templateValue();
unset( $var2 );
unset( $var2 );
$var2 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'navigation_part_name', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['navigation_part_name'] : null;
if (! isset( $var2 ) ) $var2 = NULL;
while ( is_object( $var2 ) and method_exists( $var2, 'templateValue' ) )
    $var2 = $var2->templateValue();
while ( is_object( $var2 ) and method_exists( $var2, 'templateValue' ) )
    $var2 = $var2->templateValue();
if ( is_string( $var2 ) )
    $var = substr( $var2, 2, $var1 );
else
    $var = array_slice( $var2, 2, $var1 );unset( $var1, $var2 );
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
if ( $tpl->hasVariable( 'part_name', $rootNamespace ) )
{
    $tpl->warning( 'def', "Variable 'part_name' is already defined.", array (
  0 => 
  array (
    0 => 19,
    1 => 4,
    2 => 611,
  ),
  1 => 
  array (
    0 => 20,
    1 => 75,
    2 => 758,
  ),
  2 => 'design/admin/templates/page_leftmenu.tpl',
) );
    $tpl->setVariable( 'part_name', $var, $rootNamespace );
}
else
{
    $tpl->setLocalVariable( 'part_name', $var, $rootNamespace );
}

$text .= '
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
            1 => 'design:parts/',
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
              2 => 'part_name',
            ),
            2 => false,
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            0 => 1,
            1 => '/menu.tpl',
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
    0 => 22,
    1 => 4,
    2 => 766,
  ),
  1 => 
  array (
    0 => 22,
    1 => 66,
    2 => 828,
  ),
  2 => 'design/admin/templates/page_leftmenu.tpl',
),
                       $rootNamespace, $currentNamespace );
$text .= implode( '', $textElements );

$text .= '
    ';
// undef $extract_length
$tpl->unsetLocalVariable( 'extract_length', $rootNamespace );

// undef $part_name
$tpl->unsetLocalVariable( 'part_name', $rootNamespace );

// undef $navigation_part_name
$tpl->unsetLocalVariable( 'navigation_part_name', $rootNamespace );

}
unset( $if_cond );
// if ends

$text .= '
</div>
</div>

<hr class="hide" />';

$setArray = $oldSetArray_8528f6390d82308517304b3b4130bb3a;
$tpl->Level--;
?>
