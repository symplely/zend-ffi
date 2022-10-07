<?php

declare(strict_types=1);

use FFI\CData;

if (!\defined('None'))
    \define('None', null);

if (!\defined('INET_ADDRSTRLEN'))
    \define('INET_ADDRSTRLEN', 22);

if (!\defined('INET6_ADDRSTRLEN'))
    \define('INET6_ADDRSTRLEN', 65);

if (!\defined('DS'))
    \define('DS', \DIRECTORY_SEPARATOR);

if (!\defined('IS_WINDOWS'))
    \define('IS_WINDOWS', ('\\' === \DS));

if (!\defined('IS_LINUX'))
    \define('IS_LINUX', ('/' === \DS));

if (!\defined('IS_MACOS'))
    \define('IS_MACOS', (\PHP_OS === 'Darwin'));

if (!\defined('EOL'))
    \define('EOL', \PHP_EOL);

if (!\defined('CRLF'))
    \define('CRLF', "\r\n");

if (!\defined('IS_ZTS'))
    \define('IS_ZTS', \ZEND_THREAD_SAFE);

if (!\defined('IS_CLI')) {
    /**
     * Check if php is running from cli (command line).
     */
    \define(
        'IS_CLI',
        \defined('STDIN') ||
            (empty($_SERVER['REMOTE_ADDR']) && !isset($_SERVER['HTTP_USER_AGENT']) && \count($_SERVER['argv']) > 0)
    );
}

if (!\defined('SYS_CONSOLE')) {
    /**
     * O.S. physical __input/output__ console `DEVICE`.
     */
    \define('SYS_CONSOLE', \IS_WINDOWS ? '\\\\?\\CON' : '/dev/tty');
}

if (!\defined('SYS_NULL')) {
    /**
     * O.S. physical __null__ `DEVICE`.
     */
    \define('SYS_NULL', \IS_WINDOWS ? '\\\\?\\NUL' : '/dev/null');
}

if (!\defined('SYS_PIPE')) {
    /**
     * O.S. physical __pipe__ prefix `string name` including trailing slash.
     */
    \define('SYS_PIPE', \IS_WINDOWS ? '\\\\.\\pipe\\' : \getcwd() . '/');
}

if (!\defined('IS_PHP81'))
    \define('IS_PHP81', ((float) \phpversion() >= 8.1));

if (!\defined('IS_PHP8'))
    \define('IS_PHP8', ((float) \phpversion() >= 8.0));

if (!\defined('IS_PHP74'))
    \define('IS_PHP74', ((float) \phpversion() >= 7.4) && !\IS_PHP8);

if (!\defined('S_IFMT')) {
    /**
     * bit mask for the file type bit field
     */
    \define('S_IFMT', 0170000);
}

if (!\defined('S_IFSOCK')) {
    /**
     * bit mask for socket
     */
    \define('S_IFSOCK', 0140000);
}

if (!\defined('S_IFLNK')) {
    /**
     * bit mask for symbolic link
     */
    \define('S_IFLNK', 0120000);
}

if (!\defined('S_IFREG')) {
    /**
     * bit mask for regular file
     */
    \define('S_IFREG', 0100000);
}

if (!\defined('S_IFBLK')) {
    /**
     * bit mask for block device
     */
    \define('S_IFBLK', 0060000);
}

if (!\defined('S_IFDIR')) {
    /**
     * bit mask for directory
     */
    \define('S_IFDIR', 0040000);
}

if (!\defined('S_IFCHR')) {
    /**
     * bit mask for character device
     */
    \define('S_IFCHR', 0020000);
}

if (!\defined('S_IFIFO')) {
    /**
     * bit mask for FIFO
     */
    \define('S_IFIFO', 0010000);
}

if (!\defined('S_IRWXU')) {
    /**
     * read, write, execute/search permission, owner
     */
    \define('S_IRWXU', 00700);
}

if (!\defined('S_IRUSR')) {
    /**
     * read permission, owner
     */
    \define('S_IRUSR', 00400);
}

if (!\defined('S_IWUSR')) {
    /**
     * write permission, owner
     */
    \define('S_IWUSR', 00200);
}

if (!\defined('S_IXUSR')) {
    /**
     * execute permission, owner
     */
    \define('S_IXUSR', 00100);
}

if (!\defined('O_TEMPORARY')) {
    /**
     * temporary file bit (file is deleted when last handle is closed).
     */
    \define('O_TEMPORARY', 0x0040);
}

if (!\defined('O_TEXT')) {
    /**
     * file mode is text (translated).
     */
    \define('O_TEXT', 0x4000);
}

if (!\defined('O_NOINHERIT')) {
    /**
     * child process doesn't inherit file.
     */
    \define('O_NOINHERIT', 0x0080);
}

if (!\defined('O_SEQUENTIAL')) {
    /**
     * file access is primarily sequential.
     */
    \define('O_SEQUENTIAL', 0x0020);
}

if (!\defined('O_SYNC')) {
    /**
     * FILE_FLAG_WRITE_THROUGH
     */
    \define('O_SYNC', 0x08000000);
}

if (!\defined('O_RANDOM')) {
    /**
     * file access is primarily random.
     */
    \define('O_RANDOM', 0x0010);
}

if (!\defined('O_BINARY')) {
    /**
     * Open the file for binary access.
     */
    \define('O_BINARY', 0x8000);
}

if (!\defined('O_CLOEXEC')) {
    \define('O_CLOEXEC', 0x00100000);
}

if (\IS_WINDOWS && !\defined('SIGBABY')) {
    /**
     * The SIGUSR1 signal is sent to a process to indicate user-defined conditions.
     */
    \define('SIGUSR1', 10);

    /**
     * The SIGUSR2 signa2 is sent to a process to indicate user-defined conditions.
     */
    \define('SIGUSR2', 12);

    /**
     * The SIGHUP signal is sent to a process when its controlling terminal is closed.
     */
    \define('SIGHUP', 1);

    /**
     * The SIGINT signal is sent to a process by its controlling terminal
     * when a user wishes to interrupt the process.
     */
    \define('SIGINT', 2);

    /**
     * The SIGQUIT signal is sent to a process by its controlling terminal
     * when the user requests that the process quit.
     */
    \define('SIGQUIT', 3);

    /**
     * The SIGILL signal is sent to a process when it attempts to execute an illegal,
     * malformed, unknown, or privileged instruction.
     */
    \define('SIGILL', 4);

    /**
     * The SIGTRAP signal is sent to a process when an exception (or trap) occurs.
     */
    \define('SIGTRAP', 5);

    /**
     * The SIGABRT signal is sent to a process to tell it to abort, i.e. to terminate.
     */
    \define('SIGABRT', 6);

    \define('SIGIOT', 6);

    /**
     * The SIGBUS signal is sent to a process when it causes a bus error.
     */
    \define('SIGBUS', 7);

    \define('SIGFPE', 8);

    /**
     * The SIGKILL signal is sent to a process to cause it to terminate immediately (kill).
     */
    \define('SIGKILL', 9);

    /**
     * The SIGSEGV signal is sent to a process when it makes an invalid virtual memory reference, or segmentation fault,
     */
    \define('SIGSEGV', 11);

    /**
     * The SIGPIPE signal is sent to a process when it attempts to write to a pipe without
     * a process connected to the other end.
     */
    \define('SIGPIPE', 13);

    /**
     * The SIGALRM, SIGVTALRM and SIGPROF signal is sent to a process when the time limit specified
     * in a call to a preceding alarm setting function (such as setitimer) elapses.
     */
    \define('SIGALRM', 14);

    /**
     * The SIGTERM signal is sent to a process to request its termination.
     * Unlike the SIGKILL signal, it can be caught and interpreted or ignored by the process.
     */
    \define('SIGTERM', 15);

    \define('SIGSTKFLT', 16);
    \define('SIGCLD', 17);

    /**
     * The SIGCHLD signal is sent to a process when a child process terminates, is interrupted,
     * or resumes after being interrupted.
     */
    \define('SIGCHLD', 17);

    /**
     * The SIGCONT signal instructs the operating system to continue (restart) a process previously paused by the
     * SIGSTOP or SIGTSTP signal.
     */
    \define('SIGCONT', 18);

    /**
     * The SIGSTOP signal instructs the operating system to stop a process for later resumption.
     */
    \define('SIGSTOP', 19);

    /**
     * The SIGTSTP signal is sent to a process by its controlling terminal to request it to stop (terminal stop).
     */
    \define('SIGTSTP', 20);

    /**
     * The SIGTTIN signal is sent to a process when it attempts to read in from the tty while in the background.
     */
    \define('SIGTTIN', 21);

    /**
     * The SIGTTOU signal is sent to a process when it attempts to write out from the tty while in the background.
     */
    \define('SIGTTOU', 22);

    /**
     * The SIGURG signal is sent to a process when a socket has urgent or out-of-band data available to read.
     */
    \define('SIGURG', 23);

    /**
     * The SIGXCPU signal is sent to a process when it has used up the CPU for a duration that exceeds a certain
     * predetermined user-settable value.
     */
    \define('SIGXCPU', 24);

    /**
     * The SIGXFSZ signal is sent to a process when it grows a file larger than the maximum allowed size
     */
    \define('SIGXFSZ', 25);

    /**
     * The SIGVTALRM signal is sent to a process when the time limit specified in a call to a preceding alarm setting
     * function (such as setitimer) elapses.
     */
    \define('SIGVTALRM', 26);

    /**
     * The SIGPROF signal is sent to a process when the time limit specified in a call to a preceding alarm setting
     * function (such as setitimer) elapses.
     */
    \define('SIGPROF', 27);

    /**
     * The SIGWINCH signal is sent to a process when its controlling terminal changes its size (a window change).
     */
    \define('SIGWINCH', 28);

    /**
     * The SIGPOLL signal is sent when an event occurred on an explicitly watched file descriptor.
     */
    \define('SIGPOLL', 29);

    \define('SIGIO', 29);

    /**
     * The SIGPWR signal is sent to a process when the system experiences a power failure.
     */
    \define('SIGPWR', 30);

    /**
     * The SIGSYS signal is sent to a process when it passes a bad argument to a system call.
     */
    \define('SIGSYS', 31);

    \define('SIGBABY', 31);
}

if (!\function_exists('S_ISREG')) {
    function S_ISCHECK($m, int $bitmask): bool
    {
        if (\is_array($m))
            return isset($m['mode']) ? ($m['mode'] & \S_IFMT) == $bitmask : false;

        return \is_cdata($m) ? ($m->st_mode & \S_IFMT) == $bitmask : false;
    }

    /**
     * is directory?
     *
     * @param array|CData $m
     * @return boolean
     */
    function S_ISDIR($m): bool
    {
        return \S_ISCHECK($m, \S_IFDIR);
    }

    /**
     * is character device??
     *
     * @param array|CData $m
     * @return boolean
     */
    function S_ISCHR($m): bool
    {
        return \S_ISCHECK($m, \S_IFCHR);
    }

    /**
     * is block device?
     *
     * @param array|CData $m
     * @return boolean
     */
    function S_ISBLK($m): bool
    {
        return \S_ISCHECK($m, \S_IFBLK);
    }

    /**
     * is FIFO (named pipe)?
     *
     * @param array|CData $m
     * @return boolean
     */
    function S_ISFIFO($m): bool
    {
        return \S_ISCHECK($m, \S_IFIFO);
    }

    /**
     * is symbolic link?  (Not in POSIX.1-1996.)
     *
     * @param array|CData $m
     * @return boolean
     */
    function S_ISLNK($m): bool
    {
        return \S_ISCHECK($m, \S_IFLNK);
    }

    /**
     * is socket?  (Not in POSIX.1-1996.)
     *
     * @param array|CData $m
     * @return boolean
     */
    function S_ISSOCK($m): bool
    {
        return \S_ISCHECK($m, \S_IFSOCK);
    }

    /**
     * is it a regular file?
     *
     * @param array|CData $m
     * @return boolean
     */
    function S_ISREG($m): bool
    {
        return \S_ISCHECK($m, \S_IFREG);
    }
}
