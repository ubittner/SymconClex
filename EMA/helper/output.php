<?php

// Declare
declare(strict_types=1);

trait CXEMA_output
{
    /**
     * Toggles the EMA.
     */
    protected function ToggleEMA()
    {
        if (!$this->ReadPropertyBoolean('UseOutputControlEMA')) {
            return;
        }
        $outputEMAControl = $this->ReadPropertyInteger('OutputControlEMA');
        if ($outputEMAControl != 0 && IPS_ObjectExists($outputEMAControl)) {
            $state = GetValueBoolean($outputEMAControl);
            // Impulse mode
            if ($state) {
                $alarmSystemStatus = $this->ReadPropertyInteger('AlarmSystemStatus');
                if ($alarmSystemStatus != 0 && IPS_ObjectExists($alarmSystemStatus)) {
                    $actualState = GetValueBoolean($alarmSystemStatus);
                    $toggle = RequestAction($alarmSystemStatus, !$actualState);
                    if (!$toggle) {
                        $this->SendDebug(__FUNCTION__, 'Error, could not toggle target variable.', 0);
                    }
                }
            }
        }
    }
}