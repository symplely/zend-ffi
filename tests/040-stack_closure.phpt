--TEST--
Check for Stack Closure
--SKIPIF--
<?php if (!extension_loaded("ffi")) print "skip"; ?>
--FILE--
require 'vendor/autoload.php';

class Entry
{
    protected Closure $closure;

    public function __construct()
    {
        $this->closure = function () {
            $self = isset($this) ? $this : null;

            return [
                'class' => $self ? get_class($self) : null,
                'scope' => get_called_class()
            ];
        };
    }

    public function run()
    {
        $scope = zend_closure($this->closure)->called_scope();
        var_dump(self::class === $scope);

        $result = ($this->closure)();
        var_dump(get_class($this) === $result['scope']);

        $closureEntry = zend_closure($this->closure);
        $closureEntry->change(\Exception::class);

        $scope = $closureEntry->called_scope();
        var_dump(\Exception::class === $scope);

        // This test does not update internal scope variable, or it is cached
        $result = ($this->closure)();

        $closureEntry = zend_closure($this->closure);
        $closureEntry->changeThis(new \Error());

        $result = ($this->closure)();

        var_dump(\Error::class === $result['scope']);
        var_dump(\Error::class === $result['class']);
    }
}

$t = new Entry();
$t->run();
--EXPECT--
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
