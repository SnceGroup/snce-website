{* DO NOT EDIT THIS FILE! Use an override template instead. *}

<div class="context-block">
{* DESIGN: Header START *}<div class="box-header"><div class="box-tc"><div class="box-ml"><div class="box-mr"><div class="box-tl"><div class="box-tr">
<h1 class="context-title">{"Change password for user"|i18n("mbpaex/userpaex")}</h1>
{* DESIGN: Mainline *}<div class="header-mainline"></div>
{* DESIGN: Header END *}</div></div></div></div></div></div>

{* DESIGN: Content START *}<div class="box-ml"><div class="box-mr"><div class="box-content">

<form action={concat($module.functions.password.uri,"/",$userID)|ezurl} method="post" name="Password">
    
    {if $message}
        {if or($oldPasswordNotValid,$newPasswordNotMatch,$newPasswordNotValidate,$newPasswordMustDiffer)}
            {if $oldPasswordNotValid}
                <div class="warning">
                    <h2>{'Please retype your old password.'|i18n('mbpaex/userpaex')}</h2>
                </div>
            {/if}
            {if $newPasswordNotMatch}
                <div class="warning">
                    <h2>{"Password didn't match, please retype your new password."|i18n('mbpaex/userpaex')}</h2>
                </div>
            {/if}
            {if $newPasswordNotValidate}
                <div class="warning">
                    <h2>{"Password didn't validate, please retype your new password."|i18n('mbpaex/userpaex')}</h2>
                </div>
            {/if}
            {if $newPasswordMustDiffer}
                <div class="warning">
                    <h2>{"New password must be different from the old one. Please choose another password."|i18n('mbpaex/userpaex')}</h2>
                </div>
            {/if}                    
        {else}
            <div class="feedback">
                <h2>{'Password successfully updated.'|i18n('mbpaex/userpaex')}</h2>
            </div>
        {/if}
    {/if}
    
    <div class="block">
        {if $oldPasswordNotValid}*{/if}
        <label for="oldPassword">{"Old password"|i18n("mbpaex/userpaex")}</label><div class="labelbreak"></div>
        <input id="oldPassword" type="password" name="oldPassword" size="11" value="" />
    </div>
    
    <div class="block">
        <div class="element">
            {if or($newPasswordNotMatch,$newPasswordNotValidate)}*{/if}
            <label for="newPassword">{"New password"|i18n("mbpaex/userpaex")}</label><div class="labelbreak"></div>
            <input type="password" name="newPassword" id="newPassword" size="11" value="" />
        </div>
        <div class="element">
            {if or($newPasswordNotMatch,$newPasswordNotValidate)}*{/if}
            <label for="confirmPassword">{"Retype password"|i18n("mbpaex/userpaex")}</label><div class="labelbreak"></div>
            <input type="password" name="confirmPassword" id="confirmPassword" size="11" value="" />
        </div>
        <div class="break"></div>
    </div>
    {* DESIGN: Content END *}</div></div></div>
    
	<div class="controlbar">
	{* DESIGN: Control bar START *}<div class="box-bc"><div class="box-ml"><div class="box-mr"><div class="box-tc"><div class="box-bl"><div class="box-br">
	<div class="block">    
	        <input class="defaultbutton" type="submit" name="OKButton" value="{'OK'|i18n('mbpaex/userpaex')}" />
	        <input class="button" type="submit" name="CancelButton" value="{'Cancel'|i18n('mbpaex/userpaex')}" />
	</div>
	{* DESIGN: Control bar END *}</div></div></div></div></div></div>
	</div>
</form>
</div>