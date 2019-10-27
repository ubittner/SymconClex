<?php

// Declare
declare(strict_types=1);

trait CXEMA_inputs
{
    /**
     * Toggles the Input Feedback.
     */
    public function ToggleInputFeedback()
    {
        if (!$this->ReadPropertyBoolean('UseInputFeedback')) {
            return;
        }
        $toggleState = false;
        // Source variable, alarm system state
        $sourceVariable = $this->ReadPropertyInteger('Input_Feedback_SourceVariable');
        if ($sourceVariable != 0 && IPS_ObjectExists($sourceVariable)) {
            $sourceVariableValue = boolval(GetValue($sourceVariable));
            if ($sourceVariableValue) {
                $toggleState = true;
            }
            // Target variable, actuator EMA module
            $targetVariable = $this->ReadPropertyInteger('Input_Feedback_TargetVariable');
            if ($targetVariable != 0 && IPS_ObjectExists($targetVariable)) {
                $toggle = RequestAction($targetVariable, $toggleState);
                if (!$toggle) {
                    $this->SendDebug(__FUNCTION__, 'Error, could not toggle target variable.', 0);
                }
            }
        }
    }

    /**
     * Toggles the Input Release.
     */
    public function ToggleInputRelease()
    {
        // Toggle state: false = ok, true = door / window open
        $toggleState = false;
        if ($this->ReadPropertyBoolean('UseInputRelease')) {
            // Source variable, bolt contact
            $sourceVariable = $this->ReadPropertyInteger('Input_Release_SourceVariable');
            if ($sourceVariable != 0 && IPS_ObjectExists($sourceVariable)) {
                $sourceVariableValue = boolval(GetValue($sourceVariable));
                if ($sourceVariableValue) {
                    $toggleState = true;
                }
            }
        }
        // Target variable, actuator EMA module
        $targetVariable = $this->ReadPropertyInteger('Input_Release_TargetVariable');
        if ($targetVariable != 0 && IPS_ObjectExists($targetVariable)) {
            $toggle = RequestAction($targetVariable, $toggleState);
            if (!$toggle) {
                $this->SendDebug(__FUNCTION__, 'Error, could not toggle target variable.', 0);
            }
        }
    }

    /**
     * Toggles the Input Alarm.
     */
    public function ToggleInputAlarm()
    {
        // Toggle state: false = alarm, true = no alarm
        $toggleState = true;
        $execute = false;
        if ($this->ReadPropertyBoolean('UseInputAlarm')) {
            // Source variable, alarm state of alarm system
            $sourceVariable = $this->ReadPropertyInteger('Input_Alarm_SourceVariable');
            if ($sourceVariable != 0 && IPS_ObjectExists($sourceVariable)) {
                $sourceVariableValue = boolval(GetValue($sourceVariable));
                if ($sourceVariableValue) {
                    $toggleState = false;
                    $execute = true;
                }
                if (!$sourceVariableValue) {
                    $delayDuration = $this->ReadPropertyInteger('ResetAlarmDelayDuration');
                    if ($delayDuration > 0) {
                        $this->SetTimerInterval('ResetInputAlarm', $delayDuration * 1000);
                    } else {
                        $toggleState = true;
                        $execute = true;
                    }
                }
            }
        }
        if ($execute) {
            // Target variable, actuator EMA module
            $targetVariable = $this->ReadPropertyInteger('Input_Alarm_TargetVariable');
            if ($targetVariable != 0 && IPS_ObjectExists($targetVariable)) {
                $toggle = @RequestAction($targetVariable, $toggleState);
                if (!$toggle) {
                    $this->SendDebug(__FUNCTION__, 'Error, could not toggle target variable.', 0);
                }
            }
        }
    }

    /**
     * Resets the Input Alarm.
     */
    public function ResetInputAlarm()
    {
        // Reset input alarm
        $targetVariable = $this->ReadPropertyInteger('Input_Alarm_TargetVariable');
        if ($targetVariable != 0 && IPS_ObjectExists($targetVariable)) {
            $toggle = @RequestAction($targetVariable, true);
            if (!$toggle) {
                $this->SendDebug(__FUNCTION__, 'Error, could not toggle target variable.', 0);
            }
        }
        // Deactivate timer
        $this->SetTimerInterval('ResetInputAlarm', 0);
    }
}