<?php

// Declare
declare(strict_types=1);

trait CXEMA_registerVariableUpdates
{
    /**
     * Unregisters all variable updates from message sink.
     */
    protected function UnregisterVariableUpdates()
    {
        $registeredVariables = $this->GetMessageList();
        if (!empty($registeredVariables)) {
            foreach ($registeredVariables as $id => $registeredVariable) {
                foreach ($registeredVariable as $messageType) {
                    if ($messageType == VM_UPDATE) {
                        $this->UnregisterMessage($id, VM_UPDATE);
                    }
                }
            }
        }
    }

    /**
     * Registers variable updates for message sink.
     */
    protected function RegisterVariableUpdates()
    {
        // Unregister all variable updates first
        $this->UnregisterVariableUpdates();
        // Register variable updates
        // Alarm system status
        $alarmSystemStatus = $this->ReadPropertyInteger('AlarmSystemStatus');
        if ($alarmSystemStatus != 0 && IPS_ObjectExists($alarmSystemStatus)) {
            $this->RegisterMessage($alarmSystemStatus, VM_UPDATE);
        }
        // Alarm status
        $alarmStatus = $this->ReadPropertyInteger('AlarmStatus');
        if ($alarmStatus != 0 && IPS_ObjectExists($alarmStatus)) {
            $this->RegisterMessage($alarmStatus, VM_UPDATE);
        }
        // Output
        if ($this->ReadPropertyBoolean('UseOutputControlEMA')) {
            $outputControlEMA = $this->ReadPropertyInteger('OutputControlEMA');
            if ($outputControlEMA != 0 && IPS_ObjectExists($outputControlEMA)) {
                $this->RegisterMessage($outputControlEMA, VM_UPDATE);
            }
        }
    }

    /**
     * Shows the registered updates.
     */
    public function ShowMessageSink()
    {
        print_r($this->GetMessageList());
    }

}