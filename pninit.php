<?php
/**
 * Zikula Application Framework
 *
 * @copyright (c) 2001, Zikula Development Team
 * @link http://www.zikula.org
 * @version $Id: pninit.php 24342 2008-06-06 12:03:14Z markwest $
 * @license GNU/GPL - http://www.gnu.org/copyleft/gpl.html
 */

function Programador_init()
{
	
    $tables = array('programador');
    foreach ($tables as $table) {
    	if (!DBUtil::createTable($table)) {
			return false;
		}
    }

    // Set up module variables
	pnModSetVar('Programador', 'itemsperpage', 15);
	pnModSetVar('Programador', 'modulestylesheet', 'Programador.css');
	pnModSetVar('Programador', 'addcategorytitletopermalink', true);
		
    return true;
    
}

function Programador_upgrade($oldversion)
{
    /*if (!pnSecAuthAction(0, 'mymodule::', 'admin::', ACCESS_ADMIN)) {
		return _MODULENOAUTH;
	}*/
	$ok = true;
	
	switch($oldversion) {
		case "0.1" :{
			if (!Programador_upgrade_01to_02()) {
				return false;
			}
			break;
	    }
		case '0.2':
			$ok = $ok && Programador_upgrade_02to_03();
	    
	}
	return $ok;
}

function Programador_delete()
{
    $tables = array('programador');
    foreach ($tables as $table) {
		if (!DBUtil::dropTable($table)) {
			return false;
		}
    }
    pnModDelVar('Programador');
    return true;
}

function Programador_upgrade_01to_02()
{
	
	$sql = "ALTER TABLE `_programador` ADD `Version` VARCHAR( 10 ) NOT NULL ,
					ADD `UltimaV` BOOL NULL ";
	$alter = DBUtil::executeSQL($sql);
	if ($alter === false) {
		return false;
	}
	
	$sql = "UPDATE `_programador` SET `UltimaV` = TRUE WHERE `_programador`.`ID` > 0";
	$alter = DBUtil::executeSQL($sql);
	if ($alter === false) {
		return false;
	}
	
	return true;
	
}

function Programador_upgrade_02to_03()
{
	
	$sql = "ALTER TABLE `_programador` CHANGE `ID` `Id` TINYINT( 4 ) NOT NULL";
	$alter = DBUtil::executeSQL($sql);
	if ($alter === false) {
		return false;
	}
	
	return true;
	
}