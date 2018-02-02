<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Api\AbstractTools;

class ControllerTool extends AbstractTools
{
    public function __construct($projectPath, $repoName)
    {
        parent::__construct($projectPath, $repoName);
    }

    public function toolPhpca()
    {
        //lancement du test
        $res = shell_exec($this->_vendorBinPath.'phpca --no-progress '.$this->_projectPath .'/'.$this->_repoName.' 2>&1');
        echo $this->_vendorBinPath.'phpca --no-progress '.$this->_projectPath .'/'.$this->_repoName;
        $filename = $this->_projectPath."/logs/testPhpca.txt";
        file_put_contents($filename,$res);

        return $res;
    }

    public function toolPhpCs()
    {
        //lancement du test
        $res = shell_exec($this->_vendorBinPath.'phpcs '.$this->_repoName);
        $filename = $this->_projectPath."/testPhpcs.txt";
        file_put_contents($filename,$res);

        return $res;
    }

    public function toolPhpMetrics()
    {
        //lancement du test
        $res = shell_exec($this->_vendorBinPath.'phpmetrics --report-html='.$this->_projectPath.'/phpmetrics '.$this->_repoName);
        $filename = $this->_projectPath."/testPhpMetrics.txt";
        file_put_contents($filename,$res);

        return $res;
    }

    public function testability()
    {
        //lancement du test
        $res = shell_exec($this->_vendorBinPath.'testability '.$this->_repoName.' -o testability');
        $filename = $this->_projectPath."/testAbility.txt";
        file_put_contents($filename,$res);

        return $res;
    }
}
