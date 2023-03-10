#define FFI_SCOPE "__zend__"
#define FFI_LIB "php8ts.dll"

typedef struct _IO_FILE __FILE;
typedef long int __off_t;
typedef long int __off64_t;

typedef struct
{
	int level;			   /* fill/empty level of buffer */
	unsigned flags;		   /* File status flags */
	char fd;			   /* File descriptor */
	unsigned char hold;	   /* Ungetc char if no buffer */
	int bsize;			   /* Buffer size */
	unsigned char *buffer; /* Data transfer buffer */
	unsigned char *curp;   /* Current active pointer */
	unsigned istemp;	   /* Temporary file indicator */
	short token;		   /* Used for validity checking */
} FILE;

typedef enum
{
	SUCCESS = 0,
	FAILURE = -1,
} ZEND_RESULT_CODE;

typedef unsigned long uintptr_t;
typedef struct
{
	void *ptr;
	uint32_t type_mask;

} zend_type;

typedef ZEND_RESULT_CODE zend_result;
typedef intptr_t zend_intptr_t;
typedef uintptr_t zend_uintptr_t;
typedef unsigned char zend_uchar;
typedef int64_t zend_long;
typedef uint64_t zend_ulong;
typedef int64_t zend_off_t;

typedef struct _zend_refcounted_h
{
	uint32_t refcount;
	union
	{
		uint32_t type_info;
	} u;
} zend_refcounted_h;

struct _zend_string
{
	zend_refcounted_h gc;
	zend_ulong h; /* hash value */
	size_t len;
	char val[1];
};

typedef struct _zend_string zend_string;
struct _IO_marker;
struct _IO_codecvt;
struct _IO_wide_data;
typedef void _IO_lock_t;
struct _IO_FILE
{
	int _flags;
	char *_IO_read_ptr;
	char *_IO_read_end;
	char *_IO_read_base;
	char *_IO_write_base;
	char *_IO_write_ptr;
	char *_IO_write_end;
	char *_IO_buf_base;
	char *_IO_buf_end;
	char *_IO_save_base;
	char *_IO_backup_base;
	char *_IO_save_end;
	struct _IO_marker *_markers;
	struct _IO_FILE *_chain;
	int _fileno;
	int _flags2;
	__off_t _old_offset;
	unsigned short _cur_column;
	signed char _vtable_offset;
	char _shortbuf[1];
	_IO_lock_t *_lock;
	__off64_t _offset;
	struct _IO_codecvt *_codecvt;
	struct _IO_wide_data *_wide_data;
	struct _IO_FILE *_freeres_list;
	void *_freeres_buf;
	size_t __pad5;
	int _mode;
	char _unused2[15 * sizeof(int) - 4 * sizeof(void *) - sizeof(size_t)];
};

typedef size_t (*zend_stream_fsizer_t)(void *handle);
typedef ssize_t (*zend_stream_reader_t)(void *handle, char *buf, size_t len);
typedef void (*zend_stream_closer_t)(void *handle);

typedef struct _zend_stream
{
	void *handle;
	int isatty;
	zend_stream_reader_t reader;
	zend_stream_fsizer_t fsizer;
	zend_stream_closer_t closer;
} zend_stream;

typedef enum
{
	ZEND_HANDLE_FILENAME,
	ZEND_HANDLE_FP,
	ZEND_HANDLE_STREAM
} zend_stream_type;

typedef struct _zend_file_handle
{
	union
	{
		FILE *fp;
		zend_stream stream;
	} handle;
	zend_string *filename;
	zend_string *opened_path;
	zend_uchar type; /* packed zend_stream_type */
	bool primary_script;
	bool in_list; /* added into CG(open_file) */
	char *buf;
	size_t len;
} zend_file_handle;

typedef int (*zend_stream_open_function_func_t)(const char *filename, zend_file_handle *handle);
extern zend_stream_open_function_func_t zend_stream_open_function;

struct _zend_refcounted
{
	zend_refcounted_h gc;
};

struct _zend_resource
{
	zend_refcounted_h gc;
	zend_long handle;
	int type;
	void *ptr;
};

typedef struct _zend_resource zend_resource;
typedef void (*rsrc_dtor_func_t)(zend_resource *res);

typedef struct _zend_rsrc_list_dtors_entry
{
	rsrc_dtor_func_t list_dtor_ex;
	rsrc_dtor_func_t plist_dtor_ex;

	const char *type_name;

	int module_number;
	int resource_id;
} zend_rsrc_list_dtors_entry;

typedef struct _zend_refcounted zend_refcounted;
typedef struct _zend_object_handlers zend_object_handlers;
typedef struct _zend_array HashTable;
typedef struct _zend_array zend_array;
typedef struct _zend_object zend_object;
typedef struct _zend_resource zend_resource;
typedef struct _zend_reference zend_reference;
typedef struct _zend_ast_ref zend_ast_ref;
typedef struct _zval_struct zval;
typedef struct _zend_class_entry zend_class_entry;
typedef union _zend_function zend_function;
typedef struct _zend_op_array zend_op_array;
typedef struct _zend_op zend_op;
typedef struct _zend_execute_data zend_execute_data;
typedef void (*zif_handler)(zend_execute_data *execute_data, zval *return_value);

typedef union _zend_value
{
	zend_long lval;
	double dval;
	zend_refcounted *counted;
	zend_string *str;
	zend_array *arr;
	zend_object *obj;
	zend_resource *res;
	zend_reference *ref;
	zend_ast_ref *ast;
	zval *zv;
	void *ptr;
	zend_class_entry *ce;
	zend_function *func;
	struct
	{
		uint32_t w1;
		uint32_t w2;
	} ww;
} zend_value;

struct _zval_struct
{
	zend_value value;
	union
	{
		uint32_t type_info;
		struct
		{
			zend_uchar type;
			zend_uchar type_flags;
			union
			{
				uint16_t extra;
			} u;
		} v;
	} u1;
	union
	{
		uint32_t next;
		uint32_t cache_slot;
		uint32_t opline_num;
		uint32_t lineno;
		uint32_t num_args;
		uint32_t fe_pos;
		uint32_t fe_iter_idx;
		uint32_t property_guard;
		uint32_t constant_flags;
		uint32_t extra;
	} u2;
};

typedef struct _Bucket
{
	zval val;
	zend_ulong h;	  /* hash value (or numeric index)   */
	zend_string *key; /* string key or NULL for numerics */
} Bucket;

typedef void (*dtor_func_t)(zval *pDest);
struct _zend_array
{
	zend_refcounted_h gc;
	union
	{
		struct
		{
			zend_uchar flags;
			zend_uchar _unused;
			zend_uchar nIteratorsCount;
			zend_uchar _unused2;
		} v;
		uint32_t flags;
	} u;
	uint32_t nTableMask;
	Bucket *arData;
	uint32_t nNumUsed;
	uint32_t nNumOfElements;
	uint32_t nTableSize;
	uint32_t nInternalPointer;
	zend_long nNextFreeElement;
	dtor_func_t pDestructor;
};

typedef struct _zend_property_info
{
	uint32_t offset; /* property offset for object properties or
						  property index for static properties */
	uint32_t flags;
	zend_string *name;
	zend_string *doc_comment;
	HashTable *attributes;
	zend_class_entry *ce;
	zend_type type;
} zend_property_info;

typedef struct
{
	size_t num;
	size_t num_allocated;
	struct _zend_property_info *ptr[1];
} zend_property_info_list;

typedef union
{
	struct _zend_property_info *ptr;
	uintptr_t list;
} zend_property_info_source_list;

struct _zend_reference
{
	zend_refcounted_h gc;
	zval val;
	zend_property_info_source_list sources;
};

struct _zend_ast_ref
{
	zend_refcounted_h gc;
};

struct _zend_object
{
	zend_refcounted_h gc;
	uint32_t handle;
	zend_class_entry *ce;
	const zend_object_handlers *handlers;
	HashTable *properties;
	zval properties_table[1];
};

typedef zval *(*zend_object_read_property_t)(zend_object *object, zend_string *member, int type, void **cache_slot, zval *rv);
typedef zval *(*zend_object_read_dimension_t)(zend_object *object, zval *offset, int type, zval *rv);
typedef zval *(*zend_object_write_property_t)(zend_object *object, zend_string *member, zval *value, void **cache_slot);
typedef void (*zend_object_write_dimension_t)(zend_object *object, zval *offset, zval *value);
typedef zval *(*zend_object_get_property_ptr_ptr_t)(zend_object *object, zend_string *member, int type, void **cache_slot);
typedef int (*zend_object_has_property_t)(zend_object *object, zend_string *member, int has_set_exists, void **cache_slot);
typedef int (*zend_object_has_dimension_t)(zend_object *object, zval *member, int check_empty);
typedef void (*zend_object_unset_property_t)(zend_object *object, zend_string *member, void **cache_slot);
typedef void (*zend_object_unset_dimension_t)(zend_object *object, zval *offset);
typedef HashTable *(*zend_object_get_properties_t)(zend_object *object);
typedef HashTable *(*zend_object_get_debug_info_t)(zend_object *object, int *is_temp);

typedef enum _zend_prop_purpose
{
	ZEND_PROP_PURPOSE_DEBUG,
	ZEND_PROP_PURPOSE_ARRAY_CAST,
	ZEND_PROP_PURPOSE_SERIALIZE,
	ZEND_PROP_PURPOSE_VAR_EXPORT,
	ZEND_PROP_PURPOSE_JSON,
	_ZEND_PROP_PURPOSE_NON_EXHAUSTIVE_ENUM
} zend_prop_purpose;

typedef zend_array *(*zend_object_get_properties_for_t)(zend_object *object, zend_prop_purpose purpose);
typedef zend_function *(*zend_object_get_method_t)(zend_object **object, zend_string *method, const zval *key);
typedef zend_function *(*zend_object_get_constructor_t)(zend_object *object);
typedef void (*zend_object_dtor_obj_t)(zend_object *object);
typedef void (*zend_object_free_obj_t)(zend_object *object);
typedef zend_object *(*zend_object_clone_obj_t)(zend_object *object);
typedef zend_string *(*zend_object_get_class_name_t)(const zend_object *object);
typedef int (*zend_object_compare_t)(zval *object1, zval *object2);
typedef int (*zend_object_cast_t)(zend_object *readobj, zval *retval, int type);
typedef int (*zend_object_count_elements_t)(zend_object *object, zend_long *count);
typedef int (*zend_object_get_closure_t)(zend_object *obj, zend_class_entry **ce_ptr, zend_function **fptr_ptr, zend_object **obj_ptr, bool check_only);
typedef HashTable *(*zend_object_get_gc_t)(zend_object *object, zval **table, int *n);
typedef int (*zend_object_do_operation_t)(zend_uchar opcode, zval *result, zval *op1, zval *op2);

struct _zend_object_handlers
{
	int offset;
	zend_object_free_obj_t free_obj;
	zend_object_dtor_obj_t dtor_obj;
	zend_object_clone_obj_t clone_obj;
	zend_object_read_property_t read_property;
	zend_object_write_property_t write_property;
	zend_object_read_dimension_t read_dimension;
	zend_object_write_dimension_t write_dimension;
	zend_object_get_property_ptr_ptr_t get_property_ptr_ptr;
	zend_object_has_property_t has_property;
	zend_object_unset_property_t unset_property;
	zend_object_has_dimension_t has_dimension;
	zend_object_unset_dimension_t unset_dimension;
	zend_object_get_properties_t get_properties;
	zend_object_get_method_t get_method;
	zend_object_get_constructor_t get_constructor;
	zend_object_get_class_name_t get_class_name;
	zend_object_cast_t cast_object;
	zend_object_count_elements_t count_elements;
	zend_object_get_debug_info_t get_debug_info;
	zend_object_get_closure_t get_closure;
	zend_object_get_gc_t get_gc;
	zend_object_do_operation_t do_operation;
	zend_object_compare_t compare;
	zend_object_get_properties_for_t get_properties_for;
};

/* arg_info for internal functions */
typedef struct _zend_internal_arg_info
{
	const char *name;
	zend_type type;
	const char *default_value;
} zend_internal_arg_info;

typedef struct
{
	uint32_t num_types;
	zend_type types[1];
} zend_type_list;

typedef struct _zend_arg_info
{
	zend_string *name;
	zend_type type;
	zend_string *default_value;
} zend_arg_info;

typedef struct _zend_internal_function
{
	/* Common elements */
	zend_uchar type;
	zend_uchar arg_flags[3]; /* bitset of arg_info.pass_by_reference */
	uint32_t fn_flags;
	zend_string *function_name;
	zend_class_entry *scope;
	zend_function *prototype;
	uint32_t num_args;
	uint32_t required_num_args;
	zend_internal_arg_info *arg_info;
	HashTable *attributes;
	/* END of common elements */

	zif_handler handler;
	struct _zend_module_entry *module;
	void *reserved[6];
} zend_internal_function;

typedef struct _zend_internal_function_info
{
	zend_uintptr_t required_num_args;
	zend_type type;
	const char *default_value;
} zend_internal_function_info;

typedef struct _zend_label
{
	int brk_cont;
	uint32_t opline_num;
} zend_label;

typedef struct _zend_live_range
{
	uint32_t var;
	uint32_t start;
	uint32_t end;
} zend_live_range;

typedef struct _zend_try_catch_element
{
	uint32_t try_op;
	uint32_t catch_op;
	uint32_t finally_op;
	uint32_t finally_end;
} zend_try_catch_element;

struct _zend_op_array
{
	zend_uchar type;
	zend_uchar arg_flags[3];
	uint32_t fn_flags;
	zend_string *function_name;
	zend_class_entry *scope;
	zend_function *prototype;
	uint32_t num_args;
	uint32_t required_num_args;
	zend_arg_info *arg_info;
	HashTable *attributes;
	int cache_size;
	int last_var;
	uint32_t T;
	uint32_t last;
	zend_op *opcodes;
	void ***run_time_cache;
	HashTable **static_variables_ptr;
	HashTable *static_variables;
	zend_string **vars;
	uint32_t *refcount;
	int last_live_range;
	int last_try_catch;
	zend_live_range *live_range;
	zend_try_catch_element *try_catch_array;
	zend_string *filename;
	uint32_t line_start;
	uint32_t line_end;
	zend_string *doc_comment;
	int last_literal;
	uint32_t num_dynamic_func_defs;
	zval *literals;

	/* Functions that are declared dynamically are stored here and
	 * referenced by index from opcodes. */
	zend_op_array **dynamic_func_defs;

	void *reserved[6];
};

struct _zend_execute_data
{
	const zend_op *opline;
	zend_execute_data *call;
	zval *return_value;
	zend_function *func;
	zval This;
	zend_execute_data *prev_execute_data;
	zend_array *symbol_table;
	void **run_time_cache;
	zend_array *extra_named_params;
};

typedef union _znode_op
{
	uint32_t constant;
	uint32_t var;
	uint32_t num;
	uint32_t opline_num; /*  Needs to be signed */
	uint32_t jmp_offset;
	// zval          *zv;
} znode_op;

typedef struct _znode
{ /* used only during compilation */
	zend_uchar op_type;
	zend_uchar flag;
	union
	{
		znode_op op;
		zval constant; /* replaced by literal/zv */
	} u;
} znode;

struct _zend_op
{
	const void *handler;
	znode_op op1;
	znode_op op2;
	znode_op result;
	uint32_t extended_value;
	uint32_t lineno;
	zend_uchar opcode;
	zend_uchar op1_type;
	zend_uchar op2_type;
	zend_uchar result_type;
};

union _zend_function
{
	zend_uchar type; /* MUST be the first element of this struct! */
	uint32_t quick_arg_flags;

	struct
	{
		zend_uchar type;		 /* never used */
		zend_uchar arg_flags[3]; /* bitset of arg_info.pass_by_reference */
		uint32_t fn_flags;
		zend_string *function_name;
		zend_class_entry *scope;
		zend_function *prototype;
		uint32_t num_args;
		uint32_t required_num_args;
		zend_arg_info *arg_info; /* index -1 represents the return value info, if any */
		HashTable *attributes;
	} common;

	zend_op_array op_array;
	zend_internal_function internal_function;
};

typedef struct _zend_class_name
{
	zend_string *name;
	zend_string *lc_name;
} zend_class_name;

typedef struct _zend_object_iterator zend_object_iterator;
typedef struct _zend_object_iterator_funcs
{
	void (*dtor)(zend_object_iterator *iter);
	int (*valid)(zend_object_iterator *iter);
	zval *(*get_current_data)(zend_object_iterator *iter);
	void (*get_current_key)(zend_object_iterator *iter, zval *key);
	void (*move_forward)(zend_object_iterator *iter);
	void (*rewind)(zend_object_iterator *iter);
	void (*invalidate_current)(zend_object_iterator *iter);
	HashTable *(*get_gc)(zend_object_iterator *iter, zval **table, int *n);
} zend_object_iterator_funcs;

typedef struct _zend_class_mutable_data
{
	zval *default_properties_table;
	HashTable *constants_table;
	uint32_t ce_flags;
} zend_class_mutable_data;

typedef struct _zend_class_dependency
{
	zend_string *name;
	zend_class_entry *ce;
} zend_class_dependency;

typedef struct _zend_error_info
{
	int type;
	uint32_t lineno;
	zend_string *filename;
	zend_string *message;
} zend_error_info;

typedef struct _zend_inheritance_cache_entry zend_inheritance_cache_entry;

struct _zend_inheritance_cache_entry
{
	zend_inheritance_cache_entry *next;
	zend_class_entry *ce;
	zend_class_entry *parent;
	zend_class_dependency *dependencies;
	uint32_t dependencies_count;
	uint32_t num_warnings;
	zend_error_info **warnings;
	zend_class_entry *traits_and_interfaces[1];
};

struct _zend_object_iterator
{
	zend_object std;
	zval data;
	const zend_object_iterator_funcs *funcs;
	zend_ulong index;
};

typedef struct _zend_class_iterator_funcs
{
	zend_function *zf_new_iterator;
	zend_function *zf_valid;
	zend_function *zf_current;
	zend_function *zf_key;
	zend_function *zf_next;
	zend_function *zf_rewind;
} zend_class_iterator_funcs;

struct _zend_serialize_data;
struct _zend_unserialize_data;
typedef struct _zend_serialize_data zend_serialize_data;
typedef struct _zend_unserialize_data zend_unserialize_data;

typedef struct _zend_function_entry
{
	const char *fname;
	zif_handler handler;
	const struct _zend_internal_arg_info *arg_info;
	uint32_t num_args;
	uint32_t flags;
} zend_function_entry;

typedef struct _zend_trait_method_reference
{
	zend_string *method_name;
	zend_string *class_name;
} zend_trait_method_reference;

typedef struct _zend_trait_precedence
{
	zend_trait_method_reference trait_method;
	uint32_t num_excludes;
	zend_string *exclude_class_names[1];
} zend_trait_precedence;

typedef struct _zend_trait_alias
{
	zend_trait_method_reference trait_method;
	zend_string *alias;
	uint32_t modifiers;
} zend_trait_alias;

typedef struct _zend_closure
{
	zend_object std;
	zend_function func;
	zval this_ptr;
	zend_class_entry *called_scope;
	zif_handler orig_internal_handler;
} zend_closure;

typedef struct _zend_class_constant
{
	zval value;
	zend_string *doc_comment;
	HashTable *attributes;
	zend_class_entry *ce;
} zend_class_constant;

struct _zend_class_entry
{
	char type;
	zend_string *name;
	/* class_entry or string depending on ZEND_ACC_LINKED */
	union
	{
		zend_class_entry *parent;
		zend_string *parent_name;
	};
	int refcount;
	uint32_t ce_flags;

	int default_properties_count;
	int default_static_members_count;
	zval *default_properties_table;
	zval *default_static_members_table;
	zval **static_members_table;
	HashTable function_table;
	HashTable properties_info;
	HashTable constants_table;

	zend_class_mutable_data **mutable_data;
	zend_inheritance_cache_entry *inheritance_cache;

	struct _zend_property_info **properties_info_table;

	zend_function *constructor;
	zend_function *destructor;
	zend_function *clone;
	zend_function *__get;
	zend_function *__set;
	zend_function *__unset;
	zend_function *__isset;
	zend_function *__call;
	zend_function *__callstatic;
	zend_function *__tostring;
	zend_function *__debugInfo;
	zend_function *__serialize;
	zend_function *__unserialize;

	/* allocated only if class implements Iterator or IteratorAggregate interface */
	zend_class_iterator_funcs *iterator_funcs_ptr;

	/* handlers */
	union
	{
		zend_object *(*create_object)(zend_class_entry *class_type);
		int (*interface_gets_implemented)(zend_class_entry *iface, zend_class_entry *class_type); /* a class implements this interface */
	};
	zend_object_iterator *(*get_iterator)(zend_class_entry *ce, zval *object, int by_ref);
	zend_function *(*get_static_method)(zend_class_entry *ce, zend_string *method);

	/* serializer callbacks */
	int (*serialize)(zval *object, unsigned char **buffer, size_t *buf_len, zend_serialize_data *data);
	int (*unserialize)(zval *object, zend_class_entry *ce, const unsigned char *buf, size_t buf_len, zend_unserialize_data *data);

	uint32_t num_interfaces;
	uint32_t num_traits;

	/* class_entry or string(s) depending on ZEND_ACC_LINKED */
	union
	{
		zend_class_entry **interfaces;
		zend_class_name *interface_names;
	};

	zend_class_name *trait_names;
	zend_trait_alias **trait_aliases;
	zend_trait_precedence **trait_precedences;
	HashTable *attributes;

	uint32_t enum_backing_type;
	HashTable *backed_enum_table;

	union
	{
		struct
		{
			zend_string *filename;
			uint32_t line_start;
			uint32_t line_end;
			zend_string *doc_comment;
		} user;
		struct
		{
			const struct _zend_function_entry *builtin_functions;
			struct _zend_module_entry *module;
		} internal;
	} info;
};

typedef struct _zend_ini_entry zend_ini_entry;
struct _zend_ini_entry
{
	zend_string *name;
	int (*on_modify)(zend_ini_entry *entry, zend_string *new_value, void *mh_arg1, void *mh_arg2, void *mh_arg3, int stage);
	void *mh_arg1;
	void *mh_arg2;
	void *mh_arg3;
	zend_string *value;
	zend_string *orig_value;
	void (*displayer)(zend_ini_entry *ini_entry, int type);

	int module_number;

	uint8_t modifiable;
	uint8_t orig_modifiable;
	uint8_t modified;
};

struct _zend_module_dep
{
	const char *name;
	const char *rel;
	const char *version;
	unsigned char type;
};

typedef struct _zend_module_dep zend_module_dep;
typedef struct _zend_module_entry zend_module_entry;
typedef int ts_rsrc_id;

struct _zend_module_entry
{
	unsigned short size;
	unsigned int zend_api;
	unsigned char zend_debug;
	unsigned char zts;
	const struct _zend_ini_entry *ini_entry;
	const struct _zend_module_dep *deps;
	const char *name;
	const struct _zend_function_entry *functions;
	zend_result (*module_startup_func)(int type, int module_number);
	zend_result (*module_shutdown_func)(int type, int module_number);
	zend_result (*request_startup_func)(int type, int module_number);
	zend_result (*request_shutdown_func)(int type, int module_number);
	void (*info_func)(zend_module_entry *zend_module);
	const char *version;
	size_t globals_size;
	ts_rsrc_id *globals_id_ptr;
	void (*globals_ctor)(void *global);
	void (*globals_dtor)(void *global);
	zend_result (*post_deactivate_func)(void);
	int module_started;
	unsigned char type;
	void *handle;
	int module_number;
	const char *build_id;
};

typedef struct _zend_stack
{
	int size, top, max;
	void *elements;
} zend_stack;

typedef struct _zend_llist_element
{
	struct _zend_llist_element *next;
	struct _zend_llist_element *prev;
	char data[1]; /* Needs to always be last in the struct */
} zend_llist_element;

typedef void (*llist_dtor_func_t)(void *);
typedef int (*llist_compare_func_t)(const zend_llist_element **, const zend_llist_element **);
typedef void (*llist_apply_with_args_func_t)(void *data, int num_args, va_list args);
typedef void (*llist_apply_with_arg_func_t)(void *data, void *arg);
typedef void (*llist_apply_func_t)(void *);

typedef struct _zend_llist
{
	zend_llist_element *head;
	zend_llist_element *tail;
	size_t count;
	size_t size;
	llist_dtor_func_t dtor;
	unsigned char persistent;
	zend_llist_element *traverse_ptr;
} zend_llist;

typedef zend_llist_element *zend_llist_position;

typedef void (*zend_ini_parser_cb_t)(zval *arg1, zval *arg2, zval *arg3, int callback_type, void *arg);
typedef struct _zend_ini_parser_param
{
	zend_ini_parser_cb_t ini_parser_cb;
	void *arg;
} zend_ini_parser_param;

typedef struct _zend_brk_cont_element
{
	int start;
	int cont;
	int brk;
	int parent;
	bool is_switch;
} zend_brk_cont_element;

/* Compilation context that is different for each op array. */
typedef struct _zend_oparray_context
{
	uint32_t opcodes_size;
	int vars_size;
	int literals_size;
	uint32_t fast_call_var;
	uint32_t try_catch_offset;
	int current_brk_cont;
	int last_brk_cont;
	zend_brk_cont_element *brk_cont_array;
	HashTable *labels;
} zend_oparray_context;

typedef struct _zend_declarables
{
	zend_long ticks;
} zend_declarables;

/* Compilation context that is different for each file, but shared between op arrays. */
typedef struct _zend_file_context
{
	zend_declarables declarables;

	zend_string *current_namespace;
	bool in_namespace;
	bool has_bracketed_namespaces;

	HashTable *imports;
	HashTable *imports_function;
	HashTable *imports_const;

	HashTable seen_symbols;
} zend_file_context;

typedef struct _zend_arena zend_arena;

struct _zend_arena
{
	char *ptr;
	char *end;
	zend_arena *prev;
};

typedef struct _zend_encoding zend_encoding;
typedef uint16_t zend_ast_kind;
typedef uint16_t zend_ast_attr;
typedef struct _zend_ast zend_ast;
extern size_t compiler_globals_offset;
typedef struct _zend_compiler_globals zend_compiler_globals;

typedef int (*compare_func_t)(const void *, const void *);
typedef void (*swap_func_t)(void *, void *);
typedef void (*sort_func_t)(void *, size_t, size_t, compare_func_t, swap_func_t);

struct _zend_ast
{
	zend_ast_kind kind;
	zend_ast_attr attr;
	uint32_t lineno;
	zend_ast *child[1];
};

/* Same as zend_ast, but with children count, which is updated dynamically */
typedef struct _zend_ast_list
{
	zend_ast_kind kind;
	zend_ast_attr attr;
	uint32_t lineno;
	uint32_t children;
	zend_ast *child[1];
} zend_ast_list;

/* Lineno is stored in val.u2.lineno */
typedef struct _zend_ast_zval
{
	zend_ast_kind kind;
	zend_ast_attr attr;
	zval val;
} zend_ast_zval;

/* Separate structure for function and class declaration, as they need extra information. */
typedef struct _zend_ast_decl
{
	zend_ast_kind kind;
	zend_ast_attr attr; /* Unused - for structure compatibility */
	uint32_t start_lineno;
	uint32_t end_lineno;
	uint32_t flags;
	unsigned char *lex_pos;
	zend_string *doc_comment;
	zend_string *name;
	zend_ast *child[5];
} zend_ast_decl;

typedef struct _zend_ast_znode
{
	zend_ast_kind kind;
	zend_ast_attr attr;
	uint32_t lineno;
	znode node;
} zend_ast_znode;

typedef struct
{
	uint32_t offset;
	uint32_t len;
} zend_lexer_ident_ref;

typedef union _zend_parser_stack_elem
{
	zend_ast *ast;
	zend_string *str;
	zend_ulong num;
	unsigned char *ptr;
	zend_lexer_ident_ref *ident;
} zend_parser_stack_elem;

/* zend_ptr_stack.h */
typedef struct _zend_ptr_stack
{
	int top, max;
	void **elements;
	void **top_element;
	bool persistent;
} zend_ptr_stack;

/* zend_multibyte.h */
typedef size_t (*zend_encoding_filter)(unsigned char **str, size_t *str_length, const unsigned char *buf, size_t length);

typedef struct _zend_encoding
{
	zend_encoding_filter input_filter;	/* escape input filter */
	zend_encoding_filter output_filter; /* escape output filter */
	const char *name;					/* encoding name */
	const char *(*aliases)[];			/* encoding name aliases */
	bool compatible;					/* flex compatible or not */
} zend_encoding;

typedef enum
{
	ON_TOKEN,
	ON_FEEDBACK,
	ON_STOP
} zend_php_scanner_event;

/* zend_language_scanner.h */
typedef struct _zend_lex_state
{
	unsigned int yy_leng;
	unsigned char *yy_start;
	unsigned char *yy_text;
	unsigned char *yy_cursor;
	unsigned char *yy_marker;
	unsigned char *yy_limit;
	int yy_state;
	zend_stack state_stack;
	zend_ptr_stack heredoc_label_stack;
	zend_stack nest_location_stack; /* for syntax error reporting */

	zend_file_handle *in;
	uint32_t lineno;
	zend_string *filename;

	/* original (unfiltered) script */
	unsigned char *script_org;
	size_t script_org_size;

	/* filtered script */
	unsigned char *script_filtered;
	size_t script_filtered_size;

	/* input/output filters */
	zend_encoding_filter input_filter;
	zend_encoding_filter output_filter;
	const zend_encoding *script_encoding;

	/* hooks */
	void (*on_event)(
		zend_php_scanner_event event, int token, int line,
		const char *text, size_t length, void *context);
	void *on_event_context;

	zend_ast *ast;
	zend_arena *ast_arena;
} zend_lex_state;

typedef void (*zend_ast_process_t)(zend_ast *ast);
extern zend_ast_process_t zend_ast_process;

struct _zend_compiler_globals
{
	zend_stack loop_var_stack;

	zend_class_entry *active_class_entry;

	zend_string *compiled_filename;

	int zend_lineno;

	zend_op_array *active_op_array;

	HashTable *function_table; /* function symbol table */
	HashTable *class_table;	   /* class table */

	HashTable *auto_globals;

	/* Refer to zend_yytnamerr() in zend_language_parser.y for meaning of values */
	zend_uchar parse_error;
	bool in_compilation;
	bool short_tags;

	bool unclean_shutdown;

	bool ini_parser_unbuffered_errors;

	zend_llist open_files;

	struct _zend_ini_parser_param *ini_parser_param;

	bool skip_shebang;
	bool increment_lineno;

	bool variable_width_locale;	  /* UTF-8, Shift-JIS, Big5, ISO 2022, EUC, etc */
	bool ascii_compatible_locale; /* locale uses ASCII characters as singletons */
								  /* and don't use them as lead/trail units     */

	zend_string *doc_comment;
	uint32_t extra_fn_flags;

	uint32_t compiler_options; /* set of ZEND_COMPILE_* constants */

	zend_oparray_context context;
	zend_file_context file_context;

	zend_arena *arena;

	HashTable interned_strings;

	const zend_encoding **script_encoding_list;
	size_t script_encoding_list_size;
	bool multibyte;
	bool detect_unicode;
	bool encoding_declared;

	zend_ast *ast;
	zend_arena *ast_arena;

	zend_stack delayed_oplines_stack;
	HashTable *memoized_exprs;
	int memoize_mode;

	void *map_ptr_real_base;
	void *map_ptr_base;
	size_t map_ptr_size;
	size_t map_ptr_last;

	HashTable *delayed_variance_obligations;
	HashTable *delayed_autoloads;
	HashTable *unlinked_uses;
	zend_class_entry *current_linking_class;

	uint32_t rtd_key_counter;

	zend_stack short_circuiting_opnums;
};

typedef struct _zend_executor_globals zend_executor_globals;

typedef long int __jmp_buf[8];

typedef struct
{
	unsigned long int __val[(1024 / (8 * sizeof(unsigned long int)))];
} __sigset_t;
typedef __sigset_t sigset_t;

struct __jmp_buf_tag
{
	__jmp_buf __jmpbuf;
	int __mask_was_saved;
	__sigset_t __saved_mask;
};

typedef struct __jmp_buf_tag jmp_buf[1];
typedef struct __jmp_buf_tag sigjmp_buf[1];
typedef struct _zend_vm_stack *zend_vm_stack;
typedef uint32_t HashPosition;

struct _zend_vm_stack
{
	zval *top;
	zval *end;
	zend_vm_stack prev;
};

typedef enum
{
	EH_NORMAL = 0,
	EH_THROW
} zend_error_handling_t;

typedef struct
{
	zend_error_handling_t handling;
	zend_class_entry *exception;
} zend_error_handling;

typedef struct _zend_objects_store
{
	zend_object **object_buckets;
	uint32_t top;
	uint32_t size;
	int free_list_head;
} zend_objects_store;

typedef struct _HashTableIterator
{
	HashTable *ht;
	HashPosition pos;
} HashTableIterator;

typedef struct
{
	zval *cur;
	zval *end;
	zval *start;
} zend_get_gc_buffer;

typedef struct _zend_fcall_info
{
	size_t size;
	zval function_name;
	zval *retval;
	zval *params;
	zend_object *object;
	uint32_t param_count;
	/* This hashtable can also contain positional arguments (with integer keys),
	 * which will be appended to the normal params[]. This makes it easier to
	 * integrate APIs like call_user_func_array(). The usual restriction that
	 * there may not be position arguments after named arguments applies. */
	HashTable *named_params;
} zend_fcall_info;

typedef struct _zend_fcall_info_cache
{
	zend_function *function_handler;
	zend_class_entry *calling_scope;
	zend_class_entry *called_scope;
	zend_object *object;
} zend_fcall_info_cache;

typedef struct _zend_fiber_context zend_fiber_context;

/* Encapsulates data needed for a context switch. */
typedef struct _zend_fiber_transfer
{
	/* Fiber that will be switched to / has resumed us. */
	zend_fiber_context *context;

	/* Value to that should be send to (or was received from) a fiber. */
	zval value;

	/* Bitmask of flags defined in enum zend_fiber_transfer_flag. */
	uint8_t flags;
} zend_fiber_transfer;

/* Coroutine functions must populate the given transfer with a new context
 * and (optional) data before they return. */
typedef void (*zend_fiber_coroutine)(zend_fiber_transfer *transfer);
typedef struct _zend_fiber_stack zend_fiber_stack;

struct _zend_fiber_stack
{
	void *pointer;
	size_t size;
};

typedef enum
{
	ZEND_FIBER_STATUS_INIT,
	ZEND_FIBER_STATUS_RUNNING,
	ZEND_FIBER_STATUS_SUSPENDED,
	ZEND_FIBER_STATUS_DEAD,
} zend_fiber_status;

typedef struct _zend_fiber zend_fiber;

struct _zend_fiber_context
{
	/* Pointer to boost.context or ucontext_t data. */
	void *handle;

	/* Pointer that identifies the fiber type. */
	void *kind;

	/* Entrypoint function of the fiber. */
	zend_fiber_coroutine function;

	/* Assigned C stack. */
	zend_fiber_stack *stack;

	/* Fiber status. */
	zend_fiber_status status;

	/* Reserved for extensions */
	void *reserved[6];
};

struct _zend_fiber
{
	/* PHP object handle. */
	zend_object std;

	/* Flags are defined in enum zend_fiber_flag. */
	uint8_t flags;

	/* Native C fiber context. */
	zend_fiber_context context;

	/* Fiber that resumed us. */
	zend_fiber_context *caller;

	/* Fiber that suspended us. */
	zend_fiber_context *previous;

	/* Callback and info / cache to be used when fiber is started. */
	zend_fcall_info fci;
	zend_fcall_info_cache fci_cache;

	/* Current Zend VM execute data being run by the fiber. */
	zend_execute_data *execute_data;

	/* Frame on the bottom of the fiber vm stack. */
	zend_execute_data *stack_bottom;

	/* Storage for fiber return value. */
	zval result;
};

typedef struct _OSVERSIONINFOEXA
{
	uint32_t dwOSVersionInfoSize;
	uint32_t dwMajorVersion;
	uint32_t dwMinorVersion;
	uint32_t dwBuildNumber;
	uint32_t dwPlatformId;
	char szCSDVersion[128];
	uint16_t wServicePackMajor;
	uint16_t wServicePackMinor;
	uint16_t wSuiteMask;
	char wProductType;
	char wReserved;
} OSVERSIONINFOEX;

struct _zend_executor_globals
{
	zval uninitialized_zval;
	zval error_zval;
	zend_array *symtable_cache[32];
	zend_array **symtable_cache_limit;
	zend_array **symtable_cache_ptr;
	zend_array symbol_table;
	HashTable included_files;
	jmp_buf *bailout;
	int error_reporting;
	int exit_status;
	HashTable *function_table;
	HashTable *class_table;
	HashTable *zend_constants;
	zval *vm_stack_top;
	zval *vm_stack_end;
	zend_vm_stack vm_stack;
	size_t vm_stack_page_size;
	struct _zend_execute_data *current_execute_data;
	zend_class_entry *fake_scope;
	uint32_t jit_trace_num;
	zend_long precision;
	int ticks_count;
	uint32_t persistent_constants_count;
	uint32_t persistent_functions_count;
	uint32_t persistent_classes_count;
	HashTable *in_autoload;
	bool full_tables_cleanup;
	bool no_extensions;
	bool vm_interrupt;
	bool timed_out;
	zend_long hard_timeout;
	OSVERSIONINFOEX windows_version_info;
	HashTable regular_list;
	HashTable persistent_list;
	int user_error_handler_error_reporting;
	zval user_error_handler;
	zval user_exception_handler;
	zend_stack user_error_handlers_error_reporting;
	zend_stack user_error_handlers;
	zend_stack user_exception_handlers;
	zend_error_handling_t error_handling;
	zend_class_entry *exception_class;
	zend_long timeout_seconds;
	int capture_warnings_during_sccp;
	HashTable *ini_directives;
	HashTable *modified_ini_directives;
	zend_ini_entry *error_reporting_ini_entry;
	zend_objects_store objects_store;
	zend_object *exception, *prev_exception;
	const zend_op *opline_before_exception;
	zend_op exception_op[3];
	struct _zend_module_entry *current_module;
	bool active;
	zend_uchar flags;
	zend_long assertions;
	uint32_t ht_iterators_count;
	uint32_t ht_iterators_used;
	HashTableIterator *ht_iterators;
	HashTableIterator ht_iterators_slots[16];
	void *saved_fpu_cw_ptr;
	zend_function trampoline;
	zend_op call_trampoline_op;
	HashTable weakrefs;
	bool exception_ignore_args;
	zend_long exception_string_param_max_len;
	zend_get_gc_buffer get_gc_buffer;

	zend_fiber_context *main_fiber_context;
	zend_fiber_context *current_fiber_context;

	/* Active instance of Fiber. */
	zend_fiber *active_fiber;

	/* Default fiber C stack size. */
	zend_long fiber_stack_size;

	/* If record_errors is enabled, all emitted diagnostics will be recorded,
	 * in addition to being processed as usual. */
	bool record_errors;
	uint32_t num_errors;
	zend_error_info **errors;

	void *reserved[6];
};

extern const zend_object_handlers std_object_handlers;
const zend_internal_function zend_pass_function;
extern HashTable module_registry;
extern int compiler_globals_id;
extern int executor_globals_id;
extern size_t compiler_globals_offset;
extern size_t executor_globals_offset;

typedef unsigned long DWORD;
typedef unsigned long int ULONG_PTR;
typedef void *PVOID;
typedef PVOID HANDLE;
typedef long LONG;
typedef unsigned short WORD;
typedef int key_t;
typedef PVOID PSID;

typedef unsigned int __uid_t;
typedef unsigned int __gid_t;
typedef __uid_t uid_t;
typedef __gid_t gid_t;
typedef unsigned char u_char;
typedef unsigned short u_short;
typedef unsigned int u_int;
typedef unsigned long u_long;
typedef signed long int __int64;
typedef __int64 UINT_PTR;
typedef __int64 __time64_t;
typedef __time64_t time_t;
typedef UINT_PTR SOCKET;
typedef SOCKET php_socket_t;
typedef php_socket_t uv_file;
typedef HANDLE uv_os_fd_t;

typedef struct _LIST_ENTRY
{
	struct _LIST_ENTRY *Flink;
	struct _LIST_ENTRY *Blink;
} LIST_ENTRY, *PLIST_ENTRY;

typedef struct _RTL_CRITICAL_SECTION_DEBUG
{
	WORD Type;
	WORD CreatorBackTraceIndex;
	struct _RTL_CRITICAL_SECTION *CriticalSection;
	LIST_ENTRY ProcessLocksList;
	DWORD EntryCount;
	DWORD ContentionCount;
	DWORD Flags;
	WORD CreatorBackTraceIndexHigh;
	WORD SpareWORD;
} RTL_CRITICAL_SECTION_DEBUG, *PRTL_CRITICAL_SECTION_DEBUG;

typedef struct _RTL_CRITICAL_SECTION
{
	PRTL_CRITICAL_SECTION_DEBUG DebugInfo;

	//
	//  The following three fields control entering and exiting the critical
	//  section for the resource
	//

	LONG LockCount;
	LONG RecursionCount;
	HANDLE OwningThread; // from the thread's ClientId->UniqueThread
	HANDLE LockSemaphore;
	ULONG_PTR SpinCount; // force size on 64-bit systems when packed
} RTL_CRITICAL_SECTION, *PRTL_CRITICAL_SECTION;

typedef RTL_CRITICAL_SECTION CRITICAL_SECTION;

typedef DWORD THREAD_T;
typedef CRITICAL_SECTION *MUTEX_T;

typedef void (*ts_allocate_ctor)(void *);
typedef void (*ts_allocate_dtor)(void *);

typedef intptr_t tsrm_intptr_t;
typedef uintptr_t tsrm_uintptr_t;

struct ipc_perm
{
	key_t key;
	unsigned short uid;
	unsigned short gid;
	unsigned short cuid;
	unsigned short cgid;
	unsigned short mode;
	unsigned short seq;
};

struct shmid_ds
{
	struct ipc_perm shm_perm;
	size_t shm_segsz;
	time_t shm_atime;
	time_t shm_dtime;
	time_t shm_ctime;
	unsigned short shm_cpid;
	unsigned short shm_lpid;
	short shm_nattch;
};

typedef struct
{
	FILE *stream;
	HANDLE prochnd;
} process_pair;

typedef struct
{
	void *addr;
	HANDLE info;
	HANDLE segment;
	struct shmid_ds *descriptor;
} shm_pair;

typedef struct
{
	process_pair *process;
	shm_pair *shm;
	int process_size;
	int shm_size;
	char *comspec;
	HANDLE impersonation_token;
	PSID impersonation_token_sid;
} tsrm_win32_globals;

/* startup/shutdown */
int tsrm_startup(int expected_threads, int expected_resources, int debug_level, char *debug_filename);
void tsrm_shutdown(void);
int php_tsrm_startup(void);

void tsrm_win32_startup(void);
void tsrm_win32_shutdown(void);

/* environ lock API */
void tsrm_env_lock(void);
void tsrm_env_unlock(void);

/* allocates a new thread-safe-resource id */
ts_rsrc_id ts_allocate_id(ts_rsrc_id *rsrc_id, size_t size, ts_allocate_ctor ctor, ts_allocate_dtor dtor);

/* Fast resource in reserved (pre-allocated) space */
void tsrm_reserve(size_t size);
ts_rsrc_id ts_allocate_fast_id(ts_rsrc_id *rsrc_id, size_t *offset, size_t size, ts_allocate_ctor ctor, ts_allocate_dtor dtor);

/* fetches the requested resource for the current thread */
void *ts_resource_ex(ts_rsrc_id id, THREAD_T *th_id);
// #define ts_resource(id) ts_resource_ex(id, NULL)

/* frees all resources allocated for the current thread */
void ts_free_thread(void);

/* deallocates all occurrences of a given id */
void ts_free_id(ts_rsrc_id id);

/* Debug support */
// #define TSRM_ERROR_LEVEL_ERROR 1
// #define TSRM_ERROR_LEVEL_CORE 2
// #define TSRM_ERROR_LEVEL_INFO 3

typedef void (*tsrm_thread_begin_func_t)(THREAD_T thread_id);
typedef void (*tsrm_thread_end_func_t)(THREAD_T thread_id);
typedef void (*tsrm_shutdown_func_t)(void);

/* Debug support */
void tsrm_error_set(int level, char *debug_filename);

/* utility functions */
THREAD_T tsrm_thread_id(void);
MUTEX_T tsrm_mutex_alloc(void);
void tsrm_mutex_free(MUTEX_T mutexp);
int tsrm_mutex_lock(MUTEX_T mutexp);
int tsrm_mutex_unlock(MUTEX_T mutexp);

void *tsrm_set_new_thread_begin_handler(tsrm_thread_begin_func_t new_thread_begin_handler);
void *tsrm_set_new_thread_end_handler(tsrm_thread_end_func_t new_thread_end_handler);
void *tsrm_set_shutdown_handler(tsrm_shutdown_func_t shutdown_handler);

void *tsrm_get_ls_cache(void);
uint8_t tsrm_is_main_thread(void);
uint8_t tsrm_is_shutdown(void);
const char *tsrm_api_name(void);

typedef struct _tsrm_tls_entry tsrm_tls_entry;

struct _tsrm_tls_entry
{
	void **storage;
	int count;
	THREAD_T thread_id;
	tsrm_tls_entry *next;
};

typedef struct
{
	size_t size;
	ts_allocate_ctor ctor;
	ts_allocate_dtor dtor;
	size_t fast_offset;
	int done;
} tsrm_resource_type;

typedef int (*user_opcode_handler_t)(zend_execute_data *execute_data);
typedef void (*opcode_handler_t)(void);

zend_result zend_parse_parameters(uint32_t num_args, const char *type_spec, ...);
void zend_set_function_arg_flags(zend_function *func);
zend_result zend_register_functions(zend_class_entry *scope, const zend_function_entry *functions, HashTable *function_table, int type);
void zend_unregister_functions(const zend_function_entry *functions, int count, HashTable *function_table);

int zend_register_list_destructors_ex(rsrc_dtor_func_t ld, rsrc_dtor_func_t pld, const char *type_name, int module_number);
zend_resource *zend_register_resource(void *rsrc_pointer, int rsrc_type);

void *zend_fetch_resource(zend_resource *res, const char *resource_type_name, int resource_type);
void *zend_fetch_resource2(zend_resource *res, const char *resource_type_name, int resource_type, int resource_type2);
void *zend_fetch_resource_ex(zval *res, const char *resource_type_name, int resource_type);
void *zend_fetch_resource2_ex(zval *res, const char *resource_type_name, int resource_type, int resource_type2);

__declspec(dllimport) HashTable *__vectorcall _zend_new_array(uint32_t size);
__declspec(dllimport) uint32_t zend_array_count(HashTable *ht);
__declspec(dllimport) HashTable *__vectorcall zend_new_pair(zval *val1, zval *val2);
void add_assoc_long_ex(zval *arg, const char *key, size_t key_len, zend_long n);
void add_assoc_null_ex(zval *arg, const char *key, size_t key_len);
void add_assoc_bool_ex(zval *arg, const char *key, size_t key_len, bool b);
void add_assoc_resource_ex(zval *arg, const char *key, size_t key_len, zend_resource *r);
void add_assoc_double_ex(zval *arg, const char *key, size_t key_len, double d);
void add_assoc_str_ex(zval *arg, const char *key, size_t key_len, zend_string *str);
void add_assoc_string_ex(zval *arg, const char *key, size_t key_len, const char *str);
void add_assoc_stringl_ex(zval *arg, const char *key, size_t key_len, const char *str, size_t length);
void add_assoc_zval_ex(zval *arg, const char *key, size_t key_len, zval *value);
zend_result add_next_index_string(zval *arg, const char *str);

__declspec(dllimport) zend_result __vectorcall zend_hash_del(HashTable *ht, zend_string *key);
__declspec(dllimport) zend_result __vectorcall zend_hash_del_ind(HashTable *ht, zend_string *key);
__declspec(dllimport) zend_result __vectorcall zend_hash_rehash(HashTable *ht);
__declspec(dllimport) zval *__vectorcall zend_hash_find(const HashTable *ht, zend_string *key);
__declspec(dllimport) zval *__vectorcall zend_hash_str_find(const HashTable *ht, const char *key, size_t len);
__declspec(dllimport) zval *__vectorcall zend_hash_add_or_update(HashTable *ht, zend_string *key, zval *pData, uint32_t flag);
__declspec(dllimport) zval *__vectorcall zend_hash_next_index_insert(HashTable *ht, zval *pData);

typedef void (*copy_ctor_func_t)(zval *pElement);
__declspec(dllimport) void __vectorcall zend_hash_copy(HashTable *target, HashTable *source, copy_ctor_func_t pCopyConstructor);
__declspec(dllimport) void __vectorcall zend_hash_destroy(HashTable *ht);
__declspec(dllimport) void __vectorcall zend_hash_clean(HashTable *ht);

int zend_set_user_opcode_handler(zend_uchar opcode, user_opcode_handler_t handler);
user_opcode_handler_t zend_get_user_opcode_handler(zend_uchar opcode);

void zval_ptr_dtor(zval *zval_ptr);
void zval_internal_ptr_dtor(zval *zvalue);
void zval_add_ref(zval *p);
zval *zend_get_zval_ptr(const zend_op *opline, int op_type, const znode_op *node, const zend_execute_data *execute_data);

zend_uchar zend_get_call_op(const zend_op *init_op, zend_function *fbc);
void object_init(zval *arg);
zend_result object_init_ex(zval *arg, zend_class_entry *ce);

typedef struct _php_stream php_stream;
php_stream *_php_stream_fopen_from_fd(int fd, const char *mode, const char *persistent_id, ...);

typedef struct _php_stream_wrapper php_stream_wrapper;
typedef struct _php_stream_context php_stream_context;
typedef struct stat zend_stat_t;
typedef unsigned long int __dev_t;
typedef unsigned int __uid_t;
typedef unsigned int __gid_t;
typedef unsigned long int __ino_t;
typedef unsigned long int __ino64_t;
typedef long int __time_t;
typedef unsigned int __mode_t;
typedef unsigned long int __nlink_t;
typedef long int __blksize_t;
typedef long int __blkcnt_t;
typedef long int __syscall_slong_t;
struct timespec
{
	__time_t tv_sec;
	__syscall_slong_t tv_nsec;
};
struct stat
{
	__dev_t st_dev;
	__ino_t st_ino;
	__nlink_t st_nlink;
	__mode_t st_mode;
	__uid_t st_uid;
	__gid_t st_gid;
	int __pad0;
	__dev_t st_rdev;
	__off_t st_size;
	__blksize_t st_blksize;
	__blkcnt_t st_blocks;
	struct timespec st_atim;
	struct timespec st_mtim;
	struct timespec st_ctim;
	__syscall_slong_t __glibc_reserved[3];
};

typedef struct _php_stream_notifier php_stream_notifier;
/* callback for status notifications */
typedef void (*php_stream_notification_func)(php_stream_context *context,
											 int notifycode, int severity,
											 char *xmsg, int xcode,
											 size_t bytes_sofar, size_t bytes_max,
											 void *ptr);

struct _php_stream_notifier
{
	php_stream_notification_func func;
	void (*dtor)(php_stream_notifier *notifier);
	zval ptr;
	int mask;
	size_t progress, progress_max; /* position for progress notification */
};

struct _php_stream_context
{
	php_stream_notifier *notifier;
	zval options;		/* hash keyed by wrapper family or specific wrapper */
	zend_resource *res; /* used for auto-cleanup */
};

typedef struct _php_stream_statbuf
{
	zend_stat_t sb; /* regular info */
					/* extended info to go here some day: content-type etc. etc. */
} php_stream_statbuf;

/* operations on streams that are file-handles */
typedef struct _php_stream_ops
{
	/* stdio like functions - these are mandatory! */
	ssize_t (*write)(php_stream *stream, const char *buf, size_t count);
	ssize_t (*read)(php_stream *stream, char *buf, size_t count);
	int (*close)(php_stream *stream, int close_handle);
	int (*flush)(php_stream *stream);

	const char *label; /* label for this ops structure */

	/* these are optional */
	int (*seek)(php_stream *stream, zend_off_t offset, int whence, zend_off_t *newoffset);
	int (*cast)(php_stream *stream, int castas, void **ret);
	int (*stat)(php_stream *stream, php_stream_statbuf *ssb);
	int (*set_option)(php_stream *stream, int option, int value, void *ptrparam);
} php_stream_ops;

typedef struct _php_stream_wrapper_ops
{
	/* open/create a wrapped stream */
	php_stream *(*stream_opener)(php_stream_wrapper *wrapper, const char *filename, const char *mode,
								 int options, zend_string **opened_path, php_stream_context *context, int __php_stream_call_depth, const char *__zend_filename, const uint32_t __zend_lineno, const char *__zend_filename, const uint32_t __zend_lineno);
	/* close/destroy a wrapped stream */
	int (*stream_closer)(php_stream_wrapper *wrapper, php_stream *stream);
	/* stat a wrapped stream */
	int (*stream_stat)(php_stream_wrapper *wrapper, php_stream *stream, php_stream_statbuf *ssb);
	/* stat a URL */
	int (*url_stat)(php_stream_wrapper *wrapper, const char *url, int flags, php_stream_statbuf *ssb, php_stream_context *context);
	/* open a "directory" stream */
	php_stream *(*dir_opener)(php_stream_wrapper *wrapper, const char *filename, const char *mode,
							  int options, zend_string **opened_path, php_stream_context *context, int __php_stream_call_depth, const char *__zend_filename, const uint32_t __zend_lineno, const char *__zend_filename, const uint32_t __zend_lineno);

	const char *label;

	/* delete a file */
	int (*unlink)(php_stream_wrapper *wrapper, const char *url, int options, php_stream_context *context);

	/* rename a file */
	int (*rename)(php_stream_wrapper *wrapper, const char *url_from, const char *url_to, int options, php_stream_context *context);

	/* Create/Remove directory */
	int (*stream_mkdir)(php_stream_wrapper *wrapper, const char *url, int mode, int options, php_stream_context *context);
	int (*stream_rmdir)(php_stream_wrapper *wrapper, const char *url, int options, php_stream_context *context);
	/* Metadata handling */
	int (*stream_metadata)(php_stream_wrapper *wrapper, const char *url, int options, void *value, php_stream_context *context);
} php_stream_wrapper_ops;

struct _php_stream_wrapper
{
	const php_stream_wrapper_ops *wops; /* operations the wrapper can perform */
	void *abstract;						/* context for the wrapper */
	int is_url;							/* so that PG(allow_url_fopen) can be respected */
};

typedef struct _php_stream_filter php_stream_filter;
typedef struct _php_stream_bucket php_stream_bucket;
typedef struct _php_stream_bucket_brigade php_stream_bucket_brigade;

struct _php_stream_bucket
{
	php_stream_bucket *next, *prev;
	php_stream_bucket_brigade *brigade;

	char *buf;
	size_t buflen;
	/* if non-zero, buf should be pefreed when the bucket is destroyed */
	uint8_t own_buf;
	uint8_t is_persistent;

	/* destroy this struct when refcount falls to zero */
	int refcount;
};

struct _php_stream_bucket_brigade
{
	php_stream_bucket *head, *tail;
};

typedef enum
{
	PSFS_ERR_FATAL, /* error in data stream */
	PSFS_FEED_ME,	/* filter needs more data; stop processing chain until more is available */
	PSFS_PASS_ON	/* filter generated output buckets; pass them on to next in chain */
} php_stream_filter_status_t;

typedef struct _php_stream_filter_ops
{

	php_stream_filter_status_t (*filter)(
		php_stream *stream,
		php_stream_filter *thisfilter,
		php_stream_bucket_brigade *buckets_in,
		php_stream_bucket_brigade *buckets_out,
		size_t *bytes_consumed,
		int flags);

	void (*dtor)(php_stream_filter *thisfilter);

	const char *label;

} php_stream_filter_ops;

typedef struct _php_stream_filter_chain
{
	php_stream_filter *head, *tail;

	/* Owning stream */
	php_stream *stream;
} php_stream_filter_chain;

struct _php_stream_filter
{
	const php_stream_filter_ops *fops;
	zval abstract; /* for use by filter implementation */
	php_stream_filter *next;
	php_stream_filter *prev;
	int is_persistent;

	/* link into stream and chain */
	php_stream_filter_chain *chain;

	/* buffered buckets */
	php_stream_bucket_brigade buffer;

	/* filters are auto_registered when they're applied */
	zend_resource *res;
};

struct _php_stream
{
	const php_stream_ops *ops;
	void *abstract; /* convenience pointer for abstraction */

	php_stream_filter_chain readfilters, writefilters;

	php_stream_wrapper *wrapper; /* which wrapper was used to open the stream */
	void *wrapperthis;			 /* convenience pointer for a instance of a wrapper */
	zval wrapperdata;			 /* fgetwrapperdata retrieves this */

	uint8_t is_persistent : 1;
	uint8_t in_free : 2; /* to prevent recursion during free */
	uint8_t eof : 1;
	uint8_t __exposed : 1; /* non-zero if exposed as a zval somewhere */

	/* so we know how to clean it up correctly.  This should be set to
	 * PHP_STREAM_FCLOSE_XXX as appropriate */
	uint8_t fclose_stdiocast : 2;

	char mode[16]; /* "rwb" etc. ala stdio */

	uint32_t flags; /* PHP_STREAM_FLAG_XXX */

	zend_resource *res; /* used for auto-cleanup */
	FILE *stdiocast;	/* cache this, otherwise we might leak! */
	char *orig_path;

	zend_resource *ctx;

	/* buffer */
	zend_off_t position; /* of underlying stream */
	unsigned char *readbuf;
	size_t readbuflen;
	zend_off_t readpos;
	zend_off_t writepos;

	/* how much data to read when filling buffer */
	size_t chunk_size;

	struct _php_stream *enclosing_stream; /* this is a private stream owned by enclosing_stream */
};										  /* php_stream */

int php_file_le_stream(void);
int php_file_le_pstream(void);
int php_file_le_stream_filter(void);
int _php_stream_cast(php_stream *stream, int castas, void **ret, int show_err);

__declspec(dllimport) HashTable *__vectorcall _zend_new_array(uint32_t size);
__declspec(dllimport) uint32_t zend_array_count(HashTable *ht);
__declspec(dllimport) HashTable *__vectorcall zend_new_pair(zval *val1, zval *val2);
void add_assoc_long_ex(zval *arg, const char *key, size_t key_len, zend_long n);
void add_assoc_null_ex(zval *arg, const char *key, size_t key_len);
void add_assoc_bool_ex(zval *arg, const char *key, size_t key_len, bool b);
void add_assoc_resource_ex(zval *arg, const char *key, size_t key_len, zend_resource *r);
void add_assoc_double_ex(zval *arg, const char *key, size_t key_len, double d);
void add_assoc_str_ex(zval *arg, const char *key, size_t key_len, zend_string *str);
void add_assoc_string_ex(zval *arg, const char *key, size_t key_len, const char *str);
void add_assoc_stringl_ex(zval *arg, const char *key, size_t key_len, const char *str, size_t length);
void add_assoc_zval_ex(zval *arg, const char *key, size_t key_len, zval *value);
zend_result add_next_index_string(zval *arg, const char *str);

__declspec(dllimport) void __vectorcall zend_object_std_init(zend_object *object, zend_class_entry *ce);
__declspec(dllimport) zend_object *__vectorcall zend_objects_new(zend_class_entry *ce);
__declspec(dllimport) void __vectorcall zend_objects_clone_members(zend_object *new_object, zend_object *old_object);

__declspec(dllimport) void object_properties_init(zend_object *object, zend_class_entry *class_type);
__declspec(dllimport) void zend_object_std_dtor(zend_object *object);
__declspec(dllimport) void zend_objects_destroy_object(zend_object *object);
__declspec(dllimport) zend_object *zend_objects_clone_obj(zval *object);

void zend_do_inheritance_ex(zend_class_entry *ce, zend_class_entry *parent_ce, bool checked);
/* PHPAPI void php_error(int type, const char *format, ...); */
void php_error_docref(const char *docref, int type, const char *format, ...);
__declspec(dllimport) void zend_error(int type, const char *format, ...);

/**
 * Language scanner API
 */
void zend_save_lexical_state(zend_lex_state *lex_state);
void zend_restore_lexical_state(zend_lex_state *lex_state);
void zend_prepare_string_for_scanning(zval *str, zend_string *filename);
zend_result zend_lex_tstring(zval *zv, zend_lexer_ident_ref ident_ref);

/**
 * Abstract Syntax Tree (AST) API
 */
int zendparse(void);
void __vectorcall zend_ast_destroy(zend_ast *ast);
zend_ast *__vectorcall zend_ast_create_list_0(zend_ast_kind kind);
zend_ast *__vectorcall zend_ast_create_list_1(zend_ast_kind kind, zend_ast *child);
zend_ast *__vectorcall zend_ast_create_list_2(zend_ast_kind kind, zend_ast *child1, zend_ast *child2);

zend_ast *__vectorcall zend_ast_list_add(zend_ast *list, zend_ast *op);
zend_ast *__vectorcall zend_ast_create_zval_ex(zval *zv, zend_ast_attr attr);
zend_ast *__vectorcall zend_ast_create_0(zend_ast_kind kind);
zend_ast *__vectorcall zend_ast_create_1(zend_ast_kind kind, zend_ast *child);
zend_ast *__vectorcall zend_ast_create_2(zend_ast_kind kind, zend_ast *child1, zend_ast *child2);
zend_ast *__vectorcall zend_ast_create_3(zend_ast_kind kind, zend_ast *child1, zend_ast *child2, zend_ast *child3);
zend_ast *__vectorcall zend_ast_create_4(zend_ast_kind kind, zend_ast *child1, zend_ast *child2, zend_ast *child3, zend_ast *child4);
zend_ast *__vectorcall zend_ast_create_5(zend_ast_kind kind, zend_ast *child1, zend_ast *child2, zend_ast *child3, zend_ast *child4, zend_ast *child5);
zend_ast *zend_ast_create_decl(
	zend_ast_kind kind, uint32_t flags, uint32_t start_lineno, zend_string *doc_comment,
	zend_string *name, zend_ast *child0, zend_ast *child1, zend_ast *child2, zend_ast *child3, zend_ast *child4);

typedef struct _php_socket
{
	php_socket_t bsd_socket;
	int type;
	int error;
	int blocking;
	zval zstream;
	zend_object std;
} php_socket;

typedef signed int __int32_t;
typedef __int32_t int32_t;

int _php_stream_free(php_stream *stream, int close_options);
php_stream *_php_stream_fopen_tmpfile(int dummy);
php_stream *_php_stream_fopen_from_pipe(FILE *file, const char *mode, ...);
php_stream *_php_stream_open_wrapper_ex(const char *path, const char *mode, int options, zend_string **opened_path, php_stream_context *context, ...);
ssize_t _php_stream_read(php_stream *stream, char *buf, size_t count);
ssize_t _php_stream_write(php_stream *stream, const char *buf, size_t count);
php_stream *_php_stream_fopen(const char *filename, const char *mode, zend_string **opened_path, int options, ...);
FILE *_php_stream_open_wrapper_as_file(char *path, char *mode, int options, zend_string **opened_path, ...);
ssize_t _php_stream_printf(php_stream *stream, const char *fmt, ...);
int _php_stream_set_option(php_stream *stream, int option, int value, void *ptrparam);

typedef struct fd_set
{
	u_int fd_count;		 /* how many are SET? */
	SOCKET fd_array[64]; /* an array of SOCKETs */
} fd_set;

int php_select(php_socket_t max_fd, fd_set *rfds, fd_set *wfds, fd_set *efds, struct timeval *tv);

extern php_stream_ops php_stream_stdio_ops;
extern php_stream_wrapper php_plain_files_wrapper;
typedef struct _sapi_module_struct sapi_module_struct;
extern sapi_module_struct sapi_module; /* true global */

typedef struct
{
	char *header;
	size_t header_len;
} sapi_header_struct;

typedef struct
{
	zend_llist headers;
	int http_response_code;
	unsigned char send_default_content_type;
	char *mimetype;
	char *http_status_line;
} sapi_headers_struct;

typedef enum
{						  /* Parameter: 			*/
  SAPI_HEADER_REPLACE,	  /* sapi_header_line* 	*/
  SAPI_HEADER_ADD,		  /* sapi_header_line* 	*/
  SAPI_HEADER_DELETE,	  /* sapi_header_line* 	*/
  SAPI_HEADER_DELETE_ALL, /* void					*/
  SAPI_HEADER_SET_STATUS  /* int 					*/
} sapi_header_op_enum;

struct _sapi_module_struct
{
	char *name;
	char *pretty_name;

	int (*startup)(struct _sapi_module_struct *sapi_module);
	int (*shutdown)(struct _sapi_module_struct *sapi_module);

	int (*activate)(void);
	int (*deactivate)(void);

	size_t (*ub_write)(const char *str, size_t str_length);
	void (*flush)(void *server_context);
	zend_stat_t *(*get_stat)(void);
	char *(*getenv)(const char *name, size_t name_len);

	void (*sapi_error)(int type, const char *error_msg, ...);

	int (*header_handler)(sapi_header_struct *sapi_header, sapi_header_op_enum op, sapi_headers_struct *sapi_headers);
	int (*send_headers)(sapi_headers_struct *sapi_headers);
	void (*send_header)(sapi_header_struct *sapi_header, void *server_context);

	size_t (*read_post)(char *buffer, size_t count_bytes);
	char *(*read_cookies)(void);

	void (*register_server_variables)(zval *track_vars_array);
	void (*log_message)(const char *message, int syslog_type_int);
	double (*get_request_time)(void);
	void (*terminate_process)(void);

	char *php_ini_path_override;

	void (*default_post_reader)(void);
	void (*treat_data)(int arg, char *str, zval *destArray);
	char *executable_location;

	int php_ini_ignore;
	int php_ini_ignore_cwd; /* don't look for php.ini in the current directory */

	int (*get_fd)(int *fd);

	int (*force_http_10)(void);

	int (*get_target_uid)(uid_t *);
	int (*get_target_gid)(gid_t *);

	unsigned int (*input_filter)(int arg, const char *var, char **val, size_t val_len, size_t *new_val_len);

	void (*ini_defaults)(HashTable *configuration_hash);
	int phpinfo_as_text;

	char *ini_entries;
	const zend_function_entry *additional_functions;
	unsigned int (*input_filter_init)(void);
};

typedef struct _sapi_post_entry sapi_post_entry;
struct _sapi_post_entry
{
	char *content_type;
	uint32_t content_type_len;
	void (*post_reader)(void);
	void (*post_handler)(char *content_type_dup, void *arg);
};

typedef struct
{
	const char *request_method;
	char *query_string;
	char *cookie_data;
	zend_long content_length;

	char *path_translated;
	char *request_uri;

	/* Do not use request_body directly, but the php://input stream wrapper instead */
	struct _php_stream *request_body;

	const char *content_type;

	bool headers_only;
	bool no_headers;
	bool headers_read;

	sapi_post_entry *post_entry;

	char *content_type_dup;

	/* for HTTP authentication */
	char *auth_user;
	char *auth_password;
	char *auth_digest;

	/* this is necessary for the CGI SAPI module */
	char *argv0;

	char *current_user;
	int current_user_length;

	/* this is necessary for CLI module */
	int argc;
	char **argv;
	int proto_num;
} sapi_request_info;

typedef struct _sapi_globals_struct
{
	void *server_context;
	sapi_request_info request_info;
	sapi_headers_struct sapi_headers;
	int64_t read_post_bytes;
	unsigned char post_read;
	unsigned char headers_sent;
	zend_stat_t global_stat;
	char *default_mimetype;
	char *default_charset;
	HashTable *rfc1867_uploaded_files;
	zend_long post_max_size;
	int options;
	bool sapi_started;
	double global_request_time;
	HashTable known_post_content_types;
	zval callback_func;
	zend_fcall_info_cache fci_cache;
} sapi_globals_struct;

extern int sapi_globals_id;
extern size_t sapi_globals_offset;
extern const zend_fcall_info empty_fcall_info;
extern const zend_fcall_info_cache empty_fcall_info_cache;
int zend_alter_ini_entry(zend_string *name, zend_string *new_value, int modify_type, int stage);

zend_result zend_startup_module(zend_module_entry *module_entry);
zend_module_entry *zend_register_internal_module(zend_module_entry *module_entry);
zend_module_entry *zend_register_module_ex(zend_module_entry *module);
zend_result zend_startup_module_ex(zend_module_entry *module);

size_t php_printf(const char *format, ...);
void php_info_print_table_start(void);
void php_info_print_table_header(int num_cols, ...);
void php_info_print_table_row(int num_cols, ...);
void php_info_print_table_end(void);
int php_request_startup(void);
int php_execute_script(zend_file_handle *primary_file);
int php_execute_simple_script(zend_file_handle *primary_file, zval *ret);
int zend_execute_scripts(int type, zval *retval, int file_count, ...);
void php_request_shutdown(void *dummy);

int ap_php_slprintf(char *buf, size_t len, const char *format, ...);
int ap_php_vslprintf(char *buf, size_t len, const char *format, va_list ap);
int ap_php_snprintf(char *, size_t, const char *, ...);
int ap_php_vsnprintf(char *, size_t, const char *, va_list ap);
int ap_php_vasprintf(char **buf, const char *format, va_list ap);
int ap_php_asprintf(char **buf, const char *format, ...);

typedef struct _php_core_globals php_core_globals;
extern int core_globals_id;
extern size_t core_globals_offset;

typedef struct _arg_separators
{
	char *output;
	char *input;
} arg_separators;

struct _php_core_globals
{
	bool implicit_flush;

	zend_long output_buffering;

	bool enable_dl;

	char *output_handler;

	char *unserialize_callback_func;
	zend_long serialize_precision;

	zend_long memory_limit;
	zend_long max_input_time;

	bool track_errors;
	bool display_errors;
	bool display_startup_errors;
	bool log_errors;
	zend_long log_errors_max_len;
	bool ignore_repeated_errors;
	bool ignore_repeated_source;
	bool report_memleaks;
	char *error_log;

	char *doc_root;
	char *user_dir;
	char *include_path;
	char *open_basedir;
	char *extension_dir;
	char *php_binary;
	char *sys_temp_dir;

	char *upload_tmp_dir;
	zend_long upload_max_filesize;

	char *error_append_string;
	char *error_prepend_string;

	char *auto_prepend_file;
	char *auto_append_file;

	char *input_encoding;
	char *internal_encoding;
	char *output_encoding;

	arg_separators arg_separator;

	char *variables_order;

	HashTable rfc1867_protected_variables;

	short connection_status;
	bool ignore_user_abort;

	unsigned char header_is_being_sent;

	zend_llist tick_functions;

	zval http_globals[6];

	bool expose_php;

	bool register_argc_argv;
	bool auto_globals_jit;

	char *docref_root;
	char *docref_ext;

	bool html_errors;
	bool xmlrpc_errors;

	zend_long xmlrpc_error_number;

	bool activated_auto_globals[8];

	bool modules_activated;
	bool file_uploads;
	bool during_request_startup;
	bool allow_url_fopen;
	bool enable_post_data_reading;
	bool report_zend_debug;

	int last_error_type;
	char *last_error_message;
	char *last_error_file;
	int last_error_lineno;

	char *php_sys_temp_dir;

	char *disable_functions;
	char *disable_classes;
	bool allow_url_include;
	bool com_initialized;
	zend_long max_input_nesting_level;
	zend_long max_input_vars;
	bool in_user_include;

	char *user_ini_filename;
	zend_long user_ini_cache_ttl;

	char *request_order;

	bool mail_x_header;
	char *mail_log;

	bool in_error_log;

	bool windows_show_crt_warning;

	zend_long syslog_facility;
	char *syslog_ident;
	bool have_called_openlog;
	zend_long syslog_filter;
};

void zend_activate(void);
void zend_deactivate(void);
void zend_call_destructors(void);
void zend_activate_modules(void);
void zend_deactivate_modules(void);
void zend_post_deactivate_modules(void);

void sapi_startup(sapi_module_struct *sf);
void sapi_shutdown(void);
void sapi_activate(void);
void sapi_deactivate(void);
void sapi_initialize_empty_request(void);
void sapi_add_request_header(char *var, unsigned int var_len, char *val, unsigned int val_len, void *arg);
void sapi_terminate_process(void);

void zend_stream_init_filename(zend_file_handle *handle, const char *filename);

/** Build zend_call_info/cache from a zval*
 *
 * Caller is responsible to provide a return value (fci->retval), otherwise the we will crash.
 * In order to pass parameters the following members need to be set:
 * fci->param_count = 0;
 * fci->params = NULL;
 * The callable_name argument may be NULL.
 * Set check_flags to IS_CALLABLE_STRICT for every new usage!
 */
int zend_fcall_info_init(zval *callable, uint32_t check_flags, zend_fcall_info *fci, zend_fcall_info_cache *fcc, zend_string **callable_name, char **error);

/** Call a function using information created by zend_fcall_info_init()/args().
 * If args is given then those replace the argument info in fci is temporarily.
 */
int zend_fcall_info_call(zend_fcall_info *fci, zend_fcall_info_cache *fcc, zval *retval, zval *args);

int zend_call_function(zend_fcall_info *fci, zend_fcall_info_cache *fci_cache);

void zend_release_fcall_info_cache(zend_fcall_info_cache *fcc);
zend_string *zend_get_callable_name_ex(zval *callable, zend_object *object);
zend_string *zend_get_callable_name(zval *callable);

int sapi_flush(void);
/*
#define php_output_tearup() \
	php_output_startup();   \
	php_output_activate()
#define php_output_teardown() \
	php_output_end_all();     \
	php_output_deactivate();  \
	php_output_shutdown()
*/

/* MINIT */
void php_output_startup(void);
/* RINIT */
int php_output_activate(void);

void php_output_end_all(void);
/* RSHUTDOWN */
void php_output_deactivate(void);
/* MSHUTDOWN */
void php_output_shutdown(void);

int php_module_startup(sapi_module_struct *sf, zend_module_entry *additional_modules, uint32_t num_additional_modules);
void php_module_shutdown(void);
int php_module_shutdown_wrapper(sapi_module_struct *sapi_globals);
int zend_ini_global_shutdown(void);

typedef struct
{
	zend_string *s;
	size_t a;
} smart_str;

typedef struct
{
	/* Used by the mainloop of the scanner */
	smart_str tag; /* read only */
	smart_str arg; /* read only */
	smart_str val; /* read only */
	smart_str buf;

	/* The result buffer */
	smart_str result;

	/* The data which is appended to each relative URL/FORM */
	smart_str form_app, url_app;

	int active;

	char *lookup_data;
	int state;

	int type;
	smart_str attr_val;
	int tag_type;
	int attr_type;

	/* Everything above is zeroed in RINIT */
	HashTable *tags;
} url_adapt_state_ex_t;

typedef struct _php_basic_globals
{
	HashTable *user_shutdown_function_names;
	HashTable putenv_ht;
	zval strtok_zval;
	char *strtok_string;
	zend_string *locale_string; /* current LC_CTYPE locale (or NULL for 'C') */
	bool locale_changed;		/* locale was changed and has to be restored */
	char *strtok_last;
	char strtok_table[256];
	zend_ulong strtok_len;
	char str_ebuf[40];
	zend_fcall_info array_walk_fci;
	zend_fcall_info_cache array_walk_fci_cache;
	zend_fcall_info user_compare_fci;
	zend_fcall_info_cache user_compare_fci_cache;
	zend_llist *user_tick_functions;

	zval active_ini_file_section;

	/* pageinfo.c */
	zend_long page_uid;
	zend_long page_gid;
	zend_long page_inode;
	time_t page_mtime;

	/* filestat.c && main/streams/streams.c */
	char *CurrentStatFile, *CurrentLStatFile;
	php_stream_statbuf ssb, lssb;

	/* mt_rand.c */
	uint32_t state[625]; /* state vector + 1 extra to not violate ANSI C */
	uint32_t *next;		 /* next random value is computed from here */
	int left;			 /* can *next++ this many times before reloading */

	bool mt_rand_is_seeded; /* Whether mt_rand() has been seeded */
	zend_long mt_rand_mode;

	/* syslog.c */
	char *syslog_device;

	/* var.c */
	zend_class_entry *incomplete_class;
	unsigned serialize_lock; /* whether to use the locally supplied var_hash instead (__sleep/__wakeup) */
	struct
	{
		struct php_serialize_data *data;
		unsigned level;
	} serialize;
	struct
	{
		struct php_unserialize_data *data;
		unsigned level;
	} unserialize;

	/* url_scanner_ex.re */
	url_adapt_state_ex_t url_adapt_session_ex;
	HashTable url_adapt_session_hosts_ht;
	url_adapt_state_ex_t url_adapt_output_ex;
	HashTable url_adapt_output_hosts_ht;
	HashTable *user_filter_map;
	int umask;
	zend_long unserialize_max_depth;
} php_basic_globals;

extern int basic_globals_id;

typedef enum __ptw32_robust_state_t_ __ptw32_robust_state_t;
typedef struct __ptw32_robust_node_t_ __ptw32_robust_node_t;
typedef struct __ptw32_mcs_node_t_ *__ptw32_mcs_lock_t;
typedef struct __ptw32_handle_t pthread_t;
typedef struct pthread_cond_t_ *pthread_cond_t;
typedef struct pthread_mutex_t_ *pthread_mutex_t;
typedef struct sem_t_ *sem_t;

struct __ptw32_mcs_node_t_
{
	struct __ptw32_mcs_node_t_ **lock; /* ptr to tail of queue */
	struct __ptw32_mcs_node_t_ *next;  /* ptr to successor in queue */
	HANDLE readyFlag;				   /* set after lock is released by
										  predecessor */
	HANDLE nextFlag;				   /* set after 'next' ptr is set by
										  successor */
};

typedef struct __ptw32_handle_t
{
	void *p;

	size_t x;
};

struct sem_t_
{
	int value;
	__ptw32_mcs_lock_t lock;
	HANDLE sem;
	int leftToUnblock;
};

enum __ptw32_robust_state_t_
{
	__PTW32_ROBUST_CONSISTENT,
	__PTW32_ROBUST_INCONSISTENT,
	__PTW32_ROBUST_NOTRECOVERABLE
};

/*
 * Node used to manage per-thread lists of currently-held robust mutexes.
 */
struct __ptw32_robust_node_t_
{
	pthread_mutex_t mx;
	__ptw32_robust_state_t stateInconsistent;
	__ptw32_robust_node_t *prev;
	__ptw32_robust_node_t *next;
};

struct pthread_mutex_t_
{
	LONG lock_idx;		 /* Provides exclusive access to mutex state
					via the Interlocked* mechanism.
					 0: unlocked/free.
					 1: locked - no other waiters.
					-1: locked - with possible other waiters.
				 */
	int recursive_count; /* Number of unlocks a thread needs to perform
				before the lock is released (recursive
				mutexes only). */
	int kind;			 /* Mutex type. */
	pthread_t ownerThread;
	HANDLE event; /* Mutex release notification to waiting
			 threads. */
	__ptw32_robust_node_t *
		robustNode; /* Extra state for robust mutexes  */
};

struct pthread_cond_t_
{
	long nWaitersBlocked;	/* Number of threads blocked            */
	long nWaitersGone;		/* Number of threads timed out          */
	long nWaitersToUnblock; /* Number of threads to unblock         */
	sem_t semBlockQueue;	/* Queue up threads waiting for the     */
	/*   condition to become signalled      */
	sem_t semBlockLock; /* Semaphore that guards access to      */
	/* | waiters blocked count/block queue  */
	/* +-> Mandatory Sync.LEVEL-1           */
	pthread_mutex_t mtxUnblockLock; /* Mutex that guards access to          */
	/* | waiters (to)unblock(ed) counts     */
	/* +-> Optional* Sync.LEVEL-2           */
	pthread_cond_t next; /* Doubly linked list                   */
	pthread_cond_t prev;
};

typedef struct _zend_threads_t
{
	pthread_t tid;
	struct
	{
		bool *interrupt;
	} child;
	struct
	{
		void *server;
	} parent;
	volatile int num_threads_alive;	  /* threads currently alive   */
	volatile int num_threads_working; /* threads currently working */
	pthread_mutex_t worker_mutex;
	pthread_cond_t worker_all_idle;
	zend_object std;
	int state;
} zend_threads_t;

typedef struct _zend_thread_t
{
	pthread_t tid;
	zend_fcall_info fci;
	zend_fcall_info_cache fcc;
	zval *args;
	int status;
} zend_thread_t;

void _zend_bailout(const char *filename, uint32_t lineno);
/* show an exception using zend_error(severity,...), severity should be E_ERROR */
void zend_exception_error(zval *exception, int severity, ...);
zend_string *zend_print_zval_r_to_str(zval *expr, int indent);

typedef char *va_list;

/* various true multithread-shared globals use for hooking into Zend Engine see https://www.phpinternalsbook.com/php7/extensions_design/hooks.html */
extern size_t (*zend_printf)(const char *format, ...);
extern FILE *(*zend_fopen)(const char *filename, zend_string **opened_path);
extern void (*zend_ticks_function)(int ticks);
extern void (*zend_interrupt_function)(zend_execute_data *execute_data);
extern void (*zend_error_cb)(int type, const char *error_filename, const uint32_t error_lineno, const char *format, va_list args);
extern void (*zend_on_timeout)(int seconds);
extern char *(*zend_getenv)(char *name, size_t name_len);
extern zend_string *(*zend_resolve_path)(const char *filename, size_t filename_len);

/* These two callbacks are especially for opcache */
extern int (*zend_post_startup_cb)(void);
extern void (*zend_post_shutdown_cb)(void);

/* Callback for loading of not preloaded part of the script */
extern int (*zend_preload_autoload)(zend_string *filename);

extern void (*zend_execute_ex)(zend_execute_data *execute_data);
extern void (*zend_execute_internal)(zend_execute_data *execute_data, zval *return_value);

zend_ast *zend_compile_string_to_ast(
	zend_string *code, struct _zend_arena **ast_arena, zend_string *filename);
