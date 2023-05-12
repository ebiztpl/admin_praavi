<?php

namespace App\Services\Attendance;

use App\Concerns\ItemImport;
use App\Imports\Attendance\TimesheetImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class TimesheetImportService
{
    use ItemImport;

    public function import(Request $request)
    {
        $this->deleteLogFile('timesheet');

        $this->validateFile($request);

        Excel::import(new TimesheetImport, $request->file('file'));

        $this->reportError('timesheet');
    }
}
