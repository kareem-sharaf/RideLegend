# Wireframes Documentation
## Premium Bikes Managed Marketplace

**Version:** 1.0  
**Date:** 2024  
**Status:** Phase 1 - Discovery & Architecture

---

## Table of Contents

1. [Overview](#1-overview)
2. [Design Principles](#2-design-principles)
3. [Homepage](#3-homepage)
4. [Product Listing & Filtering](#4-product-listing--filtering)
5. [Product Detail Page](#5-product-detail-page)
6. [Checkout Pages](#6-checkout-pages)
7. [Seller Dashboard](#7-seller-dashboard)
8. [Workshop Dashboard](#8-workshop-dashboard)
9. [Trade-in Form](#9-trade-in-form)
10. [Admin Panel](#10-admin-panel)

---

## 1. Overview

This document provides detailed text-based wireframe descriptions for the Premium Bikes Managed Marketplace. These wireframes serve as specifications for Figma design implementation and follow DDD principles with clear user flow rationale and clean UI principles.

### 1.1 Wireframe Purpose
- Define component hierarchy and layout
- Specify user interactions and flows
- Establish information architecture
- Guide frontend development with Tailwind CSS

### 1.2 Design System
- **Framework**: Tailwind CSS
- **Components**: Reusable Blade components
- **Responsive**: Mobile-first approach
- **Accessibility**: WCAG 2.1 AA compliance

---

## 2. Design Principles

### 2.1 Clean UI Principles
- **Minimalism**: Clean, uncluttered interfaces
- **Hierarchy**: Clear visual hierarchy with typography and spacing
- **Consistency**: Uniform component usage across pages
- **Feedback**: Clear visual feedback for user actions
- **Progressive Disclosure**: Show information progressively

### 2.2 User Flow Rationale
- **Linear Flows**: For checkout and inspection processes
- **Non-linear Navigation**: For browsing and discovery
- **Contextual Actions**: Actions available where needed
- **Clear CTAs**: Prominent call-to-action buttons

### 2.3 DDD Alignment
- **Bounded Contexts**: Each module has distinct UI patterns
- **Domain Language**: Use domain terminology in UI
- **Aggregate Views**: Show aggregate roots prominently
- **State Indicators**: Visual representation of entity states

---

## 3. Homepage

### 3.1 Layout Structure

```
┌─────────────────────────────────────────────────────────┐
│ Header (Sticky)                                          │
│ ┌──────────┐  ┌──────────┐  ┌──────────┐  ┌──────────┐│
│ │ Logo     │  │ Search   │  │ Cart (3) │  │ Profile  ││
│ └──────────┘  └──────────┘  └──────────┘  └──────────┘│
├─────────────────────────────────────────────────────────┤
│ Hero Section (Full Width)                                │
│ ┌─────────────────────────────────────────────────────┐ │
│ │ Premium Bikes Marketplace                          │ │
│ │ Trusted. Certified. Premium.                       │ │
│ │ [Browse Collection] [Sell Your Bike]               │ │
│ │ [Hero Image: Premium Bike]                         │ │
│ └─────────────────────────────────────────────────────┘ │
├─────────────────────────────────────────────────────────┤
│ Featured Categories (Grid: 3 columns)                    │
│ ┌──────────┐  ┌──────────┐  ┌──────────┐              │
│ │ Road     │  │ Mountain │  │ Electric │              │
│ │ Bikes    │  │ Bikes    │  │ Bikes    │              │
│ └──────────┘  └──────────┘  └──────────┘              │
├─────────────────────────────────────────────────────────┤
│ Featured Products (Carousel)                              │
│ ┌──────┐ ┌──────┐ ┌──────┐ ┌──────┐ ┌──────┐           │
│ │Card  │ │Card  │ │Card  │ │Card  │ │Card  │           │
│ └──────┘ └──────┘ └──────┘ └──────┘ └──────┘           │
├─────────────────────────────────────────────────────────┤
│ Why Choose Us (3 Column Grid)                            │
│ ┌──────────┐  ┌──────────┐  ┌──────────┐              │
│ │ Certified│  │ Trade-in │  │ Expert   │              │
│ │ Quality  │  │ Program  │  │ Support  │              │
│ └──────────┘  └──────────┘  └──────────┘              │
├─────────────────────────────────────────────────────────┤
│ Footer                                                    │
│ Links | Social | Newsletter                              │
└─────────────────────────────────────────────────────────┘
```

### 3.2 Components

#### Header Component
- **Logo**: Left-aligned, links to homepage
- **Search Bar**: Centered, full-text search with autocomplete
- **Cart Icon**: Right-aligned, badge showing item count
- **Profile Menu**: Dropdown with user actions (Login/Register if guest)

#### Hero Section
- **Headline**: "Premium Bikes Marketplace"
- **Subheadline**: "Trusted. Certified. Premium."
- **CTAs**: 
  - Primary: "Browse Collection" (links to products)
  - Secondary: "Sell Your Bike" (links to seller registration)
- **Hero Image**: High-quality bike image, parallax effect optional

#### Featured Categories
- **Layout**: 3-column grid (responsive: 1 column mobile, 2 tablet, 3 desktop)
- **Card Structure**:
  - Category image (aspect ratio 16:9)
  - Category name
  - Product count
  - Hover effect: slight scale and shadow

#### Featured Products Carousel
- **Layout**: Horizontal scrollable carousel
- **Card Components** (see Product Card below)
- **Navigation**: Arrow buttons, dot indicators
- **Auto-play**: Optional, with pause on hover

#### Why Choose Us Section
- **Layout**: 3-column grid
- **Icons**: Premium icons (SVG)
- **Content**: 
  - Icon
  - Title
  - Short description
- **Visual**: Clean, minimal design

### 3.3 User Flow Rationale
- **Immediate Value**: Hero section communicates value proposition
- **Discovery**: Categories and featured products enable exploration
- **Trust Building**: "Why Choose Us" establishes credibility
- **Clear Navigation**: Header provides access to all key areas

### 3.4 Responsive Behavior
- **Mobile**: Single column, stacked sections, hamburger menu
- **Tablet**: 2-column grids, expanded header
- **Desktop**: Full 3-column layouts, expanded hero

---

## 4. Product Listing & Filtering

### 4.1 Layout Structure

```
┌─────────────────────────────────────────────────────────┐
│ Header (Sticky)                                          │
├─────────────────────────────────────────────────────────┤
│ Breadcrumbs: Home > Products > Road Bikes                │
├─────────────────────────────────────────────────────────┤
│ Page Title: "Premium Road Bikes"                        │
│ Results: Showing 1-24 of 156 products                   │
├──────────────┬──────────────────────────────────────────┤
│ Sidebar      │ Main Content Area                         │
│ (Filters)    │                                           │
│              │ ┌──────────────────────────────────────┐│
│ ┌──────────┐ │ │ Sort: [Relevance ▼] [Grid/List View] ││
│ │ Price    │ │ └──────────────────────────────────────┘│
│ │ Range    │ │                                           │
│ │ [$]─[$]  │ │ ┌──────┐ ┌──────┐ ┌──────┐ ┌──────┐    │
│ └──────────┘ │ │Card  │ │Card  │ │Card  │ │Card  │    │
│              │ └──────┘ └──────┘ └──────┘ └──────┘    │
│ ┌──────────┐ │ ┌──────┐ ┌──────┐ ┌──────┐ ┌──────┐    │
│ │ Brand    │ │ │Card  │ │Card  │ │Card  │ │Card  │    │
│ │ ☑ Trek   │ │ └──────┘ └──────┘ └──────┘ └──────┘    │
│ │ ☐ Special│ │                                           │
│ │ ☐ Giant  │ │ [Pagination: 1 2 3 ... 7]                │
│ └──────────┘ │                                           │
│              │                                           │
│ ┌──────────┐ │                                           │
│ │ Condition│ │                                           │
│ │ ☑ New    │ │                                           │
│ │ ☑ Like N.│ │                                           │
│ └──────────┘ │                                           │
│              │                                           │
│ ┌──────────┐ │                                           │
│ │ Year     │ │                                           │
│ │ [2018]─[2024]│                                         │
│ └──────────┘ │                                           │
│              │                                           │
│ [Clear Filters]                                          │
└──────────────┴──────────────────────────────────────────┘
```

### 4.2 Components

#### Filter Sidebar
- **Sticky**: Stays visible on scroll (desktop)
- **Sections**:
  - **Price Range**: Dual slider input
  - **Brand**: Checkbox list (searchable)
  - **Condition**: Checkbox list
  - **Year**: Range input
  - **Category**: Hierarchical tree
  - **Certification Status**: Toggle (Certified only)
- **Clear Filters**: Button to reset all filters
- **Active Filters**: Chips showing applied filters

#### Product Grid
- **Layout**: 4 columns desktop, 3 tablet, 2 mobile
- **View Toggle**: Grid/List view switcher
- **Sort Options**: 
  - Relevance (default)
  - Price: Low to High
  - Price: High to Low
  - Newest First
  - Certification Grade

#### Product Card Component
```
┌─────────────────────┐
│ [Product Image]     │
│ [Certified Badge]   │
│                     │
│ Brand Model (Year)  │
│ Condition: Excellent│
│ $X,XXX              │
│ [View Details]      │
└─────────────────────┘
```

**Card Elements**:
- **Image**: Primary product image, hover shows additional images
- **Certification Badge**: Green badge if certified
- **Title**: Brand, Model, Year
- **Condition**: Text badge with color coding
- **Price**: Large, prominent
- **CTA**: "View Details" button

#### Pagination
- **Layout**: Numbered pages with prev/next
- **Info**: "Showing X-Y of Z products"
- **Per Page**: Dropdown (24, 48, 96)

### 4.3 User Flow Rationale
- **Progressive Filtering**: Filters narrow results incrementally
- **Quick Comparison**: Grid view enables visual comparison
- **Clear Feedback**: Active filters visible, result count updates
- **Efficient Navigation**: Pagination and sorting for large result sets

### 4.4 DDD Alignment
- **Product Aggregate**: Cards represent product aggregates
- **Search Criteria**: Filters map to SearchCriteria value object
- **Specification Pattern**: Filters use specification pattern in backend

---

## 5. Product Detail Page

### 5.1 Layout Structure

```
┌─────────────────────────────────────────────────────────┐
│ Header (Sticky)                                          │
├─────────────────────────────────────────────────────────┤
│ Breadcrumbs: Home > Products > Road Bikes > [Product]   │
├─────────────────────────────────────────────────────────┤
│ ┌──────────────────┬──────────────────────────────────┐ │
│ │ Image Gallery    │ Product Information               │ │
│ │                  │                                   │ │
│ │ [Main Image]     │ Brand Model (Year)                │ │
│ │                  │ Condition: Excellent              │ │
│ │ [Thumbnails]     │ [Certified Badge]                 │ │
│ │ ┌──┐ ┌──┐ ┌──┐  │                                   │ │
│ │ │  │ │  │ │  │  │ Price: $X,XXX                     │ │
│ │ └──┘ └──┘ └──┘  │                                   │ │
│ │                  │ [Add to Cart] [Buy Now]          │ │
│ │                  │                                   │ │
│ │                  │ ┌──────────────────────────────┐ │ │
│ │                  │ │ Specifications               │ │
│ │                  │ │ Frame: Carbon                │ │
│ │                  │ │ Groupset: Shimano 105        │ │
│ │                  │ │ ...                          │ │
│ │                  │ └──────────────────────────────┘ │ │
│ │                  │                                   │ │
│ │                  │ ┌──────────────────────────────┐ │ │
│ │                  │ │ Certification Report          │ │
│ │                  │ │ Grade: Excellent              │ │
│ │                  │ │ Issued: [Date]                │ │
│ │                  │ │ [View Full Report]           │ │
│ │                  │ └──────────────────────────────┘ │ │
│ └──────────────────┴──────────────────────────────────┘ │
├─────────────────────────────────────────────────────────┤
│ Description Section                                       │
│ ┌─────────────────────────────────────────────────────┐ │
│ │ Detailed Description                                 │ │
│ │ [Long form text]                                     │ │
│ └─────────────────────────────────────────────────────┘ │
├─────────────────────────────────────────────────────────┤
│ Seller Information                                        │
│ ┌─────────────────────────────────────────────────────┐ │
│ │ Seller: [Name] | Rating: ⭐⭐⭐⭐⭐              │ │
│ │ [Contact Seller] [View Profile]                    │ │
│ └─────────────────────────────────────────────────────┘ │
├─────────────────────────────────────────────────────────┤
│ Related Products (Carousel)                               │
│ ┌──────┐ ┌──────┐ ┌──────┐ ┌──────┐                    │
│ │Card  │ │Card  │ │Card  │ │Card  │                    │
│ └──────┘ └──────┘ └──────┘ └──────┘                    │
└─────────────────────────────────────────────────────────┘
```

### 5.2 Components

#### Image Gallery
- **Main Image**: Large display, zoom on hover
- **Thumbnails**: Scrollable row below main image
- **Navigation**: Arrow buttons, click to change main image
- **Lightbox**: Full-screen view on click

#### Product Information Panel
- **Title**: Brand, Model, Year (large, bold)
- **Condition Badge**: Color-coded (New=green, Excellent=blue, etc.)
- **Certification Badge**: Prominent if certified
- **Price**: Large, prominent display
- **Actions**:
  - **Add to Cart**: Primary button
  - **Buy Now**: Secondary button (direct checkout)
- **Availability**: Status indicator

#### Specifications Table
- **Layout**: Two-column table
- **Content**: Key-value pairs from ProductSpecification
- **Sections**: 
  - Frame & Fork
  - Groupset
  - Wheels & Tires
  - Dimensions
  - Weight

#### Certification Report Card
- **Layout**: Highlighted card/box
- **Content**:
  - Certification Grade (badge)
  - Issued Date
  - Workshop Name
  - Expiration Date (if applicable)
  - **CTA**: "View Full Report" (opens PDF/modal)

#### Description Section
- **Content**: Rich text description
- **Formatting**: Headers, lists, paragraphs
- **Images**: Inline images if provided

#### Seller Information Card
- **Seller Name**: Link to profile
- **Rating**: Star display with count
- **Actions**:
  - "Contact Seller" (opens message modal)
  - "View Profile" (links to seller page)

### 5.3 User Flow Rationale
- **Visual First**: Large images for product assessment
- **Trust Indicators**: Certification badge prominent
- **Quick Actions**: Add to cart/Buy now easily accessible
- **Detailed Info**: Expandable sections for specifications
- **Social Proof**: Seller rating and certification

### 5.4 DDD Alignment
- **Product Aggregate**: Page represents complete product aggregate
- **Certification Entity**: Certification report displayed prominently
- **Value Objects**: Specifications shown as value objects

---

## 6. Checkout Pages

### 6.1 Multi-Step Checkout Flow

#### Step 1: Cart Review

```
┌─────────────────────────────────────────────────────────┐
│ Header                                                   │
├─────────────────────────────────────────────────────────┤
│ Checkout Progress: [●] Cart [○] Shipping [○] Payment   │
├─────────────────────────────────────────────────────────┤
│ Shopping Cart                                            │
│ ┌─────────────────────────────────────────────────────┐ │
│ │ Product 1                                            │ │
│ │ [Image] Brand Model | $X,XXX | [Remove]            │ │
│ └─────────────────────────────────────────────────────┘ │
│ ┌─────────────────────────────────────────────────────┐ │
│ │ Product 2                                            │ │
│ │ [Image] Brand Model | $X,XXX | [Remove]            │ │
│ └─────────────────────────────────────────────────────┘ │
│                                                           │
│ Order Summary (Sticky Sidebar)                          │
│ ┌─────────────────────────────────────────────────────┐ │
│ │ Subtotal: $X,XXX                                    │ │
│ │ Shipping: Calculated at next step                   │ │
│ │ Tax: Calculated at next step                        │ │
│ │ ─────────────────────────────────                   │ │
│ │ Total: $X,XXX                                      │ │
│ │                                                     │ │
│ │ [Continue to Shipping]                             │ │
│ └─────────────────────────────────────────────────────┘ │
└─────────────────────────────────────────────────────────┘
```

#### Step 2: Shipping Information

```
┌─────────────────────────────────────────────────────────┐
│ Header                                                   │
├─────────────────────────────────────────────────────────┤
│ Checkout Progress: [●] Cart [●] Shipping [○] Payment   │
├─────────────────────────────────────────────────────────┤
│ Shipping Address                                         │
│ ┌─────────────────────────────────────────────────────┐ │
│ │ First Name: [_____________]                          │ │
│ │ Last Name:  [_____________]                          │ │
│ │ Address:    [_____________]                          │ │
│ │ City:       [_____________]                          │ │
│ │ State:      [Dropdown ▼]                             │ │
│ │ ZIP:        [_____________]                          │ │
│ │ Phone:      [_____________]                          │ │
│ │ ☐ Same as billing                                    │ │
│ └─────────────────────────────────────────────────────┘ │
│                                                           │
│ Shipping Method                                          │
│ ┌─────────────────────────────────────────────────────┐ │
│ │ ☑ Standard Shipping (5-7 days) - $XX.XX            │ │
│ │ ☐ Express Shipping (2-3 days) - $XX.XX             │ │
│ │ ☐ Overnight Shipping - $XX.XX                      │ │
│ └─────────────────────────────────────────────────────┘ │
│                                                           │
│ Order Summary (Updated)                                   │
│ ┌─────────────────────────────────────────────────────┐ │
│ │ Subtotal: $X,XXX                                    │ │
│ │ Shipping: $XX.XX                                    │ │
│ │ Tax: $XX.XX                                         │ │
│ │ ─────────────────────────────────                   │ │
│ │ Total: $X,XXX                                       │ │
│ │                                                     │ │
│ │ [Back] [Continue to Payment]                       │ │
│ └─────────────────────────────────────────────────────┘ │
└─────────────────────────────────────────────────────────┘
```

#### Step 3: Payment

```
┌─────────────────────────────────────────────────────────┐
│ Header                                                   │
├─────────────────────────────────────────────────────────┤
│ Checkout Progress: [●] Cart [●] Shipping [●] Payment    │
├─────────────────────────────────────────────────────────┤
│ Payment Method                                           │
│ ┌─────────────────────────────────────────────────────┐ │
│ │ ☑ Credit Card                                       │ │
│ │   Card Number: [________________]                    │ │
│ │   Expiry: [MM/YY] CVC: [___]                        │ │
│ │   Name on Card: [_____________]                      │ │
│ │                                                     │ │
│ │ ☐ PayPal                                             │ │
│ │ ☐ Trade-in Credit ($XXX.XX available)              │ │
│ └─────────────────────────────────────────────────────┘ │
│                                                           │
│ Billing Address (if different)                            │
│ ┌─────────────────────────────────────────────────────┐ │
│ │ [Same as shipping] or [Enter different address]    │ │
│ └─────────────────────────────────────────────────────┘ │
│                                                           │
│ Order Summary (Final)                                     │
│ ┌─────────────────────────────────────────────────────┐ │
│ │ Items (2): $X,XXX                                    │ │
│ │ Shipping: $XX.XX                                     │ │
│ │ Tax: $XX.XX                                          │ │
│ │ ─────────────────────────────────                   │ │
│ │ Total: $X,XXX                                        │ │
│ │                                                     │ │
│ │ ☐ I agree to Terms & Conditions                    │ │
│ │                                                     │ │
│ │ [Back] [Place Order]                                │ │
│ └─────────────────────────────────────────────────────┘ │
└─────────────────────────────────────────────────────────┘
```

#### Step 4: Order Confirmation

```
┌─────────────────────────────────────────────────────────┐
│ Header                                                   │
├─────────────────────────────────────────────────────────┤
│ ✅ Order Confirmed!                                      │
│                                                           │
│ Order #12345                                             │
│ Thank you for your purchase!                            │
│                                                           │
│ ┌─────────────────────────────────────────────────────┐ │
│ │ Order Details                                        │ │
│ │ Items: 2                                             │ │
│ │ Total: $X,XXX                                        │ │
│ │ Shipping: Standard (5-7 days)                        │ │
│ │                                                      │ │
│ │ Estimated Delivery: [Date]                          │ │
│ └─────────────────────────────────────────────────────┘ │
│                                                           │
│ [View Order] [Continue Shopping]                         │
└─────────────────────────────────────────────────────────┘
```

### 6.2 Components

#### Progress Indicator
- **Visual**: Step indicators with checkmarks
- **States**: Current (active), Completed (checked), Pending (empty)
- **Labels**: Step names

#### Order Summary Sidebar
- **Sticky**: Stays visible on scroll
- **Updates**: Dynamically updates as user progresses
- **Breakdown**: Subtotal, shipping, tax, total

#### Payment Method Selection
- **Radio Buttons**: Single selection
- **Forms**: Conditional forms based on selection
- **Validation**: Real-time validation feedback

### 6.3 User Flow Rationale
- **Linear Flow**: Clear step-by-step process
- **Progress Visibility**: User knows where they are
- **Summary Always Visible**: Order summary sticky sidebar
- **Validation**: Immediate feedback on errors
- **Confirmation**: Clear success state

### 6.4 DDD Alignment
- **Order Aggregate**: Checkout creates order aggregate
- **Payment Strategy**: UI reflects payment strategy pattern
- **Shipping Strategy**: Shipping method selection maps to strategy

---

## 7. Seller Dashboard

### 7.1 Layout Structure

```
┌─────────────────────────────────────────────────────────┐
│ Header                                                   │
├──────────────┬──────────────────────────────────────────┤
│ Sidebar       │ Main Content                             │
│ Navigation    │                                          │
│               │ Dashboard Overview                        │
│ ┌──────────┐ │ ┌──────────────────────────────────────┐│
│ │ Dashboard│ │ │ Welcome, [Seller Name]               ││
│ │ Products │ │ │                                      ││
│ │ Listings │ │ │ Quick Stats:                         ││
│ │ Inspect. │ │ │ ┌──────┐ ┌──────┐ ┌──────┐         ││
│ │ Orders   │ │ │ │ 12   │ │ 8    │ │ $XXK │         ││
│ │ Settings │ │ │ │Active│ │Pending│ │Revenue│         ││
│ └──────────┘ │ │ └──────┘ └──────┘ └──────┘         ││
│               │ └──────────────────────────────────────┘│
│               │                                          │
│               │ My Products                             │
│               │ ┌──────────────────────────────────────┐│
│               │ │ [New Product] [Filter] [Search]     ││
│               │ │                                      ││
│               │ │ ┌──────────────────────────────────┐││
│               │ │ │ Product Card                     │││
│               │ │ │ Status: Active | Views: 123     │││
│               │ │ │ [Edit] [View] [Deactivate]      │││
│               │ │ └──────────────────────────────────┘││
│               │ │                                      ││
│               │ │ [Pagination]                        ││
│               │ └──────────────────────────────────────┘│
│               │                                          │
│               │ Pending Inspections                      │
│               │ ┌──────────────────────────────────────┐│
│               │ │ Inspection Card                      │││
│               │ │ Product: [Name]                      │││
│               │ │ Status: Scheduled                    │││
│               │ │ Date: [Date]                        │││
│               │ │ [View Details]                      │││
│               │ └──────────────────────────────────────┘│
└──────────────┴──────────────────────────────────────────┘
```

### 7.2 Components

#### Sidebar Navigation
- **Menu Items**:
  - Dashboard (active indicator)
  - Products / Listings
  - Inspections
  - Orders
  - Settings
- **Collapsible**: On mobile, hamburger menu

#### Dashboard Overview
- **Welcome Message**: Personalized greeting
- **Quick Stats Cards**: 
  - Active Listings
  - Pending Inspections
  - Total Revenue
  - Recent Sales

#### Products Section
- **Actions Bar**: 
  - "New Product" button (primary)
  - Filter dropdown
  - Search input
- **Product Cards**: 
  - Product image
  - Title and status
  - Views/Engagement metrics
  - Action buttons (Edit, View, Deactivate)
- **Status Badges**: Color-coded (Active, Pending, Sold)

#### Inspections Section
- **Inspection Cards**:
  - Product name
  - Status with state indicator
  - Scheduled date/time
  - Workshop name
  - Action buttons

### 7.3 User Flow Rationale
- **Quick Access**: Sidebar provides fast navigation
- **Overview First**: Dashboard shows key metrics
- **Action-Oriented**: Clear CTAs for common tasks
- **Status Visibility**: Product and inspection statuses prominent

### 7.4 DDD Alignment
- **Product Aggregate**: Products displayed as aggregates
- **Inspection Aggregate**: Inspections shown with state
- **State Pattern**: Visual indicators reflect state transitions

---

## 8. Workshop Dashboard

### 8.1 Layout Structure

```
┌─────────────────────────────────────────────────────────┐
│ Header                                                   │
├──────────────┬──────────────────────────────────────────┤
│ Sidebar       │ Main Content                             │
│               │                                          │
│ ┌──────────┐ │ Dashboard                                │
│ │ Dashboard│ │ ┌──────────────────────────────────────┐│
│ │ Inspect. │ │ │ Today's Schedule                     ││
│ │ Schedule │ │ │ ┌──────────────────────────────────┐││
│ │ Reports  │ │ │ │ 10:00 AM - Inspection #123      │││
│ │ Settings │ │ │ │ Product: [Name]                  │││
│ └──────────┘ │ │ │ [View] [Start]                   │││
│               │ │ └──────────────────────────────────┘││
│               │ │                                      ││
│               │ │ Pending Requests                    ││
│               │ │ ┌──────────────────────────────────┐││
│               │ │ │ Request #456                      │││
│               │ │ │ Product: [Name]                  │││
│               │ │ │ Requested: [Date]                │││
│               │ │ │ [Schedule] [View Details]        │││
│               │ │ └──────────────────────────────────┘││
│               │ │                                      ││
│               │ │ Inspection Form (When Active)        ││
│               │ │ ┌──────────────────────────────────┐││
│               │ │ │ Checklist Items:                 │││
│               │ │ │ ☑ Frame condition                │││
│               │ │ │ ☑ Groupset function              │││
│               │ │ │ ☐ Brake system                   │││
│               │ │ │ ...                              │││
│               │ │ │                                   │││
│               │ │ │ Grade: [Excellent ▼]             │││
│               │ │ │ Notes: [Text area]               │││
│               │ │ │                                   │││
│               │ │ │ [Save Draft] [Complete]          │││
│               │ │ └──────────────────────────────────┘││
└──────────────┴──────────────────────────────────────────┘
```

### 8.2 Components

#### Today's Schedule
- **Layout**: List of appointments
- **Card Elements**:
  - Time slot
  - Inspection ID
  - Product name
  - Status
  - Actions (View, Start, Complete)

#### Pending Requests
- **Layout**: List of inspection requests
- **Card Elements**:
  - Request ID
  - Product information
  - Request date
  - Actions (Schedule, View Details, Reject)

#### Inspection Form
- **Checklist**: 
  - Checkbox items
  - Status indicators
  - Notes per item
- **Grade Selection**: Dropdown (Excellent, Very Good, Good, Fair)
- **Notes Field**: Large text area
- **Actions**: Save Draft, Complete Inspection

### 8.3 User Flow Rationale
- **Schedule-Focused**: Today's schedule prominent
- **Quick Actions**: Start inspection directly from schedule
- **Progressive Workflow**: Request → Schedule → Complete
- **State Management**: Clear state indicators

### 8.4 DDD Alignment
- **Inspection Aggregate**: Inspections with state transitions
- **State Pattern**: Visual representation of inspection states
- **Appointment Value Object**: Schedule shows appointment details

---

## 9. Trade-in Form

### 9.1 Layout Structure

```
┌─────────────────────────────────────────────────────────┐
│ Header                                                   │
├─────────────────────────────────────────────────────────┤
│ Trade-in Your Bike                                       │
│ Get credit toward your next purchase                     │
├─────────────────────────────────────────────────────────┤
│ ┌─────────────────────────────────────────────────────┐ │
│ │ Step 1: Bike Information                            │ │
│ │                                                      │ │
│ │ Brand: [Dropdown ▼]                                 │ │
│ │ Model: [Input]                                       │ │
│ │ Year: [Input]                                        │ │
│ │ Condition: [Excellent ▼]                             │ │
│ │                                                      │ │
│ │ Description: [Text Area]                             │ │
│ │                                                      │ │
│ │ Photos: [Upload Area]                                │ │
│ │ ┌──┐ ┌──┐ ┌──┐ [Add More]                           │ │
│ │ │  │ │  │ │  │                                       │ │
│ │ └──┘ └──┘ └──┘                                       │ │
│ │                                                      │ │
│ │ [Next Step]                                          │ │
│ └─────────────────────────────────────────────────────┘ │
├─────────────────────────────────────────────────────────┤
│ ┌─────────────────────────────────────────────────────┐ │
│ │ Step 2: Valuation (After Submission)                 │ │
│ │                                                      │ │
│ │ Your bike has been valued at:                        │ │
│ │ $X,XXX                                               │ │
│ │                                                      │ │
│ │ Valuation Details:                                   │ │
│ │ - Market Value: $X,XXX                               │ │
│ │ - Condition Adjustment: -$XXX                        │ │
│ │ - Final Value: $X,XXX                                │ │
│ │                                                      │ │
│ │ Status: Pending Approval                             │ │
│ │                                                      │ │
│ │ [Submit for Approval]                                │ │
│ └─────────────────────────────────────────────────────┘ │
└─────────────────────────────────────────────────────────┘
```

### 9.2 Components

#### Multi-Step Form
- **Progress Indicator**: Step numbers/names
- **Validation**: Real-time validation feedback
- **Photo Upload**: Drag-and-drop or file picker
- **Image Preview**: Thumbnail previews

#### Valuation Display
- **Amount**: Large, prominent display
- **Breakdown**: Detailed calculation
- **Status**: Approval status indicator
- **Timeline**: Estimated approval time

### 9.3 User Flow Rationale
- **Simple Steps**: Break complex form into steps
- **Visual Feedback**: Photo uploads show previews
- **Transparency**: Valuation breakdown visible
- **Clear Next Steps**: Obvious action buttons

### 9.4 DDD Alignment
- **Trade-in Aggregate**: Form creates trade-in aggregate
- **Valuation Value Object**: Valuation displayed as value object
- **Strategy Pattern**: Valuation calculation uses strategy (hidden from UI)

---

## 10. Admin Panel

### 10.1 Layout Structure

```
┌─────────────────────────────────────────────────────────┐
│ Admin Header                                             │
├──────────────┬──────────────────────────────────────────┤
│ Sidebar       │ Main Content                             │
│               │                                          │
│ ┌──────────┐ │ Dashboard                               │
│ │ Dashboard│ │ ┌──────────────────────────────────────┐│
│ │ Users    │ │ │ System Overview                       ││
│ │ Products │ │ │ ┌──────┐ ┌──────┐ ┌──────┐          ││
│ │ Orders   │ │ │ │ 1.2K │ │ 456  │ │ $XXK │          ││
│ │ Inspect. │ │ │ │Users │ │Orders│ │Revenue│          ││
│ │ Trade-ins│ │ │ └──────┘ └──────┘ └──────┘          ││
│ │ Reports  │ │ └──────────────────────────────────────┘│
│ │ Settings │ │                                          │
│ └──────────┘ │ Recent Activity                         │
│               │ ┌──────────────────────────────────────┐│
│               │ │ [Table: Activity Log]                ││
│               │ │ Time | User | Action | Details       ││
│               │ └──────────────────────────────────────┘│
│               │                                          │
│               │ Pending Actions                          │
│               │ ┌──────────────────────────────────────┐│
│               │ │ Trade-in Approvals: 5                ││
│               │ │ Dispute Resolutions: 2               ││
│               │ │ [View All]                           ││
│               │ └──────────────────────────────────────┘│
└──────────────┴──────────────────────────────────────────┘
```

### 10.2 Components

#### Admin Sidebar
- **Sections**:
  - Dashboard
  - User Management
  - Product Management
  - Order Management
  - Inspection Oversight
  - Trade-in Management
  - Reports & Analytics
  - System Settings

#### Dashboard Overview
- **Metrics Cards**: 
  - Total Users
  - Total Orders
  - Revenue
  - Active Products
- **Charts**: Revenue trends, user growth (optional)

#### Data Tables
- **Features**:
  - Sortable columns
  - Search/filter
  - Pagination
  - Bulk actions
  - Row actions (Edit, Delete, View)

#### Activity Log
- **Columns**: Timestamp, User, Action, Details
- **Filtering**: By user, action type, date range
- **Export**: CSV/PDF export option

### 10.3 User Flow Rationale
- **Overview First**: Dashboard shows key metrics
- **Quick Access**: Sidebar for all major functions
- **Data Management**: Tables with full CRUD operations
- **Audit Trail**: Activity log for accountability

### 10.4 DDD Alignment
- **Aggregate Management**: Admin can manage all aggregates
- **Cross-Cutting Concerns**: Admin panel spans all bounded contexts
- **Event Logging**: Activity log tracks domain events

---

## Appendix A: Component Library

### A.1 Common Components
- **Buttons**: Primary, Secondary, Danger, Ghost
- **Cards**: Default, Elevated, Outlined
- **Forms**: Input, Textarea, Select, Checkbox, Radio
- **Badges**: Status, Category, Notification
- **Modals**: Confirmation, Information, Form
- **Tables**: Sortable, Filterable, Paginated
- **Navigation**: Breadcrumbs, Pagination, Tabs

### A.2 Tailwind CSS Classes
- **Spacing**: Consistent spacing scale (4px base)
- **Colors**: Brand colors from design system
- **Typography**: Heading and body text scales
- **Shadows**: Elevation system
- **Borders**: Border radius and width system

---

## Appendix B: Responsive Breakpoints

- **Mobile**: < 640px (sm)
- **Tablet**: 640px - 1024px (md, lg)
- **Desktop**: > 1024px (xl, 2xl)

---

**Document Status**: Complete  
**Next Steps**: Proceed to Branding Guidelines

