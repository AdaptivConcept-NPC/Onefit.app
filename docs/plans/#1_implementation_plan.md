# OneFit.app — Modernization Implementation Plan

Migrate the OneFit.app from a legacy vanilla PHP monolith into a clean React frontend + PHP REST API backend, preserving 100% of the existing feature set and the original visual design language.

## User Review Required

> [!IMPORTANT]
> **Scope Decision**: The codebase has ~17 feature tabs but many are scaffolded (0-byte files). This plan covers migrating **all implemented features** first, then scaffolding the stubs. Do you want to prioritize certain tabs over others?

> [!WARNING]
> **Database Credentials**: `backend/config/db.php` contains hardcoded production credentials (`adaptivc_onefit_admin` / `8MEw3Ps!dJLksWf`). These should be moved to `.env` **immediately** regardless of which phase we execute.

> [!IMPORTANT]
> **Missing Tables**: The SQL dump has 17 tables, but `functions.php` references tables NOT in the dump: `administrators`, `general_user_profiles` (vs `user_profiles`), `community_group_members`, `teams_group_members`, `premium_group_members`, `program_subscribers`, `training_programs`, `exercises`, `teams_weekly_schedules`, `team_weekly_activities`, `workout_training`, `workouts`, and several activity tracker tables. These are the "lost" tables from the WAMP instance. Do you have any partial schema or column references for these?

## Open Questions

1. **Target Database**: Do you want to continue with MySQL/MariaDB, or would you consider migrating to PostgreSQL for the modernized stack?
2. **Hosting Strategy**: Will the React frontend be served from the same XAMPP/WAMP server, or deployed separately (e.g., Netlify/Vercel for frontend, PHP server for API)?
3. **Authentication**: Should we implement JWT-based auth for the new API, or keep PHP sessions?
4. **The Admin Panel**: `administration/index.html` is 142KB of standalone HTML. Should it be integrated into the React app as a protected route, or kept separate?
5. **Store/E-commerce**: The cart system (`user_cart_widget.php` at 29KB, `store.js` at 20KB) appears substantial. Is this a priority feature or can it be deferred?
6. **Teams Module**: The teams scheduling system (`AddNewDayActivitiesModal.php` at 46KB, `compile_teams_schedule_activity_submit_form.php` at 51KB) is the most complex feature. Is this a core differentiator or a nice-to-have?

---

## Phase 0: Foundation & Database Recovery
**Goal**: Establish the modern project structure, secure credentials, and reconstruct the complete database schema.

### Backend Infrastructure

#### [MODIFY] [db.php](file:///c:/AppDev/My_Linkdin/projects/adaptivconcept-npc/Onefit.app/backend/config/db.php)
- Move credentials to a `.env` file
- Create a `.env.example` with placeholder values
- Update `db.php` to read from environment variables

#### [NEW] `.env`
```
DB_HOST=localhost
DB_USER=adaptivc_onefit_admin
DB_PASS=********
DB_NAME=adaptivc_onefit_db
```

#### [NEW] `database/migrations/` directory
- Reconstruct missing tables by reverse-engineering from `functions.php` SQL queries:
  - `administrators` — referenced in `verifyAdminUsername()`
  - `general_user_profiles` — referenced in `getUserDetails()`, `getUserUpdates()`
  - `community_group_members` — referenced in `getUserGroups()`
  - `teams_group_members` — referenced in `getUserGroups()`
  - `premium_group_members` — referenced in `getUserGroups()`
  - `program_subscribers` — referenced in `getUserProgSubs()`
  - `training_programs` — referenced in `getUserProgSubs()`
  - `exercises` — referenced in `newExercise()`, `compileSelectInputExerciseList()`
  - `teams_weekly_schedules` — referenced in `getScheduledTrainingDayActivities()`
  - `team_weekly_activities` — referenced in `getScheduledTrainingDayActivities()`
  - Activity tracker stats tables (heart rate, body temp, speed, BMI/weight, step count)

---

## Phase 1: API Extraction Layer
**Goal**: Convert the PHP functions that return HTML into API endpoints that return JSON.

### API Architecture

Each feature function in `functions.php` becomes a dedicated API endpoint:

```
backend/api/
├── auth/
│   ├── login.php          (exists)
│   └── register.php       (exists)
├── profile/
│   ├── details.php        ← getUserDetails()
│   ├── header.php         ← getUserProfileHeader()
│   ├── friends.php        ← getUserFriends()
│   ├── groups.php         ← getUserGroups()
│   ├── programs.php       ← getUserProgSubs()
│   ├── socials.php        ← getUserSocials()
│   ├── updates.php        ← getUserUpdates()
│   ├── resources.php      ← getUserResources()
│   ├── saves.php          ← getUserSaves()
│   └── media.php          ← getUserMedia()
├── community/
│   ├── groups.php         ← getCommunityGroups()
│   ├── news.php           ← getCommunityNews()
│   ├── resources.php      ← getCommunityResources()
│   └── posts.php          ← getCommunityUpdates()
├── discovery/
│   ├── users.php          ← getAllUsers()
│   ├── trainees.php       ← getAllTrainees()
│   ├── trainers.php       ← getAllTrainers()
│   └── programs.php       ← getFitPrograms(type)
├── communications/
│   ├── conversations.php  ← getUserChatConversations()
│   ├── messages.php       ← loadChatConversation()
│   └── notifications.php  ← getUserNotifications()
├── fitness/
│   ├── tracker.php        ← get_user_stats_activity_tracker
│   ├── capture.php        ← POST stats (heart rate, temp, speed, BMI)
│   ├── progression.php    ← fp_widget.php
│   └── activities.php     ← user_daily_activity_lineup
├── teams/
│   ├── groups.php         ← teams_groups
│   ├── schedule.php       ← getScheduledTrainingDayActivities()
│   ├── exercises.php      ← compileSelectInputExerciseList()
│   └── match-schedule.php ← get_match_schedules
├── store/
│   ├── products.php       ← get_store_products
│   └── cart.php           ← user_cart_widget
└── admin/
    ├── exercises.php      ← newExercise()
    └── verify.php         ← verifyAdminUsername()
```

#### Key Refactoring Pattern

For each function, the transformation is:

**Before** (`functions.php`):
```php
function getUserFriends() {
    global $dbconn, $currentUser_Usrnm, ...;
    // SQL query
    // Build HTML string with HEREDOC
    return $htmlString;
}
```

**After** (`backend/api/profile/friends.php`):
```php
require_once("../../config/db.php");
session_start();
$username = $_SESSION['currentUserUsername'];

$stmt = $dbconn->prepare("SELECT ... WHERE users_username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

$friends = [];
while ($row = $result->fetch_assoc()) {
    $friends[] = $row;
}

echo json_encode(["success" => true, "data" => $friends]);
```

---

## Phase 2: React Frontend — Core Structure
**Goal**: Expand the existing React frontend from 3 routes to the full 11-tab architecture.

### React Architecture

```
frontend/src/
├── App.jsx                    (modify: add all routes)
├── contexts/
│   └── AuthContext.jsx        (new: session state)
├── hooks/
│   └── useApi.js              (new: fetch wrapper)
├── services/
│   ├── authService.js         (exists)
│   ├── profileService.js      (new)
│   ├── communityService.js    (new)
│   ├── discoveryService.js    (new)
│   ├── fitnessService.js      (new)
│   ├── communicationsService.js (new)
│   ├── storeService.js        (new)
│   └── teamsService.js        (new)
├── pages/
│   ├── Landing.jsx            (exists)
│   ├── Register.jsx           (exists)
│   └── Dashboard.jsx          (modify: full tab system)
├── components/
│   ├── layout/
│   │   ├── DashboardNavbar.jsx (exists — refactor)
│   │   ├── TabNavigation.jsx   (new: the 11-tab switcher)
│   │   ├── SidePanel.jsx       (new: social/creation tools panels)
│   │   └── Footer.jsx          (exists)
│   ├── dashboard/
│   │   ├── ActivityLineup.jsx  (new)
│   │   ├── NewsFeed.jsx        (new)
│   │   └── WidgetPanel.jsx     (new)
│   ├── profile/
│   │   ├── ProfileHeader.jsx   (new)
│   │   ├── FriendsList.jsx     (new)
│   │   ├── GroupsList.jsx      (new)
│   │   ├── PostsFeed.jsx       (new)
│   │   ├── SocialLinks.jsx     (new)
│   │   └── ResourcesList.jsx   (new)
│   ├── discovery/
│   │   ├── PeopleGrid.jsx      (new)
│   │   ├── ProgramsGrid.jsx    (new)
│   │   └── GroupsGrid.jsx      (new)
│   ├── fitness/
│   │   ├── ActivityChart.jsx   (new: Chart.js wrapper)
│   │   ├── StatsCapture.jsx    (new: data input forms)
│   │   └── WeeklyCalendar.jsx  (new)
│   ├── communications/
│   │   ├── ChatPanel.jsx       (new)
│   │   ├── MessageThread.jsx   (new)
│   │   └── NotificationsList.jsx (new)
│   ├── store/
│   │   ├── ProductGrid.jsx     (new)
│   │   └── CartWidget.jsx      (new)
│   └── teams/
│       ├── TeamsDashboard.jsx  (new)
│       ├── ScheduleCalendar.jsx (new)
│       └── MatchSchedule.jsx   (new)
└── styles/
    └── global.css              (exists — 80KB, preserve)
```

### Tab Navigation System

The vanilla app uses `openLink(tabName)` to switch between 11 content tabs. In React, this becomes a state-driven tab component:

```jsx
const TABS = [
  { id: 'TabHome', label: 'Dashboard', icon: 'dashboard' },
  { id: 'TabProfile', label: 'Profile', icon: 'account_circle' },
  { id: 'TabDiscovery', label: 'Discovery', icon: 'travel_explore' },
  { id: 'TabStudio', label: '.Studio', icon: 'play_circle_outline' },
  { id: 'TabStore', label: '.Store', icon: 'storefront' },
  { id: 'TabData', label: 'Insights', icon: 'insights' },
  { id: 'TabAchievements', label: 'Achievements', icon: 'emoji_events' },
  { id: 'TabMedia', label: 'Media', icon: 'perm_media' },
  { id: 'TabCommunication', label: 'Communication', icon: 'forum' },
  { id: 'TabSettings', label: 'Preferences', icon: 'settings_accessibility' },
];
```

---

## Phase 3: Feature Parity — Priority Features
**Goal**: Port the functional features (not stubs) to React, in order of user-engagement impact.

### Batch 1: Core User Flow
1. **Login → Session → Dashboard** (partially done)
2. **Registration wizard** (4-step: About → FitPrefs → Goals → Policy)
3. **Profile tab** (header, socials, friends, posts, groups)
4. **Notifications** (offcanvas panel with accordion view)

### Batch 2: Community & Social
5. **Community posts feed** (with Like/Comment/Share/Save buttons)
6. **Community groups** (discovery + subscriptions)
7. **News feed**
8. **Chat/Messaging** (conversation list + message thread)

### Batch 3: Fitness & Data
9. **Activity Tracker Charts** (5 Chart.js charts with data capture forms)
10. **Fitness Progression widgets** (bar + mini variants)
11. **Weekly activity calendar** + daily lineup

### Batch 4: Specialized Modules
12. **Teams module** (schedule management, match schedules, exercise management)
13. **Store** (product grid, cart widget)
14. **Media gallery** (shared/private/video)
15. **Admin panel** (protected route)

---

## Phase 4: Data Layer Modernization
**Goal**: Fix the database schema issues identified in the code review.

### Schema Changes
1. **Encoding**: Migrate all tables from `latin1_swedish_ci` → `utf8mb4_unicode_ci`
2. **Primary Keys**: Add surrogate `id` (INT AUTO_INCREMENT) as PK for `users`, promote existing `user_id`
3. **Timestamps**: Add `created_at` / `updated_at` to all tables
4. **Soft Deletes**: Add `deleted_at` to content tables
5. **Prepared Statements**: All API endpoints use `mysqli_prepare` or PDO
6. **Password field**: Increase `password_hash` from `varchar(20)` to `varchar(255)` (current size is too small for bcrypt hashes!)

> [!CAUTION]
> The `users.password_hash` column is `varchar(20)` which is **far too small** for bcrypt hashes (which are 60 characters). This means either: (a) passwords are NOT being hashed correctly in the legacy system, or (b) there's a mismatch between the dump and the live DB. This needs verification before any data migration.

---

## Phase 5: Polish & Parity Verification
**Goal**: Ensure visual fidelity and behavior parity with the original app.

1. **CSS Audit**: The React `global.css` (80KB) was ported from the vanilla `styles.css`. Verify all custom classes (`onefit-buttons-style-dark`, `darkpads-bg-container`, `down-top-grad-tahiti`, `content-panel-border-style`, etc.) render correctly.
2. **Responsive Behavior**: The vanilla app uses Bootstrap 5 grid extensively. Verify mobile breakpoints.
3. **Animation Parity**: Port `w3-animate-*` classes and custom pulse animations.
4. **Side Panels**: Implement the Twitter social panel and Creation tools panel toggle behavior.
5. **Load Curtain**: Implement the offline detection and core script checker equivalent.

---

## Verification Plan

### Automated Tests
- API endpoint tests: `curl` or Postman collection for each `backend/api/` endpoint
- React component rendering: `npm test` with React Testing Library
- Database migration validation: Run migration scripts against test DB

### Manual Verification
- Visual comparison: Screenshot the vanilla app (if runnable) alongside the React app for each tab
- Feature checklist: Walk through every row of the Features Map and verify functionality
- Cross-browser testing: Chrome, Firefox, Edge minimum

### Browser Testing
- Use the browser tool to navigate through each tab and verify:
  - Tab switching works
  - Data loads from API
  - Social buttons (Like/Comment/Share/Save) trigger correctly
  - Offcanvas panels open/close
  - Cart widget functions
