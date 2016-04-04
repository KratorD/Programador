<?php
/**
 * Zikula Application Framework
 *
 * @copyright (c) 2001, Zikula Development Team
 * @link http://www.zikula.org
 * @version $Id: pnuserapi.php 24342 2008-06-06 12:03:14Z markwest $
 * @license GNU/GPL - http://www.gnu.org/copyleft/gpl.html
 */

function Programador_userapi_getAll($args)
{
	
	// Optional arguments.
	if (!isset($args['startnum']) || empty($args['startnum'])) {
		$args['startnum'] = 1;
	}
	if (!isset($args['numitems']) || empty($args['numitems'])) {
		$args['numitems'] = -1;
	}
	if (!is_numeric($args['startnum']) ||
		!is_numeric($args['numitems'])) {
		return LogUtil::registerArgsError();
	}	
	if (!isset($args['order']) || empty($args['order'])) {
		$args['order'] = "Nombre";
	}
	if (isset($args['letra'])){
		$where = "WHERE `Nombre` LIKE '".$args['letra']."%' AND `UltimaV` = TRUE";
	}
	if (isset($args['buscar'])){
		$where = "WHERE `Nombre` LIKE '%".$args['buscar']."%' AND `UltimaV` = TRUE";
	}
	if (isset($args['comp'])){
		$where = "WHERE `Empresa` LIKE '".$args['comp']."' AND `UltimaV` = TRUE";
	}
	if (isset($args['cat'])){
		$where = "WHERE `Categoria` LIKE '".$args['cat']."' AND `UltimaV` = TRUE";
	}
	if (isset($args['nombre'])){
		$where = "WHERE `Nombre` LIKE '".$args['nombre']."'";
		if ($args['UltimaV'] == 'X'){
			$where.= " AND `UltimaV` = TRUE";
		}
	}

	$ficha = DBUtil::selectObjectArray ('programador', $where, $args['order']);
	// Validamos que el elemento existe en la BD
	if ($ficha === false) {
		//Lenguaje
		$dom = ZLanguage::getModuleDomain('Programador');
		return LogUtil::registerError(__('Error! Record do not found.', $dom));
	}

	// Retorna el objeto
	return $ficha;

}

function Programador_userapi_get($args)
{
	
	// Valida los parámetros requeridos
	if (!isset($args['ID']) || !is_numeric($args['ID'])) {
		return LogUtil::registerArgsError();
	}
  
	$ficha = DBUtil::selectObjectByID('programador', $args['ID'], 'ID');
  
	// Validamos que el elemento existe en la BD
	if ($ficha === false) {
		//Lenguaje
		$dom = ZLanguage::getModuleDomain('Programador');
		return LogUtil::registerError(__('Error! Record do not found.', $dom));
	}

	// Retorna el objeto
	return $ficha;
  
}

function Programador_userapi_getDistincts($args)
{
	
	// Optional arguments.
	if (!isset($args['startnum']) || empty($args['startnum'])) {
		$args['startnum'] = 1;
	}
	if (!isset($args['numitems']) || empty($args['numitems'])) {
		$args['numitems'] = -1;
	}
	if (!isset($args['order']) || empty($args['order'])) {
		$args['order'] = 'ID';
	}
	if (!is_numeric($args['startnum']) ||
		!is_numeric($args['numitems'])) {
		return LogUtil::registerArgsError();
	}

	//Recuperar el nombre de la tabla completa
	$pntable = &pnDBGetTables();	
	$table  = $pntable['Programador'];

	//Obtener los distintos de un campo
	$sql = "SELECT distinct(`".$args['campo']."`) FROM $table ORDER BY ".$args['order'];
	
	$disArray = DBUtil::executeSQL($sql);
	
	// Validamos que el elemento existe en la BD
	if ($disArray === false) {
		//Lenguaje
		$dom = ZLanguage::getModuleDomain('Programador');
		return LogUtil::registerError(__('Error! Record do not found.', $dom));
	}

	$cont = 0;
	while (!$disArray->EOF) {
		$cad[$cont]['Nombre'] = $disArray->fields[0];

		$disArray->MoveNext();
		$cont++;
	}
	/*$comp = $disArray->GetArray();
	
	$max = count($comp);	
	$cont = 0;
	while ($cont < $max){
		$cad[$cont]['Nombre'] = $comp[$cont][0];
		$cont++;
	}*/
	
	// Retorna el objeto
	return $cad;
  
}

function Programador_userapi_countitems($args)
{
	//Recuperar el nombre de la tabla completa
	$pntable = &pnDBGetTables();	
	$table  = $pntable['programador'];

	if (isset($args['filtroTipo']) && $args['filtroTipo'] != 'Todos') {
		$queryargs[] = "`Tipo` LIKE '".$args['filtroTipo']."'";
	}
	$where = '';
	if (count($queryargs) > 0) {
		$where = ' WHERE ' . implode(' AND ', $queryargs);
	}

	return DBUtil::selectObjectCount ('programador', $where, 'ID', false, '');

}

function Programador_userapi_getComp($args)
{

	//Recuperar el nombre de la tabla completa
	$pntable = &pnDBGetTables();
	$table  = $pntable['programador'];

	//Obtener las distintas compañias
	$sql = "SELECT distinct(`Empresa`) FROM $table order by 1";
	
	$companies = DBUtil::executeSQL($sql);	

	// Validamos que el elemento existe en la BD
	if ($companies === false) {
		//Lenguaje
		$dom = ZLanguage::getModuleDomain('Programador');
		return LogUtil::registerError(__('Error! Record do not found.', $dom));
	}

	while (!$companies->EOF) {
		$cad.= $companies->fields[0]."/";

		$companies->MoveNext();
	}
	//$comp = $companies->GetMenu('cmbComp'); Lo guarda directo a un combo box
	/*$comp = $companies->GetArray();
	$max = count($comp);	
	$cont = 0;
	while ($cont < $max){
		$cad .= $comp[$cont][0]."/";	
		$cont++;
	}*/
	
	// Retorna el objeto
	return $cad;

}

function Programador_userapi_getCat($args)
{

	//Recuperar el nombre de la tabla completa
	$pntable = &pnDBGetTables();	
	$table  = $pntable['programador'];

	//Obtener las distintas categorias
	$sql = "SELECT distinct(`Categoria`) FROM $table order by 1";
	
	$categ = DBUtil::executeSQL($sql);	

	// Validamos que el elemento existe en la BD
	if ($categ === false) {
		//Lenguaje
		$dom = ZLanguage::getModuleDomain('Programador');
		return LogUtil::registerError(__('Error! Record do not found.', $dom));
	}

	while (!$categ->EOF) {
		$cad.= $categ->fields[0]."/";

		$categ->MoveNext();
	}
	//$cat = $categ->GetMenu('cmbCateg');
	/*$cat = $categ->GetArray();
	$max = count($cat);	
	$cont = 0;
	while ($cont < $max){
		$cad .= $cat[$cont][0]."/";	
		$cont++;
	}*/
		
	// Retorna el objeto
	return $cad;

}