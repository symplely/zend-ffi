<?php

/** @var callable (zend_resource *res) */
interface rsrc_dtor_func_t extends closure
{
}
interface user_opcode_handler_t extends closure
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
abstract class int64_t extends int
{
}
abstract class DWORD extends int
{
}
abstract class HANDLE extends void_ptr
{
}
abstract class char extends FFI\CData
{
}
abstract class const_char extends string
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

abstract class HashTable extends _zend_array
{
}

abstract class ZendResource extends zend_resource
{
}

abstract class TsHashTable extends FFI\CData
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
abstract class errno_t extends uint32_t
{
}


interface FFI
{
    /** @return void_ptr */
    public function tsrm_get_ls_cache();

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
    public function zend_ts_hash_str_find(TsHashTable &$ht, const_char &$key, size_t $len);

    /** @return zval */
    public function zend_ts_hash_str_update(TsHashTable &$ht, const_char &$key, size_t $len, zval &$pData);

    /** @return zval */
    public function zend_ts_hash_str_add(TsHashTable &$ht, const_char &$key, size_t $len, zval &$pData);

    /** @return void */
    public function zend_ts_hash_destroy(TsHashTable &$ht);

    /** @return void */
    public function zend_ts_hash_clean(TsHashTable &$ht);

    /** @return zval */
    public function zend_ts_hash_find(TsHashTable &$ht, zend_string &$key);

    /** @return zend_result */
    public function zend_ts_hash_del(TsHashTable &$ht, zend_string &$key);

    /** @return zval */
    public function zend_ts_hash_update(TsHashTable &$ht, zend_string &$key, zval &$pData);

    /** @return zval */
    public function zend_ts_hash_add(TsHashTable &$ht, zend_string &$key, zval &$pData);

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
}