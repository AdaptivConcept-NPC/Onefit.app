# OneFit Database Schema Map

This document reverse engineers the `adaptivc_onefit_db` schema from the provided SQL dump. This map serves as a blueprint for creating migrations in a modern framework.

## Core Entities

### 1. `users`
The heart of the system.
- **Primary Key**: `username` (varchar 20)
- **Key Columns**: `password_hash`, `user_name`, `user_surname`, `user_email`, `contact_number`, `date_of_birth`, `user_gender`, `account_active` (tinyint).
- **Notes**: Uses `username` as PK. Should consider adding a surrogate `id` (int/uuid) in the future.

### 2. `user_profiles`
Extended profile data.
- **Primary Key**: `user_profile_id` (int, AI)
- **Columns**: `about`, `profile_type`, `profile_url`, `verification`, `profile_banner_url`.
- **Relationship**: (Logical) 1:1 with `users`.

### 3. `friends`
User relationships.
- **Primary Key**: `friend_id` (int, AI)
- **Foreign Keys**: 
    - `username` -> `users.username`
    - `friend_username` -> `users.username`
- **Logic**: Tracks friendship status and dates.

---

## Community & Social Features

### 4. `groups`
- **Primary Key**: `group_ref_code` (varchar 50)
- **Foreign Keys**: `created_by` -> `users.username`
- **Logic**: Defines group identity and privacy levels.

### 5. `group_members`
- **Foreign Keys**:
    - `group_ref_code` -> `groups.group_ref_code`
    - `username` -> `users.username`
- **Logic**: Junction table for group membership with roles.

### 6. `community_posts`
- **Foreign Keys**: `username` -> `users.username`
- **Logic**: Stores community status updates.

### 7. `community_resources`
- **Foreign Keys**: `shared_by` -> `users.username`
- **Logic**: Shared external links and documents.

### 8. `fave_saves`
- **Foreign Keys**: `username` -> `users.username`
- **Logic**: Generic table for "saving" content via `fave_ref`.

### 9. `interests`
- **Foreign Keys**: `created_by` -> `users.username`
- **Logic**: Dictionary of user interests.

### 10. `user_socials`
- **Foreign Keys**: `username` -> `users.username`
- **Logic**: External social profile links (handles).

---

## Blog & Content

### 11. `fitblog_posts`
- **Foreign Keys**: `username` -> `users.username`
- **Logic**: Core blog content with verification flag.

### 12. `fitblog_post_comments`
- **Foreign Keys**:
    - `post_id` -> `fitblog_posts.post_id`
    - `username` -> `users.username`

### 13. `fitblog_comment_comments`
- **Foreign Keys**:
    - `post_comment_id` -> `fitblog_post_comments.post_comment_id`
    - `username` -> `users.username`
- **Logic**: Enables nested comment replies.

---

## Messaging & Utility

### 14. `user_conversations`
- **Foreign Keys**:
    - `primary_user` -> `users.username`
    - `secondary_user` -> `users.username`
- **Logic**: Tracks 1-on-1 chat sessions.

### 15. `user_conversation_messages`
- **Foreign Keys**:
    - `conversation_id` -> `user_conversations.conversation_id`
    - `sender` -> `users.username`
    - `receiver` -> `users.username`

### 16. `notifications`
- **Foreign Keys**: `notify_user` -> `users.username`
- **Logic**: System alerts for specific users.

### 17. `news`
- **Foreign Keys**: `created_by` -> `users.username`
- **Logic**: Official system-wide announcements.

---

## Migration Recommendations

1.  **Surrogate Keys**: Introduce `id` (INT AUTO_INCREMENT or UUID) as the Primary Key for all tables, especially `users`.
2.  **Naming Consistency**: Standardize on `id` for primary keys and `user_id` for foreign keys.
3.  **Encodings**: Migrate from `latin1_swedish_ci` to `utf8mb4_unicode_ci` for full emoji and international character support.
4.  **Timestamps**: Use `created_at` and `updated_at` consistently across all tables.
5.  **Soft Deletes**: Consider adding `deleted_at` columns to avoid hard-deleting user content.
