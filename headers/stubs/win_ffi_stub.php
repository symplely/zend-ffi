<?php

interface FFI
{
    /**
     * Creates a thread to execute within the virtual address space of the calling process.
     *
     * - @link https://learn.microsoft.com/en-us/windows/win32/api/processthreadsapi/nf-processthreadsapi-createthread
     *
     * @param LPSECURITY_ATTRIBUTES $lpThreadAttributes
     * @param SIZE_T $dwStackSize
     * @param LPTHREAD_START_ROUTINE $lpStartAddress
     * @param LPVOID $lpParameter
     * @param DWORD $dwCreationFlags
     * @param LPDWORD $lpThreadId
     * @return HANDLE
     */
    public function CreateThread(
        ?LPSECURITY_ATTRIBUTES &$lpThreadAttributes,
        SIZE_T $dwStackSize,
        LPTHREAD_START_ROUTINE $lpStartAddress,
        ?LPVOID &$lpParameter,
        DWORD $dwCreationFlags,
        ?LPDWORD &$lpThreadId
    );

    /** @return DWORD */
    public function SuspendThread(HANDLE &$hThread);

    /** @return DWORD */
    public function ResumeThread(HANDLE &$hThread);

    /** @return DWORD */
    public function WaitForSingleObject(HANDLE &$hHandle, DWORD $dwMilliseconds);

    /** @return BOOL */
    public function TerminateThread(HANDLE &$hThread, DWORD $dwExitCode);

    /** @return BOOL */
    public function CloseHandle(HANDLE &$hObject);

    /** @return BOOL */
    public function GetExitCodeThread(HANDLE &$hThread, LPDWORD $lpExitCode);

    /** @return BOOL */
    public function GetThreadContext(HANDLE &$hThread, LPCONTEXT &$lpContext);

    /** @return DWORD */
    public function GetLastError();

    /** @return DWORD */
    public function GetProcessIdOfThread(HANDLE &$Thread);

    /** @return DWORD */
    public function GetThreadId(HANDLE &$Thread);

    /** @return DWORD */
    public function GetCurrentThreadId();

    /** @return HANDLE */
    public function GetCurrentThread();

    /** @return BOOL */
    public function SwitchToThread();

    /** @return void */
    public function Sleep(DWORD $dwMilliseconds);

    /** @return DWORD */
    public function SleepEx(DWORD $dwMilliseconds, BOOL $bAlertable);
}
