<?php
/**
 * Zikula Application Framework
 *
 * @copyright (c) 2001, Zikula Development Team
 * @link http://www.zikula.org
 * @version $Id: pnadmin.php 24342 2008-06-06 12:03:14Z markwest $
 * @license GNU/GPL - http://www.gnu.org/copyleft/gpl.html
 */

function Programador_admin_main()
{
    if (!SecurityUtil::checkPermission('Programador::', '::', ACCESS_ADMIN)) {
        return LogUtil::registerPermissionError();
    }

    return pnModFunc('Programador', 'admin', 'view');
}

function Programador_admin_view($args)
{
	
	if (!SecurityUtil::checkPermission('Programador::', '::', ACCESS_ADMIN)) {
		return LogUtil::registerPermissionError();
	}
	//Lenguaje
	$dom = ZLanguage::getModuleDomain('Programador');
	
	// Obtener todas las variables del modulo
	$modvars = pnModGetVar('Programador');
	
	$itemsperpage = $modvars['itemsperpage'];
	
	// Primer elemento a obtener de la paginacion
	$startnum = (($page - 1) * $itemsperpage) + 1;

	// Procesamos los datos con los APIs necesarios
	$lista = pnModAPIFunc('Programador', 'user', 'getAll', 
							array(	'startnum' => $startnum,
									'numitems' => $itemsperpage,
									'order'    => 'Nombre'));
	
	//Numero de registros para la paginacion
	$numitems = count($lista);
	
	//Crear la vista
	$render = & pnRender::getInstance('Programador');

	//Asignación de variables a la plantilla
	$render->assign('startnum', $startnum);
	$render->assign($modvars);
	$render->assign('listado', $lista);
	
	// Asignar los valores al sistema de paginación
	$render->assign('pager', array( 'numitems' => $numitems,
									'itemsperpage' => $itemsperpage));
	//Presentar la plantilla
	return $render->fetch('Programador_admin_view.htm');
																
}

function Programador_admin_new($args)
{
	
	if (!SecurityUtil::checkPermission('Programador::', '::', ACCESS_ADMIN)) {
		return LogUtil::registerPermissionError();
	}
	//Lenguaje
	$dom = ZLanguage::getModuleDomain('Programador');
	
	//Obtener los distintos valores de código de menús
	$empresas = pnModAPIFunc('Programador', 'user', 'getComp');
	$categorias = pnModAPIFunc('Programador', 'user', 'getCat');
		
	// Construimos y devolvemos la Vista
	$render = & pnRender::getInstance('Programador');
	//Asignamos los valores a la plantilla
	$render->assign('emp', $empresas);
	$render->assign('cat', $categorias);

	return $render->fetch('Programador_admin_new.htm');
  
}

function Programador_admin_create($args)
{
	
	if (!SecurityUtil::checkPermission('Programador::', '::', ACCESS_ADMIN)) {
		return LogUtil::registerPermissionError();
	}
	//Lenguaje
	$dom = ZLanguage::getModuleDomain('Programador');
	
	if (!pnModAPIFunc('Programador', 'admin', 'chkForm', array('form' => $_POST))){
		return LogUtil::registerError(__('Error! The form is not complete.', $dom));
	}
									
	//Insertar en la BD
	$last_id = DBUtil::selectFieldMax('programador','ID') ;
	$record['ID'] 		   = $last_id + 1;
	$record['Nombre'] 	   = $_POST['txtNombre'];
	$record['Web'] 		   = $_POST['txtURL'];
	$record['imgProg'] 	   = $_POST['txtimgProg'];
	$record['Descripcion'] = $_POST['txtDescripcion'];
	$record['Requisitos']  = $_POST['txtReq'];
	$record['Idioma'] 	   = $_POST['txtIdioma'];
	$record['Empresa'] 	   = $_POST['txtEmpresa'];
	$record['Categoria']   = $_POST['txtCateg'];
	$record['Version']     = $_POST['txtVersion'];
  
	if ($_POST['chkLastVersion'] == true){
		$record['UltimaV'] = true;
		//Comprobar una version anterior
		$lista = pnModAPIFunc('Programador', 'user', 'getAll', 
							array(	'nombre'  => $_POST['txtNombre'],
									'UltimaV' => 'X'));
		$old_record = $lista[0];
		if ($old_record['ID'] != ''){
			//Ya no será la ultima version
			$old_record['UltimaV'] = false;
			$result = pnModAPIFunc('Programador', 'admin', 'update', $old_record);
			if ($result === false)
				return LogUtil::registerError(__('Error trying update.', $dom));
		}
	}else{
		$record['UltimaV'] = false;
	}
	
	$result = pnModAPIFunc('Programador', 'admin', 'create', $record);
	if ($result === false)
		return LogUtil::registerError(__('Error trying to insert.', $dom));
		
	LogUtil::registerStatus (__('Program inserted sucessfully.', $dom));
	
	return pnRedirect(pnModURL('Programador', 'admin', 'view'));
  
}

function Programador_admin_modify($args)
{
	
	if (!SecurityUtil::checkPermission('Programador::', '::', ACCESS_ADMIN)) {
		return LogUtil::registerPermissionError();
	}
	//Recuperar los parametros
	$ID = isset($args['ID']) ? $args['ID'] : FormUtil::getPassedValue('ID', null, 'REQUEST');
	
	//Lenguaje
	$dom = ZLanguage::getModuleDomain('Programador');
	
	// Procesamos los datos con los APIs necesarios
	$ficha = pnModAPIFunc('Programador', 'user', 'get', array('ID' => $ID));
	if ($ficha === false) {
		return LogUtil::registerError(__('Error! Record do not found.', $dom));
	}
	
	//Obtener los distintos valores de código de menús
	$empresas = pnModAPIFunc('Programador', 'user', 'getComp');
	$categorias = pnModAPIFunc('Programador', 'user', 'getCat');
	
	//Enviarlas a la plantilla
	$render = & pnRender::getInstance('Programador');
	$render->assign('ficha', $ficha);
	$render->assign('emp', $empresas);
	$render->assign('cat', $categorias);
	
	return $render->fetch('Programador_admin_modify.htm');
  
}

function Programador_admin_update($args)
{
	
	if (!SecurityUtil::checkPermission('Programador::', '::', ACCESS_ADMIN)) {
		return LogUtil::registerPermissionError();
	}
	//Recuperar los parametros
	$ID = isset($args['ID']) ? $args['ID'] : FormUtil::getPassedValue('ID', null, 'REQUEST');
	
	//Lenguaje
	$dom = ZLanguage::getModuleDomain('Programador');
	
	if (!pnModAPIFunc('Programador', 'admin', 'chkForm', array('form' => $_POST))){
		return LogUtil::registerError(__('Error! The form is not complete.', $dom));
	}
	
	//Insertar en la BD
	$record['ID'] 		   = $ID;
	$record['Nombre'] 	   = $_POST['txtNombre'];
	$record['Web'] 		   = $_POST['txtURL'];
	$record['imgProg'] 	   = $_POST['txtimgProg'];
	$record['Descripcion'] = $_POST['txtDescripcion'];
	$record['Requisitos']  = $_POST['txtReq'];
	$record['Idioma'] 	   = $_POST['txtIdioma'];
	$record['Empresa'] 	   = $_POST['txtEmpresa'];
	$record['Categoria']   = $_POST['txtCateg'];
	$record['Version']     = $_POST['txtVersion'];
  
	if ($_POST['chkLastVersion'] == true){
		$record['UltimaV'] = true;
	}else{
		$record['UltimaV'] = false;
	}

	$result = pnModAPIFunc('Programador', 'admin', 'update', $record);
	if ($result === false)
		return LogUtil::registerError(__('Error trying update.', $dom));

	LogUtil::registerStatus (__('Program updated sucessfully.', $dom));
	
	return pnRedirect(pnModURL('Programador', 'admin', 'view'));
	
}

function Programador_admin_delete($args)
{
	if (!SecurityUtil::checkPermission('Programador::', '::', ACCESS_ADMIN)) {
		return LogUtil::registerPermissionError();
	}
	$confirmation = FormUtil::getPassedValue('confirmation', null, 'POST');
	
	//Recuperar los parametros
	$ID = isset($args['ID']) ? $args['ID'] : FormUtil::getPassedValue('ID', null, 'REQUEST');
	
	//Lenguaje
	$dom = ZLanguage::getModuleDomain('Programador');
	
	// Check for confirmation.
	if (empty($confirmation)) {
		// No confirmation yet
		// Construimos y devolvemos la Vista
		$render = & pnRender::getInstance('Programador');
		$render->assign('ID', $ID);

		// Return the output that has been generated by this function
		return $render->fetch('Programador_admin_delete.htm');
	}
	
	// Confirm authorisation code
	if (!SecurityUtil::confirmAuthKey()) {
		return LogUtil::registerAuthidError (pnModURL('Programador', 'admin', 'view'));
	}
	
	//Confirmamos que el registro que queremos borrar, existe.
	$lista = pnModAPIFunc('Programador', 'user', 'get', array('ID' => $ID));
	if ($lista === false) {
		return LogUtil::registerError(__('Error! Record do not found.', $dom));
	}
  
	if (pnModAPIFunc('Programador', 'admin', 'delete', array('ID' =>$ID))) {
		// Success
		LogUtil::registerStatus (__('Program deleted sucessfully.', $dom));
	}
	
	return pnRedirect(pnModURL('Programador', 'admin', 'view'));
	
}