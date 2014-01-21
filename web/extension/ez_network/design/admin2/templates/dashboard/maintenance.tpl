<div id="dashboard-logo"></div>
<div id="mainteinance-text">
    <h2>{'Enterprise update and maintenance'|i18n( 'design/admin/dashboard/maintenance' )}</h2>

    <p>{'You are running version <span id="ez-version" class="ok">%1</span> of eZ Publish.'|i18n( 'design/admin/dashboard/maintenance', , array( fetch( 'setup', 'version' ) ) )}</p>
    <p>{"Your installation is covered by an eZ Publish Enterprise subscription agreement."|i18n( 'design/admin/dashboard/maintenance' )}
    {if fetch( 'user', 'has_access_to', hash( 'module', 'network', 'function', 'service_portal' ))}
        {"You can access services for maintenance, monitoring and update as well as information on your subscription in the <a href=%link>Service Portal tab</a>"|i18n( 'design/admin/dashboard/maintenance', , hash( '%link', "network/service_portal"|ezurl ) )}
    {/if}
    </p>
</div>