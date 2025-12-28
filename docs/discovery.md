# Onefit.app Discovery Notes

## Overview
- **Type**: Vanilla PHP Monolith.
- **Entry Point**: `index.php` handles Landing, Login, and includes common scripts/styles.
- **Dependencies**: Bootstrap 5, jQuery, Plyr, HLS.js, FontAwesome.
- **Backend**: PHP scripts located in `scripts/php` and `app`.

## Key Directories
- `administration`: Admin panel?
- `app`: Application logic?
- `css`: Custom styles.
- `registration`: Registration flow.
- `scripts`: JS and PHP scripts.
- `web_php_api`: Potential API layer.

## Key Features identified in index.php
- **Authentication**: Login form (email/password), Google OAuth (implied by button).
- **UI Elements**:
    - Offline handling (`offline-curtain`).
    - Loading screen (`load-curtain`).
    - Navbar & Offcanvas menu.
    - OnefitNet.TV (Video player).
    - Social Media feeds (Twitter).

## Migration Strategy
1.  **Frontend**: Create a Vite+React app in `frontend/`.
2.  **Routing**: Replicate `index.php` (Landing), `registration/` (Register), and likely a dashboard after login.
3.  **Auth**: Needs to interface with existing PHP backend. Will need to inspect `login.php` to see how auth is handled (Cookies/Session).
