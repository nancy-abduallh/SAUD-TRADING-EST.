<?php
// One entry per manageable content type. Field types:
// text | textarea | number | url | email | image | icon | select | toggle | rating
// 'list' => show in table, 'required', 'filter' => adds a filter dropdown, 'source' => FK lookup
return [
    'hero' => [
        'table' => 'hero_slides', 'title' => 'Hero Slides', 'singular' => 'Slide', 'dir' => 'hero',
        'toggle' => 'is_active', 'sortable' => true, 'order' => 'sort_order, id',
        'fields' => [
            fld('title', 'Title', 'text', ['required' => 1, 'list' => 1]),
            fld('subtitle', 'Subtitle', 'text', ['list' => 1]),
            fld('description', 'Description', 'textarea', ['list' => 1]),
            fld('image_url', 'Image', 'image', ['list' => 1]),
            fld('cta_text', 'Button text'),
            fld('cta_link', 'Button link'),
            fld('sort_order', 'Order', 'number'),
            fld('is_active', 'Active', 'toggle'),
        ],
    ],
    'services' => [ // = the three sector pillars from site-data
        'table' => 'sectors', 'title' => 'Sectors & Services', 'singular' => 'Sector', 'dir' => 'sectors',
        'toggle' => null, 'sortable' => true, 'order' => 'sort_order, id',
        'fields' => [
            fld('slug', 'Key (slug)', 'text', ['required' => 1, 'list' => 1, 'help' => 'Used by the site as the object key: plastics / food / digital']),
            fld('title', 'Title (Arabic)', 'text', ['required' => 1, 'list' => 1]),
            fld('english', 'English label', 'text', ['list' => 1]),
            fld('description', 'Description', 'textarea'),
            fld('image', 'Image', 'image', ['list' => 1]),
            fld('image_alt', 'Image alt text'),
            fld('sort_order', 'Order', 'number'),
        ],
    ],
    'categories' => [
        'table' => 'categories', 'title' => 'Categories', 'singular' => 'Category', 'dir' => 'misc',
        'toggle' => null, 'sortable' => true, 'order' => 'sector_id, sort_order, id',
        'fields' => [
            fld('sector_id', 'Sector', 'select', ['required' => 1, 'list' => 1, 'filter' => 1,
                'source' => ['table' => 'sectors', 'label' => 'title']]),
            fld('name', 'Category name', 'text', ['required' => 1, 'list' => 1]),
            fld('sort_order', 'Order', 'number'),
        ],
    ],
    'products' => [
        'table' => 'products', 'title' => 'Products', 'singular' => 'Product', 'dir' => 'products',
        'toggle' => 'is_active', 'sortable' => true, 'order' => 'category_id, sort_order, id',
        'fields' => [
            fld('category_id', 'Category', 'select', ['required' => 1, 'list' => 1, 'filter' => 1,
                'source' => ['table' => 'categories', 'label' => 'name']]),
            fld('name', 'Product name', 'text', ['required' => 1, 'list' => 1]),
            fld('icon', 'Icon (Lucide name)', 'icon', ['list' => 1]),
            fld('blurb', 'Short description', 'textarea'),
            fld('image', 'Image', 'image', ['list' => 1]),
            fld('sort_order', 'Order', 'number'),
            fld('is_active', 'Visible', 'toggle'),
        ],
    ],
    'brands' => [
        'table' => 'brands', 'title' => 'Brands', 'singular' => 'Brand', 'dir' => 'brands',
        'toggle' => 'is_active', 'sortable' => true, 'order' => 'sort_order, id',
        'fields' => [
            fld('name', 'Name', 'text', ['required' => 1, 'list' => 1]),
            fld('logo_url', 'Logo', 'image', ['list' => 1]),
            fld('website_url', 'Website', 'url', ['list' => 1]),
            fld('sort_order', 'Order', 'number'),
            fld('is_active', 'Visible', 'toggle'),
        ],
    ],
    'clients' => [
        'table' => 'clients', 'title' => 'Clients', 'singular' => 'Client', 'dir' => 'clients',
        'toggle' => 'is_active', 'sortable' => true, 'order' => 'sort_order, id',
        'fields' => [
            fld('name', 'Client name', 'text', ['required' => 1, 'list' => 1]),
            fld('logo_url', 'Logo', 'image', ['list' => 1]),
            fld('description', 'Description', 'textarea'),
            fld('sort_order', 'Order', 'number'),
            fld('is_active', 'Visible', 'toggle'),
        ],
    ],
    'testimonials' => [
        'table' => 'testimonials', 'title' => 'Testimonials', 'singular' => 'Testimonial', 'dir' => 'avatars',
        'toggle' => 'is_active', 'sortable' => false, 'order' => 'id DESC',
        'fields' => [
            fld('client_name', 'Client name', 'text', ['required' => 1, 'list' => 1]),
            fld('client_position', 'Position'),
            fld('client_company', 'Company', 'text', ['list' => 1]),
            fld('content', 'Testimonial', 'textarea', ['required' => 1, 'list' => 1]),
            fld('avatar_url', 'Avatar', 'image', ['list' => 1]),
            fld('rating', 'Rating', 'rating', ['list' => 1]),
            fld('is_active', 'Visible', 'toggle'),
        ],
    ],
    'faqs' => [
        'table' => 'faqs', 'title' => 'FAQs', 'singular' => 'FAQ', 'dir' => 'misc',
        'toggle' => 'is_active', 'sortable' => true, 'order' => 'sort_order, id',
        'fields' => [
            fld('question', 'Question', 'text', ['required' => 1, 'list' => 1]),
            fld('answer', 'Answer', 'textarea', ['required' => 1, 'list' => 1]),
            fld('sort_order', 'Order', 'number'),
            fld('is_active', 'Visible', 'toggle'),
        ],
    ],
    'values' => [
        'table' => 'site_values', 'title' => 'Company Values', 'singular' => 'Value', 'dir' => 'misc',
        'toggle' => null, 'sortable' => true, 'order' => 'sort_order, id',
        'fields' => [
            fld('title', 'Title', 'text', ['required' => 1, 'list' => 1]),
            fld('description', 'Description', 'textarea', ['list' => 1]),
            fld('icon', 'Icon (Lucide name)', 'icon', ['list' => 1]),
            fld('sort_order', 'Order', 'number'),
        ],
    ],
    'ecosystem' => [
        'table' => 'digital_ecosystem', 'title' => 'Digital Ecosystem', 'singular' => 'Pillar', 'dir' => 'misc',
        'toggle' => null, 'sortable' => true, 'order' => 'sort_order, id',
        'fields' => [
            fld('title', 'Title', 'text', ['required' => 1, 'list' => 1]),
            fld('description', 'Description', 'textarea', ['list' => 1]),
            fld('icon', 'Icon (Lucide name)', 'icon', ['list' => 1]),
            fld('sort_order', 'Order', 'number'),
        ],
    ],
    'comparison' => [
        'table' => 'comparison_rows', 'title' => 'Comparison Table', 'singular' => 'Row', 'dir' => 'misc',
        'toggle' => null, 'sortable' => true, 'order' => 'sort_order, id',
        'fields' => [
            fld('label', 'Label', 'text', ['required' => 1, 'list' => 1]),
            fld('traditional', 'Traditional methods', 'text', ['list' => 1]),
            fld('smart', 'Smart / AI-driven', 'text', ['list' => 1]),
            fld('sort_order', 'Order', 'number'),
        ],
    ],
    'stats' => [
        'table' => 'stats', 'title' => 'Stats / KPIs', 'singular' => 'Stat', 'dir' => 'misc',
        'toggle' => null, 'sortable' => true, 'order' => 'sort_order, id',
        'fields' => [
            fld('value', 'Value (e.g. +٤٥)', 'text', ['required' => 1, 'list' => 1]),
            fld('label', 'Label', 'text', ['required' => 1, 'list' => 1]),
            fld('icon', 'Icon (optional)', 'icon'),
            fld('suffix', 'Suffix (optional)'),
            fld('sort_order', 'Order', 'number'),
        ],
    ],
    'countries' => [
        'table' => 'countries', 'title' => 'Countries', 'singular' => 'Country', 'dir' => 'misc',
        'toggle' => null, 'sortable' => true, 'order' => 'sort_order, id',
        'fields' => [
            fld('name', 'Name (Arabic)', 'text', ['required' => 1, 'list' => 1]),
            fld('english', 'Name (English)', 'text', ['list' => 1]),
            fld('sort_order', 'Order', 'number'),
        ],
    ],
];