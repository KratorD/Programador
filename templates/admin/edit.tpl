{adminheader}
<div class="z-admin-content-pagetitle">
    {if isset($id)}{assign var='icontype' value='edit'}{else}{assign var='icontype' value='new'}{/if}
    {icon type=$icontype size="small"}
    <h3>{if isset($id)}{gt text="Edit Program"}{else}{gt text="New Program"}{/if}</h3>
</div>

{form cssClass="z-form" enctype="multipart/form-data"}
    <fieldset>
        <legend>{if isset($id)}{gt text="Edit Program"}{else}{gt text="New Program"}{/if}</legend>

        {formvalidationsummary}

        <div class="z-formrow">
            {formlabel mandatorysym=true for="name" __text="Program Name"}
            {formtextinput id="name" mandatory=true maxLength=100}
        </div>

		<div class="z-formrow">
            {formlabel mandatorysym=true for="version" __text="Program Version"}
            {formtextinput id="version" mandatory=true maxLength=10}
        </div>

		<div class="z-formrow">
            {formlabel mandatorysym=true for="image" __text="Choose file for image"}
            {formuploadinput id="image"}
        </div>

		<div class="z-formrow">
            {formlabel mandatorysym=true for="description" __text="Description"}
            {formtextinput textMode='multiline' id="description" rows='6' cols='50' mandatory=true}
        </div>

		<div class="z-formrow">
            {formlabel mandatorysym=true for="reqWin" __text="Windows Requirements"}
            {formtextinput textMode='multiline' id="reqWin" rows='6' cols='50' mandatory=true}
			<p class="z-formnote z-informationmsg"><!--[gt text="The symbol that split the requeriments is %"]--></p>
        </div>

		<div class="z-formrow">
            {formlabel for="reqMac" __text="Macintosh Requirements"}
            {formtextinput textMode='multiline' id="reqMac" rows='6' cols='50'}
			<p class="z-formnote z-informationmsg"><!--[gt text="The symbol that split the requeriments is %"]--></p>
        </div>

		<div class="z-formrow">
            {formlabel for="reqLin" __text="Linux Requirements"}
            {formtextinput textMode='multiline' id="reqLin" rows='6' cols='50'}
			<p class="z-formnote z-informationmsg"><!--[gt text="The symbol that split the requeriments is %"]--></p>
        </div>

		<div class="z-formrow">
            {formlabel mandatorysym=true for="web" __text="URL"}
            {formtextinput id="web" mandatory=true maxLength=255}
        </div>
		
		<div class="z-formrow">
            {formlabel mandatorysym=true for="company" __text="Company"}
            {formtextinput id="company" mandatory=true maxLength=60 cssClass='z-w40 z-floatleft'}
			{formdropdownlist id="cmbComp" items=$cmbComp cssClass='z-w30'}
        </div>
		
		<div class="z-formrow">
            {formlabel mandatorysym=true for="category" __text="Category"}
            {formtextinput id="category" mandatory=true maxLength=30 cssClass='z-w40 z-floatleft'}
			{formdropdownlist id="cmbCateg" items=$cmbCateg cssClass='z-w30'}
        </div>

    </fieldset>

    <div class="z-buttons z-formbuttons">
        {formbutton class='z-bt-ok' commandName='create' __text='Save'}
        {formbutton class='z-bt-cancel' commandName='cancel' __text='Cancel'}
        {if isset($id)}{formbutton class="z-bt-delete z-btred" commandName="delete" __text="Delete" __confirmMessage='Delete'}{/if}
    </div>
{/form}
{adminfooter}
<script type="text/javascript">
// <![CDATA[
    $('cmbComp').observe('change', function(event) {
    $('company').value = $('cmbComp').value;

	});
// ]]>
</script>

<script type="text/javascript">
// <![CDATA[	
	$('cmbCateg').observe('change', function(event) {
    $('category').value = $('cmbCateg').value;
	});
// ]]>
</script>