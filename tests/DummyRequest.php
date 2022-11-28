<?php

return zend_fcall_info_call(function (int $test, string $test2) {
    return 'ok ' . $test . ' - ' . $test2;
}, 1, 'hello');
