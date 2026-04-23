# OneFit.app — Complete Features Map

> Reverse-engineered from the vanilla PHP codebase and the React frontend attempt.  
> **Source files analysed**: `index.php`, `registration/index.php`, `scripts/php/functions.php` (3,175 lines), `scripts/js/script.js` (1,514 lines), `scripts/js/script_jquery.js` (3,616 lines), `administration/index.html`, all files under `scripts/php/main_app/`, and `frontend/src/`.

---

## Legend

| Symbol | Meaning |
|--------|---------|
| ✅ | Implemented in vanilla PHP codebase |
| 🟡 | Partially implemented / scaffolded (empty files or placeholder logic) |
| 🔴 | Not implemented (0-byte files, stubs, or commented-out code) |
| ⚛️ | Ported to React frontend attempt |
| ❌ | Not ported to React |

---

## 1. Authentication & Session Management

| Feature | Vanilla PHP | React |
|---------|-------------|-------|
| User Login (email/username + password) | ✅ `scripts/php/main_app/compile_content/profile_tab/login.php` | ⚛️ `pages/Landing.jsx` + `services/authService.js` |
| Session management (`$_SESSION`) | ✅ `index.php` (lines 1-20) | ❌ (no token/session store) |
| Logout / Session destroy | ✅ `scripts/php/destroy_session.php` | ❌ |
| User Registration (multi-step) | ✅ `registration/index.php` (1,320 lines) | ⚛️ `pages/Register.jsx` + `components/RegistrationForm.jsx` |
| Profile Builder (post-registration wizard) | ✅ `data_management/system_admin/user_registration/profile_build_controller.php` | ❌ |
| About You step | ✅ `submit/aboutyou_submit.php` | ❌ |
| Fitness Preferences step | ✅ `submit/fitprefs_submit.php` | ❌ |
| Goal Setting step | ✅ `submit/goalsetting_submit.php` | ❌ |
| Policy Acceptance step | ✅ `submit/policy_acceptance_submit.php` | ❌ |
| Password hashing (`password_hash`) | ✅ `backend/api/auth/register.php` | ❌ |
| Admin username verification | ✅ `functions.php → verifyAdminUsername()` | ❌ |
| Load Curtain / Offline Detection | ✅ `script.js → checkCoreScriptLoadState()` | ❌ |

---

## 2. Dashboard Tab (`TabHome`)

| Feature | Vanilla PHP | React |
|---------|-------------|-------|
| Welcome header with user greeting | ✅ `index.php` | ⚛️ `pages/Dashboard.jsx` |
| Digital Clock widget | ✅ `scripts/js/digital-clock.js` | ⚛️ `components/DigitalClock.jsx` |
| Fitness Progression Bar widget | ✅ `compile_content/fitness_insights_tab/fitness_progression/fp_widget.php` | ⚛️ `components/FitnessProgressBar.jsx` |
| Daily Activity Lineup (schedule) | ✅ `compile_content/dashboard_tab/user_daily_activity_lineup.php` | 🟡 placeholder in Dashboard.jsx |
| News, Resources, Blog feed | ✅ `functions.php → getCommunityNews()`, `getCommunityResources()` | 🟡 spinner placeholder |
| Widget panel toggle (clock transfer) | ✅ `script_jquery.js` (lines 141-209) | ❌ |

---

## 3. Profile Tab (`TabProfile`)

| Feature | Vanilla PHP | React |
|---------|-------------|-------|
| Profile header (pic, name, verification badge) | ✅ `compile_content/profile_tab/user_profile_header.php` | ❌ |
| User details display | ✅ `functions.php → getUserDetails()` | ❌ |
| Social links list (FB, Twitter/X, IG, WhatsApp, Reddit) | ✅ `functions.php → getUserSocials()` | ❌ |
| Friends list | ✅ `functions.php → getUserFriends()` | ❌ |
| Community Group subscriptions | ✅ `compile_content/profile_tab/get_user_community_group_subs.php` | ❌ |
| Teams Group subscriptions | ✅ `compile_content/profile_tab/get_user_teams_group_subs.php` | ❌ |
| Pro Group subscriptions | ✅ `compile_content/profile_tab/get_user_pro_group_subs.php` | ❌ |
| Training Program subscriptions | ✅ `functions.php → getUserProgSubs()` | ❌ |
| User Updates / Posts feed | ✅ `functions.php → getUserUpdates()` | ❌ |
| User Resources list | ✅ `functions.php → getUserResources()` | ❌ |
| User Saves / Favourites | ✅ `functions.php → getUserSaves()` | ❌ |
| User Challenges | 🟡 `functions.php → getUserChallenges()` (returns "Loading...") | ❌ |
| User Preferences | 🟡 `functions.php → getUserPref()` (returns "Loading...") | ❌ |
| Profile picture upload / media directory | ✅ `functions.php → checkDirectoryInit()` | ❌ |

---

## 4. Discovery Tab (`TabDiscovery`)

| Feature | Vanilla PHP | React |
|---------|-------------|-------|
| All Users / People list | ✅ `functions.php → getAllUsers()` (referenced in variables) | ❌ |
| Community Groups discovery | ✅ `functions.php → getCommunityGroups()` | ❌ |
| Individual Fitness Programs | ✅ `functions.php` (variable declarations for `discoveryFitProgsIndi`) | ❌ |
| Teams Fitness Programs | ✅ `functions.php` (variable declarations for `discoveryFitProgsTeams`) | ❌ |
| All Trainees list | ✅ `functions.php` (variable declarations for `discoveryAllTrainees`) | ❌ |
| All Trainers list | ✅ `functions.php` (variable declarations for `discoveryAllTrainers`) | ❌ |

---

## 5. Studio Tab (`TabStudio`)

| Feature | Vanilla PHP | React |
|---------|-------------|-------|
| Music player (Muse) | 🔴 `compile_content/studio_tab/music/muse.php` (0 bytes) | ❌ |
| Community Stream Library | 🔴 `compile_content/studio_tab/streams/get_community_stream_library.php` (0 bytes) | ❌ |
| Community Stream Schedule | 🔴 `compile_content/studio_tab/streams/get_community_stream_schedule.php` (0 bytes) | ❌ |
| User Subscription Stream Library | 🔴 `compile_content/studio_tab/streams/get_user_sub_stream_library.php` (0 bytes) | ❌ |
| Muse player controller | 🟡 `script.js → musePlayerController()` (alert stub) | ❌ |
| HLS.js video streaming support | ✅ CDN loaded in `index.php` | ❌ |
| Plyr.io media player | ✅ CDN loaded in `index.php` | ❌ |

---

## 6. Store Tab (`TabStore`)

| Feature | Vanilla PHP | React |
|---------|-------------|-------|
| Store products listing | ✅ `compile_content/store_tab/get_store_products.php` | ❌ |
| Wearables category | ✅ `compile_content/store_tab/wearables.php` (3,499 bytes) | ❌ |
| User Cart widget | ✅ `compile_content/store_tab/user_cart_widget.php` (29,355 bytes) | ❌ |
| jQuery cart functions | ✅ `script_jquery.js → $.getStoreProducts()`, `$.getUserCart()` | ❌ |
| Cart JS logic | ✅ `scripts/js/cart.js`, `scripts/js/store.js` | ❌ |
| Accessories | 🔴 `compile_content/store_tab/accessories.php` (0 bytes) | ❌ |
| Apparel | 🔴 `compile_content/store_tab/apparel.php` (0 bytes) | ❌ |
| Consumables | 🔴 `compile_content/store_tab/consumables.php` (0 bytes) | ❌ |
| Equipment | 🔴 `compile_content/store_tab/equipment.php` (0 bytes) | ❌ |
| Exercise Machines | 🔴 `compile_content/store_tab/exercise_machines.php` (0 bytes) | ❌ |
| Membership plans | 🔴 `compile_content/store_tab/membership.php` (0 bytes) | ❌ |
| Supplements | 🔴 `compile_content/store_tab/supplements.php` (0 bytes) | ❌ |
| Weights | 🔴 `compile_content/store_tab/weights.php` (0 bytes) | ❌ |
| Store Ads (carousel, minimal) | 🔴 `compile_content/store_tab/ads/` (0 bytes each) | ❌ |

---

## 7. Fitness Insights Tab (`TabData`)

| Feature | Vanilla PHP | React |
|---------|-------------|-------|
| Activity Tracker Charts (Chart.js) | ✅ `script.js → compileUserActivityTrackerCharts()` | ❌ |
| Heart Rate Monitor chart | ✅ `syncUserActivityTrackerChart(heartRateChart, ...)` | ❌ |
| Body Temperature Monitor chart | ✅ `syncUserActivityTrackerChart(bodyTempChart, ...)` | ❌ |
| Speed Monitor chart | ✅ `syncUserActivityTrackerChart(speedChart, ...)` | ❌ |
| Step Counter chart | ✅ `syncUserActivityTrackerChart(stepCountChart, ...)` | ❌ |
| BMI & Weight chart | ✅ `syncUserActivityTrackerChart(bmiWeightChart, ...)` | ❌ |
| Stats data capture (heart rate) | ✅ `data_management/activity_tracker_stats_admin/.../user_capture_stats_heartrate.php` | ❌ |
| Stats data capture (body temp) | ✅ `data_management/activity_tracker_stats_admin/.../user_capture_stats_bodytemp.php` | ❌ |
| Stats data capture (speed) | ✅ `data_management/activity_tracker_stats_admin/.../user_capture_stats_speed.php` | ❌ |
| Stats data capture (BMI/weight) | ✅ `data_management/activity_tracker_stats_admin/.../user_capture_stats_bmiweight.php` | ❌ |
| Stats data capture (step count) | 🔴 `user_capture_stats_stepcount.php` (0 bytes) | ❌ |
| Fitness Progression widget | ✅ `script_jquery.js → $.getFitnessProgressionUIWidgets()` | ❌ |
| Weekly Assessments & Activities | ✅ referenced in jQuery functions | ❌ |
| Google Community Surveys sub-tab | 🟡 `InsightsTabGCS` tab switch in `script.js` | ❌ |
| Individual Athlete sub-tab | 🟡 `InsightsTabIAT` tab switch | ❌ |
| Challenges sub-tab | 🟡 `InsightsTabChallenges` tab switch | ❌ |
| Wellness sub-tab | 🟡 `InsightsTabWellness` tab switch | ❌ |
| Nutrition sub-tab | 🟡 `InsightsTabNutrition` tab switch | ❌ |

---

## 8. Communication Tab (`TabCommunication`)

| Feature | Vanilla PHP | React |
|---------|-------------|-------|
| Chat conversations list | ✅ `functions.php → getUserChatConversations()` | ❌ |
| Chat message loading (AJAX) | ✅ `script_jquery.js → $.loadChatConversation()` | ❌ |
| Chat toggle panel | ✅ `script_jquery.js` (offcanvas messages) | ❌ |
| Notifications list (div/ul/accordion views) | ✅ `functions.php → getUserNotifications()` | 🟡 `DashboardNavbar.jsx` offcanvas placeholder |
| Notification indicator toggle | ✅ `script_jquery.js → $.toggleNotificationIndicator()` | ❌ |
| News feed | ✅ `functions.php → getCommunityNews()` | ❌ |

---

## 9. Media Tab (`TabMedia`)

| Feature | Vanilla PHP | React |
|---------|-------------|-------|
| Shared media gallery | ✅ `script_jquery.js → $.getUsersMediaFiles()` → `shared` | ❌ |
| Private media gallery | ✅ `script_jquery.js → $.getUsersMediaFiles()` → `private` | ❌ |
| Video media gallery | ✅ `script_jquery.js → $.getUsersMediaFiles()` → `video` | ❌ |
| Audio media gallery | 🟡 `$.getUsersMediaFiles()` → `audio` (logs "unavailable") | ❌ |
| User media listing (profile) | ✅ `functions.php → getUserMedia()` (glob file scan) | ❌ |
| Media player (PHP) | ✅ `scripts/php/media_player.php` | ❌ |

---

## 10. Social Tab (`TabSocial`)

| Feature | Vanilla PHP | React |
|---------|-------------|-------|
| Follow suggestions | 🔴 `compile_content/social_tab/get_follow_suggestions.php` (0 bytes) | ❌ |
| Trending content | 🔴 `compile_content/social_tab/get_trending.php` (0 bytes) | ❌ |
| User stories | 🔴 `compile_content/social_tab/user_stories.php` (0 bytes) | ❌ |
| Social action buttons (Like, Comment, Share, Save) | ✅ `functions.php` → `getUserUpdates()`, `getUserSaves()` | ❌ |
| Community posts feed | ✅ `functions.php → getCommunityUpdates()` (referenced in globals) | ❌ |

---

## 11. Achievements Tab (`TabAchievements`)

| Feature | Vanilla PHP | React |
|---------|-------------|-------|
| Achievements / Challenges display | 🟡 Tab switch exists in `script.js` but `getUserChallenges()` returns "Loading..." | ❌ |

---

## 12. Settings / Preferences Tab (`TabSettings`)

| Feature | Vanilla PHP | React |
|---------|-------------|-------|
| User preferences | 🟡 Tab switch exists, `getUserPref()` returns "Loading..." | ❌ |

---

## 13. Teams Module

| Feature | Vanilla PHP | React |
|---------|-------------|-------|
| Teams Groups content | ✅ `compile_content/teams_content/teams_groups.php` (8,457 bytes) | ❌ |
| Teams weekly schedule management | ✅ `functions.php → getScheduledTrainingDayActivities()` | ❌ |
| Add New Day Activities Modal | ✅ `data_management/.../compile/AddNewDayActivitiesModal.php` (46,462 bytes) | ❌ |
| Teams daily activities compilation | ✅ `data_management/.../compile/compile_teams_daily_activities.php` | ❌ |
| Teams day activities preview (column/bar) | ✅ `data_management/.../compile/compile_teams_day_activities_preview_column_bar.php` | ❌ |
| Teams schedule activity submit form | ✅ `data_management/.../compile/compile_teams_schedule_activity_submit_form.php` (51,588 bytes) | ❌ |
| Exercise management (new exercise) | ✅ `functions.php → newExercise()` | ❌ |
| Exercise dropdown compilation | ✅ `functions.php → compileSelectInputExerciseList()` | ❌ |
| Match schedule (upcoming + history) | ✅ `script_jquery.js → $.getTeamMatchSchedule()` | ❌ |
| Soccer field player positions | ✅ `scripts/js/soccer-field-players-positions/` | ❌ |
| Mapoid integration | ✅ `scripts/js/mapoid/`, `mapoid-incl.js` | ❌ |

---

## 14. Administration Panel

| Feature | Vanilla PHP | React |
|---------|-------------|-------|
| Admin panel HTML | ✅ `administration/index.html` (142,542 bytes) | ❌ |
| New Administrator | 🔴 `data_management/system_admin/new_administrator.php` (0 bytes) | ❌ |
| New Exercise | 🔴 `data_management/system_admin/fitness_program_admin/new_exercise.php` (0 bytes) | ❌ |
| New Workout | 🔴 `data_management/system_admin/fitness_program_admin/new_workout.php` (0 bytes) | ❌ |
| New Weekly Workout Schedule | 🔴 `data_management/system_admin/fitness_program_admin/new_weekly_workout_schedule.php` (0 bytes) | ❌ |
| Group Admin (add community/pro/teams user) | 🔴 `data_management/system_admin/group_admin/` (all 0 bytes) | ❌ |
| New Group | 🔴 `data_management/system_admin/group_admin/new_group.php` (0 bytes) | ❌ |
| New RSS Feed | 🔴 `data_management/system_admin/notifications_news_admin/new_rss_feed.php` (0 bytes) | ❌ |

---

## 15. Premium & Membership

| Feature | Vanilla PHP | React |
|---------|-------------|-------|
| Plan comparison table | ✅ `registration/index.php` (Community.Indi, Pro.Starter, Pro.Athlete, Teams.Pro) | ⚛️ `components/PlanComparisonTable.jsx` + `components/MembershipCards.jsx` |
| Premium content module | 🟡 `compile_content/premium_content/` (directory exists) | ❌ |

---

## 16. Third-Party Integrations

| Feature | Vanilla PHP | React |
|---------|-------------|-------|
| OpenAI text generation | ✅ `web_php_api/OpenAI/ai_text.php` | ❌ |
| OpenAI image generation | ✅ `web_php_api/OpenAI/ai_image.php` | ❌ |
| OAuth (directory exists) | 🟡 `scripts/php/api/OAuth/` | ❌ |
| Chart.js (activity tracking charts) | ✅ CDN in `index.php` | ❌ |
| Moment.js (date handling) | ✅ CDN in `index.php` | ❌ |
| PHPMailer (email) | ✅ `scripts/php/mail.php` (31,812 bytes) | ❌ |
| Fitbit stats integration | 🟡 Referenced in plan comparison table | ❌ |

---

## 17. UI Infrastructure

| Feature | Vanilla PHP | React |
|---------|-------------|-------|
| Side panels (Twitter social / Creation tools) | ✅ `script_jquery.js` show/hide/toggle | ❌ |
| Sticky navbar with scroll-triggered style change | ✅ `script_jquery.js` (lines 269-334) | ❌ |
| Tab Navigation System (11 main tabs) | ✅ `script.js → openLink()` | ❌ (only 3 routes in React) |
| Snackbar / Toast notifications | ✅ `script.js → showSnackbar()` | ❌ |
| Smooth scroll | ✅ `script_jquery.js → $.smoothScroll()` | ❌ |
| Calender Activity Form modal | ✅ `script.js → openCalenderActivityForm()` | ❌ |
| Form validation (Bootstrap) | ✅ `script_jquery.js`, `formValidationScripts.js` | ❌ |
| Core script load checker | ✅ `script.js → checkCoreScriptLoadState()` | ❌ |
| localStorage state persistence (tab state, panel state) | ✅ extensive usage in both script files | ❌ |
| Floating layer at cursor position | ✅ `scripts/js/floating-layer-at-cursor-position.js` | ❌ |
| Color contrast utility | ✅ `functions.php → getContrastColor()` | ❌ |
| Color name to hex converter | ✅ `functions.php → color_name_to_hex()` | ❌ |
| Time ago formatter | ✅ `functions.php → get_time_ago()` | ❌ |
| Date difference calculator | ✅ `functions.php → dateDifference()` | ❌ |

---

## React Frontend Attempt — Summary

The React frontend (`frontend/`) successfully ported **~15%** of the vanilla app:

| Component | Maps to Vanilla Feature |
|-----------|------------------------|
| `Landing.jsx` | Login page from `index.php` |
| `Register.jsx` + `RegistrationForm.jsx` | `registration/index.php` |
| `Dashboard.jsx` | `TabHome` (skeleton only) |
| `DashboardNavbar.jsx` | Main navbar (Notifications, Preferences, Widgets, Web.nav) |
| `DigitalClock.jsx` | `digital-clock.js` |
| `FitnessProgressBar.jsx` | Fitness progression widget |
| `PlanComparisonTable.jsx` | Plan comparison table from registration |
| `MembershipCards.jsx` | Membership pricing cards |
| `HomeContent.jsx` | Landing page hero/features content |
| `Footer.jsx` | Global footer |
| `authService.js` | Login/Register API calls to `backend/api/auth/` |
| `global.css` (80KB) | `css/styles.css` (ported styles) |
