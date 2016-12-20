<?php
/*  
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; under version 2
 * of the License (non-upgradable).
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 * 
 * Copyright (c) 2002-2008 (original work) Public Research Centre Henri Tudor & University of Luxembourg (under the project TAO & TAO2);
 *               2008-2010 (update and modification) Deutsche Institut für Internationale Pädagogische Forschung (under the project TAO-TRANSFER);
 *               2009-2012 (update and modification) Public Research Centre Henri Tudor (under the project TAO-SUSTAIN & TAO-DEV);
 * 
 */
?>
<?php
/**
 * @author CRP Henri Tudor - TAO Team - {@link http://www.tao.lu}
 * @license GPLv2  http://www.opensource.org/licenses/gpl-2.0.php
 * @package tao
 * @subpackage action
 *
 */
class tao_actions_PersistenceTutorial extends tao_actions_CommonModule {
	
	//*********************************************************************
	//***     READ    *****************************************************
	//*********************************************************************
	
	public function readLiterals() {
		$user = new core_kernel_classes_Resource(LOCAL_NAMESPACE.'#superUser');
		$propertyLabel = new core_kernel_classes_Property(RDFS_LABEL); // http://www.w3.org/2000/01/rdf-schema#label
		
		$literals = $user->getPropertyValues($propertyLabel);
		echo 'Label: '.current($literals);
	}
	
	public function readResources() {
		$user = new core_kernel_classes_Resource(LOCAL_NAMESPACE.'#superUser');
		$propertyRoles = new core_kernel_classes_Property(PROPERTY_USER_ROLES); // http://www.tao.lu/Ontologies/generis.rdf#userRoles
		$uris = $user->getPropertyValues($propertyRoles);
		foreach ($uris as $uri) {
		   $resource = new core_kernel_classes_Resource($uri);
		   echo 'The admin has the role: '.$resource->getLabel()."\n";
		}
	}
	
	//*********************************************************************
	//***   UPDATE    *****************************************************
	//*********************************************************************
	
	
	public function verifyUpdate() {
		$user = new core_kernel_classes_Resource(LOCAL_NAMESPACE.'#superUser');
		$propertyRoles = new core_kernel_classes_Property(RDFS_COMMENT); // http://www.tao.lu/Ontologies/generis.rdf#userRoles
		echo "The admin has the comments: <br />\n".implode("<br />\n", $user->getPropertyValues($propertyRoles));
	}
	
	public function updateSet() {
		$user = new core_kernel_classes_Resource(LOCAL_NAMESPACE.'#superUser');
		$propertyComment = new core_kernel_classes_Property(RDFS_COMMENT); // http://www.w3.org/2000/01/rdf-schema#comment
		
		$success = $user->setPropertyValue($propertyComment, 'a nice guy');
	}
	
	public function updateEdit() {
		$user = new core_kernel_classes_Resource(LOCAL_NAMESPACE.'#superUser');
		$propertyComment = new core_kernel_classes_Property(RDFS_COMMENT); // http://www.w3.org/2000/01/rdf-schema#comment
		
		$success = $user->editPropertyValues($propertyComment, 'an ok guy');
	}
	
	public function updateRemove() {
		$user = new core_kernel_classes_Resource(LOCAL_NAMESPACE.'#superUser');
		$propertyComment = new core_kernel_classes_Property(RDFS_COMMENT); // http://www.w3.org/2000/01/rdf-schema#comment
		
		$success = $user->removePropertyValue($propertyComment, 'an ok guy');
	}
	
	public function updateRemoveAll() {
		$user = new core_kernel_classes_Resource(LOCAL_NAMESPACE.'#superUser');
		$propertyComment = new core_kernel_classes_Property(RDFS_COMMENT); // http://www.w3.org/2000/01/rdf-schema#comment
		
		$success = $user->removePropertyValues($propertyComment);
	}

	//*********************************************************************
	//***   CREATE    *****************************************************
	//*********************************************************************
	
	public function createInstance() {
		$itemClass = new core_kernel_classes_Class(TAO_ITEM_CLASS); //http://www.tao.lu/Ontologies/TAOItem.rdf#Item

		$newItem = $itemClass->createInstance('optionalItemLabel');
	}
	
	public function createSubclass() {
		$itemClass = new core_kernel_classes_Class(TAO_ITEM_CLASS); //http://www.tao.lu/Ontologies/TAOItem.rdf#Item
		$subClass = $itemClass->createSubClass('optionalSubclassLabel');
	}
	
	public function createClass() {
		$classClass = new core_kernel_classes_Class('http://www.w3.org/2000/01/rdf-schema#Class');
		$newClass = $classClass->createInstance('optionalLabel'); 
	}
	
	//*********************************************************************
	//***   DELETE    *****************************************************
	//*********************************************************************
	
	public function deleteInstance() {
		$resource = new core_kernel_classes_Resource(LOCAL_NAMESPACE.'#instance1');
		$success = $resource->delete();
	}
	
	public function deleteInstanceWithReferences() {
		$resource = new core_kernel_classes_Resource(LOCAL_NAMESPACE.'#instance1');
		$success = $resource->delete(true);
	}
	
	//*********************************************************************
	//***   SEARCH    *****************************************************
	//*********************************************************************
	
	public function search() {
		$userClass = new core_kernel_classes_Class(CLASS_GENERIS_USER);
		$globalManagerRole = new core_kernel_classes_Resource(INSTANCE_ROLE_GLOBALMANAGER); // http://www.tao.lu/Ontologies/TAO.rdf#GlobalManagerRole
		
		$resources = $userClass->searchInstances(array(
		    PROPERTY_USER_ROLES => $globalManagerRole
		));
		foreach ($resources as $resource) {
		   echo 'user: '.$resource->getLabel()."\n";
		}
	}
	
	public function searchMultiple() {
		$loader = new common_ext_ExtensionLoader(common_ext_ExtensionsManager::singleton()->getExtensionById('taoItems'));
		$loader->load();
		$itemClass = new core_kernel_classes_Class(TAO_ITEM_CLASS);
		
		$resources = $itemClass->searchInstances(array(
		    TAO_ITEM_MODEL_PROPERTY => TAO_ITEM_MODEL_QTI,
		    RDFS_LABEL => 'Periods of History'
		));
		foreach ($resources as $resource) {
		   echo 'item: '.$resource->getLabel()."\n";
		}
	}
	
	public function searchRecursiv() {
		$loader = new common_ext_ExtensionLoader(common_ext_ExtensionsManager::singleton()->getExtensionById('taoItems'));
		$loader->load();
		$itemClass = new core_kernel_classes_Class(TAO_ITEM_CLASS);
		
		$resources = $itemClass->searchInstances(array(
		    TAO_ITEM_MODEL_PROPERTY => TAO_ITEM_MODEL_QTI,
		    RDFS_LABEL => 'Periods of History'
		), array(
		    'recursive' => true
		));
		foreach ($resources as $resource) {
		   echo 'item: '.$resource->getLabel()."\n";
		}
	}
}
?>