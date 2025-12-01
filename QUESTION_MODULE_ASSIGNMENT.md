# Question and Module Assignment Guide

## Overview

Questions in the LMS are organized by **Question Categories** and can be assigned to multiple **Modules**. Each module can have both MCQ and Theory questions.

## How It Works

### 1. Question Bank System

- **Questions** are created independently in the Question Bank
- Each question belongs to a **Category** (e.g., "Python Basics", "Data Structures")
- Questions can be **MCQ** or **Theory** type
- Each question has a **marks** value

### 2. Assigning Questions to Modules

Questions can be assigned to modules in **two ways**:

#### Method 1: From the Question Resource

1. Navigate to **Question Bank** → **Questions**
2. Click on any question to **Edit** it
3. Go to the **Modules** tab at the top
4. Click **Attach** to assign the question to a module
5. Select the module from the dropdown
6. Set the **Display Order** (order in which the question appears in that module)
7. Click **Attach**

**Features:**
- See all modules where this question is used
- Shows Course name and Module name
- Detach questions from modules
- Update question order per module

#### Method 2: From the Module Resource

1. Navigate to **Course Management** → **Modules**
2. Click on any module to **Edit** it
3. Go to the **Questions** tab at the top
4. Click **Attach** to add questions to this module
5. Select questions from the dropdown
6. Set the **Display Order** for each question
7. Click **Attach**

**Features:**
- See all questions assigned to this module
- Filter by type (MCQ/Theory) or category
- Shows question text, category, type, and marks
- Detach questions or update their order
- Questions sorted by display order

## Question Display in Frontend

When students access a module, they will see:
- **Video content** (if available)
- **Learning materials** (PDFs, images, documents)
- **MCQ questions** (for practice/assessment)
- **Theory exam papers** (for download and upload)

Questions appear in the order specified by the **Display Order** field.

## Use Cases

### Use Case 1: Create Questions for a Specific Module

1. Create a new Question Category (e.g., "Laravel Module 1 - Basics")
2. Create multiple questions under that category
3. Go to the Module → **Questions** tab
4. Attach all the questions with proper ordering (0, 1, 2, 3...)

### Use Case 2: Reuse Questions Across Modules

1. Create general questions in a category (e.g., "PHP Fundamentals")
2. From each Module, attach the same questions
3. Questions can appear in multiple modules with different ordering
4. Update the question once, changes reflect everywhere

### Use Case 3: Mixed Question Types per Module

1. Create both MCQ and Theory questions
2. Assign both types to a module
3. MCQ questions: Students answer online
4. Theory questions: Students see the question and upload their answer

## Database Structure

### Tables

**questions** - Stores all questions
- id
- question_category_id
- type (mcq/theory)
- question (text)
- mcq_options (JSON array)
- correct_answer
- marks

**module_questions** (Pivot Table)
- id
- module_id
- question_id
- order (display order)
- timestamps

## Important Notes

✅ **Categories are for Organization**
- Categories help organize questions in the question bank
- They don't restrict which modules can use the questions
- Use descriptive category names for easy filtering

✅ **Display Order is Module-Specific**
- Same question can have different orders in different modules
- Order 0 appears first, then 1, 2, 3, etc.

✅ **Questions are Reusable**
- One question can be used in multiple modules
- Deleting a question removes it from all modules
- Detaching removes it from that module only

✅ **Module Count Badge**
- In the Questions list, you'll see a badge showing how many modules use each question
- Tooltip shows "Assigned to X module(s)"
- Helps identify which questions are widely used

## Admin Workflow Example

### Setting up a Complete Module

1. **Create the Module**
   - Course Management → Modules → Create
   - Select Course
   - Enter Title, Description, Order
   - Add Bunny Video ID

2. **Add Learning Materials**
   - Click **Materials** tab
   - Upload PDFs, images, Word docs
   - Set display order

3. **Add Practice Questions**
   - Click **Questions** tab
   - Click **Attach**
   - Select MCQ questions from the question bank
   - Set order: 0, 1, 2, 3...

4. **Add Theory Exam** (if needed)
   - Go to Course Management → Theory Exams → Create
   - Select this Module
   - Upload exam paper PDF
   - Students will submit answers as PDFs

## Tips & Best Practices

✅ **Organize by Category**
- Create logical categories (e.g., "Week 1", "Chapter 2", "Advanced Topics")
- Makes it easier to find and attach questions

✅ **Use Consistent Ordering**
- Start with 0 for the first question
- Increment by 1 for each subsequent question
- Leave gaps (0, 10, 20) if you might insert questions later

✅ **Review Question Usage**
- Check the "Modules" count column
- Ensure important questions are assigned to relevant modules
- Remove unused questions to keep the bank clean

✅ **Test Both Directions**
- When adding many questions to one module: Use Module → Questions tab
- When adding one question to many modules: Use Question → Modules tab

## Question Types

### MCQ Questions
- **Use for**: Quick assessments, practice quizzes, knowledge checks
- **Features**: Multiple choice options, automatic grading (if implemented)
- **Student Experience**: Select an answer, submit

### Theory Questions
- **Use for**: Detailed answers, essays, calculations, diagrams
- **Features**: Open-ended, requires manual grading
- **Student Experience**: Upload PDF with their answer

## Filtering Questions

When attaching questions to a module, you can filter by:
- **Type**: MCQ or Theory
- **Category**: Any category you've created
- **Search**: Search question text

This makes it easy to find the right questions for your module.

---

## Summary

✅ Questions are created in the Question Bank with categories
✅ Questions are assigned to modules via Attach action
✅ Same question can appear in multiple modules
✅ Each module-question assignment has its own display order
✅ Manage from either Questions → Modules tab OR Modules → Questions tab
✅ Students see questions sorted by order when they access the module

Start building your question bank and assign them to modules! 🎓
