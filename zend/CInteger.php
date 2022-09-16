<?php

declare(strict_types=1);

use FFI\CData;

if (!\class_exists('CInteger')) {
    class CInteger
    {
        protected string $tag;
        protected ?CData $cInt;
        protected ?CData $cInt_ptr;

        public function __destruct()
        {
            $this->free();
        }

        protected function __construct(string $numberType, $initializer = null, string $tag = 'ze')
        {
            $this->tag = $tag;
            $this->cInt = \Core::get($tag)->new($numberType);
            $this->cInt_ptr = \ffi_ptr($this->cInt);
            $this->cInt_ptr[0]->cdata = $initializer;
        }

        public function __invoke(): CData
        {
            return $this->cInt_ptr;
        }

        public function __debugInfo(): array
        {
            return [
                'type' => \ffi_str_typeof($this->cInt_ptr),
                'value' => $this->cInt_ptr[0]
            ];
        }

        public function void(): CData
        {
            return \FFI::cast('void *', $this->cInt_ptr);
        }

        public function cast(string $typedef): CData
        {
            return \Core::get($this->tag)->cast($typedef, $this->cInt_ptr);
        }

        public function free(): void
        {
            if (\is_cdata($this->cInt_ptr) && !\is_null_ptr($this->cInt_ptr))
                \FFI::free($this->cInt_ptr);

            $this->cInt_ptr = null;
            $this->cInt = null;
            $this->tag = '';
        }

        public static function init(string $numberType, $initializer = null, $tag = 'ze')
        {
            return new static($numberType, $initializer, $tag);
        }
    }
}
