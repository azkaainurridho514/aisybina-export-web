<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::create([
            'name' => 'Aisybina Export',
            'email' => 'aisybinaexport@gmail.com',
            "password" => Hash::make("123456")
        ]);


        DB::table('master')->insert([
            'icon' => '',
            'website_name' => 'Aisybina Export',
            'website_slug' => 'Connecting global buyers with quality products from Indonesia.',
            'website_description' => 'Aisy Bina Exports finds and vets Indonesian suppliers so international buyers can source with confidence, without spending months on the ground themselves.',
            'heading' => 'From the archipelago to your warehouse.',
            'image' => "",
            'about_heading' => 'A sourcing partner who does the groundwork for you.',
            'about_description' => 'We spend our time visiting suppliers, checking samples, and negotiating terms — so you can focus on running your own business. Aisy Bina Exports is the bridge between Indonesian producers and buyers abroad.',
            'category_heading' => 'Categories we source.',
            'category_description' => 'Each category below represents a network of producers we already work with — and a starting point if you need something more specific.',
            'choose_us_heading' => 'What working with us looks like.',
            'our_process' => 'How an order moves.',
        ]);

        DB::table('ask_us')->insert([
            'ask_us_title' => 'Custom Sourcing',
            'ask_us_heading' => 'Have something specific in mind?',
            'ask_us_description' => "Not every product fits neatly into a category. Describe what you're looking for and we'll tell you honestly if we can find it.",
            'ask_us_button' => 'Send a Sourcing Request',
        ]);

        DB::table('global_reach')->insert([
            'global_reach_title' => 'Built for buyers everywhere.',
            'global_reach_description' => 'From first inquiry to final shipment, our process is built to work across time zones and languages.',
            'global_reach_image' => "",
            'global_reach_item_1' => 'Sourcing Network',
            'global_reach_item_2' => 'Quality Oversight',
            'global_reach_item_3' => 'Export Coordination',
            'global_reach_icon_item_1' => "bi-diagram-3",
            'global_reach_icon_item_2' => "bi-clipboard-data",
            'global_reach_icon_item_3' => "bi-send",
        ]);

        DB::table('footer')->insert([
            'footer_home_heading' => 'Ready to source from Indonesia?',
            'footer_home_subheading' => "Send us a short brief — product, quantity, target market — and we'll come back with real options",
            'footer_home_button' => 'Start a Conversation',
            'footer_product_heading' => 'Still not seeing the right fit?',
            'footer_product_subheading' => "Send us your requirements and we'll help you source the right product from Indonesia.",
            'footer_product_button' => 'Request a Product',
        ]);

        DB::table('contact')->insert([
            'heading' => "Tell us what you're sourcing.",
            'subheading' => 'The more detail you share about product, quantity, and timing, the faster we can come back with real supplier options.',
            "product_heading" => "Browse what we source.",
            "product_subheading" => "Five categories, one point of contact. If your product doesn't fit any of them, send us a request at the end of the page.",
            'whatsapp' => "",
            'email' => 'aisybinaexport@gmail.com',
            'tiktok' => "",
            'instagram' => "",
            'facebook' => "",
            'youtube' => "",
            'location' => "Indonesia",
        ]);
    }
}
