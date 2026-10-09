<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductCatalogSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $categories = [
            [
                'id' => Str::uuid()->toString(),
                'name' => 'Coffee & Cocoa',
                'description' => 'Premium Indonesian coffee and cocoa products sourced from local producers.',
            ],
            [
                'id' => Str::uuid()->toString(),
                'name' => 'Coconut Products',
                'description' => 'Indonesian coconut products for food, beverage, and personal care industries.',
            ],
            [
                'id' => Str::uuid()->toString(),
                'name' => 'Spices & Herbs',
                'description' => 'Authentic Indonesian spices and herbs for international markets.',
            ],
        ];

        DB::table('categories')->insert(
            array_map(fn ($item) => array_merge($item, [
                'created_at' => $now,
                'updated_at' => $now,
            ]), $categories)
        );

        $products = [
            [
                'category' => 0,
                'name' => 'Arabica Coffee Beans',
                'description' => 'Premium Arabica coffee beans with a distinctive aroma and balanced flavor.',
                'images' => [
                    'photo-1447933601403-0c6688de566e',
                    'photo-1559056199-641a0ac8b55e',
                    'photo-1510707577719-ae7c14805e3a',
                ],
            ],
            [
                'category' => 0,
                'name' => 'Robusta Coffee Beans',
                'description' => 'Indonesian Robusta coffee beans with a strong character and full-bodied flavor.',
                'images' => [
                    'photo-1559525839-b184a4d698c7',
                    'photo-1442512595331-e89e73853f31',
                    'photo-1495474472287-4d71bcdd2085',
                ],
            ],
            [
                'category' => 0,
                'name' => 'Roasted Coffee Beans',
                'description' => 'Carefully roasted coffee beans suitable for cafes and coffee distributors.',
                'images' => [
                    'photo-1511537190424-bbbab87ac5eb',
                    'photo-1445116572660-236099ec97a0',
                    'photo-1501339847302-ac426a4a7cbb',
                ],
            ],
            [
                'category' => 0,
                'name' => 'Ground Coffee',
                'description' => 'Ground coffee suitable for retail packaging and food service businesses.',
                'images' => [
                    'photo-1559056199-641a0ac8b55e',
                    'photo-1511920170033-f8396924c348',
                    'photo-1509042239860-f550ce710b93',
                ],
            ],
            [
                'category' => 0,
                'name' => 'Cocoa Beans',
                'description' => 'Selected cocoa beans for chocolate manufacturing and cocoa-based products.',
                'images' => [
                    'photo-1511381939415-e44015466834',
                    'photo-1606313564200-e75d5e30476c',
                    'photo-1548907040-4d42baa5e4c5',
                ],
            ],

            [
                'category' => 1,
                'name' => 'Fresh Coconut',
                'description' => 'Fresh coconuts sourced from Indonesian plantations.',
                'images' => [
                    'photo-1550258987-190a2d41a8ba',
                    'photo-1580984969071-a8da5656c2fb',
                    'photo-1590502593747-42a996133562',
                ],
            ],
            [
                'category' => 1,
                'name' => 'Virgin Coconut Oil',
                'description' => 'Coconut oil for food, cosmetics, and personal care applications.',
                'images' => [
                    'photo-1608571423902-eed4a5ad8108',
                    'photo-1608248543803-ba4f8c70ae0b',
                    'photo-1601049541289-9b1b7bbbfe19',
                ],
            ],
            [
                'category' => 1,
                'name' => 'Desiccated Coconut',
                'description' => 'Dried coconut suitable for bakery and food manufacturing.',
                'images' => [
                    'photo-1550258987-190a2d41a8ba',
                    'photo-1571506165871-ee72a35bc9d4',
                    'photo-1563636619-e9143da7973b',
                ],
            ],
            [
                'category' => 1,
                'name' => 'Coconut Sugar',
                'description' => 'Coconut-derived sugar for sweetener and food ingredient markets.',
                'images' => [
                    'photo-1581441363689-1f3c3c414635',
                    'photo-1587049352851-8d4e89133924',
                    'photo-1499636136210-6f4ee915583e',
                ],
            ],
            [
                'category' => 1,
                'name' => 'Coconut Milk',
                'description' => 'Coconut milk for cooking, beverages, and food processing.',
                'images' => [
                    'photo-1563636619-e9143da7973b',
                    'photo-1550583724-b2692b85b150',
                    'photo-1547592180-85f173990554',
                ],
            ],

            [
                'category' => 2,
                'name' => 'Black Pepper',
                'description' => 'Aromatic Indonesian black pepper for culinary applications.',
                'images' => [
                    'photo-1599909533605-1c2b4b0c0a2e',
                    'photo-1532336414038-cf19250c5757',
                    'photo-1596040033229-a9821ebd058d',
                ],
            ],
            [
                'category' => 2,
                'name' => 'Cinnamon Sticks',
                'description' => 'Aromatic cinnamon sticks for beverages and spice blends.',
                'images' => [
                    'photo-1504545102780-26774c1bb073',
                    'photo-1600326145552-327f74b9c189',
                    'photo-1532336414038-cf19250c5757',
                ],
            ],
            [
                'category' => 2,
                'name' => 'Turmeric Powder',
                'description' => 'Ground turmeric with a vibrant natural color for culinary applications.',
                'images' => [
                    'photo-1615485500704-8e990f9900f5',
                    'photo-1615485290382-441e4d049cb5',
                    'photo-1596040033229-a9821ebd058d',
                ],
            ],
            [
                'category' => 2,
                'name' => 'Cloves',
                'description' => 'Indonesian cloves for food, beverage, and spice industries.',
                'images' => [
                    'photo-1515543904379-3d757afe72e4',
                    'photo-1532336414038-cf19250c5757',
                    'photo-1596040033229-a9821ebd058d',
                ],
            ],
            [
                'category' => 2,
                'name' => 'Ginger',
                'description' => 'Indonesian ginger for culinary, beverage, and food ingredient applications.',
                'images' => [
                    'photo-1615485290382-441e4d049cb5',
                    'photo-1615485500704-8e990f9900f5',
                    'photo-1596040033229-a9821ebd058d',
                ],
            ],
        ];

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
            $optionId = Str::uuid()->toString();

            $options[] = [
                'id' => $optionId,
                'title' => $definition['title'],
                'description' => $definition['description'],
                'created_at' => $now,
                'updated_at' => $now,
            ];

            foreach ($definition['items'] as $item) {
                DB::table('option_items')->insert([
                    'id' => Str::uuid()->toString(),
                    'option_id' => $optionId,
                    'title' => $item['title'],
                    'description' => $item['description'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }

        DB::table('options')->insert($options);

        foreach ($products as $product) {
            $productId = Str::uuid()->toString();

            DB::table('products')->insert([
                'id' => $productId,
                'category_id' => $categories[$product['category']]['id'],
                'name' => $product['name'],
                'description' => $product['description'],
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $images = [];

            foreach ($product['images'] as $image) {
                $images[] = [
                    'id' => Str::uuid()->toString(),
                    'product_id' => $productId,
                    'path' => "https://images.unsplash.com/{$image}?auto=format&fit=crop&w=1200&q=80",
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            DB::table('product_images')->insert($images);

            $productOptions = [];

            foreach ($options as $option) {
                $productOptions[] = [
                    'id' => Str::uuid()->toString(),
                    'product_id' => $productId,
                    'option_id' => $option['id'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            DB::table('product_options')->insert($productOptions);
        }
    }
}

