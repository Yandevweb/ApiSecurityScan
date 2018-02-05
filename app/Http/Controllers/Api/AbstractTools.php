<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

abstract class AbstractTools extends Controller
{
    protected $_projectPath     = null;
    protected $_repoName        = null;
    protected $_logsPath        = null;
    protected $_vendorBinPath   = null; //path des plugins d'analyse

    public function __construct($projectPath, $repoName, $logsPath){
        $this->_projectPath = $projectPath;
        $this->_repoName    = $repoName;
        $this->_logsPath    = $logsPath;
        $this->_vendorBinPath = env('VENDOR_BIN_PATH');
    }
}
