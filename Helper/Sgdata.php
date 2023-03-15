<?php
/**
 * @category   Syncitgroup
 * @package    Syncitgroup_Sgform
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Syncitgroup\Sgform\Helper;

use Magento\Framework\App\Helper\Context;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\HTTP\PhpEnvironment\RemoteAddress;

class Sgdata extends AbstractHelper
{
    protected $transportBuilder;
    protected $storeManager;
    protected $inlineTranslation;
    protected $RemoteAddress;
    /**
     * Scope config
     *
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    const SGFORM_CONFIG = 'sgform/general/';

    const EMAIL_TEMPLATE_ID = 'sgform_template';
    /**
     *
     * @param ScopeConfigInterface $scopeConfig ScopeConfigInterface
     */
    public function __construct(
        Context $context,
        TransportBuilder $transportBuilder,
        StoreManagerInterface $storeManager,
        StateInterface $state,
        ScopeConfigInterface $scopeConfig,
        RemoteAddress $RemoteAddress
    ) {
        $this->transportBuilder = $transportBuilder;
        $this->storeManager = $storeManager;
        $this->inlineTranslation = $state;
        $this->scopeConfig = $scopeConfig;
        $this->remoteAddress = $RemoteAddress;
        parent::__construct($context);
    }

    /*
    * Description: Get Config Status
    */
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

    /*
    * Description: To send custom Email
    */
    public function sendEmail($formContent)
    {
        $templateId = self::EMAIL_TEMPLATE_ID; // template id
        $fromEmail = 'owner@domain.com';  // sender Email id
        $fromName = 'Admin';             // sender Name
        $toEmail = $this->getConfigStatus('email'); // receiver email id

        try {
            // template variables
            $templateVars = [
                'title' => $formContent['title'],
                'author' => $formContent['author'],
                'content' => $formContent['content']
            ];

            $storeId = $this->storeManager->getStore()->getId();

            $from = ['email' => $fromEmail, 'name' => $fromName];
            $this->inlineTranslation->suspend();

            $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
            $templateOptions = [
                'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                'store' => $storeId
            ];
            $transport = $this->transportBuilder->setTemplateIdentifier($templateId, $storeScope)
                ->setTemplateOptions($templateOptions)
                ->setTemplateVars($templateVars)
                ->setFrom($from)
                ->addTo($toEmail)
                ->getTransport();
            $transport->sendMessage();
            $this->inlineTranslation->resume();
        } catch (\Exception $e) {
            $this->_logger->info($e->getMessage());
        }
    }

    /*
    * Description: Get current customer Ip
    */
    function getCurrentIp(){

        return $this->remoteAddress->getRemoteAddress();
    }
}
