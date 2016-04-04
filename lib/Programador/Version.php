<?php

/**
 * Programador
 *
 * @license GNU/LGPLv3 (or at your option, any later version).
 */

/**
 * Class to control Version information
 */
class Programador_Version extends Zikula_AbstractVersion
{

    public function getMetaData()
    {
        $meta = array();
        $meta['displayname'] = $this->__('Programador');
        $meta['url'] = $this->__(/* !used in URL - nospaces, no special chars, lcase */'Programador');
        $meta['description'] = $this->__('Show a list of programs, features and requeriments');
        $meta['version'] = '1.0.0';

        $meta['securityschema'] = array(
            'Programador::' => '::');
		$meta['core_min'] = '1.3.0'; // requires minimum 1.3.3 or later
        $meta['core_max'] = '1.4.99';

        return $meta;
    }

}