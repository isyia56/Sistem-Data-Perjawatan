# UAT List for Waran (Complaint/Issue) Section

| No | Test Case | Steps | Expected Result | Actual Result | Status (Pass/Fail) | Notes |
|---|---|---|---|---|---|---|
| 1 | Access Waran list page | 1. Log in as Admin. 2. Navigate to Waran section. 3. Verify page loads. | Waran list page displays with all records visible. | | | |
| 2 | Display list statistics | 1. Open Waran list page. 2. Observe statistics cards. | Display "Jumlah Waran = 7", "Waran Seimbang = 3", "Waran Tidak Seimbang = 4". | | | |
| 3 | Display table columns | 1. Open Waran list page. 2. Verify all columns visible. | Table shows BIL, MAKLUMAT WARAN, BUTIRAN, AKTIVITI, PENEMPATAN, J, I, K, STATUS columns. | | | |
| 4 | Create new Waran | 1. Click "Tambah Waran" button. 2. Fill in all required fields. 3. Click Save. | New Waran record created successfully with success message. | | | |
| 5 | Validate required fields on create | 1. Open create form. 2. Leave required fields empty. 3. Attempt to save. | Form validation prevents save, shows error messages for missing fields. | | | |
| 6 | Pre-populate edit form | 1. Click Edit on existing record. 2. Observe form fields. | All fields pre-populated with existing values. | | | |
| 7 | Edit existing Waran | 1. Click Edit on a record. 2. Modify fields. 3. Click Save. | Record updated successfully with success message. | | | |
| 8 | View record details | 1. Click View/action icon on a record. 2. Observe detail view. | All record fields display correctly with relationship data. | | | |
| 9 | Delete single Waran | 1. Click Delete on a record. 2. Click "Ya, Padam" on confirmation modal. | Record deleted successfully, removed from list, success message displayed. | | | |
| 10 | Delete confirmation modal | 1. Click Delete on a record. 2. Observe modal. | Modal shows confirmation with "Ya, Padam" and "Batal" buttons. | | | |
| 11 | Cancel delete action | 1. Click Delete on a record. 2. Click "Batal" button. | Modal closes, record remains in list unchanged. | | | |
| 12 | Filter by PROGRAM ALL | 1. Click "ALL" tab. 2. Verify records displayed. | All Waran records display regardless of program. | | | |
| 13 | Filter by PROGRAM 1 | 1. Click "PROGRAM 1" tab. 2. Verify filtered results. | Only PROGRAM 1 records display, statistics update accordingly. | | | |
| 14 | Filter by PROGRAM 2 | 1. Click "PROGRAM 2" tab. 2. Verify filtered results. | Only PROGRAM 2 records display, statistics update accordingly. | | | |
| 15 | Filter by PROGRAM 3 | 1. Click "PROGRAM 3" tab. 2. Verify filtered results. | Only PROGRAM 3 records display, statistics update accordingly. | | | |
| 16 | Filter by PROGRAM 4 | 1. Click "PROGRAM 4" tab. 2. Verify filtered results. | Only PROGRAM 4 records display, statistics update accordingly. | | | |
| 17 | Filter by PROGRAM 5 | 1. Click "PROGRAM 5" tab. 2. Verify filtered results. | Only PROGRAM 5 records display, statistics update accordingly. | | | |
| 18 | Filter by PROGRAM 7 | 1. Click "PROGRAM 7" tab. 2. Verify filtered results. | Only PROGRAM 7 records display, statistics update accordingly. | | | |
| 19 | Search by MAKLUMAT WARAN | 1. Enter search term in search field. 2. Press Enter or wait for auto-filter. | Results filtered to show matching records only. | | | |
| 20 | Sort MAKLUMAT WARAN column | 1. Click MAKLUMAT WARAN column header. 2. Verify sort order. | Records sorted alphabetically ascending/descending as indicated. | | | |
| 21 | Sort PENEMPATAN column | 1. Click PENEMPATAN column header. 2. Verify sort order. | Records sorted alphabetically ascending/descending as indicated. | | | |
| 22 | Sort STATUS column | 1. Click STATUS column header. 2. Verify sort order. | Records sorted by status value. | | | |
| 23 | Display STATUS color coding | 1. Open Waran list. 2. Observe status column. | "Kurang" shows in orange/warning color, "Baik" shows in green/success color. | | | |
| 24 | Bulk delete multiple records | 1. Select multiple records via checkboxes. 2. Click bulk delete button. 3. Confirm deletion. | All selected records deleted, success message shows count. | | | |
| 25 | Bulk select all | 1. Click "Select All" checkbox. 2. Verify all records selected. | All visible records checked, bulk action toolbar appears. | | | |
| 26 | View action button | 1. Click View/action icon on record. 2. Verify detail page loads. | Detailed view opens showing all record information. | | | |
| 27 | Edit action button | 1. Click Edit/action icon on record. 2. Verify form opens. | Edit form opens with pre-populated data. | | | |
| 28 | Delete action button | 1. Click Delete/action icon on record. 2. Verify modal appears. | Confirmation modal displayed with delete options. | | | |
| 29 | Navigation menu display | 1. Check sidebar navigation. 2. Locate Waran menu item. | "Waran" menu item visible under "Buku Waran" group with badge showing count (4). | | | |
| 30 | Navigation click | 1. Click "Waran" in navigation menu. 2. Verify page loads. | Waran list page loads with all records displayed. | | | |
| 31 | Data integrity - BIL unique | 1. View multiple Waran records. 2. Check BIL values. | Each record has unique BIL reference number. | | | |
| 32 | Data integrity - Required fields stored | 1. Create/edit Waran with all fields. 2. Check database. | MAKLUMAT WARAN, BUTIRAN, AKTIVITI, PENEMPATAN stored correctly. | | | |
| 33 | Data integrity - Relationships | 1. View Waran record linked to Program. 2. Verify program data. | Related program/activity data displays correctly. | | | |
| 34 | Back to list from view | 1. Open Waran view page. 2. Click Back button. | Returns to list page with previous filters/sorting preserved. | | | |
| 35 | Edit from view page | 1. Open Waran view page. 2. Click Edit button. | Edit form opens with record data pre-populated. | | | |
| 36 | Mobile responsive list | 1. Open list on mobile device. 2. Verify layout. | Columns stack appropriately, content readable without horizontal scroll. | | | |
| 37 | Mobile responsive form | 1. Open create/edit form on mobile. 2. Verify usability. | Form fields accessible and usable on mobile screen size. | | | |
| 38 | Mobile action buttons | 1. Open list on mobile. 2. Test action buttons. | View, Edit, Delete buttons accessible and functional on mobile. | | | |
| 39 | Form validation - empty MAKLUMAT WARAN | 1. Leave MAKLUMAT WARAN field empty. 2. Attempt to save. | Validation error message displayed, save prevented. | | | |
| 40 | Form validation - empty BUTIRAN | 1. Leave BUTIRAN field empty. 2. Attempt to save. | Validation error message displayed, save prevented. | | | |
| 41 | Long text handling | 1. Enter very long text in MAKLUMAT WARAN. 2. Save and verify display. | Long text stored correctly, table column truncates appropriately. | | | |
| 42 | Special characters handling | 1. Enter special characters in text fields. 2. Save and retrieve. | Special characters stored and displayed correctly without errors. | | | |
| 43 | Statistics calculation | 1. Add/delete records. 2. Observe statistics update. | Statistics (Jumlah, Seimbang, Tidak Seimbang) update correctly. | | | |
| 44 | Timestamp fields | 1. Create new Waran. 2. Check created_at/updated_at. | Timestamp fields recorded correctly for creation and updates. | | | |
| 45 | Unauthorized access denied | 1. Access as non-admin user. 2. Navigate to Waran section. | Access denied with appropriate error message or redirect. | | | |
