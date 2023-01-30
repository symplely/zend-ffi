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
        protected bool $isOwned = true;
        protected ?CData $struct = null;
        protected ?CData $struct_ptr = null;
        protected ?CData $struct_casted = null;
        protected $storage = [];
        protected static bool $is_free_active = \IS_WINDOWS;

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
            $this->isOwned = $owned;
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
                    $this->struct_ptr[0] = $integer;
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

        public function get_storage($key)
        {
            return $this->storage[$key] ?? null;
        }

        public function set_storage($key, $item)
        {
            $this->storage[$key] = $item;
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
         * Returns C pointer to the current array `index` *C data*.
         *
         * @param int $index
         * @param string|null $field
         * @return CData
         */
        public function addr_of(int $index, string $field = null): CData
        {
            if ($this->isArray) {
                $ptr = $this->get_storage($index);
                if (!\is_cdata($ptr)) {
                    if (!\is_null($field))
                        $ptr = \FFI::addr($this->__invoke()[$index]->{$field});
                    else
                        $ptr = \FFI::addr($this->__invoke()[$index]);

                    $this->set_storage($index, $ptr);
                }

                return $ptr;
            }
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
         * Set/shift the stored **C data** _cast(`  **`)_ pointer to its first element/address,
         * as if _cast(`  *`)_.
         *
         * @return void
         */
        public function reset(): void
        {
            if (\is_cdata($this->struct_casted)) {
                $struct = $this->struct_casted[0];
                $this->struct_casted = $struct;
            }
        }

        /**
         * Store and returns a cast of the current *C data* to another C _pointer_ type,
         * specified by C declaration.
         *
         * @param string $declaration
         * @return CData
         */
        public function cast(string $declaration): CData
        {
            $this->struct_casted = \Core::get($this->tag)->cast($declaration, $this->__invoke());
            return $this->struct_casted;
        }

        /**
         * Returns the previous stored `CStruct::cast()` _pointer_.
         *
         * @return CData
         */
        public function cast_ptr(): CData
        {
            return $this->struct_casted;
        }

        /**
         * Returns stored `CStruct::cast()` or current *C data* __value__, within specified `index`,
         * or `union->field`.
         *
         * @param integer $index
         * @param string|null $union_field
         * @return mixed|null
         */
        public function value(int $index = 0, string $union_field = null)
        {
            $struct = null;
            try {
                $struct = \is_cdata($this->struct_casted) ? $this->struct_casted : $this->__invoke();
                $struct = $struct[$index];
                if (\strpos($union_field, '->') !== false) {
                    $fields = \explode('->', $union_field);
                    if (\count($fields) == 3)
                        $struct = $struct->{$fields[0]}->{$fields[1]}->{$fields[2]};
                    elseif (\count($fields) == 2)
                        $struct = $struct->{$fields[0]}->{$fields[1]};
                } elseif (!\is_null($union_field)) {
                    $struct = $struct->{$union_field};
                }
            } catch (\Throwable $e) {
            }

            return $struct;
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
         * Returns a cast `void` C _pointer_ of the current array `index` *C data*.
         *
         * @param integer $index
         * @param string|null $field
         * @return CData
         */
        public function void_of(int $index, string $field = null): CData
        {
            if ($this->isArray) {
                if (!\is_null($field))
                    $ptr = $this->__invoke()[$index]->{$field};
                else
                    $ptr = $this->__invoke()[$index];

                return \FFI::cast('void*', $ptr);
            }
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
         * @return CType|null
         */
        public function type(string $field = null): ?CType
        {
            $struct = \is_null($field) ? $this->__invoke() : $this->__invoke()->{$field};
            $type = \ffi_str_typeof($struct);
            try {
                return \Core::get($this->tag)->type($type);
            } catch (\Throwable $th) {
                return null;
            }
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
            if (!\is_null($this->struct_ptr)) {
                \ffi_free_if($this->struct_ptr);
                if (\is_cdata($this->struct) && !$this->isOwned)
                    \ffi_free_if($this->struct);

                if ($this->isArray && \count($this->storage) > 0)
                    \ffi_free_if(...$this->storage);

                unset($this->storage);
                $this->struct_ptr = null;
                $this->struct = null;
                $this->struct_casted = null;
                $this->isOwned = true;
                $this->isArray = false;
                $this->isInteger = false;
                $this->tag = '';
            }
        }

        public static function ffi_free_set(bool $status): void
        {
            self::$is_free_active = $status;
        }

        public static function is_ffi_free_active(): bool
        {
            return self::$is_free_active;
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
