#define FFI_SCOPE "__threads__"
#define FFI_LIB "__platforms_pthread_library_location__"
// debian  /usr/lib/x86_64-linux-gnu/libpthread.so
// redhat /usr/lib64/libpthread.so
// pi /usr/lib/aarch64-linux-gnu/libpthread.so
// macos /usr/lib/libpthread.dylib

typedef int ts_rsrc_id;
typedef unsigned char __u_char;
typedef unsigned short int __u_short;
typedef unsigned int __u_int;
typedef unsigned long int __u_long;
typedef signed char __int8_t;
typedef unsigned char __uint8_t;
typedef signed short int __int16_t;
typedef unsigned short int __uint16_t;
typedef signed int __int32_t;
typedef unsigned int __uint32_t;
typedef signed long int __int64_t;
typedef unsigned long int __uint64_t;
typedef __int8_t __int_least8_t;
typedef __uint8_t __uint_least8_t;
typedef __int16_t __int_least16_t;
typedef __uint16_t __uint_least16_t;
typedef __int32_t __int_least32_t;
typedef __uint32_t __uint_least32_t;
typedef __int64_t __int_least64_t;
typedef __uint64_t __uint_least64_t;
typedef long int __quad_t;
typedef unsigned long int __u_quad_t;
typedef long int __intmax_t;
typedef unsigned long int __uintmax_t;
typedef unsigned long int __dev_t;
typedef unsigned int __uid_t;
typedef unsigned int __gid_t;
typedef unsigned long int __ino_t;
typedef unsigned long int __ino64_t;
typedef unsigned int __mode_t;
typedef unsigned long int __nlink_t;
typedef long int __off_t;
typedef long int __off64_t;
typedef int __pid_t;
typedef struct
{
     int __val[2];
} __fsid_t;
typedef long int __clock_t;
typedef unsigned long int __rlim_t;
typedef unsigned long int __rlim64_t;
typedef unsigned int __id_t;
typedef long int __time_t;
typedef unsigned int __useconds_t;
typedef long int __suseconds_t;
typedef int __daddr_t;
typedef int __key_t;
typedef int __clockid_t;
typedef void *__timer_t;
typedef long int __blksize_t;
typedef long int __blkcnt_t;
typedef long int __blkcnt64_t;
typedef unsigned long int __fsblkcnt_t;
typedef unsigned long int __fsblkcnt64_t;
typedef unsigned long int __fsfilcnt_t;
typedef unsigned long int __fsfilcnt64_t;
typedef long int __fsword_t;
typedef long int __ssize_t;
typedef long int __syscall_slong_t;
typedef unsigned long int __syscall_ulong_t;
typedef __off64_t __loff_t;
typedef char *__caddr_t;
typedef long int __intptr_t;
typedef unsigned int __socklen_t;
typedef int __sig_atomic_t;
typedef long unsigned int size_t;
typedef __time_t time_t;
struct timespec
{
     __time_t tv_sec;
     __syscall_slong_t tv_nsec;
};
typedef __pid_t pid_t;
struct sched_param
{
     int sched_priority;
};

typedef unsigned long int __cpu_mask;
typedef struct
{
     __cpu_mask __bits[1024 / (8 * sizeof(__cpu_mask))];
} cpu_set_t;

extern int __sched_cpucount(size_t __setsize, const cpu_set_t *__setp);
extern cpu_set_t *__sched_cpualloc(size_t __count);
extern void __sched_cpufree(cpu_set_t *__set);

extern int sched_setparam(__pid_t __pid, const struct sched_param *__param);
extern int sched_getparam(__pid_t __pid, struct sched_param *__param);
extern int sched_setscheduler(__pid_t __pid, int __policy,
                              const struct sched_param *__param);
extern int sched_getscheduler(__pid_t __pid);
extern int sched_yield(void);
extern int sched_get_priority_max(int __algorithm);
extern int sched_get_priority_min(int __algorithm);
extern int sched_rr_get_interval(__pid_t __pid, struct timespec *__t);

typedef __clock_t clock_t;
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
     long int tm_gmtoff;
     const char *tm_zone;
};
typedef __clockid_t clockid_t;
typedef __timer_t timer_t;
struct itimerspec
{
     struct timespec it_interval;
     struct timespec it_value;
};
struct sigevent;
struct __locale_struct
{
     struct __locale_data *__locales[13];
     const unsigned short int *__ctype_b;
     const int *__ctype_tolower;
     const int *__ctype_toupper;
     const char *__names[13];
};
typedef struct __locale_struct *__locale_t;
typedef __locale_t locale_t;

extern clock_t clock(void);
extern time_t time(time_t *__timer);
extern double difftime(time_t __time1, time_t __time0);
extern time_t mktime(struct tm *__tp);
extern size_t strftime(char *__restrict __s, size_t __maxsize,
                       const char *__restrict __format,
                       const struct tm *__restrict __tp);
extern size_t strftime_l(char *__restrict __s, size_t __maxsize,
                         const char *__restrict __format,
                         const struct tm *__restrict __tp,
                         locale_t __loc);
extern struct tm *gmtime(const time_t *__timer);
extern struct tm *localtime(const time_t *__timer);
extern struct tm *gmtime_r(const time_t *__restrict __timer,
                           struct tm *__restrict __tp);
extern struct tm *localtime_r(const time_t *__restrict __timer,
                              struct tm *__restrict __tp);
extern char *asctime(const struct tm *__tp);
extern char *ctime(const time_t *__timer);
extern char *asctime_r(const struct tm *__restrict __tp,
                       char *__restrict __buf);
extern char *ctime_r(const time_t *__restrict __timer,
                     char *__restrict __buf);
extern char *__tzname[2];
extern int __daylight;
extern long int __timezone;
extern char *tzname[2];
extern void tzset(void);
extern int daylight;
extern long int timezone;
extern time_t timegm(struct tm *__tp);
extern time_t timelocal(struct tm *__tp);
extern int dysize(int __year);
extern int nanosleep(const struct timespec *__requested_time,
                     struct timespec *__remaining);
extern int clock_getres(clockid_t __clock_id, struct timespec *__res);
extern int clock_gettime(clockid_t __clock_id, struct timespec *__tp);
extern int clock_settime(clockid_t __clock_id, const struct timespec *__tp);
extern int clock_nanosleep(clockid_t __clock_id, int __flags,
                           const struct timespec *__req,
                           struct timespec *__rem);
extern int clock_getcpuclockid(pid_t __pid, clockid_t *__clock_id);
extern int timespec_get(struct timespec *__ts, int __base);

typedef struct __pthread_internal_list
{
     struct __pthread_internal_list *__prev;
     struct __pthread_internal_list *__next;
} __pthread_list_t;
typedef struct __pthread_internal_slist
{
     struct __pthread_internal_slist *__next;
} __pthread_slist_t;
struct __pthread_mutex_s
{
     int __lock;
     unsigned int __count;
     int __owner;
     unsigned int __nusers;
     int __kind;
     short __spins;
     short __elision;
     __pthread_list_t __list;
};
struct __pthread_rwlock_arch_t
{
     unsigned int __readers;
     unsigned int __writers;
     unsigned int __wrphase_futex;
     unsigned int __writers_futex;
     unsigned int __pad3;
     unsigned int __pad4;
     int __cur_writer;
     int __shared;
     signed char __rwelision;
     unsigned char __pad1[7];
     unsigned long int __pad2;
     unsigned int __flags;
};
struct __pthread_cond_s
{
     union
     {
          unsigned long long int __wseq;
          struct
          {
               unsigned int __low;
               unsigned int __high;
          } __wseq32;
     };
     union
     {
          unsigned long long int __g1_start;
          struct
          {
               unsigned int __low;
               unsigned int __high;
          } __g1_start32;
     };
     unsigned int __g_refs[2];
     unsigned int __g_size[2];
     unsigned int __g1_orig_size;
     unsigned int __wrefs;
     unsigned int __g_signals[2];
};
typedef unsigned long int pthread_t;
typedef union
{
     char __size[4];
     int __align;
} pthread_mutexattr_t;
typedef union
{
     char __size[4];
     int __align;
} pthread_condattr_t;
typedef unsigned int pthread_key_t;
typedef int pthread_once_t;
union pthread_attr_t
{
     char __size[56];
     long int __align;
};
typedef union pthread_attr_t pthread_attr_t;
typedef union
{
     struct __pthread_mutex_s __data;
     char __size[40];
     long int __align;
} pthread_mutex_t;
typedef union
{
     struct __pthread_cond_s __data;
     char __size[48];
     long long int __align;
} pthread_cond_t;
typedef union
{
     struct __pthread_rwlock_arch_t __data;
     char __size[56];
     long int __align;
} pthread_rwlock_t;
typedef union
{
     char __size[8];
     long int __align;
} pthread_rwlockattr_t;
typedef volatile int pthread_spinlock_t;
typedef union
{
     char __size[32];
     long int __align;
} pthread_barrier_t;
typedef union
{
     char __size[4];
     int __align;
} pthread_barrierattr_t;
typedef long int __jmp_buf[8];
enum
{
     PTHREAD_CREATE_JOINABLE,
     PTHREAD_CREATE_DETACHED
};
enum
{
     PTHREAD_MUTEX_TIMED_NP,
     PTHREAD_MUTEX_RECURSIVE_NP,
     PTHREAD_MUTEX_ERRORCHECK_NP,
     PTHREAD_MUTEX_ADAPTIVE_NP,
     PTHREAD_MUTEX_NORMAL = PTHREAD_MUTEX_TIMED_NP,
     PTHREAD_MUTEX_RECURSIVE = PTHREAD_MUTEX_RECURSIVE_NP,
     PTHREAD_MUTEX_ERRORCHECK = PTHREAD_MUTEX_ERRORCHECK_NP,
     PTHREAD_MUTEX_DEFAULT = PTHREAD_MUTEX_NORMAL
};
enum
{
     PTHREAD_MUTEX_STALLED,
     PTHREAD_MUTEX_STALLED_NP = PTHREAD_MUTEX_STALLED,
     PTHREAD_MUTEX_ROBUST,
     PTHREAD_MUTEX_ROBUST_NP = PTHREAD_MUTEX_ROBUST
};
enum
{
     PTHREAD_PRIO_NONE,
     PTHREAD_PRIO_INHERIT,
     PTHREAD_PRIO_PROTECT
};
enum
{
     PTHREAD_RWLOCK_PREFER_READER_NP,
     PTHREAD_RWLOCK_PREFER_WRITER_NP,
     PTHREAD_RWLOCK_PREFER_WRITER_NONRECURSIVE_NP,
     PTHREAD_RWLOCK_DEFAULT_NP = PTHREAD_RWLOCK_PREFER_READER_NP
};
enum
{
     PTHREAD_INHERIT_SCHED,
     PTHREAD_EXPLICIT_SCHED
};
enum
{
     PTHREAD_SCOPE_SYSTEM,
     PTHREAD_SCOPE_PROCESS
};
enum
{
     PTHREAD_PROCESS_PRIVATE,
     PTHREAD_PROCESS_SHARED
};
struct _pthread_cleanup_buffer
{
     void (*__routine)(void *);
     void *__arg;
     int __canceltype;
     struct _pthread_cleanup_buffer *__prev;
};
enum
{
     PTHREAD_CANCEL_ENABLE,
     PTHREAD_CANCEL_DISABLE
};
enum
{
     PTHREAD_CANCEL_DEFERRED,
     PTHREAD_CANCEL_ASYNCHRONOUS
};

extern int pthread_create(pthread_t *__restrict __newthread,
                          const pthread_attr_t *__restrict __attr,
                          void *(*__start_routine)(void *),
                          void *__restrict __arg);
extern void pthread_exit(void *__retval);
extern int pthread_join(pthread_t __th, void **__thread_return);
extern int pthread_detach(pthread_t __th);
extern pthread_t pthread_self(void);
extern int pthread_equal(pthread_t __thread1, pthread_t __thread2);
extern int pthread_attr_init(pthread_attr_t *__attr);
extern int pthread_attr_destroy(pthread_attr_t *__attr);
extern int pthread_attr_getdetachstate(const pthread_attr_t *__attr,
                                       int *__detachstate);
extern int pthread_attr_setdetachstate(pthread_attr_t *__attr,
                                       int __detachstate);
extern int pthread_attr_getguardsize(const pthread_attr_t *__attr,
                                     size_t *__guardsize);
extern int pthread_attr_setguardsize(pthread_attr_t *__attr,
                                     size_t __guardsize);
extern int pthread_attr_getschedparam(const pthread_attr_t *__restrict __attr,
                                      struct sched_param *__restrict __param);
extern int pthread_attr_setschedparam(pthread_attr_t *__restrict __attr,
                                      const struct sched_param *__restrict __param);
extern int pthread_attr_getschedpolicy(const pthread_attr_t *__restrict __attr, int *__restrict __policy);
extern int pthread_attr_setschedpolicy(pthread_attr_t *__attr, int __policy);
extern int pthread_attr_getinheritsched(const pthread_attr_t *__restrict __attr, int *__restrict __inherit);
extern int pthread_attr_setinheritsched(pthread_attr_t *__attr,
                                        int __inherit);
extern int pthread_attr_getscope(const pthread_attr_t *__restrict __attr,
                                 int *__restrict __scope);
extern int pthread_attr_setscope(pthread_attr_t *__attr, int __scope);
extern int pthread_attr_getstackaddr(const pthread_attr_t *__restrict __attr, void **__restrict __stackaddr);
extern int pthread_attr_setstackaddr(pthread_attr_t *__attr,
                                     void *__stackaddr);
extern int pthread_attr_getstacksize(const pthread_attr_t *__restrict __attr, size_t *__restrict __stacksize);
extern int pthread_attr_setstacksize(pthread_attr_t *__attr,
                                     size_t __stacksize);
extern int pthread_attr_getstack(const pthread_attr_t *__restrict __attr,
                                 void **__restrict __stackaddr,
                                 size_t *__restrict __stacksize);
extern int pthread_attr_setstack(pthread_attr_t *__attr, void *__stackaddr,
                                 size_t __stacksize);
extern int pthread_setschedparam(pthread_t __target_thread, int __policy,
                                 const struct sched_param *__param);
extern int pthread_getschedparam(pthread_t __target_thread,
                                 int *__restrict __policy,
                                 struct sched_param *__restrict __param);
extern int pthread_setschedprio(pthread_t __target_thread, int __prio);
extern int pthread_once(pthread_once_t *__once_control,
                        void (*__init_routine)(void));
extern int pthread_setcancelstate(int __state, int *__oldstate);
extern int pthread_setcanceltype(int __type, int *__oldtype);
extern int pthread_cancel(pthread_t __th);
extern void pthread_testcancel(void);
typedef struct
{
     struct
     {
          __jmp_buf __cancel_jmp_buf;
          int __mask_was_saved;
     } __cancel_jmp_buf[1];
     void *__pad[4];
} __pthread_unwind_buf_t;
struct __pthread_cleanup_frame
{
     void (*__cancel_routine)(void *);
     void *__cancel_arg;
     int __do_it;
     int __cancel_type;
};
extern void __pthread_register_cancel(__pthread_unwind_buf_t *__buf);
extern void __pthread_unregister_cancel(__pthread_unwind_buf_t *__buf);
extern void __pthread_unwind_next(__pthread_unwind_buf_t *__buf)

    ;
struct __jmp_buf_tag;
extern int __sigsetjmp(struct __jmp_buf_tag *__env, int __savemask);
extern int pthread_mutex_init(pthread_mutex_t *__mutex,
                              const pthread_mutexattr_t *__mutexattr);
extern int pthread_mutex_destroy(pthread_mutex_t *__mutex);
extern int pthread_mutex_trylock(pthread_mutex_t *__mutex);
extern int pthread_mutex_lock(pthread_mutex_t *__mutex);
extern int pthread_mutex_timedlock(pthread_mutex_t *__restrict __mutex,
                                   const struct timespec *__restrict __abstime);
extern int pthread_mutex_unlock(pthread_mutex_t *__mutex);
extern int pthread_mutex_getprioceiling(const pthread_mutex_t *__restrict __mutex,
                                        int *__restrict __prioceiling);
extern int pthread_mutex_setprioceiling(pthread_mutex_t *__restrict __mutex,
                                        int __prioceiling,
                                        int *__restrict __old_ceiling);
extern int pthread_mutex_consistent(pthread_mutex_t *__mutex);
extern int pthread_mutexattr_init(pthread_mutexattr_t *__attr);
extern int pthread_mutexattr_destroy(pthread_mutexattr_t *__attr);
extern int pthread_mutexattr_getpshared(const pthread_mutexattr_t *__restrict __attr,
                                        int *__restrict __pshared);
extern int pthread_mutexattr_setpshared(pthread_mutexattr_t *__attr,
                                        int __pshared);
extern int pthread_mutexattr_gettype(const pthread_mutexattr_t *__restrict __attr, int *__restrict __kind);
extern int pthread_mutexattr_settype(pthread_mutexattr_t *__attr, int __kind);
extern int pthread_mutexattr_getprotocol(const pthread_mutexattr_t *__restrict __attr,
                                         int *__restrict __protocol);
extern int pthread_mutexattr_setprotocol(pthread_mutexattr_t *__attr,
                                         int __protocol);
extern int pthread_mutexattr_getprioceiling(const pthread_mutexattr_t *__restrict __attr,
                                            int *__restrict __prioceiling);
extern int pthread_mutexattr_setprioceiling(pthread_mutexattr_t *__attr,
                                            int __prioceiling);
extern int pthread_mutexattr_getrobust(const pthread_mutexattr_t *__attr,
                                       int *__robustness);
extern int pthread_mutexattr_setrobust(pthread_mutexattr_t *__attr,
                                       int __robustness);
extern int pthread_rwlock_init(pthread_rwlock_t *__restrict __rwlock,
                               const pthread_rwlockattr_t *__restrict __attr);
extern int pthread_rwlock_destroy(pthread_rwlock_t *__rwlock);
extern int pthread_rwlock_rdlock(pthread_rwlock_t *__rwlock);
extern int pthread_rwlock_tryrdlock(pthread_rwlock_t *__rwlock);
extern int pthread_rwlock_timedrdlock(pthread_rwlock_t *__restrict __rwlock,
                                      const struct timespec *__restrict __abstime);
extern int pthread_rwlock_wrlock(pthread_rwlock_t *__rwlock);
extern int pthread_rwlock_trywrlock(pthread_rwlock_t *__rwlock);
extern int pthread_rwlock_timedwrlock(pthread_rwlock_t *__restrict __rwlock,
                                      const struct timespec *__restrict __abstime);
extern int pthread_rwlock_unlock(pthread_rwlock_t *__rwlock);
extern int pthread_rwlockattr_init(pthread_rwlockattr_t *__attr);
extern int pthread_rwlockattr_destroy(pthread_rwlockattr_t *__attr);
extern int pthread_rwlockattr_getpshared(const pthread_rwlockattr_t *__restrict __attr,
                                         int *__restrict __pshared);
extern int pthread_rwlockattr_setpshared(pthread_rwlockattr_t *__attr,
                                         int __pshared);
extern int pthread_rwlockattr_getkind_np(const pthread_rwlockattr_t *__restrict __attr,
                                         int *__restrict __pref);
extern int pthread_rwlockattr_setkind_np(pthread_rwlockattr_t *__attr,
                                         int __pref);
extern int pthread_cond_init(pthread_cond_t *__restrict __cond,
                             const pthread_condattr_t *__restrict __cond_attr);
extern int pthread_cond_destroy(pthread_cond_t *__cond);
extern int pthread_cond_signal(pthread_cond_t *__cond);
extern int pthread_cond_broadcast(pthread_cond_t *__cond);
extern int pthread_cond_wait(pthread_cond_t *__restrict __cond,
                             pthread_mutex_t *__restrict __mutex);
extern int pthread_cond_timedwait(pthread_cond_t *__restrict __cond,
                                  pthread_mutex_t *__restrict __mutex,
                                  const struct timespec *__restrict __abstime);
extern int pthread_condattr_init(pthread_condattr_t *__attr);
extern int pthread_condattr_destroy(pthread_condattr_t *__attr);
extern int pthread_condattr_getpshared(const pthread_condattr_t *__restrict __attr,
                                       int *__restrict __pshared);
extern int pthread_condattr_setpshared(pthread_condattr_t *__attr,
                                       int __pshared);
extern int pthread_condattr_getclock(const pthread_condattr_t *__restrict __attr,
                                     __clockid_t *__restrict __clock_id);
extern int pthread_condattr_setclock(pthread_condattr_t *__attr,
                                     __clockid_t __clock_id);
extern int pthread_spin_init(pthread_spinlock_t *__lock, int __pshared);
extern int pthread_spin_destroy(pthread_spinlock_t *__lock);
extern int pthread_spin_lock(pthread_spinlock_t *__lock);
extern int pthread_spin_trylock(pthread_spinlock_t *__lock);
extern int pthread_spin_unlock(pthread_spinlock_t *__lock);
extern int pthread_barrier_init(pthread_barrier_t *__restrict __barrier,
                                const pthread_barrierattr_t *__restrict __attr, unsigned int __count);
extern int pthread_barrier_destroy(pthread_barrier_t *__barrier);
extern int pthread_barrier_wait(pthread_barrier_t *__barrier);
extern int pthread_barrierattr_init(pthread_barrierattr_t *__attr);
extern int pthread_barrierattr_destroy(pthread_barrierattr_t *__attr);
extern int pthread_barrierattr_getpshared(const pthread_barrierattr_t *__restrict __attr,
                                          int *__restrict __pshared);
extern int pthread_barrierattr_setpshared(pthread_barrierattr_t *__attr,
                                          int __pshared);
extern int pthread_key_create(pthread_key_t *__key,
                              void (*__destr_function)(void *));
extern int pthread_key_delete(pthread_key_t __key);
extern void *pthread_getspecific(pthread_key_t __key);
extern int pthread_setspecific(pthread_key_t __key,
                               const void *__pointer);
extern int pthread_getcpuclockid(pthread_t __thread_id,
                                 __clockid_t *__clock_id);

typedef struct _zend_server_context
{
     pthread_mutex_t mutex;
     uintptr_t current_request;
     uintptr_t main_request; /* Only available during worker initialization */
     char *cookie_data;
     bool finished;
} zend_server_context;
