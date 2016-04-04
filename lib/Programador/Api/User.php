<?php

/**
 * Programador
 *
 * @license GNU/LGPLv3 (or at your option, any later version).
 */

/**
 * Class to control User interface
 */
class Programador_Api_User extends Zikula_AbstractApi
{

    /**
     * get Programs filtered as requested
     * @param name $args
     * @return array of objects
     */
    public function getall($args)
    {
		// declare args
        $startnum = isset($args['startnum']) ? $args['startnum'] : 0;
        $sort = isset($args['sort']) ? $args['sort'] : 'name';
        $sortdir = isset($args['sortdir']) ? $args['sortdir'] : 'ASC';
		$name = isset($args['name']) ? $args['name'] : null;
		$company = isset($args['company']) ? $args['company'] : null;
		$category = isset($args['category']) ? $args['category'] : null;
		$nVersion = isset($args['nVersion']) ? $args['nVersion'] : false;
        $limit = isset($args['limit']) ? $args['limit'] : $this->getVar('perpage');

        $programs = $this->entityManager->getRepository('Programador_Entity_Programador')
                ->getCollection($sort, $sortdir, $startnum, $name, $company, $category, $nVersion, $limit);

        $result = array();
        foreach ($programs as $key => $program) {
            if (!SecurityUtil::checkPermission('Programador::Item', $program->getId() . '::', ACCESS_READ) ) {
                continue;
            } else {
                $result[$key] = $program;
            }
        }
        return $result;
    }

	/**
     * get Programs filtered as requested
     * @param name $args
     * @return array of objects
     */
    public function getByFilter($args)
    {
		// declare args
        $letter = isset($args['letter']) ? $args['letter'] : null;
		$program = isset($args['program']) ? $args['program'] : null;
		$search = isset($args['search']) ? $args['search'] : null;
		$limit = isset($args['limit']) ? $args['limit'] : $this->getVar('perpage');

        $programs = $this->entityManager->getRepository('Programador_Entity_Programador')
                ->getCollectionFilter($letter, $program, $search, $limit);

        $result = array();
        foreach ($programs as $key => $program) {
            if (!SecurityUtil::checkPermission('Programador::Item', $program->getId() . '::', ACCESS_READ) ) {
                continue;
            } else {
                $result[$key] = $program;
            }
        }
        return $result;
    }
	
    /**
     * count the number of results in the query
     * @param array $args
     * @return integer
     */
    public function countQuery($args)
    {
        $args['limit'] = -1;
        $items = $this->getall($args);
        return count($items);
    }

	/**
     * count the number of results in the query
     * @param array $args
     * @return integer
     */
    public function countQueryFilter($args)
    {
        $args['limit'] = -1;
        $items = $this->getByFilter($args);
        return count($items);
    }

	/**
     * retrieve a record
     * @param array $args
     * @return program entity
     */
    public function get($args)
    {
        $id = isset($args['id']) ? $args['id'] : 0;

        $program = $this->entityManager->getRepository('Programador_Entity_Programador')->findBy(array('id' => $id));

        return $program;
    }

	/**
     * Get diferents programs
     * @return programs
     */
    public function getPrograms()
    {
        $programs = $this->entityManager->getRepository('Programador_Entity_Programador')
                ->getPrograms();

        return $programs;
    }

	/**
     * Get diferents companies
     * @return companies
     */
    public function getCompanies()
    {
        $companies = $this->entityManager->getRepository('Programador_Entity_Programador')
                ->getCompanies();

        return $companies;
    }

	/**
     * Get diferents categories
     * @return categories
     */
    public function getCategories()
    {
        $categories = $this->entityManager->getRepository('Programador_Entity_Programador')
                ->getCategories();

        return $categories;
    }

	/**
     * Clear cache for given item. Can be called from other modules to clear an item cache.
     *
     * @param $item - the item: array with data or id of the item
     */
    public function clearItemCache(Programador_Entity_Programador $item)
    {
        // Clear View_cache
        $cache_ids = array();
        $cache_ids[] = 'display|id_' . $item->getId();
        $cache_ids[] = 'view|id_' . $item->getId();
        $view = Zikula_View::getInstance('Programador');
        foreach ($cache_ids as $cache_id) {
            $view->clear_cache(null, $cache_id);
        }

        // clear Theme_cache
        $cache_ids = array();
        $cache_ids[] = 'Programador|user|display|id_' . $item->getId();
        $cache_ids[] = 'Programador|user|view|'; 
        $cache_ids[] = 'homepage'; // for homepage (it can be adjustment in module settings)
        $theme = Zikula_View_Theme::getInstance();
        //if (Zikula_Core::VERSION_NUM > '1.3.2') {
        if (method_exists($theme, 'clear_cacheid_allthemes')) {
            $theme->clear_cacheid_allthemes($cache_ids);
        } else {
            // clear cache for current theme only
            foreach ($cache_ids as $cache_id) {
                $theme->clear_cache(null, $cache_id);
            }
        }
    }

}