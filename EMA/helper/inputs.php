<?php

// Declare
declare(strict_types=1);

trait CXEMA_inputs
{
    /**
     * Toggles the input Feedback.
     */
    public function ToggleInputFeedback()
    {
        if (!$this->ReadPropertyBoolean('UseInputFeedback')) {
            return;
        }
        $toggleState = false;
        // Source variable, EMA state
        $sourceVariable = $this->ReadPropertyInteger('Input_Feedback_SourceVariable');
        if ($sourceVariable != 0 && IPS_ObjectExists($sourceVariable)) {
            $variableType = gettype($sourceVariable);
            if ($variableType == 'boolean') {
                $sourceVariableValue = GetValueBoolean($sourceVariable);
                if ($sourceVariableValue) {
                    $toggleState = true;
                }
            }
            if ($variableType == 'integer') {
                $sourceVariableValue = GetValueInteger($sourceVariable);
                if ($sourceVariableValue >= 1) {
                    $toggleState = true;
                }
            }
            // Target variable, actuator EMA module
            $targetVariable = $this->ReadPropertyInteger('Input_Feedback_TargetVariable');
            if ($targetVariable != 0 && IPS_ObjectExists($targetVariable)) {
                $toggle = RequestAction($targetVariable, $toggleState);
                if (!$toggle) {
                    $this->SendDebug(__FUNCTION__, 'Error, could not toggle target variable.', 0);
                } else {
                    $this->SendDebug(__FUNCTION__, 'Target Variable: ' . $targetVariable . ', Value: ' . $toggleState, 0);
                }
            }
        }
    }

    public function ToggleInputRelease()
    {
        // Toggle state: false = ok, true = door / window open
        $toggleState = false;
        if (!$this->ReadPropertyBoolean('UseInputRelease')) {
            // Source variable, bolt contact
            $sourceVariable = $this->ReadPropertyInteger('Input_Release_SourceVariable');
            if ($sourceVariable != 0 && IPS_ObjectExists($sourceVariable)) {
                $variableType = gettype($sourceVariable);
                if ($variableType == 'boolean') {
                    $sourceVariableValue = GetValueBoolean($sourceVariable);
                    if ($sourceVariableValue) {
                        $toggleState = true;
                    }
                }
                if ($variableType == 'integer') {
                    $sourceVariableValue = GetValueInteger($sourceVariable);
                    if ($sourceVariableValue == 1) {
                        $toggleState = true;
                    }
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
                $this->SendDebug(__FUNCTION__, 'Target Variable: ' . $targetVariable . ', Value: ' . $toggleState, 0);
            }
        }
    }

    /**
     * Toggles the input Alarm.
     */
    public function ToggleInputAlarm()
    {
        // Toggle state: false = alarm, true = no alarm
        $toggleState = true;
        if (!$this->ReadPropertyBoolean('UseInputAlarm')) {
            // Source variable, EMA alarm state
            $sourceVariable = $this->ReadPropertyInteger('Input_Alarm_SourceVariable');
            if ($sourceVariable != 0 && IPS_ObjectExists($sourceVariable)) {
                $variableType = gettype($sourceVariable);
                if ($variableType == 'boolean') {
                    $sourceVariableValue = GetValueBoolean($sourceVariable);
                    if ($sourceVariableValue) {
                        $toggleState = false;
                    }
                }
                if ($variableType == 'integer') {
                    $sourceVariableValue = GetValueInteger($sourceVariable);
                    if ($sourceVariableValue == 1 || $sourceVariableValue == 2) {
                        $toggleState = false;
                    }
                }
            }
        }
        // Target variable, actuator EMA module
        $targetVariable = $this->ReadPropertyInteger('Input_Alarm_TargetVariable');
        if ($targetVariable != 0 && IPS_ObjectExists($targetVariable)) {
            $toggle = @RequestAction($targetVariable, $toggleState);
            if (!$toggle) {
                $this->SendDebug(__FUNCTION__, 'Error, could not toggle target variable.', 0);
            } else {
                $this->SendDebug(__FUNCTION__, 'Target Variable: ' . $targetVariable . ', Value: ' . $toggleState, 0);
            }
        }
    }
}