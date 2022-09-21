<?php

declare(strict_types=1);

use FFI\CData;
use FFI\CType;

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

        protected function __construct(string $typedef, string $tag = 'ze', array $initializer = null)
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
                'type' => $this->__toString()
            ];
        }

        public function __toString(): string
        {
            return \ffi_str_typeof($this->struct_ptr);
        }

        public function alignof(): int
        {
            return \FFI::alignof($this->struct_ptr);
        }

        public function char(): CData
        {
            return \FFI::cast('char *', $this->struct_ptr);
        }

        public function cast(string $typedef): CData
        {
            return \Core::get($this->tag)->cast($typedef, $this->struct_ptr);
        }

        public function void(): CData
        {
            return \FFI::cast('void *', $this->struct_ptr);
        }

        public function isNull(): bool
        {
            try {
                return \FFI::isNull($this->struct_ptr);
            } catch (\Throwable $e) {
                return true;
            }
        }

        public function sizeof(): int
        {
            return \FFI::sizeof($this->struct_ptr[0]);
        }

        public function string(?int $size = null): string
        {
            return \FFI::string($this->struct_ptr, $size);
        }

        public function typeof(): CType
        {
            return \FFI::typeof($this->struct_ptr);
        }

        public function memcmp(CData $from_ptr, int $size): int
        {
            return \FFI::memcmp($this->struct_ptr, $from_ptr, $size);
        }

        public function memcpy(CData $from_ptr, int $size): void
        {
            \FFI::memcpy($this->struct_ptr, $from_ptr, $size);
        }

        public function memset(int $value, int $size): void
        {
            \FFI::memset($this->struct_ptr, $value, $size);
        }

        public function free(): void
        {
            if (\is_cdata($this->struct_ptr) && !$this->isNull())
                \FFI::free($this->struct_ptr);

            $this->struct_ptr = null;
            $this->struct = null;
            $this->tag = '';
        }

        public static function init(string $typedef, $tag = 'ze', $initializer = null)
        {
            return new static(\str_replace('struct ', '', $typedef), $tag, $initializer);
        }
    }
}
