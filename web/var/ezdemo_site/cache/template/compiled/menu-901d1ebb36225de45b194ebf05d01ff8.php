<?php
// URI:       design:parts/my/menu.tpl
// Filename:  design/admin/templates/parts/my/menu.tpl
// Timestamp: 1383940876 (Fri Nov 8 21:01:16 CET 2013)
$oldSetArray_00de4028bb8a453da4f820dd4c05d9e5 = isset( $setArray ) ? $setArray : array();
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

$oldRestoreIncludeArray_cbde80bb8c1aaf4255b29dad8a0a2544 = isset( $restoreIncludeArray ) ? $restoreIncludeArray : array();
$restoreIncludeArray = array();

if ( isset( $currentNamespace ) and isset( $vars[$currentNamespace]['ini_section'] ) )
    $restoreIncludeArray[] = array( $currentNamespace, 'ini_section', $vars[$currentNamespace]['ini_section'] );
elseif ( !isset( $vars[( isset( $currentNamespace ) ? $currentNamespace : '' )]['ini_section'] ) ) 
    $restoreIncludeArray[] = array( ( isset( $currentNamespace ) ? $currentNamespace : '' ), 'ini_section', 'unset' );

$vars[$currentNamespace]['ini_section'] = 'Leftmenu_my';
if ( isset( $currentNamespace ) and isset( $vars[$currentNamespace]['i18n_hash'] ) )
    $restoreIncludeArray[] = array( $currentNamespace, 'i18n_hash', $vars[$currentNamespace]['i18n_hash'] );
elseif ( !isset( $vars[( isset( $currentNamespace ) ? $currentNamespace : '' )]['i18n_hash'] ) ) 
    $restoreIncludeArray[] = array( ( isset( $currentNamespace ) ? $currentNamespace : '' ), 'i18n_hash', 'unset' );

$vars[$currentNamespace]['i18n_hash'] = array (
  'my_account' => 'Il mio account',
  'my_drafts' => 'Le mie bozze',
  'my_pending' => 'Le mie cose da fare',
  'my_notifications' => 'Impostazioni personali delle notifiche',
  'my_bookmarks' => 'I miei preferiti',
  'collaboration' => 'Collaborazione',
  'change_password' => 'Cambia password',
  'my_shopping_basket' => 'Il mio carrello acquisti',
  'my_wish_list' => 'La mia lista dei desideri',
  'edit_profile' => 'Modifica profilo',
  'dashboard' => 'Pannello strumenti',
);
if ( !isset( $dKeys ) )
{
    $resH = $tpl->resourceHandler( "design" );
    $dKeys = $resH->keys();
}

$resourceFound = false;
if ( file_exists( 'var/ezdemo_site/cache/template/compiled/ini_menu-ed516ef13445d5d98c44b769af6ff74b.php' ) )
{
$resourceFound = true;
$namespaceStack[] = array( $rootNamespace, $currentNamespace );
$rootNamespace = $currentNamespace;
$tpl->createLocalVariablesList();
$tpl->appendTemplateFetch( 'design/admin/templates/parts/ini_menu.tpl' );
include( '' . 'var/ezdemo_site/cache/template/compiled/ini_menu-ed516ef13445d5d98c44b769af6ff74b.php' );
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
$tpl->processURI( 'design/admin/templates/parts/ini_menu.tpl', true, $extraParameters, $textElements, $rootNamespace, $currentNamespace );
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
$restoreIncludeArray = $oldRestoreIncludeArray_cbde80bb8c1aaf4255b29dad8a0a2544;

$text .= '
';
// def $custom_root_node
unset( $var );
$var = call_user_func_array( array( new eZContentFunctionCollection(), 'fetchContentNode' ),
  array(     'node_id' => 1,
    'node_path' => false,
    'language_code' => false,
    'remote_id' => false ) );
$var = isset( $var['result'] ) ? $var['result'] : null;
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
if ( $tpl->hasVariable( 'custom_root_node', $rootNamespace ) )
{
    $tpl->warning( 'def', "Variable 'custom_root_node' is already defined.", array (
  0 => 
  array (
    0 => 17,
    1 => 0,
    2 => 1074,
  ),
  1 => 
  array (
    0 => 17,
    1 => 72,
    2 => 1146,
  ),
  2 => 'design/admin/templates/parts/my/menu.tpl',
) );
    $tpl->setVariable( 'custom_root_node', $var, $rootNamespace );
}
else
{
    $tpl->setLocalVariable( 'custom_root_node', $var, $rootNamespace );
}

// if begins
unset( $if_cond );
unset( $if_cond );
$if_cond = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'custom_root_node', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['custom_root_node'] : null;
$if_cond1 = compiledFetchAttribute( $if_cond, 'can_read' );
unset( $if_cond );
$if_cond = $if_cond1;
if (! isset( $if_cond ) ) $if_cond = NULL;
while ( is_object( $if_cond ) and method_exists( $if_cond, 'templateValue' ) )
    $if_cond = $if_cond->templateValue();

if ( $if_cond )
{
$text .= '<div id="content-tree">
<div class="box-header"><div class="box-ml">
<h4>Struttura del sito</h4>
</div></div>

<div class="box-bc"><div class="box-ml"><div class="box-content">


<div id="contentstructure">
    ';
$oldRestoreIncludeArray_1c891ae8c644491353c5beb074c9a9bc = isset( $restoreIncludeArray ) ? $restoreIncludeArray : array();
$restoreIncludeArray = array();

if ( isset( $currentNamespace ) and isset( $vars[$currentNamespace]['custom_root_node'] ) )
    $restoreIncludeArray[] = array( $currentNamespace, 'custom_root_node', $vars[$currentNamespace]['custom_root_node'] );
elseif ( !isset( $vars[( isset( $currentNamespace ) ? $currentNamespace : '' )]['custom_root_node'] ) ) 
    $restoreIncludeArray[] = array( ( isset( $currentNamespace ) ? $currentNamespace : '' ), 'custom_root_node', 'unset' );

unset( $var );
unset( $var );
$var = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'custom_root_node', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['custom_root_node'] : null;
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
$vars[$currentNamespace]['custom_root_node'] = $var;
unset( $var );
if ( isset( $currentNamespace ) and isset( $vars[$currentNamespace]['menu_persistence'] ) )
    $restoreIncludeArray[] = array( $currentNamespace, 'menu_persistence', $vars[$currentNamespace]['menu_persistence'] );
elseif ( !isset( $vars[( isset( $currentNamespace ) ? $currentNamespace : '' )]['menu_persistence'] ) ) 
    $restoreIncludeArray[] = array( ( isset( $currentNamespace ) ? $currentNamespace : '' ), 'menu_persistence', 'unset' );

$vars[$currentNamespace]['menu_persistence'] = false;
if ( isset( $currentNamespace ) and isset( $vars[$currentNamespace]['hide_node_list'] ) )
    $restoreIncludeArray[] = array( $currentNamespace, 'hide_node_list', $vars[$currentNamespace]['hide_node_list'] );
elseif ( !isset( $vars[( isset( $currentNamespace ) ? $currentNamespace : '' )]['hide_node_list'] ) ) 
    $restoreIncludeArray[] = array( ( isset( $currentNamespace ) ? $currentNamespace : '' ), 'hide_node_list', 'unset' );

$vars[$currentNamespace]['hide_node_list'] = array (
  0 => '58',
  1 => '48',
);
if ( !isset( $dKeys ) )
{
    $resH = $tpl->resourceHandler( "design" );
    $dKeys = $resH->keys();
}

$resourceFound = false;
if ( file_exists( 'var/ezdemo_site/cache/template/compiled/content_structure_menu_dynamic-b7365c3b56edd5eed2180773216668a1.php' ) )
{
$resourceFound = true;
$namespaceStack[] = array( $rootNamespace, $currentNamespace );
$rootNamespace = $currentNamespace;
$tpl->createLocalVariablesList();
$tpl->appendTemplateFetch( 'design/admin/templates/contentstructuremenu/content_structure_menu_dynamic.tpl' );
include( '' . 'var/ezdemo_site/cache/template/compiled/content_structure_menu_dynamic-b7365c3b56edd5eed2180773216668a1.php' );
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
$tpl->processURI( 'design/admin/templates/contentstructuremenu/content_structure_menu_dynamic.tpl', true, $extraParameters, $textElements, $rootNamespace, $currentNamespace );
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
$restoreIncludeArray = $oldRestoreIncludeArray_1c891ae8c644491353c5beb074c9a9bc;

$text .= '</div>

</div></div></div>
</div>';
}
unset( $if_cond );
// if ends

$text .= '

<div id="widthcontrol-links" class="widthcontrol">
<p>';
$textElements = array();
$tpl->processFunction( 'switch', $textElements,
                       array (
  0 => 
  array (
    0 => 2,
    1 => false,
    2 => '    ',
    3 => 
    array (
      0 => 
      array (
        0 => 38,
        1 => 51,
        2 => 2003,
      ),
      1 => 
      array (
        0 => 39,
        1 => 4,
        2 => 2008,
      ),
      2 => 'design/admin/templates/parts/my/menu.tpl',
    ),
  ),
  1 => 
  array (
    0 => 4,
    1 => 
    array (
      0 => 
      array (
        0 => 2,
        1 => false,
        2 => '    <a href=',
        3 => 
        array (
          0 => 
          array (
            0 => 39,
            1 => 23,
            2 => 2029,
          ),
          1 => 
          array (
            0 => 40,
            1 => 12,
            2 => 2042,
          ),
          2 => 'design/admin/templates/parts/my/menu.tpl',
        ),
      ),
      1 => 
      array (
        0 => 3,
        1 => false,
        2 => 
        array (
          0 => 
          array (
            0 => 1,
            1 => '/user/preferences/set/admin_left_menu_size/small',
            2 => false,
          ),
          1 => 
          array (
            0 => 6,
            1 => 
            array (
              0 => 'ezurl',
            ),
            2 => false,
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            0 => 40,
            1 => 12,
            2 => 2043,
          ),
          1 => 
          array (
            0 => 40,
            1 => 68,
            2 => 2099,
          ),
          2 => 'design/admin/templates/parts/my/menu.tpl',
        ),
      ),
      2 => 
      array (
        0 => 2,
        1 => false,
        2 => ' title="',
        3 => 
        array (
          0 => 
          array (
            0 => 40,
            1 => 68,
            2 => 2100,
          ),
          1 => 
          array (
            0 => 40,
            1 => 76,
            2 => 2108,
          ),
          2 => 'design/admin/templates/parts/my/menu.tpl',
        ),
      ),
      3 => 
      array (
        0 => 3,
        1 => false,
        2 => 
        array (
          0 => 
          array (
            0 => 1,
            1 => 'Change the left menu width to small size.',
            2 => false,
          ),
          1 => 
          array (
            0 => 6,
            1 => 
            array (
              0 => 'i18n',
              1 => 
              array (
                0 => 
                array (
                  0 => 1,
                  1 => 'design/admin/parts/user/menu',
                  2 => false,
                ),
              ),
            ),
            2 => false,
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            0 => 40,
            1 => 76,
            2 => 2109,
          ),
          1 => 
          array (
            0 => 40,
            1 => 158,
            2 => 2191,
          ),
          2 => 'design/admin/templates/parts/my/menu.tpl',
        ),
      ),
      4 => 
      array (
        0 => 2,
        1 => false,
        2 => '">',
        3 => 
        array (
          0 => 
          array (
            0 => 40,
            1 => 158,
            2 => 2192,
          ),
          1 => 
          array (
            0 => 40,
            1 => 160,
            2 => 2194,
          ),
          2 => 'design/admin/templates/parts/my/menu.tpl',
        ),
      ),
      5 => 
      array (
        0 => 3,
        1 => false,
        2 => 
        array (
          0 => 
          array (
            0 => 1,
            1 => 'Small',
            2 => false,
          ),
          1 => 
          array (
            0 => 6,
            1 => 
            array (
              0 => 'i18n',
              1 => 
              array (
                0 => 
                array (
                  0 => 1,
                  1 => 'design/admin/parts/user/menu',
                  2 => false,
                ),
              ),
            ),
            2 => false,
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            0 => 40,
            1 => 160,
            2 => 2195,
          ),
          1 => 
          array (
            0 => 40,
            1 => 206,
            2 => 2241,
          ),
          2 => 'design/admin/templates/parts/my/menu.tpl',
        ),
      ),
      6 => 
      array (
        0 => 2,
        1 => false,
        2 => '</a>
    <span class="current">',
        3 => 
        array (
          0 => 
          array (
            0 => 40,
            1 => 206,
            2 => 2242,
          ),
          1 => 
          array (
            0 => 41,
            1 => 26,
            2 => 2273,
          ),
          2 => 'design/admin/templates/parts/my/menu.tpl',
        ),
      ),
      7 => 
      array (
        0 => 3,
        1 => false,
        2 => 
        array (
          0 => 
          array (
            0 => 1,
            1 => 'Medium',
            2 => false,
          ),
          1 => 
          array (
            0 => 6,
            1 => 
            array (
              0 => 'i18n',
              1 => 
              array (
                0 => 
                array (
                  0 => 1,
                  1 => 'design/admin/parts/user/menu',
                  2 => false,
                ),
              ),
            ),
            2 => false,
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            0 => 41,
            1 => 26,
            2 => 2274,
          ),
          1 => 
          array (
            0 => 41,
            1 => 73,
            2 => 2321,
          ),
          2 => 'design/admin/templates/parts/my/menu.tpl',
        ),
      ),
      8 => 
      array (
        0 => 2,
        1 => false,
        2 => '</span>
    <a href=',
        3 => 
        array (
          0 => 
          array (
            0 => 41,
            1 => 73,
            2 => 2322,
          ),
          1 => 
          array (
            0 => 42,
            1 => 12,
            2 => 2342,
          ),
          2 => 'design/admin/templates/parts/my/menu.tpl',
        ),
      ),
      9 => 
      array (
        0 => 3,
        1 => false,
        2 => 
        array (
          0 => 
          array (
            0 => 1,
            1 => '/user/preferences/set/admin_left_menu_size/large',
            2 => false,
          ),
          1 => 
          array (
            0 => 6,
            1 => 
            array (
              0 => 'ezurl',
            ),
            2 => false,
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            0 => 42,
            1 => 12,
            2 => 2343,
          ),
          1 => 
          array (
            0 => 42,
            1 => 68,
            2 => 2399,
          ),
          2 => 'design/admin/templates/parts/my/menu.tpl',
        ),
      ),
      10 => 
      array (
        0 => 2,
        1 => false,
        2 => ' title="',
        3 => 
        array (
          0 => 
          array (
            0 => 42,
            1 => 68,
            2 => 2400,
          ),
          1 => 
          array (
            0 => 42,
            1 => 76,
            2 => 2408,
          ),
          2 => 'design/admin/templates/parts/my/menu.tpl',
        ),
      ),
      11 => 
      array (
        0 => 3,
        1 => false,
        2 => 
        array (
          0 => 
          array (
            0 => 1,
            1 => 'Change the left menu width to large size.',
            2 => false,
          ),
          1 => 
          array (
            0 => 6,
            1 => 
            array (
              0 => 'i18n',
              1 => 
              array (
                0 => 
                array (
                  0 => 1,
                  1 => 'design/admin/parts/user/menu',
                  2 => false,
                ),
              ),
            ),
            2 => false,
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            0 => 42,
            1 => 76,
            2 => 2409,
          ),
          1 => 
          array (
            0 => 42,
            1 => 158,
            2 => 2491,
          ),
          2 => 'design/admin/templates/parts/my/menu.tpl',
        ),
      ),
      12 => 
      array (
        0 => 2,
        1 => false,
        2 => '">',
        3 => 
        array (
          0 => 
          array (
            0 => 42,
            1 => 158,
            2 => 2492,
          ),
          1 => 
          array (
            0 => 42,
            1 => 160,
            2 => 2494,
          ),
          2 => 'design/admin/templates/parts/my/menu.tpl',
        ),
      ),
      13 => 
      array (
        0 => 3,
        1 => false,
        2 => 
        array (
          0 => 
          array (
            0 => 1,
            1 => 'Large',
            2 => false,
          ),
          1 => 
          array (
            0 => 6,
            1 => 
            array (
              0 => 'i18n',
              1 => 
              array (
                0 => 
                array (
                  0 => 1,
                  1 => 'design/admin/parts/user/menu',
                  2 => false,
                ),
              ),
            ),
            2 => false,
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            0 => 42,
            1 => 160,
            2 => 2495,
          ),
          1 => 
          array (
            0 => 42,
            1 => 206,
            2 => 2541,
          ),
          2 => 'design/admin/templates/parts/my/menu.tpl',
        ),
      ),
      14 => 
      array (
        0 => 2,
        1 => false,
        2 => '</a>
    ',
        3 => 
        array (
          0 => 
          array (
            0 => 42,
            1 => 206,
            2 => 2542,
          ),
          1 => 
          array (
            0 => 43,
            1 => 4,
            2 => 2551,
          ),
          2 => 'design/admin/templates/parts/my/menu.tpl',
        ),
      ),
    ),
    2 => 'case',
    3 => 
    array (
      'match' => 
      array (
        0 => 
        array (
          0 => 1,
          1 => 'medium',
          2 => false,
        ),
      ),
    ),
    4 => 
    array (
      0 => 
      array (
        0 => 39,
        1 => 4,
        2 => 2009,
      ),
      1 => 
      array (
        0 => 39,
        1 => 23,
        2 => 2028,
      ),
      2 => 'design/admin/templates/parts/my/menu.tpl',
    ),
  ),
  2 => 
  array (
    0 => 2,
    1 => false,
    2 => '
    ',
    3 => 
    array (
      0 => 
      array (
        0 => 43,
        1 => 8,
        2 => 2558,
      ),
      1 => 
      array (
        0 => 45,
        1 => 4,
        2 => 2564,
      ),
      2 => 'design/admin/templates/parts/my/menu.tpl',
    ),
  ),
  3 => 
  array (
    0 => 4,
    1 => 
    array (
      0 => 
      array (
        0 => 2,
        1 => false,
        2 => '    <a href=',
        3 => 
        array (
          0 => 
          array (
            0 => 45,
            1 => 22,
            2 => 2584,
          ),
          1 => 
          array (
            0 => 46,
            1 => 12,
            2 => 2597,
          ),
          2 => 'design/admin/templates/parts/my/menu.tpl',
        ),
      ),
      1 => 
      array (
        0 => 3,
        1 => false,
        2 => 
        array (
          0 => 
          array (
            0 => 1,
            1 => '/user/preferences/set/admin_left_menu_size/small',
            2 => false,
          ),
          1 => 
          array (
            0 => 6,
            1 => 
            array (
              0 => 'ezurl',
            ),
            2 => false,
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            0 => 46,
            1 => 12,
            2 => 2598,
          ),
          1 => 
          array (
            0 => 46,
            1 => 68,
            2 => 2654,
          ),
          2 => 'design/admin/templates/parts/my/menu.tpl',
        ),
      ),
      2 => 
      array (
        0 => 2,
        1 => false,
        2 => ' title="',
        3 => 
        array (
          0 => 
          array (
            0 => 46,
            1 => 68,
            2 => 2655,
          ),
          1 => 
          array (
            0 => 46,
            1 => 76,
            2 => 2663,
          ),
          2 => 'design/admin/templates/parts/my/menu.tpl',
        ),
      ),
      3 => 
      array (
        0 => 3,
        1 => false,
        2 => 
        array (
          0 => 
          array (
            0 => 1,
            1 => 'Change the left menu width to small size.',
            2 => false,
          ),
          1 => 
          array (
            0 => 6,
            1 => 
            array (
              0 => 'i18n',
              1 => 
              array (
                0 => 
                array (
                  0 => 1,
                  1 => 'design/admin/parts/user/menu',
                  2 => false,
                ),
              ),
            ),
            2 => false,
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            0 => 46,
            1 => 76,
            2 => 2664,
          ),
          1 => 
          array (
            0 => 46,
            1 => 158,
            2 => 2746,
          ),
          2 => 'design/admin/templates/parts/my/menu.tpl',
        ),
      ),
      4 => 
      array (
        0 => 2,
        1 => false,
        2 => '">',
        3 => 
        array (
          0 => 
          array (
            0 => 46,
            1 => 158,
            2 => 2747,
          ),
          1 => 
          array (
            0 => 46,
            1 => 160,
            2 => 2749,
          ),
          2 => 'design/admin/templates/parts/my/menu.tpl',
        ),
      ),
      5 => 
      array (
        0 => 3,
        1 => false,
        2 => 
        array (
          0 => 
          array (
            0 => 1,
            1 => 'Small',
            2 => false,
          ),
          1 => 
          array (
            0 => 6,
            1 => 
            array (
              0 => 'i18n',
              1 => 
              array (
                0 => 
                array (
                  0 => 1,
                  1 => 'design/admin/parts/user/menu',
                  2 => false,
                ),
              ),
            ),
            2 => false,
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            0 => 46,
            1 => 160,
            2 => 2750,
          ),
          1 => 
          array (
            0 => 46,
            1 => 206,
            2 => 2796,
          ),
          2 => 'design/admin/templates/parts/my/menu.tpl',
        ),
      ),
      6 => 
      array (
        0 => 2,
        1 => false,
        2 => '</a>
    <a href=',
        3 => 
        array (
          0 => 
          array (
            0 => 46,
            1 => 206,
            2 => 2797,
          ),
          1 => 
          array (
            0 => 47,
            1 => 12,
            2 => 2814,
          ),
          2 => 'design/admin/templates/parts/my/menu.tpl',
        ),
      ),
      7 => 
      array (
        0 => 3,
        1 => false,
        2 => 
        array (
          0 => 
          array (
            0 => 1,
            1 => '/user/preferences/set/admin_left_menu_size/medium',
            2 => false,
          ),
          1 => 
          array (
            0 => 6,
            1 => 
            array (
              0 => 'ezurl',
            ),
            2 => false,
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            0 => 47,
            1 => 12,
            2 => 2815,
          ),
          1 => 
          array (
            0 => 47,
            1 => 69,
            2 => 2872,
          ),
          2 => 'design/admin/templates/parts/my/menu.tpl',
        ),
      ),
      8 => 
      array (
        0 => 2,
        1 => false,
        2 => ' title="',
        3 => 
        array (
          0 => 
          array (
            0 => 47,
            1 => 69,
            2 => 2873,
          ),
          1 => 
          array (
            0 => 47,
            1 => 77,
            2 => 2881,
          ),
          2 => 'design/admin/templates/parts/my/menu.tpl',
        ),
      ),
      9 => 
      array (
        0 => 3,
        1 => false,
        2 => 
        array (
          0 => 
          array (
            0 => 1,
            1 => 'Change the left menu width to medium size.',
            2 => false,
          ),
          1 => 
          array (
            0 => 6,
            1 => 
            array (
              0 => 'i18n',
              1 => 
              array (
                0 => 
                array (
                  0 => 1,
                  1 => 'design/admin/parts/user/menu',
                  2 => false,
                ),
              ),
            ),
            2 => false,
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            0 => 47,
            1 => 77,
            2 => 2882,
          ),
          1 => 
          array (
            0 => 47,
            1 => 160,
            2 => 2965,
          ),
          2 => 'design/admin/templates/parts/my/menu.tpl',
        ),
      ),
      10 => 
      array (
        0 => 2,
        1 => false,
        2 => '">',
        3 => 
        array (
          0 => 
          array (
            0 => 47,
            1 => 160,
            2 => 2966,
          ),
          1 => 
          array (
            0 => 47,
            1 => 162,
            2 => 2968,
          ),
          2 => 'design/admin/templates/parts/my/menu.tpl',
        ),
      ),
      11 => 
      array (
        0 => 3,
        1 => false,
        2 => 
        array (
          0 => 
          array (
            0 => 1,
            1 => 'Medium',
            2 => false,
          ),
          1 => 
          array (
            0 => 6,
            1 => 
            array (
              0 => 'i18n',
              1 => 
              array (
                0 => 
                array (
                  0 => 1,
                  1 => 'design/admin/parts/user/menu',
                  2 => false,
                ),
              ),
            ),
            2 => false,
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            0 => 47,
            1 => 162,
            2 => 2969,
          ),
          1 => 
          array (
            0 => 47,
            1 => 209,
            2 => 3016,
          ),
          2 => 'design/admin/templates/parts/my/menu.tpl',
        ),
      ),
      12 => 
      array (
        0 => 2,
        1 => false,
        2 => '</a>
    <span class="current">',
        3 => 
        array (
          0 => 
          array (
            0 => 47,
            1 => 209,
            2 => 3017,
          ),
          1 => 
          array (
            0 => 48,
            1 => 26,
            2 => 3048,
          ),
          2 => 'design/admin/templates/parts/my/menu.tpl',
        ),
      ),
      13 => 
      array (
        0 => 3,
        1 => false,
        2 => 
        array (
          0 => 
          array (
            0 => 1,
            1 => 'Large',
            2 => false,
          ),
          1 => 
          array (
            0 => 6,
            1 => 
            array (
              0 => 'i18n',
              1 => 
              array (
                0 => 
                array (
                  0 => 1,
                  1 => 'design/admin/parts/user/menu',
                  2 => false,
                ),
              ),
            ),
            2 => false,
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            0 => 48,
            1 => 26,
            2 => 3049,
          ),
          1 => 
          array (
            0 => 48,
            1 => 72,
            2 => 3095,
          ),
          2 => 'design/admin/templates/parts/my/menu.tpl',
        ),
      ),
      14 => 
      array (
        0 => 2,
        1 => false,
        2 => '</span>
    ',
        3 => 
        array (
          0 => 
          array (
            0 => 48,
            1 => 72,
            2 => 3096,
          ),
          1 => 
          array (
            0 => 49,
            1 => 4,
            2 => 3108,
          ),
          2 => 'design/admin/templates/parts/my/menu.tpl',
        ),
      ),
    ),
    2 => 'case',
    3 => 
    array (
      'match' => 
      array (
        0 => 
        array (
          0 => 1,
          1 => 'large',
          2 => false,
        ),
      ),
    ),
    4 => 
    array (
      0 => 
      array (
        0 => 45,
        1 => 4,
        2 => 2565,
      ),
      1 => 
      array (
        0 => 45,
        1 => 22,
        2 => 2583,
      ),
      2 => 'design/admin/templates/parts/my/menu.tpl',
    ),
  ),
  4 => 
  array (
    0 => 2,
    1 => false,
    2 => '
    ',
    3 => 
    array (
      0 => 
      array (
        0 => 49,
        1 => 8,
        2 => 3115,
      ),
      1 => 
      array (
        0 => 51,
        1 => 4,
        2 => 3121,
      ),
      2 => 'design/admin/templates/parts/my/menu.tpl',
    ),
  ),
  5 => 
  array (
    0 => 4,
    1 => 
    array (
      0 => 
      array (
        0 => 2,
        1 => false,
        2 => '    <span class="current">',
        3 => 
        array (
          0 => 
          array (
            0 => 51,
            1 => 32,
            2 => 3151,
          ),
          1 => 
          array (
            0 => 52,
            1 => 26,
            2 => 3178,
          ),
          2 => 'design/admin/templates/parts/my/menu.tpl',
        ),
      ),
      1 => 
      array (
        0 => 3,
        1 => false,
        2 => 
        array (
          0 => 
          array (
            0 => 1,
            1 => 'Small',
            2 => false,
          ),
          1 => 
          array (
            0 => 6,
            1 => 
            array (
              0 => 'i18n',
              1 => 
              array (
                0 => 
                array (
                  0 => 1,
                  1 => 'design/admin/parts/user/menu',
                  2 => false,
                ),
              ),
            ),
            2 => false,
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            0 => 52,
            1 => 26,
            2 => 3179,
          ),
          1 => 
          array (
            0 => 52,
            1 => 72,
            2 => 3225,
          ),
          2 => 'design/admin/templates/parts/my/menu.tpl',
        ),
      ),
      2 => 
      array (
        0 => 2,
        1 => false,
        2 => '</span>
    <a href=',
        3 => 
        array (
          0 => 
          array (
            0 => 52,
            1 => 72,
            2 => 3226,
          ),
          1 => 
          array (
            0 => 53,
            1 => 12,
            2 => 3246,
          ),
          2 => 'design/admin/templates/parts/my/menu.tpl',
        ),
      ),
      3 => 
      array (
        0 => 3,
        1 => false,
        2 => 
        array (
          0 => 
          array (
            0 => 1,
            1 => '/user/preferences/set/admin_left_menu_size/medium',
            2 => false,
          ),
          1 => 
          array (
            0 => 6,
            1 => 
            array (
              0 => 'ezurl',
            ),
            2 => false,
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            0 => 53,
            1 => 12,
            2 => 3247,
          ),
          1 => 
          array (
            0 => 53,
            1 => 69,
            2 => 3304,
          ),
          2 => 'design/admin/templates/parts/my/menu.tpl',
        ),
      ),
      4 => 
      array (
        0 => 2,
        1 => false,
        2 => ' title="',
        3 => 
        array (
          0 => 
          array (
            0 => 53,
            1 => 69,
            2 => 3305,
          ),
          1 => 
          array (
            0 => 53,
            1 => 77,
            2 => 3313,
          ),
          2 => 'design/admin/templates/parts/my/menu.tpl',
        ),
      ),
      5 => 
      array (
        0 => 3,
        1 => false,
        2 => 
        array (
          0 => 
          array (
            0 => 1,
            1 => 'Change the left menu width to medium size.',
            2 => false,
          ),
          1 => 
          array (
            0 => 6,
            1 => 
            array (
              0 => 'i18n',
              1 => 
              array (
                0 => 
                array (
                  0 => 1,
                  1 => 'design/admin/parts/user/menu',
                  2 => false,
                ),
              ),
            ),
            2 => false,
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            0 => 53,
            1 => 77,
            2 => 3314,
          ),
          1 => 
          array (
            0 => 53,
            1 => 160,
            2 => 3397,
          ),
          2 => 'design/admin/templates/parts/my/menu.tpl',
        ),
      ),
      6 => 
      array (
        0 => 2,
        1 => false,
        2 => '">',
        3 => 
        array (
          0 => 
          array (
            0 => 53,
            1 => 160,
            2 => 3398,
          ),
          1 => 
          array (
            0 => 53,
            1 => 162,
            2 => 3400,
          ),
          2 => 'design/admin/templates/parts/my/menu.tpl',
        ),
      ),
      7 => 
      array (
        0 => 3,
        1 => false,
        2 => 
        array (
          0 => 
          array (
            0 => 1,
            1 => 'Medium',
            2 => false,
          ),
          1 => 
          array (
            0 => 6,
            1 => 
            array (
              0 => 'i18n',
              1 => 
              array (
                0 => 
                array (
                  0 => 1,
                  1 => 'design/admin/parts/user/menu',
                  2 => false,
                ),
              ),
            ),
            2 => false,
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            0 => 53,
            1 => 162,
            2 => 3401,
          ),
          1 => 
          array (
            0 => 53,
            1 => 209,
            2 => 3448,
          ),
          2 => 'design/admin/templates/parts/my/menu.tpl',
        ),
      ),
      8 => 
      array (
        0 => 2,
        1 => false,
        2 => '</a>
    <a href=',
        3 => 
        array (
          0 => 
          array (
            0 => 53,
            1 => 209,
            2 => 3449,
          ),
          1 => 
          array (
            0 => 54,
            1 => 12,
            2 => 3466,
          ),
          2 => 'design/admin/templates/parts/my/menu.tpl',
        ),
      ),
      9 => 
      array (
        0 => 3,
        1 => false,
        2 => 
        array (
          0 => 
          array (
            0 => 1,
            1 => '/user/preferences/set/admin_left_menu_size/large',
            2 => false,
          ),
          1 => 
          array (
            0 => 6,
            1 => 
            array (
              0 => 'ezurl',
            ),
            2 => false,
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            0 => 54,
            1 => 12,
            2 => 3467,
          ),
          1 => 
          array (
            0 => 54,
            1 => 68,
            2 => 3523,
          ),
          2 => 'design/admin/templates/parts/my/menu.tpl',
        ),
      ),
      10 => 
      array (
        0 => 2,
        1 => false,
        2 => ' title="',
        3 => 
        array (
          0 => 
          array (
            0 => 54,
            1 => 68,
            2 => 3524,
          ),
          1 => 
          array (
            0 => 54,
            1 => 76,
            2 => 3532,
          ),
          2 => 'design/admin/templates/parts/my/menu.tpl',
        ),
      ),
      11 => 
      array (
        0 => 3,
        1 => false,
        2 => 
        array (
          0 => 
          array (
            0 => 1,
            1 => 'Change the left menu width to large size.',
            2 => false,
          ),
          1 => 
          array (
            0 => 6,
            1 => 
            array (
              0 => 'i18n',
              1 => 
              array (
                0 => 
                array (
                  0 => 1,
                  1 => 'design/admin/parts/user/menu',
                  2 => false,
                ),
              ),
            ),
            2 => false,
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            0 => 54,
            1 => 76,
            2 => 3533,
          ),
          1 => 
          array (
            0 => 54,
            1 => 158,
            2 => 3615,
          ),
          2 => 'design/admin/templates/parts/my/menu.tpl',
        ),
      ),
      12 => 
      array (
        0 => 2,
        1 => false,
        2 => '">',
        3 => 
        array (
          0 => 
          array (
            0 => 54,
            1 => 158,
            2 => 3616,
          ),
          1 => 
          array (
            0 => 54,
            1 => 160,
            2 => 3618,
          ),
          2 => 'design/admin/templates/parts/my/menu.tpl',
        ),
      ),
      13 => 
      array (
        0 => 3,
        1 => false,
        2 => 
        array (
          0 => 
          array (
            0 => 1,
            1 => 'Large',
            2 => false,
          ),
          1 => 
          array (
            0 => 6,
            1 => 
            array (
              0 => 'i18n',
              1 => 
              array (
                0 => 
                array (
                  0 => 1,
                  1 => 'design/admin/parts/user/menu',
                  2 => false,
                ),
              ),
            ),
            2 => false,
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            0 => 54,
            1 => 160,
            2 => 3619,
          ),
          1 => 
          array (
            0 => 54,
            1 => 206,
            2 => 3665,
          ),
          2 => 'design/admin/templates/parts/my/menu.tpl',
        ),
      ),
      14 => 
      array (
        0 => 2,
        1 => false,
        2 => '</a>
    ',
        3 => 
        array (
          0 => 
          array (
            0 => 54,
            1 => 206,
            2 => 3666,
          ),
          1 => 
          array (
            0 => 55,
            1 => 4,
            2 => 3675,
          ),
          2 => 'design/admin/templates/parts/my/menu.tpl',
        ),
      ),
    ),
    2 => 'case',
    3 => 
    array (
      'in' => 
      array (
        0 => 
        array (
          0 => 6,
          1 => 
          array (
            0 => 'array',
            1 => 
            array (
              0 => 
              array (
                0 => 1,
                1 => 'small',
                2 => false,
              ),
            ),
            2 => 
            array (
              0 => 
              array (
                0 => 1,
                1 => '',
                2 => false,
              ),
            ),
          ),
          2 => false,
        ),
      ),
    ),
    4 => 
    array (
      0 => 
      array (
        0 => 51,
        1 => 4,
        2 => 3122,
      ),
      1 => 
      array (
        0 => 51,
        1 => 32,
        2 => 3150,
      ),
      2 => 'design/admin/templates/parts/my/menu.tpl',
    ),
  ),
  6 => 
  array (
    0 => 2,
    1 => false,
    2 => '
    ',
    3 => 
    array (
      0 => 
      array (
        0 => 55,
        1 => 8,
        2 => 3682,
      ),
      1 => 
      array (
        0 => 57,
        1 => 4,
        2 => 3688,
      ),
      2 => 'design/admin/templates/parts/my/menu.tpl',
    ),
  ),
  7 => 
  array (
    0 => 4,
    1 => 
    array (
      0 => 
      array (
        0 => 2,
        1 => false,
        2 => '    <a href=',
        3 => 
        array (
          0 => 
          array (
            0 => 57,
            1 => 8,
            2 => 3694,
          ),
          1 => 
          array (
            0 => 58,
            1 => 12,
            2 => 3707,
          ),
          2 => 'design/admin/templates/parts/my/menu.tpl',
        ),
      ),
      1 => 
      array (
        0 => 3,
        1 => false,
        2 => 
        array (
          0 => 
          array (
            0 => 1,
            1 => '/user/preferences/set/admin_left_menu_size/small',
            2 => false,
          ),
          1 => 
          array (
            0 => 6,
            1 => 
            array (
              0 => 'ezurl',
            ),
            2 => false,
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            0 => 58,
            1 => 12,
            2 => 3708,
          ),
          1 => 
          array (
            0 => 58,
            1 => 68,
            2 => 3764,
          ),
          2 => 'design/admin/templates/parts/my/menu.tpl',
        ),
      ),
      2 => 
      array (
        0 => 2,
        1 => false,
        2 => ' title="',
        3 => 
        array (
          0 => 
          array (
            0 => 58,
            1 => 68,
            2 => 3765,
          ),
          1 => 
          array (
            0 => 58,
            1 => 76,
            2 => 3773,
          ),
          2 => 'design/admin/templates/parts/my/menu.tpl',
        ),
      ),
      3 => 
      array (
        0 => 3,
        1 => false,
        2 => 
        array (
          0 => 
          array (
            0 => 1,
            1 => 'Change the left menu width to small size.',
            2 => false,
          ),
          1 => 
          array (
            0 => 6,
            1 => 
            array (
              0 => 'i18n',
              1 => 
              array (
                0 => 
                array (
                  0 => 1,
                  1 => 'design/admin/parts/user/menu',
                  2 => false,
                ),
              ),
            ),
            2 => false,
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            0 => 58,
            1 => 76,
            2 => 3774,
          ),
          1 => 
          array (
            0 => 58,
            1 => 158,
            2 => 3856,
          ),
          2 => 'design/admin/templates/parts/my/menu.tpl',
        ),
      ),
      4 => 
      array (
        0 => 2,
        1 => false,
        2 => '">',
        3 => 
        array (
          0 => 
          array (
            0 => 58,
            1 => 158,
            2 => 3857,
          ),
          1 => 
          array (
            0 => 58,
            1 => 160,
            2 => 3859,
          ),
          2 => 'design/admin/templates/parts/my/menu.tpl',
        ),
      ),
      5 => 
      array (
        0 => 3,
        1 => false,
        2 => 
        array (
          0 => 
          array (
            0 => 1,
            1 => 'Small',
            2 => false,
          ),
          1 => 
          array (
            0 => 6,
            1 => 
            array (
              0 => 'i18n',
              1 => 
              array (
                0 => 
                array (
                  0 => 1,
                  1 => 'design/admin/parts/user/menu',
                  2 => false,
                ),
              ),
            ),
            2 => false,
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            0 => 58,
            1 => 160,
            2 => 3860,
          ),
          1 => 
          array (
            0 => 58,
            1 => 206,
            2 => 3906,
          ),
          2 => 'design/admin/templates/parts/my/menu.tpl',
        ),
      ),
      6 => 
      array (
        0 => 2,
        1 => false,
        2 => '</a>
    <a href=',
        3 => 
        array (
          0 => 
          array (
            0 => 58,
            1 => 206,
            2 => 3907,
          ),
          1 => 
          array (
            0 => 59,
            1 => 12,
            2 => 3924,
          ),
          2 => 'design/admin/templates/parts/my/menu.tpl',
        ),
      ),
      7 => 
      array (
        0 => 3,
        1 => false,
        2 => 
        array (
          0 => 
          array (
            0 => 1,
            1 => '/user/preferences/set/admin_left_menu_size/medium',
            2 => false,
          ),
          1 => 
          array (
            0 => 6,
            1 => 
            array (
              0 => 'ezurl',
            ),
            2 => false,
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            0 => 59,
            1 => 12,
            2 => 3925,
          ),
          1 => 
          array (
            0 => 59,
            1 => 69,
            2 => 3982,
          ),
          2 => 'design/admin/templates/parts/my/menu.tpl',
        ),
      ),
      8 => 
      array (
        0 => 2,
        1 => false,
        2 => ' title="',
        3 => 
        array (
          0 => 
          array (
            0 => 59,
            1 => 69,
            2 => 3983,
          ),
          1 => 
          array (
            0 => 59,
            1 => 77,
            2 => 3991,
          ),
          2 => 'design/admin/templates/parts/my/menu.tpl',
        ),
      ),
      9 => 
      array (
        0 => 3,
        1 => false,
        2 => 
        array (
          0 => 
          array (
            0 => 1,
            1 => 'Change the left menu width to medium size.',
            2 => false,
          ),
          1 => 
          array (
            0 => 6,
            1 => 
            array (
              0 => 'i18n',
              1 => 
              array (
                0 => 
                array (
                  0 => 1,
                  1 => 'design/admin/parts/user/menu',
                  2 => false,
                ),
              ),
            ),
            2 => false,
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            0 => 59,
            1 => 77,
            2 => 3992,
          ),
          1 => 
          array (
            0 => 59,
            1 => 160,
            2 => 4075,
          ),
          2 => 'design/admin/templates/parts/my/menu.tpl',
        ),
      ),
      10 => 
      array (
        0 => 2,
        1 => false,
        2 => '">',
        3 => 
        array (
          0 => 
          array (
            0 => 59,
            1 => 160,
            2 => 4076,
          ),
          1 => 
          array (
            0 => 59,
            1 => 162,
            2 => 4078,
          ),
          2 => 'design/admin/templates/parts/my/menu.tpl',
        ),
      ),
      11 => 
      array (
        0 => 3,
        1 => false,
        2 => 
        array (
          0 => 
          array (
            0 => 1,
            1 => 'Medium',
            2 => false,
          ),
          1 => 
          array (
            0 => 6,
            1 => 
            array (
              0 => 'i18n',
              1 => 
              array (
                0 => 
                array (
                  0 => 1,
                  1 => 'design/admin/parts/user/menu',
                  2 => false,
                ),
              ),
            ),
            2 => false,
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            0 => 59,
            1 => 162,
            2 => 4079,
          ),
          1 => 
          array (
            0 => 59,
            1 => 209,
            2 => 4126,
          ),
          2 => 'design/admin/templates/parts/my/menu.tpl',
        ),
      ),
      12 => 
      array (
        0 => 2,
        1 => false,
        2 => '</a>
    <a href=',
        3 => 
        array (
          0 => 
          array (
            0 => 59,
            1 => 209,
            2 => 4127,
          ),
          1 => 
          array (
            0 => 60,
            1 => 12,
            2 => 4144,
          ),
          2 => 'design/admin/templates/parts/my/menu.tpl',
        ),
      ),
      13 => 
      array (
        0 => 3,
        1 => false,
        2 => 
        array (
          0 => 
          array (
            0 => 1,
            1 => '/user/preferences/set/admin_left_menu_size/large',
            2 => false,
          ),
          1 => 
          array (
            0 => 6,
            1 => 
            array (
              0 => 'ezurl',
            ),
            2 => false,
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            0 => 60,
            1 => 12,
            2 => 4145,
          ),
          1 => 
          array (
            0 => 60,
            1 => 68,
            2 => 4201,
          ),
          2 => 'design/admin/templates/parts/my/menu.tpl',
        ),
      ),
      14 => 
      array (
        0 => 2,
        1 => false,
        2 => ' title="',
        3 => 
        array (
          0 => 
          array (
            0 => 60,
            1 => 68,
            2 => 4202,
          ),
          1 => 
          array (
            0 => 60,
            1 => 76,
            2 => 4210,
          ),
          2 => 'design/admin/templates/parts/my/menu.tpl',
        ),
      ),
      15 => 
      array (
        0 => 3,
        1 => false,
        2 => 
        array (
          0 => 
          array (
            0 => 1,
            1 => 'Change the left menu width to large size.',
            2 => false,
          ),
          1 => 
          array (
            0 => 6,
            1 => 
            array (
              0 => 'i18n',
              1 => 
              array (
                0 => 
                array (
                  0 => 1,
                  1 => 'design/admin/parts/user/menu',
                  2 => false,
                ),
              ),
            ),
            2 => false,
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            0 => 60,
            1 => 76,
            2 => 4211,
          ),
          1 => 
          array (
            0 => 60,
            1 => 158,
            2 => 4293,
          ),
          2 => 'design/admin/templates/parts/my/menu.tpl',
        ),
      ),
      16 => 
      array (
        0 => 2,
        1 => false,
        2 => '">',
        3 => 
        array (
          0 => 
          array (
            0 => 60,
            1 => 158,
            2 => 4294,
          ),
          1 => 
          array (
            0 => 60,
            1 => 160,
            2 => 4296,
          ),
          2 => 'design/admin/templates/parts/my/menu.tpl',
        ),
      ),
      17 => 
      array (
        0 => 3,
        1 => false,
        2 => 
        array (
          0 => 
          array (
            0 => 1,
            1 => 'Large',
            2 => false,
          ),
          1 => 
          array (
            0 => 6,
            1 => 
            array (
              0 => 'i18n',
              1 => 
              array (
                0 => 
                array (
                  0 => 1,
                  1 => 'design/admin/parts/user/menu',
                  2 => false,
                ),
              ),
            ),
            2 => false,
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            0 => 60,
            1 => 160,
            2 => 4297,
          ),
          1 => 
          array (
            0 => 60,
            1 => 206,
            2 => 4343,
          ),
          2 => 'design/admin/templates/parts/my/menu.tpl',
        ),
      ),
      18 => 
      array (
        0 => 2,
        1 => false,
        2 => '</a>
    ',
        3 => 
        array (
          0 => 
          array (
            0 => 60,
            1 => 206,
            2 => 4344,
          ),
          1 => 
          array (
            0 => 61,
            1 => 4,
            2 => 4353,
          ),
          2 => 'design/admin/templates/parts/my/menu.tpl',
        ),
      ),
    ),
    2 => 'case',
    3 => 
    array (
    ),
    4 => 
    array (
      0 => 
      array (
        0 => 57,
        1 => 4,
        2 => 3689,
      ),
      1 => 
      array (
        0 => 57,
        1 => 8,
        2 => 3693,
      ),
      2 => 'design/admin/templates/parts/my/menu.tpl',
    ),
  ),
  8 => 
  array (
    0 => 2,
    1 => false,
    2 => false,
    3 => 
    array (
      0 => 
      array (
        0 => 61,
        1 => 8,
        2 => 4360,
      ),
      1 => 
      array (
        0 => 62,
        1 => 0,
        2 => 4361,
      ),
      2 => 'design/admin/templates/parts/my/menu.tpl',
    ),
  ),
),
                       array (
  'match' => 
  array (
    0 => 
    array (
      0 => 6,
      1 => 
      array (
        0 => 'ezpreference',
        1 => 
        array (
          0 => 
          array (
            0 => 1,
            1 => 'admin_left_menu_size',
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
    0 => 38,
    1 => 0,
    2 => 1951,
  ),
  1 => 
  array (
    0 => 38,
    1 => 51,
    2 => 2002,
  ),
  2 => 'design/admin/templates/parts/my/menu.tpl',
),
                       $rootNamespace, $currentNamespace );
$text .= implode( '', $textElements );

$text .= '</p>
</div>


<div id="widthcontrol-handler" class="hide">
<div class="widthcontrol-grippy"></div>
</div>
';

$setArray = $oldSetArray_00de4028bb8a453da4f820dd4c05d9e5;
$tpl->Level--;
?>
