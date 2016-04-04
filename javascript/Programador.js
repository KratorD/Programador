/**
 * PostNuke Application Framework
 *
 * @copyright (c) 2002, Zikula Development Team
 * @link http://www.postnuke.com
 * @version $Id: Programador.js 18677 2006-04-06 12:07:09Z markwest $
 * @license GNU/GPL - http://www.gnu.org/copyleft/gpl.html
 * @package Zikula_3rdParty_Modules
 * @subpackage Programador
*/

/**
 * Load options for combo box
 *
 *@params none;
 *@return none;
 *@author Krator
 */
 
function Programador_cargaCmb(empresasStr, categoriasStr)
{

	var sel;
	empresas= empresasStr.split('/');
  categorias= categoriasStr.split('/');
	
	sel = document.frmFilter.Tipo[document.frmFilter.Tipo.selectedIndex].value;
	
	if (sel == "empresa"){
		document.frmFilter.cmb.length = empresas.length;
		for (i=0;i<empresas.length;i++){
			document.frmFilter.cmb.options[i].value = empresas[i];
			document.frmFilter.cmb.options[i].text = empresas[i];	
		}	
	}
	if (sel == "categoria"){
		document.frmFilter.cmb.length = categorias.length;
		for (i=0;i<categorias.length;i++){
			document.frmFilter.cmb.options[i].value = categorias[i];
			document.frmFilter.cmb.options[i].text = categorias[i];			
		}
	}
	if (sel == "vacio"){
		document.frmFilter.cmb.options.length = 0;
	}
}

function copiar_codigo_emp(){
	var codigo,indice;
	
	indice = document.frmAnadir.cmbEmpresa.selectedIndex;
	codigo = document.frmAnadir.cmbEmpresa.options[indice].text;
	document.frmAnadir.txtEmpresa.value = codigo;
}

function copiar_codigo_cat(){
	var codigo,indice;
	
	indice = document.frmAnadir.cmbCategoria.selectedIndex;
	codigo = document.frmAnadir.cmbCategoria.options[indice].text;
	document.frmAnadir.txtCateg.value = codigo;
}

function cargarCmb(Str,quien)
{

	var sel;
	valores= Str.split('/');
	
	if (quien == 'emp'){
		document.frmAnadir.cmbEmpresa.length = valores.length;
		for (i=0;i<valores.length;i++){
			document.frmAnadir.cmbEmpresa.options[i].value = valores[i];
			document.frmAnadir.cmbEmpresa.options[i].text = valores[i];	
		}
	}
	if (quien == 'cat'){
		document.frmAnadir.cmbCategoria.length = valores.length;
		for (i=0;i<valores.length;i++){
			document.frmAnadir.cmbCategoria.options[i].value = valores[i];
			document.frmAnadir.cmbCategoria.options[i].text = valores[i];	
		}
	}
	
}