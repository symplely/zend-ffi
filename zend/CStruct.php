<?php

declare(strict_types=1);

use FFI\CData;

if (!\class_exists('CStruct')) {
    class CStruct
    {
        protected string $tag;
        protected ?CData $struct;
        protected ?CData $struct_ptr;

        public function __destruct()
        {
            $this->free();
        }

        protected function __construct(string $typedef, array $initializer = null, string $tag = 'ze')
        {
            $this->tag = $tag;
            $this->struct = \Core::get($tag)->new('struct ' . $typedef);
            $this->struct_ptr = \ffi_ptr($this->struct);
            if (\is_array($initializer)) {
                foreach ($initializer as $key => $value)
                    $this->struct_ptr->{$key} = $value;
            }
        }

        public function __invoke(): CData
        {
            return $this->struct_ptr;
        }

        public function __debugInfo(): array
        {
            return [
                'type' => \ffi_str_typeof($this->struct_ptr)
            ];
        }

        public function char(): CData
        {
            return \FFI::cast('char *', $this->struct_ptr);
        }

        public function void(): CData
        {
            return \FFI::cast('void *', $this->struct_ptr);
        }

        public function cast(string $typedef): CData
        {
            return \Core::get($this->tag)->cast($typedef, $this->struct_ptr);
        }

        public function sizeof(): int
        {
            return \FFI::sizeof($this->struct_ptr);
        }

        public function free(): void
        {
            if (\is_cdata($this->struct_ptr) && !\is_null_ptr($this->struct_ptr))
                \FFI::free($this->struct_ptr);

            $this->struct_ptr = null;
            $this->struct = null;
            $this->tag = '';
        }

        public static function init(string $typedef, $initializer = null, $tag = 'ze')
        {
            return new static(\str_replace('struct ', '', $typedef), $initializer, $tag);
        }
    }
}
