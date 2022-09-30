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
        protected bool $isArray = false;
        protected bool $isInteger = false;
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
            bool $isSelf = false,
            int $size = null,
            bool $isInteger = false,
            int $integer = null,
            bool $owned = true,
            bool $persistent = false
        ) {

            $this->tag = $tag;
            $this->isInteger = $isInteger;
            if (!$isSelf || \is_string($typedef)) {
                if (!\is_null($size))
                    $this->struct = \Core::get($tag)->new($typedef . '[' . $size . ']', $owned, $persistent);
                elseif ($isInteger)
                    $this->struct = \Core::get($tag)->new($typedef, $owned, $persistent);
                elseif (\is_null($size) && (\is_array($initializer) && \count($initializer) === 0) && $integer === 0)
                    $this->struct = \Core::get($tag)->new($typedef, $owned, $persistent);
                else
                    $this->struct = \Core::get($tag)->new('struct ' . $typedef, $owned, $persistent);

                if (\is_null($size))
                    $this->struct_ptr = \FFI::addr($this->struct);
                else
                    $this->isArray = true;

                if (\is_array($initializer) && \is_null($size) && \count($initializer) > 0) {
                    foreach ($initializer as $key => $value)
                        $this->struct_ptr->{$key} = $value;
                } elseif (!\is_null($integer) && $isInteger) {
                    $this->struct_ptr[0]->cdata = $integer;
                }
            } else {
                $this->struct = \Core::get($tag)->new($typedef);
            }
        }

        public function __invoke(): CData
        {
            if ($this->isArray)
                return $this->struct;

            if (\is_null($this->struct_ptr))
                $this->struct_ptr = \FFI::addr($this->struct);

            return $this->struct_ptr;
        }

        public function __debugInfo(): array
        {
            if ($this->isInteger)
                return [
                    'type' => $this->__toString(),
                    'value' => $this->struct_ptr[0]
                ];

            return ['type' => $this->__toString()];
        }

        public function __toString(): string
        {
            return \ffi_str_typeof($this->__invoke());
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
         * @param bool $owned
         * @return static
         */
        public function new(string $field = null, bool $owned = true, bool $persistent = false): self
        {
            return new static($this->type($field), $this->tag, null, true, null, false, null, $owned, $persistent);
        }

        /**
         * Returns alignment size.
         *
         * @return integer
         */
        public function alignof(): int
        {
            return \FFI::alignof($this->__invoke());
        }

        /**
         * Returns a cast of the current *C data* to 'char' C _pointer_ type.
         *
         * @return CData
         */
        public function char(): CData
        {
            return \FFI::cast('char *', $this->__invoke());
        }

        /**
         * Returns a cast of the current *C data* to another C _pointer_ type, specified by C declaration.
         *
         * @param string $declaration
         * @return CData
         */
        public function cast(string $declaration): CData
        {
            return \Core::get($this->tag)->cast($declaration, $this->__invoke());
        }

        /**
         * Returns a cast of the current *C data* to 'void' C _pointer_.
         *
         * @return CData
         */
        public function void(): CData
        {
            return \FFI::cast('void *', $this->__invoke());
        }

        /**
         * Checks whether the current *C data* is a null _pointer_.
         *
         * @return boolean
         */
        public function isNull(): bool
        {
            try {
                return \FFI::isNull($this->__invoke());
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
            return \FFI::sizeof($this->__invoke()[0]);
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
                return \FFI::string($this->__invoke(), $size);

            return '';
        }

        /**
         * Returns the FFI\CType object.
         *
         * @return CType
         */
        public function typeof(): CType
        {
            return \FFI::typeof($this->__invoke());
        }

        /**
         * Creates and returns a FFI\CType object of current *C data* `$field`.
         *
         * @return CType
         */
        public function type(string $field = null): CType
        {
            $struct = \is_null($field) ? $this->__invoke() : $this->__invoke()->{$field};
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
            return \FFI::memcmp($this->__invoke(), $from_ptr, $size);
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
            \FFI::memcpy($this->__invoke(), $from_ptr, $size);
        }

        /**
         * Fills the `$size` bytes of the memory area with the constant byte `$value`.
         *
         * @param integer $value
         * @param integer $size
         * @return void
         */
        public function memset(int $value, int $size): void
        {
            \FFI::memset($this->__invoke(), $value, $size);
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
            $this->isArray = false;
            $this->isInteger = false;
            $this->struct = null;
            $this->tag = '';
        }

        public static function struct_init(string $typedef, string $ffi_tag = 'ze', array $initializer = null, bool $owned = true, bool $persistent = false)
        {
            return new static(\str_replace('struct ', '', $typedef), $ffi_tag, $initializer, false, null, false, null, $owned, $persistent);
        }

        public static function array_init(string $typedef, string $ffi_tag = 'ze', int $size = 1, bool $owned = true, bool $persistent = false)
        {
            return new static(\str_replace(['[', ']'], '', $typedef), $ffi_tag, null, false, $size, false, null, $owned, $persistent);
        }

        public static function integer_init(string $numberType, string $tag = 'ze', $value = null, bool $owned = true, bool $persistent = false)
        {
            return new static($numberType, $tag, null, false, null, true, $value, $owned, $persistent);
        }

        public static function type_init(string $type, string $tag = 'ze', bool $owned = true, bool $persistent = false)
        {
            return new static($type, $tag, [], false, null, false, 0, $owned, $persistent);
        }
    }
}
