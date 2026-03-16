### PART 1 : Normalization Challenge

## Task 1 – Identify Violations

| Table Name | Primary Key | Foreign Key | Normal Form | Description |
| :--- | :--- | :--- | :--- | :--- |
| Students | student_id | None | 3NF | Stores student information such as name and email |
| Professors | professor_id | None | 3NF | Stores professor information such as name and email |
| Courses | course_id | professor_id | 3NF | Stores course details and references the professor who teaches the course |
| Enrollments | enrollment_id | student_id, course_id | 3NF | Stores the enrollment relationship between students and courses |

The original dataset contains redundancy because student information,
course information, and professor information appear multiple times
for each enrollment record.

Update anomalies may occur:
- If a student changes their email, it must be updated in multiple rows.
- If a course name changes, it must also be updated in multiple rows.

There is also a transitive dependency:
Course → Professor → Professor Email.
This violates the Third Normal Form (3NF).

## Task 2 — Decompose to 3NF

- **Students → Enrollments:** One-to-Many (1:N). One student can enroll in multiple courses.

- **Courses → Enrollments:** One-to-Many (1:N). One course can have many students enrolled.

- **Professors → Courses:** One-to-Many (1:N). One professor can teach multiple courses.

- **Students ↔ Courses:** Many-to-Many (N:N). This relationship is implemented through the Enrollments table.


### PART 2: Relationship Drills

# 1. Author — Book

**Relationship Type:** One-to-Many (1:N)  

**FK Location:** `author_id` in the **Book** table  

Explanation: One author can write multiple books, but each book is written by only one author.

# 2. Citizen — Passport

**Relationship Type:** One-to-One (1:1)  

**FK Location:** `citizen_id` in the **Passport** table  

Explanation: Each citizen has only one passport, and each passport belongs to exactly one citizen.

# 3. Customer — Order

**Relationship Type:** One-to-Many (1:N)  

**FK Location:** `customer_id` in the **Order** table  

Explanation: A customer can place multiple orders, but each order belongs to only one customer.

# 4. Student — Class

**Relationship Type:** Many-to-Many (N:N)  

**FK Location:** Implemented through a junction table called **Enrollment** containing `student_id` and `class_id`.

Explanation: A student can enroll in many classes, and a class can contain many students.

# 5. Team — Player

**Relationship Type:** One-to-Many (1:N)  

**FK Location:** `team_id` in the **Player** table  

Explanation: One team can have many players, but each player belongs to only one team.