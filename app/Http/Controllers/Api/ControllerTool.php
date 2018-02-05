<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Api\AbstractTools;

class ControllerTool extends AbstractTools
{
    public function __construct($projectPath, $repoName, $logsPath)
    {
        parent::__construct($projectPath, $repoName, $logsPath);
    }

    public function toolPhpca()
    {
        $res = shell_exec($this->_vendorBinPath.'phpca --no-progress '.$this->_projectPath.' 2>&1');
        $filename = $this->_logsPath."/testPhpca.txt";
        file_put_contents($filename,$res);

        return $res;
    }

    public function toolPhpCs()
    {
        $res = shell_exec($this->_vendorBinPath.'phpcs '.$this->_projectPath);
        $filename = $this->_logsPath."/testPhpcs.txt";
        file_put_contents($filename,$res);

        return $res;
    }

    public function toolPhpMetrics()
    {
        $res = shell_exec($this->_vendorBinPath.'phpmetrics --report-html='.$this->_projectPath.'/phpmetrics '.$this->_projectPath);
        $filename = $this->_logsPath."/testPhpMetrics.txt";
        file_put_contents($filename,$res);

        return $res;
    }

    public function toolTestability()
    {
        $res = shell_exec($this->_vendorBinPath.'testability '.$this->_projectPath.' -o '. $this->_logsPath);
        $filename = $this->_logsPath."/testAbility.txt";
        file_put_contents($filename,$res);

        return $res;
    }
}
