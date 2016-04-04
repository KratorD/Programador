<?php
/**
 * Zikula Application Framework
 *
 * @copyright (c) 2001, Zikula Development Team
 * @link http://www.zikula.org
 * @version $Id: pnadminapi.php 24342 2008-06-06 12:03:14Z markwest $
 * @license GNU/GPL - http://www.gnu.org/copyleft/gpl.html
 */

function Programador_adminapi_chkForm($args)
{
	
	if (!isset($args['form']) || empty($args['form'])) {
		return LogUtil::registerArgsError();
	}
	extract($args['form']);
	if ($txtNombre 	 	== '' ||
		$txtURL 		== '' ||
		$txtimgProg 	== '' ||
		$txtDescripcion == '' ||
		$txtReq	 		== '' ||
		$txtIdioma 	 	== '' ||
		$txtEmpresa 	== '' ||
		$txtCateg 	 	== '' ||
		$txtVersion 	== '' )
	{
		return false;
	}
	return true;
}

function Programador_adminapi_create($args)
{
	if (!isset($args) || empty($args)) {
		return LogUtil::registerArgsError();
	}
	extract($args);
	unset($args);
	
	if (!is_numeric($ID) ||
		!isset($Nombre) ||
		!isset($Web) ||
		!isset($imgProg) ||
		!isset($Descripcion) ||
		!isset($Requisitos) ||
		!isset($Idioma) ||
		!isset($Empresa) ||
		!isset($Categoria) ||
		!isset($Version) ){
	
		$dom = ZLanguage::getModuleDomain('Programador');
		return LogUtil::registerError(__('Error! Mandatory fields are not filled.', $dom));
			
	}
	
	$args['ID'] 		 = (int)pnVarPrepForStore($ID);
	$args['Nombre'] 	 = pnVarPrepForStore($Nombre);
	$args['Web'] 		 = pnVarPrepForStore($Web);
	$args['imgProg']     = pnVarPrepForStore($imgProg);
	$args['Descripcion'] = pnVarPrepForStore($Descripcion);
	$args['Requisitos']  = pnVarPrepForStore($Requisitos);
	$args['Idioma'] 	 = pnVarPrepForStore($Idioma);
	$args['Empresa'] 	 = pnVarPrepForStore($Empresa);
	$args['Categoria'] 	 = pnVarPrepForStore($Categoria);
	$args['Version'] 	 = pnVarPrepForStore($Version);
	$args['UltimaV'] 	 = pnVarPrepForStore($UltimaV);
	
	return DBUtil::insertObject($args, 'programador','ID',true);
	
}

function Programador_adminapi_update($args)
{
	if (!isset($args) || empty($args)) {
		return LogUtil::registerError (_MODARGSERROR);
	}
	extract($args);

	$args['ID'] 		 = (int)pnVarPrepForStore($ID);
	$args['Nombre'] 	 = pnVarPrepForStore($Nombre);
	$args['Web'] 		 = pnVarPrepForStore($Web);
	$args['imgProg'] 	 = pnVarPrepForStore($imgProg);
	$args['Descripcion'] = pnVarPrepForStore($Descripcion);
	$args['Requisitos']  = pnVarPrepForStore($Requisitos);
	$args['Idioma'] 	 = pnVarPrepForStore($Idioma);
	$args['Empresa'] 	 = pnVarPrepForStore($Empresa);
	$args['Categoria'] 	 = pnVarPrepForStore($Categoria);
	$args['Version'] 	 = pnVarPrepForStore($Version);
	$args['UltimaV'] 	 = pnVarPrepForStore($UltimaV);
	
	return DBUtil::updateObject($args, 'programador','','ID',true);
	
}

/**
 * Borrar un Programa
 * @param $args['id'] ID del Programa
 * @return bool true on success, false on failure
 */
function Programador_adminapi_delete($args)
{
	// Argument check
	if (!isset($args['ID'])) {
		return LogUtil::registerArgsError();
	}
	//Lenguaje
	$dom = ZLanguage::getModuleDomain('Programador');

	// Check item exists before attempting deletion
	$item = pnModAPIFunc('Programador', 'user', 'get', array('ID' => $args['ID']));

	if ($item == false) {
		LogUtil::registerError(__('Error! Record do not found.', $dom));
	}

	if (!DBUtil::deleteObjectByID('programador', $args['ID'], 'ID')) {
		return LogUtil::registerError(__('Error! Deletion attempt failed.', $dom));
	}

	// The item has been modified, so we clear all cached pages of this item.
	$render = & pnRender::getInstance('Programador');
	$render->clear_cache(null, $args['ID']);
	$render->clear_cache('Programador_user_view.htm');

	return true;
	
}