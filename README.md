# spotify_drupal

Module created to connect Spotify to Drupal V.8.x

To install:

- Go to: drupal8/admin/modules/install
- Click to "Upload a module or theme archive to install" and upload the ZIP file
- Click to INSTALL
- Enable the module using the Drupal interface
- Go to drupal8/lanzamientos

Based on:

https://github.com/ricardojriosr/spotifyDrupal

https://github.com/aterchin/lilbacon-spotify-drupal8

https://github.com/diegodalr/spotify_web_api

Structure:

- spotify_drupal

-- src
--- controller
---- SpotifyClientController.php

-- templates
--- artist_page.html.twig
--- new_releases_page.html.twig

-- composer.json
-- spotify_client.info.yml
-- spotify_client.links.menu.yml
-- spotify_client.module
-- spotify_client.routing.yml
