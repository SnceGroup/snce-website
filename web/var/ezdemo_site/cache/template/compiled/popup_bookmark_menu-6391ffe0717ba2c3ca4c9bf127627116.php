<?php
// URI:       design/admin/templates/popupmenu/popup_bookmark_menu.tpl
// Filename:  design/admin/templates/popupmenu/popup_bookmark_menu.tpl
// Timestamp: 1383940876 (Fri Nov 8 21:01:16 CET 2013)
$oldSetArray_c5dc003f9c4768180a6ed2f2748fa4ce = isset( $setArray ) ? $setArray : array();
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

$text .= '<!-- Bookmark popup menu -->
<script type="text/javascript">
menuArray[\'BookmarkMenu\'] = { \'depth\': 0, \'headerID\': \'bookmark-header\' };
menuArray[\'BookmarkMenu\'][\'elements\'] = {};
menuArray[\'BookmarkMenu\'][\'elements\'][\'bookmark-view\'] = { \'url\': "/ezdemo_site_clean_admin/content/view/full/%nodeID%" };
menuArray[\'BookmarkMenu\'][\'elements\'][\'bookmark-edit\'] = { \'url\': "/ezdemo_site_clean_admin/content/edit/%objectID%" };
</script>

<div class="popupmenu" id="BookmarkMenu">
    <div class="popupmenuheader"><h3 id="bookmark-header">XXX</h3>

        <div class="break"></div>
    </div>
    <a id="bookmark-view" href="#" onmouseover="ezpopmenu_mouseOver( \'BookmarkMenu\' )">Vedi</a>';
// if begins
unset( $if_cond );
unset( $if_cond );
$if_cond = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'multilingual_site', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['multilingual_site'] : null;
if (! isset( $if_cond ) ) $if_cond = NULL;
while ( is_object( $if_cond ) and method_exists( $if_cond, 'templateValue' ) )
    $if_cond = $if_cond->templateValue();

if ( $if_cond )
{
$text .= '    <a id="bookmark-edit-in" class="more" href="#" onmouseover="ezpopmenu_showSubLevel( event, \'EditSubmenu\', \'bookmark-edit-in\' ); return false;">Modifica in</a>';
}
else
{
$text .= '    <a id="bookmark-edit" href="#" onmouseover="ezpopmenu_mouseOver( \'BookmarkMenu\' )">Modifica</a>';
}
unset( $if_cond );
// if ends

$text .= '    <hr />
    <a id="bookmark-remove" href="#" onmouseover="ezpopmenu_mouseOver( \'BookmarkMenu\' )"
        onclick="ezpopmenu_submitForm( \'menu-form-removebookmark\' ); return false;">Elimina il segnalibro</a>

    
    ';
// foreach begins
$skipDelimiter = true;
if ( !isset( $fe_variable_stack_7148f3ee5b36ee2661bb77851cf1dd14_40 ) ) $fe_variable_stack_7148f3ee5b36ee2661bb77851cf1dd14_40 = array();
$fe_variable_stack_7148f3ee5b36ee2661bb77851cf1dd14_40[] = compact( 'fe_array_7148f3ee5b36ee2661bb77851cf1dd14_40', 'fe_array_keys_7148f3ee5b36ee2661bb77851cf1dd14_40', 'fe_n_items_7148f3ee5b36ee2661bb77851cf1dd14_40', 'fe_n_items_processed_7148f3ee5b36ee2661bb77851cf1dd14_40', 'fe_i_7148f3ee5b36ee2661bb77851cf1dd14_40', 'fe_key_7148f3ee5b36ee2661bb77851cf1dd14_40', 'fe_val_7148f3ee5b36ee2661bb77851cf1dd14_40', 'fe_offset_7148f3ee5b36ee2661bb77851cf1dd14_40', 'fe_max_7148f3ee5b36ee2661bb77851cf1dd14_40', 'fe_reverse_7148f3ee5b36ee2661bb77851cf1dd14_40', 'fe_first_val_7148f3ee5b36ee2661bb77851cf1dd14_40', 'fe_last_val_7148f3ee5b36ee2661bb77851cf1dd14_40' );
$fe_array_7148f3ee5b36ee2661bb77851cf1dd14_40 = array (
);
$fe_array_keys_7148f3ee5b36ee2661bb77851cf1dd14_40 = is_array( $fe_array_7148f3ee5b36ee2661bb77851cf1dd14_40 ) ? array_keys( $fe_array_7148f3ee5b36ee2661bb77851cf1dd14_40 ) : array();
$fe_n_items_7148f3ee5b36ee2661bb77851cf1dd14_40 = count( $fe_array_keys_7148f3ee5b36ee2661bb77851cf1dd14_40 );
$fe_n_items_processed_7148f3ee5b36ee2661bb77851cf1dd14_40 = 0;
$fe_offset_7148f3ee5b36ee2661bb77851cf1dd14_40 = 0;
$fe_max_7148f3ee5b36ee2661bb77851cf1dd14_40 = $fe_n_items_7148f3ee5b36ee2661bb77851cf1dd14_40 - $fe_offset_7148f3ee5b36ee2661bb77851cf1dd14_40;
$fe_reverse_7148f3ee5b36ee2661bb77851cf1dd14_40 = false;
if ( $fe_offset_7148f3ee5b36ee2661bb77851cf1dd14_40 < 0 || $fe_offset_7148f3ee5b36ee2661bb77851cf1dd14_40 >= $fe_n_items_7148f3ee5b36ee2661bb77851cf1dd14_40 )
{
    $fe_offset_7148f3ee5b36ee2661bb77851cf1dd14_40 = ( $fe_offset_7148f3ee5b36ee2661bb77851cf1dd14_40 < 0 ) ? 0 : $fe_n_items_7148f3ee5b36ee2661bb77851cf1dd14_40;
    if ( $fe_n_items_7148f3ee5b36ee2661bb77851cf1dd14_40 || $fe_offset_7148f3ee5b36ee2661bb77851cf1dd14_40 < 0 )
 {
        eZDebug::writeWarning("Invalid 'offset' parameter specified: '$fe_offset_7148f3ee5b36ee2661bb77851cf1dd14_40'. Array count: $fe_n_items_7148f3ee5b36ee2661bb77851cf1dd14_40");   
}
}
if ( $fe_max_7148f3ee5b36ee2661bb77851cf1dd14_40 < 0 || $fe_offset_7148f3ee5b36ee2661bb77851cf1dd14_40 + $fe_max_7148f3ee5b36ee2661bb77851cf1dd14_40 > $fe_n_items_7148f3ee5b36ee2661bb77851cf1dd14_40 )
{
    if ( $fe_max_7148f3ee5b36ee2661bb77851cf1dd14_40 < 0 )
 eZDebug::writeWarning("Invalid 'max' parameter specified: $fe_max_7148f3ee5b36ee2661bb77851cf1dd14_40");
    $fe_max_7148f3ee5b36ee2661bb77851cf1dd14_40 = $fe_n_items_7148f3ee5b36ee2661bb77851cf1dd14_40 - $fe_offset_7148f3ee5b36ee2661bb77851cf1dd14_40;
}
if ( $fe_reverse_7148f3ee5b36ee2661bb77851cf1dd14_40 )
{
    $fe_first_val_7148f3ee5b36ee2661bb77851cf1dd14_40 = $fe_n_items_7148f3ee5b36ee2661bb77851cf1dd14_40 - 1 - $fe_offset_7148f3ee5b36ee2661bb77851cf1dd14_40;
    $fe_last_val_7148f3ee5b36ee2661bb77851cf1dd14_40  = 0;
}
else
{
    $fe_first_val_7148f3ee5b36ee2661bb77851cf1dd14_40 = $fe_offset_7148f3ee5b36ee2661bb77851cf1dd14_40;
    $fe_last_val_7148f3ee5b36ee2661bb77851cf1dd14_40  = $fe_n_items_7148f3ee5b36ee2661bb77851cf1dd14_40 - 1;
}
// foreach
for ( $fe_i_7148f3ee5b36ee2661bb77851cf1dd14_40 = $fe_first_val_7148f3ee5b36ee2661bb77851cf1dd14_40; $fe_n_items_processed_7148f3ee5b36ee2661bb77851cf1dd14_40 < $fe_max_7148f3ee5b36ee2661bb77851cf1dd14_40 && ( $fe_reverse_7148f3ee5b36ee2661bb77851cf1dd14_40 ? $fe_i_7148f3ee5b36ee2661bb77851cf1dd14_40 >= $fe_last_val_7148f3ee5b36ee2661bb77851cf1dd14_40 : $fe_i_7148f3ee5b36ee2661bb77851cf1dd14_40 <= $fe_last_val_7148f3ee5b36ee2661bb77851cf1dd14_40 ); $fe_reverse_7148f3ee5b36ee2661bb77851cf1dd14_40 ? $fe_i_7148f3ee5b36ee2661bb77851cf1dd14_40-- : $fe_i_7148f3ee5b36ee2661bb77851cf1dd14_40++ )
{
$fe_key_7148f3ee5b36ee2661bb77851cf1dd14_40 = $fe_array_keys_7148f3ee5b36ee2661bb77851cf1dd14_40[$fe_i_7148f3ee5b36ee2661bb77851cf1dd14_40];
$fe_val_7148f3ee5b36ee2661bb77851cf1dd14_40 = $fe_array_7148f3ee5b36ee2661bb77851cf1dd14_40[$fe_key_7148f3ee5b36ee2661bb77851cf1dd14_40];
$vars[$rootNamespace]['template'] = $fe_val_7148f3ee5b36ee2661bb77851cf1dd14_40;
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
    0 => 26,
    1 => 8,
    2 => 1638,
  ),
  1 => 
  array (
    0 => 26,
    1 => 49,
    2 => 1679,
  ),
  2 => 'design/admin/templates/popupmenu/popup_bookmark_menu.tpl',
),
                       $rootNamespace, $currentNamespace );
$text .= implode( '', $textElements );

$text .= '    ';
$fe_n_items_processed_7148f3ee5b36ee2661bb77851cf1dd14_40++;
} // foreach
$skipDelimiter = false;
if ( count( $fe_variable_stack_7148f3ee5b36ee2661bb77851cf1dd14_40 ) ) extract( array_pop( $fe_variable_stack_7148f3ee5b36ee2661bb77851cf1dd14_40 ) );

else
{

unset( $fe_array_7148f3ee5b36ee2661bb77851cf1dd14_40 );

unset( $fe_array_keys_7148f3ee5b36ee2661bb77851cf1dd14_40 );

unset( $fe_n_items_7148f3ee5b36ee2661bb77851cf1dd14_40 );

unset( $fe_n_items_processed_7148f3ee5b36ee2661bb77851cf1dd14_40 );

unset( $fe_i_7148f3ee5b36ee2661bb77851cf1dd14_40 );

unset( $fe_key_7148f3ee5b36ee2661bb77851cf1dd14_40 );

unset( $fe_val_7148f3ee5b36ee2661bb77851cf1dd14_40 );

unset( $fe_offset_7148f3ee5b36ee2661bb77851cf1dd14_40 );

unset( $fe_max_7148f3ee5b36ee2661bb77851cf1dd14_40 );

unset( $fe_reverse_7148f3ee5b36ee2661bb77851cf1dd14_40 );

unset( $fe_first_val_7148f3ee5b36ee2661bb77851cf1dd14_40 );

unset( $fe_last_val_7148f3ee5b36ee2661bb77851cf1dd14_40 );

unset( $fe_variable_stack_7148f3ee5b36ee2661bb77851cf1dd14_40 );

}

// foreach ends
$text .= '</div>


<form id="menu-form-removebookmark" method="post" action="/ezdemo_site_clean_admin/content/bookmark">
  <input type="hidden" name="DeleteIDArray[]" value="%bookmarkID%" />
  <input type="hidden" name="RemoveButton" value="x" />
  <input type="hidden" name="NeedRedirectBack" value="x" />
</form>';

$setArray = $oldSetArray_c5dc003f9c4768180a6ed2f2748fa4ce;
$tpl->Level--;
?>
