<?php

/*
|--------------------------------------------------------------------------
| Practice-Prog Runner
|--------------------------------------------------------------------------
| CLI-only background runner.
|--------------------------------------------------------------------------
*/

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit("Internal runner only.\n");
}

if ($argc < 4) {
    exit("Invalid runner arguments.\n");
}

$session   = $argv[1];
$sourceFile = $argv[2];
$extension = strtolower($argv[3]);

$runtimeRoot = sys_get_temp_dir() . '/practice_prog_runner';

$session = preg_replace(
    '/[^a-zA-Z0-9_-]/',
    '',
    $session
);

$sessionDir = $runtimeRoot . '/' . $session;

@mkdir($runtimeRoot, 0777, true);
@mkdir($sessionDir, 0777, true);

$statusFile = $sessionDir . '/status.json';
$outputFile = $sessionDir . '/output.txt';
$errorFile  = $sessionDir . '/error.txt';
$inputFile  = $sessionDir . '/input.txt';
$stopFile   = $sessionDir . '/stop';

file_put_contents($outputFile, '');
file_put_contents($errorFile, '');
file_put_contents($inputFile, '');

function writeStatus(array $data): void
{
    global $statusFile;

    file_put_contents(
        $statusFile,
        json_encode(
            $data,
            JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
        ),
        LOCK_EX
    );
}

function appendOutput(string $text): void
{
    global $outputFile;

    if ($text === '') {
        return;
    }

    file_put_contents(
        $outputFile,
        $text,
        FILE_APPEND | LOCK_EX
    );
}

function appendError(string $text): void
{
    global $errorFile;

    if ($text === '') {
        return;
    }

    file_put_contents(
        $errorFile,
        $text,
        FILE_APPEND | LOCK_EX
    );
}

function commandExists(string $command): bool
{
    $result = shell_exec(
        'command -v ' .
        escapeshellarg($command) .
        ' 2>/dev/null'
    );

    return !empty(trim((string)$result));
}

function friendlyError(string $raw): string
{
    $text = strtolower($raw);

    if (
        str_contains($text, 'nosuchelementexception')
    ) {
        return
            "The program tried to read input, but enough input was not available.\n\n" .
            "Check how many values your program expects.";
    }

    if (
        str_contains($text, 'inputmismatchexception')
    ) {
        return
            "The program expected a different type of input.\n\n" .
            "For example, it may expect a number but received text.";
    }

    if (
        str_contains($text, 'arrayindexoutofboundsexception') ||
        str_contains($text, 'index out of bounds')
    ) {
        return
            "The program tried to access an array position that does not exist.\n\n" .
            "Check your array index and loop limits.";
    }

    if (
        str_contains($text, 'nullpointerexception')
    ) {
        return
            "The program tried to use an empty or missing object.\n\n" .
            "Check your variable before using it.";
    }

    if (
        str_contains($text, 'syntaxerror') ||
        str_contains($text, 'parse error') ||
        str_contains($text, 'unexpected token')
    ) {
        return
            "There is a syntax error in the code.\n\n" .
            "Check brackets, quotes, semicolons and the reported line.";
    }

    if (
        str_contains($text, 'nameerror')
    ) {
        return
            "The program is using a variable or name that has not been defined.\n\n" .
            "Check the variable name and where it is declared.";
    }

    if (
        str_contains($text, 'filenotfounderror')
    ) {
        return
            "The program tried to open a file that could not be found.\n\n" .
            "Check the filename and path.";
    }

    if (
        str_contains($text, 'cannot read properties of undefined') ||
        str_contains($text, 'cannot read properties of null')
    ) {
        return
            "The program tried to use a value that does not exist.\n\n" .
            "Check the variable before accessing it.";
    }

    if (
        str_contains($text, 'error:')
    ) {
        return
            "The compiler found an error in your code.\n\n" .
            "Check the reported file and line number.";
    }

    return
        "The program stopped because an error occurred.\n\n" .
        "Check the technical details below.";
}

/*
|--------------------------------------------------------------------------
| Validate source
|--------------------------------------------------------------------------
*/

$realSource = realpath($sourceFile);

if (!$realSource || !is_file($realSource)) {

    appendError(
        "❌ ERROR\n\n" .
        "Source file could not be found.\n"
    );

    writeStatus([
        'state' => 'error',
        'message' => 'Source file could not be found.'
    ]);

    exit;
}

$baseDir = realpath(dirname(__DIR__));

/*
|--------------------------------------------------------------------------
| Temporary working directory
|--------------------------------------------------------------------------
*/

$workDir = $sessionDir . '/work';

@mkdir($workDir, 0777, true);

$fileName = basename($realSource);
$workFile = $workDir . '/' . $fileName;

if (!copy($realSource, $workFile)) {

    appendError(
        "❌ ERROR\n\n" .
        "Could not prepare source file.\n"
    );

    writeStatus([
        'state' => 'error',
        'message' => 'Could not prepare source file.'
    ]);

    exit;
}

/*
|--------------------------------------------------------------------------
| Compilation / syntax checking
|--------------------------------------------------------------------------
*/

writeStatus([
    'state' => 'checking',
    'message' => 'Checking code...'
]);

$actualCommand = null;
$compileError = '';

/*
|--------------------------------------------------------------------------
| PHP
|--------------------------------------------------------------------------
*/

if ($extension === 'php') {

    $cmd =
        '/opt/lampp/bin/php -l ' .
        escapeshellarg($workFile) .
        ' 2>&1';

    exec($cmd, $lines, $code);

    $result = implode("\n", $lines);

    if ($code !== 0) {
        $compileError = $result;
    }

    $actualCommand =
        '/opt/lampp/bin/php -d output_buffering=0 ' .
        escapeshellarg($workFile);
}

/*
|--------------------------------------------------------------------------
| Python
|--------------------------------------------------------------------------
*/

elseif (
    $extension === 'py' ||
    $extension === 'python'
) {

    $cmd =
        'python3 -m py_compile ' .
        escapeshellarg($workFile) .
        ' 2>&1';

    exec($cmd, $lines, $code);

    $result = implode("\n", $lines);

    if ($code !== 0) {
        $compileError = $result;
    }

    $actualCommand =
        'python3 -u ' .
        escapeshellarg($workFile);
}

/*
|--------------------------------------------------------------------------
| Java
|--------------------------------------------------------------------------
*/

elseif ($extension === 'java') {

    $cmd =
        'cd ' .
        escapeshellarg($workDir) .
        ' && javac ' .
        escapeshellarg($fileName) .
        ' 2>&1';

    exec($cmd, $lines, $code);

    $result = implode("\n", $lines);

    if ($code !== 0) {
        $compileError = $result;
    }

    $className =
        pathinfo(
            $fileName,
            PATHINFO_FILENAME
        );

    $actualCommand =
        'cd ' .
        escapeshellarg($workDir) .
        ' && java ' .
        escapeshellarg($className);
}

/*
|--------------------------------------------------------------------------
| C
|--------------------------------------------------------------------------
*/

elseif ($extension === 'c') {

    $binary =
        $workDir . '/program';

    $cmd =
        'gcc ' .
        escapeshellarg($workFile) .
        ' -o ' .
        escapeshellarg($binary) .
        ' 2>&1';

    exec($cmd, $lines, $code);

    $result = implode("\n", $lines);

    if ($code !== 0) {
        $compileError = $result;
    }

    $actualCommand =
        escapeshellarg($binary);
}

/*
|--------------------------------------------------------------------------
| C++
|--------------------------------------------------------------------------
*/

elseif (
    $extension === 'cpp' ||
    $extension === 'cc' ||
    $extension === 'cxx'
) {

    $binary =
        $workDir . '/program';

    $cmd =
        'g++ ' .
        escapeshellarg($workFile) .
        ' -o ' .
        escapeshellarg($binary) .
        ' 2>&1';

    exec($cmd, $lines, $code);

    $result = implode("\n", $lines);

    if ($code !== 0) {
        $compileError = $result;
    }

    $actualCommand =
        escapeshellarg($binary);
}

/*
|--------------------------------------------------------------------------
| JavaScript
|--------------------------------------------------------------------------
*/

elseif ($extension === 'js') {

    $cmd =
        'node --check ' .
        escapeshellarg($workFile) .
        ' 2>&1';

    exec($cmd, $lines, $code);

    $result = implode("\n", $lines);

    if ($code !== 0) {
        $compileError = $result;
    }

    $actualCommand =
        'node ' .
        escapeshellarg($workFile);
}

/*
|--------------------------------------------------------------------------
| TypeScript
|--------------------------------------------------------------------------
*/

elseif ($extension === 'ts') {

    if (!commandExists('npx')) {
        $compileError =
            "npx is not installed.";
    }

    $actualCommand =
        'npx --yes tsx ' .
        escapeshellarg($workFile);
}

/*
|--------------------------------------------------------------------------
| Go
|--------------------------------------------------------------------------
*/

elseif ($extension === 'go') {

    $binary =
        $workDir . '/program';

    $cmd =
        'go build -o ' .
        escapeshellarg($binary) .
        ' ' .
        escapeshellarg($workFile) .
        ' 2>&1';

    exec($cmd, $lines, $code);

    $result = implode("\n", $lines);

    if ($code !== 0) {
        $compileError = $result;
    }

    $actualCommand =
        escapeshellarg($binary);
}

/*
|--------------------------------------------------------------------------
| Rust
|--------------------------------------------------------------------------
*/

elseif ($extension === 'rs') {

    $binary =
        $workDir . '/program';

    $cmd =
        'rustc ' .
        escapeshellarg($workFile) .
        ' -o ' .
        escapeshellarg($binary) .
        ' 2>&1';

    exec($cmd, $lines, $code);

    $result = implode("\n", $lines);

    if ($code !== 0) {
        $compileError = $result;
    }

    $actualCommand =
        escapeshellarg($binary);
}

/*
|--------------------------------------------------------------------------
| Ruby
|--------------------------------------------------------------------------
*/

elseif ($extension === 'rb') {

    $cmd =
        'ruby -c ' .
        escapeshellarg($workFile) .
        ' 2>&1';

    exec($cmd, $lines, $code);

    $result = implode("\n", $lines);

    if ($code !== 0) {
        $compileError = $result;
    }

    $actualCommand =
        'ruby ' .
        escapeshellarg($workFile);
}

/*
|--------------------------------------------------------------------------
| Perl
|--------------------------------------------------------------------------
*/

elseif ($extension === 'pl') {

    $cmd =
        'perl -c ' .
        escapeshellarg($workFile) .
        ' 2>&1';

    exec($cmd, $lines, $code);

    $result = implode("\n", $lines);

    if ($code !== 0) {
        $compileError = $result;
    }

    $actualCommand =
        'perl ' .
        escapeshellarg($workFile);
}

/*
|--------------------------------------------------------------------------
| Lua
|--------------------------------------------------------------------------
*/

elseif ($extension === 'lua') {

    $actualCommand =
        'lua ' .
        escapeshellarg($workFile);
}

/*
|--------------------------------------------------------------------------
| Kotlin
|--------------------------------------------------------------------------
*/

elseif (
    $extension === 'kt' ||
    $extension === 'kts'
) {

    $jar =
        $workDir . '/program.jar';

    $cmd =
        'kotlinc ' .
        escapeshellarg($workFile) .
        ' -include-runtime -d ' .
        escapeshellarg($jar) .
        ' 2>&1';

    exec($cmd, $lines, $code);

    $result = implode("\n", $lines);

    if ($code !== 0) {
        $compileError = $result;
    }

    $actualCommand =
        'java -jar ' .
        escapeshellarg($jar);
}

/*
|--------------------------------------------------------------------------
| Unsupported
|--------------------------------------------------------------------------
*/

else {

    $compileError =
        "This file type is not supported.";

}

/*
|--------------------------------------------------------------------------
| Compilation error
|--------------------------------------------------------------------------
*/

if ($compileError !== '') {

    $friendly =
        friendlyError($compileError);

    appendError(
        "❌ ERROR\n\n" .
        $friendly .
        "\n\n" .
        "--- Technical Details ---\n" .
        $compileError .
        "\n"
    );

    writeStatus([
        'state' => 'compile_error',
        'message' => $friendly
    ]);

    exit;
}

/*
|--------------------------------------------------------------------------
| Start actual program
|--------------------------------------------------------------------------
*/

$descriptors = [
    0 => ['pipe', 'r'],
    1 => ['pipe', 'w'],
    2 => ['pipe', 'w']
];

$process =
    proc_open(
        $actualCommand,
        $descriptors,
        $pipes,
        $workDir
    );

if (!is_resource($process)) {

    appendError(
        "❌ ERROR\n\n" .
        "The program could not be started.\n"
    );

    writeStatus([
        'state' => 'error',
        'message' => 'The program could not be started.'
    ]);

    exit;
}

/*
|--------------------------------------------------------------------------
| Non-blocking streams
|--------------------------------------------------------------------------
*/

stream_set_blocking(
    $pipes[0],
    false
);

stream_set_blocking(
    $pipes[1],
    false
);

stream_set_blocking(
    $pipes[2],
    false
);

$inputPosition = 0;
$startTime = time();

writeStatus([
    'state' => 'running',
    'message' => 'Program is running. Waiting for input/output...'
]);

/*
|--------------------------------------------------------------------------
| Interactive loop
|--------------------------------------------------------------------------
*/

while (true) {

    /*
    |--------------------------------------------------------------------------
    | Stop
    |--------------------------------------------------------------------------
    */

    if (file_exists($stopFile)) {

        @proc_terminate($process);

        appendOutput(
            "\n[Program stopped]\n"
        );

        writeStatus([
            'state' => 'stopped',
            'message' => 'Program stopped.'
        ]);

        break;
    }

    /*
    |--------------------------------------------------------------------------
    | Read browser input
    |--------------------------------------------------------------------------
    */

    $input =
        @file_get_contents($inputFile);

    if ($input === false) {
        $input = '';
    }

    if (
        strlen($input) >
        $inputPosition
    ) {

        $newInput =
            substr(
                $input,
                $inputPosition
            );

        /*
        |--------------------------------------------------------------------------
        | Send input directly to stdin
        |--------------------------------------------------------------------------
        */

        $remaining =
            $newInput;

        while (
            $remaining !== ''
        ) {

            $written =
                @fwrite(
                    $pipes[0],
                    $remaining
                );

            if (
                $written === false ||
                $written === 0
            ) {
                break;
            }

            $remaining =
                substr(
                    $remaining,
                    $written
                );
        }

        $inputPosition =
            strlen($input);
    }

    /*
    |--------------------------------------------------------------------------
    | Read program output
    |--------------------------------------------------------------------------
    */

    $stdout =
        @stream_get_contents(
            $pipes[1]
        );

    if (
        $stdout !== false &&
        $stdout !== ''
    ) {

        appendOutput(
            $stdout
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Read stderr
    |--------------------------------------------------------------------------
    */

    $stderr =
        @stream_get_contents(
            $pipes[2]
        );

    if (
        $stderr !== false &&
        $stderr !== ''
    ) {

        appendOutput(
            $stderr
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Check process
    |--------------------------------------------------------------------------
    */

    $processStatus =
        proc_get_status(
            $process
        );

    if (
        !$processStatus['running']
    ) {

        $remainingOutput =
            @stream_get_contents(
                $pipes[1]
            );

        if (
            $remainingOutput !== false &&
            $remainingOutput !== ''
        ) {

            appendOutput(
                $remainingOutput
            );
        }

        $remainingError =
            @stream_get_contents(
                $pipes[2]
            );

        if (
            $remainingError !== false &&
            $remainingError !== ''
        ) {

            appendOutput(
                $remainingError
            );
        }

        $exitCode =
            $processStatus['exitcode'];

        @fclose($pipes[0]);
        @fclose($pipes[1]);
        @fclose($pipes[2]);

        @proc_close($process);

        if ($exitCode === 0) {

            writeStatus([
                'state' => 'finished',
                'message' => 'Program finished successfully.',
                'exit_code' => 0
            ]);

        } else {

            $runtimeOutput =
                @file_get_contents(
                    $outputFile
                );

            $friendly =
                friendlyError(
                    (string)$runtimeOutput
                );

            appendError(
                "\n❌ PROGRAM ERROR\n\n" .
                $friendly .
                "\n\nExit code: " .
                $exitCode .
                "\n"
            );

            writeStatus([
                'state' => 'runtime_error',
                'message' => $friendly,
                'exit_code' => $exitCode
            ]);
        }

        break;
    }

    /*
    |--------------------------------------------------------------------------
    | 5 minute safety timeout
    |--------------------------------------------------------------------------
    */

    if (
        time() - $startTime >
        300
    ) {

        @proc_terminate(
            $process
        );

        appendError(
            "\n⚠ PROGRAM STOPPED\n\n" .
            "The program ran for more than 5 minutes.\n"
        );

        writeStatus([
            'state' => 'timeout',
            'message' =>
                'Program stopped after 5 minutes.'
        ]);

        break;
    }

    usleep(50000);
}

?>
