<?php
// URI:       design:dashboard/community_activity.tpl
// Filename:  design/standard/templates/dashboard/community_activity.tpl
// Timestamp: 1383940884 (Fri Nov 8 21:01:24 CET 2013)
$oldSetArray_2e2e3670375dca923673d5df93f4ba9d = isset( $setArray ) ? $setArray : array();
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

// def $forumsRssUrl
if ( $tpl->hasVariable( 'forumsRssUrl', $rootNamespace ) )
{
    $tpl->warning( 'def', "Variable 'forumsRssUrl' is already defined.", array (
  0 => 
  array (
    0 => 1,
    1 => 0,
    2 => 1,
  ),
  1 => 
  array (
    0 => 2,
    1 => 47,
    2 => 107,
  ),
  2 => 'design/standard/templates/dashboard/community_activity.tpl',
) );
    $tpl->setVariable( 'forumsRssUrl', 'http://share.ez.no/rss/feed/all_forums', $rootNamespace );
}
else
{
    $tpl->setLocalVariable( 'forumsRssUrl', 'http://share.ez.no/rss/feed/all_forums', $rootNamespace );
}

// def $versionString
unset( $var );
$var = call_user_func_array( array( new eZSetupFunctionCollection(), 'fetchFullVersionString' ),
  array(  ) );
$var = isset( $var['result'] ) ? $var['result'] : null;
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
if ( $tpl->hasVariable( 'versionString', $rootNamespace ) )
{
    $tpl->warning( 'def', "Variable 'versionString' is already defined.", array (
  0 => 
  array (
    0 => 1,
    1 => 0,
    2 => 1,
  ),
  1 => 
  array (
    0 => 2,
    1 => 47,
    2 => 107,
  ),
  2 => 'design/standard/templates/dashboard/community_activity.tpl',
) );
    $tpl->setVariable( 'versionString', $var, $rootNamespace );
}
else
{
    $tpl->setLocalVariable( 'versionString', $var, $rootNamespace );
}

$text .= '<div class="community-block-title">
    <h2>What\'s happening in the eZ Community</h2>
    <span class="first"><a href="http://share.ez.no/get-involved/exchange#RSS?';
unset( $var );
unset( $var2 );
unset( $var2 );
$var2 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'versionString', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['versionString'] : null;
if (! isset( $var2 ) ) $var2 = NULL;
while ( is_object( $var2 ) and method_exists( $var2, 'templateValue' ) )
    $var2 = $var2->templateValue();
while ( is_object( $var2 ) and method_exists( $var2, 'templateValue' ) )
    $var2 = $var2->templateValue();
$var = ( 'utm_content=eZ+Publish+Community+Project+' . $var2 . '&utm_source=eZ+Publish+Community+Project+Dashboard&utm_medium=eZ+Publish+Community+Project+Dashboard&utm_campaign=eZ+Publish+Community+Project+Dashboard' );
unset( $var2 );
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
$text .= $var;
unset( $var );

$text .= '"><img width="16px" height="16px" src="/extension/ezdemo/design/ezdemo/images/rss-icon.gif" /></a></span>
    <span><a href="http://share.ez.no/get-involved/exchange#twitter?';
unset( $var );
unset( $var2 );
unset( $var2 );
$var2 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'versionString', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['versionString'] : null;
if (! isset( $var2 ) ) $var2 = NULL;
while ( is_object( $var2 ) and method_exists( $var2, 'templateValue' ) )
    $var2 = $var2->templateValue();
while ( is_object( $var2 ) and method_exists( $var2, 'templateValue' ) )
    $var2 = $var2->templateValue();
$var = ( 'utm_content=eZ+Publish+Community+Project+' . $var2 . '&utm_source=eZ+Publish+Community+Project+Dashboard&utm_medium=eZ+Publish+Community+Project+Dashboard&utm_campaign=eZ+Publish+Community+Project+Dashboard' );
unset( $var2 );
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
$text .= $var;
unset( $var );

$text .= '"><img width="16px" height="16px" src="/design/standard/images/twitter-icon.png" /></a></span>
    <span><a href="http://share.ez.no/get-involved/exchange#googleplus?';
unset( $var );
unset( $var2 );
unset( $var2 );
$var2 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'versionString', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['versionString'] : null;
if (! isset( $var2 ) ) $var2 = NULL;
while ( is_object( $var2 ) and method_exists( $var2, 'templateValue' ) )
    $var2 = $var2->templateValue();
while ( is_object( $var2 ) and method_exists( $var2, 'templateValue' ) )
    $var2 = $var2->templateValue();
$var = ( 'utm_content=eZ+Publish+Community+Project+' . $var2 . '&utm_source=eZ+Publish+Community+Project+Dashboard&utm_medium=eZ+Publish+Community+Project+Dashboard&utm_campaign=eZ+Publish+Community+Project+Dashboard' );
unset( $var2 );
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
$text .= $var;
unset( $var );

$text .= '"><img width="16px" height="16px" src="/design/standard/images/googleplus-icon.png" /></a></span>
</div>
<div class="break"></div>
<div class="community-activity">
    <div class="loading">
        Loading the latest forum posts...
        <img src="/design/admin/images/2/loader.gif" />
    </div>
    <div id="feed-elements">


    </div>
</div>

<script type="text/javascript">
    
    // Fetch the latest forum posts from share.ez.no
            $(document).ready(
            $.ajax({
        url: document.location.protocol + \'//ajax.googleapis.com/ajax/services/feed/load?v=1.0&num=';
unset( $var );
unset( $var );
$var = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'block', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['block'] : null;
$var1 = compiledFetchAttribute( $var, 'number_of_items' );
unset( $var );
$var = $var1;
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
$text .= ( is_object( $var ) ? compiledFetchText( $tpl, $rootNamespace, $currentNamespace, false, $var ) : $var );
unset( $var );

$text .= '&callback=?&q=\' + encodeURIComponent( \'';
unset( $var );
unset( $var );
$var = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'forumsRssUrl', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['forumsRssUrl'] : null;
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
$text .= ( is_object( $var ) ? compiledFetchText( $tpl, $rootNamespace, $currentNamespace, false, $var ) : $var );
unset( $var );

$text .= '\' ),
        dataType: \'json\',
        success: function( data )
        {
            // Hide the loading wheel
            $( \'.community-activity .loading\' ).addClass( \'hide\' );

            // Build the markup to show the latest posts
            var html = \'<ul>\';

            $( data.responseData.feed.entries ).each( function()
            {
                var $item = $(this);
                var $date = new Date( $item.attr("publishedDate") );

                //trace( $item.attr("link") );
                html += \'<li>\' +
                        \'<h5><a href ="\' + $item.attr( "link" ) + \'?utm_content=eZ+Publish+Community+Project+';
unset( $var );
unset( $var );
$var = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( 'versionString', $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]['versionString'] : null;
if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
$text .= ( is_object( $var ) ? compiledFetchText( $tpl, $rootNamespace, $currentNamespace, false, $var ) : $var );
unset( $var );

$text .= '&utm_source=eZ+Publish+Community+Project+Dashboard&utm_medium=eZ+Publish+Community+Project+Dashboard&utm_campaign=eZ+Publish+Community+Project+Dashboard\' + \'">\' + $item.attr( "title" ) + \'</a></h5> \' +
                        \'<p>\' + $item.attr("author") + \' - <em>\' + $date.getDate() + \'/\' + $date.getMonth() + \'/\' + $date.getFullYear() + \' \' + $date.getHours() + \':\' + $date.getMinutes() + \'</em></p>\' +
                    // \'<p>\' + $item.attr("c:date") + \'</p>\' +
                        \'</li>\';
            });

            html += \'</ul>\';

            // Show the results
            $( \'div.community-activity #feed-elements\' ).append( html );
        }
    })
    );


    
</script>
';

$setArray = $oldSetArray_2e2e3670375dca923673d5df93f4ba9d;
$tpl->Level--;
?>
