<?php
namespace Wwwision\AclManager\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Wwwision.AclManager".   *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Configuration\ConfigurationManager;
use TYPO3\Flow\Mvc\Controller\ActionController;
use TYPO3\Flow\Security\Policy\PolicyService;
use TYPO3\Flow\Security\Policy\Role;

/**
 * A controller for managing Access Control Lists (ACL)
 */
class AclController extends ActionController {

	/**
	 * @Flow\Inject
	 * @var PolicyService
	 */
	protected $policyService;

	/**
	 * @Flow\Inject
	 * @var ConfigurationManager
	 */
	protected $configurationManager;

	/**
	 * @return void
	 */
	public function indexAction() {
		$this->view->assign('roles', $this->policyService->getRoles());
	}

	/**
	 * @param Role $role
	 * @return void
	 */
	public function editAction(Role $role) {
		$privilegesByType = array();
		/** @var string[] $privilegeTypes */
		$privilegeTypes = $this->reflectionService->getAllImplementationClassNamesForInterface('TYPO3\Flow\Security\Policy\Privilege\PrivilegeInterface');
		foreach ($privilegeTypes as $privilegeType) {
			$privilegesByType[$privilegeType] = $role->getPrivilegesByType($privilegeType);
		}
		$this->view->assign('role', $role);
		$this->view->assign('privilegesByType', $privilegesByType);
	}

}