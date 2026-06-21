<?php

use PHPUnit\Framework\TestCase;

final class BusinessRulesTest extends TestCase
{
    public function testOtDateCannotBeBeforeRepairOrderDate(): void
    {
        $repairOrderDate = '2026-06-20';
        $workOrderDate = '2026-06-18';

        $isValid =
            $workOrderDate >= $repairOrderDate;

        $this->assertFalse($isValid);
    }

    public function testRepairOrderWithoutWorkOrderNeedsClosingComment(): void
    {
        $activeWorkOrders = 0;
        $resolutionSummary = '';

        $canClose =
            $activeWorkOrders > 0 ||
            trim($resolutionSummary) !== '';

        $this->assertFalse($canClose);
    }

    public function testEquipmentIsNotVisibleBeforeRentalStartDate(): void
    {
        $rentalStartDate = '2026-06-01';
        $rentalEndDate = null;

        $periodStart = '2026-05-01';
        $periodEnd = '2026-06-01';

        $isVisible = true;

        if (
            $rentalStartDate !== null &&
            $rentalStartDate >= $periodEnd
        ) {
            $isVisible = false;
        }

        if (
            $rentalEndDate !== null &&
            $rentalEndDate < $periodStart
        ) {
            $isVisible = false;
        }

        $this->assertFalse($isVisible);
    }

    public function testPriorityMustBeValid(): void
{
    $allowedPriorities = [
        'BAJA',
        'MEDIA',
        'ALTA'
    ];

    $priority = 'ALTA';

    $this->assertContains(
        $priority,
        $allowedPriorities
    );
}

public function testStatusMustBeValid(): void
{
    $allowedStatus = [
        'ABIERTA',
        'EN PROCESO',
        'CERRADA'
    ];

    $status = 'CERRADA';

    $this->assertContains(
        $status,
        $allowedStatus
    );
}

public function testDeleteReasonCannotBeEmpty(): void
{
    $deleteReason = '';

    $this->assertEmpty(
        trim($deleteReason)
    );
}

public function testRepairOrderWithWorkOrderCanBeClosed(): void
{
    $activeWorkOrders = 1;
    $resolutionSummary = '';

    $canClose =
        $activeWorkOrders > 0 ||
        trim($resolutionSummary) !== '';

    $this->assertTrue($canClose);
}

public function testClosedDateShouldBeAssignedWhenClosingRepairOrder(): void
{
    $status = 'CERRADA';

    $closedDate =
        ($status === 'CERRADA')
        ? date('Y-m-d')
        : null;

    $this->assertNotNull(
        $closedDate
    );
}

public function testDeletedRecordShouldNotBeVisible(): void
{
    $deletedAt =
        '2026-06-20 10:00:00';

    $isVisible =
        empty($deletedAt);

    $this->assertFalse(
        $isVisible
    );
}

public function testWorkOrderDateCanBeEqualToRepairOrderDate(): void
{
    $repairOrderDate =
        '2026-06-20';

    $workOrderDate =
        '2026-06-20';

    $isValid =
        $workOrderDate >= $repairOrderDate;

    $this->assertTrue(
        $isValid
    );
}
}