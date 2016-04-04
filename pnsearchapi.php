<?php

/**
 * Search plugin info
 **/
function Programador_searchapi_info()
{
    return array('title' => 'Programador', 
                 'functions' => array('Programador' => 'search'));
}

/**
 * Search form component
 **/
function Programador_searchapi_options($args)
{
    if (SecurityUtil::checkPermission( 'Programador::', '::', ACCESS_READ)) {
        $pnRender = pnRender::getInstance('Programador');
        $pnRender->assign('active',(isset($args['active'])&&isset($args['active']['Programador']))||(!isset($args['active'])));
        return $pnRender->fetch('Programador_search_options.htm');
    }

    return '';
}

/**
 * Search plugin main function
 **/
function Programador_searchapi_search($args)
{
    pnModDBInfoLoad('Programador');
    $pntable = pnDBGetTables();
    $progtable = $pntable['programador'];
    $progcolumn = $pntable['programador_column'];
    $searchTable = $pntable['search_result'];
    $searchColumn = $pntable['search_result_column'];

    $where = search_construct_where($args, 
                                    array($progcolumn['Nombre'], 
                                          $progcolumn['Empresa']), 
                                    null);
	
    $sessionId = session_id();

    // get the result set
    $objArray = DBUtil::selectObjectArray('programador', $where); //, 'faqid', 1, -1, '', $permFilter);
	if ($objArray === false) {
        return LogUtil::registerError(__('Error! Record do not found.'));
    }

    $insertSql = 
"INSERT INTO $searchTable
  ($searchColumn[title],
   $searchColumn[text],
   $searchColumn[extra],
   $searchColumn[created],
   $searchColumn[module],
   $searchColumn[session])
VALUES ";

    // Process the result set and insert into search result table
    foreach ($objArray as $obj) {

		$extra = serialize(array('ID' => $obj['ID']));
				
        $sql = $insertSql . '(' 
                   . '\'' . DataUtil::formatForStore($obj['Nombre']) . '\', '
                   . '\'' . DataUtil::formatForStore($obj['Descripcion']) . '\', '
                   . '\'' . DataUtil::formatForStore($obj['Nombre']) . '\', '
                   . '\'' . null . '\', '
                   . '\'' . 'Programador' . '\', '
                   . '\'' . DataUtil::formatForStore($sessionId) . '\')';
        $insertResult = DBUtil::executeSQL($sql);
        if (!$insertResult) {
            return LogUtil::registerError(__('Error! Record do not found.'));
        }
    }

    return true;
}

/**
 * Do last minute access checking and assign URL to items
 *
 * Access checking is ignored since access check has
 * already been done. But we do add a URL to the found item
 */
function Programador_searchapi_search_check(&$args)
{
    $datarow = &$args['datarow'];
    //$extra = unserialize($datarow['extra']);
	$extra = $datarow['extra'];

    $datarow['url'] = pnModUrl('Programador', 'user', 'version', array('Version' => $extra));

    return true;
}
