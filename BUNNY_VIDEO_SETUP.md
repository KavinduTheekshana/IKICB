# Bunny CDN Video Setup Guide

## How to Add Videos to Modules

When creating or editing a module, you now need to provide two pieces of information:

### 1. **Bunny Library ID**
- This is your Bunny.net Stream Library ID
- Find it in your Bunny.net dashboard under **Stream → Your Library**
- Example: `123456`

### 2. **Bunny Video ID**
- This is the unique ID of each video you upload
- Find it when you upload a video to Bunny.net
- Example: `a1b2c3d4-e5f6-7890-abcd-ef1234567890`

## Step-by-Step Instructions

### Finding Your Library ID

1. Login to [Bunny.net](https://bunny.net)
2. Go to **Stream** in the left sidebar
3. Click on your **Video Library**
4. Your Library ID appears in the URL or library settings
5. Copy this ID (you'll use it for all videos in this library)

### Getting Video IDs

1. In your Bunny.net Stream library, click **Upload**
2. Upload your video file
3. Once uploaded, click on the video
4. The **Video ID** (GUID) will be shown in the video details
5. Copy this ID for each video

### Adding Video to Module

1. **Navigate to Admin Panel** → **Modules** → **Create** or **Edit**
2. Fill in module details (Title, Description, etc.)
3. In the **Video Content** section:
   - **Bunny Library ID**: Paste your library ID (e.g., `123456`)
   - **Bunny Video ID**: Paste the video ID (e.g., `a1b2c3d4-e5f6-7890-abcd-ef1234567890`)
4. **Live Preview**: After pasting both IDs, the video preview will automatically appear below
5. Click **Save**

## What Happens Behind the Scenes

The system automatically constructs the Bunny CDN embed URL:
```
https://iframe.mediadelivery.net/embed/{LIBRARY_ID}/{VIDEO_ID}
```

This URL is saved in the `video_url` field and used to display the video on the frontend.

## Example

**Your Bunny Details:**
- Library ID: `123456`
- Video ID: `a1b2c3d4-e5f6-7890-abcd-ef1234567890`

**Auto-Generated URL:**
```
https://iframe.mediadelivery.net/embed/123456/a1b2c3d4-e5f6-7890-abcd-ef1234567890
```

## Video Preview

- As soon as you paste both IDs and click outside the field, the video preview loads automatically
- You can verify the video is correct before saving
- The preview uses the exact same embed that students will see

## Troubleshooting

### Video doesn't show in preview
- Check that both Library ID and Video ID are correct
- Make sure the video is published in Bunny.net
- Verify your Bunny.net account is active

### Wrong video appears
- Double-check the Video ID
- Each video has a unique ID - make sure you copied the correct one

### Video works in admin but not on frontend
- Ensure the video is set to "Public" in Bunny.net
- Check if there are any geographic restrictions on your Bunny library

## Database Fields

The module now stores three video-related fields:

| Field | Type | Description |
|-------|------|-------------|
| `bunny_library_id` | string | Your Bunny Stream Library ID |
| `bunny_video_id` | string | The specific video's unique ID |
| `video_url` | string | Auto-generated embed URL (for backward compatibility) |

## Migration

A new migration has been added:
```
2025_12_01_132608_add_bunny_video_fields_to_modules_table.php
```

This adds `bunny_library_id` and `bunny_video_id` columns to the `modules` table.

## Benefits of This Approach

✅ **Easier to manage**: Just paste two IDs instead of constructing full URLs
✅ **Less error-prone**: No chance of typos in the URL structure
✅ **Automatic URL generation**: System builds the correct URL for you
✅ **Live preview**: See the video immediately as you add it
✅ **Cleaner admin interface**: Clear, labeled fields for each component

---

**Need Help?**
- Bunny.net Documentation: https://docs.bunny.net/docs/stream
- Bunny.net Support: support@bunny.net
