<?php

interface FFI
{
    /** @return int */
    public function sched_yield();

    /** @return int */
    public function pthread_attr_init(pthread_attr_t &$attr);

    /** @return int */
    public function pthread_attr_destroy(pthread_attr_t &$attr);

    /** @return int */
    public function pthread_create(pthread_t_ptr &$tid, ?pthread_attr_t &$attr, callable &$start_args, void_ptr &$arg);

    /** @return int */
    public function pthread_detach(pthread_t $tid);

    /** @return int */
    public function pthread_equal(pthread_t $t1, pthread_t $t2);

    /** @return void */
    public function pthread_exit(void_ptr &$value_ptr);

    /** @return int */
    public function pthread_join(pthread_t_ptr $thread, ?void_ptr &$value_ptr);

    /** @return pthread_t */
    public function pthread_self();

    /** @return int */
    public function pthread_cancel(pthread_t $thread);

    /** @return int */
    public function pthread_key_create(pthread_key_t &$key, callable &$destructor_voidArg);

    /** @return int */
    public function pthread_key_delete(pthread_key_t $key);

    /** @return int */
    public function pthread_setspecific(pthread_key_t $key, void_ptr &$value);

    /** @return void_ptr */
    public function pthread_getspecific(pthread_key_t $key);

    /** @return int */
    public function pthread_mutexattr_init(pthread_mutexattr_t &$attr);

    /** @return int */
    public function pthread_mutexattr_destroy(pthread_mutexattr_t &$attr);

    /** @return int */
    public function pthread_mutex_init(pthread_mutex_t &$mutex, ?pthread_mutexattr_t &$attr);

    /** @return int */
    public function pthread_mutex_destroy(pthread_mutex_t &$mutex);

    /** @return int */
    public function pthread_mutexattr_settype(pthread_mutexattr_t &$attr, int $kind);

    /** @return int */
    public function pthread_mutexattr_gettype(pthread_mutexattr_t &$attr, int &$kind);

    /** @return int */
    public function pthread_mutexattr_setrobust(pthread_mutexattr_t &$attr, int $robust);

    /** @return int */
    public function pthread_mutexattr_getrobust(pthread_mutexattr_t &$attr, int &$robust);

    /** @return int */
    public function pthread_mutex_lock(pthread_mutex_t &$mutex);

    /** @return int */
    public function pthread_mutex_timedlock(
        pthread_mutex_t &$mutex,
        timespec &$abstime
    );

    /** @return int */
    public function pthread_mutex_trylock(pthread_mutex_t &$mutex);

    /** @return int */
    public function pthread_mutex_unlock(pthread_mutex_t &$mutex);

    /** @return int */
    public function pthread_mutex_consistent(pthread_mutex_t &$mutex);

    /** @return int */
    public function pthread_spin_init(pthread_spinlock_t &$lock, int $pshared);

    /** @return int */
    public function pthread_spin_destroy(pthread_spinlock_t &$lock);

    /** @return int */
    public function pthread_spin_lock(pthread_spinlock_t &$lock);

    /** @return int */
    public function pthread_spin_trylock(pthread_spinlock_t &$lock);

    /** @return int */
    public function pthread_spin_unlock(pthread_spinlock_t &$lock);

    /** @return int */
    public function pthread_barrier_init(
        pthread_barrier_t &$barrier,
        pthread_barrierattr_t &$attr,
        int $count
    );

    /** @return int */
    public function pthread_barrier_destroy(pthread_barrier_t &$barrier);

    /** @return int */
    public function pthread_barrier_wait(pthread_barrier_t &$barrier);

    /** @return int */
    public function pthread_cond_init(
        pthread_cond_t &$cond,
        pthread_condattr_t &$attr
    );

    /** @return int */
    public function pthread_cond_destroy(pthread_cond_t &$cond);

    /** @return int */
    public function pthread_cond_wait(
        pthread_cond_t &$cond,
        pthread_mutex_t &$mutex
    );

    /** @return int */
    public function pthread_cond_timedwait(
        pthread_cond_t &$cond,
        pthread_mutex_t &$mutex,
        timespec &$abstime
    );

    /** @return int */
    public function pthread_cond_signal(pthread_cond_t &$cond);

    /** @return int */
    public function pthread_cond_broadcast(pthread_cond_t &$cond);

    /** @return int */
    public function pthread_setconcurrency(int $number);

    /** @return int */
    public function pthread_getconcurrency();

    /** @return int */
    public function pthread_rwlock_init(
        pthread_rwlock_t &$lock,
        pthread_rwlockattr_t &$attr
    );

    /** @return int */
    public function pthread_rwlock_destroy(pthread_rwlock_t &$lock);

    /** @return int */
    public function pthread_rwlock_tryrdlock(pthread_rwlock_t &$lock);

    /** @return int */
    public function pthread_rwlock_trywrlock(pthread_rwlock_t &$lock);

    /** @return int */
    public function pthread_rwlock_rdlock(pthread_rwlock_t &$lock);

    /** @return int */
    public function pthread_rwlock_timedrdlock(
        pthread_rwlock_t &$lock,
        timespec &$abstime
    );

    /** @return int */
    public function pthread_rwlock_wrlock(pthread_rwlock_t &$lock);

    /** @return int */
    public function pthread_rwlock_timedwrlock(
        pthread_rwlock_t &$lock,
        timespec &$abstime
    );

    /** @return int */
    public function pthread_rwlock_unlock(pthread_rwlock_t &$lock);

    /** @return int */
    public function pthread_kill(pthread_t $thread, int $sig);
}
