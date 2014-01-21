<div id="maincontent" style="margin: 0;">
<div id="maincontent-design" class="float-break"><div id="fix">
<!-- Maincontent START -->

<div id="eznwinst" class="context-block">
<div>
<div class="box-header"><div class="box-ml">
    <h1 class="context-title">{'eZ Network installation'|i18n( 'design/admin/network' )}</h1>
<div class="header-mainline"></div>
</div></div>
<div class="box-ml"><div class="box-content">

    <div id="eznwinst_info">
        <div id="eznwinst_info_start" class="eznwinst_info">
            <p>{'eZ Network needs to be installed, click "Next" to perform installation sanity checks.'|i18n( 'design/admin/network' )}</p>
            <p>{'Note: Installation on eZ Publish cluster is only supported on master server!'|i18n( 'design/admin/network' )}
            </p>
            <p>{'In these cases you should install ez_network as explained in <em>extension/ez_network/doc/INSTALL.txt</em>'|i18n( 'design/admin/network' )}</p>
        </div>

        <div id="eznwinst_info_sanity" class="eznwinst_info hide">
            <p>{'Sanity checks to see if eZ Network can be installed automatically, takes from 1-2 minutes depending on your server'|i18n( 'design/admin/network' )}</p>
            <div class='message-error hide'>
                <h2>Sanity check failed</h2>
                <p>Your installation seems to have some issues, please follow the installation instructions in extension/ez_network/doc/INSTALL.txt to generate certification log and send it to eZ, details:</p>
                <ul id="eznwinst_error_sanity"></ul>
            </div>
        </div>

        <div id="eznwinst_info_install" class="eznwinst_info hide">
            <p>{'eZ Network installation, takes from 2-4 minutes depending on your server'|i18n( 'design/admin/network' )}</p>
            <p>{'Enter your network key as provided by eZ and click install:'|i18n( 'design/admin/network' )}
                <input type="text" size="33" id="eznwinst_info_install_nw_key" class="eznwinst_input" disabled="disabled" value="{first_set( $nw_key_list[0]['value'], '' )}" name="eZNWKey" />
                <a id="eznwinst_info_install_nw_key_btn" class="eznwinst_button" title="Click to start installation after entering network key!">Install</a>
            </p>
            <div class='message-error hide'>
                <h2>Installation failed</h2>
                <p>Installation did not complete, please follow the installation instructions in extension/ez_network/doc/INSTALL.txt to generate certification log and send it to eZ.</p>
                <ul id="eznwinst_error_install"></ul>
            </div>
        </div>

        <div id="eznwinst_info_finalize" class="eznwinst_info hide">
            <p>{'Congratulation, eZ Network installation is almost done.'|i18n( 'design/admin/network' )}</p>
            <p>Last thing to do is to setup cronjobs for eZ Network, correct php path if needed and install the following in your crontab:<br />
               ( Note for cluster setup: 'sync_network' & 'monitor' should only execute on master server! )
            <pre>
# -- eZ Network crontab setup --
ezpath="{$root_dir|wash}"
phpbin="php -d memory_limit=512M -d safe_mode=0 -d disable_functions=0"

{$rnd_minute} */8 * * * cd $ezpath && $phpbin runcronjobs.php -q sync_network >/dev/null 2>&1
1 * * * *   cd $ezpath && $phpbin runcronjobs.php -q monitor >/dev/null 2>&1
</pre></p>
            <div class='message-warning hide'>
                <h2>Some issues discovered during installation</h2>
                <ul id="eznwinst_warning_finalize"></ul>
            </div>

        </div>
    </div>

    <div id="eznwinst_btn">
        <a id="eznwinst_btn_prev" class="eznwinst_button" title="Click to go to previous page!">Previous</a>
        <a id="eznwinst_btn_next" class="eznwinst_button" title="Click to go to next page!">Next</a>
    </div>

</div></div>

<div id="eznwinst_steps" class="controllbar current_start">
    <span><img class="hide" src={"network/progress.gif"|ezimage} width="16" height="16" alt="Loading..." /></span>
    <div id="eznwinst_start">{'1. Start'|i18n( 'design/admin/network' )}</div>
    <div id="eznwinst_sanity">{'2. Sanity'|i18n( 'design/admin/network' )}</div>
    <div id="eznwinst_install">{'3. Install'|i18n( 'design/admin/network' )}</div>
    <div id="eznwinst_finalize">{'4. Finalize'|i18n( 'design/admin/network' )}</div>
</div>

</div>


<!-- Maincontent END -->
</div>
</div>
<div class="break"></div>
</div></div>

{ezscript_require('ezjsc::jquery', 'ezjsc::jqueryio')}
{literal}
<script type="text/javascript">
<!--

jQuery( function( $ )
{
    var current = 'start', steps = ['start', 'sanity', 'install', 'finalize' ], fn = {};
    var _token = '', _tokenNode = document.getElementById('ezxform_token_js');
    if ( _tokenNode ) _token = '&ezxform_token=' + _tokenNode.getAttribute('title');
    $('#eznwinst_btn a.eznwinst_button').click( function()
    {
        if ( this.className.indexOf('enabled') === -1 )
            return false;

        return stepChange( this.id.indexOf('_prev') !== -1  );
    });
    $('#eznwinst_btn_next').addClass('enabled');
    $('#eznwinst_info_install_nw_key, #eznwinst_info_install_nw_key_btn').addClass('enabled').attr('disabled', false);
    $('#eznwinst_info_install_nw_key_btn').click(function()
    {
        if ( this.className.indexOf('enabled') === -1 )
            return false;

        var inp = $('#eznwinst_info_install_nw_key');
        if ( !inp.val() )
        {
            inp.css({
                'border-color': 'red',
                'box-shadow-color': 'red',
                '-moz-box-shadow-color': 'red',
                '-webkit-box-shadow-color': 'red'
            });
            return;
        }

        fn.installData = { '_count' : 0, '_target' : 3 };
        $.post( $.ez.root_url + 'network/install', "doAction=install&nwKey=" + inp.val() + _token, fn.installResponse, 'json').error( fn.error );

        $('#eznwinst_info_install_nw_key, #eznwinst_info_install_nw_key_btn').removeClass('enabled').attr('disabled', true );
        document.getElementById('eznwinst_steps').className = "controllbar current_install progress";
    });

    /**
     * Specific functions for actions when showing a step
     */
    fn.sanityData = false;
    fn.sanity = function( )
    {
        stepStart( 'sanity' , true );

        if ( fn.sanityData !== false  )
            return stepCompleted( 'sanity' );

        fn.sanityData = { '_count' : 0, '_target' : 2 };

        // execute several checks in paralell to make it complete a bit faster
        $.post( $.ez.root_url + 'network/install', "doAction=md5" + _token, fn.sanityResponse, 'json').error( fn.error );
        $.post( $.ez.root_url + 'network/install', "doAction=env" + _token, fn.sanityResponse, 'json').error( fn.error );
    };
    fn.sanityResponse = function( data, textStatus, req )
    {
        fn.sanityData._count++;
        stepProgress( 'sanity', data['action'], data );
        fn.sanityData = $.extend( fn.sanityData, data );
        if ( fn.sanityData._count === fn.sanityData._target ) fn.sanityCompleted();
    };
    fn.sanityCompleted = function()
    {
        if ( current !== 'sanity' )
            return;

        if ( $('#eznwinst_info_sanity div.message-error.hide').length === 1 )
            stepChange();
        else
            stepCompleted( 'sanity', false  );
    };

    fn.error = function(e, jqxhr, settings)
    {
        $('#eznwinst_error_' + current).append( '<li>500 Internal Server Error for ajax call of web installer during: ' + current + '</li>' );

        if ( window.console !== undefined )
        {
            $('#eznwinst_error_' + current).append( '<li>Check your browser console ( Usually: Tools &gt; Error/Javascript console) to get the exact error message to report.</li>' );
            console.log( '500 Internal Server Error for ajax call of web installer during "' + current  +'", next line includes the exact response:' );
            if ( console.debug !== undefined )
                console.debug( jqxhr );
            else
                console.log( jqxhr );
        }

        $('#eznwinst_info_' + current + ' div.message-error').removeClass('hide');
        stepCompleted( current, false  );
    };

    fn.installData = false;
    fn.install = function( )
    {
        stepStart( 'install' );

        if ( fn.installData !== false  )
            return stepCompleted( 'install' );
    };
    fn.installResponse = function( data, textStatus, req )
    {
        fn.installData._count++;
        var hasError = stepProgress( 'install', data['action'], data );
        fn.installData = $.extend( fn.installData, data );
        if ( fn.installData._count === fn.installData._target ) fn.installCompleted();
        else if ( fn.installPostActions === undefined )
        {
            if ( hasError ) return stepCompleted( 'install', false  );
            fn.installPostActions = true;
            $.post( $.ez.root_url + 'network/install', "doAction=snapshoot" + _token, fn.installResponse, 'json').error( fn.error );
            $.post( $.ez.root_url + 'network/install', "doAction=sync" + _token, fn.installResponse, 'json').error( fn.error );
        }
    };
    fn.installCompleted = function()
    {
        if ( current !== 'install' )
            return;

        if ( $('#eznwinst_info_install div.message-error.hide').length === 1 )
            stepChange();
        else
            stepCompleted( 'install', false  );

    };

    /**
     * General step change function
     *
     * @param bool|undefined backwards Go backwards on true
     */
    function stepChange( backwards )
    {
        var pos = jQuery.inArray( current, steps ), len = steps.length -1, target = pos;
        if ( backwards )
        {
            if ( target > 0 ) target--;
            else return;
        }
        else
        {
            if ( target < len ) target++;
            else return;
        }
        current = steps[target];
        if ( fn[current] !== undefined )
        {
             fn[current].call( this );
        }
        else
        {
            stepStart.call( this, current );
            stepCompleted.call( this, current );
        }
    }

    /**
     * General step progress function
     *
     * @param string step
     * @param string action (the ajax action, not uses atm)
     * @param object data (json data from ajax call)
     */
    function stepProgress( step, action, data )
    {
        innerStepProgress( data, 'finalize', 'warning' );
        return innerStepProgress( data, step, 'error' );

        function innerStepProgress( data, step, type )
        {
            var hasType = false, prop;
            for( prop in data[type] )
            {
                if ( data[type][prop] != '' )
                {
                    hasType = true;
                    $('#eznwinst_' + type + '_' + step).append('<li>' + data[type][prop] + '</li>');
                }
            }

            if ( hasType )
                $('#eznwinst_info_' + step + ' div.message-'+ type).removeClass('hide');
            return hasType;
        }
    }

    /**
     * General step start function
     *
     * @param string step
     * @param bool showProgress
     */
    function stepStart( step, showProgress )
    {
        $('#eznwinst_btn a.enabled').removeClass('enabled').blur();
        $('#eznwinst_info div.eznwinst_info').addClass('hide');
        document.getElementById('eznwinst_steps').className = "controllbar current_" + step + ( showProgress ? " progress" : "" );
        document.getElementById('eznwinst_info_' + step).className = "eznwinst_info";
    }

    /**
     * General step complete function
     *
     * @param string step
     * @param bool|undefined enableButtons Does not enable next/prev buttons on false
     */
    function stepCompleted( step, enableButtons )
    {
        var pos = jQuery.inArray( step, steps ), len = steps.length -1;
        if ( pos > 0 && pos < len ) $('#eznwinst_steps').removeClass( 'progress' );
        if ( enableButtons || enableButtons === undefined )
        {
            document.getElementById('eznwinst_btn_prev').className = 'eznwinst_button' + ( pos > 0 && pos < len ? ' enabled': '' );
            document.getElementById('eznwinst_btn_next').className = 'eznwinst_button' + ( pos < len ? ' enabled': '' );
        }
        $('#eznwinst').height( $('#eznwinst > div').height() + 40 );
    }
});
//-->
</script>
{/literal}
