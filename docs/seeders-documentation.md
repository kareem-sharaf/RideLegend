# Seeders Documentation

## نظرة عامة

تم إنشاء seeders شاملة لتعبئة قاعدة البيانات بالبيانات اللازمة لعرض جميع الواجهات بشكل صحيح.

## Seeders المتوفرة

### 1. ProductCategorySeeder

ينشئ فئات المنتجات الأساسية:

- **Road Bikes** - دراجات الطرق
- **Mountain Bikes** - دراجات الجبال
- **Electric Bikes** - الدراجات الكهربائية
- **Gravel Bikes** - دراجات الجرافيل
- **Hybrid Bikes** - الدراجات الهجينة

**الاستخدام:**
```bash
php artisan db:seed --class=ProductCategorySeeder
```

### 2. UserSeeder

ينشئ المستخدمين:

- **1 Admin User**
  - Email: `admin@ridelegend.com`
  - Password: `password`
  - Role: `admin`

- **4 Sellers**
  - john.seller@example.com
  - sarah.seller@example.com
  - mike.seller@example.com
  - emily.seller@example.com
  - Password: `password` (لجميعهم)

- **10 Buyers** (مولّدون تلقائياً)

**الاستخدام:**
```bash
php artisan db:seed --class=UserSeeder
```

### 3. ProductSeeder

ينشئ المنتجات مع الصور:

#### منتجات واقعية (12 منتج):

**Road Bikes:**
- Specialized Tarmac SL7 Pro - $8,499.99
- Trek Domane SL 7 - $5,499.99
- Cannondale SuperSix EVO - $6,299.99

**Mountain Bikes:**
- Santa Cruz Hightower - $5,999.99
- Trek Fuel EX 9.8 - $5,499.99
- Specialized Stumpjumper EVO - $6,999.99

**Electric Bikes:**
- Trek Powerfly FS 9.7 - $6,499.99
- Specialized Turbo Levo SL - $8,999.99

**Gravel Bikes:**
- Cannondale Topstone Carbon - $4,299.99
- Trek Checkpoint SL 7 - $4,999.99

**Hybrid Bikes:**
- Trek FX 3 Disc - $899.99
- Specialized Sirrus X 3.0 - $1,099.99

#### منتجات إضافية (15 منتج):
- منتجات مولّدة تلقائياً باستخدام Factory
- حالات متنوعة (active, pending)
- أنواع مختلفة من الدراجات

**الاستخدام:**
```bash
php artisan db:seed --class=ProductSeeder
```

## تشغيل جميع Seeders

لتشغيل جميع الـ seeders مرة واحدة:

```bash
php artisan db:seed
```

أو لإعادة تعيين قاعدة البيانات وتشغيل الـ seeders:

```bash
php artisan migrate:fresh --seed
```

## ملاحظات مهمة

### 1. الصور

- الصور تُخزن كـ placeholder paths
- في حالة عدم وجود الصور، سيتم استخدام Unsplash URLs كـ fallback
- يمكنك لاحقاً تحميل صور حقيقية واستبدال الـ placeholders

### 2. البيانات المكررة

- جميع الـ seeders تستخدم `firstOrCreate` لتجنب البيانات المكررة
- يمكنك تشغيل الـ seeders عدة مرات بأمان

### 3. كلمات المرور

- جميع المستخدمين لديهم كلمة مرور: `password`
- **مهم:** غيّر كلمات المرور في الإنتاج!

### 4. الحالات

- جميع المنتجات الواقعية بحالة `active`
- المنتجات المولّدة قد تكون `active` أو `pending`

## هيكل البيانات

```
Users (15)
├── Admin (1)
├── Sellers (4)
└── Buyers (10)

Categories (5)
├── Road Bikes
├── Mountain Bikes
├── Electric Bikes
├── Gravel Bikes
└── Hybrid Bikes

Products (27)
├── Realistic Products (12)
│   ├── Road Bikes (3)
│   ├── Mountain Bikes (3)
│   ├── Electric Bikes (2)
│   ├── Gravel Bikes (2)
│   └── Hybrid Bikes (2)
└── Generated Products (15)

Product Images
├── 3 images per realistic product
└── 1 image per generated product
```

## اختبار الواجهات

بعد تشغيل الـ seeders، يمكنك اختبار:

1. **الصفحة الرئيسية** (`/`)
   - عرض Featured Bikes
   - عرض Categories

2. **صفحة قائمة المنتجات** (`/products`)
   - عرض جميع المنتجات
   - الفلترة حسب النوع
   - الترتيب

3. **صفحة تفاصيل المنتج** (`/products/{id}`)
   - عرض تفاصيل المنتج
   - معرض الصور
   - معلومات البائع

## تحديث البيانات

لإعادة تعيين وإعادة تعبئة قاعدة البيانات:

```bash
php artisan migrate:fresh --seed
```

**تحذير:** هذا سيحذف جميع البيانات الموجودة!

## إضافة بيانات جديدة

لإضافة منتجات جديدة يدوياً:

```php
use App\Models\Product;
use App\Models\ProductImage;

$product = Product::create([
    'seller_id' => 2, // ID البائع
    'title' => 'Product Title',
    'description' => 'Product description',
    'price' => 2999.99,
    'bike_type' => 'road',
    'frame_material' => 'carbon',
    'brake_type' => 'disc_brake_hydraulic',
    'wheel_size' => '700c',
    'weight' => 8.5,
    'weight_unit' => 'kg',
    'brand' => 'Brand Name',
    'model' => 'Model Name',
    'year' => 2023,
    'status' => 'active',
    'category_id' => 1, // ID الفئة
]);

ProductImage::create([
    'product_id' => $product->id,
    'path' => 'products/image.jpg',
    'is_primary' => true,
    'order' => 0,
]);
```

---

**تم الإنشاء:** 2025-11-25
**الإصدار:** 1.0

