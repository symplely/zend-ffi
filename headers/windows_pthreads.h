
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

struct timespec
{
    time_t tv_sec;
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

int __cdecl pthread_attr_getscope(const pthread_attr_t *,
                                  int *);
int __cdecl pthread_create(pthread_t *tid,
                           const pthread_attr_t *attr,
                           void *(__cdecl *start)(void *),
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
                         void(__cdecl *init_routine)(void));

__ptw32_cleanup_t *__cdecl __ptw32_pop_cleanup(int execute);

void __cdecl __ptw32_push_cleanup(__ptw32_cleanup_t *cleanup,
                                  __ptw32_cleanup_callback_t routine,
                                  void *arg);
int __cdecl pthread_key_create(pthread_key_t *key,
                               void(__cdecl *destructor)(void *));

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
unsigned __int64 __cdecl pthread_getunique_np(pthread_t thread);
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
