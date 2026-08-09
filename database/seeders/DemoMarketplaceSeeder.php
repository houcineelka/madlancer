<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DemoMarketplaceSeeder extends Seeder
{
    /**
     * Populate the marketplace with realistic, Fiverr-style demo content:
     * categories, sellers/buyers, gigs (with images/faqs/requirements/
     * upgrades/seo/tags), orders, reviews, favorites and conversations.
     * Reuses the real demo images already bundled under public/storage
     * so every image reference resolves to a real file (via the app's
     * src() helper, which looks up public/storage/{file_folder}/{uid}.{ext}).
     */
    public function run()
    {
        $now = Carbon::now();

        // ---------------------------------------------------------------
        // Admin account
        // ---------------------------------------------------------------
        DB::table('admins')->insert([
            'uid' => uid(),
            'username' => 'admin',
            'email' => 'admin@madlancer.test',
            'password' => Hash::make('password'),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // ---------------------------------------------------------------
        // Site logo (reuse the real logo file already on disk)
        // ---------------------------------------------------------------
        $logoFileId = DB::table('file_manager')->insertGetId([
            'uid' => '18412FCF2425B5F45DEB',
            'file_folder' => 'site/logo',
            'file_size' => '8200',
            'file_mimetype' => 'image/png',
            'file_extension' => 'png',
            'uploader_id' => 1,
            'uploader_type' => 'App\\Models\\User',
            'uploaded_at' => $now,
        ]);
        DB::table('settings_general')->where('id', 1)->update(['logo_id' => $logoFileId]);

        // ---------------------------------------------------------------
        // Categories & subcategories
        // ---------------------------------------------------------------
        $categories = [
            1 => ['Graphics & Design', 'graphics-design'],
            2 => ['Programming & Tech', 'programming-tech'],
            3 => ['Digital Marketing', 'digital-marketing'],
            4 => ['Writing & Translation', 'writing-translation'],
            5 => ['Video & Animation', 'video-animation'],
            6 => ['Music & Audio', 'music-audio'],
            7 => ['Business', 'business'],
        ];
        foreach ($categories as $id => [$name, $slug]) {
            DB::table('categories')->insert([
                'id' => $id,
                'uid' => uid(),
                'name' => $name,
                'slug' => $slug,
                'description' => "Explore top-rated {$name} services from freelancers around the world.",
                'is_visible' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        $subcategories = [
            1  => [1, 'Logo Design', 'logo-design'],
            2  => [1, 'Web & App Design', 'web-app-design'],
            3  => [1, 'Illustration', 'illustration'],
            4  => [2, 'WordPress', 'wordpress'],
            5  => [2, 'Website Development', 'website-development'],
            6  => [2, 'Mobile Apps', 'mobile-apps'],
            7  => [3, 'SEO', 'seo'],
            8  => [3, 'Social Media Marketing', 'social-media-marketing'],
            9  => [4, 'Content Writing', 'content-writing'],
            10 => [4, 'Translation', 'translation'],
            11 => [5, 'Video Editing', 'video-editing'],
            12 => [5, 'Animation', 'animation'],
            13 => [6, 'Voice Over', 'voice-over'],
            14 => [6, 'Music Production', 'music-production'],
            15 => [7, 'Virtual Assistant', 'virtual-assistant'],
            16 => [7, 'Market Research', 'market-research'],
        ];
        foreach ($subcategories as $id => [$parentId, $name, $slug]) {
            DB::table('subcategories')->insert([
                'id' => $id,
                'uid' => uid(),
                'parent_id' => $parentId,
                'name' => $name,
                'slug' => $slug,
                'description' => "{$name} services tailored to your project needs.",
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // ---------------------------------------------------------------
        // Users: 5 sellers + 5 buyers (reusing real avatar files on disk)
        // ---------------------------------------------------------------
        $avatarFiles = [
            ['1082C3CBC3EA54AB300B', 'png'],
            ['2F0CD6CAF7966B96CC75', 'png'],
            ['31100606773C2FFD1146', 'jpg'],
            ['38D355B1047630A7DCEC', 'png'],
            ['4954A0F2F0C410B97BFA', 'png'],
            ['976CE1CDF93682FEB4AF', 'png'],
            ['98ACE258212F9CE1C2D7', 'jpg'],
            ['9A9D1E40436620CD0827', 'png'],
            ['A8CDAC93123392CE4C18', 'png'],
            ['AB1B062B69D27A270456', 'png'],
        ];
        $avatarFileIds = [];
        foreach ($avatarFiles as $i => [$fileUid, $ext]) {
            $avatarFileIds[$i] = DB::table('file_manager')->insertGetId([
                'uid' => $fileUid,
                'file_folder' => 'avatars',
                'file_size' => '45000',
                'file_mimetype' => $ext === 'png' ? 'image/png' : 'image/jpeg',
                'file_extension' => $ext,
                'uploader_id' => $i + 1,
                'uploader_type' => 'App\\Models\\User',
                'uploaded_at' => $now,
            ]);
        }

        // user id 1-5 sellers, 6-10 buyers
        $users = [
            1  => ['seller', 'Sarah Mitchell', 'sarahdesigns', 'sarah.mitchell@example.com', 226, 'Minimalist Logo & Brand Identity Designer', 'I help startups and small businesses build a memorable visual identity with clean, modern logo design.'],
            2  => ['seller', 'Ahmed Hassan', 'ahmedcodes', 'ahmed.hassan@example.com', 164, 'Full-Stack WordPress & Mobile Developer', 'Full-stack developer with 8+ years building fast, responsive WordPress sites and cross-platform mobile apps.'],
            3  => ['seller', 'Maria Santos', 'maria.animates', 'maria.santos@example.com', 170, '2D/3D Animator & Motion Designer', 'I bring brands to life with engaging animated explainer videos and motion graphics.'],
            4  => ['seller', 'James Cooper', 'jamescooper', 'james.cooper@example.com', 1, 'SEO Content Writer & Copywriter', 'Professional writer specializing in SEO-optimized blog content, website copy, and product descriptions.'],
            5  => ['seller', 'Priya Patel', 'priyavoice', 'priya.patel@example.com', 100, 'Professional Female Voice Over Artist', 'Warm, clear, broadcast-quality voice overs for commercials, e-learning, and explainer videos.'],
            6  => ['buyer', 'Michael Turner', 'michael.turner', 'michael.turner@example.com', 1, null, null],
            7  => ['buyer', 'Emma Wilson', 'emma.wilson', 'emma.wilson@example.com', 15, null, null],
            8  => ['buyer', 'Lukas Weber', 'lukas.weber', 'lukas.weber@example.com', 82, null, null],
            9  => ['buyer', 'Sophie Martin', 'sophie.martin', 'sophie.martin@example.com', 74, null, null],
            10 => ['buyer', 'Ryan OBrien', 'ryan.obrien', 'ryan.obrien@example.com', 2, null, null],
        ];

        // Completed profit per seller (for realistic balances), keyed by user id
        $sellerCompletedProfit = [1 => '36.00', 2 => '192.00', 3 => '200.00', 4 => '28.00', 5 => '24.00'];
        $sellerPendingProfit = [2 => '320.00'];
        $buyerPurchases = [6 => '445.00', 7 => '120.00', 8 => '295.00', 9 => '155.00', 10 => '30.00'];

        foreach ($users as $id => [$type, $fullname, $username, $email, $countryId, $headline, $description]) {
            DB::table('users')->insert([
                'id' => $id,
                'uid' => uid(),
                'username' => $username,
                'email' => $email,
                'email_verified_at' => $now,
                'password' => Hash::make('password'),
                'account_type' => $type,
                'avatar_id' => $avatarFileIds[$id - 1],
                'level_id' => $type === 'seller' ? 2 : 1,
                'country_id' => $countryId,
                'fullname' => $fullname,
                'headline' => $headline,
                'description' => $description,
                'status' => 'active',
                'balance_net' => $sellerCompletedProfit[$id] ?? '0.00',
                'balance_available' => $sellerCompletedProfit[$id] ?? '0.00',
                'balance_pending' => $sellerPendingProfit[$id] ?? '0.00',
                'balance_purchases' => $buyerPurchases[$id] ?? '0.00',
                'balance_withdrawn' => '0.00',
                'last_activity' => $now,
                'created_at' => $now->copy()->subDays(120 - $id * 5),
                'updated_at' => $now,
            ]);
        }

        // ---------------------------------------------------------------
        // Seller profile detail: skills, languages, linked accounts,
        // availability, portfolio
        // ---------------------------------------------------------------
        $skills = [
            1 => [['Logo Design', 'pro'], ['Adobe Illustrator', 'pro'], ['Brand Identity', 'intermediate']],
            2 => [['WordPress', 'pro'], ['PHP', 'pro'], ['Flutter', 'intermediate'], ['MySQL', 'pro']],
            3 => [['2D Animation', 'pro'], ['After Effects', 'pro'], ['Motion Graphics', 'intermediate']],
            4 => [['SEO Writing', 'pro'], ['Copywriting', 'pro'], ['Blogging', 'pro']],
            5 => [['Voice Acting', 'pro'], ['Audio Editing', 'intermediate']],
        ];
        foreach ($skills as $userId => $list) {
            foreach ($list as [$name, $exp]) {
                DB::table('user_skills')->insert([
                    'user_id' => $userId,
                    'name' => $name,
                    'slug' => Str::slug($name),
                    'experience' => $exp,
                ]);
            }
        }

        $languages = [
            1 => [['English', 'native'], ['French', 'conversational']],
            2 => [['English', 'fluent'], ['Urdu', 'native']],
            3 => [['English', 'fluent'], ['Filipino', 'native']],
            4 => [['English', 'native']],
            5 => [['English', 'fluent'], ['Hindi', 'native']],
        ];
        foreach ($languages as $userId => $list) {
            foreach ($list as [$name, $level]) {
                DB::table('user_languages')->insert([
                    'user_id' => $userId,
                    'name' => $name,
                    'level' => $level,
                ]);
            }
        }

        $linkedAccounts = [
            1 => ['dribbble_profile' => 'https://dribbble.com/sarahdesigns', 'twitter_profile' => 'https://twitter.com/sarahdesigns'],
            2 => ['github_profile' => 'https://github.com/ahmedcodes', 'stackoverflow_profile' => 'https://stackoverflow.com/users/ahmedcodes'],
            3 => ['youtube_profile' => 'https://youtube.com/@maria.animates', 'vimeo_profile' => 'https://vimeo.com/maria.animates'],
            4 => ['twitter_profile' => 'https://twitter.com/jamescooper'],
            5 => [],
        ];
        foreach ($linkedAccounts as $userId => $fields) {
            if (empty($fields)) continue;
            DB::table('user_linked_accounts')->insert(array_merge(['user_id' => $userId], $fields));
        }

        // Note: user_availability is a "vacation mode" flag — the app treats the mere
        // presence of a row as "seller can't receive orders" regardless of the date,
        // so sellers meant to appear active must NOT have a row here.

        // Portfolio: 1 project per seller, reusing gallery images (added below after gallery files exist)

        // ---------------------------------------------------------------
        // Buyer billing info
        // ---------------------------------------------------------------
        $billing = [
            6  => ['Michael', 'Turner', 'New York', '10001', 1],
            7  => ['Emma', 'Wilson', 'Sydney', '2000', 15],
            8  => ['Lukas', 'Weber', 'Berlin', '10115', 82],
            9  => ['Sophie', 'Martin', 'Paris', '75001', 74],
            10 => ['Ryan', 'OBrien', 'Toronto', 'M5H 2N2', 2],
        ];
        foreach ($billing as $userId => [$first, $last, $city, $zip, $countryId]) {
            DB::table('user_billing')->insert([
                'user_id' => $userId,
                'firstname' => $first,
                'lastname' => $last,
                'city' => $city,
                'zip' => $zip,
                'country_id' => $countryId,
                'address' => '123 Main Street',
            ]);
        }

        // ---------------------------------------------------------------
        // Gig images: previews (thumb/medium/large) + gallery (2 per gig)
        // ---------------------------------------------------------------
        $previewSmall  = ['01B1473B7A1FCF32028E.jpg', '093117FD882CAFBDD0C6.png', '311BC403161589666116.png', '3F1B290F09E5318CB57D.jpg', 'AFD2B14CE772E452E5D1.jpg', 'CBDFF9F981504D12DA2D.png'];
        $previewMedium = ['60A0D9929520E020AF4E.jpg', '883E0C2F7E1ED3693BB1.png', '96B6139BF8A218BFE72A.png', '9B28297E4ED93F50CF96.jpg', 'D6C880D6AB9A0232BB3A.jpg', 'F80279BE122F4032F1AA.png'];
        $previewLarge  = ['1B0277D9DCCA80F41A2D.jpg', '2A65A9B7824025A899CA.png', '5AF43B5811B6475471A9.png', '71D450E628B6900A55F8.jpg', '9B404EB7961829A564F6.png', 'A23C073B08A1FFA4E871.jpg'];

        $gallerySmall  = ['2527AAAE3A8351066043.png', '288A646819672E48DAEB.jpg', '2A381AD8D3FE46DF2C3C.jpg', '3195DE96234D7A9806F9.jpg', '4FFD9E9C694494396B2A.jpg', '6A0595F993BD72DEB583.png', '84DFE68D49036FBE6BF0.jpg', '914D312DC02CFC287690.jpg', 'A6BD566C5A2DCD1535C1.png', 'A9B6911AE88597C5C547.png', 'AF758439109F4DAAED5D.jpg', 'F7AFEACCA0540A704BE4.jpg'];
        $galleryMedium = ['28FF38C258ABB6DE790D.jpg', '478539C7289E3694BE19.jpg', '513AF660E4EA44F0FDAC.png', '5573418AEB7009E723FB.jpg', '70757B81F68D79C7AB97.jpg', '7615DD0572FEAB2649B8.jpg', '77FFE044183B1E62154E.jpg', '873E9D39466EDEBA2212.png', 'B7ACBC0D7BBB3F605F85.png', 'C0D6E907DE7E540D6AA6.jpg', 'DCAA9BB71057BFD57137.png', 'FC81248B9FAB11428778.jpg'];
        $galleryLarge  = ['18774AE7B049126F45A3.jpg', '33BD54213FCC9646C3F3.png', '3A3E4EE4491462ABA7B2.jpg', '46692B0938692C602D12.jpg', '509E8347CEFD6B4E1D4B.png', '574463FE2BAF0B18151A.jpg', 'B46CBF5D179719F878FF.jpg', 'B8B34E49DB5DD60456D9.jpg', 'BD95699649E0DC34B47F.jpg', 'C1E3BDF928883B972F04.png', 'C679719D46DD4DEAF8E2.jpg', 'F3EA5FBD95D8E9B75226.png'];

        $makeFile = function ($fileNameWithExt, $folder, $uploaderId) use ($now) {
            [$fileUid, $ext] = explode('.', $fileNameWithExt);
            return DB::table('file_manager')->insertGetId([
                'uid' => $fileUid,
                'file_folder' => $folder,
                'file_size' => '52000',
                'file_mimetype' => $ext === 'png' ? 'image/png' : 'image/jpeg',
                'file_extension' => $ext,
                'uploader_id' => $uploaderId,
                'uploader_type' => 'App\\Models\\User',
                'uploaded_at' => $now,
            ]);
        };

        $gigOwners = [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 2]; // gig id => owner user id

        $previewFileIds = []; // [gigIndex 0..5] => [thumb, medium, large]
        for ($i = 0; $i < 6; $i++) {
            $ownerId = $gigOwners[$i + 1];
            $previewFileIds[$i] = [
                'thumb'  => $makeFile($previewSmall[$i], 'gigs/previews/small', $ownerId),
                'medium' => $makeFile($previewMedium[$i], 'gigs/previews/medium', $ownerId),
                'large'  => $makeFile($previewLarge[$i], 'gigs/previews/large', $ownerId),
            ];
        }

        $galleryFileIds = []; // [gigIndex 0..5] => [ [thumb,medium,large], [thumb,medium,large] ]
        for ($i = 0; $i < 6; $i++) {
            $ownerId = $gigOwners[$i + 1];
            $galleryFileIds[$i] = [];
            foreach ([0, 1] as $slot) {
                $galleryIdx = $i * 2 + $slot;
                $galleryFileIds[$i][$slot] = [
                    'thumb'  => $makeFile($gallerySmall[$galleryIdx], 'gigs/gallery/small', $ownerId),
                    'medium' => $makeFile($galleryMedium[$galleryIdx], 'gigs/gallery/medium', $ownerId),
                    'large'  => $makeFile($galleryLarge[$galleryIdx], 'gigs/gallery/large', $ownerId),
                ];
            }
        }

        // ---------------------------------------------------------------
        // Portfolio (1 project per seller, reusing that seller's gig gallery image)
        // ---------------------------------------------------------------
        $portfolioTitles = [
            1 => 'Brand Identity for Artisan Coffee Co.',
            2 => 'E-commerce WordPress Rebuild',
            3 => 'Explainer Video for FinTech Startup',
            4 => 'SEO Blog Series for SaaS Company',
            5 => 'Corporate Training Voice Over Series',
        ];
        $portfolioIds = [];
        foreach ($portfolioTitles as $userId => $title) {
            $gigIndex = $userId - 1; // seller i owns gig i (except seller2 owns 2 & 6, gigIndex 1 works fine)
            $thumbFileId = $galleryFileIds[$gigIndex][0]['large'];
            $portfolioIds[$userId] = DB::table('user_portfolio')->insertGetId([
                'uid' => uid(),
                'user_id' => $userId,
                'title' => $title,
                'slug' => Str::slug($title),
                'description' => "A showcase project demonstrating my process and results for {$title}.",
                'thumb_id' => $thumbFileId,
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
            DB::table('user_portfolio_gallery')->insert([
                'project_id' => $portfolioIds[$userId],
                'image_id' => $thumbFileId,
            ]);
        }

        // ---------------------------------------------------------------
        // Gigs
        // ---------------------------------------------------------------
        $gigs = [
            1 => [1, 1, 1, 'design a modern minimalist logo for your brand', '45.00', 3,
                "I will create a clean, modern, and memorable logo design tailored to your brand's identity.\n\nWith over 8 years of experience helping startups and small businesses, I focus on simple, versatile logos that work everywhere — from business cards to billboards.\n\nWhat you get:\n- 3 initial concepts\n- Unlimited revisions on the chosen concept\n- Final files in PNG, SVG, PDF and AI\n- Full copyright ownership",
                ['logo design', 'branding', 'minimalist', 'illustrator']],
            2 => [2, 2, 4, 'develop a fully responsive WordPress website', '120.00', 7,
                "I will build a fast, fully responsive WordPress website using the latest best practices in performance and SEO.\n\nWhether you need a business site, portfolio, or blog, I'll set up a clean design, install the right plugins, and make sure everything works flawlessly on mobile and desktop.\n\nWhat you get:\n- Custom WordPress theme setup\n- Up to 5 pages\n- Contact form & SEO basics\n- Mobile-responsive design",
                ['wordpress', 'website', 'responsive', 'php']],
            3 => [3, 5, 12, 'create a professional 2D animated explainer video', '250.00', 10,
                "I will produce a polished 2D animated explainer video to help you communicate your product or service clearly and engagingly.\n\nFrom script guidance to final render, I handle the whole animation process using industry-standard tools.\n\nWhat you get:\n- Up to 60 seconds of animation\n- Custom illustrated characters\n- Background music & sound effects\n- Full HD 1080p export",
                ['animation', 'explainer video', 'motion graphics', '2d animation']],
            4 => [4, 4, 9, 'write SEO optimized blog articles and website content', '35.00', 2,
                "I will write engaging, well-researched, SEO-optimized content that ranks and converts.\n\nI've written for SaaS companies, e-commerce brands, and agencies across a range of industries.\n\nWhat you get:\n- Up to 1000 words per article\n- Keyword research included\n- Plagiarism-free, human-written content\n- One round of free revisions",
                ['seo writing', 'content writing', 'copywriting', 'blog']],
            5 => [5, 6, 13, 'record a professional female voice over in English', '30.00', 2,
                "I will record a warm, clear, broadcast-quality voice over for your commercial, e-learning course, or explainer video.\n\nRecorded in a treated home studio with professional equipment and delivered as a clean, noise-free file.\n\nWhat you get:\n- Up to 200 words of script\n- Studio-quality WAV & MP3 files\n- Commercial usage rights\n- One free revision",
                ['voice over', 'female voice', 'narration', 'audio']],
            6 => [2, 2, 6, 'build a cross platform mobile app using Flutter', '400.00', 14,
                "I will develop a high-quality, cross-platform mobile app using Flutter, so your app runs natively on both iOS and Android from a single codebase.\n\nI handle everything from UI implementation to API integration and app store submission guidance.\n\nWhat you get:\n- Native iOS & Android app\n- Up to 6 screens\n- REST API integration\n- Source code included",
                ['flutter', 'mobile app', 'ios', 'android']],
        ];

        $gigStatus = [1 => 'featured', 2 => 'active', 3 => 'boosted', 4 => 'active', 5 => 'active', 6 => 'active'];
        $gigRating = [1 => '5.0', 2 => '5.0', 3 => '4.0', 4 => '5.0', 5 => '4.0', 6 => '0'];
        $gigReviewCount = [1 => 1, 2 => 1, 3 => 1, 4 => 1, 5 => 1, 6 => 0];
        $gigSalesCount = [1 => 1, 2 => 2, 3 => 1, 4 => 1, 5 => 1, 6 => 0];
        $gigQueueCount = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 1];

        foreach ($gigs as $id => [$ownerId, $categoryId, $subcategoryId, $title, $price, $deliveryDays, $description, $tags]) {
            $idx = $id - 1;
            DB::table('gigs')->insert([
                'id' => $id,
                'uid' => uid(),
                'user_id' => $ownerId,
                'title' => $title,
                'slug' => Str::slug($title) . '-' . strtolower(substr(uid(), 0, 6)),
                'description' => $description,
                'price' => $price,
                'delivery_time' => $deliveryDays,
                'category_id' => $categoryId,
                'subcategory_id' => $subcategoryId,
                'image_thumb_id' => $previewFileIds[$idx]['thumb'],
                'image_medium_id' => $previewFileIds[$idx]['medium'],
                'image_large_id' => $previewFileIds[$idx]['large'],
                'status' => $gigStatus[$id],
                'counter_visits' => rand(150, 900),
                'counter_impressions' => rand(1000, 5000),
                'counter_sales' => $gigSalesCount[$id],
                'counter_reviews' => $gigReviewCount[$id],
                'rating' => $gigRating[$id],
                'orders_in_queue' => $gigQueueCount[$id],
                'has_upgrades' => true,
                'has_faqs' => true,
                'created_at' => $now->copy()->subDays(90 - $id * 5),
                'updated_at' => $now,
            ]);

            // Gallery images
            foreach ([0, 1] as $slot) {
                DB::table('gig_images')->insert([
                    'gig_id' => $id,
                    'img_thumb_id' => $galleryFileIds[$idx][$slot]['thumb'],
                    'img_medium_id' => $galleryFileIds[$idx][$slot]['medium'],
                    'img_large_id' => $galleryFileIds[$idx][$slot]['large'],
                ]);
            }

            // Tags (rtconner/laravel-tagging tables, inserted directly)
            foreach ($tags as $tagName) {
                $tagSlug = Str::slug($tagName);
                $tag = DB::table('tagging_tags')->where('slug', $tagSlug)->first();
                if ($tag) {
                    DB::table('tagging_tags')->where('id', $tag->id)->increment('count');
                    $tagId = $tag->id;
                } else {
                    $tagId = DB::table('tagging_tags')->insertGetId([
                        'slug' => $tagSlug,
                        'name' => $tagName,
                        'suggest' => false,
                        'count' => 1,
                    ]);
                }
                DB::table('tagging_tagged')->insert([
                    'taggable_id' => $id,
                    'taggable_type' => 'App\\Models\\Gig',
                    'tag_name' => $tagName,
                    'tag_slug' => $tagSlug,
                ]);
            }
        }

        // FAQs
        $faqs = [
            1 => [['Do you offer unlimited revisions?', 'Yes, unlimited revisions are included on the initial concept you choose.'], ['Will I own the copyright?', 'Yes, full copyright and source files are transferred to you upon completion.']],
            2 => [['Do you provide hosting?', 'I can help configure your site on any hosting provider, but hosting itself is not included.'], ['Can you migrate my existing site?', 'Yes, I can migrate content from your current site into the new WordPress build.']],
            3 => [['What software do you use?', 'I use Adobe After Effects and Illustrator for all animation work.'], ['Can you write the script too?', 'Yes, script writing is available as an add-on upgrade.']],
            4 => [['Do you do keyword research?', 'Yes, basic keyword research is included with every article.'], ['Is the content plagiarism-free?', 'Absolutely, every article is written from scratch and checked with plagiarism tools.']],
            5 => [['What format will I receive?', 'You will receive both WAV and MP3 files.'], ['Can you match a reference voice style?', 'Yes, please share a reference and I will match the tone as closely as possible.']],
            6 => [['Which platforms do you support?', 'I build for both iOS and Android using a single Flutter codebase.'], ['Do you handle app store submission?', 'I provide guidance and prepare all required assets for submission.']],
        ];
        foreach ($faqs as $gigId => $qas) {
            foreach ($qas as [$q, $a]) {
                DB::table('gig_faqs')->insert(['gig_id' => $gigId, 'question' => $q, 'answer' => $a]);
            }
        }

        // Requirements
        $requirements = [
            1 => 'Please describe your business and any color/style preferences.',
            2 => 'Please share your site content, branding, and any reference websites you like.',
            3 => 'Please share your script or a brief description of what the video should explain.',
            4 => 'Please share the topic, target keywords, and tone of voice you prefer.',
            5 => 'Please share the script or text you would like recorded.',
            6 => 'Please share your app requirements, wireframes, or reference apps.',
        ];
        foreach ($requirements as $gigId => $question) {
            DB::table('gig_requirements')->insert([
                'gig_id' => $gigId,
                'question' => $question,
                'type' => 'text',
                'is_required' => true,
                'is_multiple' => false,
            ]);
        }

        // Upgrades
        $upgrades = [
            1 => [['Extra fast delivery (1 day)', '20.00', -2], ['Additional logo concept', '15.00', 1]],
            2 => [['Extra fast delivery (3 days)', '40.00', -4], ['SEO setup package', '25.00', 1]],
            3 => [['Extra 30 seconds of animation', '80.00', 3], ['Voice over included', '35.00', 1]],
            4 => [['Extra 500 words', '15.00', 1], ['Rush delivery (24h)', '10.00', -1]],
            5 => [['Extra 100 words', '10.00', 0], ['Rush delivery (24h)', '10.00', -1]],
            6 => [['Extra screen (up to 2)', '100.00', 3], ['Push notifications integration', '60.00', 2]],
        ];
        foreach ($upgrades as $gigId => $list) {
            foreach ($list as [$title, $price, $extraDays]) {
                DB::table('gig_upgrades')->insert([
                    'uid' => uid(),
                    'gig_id' => $gigId,
                    'title' => $title,
                    'price' => $price,
                    'extra_days' => $extraDays,
                ]);
            }
        }

        // SEO
        foreach ($gigs as $id => [$ownerId, $categoryId, $subcategoryId, $title, $price, $deliveryDays, $description, $tags]) {
            DB::table('gig_seo')->insert([
                'gig_id' => $id,
                'title' => $title . ' | Madlancer',
                'description' => Str::limit(strip_tags(str_replace("\n", ' ', $description)), 150),
            ]);
        }

        // ---------------------------------------------------------------
        // Orders + order items + invoices
        // ---------------------------------------------------------------
        // [buyerId, gigId, status, daysAgo, hasReview]
        $orderPlan = [
            ['id' => 1, 'buyer' => 6,  'gig' => 1, 'status' => 'delivered', 'days_ago' => 20, 'finished' => true],
            ['id' => 2, 'buyer' => 7,  'gig' => 2, 'status' => 'delivered', 'days_ago' => 18, 'finished' => true],
            ['id' => 3, 'buyer' => 8,  'gig' => 3, 'status' => 'delivered', 'days_ago' => 15, 'finished' => true],
            ['id' => 4, 'buyer' => 9,  'gig' => 4, 'status' => 'delivered', 'days_ago' => 12, 'finished' => true],
            ['id' => 5, 'buyer' => 10, 'gig' => 5, 'status' => 'delivered', 'days_ago' => 10, 'finished' => true],
            ['id' => 6, 'buyer' => 6,  'gig' => 6, 'status' => 'proceeded', 'days_ago' => 3,  'finished' => false],
            ['id' => 7, 'buyer' => 8,  'gig' => 1, 'status' => 'pending',   'days_ago' => 1,  'finished' => false],
            ['id' => 8, 'buyer' => 9,  'gig' => 2, 'status' => 'delivered', 'days_ago' => 5,  'finished' => true],
        ];

        $gigPrice = [];
        foreach ($gigs as $id => $g) { $gigPrice[$id] = $g[4]; }

        $reviewPlan = [
            1 => ['user' => 6,  'rating' => 5, 'message' => "Amazing work! Sarah understood exactly what I needed and delivered a beautiful logo well ahead of schedule. Highly recommend!"],
            2 => ['user' => 7,  'rating' => 5, 'message' => "Ahmed rebuilt our website and it looks fantastic. Fast communication and great attention to detail."],
            3 => ['user' => 8,  'rating' => 4, 'message' => "Great animation, captured our product perfectly. One revision needed but overall very happy."],
            4 => ['user' => 9,  'rating' => 5, 'message' => "James writes excellent, well-researched articles. Already seeing better engagement on our blog."],
            5 => ['user' => 10, 'rating' => 4, 'message' => "Lovely voice, very professional. Delivered quickly and was easy to work with."],
        ];

        foreach ($orderPlan as $o) {
            $placedAt = $now->copy()->subDays($o['days_ago']);
            $total = $gigPrice[$o['gig']];
            $profit = number_format($total * 0.8, 2, '.', '');
            $commission = number_format($total * 0.2, 2, '.', '');

            DB::table('orders')->insert([
                'id' => $o['id'],
                'uid' => uid(),
                'buyer_id' => $o['buyer'],
                'total_value' => $total,
                'subtotal_value' => $total,
                'taxes_value' => '0.00',
                'is_finished' => $o['finished'],
                'placed_at' => $placedAt,
            ]);

            $itemData = [
                'uid' => uid(),
                'order_id' => $o['id'],
                'gig_id' => $o['gig'],
                'owner_id' => $gigOwners[$o['gig']],
                'quantity' => 1,
                'has_upgrades' => false,
                'is_requirements_sent' => $o['status'] !== 'pending',
                'total_value' => $total,
                'profit_value' => $o['status'] === 'delivered' ? $profit : '0.00',
                'commission_value' => $o['status'] === 'delivered' ? $commission : '0.00',
                'status' => $o['status'],
                'is_finished' => $o['finished'],
                'placed_at' => $placedAt,
                'expected_delivery_date' => $placedAt->copy()->addDays(5),
            ];
            if ($o['status'] === 'delivered') {
                $itemData['proceeded_at'] = $placedAt->copy()->addHours(2);
                $itemData['delivered_at'] = $placedAt->copy()->addDays(4);
            } elseif ($o['status'] === 'proceeded') {
                $itemData['proceeded_at'] = $placedAt->copy()->addHours(2);
            }
            $itemId = DB::table('order_items')->insertGetId($itemData);

            DB::table('order_invoice')->insert([
                'order_id' => $o['id'],
                'payment_method' => 'stripe',
                'payment_id' => 'pi_' . strtolower(uid()),
                'firstname' => $users[$o['buyer']][1] !== null ? explode(' ', $users[$o['buyer']][1])[0] : 'Guest',
                'lastname' => $users[$o['buyer']][1] !== null ? (explode(' ', $users[$o['buyer']][1])[1] ?? '') : '',
                'email' => $users[$o['buyer']][3],
                'address' => '123 Main Street',
                'created_at' => $placedAt,
            ]);

            if (isset($reviewPlan[$o['id']])) {
                $r = $reviewPlan[$o['id']];
                DB::table('reviews')->insert([
                    'uid' => uid(),
                    'user_id' => $r['user'],
                    'seller_id' => $gigOwners[$o['gig']],
                    'gig_id' => $o['gig'],
                    'rating' => $r['rating'],
                    'message' => $r['message'],
                    'status' => 'active',
                    'created_at' => $placedAt->copy()->addDays(5),
                    'updated_at' => $placedAt->copy()->addDays(5),
                ]);
            }
        }

        // ---------------------------------------------------------------
        // Favorites
        // ---------------------------------------------------------------
        $favorites = [
            [7, 3], [7, 5], [10, 1], [10, 4], [6, 2],
        ];
        foreach ($favorites as [$userId, $gigId]) {
            DB::table('favorites')->insert([
                'gig_id' => $gigId,
                'user_id' => $userId,
                'created_at' => $now->copy()->subDays(rand(1, 15)),
            ]);
        }

        // ---------------------------------------------------------------
        // Conversations + messages
        // ---------------------------------------------------------------
        $conversationId1 = DB::table('conversations')->insertGetId([
            'uid' => uid(),
            'from_id' => 6,
            'to_id' => 1,
            'status' => 'active',
            'last_message_at' => $now->copy()->subDays(21),
            'created_at' => $now->copy()->subDays(22),
        ]);
        $messages1 = [
            [6, 1, "Hi Sarah, I love your logo portfolio! Do you also design business cards?"],
            [1, 6, "Hi Michael, thank you! Yes, I can put together a matching business card design as an add-on once the logo is finalized."],
            [6, 1, "Perfect, I'll place an order for the logo gig now and we can discuss the business card after."],
        ];
        foreach ($messages1 as $i => [$from, $to, $msg]) {
            DB::table('conversation_messages')->insert([
                'uid' => uid(),
                'conversation_id' => $conversationId1,
                'message_from' => $from,
                'message_to' => $to,
                'message' => $msg,
                'is_seen' => true,
                'created_at' => $now->copy()->subDays(22)->addHours($i),
            ]);
        }

        $conversationId2 = DB::table('conversations')->insertGetId([
            'uid' => uid(),
            'from_id' => 9,
            'to_id' => 2,
            'status' => 'active',
            'last_message_at' => $now->copy()->subDays(6),
            'created_at' => $now->copy()->subDays(6),
        ]);
        $messages2 = [
            [9, 2, "Hi Ahmed, can your WordPress package include a blog setup with categories?"],
            [2, 9, "Hi Sophie, yes — I'll include a fully configured blog section with categories and tags as part of the build."],
        ];
        foreach ($messages2 as $i => [$from, $to, $msg]) {
            DB::table('conversation_messages')->insert([
                'uid' => uid(),
                'conversation_id' => $conversationId2,
                'message_from' => $from,
                'message_to' => $to,
                'message' => $msg,
                'is_seen' => true,
                'created_at' => $now->copy()->subDays(6)->addHours($i),
            ]);
        }
    }
}
