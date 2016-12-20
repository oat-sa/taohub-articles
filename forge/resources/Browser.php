<?php
/**
 * Docs Controller provide actions to manage docs
 *
 * @author Bertrand Chevrier, <taosupport@tudor.lu>
 * @package taoDocs
 * @subpackage actions
 * @license GPLv2  http://www.opensource.org/licenses/gpl-2.0.php
 *
 */
namespace oat\taoDocs\controller;

use oat\taoDocs\helpers\FileUtils;
use oat\taoDocs\model\DocsService;

class Browser extends \tao_actions_CommonModule
{
    /**
     * constructor: initialize the service and the default data
     * @return Docs
     */
    public function __construct()
    {
        parent::__construct();

        //the service is initialized by default
        $this->service = DocsService::singleton();
        $this->defaultData();
    }

    /**
     * @example method used to populate the tree widget
     * render json data of the documents in the DOCS_PATH
     * @return void
     */
    public function getTreeData()
    {
        $data = array(
            'data' => __("My Documents"),
            'attributes' => array(
                'id' => 1,
                'class' => 'node-class'
            ),
            'children' => array()
        );
        $index = 2;
        foreach (FileUtils::parseFolder(DOCS_PATH, true) as $path => $file) {
            $data['children'][] = array(
                'data' => $file,
                'attributes' => array(
                    'id' => substr($path, strlen(DOCS_PATH)),
                    'class' => 'node-instance'
                )
            );
            $index++;
        }

        echo json_encode($data);
    }

    public function delete()
    {
        $filepath = DOCS_PATH . $this->getRequestParameter('uri');
        $deleted = FileUtils::deleteFile($filepath);
        if ($deleted) {
            //remove the current selection from the session
            $this->removeSessionAttribute('uri');

            echo json_encode(['deleted' => 1]);
        }
    }
}
