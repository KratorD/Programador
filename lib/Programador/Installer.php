<?php

/**
 * Programador
 *
 * @license GNU/LGPLv3 (or at your option, any later version).
 */

/**
 * Class to control Installer interface
 */
class Programador_Installer extends Zikula_AbstractInstaller
{

    /**
     * Initializes a new install
     *
     * This function will initialize a new installation.
     * It is accessed via the Zikula Admin interface and should
     * not be called directly.
     *
     * @return  boolean    true/false
     */
    public function install()
    {
        // create the table
        try {
            DoctrineHelper::createSchema($this->entityManager, array('Programador_Entity_Programador'));
        } catch (Exception $e) {
            return LogUtil::registerError($this->__('Doctrine Exception: ') . $e->getMessage());
        }

        // Set up config variables
        $this->setVars(Programador_Util::getModuleDefaults());
		$this->createUploadDir();

        return true;
    }

    /**
     * Upgrades an old install
     *
     * This function is used to upgrade an old version
     * of the module.  It is accessed via the Zikula
     * Admin interface and should not be called directly.
     *
     * @param   string    $oldversion Version we're upgrading
     * @return  boolean   true/false
     */
    public function upgrade($oldversion)
    {
        $this->throwForbiddenUnless(SecurityUtil::checkPermission('Programador::', '::', ACCESS_ADMIN), LogUtil::getErrorMsgPermission());

        switch ($oldversion) {
            case '0.3':
				// remove all old module vars
				$this->delVars();
				// create the table
				try {
					DoctrineHelper::createSchema($this->entityManager, array('Programador_Entity_Programador'));
				} catch (Exception $e) {
					return LogUtil::registerError($this->__('Doctrine Exception: ') . $e->getMessage());
				}

				// Set up config variables
				$this->setVars(Programador_Util::getModuleDefaults());
				$this->createUploadDir();

				$prefix = $this->serviceManager['prefix'];
				$connection = $this->entityManager->getConnection();

				$sql = "SELECT * from `". $prefix . "_programador` ORDER BY `nombre`, `id`";
				$statement = $connection->prepare($sql);
				$statement->execute();
				$results = $statement->fetchAll();

				$cont = 1;
				foreach ($results as $result){
					unset ($program);
					$program = new Programador_Entity_Programador();
					$program->setName($result['Nombre']);
					$program->setVersion($result['Version']);
					if ($oldname != $result['Nombre']){
						$cont = 1;
					}
					$program->setnVersion($cont);
					$program->setImage($result['imgProg']);
					$program->setDescription($result['Descripcion']);
					$program->setReqWin($result['Requisitos']);
					$program->setReqMac('');
					$program->setReqLin('');
					$program->setWeb($result['Web']);
					$program->setCompany($result['Empresa']);
					$program->setCategory($result['Categoria']);

					try {
						$this->entityManager->persist($program);
					} catch (Zikula_Exception $e) {
						echo "<pre>";
						var_dump($e->getDebug());
						echo "</pre>";
						die;
					}

					$oldname = $result['Nombre'];
					$cont++;

				}
				try {
					$this->entityManager->flush();
					$sql = "DROP TABLE `". $prefix . "_programador` ";
					$statement = $connection->prepare($sql);
					$statement->execute();
				} catch (Zikula_Exception $e) {
					echo "<pre>";
					var_dump($e->getDebug());
					echo "</pre>";
					die;
				}
		
			case '1.0.1':
            //future development
        }

        return true;
    }

    /**
     * removes an install
     *
     * This function removes the module from your
     * Zikula install and should be accessed via
     * the Zikula Admin interface
     *
     * @return  boolean    true/false
     */
    public function uninstall()
    {
        // drop tables
        DoctrineHelper::dropSchema($this->entityManager, 'Programador_Entity_Programador');

        //remove files from data folder
        $uploaddir = FileUtil::getDataDirectory() . '/' . $this->name . '/';
        FileUtil::deldir($uploaddir, true);

        // remove all module vars
        $this->delVars();

        return true;
    }

	/**
     * Upload directory creation
     */
    private function createUploadDir()
    {
        // upload dir creation
        $uploaddir = FileUtil::getDataDirectory() . '/' . $this->name . '/';

        if (mkdir($uploaddir, System::getVar('system.chmod_dir', 0777), true)) {
            LogUtil::registerStatus($this->__f('Created the file storage directory successfully at [%s]. Be sure that this directory is accessible via web and writable by the webserver.', $uploaddir));
        }

        return $uploaddir;
    }

}