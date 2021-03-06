<?php

/*
 * @module      Clex EMA
 *
 * @prefix      CXEMA
 *
 * @file        module.php
 *
 * @project     Normen Thiel & Ulrich Bittner
 * @author      Ulrich Bittner
 * @copyright   (c) 2019
 * @license    	CC BY-NC-SA 4.0
 *              https://creativecommons.org/licenses/by-nc-sa/4.0/
 *
 * @version     1.00-1
 * @date:       2019-09-19, 09:00
 *
 * @see         https://github.com/ubittner/SymconClex/
 *
 * @guids       Library
 *              {B1512A59-D8DE-D41E-6785-8BC20470B2A4}
 *
 *              Clex EMA
 *             	{6B36BFA3-10E1-96E2-ECE3-19AB4EC75591}
 *
 */

// Declare
declare(strict_types=1);

// Include
include_once __DIR__ . '/helper/autoload.php';

class ClexEMA extends IPSModule
{
    // Helper
    use CXEMA_inputs;
    use CXEMA_output;
    use CXEMA_registerVariableUpdates;

    public function Create()
    {
        // Never delete this line!
        parent::Create();

        //#################### Register properties

        // Output
        $this->RegisterPropertyBoolean('UseOutput', false);
        $this->RegisterPropertyInteger('Output_SourceVariable', 0);
        $this->RegisterPropertyBoolean('UseImpulseMode', false);
        $this->RegisterPropertyInteger('Output_TargetVariable', 0);

        // Input Feedback
        $this->RegisterPropertyBoolean('UseInputFeedback', false);
        $this->RegisterPropertyInteger('Input_Feedback_SourceVariable', 0);
        $this->RegisterPropertyInteger('Input_Feedback_TargetVariable', 0);

        // Input Release
        $this->RegisterPropertyBoolean('UseInputRelease', false);
        $this->RegisterPropertyInteger('Input_Release_SourceVariable', 0);
        $this->RegisterPropertyInteger('Input_Release_TargetVariable', 0);

        // Input Alarm
        $this->RegisterPropertyBoolean('UseInputAlarm', false);
        $this->RegisterPropertyInteger('Input_Alarm_SourceVariable', 0);
        $this->RegisterPropertyInteger('Input_Alarm_TargetVariable', 0);
        $this->RegisterPropertyInteger('ResetAlarmDelayDuration', 3);

        // Register timer
        $this->RegisterTimer('ResetInputAlarm', 0, 'CXEMA_ResetInputAlarm(' . $this->InstanceID . ');');
    }

    public function ApplyChanges()
    {
        // Wait until IP-Symcon is started
        $this->RegisterMessage(0, IPS_KERNELSTARTED);

        // Never delete this line!
        parent::ApplyChanges();

        // Check runlevel
        if (IPS_GetKernelRunlevel() != KR_READY) {
            return;
        }

        // Register variable updates
        $this->RegisterVariableUpdates();

        // Timer
        $this->SetTimerInterval('ResetInputAlarm', 0);

        // Check actual states
        $this->ToggleInputFeedback();
        $this->ToggleInputRelease();
        $this->ToggleInputAlarm();
    }

    public function MessageSink($TimeStamp, $SenderID, $Message, $Data)
    {
        // Send debug
        // $Data[0] = actual value
        // $Data[1] = value changed
        // $Data[2] = last value
        $this->SendDebug('MessageSink', 'Message from SenderID ' . $SenderID . ' with Message ' . $Message . "\r\n Data: " . print_r($Data, true), 0);
        switch ($Message) {
            case IPS_KERNELSTARTED:
                $this->KernelReady();
                break;
            case VM_UPDATE:
                // Output
                $output = $this->ReadPropertyInteger('Output_SourceVariable');
                $useImpulseMode = $this->ReadPropertyBoolean('UseImpulseMode');
                // Input
                $inputFeedback = $this->ReadPropertyInteger('Input_Feedback_SourceVariable');
                $inputRelease = $this->ReadPropertyInteger('Input_Release_SourceVariable');
                $inputAlarm = $this->ReadPropertyInteger('Input_Alarm_SourceVariable');
                switch ($SenderID) {
                    // Output
                    case $output:
                        // Contact interface key lock, toggles the alarm system
                        if ($useImpulseMode) {
                            if (!$Data[0] && $Data[1]) {
                                $this->SendDebug(__FUNCTION__, 'Output_SourceVariable Update', 0);
                                $this->ToggleAlarmSystem();
                            }
                        } else {
                            if ($Data[1]) {
                                $this->SendDebug(__FUNCTION__, 'Output_SourceVariable Update', 0);
                                $this->ToggleAlarmSystem();
                            }
                        }
                        break;
                    // Input
                    case $inputFeedback:
                        // Feedback, alarm system state
                        $this->SendDebug(__FUNCTION__, 'Input_Feedback_SourceVariable Update', 0);
                        $this->ToggleInputFeedback();
                        break;
                    case $inputRelease:
                        // Release, bolt contact, open door / window
                        $this->SendDebug(__FUNCTION__, 'Input_Release_SourceVariable Update', 0);
                        $this->ToggleInputRelease();
                        break;
                    case $inputAlarm:
                        // Alarm, alarm state of alarm system
                        $this->SendDebug(__FUNCTION__, 'Input_Alarm_SourceVariable Update', 0);
                        $this->ToggleInputAlarm();
                        break;
                }
                break;
        }
    }

    protected function KernelReady()
    {
        $this->ApplyChanges();
    }
}