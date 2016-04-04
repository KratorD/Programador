<?php
/**
 * Programador
 *
 * @license GNU/LGPLv3 (or at your option, any later version).
 */

/**
 * Class to control Admin interface
 */
class Programador_Controller_Admin extends Zikula_AbstractController
{

    /**
     * The main administration function.
     *
     * @return string HTML output string.
     */
    public function main()
    {
        // Security check will be done in view()
        $this->redirect(ModUtil::url('Programador', 'admin', 'view'));
    }
	
	/**
     * This method provides a generic item list overview.
     *
     * @return string|boolean Output.
     */
    public function view()
    {
        $this->throwForbiddenUnless(SecurityUtil::checkPermission('Programador::', '::', ACCESS_ADMIN), LogUtil::getErrorMsgPermission());

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

        $filter['sort'] = FormUtil::getPassedValue('sort', $sort, 'GET');
        $filter['sortdir'] = FormUtil::getPassedValue('sortdir', $sortdir, 'GET');
        if ($filter['sortdir'] != 'ASC' && $filter['sortdir'] != 'DESC') {
            $filter['sortdir'] = 'ASC';
        }
        $filter['name'] = isset($filter['name']) ? $filter['name'] : '';
        $filter['company'] = isset($filter['company']) ? $filter['company'] : '';
        $filter['category'] = isset($filter['category']) ? $filter['category'] : '';

        $this->view->assign('filter', $filter)
                   ->assign('sort', $filter['sort'])
                   ->assign('sortdir', $filter['sortdir']);

        // Get parameters from whatever input we need.
        $startnum = (int)$this->request->query->get('startnum', $this->request->request->get('startnum', isset($args['startnum']) ? $args['startnum'] : null));
		
		$this->view->assign('startnum', $startnum);
        
        $this->view->assign('rowcount', ModUtil::apiFunc('Programador', 'user', 'countQuery', $filter));

		//Diferents programs
		$difPrograms = ModUtil::apiFunc('Programador', 'user', 'getPrograms');
		$this->view->assign('difPrograms', $difPrograms);

		//Diferents companies
		$companies = ModUtil::apiFunc('Programador', 'user', 'getCompanies');
		$this->view->assign('companies', $companies);

		//Diferents categories
		$categories = ModUtil::apiFunc('Programador', 'user', 'getCategories');
		$this->view->assign('categories', $categories);

		$filter['startnum'] = $startnum;
        $programs = ModUtil::apiFunc('Programador', 'user', 'getall', $filter);

        return $this->view->assign('programs', $programs)
                          ->fetch('admin/view.tpl');
    }

	/**
     * Create or edit record.
     *
     * @return string|boolean Output.
     */
    public function edit()
    {
        $this->throwForbiddenUnless(SecurityUtil::checkPermission('Programador::', '::', ACCESS_ADD), LogUtil::getErrorMsgPermission());

        $form = FormUtil::newForm('Programador', $this);
        return $form->execute('admin/edit.tpl', new Programador_Form_Handler_Admin_Edit());
    }

	/**
     * Display a form to sort versions.
     *
     * @return string HTML output string.
     */
    public function modifyposition()
    {
		$this->throwForbiddenUnless(SecurityUtil::checkPermission('Programador::', '::', ACCESS_ADMIN), LogUtil::getErrorMsgPermission());

		// get our input
        $name = FormUtil::getPassedValue('name');

		// get programs's version
        $programs = ModUtil::apiFunc('Programador', 'user', 'getall', array('name' => $name));

		return $this->view->assign('programs', $programs)
                          ->assign('name', $name)
						  ->fetch('admin/modifyposition.tpl');

	}

    /**
     * @desc present administrator options to change module configuration
     * @return      config template
     */
    public function modifyconfig()
    {
        $this->throwForbiddenUnless(SecurityUtil::checkPermission('Programador::', '::', ACCESS_ADMIN), LogUtil::getErrorMsgPermission());

        return $this->view->fetch('admin/modifyconfig.tpl');
    }

    /**
     * @desc sets module variables as requested by admin
     * @return      status/error ->back to modify config page
     */
    public function updateconfig()
    {
        $this->checkCsrfToken();

        $this->throwForbiddenUnless(SecurityUtil::checkPermission('Programador::', '::', ACCESS_ADMIN), LogUtil::getErrorMsgPermission());

        $defaults = Programador_Util::getModuleDefaults();
        $currentModVars = $this->getVars();
        $defaults = array_merge($defaults, $currentModVars);

        $modvars = array(
            'perpage' => $this->request->request->get('perpage', $defaults['perpage']),
            'allowupload' => $this->request->request->get('allowupload', $defaults['allowupload']),
            'securedownload' => $this->request->request->get('securedownload', $defaults['securedownload']),
            'sizelimit' => $this->request->request->get('sizelimit', $defaults['sizelimit']),
            'limitsize' => $this->request->request->get('limitsize', $defaults['limitsize']),
            'limit_extension' => $this->request->request->get('limit_extension', $defaults['limit_extension']),
            'sortby' => $this->request->request->get('sortby', $defaults['sortby']),
            'cclause' => $this->request->request->get('cclause', $defaults['cclause']),
            'popular' => $this->request->request->get('popular', $defaults['popular']),
        );

        // set the new variables
        $this->setVars($modvars);

        // clear the cache
        $this->view->clear_cache();

        LogUtil::registerStatus($this->__('Done! Updated the Programador configuration.'));
        return $this->modifyconfig();
    }

    /**
     * @desc set caching to false for all admin functions
     * @return      null
     */
    public function postInitialize()
    {
        $this->view->setCaching(false);
    }

}