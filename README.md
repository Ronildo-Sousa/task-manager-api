# Task Manager API

A REST API for task management built with **Laravel**.

The goal of this project is to allow users to organize and track their tasks through a simple, secure, and scalable API.

This project focuses on **clean architecture, clear business rules, and maintainable code**, making it suitable as both a learning project and a portfolio showcase.

---

# System Purpose

The system allows authenticated users to:

* create tasks
* update tasks
* track task progress
* organize tasks by priority and category
* receive notifications for upcoming deadlines
* filter and search tasks
* view productivity statistics

Each user owns their tasks and categories, ensuring **data isolation and security**.

---

# System Entities

## User

Represents an authenticated user in the system.

Main fields:

* id
* name
* email
* password
* created_at
* updated_at

Relationships:

* A user can have **many tasks**
* A user can have **many categories**

---

## Category

Categories allow users to organize their tasks into logical groups.

Main fields:

* id
* name
* user_id
* created_at
* updated_at

Rules:

* Categories belong to a specific user
* Category names must be unique per user

Relationships:

* A category can contain **many tasks**

---

## Task

Represents a task created by a user.

Main fields:

* id
* title
* description
* status
* priority
* due_date
* user_id
* category_id
* created_at
* updated_at

Each task must belong to:

* one user
* one category

---

# Business Rules

## 1. Authentication Required

All task and category operations require the user to be authenticated.

Protected endpoints must use **token-based authentication**.

Users can:

* register an account
* log in
* access their profile
* log out

---

## 2. Data Isolation

A user **can only access their own data**.

Users are not allowed to:

* view tasks from other users
* modify tasks from other users
* delete tasks from other users
* access categories from other users

This rule must be enforced using **Policies or Middleware**.

---

## 3. Task Status

Each task has a status representing its progress.

Allowed statuses:

* pending
* in_progress
* completed
* cancelled

---

## 4. Allowed Status Transitions

Status changes must follow this workflow:

pending → in_progress
in_progress → completed
pending → cancelled

Invalid transitions must return a validation error.

Examples of invalid transitions:

* completed → pending
* cancelled → in_progress
* completed → in_progress

Once a task is **completed or cancelled**, it cannot return to a previous state.

---

## 5. Editing Completed Tasks

Tasks with status **completed** cannot have their title or description modified.

The task becomes read-only except for administrative actions.

---

## 6. Deleting Tasks

Tasks can only be deleted if their status is:

* pending

Tasks that are **in progress or completed cannot be deleted**.

---

## 7. Task Priority

Each task must have a priority level.

Available priorities:

* low
* medium
* high
* urgent

Priority determines task importance.

Priority order:

urgent → high → medium → low

---

## 8. Due Date Validation

Tasks may include a due date.

Rules:

* The due date cannot be in the past at creation time
* The due date must be a valid date format

Tasks with due dates in the past are considered **overdue**.

---

## 9. Category Assignment

Every task must belong to a **category**.

Rules:

* Tasks cannot exist without a category
* Categories must belong to the same user that owns the task
* Users cannot assign tasks to categories owned by other users

---

## 10. Task Search

Users can search tasks by:

* title
* description

Search should support partial matches.

Example:

GET /tasks?search=report

---

## 11. Task Filtering

Users can filter tasks using query parameters.

Available filters:

* status
* priority
* category
* due_date
* creation date

Example:

GET /tasks?status=pending&priority=high&category=work

---

## 12. Pagination

Task lists must support pagination to improve performance.

Example request:

GET /tasks?page=1&per_page=10

Responses should include:

* data
* pagination metadata
* navigation links

---

## 13. Task Statistics

The system provides aggregated statistics for a user's tasks.

Example metrics:

* total tasks
* pending tasks
* tasks in progress
* completed tasks
* overdue tasks
* tasks per category

Example endpoint:

GET /tasks/stats

---

## 14. Deadline Notifications

The system must notify users about tasks that are approaching their due date.

Rules:

* Notifications are triggered when a task is close to its due date
* Notifications should be generated automatically by background jobs
* Users should not receive duplicate notifications for the same task

Notification triggers may include:

* tasks due within the next 24 hours
* tasks that have become overdue

Notification processing should be handled using **scheduled jobs or queues**.

---

# API Endpoints Overview

Authentication:

POST /auth/register
POST /auth/login
POST /auth/logout
GET /auth/me

Categories:

GET /categories
POST /categories
PUT /categories/{id}
DELETE /categories/{id}

Tasks:

GET /tasks
POST /tasks
GET /tasks/{id}
PUT /tasks/{id}
DELETE /tasks/{id}

Statistics:

GET /tasks/stats
