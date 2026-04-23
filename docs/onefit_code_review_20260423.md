# OneFit Project Deep Code Review: Vanilla PHP Edition

This review analyzes the legacy vanilla PHP codebase of OneFit, focusing on architectural patterns, security, and maintainability.

## 1. Architectural Overview: "The Monolith"

The project follows a traditional "Page-Controller" pattern where each `.php` file is a self-contained unit handling request processing, business logic, and UI rendering.

### Major Issues:
- **Monolithic Files**: `index.php` and `registration/index.php` are over 1,300 lines long. They contain HTML structure, inline CSS, large blocks of inline JavaScript, and PHP logic.
- **Spaghetti Functions**: `scripts/php/functions.php` (3,100+ lines) is a global dumping ground for:
    - Helper utilities (sanitization, random strings).
    - Global state (dozens of variables initialized to `NULL`).
    - Database queries (direct SQL mixed with `global $dbconn`).
    - UI generation (returning massive `HEREDOC` HTML strings).
- **Global Dependency**: Heavy reliance on the `global` keyword makes the code fragile and difficult to test in isolation.

## 2. Security Analysis

> [!WARNING]
> Several critical security anti-patterns were identified that should be addressed in any modernization effort.

- **SQL Injection Risk**: While `mysqli::real_escape_string` is used via `sanitizeMySQL()`, the codebase relies on string interpolation for queries (e.g., `WHERE username = '$username'`). Prepared statements are the industry standard for preventing injection.
- **Cross-Site Scripting (XSS)**: Sanitization is inconsistently applied. `sanitizeString()` uses a mix of `stripslashes`, `strip_tags`, and `htmlentities`. Modern frameworks handle this automatically via templating engines.
- **Sensitive Data Exposure**: `backend/config/db.php` contains hardcoded database credentials in plain text.
- **Lack of CSRF Protection**: No tokens were found in forms, leaving the application vulnerable to Cross-Site Request Forgery.

## 3. Maintainability & Technical Debt

- **Mixed Concerns**: The code violates the Single Responsibility Principle. For example, `compileSelectInputExerciseList()` handles database fetching, business logic (sorting), and UI rendering (returning `<option>` tags).
- **Hardcoded Values**: Dozens of absolute URLs (e.g., `https://onefitnet.co.za/`) are hardcoded, making environment synchronization (Dev vs. Prod) a manual nightmare.
- **Code Duplication**: UI components like the "Load Curtain" and "Navigation" are copied across multiple files instead of being included as reusable templates.
- **Legacy PHP Patterns**: The code uses `mysqli_*` procedural functions instead of the more modern PDO or an ORM (Object-Relational Mapper).

## 4. The "Spaghetti" Identification

The "spaghetti" feeling likely stems from the **Circular Dependency** between the frontend and backend:
1.  **Frontend** relies on PHP to inject state into global JS variables.
2.  **PHP** relies on JS to trigger certain UI states (like the Load Curtain).
3.  **Functions** return HTML strings that are then echoed into the page, making it impossible to change the UI without touching the core logic.

## 5. Recommendations for Modernization

### Short Term (The "Clean Up"):
- **Extract Logic**: Move database queries out of `functions.php` and into separate service files.
- **Template Separation**: Use `include` or `require` to break up `index.php` into smaller, manageable partials (e.g., `header.php`, `footer.php`, `login_form.php`).
- **Use Prepared Statements**: Refactor all database queries to use `mysqli_prepare` or PDO.

### Long Term (The "React Shift"):
- **Headless API**: Finish the transition started in `backend/api/`. Convert all PHP functions to return JSON instead of HTML.
- **Centralized State**: Move the global PHP variables into a proper state management system (like React Context or Redux) in the frontend.
- **Environment Variables**: Use a `.env` file for database credentials and API URLs.

---
**Reviewer Note**: The original design is visually stunning, but the underlying "engine" is heavily weighted by legacy practices that make adding new features risky and slow.
