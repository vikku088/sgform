<?php
/**
 * @category   Syncitgroup
 * @package    Syncitgroup_Sgform
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Syncitgroup\Sgform\Controller\Adminhtml\Items;

class NewAction extends \Syncitgroup\Sgform\Controller\Adminhtml\Items
{

    public function execute()
    {
        $this->_forward('edit');
    }
}
