<?php
/**
 * @category   Syncitgroup
 * @package    Syncitgroup_Sgform
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Syncitgroup\Sgform\Model\ResourceModel\Sgform;
 
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'sgform_id';
    /**
     * Define model & resource model
     */
    protected function _construct()
    {
        $this->_init(
            'Syncitgroup\Sgform\Model\Sgform',
            'Syncitgroup\Sgform\Model\ResourceModel\Sgform'
        );
    }
}