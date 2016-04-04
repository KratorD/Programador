<?php
/**
 * Programador Module for Zikula
 *
 * @copyright (c) 2008, Mark West
 * @link http://www.markwest.me.uk
 * @version $Id: pntables.php 19262 2006-06-12 14:45:18Z markwest $
 * @license GNU/GPL - http://www.gnu.org/copyleft/gpl.html
*/

/**
 * Populate pntables array
 *
 * @author Krator
 * @return array pntables array
 */
function Programador_pntables()
{
    $pntable = array();

    // voting check table
    $pntable['programador'] = DBUtil::getLimitedTablename('programador');
    $pntable['programador_column'] = array( 'ID'   		  => 'ID',
                                            'Nombre' 	  => 'Nombre',
											'Web' 		  => 'Web',
											'imgProg' 	  => 'imgProg',
											'Descripcion' => 'Descripcion',
											'Requisitos'  => 'Requisitos',
											'Idioma' 	  => 'Idioma',
											'Empresa' 	  => 'Empresa',
											'Categoria'   => 'Categoria',
											'Version' 	  => 'Version',
											'UltimaV' 	  => 'UltimaV'
											);
    $pntable['programador_column_def'] = array( 'ID'  		  => "I(4) NOT NULL PRIMARY",
                                                'Nombre' 	  => "C(60) NOT NULL KEY",
												'Web' 		  => "C(255) NOT NULL",
												'imgProg' 	  => "C(25) NOT NULL",
												'Descripcion' => "X NOT NULL",
												'Requisitos'  => "X NOT NULL",
												'Idioma' 	  => "C(21) NOT NULL",
												'Empresa' 	  => "C(60) NOT NULL",
												'Categoria'   => "C(30) NOT NULL",
												'Version' 	  => "C(10) NOT NULL",
												'UltimaV' 	  => "L NULL"
												);
    $pntable['programador_column_idx'] = array('ID' => 'ID');
  
    // add standard data fields
    //ObjectUtil::addStandardFieldsToTableDefinition ($pntable['videos_usuarios_column'], '');
    //ObjectUtil::addStandardFieldsToTableDataDefinition($pntable['videos_usuarios_column_def']);

    return $pntable;
}
