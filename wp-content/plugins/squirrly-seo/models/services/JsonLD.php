<?php

class SQ_Models_Services_JsonLD extends SQ_Models_Abstract_Seo {
    private $_data = array();
    private $_types = array();


    public function __construct() {
        parent::__construct();

        if ($this->_post->sq->doseo) {
            if (!$this->_post->sq->do_jsonld) {
                add_filter('sq_json_ld', array($this, 'returnFalse'));
                return;
            }

            if (SQ_Classes_Helpers_Tools::getOption('sq_jsonld_woocommerce')) {
                if (SQ_Classes_Helpers_Tools::isPluginInstalled('woocommerce/woocommerce.php')) {
                    // Generate structured data for Woocommerce 3+.
                    if ($this->_post->post_type == 'product') {
                        add_filter('sq_json_ld', array($this, 'generate_product_data'), 8);
                    }
                }
            }

            if (SQ_Classes_Helpers_Tools::getOption('sq_jsonld_breadcrumbs')) {
                add_filter('sq_json_ld', array($this, 'generate_breadcrumblist_data'), 9);
            }
            add_filter('sq_json_ld', array($this, 'generate_structured_data'), 10);

            add_filter('sq_json_ld', array($this, 'generateJsonLd'));
            add_filter('sq_json_ld', array($this, 'packJsonLd'), 99);
        } else {
            add_filter('sq_json_ld', array($this, 'returnFalse'));
        }

    }


    /**
     * Sanitizes, encodes and outputs structured data.
     *
     * @return array|string
     */
    public function generateJsonLd() {
        $types = $this->get_data_type_for_page();
        return $this->clean($this->get_structured_data($types));
    }

    /**
     * Pack the Structured Data
     */
    public function packJsonLd($data = array()) {
        if (!empty($data)) {
            if ($this->_post->sq->jsonld && strpos($this->_post->sq->jsonld, '"name":"Auto Draft"') === false) {
                if (strpos($this->_post->sq->jsonld, 'application/ld+json') !== false) {
                    return $this->_post->sq->jsonld;
                } else {
                    return '<script type="application/ld+json">' . $this->_post->sq->jsonld . '</script>';
                }
            } else {
                return '<script type="application/ld+json">' . json_encode($data, JSON_UNESCAPED_UNICODE) . '</script>';
            }
        }

        return false;
    }

    /**
     * Sets data.
     *
     * @param  array $data Structured data.
     * @param  bool $reset Unset data (default: false).
     * @return bool
     */
    public function set_data($data, $reset = false) {
        if (!isset($data['@type']) || !preg_match('|^[a-zA-Z]{1,20}$|', $data['@type'])) {
            return false;
        } else {
            if ($data['@type'] <> 'Review' && in_array(strtolower($data['@type']), $this->_types)) {
                return false;
            }

            $this->_types[] = strtolower($data['@type']);
        }

        if ($reset && isset($this->_data)) {
            unset($this->_data);
        }

        $this->_data[] = $data;
        return true;
    }

    /**
     * Gets data.
     *
     * @return array
     */
    public function get_data() {
        return apply_filters('sq_json_ld_data', $this->_data);
    }


    /**
     * Structures and returns data.
     *
     * List of types available by default for specific request:
     *
     * 'product',
     * 'review',
     * 'breadcrumblist',
     * 'website',
     * 'order',
     *
     * @param  array $types Structured data types.
     * @return array
     */
    public function get_structured_data($types) {
        $data = array();
        // Put together the values of same type of structured data.
        foreach ($this->get_data() as $value) {
            $data[$value['@type']][] = $value;
            $data[strtolower($value['@type'])][] = $value;
        }

        //mage array unique
        $types = array_unique($types);

        // Wrap the multiple values of each type inside a graph... Then add context to each type.
        foreach ($data as $type => $value) {
            $data[$type] = count((array)$value) > 1 ? array('@graph' => $value) : $value[0];
            $data[$type] = apply_filters('woocommerce_structured_data_context', array('@context' => 'https://schema.org/'), $data, $type, $value) + $data[$type];
        }

        // If requested types, pick them up... Finally change the associative array to an indexed one.
        $data = $types ? array_values(array_intersect_key($data, array_flip($types))) : array_values($data);

        if (!empty($data)) {
            $data = count((array)$data) > 1 ? array('@graph' => $data) : $data[0];
        }
        return $data;
    }


    /**
     * Get data types for pages.
     *
     * @return array
     */
    public function get_data_type_for_page() {
        return array_filter(apply_filters('sq_structured_data_type_for_page', $this->_types));
    }


    public function clean($var) {
        if (is_array($var)) {
            return array_map(array($this, 'clean'), $var);
        } else {
            return is_scalar($var) ? sanitize_text_field($var) : $var;
        }
    }

    public function generate_structured_data() {
        $jsonld = SQ_Classes_Helpers_Tools::getOption('sq_jsonld');
        $jsonld_type = SQ_Classes_Helpers_Tools::getOption('sq_jsonld_type');
        $socials = SQ_Classes_Helpers_Tools::getOption('socials');

        if ($this->_post->post_type == 'home') {
            $markup['@type'] = $jsonld_type;
            $markup['@id'] = $this->_post->url . '#' . $jsonld_type;
            $markup['url'] = $this->_post->url;

            if (isset($jsonld[$jsonld_type])) {
                foreach ($jsonld[$jsonld_type] as $key => $value) {
                    if ($value <> '') {
                        if ($key == 'contactType' || ($jsonld_type == 'Organization' && $key == 'jobTitle')) {
                            continue;
                        }
                        if ($jsonld_type == 'Organization' && $key == 'telephone') {
                            $markup['contactPoint'] = array(
                                '@type' => 'ContactPoint',
                                'telephone' => $value,
                                'contactType' => $jsonld[$jsonld_type]['contactType'],

                            );
                        }

                        if ($key == 'logo') {
                            if ($jsonld_type == 'Person') {
                                $key = 'image';
                            }
                            $markup[$key] = array(
                                '@type' => 'ImageObject',
                                'url' => $value,
                            );
                        } else {
                            $markup[$key] = $value;
                        }

                    }
                }
            }

            if (!empty($markup)) {
                $jsonld_socials = array();
                if (isset($socials['facebook_site']) && $socials['facebook_site'] <> '') {
                    $jsonld_socials[] = $socials['facebook_site'];
                }
                if (isset($socials['twitter_site']) && $socials['twitter_site'] <> '') {
                    $jsonld_socials[] = $socials['twitter_site'];
                }
                if (isset($socials['instagram_url']) && $socials['instagram_url'] <> '') {
                    $jsonld_socials[] = $socials['instagram_url'];
                }
                if (isset($socials['linkedin_url']) && $socials['linkedin_url'] <> '') {
                    $jsonld_socials[] = $socials['linkedin_url'];
                }
                if (isset($socials['myspace_url']) && $socials['myspace_url'] <> '') {
                    $jsonld_socials[] = $socials['myspace_url'];
                }
                if (isset($socials['twitter']) && $socials['twitter'] <> '') {
                    $jsonld_socials[] = $socials['twitter'];
                }
                if (isset($socials['pinterest_url']) && $socials['pinterest_url'] <> '') {
                    $jsonld_socials[] = $socials['pinterest_url'];
                }
                if (isset($socials['youtube_url']) && $socials['youtube_url'] <> '') {
                    $jsonld_socials[] = $socials['youtube_url'];
                }

                $markup['potentialAction'] = array(
                    '@type' => 'SearchAction',
                    'target' => home_url('?s={search_term_string}'),
                    'query-input' => 'required name=search_term_string',
                );

                if (!empty($jsonld_socials)) {
                    $markup['sameAs'] = $jsonld_socials;
                }
            }
            //add current markup
            $this->set_data($markup);
        } elseif ($this->_post->post_type == 'post' || $this->_post->sq->og_type == 'article') {
            $markup['@type'] = 'Article';
            $markup['@id'] = $this->_post->url . '#' . 'Article';
            $markup['url'] = $this->_post->url;

            if (isset($this->_post->sq->title)) {
                $markup['name'] = $this->truncate($this->_post->sq->title, 0, $this->_post->sq->jsonld_title_maxlength);
                $markup['name'] = str_replace('&#034;', '"', $markup['name']);
            }

            if (isset($this->_post->sq->description)) {
                $markup['headline'] = $this->truncate($this->_post->sq->description, 0, $this->_post->sq->jsonld_description_maxlength);
                $markup['headline'] = str_replace('&#034;', '"', $markup['headline']);
            }
            $markup['mainEntityOfPage'] = array(
                '@type' => 'WebPage',
                'url' => $this->_post->url
            );

            if ($this->_post->sq->og_media <> '') {
                $markup['thumbnailUrl'] = $this->_post->sq->og_media;
            }
            if (isset($this->_post->post_date)) {
                $markup['datePublished'] = date('c', strtotime($this->_post->post_date));
            }
            if (isset($this->_post->post_modified)) {
                $markup['dateModified'] = date('c', strtotime($this->_post->post_modified));
            }

            if ($this->_post->sq->og_media <> '') {
                $markup['image'] = array(
                    "@type" => "ImageObject",
                    "url" => $this->_post->sq->og_media,
                    "height" => 500,
                    "width" => 700,
                );
            } else {
                $this->_setMedia($markup);
            }

            $user_url = $this->getAuthor('user_url');
            $display_name = $this->getAuthor('display_name');

            if ($user_url <> '' && $display_name <> '') {
                $markup['author'] = array(
                    "@type" => "Person",
                    "url" => $user_url,
                    "name" => $display_name,
                );
            } elseif (isset($jsonld['Person'])) {
                $markup['publisher'] = array(
                    "@type" => 'Person',
                    "name" => $this->getAuthor('display_name'),
                );

                foreach ($jsonld['Person'] as $key => $value) {
                    if ($value <> '') {

                        if ($key == 'logo') {
                            $markup['publisher']['image'] = array(
                                "@type" => "ImageObject",
                                "url" => $value
                            );

                        } else {
                            $markup['publisher'][$key] = $value;
                        }
                    }
                }
            }

            if (isset($jsonld['Organization'])) {
                $markup['publisher'] = array(
                    "@type" => 'Organization',
                    "url" => $this->_post->url,
                    "name" => $this->getAuthor('display_name'),
                );

                foreach ($jsonld['Organization'] as $key => $value) {
                    if ($value <> '') {
                        if ($key == 'contactType' || $key == 'telephone' || $key == 'jobTitle') {
                            continue;
                        }

                        if ($key == 'logo') {
                            $markup['publisher']['logo'] = array(
                                "@type" => "ImageObject",
                                "url" => $value
                            );

                        } else {
                            $markup['publisher'][$key] = $value;
                        }
                    } else {
                        if ($key == 'logo') {
                            if (file_exists(ABSPATH . 'favicon.ico')) {
                                $logo = home_url() . '/favicon.ico';
                            } elseif ((SQ_Classes_Helpers_Tools::getOption('favicon') <> '' && file_exists(_SQ_CACHE_DIR_ . SQ_Classes_Helpers_Tools::getOption('favicon')))) {
                                if (!get_option('permalink_structure')) {
                                    $logo = home_url() . '/index.php?sq_get=favicon';
                                } else {
                                    $logo = home_url() . '/favicon.icon';
                                }
                            } else {
                                $logo = _SQ_ASSETS_URL_ . 'img/logo.png';
                            }

                            $markup['publisher']['logo'] = array(
                                "@type" => "ImageObject",
                                "url" => $logo
                            );

                        }
                    }
                }
            }

            if ($this->_post->sq->keywords <> '') {
                $markup['keywords'] = $this->_post->sq->keywords;
            }
            //add current markup
            $this->set_data($markup);
        } elseif ($this->_post->post_type == 'profile' && $this->_post->post_author <> '') {
            $markup['@type'] = 'Person';
            $markup['@id'] = $this->getAuthor('user_url');
            $markup['url'] = $this->getAuthor('user_url');
            $markup['name'] = $this->getAuthor('display_name');
            $markup['name'] = str_replace('&#034;', '"', $markup['name']);

            //add current markup
            $this->set_data($markup);
        } elseif ($this->_post->sq->og_type == 'website') {
            $markup['@type'] = 'Website';
            $markup['@id'] = $this->_post->url . '#' . 'Website';
            $markup['url'] = $this->_post->url;

            if (isset($this->_post->sq->title)) {
                $markup['name'] = $this->truncate($this->_post->sq->title, 0, $this->_post->sq->jsonld_title_maxlength);
                $markup['name'] = str_replace('"', '\"', $markup['name']);
            }

            if (isset($this->_post->sq->description)) {
                $markup['headline'] = $this->truncate($this->_post->sq->description, 0, $this->_post->sq->jsonld_description_maxlength);
                $markup['headline'] = str_replace('&#034;', '"', $markup['headline']);
            }
            $markup['mainEntityOfPage'] = array(
                '@type' => 'WebPage',
                'url' => $this->_post->url
            );

            if ($this->_post->sq->og_media <> '') {
                $markup['thumbnailUrl'] = $this->_post->sq->og_media;
            }
            if (isset($this->_post->post_date)) {
                $markup['datePublished'] = date('c', strtotime($this->_post->post_date));
            }
            if (isset($this->_post->post_modified)) {
                $markup['dateModified'] = date('c', strtotime($this->_post->post_modified));
            }

            if ($this->_post->sq->og_media <> '') {
                $markup['image'] = array(
                    "@type" => "ImageObject",
                    "url" => $this->_post->sq->og_media,
                    "height" => 500,
                    "width" => 700,
                );
            } else {
                $this->_setMedia($markup);
            }

            //Show search bar for products and shops
            if ($this->_post->post_type == 'product' || $this->_post->post_type == 'shop') {
                $markup['potentialAction'] = array(
                    '@type' => 'SearchAction',
                    'target' => home_url('?s={search_term_string}&post_type=product'),
                    'query-input' => 'required name=search_term_string',
                );
            }

            $user_url = $this->getAuthor('user_url');
            $display_name = $this->getAuthor('display_name');
            if ($user_url <> '' && $display_name <> '') {
                $markup['author'] = array(
                    "@type" => "Person",
                    "url" => $user_url,
                    "name" => $display_name,
                );
            }

            if ($jsonld_type == 'Organization' && isset($jsonld[$jsonld_type])) {
                $markup['publisher'] = array(
                    "@type" => $jsonld_type,
                    "url" => $this->_post->url,
                    "name" => $this->getAuthor('display_name'),
                );

                foreach ($jsonld[$jsonld_type] as $key => $value) {
                    if ($value <> '') {
                        if ($key == 'contactType' || $key == 'telephone' || $key == 'jobTitle') {
                            continue;
                        }

                        if ($key == 'logo') {
                            $markup['publisher']['logo'] = array(
                                "@type" => "ImageObject",
                                "url" => $value
                            );

                        } else {
                            $markup['publisher'][$key] = $value;
                        }
                    }
                }
            }

            if ($this->_post->sq->keywords <> '') {
                $markup['keywords'] = $this->_post->sq->keywords;
            }
            //add current markup
            $this->set_data($markup);
        }
    }

    /** Set the Image from Feature image
     * @param $markup
     */
    protected function _setMedia(&$markup) {
        $images = $this->getPostImages();
        if (!empty($images)) {
            $image = current($images);
            if (isset($image['src'])) {
                $markup['image'] = array(
                    "@type" => "ImageObject",
                    "url" => $image['src'],
                    "height" => 500,
                    "width" => 700,
                );
                if (isset($image['width'])) {
                    $markup['image']["width"] = $image['width'];
                }
                if (isset($image['height'])) {
                    $markup['image']["height"] = $image['height'];
                }
            }
        }
    }

    /**
     * Generates BreadcrumbList structured data.
     */
    public function generate_breadcrumblist_data() {
        $crumbs = $markup = array();
        ///////////////////////////// Home Page
        $post = SQ_Classes_ObjController::getClass('SQ_Models_Snippet')->setHomePage();

        if ($post->ID == 0 || $this->_post->ID <> $post->ID) {
            $crumbs[] = array(
                ($post->sq->title <> '' ? $post->sq->title : $post->post_title),
                $post->url,
            );
        }

        if ($this->_post->post_type == 'category' && isset($this->_post->term_id) && isset($this->_post->taxonomy)) {
            $parents = get_ancestors($this->_post->term_id, $this->_post->taxonomy);
            if (!empty($parents)) {
                $parents = array_reverse($parents);

                foreach ($parents as $parent) {
                    $parent = get_term($parent);
                    if (!is_wp_error($parent)) {
                        $crumbs[] = array(
                            $parent->name,
                            get_term_link($parent->term_id, $this->_post->taxonomy),
                        );
                    }
                }
            }
        } else {
            /////////////////////// Parent Categories
            $categories = get_the_category($this->_post->ID);
            if (!empty($categories)) {
                foreach ($categories as $category) {
                    $parents = get_ancestors($category->term_id, $category->taxonomy);

                    if (!empty($parents)) {
                        $parents = array_reverse($parents);

                        foreach ($parents as $parent) {
                            $parent = get_term($parent);
                            if (!is_wp_error($parent)) {
                                $crumbs[] = array(
                                    $parent->name,
                                    get_term_link($parent->term_id, $category->taxonomy),
                                );
                            }
                        }
                    }

                    if (!is_wp_error(get_term_link($category->term_id, $category->taxonomy))) {
                        $crumbs[] = array(
                            $category->name,
                            get_term_link($category->term_id, $category->taxonomy),
                        );
                    }
                }
            }
        }
        if ($this->_post->post_type <> 'home') {
            ////////////////////// Current post
            $crumbs[] = array(
                ($this->_post->sq->title <> '' ? $this->_post->sq->title : $this->_post->post_title),
                $this->_post->url,
            );

            if (!empty($crumbs)) {
                $markup['@type'] = 'BreadcrumbList';
                $markup['@id'] = $this->_post->url . '#' . 'BreadcrumbList';
                $markup['itemListElement'] = array();

                foreach ($crumbs as $key => $crumb) {
                    $markup['itemListElement'][$key] = array(
                        '@type' => 'ListItem',
                        'position' => $key + 1,
                        'item' => array(
                            '@id' => $crumb[1],
                            'name' => str_replace('&#034;', '"', $crumb[0])
                        ),
                    );

                }
            }
        }

        $this->set_data($markup);

    }

    /**
     * Generates Product structured data.
     *
     */
    public function generate_product_data() {
        global $product;

        if (!class_exists('WC_Product')) {
            return;
        }

        try {
            $product = new WC_Product($this->_post->ID);

            if (!$product instanceof WC_Product) {
                return;
            }

            if (!method_exists($product, 'get_id')) {
                return;
            }

            $shop_name = get_bloginfo('name');
            $shop_url = home_url();
            $currency = get_woocommerce_currency();
            $markup = array();
            $markup['@type'] = 'Product';
            $markup['url'] = get_permalink($product->get_id());
            $markup['@id'] = $markup['url'] . '#' . 'Product';

            if (method_exists($product, 'get_name')) {
                $markup['name'] = $product->get_name();
            } else {
                $markup['name'] = $product->get_title();
            }

            if (method_exists($product, 'get_short_description')) {
                $markup['description'] = wp_strip_all_tags($product->get_short_description() ? $product->get_short_description() : $product->get_description());
            }

            if (method_exists($product, 'get_image_id')) {
                if ($image = wp_get_attachment_url($product->get_image_id())) {
                    $markup['image'] = $image;
                }
            }

            if (method_exists($product, 'get_date_on_sale_to') && $product->get_date_on_sale_to()) {
                if (method_exists($product->get_date_on_sale_to(), 'getTimestamp')) {
                    $price_valid_until = date('Y-m-d', $product->get_date_on_sale_to()->getTimestamp());
                } else {
                    $price_valid_until = date('Y-m-d', strtotime('+12 Month'));
                }
            } else {
                $price_valid_until = date('Y-m-d', strtotime('+12 Month'));
            }

            $markup_offer = array(
                '@type' => 'Offer',
                'price' => wc_format_decimal($product->get_price(), wc_get_price_decimals()),
                'priceValidUntil' => $price_valid_until,
                'url' => get_permalink($product->get_id()),
                'priceCurrency' => $currency,
                'availability' => 'https://schema.org/' . $stock = ($product->is_in_stock() ? 'InStock' : 'OutOfStock'),
                'sku' => (method_exists($product, 'get_sku')) ? $product->get_sku() : '',
                'image' => (method_exists($product, 'get_image_id')) ? wp_get_attachment_url($product->get_image_id()) : '',
                'description' => (method_exists($product, 'get_description') ? $product->get_description() : $product->get_title()),
                'seller' => array(
                    '@type' => 'Organization',
                    'name' => $shop_name,
                    'url' => $shop_url,
                ),
            );

            //Get the variation prices
            if ($product->is_type('variable') && method_exists($product, 'get_variation_prices')) {
                $prices = $product->get_variation_prices();

                $markup_offer['priceSpecification'] = array(
                    'price' => wc_format_decimal($product->get_price(), wc_get_price_decimals()),
                    'minPrice' => wc_format_decimal(current($prices['price']), wc_get_price_decimals()),
                    'maxPrice' => wc_format_decimal(end($prices['price']), wc_get_price_decimals()),
                    'priceCurrency' => $currency,
                );
            }

            //Get all categories
            $categories = $product->get_category_ids();
            if (!empty($categories)) {
                foreach ($categories as $category) {
                    $category = get_term($category, 'product_cat');
                    if (!is_wp_error($category)) {
                        $markup['brand'] = array(
                            '@type' => 'Thing',
                            'name' => $category->name,
                        );
                    }
                }
            }

            $markup['sku'] = (method_exists($product, 'get_sku')) ? $product->get_sku() : '-';
            $markup['mpn'] = $markup['sku'];

            if (function_exists('wc_prices_include_tax')) {
                $markup_offer['priceSpecification']['valueAddedTaxIncluded'] = wc_prices_include_tax() ? 'true' : 'false';
            }

            //Set the offer
            $markup['offers'] = $markup_offer;

            //If rating and reviews
            if (method_exists($product, 'get_rating_count') && $product->get_rating_count()) {

                $markup['aggregateRating'] = array(
                    '@type' => 'AggregateRating',
                    'ratingValue' => $product->get_average_rating(),
                    'ratingCount' => $product->get_rating_count(),
                    'reviewCount' => $product->get_review_count(),
                );

                //Set the reviews
                $markup['review'] = $this->get_review_data($product);

            } elseif (SQ_Classes_Helpers_Tools::getOption('sq_jsonld_product_defaults')) { //add default datas?

                //Add data if no reviews for Google validation
                $markup['aggregateRating'] = array(
                    '@type' => 'AggregateRating',
                    'ratingValue' => 5,
                    'ratingCount' => 1,
                    'reviewCount' => 1,
                );

                $markup['review'][] = array(
                    '@type' => 'Review',
                    'reviewRating' => array(
                        '@type' => 'Rating',
                        'ratingValue' => 5,
                    ),
                    'author' => array(
                        '@type' => 'Person',
                        'name' => '',
                    ),
                    'reviewBody' => '',
                    'datePublished' => (method_exists($product, 'get_date_created') && method_exists($product->get_date_created(), 'getTimestamp')) ? date('Y-m-d', $product->get_date_created()->getTimestamp()) : '',
                );
            }

            $otherbrands = array();

            //compatible with Perfect Woocommerce Brands
            if (SQ_Classes_Helpers_Tools::isPluginInstalled('perfect-woocommerce-brands/perfect-woocommerce-brands.php')) {
                $brands = wp_get_post_terms($product->get_id(), 'pwb-brand');
                foreach ($brands as $brand) {
                    $otherbrands[] = $brand->name;
                }
            }

            //compatible with YITH WooCommerce Brands Add-on
            if (SQ_Classes_Helpers_Tools::isPluginInstalled('yith-woocommerce-brands-add-on/init.php')) {
                $brands = wp_get_post_terms($product->get_id(), 'yith_product_brand');
                foreach ($brands as $brand) {
                    $otherbrands[] = $brand->name;
                }
            }

            if (!empty($otherbrands)) {
                $markup['brand'] = $otherbrands;
            }

            //Add the markup in the list
            //let other plugin hook this markup
            $this->set_data($markup);

        } catch (Exception $e) {

        }
    }

    /**
     * Generates Review structured data.
     *
     * @param $product
     * @return array | false
     */
    public function get_review_data($product) {
        global $comment;
        $markup = array();

        if (!method_exists($product, 'get_id')) {
            return false;
        }

        if (function_exists('wc_review_ratings_enabled') && wc_review_ratings_enabled() &&
            function_exists('get_comments') && function_exists('get_comment_meta')) {

            $comments = get_comments(
                array(
                    'number' => 10,
                    'post_id' => $product->get_id(),
                    'status' => 'approve',
                    'post_status' => 'publish',
                    'post_type' => 'product',
                    'parent' => 0,
                    'meta_query' => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
                        array(
                            'key' => 'rating',
                            'type' => 'NUMERIC',
                            'compare' => '>',
                            'value' => 0,
                        ),
                    ),
                )
            );

            if ($comments) {
                foreach ($comments as $comment) {
                    $markup[] = array(
                        '@type' => 'Review',
                        'reviewRating' => array(
                            '@type' => 'Rating',
                            'bestRating' => '5',
                            'ratingValue' => get_comment_meta($comment->comment_ID, 'rating', true),
                            'worstRating' => '1',
                        ),
                        'author' => array(
                            '@type' => 'Person',
                            'name' => get_comment_author($comment),
                        ),
                        'reviewBody' => get_comment_text($comment),
                        'datePublished' => get_comment_date('c', $comment),
                    );

                }
            }
        }

        return $markup;

    }

}
