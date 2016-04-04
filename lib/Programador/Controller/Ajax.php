<?php
/**
 * Copyright Zikula Foundation 2009 - Zikula Application Framework
 *
 * This work is contributed to the Zikula Foundation under one or more
 * Contributor Agreements and licensed to You under the following license:
 *
 * @license GNU/LGPLv3 (or at your option, any later version).
 * @package Zikula
 *
 * Please see the NOTICE file distributed with this source code for further
 * information regarding copyright and licensing.
 */

/**
 * Blocks_Controller_Ajax class.
 */
class Programador_Controller_Ajax extends Zikula_Controller_AbstractAjax
{
    /**
     * Changeblockorder.
     *
     * @param blockorder array of sorted blocks (value = block id)
     * @param position int zone id
     *
     * @return mixed true or Ajax error
     */
    public function changeblockorder()
    {
        $this->checkAjaxToken();
        $this->throwForbiddenUnless(SecurityUtil::checkPermission('Programador::', '::', ACCESS_ADMIN));

        $blockorder = $this->request->request->get('blockorder'); //name
        $position = $this->request->request->get('position'); //nVersion

		// get programs's version
        $programs = ModUtil::apiFunc('Programador', 'user', 'getall', array('name' => $position));

		$cont = 1;
		foreach ((array)$blockorder as $order) {
			$order--;
			$programs[$order]->setnVersion($cont);
			$this->entityManager->persist($programs[$order]);
			$cont++;
		}
		$this->entityManager->flush();

        return new Zikula_Response_Ajax(array('result' => true));
    }

}
