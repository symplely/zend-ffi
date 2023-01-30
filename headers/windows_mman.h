#define FFI_SCOPE "__misc__"
#define FFI_LIB ".\\lib\\Windows\\mman.dll"

typedef signed long int __int64;
typedef unsigned int uintptr_t;
typedef char *va_list;
typedef unsigned int size_t;
typedef int ptrdiff_t;
typedef int intptr_t;
typedef unsigned short wchar_t;
typedef signed char int8_t;
typedef short int16_t;
typedef int int32_t;
typedef long long int64_t;
typedef unsigned char uint8_t;
typedef unsigned short uint16_t;
typedef unsigned int uint32_t;
typedef unsigned long long uint64_t;

typedef signed char int_least8_t;
typedef short int_least16_t;
typedef int int_least32_t;
typedef long long int_least64_t;
typedef unsigned char uint_least8_t;
typedef unsigned short uint_least16_t;
typedef unsigned int uint_least32_t;
typedef unsigned long long uint_least64_t;

typedef signed char int_fast8_t;
typedef int int_fast16_t;
typedef int int_fast32_t;
typedef long long int_fast64_t;
typedef unsigned char uint_fast8_t;
typedef unsigned int uint_fast16_t;
typedef unsigned int uint_fast32_t;
typedef unsigned long long uint_fast64_t;

typedef long long intmax_t;
typedef unsigned long long uintmax_t;
typedef uint32_t OffsetType;
typedef int errno_t;
typedef unsigned short wint_t;
typedef unsigned short wctype_t;
typedef long __time32_t;
typedef __int64 __time64_t;

typedef struct __crt_locale_data_public
{
    unsigned short const *_locale_pctype;
    int _locale_mb_cur_max;
    unsigned int _locale_lc_codepage;
} __crt_locale_data_public;

typedef struct __crt_locale_pointers
{
    struct __crt_locale_data *locinfo;
    struct __crt_multibyte_data *mbcinfo;
} __crt_locale_pointers;

typedef __crt_locale_pointers *_locale_t;

typedef struct _Mbstatet
{
    unsigned long _Wchar;
    unsigned short _Byte, _State;
} _Mbstatet;

typedef _Mbstatet mbstate_t;
typedef __time64_t time_t;

typedef size_t rsize_t;
typedef unsigned short _ino_t;
typedef unsigned int _dev_t;
typedef long _off_t;

void *mmap(void *addr, size_t len, int prot, int flags, int fildes, OffsetType off);
int munmap(void *addr, size_t len);
int _mprotect(void *addr, size_t len, int prot);
int msync(void *addr, size_t len, int flags);
int mlock(const void *addr, size_t len);
int munlock(const void *addr, size_t len);
long getpagesize(void);
