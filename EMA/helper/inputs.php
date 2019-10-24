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
        $alarmSystemStatus = $this->ReadPropertyInteger('AlarmSystemStatus');
        if ($alarmSystemStatus != 0 && IPS_ObjectExists($alarmSystemStatus)) {
            $actualState = GetValueBoolean($alarmSystemStatus);
            $inputFeedback = $this->ReadPropertyInteger('InputFeedback');
            if ($inputFeedback != 0 && IPS_ObjectExists($inputFeedback)) {
                $toggle = RequestAction($inputFeedback, $actualState);
                if (!$toggle) {
                    $this->SendDebug(__FUNCTION__, 'Error, could not toggle target variable.', 0);
                }
            }
        }
    }

    /**
     * Toggles the input Alarm.
     */
    protected function ToggleInputAlarm()
    {
        if (!$this->ReadPropertyBoolean('UseInputAlarm')) {
            return;
        }
        $alarmStatus = $this->ReadPropertyInteger('AlarmStatus');
        if ($alarmStatus != 0 && IPS_ObjectExists($alarmStatus)) {
            $actualState = GetValue($alarmStatus);
            $inputAlarm = $this->ReadPropertyInteger('InputAlarm');
            if ($inputAlarm != 0 && IPS_ObjectExists($inputAlarm)) {
                $toggle = RequestAction($inputAlarm, !$actualState);
                if (!$toggle) {
                    $this->SendDebug(__FUNCTION__, 'Error, could not toggle target variable.', 0);
                }
            }
        }
    }



}