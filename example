<?php

declare(ticks=1);

require 'ilogger.php';

function test($param1, $param2) {
    echo "测试1";
}

test('值1', 123);

class TestClass {
    public function testMethod() {
        echo "Inside testMethod.\n";
    }
}

$test = new TestClass();
$test->testMethod();

// 触发错误
trigger_error("这是自定义错误", E_USER_WARNING);

// 触发异常
try {
    throw new Exception("触发异常力");
} catch (Exception $e) {
    // 异常已被记录，无需额外处理
}

// 引发致命错误
strlen();
