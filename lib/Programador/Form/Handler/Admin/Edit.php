<?php

/**
 * Programador
 *
 * @license GNU/LGPLv3 (or at your option, any later version).
 */
class Programador_Form_Handler_Admin_Edit extends Zikula_Form_AbstractHandler
{

    /**
     * program id.
     *
     * When set this handler is in edit mode.
     *
     * @var integer
     */
    private $id;

    /**
     * Setup form.
     *
     * @param Zikula_Form_View $view Current Zikula_Form_View instance.
     *
     * @return boolean
     */
    public function initialize(Zikula_Form_View $view)
    {
        $id = FormUtil::getPassedValue('id', null, 'GET', FILTER_SANITIZE_NUMBER_INT);
		$astemplate = FormUtil::getPassedValue('astemplate', null, 'GET', FILTER_SANITIZE_NUMBER_INT);
        if ($id) {
            // load record with id
            $program = $this->entityManager->getRepository('Programador_Entity_Programador')->find($id);

            if ($program) {
                // switch to edit mode
                $this->id = $id;
                // assign current values to form fields
                $view->assign($program->toArray());
            } else {
                return LogUtil::registerError($this->__f('Program with id %s not found', $id));
            }
        }
		if ($astemplate) {
            // load record with id
            $program = $this->entityManager->getRepository('Programador_Entity_Programador')->find($astemplate);

            if ($program) {
                // switch to edit mode
                //$this->id = $id;
                // assign current values to form fields
                $view->assign($program->toArray());
            } else {
                return LogUtil::registerError($this->__f('Program with id %s not found', $id));
            }
        }

        $view->setStateData('returnurl', ModUtil::url('Programador', 'admin', 'main'));
		
		//Dropdown Companies
		$companies = ModUtil::apiFunc('Programador', 'user', 'getCompanies');
		$cmbComp = array(array('text' => '', 'value' => ''));
		foreach ($companies as $company){
			$cmbComp[] = array('text' => $company['company'], 'value' => $company['company']);
		}
		$view->assign('cmbComp', $cmbComp);

		//Dropdown Categories
		$categories = ModUtil::apiFunc('Programador', 'user', 'getCategories');
		$cmbCateg = array(array('text' => '', 'value' => ''));
		foreach ($categories as $category){
			$cmbCateg[] = array('text' => $category['category'], 'value' => $category['category']);
		}
		$view->assign('cmbCateg', $cmbCateg);

        return true;
    }

    /**
     * Handle form submission.
     *
     * @param Zikula_Form_View $view  Current Zikula_Form_View instance.
     * @param array     &$args Args.
     *
     * @return boolean
     */
    public function handleCommand(Zikula_Form_View $view, &$args)
    {
        $returnurl = $view->getStateData('returnurl');

        // process the cancel action
        if ($args['commandName'] == 'cancel') {
            return $view->redirect($returnurl);
        }

        $storage = FileUtil::getDataDirectory() . '/' . $this->name . '/';

        if ($args['commandName'] == 'delete') {
            $program = $this->entityManager->getRepository('Programador_Entity_Programador')->find($this->id);
            $oldname = $program->getImage();
            $fullpath = DataUtil::formatForOS("$storage/$oldname");
            @unlink($fullpath);
            $this->entityManager->remove($program);
            $this->entityManager->flush();
            ModUtil::apiFunc('Programador', 'user', 'clearItemCache', $program);
            LogUtil::registerStatus($this->__f('Item [id# %s] deleted!', $this->id));
            return $view->redirect($returnurl);
        }

        // check for valid form
        if (!$view->isValid()) {
            return false;
        }

        // load form values
        $data = $view->getValues();
		
		//nVersion control
		if ($data['nVersion'] == ''){
			$lastV = ModUtil::apiFunc('Programador', 'user', 'getall', array(
				'name' => $data['name'],
				'sort' => 'nVersion',
				'sortdir' => 'DESC'
			));
			if ($lastV[0]['nVersion'] != ''){
				if ($this->id) {
					$data['nVersion'] = $lastV[0]->getnVersion();
				}else{
					$data['nVersion'] = $lastV[0]->getnVersion() + 1;
				}
			}else{
				$data['nVersion'] = 1;
			}
		}

		// Destroy the value of fields no-relationship with the entity
		unset($data['cmbComp']);
		unset($data['cmbCateg']);

        $newFileUploadedFlag = false;

        if ((is_array($data['image'])) && ($data['image']['size'] > 0)) {
            $result = Programador_Util::uploadFile('image', $storage, $data['image']['name']);
            if (!$result) {
                return LogUtil::registerError($result);
            }
            $newFileUploadedFlag = true;
            $name = $data['image']['name'];
            unset($data['image']);
            $data['image'] = $name;
        } else if (((is_array($data['image'])) && (!$data['image']['size'] > 0)) || (!isset($data['image']))) {
            $data['image'] = '';
        }

        // switch between edit and create mode
        if ($this->id) {
            $program = $this->entityManager->getRepository('Programador_Entity_Programador')->find($this->id);
            // if file is new, delete old one
            $oldname = $program->getImage();
            if ($newFileUploadedFlag) {
                $fullpath = "$storage/$oldname";
                @unlink($fullpath);
            } else {
                $data['image'] = $program->getImage();
            }
			LogUtil::registerStatus($this->__f('Item [id# %s] updated!', $this->id));
        } else {
            $program = new Programador_Entity_Programador();
			LogUtil::registerStatus($this->__f('Item created!'));
        }

        try {
            $program->merge($data);
            $this->entityManager->persist($program);
            $this->entityManager->flush();
        } catch (Zikula_Exception $e) {
            echo "<pre>";
            var_dump($e->getDebug());
            echo "</pre>";
            die;
        }

        ModUtil::apiFunc('Programador', 'user', 'clearItemCache', $program);

        return $view->redirect($returnurl);
    }

}