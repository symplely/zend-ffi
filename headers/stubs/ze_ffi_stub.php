<?php

/** @var callable (zend_resource *res) */
interface rsrc_dtor_func_t extends closure
{
}
interface user_opcode_handler_t extends closure
{
}
/** @var callable (LPVOID lpParameter) */
interface ThreadProc extends closure
{
}
/** @var callable (zend_execute_data *execute_data) */
interface zend_interrupt_function extends closure
{
}
interface LPTHREAD_START_ROUTINE extends ThreadProc
{
}
interface ts_allocate_ctor extends closure
{
}
interface ts_allocate_dtor extends closure
{
}
interface tsrm_thread_begin_func_t extends closure
{
}
interface tsrm_thread_end_func_t extends closure
{
}
interface tsrm_shutdown_func_t extends closure
{
}

abstract class SOCKET extends int
{
}
abstract class php_socket_t extends SOCKET
{
}
abstract class uint64_t extends int
{
}
abstract class int32_t extends int
{
}
abstract class int32_ptr extends int_ptr
{
}
abstract class int64_t extends int
{
}
abstract class DWORD extends int
{
}
abstract class UINT extends int
{
}
abstract class HANDLE extends void_ptr
{
}
abstract class _CONTEXT extends FFI\CData
{
}
abstract class LPCONTEXT extends _CONTEXT
{
}
abstract class char extends FFI\CData
{
}
abstract class _zend_file_handle extends FFI\CData
{
}
abstract class _SECURITY_ATTRIBUTES extends FFI\CData
{
}
abstract class CONTEXT extends _CONTEXT
{
}
abstract class LPSECURITY_ATTRIBUTES extends _SECURITY_ATTRIBUTES
{
}
abstract class LPVOID extends void_ptr
{
}
abstract class DWORD_PTR extends FFI\CData
{
}
abstract class LPDWORD extends DWORD_PTR
{
}
abstract class zend_file_handle extends _zend_file_handle
{
}
abstract class sockaddr_storage extends FFI\CData
{
}
abstract class sockaddr_in extends sockaddr
{
}
abstract class sockaddr_in6 extends sockaddr
{
}
abstract class addrinfo extends FFI\CData
{
}
abstract class int_ptr extends FFI\CData
{
}
abstract class sockaddr extends FFI\CData
{
}
abstract class va_list extends char
{
}
abstract class const_char extends string
{
}
abstract class sapi_module_struct extends FFI\CData
{
}
abstract class void_t extends FFI\CData
{
}
abstract class void_ptr extends void_t
{
}
abstract class _zval_struct extends FFI\CData
{
}
abstract class zend_object extends FFI\CData
{
}
abstract class zend_string extends FFI\CData
{
}
abstract class Resource extends FFI\CData
{
}
abstract class CStruct extends FFI\CData
{
}

abstract class zend_thread_t extends CStruct
{
}
abstract class ZendString extends zend_string
{
}
abstract class zend_op extends FFI\CData
{
}
abstract class znode_op extends FFI\CData
{
}
abstract class zend_resource extends FFI\CData
{
}
abstract class _zend_array extends FFI\CData
{
}

abstract class zend_class_entry extends FFI\CData
{
}

abstract class zend_bool extends int
{
}

abstract class off_t extends long
{
}

abstract class HashTable extends _zend_array
{
}

abstract class ZendResource extends zend_resource
{
}

abstract class zend_reference extends FFI\CData
{
}
abstract class zend_function extends FFI\CData
{
}

abstract class zend_execute_data extends FFI\CData
{
}

abstract class ZendExecutor extends zend_execute_data
{
}

abstract class _zend_module_entry extends FFI\CData
{
}

abstract class ZendModule extends zend_module_entry
{
}

abstract class zend_module_entry extends _zend_module_entry
{
}

abstract class php_stream_context extends FFI\CData
{
}

abstract class _zend_closure extends FFI\CData
{
}

abstract class ZendClosure extends zend_closure
{
}

abstract class zend_closure extends _zend_closure
{
}

abstract class ZendObjectsStore extends zend_objects_store
{
}
abstract class zend_objects_store extends _zend_objects_store
{
}
abstract class _zend_objects_store extends FFI\CData
{
}

abstract class zend_fcall_info extends FFI\CData
{
}
abstract class zend_fcall_info_cache extends FFI\CData
{
}

abstract class _zend_object extends FFI\CData
{
}
abstract class ZendObject extends _zend_object
{
}

abstract class _php_stream extends FFI\CData
{
}

abstract class php_stream extends _php_stream
{
}

abstract class ZendReference extends zend_reference
{
}

abstract class ZendFunction extends zend_function
{
}
abstract class FILE extends FFI\CData
{
}

abstract class Zval extends _zval_struct
{
}
abstract class zend_uchar extends string
{
}
abstract class uint32_t extends int
{
}
abstract class uint16_t extends int
{
}
abstract class zend_ast_kind extends uint16_t
{
}
abstract class zend_ast_attr extends uint16_t
{
}
abstract class zend_lex_state extends \FFI\CData
{
}
abstract class _zend_ast extends \FFI\CData
{
}
abstract class zend_ast extends _zend_ast
{
}
abstract class long extends int
{
}
abstract class zend_long extends long
{
}
abstract class double extends float
{
}
abstract class intptr_t extends long
{
}
abstract class size_t extends uint32_t
{
}
abstract class size_ptr extends int_ptr
{
}
abstract class timespec extends int_ptr
{
}
abstract class ts_rsrc_id extends int
{
}
abstract class ts_rsrc_id_ptr extends int_ptr
{
}
abstract class MUTEX_T extends \FFI\CData
{
}
abstract class THREAD_T extends int
{
}
abstract class pthread_attr_t extends \FFI\CData
{
}
abstract class pthread_mutexattr_t extends \FFI\CData
{
}
abstract class pthread_barrier_t extends \FFI\CData
{
}
abstract class pthread_barrierattr_t extends \FFI\CData
{
}
abstract class pthread_spinlock_t extends \FFI\CData
{
}
abstract class pthread_cond_t extends \FFI\CData
{
}
abstract class pthread_condattr_t extends \FFI\CData
{
}
abstract class pthread_rwlock_t extends \FFI\CData
{
}
abstract class pthread_rwlockattr_t extends \FFI\CData
{
}
abstract class pthread_t extends THREAD_T
{
}
abstract class pthread_t_ptr extends \FFI\CData
{
}
abstract class pthread_mutex_t extends MUTEX_T
{
}
abstract class pthread_key_t extends \FFI\CData
{
}
abstract class errno_t extends uint32_t
{
}

/**
 * @property zend_internal_function $zend_pass_function
 * @property zend_object_handlers $std_object_handlers
 * @property HashTable $module_registry
 * @property sapi_module_struct sapi_module
 * @property int $compiler_globals_id if ZTS
 * @property size_t $compiler_globals_offset if ZTS
 * @property zend_compiler_globals $compiler_globals if NTS
 * @property int sapi_globals_id if ZTS
 * @property size_t sapi_globals_offset if ZTS
 * @property sapi_globals_struct sapi_globals if NTS
 * @property int $executor_globals_id; if ZTS
 * @property size_t $executor_globals_offset; if ZTS
 * @property zend_execute_data $executor_globals; if NTS
 * @property int core_globals_id; if ZTS
 * @property size_t core_globals_offset; if ZTS
 * @property _php_core_globals core_globals; if NTS
 * @property php_stream_ops php_stream_stdio_ops;
 * @property php_stream_wrapper php_plain_files_wrapper;
 * @property zend_fcall_info empty_fcall_info;
 * @property zend_fcall_info_cache empty_fcall_info_cache;
 */
interface FFI
{
    /** @return int */
    public function zend_register_list_destructors_ex(?rsrc_dtor_func_t $ld, ?rsrc_dtor_func_t $pld, const_char $type_name, int $module_number);

    /** @return zend_resource */
    public function zend_register_resource(void_ptr &$rsrc_pointer, int $rsrc_type);

    /** @return void_ptr */
    public function zend_fetch_resource(zend_resource &$res, const_char &$resource_type_name, int $resource_type);

    /** @return void_ptr */
    public function zend_fetch_resource_ex(zval &$res, ?const_char &$resource_type_name, int $resource_type);

    /** @return void_ptr */
    public function zend_fetch_resource2(zend_resource &$res, const_char &$resource_type_name, int &$resource_type, int $resource_type2);

    /** @return void_ptr */
    public function zend_fetch_resource2_ex(zval &$res, const_char &$resource_type_name, int $resource_type, int $resource_type2);

    /** @return zend_result */
    public function zend_parse_parameters(uint32_t $num_args, const_char &$type_spec, ...$arguments);

    /** @return zval */
    public function zend_hash_find(HashTable &$ht, zend_string &$key);

    /** @return zval */
    public function zend_hash_str_find(HashTable &$ht, const_char &$key, size_t $len);

    /** @return int */
    public function zend_hash_del(HashTable &$ht, zend_string &$key);

    /** @return zval */
    public function zend_hash_add_or_update(HashTable &$ht, zend_string &$key, zval &$pData, uint32_t $flag);

    /** @return zval */
    public function zend_hash_next_index_insert(HashTable &$ht, zval &$pData);

    /** @return zend_function */
    public function zend_fetch_function(zend_string &$name);

    /** @return int */
    public function zend_set_user_opcode_handler(zend_uchar $opcode, ?user_opcode_handler_t $handler);

    /** @return user_opcode_handler_t */
    public function zend_get_user_opcode_handler(zend_uchar $opcode);

    /** @return zval */
    public function zend_get_zval_ptr(zend_op &$opline, int $op_type, znode_op &$node, zend_execute_data &$execute_data, ...$arguments);

    public function zval_ptr_dtor(zval &$zval_ptr);

    public function zval_add_ref(zval &$p);

    public function zval_internal_ptr_dtor(zval &$zvalue);

    /** @return php_stream */
    public function _php_stream_fopen_from_fd(int $fd, const_char $mode, ...$arguments);

    /** @return int */
    public function _php_stream_free(php_stream &$stream, int $close_options);

    /** @return void */
    public function php_error_docref(?const_char &$docRef, int $type, const_char &$format, ...$arguments);

    /** @return void */
    public function zend_error(int $type, const_char &$format, ...$arguments);

    /** @return int */
    public function php_file_le_stream();

    /** @return int */
    public function php_file_le_pstream();

    /** @return int */
    public function _php_stream_cast(php_stream &$stream, int $castas, void_ptr &$ret, int $show_err);

    /** @return php_stream */
    public function _php_stream_fopen_tmpfile(int $dummy);

    /** @return php_stream */
    public function _php_stream_open_wrapper_ex(const_char &$path, const_char $mode, int $options, zend_string &$opened_path, ?php_stream_context &$context, ...$arguments);

    /** @return ssize_t */
    public function _php_stream_printf(php_stream &$stream, const_char &$fmt, ...$arguments);

    /** @return HashTable */
    public function _zend_new_array(uint32_t $size);

    /** @return uint32_t */
    public function zend_array_count(HashTable &$ht);

    /** @return HashTable */
    public function zend_new_pair(zval &$val1, zval &$val2);

    /** @return void */
    public function add_assoc_long_ex(zval &$arg, const_char $key, size_t $key_len, zend_long $n);

    /** @return void */
    public function add_assoc_null_ex(zval &$arg, const_char $key, size_t $key_len);

    /** @return void */
    public function add_assoc_bool_ex(zval &$arg, const_char $key, size_t $key_len, bool $b);

    /** @return void */
    public function add_assoc_resource_ex(zval &$arg, const_char $key, size_t $key_len, zend_resource &$r);

    /** @return void */
    public function add_assoc_double_ex(zval &$arg, const_char $key, size_t $key_len, double $d);

    /** @return void */
    public function add_assoc_str_ex(zval &$arg, const_char $key, size_t $key_len, zend_string &$str);

    /** @return void */
    public function add_assoc_string_ex(zval &$arg, const_char $key, size_t $key_len, const_char $str);

    /** @return void */
    public function add_assoc_stringl_ex(zval &$arg, const_char $key, size_t $key_len, const_char $str, size_t $length);

    /** @return void */
    public function add_assoc_zval_ex(zval &$arg, const_char $key, size_t $key_len, zval &$value);

    /** @return zend_result */
    public function add_next_index_string(zval &$arg, const_char &$str);

    /** @return zend_module_entry */
    public function zend_register_module_ex(zend_module_entry &$module);

    /** @return zend_result */
    public function zend_startup_module_ex(zend_module_entry &$module);

    /** @return int */
    public function zend_alter_ini_entry(zend_string &$name, zend_string &$new_value, int $modify_type, int $stage);

    /** @return void */
    public function zend_do_inheritance_ex(zend_class_entry &$ce, zend_class_entry &$parent_ce, zend_bool $checked);

    /** @return int */
    public function ap_php_slprintf(char &$buf, size_t $len, const_char &$format, ...$args);

    /** @return int */
    public function ap_php_vslprintf(char &$buf, size_t $len, const_char &$format, va_list $ap);

    /** @return int */
    public function ap_php_snprintf(char &$buf, size_t $len, const_char &$format, ...$args);

    /** @return int */
    public function ap_php_vsnprintf(char &$buf, size_t $len, const_char &$format, va_list $ap);

    /** @return int */
    public function ap_php_vasprintf(char &$buf, const_char &$format, va_list $ap);

    /** @return int */
    public function ap_php_asprintf(char &$buf, const_char &$format, ...$args);

    /** @return void */
    public function tsrm_win32_startup();

    /** @return void */
    public function tsrm_win32_shutdown();

    /* startup/shutdown */
    /** @return int */
    public function tsrm_startup(int $expected_threads, int $expected_resources, int $debug_level, char &$debug_filename);

    /** @return void */
    public function tsrm_shutdown();

    /** @return int */
    public function php_tsrm_startup();

    /** @return void */
    public function tsrm_env_lock();

    /** @return void */
    public function tsrm_env_unlock();

    /* allocates a new thread-safe-resource id */
    /** @return ts_rsrc_id */
    public function ts_allocate_id(ts_rsrc_id_ptr &$rsrc_id, size_t $size, ?ts_allocate_ctor $ctor, ?ts_allocate_dtor $dtor);

    /* Fast resource in reserved (pre-allocated) space */
    /** @return void */
    public function tsrm_reserve(size_t $size);

    /** @return ts_rsrc_id */
    public function ts_allocate_fast_id(ts_rsrc_id_ptr &$rsrc_id, size_t &$offset, size_t $size, ts_allocate_ctor $ctor, ts_allocate_dtor $dtor);

    /* fetches the requested resource for the current thread */
    /** @return void_ptr */
    public function ts_resource_ex(ts_rsrc_id $id, ?THREAD_T &$th_id);
    // #define ts_resource(id) ts_resource_ex(id, NULL)

    /* frees all resources allocated for the current thread */
    /** @return void */
    public function ts_free_thread();

    /* deallocates all occurrences of a given id */
    /** @return void */
    public function ts_free_id(ts_rsrc_id $id);

    /** @return void */
    public function tsrm_error_set(int $level, char &$debug_filename);

    /* utility functions */
    /** @return THREAD_T */
    public function tsrm_thread_id();

    /** @return MUTEX_T */
    public function tsrm_mutex_alloc();

    /** @return void */
    public function tsrm_mutex_free(MUTEX_T $mutexp);

    /** @return int */
    public function tsrm_mutex_lock(MUTEX_T $mutexp);

    /** @return int */
    public function tsrm_mutex_unlock(MUTEX_T $mutexp);

    /** @return void_ptr */
    public function tsrm_set_new_thread_begin_handler(tsrm_thread_begin_func_t $new_thread_begin_handler);

    /** @return void_ptr */
    public function tsrm_set_new_thread_end_handler(tsrm_thread_end_func_t $new_thread_end_handler);

    /** @return void_ptr */
    public function tsrm_set_shutdown_handler(tsrm_shutdown_func_t $shutdown_handler);

    /* these 3 APIs should only be used by people that fully understand the threading model
 * used by PHP/Zend and the selected SAPI. */
    /** @return void_ptr */
    public function tsrm_new_interpreter_context();

    /** @return void_ptr */
    public function tsrm_set_interpreter_context(void_t &$new_ctx);

    /** @return void */
    public function tsrm_free_interpreter_context(void_t &$context);

    /** @return void_ptr */
    public function tsrm_get_ls_cache();

    /** @return uint8_t */
    public function tsrm_is_main_thread();

    /** @return uint8_t */
    public function tsrm_is_shutdown();

    /** @return const_char */
    public function tsrm_api_name();

    /** @return size_t */
    public function php_printf(const_char &$format, ...$args);

    /** @return int */
    public function php_request_startup();

    /** @return int */
    public function php_execute_script(zend_file_handle &$primary_file);

    /** @return int */
    public function php_execute_simple_script(zend_file_handle &$primary_file, zval &$ret);

    /** @return int */
    public function zend_execute_scripts(int $type, ?zval &$retval, int $file_count, ...$args);

    /** @return void */
    public function php_request_shutdown(?void_ptr &$dummy);

    /** @return void */
    public function php_info_print_table_start();

    /** @return void */
    public function php_info_print_table_header(int $num_cols, ...$args);

    /** @return void */
    public function php_info_print_table_row(int $num_cols, ...$args);

    /** @return void */
    public function php_info_print_table_end();

    /** @return void */
    public function zend_activate();

    /** @return void */
    public function zend_deactivate();

    /** @return void */
    public function zend_call_destructors();

    /** @return void */
    public function zend_activate_modules();

    /** @return void */
    public function zend_deactivate_modules();

    /** @return void */
    public function zend_post_deactivate_modules();

    /** @return int */
    public function sapi_send_headers();

    /** @return void */
    public function sapi_startup(sapi_module_struct &$sf);

    /** @return void */
    public function sapi_shutdown();

    /** @return void */
    public function sapi_activate();

    /** @return void */
    public function sapi_deactivate();

    /** @return int */
    public function sapi_flush();

    /** @return void */
    public function sapi_initialize_empty_request();

    /** @return void */
    public function sapi_add_request_header(char &$var, int $var_len, char &$val, int $val_len, void_ptr &$arg);

    /** @return void */
    public function sapi_terminate_process();

    /** @return void */
    public function zend_stream_init_filename(zend_file_handle &$handle, const_char $filename);

    /**
     * Build zend_call_info/cache from a zval*
     *
     * Caller is responsible to provide a return value (fci->retval), otherwise the we will crash.
     * - In order to pass parameters the following members need to be set:
     * - fci->param_count = 0;
     * - fci->params = NULL;
     * - The callable_name argument may be NULL.
     * - Set check_flags to IS_CALLABLE_STRICT for every new usage!
     *
     * @return int */
    public function zend_fcall_info_init(zval &$callable, uint32_t $check_flags, zend_fcall_info &$fci, zend_fcall_info_cache &$fcc, ?zend_string &$callable_name, ?char &$error);

    /**
     * Call a function using information created by zend_fcall_info_init()/args().
     * - If args is given then those replace the argument info in fci is temporarily.
     *
     * @return int */
    public function zend_fcall_info_call(zend_fcall_info &$fci, zend_fcall_info_cache &$fcc, ?zval &$retval, ?zval &$args);

    /** @return int */
    public function zend_call_function(zend_fcall_info &$fci, zend_fcall_info_cache &$fci_cache);

    /** @return void */
    public function zend_release_fcall_info_cache(zend_fcall_info_cache &$fcc);

    /** @return zend_string */
    public function zend_get_callable_name_ex(zval &$callable, zend_object &$object);

    /** @return zend_string */
    public function zend_get_callable_name(zval &$callable);

    /** @return void */
    public function php_output_startup();

    /** @return int */
    public function php_output_activate();

    /** @return void */
    public function php_output_end_all();

    /** @return void */
    public function php_output_deactivate();

    /** @return void */
    public function php_output_shutdown();

    /** @return int */
    public function php_module_startup(sapi_module_struct &$sf, ?zend_module_entry &$additional_modules, uint32_t ...$num_additional_modules);

    /** @return void */
    public function php_module_shutdown();

    /** @return int */
    public function php_module_shutdown_wrapper(sapi_module_struct &$sapi_globals);

    /** @return int */
    public function zend_ini_global_shutdown();

    /** @return void */
    public function _zend_bailout(const_char &$filename, uint32_t $lineno);

    /**
     * show an exception using zend_error(severity,...), severity should be E_ERROR
     * @return void
     */
    public function zend_exception_error(zval &$exception, int $severity, ...$args);

    /** @return zend_string */
    public function zend_print_zval_r_to_str(zval &$expr, int $indent);

    /**
     * Language scanner API
     */
    /** @return void */
    public function zend_save_lexical_state(zend_lex_state &$lex_state);
    /** @return void */
    public function zend_restore_lexical_state(zend_lex_state &$lex_state);
    /** @return void */
    public function zend_prepare_string_for_scanning(zval &$str, zend_string &$filename);

    /** @return zend_result */
    public function zend_lex_tstring(zval &$zv, char &$ident);

    /**
     * Abstract Syntax Tree (AST) API
     */

    /** @return int */
    public function zendparse();

    /** @return void */
    public function zend_ast_destroy(zend_ast &$ast);

    /** @return zend_object */
    public function zend_objects_new(zend_class_entry &$ce);

    /** @return void */
    public function object_properties_init(zend_object &$object, zend_class_entry &$class_type);

    /** @return zend_ast */
    public function zend_ast_create_list_0(zend_ast_kind $kind);

    /** @return zend_ast */
    public function zend_ast_list_add(zend_ast &$list, zend_ast &$op);

    /** @return zend_ast */
    public function zend_ast_create_zval_ex(zval &$zv, zend_ast_attr $attr);

    /** @return zend_ast */
    public function zend_ast_create_0(zend_ast_kind $kind);

    /** @return zend_ast */
    public function zend_ast_create_1(zend_ast_kind $kind, zend_ast &$child);

    /** @return zend_ast */
    public function zend_ast_create_2(zend_ast_kind $kind, zend_ast &$child1, zend_ast &$child2);

    /** @return zend_ast */
    public function zend_ast_create_3(zend_ast_kind $kind, zend_ast &$child1, zend_ast &$child2, zend_ast &$child3);

    /** @return zend_ast */
    public function zend_ast_create_4(zend_ast_kind $kind, zend_ast &$child1, zend_ast &$child2, zend_ast &$child3, zend_ast &$child4);

    /** @return zend_ast */
    public function zend_ast_create_decl(
        zend_ast_kind $kind,
        uint32_t $flags,
        uint32_t $start_lineno,
        zend_string &$doc_comment,
        zend_string &$name,
        zend_ast &$child0,
        zend_ast &$child1,
        zend_ast &$child2,
        zend_ast &$child3,
        zend_ast &$child4
    );

    /** @return void_ptr */
    public function mmap(?void_ptr &$addr, size_t $length, int $prot, int $flags, int $fd, off_t $offset);

    /** @return int */
    public function munmap(void_ptr &$addr, size_t $length);

    /** @return int */
    public function mprotect(void_ptr &$addr, size_t $len, int $prot);

    // from <unistd.h>
    /** @return int */
    public function getpagesize();
}
