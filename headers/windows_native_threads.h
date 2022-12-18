#define FFI_SCOPE "__threads__"
#define FFI_LIB "C:\\Windows\\System32\\Kernel32.dll"

typedef signed long int __int64;
typedef unsigned long ULONG;
typedef ULONG *PULONG;
typedef unsigned short USHORT;
typedef USHORT *PUSHORT;
typedef unsigned char UCHAR;
typedef UCHAR *PUCHAR;
typedef char *PSZ;
typedef unsigned long DWORD;
typedef int BOOL;
typedef unsigned char BYTE;
typedef unsigned short WORD;
typedef float FLOAT;
typedef FLOAT *PFLOAT;
typedef BOOL *PBOOL;
typedef BOOL *LPBOOL;
typedef BYTE *PBYTE;
typedef BYTE *LPBYTE;
typedef int *PINT;
typedef int *LPINT;
typedef WORD *PWORD;
typedef WORD *LPWORD;
typedef long *LPLONG;
typedef DWORD *PDWORD;
typedef DWORD *LPDWORD;
typedef void *LPVOID;
typedef const void *LPCVOID;

typedef int INT;
typedef unsigned int UINT;
typedef unsigned int *PUINT;
typedef unsigned int uintptr_t;

typedef char *va_list;
typedef unsigned int size_t;
typedef int ptrdiff_t;
typedef int intptr_t;

typedef unsigned short wchar_t;
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

typedef unsigned long POINTER_64_INT;
typedef signed char INT8, *PINT8;
typedef signed short INT16, *PINT16;
typedef signed int INT32, *PINT32;
typedef signed long int INT64, *PINT64;
typedef unsigned char UINT8, *PUINT8;
typedef unsigned short UINT16, *PUINT16;
typedef unsigned int UINT32, *PUINT32;
typedef unsigned long int UINT64, *PUINT64;

typedef signed int LONG32, *PLONG32;

typedef unsigned int ULONG32, *PULONG32;
typedef unsigned int DWORD32, *PDWORD32;
typedef int INT_PTR, *PINT_PTR;
typedef unsigned int UINT_PTR, *PUINT_PTR;

typedef long LONG_PTR, *PLONG_PTR;
typedef unsigned long ULONG_PTR, *PULONG_PTR;
typedef unsigned short UHALF_PTR, *PUHALF_PTR;
typedef short HALF_PTR, *PHALF_PTR;
typedef long SHANDLE_PTR;
typedef unsigned long HANDLE_PTR;

typedef ULONG_PTR SIZE_T, *PSIZE_T;
typedef LONG_PTR SSIZE_T, *PSSIZE_T;
typedef ULONG_PTR DWORD_PTR, *PDWORD_PTR;

typedef long int LONG64, *PLONG64;

typedef unsigned long int ULONG64, *PULONG64;
typedef unsigned long long int DWORD64, *PDWORD64;

typedef ULONG_PTR KAFFINITY;
typedef KAFFINITY *PKAFFINITY;
typedef void *PVOID;
typedef void *PVOID64;
typedef char CHAR;
typedef short SHORT;
typedef long LONG;

typedef int INT;

typedef wchar_t WCHAR;
typedef WCHAR *PWCHAR, *LPWCH, *PWCH;
typedef const WCHAR *LPCWCH, *PCWCH;

typedef WCHAR *NWPSTR, *LPWSTR, *PWSTR;
typedef PWSTR *PZPWSTR;
typedef const PWSTR *PCZPWSTR;
typedef WCHAR *LPUWSTR, *PUWSTR;
typedef const WCHAR *LPCWSTR, *PCWSTR;
typedef PCWSTR *PZPCWSTR;
typedef const PCWSTR *PCZPCWSTR;
typedef const WCHAR *LPCUWSTR, *PCUWSTR;

typedef WCHAR *PZZWSTR;
typedef const WCHAR *PCZZWSTR;
typedef WCHAR *PUZZWSTR;
typedef const WCHAR *PCUZZWSTR;

typedef WCHAR *PNZWCH;
typedef const WCHAR *PCNZWCH;
typedef WCHAR *PUNZWCH;
typedef const WCHAR *PCUNZWCH;
typedef CHAR *PCHAR, *LPCH, *PCH;
typedef const CHAR *LPCCH, *PCCH;

typedef CHAR *NPSTR, *LPSTR, *PSTR;
typedef PSTR *PZPSTR;
typedef const PSTR *PCZPSTR;
typedef const CHAR *LPCSTR, *PCSTR;
typedef PCSTR *PZPCSTR;
typedef const PCSTR *PCZPCSTR;

typedef CHAR *PZZSTR;
typedef const CHAR *PCZZSTR;

typedef CHAR *PNZCH;
typedef const CHAR *PCNZCH;
typedef char TCHAR, *PTCHAR;
typedef unsigned char TBYTE, *PTBYTE;

typedef LPCH LPTCH, PTCH;
typedef LPCCH LPCTCH, PCTCH;
typedef LPSTR PTSTR, LPTSTR, PUTSTR, LPUTSTR;
typedef LPCSTR PCTSTR, LPCTSTR, PCUTSTR, LPCUTSTR;
typedef PZZSTR PZZTSTR, PUZZTSTR;
typedef PCZZSTR PCZZTSTR, PCUZZTSTR;
typedef PZPSTR PZPTSTR;
typedef PNZCH PNZTCH, PUNZTCH;
typedef PCNZCH PCNZTCH, PCUNZTCH;

typedef SHORT *PSHORT;
typedef LONG *PLONG;

typedef struct _PROCESSOR_NUMBER
{
    WORD Group;
    BYTE Number;
    BYTE Reserved;
} PROCESSOR_NUMBER, *PPROCESSOR_NUMBER;

typedef struct _GROUP_AFFINITY
{
    KAFFINITY Mask;
    WORD Group;
    WORD Reserved[3];
} GROUP_AFFINITY, *PGROUP_AFFINITY;
typedef void *HANDLE;
typedef HANDLE *PHANDLE;

typedef BYTE FCHAR;
typedef WORD FSHORT;
typedef DWORD FLONG;

typedef long HRESULT;
typedef char CCHAR;
typedef DWORD LCID;
typedef PDWORD PLCID;
typedef WORD LANGID;

typedef enum
{
    UNSPECIFIED_COMPARTMENT_ID = 0,
    DEFAULT_COMPARTMENT_ID
} COMPARTMENT_ID,
    *PCOMPARTMENT_ID;
typedef struct _FLOAT128
{
    __int64 LowPart;
    __int64 HighPart;
} FLOAT128;

typedef FLOAT128 *PFLOAT128;
typedef double LONGLONG;
typedef double ULONGLONG;

typedef LONGLONG *PLONGLONG;
typedef ULONGLONG *PULONGLONG;

typedef LONGLONG USN;

typedef union _LARGE_INTEGER
{
    struct
    {
        DWORD LowPart;
        LONG HighPart;
    } s;
    struct
    {
        DWORD LowPart;
        LONG HighPart;
    } u;
    LONGLONG QuadPart;
} LARGE_INTEGER;

typedef LARGE_INTEGER *PLARGE_INTEGER;

typedef union _ULARGE_INTEGER
{
    struct
    {
        DWORD LowPart;
        DWORD HighPart;
    } s;
    struct
    {
        DWORD LowPart;
        DWORD HighPart;
    } u;
    ULONGLONG QuadPart;
} ULARGE_INTEGER;

typedef ULARGE_INTEGER *PULARGE_INTEGER;

typedef LONG_PTR RTL_REFERENCE_COUNT, *PRTL_REFERENCE_COUNT;
typedef LONG RTL_REFERENCE_COUNT32, *PRTL_REFERENCE_COUNT32;

typedef struct _LUID
{
    DWORD LowPart;
    LONG HighPart;
} LUID, *PLUID;

typedef ULONGLONG DWORDLONG;
typedef DWORDLONG *PDWORDLONG;

typedef BYTE BOOLEAN;
typedef BOOLEAN *PBOOLEAN;

typedef struct _LIST_ENTRY
{
    struct _LIST_ENTRY *Flink;
    struct _LIST_ENTRY *Blink;
} LIST_ENTRY, *PLIST_ENTRY, *PRLIST_ENTRY;

typedef struct _SINGLE_LIST_ENTRY
{
    struct _SINGLE_LIST_ENTRY *Next;
} SINGLE_LIST_ENTRY, *PSINGLE_LIST_ENTRY;

typedef struct LIST_ENTRY32
{
    DWORD Flink;
    DWORD Blink;
} LIST_ENTRY32;
typedef LIST_ENTRY32 *PLIST_ENTRY32;

typedef struct LIST_ENTRY64
{
    ULONGLONG Flink;
    ULONGLONG Blink;
} LIST_ENTRY64;
typedef LIST_ENTRY64 *PLIST_ENTRY64;
typedef struct _GUID
{
    unsigned long Data1;
    unsigned short Data2;
    unsigned short Data3;
    unsigned char Data4[8];
} GUID;
typedef GUID *LPGUID;

typedef const GUID *LPCGUID;

typedef GUID IID;
typedef IID *LPIID;

typedef GUID CLSID;
typedef CLSID *LPCLSID;

typedef GUID FMTID;
typedef FMTID *LPFMTID;

typedef struct _OBJECTID
{
    GUID Lineage;
    DWORD Uniquifier;
} OBJECTID;

typedef enum _EXCEPTION_DISPOSITION
{
    ExceptionContinueExecution,
    ExceptionContinueSearch,
    ExceptionNestedException,
    ExceptionCollidedUnwind
} EXCEPTION_DISPOSITION;

struct _EXCEPTION_RECORD;
struct _CONTEXT;

typedef EXCEPTION_DISPOSITION EXCEPTION_ROUTINE(
    struct _EXCEPTION_RECORD *ExceptionRecord,
    PVOID EstablisherFrame,
    struct _CONTEXT *ContextRecord,
    PVOID DispatcherContext);

typedef EXCEPTION_ROUTINE *PEXCEPTION_ROUTINE;
typedef ULONG_PTR KSPIN_LOCK;
typedef KSPIN_LOCK *PKSPIN_LOCK;

typedef struct _M128A
{
    ULONGLONG Low;
    LONGLONG High;
} M128A, *PM128A;

typedef struct _XSAVE_FORMAT
{
    WORD ControlWord;
    WORD StatusWord;
    BYTE TagWord;
    BYTE Reserved1;
    WORD ErrorOpcode;
    DWORD ErrorOffset;
    WORD ErrorSelector;
    WORD Reserved2;
    DWORD DataOffset;
    WORD DataSelector;
    WORD Reserved3;
    DWORD MxCsr;
    DWORD MxCsr_Mask;
    M128A FloatRegisters[8];
    M128A XmmRegisters[8];
    BYTE Reserved4[224];

} XSAVE_FORMAT, *PXSAVE_FORMAT;

typedef struct _XSAVE_CET_U_FORMAT
{
    DWORD64 Ia32CetUMsr;
    DWORD64 Ia32Pl3SspMsr;
} XSAVE_CET_U_FORMAT, *PXSAVE_CET_U_FORMAT;

typedef struct _XSAVE_AREA_HEADER
{
    DWORD64 Mask;
    DWORD64 CompactionMask;
    DWORD64 Reserved2[6];
} XSAVE_AREA_HEADER, *PXSAVE_AREA_HEADER;

typedef struct _XSAVE_AREA
{
    XSAVE_FORMAT LegacyState;
    XSAVE_AREA_HEADER Header;
} XSAVE_AREA, *PXSAVE_AREA;

typedef struct _XSTATE_CONTEXT
{
    DWORD64 Mask;
    DWORD Length;
    DWORD Reserved1;
    PXSAVE_AREA Area;
    DWORD Reserved2;
    PVOID Buffer;
    DWORD Reserved3;

} XSTATE_CONTEXT, *PXSTATE_CONTEXT;

typedef struct _SCOPE_TABLE_AMD64
{
    DWORD Count;
    struct
    {
        DWORD BeginAddress;
        DWORD EndAddress;
        DWORD HandlerAddress;
        DWORD JumpTarget;
    } ScopeRecord[1];
} SCOPE_TABLE_AMD64, *PSCOPE_TABLE_AMD64;
typedef struct _SCOPE_TABLE_ARM
{
    DWORD Count;
    struct
    {
        DWORD BeginAddress;
        DWORD EndAddress;
        DWORD HandlerAddress;
        DWORD JumpTarget;
    } ScopeRecord[1];
} SCOPE_TABLE_ARM, *PSCOPE_TABLE_ARM;
typedef struct _SCOPE_TABLE_ARM64
{
    DWORD Count;
    struct
    {
        DWORD BeginAddress;
        DWORD EndAddress;
        DWORD HandlerAddress;
        DWORD JumpTarget;
    } ScopeRecord[1];
} SCOPE_TABLE_ARM64, *PSCOPE_TABLE_ARM64;
typedef struct _KNONVOLATILE_CONTEXT_POINTERS_ARM64
{
    PDWORD64 X19;
    PDWORD64 X20;
    PDWORD64 X21;
    PDWORD64 X22;
    PDWORD64 X23;
    PDWORD64 X24;
    PDWORD64 X25;
    PDWORD64 X26;
    PDWORD64 X27;
    PDWORD64 X28;
    PDWORD64 Fp;
    PDWORD64 Lr;
    PDWORD64 D8;
    PDWORD64 D9;
    PDWORD64 D10;
    PDWORD64 D11;
    PDWORD64 D12;
    PDWORD64 D13;
    PDWORD64 D14;
    PDWORD64 D15;

} KNONVOLATILE_CONTEXT_POINTERS_ARM64, *PKNONVOLATILE_CONTEXT_POINTERS_ARM64;

typedef struct _FLOATING_SAVE_AREA
{
    DWORD ControlWord;
    DWORD StatusWord;
    DWORD TagWord;
    DWORD ErrorOffset;
    DWORD ErrorSelector;
    DWORD DataOffset;
    DWORD DataSelector;
    BYTE RegisterArea[80];
    DWORD Spare0;
} FLOATING_SAVE_AREA;

typedef FLOATING_SAVE_AREA *PFLOATING_SAVE_AREA;

typedef struct _CONTEXT
{
    DWORD ContextFlags;
    DWORD Dr0;
    DWORD Dr1;
    DWORD Dr2;
    DWORD Dr3;
    DWORD Dr6;
    DWORD Dr7;
    FLOATING_SAVE_AREA FloatSave;
    DWORD SegGs;
    DWORD SegFs;
    DWORD SegEs;
    DWORD SegDs;
    DWORD Edi;
    DWORD Esi;
    DWORD Ebx;
    DWORD Edx;
    DWORD Ecx;
    DWORD Eax;
    DWORD Ebp;
    DWORD Eip;
    DWORD SegCs;
    DWORD EFlags;
    DWORD Esp;
    DWORD SegSs;
    BYTE ExtendedRegisters[512];

} CONTEXT;

typedef CONTEXT *PCONTEXT;

typedef struct _LDT_ENTRY
{
    WORD LimitLow;
    WORD BaseLow;
    union
    {
        struct
        {
            BYTE BaseMid;
            BYTE Flags1;
            BYTE Flags2;
            BYTE BaseHi;
        } Bytes;
        struct
        {
            DWORD BaseMid : 8;
            DWORD Type : 5;
            DWORD Dpl : 2;
            DWORD Pres : 1;
            DWORD LimitHi : 4;
            DWORD Sys : 1;
            DWORD Reserved_0 : 1;
            DWORD Default_Big : 1;
            DWORD Granularity : 1;
            DWORD BaseHi : 8;
        } Bits;
    } HighWord;
} LDT_ENTRY, *PLDT_ENTRY;

typedef struct _KNONVOLATILE_CONTEXT_POINTERS
{
    DWORD Dummy;
} KNONVOLATILE_CONTEXT_POINTERS, *PKNONVOLATILE_CONTEXT_POINTERS;

typedef struct _WOW64_FLOATING_SAVE_AREA
{
    DWORD ControlWord;
    DWORD StatusWord;
    DWORD TagWord;
    DWORD ErrorOffset;
    DWORD ErrorSelector;
    DWORD DataOffset;
    DWORD DataSelector;
    BYTE RegisterArea[80];
    DWORD Cr0NpxState;
} WOW64_FLOATING_SAVE_AREA;

typedef WOW64_FLOATING_SAVE_AREA *PWOW64_FLOATING_SAVE_AREA;

typedef struct _WOW64_CONTEXT
{
    DWORD ContextFlags;
    DWORD Dr0;
    DWORD Dr1;
    DWORD Dr2;
    DWORD Dr3;
    DWORD Dr6;
    DWORD Dr7;
    WOW64_FLOATING_SAVE_AREA FloatSave;
    DWORD SegGs;
    DWORD SegFs;
    DWORD SegEs;
    DWORD SegDs;
    DWORD Edi;
    DWORD Esi;
    DWORD Ebx;
    DWORD Edx;
    DWORD Ecx;
    DWORD Eax;
    DWORD Ebp;
    DWORD Eip;
    DWORD SegCs;
    DWORD EFlags;
    DWORD Esp;
    DWORD SegSs;
    BYTE ExtendedRegisters[512];

} WOW64_CONTEXT;

typedef WOW64_CONTEXT *PWOW64_CONTEXT;

typedef struct _WOW64_LDT_ENTRY
{
    WORD LimitLow;
    WORD BaseLow;
    union
    {
        struct
        {
            BYTE BaseMid;
            BYTE Flags1;
            BYTE Flags2;
            BYTE BaseHi;
        } Bytes;
        struct
        {
            DWORD BaseMid : 8;
            DWORD Type : 5;
            DWORD Dpl : 2;
            DWORD Pres : 1;
            DWORD LimitHi : 4;
            DWORD Sys : 1;
            DWORD Reserved_0 : 1;
            DWORD Default_Big : 1;
            DWORD Granularity : 1;
            DWORD BaseHi : 8;
        } Bits;
    } HighWord;
} WOW64_LDT_ENTRY, *PWOW64_LDT_ENTRY;

typedef struct _WOW64_DESCRIPTOR_TABLE_ENTRY
{
    DWORD Selector;
    WOW64_LDT_ENTRY Descriptor;
} WOW64_DESCRIPTOR_TABLE_ENTRY, *PWOW64_DESCRIPTOR_TABLE_ENTRY;
typedef struct _EXCEPTION_RECORD
{
    DWORD ExceptionCode;
    DWORD ExceptionFlags;
    struct _EXCEPTION_RECORD *ExceptionRecord;
    PVOID ExceptionAddress;
    DWORD NumberParameters;
    ULONG_PTR ExceptionInformation[15];
} EXCEPTION_RECORD;

typedef EXCEPTION_RECORD *PEXCEPTION_RECORD;

typedef struct _EXCEPTION_RECORD32
{
    DWORD ExceptionCode;
    DWORD ExceptionFlags;
    DWORD ExceptionRecord;
    DWORD ExceptionAddress;
    DWORD NumberParameters;
    DWORD ExceptionInformation[15];
} EXCEPTION_RECORD32, *PEXCEPTION_RECORD32;

typedef struct _EXCEPTION_RECORD64
{
    DWORD ExceptionCode;
    DWORD ExceptionFlags;
    DWORD64 ExceptionRecord;
    DWORD64 ExceptionAddress;
    DWORD NumberParameters;
    DWORD __unusedAlignment;
    DWORD64 ExceptionInformation[15];
} EXCEPTION_RECORD64, *PEXCEPTION_RECORD64;

typedef struct _EXCEPTION_POINTERS
{
    PEXCEPTION_RECORD ExceptionRecord;
    PCONTEXT ContextRecord;
} EXCEPTION_POINTERS, *PEXCEPTION_POINTERS;
typedef PVOID PACCESS_TOKEN;
typedef PVOID PSECURITY_DESCRIPTOR;
typedef PVOID PSID;
typedef PVOID PCLAIMS_BLOB;
typedef DWORD ACCESS_MASK;
typedef ACCESS_MASK *PACCESS_MASK;
typedef struct _GENERIC_MAPPING
{
    ACCESS_MASK GenericRead;
    ACCESS_MASK GenericWrite;
    ACCESS_MASK GenericExecute;
    ACCESS_MASK GenericAll;
} GENERIC_MAPPING;
typedef GENERIC_MAPPING *PGENERIC_MAPPING;

typedef struct _LUID_AND_ATTRIBUTES
{
    LUID Luid;
    DWORD Attributes;
} LUID_AND_ATTRIBUTES, *PLUID_AND_ATTRIBUTES;
typedef LUID_AND_ATTRIBUTES LUID_AND_ATTRIBUTES_ARRAY[1];
typedef LUID_AND_ATTRIBUTES_ARRAY *PLUID_AND_ATTRIBUTES_ARRAY;
typedef struct _SID_IDENTIFIER_AUTHORITY
{
    BYTE Value[6];
} SID_IDENTIFIER_AUTHORITY, *PSID_IDENTIFIER_AUTHORITY;

typedef struct _SID
{
    BYTE Revision;
    BYTE SubAuthorityCount;
    SID_IDENTIFIER_AUTHORITY IdentifierAuthority;
    DWORD SubAuthority[1];

} SID, *PISID;
typedef union _SE_SID
{
    SID Sid;
    BYTE Buffer[(sizeof(SID) - sizeof(DWORD) + ((15) * sizeof(DWORD)))];
} SE_SID, *PSE_SID;

typedef enum _SID_NAME_USE
{
    SidTypeUser = 1,
    SidTypeGroup,
    SidTypeDomain,
    SidTypeAlias,
    SidTypeWellKnownGroup,
    SidTypeDeletedAccount,
    SidTypeInvalid,
    SidTypeUnknown,
    SidTypeComputer,
    SidTypeLabel,
    SidTypeLogonSession
} SID_NAME_USE,
    *PSID_NAME_USE;

typedef struct _SID_AND_ATTRIBUTES
{
    PSID Sid;
    DWORD Attributes;
} SID_AND_ATTRIBUTES, *PSID_AND_ATTRIBUTES;

typedef SID_AND_ATTRIBUTES SID_AND_ATTRIBUTES_ARRAY[1];
typedef SID_AND_ATTRIBUTES_ARRAY *PSID_AND_ATTRIBUTES_ARRAY;

typedef ULONG_PTR SID_HASH_ENTRY, *PSID_HASH_ENTRY;

typedef struct _SID_AND_ATTRIBUTES_HASH
{
    DWORD SidCount;
    PSID_AND_ATTRIBUTES SidAttr;
    SID_HASH_ENTRY Hash[32];
} SID_AND_ATTRIBUTES_HASH, *PSID_AND_ATTRIBUTES_HASH;
typedef enum
{
    WinNullSid = 0,
    WinWorldSid = 1,
    WinLocalSid = 2,
    WinCreatorOwnerSid = 3,
    WinCreatorGroupSid = 4,
    WinCreatorOwnerServerSid = 5,
    WinCreatorGroupServerSid = 6,
    WinNtAuthoritySid = 7,
    WinDialupSid = 8,
    WinNetworkSid = 9,
    WinBatchSid = 10,
    WinInteractiveSid = 11,
    WinServiceSid = 12,
    WinAnonymousSid = 13,
    WinProxySid = 14,
    WinEnterpriseControllersSid = 15,
    WinSelfSid = 16,
    WinAuthenticatedUserSid = 17,
    WinRestrictedCodeSid = 18,
    WinTerminalServerSid = 19,
    WinRemoteLogonIdSid = 20,
    WinLogonIdsSid = 21,
    WinLocalSystemSid = 22,
    WinLocalServiceSid = 23,
    WinNetworkServiceSid = 24,
    WinBuiltinDomainSid = 25,
    WinBuiltinAdministratorsSid = 26,
    WinBuiltinUsersSid = 27,
    WinBuiltinGuestsSid = 28,
    WinBuiltinPowerUsersSid = 29,
    WinBuiltinAccountOperatorsSid = 30,
    WinBuiltinSystemOperatorsSid = 31,
    WinBuiltinPrintOperatorsSid = 32,
    WinBuiltinBackupOperatorsSid = 33,
    WinBuiltinReplicatorSid = 34,
    WinBuiltinPreWindows2000CompatibleAccessSid = 35,
    WinBuiltinRemoteDesktopUsersSid = 36,
    WinBuiltinNetworkConfigurationOperatorsSid = 37,
    WinAccountAdministratorSid = 38,
    WinAccountGuestSid = 39,
    WinAccountKrbtgtSid = 40,
    WinAccountDomainAdminsSid = 41,
    WinAccountDomainUsersSid = 42,
    WinAccountDomainGuestsSid = 43,
    WinAccountComputersSid = 44,
    WinAccountControllersSid = 45,
    WinAccountCertAdminsSid = 46,
    WinAccountSchemaAdminsSid = 47,
    WinAccountEnterpriseAdminsSid = 48,
    WinAccountPolicyAdminsSid = 49,
    WinAccountRasAndIasServersSid = 50,
    WinNTLMAuthenticationSid = 51,
    WinDigestAuthenticationSid = 52,
    WinSChannelAuthenticationSid = 53,
    WinThisOrganizationSid = 54,
    WinOtherOrganizationSid = 55,
    WinBuiltinIncomingForestTrustBuildersSid = 56,
    WinBuiltinPerfMonitoringUsersSid = 57,
    WinBuiltinPerfLoggingUsersSid = 58,
    WinBuiltinAuthorizationAccessSid = 59,
    WinBuiltinTerminalServerLicenseServersSid = 60,
    WinBuiltinDCOMUsersSid = 61,
    WinBuiltinIUsersSid = 62,
    WinIUserSid = 63,
    WinBuiltinCryptoOperatorsSid = 64,
    WinUntrustedLabelSid = 65,
    WinLowLabelSid = 66,
    WinMediumLabelSid = 67,
    WinHighLabelSid = 68,
    WinSystemLabelSid = 69,
    WinWriteRestrictedCodeSid = 70,
    WinCreatorOwnerRightsSid = 71,
    WinCacheablePrincipalsGroupSid = 72,
    WinNonCacheablePrincipalsGroupSid = 73,
    WinEnterpriseReadonlyControllersSid = 74,
    WinAccountReadonlyControllersSid = 75,
    WinBuiltinEventLogReadersGroup = 76,
    WinNewEnterpriseReadonlyControllersSid = 77,
    WinBuiltinCertSvcDComAccessGroup = 78,
    WinMediumPlusLabelSid = 79,
    WinLocalLogonSid = 80,
    WinConsoleLogonSid = 81,
    WinThisOrganizationCertificateSid = 82,
    WinApplicationPackageAuthoritySid = 83,
    WinBuiltinAnyPackageSid = 84,
    WinCapabilityInternetClientSid = 85,
    WinCapabilityInternetClientServerSid = 86,
    WinCapabilityPrivateNetworkClientServerSid = 87,
    WinCapabilityPicturesLibrarySid = 88,
    WinCapabilityVideosLibrarySid = 89,
    WinCapabilityMusicLibrarySid = 90,
    WinCapabilityDocumentsLibrarySid = 91,
    WinCapabilitySharedUserCertificatesSid = 92,
    WinCapabilityEnterpriseAuthenticationSid = 93,
    WinCapabilityRemovableStorageSid = 94,
    WinBuiltinRDSRemoteAccessServersSid = 95,
    WinBuiltinRDSEndpointServersSid = 96,
    WinBuiltinRDSManagementServersSid = 97,
    WinUserModeDriversSid = 98,
    WinBuiltinHyperVAdminsSid = 99,
    WinAccountCloneableControllersSid = 100,
    WinBuiltinAccessControlAssistanceOperatorsSid = 101,
    WinBuiltinRemoteManagementUsersSid = 102,
    WinAuthenticationAuthorityAssertedSid = 103,
    WinAuthenticationServiceAssertedSid = 104,
    WinLocalAccountSid = 105,
    WinLocalAccountAndAdministratorSid = 106,
    WinAccountProtectedUsersSid = 107,
    WinCapabilityAppointmentsSid = 108,
    WinCapabilityContactsSid = 109,
    WinAccountDefaultSystemManagedSid = 110,
    WinBuiltinDefaultSystemManagedGroupSid = 111,
    WinBuiltinStorageReplicaAdminsSid = 112,
    WinAccountKeyAdminsSid = 113,
    WinAccountEnterpriseKeyAdminsSid = 114,
    WinAuthenticationKeyTrustSid = 115,
    WinAuthenticationKeyPropertyMFASid = 116,
    WinAuthenticationKeyPropertyAttestationSid = 117,
    WinAuthenticationFreshKeyAuthSid = 118,
    WinBuiltinDeviceOwnersSid = 119,
} WELL_KNOWN_SID_TYPE;
typedef struct _ACL
{
    BYTE AclRevision;
    BYTE Sbz1;
    WORD AclSize;
    WORD AceCount;
    WORD Sbz2;
} ACL;
typedef ACL *PACL;
typedef struct _ACE_HEADER
{
    BYTE AceType;
    BYTE AceFlags;
    WORD AceSize;
} ACE_HEADER;
typedef ACE_HEADER *PACE_HEADER;
typedef struct _ACCESS_ALLOWED_ACE
{
    ACE_HEADER Header;
    ACCESS_MASK Mask;
    DWORD SidStart;
} ACCESS_ALLOWED_ACE;

typedef ACCESS_ALLOWED_ACE *PACCESS_ALLOWED_ACE;

typedef struct _ACCESS_DENIED_ACE
{
    ACE_HEADER Header;
    ACCESS_MASK Mask;
    DWORD SidStart;
} ACCESS_DENIED_ACE;
typedef ACCESS_DENIED_ACE *PACCESS_DENIED_ACE;

typedef struct _SYSTEM_AUDIT_ACE
{
    ACE_HEADER Header;
    ACCESS_MASK Mask;
    DWORD SidStart;
} SYSTEM_AUDIT_ACE;
typedef SYSTEM_AUDIT_ACE *PSYSTEM_AUDIT_ACE;

typedef struct _SYSTEM_ALARM_ACE
{
    ACE_HEADER Header;
    ACCESS_MASK Mask;
    DWORD SidStart;
} SYSTEM_ALARM_ACE;
typedef SYSTEM_ALARM_ACE *PSYSTEM_ALARM_ACE;

typedef struct _SYSTEM_RESOURCE_ATTRIBUTE_ACE
{
    ACE_HEADER Header;
    ACCESS_MASK Mask;
    DWORD SidStart;

} SYSTEM_RESOURCE_ATTRIBUTE_ACE, *PSYSTEM_RESOURCE_ATTRIBUTE_ACE;

typedef struct _SYSTEM_SCOPED_POLICY_ID_ACE
{
    ACE_HEADER Header;
    ACCESS_MASK Mask;
    DWORD SidStart;
} SYSTEM_SCOPED_POLICY_ID_ACE, *PSYSTEM_SCOPED_POLICY_ID_ACE;

typedef struct _SYSTEM_MANDATORY_LABEL_ACE
{
    ACE_HEADER Header;
    ACCESS_MASK Mask;
    DWORD SidStart;
} SYSTEM_MANDATORY_LABEL_ACE, *PSYSTEM_MANDATORY_LABEL_ACE;

typedef struct _SYSTEM_PROCESS_TRUST_LABEL_ACE
{
    ACE_HEADER Header;
    ACCESS_MASK Mask;
    DWORD SidStart;
} SYSTEM_PROCESS_TRUST_LABEL_ACE, *PSYSTEM_PROCESS_TRUST_LABEL_ACE;

typedef struct _SYSTEM_ACCESS_FILTER_ACE
{
    ACE_HEADER Header;
    ACCESS_MASK Mask;
    DWORD SidStart;

} SYSTEM_ACCESS_FILTER_ACE, *PSYSTEM_ACCESS_FILTER_ACE;
typedef struct _ACCESS_ALLOWED_OBJECT_ACE
{
    ACE_HEADER Header;
    ACCESS_MASK Mask;
    DWORD Flags;
    GUID ObjectType;
    GUID InheritedObjectType;
    DWORD SidStart;
} ACCESS_ALLOWED_OBJECT_ACE, *PACCESS_ALLOWED_OBJECT_ACE;

typedef struct _ACCESS_DENIED_OBJECT_ACE
{
    ACE_HEADER Header;
    ACCESS_MASK Mask;
    DWORD Flags;
    GUID ObjectType;
    GUID InheritedObjectType;
    DWORD SidStart;
} ACCESS_DENIED_OBJECT_ACE, *PACCESS_DENIED_OBJECT_ACE;

typedef struct _SYSTEM_AUDIT_OBJECT_ACE
{
    ACE_HEADER Header;
    ACCESS_MASK Mask;
    DWORD Flags;
    GUID ObjectType;
    GUID InheritedObjectType;
    DWORD SidStart;
} SYSTEM_AUDIT_OBJECT_ACE, *PSYSTEM_AUDIT_OBJECT_ACE;

typedef struct _SYSTEM_ALARM_OBJECT_ACE
{
    ACE_HEADER Header;
    ACCESS_MASK Mask;
    DWORD Flags;
    GUID ObjectType;
    GUID InheritedObjectType;
    DWORD SidStart;
} SYSTEM_ALARM_OBJECT_ACE, *PSYSTEM_ALARM_OBJECT_ACE;

typedef struct _ACCESS_ALLOWED_CALLBACK_ACE
{
    ACE_HEADER Header;
    ACCESS_MASK Mask;
    DWORD SidStart;

} ACCESS_ALLOWED_CALLBACK_ACE, *PACCESS_ALLOWED_CALLBACK_ACE;

typedef struct _ACCESS_DENIED_CALLBACK_ACE
{
    ACE_HEADER Header;
    ACCESS_MASK Mask;
    DWORD SidStart;

} ACCESS_DENIED_CALLBACK_ACE, *PACCESS_DENIED_CALLBACK_ACE;

typedef struct _SYSTEM_AUDIT_CALLBACK_ACE
{
    ACE_HEADER Header;
    ACCESS_MASK Mask;
    DWORD SidStart;

} SYSTEM_AUDIT_CALLBACK_ACE, *PSYSTEM_AUDIT_CALLBACK_ACE;

typedef struct _SYSTEM_ALARM_CALLBACK_ACE
{
    ACE_HEADER Header;
    ACCESS_MASK Mask;
    DWORD SidStart;

} SYSTEM_ALARM_CALLBACK_ACE, *PSYSTEM_ALARM_CALLBACK_ACE;

typedef struct _ACCESS_ALLOWED_CALLBACK_OBJECT_ACE
{
    ACE_HEADER Header;
    ACCESS_MASK Mask;
    DWORD Flags;
    GUID ObjectType;
    GUID InheritedObjectType;
    DWORD SidStart;

} ACCESS_ALLOWED_CALLBACK_OBJECT_ACE, *PACCESS_ALLOWED_CALLBACK_OBJECT_ACE;

typedef struct _ACCESS_DENIED_CALLBACK_OBJECT_ACE
{
    ACE_HEADER Header;
    ACCESS_MASK Mask;
    DWORD Flags;
    GUID ObjectType;
    GUID InheritedObjectType;
    DWORD SidStart;

} ACCESS_DENIED_CALLBACK_OBJECT_ACE, *PACCESS_DENIED_CALLBACK_OBJECT_ACE;

typedef struct _SYSTEM_AUDIT_CALLBACK_OBJECT_ACE
{
    ACE_HEADER Header;
    ACCESS_MASK Mask;
    DWORD Flags;
    GUID ObjectType;
    GUID InheritedObjectType;
    DWORD SidStart;

} SYSTEM_AUDIT_CALLBACK_OBJECT_ACE, *PSYSTEM_AUDIT_CALLBACK_OBJECT_ACE;

typedef struct _SYSTEM_ALARM_CALLBACK_OBJECT_ACE
{
    ACE_HEADER Header;
    ACCESS_MASK Mask;
    DWORD Flags;
    GUID ObjectType;
    GUID InheritedObjectType;
    DWORD SidStart;

} SYSTEM_ALARM_CALLBACK_OBJECT_ACE, *PSYSTEM_ALARM_CALLBACK_OBJECT_ACE;
typedef enum _ACL_INFORMATION_CLASS
{
    AclRevisionInformation = 1,
    AclSizeInformation
} ACL_INFORMATION_CLASS;

typedef struct _ACL_REVISION_INFORMATION
{
    DWORD AclRevision;
} ACL_REVISION_INFORMATION;
typedef ACL_REVISION_INFORMATION *PACL_REVISION_INFORMATION;

typedef struct _ACL_SIZE_INFORMATION
{
    DWORD AceCount;
    DWORD AclBytesInUse;
    DWORD AclBytesFree;
} ACL_SIZE_INFORMATION;
typedef ACL_SIZE_INFORMATION *PACL_SIZE_INFORMATION;
typedef WORD SECURITY_DESCRIPTOR_CONTROL, *PSECURITY_DESCRIPTOR_CONTROL;
typedef struct _SECURITY_DESCRIPTOR_RELATIVE
{
    BYTE Revision;
    BYTE Sbz1;
    SECURITY_DESCRIPTOR_CONTROL Control;
    DWORD Owner;
    DWORD Group;
    DWORD Sacl;
    DWORD Dacl;
} SECURITY_DESCRIPTOR_RELATIVE, *PISECURITY_DESCRIPTOR_RELATIVE;

typedef struct _SECURITY_DESCRIPTOR
{
    BYTE Revision;
    BYTE Sbz1;
    SECURITY_DESCRIPTOR_CONTROL Control;
    PSID Owner;
    PSID Group;
    PACL Sacl;
    PACL Dacl;

} SECURITY_DESCRIPTOR, *PISECURITY_DESCRIPTOR;

typedef struct _SECURITY_OBJECT_AI_PARAMS
{
    DWORD Size;
    DWORD ConstraintMask;
} SECURITY_OBJECT_AI_PARAMS, *PSECURITY_OBJECT_AI_PARAMS;
typedef struct _OBJECT_TYPE_LIST
{
    WORD Level;
    WORD Sbz;
    GUID *ObjectType;
} OBJECT_TYPE_LIST, *POBJECT_TYPE_LIST;
typedef enum _AUDIT_EVENT_TYPE
{
    AuditEventObjectAccess,
    AuditEventDirectoryServiceAccess
} AUDIT_EVENT_TYPE,
    *PAUDIT_EVENT_TYPE;
typedef struct _PRIVILEGE_SET
{
    DWORD PrivilegeCount;
    DWORD Control;
    LUID_AND_ATTRIBUTES Privilege[1];
} PRIVILEGE_SET, *PPRIVILEGE_SET;
typedef enum _ACCESS_REASON_TYPE
{
    AccessReasonNone = 0x00000000,
    AccessReasonAllowedAce = 0x00010000,
    AccessReasonDeniedAce = 0x00020000,
    AccessReasonAllowedParentAce = 0x00030000,
    AccessReasonDeniedParentAce = 0x00040000,
    AccessReasonNotGrantedByCape = 0x00050000,
    AccessReasonNotGrantedByParentCape = 0x00060000,
    AccessReasonNotGrantedToAppContainer = 0x00070000,
    AccessReasonMissingPrivilege = 0x00100000,
    AccessReasonFromPrivilege = 0x00200000,
    AccessReasonIntegrityLevel = 0x00300000,
    AccessReasonOwnership = 0x00400000,
    AccessReasonNullDacl = 0x00500000,
    AccessReasonEmptyDacl = 0x00600000,
    AccessReasonNoSD = 0x00700000,
    AccessReasonNoGrant = 0x00800000,
    AccessReasonTrustLabel = 0x00900000,
    AccessReasonFilterAce = 0x00a00000
} ACCESS_REASON_TYPE;
typedef DWORD ACCESS_REASON;

typedef struct _ACCESS_REASONS
{
    ACCESS_REASON Data[32];
} ACCESS_REASONS, *PACCESS_REASONS;
typedef struct _SE_SECURITY_DESCRIPTOR
{
    DWORD Size;
    DWORD Flags;
    PSECURITY_DESCRIPTOR SecurityDescriptor;
} SE_SECURITY_DESCRIPTOR, *PSE_SECURITY_DESCRIPTOR;

typedef struct _SE_ACCESS_REQUEST
{
    DWORD Size;
    PSE_SECURITY_DESCRIPTOR SeSecurityDescriptor;
    ACCESS_MASK DesiredAccess;
    ACCESS_MASK PreviouslyGrantedAccess;
    PSID PrincipalSelfSid;
    PGENERIC_MAPPING GenericMapping;
    DWORD ObjectTypeListCount;
    POBJECT_TYPE_LIST ObjectTypeList;
} SE_ACCESS_REQUEST, *PSE_ACCESS_REQUEST;

typedef struct _SE_ACCESS_REPLY
{
    DWORD Size;
    DWORD ResultListCount;
    PACCESS_MASK GrantedAccess;
    PDWORD AccessStatus;
    PACCESS_REASONS AccessReason;
    PPRIVILEGE_SET *Privileges;
} SE_ACCESS_REPLY, *PSE_ACCESS_REPLY;
typedef enum _SECURITY_IMPERSONATION_LEVEL
{
    SecurityAnonymous,
    SecurityIdentification,
    SecurityImpersonation,
    SecurityDelegation
} SECURITY_IMPERSONATION_LEVEL,
    *PSECURITY_IMPERSONATION_LEVEL;
typedef enum _TOKEN_TYPE
{
    TokenPrimary = 1,
    TokenImpersonation
} TOKEN_TYPE;
typedef TOKEN_TYPE *PTOKEN_TYPE;

typedef enum _TOKEN_ELEVATION_TYPE
{
    TokenElevationTypeDefault = 1,
    TokenElevationTypeFull,
    TokenElevationTypeLimited,
} TOKEN_ELEVATION_TYPE,
    *PTOKEN_ELEVATION_TYPE;

typedef enum _TOKEN_INFORMATION_CLASS
{
    TokenUser = 1,
    TokenGroups,
    TokenPrivileges,
    TokenOwner,
    TokenPrimaryGroup,
    TokenDefaultDacl,
    TokenSource,
    TokenType,
    TokenImpersonationLevel,
    TokenStatistics,
    TokenRestrictedSids,
    TokenSessionId,
    TokenGroupsAndPrivileges,
    TokenSessionReference,
    TokenSandBoxInert,
    TokenAuditPolicy,
    TokenOrigin,
    TokenElevationType,
    TokenLinkedToken,
    TokenElevation,
    TokenHasRestrictions,
    TokenAccessInformation,
    TokenVirtualizationAllowed,
    TokenVirtualizationEnabled,
    TokenIntegrityLevel,
    TokenUIAccess,
    TokenMandatoryPolicy,
    TokenLogonSid,
    TokenIsAppContainer,
    TokenCapabilities,
    TokenAppContainerSid,
    TokenAppContainerNumber,
    TokenUserClaimAttributes,
    TokenDeviceClaimAttributes,
    TokenRestrictedUserClaimAttributes,
    TokenRestrictedDeviceClaimAttributes,
    TokenDeviceGroups,
    TokenRestrictedDeviceGroups,
    TokenSecurityAttributes,
    TokenIsRestricted,
    TokenProcessTrustLevel,
    TokenPrivateNameSpace,
    TokenSingletonAttributes,
    TokenBnoIsolation,
    TokenChildProcessFlags,
    TokenIsLessPrivilegedAppContainer,
    TokenIsSandboxed,
    TokenOriginatingProcessTrustLevel,
    MaxTokenInfoClass
} TOKEN_INFORMATION_CLASS,
    *PTOKEN_INFORMATION_CLASS;

typedef struct _TOKEN_USER
{
    SID_AND_ATTRIBUTES User;
} TOKEN_USER, *PTOKEN_USER;

typedef struct _SE_TOKEN_USER
{
    union
    {
        TOKEN_USER TokenUser;
        SID_AND_ATTRIBUTES User;
    } u;
    union
    {
        SID Sid;
        BYTE Buffer[(sizeof(SID) - sizeof(DWORD) + ((15) * sizeof(DWORD)))];
    } u2;

} SE_TOKEN_USER, PSE_TOKEN_USER;

typedef struct _TOKEN_GROUPS
{
    DWORD GroupCount;
    SID_AND_ATTRIBUTES Groups[1];

} TOKEN_GROUPS, *PTOKEN_GROUPS;

typedef struct _TOKEN_PRIVILEGES
{
    DWORD PrivilegeCount;
    LUID_AND_ATTRIBUTES Privileges[1];
} TOKEN_PRIVILEGES, *PTOKEN_PRIVILEGES;

typedef struct _TOKEN_OWNER
{
    PSID Owner;
} TOKEN_OWNER, *PTOKEN_OWNER;

typedef struct _TOKEN_PRIMARY_GROUP
{
    PSID PrimaryGroup;
} TOKEN_PRIMARY_GROUP, *PTOKEN_PRIMARY_GROUP;

typedef struct _TOKEN_DEFAULT_DACL
{
    PACL DefaultDacl;
} TOKEN_DEFAULT_DACL, *PTOKEN_DEFAULT_DACL;

typedef struct _TOKEN_USER_CLAIMS
{
    PCLAIMS_BLOB UserClaims;
} TOKEN_USER_CLAIMS, *PTOKEN_USER_CLAIMS;

typedef struct _TOKEN_DEVICE_CLAIMS
{
    PCLAIMS_BLOB DeviceClaims;
} TOKEN_DEVICE_CLAIMS, *PTOKEN_DEVICE_CLAIMS;

typedef struct _TOKEN_GROUPS_AND_PRIVILEGES
{
    DWORD SidCount;
    DWORD SidLength;
    PSID_AND_ATTRIBUTES Sids;
    DWORD RestrictedSidCount;
    DWORD RestrictedSidLength;
    PSID_AND_ATTRIBUTES RestrictedSids;
    DWORD PrivilegeCount;
    DWORD PrivilegeLength;
    PLUID_AND_ATTRIBUTES Privileges;
    LUID AuthenticationId;
} TOKEN_GROUPS_AND_PRIVILEGES, *PTOKEN_GROUPS_AND_PRIVILEGES;

typedef struct _TOKEN_LINKED_TOKEN
{
    HANDLE LinkedToken;
} TOKEN_LINKED_TOKEN, *PTOKEN_LINKED_TOKEN;

typedef struct _TOKEN_ELEVATION
{
    DWORD TokenIsElevated;
} TOKEN_ELEVATION, *PTOKEN_ELEVATION;

typedef struct _TOKEN_MANDATORY_LABEL
{
    SID_AND_ATTRIBUTES Label;
} TOKEN_MANDATORY_LABEL, *PTOKEN_MANDATORY_LABEL;
typedef struct _TOKEN_MANDATORY_POLICY
{
    DWORD Policy;
} TOKEN_MANDATORY_POLICY, *PTOKEN_MANDATORY_POLICY;

typedef PVOID PSECURITY_ATTRIBUTES_OPAQUE;

typedef struct _TOKEN_ACCESS_INFORMATION
{
    PSID_AND_ATTRIBUTES_HASH SidHash;
    PSID_AND_ATTRIBUTES_HASH RestrictedSidHash;
    PTOKEN_PRIVILEGES Privileges;
    LUID AuthenticationId;
    TOKEN_TYPE TokenType;
    SECURITY_IMPERSONATION_LEVEL ImpersonationLevel;
    TOKEN_MANDATORY_POLICY MandatoryPolicy;
    DWORD Flags;
    DWORD AppContainerNumber;
    PSID PackageSid;
    PSID_AND_ATTRIBUTES_HASH CapabilitiesHash;
    PSID TrustLevelSid;
    PSECURITY_ATTRIBUTES_OPAQUE SecurityAttributes;
} TOKEN_ACCESS_INFORMATION, *PTOKEN_ACCESS_INFORMATION;

typedef struct _TOKEN_AUDIT_POLICY
{
    BYTE PerUserPolicy[(((59)) >> 1) + 1];
} TOKEN_AUDIT_POLICY, *PTOKEN_AUDIT_POLICY;

typedef struct _TOKEN_SOURCE
{
    CHAR SourceName[8];
    LUID SourceIdentifier;
} TOKEN_SOURCE, *PTOKEN_SOURCE;

typedef struct _TOKEN_STATISTICS
{
    LUID TokenId;
    LUID AuthenticationId;
    LARGE_INTEGER ExpirationTime;
    TOKEN_TYPE TokenType;
    SECURITY_IMPERSONATION_LEVEL ImpersonationLevel;
    DWORD DynamicCharged;
    DWORD DynamicAvailable;
    DWORD GroupCount;
    DWORD PrivilegeCount;
    LUID ModifiedId;
} TOKEN_STATISTICS, *PTOKEN_STATISTICS;

typedef struct _TOKEN_CONTROL
{
    LUID TokenId;
    LUID AuthenticationId;
    LUID ModifiedId;
    TOKEN_SOURCE TokenSource;
} TOKEN_CONTROL, *PTOKEN_CONTROL;

typedef struct _TOKEN_ORIGIN
{
    LUID OriginatingLogonSession;
} TOKEN_ORIGIN, *PTOKEN_ORIGIN;

typedef enum _MANDATORY_LEVEL
{
    MandatoryLevelUntrusted = 0,
    MandatoryLevelLow,
    MandatoryLevelMedium,
    MandatoryLevelHigh,
    MandatoryLevelSystem,
    MandatoryLevelSecureProcess,
    MandatoryLevelCount
} MANDATORY_LEVEL,
    *PMANDATORY_LEVEL;

typedef struct _TOKEN_APPCONTAINER_INFORMATION
{
    PSID TokenAppContainer;
} TOKEN_APPCONTAINER_INFORMATION, *PTOKEN_APPCONTAINER_INFORMATION;

typedef struct _TOKEN_SID_INFORMATION
{
    PSID Sid;
} TOKEN_SID_INFORMATION, *PTOKEN_SID_INFORMATION;

typedef struct _TOKEN_BNO_ISOLATION_INFORMATION
{
    PWSTR IsolationPrefix;
    BOOLEAN IsolationEnabled;
} TOKEN_BNO_ISOLATION_INFORMATION, *PTOKEN_BNO_ISOLATION_INFORMATION;
typedef struct _CLAIM_SECURITY_ATTRIBUTE_FQBN_VALUE
{
    DWORD64 Version;
    PWSTR Name;
} CLAIM_SECURITY_ATTRIBUTE_FQBN_VALUE, *PCLAIM_SECURITY_ATTRIBUTE_FQBN_VALUE;

typedef struct _CLAIM_SECURITY_ATTRIBUTE_OCTET_STRING_VALUE
{
    PVOID pValue;
    DWORD ValueLength;
} CLAIM_SECURITY_ATTRIBUTE_OCTET_STRING_VALUE,
    *PCLAIM_SECURITY_ATTRIBUTE_OCTET_STRING_VALUE;
typedef struct _CLAIM_SECURITY_ATTRIBUTE_V1
{
    PWSTR Name;
    WORD ValueType;
    WORD Reserved;
    DWORD Flags;
    DWORD ValueCount;
    union
    {
        PLONG64 pInt64;
        PDWORD64 pUint64;
        PWSTR *ppString;
        PCLAIM_SECURITY_ATTRIBUTE_FQBN_VALUE pFqbn;
        PCLAIM_SECURITY_ATTRIBUTE_OCTET_STRING_VALUE pOctetString;
    } Values;
} CLAIM_SECURITY_ATTRIBUTE_V1, *PCLAIM_SECURITY_ATTRIBUTE_V1;

typedef struct _CLAIM_SECURITY_ATTRIBUTE_RELATIVE_V1
{
    DWORD Name;
    WORD ValueType;
    WORD Reserved;
    DWORD Flags;
    DWORD ValueCount;
    union
    {
        DWORD pInt64[1];
        DWORD pUint64[1];
        DWORD ppString[1];
        DWORD pFqbn[1];
        DWORD pOctetString[1];
    } Values;
} CLAIM_SECURITY_ATTRIBUTE_RELATIVE_V1, *PCLAIM_SECURITY_ATTRIBUTE_RELATIVE_V1;
typedef struct _CLAIM_SECURITY_ATTRIBUTES_INFORMATION
{
    WORD Version;
    WORD Reserved;
    DWORD AttributeCount;
    union
    {
        PCLAIM_SECURITY_ATTRIBUTE_V1 pAttributeV1;
    } Attribute;
} CLAIM_SECURITY_ATTRIBUTES_INFORMATION, *PCLAIM_SECURITY_ATTRIBUTES_INFORMATION;

typedef BOOLEAN SECURITY_CONTEXT_TRACKING_MODE,
    *PSECURITY_CONTEXT_TRACKING_MODE;

typedef struct _SECURITY_QUALITY_OF_SERVICE
{
    DWORD Length;
    SECURITY_IMPERSONATION_LEVEL ImpersonationLevel;
    SECURITY_CONTEXT_TRACKING_MODE ContextTrackingMode;
    BOOLEAN EffectiveOnly;
} SECURITY_QUALITY_OF_SERVICE, *PSECURITY_QUALITY_OF_SERVICE;

typedef struct _SE_IMPERSONATION_STATE
{
    PACCESS_TOKEN Token;
    BOOLEAN CopyOnOpen;
    BOOLEAN EffectiveOnly;
    SECURITY_IMPERSONATION_LEVEL Level;
} SE_IMPERSONATION_STATE, *PSE_IMPERSONATION_STATE;

typedef DWORD SECURITY_INFORMATION, *PSECURITY_INFORMATION;
typedef BYTE SE_SIGNING_LEVEL, *PSE_SIGNING_LEVEL;
typedef enum _SE_IMAGE_SIGNATURE_TYPE
{
    SeImageSignatureNone = 0,
    SeImageSignatureEmbedded,
    SeImageSignatureCache,
    SeImageSignatureCatalogCached,
    SeImageSignatureCatalogNotCached,
    SeImageSignatureCatalogHint,
    SeImageSignaturePackageCatalog,
} SE_IMAGE_SIGNATURE_TYPE,
    *PSE_IMAGE_SIGNATURE_TYPE;

typedef enum _SE_LEARNING_MODE_DATA_TYPE
{
    SeLearningModeInvalidType = 0,
    SeLearningModeSettings,
    SeLearningModeMax
} SE_LEARNING_MODE_DATA_TYPE;

typedef struct _SECURITY_CAPABILITIES
{
    PSID AppContainerSid;
    PSID_AND_ATTRIBUTES Capabilities;
    DWORD CapabilityCount;
    DWORD Reserved;
} SECURITY_CAPABILITIES, *PSECURITY_CAPABILITIES, *LPSECURITY_CAPABILITIES;
typedef struct _JOB_SET_ARRAY
{
    HANDLE JobHandle;
    DWORD MemberLevel;
    DWORD Flags;
} JOB_SET_ARRAY, *PJOB_SET_ARRAY;

typedef struct _EXCEPTION_REGISTRATION_RECORD
{
    struct _EXCEPTION_REGISTRATION_RECORD *Next;
    PEXCEPTION_ROUTINE Handler;
} EXCEPTION_REGISTRATION_RECORD;

typedef EXCEPTION_REGISTRATION_RECORD *PEXCEPTION_REGISTRATION_RECORD;

typedef struct _NT_TIB
{
    struct _EXCEPTION_REGISTRATION_RECORD *ExceptionList;
    PVOID StackBase;
    PVOID StackLimit;
    PVOID SubSystemTib;
    PVOID FiberData;
    PVOID ArbitraryUserPointer;
    struct _NT_TIB *Self;
} NT_TIB;
typedef NT_TIB *PNT_TIB;

typedef struct _NT_TIB32
{
    DWORD ExceptionList;
    DWORD StackBase;
    DWORD StackLimit;
    DWORD SubSystemTib;
    DWORD FiberData;
    DWORD ArbitraryUserPointer;
    DWORD Self;
} NT_TIB32, *PNT_TIB32;

typedef struct _NT_TIB64
{
    DWORD64 ExceptionList;
    DWORD64 StackBase;
    DWORD64 StackLimit;
    DWORD64 SubSystemTib;
    DWORD64 FiberData;
    DWORD64 ArbitraryUserPointer;
    DWORD64 Self;
} NT_TIB64, *PNT_TIB64;

typedef struct _UMS_CREATE_THREAD_ATTRIBUTES
{
    DWORD UmsVersion;
    PVOID UmsContext;
    PVOID UmsCompletionList;
} UMS_CREATE_THREAD_ATTRIBUTES, *PUMS_CREATE_THREAD_ATTRIBUTES;

typedef struct _WOW64_ARCHITECTURE_INFORMATION
{
    DWORD Machine : 16;
    DWORD KernelMode : 1;
    DWORD UserMode : 1;
    DWORD Native : 1;
    DWORD Process : 1;
    DWORD ReservedZero0 : 12;
} WOW64_ARCHITECTURE_INFORMATION;
typedef struct _PROCESS_DYNAMIC_EH_CONTINUATION_TARGET
{
    ULONG_PTR TargetAddress;
    ULONG_PTR Flags;
} PROCESS_DYNAMIC_EH_CONTINUATION_TARGET, *PPROCESS_DYNAMIC_EH_CONTINUATION_TARGET;

typedef struct _PROCESS_DYNAMIC_EH_CONTINUATION_TARGETS_INFORMATION
{
    WORD NumberOfTargets;
    WORD Reserved;
    DWORD Reserved2;
    PPROCESS_DYNAMIC_EH_CONTINUATION_TARGET Targets;
} PROCESS_DYNAMIC_EH_CONTINUATION_TARGETS_INFORMATION, *PPROCESS_DYNAMIC_EH_CONTINUATION_TARGETS_INFORMATION;
typedef struct _PROCESS_DYNAMIC_ENFORCED_ADDRESS_RANGE
{
    ULONG_PTR BaseAddress;
    SIZE_T Size;
    DWORD Flags;
} PROCESS_DYNAMIC_ENFORCED_ADDRESS_RANGE, *PPROCESS_DYNAMIC_ENFORCED_ADDRESS_RANGE;

typedef struct _PROCESS_DYNAMIC_ENFORCED_ADDRESS_RANGES_INFORMATION
{
    WORD NumberOfRanges;
    WORD Reserved;
    DWORD Reserved2;
    PPROCESS_DYNAMIC_ENFORCED_ADDRESS_RANGE Ranges;
} PROCESS_DYNAMIC_ENFORCED_ADDRESS_RANGES_INFORMATION, *PPROCESS_DYNAMIC_ENFORCED_ADDRESS_RANGES_INFORMATION;

typedef struct _QUOTA_LIMITS
{
    SIZE_T PagedPoolLimit;
    SIZE_T NonPagedPoolLimit;
    SIZE_T MinimumWorkingSetSize;
    SIZE_T MaximumWorkingSetSize;
    SIZE_T PagefileLimit;
    LARGE_INTEGER TimeLimit;
} QUOTA_LIMITS, *PQUOTA_LIMITS;

typedef union _RATE_QUOTA_LIMIT
{
    DWORD RateData;
    struct
    {
        DWORD RatePercent : 7;
        DWORD Reserved0 : 25;
    } s;
} RATE_QUOTA_LIMIT, *PRATE_QUOTA_LIMIT;

typedef struct _QUOTA_LIMITS_EX
{
    SIZE_T PagedPoolLimit;
    SIZE_T NonPagedPoolLimit;
    SIZE_T MinimumWorkingSetSize;
    SIZE_T MaximumWorkingSetSize;
    SIZE_T PagefileLimit;
    LARGE_INTEGER TimeLimit;
    SIZE_T WorkingSetLimit;
    SIZE_T Reserved2;
    SIZE_T Reserved3;
    SIZE_T Reserved4;
    DWORD Flags;
    RATE_QUOTA_LIMIT CpuRateLimit;
} QUOTA_LIMITS_EX, *PQUOTA_LIMITS_EX;

typedef struct _IO_COUNTERS
{
    ULONGLONG ReadOperationCount;
    ULONGLONG WriteOperationCount;
    ULONGLONG OtherOperationCount;
    ULONGLONG ReadTransferCount;
    ULONGLONG WriteTransferCount;
    ULONGLONG OtherTransferCount;
} IO_COUNTERS;
typedef IO_COUNTERS *PIO_COUNTERS;

typedef enum _HARDWARE_COUNTER_TYPE
{
    PMCCounter,
    MaxHardwareCounterType
} HARDWARE_COUNTER_TYPE,
    *PHARDWARE_COUNTER_TYPE;
typedef enum _PROCESS_MITIGATION_POLICY
{
    ProcessDEPPolicy,
    ProcessASLRPolicy,
    ProcessDynamicCodePolicy,
    ProcessStrictHandleCheckPolicy,
    ProcessSystemCallDisablePolicy,
    ProcessMitigationOptionsMask,
    ProcessExtensionPointDisablePolicy,
    ProcessControlFlowGuardPolicy,
    ProcessSignaturePolicy,
    ProcessFontDisablePolicy,
    ProcessImageLoadPolicy,
    ProcessSystemCallFilterPolicy,
    ProcessPayloadRestrictionPolicy,
    ProcessChildProcessPolicy,
    ProcessSideChannelIsolationPolicy,
    ProcessUserShadowStackPolicy,
    MaxProcessMitigationPolicy
} PROCESS_MITIGATION_POLICY,
    *PPROCESS_MITIGATION_POLICY;

typedef struct _PROCESS_MITIGATION_ASLR_POLICY
{
    union
    {
        DWORD Flags;
        struct
        {
            DWORD EnableBottomUpRandomization : 1;
            DWORD EnableForceRelocateImages : 1;
            DWORD EnableHighEntropy : 1;
            DWORD DisallowStrippedImages : 1;
            DWORD ReservedFlags : 28;
        } s;
    } u;
} PROCESS_MITIGATION_ASLR_POLICY, *PPROCESS_MITIGATION_ASLR_POLICY;

typedef struct _PROCESS_MITIGATION_DEP_POLICY
{
    union
    {
        DWORD Flags;
        struct
        {
            DWORD Enable : 1;
            DWORD DisableAtlThunkEmulation : 1;
            DWORD ReservedFlags : 30;
        } s;
    } u;
    BOOLEAN Permanent;
} PROCESS_MITIGATION_DEP_POLICY, *PPROCESS_MITIGATION_DEP_POLICY;

typedef struct _PROCESS_MITIGATION_STRICT_HANDLE_CHECK_POLICY
{
    union
    {
        DWORD Flags;
        struct
        {
            DWORD RaiseExceptionOnInvalidHandleReference : 1;
            DWORD HandleExceptionsPermanentlyEnabled : 1;
            DWORD ReservedFlags : 30;
        } s;
    } u;
} PROCESS_MITIGATION_STRICT_HANDLE_CHECK_POLICY, *PPROCESS_MITIGATION_STRICT_HANDLE_CHECK_POLICY;

typedef struct _PROCESS_MITIGATION_SYSTEM_CALL_DISABLE_POLICY
{
    union
    {
        DWORD Flags;
        struct
        {
            DWORD DisallowWin32kSystemCalls : 1;
            DWORD AuditDisallowWin32kSystemCalls : 1;
            DWORD ReservedFlags : 30;
        } s;
    } u;
} PROCESS_MITIGATION_SYSTEM_CALL_DISABLE_POLICY, *PPROCESS_MITIGATION_SYSTEM_CALL_DISABLE_POLICY;

typedef struct _PROCESS_MITIGATION_EXTENSION_POINT_DISABLE_POLICY
{
    union
    {
        DWORD Flags;
        struct
        {
            DWORD DisableExtensionPoints : 1;
            DWORD ReservedFlags : 31;
        } s;
    } u;
} PROCESS_MITIGATION_EXTENSION_POINT_DISABLE_POLICY, *PPROCESS_MITIGATION_EXTENSION_POINT_DISABLE_POLICY;

typedef struct _PROCESS_MITIGATION_DYNAMIC_CODE_POLICY
{
    union
    {
        DWORD Flags;
        struct
        {
            DWORD ProhibitDynamicCode : 1;
            DWORD AllowThreadOptOut : 1;
            DWORD AllowRemoteDowngrade : 1;
            DWORD AuditProhibitDynamicCode : 1;
            DWORD ReservedFlags : 28;
        } s;
    } u;
} PROCESS_MITIGATION_DYNAMIC_CODE_POLICY, *PPROCESS_MITIGATION_DYNAMIC_CODE_POLICY;

typedef struct _PROCESS_MITIGATION_CONTROL_FLOW_GUARD_POLICY
{
    union
    {
        DWORD Flags;
        struct
        {
            DWORD EnableControlFlowGuard : 1;
            DWORD EnableExportSuppression : 1;
            DWORD StrictMode : 1;
            DWORD ReservedFlags : 29;
        } s;
    } u;
} PROCESS_MITIGATION_CONTROL_FLOW_GUARD_POLICY, *PPROCESS_MITIGATION_CONTROL_FLOW_GUARD_POLICY;

typedef struct _PROCESS_MITIGATION_BINARY_SIGNATURE_POLICY
{
    union
    {
        DWORD Flags;
        struct
        {
            DWORD MicrosoftSignedOnly : 1;
            DWORD StoreSignedOnly : 1;
            DWORD MitigationOptIn : 1;
            DWORD AuditMicrosoftSignedOnly : 1;
            DWORD AuditStoreSignedOnly : 1;
            DWORD ReservedFlags : 27;
        } s;
    } u;
} PROCESS_MITIGATION_BINARY_SIGNATURE_POLICY, *PPROCESS_MITIGATION_BINARY_SIGNATURE_POLICY;

typedef struct _PROCESS_MITIGATION_FONT_DISABLE_POLICY
{
    union
    {
        DWORD Flags;
        struct
        {
            DWORD DisableNonSystemFonts : 1;
            DWORD AuditNonSystemFontLoading : 1;
            DWORD ReservedFlags : 30;
        } s;
    } u;
} PROCESS_MITIGATION_FONT_DISABLE_POLICY, *PPROCESS_MITIGATION_FONT_DISABLE_POLICY;

typedef struct _PROCESS_MITIGATION_IMAGE_LOAD_POLICY
{
    union
    {
        DWORD Flags;
        struct
        {
            DWORD NoRemoteImages : 1;
            DWORD NoLowMandatoryLabelImages : 1;
            DWORD PreferSystem32Images : 1;
            DWORD AuditNoRemoteImages : 1;
            DWORD AuditNoLowMandatoryLabelImages : 1;
            DWORD ReservedFlags : 27;
        } s;
    } u;
} PROCESS_MITIGATION_IMAGE_LOAD_POLICY, *PPROCESS_MITIGATION_IMAGE_LOAD_POLICY;

typedef struct _PROCESS_MITIGATION_SYSTEM_CALL_FILTER_POLICY
{
    union
    {
        DWORD Flags;
        struct
        {
            DWORD FilterId : 4;
            DWORD ReservedFlags : 28;
        } s;
    } u;
} PROCESS_MITIGATION_SYSTEM_CALL_FILTER_POLICY, *PPROCESS_MITIGATION_SYSTEM_CALL_FILTER_POLICY;

typedef struct _PROCESS_MITIGATION_PAYLOAD_RESTRICTION_POLICY
{
    union
    {
        DWORD Flags;
        struct
        {
            DWORD EnableExportAddressFilter : 1;
            DWORD AuditExportAddressFilter : 1;
            DWORD EnableExportAddressFilterPlus : 1;
            DWORD AuditExportAddressFilterPlus : 1;
            DWORD EnableImportAddressFilter : 1;
            DWORD AuditImportAddressFilter : 1;
            DWORD EnableRopStackPivot : 1;
            DWORD AuditRopStackPivot : 1;
            DWORD EnableRopCallerCheck : 1;
            DWORD AuditRopCallerCheck : 1;
            DWORD EnableRopSimExec : 1;
            DWORD AuditRopSimExec : 1;
            DWORD ReservedFlags : 20;
        } s;
    } u;
} PROCESS_MITIGATION_PAYLOAD_RESTRICTION_POLICY, *PPROCESS_MITIGATION_PAYLOAD_RESTRICTION_POLICY;

typedef struct _PROCESS_MITIGATION_CHILD_PROCESS_POLICY
{
    union
    {
        DWORD Flags;
        struct
        {
            DWORD NoChildProcessCreation : 1;
            DWORD AuditNoChildProcessCreation : 1;
            DWORD AllowSecureProcessCreation : 1;
            DWORD ReservedFlags : 29;
        } s;
    } u;
} PROCESS_MITIGATION_CHILD_PROCESS_POLICY, *PPROCESS_MITIGATION_CHILD_PROCESS_POLICY;

typedef struct _PROCESS_MITIGATION_SIDE_CHANNEL_ISOLATION_POLICY
{
    union
    {
        DWORD Flags;
        struct
        {
            DWORD SmtBranchTargetIsolation : 1;
            DWORD IsolateSecurityDomain : 1;
            DWORD DisablePageCombine : 1;
            DWORD SpeculativeStoreBypassDisable : 1;
            DWORD ReservedFlags : 28;
        } s;
    } u;
} PROCESS_MITIGATION_SIDE_CHANNEL_ISOLATION_POLICY, *PPROCESS_MITIGATION_SIDE_CHANNEL_ISOLATION_POLICY;

typedef struct _PROCESS_MITIGATION_USER_SHADOW_STACK_POLICY
{
    union
    {
        DWORD Flags;
        struct
        {
            DWORD EnableUserShadowStack : 1;
            DWORD AuditUserShadowStack : 1;
            DWORD SetContextIpValidation : 1;
            DWORD AuditSetContextIpValidation : 1;
            DWORD EnableUserShadowStackStrictMode : 1;
            DWORD BlockNonCetBinaries : 1;
            DWORD BlockNonCetBinariesNonEhcont : 1;
            DWORD AuditBlockNonCetBinaries : 1;
            DWORD CetDynamicApisOutOfProcOnly : 1;
            DWORD SetContextIpValidationRelaxedMode : 1;
            DWORD ReservedFlags : 22;
        } s;
    } u;
} PROCESS_MITIGATION_USER_SHADOW_STACK_POLICY, *PPROCESS_MITIGATION_USER_SHADOW_STACK_POLICY;

typedef struct _JOBOBJECT_BASIC_ACCOUNTING_INFORMATION
{
    LARGE_INTEGER TotalUserTime;
    LARGE_INTEGER TotalKernelTime;
    LARGE_INTEGER ThisPeriodTotalUserTime;
    LARGE_INTEGER ThisPeriodTotalKernelTime;
    DWORD TotalPageFaultCount;
    DWORD TotalProcesses;
    DWORD ActiveProcesses;
    DWORD TotalTerminatedProcesses;
} JOBOBJECT_BASIC_ACCOUNTING_INFORMATION, *PJOBOBJECT_BASIC_ACCOUNTING_INFORMATION;

typedef struct _JOBOBJECT_BASIC_LIMIT_INFORMATION
{
    LARGE_INTEGER PerProcessUserTimeLimit;
    LARGE_INTEGER PerJobUserTimeLimit;
    DWORD LimitFlags;
    SIZE_T MinimumWorkingSetSize;
    SIZE_T MaximumWorkingSetSize;
    DWORD ActiveProcessLimit;
    ULONG_PTR Affinity;
    DWORD PriorityClass;
    DWORD SchedulingClass;
} JOBOBJECT_BASIC_LIMIT_INFORMATION, *PJOBOBJECT_BASIC_LIMIT_INFORMATION;

typedef struct _JOBOBJECT_EXTENDED_LIMIT_INFORMATION
{
    JOBOBJECT_BASIC_LIMIT_INFORMATION BasicLimitInformation;
    IO_COUNTERS IoInfo;
    SIZE_T ProcessMemoryLimit;
    SIZE_T JobMemoryLimit;
    SIZE_T PeakProcessMemoryUsed;
    SIZE_T PeakJobMemoryUsed;
} JOBOBJECT_EXTENDED_LIMIT_INFORMATION, *PJOBOBJECT_EXTENDED_LIMIT_INFORMATION;

typedef struct _JOBOBJECT_BASIC_PROCESS_ID_LIST
{
    DWORD NumberOfAssignedProcesses;
    DWORD NumberOfProcessIdsInList;
    ULONG_PTR ProcessIdList[1];
} JOBOBJECT_BASIC_PROCESS_ID_LIST, *PJOBOBJECT_BASIC_PROCESS_ID_LIST;

typedef struct _JOBOBJECT_BASIC_UI_RESTRICTIONS
{
    DWORD UIRestrictionsClass;
} JOBOBJECT_BASIC_UI_RESTRICTIONS, *PJOBOBJECT_BASIC_UI_RESTRICTIONS;

typedef struct _JOBOBJECT_SECURITY_LIMIT_INFORMATION
{
    DWORD SecurityLimitFlags;
    HANDLE JobToken;
    PTOKEN_GROUPS SidsToDisable;
    PTOKEN_PRIVILEGES PrivilegesToDelete;
    PTOKEN_GROUPS RestrictedSids;
} JOBOBJECT_SECURITY_LIMIT_INFORMATION, *PJOBOBJECT_SECURITY_LIMIT_INFORMATION;

typedef struct _JOBOBJECT_END_OF_JOB_TIME_INFORMATION
{
    DWORD EndOfJobTimeAction;
} JOBOBJECT_END_OF_JOB_TIME_INFORMATION, *PJOBOBJECT_END_OF_JOB_TIME_INFORMATION;

typedef struct _JOBOBJECT_ASSOCIATE_COMPLETION_PORT
{
    PVOID CompletionKey;
    HANDLE CompletionPort;
} JOBOBJECT_ASSOCIATE_COMPLETION_PORT, *PJOBOBJECT_ASSOCIATE_COMPLETION_PORT;

typedef struct _JOBOBJECT_BASIC_AND_IO_ACCOUNTING_INFORMATION
{
    JOBOBJECT_BASIC_ACCOUNTING_INFORMATION BasicInfo;
    IO_COUNTERS IoInfo;
} JOBOBJECT_BASIC_AND_IO_ACCOUNTING_INFORMATION, *PJOBOBJECT_BASIC_AND_IO_ACCOUNTING_INFORMATION;

typedef struct _JOBOBJECT_JOBSET_INFORMATION
{
    DWORD MemberLevel;
} JOBOBJECT_JOBSET_INFORMATION, *PJOBOBJECT_JOBSET_INFORMATION;

typedef enum _JOBOBJECT_RATE_CONTROL_TOLERANCE
{
    ToleranceLow = 1,
    ToleranceMedium,
    ToleranceHigh
} JOBOBJECT_RATE_CONTROL_TOLERANCE,
    *PJOBOBJECT_RATE_CONTROL_TOLERANCE;

typedef enum _JOBOBJECT_RATE_CONTROL_TOLERANCE_INTERVAL
{
    ToleranceIntervalShort = 1,
    ToleranceIntervalMedium,
    ToleranceIntervalLong
} JOBOBJECT_RATE_CONTROL_TOLERANCE_INTERVAL,
    *PJOBOBJECT_RATE_CONTROL_TOLERANCE_INTERVAL;

typedef struct _JOBOBJECT_NOTIFICATION_LIMIT_INFORMATION
{
    DWORD64 IoReadBytesLimit;
    DWORD64 IoWriteBytesLimit;
    LARGE_INTEGER PerJobUserTimeLimit;
    DWORD64 JobMemoryLimit;
    JOBOBJECT_RATE_CONTROL_TOLERANCE RateControlTolerance;
    JOBOBJECT_RATE_CONTROL_TOLERANCE_INTERVAL RateControlToleranceInterval;
    DWORD LimitFlags;
} JOBOBJECT_NOTIFICATION_LIMIT_INFORMATION, *PJOBOBJECT_NOTIFICATION_LIMIT_INFORMATION;

typedef struct JOBOBJECT_NOTIFICATION_LIMIT_INFORMATION_2
{
    DWORD64 IoReadBytesLimit;
    DWORD64 IoWriteBytesLimit;
    LARGE_INTEGER PerJobUserTimeLimit;
    union
    {
        DWORD64 JobHighMemoryLimit;
        DWORD64 JobMemoryLimit;
    } u;
    union
    {
        JOBOBJECT_RATE_CONTROL_TOLERANCE RateControlTolerance;
        JOBOBJECT_RATE_CONTROL_TOLERANCE CpuRateControlTolerance;
    } u2;
    union
    {
        JOBOBJECT_RATE_CONTROL_TOLERANCE_INTERVAL RateControlToleranceInterval;
        JOBOBJECT_RATE_CONTROL_TOLERANCE_INTERVAL
        CpuRateControlToleranceInterval;
    } u3;
    DWORD LimitFlags;
    JOBOBJECT_RATE_CONTROL_TOLERANCE IoRateControlTolerance;
    DWORD64 JobLowMemoryLimit;
    JOBOBJECT_RATE_CONTROL_TOLERANCE_INTERVAL IoRateControlToleranceInterval;
    JOBOBJECT_RATE_CONTROL_TOLERANCE NetRateControlTolerance;
    JOBOBJECT_RATE_CONTROL_TOLERANCE_INTERVAL NetRateControlToleranceInterval;
} JOBOBJECT_NOTIFICATION_LIMIT_INFORMATION_2;

typedef struct _JOBOBJECT_LIMIT_VIOLATION_INFORMATION
{
    DWORD LimitFlags;
    DWORD ViolationLimitFlags;
    DWORD64 IoReadBytes;
    DWORD64 IoReadBytesLimit;
    DWORD64 IoWriteBytes;
    DWORD64 IoWriteBytesLimit;
    LARGE_INTEGER PerJobUserTime;
    LARGE_INTEGER PerJobUserTimeLimit;
    DWORD64 JobMemory;
    DWORD64 JobMemoryLimit;
    JOBOBJECT_RATE_CONTROL_TOLERANCE RateControlTolerance;
    JOBOBJECT_RATE_CONTROL_TOLERANCE RateControlToleranceLimit;
} JOBOBJECT_LIMIT_VIOLATION_INFORMATION, *PJOBOBJECT_LIMIT_VIOLATION_INFORMATION;

typedef struct JOBOBJECT_LIMIT_VIOLATION_INFORMATION_2
{
    DWORD LimitFlags;
    DWORD ViolationLimitFlags;
    DWORD64 IoReadBytes;
    DWORD64 IoReadBytesLimit;
    DWORD64 IoWriteBytes;
    DWORD64 IoWriteBytesLimit;
    LARGE_INTEGER PerJobUserTime;
    LARGE_INTEGER PerJobUserTimeLimit;
    DWORD64 JobMemory;
    union
    {
        DWORD64 JobHighMemoryLimit;
        DWORD64 JobMemoryLimit;
    } u;
    union
    {
        JOBOBJECT_RATE_CONTROL_TOLERANCE RateControlTolerance;
        JOBOBJECT_RATE_CONTROL_TOLERANCE CpuRateControlTolerance;
    } u2;
    union
    {
        JOBOBJECT_RATE_CONTROL_TOLERANCE RateControlToleranceLimit;
        JOBOBJECT_RATE_CONTROL_TOLERANCE CpuRateControlToleranceLimit;
    } u3;
    DWORD64 JobLowMemoryLimit;
    JOBOBJECT_RATE_CONTROL_TOLERANCE IoRateControlTolerance;
    JOBOBJECT_RATE_CONTROL_TOLERANCE IoRateControlToleranceLimit;
    JOBOBJECT_RATE_CONTROL_TOLERANCE NetRateControlTolerance;
    JOBOBJECT_RATE_CONTROL_TOLERANCE NetRateControlToleranceLimit;
} JOBOBJECT_LIMIT_VIOLATION_INFORMATION_2;

typedef struct _JOBOBJECT_CPU_RATE_CONTROL_INFORMATION
{
    DWORD ControlFlags;
    union
    {
        DWORD CpuRate;
        DWORD Weight;
        struct
        {
            WORD MinRate;
            WORD MaxRate;
        } s;
    } u;
} JOBOBJECT_CPU_RATE_CONTROL_INFORMATION, *PJOBOBJECT_CPU_RATE_CONTROL_INFORMATION;

typedef enum JOB_OBJECT_NET_RATE_CONTROL_FLAGS
{
    JOB_OBJECT_NET_RATE_CONTROL_ENABLE = 0x1,
    JOB_OBJECT_NET_RATE_CONTROL_MAX_BANDWIDTH = 0x2,
    JOB_OBJECT_NET_RATE_CONTROL_DSCP_TAG = 0x4,
    JOB_OBJECT_NET_RATE_CONTROL_VALID_FLAGS = 0x7
} JOB_OBJECT_NET_RATE_CONTROL_FLAGS;

typedef char __C_ASSERT__[(JOB_OBJECT_NET_RATE_CONTROL_VALID_FLAGS == (JOB_OBJECT_NET_RATE_CONTROL_ENABLE + JOB_OBJECT_NET_RATE_CONTROL_MAX_BANDWIDTH + JOB_OBJECT_NET_RATE_CONTROL_DSCP_TAG)) ? 1 : -1];
typedef struct JOBOBJECT_NET_RATE_CONTROL_INFORMATION
{
    DWORD64 MaxBandwidth;
    JOB_OBJECT_NET_RATE_CONTROL_FLAGS ControlFlags;
    BYTE DscpTag;
} JOBOBJECT_NET_RATE_CONTROL_INFORMATION;

typedef enum JOB_OBJECT_IO_RATE_CONTROL_FLAGS
{
    JOB_OBJECT_IO_RATE_CONTROL_ENABLE = 0x1,
    JOB_OBJECT_IO_RATE_CONTROL_STANDALONE_VOLUME = 0x2,
    JOB_OBJECT_IO_RATE_CONTROL_FORCE_UNIT_ACCESS_ALL = 0x4,
    JOB_OBJECT_IO_RATE_CONTROL_FORCE_UNIT_ACCESS_ON_SOFT_CAP = 0x8,
    JOB_OBJECT_IO_RATE_CONTROL_VALID_FLAGS = JOB_OBJECT_IO_RATE_CONTROL_ENABLE |
                                             JOB_OBJECT_IO_RATE_CONTROL_STANDALONE_VOLUME |
                                             JOB_OBJECT_IO_RATE_CONTROL_FORCE_UNIT_ACCESS_ALL |
                                             JOB_OBJECT_IO_RATE_CONTROL_FORCE_UNIT_ACCESS_ON_SOFT_CAP
} JOB_OBJECT_IO_RATE_CONTROL_FLAGS;

typedef struct JOBOBJECT_IO_RATE_CONTROL_INFORMATION_NATIVE
{
    LONG64 MaxIops;
    LONG64 MaxBandwidth;
    LONG64 ReservationIops;
    PWSTR VolumeName;
    DWORD BaseIoSize;
    JOB_OBJECT_IO_RATE_CONTROL_FLAGS ControlFlags;
    WORD VolumeNameLength;
} JOBOBJECT_IO_RATE_CONTROL_INFORMATION_NATIVE;

typedef JOBOBJECT_IO_RATE_CONTROL_INFORMATION_NATIVE
    JOBOBJECT_IO_RATE_CONTROL_INFORMATION_NATIVE_V1;

typedef struct JOBOBJECT_IO_RATE_CONTROL_INFORMATION_NATIVE_V2
{
    LONG64 MaxIops;
    LONG64 MaxBandwidth;
    LONG64 ReservationIops;
    PWSTR VolumeName;
    DWORD BaseIoSize;
    JOB_OBJECT_IO_RATE_CONTROL_FLAGS ControlFlags;
    WORD VolumeNameLength;
    LONG64 CriticalReservationIops;
    LONG64 ReservationBandwidth;
    LONG64 CriticalReservationBandwidth;
    LONG64 MaxTimePercent;
    LONG64 ReservationTimePercent;
    LONG64 CriticalReservationTimePercent;
} JOBOBJECT_IO_RATE_CONTROL_INFORMATION_NATIVE_V2;

typedef struct JOBOBJECT_IO_RATE_CONTROL_INFORMATION_NATIVE_V3
{
    LONG64 MaxIops;
    LONG64 MaxBandwidth;
    LONG64 ReservationIops;
    PWSTR VolumeName;
    DWORD BaseIoSize;
    JOB_OBJECT_IO_RATE_CONTROL_FLAGS ControlFlags;
    WORD VolumeNameLength;
    LONG64 CriticalReservationIops;
    LONG64 ReservationBandwidth;
    LONG64 CriticalReservationBandwidth;
    LONG64 MaxTimePercent;
    LONG64 ReservationTimePercent;
    LONG64 CriticalReservationTimePercent;
    LONG64 SoftMaxIops;
    LONG64 SoftMaxBandwidth;
    LONG64 SoftMaxTimePercent;
    LONG64 LimitExcessNotifyIops;
    LONG64 LimitExcessNotifyBandwidth;
    LONG64 LimitExcessNotifyTimePercent;
} JOBOBJECT_IO_RATE_CONTROL_INFORMATION_NATIVE_V3;

typedef enum JOBOBJECT_IO_ATTRIBUTION_CONTROL_FLAGS
{
    JOBOBJECT_IO_ATTRIBUTION_CONTROL_ENABLE = 0x1,
    JOBOBJECT_IO_ATTRIBUTION_CONTROL_DISABLE = 0x2,
    JOBOBJECT_IO_ATTRIBUTION_CONTROL_VALID_FLAGS = 0x3
} JOBOBJECT_IO_ATTRIBUTION_CONTROL_FLAGS;

typedef struct _JOBOBJECT_IO_ATTRIBUTION_STATS
{
    ULONG_PTR IoCount;
    ULONGLONG TotalNonOverlappedQueueTime;
    ULONGLONG TotalNonOverlappedServiceTime;
    ULONGLONG TotalSize;

} JOBOBJECT_IO_ATTRIBUTION_STATS, *PJOBOBJECT_IO_ATTRIBUTION_STATS;

typedef struct _JOBOBJECT_IO_ATTRIBUTION_INFORMATION
{
    DWORD ControlFlags;
    JOBOBJECT_IO_ATTRIBUTION_STATS ReadStats;
    JOBOBJECT_IO_ATTRIBUTION_STATS WriteStats;

} JOBOBJECT_IO_ATTRIBUTION_INFORMATION, *PJOBOBJECT_IO_ATTRIBUTION_INFORMATION;
typedef enum _JOBOBJECTINFOCLASS
{
    JobObjectBasicAccountingInformation = 1,
    JobObjectBasicLimitInformation,
    JobObjectBasicProcessIdList,
    JobObjectBasicUIRestrictions,
    JobObjectSecurityLimitInformation,
    JobObjectEndOfJobTimeInformation,
    JobObjectAssociateCompletionPortInformation,
    JobObjectBasicAndIoAccountingInformation,
    JobObjectExtendedLimitInformation,
    JobObjectJobSetInformation,
    JobObjectGroupInformation,
    JobObjectNotificationLimitInformation,
    JobObjectLimitViolationInformation,
    JobObjectGroupInformationEx,
    JobObjectCpuRateControlInformation,
    JobObjectCompletionFilter,
    JobObjectCompletionCounter,
    JobObjectReserved1Information = 18,
    JobObjectReserved2Information,
    JobObjectReserved3Information,
    JobObjectReserved4Information,
    JobObjectReserved5Information,
    JobObjectReserved6Information,
    JobObjectReserved7Information,
    JobObjectReserved8Information,
    JobObjectReserved9Information,
    JobObjectReserved10Information,
    JobObjectReserved11Information,
    JobObjectReserved12Information,
    JobObjectReserved13Information,
    JobObjectReserved14Information = 31,
    JobObjectNetRateControlInformation,
    JobObjectNotificationLimitInformation2,
    JobObjectLimitViolationInformation2,
    JobObjectCreateSilo,
    JobObjectSiloBasicInformation,
    JobObjectReserved15Information = 37,
    JobObjectReserved16Information = 38,
    JobObjectReserved17Information = 39,
    JobObjectReserved18Information = 40,
    JobObjectReserved19Information = 41,
    JobObjectReserved20Information = 42,
    JobObjectReserved21Information = 43,
    JobObjectReserved22Information = 44,
    JobObjectReserved23Information = 45,
    JobObjectReserved24Information = 46,
    JobObjectReserved25Information = 47,
    MaxJobObjectInfoClass
} JOBOBJECTINFOCLASS;

typedef struct _SILOOBJECT_BASIC_INFORMATION
{
    DWORD SiloId;
    DWORD SiloParentId;
    DWORD NumberOfProcesses;
    BOOLEAN IsInServerSilo;
    BYTE Reserved[3];
} SILOOBJECT_BASIC_INFORMATION, *PSILOOBJECT_BASIC_INFORMATION;

typedef enum _SERVERSILO_STATE
{
    SERVERSILO_INITING = 0,
    SERVERSILO_STARTED,
    SERVERSILO_SHUTTING_DOWN,
    SERVERSILO_TERMINATING,
    SERVERSILO_TERMINATED,
} SERVERSILO_STATE,
    *PSERVERSILO_STATE;

typedef struct _SERVERSILO_BASIC_INFORMATION
{
    DWORD ServiceSessionId;
    SERVERSILO_STATE State;
    DWORD ExitStatus;
    BOOLEAN IsDownlevelContainer;
    PVOID ApiSetSchema;
    PVOID HostApiSetSchema;
} SERVERSILO_BASIC_INFORMATION, *PSERVERSILO_BASIC_INFORMATION;

typedef enum _FIRMWARE_TYPE
{
    FirmwareTypeUnknown,
    FirmwareTypeBios,
    FirmwareTypeUefi,
    FirmwareTypeMax
} FIRMWARE_TYPE,
    *PFIRMWARE_TYPE;
typedef enum _LOGICAL_PROCESSOR_RELATIONSHIP
{
    RelationProcessorCore,
    RelationNumaNode,
    RelationCache,
    RelationProcessorPackage,
    RelationGroup,
    RelationAll = 0xffff
} LOGICAL_PROCESSOR_RELATIONSHIP;

typedef enum _PROCESSOR_CACHE_TYPE
{
    CacheUnified,
    CacheInstruction,
    CacheData,
    CacheTrace
} PROCESSOR_CACHE_TYPE;

typedef struct _CACHE_DESCRIPTOR
{
    BYTE Level;
    BYTE Associativity;
    WORD LineSize;
    DWORD Size;
    PROCESSOR_CACHE_TYPE Type;
} CACHE_DESCRIPTOR, *PCACHE_DESCRIPTOR;

typedef struct _SYSTEM_LOGICAL_PROCESSOR_INFORMATION
{
    ULONG_PTR ProcessorMask;
    LOGICAL_PROCESSOR_RELATIONSHIP Relationship;
    union
    {
        struct
        {
            BYTE Flags;
        } ProcessorCore;
        struct
        {
            DWORD NodeNumber;
        } NumaNode;
        CACHE_DESCRIPTOR Cache;
        ULONGLONG Reserved[2];
    } u;
} SYSTEM_LOGICAL_PROCESSOR_INFORMATION, *PSYSTEM_LOGICAL_PROCESSOR_INFORMATION;

typedef struct _PROCESSOR_RELATIONSHIP
{
    BYTE Flags;
    BYTE EfficiencyClass;
    BYTE Reserved[20];
    WORD GroupCount;
    GROUP_AFFINITY GroupMask[1];
} PROCESSOR_RELATIONSHIP, *PPROCESSOR_RELATIONSHIP;

typedef struct _NUMA_NODE_RELATIONSHIP
{
    DWORD NodeNumber;
    BYTE Reserved[20];
    GROUP_AFFINITY GroupMask;
} NUMA_NODE_RELATIONSHIP, *PNUMA_NODE_RELATIONSHIP;

typedef struct _CACHE_RELATIONSHIP
{
    BYTE Level;
    BYTE Associativity;
    WORD LineSize;
    DWORD CacheSize;
    PROCESSOR_CACHE_TYPE Type;
    BYTE Reserved[20];
    GROUP_AFFINITY GroupMask;
} CACHE_RELATIONSHIP, *PCACHE_RELATIONSHIP;

typedef struct _PROCESSOR_GROUP_INFO
{
    BYTE MaximumProcessorCount;
    BYTE ActiveProcessorCount;
    BYTE Reserved[38];
    KAFFINITY ActiveProcessorMask;
} PROCESSOR_GROUP_INFO, *PPROCESSOR_GROUP_INFO;

typedef struct _GROUP_RELATIONSHIP
{
    WORD MaximumGroupCount;
    WORD ActiveGroupCount;
    BYTE Reserved[20];
    PROCESSOR_GROUP_INFO GroupInfo[1];
} GROUP_RELATIONSHIP, *PGROUP_RELATIONSHIP;

struct _SYSTEM_LOGICAL_PROCESSOR_INFORMATION_EX
{
    LOGICAL_PROCESSOR_RELATIONSHIP Relationship;
    DWORD Size;
    union
    {
        PROCESSOR_RELATIONSHIP Processor;
        NUMA_NODE_RELATIONSHIP NumaNode;
        CACHE_RELATIONSHIP Cache;
        GROUP_RELATIONSHIP Group;
    } u;
};

typedef struct _SYSTEM_LOGICAL_PROCESSOR_INFORMATION_EX SYSTEM_LOGICAL_PROCESSOR_INFORMATION_EX, *PSYSTEM_LOGICAL_PROCESSOR_INFORMATION_EX;

typedef enum _CPU_SET_INFORMATION_TYPE
{
    CpuSetInformation
} CPU_SET_INFORMATION_TYPE,
    *PCPU_SET_INFORMATION_TYPE;

struct _SYSTEM_CPU_SET_INFORMATION
{
    DWORD Size;
    CPU_SET_INFORMATION_TYPE Type;
    union
    {
        struct
        {
            DWORD Id;
            WORD Group;
            BYTE LogicalProcessorIndex;
            BYTE CoreIndex;
            BYTE LastLevelCacheIndex;
            BYTE NumaNodeIndex;
            BYTE EfficiencyClass;
            union
            {
                BYTE AllFlags;
                struct
                {
                    BYTE Parked : 1;
                    BYTE Allocated : 1;
                    BYTE AllocatedToTargetProcess : 1;
                    BYTE RealTime : 1;
                    BYTE ReservedFlags : 4;
                } s;
            } u2;
            union
            {
                DWORD Reserved;
                BYTE SchedulingClass;
            };
            DWORD64 AllocationTag;
        } CpuSet;
    } u;
};

typedef struct _SYSTEM_CPU_SET_INFORMATION SYSTEM_CPU_SET_INFORMATION, *PSYSTEM_CPU_SET_INFORMATION;

typedef struct _SYSTEM_POOL_ZEROING_INFORMATION
{
    BOOLEAN PoolZeroingSupportPresent;
} SYSTEM_POOL_ZEROING_INFORMATION, *PSYSTEM_POOL_ZEROING_INFORMATION;

typedef struct _SYSTEM_PROCESSOR_CYCLE_TIME_INFORMATION
{
    DWORD64 CycleTime;
} SYSTEM_PROCESSOR_CYCLE_TIME_INFORMATION, *PSYSTEM_PROCESSOR_CYCLE_TIME_INFORMATION;
typedef struct _XSTATE_FEATURE
{
    DWORD Offset;
    DWORD Size;
} XSTATE_FEATURE, *PXSTATE_FEATURE;

typedef struct _XSTATE_CONFIGURATION
{
    DWORD64 EnabledFeatures;
    DWORD64 EnabledVolatileFeatures;
    DWORD Size;
    union
    {
        DWORD ControlFlags;
        struct
        {
            DWORD OptimizedSave : 1;
            DWORD CompactionEnabled : 1;
        };
    };
    XSTATE_FEATURE Features[(64)];
    DWORD64 EnabledSupervisorFeatures;
    DWORD64 AlignedFeatures;
    DWORD AllFeatureSize;
    DWORD AllFeatures[(64)];
    DWORD64 EnabledUserVisibleSupervisorFeatures;

} XSTATE_CONFIGURATION, *PXSTATE_CONFIGURATION;

typedef struct _MEMORY_BASIC_INFORMATION
{
    PVOID BaseAddress;
    PVOID AllocationBase;
    DWORD AllocationProtect;
    SIZE_T RegionSize;
    DWORD State;
    DWORD Protect;
    DWORD Type;
} MEMORY_BASIC_INFORMATION, *PMEMORY_BASIC_INFORMATION;

typedef struct _MEMORY_BASIC_INFORMATION32
{
    DWORD BaseAddress;
    DWORD AllocationBase;
    DWORD AllocationProtect;
    DWORD RegionSize;
    DWORD State;
    DWORD Protect;
    DWORD Type;
} MEMORY_BASIC_INFORMATION32, *PMEMORY_BASIC_INFORMATION32;

typedef struct _MEMORY_BASIC_INFORMATION64
{
    ULONGLONG BaseAddress;
    ULONGLONG AllocationBase;
    DWORD AllocationProtect;
    DWORD __alignment1;
    ULONGLONG RegionSize;
    DWORD State;
    DWORD Protect;
    DWORD Type;
    DWORD __alignment2;
} MEMORY_BASIC_INFORMATION64, *PMEMORY_BASIC_INFORMATION64;
typedef struct _CFG_CALL_TARGET_INFO
{
    ULONG_PTR Offset;
    ULONG_PTR Flags;
} CFG_CALL_TARGET_INFO, *PCFG_CALL_TARGET_INFO;
typedef struct _MEM_ADDRESS_REQUIREMENTS
{
    PVOID LowestStartingAddress;
    PVOID HighestEndingAddress;
    SIZE_T Alignment;
} MEM_ADDRESS_REQUIREMENTS, *PMEM_ADDRESS_REQUIREMENTS;
typedef enum MEM_EXTENDED_PARAMETER_TYPE
{
    MemExtendedParameterInvalidType = 0,
    MemExtendedParameterAddressRequirements,
    MemExtendedParameterNumaNode,
    MemExtendedParameterPartitionHandle,
    MemExtendedParameterUserPhysicalHandle,
    MemExtendedParameterAttributeFlags,
    MemExtendedParameterMax
} MEM_EXTENDED_PARAMETER_TYPE,
    *PMEM_EXTENDED_PARAMETER_TYPE;

typedef struct MEM_EXTENDED_PARAMETER
{
    struct
    {
        DWORD64 Type : 8;
        DWORD64 Reserved : 64 - 8;
    } s;
    union
    {
        DWORD64 ULong64;
        PVOID Pointer;
        SIZE_T Size;
        HANDLE Handle;
        DWORD ULong;
    } u;

} MEM_EXTENDED_PARAMETER, *PMEM_EXTENDED_PARAMETER;
typedef enum MEM_SECTION_EXTENDED_PARAMETER_TYPE
{
    MemSectionExtendedParameterInvalidType = 0,
    MemSectionExtendedParameterUserPhysicalFlags,
    MemSectionExtendedParameterNumaNode,
    MemSectionExtendedParameterMax
} MEM_SECTION_EXTENDED_PARAMETER_TYPE,
    *PMEM_SECTION_EXTENDED_PARAMETER_TYPE;

typedef struct _ENCLAVE_CREATE_INFO_SGX
{
    BYTE Secs[4096];
} ENCLAVE_CREATE_INFO_SGX, *PENCLAVE_CREATE_INFO_SGX;

typedef struct _ENCLAVE_INIT_INFO_SGX
{
    BYTE SigStruct[1808];
    BYTE Reserved1[240];
    BYTE EInitToken[304];
    BYTE Reserved2[1744];
} ENCLAVE_INIT_INFO_SGX, *PENCLAVE_INIT_INFO_SGX;

typedef struct _ENCLAVE_CREATE_INFO_VBS
{
    DWORD Flags;
    BYTE OwnerID[32];
} ENCLAVE_CREATE_INFO_VBS, *PENCLAVE_CREATE_INFO_VBS;

typedef struct _ENCLAVE_CREATE_INFO_VBS_BASIC
{
    DWORD Flags;
    BYTE OwnerID[32];
} ENCLAVE_CREATE_INFO_VBS_BASIC, *PENCLAVE_CREATE_INFO_VBS_BASIC;

typedef struct _ENCLAVE_LOAD_DATA_VBS_BASIC
{
    DWORD PageType;
} ENCLAVE_LOAD_DATA_VBS_BASIC, *PENCLAVE_LOAD_DATA_VBS_BASIC;

typedef struct _ENCLAVE_INIT_INFO_VBS_BASIC
{
    BYTE FamilyId[16];
    BYTE ImageId[16];
    ULONGLONG EnclaveSize;
    DWORD EnclaveSvn;
    DWORD Reserved;
    union
    {
        HANDLE SignatureInfoHandle;
        ULONGLONG Unused;
    } u;
} ENCLAVE_INIT_INFO_VBS_BASIC, *PENCLAVE_INIT_INFO_VBS_BASIC;

typedef struct _ENCLAVE_INIT_INFO_VBS
{
    DWORD Length;
    DWORD ThreadCount;
} ENCLAVE_INIT_INFO_VBS, *PENCLAVE_INIT_INFO_VBS;

typedef PVOID(ENCLAVE_TARGET_FUNCTION)(PVOID);
typedef ENCLAVE_TARGET_FUNCTION(*PENCLAVE_TARGET_FUNCTION);
typedef PENCLAVE_TARGET_FUNCTION LPENCLAVE_TARGET_FUNCTION;
typedef struct _FILE_ID_128
{
    BYTE Identifier[16];
} FILE_ID_128, *PFILE_ID_128;

typedef struct _FILE_NOTIFY_INFORMATION
{
    DWORD NextEntryOffset;
    DWORD Action;
    DWORD FileNameLength;
    WCHAR FileName[1];
} FILE_NOTIFY_INFORMATION, *PFILE_NOTIFY_INFORMATION;

typedef struct _FILE_NOTIFY_EXTENDED_INFORMATION
{
    DWORD NextEntryOffset;
    DWORD Action;
    LARGE_INTEGER CreationTime;
    LARGE_INTEGER LastModificationTime;
    LARGE_INTEGER LastChangeTime;
    LARGE_INTEGER LastAccessTime;
    LARGE_INTEGER AllocatedLength;
    LARGE_INTEGER FileSize;
    DWORD FileAttributes;
    DWORD ReparsePointTag;
    LARGE_INTEGER FileId;
    LARGE_INTEGER ParentFileId;
    DWORD FileNameLength;
    WCHAR FileName[1];
} FILE_NOTIFY_EXTENDED_INFORMATION, *PFILE_NOTIFY_EXTENDED_INFORMATION;
typedef union _FILE_SEGMENT_ELEMENT
{
    PVOID64 Buffer;
    ULONGLONG Alignment;
} FILE_SEGMENT_ELEMENT, *PFILE_SEGMENT_ELEMENT;
typedef struct _REPARSE_GUID_DATA_BUFFER
{
    DWORD ReparseTag;
    WORD ReparseDataLength;
    WORD Reserved;
    GUID ReparseGuid;
    struct
    {
        BYTE DataBuffer[1];
    } GenericReparseBuffer;
} REPARSE_GUID_DATA_BUFFER, *PREPARSE_GUID_DATA_BUFFER;
typedef struct _SCRUB_DATA_INPUT
{
    DWORD Size;
    DWORD Flags;
    DWORD MaximumIos;
    DWORD ObjectId[4];
    DWORD Reserved[25];
    BYTE ResumeContext[816];

} SCRUB_DATA_INPUT, *PSCRUB_DATA_INPUT;

typedef struct _SCRUB_PARITY_EXTENT
{
    LONGLONG Offset;
    ULONGLONG Length;

} SCRUB_PARITY_EXTENT, *PSCRUB_PARITY_EXTENT;

typedef struct _SCRUB_PARITY_EXTENT_DATA
{
    WORD Size;
    WORD Flags;
    WORD NumberOfParityExtents;
    WORD MaximumNumberOfParityExtents;
    SCRUB_PARITY_EXTENT ParityExtents[1];

} SCRUB_PARITY_EXTENT_DATA, *PSCRUB_PARITY_EXTENT_DATA;

typedef struct _SCRUB_DATA_OUTPUT
{
    DWORD Size;
    DWORD Flags;
    DWORD Status;
    ULONGLONG ErrorFileOffset;
    ULONGLONG ErrorLength;
    ULONGLONG NumberOfBytesRepaired;
    ULONGLONG NumberOfBytesFailed;
    ULONGLONG InternalFileReference;
    WORD ResumeContextLength;
    WORD ParityExtentDataOffset;
    DWORD Reserved[9];
    ULONGLONG NumberOfMetadataBytesProcessed;
    ULONGLONG NumberOfDataBytesProcessed;
    ULONGLONG TotalNumberOfMetadataBytesInUse;
    ULONGLONG TotalNumberOfDataBytesInUse;
    BYTE ResumeContext[816];

} SCRUB_DATA_OUTPUT, *PSCRUB_DATA_OUTPUT;
typedef enum _SharedVirtualDiskSupportType
{
    SharedVirtualDisksUnsupported = 0,
    SharedVirtualDisksSupported = 1,
    SharedVirtualDiskSnapshotsSupported = 3,
    SharedVirtualDiskCDPSnapshotsSupported = 7
} SharedVirtualDiskSupportType;

typedef enum _SharedVirtualDiskHandleState
{
    SharedVirtualDiskHandleStateNone = 0,
    SharedVirtualDiskHandleStateFileShared = 1,
    SharedVirtualDiskHandleStateHandleShared = 3
} SharedVirtualDiskHandleState;

typedef struct _SHARED_VIRTUAL_DISK_SUPPORT
{
    SharedVirtualDiskSupportType SharedVirtualDiskSupport;
    SharedVirtualDiskHandleState HandleState;
} SHARED_VIRTUAL_DISK_SUPPORT, *PSHARED_VIRTUAL_DISK_SUPPORT;
typedef struct _REARRANGE_FILE_DATA
{
    ULONGLONG SourceStartingOffset;
    ULONGLONG TargetOffset;
    HANDLE SourceFileHandle;
    DWORD Length;
    DWORD Flags;

} REARRANGE_FILE_DATA, *PREARRANGE_FILE_DATA;
typedef struct _SHUFFLE_FILE_DATA
{
    LONGLONG StartingOffset;
    LONGLONG Length;
    DWORD Flags;

} SHUFFLE_FILE_DATA, *PSHUFFLE_FILE_DATA;
typedef struct _NETWORK_APP_INSTANCE_EA
{
    GUID AppInstanceID;
    DWORD CsvFlags;

} NETWORK_APP_INSTANCE_EA, *PNETWORK_APP_INSTANCE_EA;

typedef enum _SYSTEM_POWER_STATE
{
    PowerSystemUnspecified = 0,
    PowerSystemWorking = 1,
    PowerSystemSleeping1 = 2,
    PowerSystemSleeping2 = 3,
    PowerSystemSleeping3 = 4,
    PowerSystemHibernate = 5,
    PowerSystemShutdown = 6,
    PowerSystemMaximum = 7
} SYSTEM_POWER_STATE,
    *PSYSTEM_POWER_STATE;

typedef enum
{
    PowerActionNone = 0,
    PowerActionReserved,
    PowerActionSleep,
    PowerActionHibernate,
    PowerActionShutdown,
    PowerActionShutdownReset,
    PowerActionShutdownOff,
    PowerActionWarmEject,
    PowerActionDisplayOff
} POWER_ACTION,
    *PPOWER_ACTION;

typedef enum _DEVICE_POWER_STATE
{
    PowerDeviceUnspecified = 0,
    PowerDeviceD0,
    PowerDeviceD1,
    PowerDeviceD2,
    PowerDeviceD3,
    PowerDeviceMaximum
} DEVICE_POWER_STATE,
    *PDEVICE_POWER_STATE;

typedef enum _MONITOR_DISPLAY_STATE
{
    PowerMonitorOff = 0,
    PowerMonitorOn,
    PowerMonitorDim
} MONITOR_DISPLAY_STATE,
    *PMONITOR_DISPLAY_STATE;

typedef enum _USER_ACTIVITY_PRESENCE
{
    PowerUserPresent = 0,
    PowerUserNotPresent,
    PowerUserInactive,
    PowerUserMaximum,
    PowerUserInvalid = PowerUserMaximum
} USER_ACTIVITY_PRESENCE,
    *PUSER_ACTIVITY_PRESENCE;

typedef DWORD EXECUTION_STATE, *PEXECUTION_STATE;

typedef enum
{
    LT_DONT_CARE,
    LT_LOWEST_LATENCY
} LATENCY_TIME;
typedef enum _POWER_REQUEST_TYPE
{
    PowerRequestDisplayRequired,
    PowerRequestSystemRequired,
    PowerRequestAwayModeRequired,
    PowerRequestExecutionRequired
} POWER_REQUEST_TYPE,
    *PPOWER_REQUEST_TYPE;
typedef struct CM_Power_Data_s
{
    DWORD PD_Size;
    DEVICE_POWER_STATE PD_MostRecentPowerState;
    DWORD PD_Capabilities;
    DWORD PD_D1Latency;
    DWORD PD_D2Latency;
    DWORD PD_D3Latency;
    DEVICE_POWER_STATE PD_PowerStateMapping[7];
    SYSTEM_POWER_STATE PD_DeepestSystemWake;
} CM_POWER_DATA, *PCM_POWER_DATA;

typedef enum
{
    SystemPowerPolicyAc,
    SystemPowerPolicyDc,
    VerifySystemPolicyAc,
    VerifySystemPolicyDc,
    SystemPowerCapabilities,
    SystemBatteryState,
    SystemPowerStateHandler,
    ProcessorStateHandler,
    SystemPowerPolicyCurrent,
    AdministratorPowerPolicy,
    SystemReserveHiberFile,
    ProcessorInformation,
    SystemPowerInformation,
    ProcessorStateHandler2,
    LastWakeTime,
    LastSleepTime,
    SystemExecutionState,
    SystemPowerStateNotifyHandler,
    ProcessorPowerPolicyAc,
    ProcessorPowerPolicyDc,
    VerifyProcessorPowerPolicyAc,
    VerifyProcessorPowerPolicyDc,
    ProcessorPowerPolicyCurrent,
    SystemPowerStateLogging,
    SystemPowerLoggingEntry,
    SetPowerSettingValue,
    NotifyUserPowerSetting,
    PowerInformationLevelUnused0,
    SystemMonitorHiberBootPowerOff,
    SystemVideoState,
    TraceApplicationPowerMessage,
    TraceApplicationPowerMessageEnd,
    ProcessorPerfStates,
    ProcessorIdleStates,
    ProcessorCap,
    SystemWakeSource,
    SystemHiberFileInformation,
    TraceServicePowerMessage,
    ProcessorLoad,
    PowerShutdownNotification,
    MonitorCapabilities,
    SessionPowerInit,
    SessionDisplayState,
    PowerRequestCreate,
    PowerRequestAction,
    GetPowerRequestList,
    ProcessorInformationEx,
    NotifyUserModeLegacyPowerEvent,
    GroupPark,
    ProcessorIdleDomains,
    WakeTimerList,
    SystemHiberFileSize,
    ProcessorIdleStatesHv,
    ProcessorPerfStatesHv,
    ProcessorPerfCapHv,
    ProcessorSetIdle,
    LogicalProcessorIdling,
    UserPresence,
    PowerSettingNotificationName,
    GetPowerSettingValue,
    IdleResiliency,
    SessionRITState,
    SessionConnectNotification,
    SessionPowerCleanup,
    SessionLockState,
    SystemHiberbootState,
    PlatformInformation,
    PdcInvocation,
    MonitorInvocation,
    FirmwareTableInformationRegistered,
    SetShutdownSelectedTime,
    SuspendResumeInvocation,
    PlmPowerRequestCreate,
    ScreenOff,
    CsDeviceNotification,
    PlatformRole,
    LastResumePerformance,
    DisplayBurst,
    ExitLatencySamplingPercentage,
    RegisterSpmPowerSettings,
    PlatformIdleStates,
    ProcessorIdleVeto,
    PlatformIdleVeto,
    SystemBatteryStatePrecise,
    ThermalEvent,
    PowerRequestActionInternal,
    BatteryDeviceState,
    PowerInformationInternal,
    ThermalStandby,
    SystemHiberFileType,
    PhysicalPowerButtonPress,
    QueryPotentialDripsConstraint,
    EnergyTrackerCreate,
    EnergyTrackerQuery,
    UpdateBlackBoxRecorder,
    SessionAllowExternalDmaDevices,
    PowerInformationLevelMaximum
} POWER_INFORMATION_LEVEL;

typedef enum
{
    UserNotPresent = 0,
    UserPresent = 1,
    UserUnknown = 0xff
} POWER_USER_PRESENCE_TYPE,
    *PPOWER_USER_PRESENCE_TYPE;

typedef struct _POWER_USER_PRESENCE
{
    POWER_USER_PRESENCE_TYPE UserPresence;
} POWER_USER_PRESENCE, *PPOWER_USER_PRESENCE;

typedef struct _POWER_SESSION_CONNECT
{
    BOOLEAN Connected;
    BOOLEAN Console;
} POWER_SESSION_CONNECT, *PPOWER_SESSION_CONNECT;

typedef struct _POWER_SESSION_TIMEOUTS
{
    DWORD InputTimeout;
    DWORD DisplayTimeout;
} POWER_SESSION_TIMEOUTS, *PPOWER_SESSION_TIMEOUTS;

typedef struct _POWER_SESSION_RIT_STATE
{
    BOOLEAN Active;
    DWORD LastInputTime;
} POWER_SESSION_RIT_STATE, *PPOWER_SESSION_RIT_STATE;

typedef struct _POWER_SESSION_WINLOGON
{
    DWORD SessionId;
    BOOLEAN Console;
    BOOLEAN Locked;
} POWER_SESSION_WINLOGON, *PPOWER_SESSION_WINLOGON;

typedef struct _POWER_SESSION_ALLOW_EXTERNAL_DMA_DEVICES
{
    BOOLEAN IsAllowed;
} POWER_SESSION_ALLOW_EXTERNAL_DMA_DEVICES, *PPOWER_SESSION_ALLOW_EXTERNAL_DMA_DEVICES;

typedef struct _POWER_IDLE_RESILIENCY
{
    DWORD CoalescingTimeout;
    DWORD IdleResiliencyPeriod;
} POWER_IDLE_RESILIENCY, *PPOWER_IDLE_RESILIENCY;

typedef enum
{
    MonitorRequestReasonUnknown,
    MonitorRequestReasonPowerButton,
    MonitorRequestReasonRemoteConnection,
    MonitorRequestReasonScMonitorpower,
    MonitorRequestReasonUserInput,
    MonitorRequestReasonAcDcDisplayBurst,
    MonitorRequestReasonUserDisplayBurst,
    MonitorRequestReasonPoSetSystemState,
    MonitorRequestReasonSetThreadExecutionState,
    MonitorRequestReasonFullWake,
    MonitorRequestReasonSessionUnlock,
    MonitorRequestReasonScreenOffRequest,
    MonitorRequestReasonIdleTimeout,
    MonitorRequestReasonPolicyChange,
    MonitorRequestReasonSleepButton,
    MonitorRequestReasonLid,
    MonitorRequestReasonBatteryCountChange,
    MonitorRequestReasonGracePeriod,
    MonitorRequestReasonPnP,
    MonitorRequestReasonDP,
    MonitorRequestReasonSxTransition,
    MonitorRequestReasonSystemIdle,
    MonitorRequestReasonNearProximity,
    MonitorRequestReasonThermalStandby,
    MonitorRequestReasonResumePdc,
    MonitorRequestReasonResumeS4,
    MonitorRequestReasonTerminal,
    MonitorRequestReasonPdcSignal,
    MonitorRequestReasonAcDcDisplayBurstSuppressed,
    MonitorRequestReasonSystemStateEntered,
    MonitorRequestReasonWinrt,
    MonitorRequestReasonUserInputKeyboard,
    MonitorRequestReasonUserInputMouse,
    MonitorRequestReasonUserInputTouch,
    MonitorRequestReasonUserInputPen,
    MonitorRequestReasonUserInputAccelerometer,
    MonitorRequestReasonUserInputHid,
    MonitorRequestReasonUserInputPoUserPresent,
    MonitorRequestReasonUserInputSessionSwitch,
    MonitorRequestReasonUserInputInitialization,
    MonitorRequestReasonPdcSignalWindowsMobilePwrNotif,
    MonitorRequestReasonPdcSignalWindowsMobileShell,
    MonitorRequestReasonPdcSignalHeyCortana,
    MonitorRequestReasonPdcSignalHolographicShell,
    MonitorRequestReasonPdcSignalFingerprint,
    MonitorRequestReasonDirectedDrips,
    MonitorRequestReasonDim,
    MonitorRequestReasonBuiltinPanel,
    MonitorRequestReasonDisplayRequiredUnDim,
    MonitorRequestReasonBatteryCountChangeSuppressed,
    MonitorRequestReasonResumeModernStandby,
    MonitorRequestReasonMax
} POWER_MONITOR_REQUEST_REASON;

typedef enum _POWER_MONITOR_REQUEST_TYPE
{
    MonitorRequestTypeOff,
    MonitorRequestTypeOnAndPresent,
    MonitorRequestTypeToggleOn
} POWER_MONITOR_REQUEST_TYPE;

typedef struct _POWER_MONITOR_INVOCATION
{
    BOOLEAN Console;
    POWER_MONITOR_REQUEST_REASON RequestReason;
} POWER_MONITOR_INVOCATION, *PPOWER_MONITOR_INVOCATION;

typedef struct _RESUME_PERFORMANCE
{
    DWORD PostTimeMs;
    ULONGLONG TotalResumeTimeMs;
    ULONGLONG ResumeCompleteTimestamp;
} RESUME_PERFORMANCE, *PRESUME_PERFORMANCE;

typedef enum
{
    PoAc,
    PoDc,
    PoHot,
    PoConditionMaximum
} SYSTEM_POWER_CONDITION;

typedef struct
{
    DWORD Version;
    GUID Guid;
    SYSTEM_POWER_CONDITION PowerCondition;
    DWORD DataLength;
    BYTE Data[1];
} SET_POWER_SETTING_VALUE, *PSET_POWER_SETTING_VALUE;

typedef struct
{
    GUID Guid;
} NOTIFY_USER_POWER_SETTING, *PNOTIFY_USER_POWER_SETTING;

typedef struct _APPLICATIONLAUNCH_SETTING_VALUE
{
    LARGE_INTEGER ActivationTime;
    DWORD Flags;
    DWORD ButtonInstanceID;

} APPLICATIONLAUNCH_SETTING_VALUE, *PAPPLICATIONLAUNCH_SETTING_VALUE;

typedef enum _POWER_PLATFORM_ROLE
{
    PlatformRoleUnspecified = 0,
    PlatformRoleDesktop,
    PlatformRoleMobile,
    PlatformRoleWorkstation,
    PlatformRoleEnterpriseServer,
    PlatformRoleSOHOServer,
    PlatformRoleAppliancePC,
    PlatformRolePerformanceServer,
    PlatformRoleSlate,
    PlatformRoleMaximum
} POWER_PLATFORM_ROLE,
    *PPOWER_PLATFORM_ROLE;
typedef struct _POWER_PLATFORM_INFORMATION
{
    BOOLEAN AoAc;
} POWER_PLATFORM_INFORMATION, *PPOWER_PLATFORM_INFORMATION;

typedef struct
{
    DWORD Granularity;
    DWORD Capacity;
} BATTERY_REPORTING_SCALE, *PBATTERY_REPORTING_SCALE;

typedef struct
{
    DWORD Frequency;
    DWORD Flags;
    DWORD PercentFrequency;
} PPM_WMI_LEGACY_PERFSTATE, *PPPM_WMI_LEGACY_PERFSTATE;

typedef struct
{
    DWORD Latency;
    DWORD Power;
    DWORD TimeCheck;
    BYTE PromotePercent;
    BYTE DemotePercent;
    BYTE StateType;
    BYTE Reserved;
    DWORD StateFlags;
    DWORD Context;
    DWORD IdleHandler;
    DWORD Reserved1;
} PPM_WMI_IDLE_STATE, *PPPM_WMI_IDLE_STATE;

typedef struct
{
    DWORD Type;
    DWORD Count;
    DWORD TargetState;
    DWORD OldState;
    DWORD64 TargetProcessors;
    PPM_WMI_IDLE_STATE State[1];
} PPM_WMI_IDLE_STATES, *PPPM_WMI_IDLE_STATES;

typedef struct
{
    DWORD Type;
    DWORD Count;
    DWORD TargetState;
    DWORD OldState;
    PVOID TargetProcessors;
    PPM_WMI_IDLE_STATE State[1];
} PPM_WMI_IDLE_STATES_EX, *PPPM_WMI_IDLE_STATES_EX;

typedef struct
{
    DWORD Frequency;
    DWORD Power;
    BYTE PercentFrequency;
    BYTE IncreaseLevel;
    BYTE DecreaseLevel;
    BYTE Type;
    DWORD IncreaseTime;
    DWORD DecreaseTime;
    DWORD64 Control;
    DWORD64 Status;
    DWORD HitCount;
    DWORD Reserved1;
    DWORD64 Reserved2;
    DWORD64 Reserved3;
} PPM_WMI_PERF_STATE, *PPPM_WMI_PERF_STATE;

typedef struct
{
    DWORD Count;
    DWORD MaxFrequency;
    DWORD CurrentState;
    DWORD MaxPerfState;
    DWORD MinPerfState;
    DWORD LowestPerfState;
    DWORD ThermalConstraint;
    BYTE BusyAdjThreshold;
    BYTE PolicyType;
    BYTE Type;
    BYTE Reserved;
    DWORD TimerInterval;
    DWORD64 TargetProcessors;
    DWORD PStateHandler;
    DWORD PStateContext;
    DWORD TStateHandler;
    DWORD TStateContext;
    DWORD FeedbackHandler;
    DWORD Reserved1;
    DWORD64 Reserved2;
    PPM_WMI_PERF_STATE State[1];
} PPM_WMI_PERF_STATES, *PPPM_WMI_PERF_STATES;

typedef struct
{
    DWORD Count;
    DWORD MaxFrequency;
    DWORD CurrentState;
    DWORD MaxPerfState;
    DWORD MinPerfState;
    DWORD LowestPerfState;
    DWORD ThermalConstraint;
    BYTE BusyAdjThreshold;
    BYTE PolicyType;
    BYTE Type;
    BYTE Reserved;
    DWORD TimerInterval;
    PVOID TargetProcessors;
    DWORD PStateHandler;
    DWORD PStateContext;
    DWORD TStateHandler;
    DWORD TStateContext;
    DWORD FeedbackHandler;
    DWORD Reserved1;
    DWORD64 Reserved2;
    PPM_WMI_PERF_STATE State[1];
} PPM_WMI_PERF_STATES_EX, *PPPM_WMI_PERF_STATES_EX;

typedef struct
{
    DWORD IdleTransitions;
    DWORD FailedTransitions;
    DWORD InvalidBucketIndex;
    DWORD64 TotalTime;
    DWORD IdleTimeBuckets[6];
} PPM_IDLE_STATE_ACCOUNTING, *PPPM_IDLE_STATE_ACCOUNTING;

typedef struct
{
    DWORD StateCount;
    DWORD TotalTransitions;
    DWORD ResetCount;
    DWORD64 StartTime;
    PPM_IDLE_STATE_ACCOUNTING State[1];
} PPM_IDLE_ACCOUNTING, *PPPM_IDLE_ACCOUNTING;

typedef struct
{
    DWORD64 TotalTimeUs;
    DWORD MinTimeUs;
    DWORD MaxTimeUs;
    DWORD Count;
} PPM_IDLE_STATE_BUCKET_EX, *PPPM_IDLE_STATE_BUCKET_EX;

typedef struct
{
    DWORD64 TotalTime;
    DWORD IdleTransitions;
    DWORD FailedTransitions;
    DWORD InvalidBucketIndex;
    DWORD MinTimeUs;
    DWORD MaxTimeUs;
    DWORD CancelledTransitions;
    PPM_IDLE_STATE_BUCKET_EX IdleTimeBuckets[16];
} PPM_IDLE_STATE_ACCOUNTING_EX, *PPPM_IDLE_STATE_ACCOUNTING_EX;

typedef struct
{
    DWORD StateCount;
    DWORD TotalTransitions;
    DWORD ResetCount;
    DWORD AbortCount;
    DWORD64 StartTime;
    PPM_IDLE_STATE_ACCOUNTING_EX State[1];
} PPM_IDLE_ACCOUNTING_EX, *PPPM_IDLE_ACCOUNTING_EX;

typedef struct
{
    DWORD State;
    DWORD Status;
    DWORD Latency;
    DWORD Speed;
    DWORD Processor;
} PPM_PERFSTATE_EVENT, *PPPM_PERFSTATE_EVENT;

typedef struct
{
    DWORD State;
    DWORD Latency;
    DWORD Speed;
    DWORD64 Processors;
} PPM_PERFSTATE_DOMAIN_EVENT, *PPPM_PERFSTATE_DOMAIN_EVENT;

typedef struct
{
    DWORD NewState;
    DWORD OldState;
    DWORD64 Processors;
} PPM_IDLESTATE_EVENT, *PPPM_IDLESTATE_EVENT;

typedef struct
{
    DWORD ThermalConstraint;
    DWORD64 Processors;
} PPM_THERMALCHANGE_EVENT, *PPPM_THERMALCHANGE_EVENT;

typedef struct
{
    BYTE Mode;
    DWORD64 Processors;
} PPM_THERMAL_POLICY_EVENT, *PPPM_THERMAL_POLICY_EVENT;

typedef struct
{
    POWER_ACTION Action;
    DWORD Flags;
    DWORD EventCode;
} POWER_ACTION_POLICY, *PPOWER_ACTION_POLICY;
typedef struct
{
    BOOLEAN Enable;
    BYTE Spare[3];
    DWORD BatteryLevel;
    POWER_ACTION_POLICY PowerPolicy;
    SYSTEM_POWER_STATE MinSystemState;
} SYSTEM_POWER_LEVEL, *PSYSTEM_POWER_LEVEL;

typedef struct _SYSTEM_POWER_POLICY
{
    DWORD Revision;
    POWER_ACTION_POLICY PowerButton;
    POWER_ACTION_POLICY SleepButton;
    POWER_ACTION_POLICY LidClose;
    SYSTEM_POWER_STATE LidOpenWake;
    DWORD Reserved;
    POWER_ACTION_POLICY Idle;
    DWORD IdleTimeout;
    BYTE IdleSensitivity;
    BYTE DynamicThrottle;
    BYTE Spare2[2];
    SYSTEM_POWER_STATE MinSleep;
    SYSTEM_POWER_STATE MaxSleep;
    SYSTEM_POWER_STATE ReducedLatencySleep;
    DWORD WinLogonFlags;
    DWORD Spare3;
    DWORD DozeS4Timeout;
    DWORD BroadcastCapacityResolution;
    SYSTEM_POWER_LEVEL DischargePolicy[4];
    DWORD VideoTimeout;
    BOOLEAN VideoDimDisplay;
    DWORD VideoReserved[3];
    DWORD SpindownTimeout;
    BOOLEAN OptimizeForPower;
    BYTE FanThrottleTolerance;
    BYTE ForcedThrottle;
    BYTE MinThrottle;
    POWER_ACTION_POLICY OverThrottled;

} SYSTEM_POWER_POLICY, *PSYSTEM_POWER_POLICY;

typedef struct
{
    DWORD TimeCheck;
    BYTE DemotePercent;
    BYTE PromotePercent;
    BYTE Spare[2];
} PROCESSOR_IDLESTATE_INFO, *PPROCESSOR_IDLESTATE_INFO;

typedef struct
{
    WORD Revision;
    union
    {
        WORD AsWORD;
        struct
        {
            WORD AllowScaling : 1;
            WORD Disabled : 1;
            WORD Reserved : 14;
        } s;
    } Flags;
    DWORD PolicyCount;
    PROCESSOR_IDLESTATE_INFO Policy[0x3];
} PROCESSOR_IDLESTATE_POLICY, *PPROCESSOR_IDLESTATE_POLICY;
typedef struct _PROCESSOR_POWER_POLICY_INFO
{
    DWORD TimeCheck;
    DWORD DemoteLimit;
    DWORD PromoteLimit;
    BYTE DemotePercent;
    BYTE PromotePercent;
    BYTE Spare[2];
    DWORD AllowDemotion : 1;
    DWORD AllowPromotion : 1;
    DWORD Reserved : 30;

} PROCESSOR_POWER_POLICY_INFO, *PPROCESSOR_POWER_POLICY_INFO;

typedef struct _PROCESSOR_POWER_POLICY
{
    DWORD Revision;
    BYTE DynamicThrottle;
    BYTE Spare[3];
    DWORD DisableCStates : 1;
    DWORD Reserved : 31;
    DWORD PolicyCount;
    PROCESSOR_POWER_POLICY_INFO Policy[3];

} PROCESSOR_POWER_POLICY, *PPROCESSOR_POWER_POLICY;

typedef struct
{
    DWORD Revision;
    BYTE MaxThrottle;
    BYTE MinThrottle;
    BYTE BusyAdjThreshold;
    union
    {
        BYTE Spare;
        union
        {
            BYTE AsBYTE;
            struct
            {
                BYTE NoDomainAccounting : 1;
                BYTE IncreasePolicy : 2;
                BYTE DecreasePolicy : 2;
                BYTE Reserved : 3;
            } s;
        } Flags;
    } u;
    DWORD TimeCheck;
    DWORD IncreaseTime;
    DWORD DecreaseTime;
    DWORD IncreasePercent;
    DWORD DecreasePercent;
} PROCESSOR_PERFSTATE_POLICY, *PPROCESSOR_PERFSTATE_POLICY;

typedef struct _ADMINISTRATOR_POWER_POLICY
{
    SYSTEM_POWER_STATE MinSleep;
    SYSTEM_POWER_STATE MaxSleep;
    DWORD MinVideoTimeout;
    DWORD MaxVideoTimeout;
    DWORD MinSpindownTimeout;
    DWORD MaxSpindownTimeout;
} ADMINISTRATOR_POWER_POLICY, *PADMINISTRATOR_POWER_POLICY;

typedef enum _HIBERFILE_BUCKET_SIZE
{
    HiberFileBucket1GB = 0,
    HiberFileBucket2GB,
    HiberFileBucket4GB,
    HiberFileBucket8GB,
    HiberFileBucket16GB,
    HiberFileBucket32GB,
    HiberFileBucketUnlimited,
    HiberFileBucketMax
} HIBERFILE_BUCKET_SIZE,
    *PHIBERFILE_BUCKET_SIZE;

typedef struct _HIBERFILE_BUCKET
{
    DWORD64 MaxPhysicalMemory;
    DWORD PhysicalMemoryPercent[0x03];
} HIBERFILE_BUCKET, *PHIBERFILE_BUCKET;

typedef struct
{
    BOOLEAN PowerButtonPresent;
    BOOLEAN SleepButtonPresent;
    BOOLEAN LidPresent;
    BOOLEAN SystemS1;
    BOOLEAN SystemS2;
    BOOLEAN SystemS3;
    BOOLEAN SystemS4;
    BOOLEAN SystemS5;
    BOOLEAN HiberFilePresent;
    BOOLEAN FullWake;
    BOOLEAN VideoDimPresent;
    BOOLEAN ApmPresent;
    BOOLEAN UpsPresent;
    BOOLEAN ThermalControl;
    BOOLEAN ProcessorThrottle;
    BYTE ProcessorMinThrottle;
    BYTE ProcessorMaxThrottle;
    BOOLEAN FastSystemS4;
    BOOLEAN Hiberboot;
    BOOLEAN WakeAlarmPresent;
    BOOLEAN AoAc;
    BOOLEAN DiskSpinDown;
    BYTE HiberFileType;
    BOOLEAN AoAcConnectivitySupported;
    BYTE spare3[6];
    BOOLEAN SystemBatteriesPresent;
    BOOLEAN BatteriesAreShortTerm;
    BATTERY_REPORTING_SCALE BatteryScale[3];
    SYSTEM_POWER_STATE AcOnLineWake;
    SYSTEM_POWER_STATE SoftLidWake;
    SYSTEM_POWER_STATE RtcWake;
    SYSTEM_POWER_STATE MinDeviceWakeState;
    SYSTEM_POWER_STATE DefaultLowLatencyWake;
} SYSTEM_POWER_CAPABILITIES, *PSYSTEM_POWER_CAPABILITIES;

typedef struct
{
    BOOLEAN AcOnLine;
    BOOLEAN BatteryPresent;
    BOOLEAN Charging;
    BOOLEAN Discharging;
    BOOLEAN Spare1[3];
    BYTE Tag;
    DWORD MaxCapacity;
    DWORD RemainingCapacity;
    DWORD Rate;
    DWORD EstimatedTime;
    DWORD DefaultAlert1;
    DWORD DefaultAlert2;
} SYSTEM_BATTERY_STATE, *PSYSTEM_BATTERY_STATE;

typedef struct _IMAGE_DOS_HEADER
{
    WORD e_magic;
    WORD e_cblp;
    WORD e_cp;
    WORD e_crlc;
    WORD e_cparhdr;
    WORD e_minalloc;
    WORD e_maxalloc;
    WORD e_ss;
    WORD e_sp;
    WORD e_csum;
    WORD e_ip;
    WORD e_cs;
    WORD e_lfarlc;
    WORD e_ovno;
    WORD e_res[4];
    WORD e_oemid;
    WORD e_oeminfo;
    WORD e_res2[10];
    LONG e_lfanew;
} IMAGE_DOS_HEADER, *PIMAGE_DOS_HEADER;

typedef struct _IMAGE_OS2_HEADER
{
    WORD ne_magic;
    CHAR ne_ver;
    CHAR ne_rev;
    WORD ne_enttab;
    WORD ne_cbenttab;
    LONG ne_crc;
    WORD ne_flags;
    WORD ne_autodata;
    WORD ne_heap;
    WORD ne_stack;
    LONG ne_csip;
    LONG ne_sssp;
    WORD ne_cseg;
    WORD ne_cmod;
    WORD ne_cbnrestab;
    WORD ne_segtab;
    WORD ne_rsrctab;
    WORD ne_restab;
    WORD ne_modtab;
    WORD ne_imptab;
    LONG ne_nrestab;
    WORD ne_cmovent;
    WORD ne_align;
    WORD ne_cres;
    BYTE ne_exetyp;
    BYTE ne_flagsothers;
    WORD ne_pretthunks;
    WORD ne_psegrefbytes;
    WORD ne_swaparea;
    WORD ne_expver;
} IMAGE_OS2_HEADER, *PIMAGE_OS2_HEADER;

typedef struct _IMAGE_VXD_HEADER
{
    WORD e32_magic;
    BYTE e32_border;
    BYTE e32_worder;
    DWORD e32_level;
    WORD e32_cpu;
    WORD e32_os;
    DWORD e32_ver;
    DWORD e32_mflags;
    DWORD e32_mpages;
    DWORD e32_startobj;
    DWORD e32_eip;
    DWORD e32_stackobj;
    DWORD e32_esp;
    DWORD e32_pagesize;
    DWORD e32_lastpagesize;
    DWORD e32_fixupsize;
    DWORD e32_fixupsum;
    DWORD e32_ldrsize;
    DWORD e32_ldrsum;
    DWORD e32_objtab;
    DWORD e32_objcnt;
    DWORD e32_objmap;
    DWORD e32_itermap;
    DWORD e32_rsrctab;
    DWORD e32_rsrccnt;
    DWORD e32_restab;
    DWORD e32_enttab;
    DWORD e32_dirtab;
    DWORD e32_dircnt;
    DWORD e32_fpagetab;
    DWORD e32_frectab;
    DWORD e32_impmod;
    DWORD e32_impmodcnt;
    DWORD e32_impproc;
    DWORD e32_pagesum;
    DWORD e32_datapage;
    DWORD e32_preload;
    DWORD e32_nrestab;
    DWORD e32_cbnrestab;
    DWORD e32_nressum;
    DWORD e32_autodata;
    DWORD e32_debuginfo;
    DWORD e32_debuglen;
    DWORD e32_instpreload;
    DWORD e32_instdemand;
    DWORD e32_heapsize;
    BYTE e32_res3[12];
    DWORD e32_winresoff;
    DWORD e32_winreslen;
    WORD e32_devid;
    WORD e32_ddkver;
} IMAGE_VXD_HEADER, *PIMAGE_VXD_HEADER;

typedef struct _IMAGE_FILE_HEADER
{
    WORD Machine;
    WORD NumberOfSections;
    DWORD TimeDateStamp;
    DWORD PointerToSymbolTable;
    DWORD NumberOfSymbols;
    WORD SizeOfOptionalHeader;
    WORD Characteristics;
} IMAGE_FILE_HEADER, *PIMAGE_FILE_HEADER;
typedef struct _IMAGE_DATA_DIRECTORY
{
    DWORD VirtualAddress;
    DWORD Size;
} IMAGE_DATA_DIRECTORY, *PIMAGE_DATA_DIRECTORY;

typedef struct _IMAGE_OPTIONAL_HEADER
{
    WORD Magic;
    BYTE MajorLinkerVersion;
    BYTE MinorLinkerVersion;
    DWORD SizeOfCode;
    DWORD SizeOfInitializedData;
    DWORD SizeOfUninitializedData;
    DWORD AddressOfEntryPoint;
    DWORD BaseOfCode;
    DWORD BaseOfData;
    DWORD ImageBase;
    DWORD SectionAlignment;
    DWORD FileAlignment;
    WORD MajorOperatingSystemVersion;
    WORD MinorOperatingSystemVersion;
    WORD MajorImageVersion;
    WORD MinorImageVersion;
    WORD MajorSubsystemVersion;
    WORD MinorSubsystemVersion;
    DWORD Win32VersionValue;
    DWORD SizeOfImage;
    DWORD SizeOfHeaders;
    DWORD CheckSum;
    WORD Subsystem;
    WORD DllCharacteristics;
    DWORD SizeOfStackReserve;
    DWORD SizeOfStackCommit;
    DWORD SizeOfHeapReserve;
    DWORD SizeOfHeapCommit;
    DWORD LoaderFlags;
    DWORD NumberOfRvaAndSizes;
    IMAGE_DATA_DIRECTORY DataDirectory[16];
} IMAGE_OPTIONAL_HEADER32, *PIMAGE_OPTIONAL_HEADER32;

typedef struct _IMAGE_ROM_OPTIONAL_HEADER
{
    WORD Magic;
    BYTE MajorLinkerVersion;
    BYTE MinorLinkerVersion;
    DWORD SizeOfCode;
    DWORD SizeOfInitializedData;
    DWORD SizeOfUninitializedData;
    DWORD AddressOfEntryPoint;
    DWORD BaseOfCode;
    DWORD BaseOfData;
    DWORD BaseOfBss;
    DWORD GprMask;
    DWORD CprMask[4];
    DWORD GpValue;
} IMAGE_ROM_OPTIONAL_HEADER, *PIMAGE_ROM_OPTIONAL_HEADER;

typedef struct _IMAGE_OPTIONAL_HEADER64
{
    WORD Magic;
    BYTE MajorLinkerVersion;
    BYTE MinorLinkerVersion;
    DWORD SizeOfCode;
    DWORD SizeOfInitializedData;
    DWORD SizeOfUninitializedData;
    DWORD AddressOfEntryPoint;
    DWORD BaseOfCode;
    ULONGLONG ImageBase;
    DWORD SectionAlignment;
    DWORD FileAlignment;
    WORD MajorOperatingSystemVersion;
    WORD MinorOperatingSystemVersion;
    WORD MajorImageVersion;
    WORD MinorImageVersion;
    WORD MajorSubsystemVersion;
    WORD MinorSubsystemVersion;
    DWORD Win32VersionValue;
    DWORD SizeOfImage;
    DWORD SizeOfHeaders;
    DWORD CheckSum;
    WORD Subsystem;
    WORD DllCharacteristics;
    ULONGLONG SizeOfStackReserve;
    ULONGLONG SizeOfStackCommit;
    ULONGLONG SizeOfHeapReserve;
    ULONGLONG SizeOfHeapCommit;
    DWORD LoaderFlags;
    DWORD NumberOfRvaAndSizes;
    IMAGE_DATA_DIRECTORY DataDirectory[16];
} IMAGE_OPTIONAL_HEADER64, *PIMAGE_OPTIONAL_HEADER64;

typedef IMAGE_OPTIONAL_HEADER32 IMAGE_OPTIONAL_HEADER;
typedef PIMAGE_OPTIONAL_HEADER32 PIMAGE_OPTIONAL_HEADER;

typedef struct _IMAGE_NT_HEADERS64
{
    DWORD Signature;
    IMAGE_FILE_HEADER FileHeader;
    IMAGE_OPTIONAL_HEADER64 OptionalHeader;
} IMAGE_NT_HEADERS64, *PIMAGE_NT_HEADERS64;

typedef struct _IMAGE_NT_HEADERS
{
    DWORD Signature;
    IMAGE_FILE_HEADER FileHeader;
    IMAGE_OPTIONAL_HEADER32 OptionalHeader;
} IMAGE_NT_HEADERS32, *PIMAGE_NT_HEADERS32;

typedef struct _IMAGE_ROM_HEADERS
{
    IMAGE_FILE_HEADER FileHeader;
    IMAGE_ROM_OPTIONAL_HEADER OptionalHeader;
} IMAGE_ROM_HEADERS, *PIMAGE_ROM_HEADERS;

typedef IMAGE_NT_HEADERS32 IMAGE_NT_HEADERS;
typedef PIMAGE_NT_HEADERS32 PIMAGE_NT_HEADERS;
typedef struct ANON_OBJECT_HEADER
{
    WORD Sig1;
    WORD Sig2;
    WORD Version;
    WORD Machine;
    DWORD TimeDateStamp;
    CLSID ClassID;
    DWORD SizeOfData;
} ANON_OBJECT_HEADER;

typedef struct ANON_OBJECT_HEADER_V2
{
    WORD Sig1;
    WORD Sig2;
    WORD Version;
    WORD Machine;
    DWORD TimeDateStamp;
    CLSID ClassID;
    DWORD SizeOfData;
    DWORD Flags;
    DWORD MetaDataSize;
    DWORD MetaDataOffset;
} ANON_OBJECT_HEADER_V2;

typedef struct ANON_OBJECT_HEADER_BIGOBJ
{
    WORD Sig1;
    WORD Sig2;
    WORD Version;
    WORD Machine;
    DWORD TimeDateStamp;
    CLSID ClassID;
    DWORD SizeOfData;
    DWORD Flags;
    DWORD MetaDataSize;
    DWORD MetaDataOffset;
    DWORD NumberOfSections;
    DWORD PointerToSymbolTable;
    DWORD NumberOfSymbols;
} ANON_OBJECT_HEADER_BIGOBJ;

typedef struct _IMAGE_SECTION_HEADER
{
    BYTE Name[8];
    union
    {
        DWORD PhysicalAddress;
        DWORD VirtualSize;
    } Misc;
    DWORD VirtualAddress;
    DWORD SizeOfRawData;
    DWORD PointerToRawData;
    DWORD PointerToRelocations;
    DWORD PointerToLinenumbers;
    WORD NumberOfRelocations;
    WORD NumberOfLinenumbers;
    DWORD Characteristics;
} IMAGE_SECTION_HEADER, *PIMAGE_SECTION_HEADER;

typedef struct _IMAGE_SYMBOL
{
    union
    {
        BYTE ShortName[8];
        struct
        {
            DWORD Short;
            DWORD Long;
        } Name;
        DWORD LongName[2];
    } N;
    DWORD Value;
    SHORT SectionNumber;
    WORD Type;
    BYTE StorageClass;
    BYTE NumberOfAuxSymbols;
} IMAGE_SYMBOL;
typedef IMAGE_SYMBOL *PIMAGE_SYMBOL;

typedef struct _IMAGE_SYMBOL_EX
{
    union
    {
        BYTE ShortName[8];
        struct
        {
            DWORD Short;
            DWORD Long;
        } Name;
        DWORD LongName[2];
    } N;
    DWORD Value;
    LONG SectionNumber;
    WORD Type;
    BYTE StorageClass;
    BYTE NumberOfAuxSymbols;
} IMAGE_SYMBOL_EX;
typedef IMAGE_SYMBOL_EX *PIMAGE_SYMBOL_EX;

typedef struct IMAGE_AUX_SYMBOL_TOKEN_DEF
{
    BYTE bAuxType;
    BYTE bReserved;
    DWORD SymbolTableIndex;
    BYTE rgbReserved[12];
} IMAGE_AUX_SYMBOL_TOKEN_DEF;

typedef IMAGE_AUX_SYMBOL_TOKEN_DEF *PIMAGE_AUX_SYMBOL_TOKEN_DEF;

typedef union _IMAGE_AUX_SYMBOL
{
    struct
    {
        DWORD TagIndex;
        union
        {
            struct
            {
                WORD Linenumber;
                WORD Size;
            } LnSz;
            DWORD TotalSize;
        } Misc;
        union
        {
            struct
            {
                DWORD PointerToLinenumber;
                DWORD PointerToNextFunction;
            } Function;
            struct
            {
                WORD Dimension[4];
            } Array;
        } FcnAry;
        WORD TvIndex;
    } Sym;
    struct
    {
        BYTE Name[18];
    } File;
    struct
    {
        DWORD Length;
        WORD NumberOfRelocations;
        WORD NumberOfLinenumbers;
        DWORD CheckSum;
        SHORT Number;
        BYTE Selection;
        BYTE bReserved;
        SHORT HighNumber;
    } Section;
    IMAGE_AUX_SYMBOL_TOKEN_DEF TokenDef;
    struct
    {
        DWORD crc;
        BYTE rgbReserved[14];
    } CRC;
} IMAGE_AUX_SYMBOL;
typedef IMAGE_AUX_SYMBOL *PIMAGE_AUX_SYMBOL;

typedef union _IMAGE_AUX_SYMBOL_EX
{
    struct
    {
        DWORD WeakDefaultSymIndex;
        DWORD WeakSearchType;
        BYTE rgbReserved[12];
    } Sym;
    struct
    {
        BYTE Name[sizeof(IMAGE_SYMBOL_EX)];
    } File;
    struct
    {
        DWORD Length;
        WORD NumberOfRelocations;
        WORD NumberOfLinenumbers;
        DWORD CheckSum;
        SHORT Number;
        BYTE Selection;
        BYTE bReserved;
        SHORT HighNumber;
        BYTE rgbReserved[2];
    } Section;
    struct
    {
        IMAGE_AUX_SYMBOL_TOKEN_DEF TokenDef;
        BYTE rgbReserved[2];
    } s;
    struct
    {
        DWORD crc;
        BYTE rgbReserved[16];
    } CRC;
} IMAGE_AUX_SYMBOL_EX;
typedef IMAGE_AUX_SYMBOL_EX *PIMAGE_AUX_SYMBOL_EX;

typedef enum IMAGE_AUX_SYMBOL_TYPE
{
    IMAGE_AUX_SYMBOL_TYPE_TOKEN_DEF = 1,
} IMAGE_AUX_SYMBOL_TYPE;
typedef struct _IMAGE_RELOCATION
{
    union
    {
        DWORD VirtualAddress;
        DWORD RelocCount;
    } u;
    DWORD SymbolTableIndex;
    WORD Type;
} IMAGE_RELOCATION;
typedef IMAGE_RELOCATION *PIMAGE_RELOCATION;
typedef struct _IMAGE_LINENUMBER
{
    union
    {
        DWORD SymbolTableIndex;
        DWORD VirtualAddress;
    } Type;
    WORD Linenumber;
} IMAGE_LINENUMBER;
typedef IMAGE_LINENUMBER *PIMAGE_LINENUMBER;

typedef struct _IMAGE_BASE_RELOCATION
{
    DWORD VirtualAddress;
    DWORD SizeOfBlock;

} IMAGE_BASE_RELOCATION;
typedef IMAGE_BASE_RELOCATION *PIMAGE_BASE_RELOCATION;
typedef struct _IMAGE_ARCHIVE_MEMBER_HEADER
{
    BYTE Name[16];
    BYTE Date[12];
    BYTE UserID[6];
    BYTE GroupID[6];
    BYTE Mode[8];
    BYTE Size[10];
    BYTE EndHeader[2];
} IMAGE_ARCHIVE_MEMBER_HEADER, *PIMAGE_ARCHIVE_MEMBER_HEADER;
typedef struct _IMAGE_EXPORT_DIRECTORY
{
    DWORD Characteristics;
    DWORD TimeDateStamp;
    WORD MajorVersion;
    WORD MinorVersion;
    DWORD Name;
    DWORD Base;
    DWORD NumberOfFunctions;
    DWORD NumberOfNames;
    DWORD AddressOfFunctions;
    DWORD AddressOfNames;
    DWORD AddressOfNameOrdinals;
} IMAGE_EXPORT_DIRECTORY, *PIMAGE_EXPORT_DIRECTORY;

typedef struct _IMAGE_IMPORT_BY_NAME
{
    WORD Hint;
    CHAR Name[1];
} IMAGE_IMPORT_BY_NAME, *PIMAGE_IMPORT_BY_NAME;

typedef struct _IMAGE_THUNK_DATA64
{
    union
    {
        ULONGLONG ForwarderString;
        ULONGLONG Function;
        ULONGLONG Ordinal;
        ULONGLONG AddressOfData;
    } u1;
} IMAGE_THUNK_DATA64;
typedef IMAGE_THUNK_DATA64 *PIMAGE_THUNK_DATA64;

typedef struct _IMAGE_THUNK_DATA32
{
    union
    {
        DWORD ForwarderString;
        DWORD Function;
        DWORD Ordinal;
        DWORD AddressOfData;
    } u1;
} IMAGE_THUNK_DATA32;
typedef IMAGE_THUNK_DATA32 *PIMAGE_THUNK_DATA32;
typedef void (*PIMAGE_TLS_CALLBACK)(
    PVOID DllHandle,
    DWORD Reason,
    PVOID Reserved);

typedef struct _IMAGE_TLS_DIRECTORY64
{
    ULONGLONG StartAddressOfRawData;
    ULONGLONG EndAddressOfRawData;
    ULONGLONG AddressOfIndex;
    ULONGLONG AddressOfCallBacks;
    DWORD SizeOfZeroFill;
    union
    {
        DWORD Characteristics;
        struct
        {
            DWORD Reserved0 : 20;
            DWORD Alignment : 4;
            DWORD Reserved1 : 8;
        } s;
    } u;

} IMAGE_TLS_DIRECTORY64;

typedef IMAGE_TLS_DIRECTORY64 *PIMAGE_TLS_DIRECTORY64;

typedef struct _IMAGE_TLS_DIRECTORY32
{
    DWORD StartAddressOfRawData;
    DWORD EndAddressOfRawData;
    DWORD AddressOfIndex;
    DWORD AddressOfCallBacks;
    DWORD SizeOfZeroFill;
    union
    {
        DWORD Characteristics;
        struct
        {
            DWORD Reserved0 : 20;
            DWORD Alignment : 4;
            DWORD Reserved1 : 8;
        } s;
    } u;

} IMAGE_TLS_DIRECTORY32;
typedef IMAGE_TLS_DIRECTORY32 *PIMAGE_TLS_DIRECTORY32;
typedef IMAGE_THUNK_DATA32 IMAGE_THUNK_DATA;
typedef PIMAGE_THUNK_DATA32 PIMAGE_THUNK_DATA;

typedef IMAGE_TLS_DIRECTORY32 IMAGE_TLS_DIRECTORY;
typedef PIMAGE_TLS_DIRECTORY32 PIMAGE_TLS_DIRECTORY;

typedef struct _IMAGE_IMPORT_DESCRIPTOR
{
    union
    {
        DWORD Characteristics;
        DWORD OriginalFirstThunk;
    } u;
    DWORD TimeDateStamp;
    DWORD ForwarderChain;
    DWORD Name;
    DWORD FirstThunk;
} IMAGE_IMPORT_DESCRIPTOR;
typedef IMAGE_IMPORT_DESCRIPTOR *PIMAGE_IMPORT_DESCRIPTOR;

typedef struct _IMAGE_BOUND_IMPORT_DESCRIPTOR
{
    DWORD TimeDateStamp;
    WORD OffsetModuleName;
    WORD NumberOfModuleForwarderRefs;

} IMAGE_BOUND_IMPORT_DESCRIPTOR, *PIMAGE_BOUND_IMPORT_DESCRIPTOR;

typedef struct _IMAGE_BOUND_FORWARDER_REF
{
    DWORD TimeDateStamp;
    WORD OffsetModuleName;
    WORD Reserved;
} IMAGE_BOUND_FORWARDER_REF, *PIMAGE_BOUND_FORWARDER_REF;

typedef struct _IMAGE_DELAYLOAD_DESCRIPTOR
{
    union
    {
        DWORD AllAttributes;
        struct
        {
            DWORD RvaBased : 1;
            DWORD ReservedAttributes : 31;
        } s;
    } Attributes;
    DWORD DllNameRVA;
    DWORD ModuleHandleRVA;
    DWORD ImportAddressTableRVA;
    DWORD ImportNameTableRVA;
    DWORD BoundImportAddressTableRVA;
    DWORD UnloadInformationTableRVA;
    DWORD TimeDateStamp;

} IMAGE_DELAYLOAD_DESCRIPTOR, *PIMAGE_DELAYLOAD_DESCRIPTOR;

typedef const IMAGE_DELAYLOAD_DESCRIPTOR *PCIMAGE_DELAYLOAD_DESCRIPTOR;
typedef struct _IMAGE_RESOURCE_DIRECTORY
{
    DWORD Characteristics;
    DWORD TimeDateStamp;
    WORD MajorVersion;
    WORD MinorVersion;
    WORD NumberOfNamedEntries;
    WORD NumberOfIdEntries;

} IMAGE_RESOURCE_DIRECTORY, *PIMAGE_RESOURCE_DIRECTORY;
typedef struct _IMAGE_RESOURCE_DIRECTORY_ENTRY
{
    union
    {
        struct
        {
            DWORD NameOffset : 31;
            DWORD NameIsString : 1;
        } s;
        DWORD Name;
        WORD Id;
    } u;
    union
    {
        DWORD OffsetToData;
        struct
        {
            DWORD OffsetToDirectory : 31;
            DWORD DataIsDirectory : 1;
        } s2;
    } u2;
} IMAGE_RESOURCE_DIRECTORY_ENTRY, *PIMAGE_RESOURCE_DIRECTORY_ENTRY;

typedef struct _IMAGE_RESOURCE_DIRECTORY_STRING
{
    WORD Length;
    CHAR NameString[1];
} IMAGE_RESOURCE_DIRECTORY_STRING, *PIMAGE_RESOURCE_DIRECTORY_STRING;

typedef struct _IMAGE_RESOURCE_DIR_STRING_U
{
    WORD Length;
    WCHAR NameString[1];
} IMAGE_RESOURCE_DIR_STRING_U, *PIMAGE_RESOURCE_DIR_STRING_U;
typedef struct _IMAGE_RESOURCE_DATA_ENTRY
{
    DWORD OffsetToData;
    DWORD Size;
    DWORD CodePage;
    DWORD Reserved;
} IMAGE_RESOURCE_DATA_ENTRY, *PIMAGE_RESOURCE_DATA_ENTRY;

typedef struct _IMAGE_LOAD_CONFIG_CODE_INTEGRITY
{
    WORD Flags;
    WORD Catalog;
    DWORD CatalogOffset;
    DWORD Reserved;
} IMAGE_LOAD_CONFIG_CODE_INTEGRITY, *PIMAGE_LOAD_CONFIG_CODE_INTEGRITY;

typedef struct _IMAGE_DYNAMIC_RELOCATION_TABLE
{
    DWORD Version;
    DWORD Size;

} IMAGE_DYNAMIC_RELOCATION_TABLE, *PIMAGE_DYNAMIC_RELOCATION_TABLE;

typedef struct _IMAGE_DYNAMIC_RELOCATION32
{
    DWORD Symbol;
    DWORD BaseRelocSize;

} IMAGE_DYNAMIC_RELOCATION32, *PIMAGE_DYNAMIC_RELOCATION32;

typedef struct _IMAGE_DYNAMIC_RELOCATION64
{
    ULONGLONG Symbol;
    DWORD BaseRelocSize;

} IMAGE_DYNAMIC_RELOCATION64, *PIMAGE_DYNAMIC_RELOCATION64;

typedef struct _IMAGE_DYNAMIC_RELOCATION32_V2
{
    DWORD HeaderSize;
    DWORD FixupInfoSize;
    DWORD Symbol;
    DWORD SymbolGroup;
    DWORD Flags;

} IMAGE_DYNAMIC_RELOCATION32_V2, *PIMAGE_DYNAMIC_RELOCATION32_V2;

typedef struct _IMAGE_DYNAMIC_RELOCATION64_V2
{
    DWORD HeaderSize;
    DWORD FixupInfoSize;
    ULONGLONG Symbol;
    DWORD SymbolGroup;
    DWORD Flags;

} IMAGE_DYNAMIC_RELOCATION64_V2, *PIMAGE_DYNAMIC_RELOCATION64_V2;

typedef IMAGE_DYNAMIC_RELOCATION32 IMAGE_DYNAMIC_RELOCATION;
typedef PIMAGE_DYNAMIC_RELOCATION32 PIMAGE_DYNAMIC_RELOCATION;
typedef IMAGE_DYNAMIC_RELOCATION32_V2 IMAGE_DYNAMIC_RELOCATION_V2;
typedef PIMAGE_DYNAMIC_RELOCATION32_V2 PIMAGE_DYNAMIC_RELOCATION_V2;

typedef struct _IMAGE_PROLOGUE_DYNAMIC_RELOCATION_HEADER
{
    BYTE PrologueByteCount;

} IMAGE_PROLOGUE_DYNAMIC_RELOCATION_HEADER;
typedef IMAGE_PROLOGUE_DYNAMIC_RELOCATION_HEADER *PIMAGE_PROLOGUE_DYNAMIC_RELOCATION_HEADER;

typedef struct _IMAGE_EPILOGUE_DYNAMIC_RELOCATION_HEADER
{
    DWORD EpilogueCount;
    BYTE EpilogueByteCount;
    BYTE BranchDescriptorElementSize;
    WORD BranchDescriptorCount;

} IMAGE_EPILOGUE_DYNAMIC_RELOCATION_HEADER;
typedef IMAGE_EPILOGUE_DYNAMIC_RELOCATION_HEADER *PIMAGE_EPILOGUE_DYNAMIC_RELOCATION_HEADER;

typedef struct _IMAGE_IMPORT_CONTROL_TRANSFER_DYNAMIC_RELOCATION
{
    DWORD PageRelativeOffset : 12;
    DWORD IndirectCall : 1;
    DWORD IATIndex : 19;
} IMAGE_IMPORT_CONTROL_TRANSFER_DYNAMIC_RELOCATION;
typedef IMAGE_IMPORT_CONTROL_TRANSFER_DYNAMIC_RELOCATION *PIMAGE_IMPORT_CONTROL_TRANSFER_DYNAMIC_RELOCATION;

typedef struct _IMAGE_INDIR_CONTROL_TRANSFER_DYNAMIC_RELOCATION
{
    WORD PageRelativeOffset : 12;
    WORD IndirectCall : 1;
    WORD RexWPrefix : 1;
    WORD CfgCheck : 1;
    WORD Reserved : 1;
} IMAGE_INDIR_CONTROL_TRANSFER_DYNAMIC_RELOCATION;
typedef IMAGE_INDIR_CONTROL_TRANSFER_DYNAMIC_RELOCATION *PIMAGE_INDIR_CONTROL_TRANSFER_DYNAMIC_RELOCATION;

typedef struct _IMAGE_SWITCHTABLE_BRANCH_DYNAMIC_RELOCATION
{
    WORD PageRelativeOffset : 12;
    WORD RegisterNumber : 4;
} IMAGE_SWITCHTABLE_BRANCH_DYNAMIC_RELOCATION;
typedef IMAGE_SWITCHTABLE_BRANCH_DYNAMIC_RELOCATION *PIMAGE_SWITCHTABLE_BRANCH_DYNAMIC_RELOCATION;

typedef struct _IMAGE_LOAD_CONFIG_DIRECTORY32
{
    DWORD Size;
    DWORD TimeDateStamp;
    WORD MajorVersion;
    WORD MinorVersion;
    DWORD GlobalFlagsClear;
    DWORD GlobalFlagsSet;
    DWORD CriticalSectionDefaultTimeout;
    DWORD DeCommitFreeBlockThreshold;
    DWORD DeCommitTotalFreeThreshold;
    DWORD LockPrefixTable;
    DWORD MaximumAllocationSize;
    DWORD VirtualMemoryThreshold;
    DWORD ProcessHeapFlags;
    DWORD ProcessAffinityMask;
    WORD CSDVersion;
    WORD DependentLoadFlags;
    DWORD EditList;
    DWORD SecurityCookie;
    DWORD SEHandlerTable;
    DWORD SEHandlerCount;
    DWORD GuardCFCheckFunctionPointer;
    DWORD GuardCFDispatchFunctionPointer;
    DWORD GuardCFFunctionTable;
    DWORD GuardCFFunctionCount;
    DWORD GuardFlags;
    IMAGE_LOAD_CONFIG_CODE_INTEGRITY CodeIntegrity;
    DWORD GuardAddressTakenIatEntryTable;
    DWORD GuardAddressTakenIatEntryCount;
    DWORD GuardLongJumpTargetTable;
    DWORD GuardLongJumpTargetCount;
    DWORD DynamicValueRelocTable;
    DWORD CHPEMetadataPointer;
    DWORD GuardRFFailureRoutine;
    DWORD GuardRFFailureRoutineFunctionPointer;
    DWORD DynamicValueRelocTableOffset;
    WORD DynamicValueRelocTableSection;
    WORD Reserved2;
    DWORD GuardRFVerifyStackPointerFunctionPointer;
    DWORD HotPatchTableOffset;
    DWORD Reserved3;
    DWORD EnclaveConfigurationPointer;
    DWORD VolatileMetadataPointer;
    DWORD GuardEHContinuationTable;
    DWORD GuardEHContinuationCount;
} IMAGE_LOAD_CONFIG_DIRECTORY32, *PIMAGE_LOAD_CONFIG_DIRECTORY32;

typedef struct _IMAGE_LOAD_CONFIG_DIRECTORY64
{
    DWORD Size;
    DWORD TimeDateStamp;
    WORD MajorVersion;
    WORD MinorVersion;
    DWORD GlobalFlagsClear;
    DWORD GlobalFlagsSet;
    DWORD CriticalSectionDefaultTimeout;
    ULONGLONG DeCommitFreeBlockThreshold;
    ULONGLONG DeCommitTotalFreeThreshold;
    ULONGLONG LockPrefixTable;
    ULONGLONG MaximumAllocationSize;
    ULONGLONG VirtualMemoryThreshold;
    ULONGLONG ProcessAffinityMask;
    DWORD ProcessHeapFlags;
    WORD CSDVersion;
    WORD DependentLoadFlags;
    ULONGLONG EditList;
    ULONGLONG SecurityCookie;
    ULONGLONG SEHandlerTable;
    ULONGLONG SEHandlerCount;
    ULONGLONG GuardCFCheckFunctionPointer;
    ULONGLONG GuardCFDispatchFunctionPointer;
    ULONGLONG GuardCFFunctionTable;
    ULONGLONG GuardCFFunctionCount;
    DWORD GuardFlags;
    IMAGE_LOAD_CONFIG_CODE_INTEGRITY CodeIntegrity;
    ULONGLONG GuardAddressTakenIatEntryTable;
    ULONGLONG GuardAddressTakenIatEntryCount;
    ULONGLONG GuardLongJumpTargetTable;
    ULONGLONG GuardLongJumpTargetCount;
    ULONGLONG DynamicValueRelocTable;
    ULONGLONG CHPEMetadataPointer;
    ULONGLONG GuardRFFailureRoutine;
    ULONGLONG GuardRFFailureRoutineFunctionPointer;
    DWORD DynamicValueRelocTableOffset;
    WORD DynamicValueRelocTableSection;
    WORD Reserved2;
    ULONGLONG GuardRFVerifyStackPointerFunctionPointer;
    DWORD HotPatchTableOffset;
    DWORD Reserved3;
    ULONGLONG EnclaveConfigurationPointer;
    ULONGLONG VolatileMetadataPointer;
    ULONGLONG GuardEHContinuationTable;
    ULONGLONG GuardEHContinuationCount;
} IMAGE_LOAD_CONFIG_DIRECTORY64, *PIMAGE_LOAD_CONFIG_DIRECTORY64;

typedef IMAGE_LOAD_CONFIG_DIRECTORY32 IMAGE_LOAD_CONFIG_DIRECTORY;
typedef PIMAGE_LOAD_CONFIG_DIRECTORY32 PIMAGE_LOAD_CONFIG_DIRECTORY;

typedef struct _IMAGE_HOT_PATCH_INFO
{
    DWORD Version;
    DWORD Size;
    DWORD SequenceNumber;
    DWORD BaseImageList;
    DWORD BaseImageCount;
    DWORD BufferOffset;
    DWORD ExtraPatchSize;
} IMAGE_HOT_PATCH_INFO, *PIMAGE_HOT_PATCH_INFO;

typedef struct _IMAGE_HOT_PATCH_BASE
{
    DWORD SequenceNumber;
    DWORD Flags;
    DWORD OriginalTimeDateStamp;
    DWORD OriginalCheckSum;
    DWORD CodeIntegrityInfo;
    DWORD CodeIntegritySize;
    DWORD PatchTable;
    DWORD BufferOffset;
} IMAGE_HOT_PATCH_BASE, *PIMAGE_HOT_PATCH_BASE;

typedef struct _IMAGE_HOT_PATCH_HASHES
{
    BYTE SHA256[32];
    BYTE SHA1[20];
} IMAGE_HOT_PATCH_HASHES, *PIMAGE_HOT_PATCH_HASHES;
typedef struct _IMAGE_CE_RUNTIME_FUNCTION_ENTRY
{
    DWORD FuncStart;
    DWORD PrologLen : 8;
    DWORD FuncLen : 22;
    DWORD ThirtyTwoBit : 1;
    DWORD ExceptionFlag : 1;
} IMAGE_CE_RUNTIME_FUNCTION_ENTRY, *PIMAGE_CE_RUNTIME_FUNCTION_ENTRY;

typedef struct _IMAGE_ARM_RUNTIME_FUNCTION_ENTRY
{
    DWORD BeginAddress;
    union
    {
        DWORD UnwindData;
        struct
        {
            DWORD Flag : 2;
            DWORD FunctionLength : 11;
            DWORD Ret : 2;
            DWORD H : 1;
            DWORD Reg : 3;
            DWORD R : 1;
            DWORD L : 1;
            DWORD C : 1;
            DWORD StackAdjust : 10;
        } s;
    } u;
} IMAGE_ARM_RUNTIME_FUNCTION_ENTRY, *PIMAGE_ARM_RUNTIME_FUNCTION_ENTRY;

typedef enum ARM64_FNPDATA_FLAGS
{
    PdataRefToFullXdata = 0,
    PdataPackedUnwindFunction = 1,
    PdataPackedUnwindFragment = 2,
} ARM64_FNPDATA_FLAGS;

typedef enum ARM64_FNPDATA_CR
{
    PdataCrUnchained = 0,
    PdataCrUnchainedSavedLr = 1,
    PdataCrChainedWithPac = 2,
    PdataCrChained = 3,
} ARM64_FNPDATA_CR;

typedef struct _IMAGE_ARM64_RUNTIME_FUNCTION_ENTRY
{
    DWORD BeginAddress;
    union
    {
        DWORD UnwindData;
        struct
        {
            DWORD Flag : 2;
            DWORD FunctionLength : 11;
            DWORD RegF : 3;
            DWORD RegI : 4;
            DWORD H : 1;
            DWORD CR : 2;
            DWORD FrameSize : 9;
        } s;
    } u;
} IMAGE_ARM64_RUNTIME_FUNCTION_ENTRY, *PIMAGE_ARM64_RUNTIME_FUNCTION_ENTRY;

typedef union IMAGE_ARM64_RUNTIME_FUNCTION_ENTRY_XDATA
{
    DWORD HeaderData;
    struct
    {
        DWORD FunctionLength : 18;
        DWORD Version : 2;
        DWORD ExceptionDataPresent : 1;
        DWORD EpilogInHeader : 1;
        DWORD EpilogCount : 5;
        DWORD CodeWords : 5;
    };
} IMAGE_ARM64_RUNTIME_FUNCTION_ENTRY_XDATA;

typedef struct _IMAGE_ALPHA64_RUNTIME_FUNCTION_ENTRY
{
    ULONGLONG BeginAddress;
    ULONGLONG EndAddress;
    ULONGLONG ExceptionHandler;
    ULONGLONG HandlerData;
    ULONGLONG PrologEndAddress;
} IMAGE_ALPHA64_RUNTIME_FUNCTION_ENTRY, *PIMAGE_ALPHA64_RUNTIME_FUNCTION_ENTRY;

typedef struct _IMAGE_ALPHA_RUNTIME_FUNCTION_ENTRY
{
    DWORD BeginAddress;
    DWORD EndAddress;
    DWORD ExceptionHandler;
    DWORD HandlerData;
    DWORD PrologEndAddress;
} IMAGE_ALPHA_RUNTIME_FUNCTION_ENTRY, *PIMAGE_ALPHA_RUNTIME_FUNCTION_ENTRY;

typedef struct _IMAGE_RUNTIME_FUNCTION_ENTRY
{
    DWORD BeginAddress;
    DWORD EndAddress;
    union
    {
        DWORD UnwindInfoAddress;
        DWORD UnwindData;
    } u;
} _IMAGE_RUNTIME_FUNCTION_ENTRY, *_PIMAGE_RUNTIME_FUNCTION_ENTRY;

typedef _IMAGE_RUNTIME_FUNCTION_ENTRY IMAGE_IA64_RUNTIME_FUNCTION_ENTRY;
typedef _PIMAGE_RUNTIME_FUNCTION_ENTRY PIMAGE_IA64_RUNTIME_FUNCTION_ENTRY;
typedef _IMAGE_RUNTIME_FUNCTION_ENTRY IMAGE_RUNTIME_FUNCTION_ENTRY;
typedef _PIMAGE_RUNTIME_FUNCTION_ENTRY PIMAGE_RUNTIME_FUNCTION_ENTRY;

typedef struct _IMAGE_ENCLAVE_CONFIG32
{
    DWORD Size;
    DWORD MinimumRequiredConfigSize;
    DWORD PolicyFlags;
    DWORD NumberOfImports;
    DWORD ImportList;
    DWORD ImportEntrySize;
    BYTE FamilyID[16];
    BYTE ImageID[16];
    DWORD ImageVersion;
    DWORD SecurityVersion;
    DWORD EnclaveSize;
    DWORD NumberOfThreads;
    DWORD EnclaveFlags;
} IMAGE_ENCLAVE_CONFIG32, *PIMAGE_ENCLAVE_CONFIG32;

typedef struct _IMAGE_ENCLAVE_CONFIG64
{
    DWORD Size;
    DWORD MinimumRequiredConfigSize;
    DWORD PolicyFlags;
    DWORD NumberOfImports;
    DWORD ImportList;
    DWORD ImportEntrySize;
    BYTE FamilyID[16];
    BYTE ImageID[16];
    DWORD ImageVersion;
    DWORD SecurityVersion;
    ULONGLONG EnclaveSize;
    DWORD NumberOfThreads;
    DWORD EnclaveFlags;
} IMAGE_ENCLAVE_CONFIG64, *PIMAGE_ENCLAVE_CONFIG64;

typedef IMAGE_ENCLAVE_CONFIG32 IMAGE_ENCLAVE_CONFIG;
typedef PIMAGE_ENCLAVE_CONFIG32 PIMAGE_ENCLAVE_CONFIG;

typedef struct _IMAGE_ENCLAVE_IMPORT
{
    DWORD MatchType;
    DWORD MinimumSecurityVersion;
    BYTE UniqueOrAuthorID[32];
    BYTE FamilyID[16];
    BYTE ImageID[16];
    DWORD ImportName;
    DWORD Reserved;
} IMAGE_ENCLAVE_IMPORT, *PIMAGE_ENCLAVE_IMPORT;
typedef struct _IMAGE_DEBUG_DIRECTORY
{
    DWORD Characteristics;
    DWORD TimeDateStamp;
    WORD MajorVersion;
    WORD MinorVersion;
    DWORD Type;
    DWORD SizeOfData;
    DWORD AddressOfRawData;
    DWORD PointerToRawData;
} IMAGE_DEBUG_DIRECTORY, *PIMAGE_DEBUG_DIRECTORY;
typedef struct _IMAGE_COFF_SYMBOLS_HEADER
{
    DWORD NumberOfSymbols;
    DWORD LvaToFirstSymbol;
    DWORD NumberOfLinenumbers;
    DWORD LvaToFirstLinenumber;
    DWORD RvaToFirstByteOfCode;
    DWORD RvaToLastByteOfCode;
    DWORD RvaToFirstByteOfData;
    DWORD RvaToLastByteOfData;
} IMAGE_COFF_SYMBOLS_HEADER, *PIMAGE_COFF_SYMBOLS_HEADER;

typedef struct _FPO_DATA
{
    DWORD ulOffStart;
    DWORD cbProcSize;
    DWORD cdwLocals;
    WORD cdwParams;
    WORD cbProlog : 8;
    WORD cbRegs : 3;
    WORD fHasSEH : 1;
    WORD fUseBP : 1;
    WORD reserved : 1;
    WORD cbFrame : 2;
} FPO_DATA, *PFPO_DATA;

typedef struct _IMAGE_DEBUG_MISC
{
    DWORD DataType;
    DWORD Length;
    BOOLEAN Unicode;
    BYTE Reserved[3];
    BYTE Data[1];
} IMAGE_DEBUG_MISC, *PIMAGE_DEBUG_MISC;

typedef struct _IMAGE_FUNCTION_ENTRY
{
    DWORD StartingAddress;
    DWORD EndingAddress;
    DWORD EndOfPrologue;
} IMAGE_FUNCTION_ENTRY, *PIMAGE_FUNCTION_ENTRY;

typedef struct _IMAGE_FUNCTION_ENTRY64
{
    ULONGLONG StartingAddress;
    ULONGLONG EndingAddress;
    union
    {
        ULONGLONG EndOfPrologue;
        ULONGLONG UnwindInfoAddress;
    } u;
} IMAGE_FUNCTION_ENTRY64, *PIMAGE_FUNCTION_ENTRY64;
typedef struct _IMAGE_SEPARATE_DEBUG_HEADER
{
    WORD Signature;
    WORD Flags;
    WORD Machine;
    WORD Characteristics;
    DWORD TimeDateStamp;
    DWORD CheckSum;
    DWORD ImageBase;
    DWORD SizeOfImage;
    DWORD NumberOfSections;
    DWORD ExportedNamesSize;
    DWORD DebugDirectorySize;
    DWORD SectionAlignment;
    DWORD Reserved[2];
} IMAGE_SEPARATE_DEBUG_HEADER, *PIMAGE_SEPARATE_DEBUG_HEADER;

typedef struct _NON_PAGED_DEBUG_INFO
{
    WORD Signature;
    WORD Flags;
    DWORD Size;
    WORD Machine;
    WORD Characteristics;
    DWORD TimeDateStamp;
    DWORD CheckSum;
    DWORD SizeOfImage;
    ULONGLONG ImageBase;

} NON_PAGED_DEBUG_INFO, *PNON_PAGED_DEBUG_INFO;
typedef struct _ImageArchitectureHeader
{
    unsigned int AmaskValue : 1;
    int : 7;
    unsigned int AmaskShift : 8;
    int : 16;
    DWORD FirstEntryRVA;
} IMAGE_ARCHITECTURE_HEADER, *PIMAGE_ARCHITECTURE_HEADER;

typedef struct _ImageArchitectureEntry
{
    DWORD FixupInstRVA;
    DWORD NewInst;
} IMAGE_ARCHITECTURE_ENTRY, *PIMAGE_ARCHITECTURE_ENTRY;

typedef struct IMPORT_OBJECT_HEADER
{
    WORD Sig1;
    WORD Sig2;
    WORD Version;
    WORD Machine;
    DWORD TimeDateStamp;
    DWORD SizeOfData;
    union
    {
        WORD Ordinal;
        WORD Hint;
    } u;
    WORD Type : 2;
    WORD NameType : 3;
    WORD Reserved : 11;
} IMPORT_OBJECT_HEADER;

typedef enum IMPORT_OBJECT_TYPE
{
    IMPORT_OBJECT_CODE = 0,
    IMPORT_OBJECT_DATA = 1,
    IMPORT_OBJECT_CONST = 2,
} IMPORT_OBJECT_TYPE;

typedef enum IMPORT_OBJECT_NAME_TYPE
{
    IMPORT_OBJECT_ORDINAL = 0,
    IMPORT_OBJECT_NAME = 1,
    IMPORT_OBJECT_NAME_NO_PREFIX = 2,
    IMPORT_OBJECT_NAME_UNDECORATE = 3,
    IMPORT_OBJECT_NAME_EXPORTAS = 4,
} IMPORT_OBJECT_NAME_TYPE;

typedef enum ReplacesCorHdrNumericDefines
{
    COMIMAGE_FLAGS_ILONLY = 0x00000001,
    COMIMAGE_FLAGS_32BITREQUIRED = 0x00000002,
    COMIMAGE_FLAGS_IL_LIBRARY = 0x00000004,
    COMIMAGE_FLAGS_STRONGNAMESIGNED = 0x00000008,
    COMIMAGE_FLAGS_NATIVE_ENTRYPOINT = 0x00000010,
    COMIMAGE_FLAGS_TRACKDEBUGDATA = 0x00010000,
    COMIMAGE_FLAGS_32BITPREFERRED = 0x00020000,
    COR_VERSION_MAJOR_V2 = 2,
    COR_VERSION_MAJOR = COR_VERSION_MAJOR_V2,
    COR_VERSION_MINOR = 5,
    COR_DELETED_NAME_LENGTH = 8,
    COR_VTABLEGAP_NAME_LENGTH = 8,
    NATIVE_TYPE_MAX_CB = 1,
    COR_ILMETHOD_SECT_SMALL_MAX_DATASIZE = 0xFF,
    IMAGE_COR_MIH_METHODRVA = 0x01,
    IMAGE_COR_MIH_EHRVA = 0x02,
    IMAGE_COR_MIH_BASICBLOCK = 0x08,
    COR_VTABLE_32BIT = 0x01,
    COR_VTABLE_64BIT = 0x02,
    COR_VTABLE_FROM_UNMANAGED = 0x04,
    COR_VTABLE_FROM_UNMANAGED_RETAIN_APPDOMAIN = 0x08,
    COR_VTABLE_CALL_MOST_DERIVED = 0x10,
    IMAGE_COR_EATJ_THUNK_SIZE = 32,
    MAX_CLASS_NAME = 1024,
    MAX_PACKAGE_NAME = 1024,
} ReplacesCorHdrNumericDefines;

typedef struct IMAGE_COR20_HEADER
{
    DWORD cb;
    WORD MajorRuntimeVersion;
    WORD MinorRuntimeVersion;
    IMAGE_DATA_DIRECTORY MetaData;
    DWORD Flags;
    union
    {
        DWORD EntryPointToken;
        DWORD EntryPointRVA;
    } u;
    IMAGE_DATA_DIRECTORY Resources;
    IMAGE_DATA_DIRECTORY StrongNameSignature;
    IMAGE_DATA_DIRECTORY CodeManagerTable;
    IMAGE_DATA_DIRECTORY VTableFixups;
    IMAGE_DATA_DIRECTORY ExportAddressTableJumps;
    IMAGE_DATA_DIRECTORY ManagedNativeHeader;

} IMAGE_COR20_HEADER, *PIMAGE_COR20_HEADER;

typedef struct _SINGLE_LIST_ENTRY SLIST_ENTRY, *PSLIST_ENTRY;
typedef union _SLIST_HEADER
{
    ULONGLONG Alignment;
    struct
    {
        SLIST_ENTRY Next;
        WORD Depth;
        WORD CpuId;
    } s;
} SLIST_HEADER, *PSLIST_HEADER;

typedef union _RTL_RUN_ONCE
{
    PVOID Ptr;
} RTL_RUN_ONCE, *PRTL_RUN_ONCE;

typedef struct _RTL_BARRIER
{
    DWORD Reserved1;
    DWORD Reserved2;
    ULONG_PTR Reserved3[2];
    DWORD Reserved4;
    DWORD Reserved5;
} RTL_BARRIER, *PRTL_BARRIER;

typedef struct _MESSAGE_RESOURCE_ENTRY
{
    WORD Length;
    WORD Flags;
    BYTE Text[1];
} MESSAGE_RESOURCE_ENTRY, *PMESSAGE_RESOURCE_ENTRY;

typedef struct _MESSAGE_RESOURCE_BLOCK
{
    DWORD LowId;
    DWORD HighId;
    DWORD OffsetToEntries;
} MESSAGE_RESOURCE_BLOCK, *PMESSAGE_RESOURCE_BLOCK;

typedef struct _MESSAGE_RESOURCE_DATA
{
    DWORD NumberOfBlocks;
    MESSAGE_RESOURCE_BLOCK Blocks[1];
} MESSAGE_RESOURCE_DATA, *PMESSAGE_RESOURCE_DATA;

typedef struct _OSVERSIONINFOA
{
    DWORD dwOSVersionInfoSize;
    DWORD dwMajorVersion;
    DWORD dwMinorVersion;
    DWORD dwBuildNumber;
    DWORD dwPlatformId;
    CHAR szCSDVersion[128];
} OSVERSIONINFOA, *POSVERSIONINFOA, *LPOSVERSIONINFOA;

typedef struct _OSVERSIONINFOW
{
    DWORD dwOSVersionInfoSize;
    DWORD dwMajorVersion;
    DWORD dwMinorVersion;
    DWORD dwBuildNumber;
    DWORD dwPlatformId;
    WCHAR szCSDVersion[128];
} OSVERSIONINFOW, *POSVERSIONINFOW, *LPOSVERSIONINFOW, RTL_OSVERSIONINFOW, *PRTL_OSVERSIONINFOW;

typedef OSVERSIONINFOA OSVERSIONINFO;
typedef POSVERSIONINFOA POSVERSIONINFO;
typedef LPOSVERSIONINFOA LPOSVERSIONINFO;

typedef struct _OSVERSIONINFOEXA
{
    DWORD dwOSVersionInfoSize;
    DWORD dwMajorVersion;
    DWORD dwMinorVersion;
    DWORD dwBuildNumber;
    DWORD dwPlatformId;
    CHAR szCSDVersion[128];
    WORD wServicePackMajor;
    WORD wServicePackMinor;
    WORD wSuiteMask;
    BYTE wProductType;
    BYTE wReserved;
} OSVERSIONINFOEXA, *POSVERSIONINFOEXA, *LPOSVERSIONINFOEXA;
typedef struct _OSVERSIONINFOEXW
{
    DWORD dwOSVersionInfoSize;
    DWORD dwMajorVersion;
    DWORD dwMinorVersion;
    DWORD dwBuildNumber;
    DWORD dwPlatformId;
    WCHAR szCSDVersion[128];
    WORD wServicePackMajor;
    WORD wServicePackMinor;
    WORD wSuiteMask;
    BYTE wProductType;
    BYTE wReserved;
} OSVERSIONINFOEXW, *POSVERSIONINFOEXW, *LPOSVERSIONINFOEXW, RTL_OSVERSIONINFOEXW, *PRTL_OSVERSIONINFOEXW;

typedef OSVERSIONINFOEXA OSVERSIONINFOEX;
typedef POSVERSIONINFOEXA POSVERSIONINFOEX;
typedef LPOSVERSIONINFOEXA LPOSVERSIONINFOEX;

typedef enum _RTL_UMS_THREAD_INFO_CLASS
{
    UmsThreadInvalidInfoClass = 0,
    UmsThreadUserContext,
    UmsThreadPriority,
    UmsThreadAffinity,
    UmsThreadTeb,
    UmsThreadIsSuspended,
    UmsThreadIsTerminated,
    UmsThreadMaxInfoClass
} RTL_UMS_THREAD_INFO_CLASS,
    *PRTL_UMS_THREAD_INFO_CLASS;

typedef enum _RTL_UMS_SCHEDULER_REASON
{
    UmsSchedulerStartup = 0,
    UmsSchedulerThreadBlocked,
    UmsSchedulerThreadYield,
} RTL_UMS_SCHEDULER_REASON,
    *PRTL_UMS_SCHEDULER_REASON;

typedef void RTL_UMS_SCHEDULER_ENTRY_POINT(
    RTL_UMS_SCHEDULER_REASON Reason,
    ULONG_PTR ActivationPayload,
    PVOID SchedulerParam);

typedef RTL_UMS_SCHEDULER_ENTRY_POINT *PRTL_UMS_SCHEDULER_ENTRY_POINT;

typedef enum _OS_DEPLOYEMENT_STATE_VALUES
{
    OS_DEPLOYMENT_STANDARD = 1,
    OS_DEPLOYMENT_COMPACT
} OS_DEPLOYEMENT_STATE_VALUES;

typedef struct _NV_MEMORY_RANGE
{
    void *BaseAddress;
    SIZE_T Length;
} NV_MEMORY_RANGE, *PNV_MEMORY_RANGE;
typedef struct CORRELATION_VECTOR
{
    CHAR Version;
    CHAR Vector[129];
} CORRELATION_VECTOR;

typedef CORRELATION_VECTOR *PCORRELATION_VECTOR;

typedef struct _CUSTOM_SYSTEM_EVENT_TRIGGER_CONFIG
{
    DWORD Size;
    PCWSTR TriggerId;

} CUSTOM_SYSTEM_EVENT_TRIGGER_CONFIG, *PCUSTOM_SYSTEM_EVENT_TRIGGER_CONFIG;

typedef enum _IMAGE_POLICY_ENTRY_TYPE
{
    ImagePolicyEntryTypeNone = 0,
    ImagePolicyEntryTypeBool,
    ImagePolicyEntryTypeInt8,
    ImagePolicyEntryTypeUInt8,
    ImagePolicyEntryTypeInt16,
    ImagePolicyEntryTypeUInt16,
    ImagePolicyEntryTypeInt32,
    ImagePolicyEntryTypeUInt32,
    ImagePolicyEntryTypeInt64,
    ImagePolicyEntryTypeUInt64,
    ImagePolicyEntryTypeAnsiString,
    ImagePolicyEntryTypeUnicodeString,
    ImagePolicyEntryTypeOverride,
    ImagePolicyEntryTypeMaximum
} IMAGE_POLICY_ENTRY_TYPE;

typedef enum _IMAGE_POLICY_ID
{
    ImagePolicyIdNone = 0,
    ImagePolicyIdEtw,
    ImagePolicyIdDebug,
    ImagePolicyIdCrashDump,
    ImagePolicyIdCrashDumpKey,
    ImagePolicyIdCrashDumpKeyGuid,
    ImagePolicyIdParentSd,
    ImagePolicyIdParentSdRev,
    ImagePolicyIdSvn,
    ImagePolicyIdDeviceId,
    ImagePolicyIdCapability,
    ImagePolicyIdScenarioId,
    ImagePolicyIdMaximum
} IMAGE_POLICY_ID;

typedef struct _IMAGE_POLICY_ENTRY
{
    IMAGE_POLICY_ENTRY_TYPE Type;
    IMAGE_POLICY_ID PolicyId;
    union
    {
        const void *None;
        BOOLEAN BoolValue;
        INT8 Int8Value;
        UINT8 UInt8Value;
        INT16 Int16Value;
        UINT16 UInt16Value;
        INT32 Int32Value;
        UINT32 UInt32Value;
        INT64 Int64Value;
        UINT64 UInt64Value;
        PCSTR AnsiStringValue;
        PCWSTR UnicodeStringValue;
    } u;
} IMAGE_POLICY_ENTRY;
typedef const IMAGE_POLICY_ENTRY *PCIMAGE_POLICY_ENTRY;

typedef struct _IMAGE_POLICY_METADATA
{
    BYTE Version;
    BYTE Reserved0[7];
    ULONGLONG ApplicationId;
    IMAGE_POLICY_ENTRY Policies[];
} IMAGE_POLICY_METADATA;
typedef const IMAGE_POLICY_METADATA *PCIMAGE_POLICY_METADATA;

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
} RTL_CRITICAL_SECTION_DEBUG, *PRTL_CRITICAL_SECTION_DEBUG, RTL_RESOURCE_DEBUG, *PRTL_RESOURCE_DEBUG;

typedef struct _RTL_CRITICAL_SECTION
{
    PRTL_CRITICAL_SECTION_DEBUG DebugInfo;
    LONG LockCount;
    LONG RecursionCount;
    HANDLE OwningThread;
    HANDLE LockSemaphore;
    ULONG_PTR SpinCount;
} RTL_CRITICAL_SECTION, *PRTL_CRITICAL_SECTION;

typedef struct _RTL_SRWLOCK
{
    PVOID Ptr;
} RTL_SRWLOCK, *PRTL_SRWLOCK;

typedef struct _RTL_CONDITION_VARIABLE
{
    PVOID Ptr;
} RTL_CONDITION_VARIABLE, *PRTL_CONDITION_VARIABLE;

typedef void (*PAPCFUNC)(
    ULONG_PTR Parameter);
typedef LONG (*PVECTORED_EXCEPTION_HANDLER)(
    struct _EXCEPTION_POINTERS *ExceptionInfo);

typedef enum _HEAP_INFORMATION_CLASS
{
    HeapCompatibilityInformation = 0,
    HeapEnableTerminationOnCorruption = 1,
    HeapOptimizeResources = 3

} HEAP_INFORMATION_CLASS;
typedef struct _HEAP_OPTIMIZE_RESOURCES_INFORMATION
{
    DWORD Version;
    DWORD Flags;
} HEAP_OPTIMIZE_RESOURCES_INFORMATION, *PHEAP_OPTIMIZE_RESOURCES_INFORMATION;
typedef void (*WAITORTIMERCALLBACKFUNC)(PVOID, BOOLEAN);
typedef void (*WORKERCALLBACKFUNC)(PVOID);
typedef void (*APC_CALLBACK_FUNCTION)(DWORD, PVOID, PVOID);
typedef WAITORTIMERCALLBACKFUNC WAITORTIMERCALLBACK;
typedef void (*PFLS_CALLBACK_FUNCTION)(
    PVOID lpFlsData);

typedef BOOLEAN (*PSECURE_MEMORY_CACHE_CALLBACK)(
    PVOID Addr,
    SIZE_T Range);

typedef enum _ACTIVATION_CONTEXT_INFO_CLASS
{
    ActivationContextBasicInformation = 1,
    ActivationContextDetailedInformation = 2,
    AssemblyDetailedInformationInActivationContext = 3,
    FileInformationInAssemblyOfAssemblyInActivationContext = 4,
    RunlevelInformationInActivationContext = 5,
    CompatibilityInformationInActivationContext = 6,
    ActivationContextManifestResourceName = 7,
    MaxActivationContextInfoClass,
    AssemblyDetailedInformationInActivationContxt = 3,
    FileInformationInAssemblyOfAssemblyInActivationContxt = 4
} ACTIVATION_CONTEXT_INFO_CLASS;

typedef struct _ACTIVATION_CONTEXT_QUERY_INDEX
{
    DWORD ulAssemblyIndex;
    DWORD ulFileIndexInAssembly;
} ACTIVATION_CONTEXT_QUERY_INDEX, *PACTIVATION_CONTEXT_QUERY_INDEX;

typedef const struct _ACTIVATION_CONTEXT_QUERY_INDEX *PCACTIVATION_CONTEXT_QUERY_INDEX;

typedef struct _ASSEMBLY_FILE_DETAILED_INFORMATION
{
    DWORD ulFlags;
    DWORD ulFilenameLength;
    DWORD ulPathLength;
    PCWSTR lpFileName;
    PCWSTR lpFilePath;
} ASSEMBLY_FILE_DETAILED_INFORMATION, *PASSEMBLY_FILE_DETAILED_INFORMATION;
typedef const ASSEMBLY_FILE_DETAILED_INFORMATION *PCASSEMBLY_FILE_DETAILED_INFORMATION;

typedef struct _ACTIVATION_CONTEXT_ASSEMBLY_DETAILED_INFORMATION
{
    DWORD ulFlags;
    DWORD ulEncodedAssemblyIdentityLength;
    DWORD ulManifestPathType;
    DWORD ulManifestPathLength;
    LARGE_INTEGER liManifestLastWriteTime;
    DWORD ulPolicyPathType;
    DWORD ulPolicyPathLength;
    LARGE_INTEGER liPolicyLastWriteTime;
    DWORD ulMetadataSatelliteRosterIndex;
    DWORD ulManifestVersionMajor;
    DWORD ulManifestVersionMinor;
    DWORD ulPolicyVersionMajor;
    DWORD ulPolicyVersionMinor;
    DWORD ulAssemblyDirectoryNameLength;
    PCWSTR lpAssemblyEncodedAssemblyIdentity;
    PCWSTR lpAssemblyManifestPath;
    PCWSTR lpAssemblyPolicyPath;
    PCWSTR lpAssemblyDirectoryName;
    DWORD ulFileCount;
} ACTIVATION_CONTEXT_ASSEMBLY_DETAILED_INFORMATION, *PACTIVATION_CONTEXT_ASSEMBLY_DETAILED_INFORMATION;

typedef const struct _ACTIVATION_CONTEXT_ASSEMBLY_DETAILED_INFORMATION *PCACTIVATION_CONTEXT_ASSEMBLY_DETAILED_INFORMATION;

typedef enum
{
    ACTCTX_RUN_LEVEL_UNSPECIFIED = 0,
    ACTCTX_RUN_LEVEL_AS_INVOKER,
    ACTCTX_RUN_LEVEL_HIGHEST_AVAILABLE,
    ACTCTX_RUN_LEVEL_REQUIRE_ADMIN,
    ACTCTX_RUN_LEVEL_NUMBERS
} ACTCTX_REQUESTED_RUN_LEVEL;

typedef struct _ACTIVATION_CONTEXT_RUN_LEVEL_INFORMATION
{
    DWORD ulFlags;
    ACTCTX_REQUESTED_RUN_LEVEL RunLevel;
    DWORD UiAccess;
} ACTIVATION_CONTEXT_RUN_LEVEL_INFORMATION, *PACTIVATION_CONTEXT_RUN_LEVEL_INFORMATION;

typedef const struct _ACTIVATION_CONTEXT_RUN_LEVEL_INFORMATION *PCACTIVATION_CONTEXT_RUN_LEVEL_INFORMATION;

typedef enum
{
    ACTCTX_COMPATIBILITY_ELEMENT_TYPE_UNKNOWN = 0,
    ACTCTX_COMPATIBILITY_ELEMENT_TYPE_OS,
    ACTCTX_COMPATIBILITY_ELEMENT_TYPE_MITIGATION,
    ACTCTX_COMPATIBILITY_ELEMENT_TYPE_MAXVERSIONTESTED
} ACTCTX_COMPATIBILITY_ELEMENT_TYPE;

typedef struct _COMPATIBILITY_CONTEXT_ELEMENT
{
    GUID Id;
    ACTCTX_COMPATIBILITY_ELEMENT_TYPE Type;
    ULONGLONG MaxVersionTested;
} COMPATIBILITY_CONTEXT_ELEMENT, *PCOMPATIBILITY_CONTEXT_ELEMENT;

typedef const struct _COMPATIBILITY_CONTEXT_ELEMENT *PCCOMPATIBILITY_CONTEXT_ELEMENT;
typedef struct _SUPPORTED_OS_INFO
{
    WORD MajorVersion;
    WORD MinorVersion;
} SUPPORTED_OS_INFO, *PSUPPORTED_OS_INFO;

typedef struct _MAXVERSIONTESTED_INFO
{
    ULONGLONG MaxVersionTested;
} MAXVERSIONTESTED_INFO, *PMAXVERSIONTESTED_INFO;

typedef struct _ACTIVATION_CONTEXT_DETAILED_INFORMATION
{
    DWORD dwFlags;
    DWORD ulFormatVersion;
    DWORD ulAssemblyCount;
    DWORD ulRootManifestPathType;
    DWORD ulRootManifestPathChars;
    DWORD ulRootConfigurationPathType;
    DWORD ulRootConfigurationPathChars;
    DWORD ulAppDirPathType;
    DWORD ulAppDirPathChars;
    PCWSTR lpRootManifestPath;
    PCWSTR lpRootConfigurationPath;
    PCWSTR lpAppDirPath;
} ACTIVATION_CONTEXT_DETAILED_INFORMATION, *PACTIVATION_CONTEXT_DETAILED_INFORMATION;

typedef const struct _ACTIVATION_CONTEXT_DETAILED_INFORMATION *PCACTIVATION_CONTEXT_DETAILED_INFORMATION;

typedef struct _HARDWARE_COUNTER_DATA
{
    HARDWARE_COUNTER_TYPE Type;
    DWORD Reserved;
    DWORD64 Value;
} HARDWARE_COUNTER_DATA, *PHARDWARE_COUNTER_DATA;

typedef struct _PERFORMANCE_DATA
{
    WORD Size;
    BYTE Version;
    BYTE HwCountersCount;
    DWORD ContextSwitchCount;
    DWORD64 WaitReasonBitMap;
    DWORD64 CycleTime;
    DWORD RetryCount;
    DWORD Reserved;
    HARDWARE_COUNTER_DATA HwCounters[16];
} PERFORMANCE_DATA, *PPERFORMANCE_DATA;

typedef struct _EVENTLOGRECORD
{
    DWORD Length;
    DWORD Reserved;
    DWORD RecordNumber;
    DWORD TimeGenerated;
    DWORD TimeWritten;
    DWORD EventID;
    WORD EventType;
    WORD NumStrings;
    WORD EventCategory;
    WORD ReservedFlags;
    DWORD ClosingRecordNumber;
    DWORD StringOffset;
    DWORD UserSidLength;
    DWORD UserSidOffset;
    DWORD DataLength;
    DWORD DataOffset;
} EVENTLOGRECORD, *PEVENTLOGRECORD;

struct _EVENTSFORLOGFILE;
typedef struct _EVENTSFORLOGFILE EVENTSFORLOGFILE, *PEVENTSFORLOGFILE;

struct _PACKEDEVENTINFO;
typedef struct _PACKEDEVENTINFO PACKEDEVENTINFO, *PPACKEDEVENTINFO;

typedef enum _CM_SERVICE_NODE_TYPE
{
    DriverType = 0x00000001,
    FileSystemType = 0x00000002,
    Win32ServiceOwnProcess = 0x00000010,
    Win32ServiceShareProcess = 0x00000020,
    AdapterType = 0x00000004,
    RecognizerType = 0x00000008
} SERVICE_NODE_TYPE;

typedef enum _CM_SERVICE_LOAD_TYPE
{
    BootLoad = 0x00000000,
    SystemLoad = 0x00000001,
    AutoLoad = 0x00000002,
    DemandLoad = 0x00000003,
    DisableLoad = 0x00000004
} SERVICE_LOAD_TYPE;

typedef enum _CM_ERROR_CONTROL_TYPE
{
    IgnoreError = 0x00000000,
    NormalError = 0x00000001,
    SevereError = 0x00000002,
    CriticalError = 0x00000003
} SERVICE_ERROR_TYPE;
typedef struct _TAPE_ERASE
{
    DWORD Type;
    BOOLEAN Immediate;
} TAPE_ERASE, *PTAPE_ERASE;
typedef struct _TAPE_PREPARE
{
    DWORD Operation;
    BOOLEAN Immediate;
} TAPE_PREPARE, *PTAPE_PREPARE;

typedef struct _TAPE_WRITE_MARKS
{
    DWORD Type;
    DWORD Count;
    BOOLEAN Immediate;
} TAPE_WRITE_MARKS, *PTAPE_WRITE_MARKS;

typedef struct _TAPE_GET_POSITION
{
    DWORD Type;
    DWORD Partition;
    LARGE_INTEGER Offset;
} TAPE_GET_POSITION, *PTAPE_GET_POSITION;
typedef struct _TAPE_SET_POSITION
{
    DWORD Method;
    DWORD Partition;
    LARGE_INTEGER Offset;
    BOOLEAN Immediate;
} TAPE_SET_POSITION, *PTAPE_SET_POSITION;
typedef struct _TAPE_GET_DRIVE_PARAMETERS
{
    BOOLEAN ECC;
    BOOLEAN Compression;
    BOOLEAN DataPadding;
    BOOLEAN ReportSetmarks;
    DWORD DefaultBlockSize;
    DWORD MaximumBlockSize;
    DWORD MinimumBlockSize;
    DWORD MaximumPartitionCount;
    DWORD FeaturesLow;
    DWORD FeaturesHigh;
    DWORD EOTWarningZoneSize;
} TAPE_GET_DRIVE_PARAMETERS, *PTAPE_GET_DRIVE_PARAMETERS;

typedef struct _TAPE_SET_DRIVE_PARAMETERS
{
    BOOLEAN ECC;
    BOOLEAN Compression;
    BOOLEAN DataPadding;
    BOOLEAN ReportSetmarks;
    DWORD EOTWarningZoneSize;
} TAPE_SET_DRIVE_PARAMETERS, *PTAPE_SET_DRIVE_PARAMETERS;

typedef struct _TAPE_GET_MEDIA_PARAMETERS
{
    LARGE_INTEGER Capacity;
    LARGE_INTEGER Remaining;
    DWORD BlockSize;
    DWORD PartitionCount;
    BOOLEAN WriteProtected;
} TAPE_GET_MEDIA_PARAMETERS, *PTAPE_GET_MEDIA_PARAMETERS;

typedef struct _TAPE_SET_MEDIA_PARAMETERS
{
    DWORD BlockSize;
} TAPE_SET_MEDIA_PARAMETERS, *PTAPE_SET_MEDIA_PARAMETERS;

typedef struct _TAPE_CREATE_PARTITION
{
    DWORD Method;
    DWORD Count;
    DWORD Size;
} TAPE_CREATE_PARTITION, *PTAPE_CREATE_PARTITION;
typedef struct _TAPE_WMI_OPERATIONS
{
    DWORD Method;
    DWORD DataBufferSize;
    PVOID DataBuffer;
} TAPE_WMI_OPERATIONS, *PTAPE_WMI_OPERATIONS;

typedef enum _TAPE_DRIVE_PROBLEM_TYPE
{
    TapeDriveProblemNone,
    TapeDriveReadWriteWarning,
    TapeDriveReadWriteError,
    TapeDriveReadWarning,
    TapeDriveWriteWarning,
    TapeDriveReadError,
    TapeDriveWriteError,
    TapeDriveHardwareError,
    TapeDriveUnsupportedMedia,
    TapeDriveScsiConnectionError,
    TapeDriveTimetoClean,
    TapeDriveCleanDriveNow,
    TapeDriveMediaLifeExpired,
    TapeDriveSnappedTape
} TAPE_DRIVE_PROBLEM_TYPE;
typedef GUID UOW, *PUOW;
typedef GUID CRM_PROTOCOL_ID, *PCRM_PROTOCOL_ID;
typedef ULONG NOTIFICATION_MASK;
typedef struct _TRANSACTION_NOTIFICATION
{
    PVOID TransactionKey;
    ULONG TransactionNotification;
    LARGE_INTEGER TmVirtualClock;
    ULONG ArgumentLength;
} TRANSACTION_NOTIFICATION, *PTRANSACTION_NOTIFICATION;

typedef struct _TRANSACTION_NOTIFICATION_RECOVERY_ARGUMENT
{
    GUID EnlistmentId;
    UOW uow;
} TRANSACTION_NOTIFICATION_RECOVERY_ARGUMENT, *PTRANSACTION_NOTIFICATION_RECOVERY_ARGUMENT;

typedef struct _TRANSACTION_NOTIFICATION_TM_ONLINE_ARGUMENT
{
    GUID TmIdentity;
    ULONG Flags;
} TRANSACTION_NOTIFICATION_TM_ONLINE_ARGUMENT, *PTRANSACTION_NOTIFICATION_TM_ONLINE_ARGUMENT;

typedef ULONG SAVEPOINT_ID, *PSAVEPOINT_ID;

typedef struct _TRANSACTION_NOTIFICATION_SAVEPOINT_ARGUMENT
{
    SAVEPOINT_ID SavepointId;
} TRANSACTION_NOTIFICATION_SAVEPOINT_ARGUMENT, *PTRANSACTION_NOTIFICATION_SAVEPOINT_ARGUMENT;

typedef struct _TRANSACTION_NOTIFICATION_PROPAGATE_ARGUMENT
{
    ULONG PropagationCookie;
    GUID uow;
    GUID TmIdentity;
    ULONG BufferLength;

} TRANSACTION_NOTIFICATION_PROPAGATE_ARGUMENT, *PTRANSACTION_NOTIFICATION_PROPAGATE_ARGUMENT;

typedef struct _TRANSACTION_NOTIFICATION_MARSHAL_ARGUMENT
{
    ULONG MarshalCookie;
    GUID uow;
} TRANSACTION_NOTIFICATION_MARSHAL_ARGUMENT, *PTRANSACTION_NOTIFICATION_MARSHAL_ARGUMENT;

typedef TRANSACTION_NOTIFICATION_PROPAGATE_ARGUMENT TRANSACTION_NOTIFICATION_PROMOTE_ARGUMENT, *PTRANSACTION_NOTIFICATION_PROMOTE_ARGUMENT;

typedef struct _KCRM_MARSHAL_HEADER
{
    ULONG VersionMajor;
    ULONG VersionMinor;
    ULONG NumProtocols;
    ULONG Unused;
} KCRM_MARSHAL_HEADER, *PKCRM_MARSHAL_HEADER, *PRKCRM_MARSHAL_HEADER;

typedef struct _KCRM_TRANSACTION_BLOB
{
    UOW uow;
    GUID TmIdentity;
    ULONG IsolationLevel;
    ULONG IsolationFlags;
    ULONG Timeout;
    WCHAR Description[64];
} KCRM_TRANSACTION_BLOB, *PKCRM_TRANSACTION_BLOB, *PRKCRM_TRANSACTION_BLOB;

typedef struct _KCRM_PROTOCOL_BLOB
{
    CRM_PROTOCOL_ID ProtocolId;
    ULONG StaticInfoLength;
    ULONG TransactionIdInfoLength;
    ULONG Unused1;
    ULONG Unused2;
} KCRM_PROTOCOL_BLOB, *PKCRM_PROTOCOL_BLOB, *PRKCRM_PROTOCOL_BLOB;
typedef enum _TRANSACTION_OUTCOME
{
    TransactionOutcomeUndetermined = 1,
    TransactionOutcomeCommitted,
    TransactionOutcomeAborted,
} TRANSACTION_OUTCOME;

typedef enum _TRANSACTION_STATE
{
    TransactionStateNormal = 1,
    TransactionStateIndoubt,
    TransactionStateCommittedNotify,
} TRANSACTION_STATE;

typedef struct _TRANSACTION_BASIC_INFORMATION
{
    GUID TransactionId;
    DWORD State;
    DWORD Outcome;
} TRANSACTION_BASIC_INFORMATION, *PTRANSACTION_BASIC_INFORMATION;

typedef struct _TRANSACTIONMANAGER_BASIC_INFORMATION
{
    GUID TmIdentity;
    LARGE_INTEGER VirtualClock;
} TRANSACTIONMANAGER_BASIC_INFORMATION, *PTRANSACTIONMANAGER_BASIC_INFORMATION;

typedef struct _TRANSACTIONMANAGER_LOG_INFORMATION
{
    GUID LogIdentity;
} TRANSACTIONMANAGER_LOG_INFORMATION, *PTRANSACTIONMANAGER_LOG_INFORMATION;

typedef struct _TRANSACTIONMANAGER_LOGPATH_INFORMATION
{
    DWORD LogPathLength;
    WCHAR LogPath[1];

} TRANSACTIONMANAGER_LOGPATH_INFORMATION, *PTRANSACTIONMANAGER_LOGPATH_INFORMATION;

typedef struct _TRANSACTIONMANAGER_RECOVERY_INFORMATION
{
    ULONGLONG LastRecoveredLsn;
} TRANSACTIONMANAGER_RECOVERY_INFORMATION, *PTRANSACTIONMANAGER_RECOVERY_INFORMATION;

typedef struct _TRANSACTIONMANAGER_OLDEST_INFORMATION
{
    GUID OldestTransactionGuid;
} TRANSACTIONMANAGER_OLDEST_INFORMATION, *PTRANSACTIONMANAGER_OLDEST_INFORMATION;

typedef struct _TRANSACTION_PROPERTIES_INFORMATION
{
    DWORD IsolationLevel;
    DWORD IsolationFlags;
    LARGE_INTEGER Timeout;
    DWORD Outcome;
    DWORD DescriptionLength;
    WCHAR Description[1];

} TRANSACTION_PROPERTIES_INFORMATION, *PTRANSACTION_PROPERTIES_INFORMATION;

typedef struct _TRANSACTION_BIND_INFORMATION
{
    HANDLE TmHandle;
} TRANSACTION_BIND_INFORMATION, *PTRANSACTION_BIND_INFORMATION;

typedef struct _TRANSACTION_ENLISTMENT_PAIR
{
    GUID EnlistmentId;
    GUID ResourceManagerId;
} TRANSACTION_ENLISTMENT_PAIR, *PTRANSACTION_ENLISTMENT_PAIR;

typedef struct _TRANSACTION_ENLISTMENTS_INFORMATION
{
    DWORD NumberOfEnlistments;
    TRANSACTION_ENLISTMENT_PAIR EnlistmentPair[1];
} TRANSACTION_ENLISTMENTS_INFORMATION, *PTRANSACTION_ENLISTMENTS_INFORMATION;

typedef struct _TRANSACTION_SUPERIOR_ENLISTMENT_INFORMATION
{
    TRANSACTION_ENLISTMENT_PAIR SuperiorEnlistmentPair;
} TRANSACTION_SUPERIOR_ENLISTMENT_INFORMATION, *PTRANSACTION_SUPERIOR_ENLISTMENT_INFORMATION;

typedef struct _RESOURCEMANAGER_BASIC_INFORMATION
{
    GUID ResourceManagerId;
    DWORD DescriptionLength;
    WCHAR Description[1];
} RESOURCEMANAGER_BASIC_INFORMATION, *PRESOURCEMANAGER_BASIC_INFORMATION;

typedef struct _RESOURCEMANAGER_COMPLETION_INFORMATION
{
    HANDLE IoCompletionPortHandle;
    ULONG_PTR CompletionKey;
} RESOURCEMANAGER_COMPLETION_INFORMATION, *PRESOURCEMANAGER_COMPLETION_INFORMATION;

typedef enum _TRANSACTION_INFORMATION_CLASS
{
    TransactionBasicInformation,
    TransactionPropertiesInformation,
    TransactionEnlistmentInformation,
    TransactionSuperiorEnlistmentInformation,
    TransactionBindInformation,
    TransactionDTCPrivateInformation,

} TRANSACTION_INFORMATION_CLASS;

typedef enum _TRANSACTIONMANAGER_INFORMATION_CLASS
{
    TransactionManagerBasicInformation,
    TransactionManagerLogInformation,
    TransactionManagerLogPathInformation,
    TransactionManagerRecoveryInformation = 4,
    TransactionManagerOnlineProbeInformation = 3,
    TransactionManagerOldestTransactionInformation = 5

} TRANSACTIONMANAGER_INFORMATION_CLASS;

typedef enum _RESOURCEMANAGER_INFORMATION_CLASS
{
    ResourceManagerBasicInformation,
    ResourceManagerCompletionInformation,
} RESOURCEMANAGER_INFORMATION_CLASS;

typedef struct _ENLISTMENT_BASIC_INFORMATION
{
    GUID EnlistmentId;
    GUID TransactionId;
    GUID ResourceManagerId;
} ENLISTMENT_BASIC_INFORMATION, *PENLISTMENT_BASIC_INFORMATION;

typedef struct _ENLISTMENT_CRM_INFORMATION
{
    GUID CrmTransactionManagerId;
    GUID CrmResourceManagerId;
    GUID CrmEnlistmentId;
} ENLISTMENT_CRM_INFORMATION, *PENLISTMENT_CRM_INFORMATION;

typedef enum _ENLISTMENT_INFORMATION_CLASS
{
    EnlistmentBasicInformation,
    EnlistmentRecoveryInformation,
    EnlistmentCrmInformation
} ENLISTMENT_INFORMATION_CLASS;

typedef struct _TRANSACTION_LIST_ENTRY
{
    UOW uow;
} TRANSACTION_LIST_ENTRY, *PTRANSACTION_LIST_ENTRY;

typedef struct _TRANSACTION_LIST_INFORMATION
{
    DWORD NumberOfTransactions;
    TRANSACTION_LIST_ENTRY TransactionInformation[1];
} TRANSACTION_LIST_INFORMATION, *PTRANSACTION_LIST_INFORMATION;

typedef enum _KTMOBJECT_TYPE
{
    KTMOBJECT_TRANSACTION,
    KTMOBJECT_TRANSACTION_MANAGER,
    KTMOBJECT_RESOURCE_MANAGER,
    KTMOBJECT_ENLISTMENT,
    KTMOBJECT_INVALID

} KTMOBJECT_TYPE,
    *PKTMOBJECT_TYPE;

typedef struct _KTMOBJECT_CURSOR
{
    GUID LastQuery;
    DWORD ObjectIdCount;
    GUID ObjectIds[1];

} KTMOBJECT_CURSOR, *PKTMOBJECT_CURSOR;
typedef DWORD TP_VERSION, *PTP_VERSION;

typedef struct _TP_CALLBACK_INSTANCE TP_CALLBACK_INSTANCE, *PTP_CALLBACK_INSTANCE;

typedef void (*PTP_SIMPLE_CALLBACK)(
    PTP_CALLBACK_INSTANCE Instance,
    PVOID Context);

typedef struct _TP_POOL TP_POOL, *PTP_POOL;

typedef enum _TP_CALLBACK_PRIORITY
{
    TP_CALLBACK_PRIORITY_HIGH,
    TP_CALLBACK_PRIORITY_NORMAL,
    TP_CALLBACK_PRIORITY_LOW,
    TP_CALLBACK_PRIORITY_INVALID,
    TP_CALLBACK_PRIORITY_COUNT = TP_CALLBACK_PRIORITY_INVALID
} TP_CALLBACK_PRIORITY;

typedef struct _TP_POOL_STACK_INFORMATION
{
    SIZE_T StackReserve;
    SIZE_T StackCommit;
} TP_POOL_STACK_INFORMATION, *PTP_POOL_STACK_INFORMATION;

typedef struct _TP_CLEANUP_GROUP TP_CLEANUP_GROUP, *PTP_CLEANUP_GROUP;

typedef void (*PTP_CLEANUP_GROUP_CANCEL_CALLBACK)(
    PVOID ObjectContext,
    PVOID CleanupContext);

typedef struct _TP_CALLBACK_ENVIRON_V3
{
    TP_VERSION Version;
    PTP_POOL Pool;
    PTP_CLEANUP_GROUP CleanupGroup;
    PTP_CLEANUP_GROUP_CANCEL_CALLBACK CleanupGroupCancelCallback;
    PVOID RaceDll;
    struct _ACTIVATION_CONTEXT *ActivationContext;
    PTP_SIMPLE_CALLBACK FinalizationCallback;
    union
    {
        DWORD Flags;
        struct
        {
            DWORD LongFunction : 1;
            DWORD Persistent : 1;
            DWORD Private : 30;
        } s;
    } u;
    TP_CALLBACK_PRIORITY CallbackPriority;
    DWORD Size;
} TP_CALLBACK_ENVIRON_V3;

typedef TP_CALLBACK_ENVIRON_V3 TP_CALLBACK_ENVIRON, *PTP_CALLBACK_ENVIRON;

typedef struct _TP_WORK TP_WORK, *PTP_WORK;

typedef void (*PTP_WORK_CALLBACK)(
    PTP_CALLBACK_INSTANCE Instance,
    PVOID Context,
    PTP_WORK Work);

typedef struct _TP_TIMER TP_TIMER, *PTP_TIMER;

typedef void (*PTP_TIMER_CALLBACK)(
    PTP_CALLBACK_INSTANCE Instance,
    PVOID Context,
    PTP_TIMER Timer);

typedef DWORD TP_WAIT_RESULT;

typedef struct _TP_WAIT TP_WAIT, *PTP_WAIT;

typedef void (*PTP_WAIT_CALLBACK)(
    PTP_CALLBACK_INSTANCE Instance,
    PVOID Context,
    PTP_WAIT Wait,
    TP_WAIT_RESULT WaitResult);

typedef struct _TP_IO TP_IO, *PTP_IO;

typedef UINT_PTR WPARAM;
typedef LONG_PTR LPARAM;
typedef LONG_PTR LRESULT;
typedef HANDLE *SPHANDLE;
typedef HANDLE *LPHANDLE;
typedef HANDLE HGLOBAL;
typedef HANDLE HLOCAL;
typedef HANDLE GLOBALHANDLE;
typedef HANDLE LOCALHANDLE;
typedef int (*FARPROC)();
typedef int (*NEARPROC)();
typedef int (*PROC)();
typedef WORD ATOM;

struct HKEY__
{
    int unused;
};
typedef struct HKEY__ *HKEY;
typedef HKEY *PHKEY;
struct HMETAFILE__
{
    int unused;
};
typedef struct HMETAFILE__ *HMETAFILE;
struct HINSTANCE__
{
    int unused;
};
typedef struct HINSTANCE__ *HINSTANCE;
typedef HINSTANCE HMODULE;
struct HRGN__
{
    int unused;
};
typedef struct HRGN__ *HRGN;
struct HRSRC__
{
    int unused;
};
typedef struct HRSRC__ *HRSRC;
struct HSPRITE__
{
    int unused;
};
typedef struct HSPRITE__ *HSPRITE;
struct HLSURF__
{
    int unused;
};
typedef struct HLSURF__ *HLSURF;
struct HSTR__
{
    int unused;
};
typedef struct HSTR__ *HSTR;
struct HTASK__
{
    int unused;
};
typedef struct HTASK__ *HTASK;
struct HWINSTA__
{
    int unused;
};
typedef struct HWINSTA__ *HWINSTA;
struct HKL__
{
    int unused;
};
typedef struct HKL__ *HKL;

typedef int HFILE;
typedef struct _FILETIME
{
    DWORD dwLowDateTime;
    DWORD dwHighDateTime;
} FILETIME, *PFILETIME, *LPFILETIME;

typedef struct _SECURITY_ATTRIBUTES
{
    DWORD nLength;
    LPVOID lpSecurityDescriptor;
    BOOL bInheritHandle;
} SECURITY_ATTRIBUTES, *PSECURITY_ATTRIBUTES, *LPSECURITY_ATTRIBUTES;

typedef struct _OVERLAPPED
{
    ULONG_PTR Internal;
    ULONG_PTR InternalHigh;
    union
    {
        struct
        {
            DWORD Offset;
            DWORD OffsetHigh;
        } s;
        PVOID Pointer;
    } u;
    HANDLE hEvent;
} OVERLAPPED, *LPOVERLAPPED;

typedef struct _OVERLAPPED_ENTRY
{
    ULONG_PTR lpCompletionKey;
    LPOVERLAPPED lpOverlapped;
    ULONG_PTR Internal;
    DWORD dwNumberOfBytesTransferred;
} OVERLAPPED_ENTRY, *LPOVERLAPPED_ENTRY;
typedef struct _SYSTEMTIME
{
    WORD wYear;
    WORD wMonth;
    WORD wDayOfWeek;
    WORD wDay;
    WORD wHour;
    WORD wMinute;
    WORD wSecond;
    WORD wMilliseconds;
} SYSTEMTIME, *PSYSTEMTIME, *LPSYSTEMTIME;

typedef struct _WIN32_FIND_DATAA
{
    DWORD dwFileAttributes;
    FILETIME ftCreationTime;
    FILETIME ftLastAccessTime;
    FILETIME ftLastWriteTime;
    DWORD nFileSizeHigh;
    DWORD nFileSizeLow;
    DWORD dwReserved0;
    DWORD dwReserved1;
    CHAR cFileName[260];
    CHAR cAlternateFileName[14];
} WIN32_FIND_DATAA, *PWIN32_FIND_DATAA, *LPWIN32_FIND_DATAA;
typedef struct _WIN32_FIND_DATAW
{
    DWORD dwFileAttributes;
    FILETIME ftCreationTime;
    FILETIME ftLastAccessTime;
    FILETIME ftLastWriteTime;
    DWORD nFileSizeHigh;
    DWORD nFileSizeLow;
    DWORD dwReserved0;
    DWORD dwReserved1;
    WCHAR cFileName[260];
    WCHAR cAlternateFileName[14];
} WIN32_FIND_DATAW, *PWIN32_FIND_DATAW, *LPWIN32_FIND_DATAW;

typedef WIN32_FIND_DATAA WIN32_FIND_DATA;
typedef PWIN32_FIND_DATAA PWIN32_FIND_DATA;
typedef LPWIN32_FIND_DATAA LPWIN32_FIND_DATA;

typedef enum _FINDEX_INFO_LEVELS
{
    FindExInfoStandard,
    FindExInfoBasic,
    FindExInfoMaxInfoLevel
} FINDEX_INFO_LEVELS;

typedef enum _FINDEX_SEARCH_OPS
{
    FindExSearchNameMatch,
    FindExSearchLimitToDirectories,
    FindExSearchLimitToDevices,
    FindExSearchMaxSearchOp
} FINDEX_SEARCH_OPS;

typedef enum _READ_DIRECTORY_NOTIFY_INFORMATION_CLASS
{
    ReadDirectoryNotifyInformation = 1,
    ReadDirectoryNotifyExtendedInformation
} READ_DIRECTORY_NOTIFY_INFORMATION_CLASS,
    *PREAD_DIRECTORY_NOTIFY_INFORMATION_CLASS;

typedef enum _GET_FILEEX_INFO_LEVELS
{
    GetFileExInfoStandard,
    GetFileExMaxInfoLevel
} GET_FILEEX_INFO_LEVELS;

typedef enum _FILE_INFO_BY_HANDLE_CLASS
{
    FileBasicInfo,
    FileStandardInfo,
    FileNameInfo,
    FileRenameInfo,
    FileDispositionInfo,
    FileAllocationInfo,
    FileEndOfFileInfo,
    FileStreamInfo,
    FileCompressionInfo,
    FileAttributeTagInfo,
    FileIdBothDirectoryInfo,
    FileIdBothDirectoryRestartInfo,
    FileIoPriorityHintInfo,
    FileRemoteProtocolInfo,
    FileFullDirectoryInfo,
    FileFullDirectoryRestartInfo,
    FileStorageInfo,
    FileAlignmentInfo,
    FileIdInfo,
    FileIdExtdDirectoryInfo,
    FileIdExtdDirectoryRestartInfo,
    FileDispositionInfoEx,
    FileRenameInfoEx,
    FileCaseSensitiveInfo,
    FileNormalizedNameInfo,
    MaximumFileInfoByHandleClass
} FILE_INFO_BY_HANDLE_CLASS,
    *PFILE_INFO_BY_HANDLE_CLASS;

typedef RTL_CRITICAL_SECTION CRITICAL_SECTION;
typedef PRTL_CRITICAL_SECTION PCRITICAL_SECTION;
typedef PRTL_CRITICAL_SECTION LPCRITICAL_SECTION;

typedef RTL_CRITICAL_SECTION_DEBUG CRITICAL_SECTION_DEBUG;
typedef PRTL_CRITICAL_SECTION_DEBUG PCRITICAL_SECTION_DEBUG;
typedef PRTL_CRITICAL_SECTION_DEBUG LPCRITICAL_SECTION_DEBUG;

typedef void (*LPOVERLAPPED_COMPLETION_ROUTINE)(
    DWORD dwErrorCode,
    DWORD dwNumberOfBytesTransfered,
    LPOVERLAPPED lpOverlapped);

typedef struct _PROCESS_HEAP_ENTRY
{
    PVOID lpData;
    DWORD cbData;
    BYTE cbOverhead;
    BYTE iRegionIndex;
    WORD wFlags;
    union
    {
        struct
        {
            HANDLE hMem;
            DWORD dwReserved[3];
        } Block;
        struct
        {
            DWORD dwCommittedSize;
            DWORD dwUnCommittedSize;
            LPVOID lpFirstBlock;
            LPVOID lpLastBlock;
        } Region;
    } u;
} PROCESS_HEAP_ENTRY, *LPPROCESS_HEAP_ENTRY, *PPROCESS_HEAP_ENTRY;

typedef struct _REASON_CONTEXT
{
    ULONG Version;
    DWORD Flags;
    union
    {
        struct
        {
            HMODULE LocalizedReasonModule;
            ULONG LocalizedReasonId;
            ULONG ReasonStringCount;
            LPWSTR *ReasonStrings;
        } Detailed;
        LPWSTR SimpleReasonString;
    } Reason;
} REASON_CONTEXT, *PREASON_CONTEXT;
typedef DWORD (*PTHREAD_START_ROUTINE)(
    LPVOID lpThreadParameter);
typedef PTHREAD_START_ROUTINE LPTHREAD_START_ROUTINE;

typedef LPVOID (*PENCLAVE_ROUTINE)(
    LPVOID lpThreadParameter);
typedef PENCLAVE_ROUTINE LPENCLAVE_ROUTINE;

typedef struct _EXCEPTION_DEBUG_INFO
{
    EXCEPTION_RECORD ExceptionRecord;
    DWORD dwFirstChance;
} EXCEPTION_DEBUG_INFO, *LPEXCEPTION_DEBUG_INFO;

typedef struct _CREATE_THREAD_DEBUG_INFO
{
    HANDLE hThread;
    LPVOID lpThreadLocalBase;
    LPTHREAD_START_ROUTINE lpStartAddress;
} CREATE_THREAD_DEBUG_INFO, *LPCREATE_THREAD_DEBUG_INFO;

typedef struct _CREATE_PROCESS_DEBUG_INFO
{
    HANDLE hFile;
    HANDLE hProcess;
    HANDLE hThread;
    LPVOID lpBaseOfImage;
    DWORD dwDebugInfoFileOffset;
    DWORD nDebugInfoSize;
    LPVOID lpThreadLocalBase;
    LPTHREAD_START_ROUTINE lpStartAddress;
    LPVOID lpImageName;
    WORD fUnicode;
} CREATE_PROCESS_DEBUG_INFO, *LPCREATE_PROCESS_DEBUG_INFO;

typedef struct _EXIT_THREAD_DEBUG_INFO
{
    DWORD dwExitCode;
} EXIT_THREAD_DEBUG_INFO, *LPEXIT_THREAD_DEBUG_INFO;

typedef struct _EXIT_PROCESS_DEBUG_INFO
{
    DWORD dwExitCode;
} EXIT_PROCESS_DEBUG_INFO, *LPEXIT_PROCESS_DEBUG_INFO;

typedef struct _LOAD_DLL_DEBUG_INFO
{
    HANDLE hFile;
    LPVOID lpBaseOfDll;
    DWORD dwDebugInfoFileOffset;
    DWORD nDebugInfoSize;
    LPVOID lpImageName;
    WORD fUnicode;
} LOAD_DLL_DEBUG_INFO, *LPLOAD_DLL_DEBUG_INFO;

typedef struct _UNLOAD_DLL_DEBUG_INFO
{
    LPVOID lpBaseOfDll;
} UNLOAD_DLL_DEBUG_INFO, *LPUNLOAD_DLL_DEBUG_INFO;

typedef struct _OUTPUT_DEBUG_STRING_INFO
{
    LPSTR lpDebugStringData;
    WORD fUnicode;
    WORD nDebugStringLength;
} OUTPUT_DEBUG_STRING_INFO, *LPOUTPUT_DEBUG_STRING_INFO;

typedef struct _RIP_INFO
{
    DWORD dwError;
    DWORD dwType;
} RIP_INFO, *LPRIP_INFO;

typedef struct _DEBUG_EVENT
{
    DWORD dwDebugEventCode;
    DWORD dwProcessId;
    DWORD dwThreadId;
    union
    {
        EXCEPTION_DEBUG_INFO Exception;
        CREATE_THREAD_DEBUG_INFO CreateThread;
        CREATE_PROCESS_DEBUG_INFO CreateProcessInfo;
        EXIT_THREAD_DEBUG_INFO ExitThread;
        EXIT_PROCESS_DEBUG_INFO ExitProcess;
        LOAD_DLL_DEBUG_INFO LoadDll;
        UNLOAD_DLL_DEBUG_INFO UnloadDll;
        OUTPUT_DEBUG_STRING_INFO DebugString;
        RIP_INFO RipInfo;
    } u;
} DEBUG_EVENT, *LPDEBUG_EVENT;

typedef PCONTEXT LPCONTEXT;

typedef struct _PROCESS_INFORMATION
{
    HANDLE hProcess;
    HANDLE hThread;
    DWORD dwProcessId;
    DWORD dwThreadId;
} PROCESS_INFORMATION, *PPROCESS_INFORMATION, *LPPROCESS_INFORMATION;

typedef struct _STARTUPINFOA
{
    DWORD cb;
    LPSTR lpReserved;
    LPSTR lpDesktop;
    LPSTR lpTitle;
    DWORD dwX;
    DWORD dwY;
    DWORD dwXSize;
    DWORD dwYSize;
    DWORD dwXCountChars;
    DWORD dwYCountChars;
    DWORD dwFillAttribute;
    DWORD dwFlags;
    WORD wShowWindow;
    WORD cbReserved2;
    LPBYTE lpReserved2;
    HANDLE hStdInput;
    HANDLE hStdOutput;
    HANDLE hStdError;
} STARTUPINFOA, *LPSTARTUPINFOA;
typedef struct _STARTUPINFOW
{
    DWORD cb;
    LPWSTR lpReserved;
    LPWSTR lpDesktop;
    LPWSTR lpTitle;
    DWORD dwX;
    DWORD dwY;
    DWORD dwXSize;
    DWORD dwYSize;
    DWORD dwXCountChars;
    DWORD dwYCountChars;
    DWORD dwFillAttribute;
    DWORD dwFlags;
    WORD wShowWindow;
    WORD cbReserved2;
    LPBYTE lpReserved2;
    HANDLE hStdInput;
    HANDLE hStdOutput;
    HANDLE hStdError;
} STARTUPINFOW, *LPSTARTUPINFOW;

typedef STARTUPINFOA STARTUPINFO;
typedef LPSTARTUPINFOA LPSTARTUPINFO;

DWORD QueueUserAPC(
    PAPCFUNC pfnAPC,
    HANDLE hThread,
    ULONG_PTR dwData);

BOOL GetProcessTimes(
    HANDLE hProcess,
    LPFILETIME lpCreationTime,
    LPFILETIME lpExitTime,
    LPFILETIME lpKernelTime,
    LPFILETIME lpUserTime);

HANDLE GetCurrentProcess(
    void);

DWORD GetCurrentProcessId(
    void);

void ExitProcess(
    UINT uExitCode);

BOOL TerminateProcess(
    HANDLE hProcess,
    UINT uExitCode);

BOOL GetExitCodeProcess(
    HANDLE hProcess,
    LPDWORD lpExitCode);

BOOL SwitchToThread(
    void);

HANDLE CreateThread(
    LPSECURITY_ATTRIBUTES lpThreadAttributes,
    SIZE_T dwStackSize,
    LPTHREAD_START_ROUTINE lpStartAddress,
    LPVOID lpParameter,
    DWORD dwCreationFlags,
    LPDWORD lpThreadId);

HANDLE CreateRemoteThread(
    HANDLE hProcess,
    LPSECURITY_ATTRIBUTES lpThreadAttributes,
    SIZE_T dwStackSize,
    LPTHREAD_START_ROUTINE lpStartAddress,
    LPVOID lpParameter,
    DWORD dwCreationFlags,
    LPDWORD lpThreadId);

HANDLE GetCurrentThread(
    void);

DWORD GetCurrentThreadId(
    void);

HANDLE OpenThread(
    DWORD dwDesiredAccess,
    BOOL bInheritHandle,
    DWORD dwThreadId);

BOOL SetThreadPriority(
    HANDLE hThread,
    int nPriority);

BOOL SetThreadPriorityBoost(
    HANDLE hThread,
    BOOL bDisablePriorityBoost);

BOOL GetThreadPriorityBoost(
    HANDLE hThread,
    PBOOL pDisablePriorityBoost);

int GetThreadPriority(
    HANDLE hThread);

void ExitThread(
    DWORD dwExitCode);

BOOL TerminateThread(
    HANDLE hThread,
    DWORD dwExitCode);

BOOL GetExitCodeThread(
    HANDLE hThread,
    LPDWORD lpExitCode);

DWORD SuspendThread(
    HANDLE hThread);

DWORD ResumeThread(
    HANDLE hThread);

DWORD TlsAlloc(
    void);

LPVOID TlsGetValue(
    DWORD dwTlsIndex);

BOOL TlsSetValue(
    DWORD dwTlsIndex,
    LPVOID lpTlsValue);

BOOL TlsFree(
    DWORD dwTlsIndex);

BOOL CreateProcessA(
    LPCSTR lpApplicationName,
    LPSTR lpCommandLine,
    LPSECURITY_ATTRIBUTES lpProcessAttributes,
    LPSECURITY_ATTRIBUTES lpThreadAttributes,
    BOOL bInheritHandles,
    DWORD dwCreationFlags,
    LPVOID lpEnvironment,
    LPCSTR lpCurrentDirectory,
    LPSTARTUPINFOA lpStartupInfo,
    LPPROCESS_INFORMATION lpProcessInformation);

BOOL CreateProcessW(
    LPCWSTR lpApplicationName,
    LPWSTR lpCommandLine,
    LPSECURITY_ATTRIBUTES lpProcessAttributes,
    LPSECURITY_ATTRIBUTES lpThreadAttributes,
    BOOL bInheritHandles,
    DWORD dwCreationFlags,
    LPVOID lpEnvironment,
    LPCWSTR lpCurrentDirectory,
    LPSTARTUPINFOW lpStartupInfo,
    LPPROCESS_INFORMATION lpProcessInformation);

BOOL SetProcessShutdownParameters(
    DWORD dwLevel,
    DWORD dwFlags);

DWORD GetProcessVersion(
    DWORD ProcessId);

void GetStartupInfoW(
    LPSTARTUPINFOW lpStartupInfo);

BOOL CreateProcessAsUserW(
    HANDLE hToken,
    LPCWSTR lpApplicationName,
    LPWSTR lpCommandLine,
    LPSECURITY_ATTRIBUTES lpProcessAttributes,
    LPSECURITY_ATTRIBUTES lpThreadAttributes,
    BOOL bInheritHandles,
    DWORD dwCreationFlags,
    LPVOID lpEnvironment,
    LPCWSTR lpCurrentDirectory,
    LPSTARTUPINFOW lpStartupInfo,
    LPPROCESS_INFORMATION lpProcessInformation);

BOOL SetThreadToken(
    PHANDLE Thread,
    HANDLE Token);

BOOL OpenProcessToken(
    HANDLE ProcessHandle,
    DWORD DesiredAccess,
    PHANDLE TokenHandle);

BOOL OpenThreadToken(
    HANDLE ThreadHandle,
    DWORD DesiredAccess,
    BOOL OpenAsSelf,
    PHANDLE TokenHandle);

BOOL SetPriorityClass(
    HANDLE hProcess,
    DWORD dwPriorityClass);

DWORD GetPriorityClass(
    HANDLE hProcess);

BOOL SetThreadStackGuarantee(
    PULONG StackSizeInBytes);

BOOL ProcessIdToSessionId(
    DWORD dwProcessId,
    DWORD *pSessionId);

typedef struct _PROC_THREAD_ATTRIBUTE_LIST *PPROC_THREAD_ATTRIBUTE_LIST, *LPPROC_THREAD_ATTRIBUTE_LIST;

DWORD GetProcessId(
    HANDLE Process);

DWORD GetThreadId(
    HANDLE Thread);

void FlushProcessWriteBuffers(
    void);

DWORD GetProcessIdOfThread(
    HANDLE Thread);

BOOL InitializeProcThreadAttributeList(
    LPPROC_THREAD_ATTRIBUTE_LIST lpAttributeList,
    DWORD dwAttributeCount,
    DWORD dwFlags,
    PSIZE_T lpSize);

void DeleteProcThreadAttributeList(
    LPPROC_THREAD_ATTRIBUTE_LIST lpAttributeList);

BOOL UpdateProcThreadAttribute(
    LPPROC_THREAD_ATTRIBUTE_LIST lpAttributeList,
    DWORD dwFlags,
    DWORD_PTR Attribute,
    PVOID lpValue,
    SIZE_T cbSize,
    PVOID lpPreviousValue,
    PSIZE_T lpReturnSize);

BOOL SetProcessDynamicEHContinuationTargets(
    HANDLE Process,
    USHORT NumberOfTargets,
    PPROCESS_DYNAMIC_EH_CONTINUATION_TARGET Targets);

BOOL SetProcessDynamicEnforcedCetCompatibleRanges(
    HANDLE Process,
    USHORT NumberOfRanges,
    PPROCESS_DYNAMIC_ENFORCED_ADDRESS_RANGE Ranges);

BOOL SetProcessAffinityUpdateMode(
    HANDLE hProcess,
    DWORD dwFlags);

BOOL QueryProcessAffinityUpdateMode(
    HANDLE hProcess,
    LPDWORD lpdwFlags);

HANDLE CreateRemoteThreadEx(
    HANDLE hProcess,
    LPSECURITY_ATTRIBUTES lpThreadAttributes,
    SIZE_T dwStackSize,
    LPTHREAD_START_ROUTINE lpStartAddress,
    LPVOID lpParameter,
    DWORD dwCreationFlags,
    LPPROC_THREAD_ATTRIBUTE_LIST lpAttributeList,
    LPDWORD lpThreadId);

void GetCurrentThreadStackLimits(
    PULONG_PTR LowLimit,
    PULONG_PTR HighLimit);

BOOL GetThreadContext(
    HANDLE hThread,
    LPCONTEXT lpContext);

BOOL GetProcessMitigationPolicy(
    HANDLE hProcess,
    PROCESS_MITIGATION_POLICY MitigationPolicy,
    PVOID lpBuffer,
    SIZE_T dwLength);

BOOL SetThreadContext(
    HANDLE hThread,
    const CONTEXT *lpContext);

BOOL SetProcessMitigationPolicy(
    PROCESS_MITIGATION_POLICY MitigationPolicy,
    PVOID lpBuffer,
    SIZE_T dwLength);

BOOL FlushInstructionCache(
    HANDLE hProcess,
    LPCVOID lpBaseAddress,
    SIZE_T dwSize);

BOOL GetThreadTimes(
    HANDLE hThread,
    LPFILETIME lpCreationTime,
    LPFILETIME lpExitTime,
    LPFILETIME lpKernelTime,
    LPFILETIME lpUserTime);

HANDLE OpenProcess(
    DWORD dwDesiredAccess,
    BOOL bInheritHandle,
    DWORD dwProcessId);

BOOL IsProcessorFeaturePresent(
    DWORD ProcessorFeature);

BOOL GetProcessHandleCount(
    HANDLE hProcess,
    PDWORD pdwHandleCount);

DWORD GetCurrentProcessorNumber(
    void);

BOOL SetThreadIdealProcessorEx(
    HANDLE hThread,
    PPROCESSOR_NUMBER lpIdealProcessor,
    PPROCESSOR_NUMBER lpPreviousIdealProcessor);

BOOL GetThreadIdealProcessorEx(
    HANDLE hThread,
    PPROCESSOR_NUMBER lpIdealProcessor);

void GetCurrentProcessorNumberEx(
    PPROCESSOR_NUMBER ProcNumber);

BOOL GetProcessPriorityBoost(
    HANDLE hProcess,
    PBOOL pDisablePriorityBoost);

BOOL SetProcessPriorityBoost(
    HANDLE hProcess,
    BOOL bDisablePriorityBoost);

BOOL GetThreadIOPendingFlag(
    HANDLE hThread,
    PBOOL lpIOIsPending);

BOOL GetSystemTimes(
    PFILETIME lpIdleTime,
    PFILETIME lpKernelTime,
    PFILETIME lpUserTime);

typedef enum _THREAD_INFORMATION_CLASS
{
    ThreadMemoryPriority,
    ThreadAbsoluteCpuPriority,
    ThreadDynamicCodePolicy,
    ThreadPowerThrottling,
    ThreadInformationClassMax
} THREAD_INFORMATION_CLASS;

typedef struct _MEMORY_PRIORITY_INFORMATION
{
    ULONG MemoryPriority;
} MEMORY_PRIORITY_INFORMATION, *PMEMORY_PRIORITY_INFORMATION;

BOOL GetThreadInformation(
    HANDLE hThread,
    THREAD_INFORMATION_CLASS ThreadInformationClass,
    LPVOID ThreadInformation,
    DWORD ThreadInformationSize);

BOOL SetThreadInformation(
    HANDLE hThread,
    THREAD_INFORMATION_CLASS ThreadInformationClass,
    LPVOID ThreadInformation,
    DWORD ThreadInformationSize);
typedef struct _THREAD_POWER_THROTTLING_STATE
{
    ULONG Version;
    ULONG ControlMask;
    ULONG StateMask;
} THREAD_POWER_THROTTLING_STATE;

BOOL IsProcessCritical(
    HANDLE hProcess,
    PBOOL Critical);

BOOL SetProtectedPolicy(
    LPCGUID PolicyGuid,
    ULONG_PTR PolicyValue,
    PULONG_PTR OldPolicyValue);

BOOL QueryProtectedPolicy(
    LPCGUID PolicyGuid,
    PULONG_PTR PolicyValue);

DWORD SetThreadIdealProcessor(
    HANDLE hThread,
    DWORD dwIdealProcessor);

typedef enum _PROCESS_INFORMATION_CLASS
{
    ProcessMemoryPriority,
    ProcessMemoryExhaustionInfo,
    ProcessAppMemoryInfo,
    ProcessInPrivateInfo,
    ProcessPowerThrottling,
    ProcessReservedValue1,
    ProcessTelemetryCoverageInfo,
    ProcessProtectionLevelInfo,
    ProcessLeapSecondInfo,
    ProcessInformationClassMax
} PROCESS_INFORMATION_CLASS;

typedef struct _APP_MEMORY_INFORMATION
{
    ULONG64 AvailableCommit;
    ULONG64 PrivateCommitUsage;
    ULONG64 PeakPrivateCommitUsage;
    ULONG64 TotalCommitUsage;
} APP_MEMORY_INFORMATION, *PAPP_MEMORY_INFORMATION;

typedef enum _PROCESS_MEMORY_EXHAUSTION_TYPE
{
    PMETypeFailFastOnCommitFailure,
    PMETypeMax
} PROCESS_MEMORY_EXHAUSTION_TYPE,
    *PPROCESS_MEMORY_EXHAUSTION_TYPE;

typedef struct _PROCESS_MEMORY_EXHAUSTION_INFO
{
    USHORT Version;
    USHORT Reserved;
    PROCESS_MEMORY_EXHAUSTION_TYPE Type;
    ULONG_PTR Value;
} PROCESS_MEMORY_EXHAUSTION_INFO, *PPROCESS_MEMORY_EXHAUSTION_INFO;

typedef struct _PROCESS_POWER_THROTTLING_STATE
{
    ULONG Version;
    ULONG ControlMask;
    ULONG StateMask;
} PROCESS_POWER_THROTTLING_STATE, *PPROCESS_POWER_THROTTLING_STATE;

typedef struct PROCESS_PROTECTION_LEVEL_INFORMATION
{
    DWORD ProtectionLevel;
} PROCESS_PROTECTION_LEVEL_INFORMATION;

typedef struct _PROCESS_LEAP_SECOND_INFO
{
    ULONG Flags;
    ULONG Reserved;
} PROCESS_LEAP_SECOND_INFO, *PPROCESS_LEAP_SECOND_INFO;

BOOL SetProcessInformation(
    HANDLE hProcess,
    PROCESS_INFORMATION_CLASS ProcessInformationClass,
    LPVOID ProcessInformation,
    DWORD ProcessInformationSize);

BOOL GetProcessInformation(
    HANDLE hProcess,
    PROCESS_INFORMATION_CLASS ProcessInformationClass,
    LPVOID ProcessInformation,
    DWORD ProcessInformationSize);

BOOL GetSystemCpuSetInformation(
    PSYSTEM_CPU_SET_INFORMATION Information,
    ULONG BufferLength,
    PULONG ReturnedLength,
    HANDLE Process,
    ULONG Flags);

BOOL GetProcessDefaultCpuSets(
    HANDLE Process,
    PULONG CpuSetIds,
    ULONG CpuSetIdCount,
    PULONG RequiredIdCount);

BOOL SetProcessDefaultCpuSets(
    HANDLE Process,
    const ULONG *CpuSetIds,
    ULONG CpuSetIdCount);

BOOL GetThreadSelectedCpuSets(
    HANDLE Thread,
    PULONG CpuSetIds,
    ULONG CpuSetIdCount,
    PULONG RequiredIdCount);

BOOL SetThreadSelectedCpuSets(
    HANDLE Thread,
    const ULONG *CpuSetIds,
    ULONG CpuSetIdCount);

BOOL CreateProcessAsUserA(
    HANDLE hToken,
    LPCSTR lpApplicationName,
    LPSTR lpCommandLine,
    LPSECURITY_ATTRIBUTES lpProcessAttributes,
    LPSECURITY_ATTRIBUTES lpThreadAttributes,
    BOOL bInheritHandles,
    DWORD dwCreationFlags,
    LPVOID lpEnvironment,
    LPCSTR lpCurrentDirectory,
    LPSTARTUPINFOA lpStartupInfo,
    LPPROCESS_INFORMATION lpProcessInformation);

BOOL GetProcessShutdownParameters(
    LPDWORD lpdwLevel,
    LPDWORD lpdwFlags);

HRESULT SetThreadDescription(
    HANDLE hThread,
    PCWSTR lpThreadDescription);

HRESULT GetThreadDescription(
    HANDLE hThread,
    PWSTR *ppszThreadDescription);

BOOL CloseHandle(HANDLE hObject);

void Sleep(DWORD dwMilliseconds);
DWORD SleepEx(DWORD dwMilliseconds, BOOL bAlertable);

DWORD GetLastError();

DWORD WaitForSingleObject(HANDLE hHandle, DWORD dwMilliseconds);
DWORD WaitForMultipleObjects(
    DWORD nCount, const HANDLE *lpHandles, BOOL bWaitAll, DWORD dwMilliseconds);
DWORD WaitForMultipleObjectsEx(
    DWORD nCount, const HANDLE *lpHandles, BOOL bWaitAll, DWORD dwMilliseconds, BOOL bAlertable);
