<?php
/**
 * @category   Syncitgroup
 * @package    Syncitgroup_Sgform
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Syncitgroup\Sgform\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Filesystem;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Filesystem\Directory\WriteInterface;

class Userip implements ObserverInterface
{
    /**
     * @var DirectoryList
     */
    private $directoryList;

    /**
     * @var Filesystem
     */
    private $filesystem;

    public function __construct(
        \Syncitgroup\Sgform\Helper\Sgdata $sgHelper,
        DirectoryList $directoryList,
        Filesystem $filesystem
    )
    {
        $this->_sgHelper = $sgHelper;
        $this->directoryList = $directoryList;
        $this->filesystem = $filesystem;
    }

    public function execute(Observer $observer)
    {
        try {
            $userIp = $this->_sgHelper->getCurrentIp();
            $this->createDemoTextFile($userIp);
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        return $this;
    }

    /**
     * create custom folder and write text file
     *
     * @return bool
     */
    public function createDemoTextFile($userIp)
    {
        $varDirectory = $this->filesystem->getDirectoryWrite(
            DirectoryList::VAR_DIR
        );
        $varPath = $this->directoryList->getPath('var');
        $fileName = 'userip.txt'; //textfile name
        $path = $varPath . '/sgform/' . $fileName;

        // Write Content
        $this->write($varDirectory, $path, $userIp);
    }

    /**
     * Write content to text file
     *
     * @param WriteInterface $writeDirectory
     * @param $filePath
     * @return bool
     * @throws FileSystemException
     */
    public function write(WriteInterface $writeDirectory, string $filePath, $userIp)
    {
        $stream = $writeDirectory->openFile($filePath, 'a');
        $stream->lock();
        $fileData = "Last User Ip: ". $userIp."\n";
        $stream->write($fileData);
        $stream->unlock();
        $stream->close();

        return true;
    }
}