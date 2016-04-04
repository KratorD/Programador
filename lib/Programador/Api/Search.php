<?php

class Programador_Api_Search extends Zikula_AbstractApi
{

    /**
     * Search plugin info
     */
    public function info()
    {
        return array(	'title' => 'Programador',
						'functions' => array('Programador' => 'search'));
    }

    /**
     * Search form component
     */
    public function options($args)
    {
        if (SecurityUtil::checkPermission('Programador::', '::', ACCESS_READ)) {
            $render = Zikula_View::getInstance('Programador');
            $render->assign('active', !isset($args['active']) || isset($args['active']['Programador']));
            return $render->fetch('search/options.tpl');
        }

        return '';
    }

    /**
     * Search plugin main function
     */
    public function search($args)
    {
        ModUtil::dbInfoLoad('Search');

        $sessionId = session_id();

        // this is a bit of a hacky way to ustilize this API for Doctrine calls.
        $where = Search_Api_User::construct_where($args, array(
                    'a.name',
                    'a.company',
					'a.category'), null);
        if (!empty($where)) {
            $where = trim(substr(trim($where), 1, -1));
        }

        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('a')
            ->from('Programador_Entity_Programador', 'a')
            ->where($where);
        $query = $qb->getQuery();
        $results = $query->getResult();

        foreach ($results as $result) {
            $title = $result->getName() . " " . $result->getVersion();
			$record = array(
                'title' => $title,
                'text' => $result->getDescription(),
                'extra' => serialize(array('id' => $result->getId())),
                'module' => 'Programador',
                'session' => $sessionId
            );

            if (!DBUtil::insertObject($record, 'search_result')) {
                return LogUtil::registerError($this->__('Error! Could not save the search results.'));
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
    public function search_check($args)
    {
        $datarow = &$args['datarow'];
        $extra = unserialize($datarow['extra']);

        $datarow['url'] = ModUtil::url('Programador', 'user', 'display', array('id' => $extra['id']));

        return true;
    }

}