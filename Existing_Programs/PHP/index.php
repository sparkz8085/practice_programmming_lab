<?php

$baseDir = __DIR__;

$allowedExtensions = [
    'php',
'py',
'python',
'java',
'c',
'cpp',
'cc',
'cxx',
'js',
'ts',
'go',
'rs',
'rb',
'pl',
'lua',
'kt',
'kts'
];

/*
 * | ------*--------------------------------------------------------------------
 * | Recursive file scanner
 * |--------------------------------------------------------------------------
 */

function getFilesRecursive(
    string $directory,
    string $relative = ''
): array {

    global $allowedExtensions;

    $result = [];

    $items =
    @scandir($directory);

    if (!$items) {
        return $result;
    }

    foreach ($items as $item) {

        if (
            $item === '.' ||
            $item === '..'
        ) {
            continue;
        }

        if (
            $item === 'runner.php'
        ) {
            continue;
        }

        $fullPath =
        $directory .
        DIRECTORY_SEPARATOR .
        $item;

        $relativePath =
        $relative === ''
        ? $item
        : $relative . '/' . $item;

        if (is_dir($fullPath)) {

            $result =
            array_merge(
                $result,
                getFilesRecursive(
                    $fullPath,
                    $relativePath
                )
            );

            continue;
        }

        if (!is_file($fullPath)) {
            continue;
        }

        $extension =
        strtolower(
            pathinfo(
                $item,
                PATHINFO_EXTENSION
            )
        );

        if (
            !in_array(
                $extension,
                $allowedExtensions,
                true
            )
        ) {
            continue;
        }

        $result[] = [
            'name' =>
            $item,

            'path' =>
            $relativePath,

            'full' =>
            $fullPath,

            'extension' =>
            $extension,

            'size' =>
            filesize($fullPath),

            'modified' =>
            filemtime($fullPath)
        ];
    }

    return $result;
}

/*
 * | ------*--------------------------------------------------------------------
 * | Find file
 * |--------------------------------------------------------------------------
 */

function findFile(
    string $relativePath
): ?array {

    global $baseDir;
    global $allowedExtensions;

    $relativePath =
    str_replace(
        ['\\', "\0"],
        ['/', ''],
        $relativePath
    );

    $relativePath =
    ltrim(
        $relativePath,
        '/'
    );

    $fullPath =
    realpath(
        $baseDir .
        '/' .
        $relativePath
    );

    $realBase =
    realpath(
        $baseDir
    );

    if (
        !$fullPath ||
        !$realBase
    ) {
        return null;
    }

    if (
        $fullPath !== $realBase &&
        !str_starts_with(
            $fullPath,
            $realBase .
            DIRECTORY_SEPARATOR
        )
    ) {
        return null;
    }

    if (!is_file($fullPath)) {
        return null;
    }

    $extension =
    strtolower(
        pathinfo(
            $fullPath,
            PATHINFO_EXTENSION
        )
    );

    if (
        !in_array(
            $extension,
            $allowedExtensions,
            true
        )
    ) {
        return null;
    }

    return [
        'name' =>
        basename($fullPath),

        'path' =>
        $relativePath,

        'full' =>
        $fullPath,

        'extension' =>
        $extension,

        'size' =>
        filesize($fullPath),

        'modified' =>
        filemtime($fullPath)
    ];
}

/*
 * | ------*--------------------------------------------------------------------
 * | API
 * |--------------------------------------------------------------------------
 */

if (isset($_GET['api'])) {

    header(
        'Content-Type: application/json; charset=utf-8'
    );

    $api =
    $_GET['api'];

    /*
     *     | --*------------------------------------------------------------------------
     *     | SOURCE
     *     |--------------------------------------------------------------------------
     */

    if (
        $api === 'source'
    ) {

        $file =
        findFile(
            $_GET['file'] ?? ''
        );

        if (!$file) {

            http_response_code(404);

            echo json_encode([
                'success' => false,
                'message' =>
                'File not found.'
            ]);

            exit;
        }

        $source =
        @file_get_contents(
            $file['full']
        );

        echo json_encode([
            'success' => true,
            'file' =>
            $file['path'],
            'extension' =>
            $file['extension'],
            'source' =>
            $source === false
            ? ''
            : $source
        ]);

        exit;
    }

    /*
     *     | --*------------------------------------------------------------------------
     *     | START
     *     |--------------------------------------------------------------------------
     */

    if (
        $api === 'start'
    ) {

        $file =
        findFile(
            $_POST['file'] ?? ''
        );

        if (!$file) {

            http_response_code(404);

            echo json_encode([
                'success' => false,
                'message' =>
                'File not found.'
            ]);

            exit;
        }

        $session =
        bin2hex(
            random_bytes(16)
        );

        $runtimeRoot =
        sys_get_temp_dir() .
        '/practice_prog_runner';

                $sessionDir =
                $runtimeRoot .
                '/' .
                $session;

                @mkdir(
                    $sessionDir,
                    0777,
                    true
                );

                file_put_contents(
                    $sessionDir .
                    '/input.txt',
                    ''
                );

                file_put_contents(
                    $sessionDir .
                    '/output.txt',
                    ''
                );

                file_put_contents(
                    $sessionDir .
                    '/error.txt',
                    ''
                );

                file_put_contents(
                    $sessionDir .
                    '/status.json',
                    json_encode([
                        'state' =>
                        'starting',
                        'message' =>
                        'Starting program...'
                    ])
                );

                $php =
                '/opt/lampp/bin/php';

                        $runner =
                        __DIR__ .
                        '/runner.php';

                $command =
                'nohup ' .
                escapeshellarg($php) .
                ' ' .
                escapeshellarg($runner) .
                ' ' .
                escapeshellarg($session) .
                ' ' .
                escapeshellarg($file['full']) .
                ' ' .
                escapeshellarg($file['extension']) .
                ' > /dev/null 2>&1 &';

                exec($command);

                echo json_encode([
                    'success' => true,
                    'session' =>
                    $session,
                    'file' =>
                    $file['path']
                ]);

                exit;
    }

    /*
     *     | --*------------------------------------------------------------------------
     *     | STATUS
     *     |--------------------------------------------------------------------------
     */

    if (
        $api === 'status'
    ) {

        $session =
        preg_replace(
            '/[^a-zA-Z0-9_-]/',
            '',
            $_GET['session'] ?? ''
        );

        if ($session === '') {

            echo json_encode([
                'success' => false,
                'message' =>
                'Invalid session.'
            ]);

            exit;
        }

        $sessionDir =
        sys_get_temp_dir() .
        '/practice_prog_runner/' .
        $session;

        $statusFile =
        $sessionDir .
        '/status.json';

            $outputFile =
            $sessionDir .
            '/output.txt';

        $errorFile =
        $sessionDir .
        '/error.txt';

            $status = [
                'state' =>
                'unknown',

                'message' =>
                'No status available.'
            ];

            if (
                is_file($statusFile)
            ) {

                $statusData =
                @file_get_contents(
                    $statusFile
                );

                $decoded =
                json_decode(
                    (string)$statusData,
                            true
                );

                if (
                    is_array($decoded)
                ) {
                    $status =
                    $decoded;
                }
            }

            $output =
            is_file($outputFile)
            ? @file_get_contents(
                $outputFile
            )
            : '';

            $error =
            is_file($errorFile)
            ? @file_get_contents(
                $errorFile
            )
            : '';

            echo json_encode([
                'success' =>
                true,

                'status' =>
                $status,

                'output' =>
                $output === false
                ? ''
                : $output,

                'error' =>
                $error === false
                ? ''
                : $error
            ]);

            exit;
    }

    /*
     *     | --*------------------------------------------------------------------------
     *     | INPUT
     *     |--------------------------------------------------------------------------
     */

    if (
        $api === 'input'
    ) {

        $session =
        preg_replace(
            '/[^a-zA-Z0-9_-]/',
            '',
            $_POST['session'] ?? ''
        );

        if ($session === '') {

            echo json_encode([
                'success' => false,
                'message' =>
                'Invalid session.'
            ]);

            exit;
        }

        $sessionDir =
        sys_get_temp_dir() .
        '/practice_prog_runner/' .
        $session;

        if (!is_dir($sessionDir)) {

            echo json_encode([
                'success' => false,
                'message' =>
                'Session not found.'
            ]);

            exit;
        }

        $input =
        $_POST['input'] ?? '';

        /*
         * |--------------------------------------------------------------------------
         * | Important:
         * | Always send Enter.
         * |--------------------------------------------------------------------------
         */

        $input .= "\n";

        file_put_contents(
            $sessionDir .
            '/input.txt',
            $input,
            FILE_APPEND | LOCK_EX
        );

        echo json_encode([
            'success' => true
        ]);

        exit;
    }

    /*
     *     | --*------------------------------------------------------------------------
     *     | STOP
     *     |--------------------------------------------------------------------------
     */

    if (
        $api === 'stop'
    ) {

        $session =
        preg_replace(
            '/[^a-zA-Z0-9_-]/',
            '',
            $_POST['session'] ?? ''
        );

        if ($session === '') {

            echo json_encode([
                'success' => false,
                'message' =>
                'Invalid session.'
            ]);

            exit;
        }

        $sessionDir =
        sys_get_temp_dir() .
        '/practice_prog_runner/' .
        $session;

        if (!is_dir($sessionDir)) {

            echo json_encode([
                'success' => false,
                'message' =>
                'Session not found.'
            ]);

            exit;
        }

        file_put_contents(
            $sessionDir .
            '/stop',
            '1'
        );

        echo json_encode([
            'success' => true
        ]);

        exit;
    }

    echo json_encode([
        'success' => false,
        'message' =>
        'Unknown API.'
    ]);

    exit;
}

/*
 * | ------*--------------------------------------------------------------------
 * | Files
 * |--------------------------------------------------------------------------
 */

$files =
getFilesRecursive(
    $baseDir
);

usort(
    $files,
    function ($a, $b) {

        return strcasecmp(
            $a['path'],
            $b['path']
        );
    }
);

?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1.0"
>

<title>
Practice Programming Lab
</title>

<style>

* {
    box-sizing: border-box;
}

body {
    margin: 0;

    font-family:
    Inter,
    system-ui,
    -apple-system,
    BlinkMacSystemFont,
    "Segoe UI",
    sans-serif;

    background: #0b0f14;

    color: #e8edf2;
}

header {
    padding: 22px 28px;

    border-bottom:
    1px solid #202833;

    background: #10151c;
}

header h1 {
    margin: 0;
    font-size: 23px;
}

header p {
    margin: 6px 0 0;

    color: #8d99a8;

    font-size: 14px;
}

.layout {
    display: grid;

    grid-template-columns:
    300px 1fr;

    min-height:
    calc(100vh - 82px);
}

.sidebar {
    border-right:
    1px solid #202833;

    background: #0e1319;

    padding: 18px;

    overflow-y: auto;
}

.sidebar h2 {
    font-size: 14px;

    color: #8d99a8;

    margin:
    0 0 14px;
}

.file {
    padding:
    11px 12px;

    border-radius: 8px;

    cursor: pointer;

    margin-bottom: 5px;

    transition: 0.15s;
}

.file:hover {
    background: #18202a;
}

.file.active {
    background: #1d2935;
}

.file-name {
    font-size: 14px;
}

.file-path {
    color: #778493;

    font-size: 11px;

    margin-top: 3px;

    word-break: break-all;
}

.main {
    padding: 20px;

    min-width: 0;
}

.toolbar {
    display: flex;

    align-items: center;

    gap: 10px;

    margin-bottom: 15px;
}

.selected-file {
    flex: 1;

    padding:
    11px 14px;

    background: #111820;

    border:
    1px solid #242e39;

    border-radius: 8px;

    color: #b9c4d0;
}

button {
    border: 0;

    border-radius: 8px;

    padding:
    11px 18px;

    cursor: pointer;

    font-weight: 600;
}

.run {
    background: #35c979;

    color: #06120b;
}

.stop {
    background: #e85d5d;

    color: white;
}

button:disabled {
    opacity: 0.45;

    cursor: not-allowed;
}

.panels {
    display: grid;

    grid-template-columns:
    1fr 1fr;

    gap: 15px;
}

.panel {
    background: #0f151c;

    border:
    1px solid #222c37;

    border-radius: 10px;

    overflow: hidden;
}

.panel-title {
    padding:
    10px 13px;

    border-bottom:
    1px solid #222c37;

    color: #9aa7b5;

    font-size: 13px;
}

pre {
    margin: 0;

    padding: 16px;

    min-height: 330px;

    max-height: 550px;

    overflow: auto;

    font-family:
    "JetBrains Mono",
    "Fira Code",
    monospace;

    font-size: 13px;

    line-height: 1.55;

    white-space: pre-wrap;

    word-break: break-word;
}

.console-panel {
    margin-top: 15px;
}

.console {
    background: #050709;

    min-height: 330px;

    max-height: 500px;

    overflow-y: auto;

    padding: 15px;

    font-family:
    "JetBrains Mono",
    "Fira Code",
    monospace;

    font-size: 14px;

    line-height: 1.55;

    white-space: pre-wrap;

    word-break: break-word;
}

.console-input-row {
    display: flex;

    border-top:
    1px solid #202832;

    background: #0b1016;
}

.console-input {
    flex: 1;

    background: transparent;

    border: 0;

    outline: none;

    color: #e8edf2;

    padding:
    13px 15px;

    font-family:
    "JetBrains Mono",
    "Fira Code",
    monospace;

    font-size: 14px;
}

.console-input::placeholder {
    color: #596572;
}

.status {
    margin-top: 12px;

    padding:
    10px 13px;

    border-radius: 8px;

    background: #111820;

    color: #9eabb9;

    font-size: 13px;
}

.error-box {
    margin-top: 15px;

    border:
    1px solid #633535;

    background: #1c1010;

    border-radius: 9px;

    overflow: hidden;
}

.error-title {
    padding:
    10px 13px;

    color: #ff9c9c;

    border-bottom:
    1px solid #633535;
}

.error-content {
    padding: 14px;

    white-space: pre-wrap;

    font-family: monospace;

    color: #e8caca;

    font-size: 13px;
}

.empty {
    color: #6f7b88;

    padding: 20px;

    text-align: center;
}

@media (max-width: 900px) {

    .layout {
        grid-template-columns: 1fr;
    }

    .sidebar {
        border-right: 0;

        border-bottom:
        1px solid #202833;

        max-height: 260px;
    }

    .panels {
        grid-template-columns: 1fr;
    }

}

</style>

</head>

<body>

<header>

<h1>
Practice Programming Lab
</h1>

<p>
Multi-language interactive programming environment
</p>

</header>

<div class="layout">

<aside class="sidebar">

<h2>
PROGRAM FILES
</h2>

<div id="fileList">

<?php if (empty($files)): ?>

<div class="empty">
No supported source files found.
</div>

<?php else: ?>

<?php foreach ($files as $file): ?>

<div
class="file"
data-file="<?= htmlspecialchars($file['path']) ?>"
onclick="selectFile(this)"
>

<div class="file-name">
<?= htmlspecialchars($file['name']) ?>
</div>

<div class="file-path">
<?= htmlspecialchars($file['path']) ?>
</div>

</div>

<?php endforeach; ?>

<?php endif; ?>

</div>

</aside>

<main class="main">

<div class="toolbar">

<div
class="selected-file"
id="selectedFile"
>
No file selected
</div>

<button
class="run"
id="runButton"
onclick="runProgram()"
disabled
>
▶ Run
</button>

<button
class="stop"
id="stopButton"
onclick="stopProgram()"
disabled
>
■ Stop
</button>

</div>

<div class="panels">

<div class="panel">

<div class="panel-title">
SOURCE CODE
</div>

<pre id="sourceCode">
Select a file.
</pre>

</div>

<div class="panel">

<div class="panel-title">
PROGRAM OUTPUT
</div>

<pre id="programOutput"></pre>

</div>

</div>

<div class="panel console-panel">

<div class="panel-title">
INTERACTIVE TERMINAL
</div>

<div
class="console"
id="console"
></div>

<div class="console-input-row">

<input
id="consoleInput"
class="console-input"
type="text"
autocomplete="off"
placeholder="Type input and press Enter..."
disabled
>

</div>

</div>

<div
class="status"
id="status"
>
Ready.
</div>

<div
class="error-box"
id="errorBox"
style="display:none"
>

<div class="error-title">
⚠ Program Error
</div>

<div
class="error-content"
id="errorContent"
></div>

</div>

</main>

</div>

<script>

/*
 * | ------*--------------------------------------------------------------------
 * | State
 * |--------------------------------------------------------------------------
 */

let selectedFile = null;
let currentSession = null;
let pollingTimer = null;

/*
 * | ------*--------------------------------------------------------------------
 * | Terminal state
 * |--------------------------------------------------------------------------
 * |
 * | This is the important part.
 * |
 * | The dashboard keeps track of the program output and the line where
 * | the user is currently typing.
 * |
 * |--------------------------------------------------------------------------
 */

let terminalText = '';
let serverOutput = '';
let waitingForInput = false;

/*
 * | ------*--------------------------------------------------------------------
 * | Select file
 * |--------------------------------------------------------------------------
 */

async function selectFile(element)
{
    document
    .querySelectorAll('.file')
    .forEach(
        el =>
        el.classList.remove('active')
    );

    element.classList.add('active');

    selectedFile =
    element.dataset.file;

    document.getElementById(
        'selectedFile'
    ).textContent =
    selectedFile;

    document.getElementById(
        'runButton'
    ).disabled = false;

    await loadSource(
        selectedFile
    );

    resetConsole();

    document.getElementById(
        'status'
    ).textContent =
    'Ready.';
}

/*
 * | ------*--------------------------------------------------------------------
 * | Load source
 * |--------------------------------------------------------------------------
 */

async function loadSource(file)
{
    const response =
    await fetch(
        '?api=source&file=' +
    encodeURIComponent(file)
    );

    const data =
    await response.json();

    if (!data.success) {

        document.getElementById(
            'sourceCode'
        ).textContent =
        'Could not load source code.';

        return;
    }

    document.getElementById(
        'sourceCode'
    ).textContent =
    data.source;
}

/*
 * | ------*--------------------------------------------------------------------
 * | Reset terminal
 * |--------------------------------------------------------------------------
 */

function resetConsole()
{
    terminalText = '';
    serverOutput = '';
    waitingForInput = false;

    document.getElementById(
        'console'
    ).textContent = '';

    document.getElementById(
        'programOutput'
    ).textContent = '';

    document.getElementById(
        'consoleInput'
    ).value = '';

    document.getElementById(
        'consoleInput'
    ).disabled = true;

    document.getElementById(
        'errorBox'
    ).style.display =
    'none';
}

/*
 * | ------*--------------------------------------------------------------------
 * | Run
 * |--------------------------------------------------------------------------
 */

async function runProgram()
{
    if (!selectedFile) {
        return;
    }

    if (currentSession) {
        return;
    }

    resetConsole();

    document.getElementById(
        'status'
    ).textContent =
    'Checking code...';

    document.getElementById(
        'runButton'
    ).disabled = true;

    document.getElementById(
        'stopButton'
    ).disabled = false;

    const form =
    new FormData();

    form.append(
        'file',
        selectedFile
    );

    try {

        const response =
        await fetch(
            '?api=start',
            {
                method: 'POST',
                body: form
            }
        );

        const data =
        await response.json();

        if (!data.success) {

            showError(
                data.message ||
                'Could not start program.'
            );

            resetRunner();

            return;
        }

        currentSession =
        data.session;

        startPolling();

    } catch (error) {

        showError(
            'Could not communicate with the runner.'
        );

        resetRunner();
    }
}

/*
 * | ------*--------------------------------------------------------------------
 * | Polling
 * |--------------------------------------------------------------------------
 */

function startPolling()
{
    if (pollingTimer) {

        clearInterval(
            pollingTimer
        );
    }

    pollingTimer =
    setInterval(
        pollStatus,
        100
    );

    pollStatus();
}

/*
 * | ------*--------------------------------------------------------------------
 * | Poll status
 * |--------------------------------------------------------------------------
 */

async function pollStatus()
{
    if (!currentSession) {
        return;
    }

    try {

        const response =
        await fetch(
            '?api=status&session=' +
        encodeURIComponent(
            currentSession
        ),
        {
            cache: 'no-store'
        }
        );

        const data =
        await response.json();

        if (!data.success) {
            return;
        }

        /*
         * |--------------------------------------------------------------------------
         * | Program output
         * |--------------------------------------------------------------------------
         */

        const newOutput =
        data.output || '';

        updateTerminal(newOutput);

        document.getElementById(
            'programOutput'
        ).textContent = terminalText;

        /*
         * |--------------------------------------------------------------------------
         * | Status
         * |--------------------------------------------------------------------------
         */

        if (data.status) {

            document.getElementById(
                'status'
            ).textContent =
            data.status.message ||
            data.status.state ||
            'Running...';
        }

        /*
         * |--------------------------------------------------------------------------
         * | Error
         * |--------------------------------------------------------------------------
         */

        if (data.error) {

            showError(
                data.error
            );
        }

        /*
         * |--------------------------------------------------------------------------
         * | Finished
         * |--------------------------------------------------------------------------
         */

        const state =
        data.status
        ? data.status.state
        : '';

        if (
            state === 'finished' ||
            state === 'compile_error' ||
            state === 'runtime_error' ||
            state === 'stopped' ||
            state === 'timeout' ||
            state === 'error'
        ) {

            document.getElementById(
                'consoleInput'
            ).disabled = true;

            document.getElementById(
                'stopButton'
            ).disabled = true;

            document.getElementById(
                'runButton'
            ).disabled =
            !selectedFile;

            currentSession = null;

            if (pollingTimer) {

                clearInterval(
                    pollingTimer
                );

                pollingTimer = null;
            }
        }

        /*
         * |--------------------------------------------------------------------------
         * | Running
         * |--------------------------------------------------------------------------
         */

        else if (
            state === 'running'
        ) {

            document.getElementById(
                'consoleInput'
            ).disabled = false;

            document.getElementById(
                'consoleInput'
            ).focus();
        }

    } catch (error) {

        console.error(error);
    }
}

/*
 * | ------*--------------------------------------------------------------------
 * | Terminal renderer
 * |--------------------------------------------------------------------------
 * |
 * | IMPORTANT:
 * |
 * | Suppose program prints:
 * |
 * | Enter a number:
 * |
 * | User enters:
 * |
 * | 2
 * |
 * | We want:
 * |
 * | Enter a number: 2
 * |
 * | NOT:
 * |
 * | Enter a number:
 * | 2
 * |
 * |--------------------------------------------------------------------------
 */

function updateTerminal(newOutput)
{
    const consoleBox = document.getElementById('console');

    // The runner's output file is append-only. Track it separately from
    // terminalText because terminalText also contains locally echoed input.
    if (newOutput === serverOutput) {
        return;
    }

    if (newOutput.startsWith(serverOutput)) {
        const addedOutput = newOutput.slice(serverOutput.length);
        serverOutput = newOutput;
        terminalText += addedOutput;
    } else {
        // A fresh or reset runner output stream.
        serverOutput = newOutput;
        terminalText = newOutput;
    }

    consoleBox.textContent = terminalText;
    consoleBox.scrollTop = consoleBox.scrollHeight;
}

/*
 * | ------*--------------------------------------------------------------------
 * | Send input
 * |--------------------------------------------------------------------------
 */

async function sendInput()
{
    if (!currentSession) {
        return;
    }

    const inputBox = document.getElementById('consoleInput');
    const value = inputBox.value;

    // Echo submitted input on its own line in the dashboard terminal.
    if (terminalText.length > 0 && !terminalText.endsWith('\n')) {
        terminalText += '\n';
    }
    terminalText += value + '\n';

    const consoleBox = document.getElementById('console');
    consoleBox.textContent = terminalText;
    consoleBox.scrollTop = consoleBox.scrollHeight;

    document.getElementById('programOutput').textContent = terminalText;
    inputBox.value = '';
    waitingForInput = true;

    const form = new FormData();
    form.append('session', currentSession);
    form.append('input', value);

    try {
        const response = await fetch('?api=input', {
            method: 'POST',
            body: form
        });
        const result = await response.json();

        if (!result.success) {
            showError(result.message || 'Could not send input to the program.');
        }
    } catch (error) {
        console.error(error);
        showError('Could not send input to the running program.');
    }
}

// The input field needs an explicit Enter handler to send text to the runner.
document.getElementById('consoleInput').addEventListener('keydown', function(event) {
    if (event.key === 'Enter') {
        event.preventDefault();
        sendInput();
    }
});

async function stopProgram()
{
    if (!currentSession) {
        return;
    }

    const form =
    new FormData();

    form.append(
        'session',
        currentSession
    );

    try {

        await fetch(
            '?api=stop',
            {
                method: 'POST',
                body: form
            }
        );

    } catch (error) {

        console.error(error);
    }
}

/*
 * | ------*--------------------------------------------------------------------
 * | Error
 * |--------------------------------------------------------------------------
 */

function showError(message)
{
    document.getElementById(
        'errorContent'
    ).textContent =
    message;

    document.getElementById(
        'errorBox'
    ).style.display =
    'block';
}

/*
 * | ------*--------------------------------------------------------------------
 * | Reset runner
 * |--------------------------------------------------------------------------
 */

function resetRunner()
{
    currentSession = null;

    if (pollingTimer) {

        clearInterval(
            pollingTimer
        );

        pollingTimer = null;
    }

    document.getElementById(
        'runButton'
    ).disabled =
    !selectedFile;

    document.getElementById(
        'stopButton'
    ).disabled = true;

    document.getElementById(
        'consoleInput'
    ).disabled = true;
}

/*
 * | ------*--------------------------------------------------------------------
 * | Invisible keyboard file search
 * |--------------------------------------------------------------------------
 */

let searchBuffer = '';

document.addEventListener(
    'keydown',
    function(event) {

        if (
            document.activeElement ===
            document.getElementById(
                'consoleInput'
            )
        ) {
            return;
        }

        if (
            event.key ===
            'Escape'
        ) {

            searchBuffer = '';

filterFiles();

return;
        }

        if (
            event.key ===
            'Backspace'
        ) {

            event.preventDefault();

            searchBuffer =
            searchBuffer.slice(
                0,
                -1
            );

            filterFiles();

            return;
        }

        if (
            event.key.length === 1 &&
            !event.ctrlKey &&
            !event.altKey &&
            !event.metaKey
        ) {

            searchBuffer +=
            event.key;

            filterFiles();
        }

    }
);

/*
 * | ------*--------------------------------------------------------------------
 * | File filter
 * |--------------------------------------------------------------------------
 */

function filterFiles()
{
    const query =
    searchBuffer.toLowerCase();

    document
    .querySelectorAll('.file')
    .forEach(
        element => {

            const text =
            element.textContent
            .toLowerCase();

            element.style.display =
            text.includes(query)
            ? ''
    : 'none';
        }
    );
}

</script>

</body>

</html>
