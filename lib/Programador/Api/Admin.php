<?php
/**
 * Programador
 *
 * @license GNU/LGPLv3 (or at your option, any later version).
 */

/**
 * Class to control Admin interface
 */
class Programador_Api_Admin extends Zikula_AbstractApi
{

    /**
     * Get available admin panel links
     *
     * @return array array of admin links
     */
    public function getlinks()
    {
        // Define an empty array to hold the list of admin links
        $links = array();

        if (SecurityUtil::checkPermission('Programador::', '::', ACCESS_ADMIN)) {
            $links[] = array(
                'url' => ModUtil::url('Programador', 'admin', 'main'),
                'text' => $this->__('Programs List'),
                'class' => 'z-icon-es-view');
        }

        if (SecurityUtil::checkPermission('Programador::', '::', ACCESS_ADMIN)) {
            $links[] = array(
                'url' => ModUtil::url('Programador', 'admin', 'edit'),
                'text' => $this->__('New program'),
                'class' => 'z-icon-es-new');
        }

        if (SecurityUtil::checkPermission('Programador::', '::', ACCESS_ADMIN)) {
            $links[] = array(
                'url' => ModUtil::url('Programador', 'admin', 'modifyconfig'),
                'text' => $this->__('Settings'),
                'class' => 'z-icon-es-config');
        }

        return $links;
    }

}