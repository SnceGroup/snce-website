<?php
// URI:       design/admin/templates/page_search.tpl
// Filename:  design/admin/templates/page_search.tpl
// Timestamp: 1383940876 (Fri Nov 8 21:01:16 CET 2013)
$oldSetArray_743cef8e0e49846096d097f9c8432f61 = isset( $setArray ) ? $setArray : array();
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

// def $search_node_id
unset( $var );
unset( $var1 );
unset( $var1 );
$var1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( "search_subtree_array", $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]["search_subtree_array"] : null;
$var2 = compiledFetchAttribute( $var1, 0 );
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
    unset( $var2 );
unset( $var2 );
$var2 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( "module_result", $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]["module_result"] : null;
$var3 = compiledFetchAttribute( $var2, "path" );
unset( $var2 );
$var2 = $var3;
$var3 = compiledFetchAttribute( $var2, 0 );
unset( $var2 );
$var2 = $var3;
$var3 = compiledFetchAttribute( $var2, "node_id" );
unset( $var2 );
$var2 = $var3;
if (! isset( $var2 ) ) $var2 = NULL;
while ( is_object( $var2 ) and method_exists( $var2, 'templateValue' ) )
    $var2 = $var2->templateValue();
while ( is_object( $var2 ) and method_exists( $var2, 'templateValue' ) )
    $var2 = $var2->templateValue();

    if ( isset( $var2 ) )
    {
        $var = $var2;
    }
    else
    {
        $var = 1;
    }
}
unset( $var1, $var2 );
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
if ( $tpl->hasVariable( 'search_node_id', $rootNamespace ) )
{
    $tpl->warning( 'def', "Variable 'search_node_id' is already defined.", array (
  0 => 
  array (
    0 => 1,
    1 => 0,
    2 => 1,
  ),
  1 => 
  array (
    0 => 3,
    1 => 21,
    2 => 196,
  ),
  2 => 'design/admin/templates/page_search.tpl',
) );
    $tpl->setVariable( 'search_node_id', $var, $rootNamespace );
}
else
{
    $tpl->setLocalVariable( 'search_node_id', $var, $rootNamespace );
}

// def $search_title
if ( $tpl->hasVariable( 'search_title', $rootNamespace ) )
{
    $tpl->warning( 'def', "Variable 'search_title' is already defined.", array (
  0 => 
  array (
    0 => 1,
    1 => 0,
    2 => 1,
  ),
  1 => 
  array (
    0 => 3,
    1 => 21,
    2 => 196,
  ),
  2 => 'design/admin/templates/page_search.tpl',
) );
    $tpl->setVariable( 'search_title', 'Cerca in tutti i contenuti', $rootNamespace );
}
else
{
    $tpl->setLocalVariable( 'search_title', 'Cerca in tutti i contenuti', $rootNamespace );
}

// def $section_id
if ( $tpl->hasVariable( 'section_id', $rootNamespace ) )
{
    $tpl->warning( 'def', "Variable 'section_id' is already defined.", array (
  0 => 
  array (
    0 => 1,
    1 => 0,
    2 => 1,
  ),
  1 => 
  array (
    0 => 3,
    1 => 21,
    2 => 196,
  ),
  2 => 'design/admin/templates/page_search.tpl',
) );
    $tpl->setVariable( 'section_id', -1, $rootNamespace );
}
else
{
    $tpl->setLocalVariable( 'section_id', -1, $rootNamespace );
}

// if begins
unset( $if_cond );
if (! isset( $if_cond ) ) $if_cond = NULL;
while ( is_object( $if_cond ) and method_exists( $if_cond, 'templateValue' ) )
    $if_cond = $if_cond->templateValue();
$if_condData = array( 'value' => $if_cond );
$tpl->processOperator( 'ezhttp_hasvariable',
                       array (
  0 => 
  array (
    0 => 
    array (
      0 => 1,
      1 => 'SectionID',
      2 => false,
    ),
  ),
  1 => 
  array (
    0 => 
    array (
      0 => 1,
      1 => 'get',
      2 => false,
    ),
  ),
),
                       $rootNamespace, $currentNamespace, $if_condData, false, false );
$if_cond = $if_condData['value'];
unset( $if_condData );
if (! isset( $if_cond ) ) $if_cond = NULL;
while ( is_object( $if_cond ) and method_exists( $if_cond, 'templateValue' ) )
    $if_cond = $if_cond->templateValue();

if ( $if_cond )
{
$text .= '    ';
unset( $var );
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
$varData = array( 'value' => $var );
$tpl->processOperator( 'ezhttp',
                       array (
  0 => 
  array (
    0 => 
    array (
      0 => 1,
      1 => 'SectionID',
      2 => false,
    ),
  ),
  1 => 
  array (
    0 => 
    array (
      0 => 1,
      1 => 'get',
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
if ( array_key_exists( $currentNamespace, $vars ) && array_key_exists( 'section_id', $vars[$currentNamespace] ) )
{
    $vars[$currentNamespace]['section_id'] = $var;
    unset( $var );
}
}
unset( $if_cond );
// if ends

$text .= '<div class="searchblock">
<form action="/ezdemo_site_clean_admin/content/search" method="get">
    ';
// if begins
unset( $if_cond );
unset( $if_cond );
$if_cond = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'ui_context_edit', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['ui_context_edit'] : null;
if (! isset( $if_cond ) ) $if_cond = NULL;
while ( is_object( $if_cond ) and method_exists( $if_cond, 'templateValue' ) )
    $if_cond = $if_cond->templateValue();

if ( $if_cond )
{
$text .= '        <input id="searchtext" name="SearchText" class="disabled" type="text" size="20" value="';
// if begins
unset( $if_cond );
unset( $if_cond1 );
unset( $if_cond1 );
$if_cond1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'search_text', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['search_text'] : null;
if (! isset( $if_cond1 ) ) $if_cond1 = NULL;
while ( is_object( $if_cond1 ) and method_exists( $if_cond1, 'templateValue' ) )
    $if_cond1 = $if_cond1->templateValue();
$if_cond = isset( $if_cond1 );unset( $if_cond1 );
if (! isset( $if_cond ) ) $if_cond = NULL;
while ( is_object( $if_cond ) and method_exists( $if_cond, 'templateValue' ) )
    $if_cond = $if_cond->templateValue();

if ( $if_cond )
{
unset( $var );
unset( $var1 );
unset( $var1 );
$var1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'search_text', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['search_text'] : null;
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

}
unset( $if_cond );
// if ends

$text .= '" disabled="disabled" title="';
unset( $var );
unset( $var1 );
unset( $var1 );
$var1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'search_title', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['search_title'] : null;
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

$text .= '" />
        <input id="searchbutton" class="button-disabled hide" name="SearchButton" type="submit" value="Cerca" disabled="disabled" />
        <p class="advanced hide"><span class="disabled">Avanzata</span></p>
    ';
}
else
{
$text .= '        ';
// if begins
unset( $if_cond );
unset( $if_cond1 );
unset( $if_cond1 );
$if_cond1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'search_node_id', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['search_node_id'] : null;
if (! isset( $if_cond1 ) ) $if_cond1 = NULL;
while ( is_object( $if_cond1 ) and method_exists( $if_cond1, 'templateValue' ) )
    $if_cond1 = $if_cond1->templateValue();
$if_cond = ( ( $if_cond1 ) > ( 1 ) );
unset( $if_cond1 );
if (! isset( $if_cond ) ) $if_cond = NULL;
while ( is_object( $if_cond ) and method_exists( $if_cond, 'templateValue' ) )
    $if_cond = $if_cond->templateValue();

if ( $if_cond )
{
$text .= '            ';
unset( $var );
unset( $var2 );
unset( $var3 );
unset( $var4 );
unset( $var4 );
$var4 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'search_node_id', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['search_node_id'] : null;
if (! isset( $var4 ) ) $var4 = NULL;
while ( is_object( $var4 ) and method_exists( $var4, 'templateValue' ) )
    $var4 = $var4->templateValue();
while ( is_object( $var4 ) and method_exists( $var4, 'templateValue' ) )
    $var4 = $var4->templateValue();
$var3 = call_user_func_array( array( new eZContentFunctionCollection(), 'fetchContentNode' ),
  array(     'node_id' => $var4,
    'node_path' => false,
    'language_code' => false,
    'remote_id' => false ) );
$var3 = isset( $var3['result'] ) ? $var3['result'] : null;
unset( $var4 );
$var4 = compiledFetchAttribute( $var3, 'name' );
unset( $var3 );
$var3 = $var4;
if (! isset( $var3 ) ) $var3 = NULL;
while ( is_object( $var3 ) and method_exists( $var3, 'templateValue' ) )
    $var3 = $var3->templateValue();
$var2 = array( '%node' => $var3 );unset( $var3 );
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
$var = strtr( 'Cerca in \'%node\'', $var3 );
unset( $var2, $var3, $var4, $var5 );
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
if ( array_key_exists( $currentNamespace, $vars ) && array_key_exists( 'search_title', $vars[$currentNamespace] ) )
{
    $vars[$currentNamespace]['search_title'] = $var;
    unset( $var );
}
$text .= '        ';
}
unset( $if_cond );
// if ends

$text .= '        <div id="searchtextwrapper">
            <input id="searchtext" name="SearchText" type="text" size="20" value="';
// if begins
unset( $if_cond );
unset( $if_cond1 );
unset( $if_cond1 );
$if_cond1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'search_text', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['search_text'] : null;
if (! isset( $if_cond1 ) ) $if_cond1 = NULL;
while ( is_object( $if_cond1 ) and method_exists( $if_cond1, 'templateValue' ) )
    $if_cond1 = $if_cond1->templateValue();
$if_cond = isset( $if_cond1 );unset( $if_cond1 );
if (! isset( $if_cond ) ) $if_cond = NULL;
while ( is_object( $if_cond ) and method_exists( $if_cond, 'templateValue' ) )
    $if_cond = $if_cond->templateValue();

if ( $if_cond )
{
unset( $var );
unset( $var1 );
unset( $var1 );
$var1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'search_text', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['search_text'] : null;
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

}
unset( $if_cond );
// if ends

$text .= '" title="';
unset( $var );
unset( $var1 );
unset( $var1 );
$var1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'search_title', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['search_title'] : null;
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

$text .= '" />
        </div>
        <input id="searchbutton" class="button hide" name="SearchButton" type="submit" value="Cerca" />
        ';
// if begins
unset( $if_cond );
unset( $if_cond1 );
unset( $if_cond1 );
$if_cond1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'ui_context', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['ui_context'] : null;
if (! isset( $if_cond1 ) ) $if_cond1 = NULL;
while ( is_object( $if_cond1 ) and method_exists( $if_cond1, 'templateValue' ) )
    $if_cond1 = $if_cond1->templateValue();
$if_cond = ( ( $if_cond1 ) == ( 'browse' ) );
unset( $if_cond1 );
if (! isset( $if_cond ) ) $if_cond = NULL;
while ( is_object( $if_cond ) and method_exists( $if_cond, 'templateValue' ) )
    $if_cond = $if_cond->templateValue();

if ( $if_cond )
{
$text .= '            <input name="Mode" type="hidden" value="browse" />
            <input name="BrowsePageLimit" type="hidden" value="';
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
$text .= $var;
unset( $var );

$text .= '" />
            <p class="advanced hide"><span class="disabled">Avanzata</span></p>
        ';
}
else
{
$text .= '            <p class="advanced hide"><a href="/ezdemo_site_clean_admin/content/advancedsearch" title="Ricerca avanzata.">Avanzata</a></p>
        ';
}
unset( $if_cond );
// if ends

$text .= '        <div class="searchbuttonfield" id="searchbuttonfield"></div>
        <div class="searchscope" id="searchscope"></div>

        <div class="searchscope-menu-container">
            <div class="searchscope-pane" id="searchscope-pane">
                <a href="javascript:;" class="close" id="searchscope-pane-close"><span class="mini-icon mini-icon-remove-close"></span></a>
                <div class="searchscope-title">Search scope</div>
                <div class="searchscope-body">
                    ';
// def $disabled
if ( $tpl->hasVariable( 'disabled', $rootNamespace ) )
{
    $tpl->warning( 'def', "Variable 'disabled' is already defined.", array (
  0 => 
  array (
    0 => 36,
    1 => 20,
    2 => 2634,
  ),
  1 => 
  array (
    0 => 39,
    1 => 46,
    2 => 2785,
  ),
  2 => 'design/admin/templates/page_search.tpl',
) );
    $tpl->setVariable( 'disabled', false, $rootNamespace );
}
else
{
    $tpl->setLocalVariable( 'disabled', false, $rootNamespace );
}

// def $nd
if ( $tpl->hasVariable( 'nd', $rootNamespace ) )
{
    $tpl->warning( 'def', "Variable 'nd' is already defined.", array (
  0 => 
  array (
    0 => 36,
    1 => 20,
    2 => 2634,
  ),
  1 => 
  array (
    0 => 39,
    1 => 46,
    2 => 2785,
  ),
  2 => 'design/admin/templates/page_search.tpl',
) );
    $tpl->setVariable( 'nd', 1, $rootNamespace );
}
else
{
    $tpl->setLocalVariable( 'nd', 1, $rootNamespace );
}

// def $left_checked
if ( $tpl->hasVariable( 'left_checked', $rootNamespace ) )
{
    $tpl->warning( 'def', "Variable 'left_checked' is already defined.", array (
  0 => 
  array (
    0 => 36,
    1 => 20,
    2 => 2634,
  ),
  1 => 
  array (
    0 => 39,
    1 => 46,
    2 => 2785,
  ),
  2 => 'design/admin/templates/page_search.tpl',
) );
    $tpl->setVariable( 'left_checked', true, $rootNamespace );
}
else
{
    $tpl->setLocalVariable( 'left_checked', true, $rootNamespace );
}

// def $current_loc
if ( $tpl->hasVariable( 'current_loc', $rootNamespace ) )
{
    $tpl->warning( 'def', "Variable 'current_loc' is already defined.", array (
  0 => 
  array (
    0 => 36,
    1 => 20,
    2 => 2634,
  ),
  1 => 
  array (
    0 => 39,
    1 => 46,
    2 => 2785,
  ),
  2 => 'design/admin/templates/page_search.tpl',
) );
    $tpl->setVariable( 'current_loc', true, $rootNamespace );
}
else
{
    $tpl->setLocalVariable( 'current_loc', true, $rootNamespace );
}

$text .= '                    ';
// if begins
unset( $if_cond );
unset( $if_cond1 );
unset( $if_cond1 );
$if_cond1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'ui_context', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['ui_context'] : null;
if (! isset( $if_cond1 ) ) $if_cond1 = NULL;
while ( is_object( $if_cond1 ) and method_exists( $if_cond1, 'templateValue' ) )
    $if_cond1 = $if_cond1->templateValue();
$if_cond = ( ( $if_cond1 ) == ( 'edit' ) );
unset( $if_cond1 );
if (! isset( $if_cond ) ) $if_cond = NULL;
while ( is_object( $if_cond ) and method_exists( $if_cond, 'templateValue' ) )
    $if_cond = $if_cond->templateValue();

if ( $if_cond )
{
$text .= '                        ';
if ( array_key_exists( $currentNamespace, $vars ) && array_key_exists( 'disabled', $vars[$currentNamespace] ) )
{
    $vars[$currentNamespace]['disabled'] = true;
}
$text .= '                    ';
}
else
{
$text .= '                        ';
// if begins
unset( $if_cond );
unset( $if_cond1 );
unset( $if_cond1 );
$if_cond1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'module_result', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['module_result'] : null;
$if_cond2 = compiledFetchAttribute( $if_cond1, 'node_id' );
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
$text .= '                            ';
unset( $var );
unset( $var );
$var = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'module_result', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['module_result'] : null;
$var1 = compiledFetchAttribute( $var, 'node_id' );
unset( $var );
$var = $var1;
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
if ( array_key_exists( $currentNamespace, $vars ) && array_key_exists( 'nd', $vars[$currentNamespace] ) )
{
    $vars[$currentNamespace]['nd'] = $var;
    unset( $var );
}
$text .= '                        ';
}
else
{
$text .= '                            ';
// if begins
unset( $if_cond );
unset( $if_cond1 );
unset( $if_cond1 );
$if_cond1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'search_subtree_array', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['search_subtree_array'] : null;
if (! isset( $if_cond1 ) ) $if_cond1 = NULL;
while ( is_object( $if_cond1 ) and method_exists( $if_cond1, 'templateValue' ) )
    $if_cond1 = $if_cond1->templateValue();
$if_cond = isset( $if_cond1 );unset( $if_cond1 );
if (! isset( $if_cond ) ) $if_cond = NULL;
while ( is_object( $if_cond ) and method_exists( $if_cond, 'templateValue' ) )
    $if_cond = $if_cond->templateValue();

if ( $if_cond )
{
$text .= '                                ';
// if begins
unset( $if_cond );
unset( $if_cond1 );
if (! isset( $if_cond1 ) ) $if_cond1 = NULL;
while ( is_object( $if_cond1 ) and method_exists( $if_cond1, 'templateValue' ) )
    $if_cond1 = $if_cond1->templateValue();
$if_cond1Data = array( 'value' => $if_cond1 );
$tpl->processOperator( 'count',
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
        2 => 'search_subtree_array',
      ),
      2 => false,
    ),
  ),
),
                       $rootNamespace, $currentNamespace, $if_cond1Data, false, false );
$if_cond1 = $if_cond1Data['value'];
unset( $if_cond1Data );
if (! isset( $if_cond1 ) ) $if_cond1 = NULL;
while ( is_object( $if_cond1 ) and method_exists( $if_cond1, 'templateValue' ) )
    $if_cond1 = $if_cond1->templateValue();
$if_cond = ( ( $if_cond1 ) == ( 1 ) );
unset( $if_cond1 );
if (! isset( $if_cond ) ) $if_cond = NULL;
while ( is_object( $if_cond ) and method_exists( $if_cond, 'templateValue' ) )
    $if_cond = $if_cond->templateValue();

if ( $if_cond )
{
$text .= '                                    ';
// if begins
unset( $if_cond );
unset( $if_cond1 );
unset( $if_cond1 );
$if_cond1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'search_subtree_array', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['search_subtree_array'] : null;
$if_cond2 = compiledFetchAttribute( $if_cond1, 0 );
unset( $if_cond1 );
$if_cond1 = $if_cond2;
if (! isset( $if_cond1 ) ) $if_cond1 = NULL;
while ( is_object( $if_cond1 ) and method_exists( $if_cond1, 'templateValue' ) )
    $if_cond1 = $if_cond1->templateValue();
$if_cond = ( ( $if_cond1 ) != ( 1 ) );
unset( $if_cond1 );
if (! isset( $if_cond ) ) $if_cond = NULL;
while ( is_object( $if_cond ) and method_exists( $if_cond, 'templateValue' ) )
    $if_cond = $if_cond->templateValue();

if ( $if_cond )
{
$text .= '                                        ';
unset( $var );
unset( $var );
$var = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'search_subtree_array', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['search_subtree_array'] : null;
$var1 = compiledFetchAttribute( $var, 0 );
unset( $var );
$var = $var1;
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
if ( array_key_exists( $currentNamespace, $vars ) && array_key_exists( 'nd', $vars[$currentNamespace] ) )
{
    $vars[$currentNamespace]['nd'] = $var;
    unset( $var );
}
$text .= '                                        ';
if ( array_key_exists( $currentNamespace, $vars ) && array_key_exists( 'left_checked', $vars[$currentNamespace] ) )
{
    $vars[$currentNamespace]['left_checked'] = false;
}
$text .= '                                    ';
}
else
{
$text .= '                                        ';
if ( array_key_exists( $currentNamespace, $vars ) && array_key_exists( 'disabled', $vars[$currentNamespace] ) )
{
    $vars[$currentNamespace]['disabled'] = true;
}
$text .= '                                    ';
}
unset( $if_cond );
// if ends

$text .= '                                    ';
if ( array_key_exists( $currentNamespace, $vars ) && array_key_exists( 'current_loc', $vars[$currentNamespace] ) )
{
    $vars[$currentNamespace]['current_loc'] = false;
}
$text .= '                                ';
}
else
{
$text .= '                                    ';
if ( array_key_exists( $currentNamespace, $vars ) && array_key_exists( 'disabled', $vars[$currentNamespace] ) )
{
    $vars[$currentNamespace]['disabled'] = true;
}
$text .= '                                ';
}
unset( $if_cond );
// if ends

$text .= '                            ';
}
else
{
$text .= '                                ';
if ( array_key_exists( $currentNamespace, $vars ) && array_key_exists( 'disabled', $vars[$currentNamespace] ) )
{
    $vars[$currentNamespace]['disabled'] = true;
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
}
unset( $if_cond );
// if ends

$text .= '                    <label>Sezione</label>
                    <select name="SectionID"';
// if begins
unset( $if_cond );
unset( $if_cond );
$if_cond = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'disabled', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['disabled'] : null;
if (! isset( $if_cond ) ) $if_cond = NULL;
while ( is_object( $if_cond ) and method_exists( $if_cond, 'templateValue' ) )
    $if_cond = $if_cond->templateValue();

if ( $if_cond )
{
$text .= ' disabled="disabled"';
}
unset( $if_cond );
// if ends

$text .= '>
                        <option value="-1">All</option>
                        ';
// foreach begins
$skipDelimiter = true;
if ( !isset( $fe_variable_stack_049409c21b8a5412bd4ffcf4fb140f4a_29 ) ) $fe_variable_stack_049409c21b8a5412bd4ffcf4fb140f4a_29 = array();
$fe_variable_stack_049409c21b8a5412bd4ffcf4fb140f4a_29[] = compact( 'fe_array_049409c21b8a5412bd4ffcf4fb140f4a_29', 'fe_array_keys_049409c21b8a5412bd4ffcf4fb140f4a_29', 'fe_n_items_049409c21b8a5412bd4ffcf4fb140f4a_29', 'fe_n_items_processed_049409c21b8a5412bd4ffcf4fb140f4a_29', 'fe_i_049409c21b8a5412bd4ffcf4fb140f4a_29', 'fe_key_049409c21b8a5412bd4ffcf4fb140f4a_29', 'fe_val_049409c21b8a5412bd4ffcf4fb140f4a_29', 'fe_offset_049409c21b8a5412bd4ffcf4fb140f4a_29', 'fe_max_049409c21b8a5412bd4ffcf4fb140f4a_29', 'fe_reverse_049409c21b8a5412bd4ffcf4fb140f4a_29', 'fe_first_val_049409c21b8a5412bd4ffcf4fb140f4a_29', 'fe_last_val_049409c21b8a5412bd4ffcf4fb140f4a_29' );
unset( $fe_array_049409c21b8a5412bd4ffcf4fb140f4a_29 );
$fe_array_049409c21b8a5412bd4ffcf4fb140f4a_29 = call_user_func_array( array( new eZSectionFunctionCollection(), 'fetchSectionList' ),
  array(  ) );
$fe_array_049409c21b8a5412bd4ffcf4fb140f4a_29 = isset( $fe_array_049409c21b8a5412bd4ffcf4fb140f4a_29['result'] ) ? $fe_array_049409c21b8a5412bd4ffcf4fb140f4a_29['result'] : null;
if (! isset( $fe_array_049409c21b8a5412bd4ffcf4fb140f4a_29 ) ) $fe_array_049409c21b8a5412bd4ffcf4fb140f4a_29 = NULL;
while ( is_object( $fe_array_049409c21b8a5412bd4ffcf4fb140f4a_29 ) and method_exists( $fe_array_049409c21b8a5412bd4ffcf4fb140f4a_29, 'templateValue' ) )
    $fe_array_049409c21b8a5412bd4ffcf4fb140f4a_29 = $fe_array_049409c21b8a5412bd4ffcf4fb140f4a_29->templateValue();

$fe_array_keys_049409c21b8a5412bd4ffcf4fb140f4a_29 = is_array( $fe_array_049409c21b8a5412bd4ffcf4fb140f4a_29 ) ? array_keys( $fe_array_049409c21b8a5412bd4ffcf4fb140f4a_29 ) : array();
$fe_n_items_049409c21b8a5412bd4ffcf4fb140f4a_29 = count( $fe_array_keys_049409c21b8a5412bd4ffcf4fb140f4a_29 );
$fe_n_items_processed_049409c21b8a5412bd4ffcf4fb140f4a_29 = 0;
$fe_offset_049409c21b8a5412bd4ffcf4fb140f4a_29 = 0;
$fe_max_049409c21b8a5412bd4ffcf4fb140f4a_29 = $fe_n_items_049409c21b8a5412bd4ffcf4fb140f4a_29 - $fe_offset_049409c21b8a5412bd4ffcf4fb140f4a_29;
$fe_reverse_049409c21b8a5412bd4ffcf4fb140f4a_29 = false;
if ( $fe_offset_049409c21b8a5412bd4ffcf4fb140f4a_29 < 0 || $fe_offset_049409c21b8a5412bd4ffcf4fb140f4a_29 >= $fe_n_items_049409c21b8a5412bd4ffcf4fb140f4a_29 )
{
    $fe_offset_049409c21b8a5412bd4ffcf4fb140f4a_29 = ( $fe_offset_049409c21b8a5412bd4ffcf4fb140f4a_29 < 0 ) ? 0 : $fe_n_items_049409c21b8a5412bd4ffcf4fb140f4a_29;
    if ( $fe_n_items_049409c21b8a5412bd4ffcf4fb140f4a_29 || $fe_offset_049409c21b8a5412bd4ffcf4fb140f4a_29 < 0 )
 {
        eZDebug::writeWarning("Invalid 'offset' parameter specified: '$fe_offset_049409c21b8a5412bd4ffcf4fb140f4a_29'. Array count: $fe_n_items_049409c21b8a5412bd4ffcf4fb140f4a_29");   
}
}
if ( $fe_max_049409c21b8a5412bd4ffcf4fb140f4a_29 < 0 || $fe_offset_049409c21b8a5412bd4ffcf4fb140f4a_29 + $fe_max_049409c21b8a5412bd4ffcf4fb140f4a_29 > $fe_n_items_049409c21b8a5412bd4ffcf4fb140f4a_29 )
{
    if ( $fe_max_049409c21b8a5412bd4ffcf4fb140f4a_29 < 0 )
 eZDebug::writeWarning("Invalid 'max' parameter specified: $fe_max_049409c21b8a5412bd4ffcf4fb140f4a_29");
    $fe_max_049409c21b8a5412bd4ffcf4fb140f4a_29 = $fe_n_items_049409c21b8a5412bd4ffcf4fb140f4a_29 - $fe_offset_049409c21b8a5412bd4ffcf4fb140f4a_29;
}
if ( $fe_reverse_049409c21b8a5412bd4ffcf4fb140f4a_29 )
{
    $fe_first_val_049409c21b8a5412bd4ffcf4fb140f4a_29 = $fe_n_items_049409c21b8a5412bd4ffcf4fb140f4a_29 - 1 - $fe_offset_049409c21b8a5412bd4ffcf4fb140f4a_29;
    $fe_last_val_049409c21b8a5412bd4ffcf4fb140f4a_29  = 0;
}
else
{
    $fe_first_val_049409c21b8a5412bd4ffcf4fb140f4a_29 = $fe_offset_049409c21b8a5412bd4ffcf4fb140f4a_29;
    $fe_last_val_049409c21b8a5412bd4ffcf4fb140f4a_29  = $fe_n_items_049409c21b8a5412bd4ffcf4fb140f4a_29 - 1;
}
// foreach
for ( $fe_i_049409c21b8a5412bd4ffcf4fb140f4a_29 = $fe_first_val_049409c21b8a5412bd4ffcf4fb140f4a_29; $fe_n_items_processed_049409c21b8a5412bd4ffcf4fb140f4a_29 < $fe_max_049409c21b8a5412bd4ffcf4fb140f4a_29 && ( $fe_reverse_049409c21b8a5412bd4ffcf4fb140f4a_29 ? $fe_i_049409c21b8a5412bd4ffcf4fb140f4a_29 >= $fe_last_val_049409c21b8a5412bd4ffcf4fb140f4a_29 : $fe_i_049409c21b8a5412bd4ffcf4fb140f4a_29 <= $fe_last_val_049409c21b8a5412bd4ffcf4fb140f4a_29 ); $fe_reverse_049409c21b8a5412bd4ffcf4fb140f4a_29 ? $fe_i_049409c21b8a5412bd4ffcf4fb140f4a_29-- : $fe_i_049409c21b8a5412bd4ffcf4fb140f4a_29++ )
{
$fe_key_049409c21b8a5412bd4ffcf4fb140f4a_29 = $fe_array_keys_049409c21b8a5412bd4ffcf4fb140f4a_29[$fe_i_049409c21b8a5412bd4ffcf4fb140f4a_29];
$fe_val_049409c21b8a5412bd4ffcf4fb140f4a_29 = $fe_array_049409c21b8a5412bd4ffcf4fb140f4a_29[$fe_key_049409c21b8a5412bd4ffcf4fb140f4a_29];
$vars[$rootNamespace]['section'] = $fe_val_049409c21b8a5412bd4ffcf4fb140f4a_29;
$text .= '                        <option value="';
unset( $var );
unset( $var );
$var = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'section', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['section'] : null;
$var1 = compiledFetchAttribute( $var, 'id' );
unset( $var );
$var = $var1;
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
$text .= ( is_object( $var ) ? compiledFetchText( $tpl, $rootNamespace, $currentNamespace, false, $var ) : $var );
unset( $var );

$text .= '"';
// if begins
unset( $if_cond );
unset( $if_cond1 );
unset( $if_cond1 );
$if_cond1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'section', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['section'] : null;
$if_cond2 = compiledFetchAttribute( $if_cond1, 'id' );
unset( $if_cond1 );
$if_cond1 = $if_cond2;
if (! isset( $if_cond1 ) ) $if_cond1 = NULL;
while ( is_object( $if_cond1 ) and method_exists( $if_cond1, 'templateValue' ) )
    $if_cond1 = $if_cond1->templateValue();
unset( $if_cond2 );
unset( $if_cond2 );
$if_cond2 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'section_id', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['section_id'] : null;
if (! isset( $if_cond2 ) ) $if_cond2 = NULL;
while ( is_object( $if_cond2 ) and method_exists( $if_cond2, 'templateValue' ) )
    $if_cond2 = $if_cond2->templateValue();
$if_cond = ( ( $if_cond1 ) == ( $if_cond2 ) );
unset( $if_cond1, $if_cond2 );
if (! isset( $if_cond ) ) $if_cond = NULL;
while ( is_object( $if_cond ) and method_exists( $if_cond, 'templateValue' ) )
    $if_cond = $if_cond->templateValue();

if ( $if_cond )
{
$text .= ' selected="selected"';
}
unset( $if_cond );
// if ends

$text .= '>';
unset( $var );
unset( $var1 );
unset( $var1 );
$var1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'section', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['section'] : null;
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

$text .= '</option>
                        ';
$fe_n_items_processed_049409c21b8a5412bd4ffcf4fb140f4a_29++;
} // foreach
$skipDelimiter = false;
if ( count( $fe_variable_stack_049409c21b8a5412bd4ffcf4fb140f4a_29 ) ) extract( array_pop( $fe_variable_stack_049409c21b8a5412bd4ffcf4fb140f4a_29 ) );

else
{

unset( $fe_array_049409c21b8a5412bd4ffcf4fb140f4a_29 );

unset( $fe_array_keys_049409c21b8a5412bd4ffcf4fb140f4a_29 );

unset( $fe_n_items_049409c21b8a5412bd4ffcf4fb140f4a_29 );

unset( $fe_n_items_processed_049409c21b8a5412bd4ffcf4fb140f4a_29 );

unset( $fe_i_049409c21b8a5412bd4ffcf4fb140f4a_29 );

unset( $fe_key_049409c21b8a5412bd4ffcf4fb140f4a_29 );

unset( $fe_val_049409c21b8a5412bd4ffcf4fb140f4a_29 );

unset( $fe_offset_049409c21b8a5412bd4ffcf4fb140f4a_29 );

unset( $fe_max_049409c21b8a5412bd4ffcf4fb140f4a_29 );

unset( $fe_reverse_049409c21b8a5412bd4ffcf4fb140f4a_29 );

unset( $fe_first_val_049409c21b8a5412bd4ffcf4fb140f4a_29 );

unset( $fe_last_val_049409c21b8a5412bd4ffcf4fb140f4a_29 );

unset( $fe_variable_stack_049409c21b8a5412bd4ffcf4fb140f4a_29 );

}

// foreach ends
$text .= '                    </select>

                    <label';
// if begins
unset( $if_cond );
unset( $if_cond );
$if_cond = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'disabled', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['disabled'] : null;
if (! isset( $if_cond ) ) $if_cond = NULL;
while ( is_object( $if_cond ) and method_exists( $if_cond, 'templateValue' ) )
    $if_cond = $if_cond->templateValue();

if ( $if_cond )
{
$text .= ' class="disabled"';
}
unset( $if_cond );
// if ends

$text .= '><input type="radio" name="SubTreeArray" value="';
unset( $var );
unset( $var );
$var = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'search_node_id', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['search_node_id'] : null;
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
$text .= ( is_object( $var ) ? compiledFetchText( $tpl, $rootNamespace, $currentNamespace, false, $var ) : $var );
unset( $var );

$text .= '" checked="checked" title="';
unset( $var );
unset( $var1 );
unset( $var1 );
$var1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'search_title', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['search_title'] : null;
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

$text .= '" />';
unset( $var );
unset( $var1 );
unset( $var1 );
$var1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'search_title', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['search_title'] : null;
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

$text .= '</label>
                    ';
// if begins
unset( $if_cond );
unset( $if_cond1 );
unset( $if_cond1 );
$if_cond1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'search_node_id', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['search_node_id'] : null;
if (! isset( $if_cond1 ) ) $if_cond1 = NULL;
while ( is_object( $if_cond1 ) and method_exists( $if_cond1, 'templateValue' ) )
    $if_cond1 = $if_cond1->templateValue();
$if_cond = ( ( $if_cond1 ) != ( 1 ) );
unset( $if_cond1 );
if (! isset( $if_cond ) ) $if_cond = NULL;
while ( is_object( $if_cond ) and method_exists( $if_cond, 'templateValue' ) )
    $if_cond = $if_cond->templateValue();

if ( $if_cond )
{
$text .= '                    <label';
// if begins
unset( $if_cond );
unset( $if_cond );
$if_cond = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'disabled', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['disabled'] : null;
if (! isset( $if_cond ) ) $if_cond = NULL;
while ( is_object( $if_cond ) and method_exists( $if_cond, 'templateValue' ) )
    $if_cond = $if_cond->templateValue();

if ( $if_cond )
{
$text .= ' class="disabled"';
}
unset( $if_cond );
// if ends

$text .= '><input type="radio" name="SubTreeArray" value="1"';
// if begins
unset( $if_cond );
unset( $if_cond );
$if_cond = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'disabled', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['disabled'] : null;
if (! isset( $if_cond ) ) $if_cond = NULL;
while ( is_object( $if_cond ) and method_exists( $if_cond, 'templateValue' ) )
    $if_cond = $if_cond->templateValue();

if ( $if_cond )
{
$text .= ' disabled="disabled"';
}
else
{
$text .= ' title="Cerca in tutti i contenuti"';
}
unset( $if_cond );
// if ends

$text .= ' />Cerca in tutti i contenuti</label>
                    ';
}
unset( $if_cond );
// if ends

$text .= '                    <label';
// if begins
unset( $if_cond );
unset( $if_cond );
$if_cond = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'disabled', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['disabled'] : null;
if (! isset( $if_cond ) ) $if_cond = NULL;
while ( is_object( $if_cond ) and method_exists( $if_cond, 'templateValue' ) )
    $if_cond = $if_cond->templateValue();

if ( $if_cond )
{
$text .= ' class="disabled"';
}
unset( $if_cond );
// if ends

$text .= '><input type="radio" name="SubTreeArray" value="';
unset( $var );
unset( $var );
$var = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'nd', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['nd'] : null;
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
$text .= ( is_object( $var ) ? compiledFetchText( $tpl, $rootNamespace, $currentNamespace, false, $var ) : $var );
unset( $var );

$text .= '"';
// if begins
unset( $if_cond );
unset( $if_cond );
$if_cond = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'disabled', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['disabled'] : null;
if (! isset( $if_cond ) ) $if_cond = NULL;
while ( is_object( $if_cond ) and method_exists( $if_cond, 'templateValue' ) )
    $if_cond = $if_cond->templateValue();

if ( $if_cond )
{
$text .= ' disabled="disabled"';
}
else
{
$text .= ' title="Search only from the current location"';
}
unset( $if_cond );
// if ends

$text .= ' />';
// if begins
unset( $if_cond );
unset( $if_cond );
$if_cond = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'current_loc', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['current_loc'] : null;
if (! isset( $if_cond ) ) $if_cond = NULL;
while ( is_object( $if_cond ) and method_exists( $if_cond, 'templateValue' ) )
    $if_cond = $if_cond->templateValue();

if ( $if_cond )
{
unset( $var );
$var = 'Posizione corrente';
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
$text .= $var;
unset( $var );

}
else
{
unset( $var );
$var = 'Stessa collocazione';
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
$text .= $var;
unset( $var );

}
unset( $if_cond );
// if ends

$text .= '</label>
                    ';
// undef $disabled
$tpl->unsetLocalVariable( 'disabled', $rootNamespace );

// undef $nd
$tpl->unsetLocalVariable( 'nd', $rootNamespace );

// undef $left_checked
$tpl->unsetLocalVariable( 'left_checked', $rootNamespace );

// undef $current_loc
$tpl->unsetLocalVariable( 'current_loc', $rootNamespace );

$text .= '                </div>
            </div>
        </div>
    ';
}
unset( $if_cond );
// if ends

$text .= '</form>
</div>

<script type="text/javascript">


(function($){
    if ( !document.getElementById(\'searchbuttonfield\') )return;

    $(\'#searchbuttonfield\').click(function(){
        if ( $(\'#searchtext\').val() === $(\'#searchtext\').attr(\'title\') )return;
          $(\'#searchbutton\').click();
    });
    $(\'#searchscope\').click(function(){
        $(\'#searchscope-pane\').addClass(\'active\');
    });
    $(\'#searchscope-pane-close\').click(function(){
        $(\'#searchscope-pane\').removeClass(\'active\');
    });
    $(\'input:radio[name=SubTreeArray]\').change( function() {
        $(\'#searchtext\').attr(\'value\', $(this).attr(\'title\'));
        $(\'#searchtext\').attr(\'title\', $(this).attr(\'title\'));
    } );
})( jQuery );

</script>';
// undef $search_node_id
$tpl->unsetLocalVariable( 'search_node_id', $rootNamespace );

// undef $section_id
$tpl->unsetLocalVariable( 'section_id', $rootNamespace );


$setArray = $oldSetArray_743cef8e0e49846096d097f9c8432f61;
$tpl->Level--;
?>
