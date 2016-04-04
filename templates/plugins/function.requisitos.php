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
 * <!--[makepercentbar percent=$browsers.msie.1 label="`$browsers.msie.1` %" width=200]-->
 *
 * @author       Krator
 * @since        04/03/09
 * @see          function.requisitos.php::smarty_function_requisitos()
 * @param        array       $params      All attributes passed to this function from the template
 * @param        object      &$smarty     Reference to the Smarty object
 * @param        string      $req	        String with the requeriments system join for %
 * @return       string      the results of the module function
 */
function smarty_function_requisitos($params, &$smarty)
{
    
    //Dividir la cadena en subcadenas por el signo % de la BD
    $req = $params['req'];
    $div = explode("%",$req);
	$num = count($div);
	$cont = 0;
	//Generar la cadena con la lista en HTML
	while($cont < $num){
		$cadena .= "<li>$div[$cont]</li>";
		$cont++;
	}
	return $cadena;
		
}
