<?php
function dbExport($path = ROOT . "/backups/")
{
    require(ROOT . "/functions/db.php");
    require(ROOT . "/config.php");
    $sqldumpbinfilepath = ROOT . "/tools/mysqldump.exe";

    $dbpath = $path . "database.sql";
    $fpath = $path . "files.zip";
    $floca = ROOT . "/upload";
    exec("$sqldumpbinfilepath --user={$database["username"]} --password={$database["password"]} --host={$database["hostname"]} {$database["database"]} --result-file={$dbpath}", $output, $rcode);
    if ($rcode == 0) {
        // SQL WAS DUMPED!
        $zip = new ZipArchive;
        if ($zip->open($fpath, ZipArchive::CREATE) === TRUE) {
            $rootPath = $floca;
            // Add files to the zip file
            // Create recursive directory iterator
            /** @var SplFileInfo[] $files */
            $files = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($rootPath),
                RecursiveIteratorIterator::LEAVES_ONLY
            );
            foreach ($files as $name => $file) {
                // Skip directories (they would be added automatically)
                if (!$file->isDir()) {
                    // Get real and relative path for current file
                    $filePath = $file->getRealPath();
                    $relativePath = substr($filePath, strlen($rootPath) + 1);

                    // Add current file to archive
                    $zip->addFile($filePath, $relativePath);
                }
            }
            // Add random.txt file to zip and rename it to newfile.txt
            $zip->addFile($dbpath, 'database.sql');

            // All files are added, so close the zip file.
            $zip->close();
            mkdir($path.date("Y-m-d-hms"));
            rename($fpath, $path.date("Y-m-d-hms")."/backup.zip");
            unlink($path."database.sql");
        } else {
            return "FILE_ZIP_ERROR";
        }
    } else {
        return "SQL_DUMP_ERROR";
    }
}
function regenerateDatabase()
{
}
