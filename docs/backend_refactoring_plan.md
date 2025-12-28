# Backend Refactoring & Verification Plan

## Goal
Establish a dedicated backend/ directory containing a clean, REST-like API that serves the React frontend. This involves auditing existing PHP scripts, refactoring them to return JSON instead of HTML/redirects, and ensuring secure session handling.

## Strategy
Isolation: Create a new backend/ folder. Do not modify the original legacy files (scripts/php/...) in place if possible, to keep a backup. Instead, copy and refactor into backend/.

## API Structure:
- backend/api/auth/: Login, Register, Logout.
- backend/api/user/: Profile, Settings.
- backend/api/dashboard/: Widgets, Feeds.
- backend/config/: Database connection, Helpers (CORS, JSON Response).

## Refactoring Process:
- Identify: Find the target legacy script (e.g., login.php).
- Analyze: Understand its dependencies (config.php, functions.php).
- Extract: Copy the core logic to a new API endpoint.
- Clean: Remove HTML generation, header('Location: ...') redirects.
- Response: Ensure it outputs standard JSON ({ "success": true, "data": ... }).
- Verify: Test the endpoint with the React authService.

## Phase 1: Authentication (Priority)
- Target: scripts/php/main_app/compile_content/profile_tab/login.php
- New Endpoint: backend/api/auth/login.php
- Dependencies: Database connection.
- Goal: React Login form sends credentials -> PHP validates -> Returns JSON + - Session Cookie -> React stores user state.

## Phase 2: Registration
- Target: scripts/php/main_app/data_management/system_admin/user_registration/- register_user.php
- New Endpoint: backend/api/auth/register.php
- Phase 3: Dashboard Data
- Targets: initializeContent logic from app/index.php.
- New Endpoints:
- backend/api/dashboard/get_stats.php (for Fitness Progress)
- backend/api/dashboard/get_notifications.php

## Directory Structure
```
c:\xampp\htdocs\Onefit.app\
├── backend/                <-- NEW
│   ├── api/
│   │   ├── auth/
│   │   │   ├── login.php
│   │   │   └── register.php
│   │   └── ...
│   ├── config/
│   │   ├── db.php
│   │   └── headers.php     <-- CORS handling
│   └── index.php           <-- Silence
├── frontend/               <-- React App
├── scripts/                <-- Legacy 
```

## PHP (Reference)
- Immediate Next Steps
- Create backend/ folder structure.
- Create backend/config/db.php (Derived - from existing config).
- Create backend/config/headers.php to - handle JSON headers and CORS (dev mode).
- Refactor login.php.
