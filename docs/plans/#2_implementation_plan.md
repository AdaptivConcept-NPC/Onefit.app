# OneFit.app — Modernization Implementation Plan (v2)

Migrate OneFit.app from a legacy vanilla PHP monolith into a **React + Laravel** architecture, preserving all existing features and the original visual design language.

> [!NOTE]
> **Updated based on user feedback (2026-04-23)**:
> - Backend → **Laravel** (not raw PHP API files)
> - Auth → **JWT via Laravel Sanctum**
> - Database → **MySQL** (continue, revisit PostgreSQL later)
> - Frontend → **Netlify-deployable** offline preview
> - Teams & Store → **Core priority features**
> - Admin panel → **Integrate into React** as protected route
> - Missing tables → **Reconstruct from code references** (ERD scan incoming from user)

---

## Resolved Decisions

| Question | Decision |
|----------|----------|
| Target Database | MySQL/MariaDB (revisit PostgreSQL later) |
| Backend Framework | **Laravel** with Eloquent ORM |
| Auth Strategy | **JWT via Laravel Sanctum** |
| Frontend Hosting | Vite + **Netlify** (offline preview capability) |
| Admin Panel | Integrate into React as protected admin route |
| Store Priority | Core feature — subscriptions + fitness equipment |
| Teams Priority | Core differentiator — HPC + Sports Analysis collaboration |
| Missing Tables | Reconstruct sensible schemas; validate against ERD scan later |

## All Questions Resolved

| Question | Decision |
|----------|----------|
| Laravel location | **`Onefit.app/laravel-api/`** — sibling to `frontend/` in same repo |
| Seed data | **Yes** — create realistic demo seeders for all tables |
| Laravel deployment | **Local only** for now (`php artisan serve`); future $5/mo VPS when budget allows |
| Frontend offline mode | React detects API availability, falls back to **bundled mock data** for Netlify portfolio demo |

---

## Phase 0: Foundation & Database Recovery
**Goal**: Set up the Laravel project, reconstruct the complete database schema via migrations, and secure credentials.

### Laravel Project Setup

#### [NEW] `Onefit.app/api/` — Laravel application
- Initialize via `composer create-project laravel/laravel api`
- Configure `.env` with MySQL credentials
- Install Sanctum: `composer require laravel/sanctum`
- Configure CORS for React frontend origin

### Database Migrations — Existing Tables (from SQL dump)

All 17 tables from the dump, converted to Laravel migrations with schema improvements:

| Migration | Source Table | Key Changes |
|-----------|-------------|-------------|
| `create_users_table` | `users` | PK → `id` (auto-inc), `username` unique index, `password_hash` → `password` varchar(255), `utf8mb4` |
| `create_user_profiles_table` | `user_profiles` → `general_user_profiles` | Add `users_username` FK, `profile_image_url` |
| `create_friends_table` | `friends` | Add `created_at`/`updated_at` |
| `create_groups_table` | `groups` | PK remains `group_ref_code`, add timestamps |
| `create_group_members_table` | `group_members` | Add timestamps |
| `create_community_posts_table` | `community_posts` | Add timestamps |
| `create_community_resources_table` | `community_resources` | Add timestamps |
| `create_fave_saves_table` | `fave_saves` | Add timestamps |
| `create_fitblog_posts_table` | `fitblog_posts` | Add timestamps, soft deletes |
| `create_fitblog_post_comments_table` | `fitblog_post_comments` | Add timestamps |
| `create_fitblog_comment_comments_table` | `fitblog_comment_comments` | Add timestamps |
| `create_interests_table` | `interests` | Already has `creation_date` |
| `create_news_table` | `news` | Add timestamps |
| `create_notifications_table` | `notifications` | Add `read_at` nullable timestamp |
| `create_user_conversations_table` | `user_conversations` | Add timestamps |
| `create_user_conversation_messages_table` | `user_conversation_messages` | Add timestamps, soft deletes |
| `create_user_socials_table` | `user_socials` | Add timestamps |

### Database Migrations — Reconstructed Tables (from `functions.php` references)

These tables are referenced in PHP code but missing from the SQL dump:

#### `administrators`
```
- id (PK, auto-inc)
- username (FK → users.username)
- admin_role (varchar 50)
- created_at / updated_at
```
*Source*: `verifyAdminUsername()` in `functions.php`

#### `general_user_profiles` (extended version of `user_profiles`)
```
- user_profile_id (PK, auto-inc)
- about (text)
- profile_type (varchar 45) — "community", "teams", "pro"
- verification (varchar 50) — "verified", "unverified"
- profile_url (varchar 100)
- profile_image_url (varchar 255)
- profile_banner_url (varchar 255)
- users_username (FK → users.username)
- created_at / updated_at
```
*Source*: `register.php`, `getUserUpdates()`, `getUserDetails()`

#### `community_group_members`
```
- id (PK, auto-inc)
- groups_group_ref_code (FK → groups.group_ref_code)
- users_username (FK → users.username)
- group_role (varchar 20)
- join_date (datetime)
- active (tinyint)
- created_at / updated_at
```
*Source*: `getUserGroups()` — `LEFT JOIN community_group_members cgm ON cgm.groups_group_ref_code = grps.group_ref_code`

#### `teams_group_members`
```
- id (PK, auto-inc)
- groups_group_ref_code (FK → groups.group_ref_code)
- users_username (FK → users.username)
- group_role (varchar 20)
- join_date (datetime)
- active (tinyint)
- created_at / updated_at
```
*Source*: `getUserGroups()` — `LEFT JOIN teams_group_members tgm`

#### `premium_group_members`
```
- id (PK, auto-inc)
- groups_group_ref_code (FK → groups.group_ref_code)
- users_username (FK → users.username)
- group_role (varchar 20)
- join_date (datetime)
- active (tinyint)
- created_at / updated_at
```
*Source*: `getUserGroups()` — `LEFT JOIN premium_group_members pgm`

#### `training_programs`
```
- program_id (PK, auto-inc)
- program_ref_code (varchar 50, unique)
- program_title (varchar 100)
- program_description (text)
- program_duration (varchar 50)
- program_category (varchar 50) — "indi", "teams"
- program_privacy (varchar 20)
- users_username (FK → users.username) — the trainer/creator
- active (tinyint)
- creation_date (datetime)
- created_at / updated_at
```
*Source*: `getUserProgSubs()` — `SELECT ... FROM program_subscribers ps INNER JOIN training_programs tp`

#### `program_subscribers`
```
- prog_subscriber_id (PK, auto-inc)
- username (FK → users.username)
- program_ref_code (FK → training_programs.program_ref_code)
- subscribe_date (datetime)
- created_at / updated_at
```
*Source*: `getUserProgSubs()`

#### `exercises`
```
- exercise_id (PK, auto-inc)
- exercise_name (varchar 100)
- exercise_description (text)
- exercise_type (varchar 50)
- exercise_category (varchar 50)
- exercise_difficulty (varchar 20)
- muscle_group (varchar 50)
- created_by (FK → users.username)
- created_at / updated_at
```
*Source*: `newExercise()`, `compileSelectInputExerciseList()`

#### `teams_weekly_schedules`
```
- schedule_id (PK, auto-inc)
- group_ref_code (FK → groups.group_ref_code)
- week_start_date (date)
- week_end_date (date)
- created_by (FK → users.username)
- created_at / updated_at
```
*Source*: `getScheduledTrainingDayActivities()`

#### `team_weekly_activities`
```
- activity_id (PK, auto-inc)
- schedule_id (FK → teams_weekly_schedules.schedule_id)
- activity_title (varchar 100)
- activity_description (text)
- activity_date (date)
- activity_time (time)
- activity_duration (varchar 50)
- exercise_id (FK → exercises.exercise_id, nullable)
- reps (int, nullable)
- sets (int, nullable)
- created_at / updated_at
```
*Source*: `compile_teams_daily_activities.php`, `AddNewDayActivitiesModal.php`

#### Activity Tracker Stats Tables
```
user_stats_heartrate:     id, username, bpm, date, time, created_at
user_stats_bodytemp:      id, username, temperature, date, time, created_at
user_stats_speed:         id, username, speed, date, time, created_at
user_stats_bmiweight:     id, username, bmi, weight, height, date, time, created_at
user_stats_stepcount:     id, username, steps, date, time, created_at
```
*Source*: `user_capture_stats_*.php` files, `syncUserActivityTrackerChart()` in `script.js`

#### `activity_log`
```
- log_id (PK, auto-inc)
- log_type (varchar 50)
- log_message (text)
- log_details (text)
- log_category (varchar 50)
- log_ref (varchar 50)
- users_username (FK → users.username)
- created_at
```
*Source*: `log_activity()` function called in `login.php`

---

## Phase 1: Laravel API Layer
**Goal**: Build the full REST API in Laravel with Eloquent models, controllers, and Sanctum auth.

### Models & Controllers

```
app/
├── Models/
│   ├── User.php
│   ├── UserProfile.php
│   ├── Friend.php
│   ├── Group.php
│   ├── GroupMember.php (abstract → CommunityGroupMember, TeamsGroupMember, PremiumGroupMember)
│   ├── CommunityPost.php
│   ├── CommunityResource.php
│   ├── FaveSave.php
│   ├── FitblogPost.php
│   ├── FitblogPostComment.php
│   ├── FitblogCommentComment.php
│   ├── Interest.php
│   ├── News.php
│   ├── Notification.php
│   ├── Conversation.php
│   ├── ConversationMessage.php
│   ├── UserSocial.php
│   ├── TrainingProgram.php
│   ├── ProgramSubscriber.php
│   ├── Exercise.php
│   ├── TeamsWeeklySchedule.php
│   ├── TeamWeeklyActivity.php
│   └── Stats/ (HeartRate, BodyTemp, Speed, BmiWeight, StepCount)
├── Http/Controllers/Api/
│   ├── AuthController.php        — login, register, logout
│   ├── ProfileController.php     — details, header, friends, groups, socials
│   ├── CommunityController.php   — posts, resources, groups, news
│   ├── DiscoveryController.php   — users, trainees, trainers, programs
│   ├── CommunicationsController.php — conversations, messages, notifications
│   ├── FitnessController.php     — tracker stats (CRUD), progression widget
│   ├── TeamsController.php       — groups, schedules, exercises, match schedules
│   ├── StoreController.php       — products, cart
│   └── AdminController.php       — admin verification, exercises CRUD
```

### API Routes (`routes/api.php`)

```php
// Public
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);

// Protected (Sanctum)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/profile/{username}', [ProfileController::class, 'show']);
    Route::get('/profile/{username}/friends', [ProfileController::class, 'friends']);
    Route::get('/profile/{username}/groups', [ProfileController::class, 'groups']);
    // ... etc for all endpoints
    
    Route::apiResource('community/posts', CommunityController::class);
    Route::apiResource('fitness/stats/heartrate', HeartRateController::class);
    Route::apiResource('teams/schedules', TeamsScheduleController::class);
    Route::apiResource('store/products', StoreController::class);
    Route::apiResource('store/cart', CartController::class);
});
```

---

## Phase 2: React Frontend — Core Structure
**Goal**: Expand from 3 routes to the full 11-tab architecture with Sanctum auth.

*(Same React architecture as v1 plan — see [Features Map](file:///C:/Users/28523971/.gemini/antigravity/brain/4d04a544-4480-41f8-8361-1d906f57da85/onefit_features_map.md) for the tab-to-component mapping)*

### Key additions for Laravel integration:
- `AuthContext.jsx` — stores JWT token from Sanctum, handles refresh
- `useApi.js` hook — attaches `Authorization: Bearer <token>` header
- `services/*.js` — all `fetch()` calls point to Laravel `/api/` routes
- Vite proxy config for local dev (`vite.config.js` → proxy `/api` to `localhost:8000`)

### Netlify Deployment Config
```toml
# netlify.toml
[build]
  command = "npm run build"
  publish = "dist"

[[redirects]]
  from = "/*"
  to = "/index.html"
  status = 200
```

For offline preview: the frontend will gracefully degrade when the API is unreachable, showing cached/mock data where possible.

---

## Phase 3: Feature Parity (Priority Order)

### Batch 1: Core User Flow
1. Login → JWT token → Dashboard
2. Registration wizard (4-step)
3. Profile tab (header, socials, friends, posts, groups)
4. Notifications (offcanvas panel)

### Batch 2: Community & Social
5. Community posts feed (Like/Comment/Share/Save)
6. Community groups (discovery + subscriptions)
7. News feed
8. Chat/Messaging

### Batch 3: Fitness & Data (Core Differentiator)
9. Activity Tracker Charts (5x Chart.js)
10. Fitness Progression widgets
11. Weekly activity calendar + daily lineup

### Batch 4: Teams Module (Core Differentiator)
12. Teams groups & membership
13. Schedule management (weekly activities)
14. Match schedules (upcoming + history)
15. Exercise management
16. Soccer field player positions visualization

### Batch 5: Store & Commerce
17. Product grid (wearables, equipment, supplements)
18. Cart widget + checkout flow
19. Membership/subscription plans

### Batch 6: Supporting Features
20. Media gallery (shared/private/video)
21. Admin panel (protected route)
22. Studio (streaming, music — scaffold)
23. Achievements, Preferences (scaffold)

---

## Phase 4: Data Layer Modernization

1. **Encoding**: All tables `utf8mb4_unicode_ci`
2. **Primary Keys**: Surrogate `id` auto-increment on all tables
3. **Timestamps**: Laravel `$table->timestamps()` on all migrations
4. **Soft Deletes**: On content tables (posts, messages, programs)
5. **Password**: `varchar(255)` for bcrypt — **critical fix**
6. **Prepared Statements**: Eloquent handles this automatically

---

## Phase 5: Polish & Verification

1. **CSS Parity**: Validate all custom classes from `global.css` (80KB)
2. **Responsive**: Bootstrap 5 grid breakpoints
3. **Animations**: `w3-animate-*` classes, custom pulse animations
4. **Side Panels**: Twitter social + Creation tools toggle
5. **Load Curtain**: Offline detection + API health check

---

## Verification Plan

### Automated
- Laravel: `php artisan test` — Feature tests for each API endpoint
- React: `npm test` — Component rendering tests
- Database: `php artisan migrate:fresh --seed` on test DB

### Manual
- Visual comparison with vanilla app screenshots
- Feature checklist walkthrough against Features Map
- Netlify deployment test (offline preview mode)

### Browser Testing
- Navigate all 11 tabs
- Verify CRUD operations on posts, groups, schedules
- Test JWT auth flow (login → token → protected routes → logout)
