<?php
// URI:       design/admin/templates/popupmenu/popup_subitems_menu.tpl
// Filename:  design/admin/templates/popupmenu/popup_subitems_menu.tpl
// Timestamp: 1383940876 (Fri Nov 8 21:01:16 CET 2013)
$oldSetArray_8310689b695f21c9e2e542518541fb07 = isset( $setArray ) ? $setArray : array();
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

$text .= '<!-- Subitems icon click popup menu -->
<script type="text/javascript">
menuArray[\'SubitemsContextMenu\'] = { \'depth\': 0, \'headerID\': \'child-menu-header\' };
menuArray[\'SubitemsContextMenu\'][\'elements\'] = {};
//menuArray[\'SubitemsContextMenu\'][\'elements\'][\'child-menu-view\'] = { \'url\': "/ezdemo_site_clean_admin/content/view/full/%nodeID%" };
menuArray[\'SubitemsContextMenu\'][\'elements\'][\'child-menu-preview\'] = { \'url\': "/ezdemo_site_clean_admin/content/versionview/%objectID%/%version%" };
menuArray[\'SubitemsContextMenu\'][\'elements\'][\'child-menu-edit\'] = { \'url\': "/ezdemo_site_clean_admin/content/edit/%objectID%" };
menuArray[\'SubitemsContextMenu\'][\'elements\'][\'child-menu-copy\'] = { \'url\': "/ezdemo_site_clean_admin/content/copy/%objectID%" };
menuArray[\'SubitemsContextMenu\'][\'elements\'][\'child-menu-copy-subtree\'] = { \'url\': "/ezdemo_site_clean_admin/content/copysubtree/%nodeID%" };
menuArray[\'SubitemsContextMenu\'][\'elements\'][\'child-menu-create-here\'] = { \'disabled_class\': \'menu-item-disabled\' };
</script>

<div class="popupmenu" id="SubitemsContextMenu">
    <div class="popupmenuheader"><h3 id="child-menu-header">XXX</h3>

        <div class="break"></div>
    </div>

    <a id="child-menu-preview" href="#" onmouseover="ezpopmenu_mouseOver( \'SubitemsContextMenu\' )">Anteprima</a>';
// if begins
unset( $if_cond );
unset( $if_cond );
$if_cond = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'multilingual_site', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['multilingual_site'] : null;
if (! isset( $if_cond ) ) $if_cond = NULL;
while ( is_object( $if_cond ) and method_exists( $if_cond, 'templateValue' ) )
    $if_cond = $if_cond->templateValue();

if ( $if_cond )
{
$text .= '    <a id="child-menu-edit-in" class="more" href="#" onmouseover="ezpopmenu_showSubLevel( event, \'EditSubmenu\', \'child-menu-edit-in\' ); return false;">Modifica in</a>';
}
else
{
$text .= '    <a id="child-menu-edit" href="#" onmouseover="ezpopmenu_mouseOver( \'SubitemsContextMenu\' )">Modifica</a>';
}
unset( $if_cond );
// if ends

$text .= '    <hr />
    <a id="child-menu-copy" href="#" onmouseover="ezpopmenu_mouseOver( \'SubitemsContextMenu\' )">Copia</a>
    <a id="child-menu-copy-subtree" href="#" onmouseover="ezpopmenu_mouseOver( \'SubitemsContextMenu\' )">Copia il sotto-albero</a>
    <a id="child-menu-move" href="#" onmouseover="ezpopmenu_mouseOver( \'SubitemsContextMenu\' )"
       onclick="ezpopmenu_submitForm( \'menu-form-move\' ); return false;">Sposta</a>
    <a id="child-menu-remove" href="#" onmouseover="ezpopmenu_mouseOver( \'SubitemsContextMenu\' )"
       onclick="ezpopmenu_submitForm( \'menu-form-remove\' ); return false;">Elimina</a>
    <a id="child-menu-advanced" class="more" href="#" onmouseover="ezpopmenu_showSubLevel( event, \'Advanced\', \'child-menu-advanced\' ); return false;">Avanzata</a>
    <hr />
    <a id="child-menu-bookmark" href="#" onmouseover="ezpopmenu_mouseOver( \'SubitemsContextMenu\' )"
       onclick="ezpopmenu_submitForm( \'menu-form-addbookmark\' ); return false;">Aggiungi ai miei preferiti</a>
    <a id="child-menu-notify" href="#" onmouseover="ezpopmenu_mouseOver( \'SubitemsContextMenu\' )"
       onclick="ezpopmenu_submitForm( \'menu-form-notify\' ); return false;">Aggiungi alle mie notifiche</a>

    <a id="child-menu-create-here" class="more" href="#" onmouseover="ezpopmenu_showSubLevel( event, \'CreateHereMenu\', \'child-menu-create-here\' ); return false;">Crea qui</a>

    
    ';
$loopItem = array (
  0 => 'node/oosubitemscontextmenu.tpl',
  1 => 'node/ezflsubitemscontextmenu.tpl',
  2 => 'node/ezmusubitemscontextmenu.tpl',
);
if ( !isset( $sectionStack ) )
    $sectionStack = array();
$variableValue = new eZTemplateSectionIterator();
$lastVariableValue = false;
$index = 0;
$currentIndex = 1;
if ( is_array( $loopItem ) )
{
    $loopKeys = array_keys( $loopItem );
    $loopCount = count( $loopKeys );
}
else if ( is_numeric( $loopItem ) )
{
    $loopKeys = false;
    if ( $loopItem < 0 )
        $loopCountValue = -$loopItem;
    else
        $loopCountValue = $loopItem;
    $loopCount = $loopCountValue - 0;
}
else if ( is_string( $loopItem ) )
{
    $loopKeys = false;
    $loopCount = strlen( $loopItem ) - 0;
}
else
{
    $loopKeys = false;
    $loopCount = 0;
}
while ( $index < $loopCount )
{
    if ( is_array( $loopItem ) )
    {
        $loopKey = $loopKeys[$index];
        unset( $item );
        $item = $loopItem[$loopKey];
    }
    else if ( is_numeric( $loopItem ) )
    {
        unset( $item );
        $item = $index + 0 + 1;
        if ( $loopItem < 0 )
            $item = -$item;
        $loopKey = $index + 0;
    }
    else if ( is_string( $loopItem ) )
    {
        unset( $item );
        $loopKey = $index + 0;
        $item = $loopItem[$loopKey];
    }
    unset( $last );
    $last = false;

    $variableValue->setIteratorValues( $item, $loopKey, $currentIndex - 1, $currentIndex, false, $last );
$vars[$currentNamespace]['template'] = $variableValue;
$sectionStack[] = array( &$variableValue, &$loopItem, $loopKeys, $loopCount, $currentIndex, $index );
unset( $loopItem, $loopKeys );

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
              2 => 'template',
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
    0 => 43,
    1 => 8,
    2 => 3833,
  ),
  1 => 
  array (
    0 => 43,
    1 => 49,
    2 => 3874,
  ),
  2 => 'design/admin/templates/popupmenu/popup_subitems_menu.tpl',
),
                       $rootNamespace, $currentNamespace );
$text .= implode( '', $textElements );

$text .= '    ';
list( $variableValue, $loopItem, $loopKeys, $loopCount, $currentIndex, $index ) = array_pop( $sectionStack );
++$currentIndex;

$lastVariableValue = $variableValue;
++$index;

}
unset( $loopKeys, $loopCount, $index, $last, $loopIndex, $loopItem );
$text .= '</div>';

$setArray = $oldSetArray_8310689b695f21c9e2e542518541fb07;
$tpl->Level--;
?>
