{ajaxheader modname='Programador' ui=true}
{adminheader}
<div class="z-admin-content-pagetitle">
    {icon type="view" size="small"}
    <h3>{gt text='Programador main'}</h3>
</div>

{insert name="getstatusmsg"}

<form class="z-form" action="{modurl modname="Programador" type="admin" func="view"}" method="post" enctype="application/x-www-form-urlencoded">
    {gt text="All" assign="lblAll"}
    {gt text="Filter" assign="lblFilter"}
    <fieldset>
        <legend>{$lblFilter}</legend>
        <span class="z-nowrap">
            <label for="filter_name">{gt text="Name"}</label>
            <select id="filter_name" name="filter[name]">
                <option value="0">{$lblAll}</option>
                {foreach from=$difPrograms item='progName'}
                    <option value="{$progName.name}" {if $filter.name eq $progName.name}selected="selected"{/if}>{$progName.name|safetext}</option>
                {/foreach}
            </select>
        </span>
        <span class="z-nowrap">
            <label for="filter_company">{gt text="Company"}</label>
            <select id="filter_company" name="filter[company]">
                <option value="0">{$lblAll}</option>
                {foreach from=$companies item='company'}
                    <option value="{$company.company}" {if $filter.company eq $company.company}selected="selected"{/if}>{$company.company|safetext}</option>
                {/foreach}
            </select>
        </span>
        <span class="z-nowrap">
            <label for="filter_category">{gt text="Category"}</label>
            <select id="filter_category" name="filter[category]">
                <option value="0">{$lblAll}</option>
                {foreach from=$categories item='category'}
                    <option value="{$category.category}" {if $filter.category eq $category.category}selected="selected"{/if}>{$category.category|safetext}</option>
                {/foreach}
            </select>
        </span>
        <span class="z-nowrap z-buttons">
            <input class="z-bt-filter z-bt-small" name="submit" type="submit" value="{gt text='Filter'}" />
            <input class="z-bt-cancel z-bt-small" name="clear" type="submit" value="{gt text='Clear'}" />
        </span>
    </fieldset>
</form>

<table class="z-datatable">
    <thead>
        <tr>
            <th>{sortlink __linktext='Name' sort='name' currentsort=$sort sortdir=$sortdir modname='Programador' type='admin' func='view' filter=$filter}</th>
            <th>{sortlink __linktext='Version' sort='version' currentsort=$sort sortdir=$sortdir modname='Programador' type='admin' func='view' filter=$filter}</th>
            <th>{gt text='#Version'}</th>
            <th>{sortlink __linktext='Company' sort='company' currentsort=$sort sortdir=$sortdir modname='Programador' type='admin' func='view' filter=$filter}</th>
			<th>{sortlink __linktext='Category' sort='category' currentsort=$sort sortdir=$sortdir modname='Programador' type='admin' func='view' filter=$filter}</th>
            <th class="z-nowrap z-right">{gt text='Actions'}</th>
        </tr>
    </thead>
    <tbody>
        {foreach from=$programs item='program'}
        <tr class="{cycle values="z-odd,z-even"}">
            <td>{$program->getName()|safetext}</td>
            <td>{$program->getVersion()|safetext}</td>
            <td>{$program->getnVersion()|safetext}</td>
            <td>{$program->getCompany()|safetext}</td>
			<td>{$program->getCategory()|safetext}</td>
            <td class="z-nowrap z-right">
                <a href="{modurl modname="Programador" type="user" func="display" id=$program->getId()}">{img modname='core' set='icons/extrasmall' src='14_layer_visible.png' __title='View' __alt='View' class='tooltips'}</a>
                <a href="{modurl modname="Programador" type="admin" func="edit" id=$program->getId()}">{img modname='core' set='icons/extrasmall' src='xedit.png' __title='Edit' __alt='Edit' class='tooltips'}</a>
				<a href="{modurl modname="Programador" type="admin" func="modifyposition" name=$program->getName()}">{img src="sort-ascend.png" __title='Modify #Version' __alt='Modify #Version' class='tooltips'}</a>
				<a href="{modurl modname="Programador" type="admin" func="edit" astemplate=$program->getId()}">{img modname='core' set='icons/extrasmall' src='filesaveas.png' __title='Reuse' __alt='Reuse' class='tooltips'}</a>
            </td>
        </tr>
        {foreachelse}
        <tr class='z-datatableempty'><td colspan='6' class='z-center'>{gt text='No programs founded.'}</td></tr>
        {/foreach}
    </tbody>
</table>
{pager rowcount=$rowcount limit=$modvars.Programador.perpage posvar='startnum'}
{adminfooter}
<script type="text/javascript">
// <![CDATA[
    Zikula.UI.Tooltips($$('.tooltips'));
// ]]>
</script>