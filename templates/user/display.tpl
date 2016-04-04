{ajaxheader modname='Programador' ui=true}
{pagesetvar name='title' value='Programador'}

<h2><center>{gt text='Program List'}</center></h2>
<p>
	<form name="frmBsq" id="frmBsq" method="post" action="{modurl modname="Programador" type="user" func="filter"}">
	  <table width="600" border="0" align="center">
		<tr>
		  <td width="200"><div align="right">{img src=dpSearch.gif width=20 height=23}</div></td>
		  <td width="200"><div align="center"><input type="text" name="txtBusqueda" /></div></td>
		  <td width="200"><input type="submit" name="Buscar" value="Buscar" /></td>
		</tr>
	  </table>
	</form>
</p>

<p><div align="center">[
{ section name=lstLetras loop=$letras }
	<a href="{modurl modname="Programador" type="user" func="filter" letra=$letras[lstLetras]}">{$letras[lstLetras]}</a>
	{ if $smarty.section.lstLetras.index EQ round( $numLetras / 2 ) }
		&nbsp; ]<br />[ &nbsp;
	{ else }
		&nbsp;|&nbsp;
	{ /if }
{ /section }
 ]</div></p><br>

<table width="600" border="1" align="center">
  	<tr>
    	<td height="25" bgcolor="#66CC99">
    		<div align="center"><a href="{ $program.web }">
    		{ $program.name }&nbsp;{ $program.version }</a></div>
    	</td>
    </tr>
    <tr>
      <td><table width="600" border="1">
        <tr>
        {if ($smarty.foreach.con.iteration % 2) eq 0}
        	<td width="200" height="200" align="center" valign="middle"> 
				<div align="center">
					<img src="{$imgPath}{$program.image}" />
				</div>
			</td>
			<td bgcolor="#CCCC66">
        		<p style="text-align:justify">{ $program.description }</p>
			</td>
        {else}
        	<td bgcolor="#CCCC66">
        		<p style="text-align:justify">{ $program.description }</p>
			</td>
			<td width="200" height="200" align="center" valign="middle"> 
				<div align="center">
					<img src="{$imgPath}{$program.image}" />
				</div>
          </td>
        {/if}
        </tr></table>
      </td>
    </tr>
	<tr>
		<td bgcolor="#269">
			<ul id="tabs_requirements{$loopProg}" class="z-tabs">
                <li class="tab{$loopProg}"><a href="#reqWin{$loopProg}">{gt text='Windows Req.'}</a></li>
                <li class="tab{$loopProg}"><a href="#reqMac{$loopProg}">{gt text='Mac Req.'}</a></li>
				<li class="tab{$loopProg}"><a href="#reqLin{$loopProg}">{gt text='Linux Req.'}</a></li>
            </ul>
            <div id="reqWin{$loopProg}">{requisitos req=$program.reqWin}</div>
            <div id="reqMac{$loopProg}">{if $program.reqMac NE ''}{requisitos req=$program.reqMac}{else}{gt text='No detailed.'}{/if}</div>
			<div id="reqLin{$loopProg}">{if $program.reqLin NE ''}{requisitos req=$program.reqLin}{else}{gt text='No detailed.'}{/if}</div>
		</td>
	</tr>
    <tr>
	    <td>
	  		<table width="600" border="1">
		  		<tr>
	  				<td width="200" bgcolor="#66CC99"><div align="center">{gt text="Company:"} { $program.company }</div></td>
					<td width="380" height="25" bgcolor="#66CC99"><div align="center">{ $program.category }</div></td>
					{if $version NE 1}
						<td width="20" bgcolor="#66CC99"><div align="center">
						<a href="{modurl modname="Programador" type="user" func="filter" program=$program.name}">
						{ img src=h-boton.gif width=20 height=20 __alt="History" altml=true }</a></div></td>
					{/if}
		  		</tr>
		 		</table>
		 	</td>
    </tr>
  </table><br><br>
  <script type="text/javascript">
// <![CDATA[
    Zikula.UI.Tooltips($$('.tooltips'));
	var tabs{{$loopProg}} = new Zikula.UI.Tabs('tabs_requirements{{$loopProg}}');
// ]]>
</script>
