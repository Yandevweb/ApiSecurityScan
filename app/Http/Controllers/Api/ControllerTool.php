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
        $testReturn =[];
        $res = shell_exec($this->_vendorBinPath.'phpca --no-progress '.$this->_projectPath.' 2>&1');
        $filename = $this->_logsPath."/testPhpca.txt";
        file_put_contents($filename,$res);

        $testReturn['name']         = "php_code_analyzer";
        $testReturn['description']  = "Finds usage of non-built-in extensions.";
        $testReturn['log']          = $res;

        return $testReturn;
    }

    public function toolPhpCs()
    {
        $testReturn =[];
        $res = shell_exec($this->_vendorBinPath.'phpcs '.$this->_projectPath);
        $filename = $this->_logsPath."/testPhpcs.txt";
        file_put_contents($filename,$res);

        $testReturn['name']         = "php_sode_sniffer";
        $testReturn['description']  = "PHPCS checks the code for a large range of coding standard.";
        $testReturn['log']          = $res;

        return $testReturn;
    }

    public function toolPhpMetrics()
    {
        $testReturn =[];
        $res = shell_exec($this->_vendorBinPath.'phpmetrics --report-html='.$this->_projectPath.'/phpmetrics '.$this->_projectPath);
        $filename = $this->_logsPath."/testPhpMetrics.txt";
        file_put_contents($filename,$res);

        $testReturn['name']         = "php_metrics";
        $testReturn['description']  = "Calculates all sorts of metrics, and display them in a gorgeous interface.";
        $testReturn['log']          = $res;

        return $testReturn;
    }

    public function toolTestability()
    {
        $testReturn =[];
        $res = shell_exec($this->_vendorBinPath.'testability '.$this->_projectPath.' -o '. $this->_logsPath);
        $filename = $this->_logsPath."/testAbility.txt";
        file_put_contents($filename,$res);

        $testReturn['name']         = "test_ability";
        $testReturn['description']  = "Analyses and produces a report with testability issues of a php codebase.";
        $testReturn['log']          = $res;

        return $testReturn;
    }
}
