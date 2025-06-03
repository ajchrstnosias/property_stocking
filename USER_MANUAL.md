# USER MANUAL: Property Stocking

Welcome to Property Stocking! This guide explains how to use the system, whether you are a staff member looking to borrow items or an administrator managing the system.

---

**Part 1: User Guide (For Staff Borrowing Items)**

This section is for staff members who will be requesting and borrowing items.

## 1. Introduction

Property Stocking allows you to request items you need for your work. You can see the status of your requests and manage your account.

## 2. Getting Started

### 2.1 Accessing the System
*   You can access the system by navigating to its web address in your browser `http://127.0.0.1:8000`.

### 2.2 Registration (Creating a New Account)
If you don't have an account, you'll need to register:
1.  On the homepage (`http://127.0.0.1:8000`) or login page, look for a "Register" Button.
2.  Fill in the required information, such as your name, email address, and a password.
3.  Submit the registration form.

### 2.3 Logging In
1.  Click the "Login" link, found in the website's header or navigation bar.
2.  Enter your registered email address and password.
3.  Click the "Login" button.

## 3. Staff Dashboard

After logging in, you will be taken to your **Staff Dashboard**.
*   **Overview**:
    *   You'll see a summary card for "My Total Items Borrowed," showing the count of items currently issued to you.
*   **My Recent Item Requests**:
    *   A table lists your most recent item requests, showing:
        *   Date of request
        *   Item name
        *   Quantity requested
        *   Status (Pending, Approved, Denied)
*   **New Item Request Button**:
    *   You'll find a prominent "New Item Request" button to start the process of borrowing an item.

## 4. Creating a New Item Request

1.  From your dashboard or the "My Item Requests" page, click the "New Item Request" button.
2.  This will take you to the **Create New Item Request** form.
3.  **Fill in the form:**
    *   **Select Item** (Required): Choose an item from the dropdown list. The list shows the item name, current available quantity, and its category. Only items with available stock are listed.
    *   **Requested Quantity** (Required): Enter the number of units you want to borrow. This must be at least 1. The system will warn you if you try to request more than the available stock.
    *   **Reason/Remarks for Request**: Optionally, you can add any notes, reasons, or remarks for your request in this text area.
4.  **Submit**: Click the "Submit Request" button. You can click "Cancel" to return to the dashboard without submitting.

## 5. Viewing My Item Requests (`http://127.0.0.1:8000/my-requests`)

You can track all your past and current item requests:
1.  Navigate to the "My Item Requests" section (accessible from side navigation menu).
2.  **Filter Requests**: Use the "Filter by status" dropdown to view:
    *   All My Requests
    *   Pending Approval
    *   Approved (Issued)
    *   Pending Return
    *   Returned
    *   Denied
3.  **Request List**: The table displays your requests with the following details:
    *   **Req. ID**: The unique identifier for your request.
    *   **Item**: Name of the item, along with its Property Number and Serial Number (if applicable).
    *   **Qty Req.**: The quantity you requested.
    *   **Date Requested**: When you submitted the request.
    *   **Status**: The current status of your request (e.g., "Pending Approval," "Approved (Issued)").
    *   **Admin Remarks**: Any notes or comments added by an administrator regarding your request.
4.  **Download My Transactions (PDF)**:
    *   There's a button to "Download My Transactions (PDF)," which will generate a PDF report of your item request history.

## 6. Logging Out

When you are finished:
1.  Find the "Logout" link (in the navigation menu).
2.  Click it to securely end your session.

---

**Part 2: Administrator Guide**

This section is for administrators who manage the Property Stocking system, its inventory, and user requests.

## 1. Accessing the Admin Panel

*   Administrators typically access the admin panel via logging in with Admin cridentials

## 2. Admin Dashboard

The Admin Dashboard provides an overview and quick access to management functions:
*   **Admin-Specific Overview Cards**:
    *   **Total Items**: Total number of item types in the system.
    *   **Total Quantity In Stock**: Sum of quantities of all available items.
    *   **Categories**: Total number of item categories defined.
*   **All Currently Borrowed Items**:
    *   A table lists all items currently issued to any staff member, showing:
        *   Staff Name
        *   Item Name
        *   Property #
        *   Quantity borrowed
        *   Date Issued
*   **Recent Item Requests**:
    *   A view of all recent item requests from all users, similar to the staff view but comprehensive.

## 3. Managing Items (Inventory)

This section covers the management of all stockable items.

### 3.1 Viewing Items (`admin/items/index.blade.php`)
1.  Navigate to the "Manage Items" section in the admin panel.
2.  **Item List**: A table displays all items with details:
    *   Name, Category, Location
    *   Quantity (current stock)
    *   Property Number, Serial Number
    *   Status (e.g., Available, In Use, Borrowed, Under Maintenance, Disposed, Lost)
    *   Unit Cost, Acquisition Date
3.  **Actions per item**:
    *   **Edit**: Modify the item's details.
    *   **Delete**: Remove the item from the system (a confirmation prompt will appear).

### 3.2 Adding a New Item (`admin/items/create.blade.php`)
1.  Click the "Add New Item" button on the "Manage Items" page.
2.  **Fill out the form**:
    *   **Item Name** (Required)
    *   **Category** (Required, select from dropdown)
    *   **Location** (Required, select from dropdown)
    *   **Quantity** (Required, numeric)
    *   **Property Number** (Required)
    *   **Serial Number** (Optional)
    *   **Unit Cost** (Required, numeric)
    *   **Acquisition Date** (Optional, date)
    *   **Status** (Required, select from dropdown: Available, In Use, Borrowed, Under Maintenance, Disposed, Lost)
    *   **Description** (Optional, textarea)
    *   **Remarks** (Optional, textarea for internal notes)
3.  Click "Add Item" to save. "Cancel" discards changes.

### 3.3 Editing an Item (`admin/items/edit.blade.php`)
1.  From the item list, click "Edit" for the desired item.
2.  The form (same as add item form) will be pre-filled.
3.  Modify the details and click "Update Item" (or similar) to save.

## 4. Managing Item Requests (`admin/requests/index.blade.php`)

This is where administrators approve, deny, and track item requests from users.

1.  Access via "Item Requests" (from admin dashboard or menu).
2.  **Request List**: Displays all requests with comprehensive details:
    *   Req. ID, Requested By, Item (Name, Prop#, SN), Qty Req., Item Stock (current), Date Requested, Status, Admin Remarks.
3.  **Filtering Requests**:
    *   Use the status dropdown to filter by: All, Pending Approval, Approved (Issued), Pending Return, Returned, Denied.
4.  **Processing Pending Issuance Requests (Status: "Pending Approval")**:
    *   **Approve Issuance**:
        *   Click "Approve Issuance."
        *   Confirm the action. This updates the request status and deducts the item quantity from stock.
    *   **Deny Issuance**:
        *   Click "Deny."
        *   A modal appears to optionally enter a "Reason for Denial."
        *   Confirm to deny the request. Stock is not affected.
5.  **Processing Pending Return Requests (Status: "Pending Return Approval")**:
    *   These requests appear when a user has marked an item for return.
    *   **Approve Return**:
        *   Click "Approve Return."
        *   Confirm. This updates the request status (e.g., to "Returned") and updates the item's stock.
    *   **Deny Return**:
        *   Click "Deny Return."
        *   A modal appears to optionally enter a "Reason for Denying Return."
        *   Confirm. The item status might revert or go into a disputed state as per system rules.
6.  **Viewing Processed Requests**:
    *   For requests already processed, the list typically shows who processed it and when.

## 5. Managing Categories (`admin/categories/`)

Organize items by category.

### 5.1 Viewing Categories (`admin/categories/index.blade.php`)
1.  Navigate to the "Categories" section.
2.  **Category List**: Displays Name, Description, and Items Count (number of items in that category).
3.  **Search**: Search for categories.
4.  **Actions per category**:
    *   **Edit**: Modify category details.
    *   **Delete**: Remove category (confirmation prompt).

### 5.2 Adding a New Category (`admin/categories/create.blade.php` using `_form.blade.php`)
1.  Click "New Category."
2.  **Fill out the form**:
    *   **Name** (Required)
    *   **Description** (Optional, textarea)
3.  Click "Create Category."

### 5.3 Editing a Category (`admin/categories/edit.blade.php` using `_form.blade.php`)
1.  From the category list, click "Edit."
2.  Modify details and click "Update Category."

## 6. Managing Locations (`admin/locations/`)

Manage physical or logical locations for items.

### 6.1 Viewing Locations (`admin/locations/index.blade.php`)
1.  Navigate to the "Locations" section.
2.  **Location List**: Displays Name, Description, and Items Count.
3.  **Search**: Search for locations.
4.  **Actions per location**:
    *   **Edit**: Modify location details.
    *   **Delete**: Remove location (confirmation prompt).

### 6.2 Adding a New Location (`admin/locations/create.blade.php` using `_form.blade.php`)
1.  Click "New Location."
2.  **Fill out the form**:
    *   **Name** (Required)
    *   **Description** (Optional, textarea)
3.  Click "Create Location."

### 6.3 Editing a Location (`admin/locations/edit.blade.php` using `_form.blade.php`)
1.  From the location list, click "Edit."
2.  Modify details and click "Update Location."

## 7. Generating Reports (`admin/reports/transactions_form.blade.php`)

Administrators can generate transaction reports.
1.  Navigate to the "Reports" or "Transaction Report" section.
2.  **Select Date Range**:
    *   **Start Date** (Optional, date picker)
    *   **End Date** (Optional, date picker)
    *   If both are left blank, the report will include all transactions.
3.  **Generate PDF**: Click the "Generate PDF Report" button. The report will open in a new browser tab. This report likely details item issuance and return transactions within the specified period.
