# How to Add Learning Materials to Modules

## Quick Guide for Adding PDF, Word, and Image Materials

### Step-by-Step Instructions

#### 1. **Access Admin Panel**
```
URL: http://localhost:8000/admin
Login: admin@ikicb.com / password
```

#### 2. **Navigate to Modules**
- Click **Course Management** in the sidebar
- Click **Modules**
- Find the module you want to add materials to
- Click **Edit** (pencil icon)

#### 3. **Add Materials**
- Click on the **Materials** tab (at the top)
- Click **Create** button

#### 4. **Fill in Material Details**

**For PDF Documents:**
1. **Title**: Enter a descriptive name (e.g., "Lecture Notes - Chapter 1")
2. **Description**: Optional description (e.g., "Complete notes covering all topics")
3. **Type**: Select **"PDF Document"**
4. **Display Order**: Enter a number (0 appears first, 1 second, etc.)
5. **Upload File**: Click and select your PDF file
6. Click **Create**

**For Word Documents:**
1. **Title**: Enter name (e.g., "Assignment Template")
2. **Description**: Optional
3. **Type**: Select **"Document (Word, Excel, etc.)"**
4. **Display Order**: Enter order number
5. **Upload File**: Select your .doc or .docx file
6. Click **Create**

**For Images (JPG/PNG):**
1. **Title**: Enter name (e.g., "System Architecture Diagram")
2. **Description**: Optional
3. **Type**: Select **"Image"**
4. **Display Order**: Enter order number
5. **Upload File**: Select your .jpg, .jpeg, or .png file
6. Click **Create**

### Supported File Types

| Material Type | Supported Formats | Max Size | Icon Color |
|---------------|-------------------|----------|------------|
| PDF | .pdf | 50 MB | 🔴 Red |
| Images | .jpg, .jpeg, .png, .gif | 50 MB | 🟢 Green |
| Documents | .doc, .docx, .xls, .xlsx | 50 MB | 🔵 Blue |
| Videos | .mp4, .mov, .avi | 50 MB | 🟡 Purple |
| Other | Any file type | 50 MB | ⚪ Gray |

### Example Module Setup

For a typical course module, you might add:

1. **Order 0** - Lecture Notes (PDF)
2. **Order 1** - Diagram Image (JPG)
3. **Order 2** - Practice Exercise (Word)
4. **Order 3** - Reference Chart (PDF)
5. **Order 4** - Additional Resources (PDF)

### How Students See Materials

**On the Frontend:**
- Materials appear in a **beautiful 2-column grid**
- **Images show preview** - students can see the image directly
- **PDFs/Documents show colored icons** - easy to identify type
- Each material has:
  - ✅ Title and description
  - ✅ File type badge (color-coded)
  - ✅ File size display
  - ✅ View button (for images)
  - ✅ Download button (all files)

### Frontend Display Features

**Image Materials:**
```
┌─────────────────────────┐
│   [Image Preview]       │
│                         │
├─────────────────────────┤
│ Architecture Diagram    │
│ System overview         │
│ [IMAGE] 2.5 MB         │
│ [View] [Download]      │
└─────────────────────────┘
```

**PDF/Document Materials:**
```
┌─────────────────────────┐
│   [Red PDF Icon]        │
│                         │
├─────────────────────────┤
│ Lecture Notes Ch 1     │
│ Complete course notes  │
│ [PDF] 1.8 MB           │
│ [Download]             │
└─────────────────────────┘
```

### Managing Materials

**To Edit a Material:**
1. Go to Module → Materials tab
2. Click **Edit** (pencil icon) on any material
3. Update details
4. Click **Save**

**To Delete a Material:**
1. Go to Module → Materials tab
2. Click **Delete** (trash icon)
3. Confirm deletion

**To Reorder Materials:**
1. Edit each material
2. Change the **Display Order** number
3. Materials are automatically sorted by order

### Tips & Best Practices

✅ **Use Clear Titles**
- Good: "Week 1 - Introduction to Python.pdf"
- Bad: "Document1.pdf"

✅ **Add Descriptions**
- Helps students understand what's inside
- Example: "This PDF contains all examples from the lecture"

✅ **Organize by Order**
- 0 = Most important/first
- Keep related materials together

✅ **Use Appropriate Types**
- Don't upload images as "Document"
- Correct type = better user experience

✅ **File Naming**
- Use descriptive filenames
- Avoid spaces (use underscores or hyphens)
- Example: `python_basics_notes.pdf`

### Common Use Cases

#### Case 1: Complete Lecture Package
```
0. Lecture_Slides.pdf (PDF)
1. Class_Diagram.jpg (Image)
2. Practice_Exercise.docx (Document)
3. Solutions.pdf (PDF)
```

#### Case 2: Visual Learning Module
```
0. Overview_Image.jpg (Image)
1. Step1_Screenshot.png (Image)
2. Step2_Screenshot.png (Image)
3. Summary_Notes.pdf (PDF)
```

#### Case 3: Assignment Module
```
0. Assignment_Instructions.pdf (PDF)
1. Template.docx (Document)
2. Example_Solution.pdf (PDF)
3. Rubric.xlsx (Document)
```

### Troubleshooting

**Problem: File won't upload**
- Check file size (max 50 MB)
- Check file type is supported
- Try compressing large PDFs

**Problem: Wrong file type uploaded**
- Edit the material
- Change the **Type** dropdown
- Save changes

**Problem: Materials not showing on frontend**
- Make sure module is part of a published course
- Ensure user has unlocked the module
- Check file path is correct

### Quick Test

To test materials are working:

1. **Add materials to a module** (PDF, Image, Word)
2. **Login as student**: student@ikicb.com / password
3. **Enroll in the course** (buy full course or module)
4. **Access the module**
5. **See materials display** in beautiful grid
6. **Click download** to test file access

### Video Tutorial Summary

**Admin Side (2 minutes):**
1. Open admin panel
2. Navigate to Modules
3. Edit module → Materials tab
4. Click Create
5. Add PDF (red icon)
6. Add Image (shows preview)
7. Add Word doc (blue icon)
8. Set display order
9. Save

**Student Side (1 minute):**
1. Login as student
2. Access enrolled course
3. Open module
4. See materials in grid
5. View image preview
6. Download files

### Need Help?

- **File size limits**: Edit `php.ini` to increase upload limits
- **Storage location**: Files saved in `storage/app/public/module-materials/`
- **Link storage**: Run `php artisan storage:link` if files don't show
- **More formats**: Edit MaterialsRelationManager.php to add more types

---

## Summary

✅ **Supports**: PDF, Word, Excel, JPG, PNG, and more
✅ **Easy Upload**: Simple form in admin panel
✅ **Beautiful Display**: Color-coded, organized grid on frontend
✅ **Student Friendly**: Preview images, download all files
✅ **Production Ready**: Fully tested and working

Start adding materials to your modules now! 🚀
