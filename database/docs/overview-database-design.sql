Module 1 — Users & Roles
CREATE TABLE users (
    id          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    email       VARCHAR(255) NOT NULL UNIQUE,
    phone       VARCHAR(20) UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    full_name   VARCHAR(150) NOT NULL,
    avatar_url  VARCHAR(500),
    role        ENUM('guest','buyer','seller','inspector','admin') NOT NULL DEFAULT 'buyer',
    status      ENUM('active','inactive','banned','pending_verify') NOT NULL DEFAULT 'active',
    email_verified_at TIMESTAMP NULL,
    phone_verified_at TIMESTAMP NULL,
    last_login_at     TIMESTAMP NULL,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_role_status (role, status)
);

-- Thông tin mở rộng (tách riêng để bảng users gọn)
CREATE TABLE user_profiles (
    user_id     BIGINT UNSIGNED PRIMARY KEY,
    bio         TEXT,
    city        VARCHAR(100),
    district    VARCHAR(100),
    id_number   VARCHAR(30),                    -- CMND/CCCD (lưu mã hóa)
    id_verified BOOLEAN DEFAULT FALSE,
    rating_score  DECIMAL(3,2) DEFAULT 0.00,   -- Trung bình sao
    rating_count  INT UNSIGNED DEFAULT 0,
    total_sold    INT UNSIGNED DEFAULT 0,
    total_bought  INT UNSIGNED DEFAULT 0,
    response_rate TINYINT UNSIGNED DEFAULT 0,  -- % phản hồi tin nhắn
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Inspector profile riêng (người kiểm định có thêm thông tin)
CREATE TABLE inspector_profiles (
    user_id         BIGINT UNSIGNED PRIMARY KEY,
    certification   VARCHAR(255),
    specialty       SET('road','mtb','bmx','triathlon','electric'),
    service_area    VARCHAR(255),               -- Khu vực hoạt động
    inspection_fee  DECIMAL(10,2),
    total_inspected INT UNSIGNED DEFAULT 0,
    is_available    BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Địa chỉ (user có thể có nhiều địa chỉ)
CREATE TABLE user_addresses (
    id          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id     BIGINT UNSIGNED NOT NULL,
    label       VARCHAR(50),                    -- "Nhà", "Văn phòng"...
    full_address TEXT NOT NULL,
    city        VARCHAR(100),
    district    VARCHAR(100),
    ward        VARCHAR(100),
    lat         DECIMAL(10,8),
    lng         DECIMAL(11,8),
    is_default  BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

Module 2 — Danh mục & thương hiệu
sql-- Danh mục xe (hỗ trợ đệ quy: Road → Endurance Road, MTB → Trail MTB...)
CREATE TABLE bike_categories (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    parent_id   INT UNSIGNED NULL,
    name        VARCHAR(100) NOT NULL,
    slug        VARCHAR(120) NOT NULL UNIQUE,
    description TEXT,
    icon_url    VARCHAR(500),
    sort_order  TINYINT UNSIGNED DEFAULT 0,
    is_active   BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (parent_id) REFERENCES bike_categories(id) ON DELETE SET NULL
);

-- Thương hiệu xe đạp
CREATE TABLE bike_brands (
    id              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name            VARCHAR(100) NOT NULL UNIQUE,
    slug            VARCHAR(120) NOT NULL UNIQUE,
    country_origin  VARCHAR(80),
    logo_url        VARCHAR(500),
    website_url     VARCHAR(500),
    description     TEXT,
    is_active       BOOLEAN DEFAULT TRUE,
    sort_order      TINYINT UNSIGNED DEFAULT 0
);

-- Model cụ thể (tùy chọn, giúp tra cứu nhanh giá thị trường)
CREATE TABLE bike_models (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    brand_id    INT UNSIGNED NOT NULL,
    category_id INT UNSIGNED NOT NULL,
    name        VARCHAR(150) NOT NULL,
    year_start  YEAR,
    year_end    YEAR NULL,
    msrp        DECIMAL(12,2) NULL,            -- Giá bán lẻ gốc
    description TEXT,
    FOREIGN KEY (brand_id)    REFERENCES bike_brands(id),
    FOREIGN KEY (category_id) REFERENCES bike_categories(id)
);

-- Tags hệ thống (tiện lọc: "fixed gear", "full-suspension", "carbon"...)
CREATE TABLE tags (
    id    INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name  VARCHAR(80) NOT NULL UNIQUE,
    slug  VARCHAR(100) NOT NULL UNIQUE
);

Module 3 — Tin đăng bán
sql-- Tin đăng chính
CREATE TABLE listings (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    seller_id       BIGINT UNSIGNED NOT NULL,
    category_id     INT UNSIGNED NOT NULL,
    brand_id        INT UNSIGNED,
    model_id        INT UNSIGNED NULL,
    title           VARCHAR(255) NOT NULL,
    description     TEXT,
    price           DECIMAL(12,2) NOT NULL,
    negotiable      BOOLEAN DEFAULT TRUE,       -- Có thương lượng không
    condition       ENUM('new','like_new','good','fair','poor') NOT NULL,
    status          ENUM('draft','pending_review','active','sold',
                         'hidden','rejected','expired') DEFAULT 'pending_review',

    -- Thông số kỹ thuật phổ biến (đặt thẳng để dễ lọc)
    frame_size      VARCHAR(30),               -- S, M, L, XL, 52cm...
    wheel_size      VARCHAR(20),               -- 26", 27.5", 29", 700c
    frame_material  ENUM('aluminum','carbon','steel','titanium','other'),
    color           VARCHAR(80),
    manufacture_year YEAR,
    mileage_km      INT UNSIGNED,              -- Km đã đi (nếu biết)

    -- Vị trí & hiển thị
    city            VARCHAR(100),
    district        VARCHAR(100),
    lat             DECIMAL(10,8),
    lng             DECIMAL(11,8),
    view_count      INT UNSIGNED DEFAULT 0,
    is_featured     BOOLEAN DEFAULT FALSE,     -- Tin nổi bật (trả phí)
    is_inspected    BOOLEAN DEFAULT FALSE,     -- Đã có nhãn kiểm định
    expires_at      TIMESTAMP NULL,
    published_at    TIMESTAMP NULL,
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (seller_id)   REFERENCES users(id),
    FOREIGN KEY (category_id) REFERENCES bike_categories(id),
    FOREIGN KEY (brand_id)    REFERENCES bike_brands(id),
    FOREIGN KEY (model_id)    REFERENCES bike_models(id),

    INDEX idx_status_city (status, city),
    INDEX idx_price (price),
    INDEX idx_category (category_id),
    FULLTEXT idx_search (title, description)
);

-- Ảnh & video
CREATE TABLE listing_media (
    id          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    listing_id  BIGINT UNSIGNED NOT NULL,
    url         VARCHAR(1000) NOT NULL,
    thumb_url   VARCHAR(1000),
    type        ENUM('image','video') DEFAULT 'image',
    sort_order  TINYINT UNSIGNED DEFAULT 0,
    is_primary  BOOLEAN DEFAULT FALSE,          -- Ảnh đại diện
    FOREIGN KEY (listing_id) REFERENCES listings(id) ON DELETE CASCADE
);

-- Thông số linh kiện chi tiết (groupset, bánh, phanh...)
CREATE TABLE listing_components (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    listing_id      BIGINT UNSIGNED NOT NULL,
    component_type  ENUM('drivetrain','brakes','wheelset','handlebars',
                         'saddle','fork','pedals','other') NOT NULL,
    brand           VARCHAR(100),
    model_name      VARCHAR(150),
    condition       ENUM('excellent','good','fair','poor'),
    notes           TEXT,
    FOREIGN KEY (listing_id) REFERENCES listings(id) ON DELETE CASCADE
);

-- Thông số tùy chỉnh EAV (cho các spec không chuẩn hóa)
CREATE TABLE listing_specs (
    id          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    listing_id  BIGINT UNSIGNED NOT NULL,
    spec_key    VARCHAR(100) NOT NULL,
    spec_value  VARCHAR(255) NOT NULL,
    FOREIGN KEY (listing_id) REFERENCES listings(id) ON DELETE CASCADE
);

-- Gắn tag cho tin đăng
CREATE TABLE listing_tags (
    listing_id  BIGINT UNSIGNED NOT NULL,
    tag_id      INT UNSIGNED NOT NULL,
    PRIMARY KEY (listing_id, tag_id),
    FOREIGN KEY (listing_id) REFERENCES listings(id) ON DELETE CASCADE,
    FOREIGN KEY (tag_id)     REFERENCES tags(id) ON DELETE CASCADE
);

-- Wishlist / xe yêu thích
CREATE TABLE wishlists (
    user_id     BIGINT UNSIGNED NOT NULL,
    listing_id  BIGINT UNSIGNED NOT NULL,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (user_id, listing_id),
    FOREIGN KEY (user_id)   REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (listing_id) REFERENCES listings(id) ON DELETE CASCADE
);

-- Tìm kiếm đã lưu (có thể bật thông báo khi có xe mới phù hợp)
CREATE TABLE saved_searches (
    id                  BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id             BIGINT UNSIGNED NOT NULL,
    name                VARCHAR(150),
    filters_json        JSON NOT NULL,          -- {category, brand, price_min, ...}
    notify_new_listing  BOOLEAN DEFAULT FALSE,
    created_at          TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

Module 4 — Tin nhắn & giao tiếp
sql-- Cuộc hội thoại (mỗi cặp buyer-seller cho một listing)
CREATE TABLE conversations (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    listing_id      BIGINT UNSIGNED NOT NULL,
    buyer_id        BIGINT UNSIGNED NOT NULL,
    seller_id       BIGINT UNSIGNED NOT NULL,
    status          ENUM('active','archived','blocked') DEFAULT 'active',
    last_message_at TIMESTAMP NULL,
    buyer_unread    INT UNSIGNED DEFAULT 0,
    seller_unread   INT UNSIGNED DEFAULT 0,
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uq_conv (listing_id, buyer_id, seller_id),
    FOREIGN KEY (listing_id) REFERENCES listings(id),
    FOREIGN KEY (buyer_id)   REFERENCES users(id),
    FOREIGN KEY (seller_id)  REFERENCES users(id)
);

-- Tin nhắn
CREATE TABLE messages (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    conversation_id BIGINT UNSIGNED NOT NULL,
    sender_id       BIGINT UNSIGNED NOT NULL,
    content         TEXT,
    type            ENUM('text','image','offer','system') DEFAULT 'text',
    metadata_json   JSON NULL,                  -- Với offer: {amount, expires_at}
    read_at         TIMESTAMP NULL,
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (conversation_id) REFERENCES conversations(id) ON DELETE CASCADE,
    FOREIGN KEY (sender_id)       REFERENCES users(id),
    INDEX idx_conv_created (conversation_id, created_at)
);

-- Lời đề nghị giá (tách ra để dễ quản lý)
CREATE TABLE price_offers (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    message_id      BIGINT UNSIGNED NOT NULL,
    conversation_id BIGINT UNSIGNED NOT NULL,
    amount          DECIMAL(12,2) NOT NULL,
    status          ENUM('pending','accepted','rejected','expired','countered') DEFAULT 'pending',
    counter_amount  DECIMAL(12,2) NULL,
    expires_at      TIMESTAMP NULL,
    responded_at    TIMESTAMP NULL,
    FOREIGN KEY (message_id)      REFERENCES messages(id),
    FOREIGN KEY (conversation_id) REFERENCES conversations(id)
);

Module 5 — Đặt mua & giao dịch
sql-- Đơn hàng
CREATE TABLE orders (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    listing_id      BIGINT UNSIGNED NOT NULL,
    buyer_id        BIGINT UNSIGNED NOT NULL,
    seller_id       BIGINT UNSIGNED NOT NULL,
    amount          DECIMAL(12,2) NOT NULL,     -- Giá thỏa thuận
    deposit_amount  DECIMAL(12,2) DEFAULT 0,    -- Tiền cọc
    status          ENUM('pending','deposit_paid','confirmed','inspecting',
                         'completed','cancelled','disputed','refunded') DEFAULT 'pending',
    inspection_required BOOLEAN DEFAULT FALSE,
    notes           TEXT,
    cancelled_reason TEXT NULL,
    cancelled_by    BIGINT UNSIGNED NULL,
    completed_at    TIMESTAMP NULL,
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (listing_id) REFERENCES listings(id),
    FOREIGN KEY (buyer_id)   REFERENCES users(id),
    FOREIGN KEY (seller_id)  REFERENCES users(id)
);

-- Lịch sử trạng thái đơn
CREATE TABLE order_status_logs (
    id          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    order_id    BIGINT UNSIGNED NOT NULL,
    from_status VARCHAR(50),
    to_status   VARCHAR(50) NOT NULL,
    changed_by  BIGINT UNSIGNED,
    note        TEXT,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id)
);

-- Giao dịch tài chính
CREATE TABLE transactions (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    order_id        BIGINT UNSIGNED NOT NULL,
    user_id         BIGINT UNSIGNED NOT NULL,   -- Người thực hiện
    type            ENUM('deposit','full_payment','refund',
                         'service_fee','inspection_fee') NOT NULL,
    amount          DECIMAL(12,2) NOT NULL,
    fee             DECIMAL(10,2) DEFAULT 0,
    net_amount      DECIMAL(12,2) NOT NULL,
    payment_method  ENUM('cash','bank_transfer','momo','zalopay','vnpay','other'),
    status          ENUM('pending','completed','failed','refunded') DEFAULT 'pending',
    reference_code  VARCHAR(100),               -- Mã giao dịch từ cổng TT
    gateway_response JSON NULL,
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (user_id)  REFERENCES users(id)
);

-- Cấu hình phí dịch vụ (admin điều chỉnh được)
CREATE TABLE service_fee_configs (
    id              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name            VARCHAR(100) NOT NULL,
    type            ENUM('percentage','fixed') NOT NULL,
    value           DECIMAL(8,4) NOT NULL,
    applicable_to   ENUM('all','featured_listing','inspection','transaction') NOT NULL,
    min_amount      DECIMAL(10,2) NULL,
    max_amount      DECIMAL(10,2) NULL,
    is_active       BOOLEAN DEFAULT TRUE,
    effective_from  DATE,
    effective_to    DATE NULL
);

Module 6 — Đánh giá & uy tín
sqlCREATE TABLE reviews (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    order_id        BIGINT UNSIGNED NOT NULL,
    reviewer_id     BIGINT UNSIGNED NOT NULL,
    reviewee_id     BIGINT UNSIGNED NOT NULL,
    listing_id      BIGINT UNSIGNED NOT NULL,
    rating          TINYINT UNSIGNED NOT NULL CHECK (rating BETWEEN 1 AND 5),
    comment         TEXT,
    is_buyer_review BOOLEAN NOT NULL,           -- TRUE = buyer đánh giá seller
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uq_review (order_id, reviewer_id),
    FOREIGN KEY (order_id)    REFERENCES orders(id),
    FOREIGN KEY (reviewer_id) REFERENCES users(id),
    FOREIGN KEY (reviewee_id) REFERENCES users(id),
    FOREIGN KEY (listing_id)  REFERENCES listings(id)
);

CREATE TABLE review_responses (
    id          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    review_id   BIGINT UNSIGNED NOT NULL UNIQUE,
    content     TEXT NOT NULL,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (review_id) REFERENCES reviews(id) ON DELETE CASCADE
);

Module 7 — Kiểm định xe
sql-- Yêu cầu kiểm định
CREATE TABLE inspection_requests (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    listing_id      BIGINT UNSIGNED NOT NULL,
    order_id        BIGINT UNSIGNED NULL,       -- Gắn đơn hàng nếu là pre-purchase
    requester_id    BIGINT UNSIGNED NOT NULL,
    inspector_id    BIGINT UNSIGNED NULL,
    type            ENUM('pre_listing','pre_purchase','dispute') DEFAULT 'pre_listing',
    status          ENUM('pending','assigned','scheduled','in_progress',
                         'completed','cancelled') DEFAULT 'pending',
    inspection_fee  DECIMAL(10,2),
    scheduled_at    TIMESTAMP NULL,
    location        TEXT,
    notes           TEXT,
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (listing_id)   REFERENCES listings(id),
    FOREIGN KEY (order_id)     REFERENCES orders(id),
    FOREIGN KEY (requester_id) REFERENCES users(id),
    FOREIGN KEY (inspector_id) REFERENCES users(id)
);

-- Báo cáo kiểm định chi tiết
CREATE TABLE inspection_reports (
    id                  BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    request_id          BIGINT UNSIGNED NOT NULL UNIQUE,
    inspector_id        BIGINT UNSIGNED NOT NULL,
    overall_condition   ENUM('excellent','good','fair','poor') NOT NULL,
    frame_condition     ENUM('excellent','good','fair','poor'),
    brake_condition     ENUM('excellent','good','fair','poor'),
    drivetrain_condition ENUM('excellent','good','fair','poor'),
    wheelset_condition  ENUM('excellent','good','fair','poor'),
    electrical_condition ENUM('excellent','good','fair','poor','na') DEFAULT 'na',
    summary             TEXT,
    recommendation      ENUM('approve','approve_with_notes','reject') NOT NULL,
    report_url          VARCHAR(1000) NULL,     -- PDF báo cáo upload
    created_at          TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (request_id)  REFERENCES inspection_requests(id),
    FOREIGN KEY (inspector_id) REFERENCES users(id)
);

-- Checklist chi tiết từng hạng mục
CREATE TABLE inspection_checklist_items (
    id          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    report_id   BIGINT UNSIGNED NOT NULL,
    component   VARCHAR(150) NOT NULL,
    status      ENUM('pass','warn','fail') NOT NULL,
    notes       TEXT,
    FOREIGN KEY (report_id) REFERENCES inspection_reports(id) ON DELETE CASCADE
);

-- Nhãn kiểm định gắn lên listing
CREATE TABLE inspection_labels (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    listing_id      BIGINT UNSIGNED NOT NULL,
    report_id       BIGINT UNSIGNED NOT NULL,
    inspector_id    BIGINT UNSIGNED NOT NULL,
    label_type      ENUM('inspected','certified') NOT NULL,
    issued_at       TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    expires_at      TIMESTAMP NULL,
    is_active       BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (listing_id)  REFERENCES listings(id),
    FOREIGN KEY (report_id)   REFERENCES inspection_reports(id),
    FOREIGN KEY (inspector_id) REFERENCES users(id)
);

Module 8 — Báo cáo, vi phạm & tranh chấp
sql-- Báo cáo tin đăng
CREATE TABLE listing_reports (
    id          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    listing_id  BIGINT UNSIGNED NOT NULL,
    reporter_id BIGINT UNSIGNED NOT NULL,
    reason      ENUM('fake','wrong_info','inappropriate','spam','already_sold','other') NOT NULL,
    description TEXT,
    status      ENUM('pending','reviewing','resolved','dismissed') DEFAULT 'pending',
    resolved_by BIGINT UNSIGNED NULL,
    resolved_at TIMESTAMP NULL,
    resolution_note TEXT NULL,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (listing_id)  REFERENCES listings(id),
    FOREIGN KEY (reporter_id) REFERENCES users(id)
);

-- Báo cáo người dùng
CREATE TABLE user_reports (
    id          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    reported_user_id BIGINT UNSIGNED NOT NULL,
    reporter_id BIGINT UNSIGNED NOT NULL,
    reason      ENUM('scam','harassment','fake_info','other') NOT NULL,
    description TEXT,
    status      ENUM('pending','reviewing','resolved','dismissed') DEFAULT 'pending',
    resolved_by BIGINT UNSIGNED NULL,
    resolved_at TIMESTAMP NULL,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (reported_user_id) REFERENCES users(id),
    FOREIGN KEY (reporter_id)      REFERENCES users(id)
);

-- Tranh chấp giao dịch
CREATE TABLE disputes (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    order_id        BIGINT UNSIGNED NOT NULL UNIQUE,
    initiator_id    BIGINT UNSIGNED NOT NULL,
    reason          ENUM('item_not_as_described','item_not_received',
                         'payment_issue','other') NOT NULL,
    description     TEXT,
    evidence_json   JSON NULL,                  -- URLs ảnh/video bằng chứng
    status          ENUM('open','under_review','resolved','closed') DEFAULT 'open',
    assigned_inspector BIGINT UNSIGNED NULL,
    resolution      ENUM('refund_buyer','release_seller','split','other') NULL,
    resolution_note TEXT NULL,
    resolved_at     TIMESTAMP NULL,
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id)             REFERENCES orders(id),
    FOREIGN KEY (initiator_id)         REFERENCES users(id),
    FOREIGN KEY (assigned_inspector)   REFERENCES users(id)
);

Module 9 — Thông báo & hệ thống
sql-- Thông báo in-app
CREATE TABLE notifications (
    id          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id     BIGINT UNSIGNED NOT NULL,
    type        VARCHAR(80) NOT NULL,           -- 'new_message', 'order_update', 'inspection_done'...
    title       VARCHAR(255) NOT NULL,
    body        TEXT,
    data_json   JSON NULL,                      -- {listing_id, order_id, ...}
    is_read     BOOLEAN DEFAULT FALSE,
    read_at     TIMESTAMP NULL,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_unread (user_id, is_read, created_at)
);

-- Cấu hình thông báo của từng user
CREATE TABLE notification_preferences (
    user_id             BIGINT UNSIGNED PRIMARY KEY,
    email_messages      BOOLEAN DEFAULT TRUE,
    email_orders        BOOLEAN DEFAULT TRUE,
    email_promotions    BOOLEAN DEFAULT FALSE,
    push_messages       BOOLEAN DEFAULT TRUE,
    push_orders         BOOLEAN DEFAULT TRUE,
    push_wishlist_price BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Audit log (ai làm gì, lúc nào)
CREATE TABLE audit_logs (
    id          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id     BIGINT UNSIGNED NULL,
    action      VARCHAR(100) NOT NULL,          -- 'listing.approve', 'user.ban'...
    entity_type VARCHAR(80),
    entity_id   BIGINT UNSIGNED NULL,
    changes_json JSON NULL,                     -- {before: {...}, after: {...}}
    ip_address  VARCHAR(45),
    user_agent  VARCHAR(500),
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_entity (entity_type, entity_id),
    INDEX idx_action (action, created_at)
);

-- Cấu hình hệ thống (admin điều chỉnh runtime)
CREATE TABLE system_configs (
    config_key  VARCHAR(100) PRIMARY KEY,
    value       TEXT NOT NULL,
    description TEXT,
    updated_by  BIGINT UNSIGNED NULL,
    updated_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

Module 10 — Mở rộng (Logistics, Thanh toán, Chatbot)
sql-- === LOGISTICS ===
CREATE TABLE logistics_providers (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(100) NOT NULL,
    code        VARCHAR(30) NOT NULL UNIQUE,    -- 'ghn', 'ghtk', 'viettelpost'
    api_base_url VARCHAR(500),
    is_active   BOOLEAN DEFAULT TRUE,
    config_json JSON NULL                       -- API keys (lưu mã hóa)
);

CREATE TABLE shipments (
    id                  BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    order_id            BIGINT UNSIGNED NOT NULL,
    provider_id         INT UNSIGNED NOT NULL,
    tracking_number     VARCHAR(100),
    status              ENUM('pending','picked_up','in_transit',
                             'delivered','failed','returned') DEFAULT 'pending',
    shipping_fee        DECIMAL(10,2),
    sender_address_id   BIGINT UNSIGNED,
    receiver_address_id BIGINT UNSIGNED,
    estimated_delivery  DATE NULL,
    delivered_at        TIMESTAMP NULL,
    provider_response   JSON NULL,
    created_at          TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id)    REFERENCES orders(id),
    FOREIGN KEY (provider_id) REFERENCES logistics_providers(id)
);

-- === THANH TOÁN ONLINE ===
CREATE TABLE payment_gateways (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(80) NOT NULL,
    code        VARCHAR(30) NOT NULL UNIQUE,    -- 'momo', 'zalopay', 'vnpay'
    is_active   BOOLEAN DEFAULT TRUE,
    config_json JSON NULL                       -- Merchant ID, secret key (mã hóa)
);

CREATE TABLE payment_gateway_logs (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    transaction_id  BIGINT UNSIGNED NOT NULL,
    gateway_id      INT UNSIGNED NOT NULL,
    gateway_ref     VARCHAR(200),
    request_json    JSON NULL,
    response_json   JSON NULL,
    status          ENUM('initiated','success','failed','pending') DEFAULT 'initiated',
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (transaction_id) REFERENCES transactions(id),
    FOREIGN KEY (gateway_id)     REFERENCES payment_gateways(id)
);

-- === CHATBOT ===
CREATE TABLE chatbot_sessions (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id         BIGINT UNSIGNED NULL,       -- NULL nếu chưa đăng nhập
    session_token   VARCHAR(100) NOT NULL UNIQUE,
    context_json    JSON NULL,                  -- Ngữ cảnh hội thoại
    last_active_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE chatbot_messages (
    id          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    session_id  BIGINT UNSIGNED NOT NULL,
    role        ENUM('user','bot') NOT NULL,
    content     TEXT NOT NULL,
    intent      VARCHAR(100) NULL,              -- 'find_bike', 'track_order'...
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (session_id) REFERENCES chatbot_sessions(id) ON DELETE CASCADE
);

-- link ảnh ERD
https://app.diagrams.net/?src=about#G1i_WCWrBs-neCw71StamK8vSoS11m9lgw#%7B%22pageId%22%3A%22UOgwQgM0UyCYD0DGufqF%22%7D

