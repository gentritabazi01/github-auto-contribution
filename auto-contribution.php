<?php

// General variables
$beginDate = '2017-01-05';
$endDate = '2017-01-10';
$begin = new DateTime($beginDate);
$end = new DateTime($endDate);
$interval = DateInterval::createFromDateString('1 day');
$period = new DatePeriod($begin, $interval, $end);
$fileName = 'test-file.md';
$setOrExport = 'set';

// Loop between two dates.
foreach ($period as $dt) {
    $d = $dt->format('Y-m-d');

    // Random contributions.
    for ($i = 0; $i < rand(1, 35); $i++) {
        // Write to file,
        $myfile = fopen($fileName, 'w') or die('Unable to open file!');
        fwrite($myfile, $d.' - '.$i);
        fclose($myfile);

        // Commit changes,
        exec($setOrExport.' GIT_COMMITTER_DATE="'.$d.' 12:00:00"');
        exec($setOrExport.' GIT_AUTHOR_DATE="'.$d.' 12:00:00"');
        exec('git add '.$fileName.' -f');
        exec('git commit --date="'.$d.' 12:00:00" -m "commited on '.$d.'"');
    }
}

// Final commands.
exec('git push origin master');
exec('git commit -am "cleanup"');
exec('git push origin master');
