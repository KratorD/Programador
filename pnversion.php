<?php
/**
 * Programador  Module
 *
 * @package      Programador
 * @version      $Id: pnversion.php 2011-05-18$
 * @author       Krator
 * @link         http://www.edicionmania.com
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */

$dom = ZLanguage::getModuleDomain('Programador');
$modversion['name']           = 'Programador';
$modversion['displayname']    = __('Programador', $dom);
$modversion['url']            = __('Programador', $dom);
$modversion['version']        = '0.3';
$modversion['description']    = __('Show a list of programs, features and requeriments', $dom);
$modversion['credits']        = 'pndocs/changelog.txt';
$modversion['help']           = 'pndocs/readme.txt';
$modversion['changelog']      = 'pndocs/changelog.txt';
$modversion['license']        = 'pndocs/license.txt';
$modversion['official']       = 0;
$modversion['author']         = 'Krator';
$modversion['contact']        = 'http://www.edicionmania.com';
$modversion['admin']          = 1;
$modversion['user']           = 1;
$modversion['securityschema'] = array('Programador::' => 'Programador::');
