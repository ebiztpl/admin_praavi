<?php

namespace App\Actions\Payroll;

use App\Models\Payroll\SalaryStructure;
use Illuminate\Support\Collection;

class CalculatePayroll
{
    public function execute(int $employeeId, string $startDate, string $endDate, SalaryStructure $salaryStructure, Collection $attendanceTypes, Collection $productionAttendanceTypes): array
    {
        $attendance = (new GetAttendanceBetweenPeriod)->execute(
            employeeId: $employeeId,
            startDate: $startDate,
            endDate: $endDate,
            attendanceTypes: $attendanceTypes
        );

        $attendanceRecords = (new GetProductionAttendanceBetweenPeriod)->execute(
            employeeId: $employeeId,
            startDate: $startDate,
            endDate: $endDate
        );

        $attendanceSummary = (new GetAttendanceSummary)->execute(
            attendance: $attendance,
            attendanceTypes: $attendanceTypes
        );

        $attendanceSummary = (new GetProductionAttendanceSummary)->execute(
            attendanceRecords: $attendanceRecords,
            productionAttendanceTypes: $productionAttendanceTypes,
            attendanceSummary: $attendanceSummary
        );

        $present = (new CalculatePresent)->execute(
            attendance: $attendance,
            attendanceTypes: $attendanceTypes
        );

        $records = (new GetFlatRatePayHeadRecord)->execute(
            salaryStructure: $salaryStructure,
            startDate: $startDate,
            endDate: $endDate
        );

        $records = (new GetAttendanceBasedPayHeadRecord)->execute(
            salaryStructure: $salaryStructure,
            present: $present,
            records: $records
        );

        $records = (new GetComputationPayHeadRecord)->execute(
            salaryStructure: $salaryStructure,
            records: $records
        );

        $records = (new GetProductionBasedPayHeadRecord)->execute(
            salaryStructure: $salaryStructure,
            attendanceRecords: $attendanceRecords,
            records: $records
        );

        $records = (new GetUserDefinedPayHeadRecord)->execute(
            salaryStructure: $salaryStructure,
            records: $records
        );

        return [$attendanceSummary, $records];
    }
}
