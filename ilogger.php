<?php

class Logger {
    private static $instance;
    private static $fileHandle;

    private function __construct() {
        // 打开日志文件以追加模式写入
        self::$fileHandle = fopen('log.txt', 'a');
        
        // 设置错误处理程序
        set_error_handler([$this, 'handleError']);
        
        // 设置异常处理程序
        set_exception_handler([$this, 'handleException']);
        
        // 注册 tick 函数
        register_tick_function([$this, 'logTick']);
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function logTick() {
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);
        if (isset($backtrace[1])) {
            $caller = $backtrace[1];
            $message = '';

            if (isset($caller['class'])) {
                $message = "[Info] class: {$caller['class']}->{$caller['function']}();";
            } else {
                $message = "[Info] func: {$caller['function']}();";
            }

            self::writeLog($message);
        }
    }

    public function handleError($errno, $errstr, $errfile, $errline) {
        $message = "[Error] 错误行数: $errline 错误原因: $errstr";
        self::writeLog($message);
    }

    public function handleException($exception) {
        $message = "[Error] 错误行数: {$exception->getLine()} 错误原因: {$exception->getMessage()}";
        self::writeLog($message);
    }

    private static function writeLog($message) {
        if (self::$fileHandle) {
            fwrite(self::$fileHandle, date('Y-m-d H:i:s') . " " . $message . "\n");
        }
    }

    public function __destruct() {
        if (self::$fileHandle) {
            fwrite(self::$fileHandle, "-------------End-------------\n");
            fclose(self::$fileHandle);
        }
    }
}

// 启动 Logger
Logger::getInstance();
