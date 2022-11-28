<?php

declare(strict_types=1);

use FFI\CData;
use ZE\Zval;
use ZE\Resource;
use ZE\PhpStream;
use ZE\ZendResource;
use ZE\ZendExecutor;
use ZE\ZendObject;
use ZE\ZendClosure;
use ZE\ZendOp;
use ZE\ZendReference;
use ZE\ZendString;
use ZE\ZendMethod;
use ZE\ZendObjectsStore;

if (!\function_exists('zval_stack')) {
    /**
     * Returns `Zval` of an argument by it's index.
     * - Represents `ZEND_CALL_ARG()` _macro_, the argument index is starting from 0.
     *
     * @param integer $argument
     * @return Zval
     */
    function zval_stack(int $argument): Zval
    {
        return ZendExecutor::init()->previous_state()->call_argument($argument);
    }

    /**
     * Zval `value` constructor, a copy of `argument`.
     *
     * @param mixed $argument
     * @return Zval
     */
    function zval_constructor($argument): Zval
    {
        return Zval::constructor($argument);
    }

    function zval_return()
    {
        return ZendExecutor::init()->previous_state()->return_value();
    }

    /**
     * Represents `php_stream_to_zval()` _macro_.
     *
     * Use this to assign the stream to a zval and tell the stream that is
     * has been exported to the engine; it will expect to be closed automatically
     * when the resources are auto-destructed.
     *
     * @param php_stream $ptr
     * @return Zval
     */
    function zval_stream(CData $ptr): Zval
    {
        return PhpStream::init_stream($ptr);
    }

    /**
     * Creates a new zval from it's type and value.
     *
     * @param int $type Value type
     * @param CData $value Value, should be zval-compatible
     * @param bool $isPersistent
     *
     * @return Zval
     */
    function zval_new(int $type, CData $value, bool $isPersistent = false): Zval
    {
        return Zval::new($type, $value, $isPersistent);
    }

    /**
     * Returns _native_ value for `userland`.
     *
     * @param Zval $zval
     */
    function zval_native(Zval $zval)
    {
        $zval->native_value($argument);
        return $argument;
    }

    /**
     * Creates a `Zval` instance base on various accessor macros.
     *
     * @param string|int $accessor One of:
     * -          Macro                 Return/Set type
     * - `ZE::TRUE`   for `ZVAL_TRUE()`
     * - `ZE::FALSE`   for `ZVAL_FALSE()`
     * - `ZE::NULL`   for `ZVAL_NULL()`
     * - `ZE::UNDEF`   for `ZVAL_UNDEF()`
     * - `ZE::BOOL`   for `ZVAL_BOOL()`   `unsigned char`
     * -
     * - `ZE::TYPE_P`   for `Z_TYPE_P()`  `unsigned char`
     * - `ZE::TYPE_INFO_P`  for `Z_TYPE_INFO_P()` `unsigned char`
     * - `ZE::REFCOUNTED`   for `Z_REFCOUNTED()` `boolean`
     * - `ZE::TYPE_INFO_REFCOUNTED`  for `Z_TYPE_INFO_REFCOUNTED()` `boolean`
     * - `ZE::LVAL_P`   for `Z_LVAL_P()`  `zend_long`
     * - `ZE::DVAL_P`   for `Z_DVAL_P()`  `double`
     * - `ZE::STR_P`    for `Z_STR_P()`   `zend_string *`
     * - `ZE::STRVAL_P` for `Z_STRVAL_P()`  `char *`
     * - `ZE::STRLEN_P` for `Z_STRLEN_P()`  `size_t`
     * - `ZE::ARR_P`    for `Z_ARR_P()`   `HashTable *`
     * - `ZE::ARRVAL_P` for `Z_ARRVAL_P()`    `HashTable *`
     * - `ZE::OBJ_P`    for `Z_OBJ_P()`   `zend_object *`
     * - `ZE::OBJCE_P`  for `Z_OBJCE_P()` `zend_class_entry *`
     * - `ZE::RES_P`    for `Z_RES_P()`   `zend_resource *`
     * - `ZE::REF_P`    for `Z_REF_P()`   `zend_reference *`
     * - `ZE::REFVAL_P` for `Z_REFVAL_P()`  `zval *`
     * - `ZE::COUNTED_P`  for `Z_COUNTED_P()` `*`
     *
     * @param CData|int|bool|null $value a zend `C` struct/value to set to
     * @return Zval
     */
    function zval_macro($accessor, $value = null): Zval
    {
        return Zval::init()->macro($accessor, $value);
    }

    /**
     * @param object $ptr _struct_ with `->data` field **or** by `$name`
     * @param object $instance to be _cast_ to `void*`
     * @param string $name data field name other than `->data` the default
     * @return object $ptr
     */
    function zval_set_data(object $ptr, object $instance, string $name = 'data'): object
    {
        if (\is_cdata($ptr)) {
            $zval = Zval::constructor($instance);
            $ptr->{$name} = \ffi_void($zval()->value->obj);
            $zval->gc_addRef();
        }

        return $ptr;
    }

    /**
     * @param object $ptr _struct_ with `->data` field **or**
     * @param string $name data field name other than `->data` the default
     * @return object|null
     */
    function zval_get_data(object $ptr, string $name = 'data'): ?object
    {
        $zval = null;
        if (\is_cdata($ptr) && !\is_null($ptr->{$name})) {
            $zval = \zval_native(\zval_macro(
                ZE::OBJ_P,
                \ze_cast('zend_object*', $ptr->{$name})
            ));
        }

        return $zval;
    }

    /**
     * Represents `zend_gc_addref` macro.
     *
     * @param object|mixed $instance
     * @return object
     */
    function zval_add_ref(object $instance): object
    {
        $zval = \zval_stack(0);
        $zval->gc_addRef();
        return $instance;
    }

    /**
     * Represents `zend_gc_delref` macro.
     *
     * @param object|mixed $instance
     * @return object
     */
    function zval_del_ref(object $instance): object
    {
        $zval = \zval_stack(0);
        $zval->gc_delRef();
        return $instance;
    }

    /**
     * Check for `IS_OBJ_DESTRUCTOR_CALLED`, with `GC_ADD_FLAGS` macro.
     *
     * @param object|mixed $instance
     * @return int
     */
    function zval_skip_dtor(object $instance): int
    {
        return \zval_stack(0)->gc_add_flags(\ZE::IS_OBJ_DESTRUCTOR_CALLED);
    }

    /**
     * Check for `IS_OBJ_DESTRUCTOR_CALLED`, with `GC_FLAGS(GC_TYPE_INFO)` macro.
     *
     * @param object|mixed $instance
     * @return bool
     */
    function zval_is_dtor(object $instance): bool
    {
        return (bool) (\zval_stack(0)->gc_flags() & \ZE::IS_OBJ_DESTRUCTOR_CALLED);
    }

    /**
     * Returns an _instance_ that's a cross platform representation of a file handle.
     *
     * @param string $type - a handle `uv_file`, `uv_os_fd_t`, `php_socket_t` or _any_ platform type.
     * @return Resource
     */
    function fd_type(string $type = 'uv_file'): Resource
    {
        return Resource::init($type);
    }

    /**
     * Temporary enable `cli` if needed to preform a `php://fd/` **fopen()** call.
     *
     * @param integer $resource fd number
     * @return resource|false
     */
    function php_fd_direct(int $resource)
    {
        return \cli_direct(function (int $type) {
            return \fopen('php://fd/' . $type, '');
        }, $resource);
    }

    /**
     * Temporary enable `cli` if needed to preform a `php://fd/` **_php_stream_open_wrapper_ex()** call.
     * - Same as `php_fd_direct()` but returns a **Zval** _instance_ of `resource`.
     *
     * @param integer $resource fd number
     * @return Zval
     */
    function zval_fd_direct(int $resource): Zval
    {
        return \cli_direct(function (int $type) {
            $fd = Core::get_stdio($type);
            if ($fd === null)
                $fd = PhpStream::open_wrapper('php://fd/' . $type, '', 0)();

            return \zval_stream($fd);
        }, $resource);
    }

    /**
     * Returns an _instance_ representing `_php_stream` _C structure_.
     *
     * @return PhpStream
     */
    function stream_type(): PhpStream
    {
        return PhpStream::init();
    }

    /**
     * @param zend_resource|CData $res ZendResource
     * @return Zval
     */
    function zval_resource(CData $res): Zval
    {
        return Zval::init()->macro(\ZE::RES_P, $res);
    }

    /**
     * @param _zend_array|CData $ht HashTable
     * @return Zval
     */
    function zval_array(CData $ht): Zval
    {
        return Zval::init()->macro(\ZE::ARR_P, $ht);
    }

    /**
     * @param zval|CData $zval_value
     * @param zval|CData $zval_value2
     * @return _zend_array HashTable
     */
    function zend_new_pair(CData $zval_value, CData $zval_value2)
    {
        return \ze_ffi()->zend_new_pair($zval_value, $zval_value2);
    }

    /**
     * @param object|CData $ptr Will be **cast** to a `void` pointer
     * @param integer $type
     * @return zend_resource CData
     */
    function zend_register_resource($ptr, int $type): CData
    {
        return \ze_ffi()->zend_register_resource(\ze_ffi()->cast('void*', $ptr), $type);
    }

    /**
     * @param object|zend_resource|CData $ptr
     * @param string $type_name
     * @param integer|null $type_number if `null` uses `$ptr->type`
     * @param string $type_cast **void*** pointer to **typedef**, pass `null` for original **void***
     * @return CData **typedef**, or **void** pointer, if `null` in **$type_cast**
     */
    function zend_fetch_resource(object $ptr, string $type_name = '', int $type_number = null, ?string $type_cast = 'php_stream*'): CData
    {
        $void = \ze_ffi()->zend_fetch_resource($ptr, $type_name, \is_null($type_number)
            ? $ptr->type : $type_number);

        if (\is_null($type_cast))
            return $void;

        return \ze_ffi()->cast($type_cast, $void);
    }

    function zend_register_list_destructors_ex(callable $ld, ?callable $pld, string $type_name, int $module_number)
    {
        return \ze_ffi()->zend_register_list_destructors_ex($ld, $pld, $type_name, $module_number);
    }

    function zend_resource($argument): ZendResource
    {
        return ZendResource::init($argument);
    }

    function create_resource(CData $fd_ptr, string $type = 'stream', int $module = 20220101, callable $rsrc = null)
    {
        $fd_res = \zend_register_resource(
            $fd_ptr,
            \zend_register_list_destructors_ex((\is_null($rsrc)
                    ? function (CData $rsrc) {
                    } : $rsrc),
                null,
                $type,
                $module
            )
        );

        $fd_zval = \zval_resource($fd_res);

        return \zval_native($fd_zval);
    }

    function zend_reference(&$argument): ZendReference
    {
        return ZendReference::init($argument);
    }

    function zend_object(object $argument): ZendObject
    {
        return ZendObject::init($argument);
    }

    function zend_object_ex(CData $argument): ZendObject
    {
        return ZendObject::init_value($argument);
    }

    function zend_closure(\Closure $argument): ZendClosure
    {
        return ZendClosure::init($argument);
    }

    function zend_string(CData $argument): ZendString
    {
        return ZendString::init_value($argument);
    }

    function zend_strings(string $argument): ZendString
    {
        return ZendString::init($argument);
    }

    function zend_executor(): ZendExecutor
    {
        return ZendExecutor::init()->previous_state();
    }

    function zend_object_store(): ZendObjectsStore
    {
        return ZendExecutor::objects_store();
    }

    function zend_op(): ZendOp
    {
        return ZendExecutor::init()->previous_state()->opline();
    }

    /**
     * @return ZendMethod|\ReflectionMethod
     */
    function zend_method(string $class, string $method): ZendMethod
    {
        return ZendMethod::init($class, $method);
    }

    function zend_value(CData $ptr): Zval
    {
        return Zval::init_value($ptr);
    }

    function zval_blank(): Zval
    {
        return Zval::init();
    }

    /**
     * @param resource $stream
     * @return array<Zval|uv_file|int>
     */
    function zval_to_fd_pair($stream): array
    {
        $zval = Resource::get_fd((int)$stream, true);
        $fd = $zval instanceof Zval ? Resource::get_fd((int)$stream, false, false, true) : null;
        if (!\is_integer($fd)) {
            $zval = Zval::constructor($stream);
            $fd = PhpStream::zval_to_fd($zval, true);
        }

        return [$zval, $fd];
    }

    /**
     * @param resource $fd
     * @return int|uv_file `fd`
     */
    function get_fd_resource($fd): int
    {
        if (!\is_resource($fd))
            return \ze_ffi()->zend_error(\E_WARNING, "only resource types allowed");

        $fd_int = Resource::get_fd((int)$fd, false, true);
        $fd_int = \is_cdata($fd_int) ? $fd_int[0] : $fd_int;

        return \is_null($fd_int) ? PhpStream::zval_to_fd(\zval_stack(0)) : $fd_int;
    }

    /**
     * Represents `ext-uv` _macro_ `PHP_UV_FD_TO_ZVAL()`.
     *
     * @param int $fd
     * @param string $mode
     * @param bool $getZval
     * @return resource|Zval
     */
    function get_resource_fd($fd, string $mode = 'wb+', bool $getZval = false)
    {
        return PhpStream::fd_to_zval($fd, $mode, $getZval);
    }

    /**
     * @param Zval $handle
     * @return php_socket_t|int
     */
    function get_socket_fd(Zval $handle, string $fd_type = 'php_socket_t')
    {
        return PhpStream::zval_to_fd_select($handle, $fd_type);
    }

    /**
     * Represents `PG()` macro.
     *
     *```cpp
     *struct _php_core_globals
     *{
     *	zend_bool implicit_flush;
     *	zend_long output_buffering;
     *	zend_bool enable_dl;
     *	char *output_handler;
     *	char *unserialize_callback_func;
     *	zend_long serialize_precision;
     *	zend_long memory_limit;
     *	zend_long max_input_time;
     *	zend_bool track_errors;
     *	zend_bool display_errors;
     *	zend_bool display_startup_errors;
     *	zend_bool log_errors;
     *	zend_long log_errors_max_len;
     *	zend_bool ignore_repeated_errors;
     *	zend_bool ignore_repeated_source;
     *	zend_bool report_memleaks;
     *	char *error_log;
     *	char *doc_root;
     *	char *user_dir;
     *	char *include_path;
     *	char *open_basedir;
     *	char *extension_dir;
     *	char *php_binary;
     *	char *sys_temp_dir;
     *	char *upload_tmp_dir;
     *	zend_long upload_max_filesize;
     *	char *error_append_string;
     *	char *error_prepend_string;
     *	char *auto_prepend_file;
     *	char *auto_append_file;
     *	char *input_encoding;
     *	char *internal_encoding;
     *	char *output_encoding;
     *	arg_separators arg_separator;
     *	char *variables_order;
     *	HashTable rfc1867_protected_variables;
     *	short connection_status;
     *	zend_bool ignore_user_abort;
     *	unsigned char header_is_being_sent;
     *	zend_llist tick_functions;
     *	zval http_globals[6];
     *	zend_bool expose_php;
     *	zend_bool register_argc_argv;
     *	zend_bool auto_globals_jit;
     *	char *docref_root;
     *	char *docref_ext;
     *	zend_bool html_errors;
     *	zend_bool xmlrpc_errors;
     *	zend_long xmlrpc_error_number;
     *	zend_bool activated_auto_globals[8];
     *	zend_bool modules_activated;
     *	zend_bool file_uploads;
     *	zend_bool during_request_startup;
     *	zend_bool allow_url_fopen;
     *	zend_bool enable_post_data_reading;
     *	zend_bool report_zend_debug;
     *	int last_error_type;
     *	char *last_error_message;
     *	char *last_error_file;
     *	int last_error_lineno;
     *	char *php_sys_temp_dir;
     *	char *disable_functions;
     *	char *disable_classes;
     *	zend_bool allow_url_include;
     *	zend_bool com_initialized;
     *	zend_long max_input_nesting_level;
     *	zend_long max_input_vars;
     *	zend_bool in_user_include;
     *	char *user_ini_filename;
     *	zend_long user_ini_cache_ttl;
     *	char *request_order;
     *	zend_bool mail_x_header;
     *	char *mail_log;
     *	zend_bool in_error_log;
     *	zend_bool windows_show_crt_warning;
     *	zend_long syslog_facility;
     *	char *syslog_ident;
     *	zend_bool have_called_openlog;
     *	zend_long syslog_filter;
     *};
     *```
     * @param string $element field
     * @param mixed $initialize set element value
     * @return CData|mixed
     */
    function zend_pg(string $element = null, $initialize = 'empty')
    {
        $pg = (\PHP_ZTS) ? Zval::tsrmg_fast_static('core_globals_offset', 'php_core_globals*') : \ze_ffi()->core_globals;
        if ($initialize !== 'empty')
            $pg->{$element} = $initialize;

        return \is_null($element) ? $pg : $pg->{$element};
    }

    /**
     * Represents `EG()` macro.
     *
     *```cpp
     *struct _zend_executor_globals
     *{
     *	zval uninitialized_zval;
     *	zval error_zval;
     *	zend_array *symtable_cache[32];
     *	zend_array **symtable_cache_limit;
     *	zend_array **symtable_cache_ptr;
     *	zend_array symbol_table;
     *	HashTable included_files;
     *	jmp_buf *bailout;
     *	int error_reporting;
     *	int exit_status;
     *	HashTable *function_table;
     *	HashTable *class_table;
     *	HashTable *zend_constants;
     *	zval *vm_stack_top;
     *	zval *vm_stack_end;
     *	zend_vm_stack vm_stack;
     *	size_t vm_stack_page_size;
     *	struct _zend_execute_data *current_execute_data;
     *	zend_class_entry *fake_scope;
     *	uint32_t jit_trace_num;
     *	zend_long precision;
     *	int ticks_count;
     *	uint32_t persistent_constants_count;
     *	uint32_t persistent_functions_count;
     *	uint32_t persistent_classes_count;
     *	HashTable *in_autoload;
     *	zend_bool full_tables_cleanup;
     *	zend_bool no_extensions;
     *	zend_bool vm_interrupt;
     *	zend_bool timed_out;
     *	zend_long hard_timeout;
     *	OSVERSIONINFOEX windows_version_info;
     *	HashTable regular_list;
     *	HashTable persistent_list;
     *	int user_error_handler_error_reporting;
     *	zval user_error_handler;
     *	zval user_exception_handler;
     *	zend_stack user_error_handlers_error_reporting;
     *	zend_stack user_error_handlers;
     *	zend_stack user_exception_handlers;
     *	zend_error_handling_t error_handling;
     *	zend_class_entry *exception_class;
     *	zend_long timeout_seconds;
     *	int lambda_count;
     *	HashTable *ini_directives;
     *	HashTable *modified_ini_directives;
     *	zend_ini_entry *error_reporting_ini_entry;
     *	zend_objects_store objects_store;
     *	zend_object *exception, *prev_exception;
     *	const zend_op *opline_before_exception;
     *	zend_op exception_op[3];
     *	struct _zend_module_entry *current_module;
     *	zend_bool active;
     *	zend_uchar flags;
     *	zend_long assertions;
     *	uint32_t ht_iterators_count;
     *	uint32_t ht_iterators_used;
     *	HashTableIterator *ht_iterators;
     *	HashTableIterator ht_iterators_slots[16];
     *	void *saved_fpu_cw_ptr;
     *	zend_function trampoline;
     *	zend_op call_trampoline_op;
     *	HashTable weakrefs;
     *	zend_bool exception_ignore_args;
     *	zend_long exception_string_param_max_len;
     *	zend_get_gc_buffer get_gc_buffer;
     *	void *reserved[6];
     *};
     *```
     * @param string $element field
     * @param mixed $initialize set element value
     * @return CData|mixed
     */
    function zend_eg(string $element = null, $initialize = 'empty')
    {
        $eg = (\PHP_ZTS) ? Zval::tsrmg_fast('executor_globals_offset', 'zend_executor_globals*') : \ze_ffi()->executor_globals;
        if ($initialize !== 'empty')
            $eg->{$element} = $initialize;

        return \is_null($element) ? $eg : $eg->{$element};
    }

    /**
     * Represents `CG()` macro.
     *
     *```cpp
     *struct _zend_compiler_globals
     *{
     *	zend_stack loop_var_stack;
     *	zend_class_entry *active_class_entry;
     *	zend_string *compiled_filename;
     *	int zend_lineno;
     *	zend_op_array *active_op_array;
     *	HashTable *function_table;
     *	HashTable *class_table;
     *	HashTable *auto_globals;
     *  zend_uchar parse_error;
     *	zend_bool in_compilation;
     *	zend_bool short_tags;
     *	zend_bool unclean_shutdown;
     *	zend_bool ini_parser_unbuffered_errors;
     *	zend_llist open_files;
     *	struct _zend_ini_parser_param *ini_parser_param;
     *	zend_bool skip_shebang;
     *	zend_bool increment_lineno;
     *	zend_string *doc_comment;
     *	uint32_t extra_fn_flags;
     *	uint32_t compiler_options;
     *	zend_oparray_context context;
     *	zend_file_context file_context;
     *	zend_arena *arena;
     *	HashTable interned_strings;
     *	const zend_encoding **script_encoding_list;
     *	size_t script_encoding_list_size;
     *	zend_bool multibyte;
     *	zend_bool detect_unicode;
     *	zend_bool encoding_declared;
     *	zend_ast *ast;
     *	zend_arena *ast_arena;
     *	zend_stack delayed_oplines_stack;
     *	HashTable *memoized_exprs;
     *	int memoize_mode;
     *	void *map_ptr_base;
     *	size_t map_ptr_size;
     *	size_t map_ptr_last;
     *	HashTable *delayed_variance_obligations;
     *	HashTable *delayed_autoloads;
     *	uint32_t rtd_key_counter;
     *	zend_stack short_circuiting_opnums;
     *};
     *```
     * @param string $element field
     * @param mixed $initialize set element value
     * @return CData|mixed
     */
    function zend_cg(string $element = null, $initialize = 'empty')
    {
        $cg = (\PHP_ZTS) ? Zval::tsrmg_fast('compiler_globals_offset', 'zend_compiler_globals*') : \ze_ffi()->compiler_globals;
        if ($initialize !== 'empty')
            $cg->{$element} = $initialize;

        return \is_null($element) ? $cg : $cg->{$element};
    }

    /**
     * Represents `SG()` macro.
     *
     *```cpp
     * typedef struct _sapi_globals_struct
     *{
     *	void *server_context;
     *	sapi_request_info request_info;
     *	sapi_headers_struct sapi_headers;
     *	int64_t read_post_bytes;
     *	unsigned char post_read;
     *	unsigned char headers_sent;
     *	zend_stat_t global_stat;
     *	char *default_mimetype;
     *	char *default_charset;
     *	HashTable *rfc1867_uploaded_files;
     *	zend_long post_max_size;
     *	int options;
     *	zend_bool sapi_started;
     *	double global_request_time;
     *	HashTable known_post_content_types;
     *	zval callback_func;
     *	zend_fcall_info_cache fci_cache;
     *} sapi_globals_struct;
     *```
     * @param string $element field
     * @param mixed $initialize set element value
     * @return CData|mixed
     */
    function zend_sg(string $element = null, $initialize = 'empty')
    {
        $sg = (\PHP_ZTS) ? Zval::tsrmg_fast('sapi_globals_offset', 'sapi_globals_struct*') : \ze_ffi()->sapi_globals;
        if ($initialize !== 'empty')
            $sg->{$element} = $initialize;

        return \is_null($element) ? $sg : $sg->{$element};
    }

    function zend_fcall_info_call($routine, ...$arguments)
    {
        $zval = \zval_stack(0);
        $ret = \zval_blank();
        if (!\is_null($arguments))
            $args = \zval_stack(1);
        else
            $args = null;

        $fci = \c_typedef('zend_fcall_info');
        $fci()->param_count = 0;
        $fci()->params = NULL;
        $fcc = \c_typedef('zend_fcall_info_cache');
        if (\ze_ffi()->zend_fcall_info_init(
            $zval(),
            0,
            $fci(),
            $fcc(),
            null,
            null
        ) === 0) {
            if (\ze_ffi()->zend_fcall_info_call(
                $fci(),
                $fcc(),
                $ret(),
                ($args instanceof Zval ? $args() : $args)
            ) === 0) {
                \ze_ffi()->zend_release_fcall_info_cache($fcc());

                return \zval_native($ret);
            }
        }

        return \ZE::FAILURE;
    }

    function zend_call_function($routine, $argument = null)
    {
        $zval = \zval_stack(0);
        $ret = \zval_blank();
        $args = \zval_stack(1);

        $fci = \c_typedef('zend_fcall_info');
        $fcc = \c_typedef('zend_fcall_info_cache');
        if (\ze_ffi()->zend_fcall_info_init(
            $zval(),
            0,
            $fci(),
            $fcc(),
            null,
            null
        ) === 0) {
            $fci()->param_count = 1;
            $fci()->retval = $ret();
            $fci()->params = $args();
            if (\ze_ffi()->zend_call_function($fci(), $fcc()) === 0) {
                \ze_ffi()->zend_release_fcall_info_cache($fcc());

                return \zval_native($ret);
            }
        }

        return \ZE::FAILURE;
    }

    function zend_execute_scripts(string $file)
    {
        $primary_file = \c_struct_type('_zend_file_handle');
        \ze_ffi()->zend_stream_init_filename($primary_file(), $file);
        $ret = \zval_blank();
        \ze_ffi()->zend_execute_scripts(\ZE::ZEND_REQUIRE, $ret(), 1, $primary_file());
        //\ze_ffi()->zend_file_handle_dtor($primary_file());

        return \zval_native($ret);
    }
}
