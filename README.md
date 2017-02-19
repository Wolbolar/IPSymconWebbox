# IPSymconWebbox

Modul für IP-Symcon ab Version 4 stellt eine Schnittstelle zu IP-Symcon zur Verfügung und liefert eine HTML Seite die extern eingebunden werden kann.

## Dokumentation

**Inhaltsverzeichnis**

1. [Funktionsumfang](#1-funktionsumfang)  
2. [Voraussetzungen](#2-voraussetzungen)  
3. [Installation](#3-installation)  
4. [Funktionsreferenz](#4-funktionsreferenz)
5. [Konfiguration](#5-konfiguartion)  
6. [Anhang](#6-anhang)  

## 1. Funktionsumfang

Mit dem Modul wird unter Kerninstanzen eine Instanz Webbox und ein Webhook /hook/webbox angelegt. Das Modul stellt eine Schnittstelle zu IP-Symcon zur Verfügung
um damit in externen Webseiten oder Visualisierungstools wie Mediola NEO oder IPSStudio einfach Inhalt in einem Webseitenelement (NEO) bzw. Webview Element (IPSStudio) einzubinden.

### NEO Funktionen für Webseitenelement:  

* HTMLBox aus IP-Symcon darstellen
* Media Image aus IP-Symcon darstellen
* Coveranzeige darstellen z.B. Sonos


## 2. Voraussetzungen

 - IP-Symcon 4.0

## 3. Installation

### a. Laden des Moduls

In IP-Symcon (Ver. 4.0) unter Kerninstanzen über _*Modules*_ -> Hinzufügen das Modul ergänzen mit der URL:
	
    `https://github.com/Wolbolar/IPSymconWebbox`  
	
### b. Einrichtung in IPS

In IP-Symcon unter Kern Instanzen Instanz hinzufügen auswählen und Webbox auswählen.

### c. Überprüfen und Setzten des Webhook Benutzernamens und Passworts

Die soeben erstellte Kerninstanz Webbox öffnen, hier einen Webhook Benutzernamen und Webhook Passwort wählen, eintragen und mit Übernehmen der Instanz zuweisen.


## 4. Funktionsreferenz

### HTMLBox aus IP-Symcon in NEO einbinden:

In NEO ein Webseitenelement auf die Remoteseite ziehen. Bei Webseite auf Zuweisen klicken. In dem Webseitendialog nun auf + klicken um eine neue Webseite anzulegen. Einen Namen für die Webseite vergeben.
Als URL nun wie folgt eintragen:
```
http://<webhook user>:<webhook password>@<IP IPS>:3777/hook/webbox?type=htmlbox&objectid=<objectid>
```
<webhook user>      Webhook Benutzername wie er in der I/O Instanz festgelegt wurde

<webhook password>  Webhook Passwort wie es in der I/O Instanz festgelegt wurde

<IP IPS>            IP Adresse des IP-Symcon Servers

<objectid>          ObjektID der Variable in IP-Symcon mit Variablenprofil ~HTMLBox 

Beispiel:
http://max:musterpasswort@192.168.10.10:3777/hook/webbox?type=htmlbox&objectid=12345


### Media Image aus IP-Symcon in NEO einbinden:	

In NEO ein Webseitenelement auf die Remoteseite ziehen. Bei Webseite auf Zuweisen klicken. In dem Webseitendialog nun auf + klicken um eine neue Webseite anzulegen. Einen Namen für die Webseite vergeben.
Als URL nun wie folgt eintragen:
```
http://<webhook user>:<webhook password>@<IP IPS>:3777/hook/webbox?type=mediaimage&objectid=<objectid>
```
<webhook user>      Webhook Benutzername wie er in der I/O Instanz festgelegt wurde

<webhook password>  Webhook Passwort wie es in der I/O Instanz festgelegt wurde

<IP IPS>            IP Adresse des IP-Symcon Servers

<objectid>          ObjektID des Medien Image in IP-Symcon 

Beispiel:
http://max:musterpasswort@192.168.10.10:3777/hook/webbox?type=mediaimage&objectid=12345

Wenn das Bild eine bestimmte Größe haben soll wird noch height und width mit übergeben oder size

Beispiel mit height und width:
http://max:musterpasswort@192.168.10.10:3777/hook/webbox?type=mediaimage&objectid=12345&height=500&width=300

oder
Beispiel mit size (Prozent des Originals):
http://max:musterpasswort@192.168.10.10:3777/hook/webbox?type=mediaimage&objectid=12345&size=30

## 5. Konfiguration:

### Webbox:

| Eigenschaft         | Typ     | Wert            | Beschreibung                                 |
| :-----------------: | :-----: | :-------------: | :------------------------------------------: |
| webhookusername     | string  | Benutzername    | Webhook Benutzername                         |
| webhookpassword     | string  | Passwort        | Webhook Passwort                             |


## 6. Anhang

###  a. Funktionen:

#### Webbox:

zu ergänzen


###  b. GUIDs und Datenaustausch:

#### Webbox:

GUID: `{2669C5BE-13FD-4FE9-9862-CCC5458657CE}` 



