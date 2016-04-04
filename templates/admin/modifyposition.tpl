{ajaxheader modname=Programador filename=blocks.js}
{pageaddvarblock}
<script type="text/javascript">
    document.observe("dom:loaded", blocksmodifyinit);
</script>
{/pageaddvarblock}
{ajaxheader modname='Programador' ui=true}
{adminheader}
<div class="z-admin-content-pagetitle">
    {icon type="view" size="small"}
    <h3>{gt text='Programador main'}</h3>
</div>

{insert name="getstatusmsg"}

<p class="z-informationmsg">{gt text="Notice: Use drag and drop to arrange the programs in this position into your desired order. The new program order will be saved automatically."}</p>
<form id="blockpositionform" class="z-form" action="{modurl modname="Programador" type="admin" func="updateposition"}" method="post" enctype="application/x-www-form-urlencoded">
	<input type="hidden" name="csrftoken" value="{insert name='csrftoken'}" />
	<input type="hidden" id="position" name="position[name]" value="{$name|safetext}" />
	<ol id="assignedblocklist" class="z-itemlist">
		<li id="assignedblocklistheader" class="z-itemheader z-itemsortheader z-clearfix">
			<span class="z-itemcell z-w10">{gt text="Name"}</span>
			<span class="z-itemcell z-w30">{gt text="Version"}</span>
			<span class="z-itemcell z-w15">{gt text="#Version"}</span>
			<span class="z-itemcell z-w15">{gt text="Company"}</span>
			<span class="z-itemcell z-w15">{gt text="Category"}</span>
		</li>
		{foreach from=$programs item='program'}
		<li id="block_{$program.nVersion}" class="{cycle name=assignedblocklist values="z-odd,z-even"} z-sortable z-clearfix z-itemsort">
			<span class="z-itemcell z-w10">{$program.name|safetext}</span>
			<span class="z-itemcell z-w30">{$program.version|safetext}</span>
			<span class="z-itemcell z-w15">{$program.nVersion|safetext}</span>
			<span class="z-itemcell z-w15">{$program.company|safetext}</span>
			<span class="z-itemcell z-w15">{$program.category|safetext}</span>
		</li>
		{/foreach}
	</ol>
</form>

{adminfooter}
<script type="text/javascript">
// <![CDATA[
    Zikula.UI.Tooltips($$('.tooltips'));
// ]]>
</script>