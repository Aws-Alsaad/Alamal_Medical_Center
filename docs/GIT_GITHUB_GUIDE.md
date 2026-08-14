# Git and GitHub Working Guide

## 1. Purpose

This file is the permanent Git and GitHub command reference for Project 2.

It covers:

- Repository initialization.
- Connecting a local repository to GitHub.
- Cloning the repository.
- Branch management.
- Commit creation.
- Pulling and pushing changes.
- Reviewing repository changes.
- Resolving common Git problems.
- Protecting sensitive information.

## 2. Repository Policy

- Repository visibility: Public.
- Primary branch: `main`.
- Backend integration branch: `backend-development`.
- Normal Backend work must not be performed directly on `main`.
- Teammates currently clone and read the repository only.
- Collaborator access is not currently required.
- Collaborator access will be required only if teammates later need direct push access.
- Secrets and local environment configuration must never be committed.

Because the repository is Public, all committed content can be viewed by anyone.

## 3. One-Time Git Configuration

```bash
git --version
git config --global user.name "Your Name"
git config --global user.email "your-email@example.com"
git config --global --list
```

- `git --version` verifies that Git is installed.
- `git config --global user.name` sets the name attached to commits.
- `git config --global user.email` sets the email attached to commits.
- `git config --global --list` displays the current global configuration.
- This configuration normally needs to be completed only once per development machine.

## 4. Creating the GitHub Repository

1. Open GitHub.
2. Choose `New repository`.
3. Enter the repository name.
4. Select `Public`.
5. Do not initialize the repository with files when the local project already contains files.
6. Create the repository.

An empty GitHub repository helps avoid conflicts when an existing local project will be pushed because it does not introduce a separate initial commit or files that are missing from the local history.

## 5. Initializing and Connecting an Existing Local Project

Execute the following commands from the root directory of the local project:

```bash
git init
git status
git add .
git commit -m "chore: initialize project repository"
git branch -M main
git remote add origin https://github.com/<GITHUB_USERNAME>/<REPOSITORY_NAME>.git
git remote -v
git push -u origin main
```

- `git init` initializes Git in the current project.
- `git status` displays tracked, untracked, staged, and modified files.
- `git add .` stages the current project files.
- `git commit` creates the initial local commit.
- `git branch -M main` names the primary branch `main`.
- `git remote add origin` connects the local repository to GitHub.
- `git remote -v` verifies the remote URL.
- `git push -u origin main` uploads the branch and configures upstream tracking.

> **Warning:** Inspect `.gitignore` and `git status` before the first commit to ensure that secrets and local files are excluded.

## 6. Creating the Backend Development Branch

```bash
git switch -c backend-development
git push -u origin backend-development
```

- The first command creates and switches to `backend-development`.
- The second command uploads it to GitHub and configures upstream tracking.
- Normal Backend development must occur on `backend-development`, not directly on `main`.

## 7. Cloning the Repository

```bash
git clone https://github.com/<GITHUB_USERNAME>/<REPOSITORY_NAME>.git
cd <REPOSITORY_NAME>
git branch -a
git switch backend-development
git pull origin backend-development
```

- `git clone` creates a complete local copy.
- It normally creates a remote named `origin`.
- `cd` enters the repository directory.
- `git branch -a` displays local and remote branches.
- `git switch backend-development` selects the Backend development branch.
- `git pull` retrieves the latest changes.

Teammates can clone a Public repository without collaborator access, but they cannot push directly unless write access is granted.

## 8. Daily Development Workflow

```bash
git switch backend-development
git pull origin backend-development
git status
git diff
git add .
git status
git commit -m "feat: describe the completed feature"
git push origin backend-development
```

Recommended order:

1. Switch to the correct branch.
2. Pull the newest remote changes before beginning.
3. Review repository status.
4. Review modifications.
5. Stage the intended files.
6. Review the staged state.
7. Create a clear commit.
8. Push the commit.

Developers should avoid combining unrelated changes in one commit.

## 9. Feature Branch Workflow

Before beginning the feature:

```bash
git switch backend-development
git pull origin backend-development
git switch -c feat/<feature-name>
```

After completing the work:

```bash
git status
git diff
git add .
git commit -m "feat: describe the completed feature"
git push -u origin feat/<feature-name>
```

The normal Pull Request direction is:

```text
feat/<feature-name>
→ backend-development
```

After completing and testing a major Backend milestone, the Pull Request direction may be:

```text
backend-development
→ main
```

Replace `<feature-name>` with a short descriptive name.

Examples:

```text
feat/role-authentication
feat/doctor-directory
feat/audit-logging
```

## 10. Commit Message Types

These prefixes are a project naming convention and are not enforced automatically by GitHub.

### feat:

Use for a new user-visible or system feature.

Examples:

```text
feat: add role-based authentication
feat: add doctor directory endpoint
feat: add department directory endpoint
```

### fix:

Use for correcting incorrect behavior or a defect.

Examples:

```text
fix: reject login through an incorrect role route
fix: return 404 when doctor is missing
fix: prevent negative medical-service cost
```

### test:

Use when the commit contains tests or test-related changes.

Examples:

```text
test: add login feature tests
test: cover department directory response
test: add invalid-role authentication tests
```

### docs:

Use when the commit changes documentation only.

Examples:

```text
docs: document database design
docs: add local setup instructions
docs: update API conventions
```

### refactor:

Use for internal code restructuring without changing the expected external behavior.

Examples:

```text
refactor: move doctor queries to repository
refactor: simplify login service
refactor: extract API response helper
```

### chore:

Use for maintenance, configuration, tooling, dependency, or repository-setup changes.

Examples:

```text
chore: configure Laravel Pint
chore: update composer dependencies
chore: update gitignore
chore: initialize project repository
```

Commit messages should be short, specific, and written in the imperative style.

## 11. Reviewing Repository State

```bash
git status
git branch
git branch -a
git log --oneline
git log --oneline --graph --decorate --all
git diff
git diff --staged
git remote -v
```

- `git status` shows the current working-tree state.
- `git branch` shows local branches.
- `git branch -a` shows local and remote branches.
- `git log --oneline` shows a concise commit history.
- `git log --oneline --graph --decorate --all` shows a visual branch and commit history.
- `git diff` shows unstaged modifications.
- `git diff --staged` shows staged modifications.
- `git remote -v` shows configured remote addresses.

## 12. Undoing Local Changes Safely

```bash
git restore path/to/file
git restore --staged path/to/file
git stash
git stash pop
```

- `git restore path/to/file` discards unstaged changes in the specified file.
- `git restore --staged path/to/file` removes the file from staging but preserves its local modifications.
- `git stash` temporarily stores uncommitted work and cleans the working tree.
- `git stash pop` restores the most recently stashed work.

> **Warning:** `git restore path/to/file` can permanently discard uncommitted changes.

## 13. Pull and Push Problems

A push may be rejected when the remote branch contains commits that are missing locally. Retrieve those commits with:

```bash
git pull origin backend-development
```

After resolving any conflicts:

```bash
git status
git add .
git commit -m "fix: resolve merge conflicts"
git push origin backend-development
```

Basic conflict-resolution process:

1. Pull the remote changes.
2. Open conflicting files.
3. Select or combine the correct content.
4. Remove conflict markers.
5. Test the result.
6. Stage resolved files.
7. Commit the resolution.
8. Push again.

```text
Do not use `git push --force` on `main` or `backend-development`.
```

Force-pushing can overwrite or remove other contributors’ history.

## 14. Files That Must Not Be Committed

```text
.env
vendor/
storage/logs/
IDE-specific temporary files
passwords
API keys
access tokens
real credentials
local secrets
private keys
temporary system files
```

- `.env` contains local and potentially sensitive configuration.
- `vendor/` can be restored through Composer.
- Runtime logs do not belong in source control.
- Secrets must never appear in committed source code or documentation.
- `.env.example` may be committed only with safe placeholder values.

## 15. Files That Should Be Committed

```text
composer.json
composer.lock
.env.example
application source code
migrations
seeders
factories
tests
Postman collections
project documentation
configuration files that contain no secrets
```

`composer.lock` should be committed so all developers install compatible dependency versions.

## 16. Quick Command Reference

### Check status

```bash
git status
```

### Pull latest changes

```bash
git pull origin backend-development
```

### Stage all changes

```bash
git add .
```

### Stage a specific file

```bash
git add path/to/file
```

### Commit changes

```bash
git commit -m "feat: describe the completed feature"
```

### Push changes

```bash
git push origin backend-development
```

### Switch branches

```bash
git switch backend-development
```

### Create and switch to a new branch

```bash
git switch -c feat/<feature-name>
```

### View concise history

```bash
git log --oneline
```

### View branch history graph

```bash
git log --oneline --graph --decorate --all
```

### Temporarily store work

```bash
git stash
```

### Restore stored work

```bash
git stash pop
```

### Discard unstaged file changes

```bash
git restore path/to/file
```

### Remove a file from staging

```bash
git restore --staged path/to/file
```
