# Clex  

Dies ist ein Gemeinschaftsprojekt von Normen Thiel und Ulrich Bittner.  

Mit diesem Modul kann das [Clex Funkschaltmodul CX6932 von Uhlmann & Zacher](https://uundz.com) in [IP-Symcon](https://www.symcon.de/) eingebunden werden.

Für dieses Modul besteht kein Anspruch auf Fehlerfreiheit, Weiterentwicklung, sonstige Unterstützung oder Support. Bevor das Modul installiert wird, sollte unbedingt ein Backup von IP-Symcon durchgeführt werden. Der Entwickler haftet nicht für eventuell auftretende Datenverluste oder sonstige Schäden. Der Nutzer stimmt den o.a. Bedingungen, sowie den Lizenzbedingungen ausdrücklich zu.  

### Inhaltverzeichnis

1. [Funktionsumfang](#1-funktionsumfang)
2. [Voraussetzungen](#2-voraussetzungen)
3. [Software-Installation](#3-software-installation)
4. [Einrichten der Instanzen in IP-Symcon](#4-einrichten-der-instanzen-in-ip-symcon)
5. [Statusvariablen und Profile](#5-statusvariablen-und-profile)
6. [WebFront](#6-webfront)
7. [PHP-Befehlsreferenz](#7-php-befehlsreferenz)

### 1. Funktionsumfang

* Ver- und entriegeln

### 2. Voraussetzungen

- IP-Symcon ab Version 5.2
- U&Z Clex Schließsystem
- U&Z Clex Funkschaltmodul CX6932

### 3. Software-Installation

- Bei kommerzieller Nutzung (z.B. als Einrichter oder Integrator) wenden Sie sich bitte zunächst an den Autor.
  
- Bei privater Nutzung wird das Modul über das [Module Control](https://www.symcon.de/service/dokumentation/modulreferenz/module-control/) installiert. Fügen Sie folgende URL hinzu:  

`https://github.com/ubittner/SymconClex`

### 4. Einrichten der Instanzen in IP-Symcon  

An beliebiger Stelle im Objektbaum `Instanz hinzufügen` auswählen und `Clex Funk` auswählen, welches unter dem Hersteller `U&Z` aufgeführt ist. Es wird eine Instanz angelegt, in der die Eigenschaften festgelegt werden können.

__Konfigurationsseite__:

Name                                | Beschreibung
----------------------------------- | ---------------------------------
(0) Instanzinformationen            | Instanzinformationen
(1) to de done                      | to be done

### 5. Statusvariablen und Profile  

Die Statusvariablen / Kategorien werden automatisch angelegt. Das Löschen einzelner kann zu Fehlfunktionen führen.

##### Statusvariablen

Name                    | Typ       | Beschreibung
----------------------- | --------- | ----------------
To be done              | Boolean   | to be done
 
##### Profile:

Nachfolgende Profile werden zusätzlichen hinzugefügt:

To be done

Wird die Instanz gelöscht, so werden automatisch die oben aufgeführten Profile gelöscht.

### 6. WebFront

Über das WebFront kann das elektronische Schließsystem ver- und entriegelt werden. 

### 7. PHP-Befehlsreferenz  

```text
Schließsystem ver- und entriegeln:
CXFUNK_ToggleDoorLock(integer $InstanzID, boolean $Status);  
  
Beispiele:  
Verriegeln: CXFUNK_ToggleDoorLock(12345, false);   
Entriegeln: CXFUNK_ToggleDoorLock(12345, true); 
```  
