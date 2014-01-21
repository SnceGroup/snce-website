<?php
// URI:       design:parts/content/menu.tpl
// Filename:  design/admin/templates/parts/content/menu.tpl
// Timestamp: 1383940876 (Fri Nov 8 21:01:16 CET 2013)
$oldSetArray_3ffabcd3cffec47a47b558f90ce441aa = isset( $setArray ) ? $setArray : array();
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

$text .= '<div id="content-tree">

<div class="box-header"><div class="box-ml">
<h4>Struttura contenuti</h4>
</div></div>
<div class="box-bc"><div class="box-ml"><div class="box-content">


<div id="contentstructure">
    ';
$oldRestoreIncludeArray_ad2335d9822d7139c311e9ea182c3eaa = isset( $restoreIncludeArray ) ? $restoreIncludeArray : array();
$restoreIncludeArray = array();

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
$restoreIncludeArray = $oldRestoreIncludeArray_ad2335d9822d7139c311e9ea182c3eaa;

$text .= '</div>

';
// if begins
unset( $if_cond );
unset( $if_cond1 );
unset( $if_cond1 );
$if_cond1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'ui_context', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['ui_context'] : null;
if (! isset( $if_cond1 ) ) $if_cond1 = NULL;
while ( is_object( $if_cond1 ) and method_exists( $if_cond1, 'templateValue' ) )
    $if_cond1 = $if_cond1->templateValue();
$if_cond = ( ( $if_cond1 ) != ( 'browse' ) );
unset( $if_cond1 );
if (! isset( $if_cond ) ) $if_cond = NULL;
while ( is_object( $if_cond ) and method_exists( $if_cond, 'templateValue' ) )
    $if_cond = $if_cond->templateValue();

if ( $if_cond )
{
$text .= '<div id="trash">
<a class="image-text" href=';
unset( $var );
unset( $var1 );
$var1 = ( '/content/trash/' . 2 );
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

$text .= ' title="Guarda e gestisci i contenuti del cestino."><img src="/design/admin/images/trash-icon-16x16.gif" width="16" height="16" alt="Cestino" />&nbsp;<span>Cestino</span></a>
</div>';
}
unset( $if_cond );
// if ends

$text .= '
</div></div></div>
</div>

';
$oldRestoreIncludeArray_4e4cd0293dd1890539a1b585b0b647c0 = isset( $restoreIncludeArray ) ? $restoreIncludeArray : array();
$restoreIncludeArray = array();

if ( isset( $currentNamespace ) and isset( $vars[$currentNamespace]['ini_section'] ) )
    $restoreIncludeArray[] = array( $currentNamespace, 'ini_section', $vars[$currentNamespace]['ini_section'] );
elseif ( !isset( $vars[( isset( $currentNamespace ) ? $currentNamespace : '' )]['ini_section'] ) ) 
    $restoreIncludeArray[] = array( ( isset( $currentNamespace ) ? $currentNamespace : '' ), 'ini_section', 'unset' );

$vars[$currentNamespace]['ini_section'] = 'Leftmenu_content';
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
$restoreIncludeArray = $oldRestoreIncludeArray_4e4cd0293dd1890539a1b585b0b647c0;

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
        0 => 29,
        1 => 51,
        2 => 1294,
      ),
      1 => 
      array (
        0 => 30,
        1 => 4,
        2 => 1299,
      ),
      2 => 'design/admin/templates/parts/content/menu.tpl',
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
            0 => 30,
            1 => 23,
            2 => 1320,
          ),
          1 => 
          array (
            0 => 31,
            1 => 12,
            2 => 1333,
          ),
          2 => 'design/admin/templates/parts/content/menu.tpl',
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
            0 => 31,
            1 => 12,
            2 => 1334,
          ),
          1 => 
          array (
            0 => 31,
            1 => 68,
            2 => 1390,
          ),
          2 => 'design/admin/templates/parts/content/menu.tpl',
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
            0 => 31,
            1 => 68,
            2 => 1391,
          ),
          1 => 
          array (
            0 => 31,
            1 => 76,
            2 => 1399,
          ),
          2 => 'design/admin/templates/parts/content/menu.tpl',
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
                  1 => 'design/admin/parts/content/menu',
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
            0 => 31,
            1 => 76,
            2 => 1400,
          ),
          1 => 
          array (
            0 => 31,
            1 => 161,
            2 => 1485,
          ),
          2 => 'design/admin/templates/parts/content/menu.tpl',
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
            0 => 31,
            1 => 161,
            2 => 1486,
          ),
          1 => 
          array (
            0 => 31,
            1 => 163,
            2 => 1488,
          ),
          2 => 'design/admin/templates/parts/content/menu.tpl',
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
                  1 => 'design/admin/parts/content/menu',
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
            0 => 31,
            1 => 163,
            2 => 1489,
          ),
          1 => 
          array (
            0 => 31,
            1 => 212,
            2 => 1538,
          ),
          2 => 'design/admin/templates/parts/content/menu.tpl',
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
            0 => 31,
            1 => 212,
            2 => 1539,
          ),
          1 => 
          array (
            0 => 32,
            1 => 26,
            2 => 1570,
          ),
          2 => 'design/admin/templates/parts/content/menu.tpl',
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
                  1 => 'design/admin/parts/content/menu',
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
            0 => 32,
            1 => 26,
            2 => 1571,
          ),
          1 => 
          array (
            0 => 32,
            1 => 76,
            2 => 1621,
          ),
          2 => 'design/admin/templates/parts/content/menu.tpl',
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
            0 => 32,
            1 => 76,
            2 => 1622,
          ),
          1 => 
          array (
            0 => 33,
            1 => 12,
            2 => 1642,
          ),
          2 => 'design/admin/templates/parts/content/menu.tpl',
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
            0 => 33,
            1 => 12,
            2 => 1643,
          ),
          1 => 
          array (
            0 => 33,
            1 => 68,
            2 => 1699,
          ),
          2 => 'design/admin/templates/parts/content/menu.tpl',
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
            0 => 33,
            1 => 68,
            2 => 1700,
          ),
          1 => 
          array (
            0 => 33,
            1 => 76,
            2 => 1708,
          ),
          2 => 'design/admin/templates/parts/content/menu.tpl',
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
                  1 => 'design/admin/parts/content/menu',
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
            0 => 33,
            1 => 76,
            2 => 1709,
          ),
          1 => 
          array (
            0 => 33,
            1 => 161,
            2 => 1794,
          ),
          2 => 'design/admin/templates/parts/content/menu.tpl',
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
            0 => 33,
            1 => 161,
            2 => 1795,
          ),
          1 => 
          array (
            0 => 33,
            1 => 163,
            2 => 1797,
          ),
          2 => 'design/admin/templates/parts/content/menu.tpl',
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
                  1 => 'design/admin/parts/content/menu',
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
            0 => 33,
            1 => 163,
            2 => 1798,
          ),
          1 => 
          array (
            0 => 33,
            1 => 212,
            2 => 1847,
          ),
          2 => 'design/admin/templates/parts/content/menu.tpl',
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
            0 => 33,
            1 => 212,
            2 => 1848,
          ),
          1 => 
          array (
            0 => 34,
            1 => 4,
            2 => 1857,
          ),
          2 => 'design/admin/templates/parts/content/menu.tpl',
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
        0 => 30,
        1 => 4,
        2 => 1300,
      ),
      1 => 
      array (
        0 => 30,
        1 => 23,
        2 => 1319,
      ),
      2 => 'design/admin/templates/parts/content/menu.tpl',
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
        0 => 34,
        1 => 8,
        2 => 1864,
      ),
      1 => 
      array (
        0 => 36,
        1 => 4,
        2 => 1870,
      ),
      2 => 'design/admin/templates/parts/content/menu.tpl',
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
            0 => 36,
            1 => 22,
            2 => 1890,
          ),
          1 => 
          array (
            0 => 37,
            1 => 12,
            2 => 1903,
          ),
          2 => 'design/admin/templates/parts/content/menu.tpl',
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
            0 => 37,
            1 => 12,
            2 => 1904,
          ),
          1 => 
          array (
            0 => 37,
            1 => 68,
            2 => 1960,
          ),
          2 => 'design/admin/templates/parts/content/menu.tpl',
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
            0 => 37,
            1 => 68,
            2 => 1961,
          ),
          1 => 
          array (
            0 => 37,
            1 => 76,
            2 => 1969,
          ),
          2 => 'design/admin/templates/parts/content/menu.tpl',
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
                  1 => 'design/admin/parts/content/menu',
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
            0 => 37,
            1 => 76,
            2 => 1970,
          ),
          1 => 
          array (
            0 => 37,
            1 => 161,
            2 => 2055,
          ),
          2 => 'design/admin/templates/parts/content/menu.tpl',
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
            0 => 37,
            1 => 161,
            2 => 2056,
          ),
          1 => 
          array (
            0 => 37,
            1 => 163,
            2 => 2058,
          ),
          2 => 'design/admin/templates/parts/content/menu.tpl',
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
                  1 => 'design/admin/parts/content/menu',
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
            0 => 37,
            1 => 163,
            2 => 2059,
          ),
          1 => 
          array (
            0 => 37,
            1 => 212,
            2 => 2108,
          ),
          2 => 'design/admin/templates/parts/content/menu.tpl',
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
            0 => 37,
            1 => 212,
            2 => 2109,
          ),
          1 => 
          array (
            0 => 38,
            1 => 12,
            2 => 2126,
          ),
          2 => 'design/admin/templates/parts/content/menu.tpl',
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
            0 => 38,
            1 => 12,
            2 => 2127,
          ),
          1 => 
          array (
            0 => 38,
            1 => 69,
            2 => 2184,
          ),
          2 => 'design/admin/templates/parts/content/menu.tpl',
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
            0 => 38,
            1 => 69,
            2 => 2185,
          ),
          1 => 
          array (
            0 => 38,
            1 => 77,
            2 => 2193,
          ),
          2 => 'design/admin/templates/parts/content/menu.tpl',
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
                  1 => 'design/admin/parts/content/menu',
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
            0 => 38,
            1 => 77,
            2 => 2194,
          ),
          1 => 
          array (
            0 => 38,
            1 => 163,
            2 => 2280,
          ),
          2 => 'design/admin/templates/parts/content/menu.tpl',
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
            0 => 38,
            1 => 163,
            2 => 2281,
          ),
          1 => 
          array (
            0 => 38,
            1 => 165,
            2 => 2283,
          ),
          2 => 'design/admin/templates/parts/content/menu.tpl',
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
                  1 => 'design/admin/parts/content/menu',
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
            0 => 38,
            1 => 165,
            2 => 2284,
          ),
          1 => 
          array (
            0 => 38,
            1 => 215,
            2 => 2334,
          ),
          2 => 'design/admin/templates/parts/content/menu.tpl',
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
            0 => 38,
            1 => 215,
            2 => 2335,
          ),
          1 => 
          array (
            0 => 39,
            1 => 26,
            2 => 2366,
          ),
          2 => 'design/admin/templates/parts/content/menu.tpl',
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
                  1 => 'design/admin/parts/content/menu',
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
            0 => 39,
            1 => 26,
            2 => 2367,
          ),
          1 => 
          array (
            0 => 39,
            1 => 75,
            2 => 2416,
          ),
          2 => 'design/admin/templates/parts/content/menu.tpl',
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
            0 => 39,
            1 => 75,
            2 => 2417,
          ),
          1 => 
          array (
            0 => 40,
            1 => 4,
            2 => 2429,
          ),
          2 => 'design/admin/templates/parts/content/menu.tpl',
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
        0 => 36,
        1 => 4,
        2 => 1871,
      ),
      1 => 
      array (
        0 => 36,
        1 => 22,
        2 => 1889,
      ),
      2 => 'design/admin/templates/parts/content/menu.tpl',
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
        0 => 40,
        1 => 8,
        2 => 2436,
      ),
      1 => 
      array (
        0 => 42,
        1 => 4,
        2 => 2442,
      ),
      2 => 'design/admin/templates/parts/content/menu.tpl',
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
            0 => 42,
            1 => 32,
            2 => 2472,
          ),
          1 => 
          array (
            0 => 43,
            1 => 26,
            2 => 2499,
          ),
          2 => 'design/admin/templates/parts/content/menu.tpl',
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
                  1 => 'design/admin/parts/content/menu',
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
            0 => 43,
            1 => 26,
            2 => 2500,
          ),
          1 => 
          array (
            0 => 43,
            1 => 75,
            2 => 2549,
          ),
          2 => 'design/admin/templates/parts/content/menu.tpl',
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
            0 => 43,
            1 => 75,
            2 => 2550,
          ),
          1 => 
          array (
            0 => 44,
            1 => 12,
            2 => 2570,
          ),
          2 => 'design/admin/templates/parts/content/menu.tpl',
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
            0 => 44,
            1 => 12,
            2 => 2571,
          ),
          1 => 
          array (
            0 => 44,
            1 => 69,
            2 => 2628,
          ),
          2 => 'design/admin/templates/parts/content/menu.tpl',
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
            0 => 44,
            1 => 69,
            2 => 2629,
          ),
          1 => 
          array (
            0 => 44,
            1 => 77,
            2 => 2637,
          ),
          2 => 'design/admin/templates/parts/content/menu.tpl',
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
                  1 => 'design/admin/parts/content/menu',
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
            0 => 44,
            1 => 77,
            2 => 2638,
          ),
          1 => 
          array (
            0 => 44,
            1 => 163,
            2 => 2724,
          ),
          2 => 'design/admin/templates/parts/content/menu.tpl',
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
            0 => 44,
            1 => 163,
            2 => 2725,
          ),
          1 => 
          array (
            0 => 44,
            1 => 165,
            2 => 2727,
          ),
          2 => 'design/admin/templates/parts/content/menu.tpl',
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
                  1 => 'design/admin/parts/content/menu',
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
            0 => 44,
            1 => 165,
            2 => 2728,
          ),
          1 => 
          array (
            0 => 44,
            1 => 215,
            2 => 2778,
          ),
          2 => 'design/admin/templates/parts/content/menu.tpl',
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
            0 => 44,
            1 => 215,
            2 => 2779,
          ),
          1 => 
          array (
            0 => 45,
            1 => 12,
            2 => 2796,
          ),
          2 => 'design/admin/templates/parts/content/menu.tpl',
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
            0 => 45,
            1 => 12,
            2 => 2797,
          ),
          1 => 
          array (
            0 => 45,
            1 => 68,
            2 => 2853,
          ),
          2 => 'design/admin/templates/parts/content/menu.tpl',
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
            0 => 45,
            1 => 68,
            2 => 2854,
          ),
          1 => 
          array (
            0 => 45,
            1 => 76,
            2 => 2862,
          ),
          2 => 'design/admin/templates/parts/content/menu.tpl',
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
                  1 => 'design/admin/parts/content/menu',
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
            0 => 45,
            1 => 76,
            2 => 2863,
          ),
          1 => 
          array (
            0 => 45,
            1 => 161,
            2 => 2948,
          ),
          2 => 'design/admin/templates/parts/content/menu.tpl',
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
            0 => 45,
            1 => 161,
            2 => 2949,
          ),
          1 => 
          array (
            0 => 45,
            1 => 163,
            2 => 2951,
          ),
          2 => 'design/admin/templates/parts/content/menu.tpl',
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
                  1 => 'design/admin/parts/content/menu',
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
            0 => 45,
            1 => 163,
            2 => 2952,
          ),
          1 => 
          array (
            0 => 45,
            1 => 212,
            2 => 3001,
          ),
          2 => 'design/admin/templates/parts/content/menu.tpl',
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
            0 => 45,
            1 => 212,
            2 => 3002,
          ),
          1 => 
          array (
            0 => 46,
            1 => 4,
            2 => 3011,
          ),
          2 => 'design/admin/templates/parts/content/menu.tpl',
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
        0 => 42,
        1 => 4,
        2 => 2443,
      ),
      1 => 
      array (
        0 => 42,
        1 => 32,
        2 => 2471,
      ),
      2 => 'design/admin/templates/parts/content/menu.tpl',
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
        0 => 46,
        1 => 8,
        2 => 3018,
      ),
      1 => 
      array (
        0 => 48,
        1 => 4,
        2 => 3024,
      ),
      2 => 'design/admin/templates/parts/content/menu.tpl',
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
            0 => 48,
            1 => 8,
            2 => 3030,
          ),
          1 => 
          array (
            0 => 49,
            1 => 12,
            2 => 3043,
          ),
          2 => 'design/admin/templates/parts/content/menu.tpl',
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
            0 => 49,
            1 => 12,
            2 => 3044,
          ),
          1 => 
          array (
            0 => 49,
            1 => 68,
            2 => 3100,
          ),
          2 => 'design/admin/templates/parts/content/menu.tpl',
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
            0 => 49,
            1 => 68,
            2 => 3101,
          ),
          1 => 
          array (
            0 => 49,
            1 => 76,
            2 => 3109,
          ),
          2 => 'design/admin/templates/parts/content/menu.tpl',
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
                  1 => 'design/admin/parts/content/menu',
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
            0 => 49,
            1 => 76,
            2 => 3110,
          ),
          1 => 
          array (
            0 => 49,
            1 => 161,
            2 => 3195,
          ),
          2 => 'design/admin/templates/parts/content/menu.tpl',
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
            0 => 49,
            1 => 161,
            2 => 3196,
          ),
          1 => 
          array (
            0 => 49,
            1 => 163,
            2 => 3198,
          ),
          2 => 'design/admin/templates/parts/content/menu.tpl',
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
                  1 => 'design/admin/parts/content/menu',
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
            0 => 49,
            1 => 163,
            2 => 3199,
          ),
          1 => 
          array (
            0 => 49,
            1 => 212,
            2 => 3248,
          ),
          2 => 'design/admin/templates/parts/content/menu.tpl',
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
            0 => 49,
            1 => 212,
            2 => 3249,
          ),
          1 => 
          array (
            0 => 50,
            1 => 12,
            2 => 3266,
          ),
          2 => 'design/admin/templates/parts/content/menu.tpl',
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
            0 => 50,
            1 => 12,
            2 => 3267,
          ),
          1 => 
          array (
            0 => 50,
            1 => 69,
            2 => 3324,
          ),
          2 => 'design/admin/templates/parts/content/menu.tpl',
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
            0 => 50,
            1 => 69,
            2 => 3325,
          ),
          1 => 
          array (
            0 => 50,
            1 => 77,
            2 => 3333,
          ),
          2 => 'design/admin/templates/parts/content/menu.tpl',
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
                  1 => 'design/admin/parts/content/menu',
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
            0 => 50,
            1 => 77,
            2 => 3334,
          ),
          1 => 
          array (
            0 => 50,
            1 => 163,
            2 => 3420,
          ),
          2 => 'design/admin/templates/parts/content/menu.tpl',
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
            0 => 50,
            1 => 163,
            2 => 3421,
          ),
          1 => 
          array (
            0 => 50,
            1 => 165,
            2 => 3423,
          ),
          2 => 'design/admin/templates/parts/content/menu.tpl',
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
                  1 => 'design/admin/parts/content/menu',
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
            0 => 50,
            1 => 165,
            2 => 3424,
          ),
          1 => 
          array (
            0 => 50,
            1 => 215,
            2 => 3474,
          ),
          2 => 'design/admin/templates/parts/content/menu.tpl',
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
            0 => 50,
            1 => 215,
            2 => 3475,
          ),
          1 => 
          array (
            0 => 51,
            1 => 12,
            2 => 3492,
          ),
          2 => 'design/admin/templates/parts/content/menu.tpl',
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
            0 => 51,
            1 => 12,
            2 => 3493,
          ),
          1 => 
          array (
            0 => 51,
            1 => 68,
            2 => 3549,
          ),
          2 => 'design/admin/templates/parts/content/menu.tpl',
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
            0 => 51,
            1 => 68,
            2 => 3550,
          ),
          1 => 
          array (
            0 => 51,
            1 => 76,
            2 => 3558,
          ),
          2 => 'design/admin/templates/parts/content/menu.tpl',
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
                  1 => 'design/admin/parts/content/menu',
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
            0 => 51,
            1 => 76,
            2 => 3559,
          ),
          1 => 
          array (
            0 => 51,
            1 => 161,
            2 => 3644,
          ),
          2 => 'design/admin/templates/parts/content/menu.tpl',
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
            0 => 51,
            1 => 161,
            2 => 3645,
          ),
          1 => 
          array (
            0 => 51,
            1 => 163,
            2 => 3647,
          ),
          2 => 'design/admin/templates/parts/content/menu.tpl',
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
                  1 => 'design/admin/parts/content/menu',
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
            0 => 51,
            1 => 163,
            2 => 3648,
          ),
          1 => 
          array (
            0 => 51,
            1 => 212,
            2 => 3697,
          ),
          2 => 'design/admin/templates/parts/content/menu.tpl',
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
            0 => 51,
            1 => 212,
            2 => 3698,
          ),
          1 => 
          array (
            0 => 52,
            1 => 4,
            2 => 3707,
          ),
          2 => 'design/admin/templates/parts/content/menu.tpl',
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
        0 => 48,
        1 => 4,
        2 => 3025,
      ),
      1 => 
      array (
        0 => 48,
        1 => 8,
        2 => 3029,
      ),
      2 => 'design/admin/templates/parts/content/menu.tpl',
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
        0 => 52,
        1 => 8,
        2 => 3714,
      ),
      1 => 
      array (
        0 => 53,
        1 => 0,
        2 => 3715,
      ),
      2 => 'design/admin/templates/parts/content/menu.tpl',
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
    0 => 29,
    1 => 0,
    2 => 1242,
  ),
  1 => 
  array (
    0 => 29,
    1 => 51,
    2 => 1293,
  ),
  2 => 'design/admin/templates/parts/content/menu.tpl',
),
                       $rootNamespace, $currentNamespace );
$text .= implode( '', $textElements );

$text .= '</p>
</div>


<div id="widthcontrol-handler" class="hide">
<div class="widthcontrol-grippy"></div>
</div>
';

$setArray = $oldSetArray_3ffabcd3cffec47a47b558f90ce441aa;
$tpl->Level--;
?>
