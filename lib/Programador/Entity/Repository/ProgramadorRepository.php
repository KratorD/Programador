<?php

/**
 * Programador
 * 
 * @license MIT
 *
 * Please see the NOTICE file distributed with this source code for further
 * information regarding copyright and licensing.
 */
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Programador_Entity_Programador as Programador;

class Programador_Entity_Repository_ProgramadorRepository extends EntityRepository
{

    /**
     * Get a collection of items for display
     * 
     * @param string $orderBy
     * @param string $orderDir
     * @param integer $startNum
     * @param string $name
	 * @param string $company
	 * @param string $category
     * @param integer $limit
     * @return array of objects 
     */
    public function getCollection($orderBy, $orderDir, $startNum, $name = null, $company = null, $category = null, $nVersion = false, $limit)
    {
        $dql = "SELECT a FROM Programador_Entity_Programador a";
        $where = array();

        if (!empty($name)) {
            $where[] = "a.name LIKE '$name'";
        }
		if (!empty($company)) {
            $where[] = "a.company LIKE '$company'";
        }
		if (!empty($category)) {
            $where[] = "a.category LIKE '$category'";
        }
		if ($nVersion == true) {
            $where[] = "a.nVersion = (SELECT max(b.nVersion) FROM Programador_Entity_Programador b WHERE a.name = b.name)";
        }
        if (!empty($where)) {
            $dql .= ' WHERE ' . implode(' AND ', $where);
        }

        $dql .= " ORDER BY a.$orderBy $orderDir";

        // generate query
        $query = $this->_em->createQuery($dql);

        if ($startNum > 0) {
            $query->setFirstResult($startNum);
        }
        if ($limit > 0) {
            $query->setMaxResults($limit);
        }

        try {
            $result = $query->getResult();
        } catch (Exception $e) {
            echo "<pre>";
            var_dump($e->getMessage());
            var_dump($query->getDQL());
            var_dump($query->getParameters());
            var_dump($query->getSQL());
            die;
        }
        return $result;
    }

	/**
     * Get a collection of items for display
     * 
     * @param string $letter
	 * @param string $program
	 * @param string $search
     * @param integer $limit
     * @return array of objects 
     */
    public function getCollectionFilter($letter = null, $program = null, $search = null, $limit)
    {
        $dql = "SELECT a FROM Programador_Entity_Programador a";
        $where = array();

        if (!empty($letter)) {
            $where[] = "a.name LIKE '$letter%'";
			$where[] = "a.nVersion = (SELECT max(b.nVersion) FROM Programador_Entity_Programador b WHERE a.name = b.name)";
        }
		if (!empty($program)) {
            $where[] = "a.name LIKE '%$program%'";
        }
		if (!empty($search)) {
            $where[] = "(a.name LIKE '%$search%' OR a.company LIKE '%$search%' OR a.category LIKE '%$search%')";
			$where[] = "a.nVersion = (SELECT max(b.nVersion) FROM Programador_Entity_Programador b WHERE a.name = b.name)";
        }
        if (!empty($where)) {
            $dql .= ' WHERE ' . implode(' AND ', $where);
        }

//        $dql .= " ORDER BY a.$orderBy $orderDir";

        // generate query
        $query = $this->_em->createQuery($dql);

        if ($limit > 0) {
            $query->setMaxResults($limit);
        }

        try {
            $result = $query->getResult();
        } catch (Exception $e) {
            echo "<pre>";
            var_dump($e->getMessage());
            var_dump($query->getDQL());
            var_dump($query->getParameters());
            var_dump($query->getSQL());
            die;
        }
        return $result;
    }

	/**
     * get diferents programs
     * @return programs list
     */
    public function getPrograms()
    {
		$dql = "SELECT DISTINCT (a.name) FROM Programador_Entity_Programador a";
        $dql .= " ORDER BY a.name ASC";
		// generate query
        $query = $this->_em->createQuery($dql);

		try {
            $result = $query->getResult();
        } catch (Exception $e) {
            echo "<pre>";
            var_dump($e->getMessage());
            var_dump($query->getDQL());
            var_dump($query->getParameters());
            var_dump($query->getSQL());
            die;
        }
        return $result;
	}

	/**
     * get diferents companies
     * @return companies list
     */
    public function getCompanies()
    {
		$dql = "SELECT DISTINCT (a.company) FROM Programador_Entity_Programador a";
        $dql .= " ORDER BY a.company ASC";
		// generate query
        $query = $this->_em->createQuery($dql);

		try {
            $result = $query->getResult();
        } catch (Exception $e) {
            echo "<pre>";
            var_dump($e->getMessage());
            var_dump($query->getDQL());
            var_dump($query->getParameters());
            var_dump($query->getSQL());
            die;
        }
        return $result;
	}

	/**
     * get diferents categories
     * @return categories list
     */
    public function getCategories()
    {
		$dql = "SELECT DISTINCT (a.category) FROM Programador_Entity_Programador a";
        $dql .= " ORDER BY a.category ASC";
		// generate query
        $query = $this->_em->createQuery($dql);

		try {
            $result = $query->getResult();
        } catch (Exception $e) {
            echo "<pre>";
            var_dump($e->getMessage());
            var_dump($query->getDQL());
            var_dump($query->getParameters());
            var_dump($query->getSQL());
            die;
        }
        return $result;
	}
}