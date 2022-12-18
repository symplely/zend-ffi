#define FFI_SCOPE "__threads__"
#define FFI_LIB ".\\lib\\Windows\\pthreadVC3.dll"

typedef signed long int __int64;
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
typedef void *HANDLE;
typedef HANDLE *PHANDLE;
typedef long LONG;
typedef unsigned long DWORD;
typedef int BOOL;
typedef __int64 __time64_t;

typedef __time64_t time_t;
typedef size_t rsize_t;
typedef signed long long _int64;
typedef _int64 int64_t;
typedef unsigned long long uint64_t;
enum
{
    __PTW32_FALSE = 0,
    __PTW32_TRUE = (!__PTW32_FALSE)
};
struct tm
{
    int tm_sec;
    int tm_min;
    int tm_hour;
    int tm_mday;
    int tm_mon;
    int tm_year;
    int tm_wday;
    int tm_yday;
    int tm_isdst;
};
typedef long clock_t;

struct _timespec32
{
    __time32_t tv_sec;
    long tv_nsec;
};

struct _timespec64
{
    __time64_t tv_sec;
    long tv_nsec;
};

typedef int pid_t;
struct timespec
{
    time_t tv_sec;
    int tv_nsec;
};
enum
{
    SCHED_OTHER = 0,
    SCHED_FIFO,
    SCHED_RR,
    SCHED_MIN = SCHED_OTHER,
    SCHED_MAX = SCHED_RR
};

struct sched_param
{
    int sched_priority;
};
typedef union
{
    char cpuset[(sizeof(size_t) * 8) / 8];
    size_t _align;
} cpu_set_t;

int __cdecl sched_yield(void);

int __cdecl sched_get_priority_min(int policy);

int __cdecl sched_get_priority_max(int policy);
int __cdecl sched_setscheduler(pid_t pid, int policy);
int __cdecl sched_setaffinity(pid_t pid, size_t cpusetsize, cpu_set_t *mask);

int __cdecl sched_getaffinity(pid_t pid, size_t cpusetsize, cpu_set_t *mask);
int __cdecl _sched_affinitycpucount(const cpu_set_t *set);

void __cdecl _sched_affinitycpuzero(cpu_set_t *pset);

void __cdecl _sched_affinitycpuset(int cpu, cpu_set_t *pset);

void __cdecl _sched_affinitycpuclr(int cpu, cpu_set_t *pset);

int __cdecl _sched_affinitycpuisset(int cpu, const cpu_set_t *pset);

void __cdecl _sched_affinitycpuand(cpu_set_t *pdestset, const cpu_set_t *psrcset1, const cpu_set_t *psrcset2);

void __cdecl _sched_affinitycpuor(cpu_set_t *pdestset, const cpu_set_t *psrcset1, const cpu_set_t *psrcset2);

void __cdecl _sched_affinitycpuxor(cpu_set_t *pdestset, const cpu_set_t *psrcset1, const cpu_set_t *psrcset2);

int __cdecl _sched_affinitycpuequal(const cpu_set_t *pset1, const cpu_set_t *pset2);

typedef struct
{
    void *p;

    size_t x;
} __ptw32_handle_t;

typedef __ptw32_handle_t pthread_t;
typedef struct pthread_attr_t_ *pthread_attr_t;
typedef struct pthread_once_t_ pthread_once_t;
typedef struct pthread_key_t_ *pthread_key_t;
typedef struct pthread_mutex_t_ *pthread_mutex_t;
typedef struct pthread_mutexattr_t_ *pthread_mutexattr_t;
typedef struct pthread_cond_t_ *pthread_cond_t;
typedef struct pthread_condattr_t_ *pthread_condattr_t;

typedef struct pthread_rwlock_t_ *pthread_rwlock_t;
typedef struct pthread_rwlockattr_t_ *pthread_rwlockattr_t;
typedef struct pthread_spinlock_t_ *pthread_spinlock_t;
typedef struct pthread_barrier_t_ *pthread_barrier_t;
typedef struct pthread_barrierattr_t_ *pthread_barrierattr_t;
typedef struct sem_t_ *sem_t;

typedef struct __ptw32_mcs_node_t_ __ptw32_mcs_local_node_t;

struct pthread_mutexattr_t_
{
    int pshared;
    int kind;
    int robustness;
};

typedef struct __ptw32_mcs_node_t_ *__ptw32_mcs_lock_t;
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

typedef enum __ptw32_robust_state_t_ __ptw32_robust_state_t;
typedef struct __ptw32_robust_node_t_ __ptw32_robust_node_t;
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
    LONG lock_idx;       /* Provides exclusive access to mutex state
                    via the Interlocked* mechanism.
                     0: unlocked/free.
                     1: locked - no other waiters.
                    -1: locked - with possible other waiters.
                 */
    int recursive_count; /* Number of unlocks a thread needs to perform
                before the lock is released (recursive
                mutexes only). */
    int kind;            /* Mutex type. */
    pthread_t ownerThread;
    HANDLE event; /* Mutex release notification to waiting
             threads. */
    __ptw32_robust_node_t *
        robustNode; /* Extra state for robust mutexes  */
};

struct pthread_attr_t_
{
    unsigned long valid;
    void *stackaddr;
    size_t stacksize;
    int detachstate;
    struct sched_param param;
    int inheritsched;
    int contentionscope;
    size_t cpuset;
    char *thrname;
};

struct pthread_spinlock_t_
{
    long interlock; /* Locking element for multi-cpus. */
    union
    {
        int cpus;              /* No. of cpus if multi cpus, or   */
        pthread_mutex_t mutex; /* mutex if single cpu.            */
    } u;
};

struct __ptw32_mcs_node_t_
{
    struct __ptw32_mcs_node_t_ *lock; /* ptr to tail of queue */
    struct __ptw32_mcs_node_t_ *next; /* ptr to successor in queue */
    HANDLE readyFlag;                 /* set after lock is released by
                                         predecessor */
    HANDLE nextFlag;                  /* set after 'next' ptr is set by
                                         successor */
};

struct pthread_barrier_t_
{
    unsigned int nCurrentBarrierHeight;
    unsigned int nInitialBarrierHeight;
    int pshared;
    sem_t semBarrierBreeched;
    __ptw32_mcs_lock_t lock;
    __ptw32_mcs_local_node_t proxynode;
};

struct pthread_barrierattr_t_
{
    int pshared;
};

struct pthread_key_t_
{
    DWORD key;
    void(__cdecl *destructor)(void *);
    __ptw32_mcs_lock_t keyLock;
    void *threads;
};

typedef struct ThreadParms ThreadParms;

struct ThreadParms
{
    pthread_t tid;
    void *(__cdecl *start)(void *);
    void *arg;
};

struct pthread_cond_t_
{
    long nWaitersBlocked;   /* Number of threads blocked            */
    long nWaitersGone;      /* Number of threads timed out          */
    long nWaitersToUnblock; /* Number of threads to unblock         */
    sem_t semBlockQueue;    /* Queue up threads waiting for the     */
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

struct pthread_condattr_t_
{
    int pshared;
};

struct pthread_rwlock_t_
{
    pthread_mutex_t mtxExclusiveAccess;
    pthread_mutex_t mtxSharedAccessCompleted;
    pthread_cond_t cndSharedAccessCompleted;
    int nSharedAccessCount;
    int nExclusiveAccessCount;
    int nCompletedSharedAccessCount;
    int nMagic;
};

struct pthread_rwlockattr_t_
{
    int pshared;
};

typedef union
{
    char cpuset[(sizeof(size_t) * 8) / 8];
    size_t _cpuset;
} _sched_cpu_set_vector_;

enum
{
    PTHREAD_CREATE_JOINABLE = 0,
    PTHREAD_CREATE_DETACHED = 1,
    PTHREAD_INHERIT_SCHED = 0,
    PTHREAD_EXPLICIT_SCHED = 1,
    PTHREAD_SCOPE_PROCESS = 0,
    PTHREAD_SCOPE_SYSTEM = 1,
    PTHREAD_CANCEL_ENABLE = 0,
    PTHREAD_CANCEL_DISABLE = 1,
    PTHREAD_CANCEL_ASYNCHRONOUS = 0,
    PTHREAD_CANCEL_DEFERRED = 1,
    PTHREAD_PROCESS_PRIVATE = 0,
    PTHREAD_PROCESS_SHARED = 1,
    PTHREAD_MUTEX_STALLED = 0,
    PTHREAD_MUTEX_ROBUST = 1,
    PTHREAD_BARRIER_SERIAL_THREAD = -1
};
struct pthread_once_t_
{
    void *lock;
    int done;
};
enum
{

    PTHREAD_MUTEX_FAST_NP,
    PTHREAD_MUTEX_RECURSIVE_NP,
    PTHREAD_MUTEX_ERRORCHECK_NP,
    PTHREAD_MUTEX_TIMED_NP = PTHREAD_MUTEX_FAST_NP,
    PTHREAD_MUTEX_ADAPTIVE_NP = PTHREAD_MUTEX_FAST_NP,

    PTHREAD_MUTEX_NORMAL = PTHREAD_MUTEX_FAST_NP,
    PTHREAD_MUTEX_RECURSIVE = PTHREAD_MUTEX_RECURSIVE_NP,
    PTHREAD_MUTEX_ERRORCHECK = PTHREAD_MUTEX_ERRORCHECK_NP,
    PTHREAD_MUTEX_DEFAULT = PTHREAD_MUTEX_NORMAL
};

typedef struct __ptw32_cleanup_t __ptw32_cleanup_t;
typedef void (*__cdecl __ptw32_cleanup_callback_t)(void *);
struct __ptw32_cleanup_t
{
    __ptw32_cleanup_callback_t routine;
    void *arg;
    struct __ptw32_cleanup_t *prev;
};

int __cdecl pthread_attr_init(pthread_attr_t *attr);

int __cdecl pthread_attr_destroy(pthread_attr_t *attr);

int __cdecl pthread_attr_getaffinity_np(const pthread_attr_t *attr,
                                        size_t cpusetsize,
                                        cpu_set_t *cpuset);

int __cdecl pthread_attr_getdetachstate(const pthread_attr_t *attr,
                                        int *detachstate);

int __cdecl pthread_attr_getstackaddr(const pthread_attr_t *attr,
                                      void **stackaddr);

int __cdecl pthread_attr_getstacksize(const pthread_attr_t *attr,
                                      size_t *stacksize);

int __cdecl pthread_attr_setaffinity_np(pthread_attr_t *attr,
                                        size_t cpusetsize,
                                        const cpu_set_t *cpuset);

int __cdecl pthread_attr_setdetachstate(pthread_attr_t *attr,
                                        int detachstate);

int __cdecl pthread_attr_setstackaddr(pthread_attr_t *attr,
                                      void *stackaddr);

int __cdecl pthread_attr_setstacksize(pthread_attr_t *attr,
                                      size_t stacksize);

int __cdecl pthread_attr_getschedparam(const pthread_attr_t *attr,
                                       struct sched_param *param);

int __cdecl pthread_attr_setschedparam(pthread_attr_t *attr,
                                       const struct sched_param *param);

int __cdecl pthread_attr_setschedpolicy(pthread_attr_t *,
                                        int);

int __cdecl pthread_attr_getschedpolicy(const pthread_attr_t *,
                                        int *);

int __cdecl pthread_attr_setinheritsched(pthread_attr_t *attr,
                                         int inheritsched);

int __cdecl pthread_attr_getinheritsched(const pthread_attr_t *attr,
                                         int *inheritsched);

int __cdecl pthread_attr_setscope(pthread_attr_t *,
                                  int);

int __cdecl pthread_attr_getscope(const pthread_attr_t *, int *);
int __cdecl pthread_create(pthread_t *tid,
                           const pthread_attr_t *attr,
                           void *(*start)(void *),
                           void *arg);

int __cdecl pthread_detach(pthread_t tid);

int __cdecl pthread_equal(pthread_t t1,
                          pthread_t t2);

void __cdecl pthread_exit(void *value_ptr);

int __cdecl pthread_join(pthread_t thread,
                         void **value_ptr);

pthread_t __cdecl pthread_self(void);

int __cdecl pthread_cancel(pthread_t thread);

int __cdecl pthread_setcancelstate(int state,
                                   int *oldstate);

int __cdecl pthread_setcanceltype(int type,
                                  int *oldtype);

void __cdecl pthread_testcancel(void);

int __cdecl pthread_once(pthread_once_t *once_control,
                         void (*init_routine)(void));

__ptw32_cleanup_t *__cdecl __ptw32_pop_cleanup(int execute);

void __cdecl __ptw32_push_cleanup(__ptw32_cleanup_t *cleanup,
                                  __ptw32_cleanup_callback_t routine,
                                  void *arg);
int __cdecl pthread_key_create(pthread_key_t *key,
                               void (*destructor)(void *));

int __cdecl pthread_key_delete(pthread_key_t key);

int __cdecl pthread_setspecific(pthread_key_t key,
                                const void *value);

void *__cdecl pthread_getspecific(pthread_key_t key);
int __cdecl pthread_mutexattr_init(pthread_mutexattr_t *attr);

int __cdecl pthread_mutexattr_destroy(pthread_mutexattr_t *attr);

int __cdecl pthread_mutexattr_getpshared(const pthread_mutexattr_t
                                             *attr,
                                         int *pshared);

int __cdecl pthread_mutexattr_setpshared(pthread_mutexattr_t *attr,
                                         int pshared);

int __cdecl pthread_mutexattr_settype(pthread_mutexattr_t *attr, int kind);
int __cdecl pthread_mutexattr_gettype(const pthread_mutexattr_t *attr, int *kind);

int __cdecl pthread_mutexattr_setrobust(
    pthread_mutexattr_t *attr,
    int robust);
int __cdecl pthread_mutexattr_getrobust(
    const pthread_mutexattr_t *attr,
    int *robust);
int __cdecl pthread_barrierattr_init(pthread_barrierattr_t *attr);

int __cdecl pthread_barrierattr_destroy(pthread_barrierattr_t *attr);

int __cdecl pthread_barrierattr_getpshared(const pthread_barrierattr_t
                                               *attr,
                                           int *pshared);

int __cdecl pthread_barrierattr_setpshared(pthread_barrierattr_t *attr,
                                           int pshared);
int __cdecl pthread_mutex_init(pthread_mutex_t *mutex,
                               const pthread_mutexattr_t *attr);

int __cdecl pthread_mutex_destroy(pthread_mutex_t *mutex);

int __cdecl pthread_mutex_lock(pthread_mutex_t *mutex);

int __cdecl pthread_mutex_timedlock(pthread_mutex_t *mutex,
                                    const struct timespec *abstime);

int __cdecl pthread_mutex_trylock(pthread_mutex_t *mutex);

int __cdecl pthread_mutex_unlock(pthread_mutex_t *mutex);

int __cdecl pthread_mutex_consistent(pthread_mutex_t *mutex);
int __cdecl pthread_spin_init(pthread_spinlock_t *lock, int pshared);

int __cdecl pthread_spin_destroy(pthread_spinlock_t *lock);

int __cdecl pthread_spin_lock(pthread_spinlock_t *lock);

int __cdecl pthread_spin_trylock(pthread_spinlock_t *lock);

int __cdecl pthread_spin_unlock(pthread_spinlock_t *lock);
int __cdecl pthread_barrier_init(pthread_barrier_t *barrier,
                                 const pthread_barrierattr_t *attr,
                                 unsigned int count);

int __cdecl pthread_barrier_destroy(pthread_barrier_t *barrier);

int __cdecl pthread_barrier_wait(pthread_barrier_t *barrier);
int __cdecl pthread_condattr_init(pthread_condattr_t *attr);

int __cdecl pthread_condattr_destroy(pthread_condattr_t *attr);

int __cdecl pthread_condattr_getpshared(const pthread_condattr_t *attr,
                                        int *pshared);

int __cdecl pthread_condattr_setpshared(pthread_condattr_t *attr,
                                        int pshared);
int __cdecl pthread_cond_init(pthread_cond_t *cond,
                              const pthread_condattr_t *attr);

int __cdecl pthread_cond_destroy(pthread_cond_t *cond);

int __cdecl pthread_cond_wait(pthread_cond_t *cond,
                              pthread_mutex_t *mutex);

int __cdecl pthread_cond_timedwait(pthread_cond_t *cond,
                                   pthread_mutex_t *mutex,
                                   const struct timespec *abstime);

int __cdecl pthread_cond_signal(pthread_cond_t *cond);

int __cdecl pthread_cond_broadcast(pthread_cond_t *cond);
int __cdecl pthread_setschedparam(pthread_t thread,
                                  int policy,
                                  const struct sched_param *param);

int __cdecl pthread_getschedparam(pthread_t thread,
                                  int *policy,
                                  struct sched_param *param);

int __cdecl pthread_setconcurrency(int);

int __cdecl pthread_getconcurrency(void);
int __cdecl pthread_rwlock_init(pthread_rwlock_t *lock,
                                const pthread_rwlockattr_t *attr);

int __cdecl pthread_rwlock_destroy(pthread_rwlock_t *lock);

int __cdecl pthread_rwlock_tryrdlock(pthread_rwlock_t *);

int __cdecl pthread_rwlock_trywrlock(pthread_rwlock_t *);

int __cdecl pthread_rwlock_rdlock(pthread_rwlock_t *lock);

int __cdecl pthread_rwlock_timedrdlock(pthread_rwlock_t *lock,
                                       const struct timespec *abstime);

int __cdecl pthread_rwlock_wrlock(pthread_rwlock_t *lock);

int __cdecl pthread_rwlock_timedwrlock(pthread_rwlock_t *lock,
                                       const struct timespec *abstime);

int __cdecl pthread_rwlock_unlock(pthread_rwlock_t *lock);

int __cdecl pthread_rwlockattr_init(pthread_rwlockattr_t *attr);

int __cdecl pthread_rwlockattr_destroy(pthread_rwlockattr_t *attr);

int __cdecl pthread_rwlockattr_getpshared(const pthread_rwlockattr_t *attr,
                                          int *pshared);

int __cdecl pthread_rwlockattr_setpshared(pthread_rwlockattr_t *attr,
                                          int pshared);
int __cdecl pthread_kill(pthread_t thread, int sig);
int __cdecl pthread_mutexattr_setkind_np(pthread_mutexattr_t *attr,
                                         int kind);
int __cdecl pthread_mutexattr_getkind_np(pthread_mutexattr_t *attr,
                                         int *kind);
int __cdecl pthread_timedjoin_np(pthread_t thread,
                                 void **value_ptr,
                                 const struct timespec *abstime);
int __cdecl pthread_tryjoin_np(pthread_t thread,
                               void **value_ptr);
int __cdecl pthread_setaffinity_np(pthread_t thread,
                                   size_t cpusetsize,
                                   const cpu_set_t *cpuset);
int __cdecl pthread_getaffinity_np(pthread_t thread,
                                   size_t cpusetsize,
                                   cpu_set_t *cpuset);
int __cdecl pthread_delay_np(struct timespec *interval);
int __cdecl pthread_num_processors_np(void);
uint64_t __cdecl pthread_getunique_np(pthread_t thread);
int __cdecl pthread_win32_process_attach_np(void);
int __cdecl pthread_win32_process_detach_np(void);
int __cdecl pthread_win32_thread_attach_np(void);
int __cdecl pthread_win32_thread_detach_np(void);
struct timespec *__cdecl pthread_win32_getabstime_np(
    struct timespec *abstime,
    const struct timespec *relative);
int __cdecl pthread_win32_test_features_np(int);
enum __ptw32_features
{
    __PTW32_SYSTEM_INTERLOCKED_COMPARE_EXCHANGE = 0x0001,
    __PTW32_ALERTABLE_ASYNC_CANCEL = 0x0002
};
void *__cdecl pthread_timechange_handler_np(void *);
void *__cdecl pthread_getw32threadhandle_np(pthread_t thread);
unsigned long __cdecl pthread_getw32threadid_np(pthread_t thread);
int __cdecl pthread_setname_np(pthread_t thr, const char *name);
int __cdecl pthread_attr_setname_np(pthread_attr_t *attr, const char *name);

int __cdecl pthread_getname_np(pthread_t thr, char *name, int len);
int __cdecl pthread_attr_getname_np(pthread_attr_t *attr, char *name, int len);
int __cdecl pthreadCancelableWait(void *waitHandle);
int __cdecl pthreadCancelableTimedWait(void *waitHandle,
                                       unsigned long timeout);
unsigned long __cdecl __ptw32_get_exception_services_code(void);
