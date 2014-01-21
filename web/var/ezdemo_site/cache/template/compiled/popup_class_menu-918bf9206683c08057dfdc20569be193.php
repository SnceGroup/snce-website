<?php
// URI:       design/admin/templates/popupmenu/popup_class_menu.tpl
// Filename:  design/admin/templates/popupmenu/popup_class_menu.tpl
// Timestamp: 1383940876 (Fri Nov 8 21:01:16 CET 2013)
$oldSetArray_40feccc274a4c4447cbdda8ed1e6cfba = isset( $setArray ) ? $setArray : array();
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

$text .= '<!-- Class popup menu -->
<script type="text/javascript">
menuArray[\'ClassMenu\'] = { \'depth\': 0, \'headerID\': \'class-header\' };
menuArray[\'ClassMenu\'][\'elements\'] = {};
menuArray[\'ClassMenu\'][\'elements\'][\'class-view\'] = { \'url\': "/ezdemo_site_clean_admin/class/view/%classID%" };
menuArray[\'ClassMenu\'][\'elements\'][\'class-edit\'] = { \'url\': "/ezdemo_site_clean_admin/class/edit/%classID%" };
menuArray[\'ClassMenu\'][\'elements\'][\'view-cache-delete\'] = { \'url\': "/ezdemo_site_clean_admin/%currentURL%" };
menuArray[\'ClassMenu\'][\'elements\'][\'recursive-view-cache-delete\'] = { \'url\': "/ezdemo_site_clean_admin/%currentURL%" };
menuArray[\'ClassMenu\'][\'elements\'][\'class-createnodefeed\'] = { \'url\': "/ezdemo_site_clean_admin/content/view/full/%nodeID%" };
menuArray[\'ClassMenu\'][\'elements\'][\'class-createnodefeed\'][\'disabled_class\'] = \'menu-item-disabled\';
menuArray[\'ClassMenu\'][\'elements\'][\'class-createnodefeed\'][\'disabled_for\'] = { \'class-createnodefeed\': \'yes\' };
menuArray[\'ClassMenu\'][\'elements\'][\'class-removenodefeed\'] = { \'url\': "/ezdemo_site_clean_admin/content/view/full/%nodeID%" };
menuArray[\'ClassMenu\'][\'elements\'][\'class-removenodefeed\'][\'disabled_class\'] = \'menu-item-disabled\';
menuArray[\'ClassMenu\'][\'elements\'][\'class-removenodefeed\'][\'disabled_for\'] = { \'class-removenodefeed\': \'yes\' };
menuArray[\'ClassMenu\'][\'elements\'][\'class-history\'] = { \'url\': "/ezdemo_site_clean_admin/content/history/%objectID%" };
menuArray[\'ClassMenu\'][\'elements\'][\'class-history\'][\'disabled_class\'] = \'menu-item-disabled\';
menuArray[\'ClassMenu\'][\'elements\'][\'class-history\'][\'disabled_for\'] = { \'class-history\': \'yes\' };
menuArray[\'ClassMenu\'][\'elements\'][\'url-alias\'] = { \'url\': "/ezdemo_site_clean_admin/content/urlalias/%nodeID%" };
menuArray[\'ClassMenu\'][\'elements\'][\'url-alias\'][\'disabled_class\'] = \'menu-item-disabled\';
menuArray[\'ClassMenu\'][\'elements\'][\'url-alias\'][\'disabled_for\'] = { \'url-alias\': \'yes\' };
</script>

<div class="popupmenu" id="ClassMenu">
    <div class="popupmenuheader"><h3 id="class-header">XXX</h3>

        <div class="break"></div>
    </div>
    <a id="class-view" href="#" onmouseover="ezpopmenu_mouseOver( \'ClassMenu\' )">Guarda la classe</a>';
// if begins
unset( $if_cond );
unset( $if_cond );
$if_cond = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'multilingual_site', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['multilingual_site'] : null;
if (! isset( $if_cond ) ) $if_cond = NULL;
while ( is_object( $if_cond ) and method_exists( $if_cond, 'templateValue' ) )
    $if_cond = $if_cond->templateValue();

if ( $if_cond )
{
$text .= '    <a id="class-edit-in" class="more" href="#" onmouseover="ezpopmenu_showSubLevel( event, \'EditClassSubmenu\', \'class-edit-in\' ); return false;">Modifica classe in</a>';
}
else
{
$text .= '    <a id="class-edit" href="#" onmouseover="ezpopmenu_mouseOver( \'ClassMenu\' )">Modifica classe</a>';
}
unset( $if_cond );
// if ends

$text .= '
    <hr />
    <a id="view-cache-delete" href="#" onmouseover="ezpopmenu_mouseOver( \'ClassMenu\' )" onclick="ezpopmenu_submitForm( \'menu-form-view-cache-delete\' ); return false;">Cancella cache delle viste dei contenuti</a>
<!--
    <a id="template-cache-delete" href="#" onmouseover="ezpopmenu_mouseOver( \'ClassMenu\' )">Cancella cache dei template</a>
-->
    <a id="recursive-view-cache-delete" href="#" onmouseover="ezpopmenu_mouseOver( \'ClassMenu\' )" onclick="ezpopmenu_submitForm( \'menu-form-recursive-view-cache-delete\' ); return false;">Cancella cache delle viste dei contenuti partendo da qui</a>
    <hr />
    <a id="class-createnodefeed" href="#" onmouseover="ezpopmenu_mouseOver( \'ClassMenu\' )"
       onclick="ezpopmenu_submitForm( \'menu-form-createnodefeed\' ); return false;">Crea un flusso RSS/ATOM</a>
    <a id="class-removenodefeed" href="#" onmouseover="ezpopmenu_mouseOver( \'ClassMenu\' )"
       onclick="ezpopmenu_submitForm( \'menu-form-removenodefeed\' ); return false;">Elimina il flusso RSS/ATOM</a>
    <hr />
    <a id="override-view" class="more" href="#" onmouseover="ezpopmenu_hide(\'OverrideByClassSiteAccess\'); ezpopmenu_hide(\'OverrideByNodeSiteAccess\'); ezpopmenu_showSubLevel( event, \'OverrideSiteAccess\', \'override-view\' ); return false;">Template di override</a>
    <a id="override-by-class-view" class="more" href="#" onmouseover="ezpopmenu_hide(\'OverrideSiteAccess\'); ezpopmenu_hide(\'OverrideByNodeSiteAccess\'); ezpopmenu_showSubLevel( event, \'OverrideByClassSiteAccess\', \'override-by-class-view\' ); return false;">Nuovo override di classe</a>
    <a id="override-by-node-view" class="more" href="#" onmouseover="ezpopmenu_hide(\'OverrideSiteAccess\'); ezpopmenu_hide(\'OverrideByClassSiteAccess\'); ezpopmenu_showSubLevel( event, \'OverrideByNodeSiteAccess\', \'override-by-node-view\' ); return false;">Nuovo override di nodo</a>
    <hr />
    <a id="class-history" href="#" onmouseover="ezpopmenu_mouseOver( \'ClassMenu\' )">Gestisci versioni</a>
    <a id="url-alias" href="#" onmouseover="ezpopmenu_mouseOver( \'ClassMenu\' )">Gestisci gli URL alias</a>
    
    
    ';
// foreach begins
$skipDelimiter = true;
if ( !isset( $fe_variable_stack_fd143325d3ac3a17367bd268b54780e7_39 ) ) $fe_variable_stack_fd143325d3ac3a17367bd268b54780e7_39 = array();
$fe_variable_stack_fd143325d3ac3a17367bd268b54780e7_39[] = compact( 'fe_array_fd143325d3ac3a17367bd268b54780e7_39', 'fe_array_keys_fd143325d3ac3a17367bd268b54780e7_39', 'fe_n_items_fd143325d3ac3a17367bd268b54780e7_39', 'fe_n_items_processed_fd143325d3ac3a17367bd268b54780e7_39', 'fe_i_fd143325d3ac3a17367bd268b54780e7_39', 'fe_key_fd143325d3ac3a17367bd268b54780e7_39', 'fe_val_fd143325d3ac3a17367bd268b54780e7_39', 'fe_offset_fd143325d3ac3a17367bd268b54780e7_39', 'fe_max_fd143325d3ac3a17367bd268b54780e7_39', 'fe_reverse_fd143325d3ac3a17367bd268b54780e7_39', 'fe_first_val_fd143325d3ac3a17367bd268b54780e7_39', 'fe_last_val_fd143325d3ac3a17367bd268b54780e7_39' );
$fe_array_fd143325d3ac3a17367bd268b54780e7_39 = array (
);
$fe_array_keys_fd143325d3ac3a17367bd268b54780e7_39 = is_array( $fe_array_fd143325d3ac3a17367bd268b54780e7_39 ) ? array_keys( $fe_array_fd143325d3ac3a17367bd268b54780e7_39 ) : array();
$fe_n_items_fd143325d3ac3a17367bd268b54780e7_39 = count( $fe_array_keys_fd143325d3ac3a17367bd268b54780e7_39 );
$fe_n_items_processed_fd143325d3ac3a17367bd268b54780e7_39 = 0;
$fe_offset_fd143325d3ac3a17367bd268b54780e7_39 = 0;
$fe_max_fd143325d3ac3a17367bd268b54780e7_39 = $fe_n_items_fd143325d3ac3a17367bd268b54780e7_39 - $fe_offset_fd143325d3ac3a17367bd268b54780e7_39;
$fe_reverse_fd143325d3ac3a17367bd268b54780e7_39 = false;
if ( $fe_offset_fd143325d3ac3a17367bd268b54780e7_39 < 0 || $fe_offset_fd143325d3ac3a17367bd268b54780e7_39 >= $fe_n_items_fd143325d3ac3a17367bd268b54780e7_39 )
{
    $fe_offset_fd143325d3ac3a17367bd268b54780e7_39 = ( $fe_offset_fd143325d3ac3a17367bd268b54780e7_39 < 0 ) ? 0 : $fe_n_items_fd143325d3ac3a17367bd268b54780e7_39;
    if ( $fe_n_items_fd143325d3ac3a17367bd268b54780e7_39 || $fe_offset_fd143325d3ac3a17367bd268b54780e7_39 < 0 )
 {
        eZDebug::writeWarning("Invalid 'offset' parameter specified: '$fe_offset_fd143325d3ac3a17367bd268b54780e7_39'. Array count: $fe_n_items_fd143325d3ac3a17367bd268b54780e7_39");   
}
}
if ( $fe_max_fd143325d3ac3a17367bd268b54780e7_39 < 0 || $fe_offset_fd143325d3ac3a17367bd268b54780e7_39 + $fe_max_fd143325d3ac3a17367bd268b54780e7_39 > $fe_n_items_fd143325d3ac3a17367bd268b54780e7_39 )
{
    if ( $fe_max_fd143325d3ac3a17367bd268b54780e7_39 < 0 )
 eZDebug::writeWarning("Invalid 'max' parameter specified: $fe_max_fd143325d3ac3a17367bd268b54780e7_39");
    $fe_max_fd143325d3ac3a17367bd268b54780e7_39 = $fe_n_items_fd143325d3ac3a17367bd268b54780e7_39 - $fe_offset_fd143325d3ac3a17367bd268b54780e7_39;
}
if ( $fe_reverse_fd143325d3ac3a17367bd268b54780e7_39 )
{
    $fe_first_val_fd143325d3ac3a17367bd268b54780e7_39 = $fe_n_items_fd143325d3ac3a17367bd268b54780e7_39 - 1 - $fe_offset_fd143325d3ac3a17367bd268b54780e7_39;
    $fe_last_val_fd143325d3ac3a17367bd268b54780e7_39  = 0;
}
else
{
    $fe_first_val_fd143325d3ac3a17367bd268b54780e7_39 = $fe_offset_fd143325d3ac3a17367bd268b54780e7_39;
    $fe_last_val_fd143325d3ac3a17367bd268b54780e7_39  = $fe_n_items_fd143325d3ac3a17367bd268b54780e7_39 - 1;
}
// foreach
for ( $fe_i_fd143325d3ac3a17367bd268b54780e7_39 = $fe_first_val_fd143325d3ac3a17367bd268b54780e7_39; $fe_n_items_processed_fd143325d3ac3a17367bd268b54780e7_39 < $fe_max_fd143325d3ac3a17367bd268b54780e7_39 && ( $fe_reverse_fd143325d3ac3a17367bd268b54780e7_39 ? $fe_i_fd143325d3ac3a17367bd268b54780e7_39 >= $fe_last_val_fd143325d3ac3a17367bd268b54780e7_39 : $fe_i_fd143325d3ac3a17367bd268b54780e7_39 <= $fe_last_val_fd143325d3ac3a17367bd268b54780e7_39 ); $fe_reverse_fd143325d3ac3a17367bd268b54780e7_39 ? $fe_i_fd143325d3ac3a17367bd268b54780e7_39-- : $fe_i_fd143325d3ac3a17367bd268b54780e7_39++ )
{
$fe_key_fd143325d3ac3a17367bd268b54780e7_39 = $fe_array_keys_fd143325d3ac3a17367bd268b54780e7_39[$fe_i_fd143325d3ac3a17367bd268b54780e7_39];
$fe_val_fd143325d3ac3a17367bd268b54780e7_39 = $fe_array_fd143325d3ac3a17367bd268b54780e7_39[$fe_key_fd143325d3ac3a17367bd268b54780e7_39];
$vars[$rootNamespace]['template'] = $fe_val_fd143325d3ac3a17367bd268b54780e7_39;
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
    0 => 56,
    1 => 8,
    2 => 5269,
  ),
  1 => 
  array (
    0 => 56,
    1 => 49,
    2 => 5310,
  ),
  2 => 'design/admin/templates/popupmenu/popup_class_menu.tpl',
),
                       $rootNamespace, $currentNamespace );
$text .= implode( '', $textElements );

$text .= '    ';
$fe_n_items_processed_fd143325d3ac3a17367bd268b54780e7_39++;
} // foreach
$skipDelimiter = false;
if ( count( $fe_variable_stack_fd143325d3ac3a17367bd268b54780e7_39 ) ) extract( array_pop( $fe_variable_stack_fd143325d3ac3a17367bd268b54780e7_39 ) );

else
{

unset( $fe_array_fd143325d3ac3a17367bd268b54780e7_39 );

unset( $fe_array_keys_fd143325d3ac3a17367bd268b54780e7_39 );

unset( $fe_n_items_fd143325d3ac3a17367bd268b54780e7_39 );

unset( $fe_n_items_processed_fd143325d3ac3a17367bd268b54780e7_39 );

unset( $fe_i_fd143325d3ac3a17367bd268b54780e7_39 );

unset( $fe_key_fd143325d3ac3a17367bd268b54780e7_39 );

unset( $fe_val_fd143325d3ac3a17367bd268b54780e7_39 );

unset( $fe_offset_fd143325d3ac3a17367bd268b54780e7_39 );

unset( $fe_max_fd143325d3ac3a17367bd268b54780e7_39 );

unset( $fe_reverse_fd143325d3ac3a17367bd268b54780e7_39 );

unset( $fe_first_val_fd143325d3ac3a17367bd268b54780e7_39 );

unset( $fe_last_val_fd143325d3ac3a17367bd268b54780e7_39 );

unset( $fe_variable_stack_fd143325d3ac3a17367bd268b54780e7_39 );

}

// foreach ends
$text .= '</div>


<form id="menu-form-createnodefeed" method="post" action="/ezdemo_site_clean_admin/content/action">
  <input type="hidden" name="ContentObjectID" value="%objectID%" />
  <input type="hidden" name="NodeID" value="%nodeID%" />
  <input type="hidden" name="CreateNodeFeed" value="x" />
</form>


<form id="menu-form-removenodefeed" method="post" action="/ezdemo_site_clean_admin/content/action">
  <input type="hidden" name="ContentObjectID" value="%objectID%" />
  <input type="hidden" name="NodeID" value="%nodeID%" />
  <input type="hidden" name="RemoveNodeFeed" value="x" />
</form>


<form id="menu-form-view-cache-delete" method="post" action="/ezdemo_site_clean_admin/content/action">
  <input type="hidden" name="NodeID" value="%nodeID%" />
  <input type="hidden" name="ObjectID" value="%objectID%" />
  <input type="hidden" name="CurrentURL" value="%currentURL%" />
  <input type="hidden" name="ClearViewCacheButton" value="x" />
</form>


<form id="menu-form-recursive-view-cache-delete" method="post" action="/ezdemo_site_clean_admin/content/action">
  <input type="hidden" name="NodeID" value="%nodeID%" />
  <input type="hidden" name="ObjectID" value="%objectID%" />
  <input type="hidden" name="CurrentURL" value="%currentURL%" />
  <input type="hidden" name="ClearViewCacheSubtreeButton" value="x" />
</form>';

$setArray = $oldSetArray_40feccc274a4c4447cbdda8ed1e6cfba;
$tpl->Level--;
?>
