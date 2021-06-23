# DDCE Profiles

## Description

Creates a custom post type, called DDCE Profiles, which allows a user to add a profile with a name, title, and a background WYSIWYG field. Each profile opens a modal with the name, role, and background info.

### Installation
Download the latest release (.zip file). Log into the WordPress dashboard. Under "Plugins" select "Add new". Click the "Upload plugin button near the top". Click "Choose file" and select the downloaded latest release, or drag and drop the file into the box.

<a href="https://wordpress.org/support/article/managing-plugins/#manual-upload-via-wordpress-admin" target="_blank">https://wordpress.org/support/article/managing-plugins/#manual-upload-via-wordpress-admin</a>

## Shortcode

The shortcode provided will pull profile information using the following shortcode example:

```
[ddce_profile slug="pig-bellmont"]
```

Slugs can be pulled via the post editor by selecting 'Screen Options', and checking the Slug checkbox provided in the 'Screen elements' window.
