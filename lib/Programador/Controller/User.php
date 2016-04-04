<?php

/**
 * Programador
 *
 * @license GNU/LGPLv3 (or at your option, any later version).
 */

/**
 * Class to control User interface
 */
class Programador_Controller_User extends Zikula_AbstractController
{

    /**
     * main (default) method
     */
    public function main()
    {
        $this->redirect(ModUtil::url('Programador', 'user', 'view'));
    }

    /**
     * This method provides a generic item list overview.
     *
     * @return string|boolean Output.
     */
    public function view()
    {
        // check module permissions
        $this->throwForbiddenUnless(SecurityUtil::checkPermission('Programador::', '::', ACCESS_READ), LogUtil::getErrorMsgPermission());

        //Filters
		$sfilter = SessionUtil::getVar('filter', array(), 'Programador');
        $filter = FormUtil::getPassedValue('filter', $sfilter);

        $clear = FormUtil::getPassedValue('clear', 0);
        if ($clear) {
            $filter = array();
            SessionUtil::setVar('filter', $filter, 'Programador');
        }

		// sort and sortdir GET parameters override filter values
        $sort = (isset($filter['sort']) && !empty($filter['sort'])) ? strtolower($filter['sort']) : 'name';
        $sortdir = (isset($filter['sortdir']) && !empty($filter['sortdir'])) ? strtoupper($filter['sortdir']) : 'ASC';
		$letra  = $this->request->query->get('letra', isset($args['letra']) ? $args['letra'] : 'A');
		$name = $this->request->query->get('program', isset($args['program']) ? $args['program'] : null);
		$search = $this->request->query->get('search', isset($args['search']) ? $args['search'] : null);

        $filter['sort'] = FormUtil::getPassedValue('sort', $sort, 'GET');
        $filter['sortdir'] = FormUtil::getPassedValue('sortdir', $sortdir, 'GET');
        if ($filter['sortdir'] != 'ASC' && $filter['sortdir'] != 'DESC') {
            $filter['sortdir'] = 'ASC';
        }
        $filter['company'] = isset($filter['company']) ? $filter['company'] : '';
        $filter['category'] = isset($filter['category']) ? $filter['category'] : '';

        $this->view->assign('filter', $filter)
                   ->assign('sort', $filter['sort'])
                   ->assign('sortdir', $filter['sortdir']);

        // Get parameters from whatever input we need.
        $startnum = (int)$this->request->query->get('startnum', $this->request->request->get('startnum', isset($args['startnum']) ? $args['startnum'] : null));
		$this->view->assign('startnum', $startnum);
        
        //Preparamos la cabecera de la plantilla
		$letras = array("A","B","C","D","E","F","G","H","I","J","K","L","M",
                  "N","O","P","Q","R","S","T","U","V","W","X","Y","Z",
          	  	  "1","2","3","4","5","6","7","8","9","0");

		$num = count($letras) - 1;

        $this->view->setCacheId('view|ord_' . $orderby . '_' . $original_sdir . '_stnum_' . $startnum);

		if ($filter['company'] == '' && $filter['category'] == ''){
			$programs = ModUtil::apiFunc('Programador', 'user', 'getByFilter', array(
                    'startnum' => $startnum,
                    'orderby' => $orderby,
                    'orderdir' => $orderdir,
                    'letter' => $letra,
                ));
			$this->view->assign('rowcount', ModUtil::apiFunc('Programador', 'user', 'countQueryFilter', array(
                    'startnum' => $startnum,
                    'orderby' => $orderby,
                    'orderdir' => $orderdir,
                    'letter' => $letra,
                )));
		}else{
			$filter['nVersion'] = true;
			$programs = ModUtil::apiFunc('Programador', 'user', 'getall', $filter);
			$this->view->assign('rowcount', ModUtil::apiFunc('Programador', 'user', 'countQuery', $filter));
		}

		//Diferents companies
		$companies = ModUtil::apiFunc('Programador', 'user', 'getCompanies');
		$this->view->assign('companies', $companies);

		//Diferents categories
		$categories = ModUtil::apiFunc('Programador', 'user', 'getCategories');
		$this->view->assign('categories', $categories);

		// Image Path
        $imgPath = FileUtil::getDataDirectory() . '/' . $this->name . '/';

        return $this->view
                        ->assign('programs', $programs)
						->assign('letras', $letras)
						->assign('letra', $letra)
						->assign('numLetras', $num)
						->assign('imgPath', $imgPath)
                        ->fetch('user/view.tpl');
    }

    /**
     * Display one item
     * @param type $args
     * @return string|boolean
     */
    public function display($args)
    {
        $this->throwForbiddenUnless(SecurityUtil::checkPermission('Programador::', '::', ACCESS_READ), LogUtil::getErrorMsgPermission());
        $id = isset($args['id']) ? $args['id'] : (int)$this->request->query->get('id', null);
        if (!isset($id)) {
            throw new Zikula_Exception_Fatal($this->__f('Error! Could not find program for ID #%s.', $id));
        }

		//Preparamos la cabecera de la plantilla
		$letras = array("A","B","C","D","E","F","G","H","I","J","K","L","M",
                  "N","O","P","Q","R","S","T","U","V","W","X","Y","Z",
          	  	  "1","2","3","4","5","6","7","8","9","0");

		$num = count($letras) - 1;

		//Diferents companies
		$companies = ModUtil::apiFunc('Programador', 'user', 'getCompanies');
		$this->view->assign('companies', $companies);

		//Diferents categories
		$categories = ModUtil::apiFunc('Programador', 'user', 'getCategories');
		$this->view->assign('categories', $categories);

		// Image Path
        $imgPath = FileUtil::getDataDirectory() . '/' . $this->name . '/';
		
        $item = $this->entityManager->getRepository('Programador_Entity_Programador')->find($id);

        $this->view->setCacheId('display|id_' . $id);

        return $this->view
                        ->assign('program', $item)
						->assign('letras', $letras)
						->assign('numLetras', $num)
						->assign('imgPath', $imgPath)
                        ->fetch('user/display.tpl');
    }

	/**
     * This method provides a generic item list overview filtered.
     *
     * @return string|boolean Output.
     */
    public function filter($args)
    {
        // check module permissions
        $this->throwForbiddenUnless(SecurityUtil::checkPermission('Programador::', '::', ACCESS_READ), LogUtil::getErrorMsgPermission());

        // Get parameters from whatever input we need.
        $startnum = (int)$this->request->query->get('startnum', isset($args['startnum']) ? $args['startnum'] : null);
        $orderby = $this->request->query->get('orderby', isset($args['orderby']) ? $args['orderby'] : 'name');
        $original_sdir = $this->request->query->get('sdir', isset($args['sdir']) ? $args['sdir'] : 1);
		$letra  = $this->request->query->get('letra', isset($args['letra']) ? $args['letra'] : null);
		$name = $this->request->query->get('program', isset($args['program']) ? $args['program'] : null);
		$search = FormUtil::getPassedValue('txtBusqueda', isset($args['txtBusqueda']) ? $args['txtBusqueda'] : null, 'POST');

		//Preparamos la cabecera de la plantilla
		$letras = array("A","B","C","D","E","F","G","H","I","J","K","L","M",
                  "N","O","P","Q","R","S","T","U","V","W","X","Y","Z",
          	  	  "1","2","3","4","5","6","7","8","9","0");

		$num = count($letras) - 1;

        $this->view->setCacheId('filter|ord_' . $orderby . '_' . $original_sdir . '_stnum_' . $startnum);

        $this->view
                ->assign('startnum', $startnum)
                ->assign('orderby', $orderby)
                ->assign('sdir', $original_sdir)
				->assign('filter_active', false);

        $sdir = $original_sdir ? 0 : 1; //if true change to false, if false change to true
        // change class for selected 'orderby' field to asc/desc
        if ($sdir == 0) {
            $sort['class'][$orderby] = 'z-order-desc';
            $orderdir = 'DESC';
        }
        if ($sdir == 1) {
            $sort['class'][$orderby] = 'z-order-asc';
            $orderdir = 'ASC';
        }

		$this->view->assign('filter_active', (empty($letra)) ? false : true);
		
		$programs = ModUtil::apiFunc('Programador', 'user', 'getByFilter', array(
                    'startnum' => $startnum,
                    'orderby' => $orderby,
                    'orderdir' => $orderdir,
                    'letter' => $letra,
					'program' => $name,
					'search' => $search
                ));
        $rowcount = ModUtil::apiFunc('Programador', 'user', 'countQueryFilter', array(
				    'letter' => $letra,
					'program' => $name,
					'search' => $search
				));

		//Diferents companies
		$companies = ModUtil::apiFunc('Programador', 'user', 'getCompanies');
		$this->view->assign('companies', $companies);

		//Diferents categories
		$categories = ModUtil::apiFunc('Programador', 'user', 'getCategories');
		$this->view->assign('categories', $categories);

		// Image Path
        $imgPath = FileUtil::getDataDirectory() . '/' . $this->name . '/';

        return $this->view
                        ->assign('programs', $programs)
                        ->assign('rowcount', $rowcount)
						->assign('letras', $letras)
						->assign('numLetras', $num)
						->assign('imgPath', $imgPath)
                        ->fetch('user/view.tpl');
    }

}