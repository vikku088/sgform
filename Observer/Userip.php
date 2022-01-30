<?php
/**
 * @category   Syncitgroup
 * @package    Syncitgroup_Sgform
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Syncitgroup\Sgform\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class Userip implements ObserverInterface
{

    public function execute(Observer $observer)
    {
        try {
            
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        return $this;
    }
}