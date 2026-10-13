<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductCatalogSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $categoryDefinitions = [
            [
                'name' => 'Coffee & Cocoa',
                'description' => 'Premium Indonesian coffee and cocoa products sourced from local producers.',
            ],
            [
                'name' => 'Coconut Products',
                'description' => 'Indonesian coconut products for food, beverage, and personal care industries.',
            ],
            [
                'name' => 'Spices & Herbs',
                'description' => 'Authentic Indonesian spices and herbs for international markets.',
            ],
            [
                'name' => 'Tropical Fruits',
                'description' => 'Selected tropical fruits from Indonesia for food service and export markets.',
            ],
            [
                'name' => 'Natural Ingredients',
                'description' => 'Natural agricultural ingredients for food, beverage, and manufacturing.',
            ],
        ];

        $categories = [];

        foreach ($categoryDefinitions as $definition) {
            $category = Category::firstOrCreate(
                ['name' => $definition['name']],
                [
                    'id' => (string) Str::uuid(),
                    'slug' => Str::slug($definition['name']),
                    'description' => $definition['description'],
                ]
            );

            $categories[] = $category;
        }

        $optionDefinitions = [
            [
                'title' => 'Packaging',
                'description' => 'Available packaging formats for export orders.',
                'items' => [
                    ['title' => 'Bulk Packaging', 'description' => 'Packaging for large-volume shipments.'],
                    ['title' => 'Retail Packaging', 'description' => 'Packaging for retail distribution.'],
                    ['title' => 'Custom Packaging', 'description' => 'Packaging tailored to buyer requirements.'],
                ],
            ],
            [
                'title' => 'Order Volume',
                'description' => 'Order quantities based on buyer requirements.',
                'items' => [
                    ['title' => 'Sample Order', 'description' => 'Small quantity for product evaluation.'],
                    ['title' => 'Wholesale', 'description' => 'Wholesale quantity for distributors.'],
                    ['title' => 'Bulk Order', 'description' => 'Large quantities for commercial orders.'],
                ],
            ],
            [
                'title' => 'Product Grade',
                'description' => 'Product grades based on specifications and availability.',
                'items' => [
                    ['title' => 'Standard Grade', 'description' => 'Standard commercial specifications.'],
                    ['title' => 'Premium Grade', 'description' => 'Selected products with premium specifications.'],
                    ['title' => 'Custom Grade', 'description' => 'Specifications agreed upon with the buyer.'],
                ],
            ],
        ];

        $options = [];

        foreach ($optionDefinitions as $definition) {
            $optionId = (string) Str::uuid();

            DB::table('options')->insert([
                'id' => $optionId,
                'title' => $definition['title'],
                'description' => $definition['description'],
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $options[] = ['id' => $optionId];

            foreach ($definition['items'] as $item) {
                DB::table('option_items')->insert([
                    'id' => (string) Str::uuid(),
                    'option_id' => $optionId,
                    'description' => $item['description'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }

        $productDefinitions = [
            [0, 'Arabica Coffee Beans', 'Premium Arabica coffee beans with a distinctive aroma and balanced flavor.'],
            [0, 'Robusta Coffee Beans', 'Indonesian Robusta coffee beans with a strong character and full-bodied flavor.'],
            [0, 'Roasted Coffee Beans', 'Carefully roasted coffee beans suitable for cafes and coffee distributors.'],
            [0, 'Ground Coffee', 'Ground coffee suitable for retail packaging and food service businesses.'],
            [0, 'Cocoa Beans', 'Selected cocoa beans for chocolate manufacturing and cocoa-based products.'],
            [0, 'Cocoa Powder', 'Fine cocoa powder for bakery, beverage, and confectionery applications.'],
            [0, 'Cocoa Butter', 'Cocoa butter for chocolate production, cosmetics, and personal care products.'],
            [0, 'Coffee Cascara', 'Dried coffee cherry husks for specialty tea and beverage applications.'],
            [0, 'Green Coffee Beans', 'Unroasted green coffee beans for roasters and wholesale buyers.'],
            [0, 'Instant Coffee Powder', 'Convenient soluble coffee powder for beverage manufacturers and distributors.'],

            [1, 'Fresh Coconut', 'Fresh coconuts sourced from Indonesian plantations.'],
            [1, 'Virgin Coconut Oil', 'Virgin coconut oil for food, cosmetics, and personal care applications.'],
            [1, 'Desiccated Coconut', 'Dried coconut suitable for bakery and food manufacturing.'],
            [1, 'Coconut Sugar', 'Coconut-derived sugar for sweetener and food ingredient markets.'],
            [1, 'Coconut Milk', 'Coconut milk for cooking, beverages, and food processing.'],
            [1, 'Coconut Water', 'Refreshing coconut water for beverage production and retail distribution.'],
            [1, 'Coconut Flour', 'Coconut flour for baking, gluten-free products, and food manufacturing.'],
            [1, 'Coconut Cream', 'Rich coconut cream for sauces, desserts, and commercial food preparation.'],
            [1, 'Coconut Charcoal', 'Coconut shell charcoal for industrial and approved commercial applications.'],
            [1, 'Coconut Shell', 'Processed coconut shells for craft, material, and industrial uses.'],

            [2, 'Black Pepper', 'Aromatic Indonesian black pepper for culinary applications.'],
            [2, 'White Pepper', 'Selected white pepper with a warm flavor for seasoning and food processing.'],
            [2, 'Cinnamon Sticks', 'Aromatic cinnamon sticks for beverages and spice blends.'],
            [2, 'Turmeric Powder', 'Ground turmeric with a vibrant natural color for culinary applications.'],
            [2, 'Cloves', 'Indonesian cloves for food, beverage, and spice industries.'],
            [2, 'Ginger', 'Indonesian ginger for culinary, beverage, and food ingredient applications.'],
            [2, 'Nutmeg', 'Whole Indonesian nutmeg for seasoning, baking, and food manufacturing.'],
            [2, 'Cardamom', 'Fragrant cardamom for spice blends, beverages, and culinary products.'],
            [2, 'Coriander Seeds', 'Dried coriander seeds for seasoning and commercial food production.'],
            [2, 'Lemongrass', 'Aromatic lemongrass for food, tea, and herbal ingredient applications.'],

            [3, 'Dried Mango', 'Sweet dried mango slices for snacks, retail packs, and food service.'],
            [3, 'Dried Pineapple', 'Tropical dried pineapple for snack products and bakery ingredients.'],
            [3, 'Banana Chips', 'Crispy banana chips suitable for retail and wholesale snack markets.'],
            [3, 'Fresh Mango', 'Selected fresh mangoes for distributors and fresh produce buyers.'],
            [3, 'Fresh Pineapple', 'Indonesian pineapples for fresh markets and food processing.'],
            [3, 'Dragon Fruit', 'Tropical dragon fruit for fresh produce and beverage applications.'],
            [3, 'Papaya', 'Fresh papaya for produce distributors and food service businesses.'],
            [3, 'Passion Fruit', 'Aromatic passion fruit for juice, puree, and beverage production.'],
            [3, 'Mangosteen', 'Selected mangosteen fruit for fresh produce export markets.'],
            [3, 'Jackfruit', 'Tropical jackfruit for fresh, frozen, and food processing applications.'],

            [4, 'Raw Honey', 'Natural honey for food manufacturing, retail packaging, and food service.'],
            [4, 'Palm Sugar', 'Traditional palm sugar for sweeteners, sauces, and beverage applications.'],
            [4, 'Cassava Flour', 'Cassava-based flour for food manufacturing and gluten-free recipes.'],
            [4, 'Tapioca Starch', 'Tapioca starch for food processing, sauces, and industrial applications.'],
            [4, 'Moringa Powder', 'Finely milled moringa leaf powder for ingredient and wellness food markets.'],
            [4, 'Vanilla Beans', 'Aromatic vanilla beans for bakery, confectionery, and beverage production.'],
            [4, 'Sea Salt', 'Harvested sea salt for culinary use and food manufacturing.'],
            [4, 'Rice Flour', 'Rice flour for traditional foods, baking, and commercial food production.'],
            [4, 'Tempeh Chips', 'Crunchy tempeh-based snack product for retail and wholesale distribution.'],
            [4, 'Herbal Tea Blend', 'Dried herbal ingredients blended for tea and beverage applications.'],
        ];

        $photoPools = [
            0 => [
                'photo-1447933601403-0c6688de566e',
                'photo-1559056199-641a0ac8b55e',
                'photo-1510707577719-ae7c14805e3a',
                'photo-1442512595331-e89e73853f31',
                'photo-1495474472287-4d71bcdd2085',
                'photo-1511537190424-bbbab87ac5eb',
                'photo-1511920170033-f8396924c348',
                'photo-1509042239860-f550ce710b93',
                'photo-1511381939415-e44015466834',
                'photo-1606313564200-e75d5e30476c',
            ],
            1 => [
                'photo-1550258987-190a2d41a8ba',
                'photo-1580984969071-a8da5656c2fb',
                'photo-1590502593747-42a996133562',
                'photo-1608571423902-eed4a5ad8108',
                'photo-1608248543803-ba4f8c70ae0b',
                'photo-1601049541289-9b1b7bbbfe19',
                'photo-1581441363689-1f3c3c414635',
                'photo-1587049352851-8d4e89133924',
                'photo-1563636619-e9143da7973b',
                'photo-1550583724-b2692b85b150',
            ],
            2 => [
                'photo-1599909533605-1c2b4b0c0a2e',
                'photo-1532336414038-cf19250c5757',
                'photo-1596040033229-a9821ebd058d',
                'photo-1504545102780-26774c1bb073',
                'photo-1600326145552-327f74b9c189',
                'photo-1615485500704-8e990f9900f5',
                'photo-1615485290382-441e4d049cb5',
                'photo-1515543904379-3d757afe72e4',
                'photo-1547592180-85f173990554',
                'photo-1566385101042-1a0aa0c1268c',
            ],
            3 => [
                'photo-1550258987-190a2d41a8ba',
                'photo-1571506165871-ee72a35bc9d4',
                'photo-1563636619-e9143da7973b',
                'photo-1499636136210-6f4ee915583e',
                'photo-1547592180-85f173990554',
                'photo-1518843875459-f738682238a6',
                'photo-1488459716781-31db52582fe9',
                'photo-1601004890684-d8cbf643f5f2',
                'photo-1619566636858-adf3ef46400b',
                'photo-1546173159-315724a31696',
            ],
            4 => [
                'photo-1587049352851-8d4e89133924',
                'photo-1581441363689-1f3c3c414635',
                'photo-1576092768241-dec231879fc3',
                'photo-1544787219-7f47ccb76574',
                'photo-1603909223429-69bb7101f420',
                'photo-1518843875459-f738682238a6',
                'photo-1601004890684-d8cbf643f5f2',
                'photo-1547592180-85f173990554',
                'photo-1596040033229-a9821ebd058d',
                'photo-1505576399274-565b52d4ac71',
            ],
        ];

        foreach ($productDefinitions as [$categoryIndex, $name, $description]) {
            $product = Product::create([
                'id' => (string) Str::uuid(),
                'category_id' => $categories[$categoryIndex]->id,
                'name' => $name,
                'description' => $description,
                'moq' => collect([
                    '100 kg', '250 kg', '500 kg', '1 ton', '2 tons',
                ])->random(),
                'lead_time' => collect([
                    '7-14 days', '14-21 days', '21-30 days', '30-45 days',
                ])->random(),
                'shelf_time' => collect([
                    '6 months', '12 months', '18 months', '24 months',
                ])->random(),
                'container_capacity' => collect([
                    '20 ft: 8-10 tons',
                    '20 ft: 10-12 tons',
                    '40 ft: 20-25 tons',
                    '40 ft: 25-27 tons',
                ])->random(),
                'sample_available' => (bool) random_int(0, 1),
                'private_label' => (bool) random_int(0, 1),
                'hs_code' => (string) random_int(70000000, 99999999),
                'is_delete' => false,
            ]);

            $imageCount = random_int(3, 5);
            $availablePhotos = $photoPools[$categoryIndex];
            shuffle($availablePhotos);

            $selectedPhotos = array_slice(
                $availablePhotos,
                0,
                $imageCount
            );

            $images = [];

            foreach ($selectedPhotos as $photo) {
                $images[] = [
                    'id' => (string) Str::uuid(),
                    'product_id' => $product->id,
                    'path' => "https://images.unsplash.com/{$photo}?auto=format&fit=crop&w=1200&q=80",
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            DB::table('product_images')->insert($images);

            $productOptions = [];

            foreach ($options as $option) {
                $productOptions[] = [
                    'id' => (string) Str::uuid(),
                    'product_id' => $product->id,
                    'option_id' => $option['id'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            DB::table('product_options')->insert($productOptions);
        }

        $this->command?->info(
            'Catalog seeder completed: 5 categories, 50 products, and 150-250 images.'
        );
    }
}