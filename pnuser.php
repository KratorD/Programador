<?php
/**
 * Zikula Application Framework
 *
 * @copyright (c) 2001, Zikula Development Team
 * @link http://www.zikula.org
 * @version $Id: pnuser.php 24342 2008-06-06 12:03:14Z markwest $
 * @license GNU/GPL - http://www.gnu.org/copyleft/gpl.html
 */

function Programador_user_main()
{
    return Programador_user_show(null);
}

function Programador_user_show($args)
{
	//Obtener los parametros	
	$letra  = FormUtil::getPassedValue('letra', isset($args['letra']) ? $args['letra'] : 'A', 'GET');
	
	// Procesamos los datos con los APIs necesarios
	$lista = pnModAPIFunc('Programador', 'user', 'getAll', array('letra' => $letra));
	$companies = pnModAPIFunc('Programador', 'user', 'getComp');
	$category = pnModAPIFunc('Programador', 'user', 'getCat');
	
	//Preparamos la cabecera de la plantilla
	$letras = array("A","B","C","D","E","F","G","H","I","J","K","L","M",
                  "N","O","P","Q","R","S","T","U","V","W","X","Y","Z",
          	  	  "1","2","3","4","5","6","7","8","9","0");

	$num = count($letras) - 1;
		
	// Construimos y devolvemos la Vista
	$render = & pnRender::getInstance('Programador');
	
	//Enviarlas a la plantilla
	$render->assign('listado', $lista);
	$render->assign('comp', $companies);
	$render->assign('categ', $category);
	$render->assign('letras', $letras);
	$render->assign('numLetras', $num);
	
	return $render->fetch('Programador_user_show.htm');

}

function Programador_user_buscar($args)
{
	
	//Obtener los parametros	
	$buscar  = FormUtil::getPassedValue('txtBusqueda', isset($args['txtBusqueda']) ? $args['txtBusqueda'] : 'A', 'POST');
	
	// Procesamos los datos con los APIs necesarios
	$lista = pnModAPIFunc('Programador', 'user', 'getAll', array('buscar' => $buscar));
	$companies = pnModAPIFunc('Programador', 'user', 'getComp');
	
	//Preparamos la cabecera de la plantilla
	$letras = array("A","B","C","D","E","F","G","H","I","J","K","L","M",
                  "N","O","P","Q","R","S","T","U","V","W","X","Y","Z",
          	  	  "1","2","3","4","5","6","7","8","9","0");

	$num = count($letras) - 1;
	
	// Construimos y devolvemos la Vista
	$render = & pnRender::getInstance('Programador');
	
	//Enviarlas a la plantilla
	$render->assign('listado', $lista);
	$render->assign('comp', $companies);
	$render->assign('letras', $letras);
	$render->assign('numLetras', $num);
	
	return $render->fetch('Programador_user_show.htm');
	
}

function Programador_user_filter($args)
{
	//Obtener los parametros	
	$type    = FormUtil::getPassedValue('Tipo', isset($args['Tipo']) ? $args['Tipo'] : 'Empresa', 'REQUEST');

	if ($type == "empresa"){
		$filter  = FormUtil::getPassedValue('cmb', isset($args['cmb']) ? $args['cmb'] : 'Adobe', 'POST');
		// Procesamos los datos con los APIs necesarios
		$lista = pnModAPIFunc('Programador', 'user', 'getAll', array('comp' => $filter));
	}else{
		$filter  = FormUtil::getPassedValue('cmb', isset($args['cmb']) ? $args['cmb'] : 'Edición', 'POST');
		// Procesamos los datos con los APIs necesarios
		$lista = pnModAPIFunc('Programador', 'user', 'getAll', array('cat' => $filter));
	}
		
	$companies = pnModAPIFunc('Programador', 'user', 'getComp');
	$cat = pnModAPIFunc('Programador', 'user', 'getCat');
	
	//Preparamos la cabecera de la plantilla
	$letras = array("A","B","C","D","E","F","G","H","I","J","K","L","M",
                  "N","O","P","Q","R","S","T","U","V","W","X","Y","Z",
          	  	  "1","2","3","4","5","6","7","8","9","0");

	$num = count($letras) - 1;
	
	// Construimos y devolvemos la Vista
	$render = & pnRender::getInstance('Programador');
	
	//Enviarlas a la plantilla
	$render->assign('listado', $lista);
	$render->assign('comp', $companies);
	$render->assign('categ', $cat);
	$render->assign('letras', $letras);
	$render->assign('numLetras', $num);
	
	return $render->fetch('Programador_user_show.htm');
}

function Programador_user_version($args)
{
	
	//Obtener los parametros	
	$version    = FormUtil::getPassedValue('Version', isset($args['Version']) ? $args['Version'] : NULL, 'REQUEST');
	
	if (!isset($version) || empty($version)) {
		return LogUtil::registerArgsError();
	}
	
	// Procesamos los datos con los APIs necesarios
	$lista = pnModAPIFunc('Programador', 'user', 'getAll', array('nombre' => $version));
	$companies = pnModAPIFunc('Programador', 'user', 'getComp');
	$cat = pnModAPIFunc('Programador', 'user', 'getCat');
	
	//Preparamos la cabecera de la plantilla
	$letras = array("A","B","C","D","E","F","G","H","I","J","K","L","M",
                  "N","O","P","Q","R","S","T","U","V","W","X","Y","Z",
          	  	  "1","2","3","4","5","6","7","8","9","0");

	$num = count($letras) - 1;
	
	// Construimos y devolvemos la Vista
	$render = & pnRender::getInstance('Programador');
	
	//Enviarlas a la plantilla
	$render->assign('listado', $lista);
	$render->assign('comp', $companies);
	$render->assign('categ', $cat);
	$render->assign('letras', $letras);
	$render->assign('numLetras', $num);
	$render->assign('version', 1);
	
	return $render->fetch('Programador_user_show.htm');
	
}