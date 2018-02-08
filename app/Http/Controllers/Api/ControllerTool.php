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

        $testReturn['name']         = "PHP Code Analyzer";
        $testReturn['description']  = "Finds usage of non-built-in extensions.";
        $testReturn['logLink']      = "false";
        $testReturn['log']          = str_replace("/var/www/tmp/freeUser", "", $res);
        $testReturn['logFile']      = "/logs/testPhpca.txt";

        return $testReturn;
    }

    public function toolPhpCs()
    {
        $testReturn =[];
        $res = shell_exec($this->_vendorBinPath.'phpcs '.$this->_projectPath);
        $filename = $this->_logsPath."/testPhpcs.txt";
        file_put_contents($filename,$res);

        $testReturn['name']         = "PHP Code Sniffer";
        $testReturn['description']  = "PHPCS checks the code for a large range of coding standard.";
        $testReturn['logLink']      = "false";
        $testReturn['log']          = str_replace("/var/www/tmp/freeUser", "", $res);
        $testReturn['logFile']      = "/logs/testPhpcs.txt";

        return $testReturn;
    }

    public function toolPhpMetrics()
    {
        $testReturn =[];
        $res = shell_exec($this->_vendorBinPath.'phpmetrics --report-html='.$this->_projectPath.'/phpmetrics '.$this->_projectPath);
        $filename = $this->_logsPath."/testPhpMetrics.txt";
        file_put_contents($filename,$res);

        $testReturn['name']         = "PHP Metrics";
        $testReturn['description']  = "Calculates all sorts of metrics, and display them in a gorgeous interface.";
        $testReturn['logLink']      = "true";
        $testReturn['log']          = str_replace("/var/www/tmp/freeUser", "", $res);
        $testReturn['logFile']      = "/logs/testPhpMetrics.txt";

        return $testReturn;
    }

    public function toolTestability()
    {
        $testReturn =[];
        $res = shell_exec($this->_vendorBinPath.'testability '.$this->_projectPath.' -o '. $this->_logsPath);
        $filename = $this->_logsPath."/testAbility.txt";
        file_put_contents($filename,$res);

        $testReturn['name']         = "Test Ability";
        $testReturn['description']  = "Analyses and produces a report with testability issues of a php codebase.";
        $testReturn['logLink']      = "false";
        $testReturn['log']          = str_replace("/var/www/tmp/freeUser", "", $res);
        $testReturn['logFile']      = "/logs/testAbility.txt";

        return $testReturn;
    }
}
