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
        // Output
        if ($this->ReadPropertyBoolean('UseOutput')) {
            $outputSourceVariable = $this->ReadPropertyInteger('Output_SourceVariable');
            if ($outputSourceVariable != 0 && IPS_ObjectExists($outputSourceVariable)) {
                $this->RegisterMessage($outputSourceVariable, VM_UPDATE);
            }
        }
        // Input Feedback, EMA status
        $sourceVariable = $this->ReadPropertyInteger('Input_Feedback_SourceVariable');
        if ($sourceVariable != 0 && IPS_ObjectExists($sourceVariable)) {
            $this->RegisterMessage($sourceVariable, VM_UPDATE);
        }
        // Input Release, bolt contact
        $sourceVariable = $this->ReadPropertyInteger('Input_Release_SourceVariable');
        if ($sourceVariable != 0 && IPS_ObjectExists($sourceVariable)) {
            $this->RegisterMessage($sourceVariable, VM_UPDATE);
        }
        // Input Alarm, EMA alarm status
        $sourceVariable = $this->ReadPropertyInteger('Input_Alarm_SourceVariable');
        if ($sourceVariable != 0 && IPS_ObjectExists($sourceVariable)) {
            $this->RegisterMessage($sourceVariable, VM_UPDATE);
        }
    }

    /**
     * Shows the registered variable updates.
     */
    public function ShowMessageSink()
    {
        $registeredVariableUpdates = [];
        $registeredVariables = $this->GetMessageList();
        foreach ($registeredVariables as $id => $registeredVariable) {
            foreach ($registeredVariable as $messageType) {
                if ($messageType == VM_UPDATE) {
                    array_push($registeredVariableUpdates, ['id' => $id, 'name' => IPS_GetName($id)]);
                }
            }
        }
        sort($registeredVariableUpdates);
        echo "\n\nRegistrierte Variablen:\n\n";
        print_r($registeredVariableUpdates);
    }
}