<?php

// Declare
declare(strict_types=1);

trait CXEMA_output
{
    /**
     * Toggles the EMA.
     */
    public function ToggleAlarmSystem()
    {
        if (!$this->ReadPropertyBoolean('UseOutput')) {
            return;
        }
        // Trigger
        $sourceVariable = $this->ReadPropertyInteger('Output_SourceVariable');
        if ($sourceVariable != 0 && IPS_ObjectExists($sourceVariable)) {
            $sourceVariableValue = boolval(GetValue($sourceVariable));
            $impulseMode = $this->ReadPropertyBoolean('UseImpulseMode');
            // EMA
            $targetVariable = $this->ReadPropertyInteger('Output_TargetVariable');
            // Normal mode
            if (!$impulseMode) {
                $toggle = RequestAction($targetVariable, $sourceVariableValue);
                if (!$toggle) {
                    $this->SendDebug(__FUNCTION__, 'Error, could not toggle target variable.', 0);
                }
            } else {
                // Impulse mode
                if (!$sourceVariableValue) {
                    $targetVariableValue = boolval(GetValue($targetVariable));
                    $toggle = RequestAction($targetVariable, !$targetVariableValue);
                    if (!$toggle) {
                        $this->SendDebug(__FUNCTION__, 'Error, could not toggle target variable.', 0);
                    }
                }
            }
        }
    }
}