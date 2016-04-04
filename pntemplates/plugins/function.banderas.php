<?php
/**
 * Zikula Application Framework
 *
 * @copyright (c) 2002, Zikula Development Team
 * @link http://www.zikula.org
 * @version $Id: function.makepercentbar.php 24342 2008-06-06 12:03:14Z markwest $
 * @license GNU/GPL - http://www.gnu.org/copyleft/gpl.html
 * @package Zikula_Value_Addons
 * @subpackage Programador
 */

/**
 * Smarty function to display a requeriment system
 *
 * Example
 * <!--[ requisitos bandera=$lista.Banderas ]-->
 *
 * @author       Krator
 * @since        04/03/09
 * @see          function.banderas.php::smarty_function_requisitos()
 * @param        array       $params      All attributes passed to this function from the template
 * @param        object      &$smarty     Reference to the Smarty object
 * @param        string      $bandera     String with the flags
 * @return       string      the results of the module function
 */
function smarty_function_banderas($params, &$smarty)
{
    
    // load the pnimg plugin
    require_once $smarty->_get_plugin_filepath('function','img');
    
    //Dividir la cadena en subcadenas por el signo , de la BD
    $idioma = $params['banderas'];
    $div = explode(",",$idioma);
	$num = count($div);
	$cont = 0;
	while($cont < $num){
		$img .= '<img src="./images/flags/flag-'.$div[$cont].'.png">&nbsp;&nbsp;';
		$cont++;
	}
	return $img;
		
}
