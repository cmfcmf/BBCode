<?php
/**
 * BBCode
 *
 * @license http://www.gnu.org/copyleft/gpl.html
 * @package Zikula_Utility_Modules
 * @subpackage BBCode
 *
 * Please see the NOTICE file distributed with this source code for further
 * information regarding copyright and licensing.
 */

class BBCode_Controller_Admin extends Zikula_Controller
{
	/**
	* main function
	*
	*/
	public function main()
	{
	    if (!SecurityUtil::checkPermission('BBCode::', "::", ACCESS_ADMIN)) {
            return LogUtil::registerPermissionError(System::getVar('entrypoint', 'index.php'));
	    }

        $hookedmodules = array();
	    $hmods = ModUtil::apiFunc('modules', 'admin', 'gethookedmodules', array('hookmodname' => 'BBCode'));
        if(is_Array($hmods) ) {
            foreach($hmods as $hmod => $dummy) {
                $modid = ModUtil::getIdFromName($hmod);
                $moddata = ModUtil::getInfo($modid);
                $moddata['id'] = $modid;
                $hookedmodules[] = $moddata;
            }
        }
	    $this->view->assign('hookedmodules', $hookedmodules);
	    return $this->view->fetch('bbcode_admin_main.tpl');
	}

	/**
	* configuration
	*
	*/
	public function config()
	{
	    if (!SecurityUtil::checkPermission('BBCode::', "::", ACCESS_ADMIN)) {
            return LogUtil::registerPermissionError();
	    }

        // Create output object
        $form = FormUtil::newForm('BBCode', $this);
        // Return the output that has been generated by this function
        return $form->execute('bbcode_admin_config.tpl', new BBCode_Form_Handler_Admin_ModifyConfig());

	}


}
