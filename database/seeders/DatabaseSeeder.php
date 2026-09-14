<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'Aisybina Export',
            'email' => 'aisybinaexport@gmail.com',
            "password" => Hash::make("@i5yb!na3xp0r7")
        ]);

        DB::table('master')->insert([
            'logo' => 'images/website/logo_aisybina.png',
            'website_name' => 'Aisybina Export',
            'website_slug' => 'Connecting global buyers with quality products from Indonesia.',
            'website_description' => 'Aisy Bina Exports finds and vets Indonesian suppliers so international buyers can source with confidence, without spending months on the ground themselves.',
            'heading' => 'From the archipelago to your warehouse.',
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
            'global_reach_image' => "images/website/img_global_reach.png",
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

        DB::table('about')->insert([
            'intro_title' => 'Unlimited Creativity, Endless Innovation',
            'intro_description' => "Aisybina Export is an Indonesian export company focused on providing high-quality products in the children's fashion and food sectors. We offer a combination of traditional values, educational needs, and modern lifestyles through three main lines: children's Muslim koko shirts, elementary, middle, and high school uniforms, and frozen groceries.\n\nWith a strong commitment to quality, product authenticity, and professional service, Aisybina Export is here to answer the growing needs of local and international markets.\n\nWe believe that authentic Indonesian products are able to compete in the global market by prioritizing quality, practicality, and cultural values.",
            'image_intro' => "images/website/img_about_company.png",

            'vision_description' => 'To become a trusted export company that delivers original Indonesian products with superior quality, thereby providing added value to business partners, consumers, and the global community.',
            'image_vision' => "images/website/img_vision.png",

            'image_mission' => "images/website/img_mission.png",

            'value_description' => "Aisybina Export has company values that we always maintain to ensure the company's integrity is maintained.",
            'image_value' => "images/website/img_value.png",
        ]);

        DB::table('about_item')->insert([
            [
                'id' => (string) Str::uuid(),
                'icon' => 'bi-clipboard-check',
                'title' => 'Vetted Suppliers',
                'description' => 'Every supplier we work with has been checked in person before we recommend them.',
            ],
            [
                'id' => (string) Str::uuid(),
                'icon' => 'bi-chat-dots',
                'title' => 'Clear Communication',
                'description' => 'You get straight answers and steady updates from inquiry through shipment.',
            ],
            [
                'id' => (string) Str::uuid(),
                'icon' => 'bi-sliders2',
                'title' => 'Sourcing on Request',
                'description' => "Not on our list yet? We'll go find it if it can be sourced from Indonesia.",
            ],
        ]);

        DB::table('choose_us')->insert([
            [
                'id' => (string) Str::uuid(),
                'icon' => 'bi-shield-check',
                'title' => 'Supplier Vetting',
                'description' => 'We check suppliers ourselves before putting them in front of you.',
            ],
            [
                'id' => (string) Str::uuid(),
                'icon' => 'bi-eyedropper',
                'title' => 'Sample & Spec Checks',
                'description' => 'Samples are reviewed against your specification before an order is placed.',
            ],
            [
                'id' => (string) Str::uuid(),
                'icon' => 'bi-search',
                'title' => 'Made-to-Order Sourcing',
                'description' => "Tell us the product and we'll go look for a supplier who can make it.",
            ],
            [
                'id' => (string) Str::uuid(),
                'icon' => 'bi-file-earmark-text',
                'title' => 'Export Documentation',
                'description' => 'We help coordinate the paperwork and preparation your shipment needs.',
            ],
        ]);

        DB::table('our_process')->insert([
            [
                'id' => (string) Str::uuid(),
                'title' => 'Share Your Brief',
            ],
            [
                'id' => (string) Str::uuid(),
                'title' => 'Sourcing & Shortlisting',
            ],
            [
                'id' => (string) Str::uuid(),
                'title' => 'Sample Approval',
            ],
            [
                'id' => (string) Str::uuid(),
                'title' => 'Order Confirmation',
            ],
            [
                'id' => (string) Str::uuid(),
                'title' => 'Export & Shipping',
            ],
        ]);

        DB::table('about_missions')->insert([
            [
                'id' => (string) Str::uuid(),
                'description' => 'Providing export products that are high quality, hygienic, and meet international standards.',
            ],
            [
                'id' => (string) Str::uuid(),
                'description' => 'Supporting the growth of local Indonesian MSMEs by opening up access to global markets.',
            ],
            [
                'id' => (string) Str::uuid(),
                'description' => 'Establishing sustainable partnerships based on the principles of trust, professionalism, and mutual benefit.',
            ],
            [
                'id' => (string) Str::uuid(),
                'description' => 'Presenting product innovations that suit the needs of the modern market.',
            ],
            [
                'id' => (string) Str::uuid(),
                'description' => 'Promoting a positive image of Indonesian products on the international stage.',
            ],
        ]);

        DB::table('about_values')->insert([
            [
                'id' => (string) Str::uuid(),
                'title' => 'Guaranteed Quality',
                'description' => 'Each product goes through a strict selection and supervision process according to export standards.',
            ],
            [
                'id' => (string) Str::uuid(),
                'title' => 'Professional & Trusted',
                'description' => 'We are highly focused on business partner satisfaction and maintaining long-term relationships.',
            ],
            [
                'id' => (string) Str::uuid(),
                'title' => 'Sustainable Innovation',
                'description' => 'Always adapt to global trends without leaving local identity.',
            ],
            [
                'id' => (string) Str::uuid(),
                'title' => 'Social Commitment',
                'description' => 'Supporting local workforce empowerment and environmental sustainability.',
            ],
        ]);
    }
}
