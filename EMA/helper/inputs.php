<?php

// Declare
declare(strict_types=1);

trait CXEMA_inputs
{
    /**
     * Toggles the input Feedback.
     */
    protected function ToggleInputFeedback()
    {
        if (!$this->ReadPropertyBoolean('UseInputFeedback')) {
            return;
        }
        // Source variable, EMA state
        $sourceVariable = $this->ReadPropertyInteger('Input_Feedback_SourceVariable');
        if ($sourceVariable != 0 && IPS_ObjectExists($sourceVariable)) {
            $sourceVariableValue = GetValueBoolean($sourceVariable);
            // Target variable, actuator EMA module
            $targetVariable = $this->ReadPropertyInteger('Input_Feedback_TargetVariable');
            if ($targetVariable != 0 && IPS_ObjectExists($targetVariable)) {
                $toggle = RequestAction($targetVariable, $sourceVariableValue);
                if (!$toggle) {
                    $this->SendDebug(__FUNCTION__, 'Error, could not toggle target variable.', 0);
                } else {
                    $this->SendDebug(__FUNCTION__, 'Target Variable: ' . $targetVariable . ' , Value: ' . var_dump($sourceVariableValue), 0);
                }
            }
        }
    }

    protected function ToggleInputRelease()
    {
        // Toggle state: false = ok, true = door / window open
        $toggleState = false;
        if (!$this->ReadPropertyBoolean('UseInputRelease')) {
            // Source variable, bolt contact
            $sourceVariable = $this->ReadPropertyInteger('Input_Release_SourceVariable');
            if ($sourceVariable != 0 && IPS_ObjectExists($sourceVariable)) {
                $sourceVariableValue = GetValueBoolean($sourceVariable);
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
            } else {
                $this->SendDebug(__FUNCTION__, 'Target Variable: ' . $targetVariable . ' , Value: ' . var_dump($toggleState), 0);
            }
        }
    }

    /**
     * Toggles the input Alarm.
     */
    protected function ToggleInputAlarm()
    {
        // Toggle state: false = alarm, true = no alarm
        $toggleState = true;
        if (!$this->ReadPropertyBoolean('UseInputAlarm')) {
            // Source variable, EMA alarm state
            $sourceVariable = $this->ReadPropertyInteger('Input_Alarm_SourceVariable');
            if ($sourceVariable != 0 && IPS_ObjectExists($sourceVariable)) {
                $sourceVariableValue = GetValue($sourceVariable);
                if ($sourceVariableValue == 1 || $sourceVariable == 2) {
                    $toggleState = false;
                }
            }
        }
        // Target variable, actuator EMA module
        $targetVariable = $this->ReadPropertyInteger('Input_Alarm_TargetVariable');
        if ($targetVariable != 0 && IPS_ObjectExists($targetVariable)) {
            $toggle = RequestAction($targetVariable, $toggleState);
            if (!$toggle) {
                $this->SendDebug(__FUNCTION__, 'Error, could not toggle target variable.', 0);
            } else {
                $this->SendDebug(__FUNCTION__, 'Target Variable: ' . $targetVariable . ' , Value: ' . var_dump($toggleState), 0);
            }
        }
    }
}