<?php

return [
    'column' => [
        'name' => 'Názov',
        'guard_name' => 'Guard',
        'controller_class' => 'Controller',
        'controller_method_group' => 'Skupina akcií',
        'controller_method' => 'Akcia',
    ],
    'field' => [
        'name' => 'Názov',
        'guard_name' => 'Guard',
        'controller_class' => 'Controller',
        'controller_method_group' => 'Skupina akcií',
        'controller_method' => 'Akcia',
    ],
    'model' => [
        'title' => [
            'singular' => 'Právo používateľov administrácie',
            'plural' => 'Práva používateľov administrácie',
        ],
    ],
    'method-group' => [
        'read-only' => 'čítanie',
        'write' => 'zápis',
    ],
    'param' => [
        'image' => 'Obrázky',
        'country' => 'Krajiny',
        'language' => 'Jazyky',
        'locale' => 'Lokalizácie',
        'name_day' => 'Meniny',
        'user' => 'Použivatelia administrácie',
        'group' => 'Skupiny používateľov',
        'role' => 'Role použivateľov',
        'permission' => 'Práva',
        'shop' => 'e-shopy',
        'delivery_method' => 'Spôsoby doručenia',
        'payment_method' => 'Spôsoby platby',
        'post_office' => 'Poštové úrady',
        'balikomat_address' => 'Adresy balíkomatu',
        's_p_s_parcelshop_address' => 'Adresy SPS Parcelshop',
        'invoice_template' => 'Faktúry - šablóny',
        'product' => 'Produkty',
        'product_category' => 'Kategórie produktov',
        'product_variant' => 'Varianty produktov',
        'product_review' => 'Recenzie produktov',
        'product_faq' => 'FAQ produktov',
        'package_box' => 'Balenie',
        'flyer' => 'Letáky',
        'package_type' => 'Typy balenia',
        'warehouse' => 'Sklady',
        'warehouse_log' => 'Logy skladov',
        'order' => 'Objednávky',
        'order_item' => 'Položky objednávok',
        'order_delivery' => 'Nastavenia doručenia objednávok',
        'order_payment' => 'Fakturačné údaje objednávok',
        'coupon' => 'Kupóny',
        'customer' => 'Zákazníci',
        'customer_note' => 'Poznámky k zákazníkom',
        'blacklisted_visitor' => 'Blacklist',
        'email_order_notification' => 'e-mail notifikácie objednávok',
        'sms_order_notification' => 'SMS notifikácie objednávok',
        'email_system_notification' => 'e-mail systémové notifikácie',
        'sms_system_notification' => 'SMS systémové notifikácie',
        'communication_log' => 'Log komunikácie',
        'translation' => 'Preklad',
        'file' => 'Súbory',
        'ebook' => 'ebooky',
        'newsletter_registration' => 'Registrácie do newsletteru',
        'email_user_notification' => 'e-mail notifikácie používateľov',
        'export' => 'Export',
        // CMS
        'page_template' => 'Šablóny stránok',
        'page' => 'Stránky',
        'page_proxy' => 'Proxy stránky',
        'shop_frontpage_settings' => 'Frontpage nastavenia shopov',
        'html_wrapper' => 'CMS element - HTML Wrapper',
        'cookie_consent' => 'CMS element - Súhlas s používaním cookies',
        'top_navigation' => 'CMS element - Horná navigácia',
        'top_panel' => 'CMS element - Horný panel',
        'main_navigation' => 'CMS element - Hlavná navigácia',
        'navigation_item' => 'CMS element - Položky navigácie',

        'delivery_list' => 'CMS element - Zoznam metód dodania',
        'product_list' => 'CMS element - Zoznam produktov',
        'ebook_list' => 'CMS element - Zoznam ebooks',
        'advice_list' => 'CMS element - Zoznam článkov poradne',
        'advice_expert_list' => 'CMS element - Zoznam článkov odbornej poradne',
        'advice_pair_list' => 'CMS element - Zoznam článkov párovej poradne',
        'article_video_list' => 'CMS element - Zoznam video článkov',
        'certificate_list' => 'CMS element - Zoznam certifikátov',
        'joke_list' => 'CMS element - Zoznam vtipov',
        'reference_list' => 'CMS element - Zoznam referencií',
        'reference_external_list' => 'CMS element - Zoznam externých referencií',
        'reference_video_list' => 'CMS element - Zoznam video referencií',
        'header' => 'CMS element - Hlavička',
        'text' => 'CMS element - Textový blok',
        'link' => 'CMS element - Link',
        'gallery' => 'CMS element - Galéria',
        'iframe_video' => 'CMS element - iframe video',
        'html_wrapper' => 'CMS element - HTML wrapper',
        'cookie_consent' => 'CMS element - Súhlas s používaním cookies',
        'top_navigation' => 'CMS element - Horná navigácia',
        'top_panel' => 'CMS element - Horný panel',
        'social_footer' => 'CMS element - Social footers',
        'footer_navigation' => 'CMS element - Footer navigácie',
        'footer_note' => 'CMS element - Footer poznámky',
        'about_panel' => 'CMS element - Informačné panely',
        'stats_panel' => 'CMS element - Štatistické panely',
        'comparison_panel' => 'CMS element - Porovnávacie panely',
        'additional_info_panel' => 'CMS element - Dodatočné info panely',
        'advice_expert_panel' => 'CMS element - Panely odbornej poradne',
        'newsletter' => 'CMS element - Newsletter formuláre',
        'search_engine' => 'CMS element - Vyhľadávače',
        'login_registration' => 'CMS element - Formuláre pre prihlásenie a registráciu',
        'forgot_password' => 'CMS element - Formuláre pre zabudnuté heslo',
        'user_profile' => 'CMS element - Profily zákazníkov',
        'shopping_cart' => 'CMS element - Nákupné košíky',
        'shopping-checkout' => 'CMS element - Pokladňa',
        'shopping-after' => 'CMS element - Po nákupe',
        'main_navigation' => 'CMS element - Hlavná navigácia',
        'row_navigation' => 'CMS element - Navigácia v riadku',
        'main_slider' => 'CMS element - Hlavné slidere',
        'navigation_item' => 'CMS element - Položky navigácie',
        'slider_item' => 'CMS element - Slider',
        'product-faq' => 'CMS element - FAQ produktov',
        'advice_expert_question' => 'Otázky pre odbornú poradňu',
        'advice' => 'Články v poradni',
        'advice_expert' => 'Články v odbornej poradni',
        'advice_pair' => 'Články v párovej poradni',
        'article_video' => 'Video články',
        'certificate' => 'Certifikátu',
        'joke' => 'Vtipy',
        'reference' => 'Referencie',
        'reference_external' => 'Externé referencie',
        'reference_video' => 'Video referencie',
        'proxy_product' => 'CMS element - Proxy produkt',
        'proxy_ebook' => 'CMS element - Proxy ebook',
        'proxy_advice' => 'CMS element - Proxy článok v poradni',
        'proxy_advice_pair' => 'CMS element - Proxy článok v párovej poradni',
        'proxy_article_video' => 'CMS element - Proxy video článok',
        'proxy_reference_video' => 'CMS element - Proxy video referencia',
        'affiliate' => 'CMS element - Affiliate form',
        'contact' => 'CMS element - Kontakt form',
    ],
];