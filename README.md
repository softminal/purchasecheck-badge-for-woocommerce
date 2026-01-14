# WooAP – Already Purchased Badge  
_Workflow & Implementation Plan_

---

## Overview

WooAP adds a visual **“Purchased / Already Bought” badge** to WooCommerce products for logged-in users who have already purchased a product.

### Goals
- Improve user experience
- Prevent accidental duplicate purchases
- Fully WooCommerce-native
- Vue-friendly and REST-ready
- Scalable for future style & rule extensions

---

## Architecture Assumptions

- Custom MVC-like framework (Model, Controller, Route)
- PHP backend
- Vue.js frontend
- WooCommerce is required
- WordPress REST API may be used

---

## Admin UI Decision

- **No WordPress top-level menu**
- Add a **custom WooCommerce Settings tab**

Path:
```
WooCommerce → Settings → WooAP
```

---

## Settings Architecture

### WooCommerce Tab
```
wooap
```

### Section (v1)
```
wooap_purchased_badge
```

### Option Prefix
```
wooap_
```

---

## MVP Settings (Version 1)

| Feature | Option Key | Type | Default |
|------|-----------|------|---------|
Enable badge | `wooap_enable_badge` | checkbox | true |
Badge text | `wooap_badge_text` | text | Purchased |
Order statuses | `wooap_order_statuses` | multiselect | completed, processing |
Show on shop | `wooap_show_shop` | checkbox | true |
Show on category | `wooap_show_category` | checkbox | true |
Show on product page | `wooap_show_product` | checkbox | true |

---

## Data Flow (High Level)

```
Admin Settings
   ↓
Stored in wp_options
   ↓
Controller loads settings
   ↓
Exposed to Frontend (JS or REST)
   ↓
Vue renders badge conditionally
```

---

## Step-by-Step Implementation Plan

---

## STEP 1: Purchase Detection (Model Layer)

### Responsibility
Determine whether a user has purchased a product.

### Rules
- User must be logged in
- Order status must be allowed
- Variable products should match parent ID
- One purchase is enough

### Required Methods
- `hasUserPurchasedProduct(userId, productId)`
- `getPurchasedProductIds(userId, productIds[])`

---

## STEP 2: Product Context Resolver

### Responsibility
- Detect all product IDs being rendered on a page
- Avoid N+1 queries
- Work with shop, category, and product pages

---

## STEP 3: Business Logic Controller

### Responsibility
- Decide whether badge should be shown
- Apply role-based logic (future)
- Merge settings + purchase data

---

## STEP 4: REST API (Optional)

Endpoint:
```
GET /wp-json/wooap/v1/purchased-products
```

---

## STEP 5: Vue Badge Component

### Responsibilities
- Receive product ID
- Read purchase status
- Render badge conditionally

---

## STEP 6: Frontend Integration Points

- Shop & Category pages: product card overlay
- Product page: before title / after price

---

## STEP 7: Performance Strategy

- Bulk queries
- Request-level caching
- Optional transients

---

## STEP 8: MVP Scope

### Included
- Logged-in users
- Completed + Processing orders
- Shop / Category / Product pages
- Default badge style
- WooCommerce settings tab

### Excluded
- Custom styles UI
- Role rules
- Analytics

---

## Future Roadmap

```
WooAP
 ├── Purchased Badge
 ├── Styles
 ├── Role Rules
 ├── Advanced
 └── Integrations
```

---

## Status
🚧 In Development
