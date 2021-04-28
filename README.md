# Nextcloud HtmlWidget

A HTML rendering dashboard widget

⚙ Configure via `Settings > Administration > Theming > htmlbox widget`

📄 Paste HTML-Code to be shown in the dashboard widget in the textinput field.

### Dashboard layout

Once the app is installed, if you want the HtmlWidget to be displayed by default on new users dashboard, change the default dashboard layout:

```
occ config:app:set dashboard layout --value=htmlwidget,recommendations,spreed,mail,calendar
```
