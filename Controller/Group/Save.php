<?php
/**
 * @category   Syncitgroup
 * @package    Syncitgroup_Sgform
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Syncitgroup\Sgform\Controller\Group;

use Magento\Framework\App\Action\Context;
use Syncitgroup\Sgform\Model\SgformFactory;
use Magento\Framework\DataObject;

class Save extends \Magento\Framework\App\Action\Action
{
	/**
     * @var Sgform
     */
    protected $_sgform;

    public function __construct(
		Context $context,
        SgformFactory $sgform,
        \Syncitgroup\Sgform\Helper\Sgdata $sgHelper
    ) {
        $this->_sgform = $sgform;
        $this->_sgHelper = $sgHelper;
        parent::__construct($context);
    }
	public function execute()
    {
        $data = $this->getRequest()->getParams();
    	$sgform = $this->_sgform->create();
        $sgform->setData($data);
        if($sgform->save()){
            $this->_sgHelper->sendEmail($data);
            $customData = new DataObject($data);
 
            // define custom event name with array data
            $this->_eventManager->dispatch('sgform_submit_event_observer',
                [
                    'formdetails' => $customData
                ]
            );

            $this->messageManager->addSuccessMessage(__('Thank you for submitting to
            Syncit Group custom form!.'));
        }else{
            $this->messageManager->addErrorMessage(__('Data was not saved.'));
        }
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('sgform/group/form');
        return $resultRedirect;
    }
}
