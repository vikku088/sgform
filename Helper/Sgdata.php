<?php
/**
 * @category   Syncitgroup
 * @package    Syncitgroup_Sgform
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Syncitgroup\Sgform\Helper;

use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Sgdata extends AbstractHelper
{
    /**
     * Scope config
     *
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    const SGFORM_CONFIG = 'sgform/general/';
    /**
     *
     * @param ScopeConfigInterface $scopeConfig ScopeConfigInterface
     */
    public function __construct(
        Context $context,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context);
    }

    function getConfigStatus($config)
    {
        $scope = ScopeInterface::SCOPE_STORE;

        $status = false;
        if ($config) {
            if ($this->scopeConfig->getValue(self::SGFORM_CONFIG . $config, $scope)) {
                $status = $this->scopeConfig->getValue(self::SGFORM_CONFIG . $config, $scope);
            }
        }
        return $status;
    }
}
