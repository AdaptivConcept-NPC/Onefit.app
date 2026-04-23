# OneFit Reconstructed Database Schema Blueprint

This document contains the detailed schema definitions for tables referenced in the legacy code but missing from the SQL dump. These will be implemented as Laravel migrations.

---

## 1. Administrators (`administrators`)
Used for admin verification and role management.

| Column | Type | Attributes | Description |
|--------|------|------------|-------------|
| `id` | BIGINT | UNSIGNED, AUTO_INCREMENT, PK | |
| `username` | VARCHAR(20) | UNIQUE, FK → `users.username` | The unique username from users table |
| `admin_role` | VARCHAR(50) | NOT NULL | e.g., 'superadmin', 'trainer_admin', 'moderator' |
| `account_active` | TINYINT(1) | DEFAULT 1 | Admin status |
| `created_at` | TIMESTAMP | | Laravel standard |
| `updated_at` | TIMESTAMP | | Laravel standard |

*Source Reference*: `functions.php:138` -> `SELECT username FROM administrators WHERE username ='$verif_username' AND account_active = 1`

---

## 2. General User Profiles (`general_user_profiles`)
Extended profile data beyond the basic `user_profiles` table.

| Column | Type | Attributes | Description |
|--------|------|------------|-------------|
| `id` | BIGINT | UNSIGNED, AUTO_INCREMENT, PK | |
| `users_username` | VARCHAR(20) | UNIQUE, FK → `users.username` | |
| `about` | TEXT | NULLABLE | Bio/description |
| `profile_type` | VARCHAR(45) | NULLABLE | 'community', 'teams', 'pro' |
| `verification` | VARCHAR(50) | DEFAULT 'unverified' | |
| `profile_url` | VARCHAR(100) | NULLABLE | Vanity URL |
| `profile_image_url` | VARCHAR(255) | NULLABLE | Path to profile pic |
| `profile_banner_url` | TEXT | NULLABLE | Path to banner image |
| `created_at` | TIMESTAMP | | |
| `updated_at` | TIMESTAMP | | |

*Source Reference*: `functions.php:677` -> `SELECT * FROM users u INNER JOIN general_user_profiles gup ON u.username = gup.users_username`

---

## 3. Training Programs (`training_programs`)
Core entity for the fitness platform.

| Column | Type | Attributes | Description |
|--------|------|------------|-------------|
| `id` | BIGINT | UNSIGNED, AUTO_INCREMENT, PK | |
| `program_ref_code` | VARCHAR(50) | UNIQUE, NOT NULL | |
| `program_title` | VARCHAR(100) | NOT NULL | |
| `program_description` | TEXT | NULLABLE | |
| `program_duration` | VARCHAR(50) | NULLABLE | e.g., '12 weeks' |
| `program_category` | VARCHAR(50) | NOT NULL | 'individual', 'teams', 'pro' |
| `program_privacy` | VARCHAR(20) | DEFAULT 'public' | |
| `created_by` | VARCHAR(20) | FK → `users.username` | The trainer |
| `xp_points` | INT | DEFAULT 0 | |
| `active` | TINYINT(1) | DEFAULT 1 | |
| `created_at` | TIMESTAMP | | |
| `updated_at` | TIMESTAMP | | |

*Source Reference*: `functions.php:735`, `getUserProgSubs()`

---

## 4. Program Subscribers (`program_subscribers`)
Join table for user-to-program mapping.

| Column | Type | Attributes | Description |
|--------|------|------------|-------------|
| `id` | BIGINT | UNSIGNED, AUTO_INCREMENT, PK | |
| `username` | VARCHAR(20) | FK → `users.username` | |
| `program_ref_code` | VARCHAR(50) | FK → `training_programs.program_ref_code` | |
| `subscribe_date` | DATETIME | DEFAULT current_timestamp | |
| `created_at` | TIMESTAMP | | |
| `updated_at` | TIMESTAMP | | |

*Source Reference*: `getUserProgSubs()`

---

## 5. Exercises (`exercises`)
Individual workout movements.

| Column | Type | Attributes | Description |
|--------|------|------------|-------------|
| `exercise_id` | BIGINT | UNSIGNED, AUTO_INCREMENT, PK | |
| `exercise_name` | VARCHAR(100) | NOT NULL | |
| `exercise_description` | TEXT | NULLABLE | |
| `exercise_type` | VARCHAR(50) | NULLABLE | |
| `xp_points` | INT | DEFAULT 0 | |
| `muscle_group` | VARCHAR(50) | NULLABLE | |
| `created_by` | VARCHAR(20) | FK → `users.username` | |
| `created_at` | TIMESTAMP | | |
| `updated_at` | TIMESTAMP | | |

*Source Reference*: `functions.php:412` -> `SELECT exercise_id, exercise_name, xp_points FROM exercises`

---

## 6. Teams Weekly Schedules (`teams_weekly_schedules`)
Parent entity for team-based training calendars.

| Column | Type | Attributes | Description |
|--------|------|------------|-------------|
| `schedule_id` | BIGINT | UNSIGNED, AUTO_INCREMENT, PK | |
| `group_ref_code` | VARCHAR(50) | FK → `groups.group_ref_code` | |
| `week_start_date` | DATE | NOT NULL | |
| `week_end_date` | DATE | NOT NULL | |
| `created_by` | VARCHAR(20) | FK → `users.username` | |
| `created_at` | TIMESTAMP | | |
| `updated_at` | TIMESTAMP | | |

---

## 7. Team Weekly Activities (`team_weekly_activities`)
Individual scheduled events within a team's week.

| Column | Type | Attributes | Description |
|--------|------|------------|-------------|
| `teams_activity_id` | BIGINT | UNSIGNED, AUTO_INCREMENT, PK | |
| `schedule_id` | BIGINT | UNSIGNED, FK → `teams_weekly_schedules.schedule_id` | |
| `activity_title` | VARCHAR(100) | NOT NULL | |
| `activity_description` | TEXT | NULLABLE | |
| `activity_date` | DATE | NOT NULL | |
| `activity_time` | TIME | NULLABLE | |
| `exercise_id` | BIGINT | UNSIGNED, FK → `exercises.exercise_id`, NULLABLE | |
| `reps` | INT | NULLABLE | |
| `sets` | INT | NULLABLE | |
| `duration` | VARCHAR(50) | NULLABLE | |
| `created_at` | TIMESTAMP | | |
| `updated_at` | TIMESTAMP | | |

*Source Reference*: `functions.php:457`

---

## 8. Group Membership Sub-Tables
The code references separate join tables for different group types.

### Community Group Members (`community_group_members`)
### Teams Group Members (`teams_group_members`)
### Premium Group Members (`premium_group_members`)

*Structure for all*:
| Column | Type | Attributes | Description |
|--------|------|------------|-------------|
| `id` | BIGINT | UNSIGNED, AUTO_INCREMENT, PK | |
| `groups_group_ref_code` | VARCHAR(50) | FK → `groups.group_ref_code` | |
| `users_username` | VARCHAR(20) | FK → `users.username` | |
| `group_role` | VARCHAR(20) | DEFAULT 'member' | |
| `active` | TINYINT(1) | DEFAULT 1 | |
| `created_at` | TIMESTAMP | | |
| `updated_at` | TIMESTAMP | | |

---

## 9. Activity Tracker Stats Tables
Dedicated tables for high-frequency biometric data.

### `user_stats_heartrate`
### `user_stats_bodytemp`
### `user_stats_speed`
### `user_stats_bmiweight`
### `user_stats_stepcount`

*Standard Structure*:
| Column | Type | Attributes | Description |
|--------|------|------------|-------------|
| `id` | BIGINT | UNSIGNED, AUTO_INCREMENT, PK | |
| `username` | VARCHAR(20) | FK → `users.username` | |
| `[stat_value]` | FLOAT/INT | NOT NULL | e.g., `bpm`, `temperature`, `speed`, `steps` |
| `date` | DATE | NOT NULL | |
| `time` | TIME | NOT NULL | |
| `created_at` | TIMESTAMP | | |
