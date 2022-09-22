<?php

declare(strict_types=1);

use FFI\CData;
use FFI\CType;

if (!\class_exists('CStruct')) {

    /**
     * A generic **C structure** _C data_ class, methods are the same as general
     * `FFI` methods with additional features.
     */
    class CStruct
    {
        protected string $tag;
        protected ?CData $struct = null;
        protected ?CData $struct_ptr = null;

        public function __destruct()
        {
            $this->free();
        }

        protected function __construct(
            $typedef,
            string $tag = 'ze',
            array $initializer = null,
            bool $isSelf = false
        ) {
            $this->tag = $tag;
            if (!$isSelf || \is_string($typedef)) {
                $this->struct = \Core::get($tag)->new('struct ' . $typedef);
                $this->struct_ptr = \FFI::addr($this->struct);
                if (\is_array($initializer)) {
                    foreach ($initializer as $key => $value)
                        $this->struct_ptr->{$key} = $value;
                }
            } else {
                $this->struct = \Core::get($tag)->new($typedef);
            }
        }

        public function __invoke(): CData
        {
            if (\is_null($this->struct_ptr))
                $this->struct_ptr = \FFI::addr($this->struct);

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
            $struct = $this->__invoke();
            return \ffi_str_typeof($struct);
        }

        /**
         * Returns C pointer to the current *C data* structure `field`.
         *
         * @param string|null $field
         * @return CData
         */
        public function addr(string $field = null): CData
        {
            $struct = $this->__invoke();

            if (!\is_null($field))
                return \FFI::addr($struct->{$field});

            return $struct;
        }

        /**
         * Creates an `CStruct` from current _C data_ `field`.
         *
         * @param string|null $field
         * @return static
         */
        public function new(string $field = null): self
        {
            return new static($this->type($field), $this->tag, null, true);
        }

        /**
         * Returns alignment size.
         *
         * @return integer
         */
        public function alignof(): int
        {
            return \FFI::alignof($this->struct_ptr);
        }

        /**
         * Returns a cast of the current *C data* to 'char' C _pointer_ type.
         *
         * @return CData
         */
        public function char(): CData
        {
            return \FFI::cast('char *', $this->struct_ptr);
        }

        /**
         * Returns a cast of the current *C data* to another C _pointer_ type, specified by C declaration.
         *
         * @param string $declaration
         * @return CData
         */
        public function cast(string $declaration): CData
        {
            return \Core::get($this->tag)->cast($declaration, $this->struct_ptr);
        }

        /**
         * Returns a cast of the current *C data* to 'void' C _pointer_.
         *
         * @return CData
         */
        public function void(): CData
        {
            return \FFI::cast('void *', $this->struct_ptr);
        }

        /**
         * Checks whether the current *C data* is a null _pointer_.
         *
         * @return boolean
         */
        public function isNull(): bool
        {
            try {
                return \FFI::isNull($this->struct_ptr);
            } catch (\Throwable $e) {
                return true;
            }
        }

        /**
         * Returns memory size.
         *
         * @return integer
         */
        public function sizeof(): int
        {
            return \FFI::sizeof($this->struct_ptr[0]);
        }

        /**
         * Return/creates a PHP string, only if *C data* is `char *`.
         *
         * @param integer|null $size
         * @return string
         */
        public function string(?int $size = null): string
        {
            if ($this->__toString() === 'char*')
                return \FFI::string($this->struct_ptr, $size);

            return '';
        }

        /**
         * Returns the FFI\CType object.
         *
         * @return CType
         */
        public function typeof(): CType
        {
            return \FFI::typeof($this->struct_ptr);
        }

        /**
         * Creates and returns a FFI\CType object of current *C data* `$field`.
         *
         * @return CType
         */
        public function type(string $field = null): CType
        {
            $struct = \is_null($field) ? $this->struct_ptr : $this->struct_ptr->{$field};
            $type = \ffi_str_typeof($struct);

            return \Core::get($this->tag)->type($type);
        }

        /**
         * Compares `$size` bytes from `$from_ptr` memory area.
         *
         * @param CData $from_ptr
         * @param integer $size
         * @return integer
         */
        public function memcmp(CData $from_ptr, int $size): int
        {
            return \FFI::memcmp($this->struct_ptr, $from_ptr, $size);
        }

        /**
         * Copies `$size` bytes from `$from_ptr` memory area.
         *
         * @param CData $from_ptr
         * @param integer $size
         * @return void
         */
        public function memcpy(CData $from_ptr, int $size): void
        {
            \FFI::memcpy($this->struct_ptr, $from_ptr, $size);
        }

        /**
         * Fills the `$size` bytes of the memory area with the constant byte `$byte`.
         *
         * @param integer $value
         * @param integer $size
         * @return void
         */
        public function memset(int $value, int $size): void
        {
            \FFI::memset($this->struct_ptr, $value, $size);
        }

        /**
         * Manually removes current "not-owned" data structure, and `null` fields.
         *
         * @return void
         */
        public function free(): void
        {
            if (\is_cdata($this->struct_ptr) && !$this->isNull())
                \FFI::free($this->struct_ptr);

            $this->struct_ptr = null;
            $this->struct = null;
            $this->tag = '';
        }

        public static function init(string $typedef, string $ffi_tag = 'ze', array $initializer = null)
        {
            return new static(\str_replace('struct ', '', $typedef), $ffi_tag, $initializer);
        }
    }
}
