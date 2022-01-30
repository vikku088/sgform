<?php
/**
 * @category   Syncitgroup
 * @package    Syncitgroup_Sgform
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Syncitgroup\Sgform\Model\ResourceModel;

class Sgform extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Define main table
     */
    protected function _construct()
    {
        $this->_init('syncitgroup_sgform', 'sgform_id');   //here "syncitgroup_sgform" is table name and "sgform_id" is the primary key of custom table
    }
}