{adminheader}
<div class="z-admin-content-pagetitle">
    {icon type="config" size="small"}
    <h3>{gt text='Programador settings'}</h3>
</div>

<form class="z-form" action="{modurl modname="Programador" type="admin" func="updateconfig"}" method="post" enctype="application/x-www-form-urlencoded">
    <div>
        <input type="hidden" name="csrftoken" value="{insert name="csrftoken"}" />
        <fieldset>
            <legend>{gt text='General settings'}</legend>

            <div class="z-formrow">
                <label for="limitsize">{gt text='Maximum file size'}</label>
                <input disabled="disabled" id="limitsize" type="text" name="limitsize" value="{$modvars.Programador.limitsize|safetext}" size="40" maxlength="80" />
            </div>
			
			<div class="z-formrow">
                <label for="perpage">{gt text='Programs per page'}</label>
                <input id="perpage" type="text" name="perpage" value="{$modvars.Programador.perpage|safetext}" size="40" maxlength="80" />
            </div>

        </fieldset>

        <!--
        <fieldset>
            <legend>{gt text='Allowed Extension settings'}</legend>

            <div class="z-formrow">
                <label for="limit_extension">{gt text='limit_extension'}</label>
                <input disabled="disabled" type="checkbox" value="1" id="limit_extension" name="limit_extension"{if $modvars.Programador.limit_extension eq true} checked="checked"{/if}/>
            </div>

            <div class="z-formrow">
                <label for="importfrommod">{gt text='importfrommod'}</label>
                <input disabled="disabled" type="checkbox" value="1" id="importfrommod" name="importfrommod"{if $modvars.Programador.importfrommod eq true} checked="checked"{/if}/>
            </div>

        </fieldset>
        -->
        <div class="z-buttons z-formbuttons">
            {button src="button_ok.png" set="icons/extrasmall" __alt="Save" __title="Save" __text="Save"}
            <a href="{modurl modname="Programador" type="admin" func='modifyconfig'}" title="{gt text="Cancel"}">{img modname=core src="button_cancel.png" set="icons/extrasmall" __alt="Cancel" __title="Cancel"} {gt text="Cancel"}</a>
        </div>
    </div>
</form>
{adminfooter}