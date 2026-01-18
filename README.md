# Webtechnologien---Projekt---WS2025
Team project for a web application built with HTML, CSS (Bootstrap), PHP, and MySQL. Includes user authentication with sessions, role-based access (users &amp; admins), file uploads, and both public and private sections. Focus on full-stack development principles, security, and clean code — without CMS or frameworks.

## Arbeiten mit Git – Branch erstellen und Änderungen pushen

### 1. Lokales Repository aktualisieren
Stelle sicher, dass du dich im Hauptbranch (z. B. `main` oder `develop`) befindest und dein lokales Repository auf dem neuesten Stand ist:
```bash
git checkout main  # Oder `develop`, je nach Workflow
git pull origin main  # Holt die neuesten Änderungen
```

### 2. Eigenen Branch erstellen
Erstelle einen neuen Branch für deine Arbeit. Gib dem Branch einen beschreibenden Namen, der die Aufgabe oder das Feature widerspiegelt:
```bash
git checkout -b feature/<beschreibung>
# Für Frontend: frontend/<beschreibung>
# Für Backend: backend/<beschreibung>
# Beispiel: git checkout -b frontend/frontendSetup
```

### 3. Änderungen vornehmen
Führe deine Änderungen im Code durch. Speichere die Änderungen regelmäßig.

### 4. Änderungen hinzufügen und committen
Füge die geänderten Dateien zur Staging-Area hinzu und erstelle einen Commit:
```bash
git add -A  # Fügt alle geänderten Dateien hinzu
git commit -m "Kurze Beschreibung der Änderungen"
# Beispiel: git commit -m "LoginScreen-Button verbessert und Validierung hinzugefügt"
```

### 5. Branch zum Remote-Repository pushen
Sende deinen Branch zum Remote-Repository:
```bash
git push origin feature/<beschreibung>
# Beispiel: git push origin feature/login-optimierung
```

### 6. Pull Request erstellen
1. Öffne das Repository im Web-Interface (z. B. GitHub, GitLab).
2. Gehe zu deinem Branch und klicke auf "Pull Request erstellen".
3. Füge eine Beschreibung hinzu, was geändert wurde, und fordere gegebenenfalls eine Überprüfung an.

### 7. Feedback umsetzen
Falls es Anmerkungen oder Änderungen gibt, aktualisiere deinen Branch lokal, füge neue Änderungen hinzu und pushe erneut:
```bash
git add .
git commit -m "Feedback umgesetzt: ..."
git push origin feature/<beschreibung>
```

### 8. Branch zusammenführen
Nach der Genehmigung des Pull Requests wird dein Branch in den Hauptbranch gemerged. Lösche anschließend den Branch lokal und remote:
```bash
git checkout main  # Zurück zum Hauptbranch

git pull origin main  # Hauptbranch aktualisieren

git branch -d feature/<beschreibung>  # Lokalen Branch löschen

git push origin --delete feature/<beschreibung>  # Remote-Branch löschen
