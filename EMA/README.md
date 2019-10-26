# Clex EMA

Dies ist ein Gemeinschaftsprojekt von Normen Thiel und Ulrich Bittner.  

Mit diesem Modul kann das [Clex EMA-Modul CX6934 von Uhlmann und Zacher](https://uundz.com/systeme/komponenten/ema-modul.html) in [IP-Symcon](https://www.symcon.de/) eingebunden werden.

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

* Schaltet den Ausgang und die Eingänge des EMA-Moduls.

### 2. Voraussetzungen

- IP-Symcon ab Version 5.2
- EMA
- U&Z Clex Schließsystem
- U&Z EMA-Modul CX6934
- Kontaktschnittstelle (z.B. HmIP-SCI) 
- Schaltaktor (z.B. HmIP-PBCS)

### 3. Software-Installation

- Bei kommerzieller Nutzung (z.B. als Einrichter oder Integrator) wenden Sie sich bitte zunächst an den Autor.
  
- Bei privater Nutzung wird das Modul über das [Module Control](https://www.symcon.de/service/dokumentation/modulreferenz/module-control/) installiert. Fügen Sie folgende URL hinzu:  

`https://github.com/ubittner/SymconClex`

### 4. Einrichten der Instanzen in IP-Symcon  

An beliebiger Stelle im Objektbaum `Instanz hinzufügen` auswählen und `Clex EMA` auswählen, welches unter dem Hersteller `U&Z` aufgeführt ist. Es wird eine Instanz angelegt, in der die Eigenschaften festgelegt werden können.

__Konfigurationsseite__:

Name                                            | Beschreibung
----------------------------------------------- | ----------------------------------------------------------
(0) Instanzinformationen                        | Instanzinformationen
(1) Ausgang - K1 Scharf-/Unscharf schalten      | Schaltet die EMA Scharf/Unscharf
(2) Eingang - Rückmeldung                       | Meldet dem EMA-Modul den Status der EMA
(3) Eingang - Freigabe Scharfschaltbereitschaft | Überwachung Riegelkontakt
(4) Eingang - Alarm                             | Meldet dem EMA-Modul, ob die EMA ein Alarm ausgelöst hat

__Aktionsbereich__:

Name                    | Beschreibung
----------------------- | ------------------------------------------------------
Registrierte Variablen  | Zeigt die registrierten Variablen für Statusupdates an

Für den Ausgang und die Eingänge verwendeten Quell- und Zielvariablen, werden nachfolgende Variablentypen vorausgesetzt.

__Variablentyp__:

Name                                            | Quellvariable     | Zielvariable
----------------------------------------------- | ----------------- | ----------------
(1) Ausgang - K1 Scharf-/Unscharf schalten      | boolean           | boolean
(2) Eingang - Rückmeldung                       | boolean, integer  | boolean
(3) Eingang - Freigabe Scharfschaltbereitschaft | boolean, integer  | boolean
(4) Eingang - Alarm                             | boolean, integer  | boolean

### 5. Statusvariablen und Profile  

Die Statusvariablen / Kategorien werden automatisch angelegt. Das Löschen einzelner kann zu Fehlfunktionen führen.

##### Statusvariablen

Es werden keine Statusvariablen verwendet.
 
##### Profile:

Es werden keine Profile verwendet.

### 6. WebFront

Das Modul benötigt kein WebFront.

### 7. PHP-Befehlsreferenz  

```text
Ausgang - K1 Scharf-/Unscharf schalten:  

CXEMA_ToggleAlarmSystem(integer $InstanzID);    
Schaltet die EMA.  

$InstanzID:     Instanz ID des EMA-Moduls

Beispiel:  
$toggle = CXEMA_ToggleEMA(12345);
```  

```text
Eingang - Rückmeldung:  

CXEMA_ToggleInputFeedback(integer $InstanzID);    
Meldet dem EMA-Modul den Status der EMA.

$InstanzID:     Instanz ID des EMA-Moduls

Beispiel:  
$toggle = CXEMA_ToggleFeedback(12345);
```  

```text
Eingang - Freigabe Scharfschaltbereitschaft:  

CXEMA_ToggleInputRelease(integer $InstanzID);    
Überprüft ein Riegelkontakt und erteilt die Freigabe zum Scharfschalten.

$InstanzID:     Instanz ID des EMA-Moduls

Beispiel:  
$toggle = CXEMA_ToggleRelease(12345);
```  

```text
Eingang - Alarm:  

CXEMA_ToggleInputAlarm(integer $InstanzID);    
Meldet dem EMA-Modul, ob die EMA ein Alarm ausgelöst hat

$InstanzID:     Instanz ID des EMA-Moduls

Beispiel:  
$toggle = CXEMA_ToggleInputAlarm(12345);
```


