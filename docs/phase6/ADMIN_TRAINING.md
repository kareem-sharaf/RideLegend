# Admin Panel Training Guide
## Premium Bikes Marketplace

**Version:** 1.0  
**Date:** 2024

---

## 📋 Table of Contents

1. [Getting Started](#getting-started)
2. [Dashboard Overview](#dashboard-overview)
3. [User Management](#user-management)
4. [Product Management](#product-management)
5. [Order Processing](#order-processing)
6. [Payment Handling](#payment-handling)
7. [Inspection Review](#inspection-review)
8. [Trade-in Management](#trade-in-management)
9. [Settings Configuration](#settings-configuration)
10. [Monitoring & Logs](#monitoring--logs)

---

## Getting Started

### Accessing Admin Panel

1. Navigate to: `https://yourdomain.com/admin/dashboard`
2. Login with admin credentials
3. You'll see the dashboard with statistics

### Navigation

- **Sidebar**: Main navigation menu
- **Header**: User info and logout
- **Main Area**: Current page content

---

## Dashboard Overview

### Statistics Cards

- **Total Users**: All registered users
- **Total Revenue**: Sum of all completed orders
- **Total Orders**: All orders in system
- **Total Products**: All listed products

### Charts

- **Sales Chart**: Orders over last 30 days
- **Revenue Chart**: Revenue over last 12 months
- **Status Charts**: Distribution by status

### Recent Activity

- **Recent Orders**: Last 10 orders
- **Recent Users**: Last 10 registrations

---

## User Management

### Viewing Users

1. Go to **Users** in sidebar
2. Use filters:
   - **Role**: Filter by buyer/seller/workshop/admin
   - **Search**: Search by name or email

### User Actions

#### View User Details
- Click **View** to see:
  - User information
  - Statistics (products, orders, spending)
  - Roles and permissions

#### Edit User
- Click **Edit** to modify:
  - Name, email, phone
  - Role assignment
  - Spatie Permission roles

#### Toggle Status
- Click **Activate/Deactivate** to:
  - Enable/disable user account
  - Control access

#### Delete User
- Click **Delete** (with confirmation)
- **Note**: Cannot delete your own account

---

## Product Management

### Viewing Products

1. Go to **Products** in sidebar
2. Filter by:
   - **Status**: pending/approved/rejected
   - **Search**: Search by title, brand, model

### Product Actions

#### Approve Product
1. Click **Approve** on pending products
2. Product status changes to "approved"
3. Product becomes visible to buyers

#### Reject Product
1. Click **Reject** on pending products
2. Product status changes to "rejected"
3. Product is hidden from buyers

#### Delete Product
- Click **Delete** to permanently remove
- **Warning**: This action cannot be undone

---

## Order Processing

### Viewing Orders

1. Go to **Orders** in sidebar
2. Filter by:
   - **Status**: pending/confirmed/processing/shipped/delivered/cancelled
   - **Search**: Order number or customer name

### Order Actions

#### Update Order Status

1. Open order details
2. Select new status from dropdown
3. Click **Update Status**

**Status Flow**:
```
pending → confirmed → processing → shipped → delivered
```

#### Generate Invoice

1. Click **Invoice** button
2. PDF invoice downloads automatically
3. Contains:
   - Order details
   - Customer information
   - Items and pricing
   - Payment information

---

## Payment Handling

### Viewing Payments

1. Go to **Payments** in sidebar
2. Filter by:
   - **Status**: pending/processing/completed/failed/refunded
   - **Payment Method**: credit_card/paypal/stripe/etc.

### Refund Processing

1. Open payment details
2. Click **Refund**
3. Enter:
   - **Amount**: Full or partial refund
   - **Reason**: Optional reason
4. Confirm refund

**Note**: Only completed payments can be refunded

---

## Inspection Review

### Viewing Inspections

1. Go to **Inspections** in sidebar
2. Filter by status
3. View inspection details:
   - Product information
   - Inspection report
   - Images
   - Workshop details

### Inspection Actions

#### Approve Inspection
- Changes status to "approved"
- Product can proceed to certification

#### Reject Inspection
- Changes status to "rejected"
- Product requires re-inspection

---

## Trade-in Management

### Viewing Trade-ins

1. Go to **Trade-ins** in sidebar
2. Filter by status
3. View details:
   - Buyer information
   - Bike details
   - Valuation
   - Request information

### Trade-in Actions

#### Approve Trade-in

1. Review valuation
2. Click **Approve**
3. Enter credit amount
4. System creates credit for buyer
5. Status changes to "approved"

#### Reject Trade-in

1. Click **Reject**
2. Enter rejection reason
3. Status changes to "rejected"
4. Buyer is notified

---

## Settings Configuration

### Accessing Settings

1. Go to **Settings** in sidebar
2. View current configuration

### Configurable Settings

#### Commission Fees
- **Commission Rate**: Total platform commission (%)
- **Seller Commission Rate**: Seller commission (%)
- **Platform Fee**: Additional service fee (%)

#### Service Fees
- **Inspection Fee**: Cost per inspection ($)
- **Shipping Base Cost**: Base shipping rate ($)

### Updating Settings

1. Modify values in form
2. Click **Save Settings**
3. Changes take effect immediately

---

## Monitoring & Logs

### Accessing Logs

Logs are stored in: `storage/logs/`

### Log Files

- **laravel.log**: General application logs
- **admin.log**: Admin panel activities
- **payments.log**: Payment transactions
- **security.log**: Security events

### Monitoring Tools

#### Laravel Telescope (Development)
- Access at: `/telescope`
- View queries, requests, jobs

#### Sentry (Production)
- Error tracking
- Performance monitoring
- Alert notifications

### Health Checks

- **Endpoint**: `/up`
- **Status**: Returns 200 if healthy
- **Use**: Uptime monitoring services

---

## Best Practices

### Daily Tasks

1. Review pending products
2. Process pending orders
3. Check payment issues
4. Review inspection requests
5. Monitor error logs

### Weekly Tasks

1. Review user registrations
2. Analyze sales trends
3. Check system performance
4. Review security logs
5. Update settings if needed

### Monthly Tasks

1. Generate reports
2. Review user feedback
3. Analyze metrics
4. Plan improvements
5. Backup verification

---

## Troubleshooting

### Common Issues

#### Cannot Access Admin Panel
- Verify admin role assigned
- Check authentication
- Clear browser cache

#### Statistics Not Updating
- Clear application cache: `php artisan cache:clear`
- Wait for cache expiration (5 minutes)

#### Orders Not Processing
- Check queue workers: `sudo supervisorctl status`
- Restart workers if needed

#### Payment Issues
- Check payment gateway logs
- Verify API credentials
- Review transaction logs

---

## Support Resources

### Documentation
- Phase 5 README: `docs/phase5/README.md`
- API Documentation: `docs/phase3/API_ENDPOINTS.md`

### Contact
- Technical Support: support@premiumbikes.com
- Emergency: [emergency contact]

---

**Last Updated**: 2024

