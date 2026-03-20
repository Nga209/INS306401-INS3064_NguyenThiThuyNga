### PART 1: Theory Warm-up – Advanced SQL & PDO

## Task 1 – JOIN Distinction

| Question | Answer |
|----------|--------|
| **Explain the primary difference in result sets between an INNER JOIN and a LEFT JOIN when a record in the left table has no matching record in the right table.** | **INNER JOIN** only returns rows where there is a match in both tables. If a record in the left table has no match in the right table, it is excluded.<br><br>**LEFT JOIN** returns all records from the left table, even if there is no match in the right table. For unmatched rows, columns from the right table will contain NULL values. |

---

## Task 2 – Aggregation Logic

| Question | Answer |
|----------|--------|
| **What is the specific purpose of the HAVING clause, and why can we not use the WHERE clause for the same purpose when dealing with aggregate functions like SUM() or COUNT()?** | **HAVING** is used to filter groups after the `GROUP BY` clause has been applied. It works with aggregate functions.<br><br>**WHERE** cannot be used with aggregate functions because it filters individual rows **before** grouping occurs. The database evaluates `WHERE` first, then `GROUP BY`, and finally `HAVING`. |

---

## Task 3 – PDO Definition

| Question | Answer |
|----------|--------|
| **What does PDO stand for, and name two advantages of using PDO over the older mysql extension?** | **PDO** = PHP Data Objects.<br><br>**Advantages:**<br>1. **Database Independence** – PDO supports multiple database systems (MySQL, PostgreSQL, SQLite, etc.).<br>2. **Prepared Statements** – Built-in protection against SQL injection attacks. |

---

## Task 4 – Security

| Question | Answer |
|----------|--------|
| **How do Prepared Statements protect a database from SQL Injection attacks? Describe the mechanism briefly.** | Prepared Statements separate SQL logic from data. The SQL query is sent to the database server first for compilation, then the data is sent separately as parameters. This ensures that user input is treated as data only, never as executable SQL code, preventing malicious injection. |

---

## Task 5 – Execution Flow

| Question | Answer |
|----------|--------|
| **In a SQL query containing WHERE, GROUP BY, and HAVING, in what order does the database engine typically evaluate these clauses?** | **Execution Order:**<br>1. **WHERE** – Filters individual rows from the table<br>2. **GROUP BY** – Groups the filtered rows<br>3. **HAVING** – Filters the groups based on aggregate conditions |

---

### Summary Table

| Task | Topic | Key Concept |
|------|-------|-------------|
| 1 | JOIN Types | INNER JOIN vs LEFT JOIN |
| 2 | Aggregation | HAVING vs WHERE |
| 3 | PDO | PHP Data Objects advantages |
| 4 | Security | Prepared Statements mechanism |
| 5 | Execution Flow | WHERE → GROUP BY → HAVING |
