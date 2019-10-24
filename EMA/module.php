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

        // Status of alarm system and alarm
        $this->RegisterPropertyInteger('AlarmSystemStatus', 0);
        $this->RegisterPropertyInteger('AlarmStatus', 0);

        // Output, toggles the alarm system
        $this->RegisterPropertyBoolean('UseOutputControlEMA', false);
        $this->RegisterPropertyInteger('OutputControlEMA', 0);

        // Input feedback, status of the alarm system for alarm system module
        $this->RegisterPropertyBoolean('UseInputFeedback', false);
        $this->RegisterPropertyInteger('InputFeedback', 0);

        // Input release, release to toggle the alarm system
        $this->RegisterPropertyBoolean('UseInputRelease', false);
        $this->RegisterPropertyInteger('InputRelease', 0);

        // Input alarm, trigger for alarm signaling at door lock
        $this->RegisterPropertyBoolean('UseInputAlarm', false);
        $this->RegisterPropertyInteger('InputAlarm', 0);

        //#################### Register profiles

        //#################### Register timer

        //#################### Register attributes

        //#################### Register buffer
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
    }

    public function MessageSink($TimeStamp, $SenderID, $Message, $Data)
    {
        // Send debug
        $this->SendDebug('MessageSink', 'Message from SenderID ' . $SenderID . ' with Message ' . $Message . "\r\n Data: " . print_r($Data, true), 0);
        switch ($Message) {
            case IPS_KERNELSTARTED:
                $this->KernelReady();
                break;
            case VM_UPDATE:
                // EMA
                $alarmSystemStatus = $this->ReadPropertyInteger('AlarmSystemStatus');
                $alarmStatus = $this->ReadPropertyInteger('AlarmStatus');
                // Output
                $OutputControlEMA = $this->ReadPropertyInteger('OutputControlEMA');
                switch ($SenderID) {
                    case $OutputControlEMA:
                        $this->ToggleEMA();
                        break;
                    case $alarmSystemStatus:
                        // Input Feedback
                        $this->ToggleInputFeedback();
                        break;
                    case $alarmStatus:
                        // Input Alarm
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

    public function Destroy()
    {
        // Never delete this line!
        parent::Destroy();

        // Delete profiles
    }

    //#################### Request Action

    public function RequestAction($Ident, $Value)
    {
        switch ($Ident) {
            case 'NoName':
                $this->DoThis($Value);
                break;
        }
    }
}